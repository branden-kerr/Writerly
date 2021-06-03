<?php

namespace FluentFormPro\Payments\Classes;

use FluentForm\Framework\Helpers\ArrayHelper;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class CouponModel
{
    private $table = 'fluentform_coupons';

    public function getCoupons($paginate = false)
    {
        $query = wpFluent()->table($this->table);
        if ($paginate) {
            $coupons = $query->paginate();
            foreach ($coupons['data'] as $coupon) {
                $coupon->settings = maybe_unserialize($coupon->settings);
                if ($coupon->start_date == '0000-00-00') {
                    $coupon->start_date = '';
                }
                if ($coupon->expire_date == '0000-00-00') {
                    $coupon->expire_date = '';
                }
            }
            return $coupons;
        }
        $coupons = $query->get();
        foreach ($coupons as $coupon) {
            $coupon->settings = maybe_unserialize($coupon->settings);
            if ($coupon->start_date == '0000-00-00') {
                $coupon->start_date = '';
            }
            if ($coupon->expire_date == '0000-00-00') {
                $coupon->expire_date = '';
            }
        }

        return $coupons;
    }

    public function getCouponByCode($code)
    {
        $coupon = wpFluent()->table($this->table)
            ->where('code', $code)
            ->first();
        if (!$coupon) {
            return $coupon;
        }

        $coupon->settings = maybe_unserialize($coupon->settings);

        if ($coupon->start_date == '0000-00-00') {
            $coupon->start_date = '';
        }

        if ($coupon->expire_date == '0000-00-00') {
            $coupon->expire_date = '';
        }
        return $coupon;
    }

    public function getCouponsByCodes($codes)
    {
        $coupons = wpFluent()->table($this->table)
            ->whereIn('code', $codes)
            ->get();
        foreach ($coupons as $coupon) {
            $coupon->settings = maybe_unserialize($coupon->settings);
            if ($coupon->start_date == '0000-00-00') {
                $coupon->start_date = '';
            }
            if ($coupon->expire_date == '0000-00-00') {
                $coupon->expire_date = '';
            }
        }

        return $coupons;
    }

    public function insert($data)
    {
        $data['created_at'] = current_time('mysql');
        $data['updated_at'] = current_time('mysql');
        $data['created_by'] = get_current_user_id();

        $data['settings'] = maybe_serialize($data['settings']);

        return wpFluent()->table($this->table)
            ->insert($data);
    }

    public function update($id, $data)
    {
        $data['updated_at'] = current_time('mysql');

        $data['settings'] = maybe_serialize($data['settings']);

        return wpFluent()->table($this->table)
            ->where('id', $id)
            ->update($data);
    }

    public function delete($id)
    {
        return wpFluent()->table($this->table)
            ->where('id', $id)
            ->delete();
    }

    public function getValidCoupons($coupons, $formId, $amountTotal)
    {
        $amountTotal = $amountTotal / 100; // convert cents to money
        $validCoupons = [];

        $otherCouponCodes = [];
        foreach ($coupons as $coupon) {
            if ($coupon->status != 'active') {
                continue;
            }

            if ($formIds = ArrayHelper::get($coupon->settings, 'allowed_form_ids')) {
                if (!in_array($formId, $formIds)) {
                    continue;
                }
            }

            if ($coupon->min_amount && $coupon->min_amount > $amountTotal) {
                continue;
            }

            if ($otherCouponCodes && $coupon->stackable != 'yes') {
                continue;
            }

            $discountAmount = $coupon->amount;
            if ($coupon->coupon_type == 'percent') {
                $discountAmount = ($coupon->amount / 100) * $amountTotal;
            }

            $amountTotal = $amountTotal - $discountAmount;
            $otherCouponCodes[] = $coupon->code;

            $validCoupons[] = $coupon;

        }

        return $validCoupons;

    }

    public function migrate()
    {
        global $wpdb;

        $charsetCollate = $wpdb->get_charset_collate();

        $table = $wpdb->prefix . $this->table;

        if ($wpdb->get_var("SHOW TABLES LIKE '$table'") != $table) {
            $sql = "CREATE TABLE $table (
				id int(11) NOT NULL AUTO_INCREMENT,
				title varchar(192),
				code varchar(192),
				coupon_type varchar(255) DEFAULT 'percent',
				amount decimal(10,2) NULL,
				status varchar(192) DEFAULT 'active',
				stackable varchar(192) DEFAULT 'no',
				settings longtext,
				created_by INT(11) NULL,
				min_amount INT(11) NULL,
				max_use INT(11) NULL,
				start_date date NULL,
				expire_date date NULL,
				created_at timestamp NULL,
				updated_at timestamp NULL,
				PRIMARY  KEY  (id)
			  ) $charsetCollate;";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

            dbDelta($sql);
        }
    }

    public function isCouponCodeAvailable($code, $exceptId = false)
    {
        $query = wpFluent()->table($this->table)
            ->where('code', $code);
        if($exceptId) {
            $query = $query->where('id', '!=', $exceptId);
        }
        return $query->first();
    }
}
