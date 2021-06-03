<?php

namespace FluentFormPro\Integrations\Zapier;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Modules\Form\FormFieldsParser;
use FluentForm\App\Services\Integrations\LogResponseTrait;
use FluentForm\Framework\Helpers\ArrayHelper;

trait NotifyTrait
{
    use LogResponseTrait;

    public function notify($feed, $formData, $entry, $form)
    {
        try {
            $values = $feed['processedValues'];
            $payload = ['body' => $formData];
            $payload = apply_filters('fluentform_integration_data_zapier', $payload, $feed, $entry);
            $response = wp_remote_post($values['url'], $payload);
            if (is_wp_error($response)) {
                $code = ArrayHelper::get($response, 'response.code');
                throw new \Exception($response->get_error_message() .', with response code: '.$code, (int)$response->get_error_code());
            } else {
                return $response;
            }
        } catch (\Exception $e) {
            return new \WP_Error('broke', $e->getMessage());
        }
    }


    public function verifyEndpoint()
    {
        $formId = intval($this->app->request->get('form_id'));

        $form = wpFluent()->table('fluentform_forms')->find($formId);

        $fields = array_map(function ($f) {
            return str_replace('.*', '', $f);
        }, array_keys(FormFieldsParser::getInputs($form)));

        $webHook = wpFluent()
            ->table($this->table)
            ->where('form_id', $formId)
            ->where('meta_key', $this->metaKey)
            ->first();

        $webHook = json_decode($webHook->value);

        $requestData = json_encode(
            array_combine($fields, array_fill(0, count($fields), ''))
        );

        $requestHeaders['Content-Type'] = 'application/json';

        $payload = [
            'body'    => $requestData,
            'method'  => 'POST',
            'headers' => $requestHeaders
        ];

        $response = wp_remote_request($webHook->url, $payload);

        if (is_wp_error($response)) {
            return wp_send_json_error(array(
                'message' => $response->get_error_message()
            ), 400);
        }

        wp_send_json_success(array(
            'message' => __('Sample sent successfully.'),
        ));
    }
}
