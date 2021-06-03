<?php

namespace FluentFormPro\Payments\PaymentMethods\Stripe;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Services\FormBuilder\ShortCodeParser;
use FluentForm\Framework\Helpers\ArrayHelper;
use FluentFormPro\Payments\Components\PaymentMethods;
use FluentFormPro\Payments\PaymentHelper;
use FluentFormPro\Payments\PaymentMethods\BaseProcessor;
use FluentFormPro\Payments\PaymentMethods\Stripe\API\CheckoutSession;

class StripeProcessor extends BaseProcessor
{
    public $method = 'stripe';

    protected $form;

    public function init()
    {
        add_action('fluentform_process_payment_' . $this->method, array($this, 'handlePaymentAction'), 10, 4);
        add_action('fluent_payment_frameless_' . $this->method, array($this, 'handleSessionRedirectBack'));
    }

    public function handlePaymentAction($submissionId, $submissionData, $form, $methodSettings)
    {
        $this->setSubmissionId($submissionId);
        $this->form = $form;
        $submission = $this->getSubmission();


        $uniqueHash = md5($submission->id . '-' . $form->id . '-' . time() . '-' . mt_rand(100, 999));

        $transactionId = $this->insertTransaction([
            'transaction_type' => 'onetime',
            'transaction_hash' => $uniqueHash,
            'payment_total'    => $this->getAmountTotal(),
            'status'           => 'pending',
            'currency'         => strtoupper($submission->currency),
            'payment_mode'     => $this->getPaymentMode()
        ]);

        $transaction = $this->getTransaction($transactionId);

        $this->handleCheckoutSession($transaction, $submission, $form, $methodSettings);
    }

    public function handleCheckoutSession($transaction, $submission, $form, $methodSettings)
    {
        $formSettings = PaymentHelper::getFormSettings($form->id);

        $successUrl = add_query_arg([
            'fluentform_payment' => $submission->id,
            'payment_method'     => $this->method,
            'transaction_hash'   => $transaction->transaction_hash,
            'type'               => 'success'
        ], home_url('/'));

        $cancelUrl = $submission->source_url;

        if (!wp_http_validate_url($cancelUrl)) {
            $cancelUrl = home_url($cancelUrl);
        }

        $paymentMethods = ArrayHelper::get($formSettings, 'stripe_checkout_methods', ['card']);
        if (!$paymentMethods || !is_array($paymentMethods)) {
            $paymentMethods = ['card'];
        }

        $checkoutArgs = [
            'cancel_url'                 => wp_sanitize_redirect($cancelUrl),
            'success_url'                => wp_sanitize_redirect($successUrl),
            'locale'                     => 'auto',
            'billing_address_collection' => 'auto',
            'payment_method_types'       => $paymentMethods,
            'client_reference_id'        => $submission->id,
            'submit_type'                => 'auto',
            'mode'                       => 'payment',
            'metadata'                   => [
                'submission_id'  => $submission->id,
                'form_id'        => $form->id,
                'transaction_id' => $transaction->id
            ]
        ];

        if ($formSettings['transaction_type'] == 'donation') {
            $checkoutArgs['submit_type'] = 'donate';
        }

        if (ArrayHelper::get($methodSettings, 'settings.require_billing_info.value') == 'yes') {
            $checkoutArgs['billing_address_collection'] = 'required';
        }

        if (ArrayHelper::get($methodSettings, 'settings.require_shipping_info.value') == 'yes') {
            $checkoutArgs['shipping_address_collection'] = [
                'allowed_countries' => StripeSettings::supportedShippingCountries()
            ];
        }

        if ($lineItems = $this->getFormattedItems($submission->currency)) {
            $checkoutArgs['line_items'] = $lineItems;
        }

        $checkoutArgs['payment_intent_data'] = $this->getPaymentIntentData($transaction, $submission, $form);

        $receiptEmail = $this->getReceiptEmail($submission);

        if ($receiptEmail) {
            $checkoutArgs['customer_email'] = $receiptEmail;
            $checkoutArgs['payment_intent_data']['receipt_email'] = $receiptEmail;
        }

        $checkoutArgs = apply_filters('fluentform_stripe_checkout_args', $checkoutArgs, $submission, $transaction, $form);

        $session = CheckoutSession::create($checkoutArgs);

        if (!empty($session->error) || is_wp_error($session)) {
            $error = 'Something is wrong';
            if (is_wp_error($session)) {
                $error = $session->get_error_message();
            } else if (!empty($session->error->message)) {
                $error = $session->error->message;
            }
            wp_send_json([
                'errors' => 'Stripe Error: ' . $error
            ], 423);
        }

        $this->setMetaData('stripe_session_id', $session->id);

        do_action('ff_log_data', [
            'parent_source_id' => $submission->form_id,
            'source_type'      => 'submission_item',
            'source_id'        => $submission->id,
            'component'        => 'Payment',
            'status'           => 'info',
            'title'            => 'Redirect to Stripe',
            'description'      => 'User redirect to Stripe for completing the payment'
        ]);

        wp_send_json_success([
            'nextAction' => 'payment',
            'actionName' => 'stripeRedirectToCheckout',
            'sessionId'  => $session->id,
            'message'    => __('You are redirecting to stripe.com to complete the purchase. Please wait while you are redirecting....', 'fluentformpro'),
            'result'     => [
                'insert_id' => $submission->id
            ]
        ], 200);
    }

    private function getPaymentIntentData($transaction, $submission, $form)
    {
        $data = [
            'capture_method'       => 'automatic',
            'description'          => $form->title,
            'statement_descriptor' => $this->getDescriptor($form->title)
        ];

        $paymentSettings = PaymentHelper::getFormSettings($form->id, 'admin');

        $intentMeta = [
            'submission_id'  => $submission->id,
            'form_id'        => $form->id,
            'transaction_id' => $transaction->id,
            'wp_plugin'      => 'WP Fluent Forms Pro',
            'form_title'     => $form->title
        ];

        if (ArrayHelper::get($paymentSettings, 'push_meta_to_stripe') == 'yes') {
            $metaItems = ArrayHelper::get($paymentSettings, 'stripe_meta_data', []);
            foreach ($metaItems as $metaItem) {
                if ($itemValue = ArrayHelper::get($metaItem, 'item_value')) {
                    $metaData[ArrayHelper::get($metaItem, 'label', 'item')] = $itemValue;
                }
            }
            $metaData = ShortCodeParser::parse($metaData, $submission->id, $submission->response);
            $metaData = array_filter($metaData);
            foreach ($metaData as $itemKey => $value) {
                if (is_string($value) || is_numeric($value)) {
                    $metaData[$itemKey] = strip_tags($value);
                }
            }
            $intentMeta = array_merge($intentMeta, $metaData);
        }

        $data['metadata'] = $intentMeta;
        return $data;
    }

    public function getFormattedItems($currency)
    {
        $orderItems = $this->getOrderItems();

        $formattedItems = [];
        $priceSubtotal = 0;

        $discountItems = $this->getDiscountItems();

        foreach ($orderItems as $item) {
            $price = $item->item_price;
            if (PaymentHelper::isZeroDecimal($currency)) {
                $price = intval($price / 100);
            }
            $quantity = ($item->quantity) ? $item->quantity : 1;
            $stripeLine = [
                'price_data' => [
                    'currency'     => $currency,
                    'unit_amount'  => $price,
                    'product_data' => [
                        'name' => $item->item_name
                    ]
                ],
                'quantity'   => $quantity
            ];
            $lineTotal = $quantity * $price;
            $priceSubtotal += $lineTotal;
            $formattedItems[] = $stripeLine;
        }

        if($discountItems) {
            $discountTotal = 0;
            foreach ($discountItems as $discountItem) {
                $discountTotal += $discountItem->line_total;
            }

            if (PaymentHelper::isZeroDecimal($currency)) {
                $discountTotal = intval($discountTotal / 100);
            }

            $newDiscountItems = [];

            foreach ($formattedItems as $item) {
                $baseAmount = $item['price_data']['unit_amount'];
                $item['price_data']['unit_amount'] = intval($baseAmount - ($discountTotal / $priceSubtotal) * $baseAmount);
                $newDiscountItems[] = $item;
            }

            $formattedItems = $newDiscountItems;
        }

        return $formattedItems;
    }

    public function handleSessionRedirectBack($data)
    {
        $type = sanitize_text_field($data['type']);
        $submissionId = intval($data['fluentform_payment']);
        $this->setSubmissionId($submissionId);

        $submission = $this->getSubmission();

        $transactionHash = sanitize_text_field($data['transaction_hash']);
        $transaction = $this->getTransaction($transactionHash, 'transaction_hash');

        if (!$transaction || !$submission) {
            return;
        }
        if ($type == 'success') {
            if ($this->getMetaData('is_form_action_fired') == 'yes') {
                $returnData = $this->getReturnData();
            } else {
                $sessionId = $this->getMetaData('stripe_session_id');
                $session = CheckoutSession::retrieve($sessionId, [
                    'expand' => ['payment_intent.customer']
                ], $submission->form_id);
                if ($session && !is_wp_error($session) && $session->payment_intent && $paymentStatus = $this->getIntentSuccessName($session->payment_intent)) {
                    $returnData = $this->processStripeSession($session, $submission, $transaction);
                } else {
                    $error = __('Sorry! No Valid payment session found. Please try again');
                    if (is_wp_error($session)) {
                        $error = $session->get_error_message();
                    }
                    $returnData = [
                        'insert_id' => $submission->id,
                        'title'     => __('Failed to retrieve session data'),
                        'result'    => false,
                        'error'     => $error
                    ];
                }
            }
        } else {
            $returnData = [
                'insert_id' => $submission->id,
                'result'    => false,
                'error'     => __('Looks like you have cancelled the payment. Please try again!', 'fluentformpro')
            ];
        }

        $returnData['type'] = $type;

        if (!isset($returnData['is_new'])) {
            $returnData['is_new'] = false;
        }

        $this->showPaymentView($returnData);
    }

    public function processStripeSession($session, $submission, $transaction)
    {
        $this->setSubmissionId($submission->id);
        $updateData = [
            'charge_id'    => $session->payment_intent->id,
            'status'       => 'paid',
            'payment_note' => maybe_serialize($session->payment_intent)
        ];
        if (!empty($session->payment_intent->charges->data[0])) {
            $charge = $session->payment_intent->charges->data[0];
            if (!empty($charge->billing_details)) {
                $updateData['payer_name'] = $charge->billing_details->name;
                $updateData['payer_email'] = $charge->billing_details->email;
                $updateData['billing_address'] = $this->formatAddress($charge->billing_details->address);
            }

            if (!empty($charge->shipping) && !empty($charge->shipping->address)) {
                $updateData['shipping_address'] = $this->formatAddress($charge->shipping->address);
            }

            if (!empty($charge->payment_method_details->card)) {
                $card = $charge->payment_method_details->card;
                $updateData['card_brand'] = $card->brand;
                $updateData['card_last_4'] = $card->last4;
            }
        }

        $isNew = $this->getMetaData('is_form_action_fired') == 'yes';
        $paymentStatus = $this->getIntentSuccessName($session->payment_intent);
        $this->updateTransaction($transaction->id, $updateData);
        $this->changeSubmissionPaymentStatus($paymentStatus);
        $this->changeTransactionStatus($transaction->id, $paymentStatus);
        $returnData = $this->completePaymentSubmission(false);
        $this->recalculatePaidTotal();
        $returnData['is_new'] = $isNew;
        return $returnData;
    }

    private function getIntentSuccessName($intent)
    {
        if (!$intent || !$intent->status) {
            return false;
        }

        $successStatuses = [
            'succeeded'        => 'paid',
            'requires_capture' => 'requires_capture'
        ];

        if (isset($successStatuses[$intent->status])) {
            return $successStatuses[$intent->status];
        }

        return false;
    }

    private function getDescriptor($title)
    {
        $illegal = array('<', '>', '"', "'");
        // Remove slashes
        $descriptor = stripslashes($title);
        // Remove illegal characters
        $descriptor = str_replace($illegal, '', $descriptor);
        // Trim to 22 characters max
        return substr($descriptor, 0, 22);
    }

    private function formatAddress($address)
    {
        $addressArray = [
            'line1'       => $address->line1,
            'line2'       => $address->line2,
            'city'        => $address->city,
            'state'       => $address->state,
            'postal_code' => $address->postal_code,
            'country'     => $address->country,
        ];
        return implode(', ', array_filter($addressArray));
    }

    public function handleRefund($event)
    {
        $data = $event->data->object;
        $chargeId = $data->payment_intent;

        // Get the Transaction from database
        $transaction = wpFluent()->table('fluentform_transactions')
            ->where('charge_id', $chargeId)
            ->where('payment_method', 'stripe')
            ->where('transaction_type', 'onetime')
            ->first();

        if (!$transaction) {
            // Not our transaction
            return;
        }

        $submission = wpFluent()->table('fluentform_submissions')
            ->find($transaction->submission_id);

        if (!$submission) {
            return;
        }

        $this->setSubmissionId($submission->id);
        $amountRefunded = $data->amount_refunded;
        if (PaymentHelper::isZeroDecimal($data->currency)) {
            $amountRefunded = $amountRefunded * 100;
        }

        $status = 'refunded';
        if ($amountRefunded < $transaction->payment_total) {
            $status = 'partially-refunded';
        }

        wpFluent()->table('fluentform_transactions')
            ->where('submission_id', $submission->id)
            ->where('transaction_type', 'refund')
            ->delete();

        $this->refund($amountRefunded, $transaction, $submission, 'stripe', $chargeId, 'Refund from Stripe');

    }

    public function getPaymentMode()
    {
        $stripeSettings = StripeSettings::getSettings();
        return $stripeSettings['payment_mode'];
    }

    private function getReceiptEmail($submission)
    {
        $paymentSettings = PaymentHelper::getFormSettings($submission->form_id, 'admin');
        $targetInput = ArrayHelper::get($paymentSettings, 'receipt_email');
        if ($targetInput) {
            if (isset($submission->response[$targetInput])) {
                $receiptEmail = $submission->response[$targetInput];
                if (is_email($receiptEmail)) {
                    return $receiptEmail;
                }
            }
        }

        if ($userId = get_current_user_id()) {
            $user = get_user_by('ID', $userId);
            return $user->user_email;
        }

        return false;
    }
}