<?php

namespace FluentFormPro\Payments\Classes;

use FluentForm\Framework\Helpers\ArrayHelper;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class CouponController
{
    public function validateCoupon()
    {
        $code = sanitize_text_field($_REQUEST['coupon']);
        $formId = intval($_REQUEST['form_id']);
        $totalAmount = intval($_REQUEST['total_amount']);

        $couponModel = new CouponModel();
        $coupon = $couponModel->getCouponByCode($code);

        if(!$coupon || $coupon->status != 'active') {
            wp_send_json([
                'message' => __('The provided coupon is not valid', 'fluentformpro')
            ], 423);
        }

        if($formIds = ArrayHelper::get($coupon->settings, 'allowed_form_ids')) {
            if(!in_array($formId, $formIds)) {
                wp_send_json([
                    'message' => __('The provided coupon is not valid', 'fluentformpro')
                ], 423);
            }
        }

        if($coupon->min_amount && $coupon->min_amount > $totalAmount) {
            wp_send_json([
                'message' => __('The provided coupon does not meet the requirements', 'fluentformpro')
            ], 423);
        }

        $otherCouponCodes = ArrayHelper::get($_REQUEST, 'other_coupons', '');

        if($otherCouponCodes) {
            $otherCouponCodes = \json_decode($otherCouponCodes, true);
            if ($otherCouponCodes) {
                $codes = $couponModel->getCouponsByCodes($otherCouponCodes);
                foreach ($codes as $couponItem) {
                    if (($couponItem->stackable != 'yes' || $coupon->stackable != 'yes') && $coupon->code != $couponItem->code) {
                        wp_send_json([
                            'message' => __('Sorry, You can not apply this coupon with other coupon code', 'fluentformpro')
                        ], 423);
                    }
                }
            }
        }

        wp_send_json([
            'coupon' => [
                'code' => $coupon->code,
                'title' => $coupon->title,
                'amount' => $coupon->amount,
                'coupon_type' => $coupon->coupon_type
            ]
        ], 200);

    }
}