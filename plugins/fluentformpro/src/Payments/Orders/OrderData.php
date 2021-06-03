<?php

namespace FluentFormPro\Payments\Orders;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentFormPro\Payments\PaymentHelper;

class OrderData
{
    public static function getSummary($submission, $form)
    {
        $orderItems = self::getOrderItems($submission);
        $discountItems = self::getDiscounts($submission);
        return [
            'order_items' => $orderItems,
            'discount_items' => $discountItems,
            'transactions' => self::getTransactions($submission->id),
            'refunds' => self::getRefunds($submission->id),
            'order_items_subtotal' => self::calculateOrderItemsTotal($orderItems, false, false),
            'order_items_total' => self::calculateOrderItemsTotal($orderItems, false, false, $discountItems)
        ];
    }

    public static function getOrderItems($submission)
    {
        $items = wpFluent()->table('fluentform_order_items')
            ->where('submission_id', $submission->id)
            ->where('type', 'single')
            ->get();

        foreach ($items as $item) {
            $item->formatted_item_price = PaymentHelper::formatMoney($item->item_price, $submission->currency);
            $item->formatted_line_total = PaymentHelper::formatMoney($item->line_total, $submission->currency);
        }

        return $items;
    }

    public static function getDiscounts($submission)
    {
        $items = wpFluent()->table('fluentform_order_items')
            ->where('submission_id', $submission->id)
            ->where('type', 'discount')
            ->get();

        foreach ($items as $item) {
            $item->formatted_item_price = PaymentHelper::formatMoney($item->item_price, $submission->currency);
            $item->formatted_line_total = PaymentHelper::formatMoney($item->line_total, $submission->currency);
        }

        return $items;
    }

    public static function getTransactions($submissionId)
    {
        $transactions = wpFluent()->table('fluentform_transactions')
            ->where('submission_id', $submissionId)
            ->where('transaction_type', 'onetime')
            ->orderBy('id', 'ASC')
            ->get();

        $formattedTransactions = [];
        foreach ($transactions as $transaction) {
            $transaction->payment_note = maybe_unserialize($transaction->payment_note);
            $transaction = apply_filters('fluentform_transaction_data_'.$transaction->payment_method, $transaction);
            if($transaction) {
                $formattedTransactions[] = $transaction;
            }
        }

        return $formattedTransactions;
    }

    public static function getRefunds($submissionId)
    {
        $transactions = wpFluent()->table('fluentform_transactions')
            ->where('submission_id', $submissionId)
            ->where('transaction_type', 'refund')
            ->orderBy('id', 'ASC')
            ->get();

        $formattedTransactions = [];
        foreach ($transactions as $transaction) {
            $transaction->payment_note = maybe_unserialize($transaction->payment_note);
            $transaction = apply_filters('fluentform_transaction_data_'.$transaction->payment_method, $transaction);
            if($transaction) {
                $formattedTransactions[] = $transaction;
            }
        }

        return $formattedTransactions;
    }

    public static function calculateOrderItemsTotal($orderItems, $formatted = false, $currency = false, $discountItems = []) {
        $total = 0;
        foreach ($orderItems as $item) {
            $total += $item->line_total;
        }

        if($discountItems) {
            foreach ($discountItems as $discountItem) {
                $total -= $discountItem->line_total;
            }
        }

        if($formatted) {
            return PaymentHelper::formatMoney($total, $currency);
        }

        return $total;
    }
}