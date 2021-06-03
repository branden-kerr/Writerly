<?php

namespace FluentFormPro\classes;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Helpers\Helper;
use FluentForm\App\Services\Browser\Browser;
use FluentForm\Framework\Helpers\ArrayHelper as Arr;

class DraftSubmissionsManager
{
    protected $app = null;

    protected static $tableName = 'fluentform_draft_submissions';

    protected static $cookieName = 'fluentform_step_form_hash';

    public function __construct($app)
    {
        $this->app = $app;
        $this->init();
    }

    public function init()
    {
        add_action('fluentform_submission_inserted', [$this, 'delete'], 10, 3);
        add_filter('fluentform_form_fields_update', [$this, 'checkPartialSettings'], 10, 2);
        $this->registerAjaxHandlers();
    }

    public static function boot($app)
    {
        return new static($app);
    }

    public function registerAjaxHandlers()
    {
        $this->app->addAdminAjaxAction('fluentform_step_form_save_data', [$this, 'save']);
        $this->app->addPublicAjaxAction('fluentform_step_form_save_data', [$this, 'save']);
        $this->app->addAdminAjaxAction('fluentform_step_form_get_data', [$this, 'getEntry']);
        $this->app->addPublicAjaxAction('fluentform_step_form_get_data', [$this, 'getEntry']);
    }

    public function get($hash, $formId = false)
    {
        if ($formId) {
            return wpFluent()->table(static::$tableName)
                ->where('hash', $hash)
                ->where('form_id', $formId)
                ->first();
        }
        return wpFluent()->table(static::$tableName)->where('hash', $hash)->first();
    }

    public function getEntry()
    {
        $data = null;
        $entry = false;
        $formId = intval($_REQUEST['form_id']);
        if ($hash = $this->getHash()) {
            $entry = $this->get($hash, $formId);
        }

        if (!$entry && $userId = get_current_user_id()) {
            $entry = wpFluent()->table(static::$tableName)
                ->where('user_id', $userId)
                ->where('form_id', $formId)
                ->first();
        }

        if ($entry) {
            $data['step_completed'] = (int)$entry->step_completed;
            $data['response'] = json_decode($entry->response, true);
            unset(
                $data['response']['_wp_http_referer'],
                $data['response']['__fluent_form_embded_post_id'],
                $data['response']['_fluentform_' . $entry->form_id . '_fluentformnonce']
            );
        }

        wp_send_json($data, 200);
    }

    public function save()
    {
        $hash = $this->getHash();
        $this->saveState($hash);
        wp_send_json_success();
    }

    public function saveState($hash)
    {
        $formData = $this->app->request->get();
        parse_str($formData['data'], $formData['data']);
        $response = json_encode($formData['data']);
        $formId = $formData['form_id'];
        $exist = $this->get($hash);
        if (!$exist) {
            $browser = new Browser();
            $ipAddress = $this->app->request->getIp();
            if ((defined('FLUENTFROM_DISABLE_IP_LOGGING') && FLUENTFROM_DISABLE_IP_LOGGING) || apply_filters('fluentform_disable_ip_logging', false, $formId)) {
                $ipAddress = false;
            }
            $response = [
                'form_id'        => $formData['form_id'],
                'hash'           => $hash,
                'response'       => $response,
                'source_url'     => site_url(Arr::get($formData, 'data._wp_http_referer')),
                'user_id'        => get_current_user_id(),
                'browser'        => $browser->getBrowser(),
                'device'         => $browser->getPlatform(),
                'ip'             => $ipAddress,
                'step_completed' => $formData['active_step'],
                'created_at'     => current_time('mysql'),
                'updated_at'     => current_time('mysql')
            ];
            wpFluent()->table(static::$tableName)->insert($response);
        } else {
            wpFluent()->table(static::$tableName)->where('id', $exist->id)->update([
                'response'       => $response,
                'step_completed' => $formData['active_step'],
                'updated_at'     => current_time('mysql')
            ]);
        }

        $this->setcookie($this->getCookieName($formId), $hash, $this->getExpiryDate());
    }

    public function delete($insertId, $formData, $form)
    {
        if (Helper::getFormMeta($form->id, 'step_data_persistency_status') != 'yes') {
            return;
        }
        if ($hash = Arr::get($_COOKIE, $this->getCookieName($form->id))) {
            ob_start();
            wpFluent()->table(static::$tableName)->where('hash', $hash)->delete();
            $this->deleteCookie();
            $errors = ob_get_clean();
        }

        if ($userId = get_the_ID()) {
            wpFluent()->table(static::$tableName)
                ->where('user_id', $userId)
                ->where('form_id', $form->id)
                ->delete();
        }
    }

    protected function getHash()
    {
        return Arr::get(
            $_COOKIE, $this->getCookieName(), wp_generate_uuid4()
        );
    }

    protected function getCookieName($formId = false)
    {
        $formId = $formId ? $formId : $this->app->request->get('form_id');

        return static::$cookieName . '_' . $formId;
    }

    protected function getExpiryDate($previousTime = false)
    {
        $offset = 7 * 24 * 60 * 60;
        return ($previousTime ? time() - $offset : time() + $offset);
    }

    protected function setCookie($name, $value, $expiryDate)
    {
        setcookie(
            $name,
            $value,
            $expiryDate,
            COOKIEPATH,
            COOKIE_DOMAIN
        );
    }

    protected function deleteCookie()
    {
        $this->setcookie($this->getCookieName(), '', $this->getExpiryDate(true));
    }

    public function checkPartialSettings($fields, $formId)
    {
        $fieldsArray = \json_decode($fields, true);
        $isPartialEnabled = 'no';
        if (isset($fieldsArray['stepsWrapper'])) {
            $isPartialEnabled = Arr::get($fieldsArray, 'stepsWrapper.stepStart.settings.enable_step_data_persistency', 'no');
        }
        self::migrate();
        Helper::setFormMeta($formId, 'step_data_persistency_status', $isPartialEnabled);
        return $fields;
    }

    /**
     * Migrate the table.
     *
     * @return void
     */
    public static function migrate()
    {
        global $wpdb;
        $charsetCollate = $wpdb->get_charset_collate();
        $table = $wpdb->prefix . static::$tableName;
        if ($wpdb->get_var("SHOW TABLES LIKE '$table'") != $table) {
            $sql = "CREATE TABLE $table (
                `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			    `form_id` INT UNSIGNED NULL,
			    `hash` VARCHAR(255) NOT NULL,
			    `type` VARCHAR(255) DEFAULT 'step_data',
			    `step_completed` INT UNSIGNED NOT NULL,
                `user_id` INT UNSIGNED NOT NULL,
                `response` LONGTEXT NULL,
                `source_url` VARCHAR(255) NULL,
                `browser` VARCHAR(45) NULL,
                `device` VARCHAR(45) NULL,
                `ip` VARCHAR(45) NULL,
                `created_at` TIMESTAMP NULL,
                `updated_at` TIMESTAMP NULL,
                 PRIMARY KEY (`id`) ) $charsetCollate;";
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    }
}
