<?php

class FluentFormAddOnChecker
{
    private $vars;

    function __construct($vars)
    {
        $this->vars = $vars;
        add_action('admin_init', array($this, 'init'));
        add_action('admin_init', array($this, 'activate_license'));
        add_action('admin_init', array($this, 'deactivate_license'));
        add_action('admin_init', array($this, 'check_license'));
        add_action('admin_init', array($this, 'sl_updater'), 0);
        add_filter('fluentform_addons_extra_menu', array($this, 'registerLicenseMenu'));
        add_action('fluentform_addons_page_render_' . $this->get_var('menu_slug'), array($this, 'license_page'));
    }

    public function isLocal()
    {
        $ip_address = '';
        if (array_key_exists('SERVER_ADDR', $_SERVER)) {
            $ip_address = $_SERVER['SERVER_ADDR'];
        } else if (array_key_exists('LOCAL_ADDR', $_SERVER)) {
            $ip_address = $_SERVER['LOCAL_ADDR'];
        }
        return in_array($ip_address, array("127.0.0.1", "::1"));
    }

    function get_var($var)
    {
        if (isset($this->vars[$var])) {
            return $this->vars[$var];
        }
        return false;
    }

    public function registerLicenseMenu($menus)
    {
        $menus[$this->get_var('menu_slug')] = $this->get_var('menu_title');
        return $menus;
    }

    public function register_option()
    {
        // creates our settings in the options table
        register_setting($this->get_var('option_group'), $this->get_var('license_key'));
    }

    /**
     * Show an error message that license needs to be activated
     */
    function init()
    {
        $this->register_option();
        if (defined('DOING_AJAX') && DOING_AJAX) {
            return;
        }

        if (!defined('FLUENTFORM_VERSION')) {
            return;
        }

        $licenseStatus = $this->getSavedLicenseStatus();

        if (!$licenseStatus) {
            add_action('admin_notices', function () {
                echo '<div class="error error_notice' . $this->get_var('option_group') . '"><p>' .
                    sprintf(__('The %s license needs to be activated. %sActivate Now%s', 'ninja-tables-pro'),
                        $this->get_var('plugin_title'), '<a href="' . $this->get_var('activate_url') . '">',
                        '</a>') .
                    '</p></div>';
            });
            return;
        }

        $licenseData = get_option($this->get_var('license_status') . '_checking');

        if (!$licenseData) {
            return;
        }

        if ($licenseStatus == 'expired') {
            $expireMessage = $this->getExpireMessage($licenseData);
            add_filter('fluentform_dashboard_notices', function ($notices) use ($expireMessage) {
                $notices['license_expire'] = array(
                    'type'     => 'error',
                    'message'  => $expireMessage,
                    'closable' => false
                );
                return $notices;
            });
            if ($this->willShowExpirationNotice()) {
                add_action('admin_notices', function () use ($expireMessage) {
                    echo '<div class="error">' . $expireMessage . '</div>';
                });
            }
            return;
        }

        if ('valid' != $licenseStatus) {
            add_action('admin_notices', function () {
                echo '<div class="error error_notice' . $this->get_var('option_group') . '"><p>' .
                    sprintf(__('The %s license needs to be activated. %sActivate Now%s', 'ninja-tables-pro'),
                        $this->get_var('plugin_title'), '<a href="' . $this->get_var('activate_url') . '">',
                        '</a>') .
                    '</p></div>';
            });
        }
    }

    function sl_updater()
    {
        // retrieve our license key from the DB
        $license_key = trim(get_option($this->get_var('license_key')));
        $license_status = get_option($this->get_var('license_status'));

        // setup the updater
        new FluentFormAddOnUpdater($this->get_var('store_url'), $this->get_var('plugin_file'), array(
            'version'   => $this->get_var('version'),
            'license'   => $license_key,
            'item_name' => $this->get_var('item_name'),
            'item_id'   => $this->get_var('item_id'),
            'author'    => $this->get_var('author')
        ),
            array(
                'license_status' => $license_status,
                'admin_page_url' => $this->get_var('activate_url'),
                'purchase_url'   => $this->get_var('purchase_url'),
                'plugin_title'   => $this->get_var('plugin_title')
            )
        );
    }

    function license_page()
    {
        $license = $this->getSavedLicenseKey();
        $status = $this->getSavedLicenseStatus();

        if ($status == 'expired' && $license) {
            $activation = $this->tryActivateLicense($license);
            $status = $this->getSavedLicenseStatus();
        }

        $licenseData = false;
        if ($status) {
            $licenseData = get_option($this->get_var('license_status') . '_checking');
            if (!$licenseData) {
                $remoteData = $this->getRemoteLicense();
                if ($remoteData && !is_wp_error($remoteData)) {
                    $licenseData = $remoteData;
                }
            }
        }

        $renewHtml = $this->getRenewHtml($licenseData);
        settings_errors();
        ?>
        <div class="signature_activate_wrapper fluent_activation_wrapper">
        <h2><?php echo esc_html($this->get_var('plugin_title')) ?></h2>

        <?php if ($renewHtml): ?>
            <div style="padding: 20px; margin-bottom: 20px; background: white;" class="ff_renew_html">
                <?php echo $renewHtml; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="options.php">
            <?php settings_fields($this->get_var('option_group')); ?>
            <?php if ('valid' != $status): ?>
                <p><?php echo esc_html(sprintf(__('Thank you for purchasing %s!  Please enter your license key below.',
                        'fluentformpro'), $this->get_var('plugin_title'))); ?></p>
            <?php endif; ?>

            <?php
            if ($status != false && $status == 'valid') {
                $extraClass = 'fluent_plugin_activated_hide';
            } else {
                $extraClass = '';
            }
            if (isset($_GET['debug'])) {
                $extraClass = '';
            }
            ?>
            <label class="fluentform_label <?php echo $extraClass; ?>">
                <span><?php _e('Enter your license key'); ?></span>
                <input id="<?php echo esc_attr($license) ?>"
                       name="<?php echo $this->get_var('license_key') ?>"
                       type="text" class="regular-text" value="<?php esc_attr_e($license); ?>"/>
            </label>

            <?php if ($status !== false && $status == 'valid') { ?>
                <div class="license_activated_sucess">
                    <?php _e('Your license is active! Enjoy '); ?><?php echo esc_html($this->get_var('plugin_title')) ?>
                </div>
                <?php wp_nonce_field($this->get_var('option_group') . '_nonce',
                    $this->get_var('option_group') . '_nonce'); ?>
                <input type="hidden" name="<?php echo $this->get_var('option_group') ?>_do_deactivate_license"
                       value="1"/>
                <input type="submit" class="button-secondary" name="<?= $this->get_var('option_group') ?>_deactivate"
                       value="<?php _e('Deactivate License'); ?>"/>
            <?php } else {
                wp_nonce_field($this->get_var('option_group') . '_nonce',
                    $this->get_var('option_group') . '_nonce'); ?>
                <input type="hidden" name="<?php echo $this->get_var('option_group') ?>_do_activate_license" value="1"/>
                <input type="submit" class="button-primary button_activate"
                       name="<?php echo $this->get_var('option_group') ?>_activate"
                       value="<?php _e('Activate License'); ?>"/>
            <?php } ?>
            <p class="contact_us_line"><?php echo sprintf(esc_html(__('Any questions or problems with your license? %sContact us%s!',
                    'fluentform-signature')), '<a href="' . $this->get_var('contact_url') . '">', '</a>'); ?></p>
        </form>
        <?php
    }

    function activate_license()
    {
        // listen for our activate button to be clicked
        if (!isset($_POST[$this->get_var('option_group') . '_do_activate_license'])) {
            return;
        }

        if (!\FluentForm\App\Modules\Acl\Acl::hasPermission('fluentform_full_access')) {
            add_settings_error(
                $this->get_var('option_group'),
                'deactivate',
                __('Sorry! You do not have permission to activate this license.', 'fluentformpro')
            );
            return;
        }

        // run a quick security check
        if (!check_admin_referer($this->get_var('option_group') . '_nonce',
            $this->get_var('option_group') . '_nonce')
        ) {
            return;
        } // get out if we didn't click the Activate button

        // retrieve the license from the database
        $license = trim($_REQUEST[$this->get_var('option_group') . '_key']);

        $result = $this->tryActivateLicense($license);
        if (is_wp_error($result)) {
            $message = $result->get_error_message();
            add_settings_error(
                $this->get_var('option_group'),
                'activate',
                $message
            );
            return;
        }

        return;
    }

    private function tryActivateLicense($license)
    {
        $isNetworkMainSite = is_multisite();

        if ($isNetworkMainSite) {
            // data to send in our API request
            $api_params = array(
                'edd_action' => 'activate_license',
                'license'    => $license,
                'item_name'  => urlencode($this->get_var('item_name')), // the name of our product in EDD
                'item_id'    => $this->get_var('item_id'),
                'url'        => network_site_url()
            );
        } else {
            // data to send in our API request
            $api_params = array(
                'edd_action' => 'activate_license',
                'license'    => $license,
                'item_name'  => urlencode($this->get_var('item_name')), // the name of our product in EDD
                'item_id'    => $this->get_var('item_id'),
                'url'        => home_url()
            );
        }

        // Call the custom API.
        $response = wp_remote_get(
            $this->get_var('store_url'),
            array('timeout' => 15, 'sslverify' => false, 'body' => $api_params)
        );

        // make sure the response came back okay
        if (is_wp_error($response)) {
            $license_data = file_get_contents($this->get_var('store_url') . '?' . http_build_query($api_params));
            if (!$license_data) {
                $license_data = $this->urlGetContentFallBack($this->get_var('store_url') . '?' . http_build_query($api_params));
            }
            if (!$license_data) {
                return new WP_Error(
                    423,
                    'Error when contacting with license server. Please check that your server have curl installed',
                    [
                        'response' => $response,
                        'is_error' => true
                    ]
                );
            }
            $license_data = json_decode($license_data);
        } else {
            $license_data = json_decode(wp_remote_retrieve_body($response));
        }

        // $license_data->license will be either "valid" or "invalid"
        if ($license_data->license) {
            if ($license_data->license == 'invalid' && $license_data->error == 'expired') {
                $this->setLicenseStatus('expired');
            } else {
                $this->setLicenseStatus($license_data->license);
            }
        }

        $license_data->next_timestamp = time() + $this->get_var('cache_time');

        update_option(
            $this->get_var('license_status') . '_checking',
            $license_data
        );

        if ('valid' == $license_data->license) {
            $this->setLicenseKey($license);
            // save the license key to the database
            return array(
                'message'  => 'Congratulation! ' . $this->get_var('plugin_title') . ' is successfully activated',
                'response' => $license_data,
                'status'   => 'valid'
            );
        }

        $errorMessage = $this->getErrorMessage($license_data, $license);

        return new WP_Error(
            423,
            $errorMessage,
            [
                'license_data' => $license_data,
                'is_error'     => true
            ]
        );
    }

    function deactivate_license()
    {
        // listen for our activate button to be clicked
        if (isset($_POST[$this->get_var('option_group') . '_do_deactivate_license'])) {
            if (!\FluentForm\App\Modules\Acl\Acl::hasPermission('fluentform_full_access')) {
                add_settings_error(
                    $this->get_var('option_group'),
                    'deactivate',
                    __('Sorry! You do not have permission to deactivate this license.', 'fluentformpro')
                );
                return;
            }

            // run a quick security check
            if (!check_admin_referer($this->get_var('option_group') . '_nonce',
                $this->get_var('option_group') . '_nonce')
            ) {
                return;
            } // get out if we didn't click the Activate button

            // retrieve the license from the database

            $license = $this->getSavedLicenseKey();

            // data to send in our API request
            $api_params = array(
                'edd_action' => 'deactivate_license',
                'license'    => $license,
                'item_name'  => urlencode($this->get_var('item_name')), // the name of our product in EDD
                'item_id'    => $this->get_var('item_id'),
                'url'        => home_url()
            );

            // Call the custom API.
            $response = wp_remote_post($this->get_var('store_url'),
                array('timeout' => 15, 'sslverify' => false, 'body' => $api_params));

            // make sure the response came back okay
            if (is_wp_error($response)) {
                add_settings_error(
                    $this->get_var('option_group'),
                    'deactivate',
                    __('There was an error deactivating the license, please try again or contact support.',
                        'fluentformpro')
                );
                return false;
            }

            // decode the license data
            $license_data = json_decode(wp_remote_retrieve_body($response));

            // $license_data->license will be either "deactivated" or "failed"
            if ('deactivated' == $license_data->license || $license_data->license == 'failed') {
                $this->setLicenseStatus(false);
                $this->setLicenseKey(false);
                delete_option($this->get_var('license_status') . '_checking');
                add_settings_error(
                    $this->get_var('option_group'),
                    'deactivate',
                    __('License deactivated', 'fluentformpro')
                );
                wp_safe_redirect($this->get_var('activate_url'));
                exit();

            } else {
                add_settings_error(
                    $this->get_var('option_group'),
                    'deactivate',
                    __('Unable to deactivate license, please try again or contact support.', 'fluentformpro')
                );
            }
        }
    }

    public function check_license()
    {
        $cachedData = get_option($this->get_var('license_status') . '_checking');

        $nextTimestamp = (!empty($cachedData->next_timestamp)) ? $cachedData->next_timestamp : 0;

        if ($nextTimestamp > time()) {
            return;
        }

        $license_data = $this->getRemoteLicense();

        if (is_wp_error($license_data) || !$license_data) {
            return false;
        }

        if ($license_data && $license_data->license) {
            $this->setLicenseStatus($license_data->license);
        }

        $license_data->next_timestamp = time() + $this->get_var('cache_time');

        // Set to check again in sometime later.
        update_option(
            $this->get_var('license_status') . '_checking',
            $license_data
        );
    }

    private function getRemoteLicense()
    {
        $license = $this->getSavedLicenseKey();

        if (!$license) {
            return false;
        }

        if (is_multisite()) {
            $api_params = array(
                'edd_action' => 'check_license',
                'license'    => $license,
                'item_name'  => urlencode($this->get_var('item_name')),
                'url'        => network_site_url()
            );
        } else {
            $api_params = array(
                'edd_action' => 'check_license',
                'license'    => $license,
                'item_name'  => urlencode($this->get_var('item_name')),
                'url'        => home_url()
            );
        }

        // Call the custom API.
        $response = wp_remote_get(
            $this->get_var('store_url'),
            array(
                'timeout'   => 15,
                'sslverify' => false,
                'body'      => $api_params
            )
        );

        if (is_wp_error($response)) {
            return $response;
        }

        $license_data = json_decode(
            wp_remote_retrieve_body($response)
        );

        return $license_data;
    }

    private function getErrorMessage($licenseData, $licenseKey = false)
    {
        $errorMessage = 'There was an error activating the license, please verify your license is correct and try again or contact support.';

        if ($licenseData->error == 'expired') {
            $renewUrl = $this->getRenewUrl($licenseKey);
            $errorMessage = 'Your license has been expired at ' . $licenseData->expires . ' . Please <a target="_blank" href="' . $renewUrl . '">click here</a> to renew your license';
        } else if ($licenseData->error == 'no_activations_left') {
            $errorMessage = 'No Activation Site left: You have activated all the sites that your license offer. Please go to wpmanageninja.com account and review your sites. You may deactivate your unused sites from wpmanageninja account or you can purchase another license. <a target="_blank" href="' . $this->get_var('purchase_url') . '">Click Here to purchase another license</a>';
        } else if ($licenseData->error == 'missing') {
            $errorMessage = 'The given license key is not valid. Please verify that your license is correct. You may login to wpmanageninja.com account and get your valid license key for your purchase.';
        }

        return $errorMessage;
    }

    private function urlGetContentFallBack($url)
    {
        $parts = parse_url($url);
        $host = $parts['host'];
        $result = false;
        if (!function_exists('curl_init')) {
            $ch = curl_init();
            $header = array('GET /1575051 HTTP/1.1',
                "Host: {$host}",
                'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Language:en-US,en;q=0.8',
                'Cache-Control:max-age=0',
                'Connection:keep-alive',
                'Host:adfoc.us',
                'User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36',
            );
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
            curl_setopt($ch, CURLOPT_COOKIESESSION, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            $result = curl_exec($ch);
            curl_close($ch);
        }
        if (!$result && function_exists('fopen') && function_exists('stream_get_contents')) {
            $handle = fopen($url, "r");
            $result = stream_get_contents($handle);
        }
        return $result;
    }

    private function getSavedLicenseKey()
    {
        if (is_multisite()) {
            $license = trim(get_network_option(get_main_network_id(), $this->get_var('license_key')));
        } else {
            $license = trim(get_option($this->get_var('license_key')));
        }
        return $license;
    }

    private function setLicenseKey($key)
    {
        if (is_multisite()) {
            $status = update_network_option(get_main_network_id(), $this->get_var('license_key'), $key);
        } else {
            $status = update_option($this->get_var('license_key'), $key);
        }
        return $status;
    }

    private function getSavedLicenseStatus()
    {
        if (is_multisite()) {
            $status = trim(get_network_option(get_main_network_id(), $this->get_var('license_status')));
        } else {
            $status = trim(get_option($this->get_var('license_status')));
        }
        return $status;
    }

    private function setLicenseStatus($status)
    {
        if (is_multisite()) {
            $status = update_network_option(get_main_network_id(), $this->get_var('license_status'), $status);
        } else {
            $status = update_option($this->get_var('license_status'), $status);
        }
        return $status;
    }

    private function getExpireMessage($licenseData)
    {
        $renewUrl = $this->get_var('activate_url');

        return '<p>Your ' . $this->get_var('plugin_title') . ' license has been <b>expired at ' . date('d M Y', strtotime($licenseData->expires)) . '</b>, Please ' .
            '<a href="' . $renewUrl . '"><b>Click Here to Renew Your License</b></a>' . '</p>';
    }

    private function willShowExpirationNotice()
    {
        if (!defined('FLUENTFORM_VERSION') || !\FluentForm\App\Modules\Acl\Acl::hasAnyFormPermission()) {
            return false;
        }
        global $pagenow;
        $showablePages = ['index.php', 'plugins.php'];
        if (in_array($pagenow, $showablePages)) {
            return true;
        }
        return false;
    }

    private function getRenewHtml($license_data)
    {
        if (!$license_data) {
            return;
        }
        $status = $this->getSavedLicenseStatus();
        if (!$status) {
            return;
        }
        $renewUrl = $this->getRenewUrl();
        $renewHTML = '';
        if ($status == 'expired') {
            $expiredDate = date('d M Y', strtotime($license_data->expires));
            $renewHTML = '<p>Your license was expired at <b>' . $expiredDate . '</b></p>';
            $renewHTML .= '<p><a class="button-secondary button_activate" target="_blank" href="' . $renewUrl . '">click here to renew your license</a></p>';
        } else if ($status == 'valid') {
            if ($license_data->expires != 'lifetime') {
                $expireDate = date('d M Y', strtotime($license_data->expires));
                $interval = strtotime($license_data->expires) - time();
                $intervalDays = intval($interval / (60 * 60 * 24));
                if ($intervalDays < 30) {
                    $renewHTML = '<p>Your license will be expired in ' . $intervalDays . ' days</p>';
                    $renewHTML .= '<p>Please <a class="button-secondary button_activate" target="_blank" href="' . $renewUrl . '">click here to renew your license</a></p>';
                }
            }
        }

        return $renewHTML;
    }

    private function getRenewUrl($licenseKey = false)
    {
        if (!$licenseKey) {
            $licenseKey = $this->getSavedLicenseKey();
        }
        if ($licenseKey) {
            $renewUrl = $this->get_var('store_url') . '/checkout/?edd_license_key=' . $licenseKey . '&download_id=' . $this->get_var('item_id');
        } else {
            $renewUrl = $this->get_var('purchase_url');
        }
        return $renewUrl;
    }

}
