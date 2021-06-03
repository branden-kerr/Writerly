<?php

namespace FluentFormPro\Integrations\WebHook;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Services\Integrations\LogResponseTrait;
use FluentForm\Framework\Helpers\ArrayHelper;
use FluentFormPro\Payments\Orders\OrderData;

trait NotifyTrait
{
    use LogResponseTrait;

    public function notify($feed, $formData, $entry, $form)
    {
        $settings = $feed['processedValues'];

        try {
            $requestHeaders = $this->getWebHookRequestHeaders($settings, $formData, $form, $entry->id);

            $requestMethod = $this->getWebHookRequestMethod($settings, $formData, $form, $entry->id);

            $requestData = $this->getWebHookRequestData($settings, $formData, $form, $entry);

            $requestUrl = $this->getWebHookRequestUrl(
                $settings, $formData, $form, $entry->id, $requestMethod, $requestData
            );

            $requestFormat = $settings['request_format'];
            if (in_array($requestMethod, ['POST', 'PUT', 'PATCH']) && $requestFormat == 'JSON') {
                $requestHeaders['Content-Type'] = 'application/json';
                $requestData = json_encode($requestData);
            }

            $payload = [
                'body'      => !in_array($requestMethod, ['GET', 'DELETE']) ? $requestData : null,
                'method'    => $requestMethod,
                'headers'   => $requestHeaders,
                'sslverify' => apply_filters('ff_webhook_ssl_verify', false),
            ];

            $payload = apply_filters(
                'fluentform_webhook_request_args',
                $payload, $settings, $formData, $form, $entry->id
            );

            $response = wp_remote_request($requestUrl, $payload);

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

    protected function getWebHookRequestMethod($settings, $data, $form, $entryId)
    {
        $method = $settings['request_method'];

        $method = apply_filters(
            'fluentform_webhook_request_method',
            $method, $settings, $data, $form, $entryId
        );

        return strtoupper($method);
    }

    protected function getWebHookRequestHeaders($settings, $data, $form, $entryId)
    {
        if ($settings['with_header'] == 'nop') return [];

        $parsedHeaders = $settings['request_headers'];

        $requestHeaders = [];
        foreach ($parsedHeaders as $header) {
            $requestHeaders[$header['key']] = $header['value'];
        }

        $requestHeaders = apply_filters(
            'fluentform_webhook_request_headers',
            $requestHeaders, $settings, $data, $form, $entryId
        );

        unset($requestHeaders[null]);

        return $requestHeaders;
    }

    protected function getWebHookRequestData($settings, $data, $form, $entry)
    {
        $formData = ArrayHelper::except($data, [
            '_wp_http_referer',
            '__fluent_form_embded_post_id',
            '_fluentform_15_fluentformnonce'
        ]);

        $selectedData = [];
        if ($settings['request_body'] == 'all_fields') {
            $selectedData = $formData;
            $submission = $entry;
            unset($submission->response);
            $selectedData['__submission'] = $submission;
            if($entry->payment_total) {
                $selectedData['__order_items'] = OrderData::getOrderItems($entry);
                $selectedData['__transactions'] = OrderData::getTransactions($entry->id);
            }
        } else {
            foreach ($settings['fields'] as $input) {
                $selectedData[$input['key']] = $input['value'];
            }
        }

        return apply_filters(
            'fluentform_webhook_request_data',
            $selectedData, $settings, $data, $form, $entry
        );
    }

    protected function getWebHookRequestUrl($settings, $data, $form, $entryId, $requestMethod, $requestData)
    {
        $url = $settings['request_url'];

        if (in_array($requestMethod, ['GET', 'DELETE']) && !empty($requestData)) {
            $url = add_query_arg($requestData, $url);
        }

        return apply_filters(
            'fluentform_webhook_request_url',
            $url, $settings, $data, $form, $entryId
        );
    }
}
