<?php

namespace FluentFormPro\Payments\PaymentMethods\Stripe;

use FluentForm\Framework\Helpers\ArrayHelper;
use FluentFormPro\Payments\PaymentHelper;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class StripeSettings
{
    public static function getSettings()
    {
        $defaults = [
            'test_publishable_key' => '',
            'test_secret_key'      => '',
            'live_publishable_key' => '',
            'live_secret_key'      => '',
            'payment_mode'         => 'test',
            'is_active'            => 'no'
        ];

        $settings = get_option('fluentform_payment_settings_stripe', []);

        $settings = wp_parse_args($settings, $defaults);

        return $settings;
    }

    public static function updateSettings($data)
    {
        $settings = self::getSettings();
        $settings = wp_parse_args($data, $settings);
        update_option('fluentform_payment_settings_stripe', $settings);
        return self::getSettings();
    }

    public static function getSecretKey($formId = false)
    {
        if ($formId) {
            $formPaymentSettings = PaymentHelper::getFormSettings($formId, 'admin');
            if (ArrayHelper::get($formPaymentSettings, 'stripe_account_type') == 'custom') {
                return ArrayHelper::get($formPaymentSettings, 'stripe_custom_config.secret_key');
            }
        }

        $settings = self::getSettings();
        if ($settings['payment_mode'] == 'live') {
            return $settings['live_secret_key'];
        }
        return $settings['test_secret_key'];
    }

    public static function getPublishableKey($formId = false)
    {
        if ($formId) {
            $formPaymentSettings = PaymentHelper::getFormSettings($formId, 'admin');
            if (ArrayHelper::get($formPaymentSettings, 'stripe_account_type') == 'custom') {
                return ArrayHelper::get($formPaymentSettings, 'stripe_custom_config.publishable_key');
            }
        }

        $settings = self::getSettings();
        if ($settings['payment_mode'] == 'live') {
            return $settings['live_publishable_key'];
        }
        return $settings['test_publishable_key'];
    }

    public static function isLive($formId = false)
    {
        if ($formId) {
            $formPaymentSettings = PaymentHelper::getFormSettings($formId, 'admin');
            if (ArrayHelper::get($formPaymentSettings, 'stripe_account_type') == 'custom') {
                return ArrayHelper::get($formPaymentSettings, 'stripe_custom_config.payment_mode') == 'live';
            }
        }

        $settings = self::getSettings();
        return $settings['payment_mode'] == 'live';
    }

    public static function supportedShippingCountries()
    {
        $countries = [
            'AC', 'AD', 'AE', 'AF', 'AG', 'AI', 'AL', 'AM', 'AO', 'AQ', 'AR', 'AT', 'AU', 'AW', 'AX', 'AZ',
            'BA', 'BB', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BL', 'BM', 'BN', 'BO', 'BQ', 'BR', 'BS',
            'BT', 'BV', 'BW', 'BY', 'BZ', 'CA', 'CD', 'CF', 'CG', 'CH', 'CI', 'CK', 'CL', 'CM', 'CN', 'CO',
            'CR', 'CV', 'CW', 'CY', 'CZ', 'DE', 'DJ', 'DK', 'DM', 'DO', 'DZ', 'EC', 'EE', 'EG', 'EH', 'ER',
            'ES', 'ET', 'FI', 'FJ', 'FK', 'FO', 'FR', 'GA', 'GB', 'GD', 'GE', 'GF', 'GG', 'GH', 'GI', 'GL',
            'GM', 'GN', 'GP', 'GQ', 'GR', 'GS', 'GT', 'GU', 'GW', 'GY', 'HK', 'HN', 'HR', 'HT', 'HU', 'ID',
            'IE', 'IL', 'IM', 'IN', 'IO', 'IQ', 'IS', 'IT', 'JE', 'JM', 'JO', 'JP', 'KE', 'KG', 'KH', 'KI',
            'KM', 'KN', 'KR', 'KW', 'KY', 'KZ', 'LA', 'LB', 'LC', 'LI', 'LK', 'LR', 'LS', 'LT', 'LU', 'LV',
            'LY', 'MA', 'MC', 'MD', 'ME', 'MF', 'MG', 'MK', 'ML', 'MM', 'MN', 'MO', 'MQ', 'MR', 'MS', 'MT',
            'MU', 'MV', 'MW', 'MX', 'MY', 'MZ', 'NA', 'NC', 'NE', 'NG', 'NI', 'NL', 'NO', 'NP', 'NR', 'NU',
            'NZ', 'OM', 'PA', 'PE', 'PF', 'PG', 'PH', 'PK', 'PL', 'PM', 'PN', 'PR', 'PS', 'PT', 'PY', 'QA',
            'RE', 'RO', 'RS', 'RU', 'RW', 'SA', 'SB', 'SC', 'SE', 'SG', 'SH', 'SI', 'SJ', 'SK', 'SL', 'SM',
            'SN', 'SO', 'SR', 'SS', 'ST', 'SV', 'SX', 'SZ', 'TA', 'TC', 'TD', 'TF', 'TG', 'TH', 'TJ', 'TK',
            'TL', 'TM', 'TN', 'TO', 'TR', 'TT', 'TV', 'TW', 'TZ', 'UA', 'UG', 'US', 'UY', 'UZ', 'VA', 'VC',
            'VE', 'VG', 'VN', 'VU', 'WF', 'WS', 'XK', 'YE', 'YT', 'ZA', 'ZM', 'ZW', 'ZZ'
        ];

        return apply_filters('fluentform_stripe_supported_shipping_countries', $countries);
    }

    public static function getClientId($paymentMode = 'live')
    {
        if ($paymentMode == 'live') {
            return 'ca_GwAPNUlKAW6EgeTqERQieU3DXLAX3k7N';
        } else {
            return 'ca_GwAPhxHwszjhsFRdC4j5DqKHud7JLQ8C';
        }
    }

    public static function getAuthProviderBase()
    {
        return 'https://stripe.lab/?stripe_connect=1';
    }

    public static function guessFormIdFromEvent($event)
    {
        $eventType = $event->type;
        if ($eventType == 'checkout.session.completed' || $eventType == 'charge.refunded') {
            $data = $event->data->object;
            $metaData = (array) $data->metadata;
            $formId = ArrayHelper::get($metaData, 'form_id');
            return $formId;
        }

        return false;
    }

}