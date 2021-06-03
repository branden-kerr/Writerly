<?php

namespace FluentFormPro\Payments\Migrations;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class OrderItems
{
    /**
     * Migrate the table.
     *
     * @return void
     */
    public static function migrate()
    {
        global $wpdb;

        $charsetCollate = $wpdb->get_charset_collate();

        $table = $wpdb->prefix . 'fluentform_order_items';

        if ($wpdb->get_var("SHOW TABLES LIKE '$table'") != $table) {
            $sql = "CREATE TABLE $table (
				id int(11) NOT NULL AUTO_INCREMENT,
				form_id int(11) NOT NULL,
				submission_id int(11) NOT NULL,
				type varchar(255) DEFAULT 'single',
				parent_holder varchar(255),
				billing_interval varchar(255),
				item_name varchar(255),
				quantity int(11) DEFAULT 1,
				item_price int(11),
				line_total int(11),
				created_at timestamp NULL,
				updated_at timestamp NULL,
				PRIMARY  KEY  (id)
			  ) $charsetCollate;";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

            dbDelta($sql);
        }
    }
}