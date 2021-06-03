<?php

namespace FluentFormPro\Integrations\Zapier;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Modules\Acl\Acl;
use FluentForm\Framework\Foundation\Application;
use FluentForm\Framework\Helpers\ArrayHelper;

class Bootstrap
{
    protected $app = null;
    protected $notifier = null;
    protected $title = 'Zapier';

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->register();
    }

    public function register()
    {
        $isEnabled =  $this->isEnabled();
        add_filter('fluentform_global_addons', function ($addons) use ($isEnabled) {
            $addons['zapier'] = [
                'title' => 'Zapier',
                'category' => 'crm',
                'description' => 'WP Fluent Forms Zapier module allows you to connect your WordPress forms with over 600+ web apps. The integration possibilities here are just endless.',
                'logo' => $this->app->publicUrl('img/integrations/zapier.png'),
                'enabled' => ($isEnabled) ? 'yes' : 'no'
            ];
            return $addons;
        });

        if(!$isEnabled) {
            return;
        }

       // add_filter('fluentform_notifying_async_zapier', '__return_false');

        add_filter('fluentform_global_notification_active_types', function ($types) {
            $types['fluentform_zapier_feed'] = 'zapier';
            return $types;
        }, 20, 1);
        add_action('fluentform_integration_notify_fluentform_zapier_feed', array($this, 'notify'), 20, 4);

        add_filter('fluentform_form_settings_menu', array($this, 'addFormMenu'));

        add_action('wp_ajax_fluentform-get-zapier-notifications', function () {
            Acl::verify('fluentform_forms_manager');
            $this->getApiClient()->getNotifications();
        });

        add_action('wp_ajax_fluentform-save-zapier-notification', function () {
            Acl::verify('fluentform_forms_manager');
            $this->getApiClient()->saveNotification();
        });

        add_action('wp_ajax_fluentform-delete-zapier-notification', function () {
            Acl::verify('fluentform_forms_manager');
            $this->getApiClient()->deleteNotification();
        });

        add_action('wp_ajax_fluentform-verify-endpoint-zapier', function () {
            Acl::verify('fluentform_forms_manager');
            $this->getApiClient()->verifyEndpoint();
        });
    }

    public function addFormMenu($settingsMenus)
    {
        $settingsMenus['zapier'] = array(
            'slug'  => 'form_settings',
            'hash'  => 'zapier',
            'route' => '/zapier',
            'title' => $this->title,
        );
        return $settingsMenus;
    }

    public function notify($feed, $formData, $entry, $form)
    {
        $response = $this->getApiClient()->notify($feed, $formData, $entry, $form);
        if(is_wp_error($response)) {
            do_action('ff_integration_action_result', $feed, 'failed', $response->get_error_message());
            return;
        }

        $code = ArrayHelper::get($response, 'response.code');
        if($code < 300) {
            // it's a success
            do_action('ff_integration_action_result', $feed, 'success', 'Zapier payload has been fired. Status Code: '.$code);
            return;
        }
        do_action('ff_integration_action_result', $feed, 'failed', 'Zapier payload maybe failed to the target server. Status Code: '.$code);

    }

    protected function getApiClient()
    {
        return new Client($this->app);
    }

    public function isEnabled()
    {
        $globalModules = get_option('fluentform_global_modules_status');
        return $globalModules && isset($globalModules['zapier']) && $globalModules['zapier'] == 'yes';
    }

}
