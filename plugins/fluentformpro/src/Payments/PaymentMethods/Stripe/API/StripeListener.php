<?php

namespace FluentFormPro\Payments\PaymentMethods\Stripe\API;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Helpers\Helper;
use FluentForm\Framework\Helpers\ArrayHelper;
use FluentFormPro\Payments\PaymentHelper;
use FluentFormPro\Payments\PaymentMethods\BaseProcessor;
use FluentFormPro\Payments\PaymentMethods\Stripe\StripeProcessor;
use FluentFormPro\Payments\PaymentMethods\Stripe\StripeSettings;

class StripeListener
{

    public function verifyIPN()
    {
       // $signature = $_SERVER['HTTP_STRIPE_SIGNATURE'];

        // retrieve the request's body and parse it as JSON
        $body = @file_get_contents('php://input');

//        $this->verifySignature($body, $signature);
//
//        print_r($signature);
//        die();

        $event = json_decode($body);

        if (!$event || empty($event->id)) {
            return;
        }

        $eventId = $event->id;

        if ($eventId) {
            status_header(200);
            try {
                $formId = StripeSettings::guessFormIdFromEvent($event);
                $event = $this->retrive($eventId, $formId);

                if ($event && !is_wp_error($event)) {
                    $eventType = $event->type;

                    if ($eventType == 'charge.succeeded') {
                     //   $this->handleChargeSucceeded($event);
                    } else if ($eventType == 'invoice.payment_succeeded') {
                     //   $this->maybeHandleSubscriptionPayment($event);
                    } else if ($eventType == 'charge.refunded') {
                        $this->handleChargeRefund($event);
                    } else if ($eventType == 'customer.subscription.deleted') {
                    //    $this->handleSubscriptionCancelled($event);
                    } else if ($eventType == 'checkout.session.completed') {
                        $this->handleCheckoutSessionCompleted($event);
                    }
                }
            } catch (\Exception $e) {
                return; // No event found for this account
            }
        } else {
            status_header(500);
            die('-1'); // Failed
        }
        die('1');
    }

    // This is an onetime payment success
    private function handleChargeSucceeded($event)
    {
        $charge = $event->data->object;
        $transaction = wpPayFormDB()->table('wpf_order_transactions')
            ->where('charge_id', $charge->id)
            ->where('payment_method', 'stripe')
            ->first();

        if (!$transaction) {
            return;
        }

        do_action('wppayform/form_submission_activity_start', $transaction->form_id);

        // We have the transaction so we have to update some fields
        $updateData = array(
            'status' => 'paid'
        );
        if (!$transaction->card_last_4) {
            if (!empty($charge->source->last4)) {
                $updateData['card_last_4'] = $charge->source->last4;
            } else if (!empty($charge->payment_method_details->card->last4)) {
                $updateData['card_last_4'] = $charge->payment_method_details->card->last4;
            }
        }
        if (!$transaction->card_brand) {
            if (!empty($charge->source->brand)) {
                $updateData['card_brand'] = $charge->source->brand;
            } else if (!empty($charge->payment_method_details->card->network)) {
                $updateData['card_brand'] = $charge->payment_method_details->card->network;
            }
        }

        wpFluent()->table('wpf_order_transactions')
            ->where('id', $transaction->id)
            ->update($updateData);
    }

    /*
     * Handle Subscription Payment IPN
     * Refactored in version 2.0
     */
    private function maybeHandleSubscriptionPayment($event)
    {
        $data = $event->data->object;
        $subscriptionId = false;
        if (property_exists($data, 'subscription')) {
            $subscriptionId = $data->subscription;
        }
        if (!$subscriptionId) {
            return;
        }

        $subscription = wpFluent()->table('wpf_subscriptions')
            ->where('vendor_subscriptipn_id', $subscriptionId)
            ->where('vendor_customer_id', $data->customer)
            ->first();

        if (!$subscription) {
            return;
        }


        $submissionModel = new Submission();
        $submission = $submissionModel->getSubmission($subscription->submission_id);
        if (!$submission) {
            return;
        }

        do_action('wppayform/form_submission_activity_start', $submission->form_id);

        // Maybe Insert The transaction Now
        $subscriptionTransaction = new SubscriptionTransaction();

        $totalAmount = $data->total;
        if (GeneralSettings::isZeroDecimal($data->currency)) {
            $totalAmount = intval($totalAmount * 100);
        }

        $transactionId = $subscriptionTransaction->maybeInsertCharge([
            'form_id' => $submission->form_id,
            'user_id' => $submission->user_id,
            'submission_id' => $submission->id,
            'subscription_id' => $subscription->id,
            'transaction_type' => 'subscription',
            'payment_method' => 'stripe',
            'charge_id' => $data->charge,
            'payment_total' => $totalAmount,
            'status' => $data->status,
            'currency' => $data->currency,
            'payment_mode' => ($data->livemode) ? 'live' : 'test',
            'payment_note' => maybe_serialize($data),
            'created_at' => date('Y-m-d H:i:s', $data->created + (int) ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS )),
            'updated_at' => date('Y-m-d H:i:s', $data->created + (int) ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ))
        ]);

        $transaction = $subscriptionTransaction->getTransaction($transactionId);

        $subscriptionModel = new Subscription();

        $subscriptionModel->update($subscription->id, [
            'status' => 'active'
        ]);

        $mainSubscription = $subscriptionModel->getSubscription($subscription->id);

        $isNewPayment = $subscription->bill_count != $mainSubscription->bill_count;

        // Check For Payment EOT
        if ($mainSubscription->bill_times && $mainSubscription->bill_count >= $mainSubscription->bill_times) {

            // We have to cancel this subscription as total bill times done
            $response = ApiRequest::request([
                'cancel_at_period_end' => 'true'
            ], 'subscriptions/' . $mainSubscription->vendor_subscriptipn_id, 'POST');

            if (!is_wp_error($response)) {
                $subscriptionModel->update($mainSubscription->id, [
                    'status' => 'completed'
                ]);
                SubmissionActivity::createActivity(array(
                    'form_id' => $submission->form_id,
                    'submission_id' => $submission->id,
                    'type' => 'activity',
                    'created_by' => 'PayForm BOT',
                    'content' => __('The Subscription Term Period has been completed', 'wppayform')
                ));
                $updatedSubscription = $subscriptionModel->getSubscription($subscription->id);
                do_action('wppayform/subscription_payment_eot_completed', $submission, $updatedSubscription, $submission->form_id, $response);
                do_action('wppayform/subscription_payment_eot_completed_stripe', $submission, $updatedSubscription, $submission->form_id, $response);
            }
        }

        if ($isNewPayment) {
            // New Payment Made so we have to fire some events here
            do_action('wppayform/subscription_payment_received', $submission, $transaction, $submission->form_id, $subscription);
            do_action('wppayform/subscription_payment_received_stripe', $submission, $transaction, $submission->form_id, $subscription);
        }
    }

    /*
     * Refactored at version 2.0
     * We are logging refunds now for both subscription and
     * One time payments
     */
    private function handleChargeRefund($event)
    {
        (new StripeProcessor())->handleRefund($event);
    }

    /*
     * Handle Subscription Canceled
     */
    private function handleSubscriptionCancelled($event)
    {
        $data = $event->data->object;
        $subscriptionId = $data->id;
        $subscriptionModel = new Subscription();

        $subscription = wpFluent()->table('wpf_subscriptions')
            ->where('vendor_subscriptipn_id', $subscriptionId)
            ->where('status', '!=', 'completed')
            ->first();

        if (!$subscription) {
            return;
        }

        do_action('wppayform/form_submission_activity_start', $subscription->form_id);


        $subscriptionModel->update($subscription->id, [
            'status' => 'cancelled'
        ]);


        $subscription = $subscriptionModel->getSubscription($subscription->id);

        $submissionModel = new Submission();
        $submission = $submissionModel->getSubmission($subscription->submission_id);

        // New Payment Made so we have to fire some events here
        do_action('wppayform/subscription_payment_canceled', $submission, $subscription, $submission->form_id, $data);
        do_action('wppayform/subscription_payment_canceled_stripe', $submission, $subscription, $submission->form_id, $data);

    }


    private function handleCheckoutSessionCompleted($event)
    {
        $data = $event->data->object;

        $metaData = (array) $data->metadata;

        $formId = ArrayHelper::get($metaData, 'form_id');

        $session = CheckoutSession::retrieve($data->id, [
            'expand' => [
                'payment_intent.customer'
            ]
        ], $formId);

        if (!$session || is_wp_error($session) || empty($session->payment_intent)) {
            return;
        }


        $submissionId = intval($session->client_reference_id);

        if (!$session || !$submissionId) {
            return;
        }

        if (Helper::getSubmissionMeta($submissionId, 'is_form_action_fired') == 'yes') {
            return;
        }

        // let's get the pending submission
        $submission = wpFluent()->table('fluentform_submissions')
            ->where('id', $submissionId)
            ->where('payment_status', 'pending')
            ->first();
        if (!$submission) {
            return;
        }

        $transaction = wpFluent()->table('fluentform_transactions')
            ->where('form_id', $submission->form_id)
            ->where('status', 'pending')
            ->where('submission_id', $submission->id)
            ->first();
        // Let get the transaction now
        if(!$transaction) {
            return;
        }

        $returnData = (new StripeProcessor())->processStripeSession($session, $submission, $transaction);

    }

    /*
     *
     */
    public function retrive($eventId, $formId = false)
    {
        $api = new ApiRequest();
        $api::set_secret_key(StripeSettings::getSecretKey($formId));
        return $api::request([], 'events/' . $eventId, 'GET');
    }

    public function verifySignature($payload, $signature)
    {
        // Extract timestamp and signatures from header
        $timestamp = self::getTimestamp($signature);
        $signatures = self::getSignatures($signature);

        if (-1 === $timestamp) {
            return false;
        }
        if (empty($signatures)) {
            return false;
        }

        $signedPayload = "{$timestamp}.{$payload}";

        if(!function_exists('hash_hmac')) {
            return false;
        }

        $secret = 'whsec_NsNZNMSnWVPLt8GErz3SVZ97pWu8eb6D';

        $expectedSignature = \hash_hmac('sha256', $payload, $secret);

        foreach ($signatures as $signature) {
            if($this->secureCompare($signature, $expectedSignature)) {
                return true;
            }
        }

        return false;
    }

    protected function getTimeStamp($signature)
    {
        $items = \explode(',', $signature);

        foreach ($items as $item) {
            $itemParts = \explode('=', $item, 2);
            if ('t' === $itemParts[0]) {
                if (!\is_numeric($itemParts[1])) {
                    return -1;
                }

                return (int) ($itemParts[1]);
            }
        }

        return -1;
    }

    private function getSignatures($header, $scheme = 'v1')
    {
        $signatures = [];
        $items = \explode(',', $header);

        foreach ($items as $item) {
            $itemParts = \explode('=', $item, 2);
            if (\trim($itemParts[0]) === $scheme) {
                $signatures[] = $itemParts[1];
            }
        }

        return $signatures;
    }

    protected function secureCompare($a, $b)
    {
        if (function_exists('hash_equals')) {
            return \hash_equals($a, $b);
        }

        if (\strlen($a) !== \strlen($b)) {
            return false;
        }

        $result = 0;
        for ($i = 0; $i < \strlen($a); ++$i) {
            $result |= \ord($a[$i]) ^ \ord($b[$i]);
        }

        return 0 === $result;
    }

}
