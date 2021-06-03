<?php

namespace FluentFormPro\Components;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Services\FormBuilder\BaseFieldManager;
use FluentForm\Framework\Helpers\ArrayHelper;

class PhoneField extends BaseFieldManager
{
    public function __construct()
    {
        parent::__construct(
            'phone',
            'Phone/Mobile',
            ['phone', 'telephone', 'mobile'],
            'general'
        );

        /*
         * Upgrading component settings
         */
        add_filter('fluentform_editor_init_element_phone', function ($element) {
            if (!isset($element['settings']['phone_country_list'])) {
                $element['settings']['phone_country_list'] = array(
                    'active_list'  => 'all',
                    'visible_list' => array(),
                    'hidden_list'  => array(),
                );
                $element['settings']['default_country'] = '';
            }
            return $element;
        });
    }

    function getComponent()
    {
        return [
            'index'          => 15,
            'element'        => $this->key,
            'attributes'     => [
                'name'        => $this->key,
                'class'       => '',
                'value'       => '',
                'type'        => 'tel',
                'placeholder' => __('Mobile Number', 'fluentformpro')
            ],
            'settings'       => [
                'container_class'     => '',
                'placeholder'         => '',
                'int_tel_number'      => 'with_extended_validation',
                'auto_select_country' => 'no',
                'label'               => $this->title,
                'label_placement'     => '',
                'help_message'        => '',
                'admin_field_label'   => '',
                'phone_country_list'  => array(
                    'active_list'  => 'all',
                    'visible_list' => array(),
                    'hidden_list'  => array(),
                ),
                'default_country'     => '',
                'validation_rules'    => [
                    'required'           => [
                        'value'   => false,
                        'message' => __('This field is required', 'fluentformpro'),
                    ],
                    'valid_phone_number' => [
                        'value'   => false,
                        'message' => __('Phone number is not valid', 'fluentformpro')
                    ]
                ],
                'conditional_logics'  => []
            ],
            'editor_options' => [
                'title'      => $this->title . ' Field',
                'icon_class' => 'el-icon-phone-outline',
                'template'   => 'inputText'
            ],
        ];
    }

    public function getGeneralEditorElements()
    {
        return [
            'label',
            'admin_field_label',
            'placeholder',
            'value',
            'label_placement',
            'int_tel_number',
            'auto_select_country',
            'phone_country_list',
            'validation_rules',
        ];
    }

    public function generalEditorElement()
    {
        return [
            'int_tel_number'      => [
                'template'  => 'radio',
                'label'     => 'Enable Smart Phone Field',
                'help_text' => 'Enable this if you want to display smart phone input which will show flags and validate the number',
                'options'   => [
                    [
                        'label' => 'Disable',
                        'value' => 'no'
                    ],
                    [
                        'label' => 'With Extended Number Format',
                        'value' => 'with_extended_validation'
                    ]
                ]
            ],
            'auto_select_country' => [
                'template'   => 'radio',
                'label'      => 'Enable Auto Country Select',
                'help_text'  => 'If you enable this, The country will be selected based on user\'s ip address. ipinfo.io service will be used here',
                'options'    => [
                    [
                        'label' => 'No',
                        'value' => 'no'
                    ],
                    [
                        'label' => 'Yes',
                        'value' => 'yes'
                    ]
                ],
                'dependency' => array(
                    'depends_on' => 'settings/int_tel_number',
                    'value'      => 'no',
                    'operator'   => '!='
                )
            ],
            'phone_country_list'  => array(
                'template'       => 'customCountryList',
                'label'          => __('Available Countries', 'fluentform'),
                'disable_labels' => true,
                'key'            => 'phone_country_list',
                'dependency'     => array(
                    'depends_on' => 'settings/auto_select_country',
                    'value'      => 'yes',
                    'operator'   => '!='
                )
            )
        ];
    }

    public function render($data, $form)
    {

        $elementName = $data['element'];
        $data = apply_filters('fluenform_rendering_field_data_' . $elementName, $data, $form);

        $data['attributes']['class'] = @trim(
            'ff-el-form-control ff-el-phone ' . $data['attributes']['class']
        );

        $data['attributes']['id'] = $this->makeElementId($data, $form);

        if ($tabIndex = \FluentForm\App\Helpers\Helper::getNextTabIndex()) {
            $data['attributes']['tabindex'] = $tabIndex;
        }

        $data['attributes']['inputmode'] = 'tel';

        $flagType = ArrayHelper::get($data, 'settings.int_tel_number');

        if ($flagType == 'only_country_flag' || $flagType == 'with_extended_validation') {
            // $data['attributes']['placeholder'] = '';
            $data['attributes']['class'] .= ' ff_el_with_extended_validation';
            $this->pushScripts($data, $form);
        }
        $elMarkup = "<input " . $this->buildAttributes($data['attributes'], $form) . ">";


        $html = $this->buildElementMarkup($elMarkup, $data, $form);
        echo apply_filters('fluenform_rendering_field_html_' . $elementName, $html, $data, $form);
    }

    private function pushScripts($data, $form)
    {
        // We can add assets for this field
        wp_enqueue_style('intlTelInput');
        wp_enqueue_script('intlTelInput');
        wp_enqueue_script('intlTelInputUtils');


        add_action('wp_footer', function () use ($data, $form) {
            $geoLocate = ArrayHelper::get($data, 'settings.auto_select_country') == 'yes';

            $itlOptions = [
                'separateDialCode' => false,
                'nationalMode'     => true,
                'autoPlaceholder'  => 'aggressive',
                'formatOnDisplay'  => true
            ];

            if ($geoLocate) {
                $itlOptions['initialCountry'] = 'auto';
            } else {
                $itlOptions['initialCountry'] = ArrayHelper::get($data, 'settings.default_country', '');
                $activeList = ArrayHelper::get($data, 'settings.phone_country_list.active_list');

                if ($activeList == 'priority_based') {
                    $selectCountries = ArrayHelper::get($data, 'settings.phone_country_list.priority_based', []);
                    $priorityCountries = $this->getSelectedCountries($selectCountries);
                    $itlOptions['preferredCountries'] = array_keys($priorityCountries);
                } else if ($activeList == 'visible_list') {
                    $onlyCountries = ArrayHelper::get($data, 'settings.phone_country_list.visible_list', []);
                    $itlOptions['onlyCountries'] = $onlyCountries;
                } else if ($activeList == 'hidden_list') {
                    $countries = $this->loadCountries($data);
                    $itlOptions['onlyCountries'] = array_keys($countries);
                }
            }

            $itlOptions = apply_filters('fluentform_itl_options', $itlOptions, $data, $form);
            $itlOptions = json_encode($itlOptions);

            $settings = get_option('_fluentform_global_form_settings');
            $token = ArrayHelper::get($settings, 'misc.geo_provider_token');

            $url = 'https://ipinfo.io';
            if ($token) {
                $url = 'https://ipinfo.io/?token=' . $token;
            }
            $ipProviderUrl = apply_filters('fluentform_ip_provider', $url);

            ?>
            <script type="text/javascript">
                jQuery(document).ready(function ($) {
                    function initTelInput() {
                        if (typeof intlTelInput == 'undefined') {
                            return;
                        }
                        var telInput = jQuery('.<?php echo $form->instance_css_class; ?>').find("#<?php echo $data['attributes']['id']; ?>");
                        if (!telInput.length) {
                            return;
                        }

                        var itlOptions = JSON.parse('<?php echo $itlOptions; ?>');
                        <?php if($geoLocate && $ipProviderUrl): ?>
                        itlOptions.geoIpLookup = function (success, failure) {
                            jQuery.get("<?php echo $ipProviderUrl; ?>", function (res) {
                                return true;
                            }, "json").always(function (resp) {
                                var countryCode = (resp && resp.country) ? resp.country : "";
                                success(countryCode);
                            });
                        };
                        <?php endif; ?>
                        var iti = intlTelInput(telInput[0], itlOptions);
                        if (telInput.val()) {
                            iti.setNumber(telInput.val());
                        }
                        telInput.on("keyup change", function () {
                            if (typeof intlTelInputUtils !== 'undefined') { // utils are lazy loaded, so must check
                                var currentText = iti.getNumber(intlTelInputUtils.numberFormat.E164);
                                if (typeof currentText === 'string') { // sometimes the currentText is an object :)
                                    iti.setNumber(currentText); // will autoformat because of formatOnDisplay=true
                                }
                            }
                        });
                    }

                    initTelInput();
                    $(document).on('reInitExtras', '.<?php echo $form->instance_css_class; ?>', function () {
                        initTelInput();
                    });
                });
            </script>
            <?php
        }, 9999);
    }

    /**
     * Load countt list from file
     * @param array $data
     * @return array
     */
    protected function loadCountries($data)
    {
        $data['options'] = array();
        $activeList = ArrayHelper::get($data, 'settings.phone_country_list.active_list');
        $countries = getFluentFormCountryList();
        $filteredCountries = [];
        if ($activeList == 'visible_list') {
            $selectCountries = ArrayHelper::get($data, 'settings.phone_country_list.' . $activeList, []);
            foreach ($selectCountries as $value) {
                $filteredCountries[$value] = $countries[$value];
            }
        } elseif ($activeList == 'hidden_list' || $activeList == 'priority_based') {
            $filteredCountries = $countries;
            $selectCountries = ArrayHelper::get($data, 'settings.phone_country_list.' . $activeList, []);
            foreach ($selectCountries as $value) {
                unset($filteredCountries[$value]);
            }
        } else {
            $filteredCountries = $countries;
        }

        return $filteredCountries;
    }

    protected function getSelectedCountries($keys = [])
    {

        $options = [];
        $countries = getFluentFormCountryList();
        foreach ($keys as $value) {
            $options[$value] = $countries[$value];
        }

        return $options;
    }
}