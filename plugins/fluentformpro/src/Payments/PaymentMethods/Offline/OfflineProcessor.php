<?php

namespace FluentFormPro\Payments\PaymentMethods\Offline;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentFormPro\Payments\PaymentHelper;
use FluentFormPro\Payments\Components\PaymentMethods;
use FluentFormPro\Payments\PaymentMethods\BaseProcessor;

class OfflineProcessor extends BaseProcessor
{
    protected $form;

    protected $method = 'test';

    public function handlePaymentAction($submissionId, $submissionData, $form, $methodSettings)
    {
        $this->form = $form;
        $this->setSubmissionId($submissionId);
        
        $this->insertTransaction([
            'transaction_type' => 'onetime',
            'payment_total' => $this->getAmountTotal(),
            'status' => 'pending',
            'currency' => PaymentHelper::getFormCurrency($form->id),
            'payment_mode' => $this->getPaymentMode()
        ]);
    }

    public function getPaymentMode()
    {
        return $this->method;
    }
}
