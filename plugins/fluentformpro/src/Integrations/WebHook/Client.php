<?php

namespace FluentFormPro\Integrations\WebHook;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Exception;
use FluentForm\Framework\Foundation\Application;
use FluentForm\App\Services\Integrations\BaseIntegration;

class Client extends BaseIntegration
{
	use NotifyTrait;

	protected $app = null;
	
	protected $metaKey = 'fluentform_webhook_feed';

	public function __construct(Application $app)
	{
		$this->app = $app;

		parent::__construct(
			$this->metaKey, $app->request->get('form_id', false), true
		);
	}

	/**
	 * Get all notifications/feeds
	 * @return JSON Response
	 */
	public function getWebHooks()
	{
		$response = [
			'integrations' => $this->getAll(),
			'request_headers' => $this->getHeaders()
		];

		wp_send_json_success($response);
	}

	/**
	 * Save GetResponse Feed
	 * @return JSON Response
	 */
	public function saveWebHook()
	{
		$notification = $this->app->request->get('notification');
        $notification_id = $this->app->request->get('notification_id');
        $notification = json_decode($notification, true);

        $notification = fluentFormSanitizer(
        	$this->validate($notification)
        );

        if ($notification_id) {
            $this->update($notification_id, $notification);
            $message = __('Feed successfully updated', 'fluentformpro');
        } else {
            $notification_id = $this->save($notification);
            $message = __('Feed successfully created', 'fluentformpro');
        }

        wp_send_json_success(array(
            'message' => $message,
            'notification_id' => $notification_id
        ), 200);
	}

	/**
	 * Delete GetResponse Feed
	 * @return JSON Response
	 */
	public function deleteWebHook()
    {
        $this->delete($this->app->request->get('id'));

        wp_send_json_success(array(
            'message'      => __('Selected WebHook Feed is deleted', 'fluentformpro'),
            'integrations' => $this->getAll()
        ));
    }

	/**
	 * Validate inputs
	 * @param  array $notification
	 * @return array $notification
	 */
	protected function validate($notification)
	{
		$validator = fluentValidator($notification, [
            'name'                      => 'required',
            'request_body'              => 'required',
            'request_url'               => 'required|url'
        ], [
        	'name.required'              => __('Feed Name is required', 'fluentformpro'),
            'request_url.required'       => __('Request URL is required', 'fluentformpro'),
            'request_url.url'       => __('Request URL format is invalid', 'fluentformpro'),
            'request_body.required'      => __('Request body is required', 'fluentformpro')
        ])->validate();
		
		$errors = $validator->errors();

		if (!$this->validateFields($notification)) {
        	$errors['fields']['required'] = __('Field name is required', 'fluentformpro');
        }

        if (!$this->validateHeaders($notification)) {
        	$errors['headers']['required'] = __('Header name is required', 'fluentformpro');
        }

        if ($errors) {
            wp_send_json_error(array(
                'errors'  => $errors,
                'message' => __('Please fix the errors', 'fluentformpro')
            ), 400);
        }

		return $notification;
	}

	protected function validateFields($notification)
	{
		if ($notification['request_body'] != 'all_fields') {
			foreach ($notification['fields'] as $field) {
				if (empty($field['key'])) {
					return false;
				}
			}
		}
		return true;
	}

	protected function validateHeaders(&$notification)
	{
		if ($notification['with_header'] == 'yup') {
			foreach ($notification['request_headers'] as $key => &$header) {
				if (empty($header['key'])) {
					return false;
				}
			}
		}
		return true;
	}


	protected function getHeaders()
	{
		return array(
			array(
				'label' => 'Accept',
				'value' => 'Accept',
				'possible_values' => [
					'title' => 'Accep Header Samples',
                    'shortcodes' => [
                        'Accept: text/plain' => 'text/plain',
                        'Accept: text/html' => 'text/html',
                        'Accept: text/*' => 'text/*'
                    ]
				]
			),
			array(
				'label' => 'Accept-Charset',
				'value' => 'Accept-Charset',
				'possible_values' => [
					'title' => 'Accep-Charset Header Samples',
                    'shortcodes' => [
                        'Accept-Charset: utf-8' => 'utf-8',
                        'Accept-Charset: iso-8859-1' => 'iso-8859-1'
                    ]
				]
			),
			array(
				'label' => 'Accept-Encoding',
				'value' => 'Accept-Encoding',
				'possible_values' => [
					'title' => 'Accept-Encoding Header Samples',
                    'shortcodes' => [
                        'Accept-Encoding: gzip' => 'gzip',
                        'Accept-Encoding: compress' => 'compress',
                        'Accept-Encoding: deflate' => 'deflate',
                        'Accept-Encoding: br' => 'br',
                        'Accept-Encoding: identity' => 'identity',
                        'Accept-Encoding: *' => '*'
                    ]
				]
			),
			array(
				'label' => 'Accept-Language',
				'value' => 'Accept-Language',
				'possible_values' => [
					'title' => 'Accept-Language Header Samples',
                    'shortcodes' => [
                        'Accept-Language: en' => 'en',
                        'Accept-Language: en-US' => 'en-US',
                        'Accept-Language: en-GR' => 'en-GR',
                        'Accept-Language: en-US,en;q=0.5' => 'en-US,en;q=0.5'
                    ]
				]
			),
			array(
				'label' => 'Accept-Datetime',
				'value' => 'Accept-Datetime',
			),
			array(
				'label' => 'Authorization',
				'value' => 'Authorization',
			),
			array(
				'label' => 'Cache-Control',
				'value' => 'Cache-Control',
			),
			array(
				'label' => 'Connection',
				'value' => 'Connection',
			),
			array(
				'label' => 'Cookie',
				'value' => 'Cookie',
			),
			array(
				'label' => 'Content-Length',
				'value' => 'Content-Length',
			),
			array(
				'label' => 'Content-Type',
				'value' => 'Content-Type',
			),
			array(
				'label' => 'Date',
				'value' => 'Date',
			),
			array(
				'label' => 'Expect',
				'value' => 'Expect',
			),
			array(
				'label' => 'Forwarded',
				'value' => 'Forwarded',
			),
			array(
				'label' => 'From',
				'value' => 'From',
			),
			array(
				'label' => 'Host',
				'value' => 'Host',
			),
			array(
				'label' => 'If-Match',
				'value' => 'If-Match',
			),
			array(
				'label' => 'If-Modified-Since',
				'value' => 'If-Modified-Since',
			),
			array(
				'label' => 'If-None-Match',
				'value' => 'If-None-Match',
			),
			array(
				'label' => 'If-Range',
				'value' => 'If-Range',
			),
			array(
				'label' => 'If-Unmodified-Since',
				'value' => 'If-Unmodified-Since',
			),
			array(
				'label' => 'Max-Forwards',
				'value' => 'Max-Forwards',
			),
			array(
				'label' => 'Origin',
				'value' => 'Origin',
			),
			array(
				'label' => 'Pragma',
				'value' => 'Pragma',
			),
			array(
				'label' => 'Proxy-Authorization',
				'value' => 'Proxy-Authorization',
			),
			array(
				'label' => 'Range',
				'value' => 'Range',
			),
			array(
				'label' => 'Referer',
				'value' => 'Referer',
			),
			array(
				'label' => 'TE',
				'value' => 'TE',
			),
			array(
				'label' => 'User-Agent',
				'value' => 'User-Agent',
			),
			array(
				'label' => 'Upgrade',
				'value' => 'Upgrade',
			),
			array(
				'label' => 'Via',
				'value' => 'Via',
			),
			array(
				'label' => 'Warning',
				'value' => 'Warning',
			),
		);
	}
}
