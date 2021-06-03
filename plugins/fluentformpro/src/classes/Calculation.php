<?php
namespace FluentFormPro\classes;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Calculation
{
    public function enqueueScripts()
    {
        wp_enqueue_script('fluentform-advanced');
        wp_enqueue_script('fluent-math-expression', FLUENTFORMPRO_DIR_URL.'public/libs/math-expression.min.js', array(), '1.2.17');
    }
}