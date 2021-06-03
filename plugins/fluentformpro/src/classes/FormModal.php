<?php
namespace FluentFormPro\classes;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class FormModal
{

    public static $instanceId = 0;

    public static function renderModal($atts)
    {
        self::$instanceId += 1;
        $uniqueId = 'ff_modal_instance_'.self::$instanceId;


        if(self::$instanceId == 1) {
            wp_enqueue_script('lity', FLUENTFORMPRO_DIR_URL.'public/libs/lity/lity.min.js', array('jquery'), '2.3.1', true);
            wp_enqueue_style('lity', FLUENTFORMPRO_DIR_URL.'public/libs/lity/lity.min.css', array(), '2.3.1', 'all');
            add_action('wp_footer', function () {
                ?>
                <script type="text/javascript">
                    jQuery(document).ready(function () {
                        jQuery('.ff_modal_btn').on('click', function (e) {
                            if(!jQuery(this).data('instance')) {
                                return;
                            }
                            var instanceId = jQuery(this).data('instance');
                            jQuery(document).on('click', '#'+instanceId, lity);
                        });
                    });
                </script>
                <?php
            }, 999999);
        }

        return '<div class="ff_form_modal"><button data-lity data-lity-target="#'.$uniqueId.'" class="ff_modal_btn '.$atts['css_class'].'">'.$atts['btn_text'].'</button><div style="display: none" class="ff_form_modal_body"><div style="background-color: '.$atts['bg_color'].'" class="ff_modal_container lity-hide" id="'.$uniqueId.'">'.do_shortcode('[fluentform id="'.$atts['form_id'].'"]').'</div></div></div>';
    }

}