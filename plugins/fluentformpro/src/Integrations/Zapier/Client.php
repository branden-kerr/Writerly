<?php

namespace FluentFormPro\Integrations\Zapier;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Exception;
use FluentForm\Framework\Foundation\Application;

class Client
{
	use NotifyTrait;

	protected $app = null;
	protected $table = 'fluentform_form_meta';
	protected $metaKey = 'fluentform_zapier_feed';
	protected $baseUrl = 'https://hooks.zapier.com/hooks/catch/';

	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	/**
	 * Get Zapier Feeds
	 * @return JSON Response
	 */
	public function getNotifications()
	{
		$hooks = wpFluent()
		->table($this->table)
		->where('form_id', intval($this->app->request->get('form_id')))
		->where('meta_key', $this->metaKey)
		->get();

		if ($hooks) {
			$hooks = array_map(function($hook) {
				$hook->value = json_decode($hook->value);
				return $hook;
			}, $hooks);
		}

		wp_send_json_success($hooks);
	}

	/**
	 * Save Zapier Feed
	 * @return JSON Response
	 */
	public function saveNotification()
	{
		$request = $this->validate($this->app->request->all());

		if (empty($request['id'])) {
			$id = $this->insertNotification($request);
		} else {
			$id = $this->updateNotification($request);
		}

		wp_send_json_success(['id' => $id]);
	}

	protected function insertNotification($request)
	{
		return wpFluent()
		->table($this->table)
		->insert([
			'meta_key' => $this->metaKey,
			'form_id' => $request['form_id'],
			'value' => $request['value']
		]);
	}

	protected function updateNotification($request)
	{
		wpFluent()
		->table($this->table)
		->where('id', $id = $request['id'])
		->update(['value' => $request['value']]);

		return $id;
	}

	/**
	 * Delete Zapier Feed
	 * @return JSON Response
	 */
	public function deleteNotification()
    {
    	try {
    		wpFluent()
			->table($this->table)
			->where('id', $this->app->request->get('id'))
			->delete();

	        wp_send_json_success();
    	} catch(Exception $e) {
    		wp_send_json_error();
    	}
    }

    protected function validate($request)
	{
		$validator = fluentValidator($request['value'], [
			'name' => 'required',
			'url' => 'required|url'
		]);

		if ($validator->validate()->fails()) {
			wp_send_json_error($validator->errors(), 422);
		}

		$request['value']['url'] = esc_url_raw($request['value']['url']);
		$request['value']['name'] = sanitize_text_field($request['value']['name']);
		
		$request['value'] = json_encode($request['value']);

		return $request;
	}
}
