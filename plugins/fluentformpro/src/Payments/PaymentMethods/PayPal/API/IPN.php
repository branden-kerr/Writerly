<?php

namespace FluentFormPro\Payments\PaymentMethods\PayPal\API;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentFormPro\Payments\PaymentMethods\PayPal\PayPalSettings;

class IPN
{
    public function verifyIPN()
    {
        // Check the request method is POST
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] != 'POST') {
            return;
        }

        // Set initial post data to empty string
        $post_data = '';

        // Fallback just in case post_max_size is lower than needed
        if (ini_get('allow_url_fopen')) {
            $post_data = file_get_contents('php://input');
        } else {
            // If allow_url_fopen is not enabled, then make sure that post_max_size is large enough
            ini_set('post_max_size', '12M');
        }
        // Start the encoded data collection with notification command
        $encoded_data = 'cmd=_notify-validate';

        // Get current arg separator
        $arg_separator = ini_get('arg_separator.output');

        // Verify there is a post_data
        if ($post_data || strlen($post_data) > 0) {
            // Append the data
            $encoded_data .= $arg_separator . $post_data;
        } else {
            // Check if POST is empty
            if (empty($_POST)) {
                // Nothing to do
                return;
            } else {
                // Loop through each POST
                foreach ($_POST as $key => $value) {
                    // Encode the value and append the data
                    $encoded_data .= $arg_separator . "$key=" . urlencode($value);
                }
            }
        }

        // Convert collected post data to an array
        parse_str($encoded_data, $encoded_data_array);

        foreach ($encoded_data_array as $key => $value) {
            if (false !== strpos($key, 'amp;')) {
                $new_key = str_replace('&amp;', '&', $key);
                $new_key = str_replace('amp;', '&', $new_key);
                unset($encoded_data_array[$key]);
                $encoded_data_array[$new_key] = $value;
            }
        }

        /**
         * PayPal Web IPN Verification
         *
         * Allows filtering the IPN Verification data that PayPal passes back in via IPN with PayPal Standard
         *
         *
         * @param array $data The PayPal Web Accept Data
         */
        $encoded_data_array = apply_filters('fluentform_process_paypal_ipn_data', $encoded_data_array);

        $paymentSettings = PayPalSettings::getSettings();

        $ipnVerified = false;

        if ($paymentSettings['disable_ipn_verification'] != 'yes') {
            // Validate the IPN
            $remote_post_vars = array(
                'method' => 'POST',
                'timeout' => 45,
                'redirection' => 5,
                'httpversion' => '1.1',
                'blocking' => true,
                'headers' => array(
                    'host' => 'www.paypal.com',
                    'connection' => 'close',
                    'content-type' => 'application/x-www-form-urlencoded',
                    'post' => '/cgi-bin/webscr HTTP/1.1',
                    'user-agent' => 'Fluent Forms IPN Verification/' . FLUENTFORMPRO_VERSION . '; ' . get_bloginfo('url')
                ),
                'sslverify' => false,
                'body' => $encoded_data_array
            );
            // Get response
            $api_response = wp_remote_post(PayPalSettings::getPaypalRedirect(true, true), $remote_post_vars);
            if (is_wp_error($api_response)) {
                if (defined('FLUENTFORM_PAYPAL_IPN_DEBUG')) {
                    error_log('Fluent Forms: IPN Verification Failed for api reponse error');
                }
                do_action('fluentform_paypal_ipn_verification_failed', $remote_post_vars, $encoded_data_array);
                return; // Something went wrong
            }
            if (wp_remote_retrieve_body($api_response) !== 'VERIFIED') {
                if (defined('FLUENTFORM_PAYPAL_IPN_DEBUG')) {
                    error_log('Fluent Forms: IPN Verification Failed');
                }
                do_action('fluentform/paypal_ipn_not_verified', $api_response, $remote_post_vars, $encoded_data_array);
                return; // Response not okay
            }

            $ipnVerified = true;
        }


        // Check if $post_data_array has been populated
        if (!is_array($encoded_data_array) && !empty($encoded_data_array)) {
            return;
        }

        $defaults = array(
            'txn_type' => '',
            'payment_status' => '',
            'custom' => ''
        );

        $encoded_data_array = wp_parse_args($encoded_data_array, $defaults);

        //      $payment_id = 0;

//        if (!empty($encoded_data_array['parent_txn_id'])) {
//           // $payment_id = $this->getPaymentIdByTransactionId($encoded_data_array['parent_txn_id']);
//        } elseif (!empty($encoded_data_array['txn_id'])) {
//           // $payment_id = $this->getPaymentIdByTransactionId($encoded_data_array['txn_id']);
//        }

        $submissionId = !empty($encoded_data_array['custom']) ? absint($encoded_data_array['custom']) : 0;

        if (defined('FLUENTFORM_PAYPAL_IPN_DEBUG')) {
            error_log('IPN DATA: ');
            error_log(json_encode($encoded_data_array));
        }

        if(defined('FLUENTFORM_PAYMENT_DEBUG')) {
            $entry = wpFluent()->table('fluentform_submissions')->find($submissionId);
            if($entry) {
                do_action('ff_log_data', [
                    'parent_source_id' => $entry->form_id,
                    'source_type' => 'submission_item',
                    'source_id' => $entry->id,
                    'component' => 'Payment',
                    'status' => 'debug_json',
                    'title' => 'Payment IPN Debug Info - PayPal',
                    'description' => json_encode($encoded_data_array)
                ]);
            }
        }

        if (has_action('fluentform_ipn_paypal_action_' . $encoded_data_array['txn_type'])) {
            // Allow PayPal IPN types to be processed separately
            do_action('fluentform_ipn_paypal_action_' . $encoded_data_array['txn_type'], $encoded_data_array, $submissionId, $ipnVerified);
        } else {
            // Fallback to web accept just in case the txn_type isn't present
            do_action('fluentform_ipn_paypal_action_web_accept', $encoded_data_array, $submissionId, $ipnVerified);
        }
        exit;
    }

}