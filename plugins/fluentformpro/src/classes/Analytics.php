<?php
namespace FluentFormPro\classes;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Analytics
{
    public function registerMenu($menus, $form_id)
    {
//        $menus['analytics'] = array(
//            'slug'  => 'analytics',
//            'title' => __('Analytics', 'fluentformpro')
//        );

        return $menus;
    }

    public function render($form_id)
    {
        $analytics = array(
//            'uniqueViews' => $this->getUniqueViews($form_id)
        );
        require (FLUENTFORMPRO_DIR_PATH.'src/views/analytics_view.php');

        wp_enqueue_script(
            'fluentformpro_analytics_render',
            FLUENTFORMPRO_DIR_URL."public/js/analytics.js",
            false
        );

        wp_localize_script('fluentformpro_analytics_render', 'fluentformpro_analytics', array(
            'form_id' => $form_id,
            'analytics' => $analytics
        ));
    }

    private function getUniqueViews($form_id, $start, $end)
    {
        return wpFluent()->table('fluentform_form_analytics')
            ->where('form_id', $form_id)
            ->whereBetween('created_at', $start, $end)
            ->count();
    }

    private function getTotalViews($form_id, $start, $end)
    {
        global $wpdb;
        $views =  wpFluent()->table('fluentform_form_analytics')
                        ->select(wpFluent()->raw('SUM('.$wpdb->prefix.'fluentform_form_analytics.count) as total_views'))
                         ->where('form_id', $form_id)
                         ->whereBetween('created_at', $start, $end)
                         ->first();

        return ($views) ? $views->total_views : 0;
    }

    private function byWeek($form_id) {
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $start = date('Y-m-d 00:00:00', strtotime("-$i day"));
            $day = date('l', strtotime($start));
            $end = date('Y-m-d 23:59:59', strtotime("-$i day"));
            $uniqueViews = $this->getUniqueViews($form_id, $start, $end);
            $totalViews = $this->getTotalViews($form_id, $start, $end);

            $data['labels'][] = $day;
            $data['totalViews'][] = $totalViews;
            $data['uniqueViews'][] = $uniqueViews;
        }
        return $data;
    }

    private function byMonth($form_id) {
        $data = [];
        $totalDays = (int)date('t');

        for ($i = 1; $i <= $totalDays; $i++) {
            $start = date("Y-m-$i 00:00:00", strtotime("-$i day"));
            $end = date("Y-m-$i 23:59:59", strtotime("-$i day"));
            $uniqueViews = $this->getUniqueViews($form_id, $start, $end);
            $totalViews = $this->getTotalViews($form_id, $start, $end);

            $data['labels'][] = date('Y-m-d', strtotime($start));
            $data['totalViews'][] = $totalViews;
            $data['uniqueViews'][] = $uniqueViews;
        }
        return $data;
    }

    public function fetchAnalytics()
    {
        $data_span = sanitize_text_field($_REQUEST['data_span']);
        $form_id = intval($_REQUEST['form_id']);

        $data = [];

        if ($data_span == 'week') {
            $data = $this->byWeek($form_id);
        }

        if ($data_span == 'month') {
            $data = $this->byMonth($form_id);
        }

        wp_send_json_success(array(
            'analytics' => $data
        ), 200);

        wp_send_json_error(array(

        ), 421);
    }

}