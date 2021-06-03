<?php
namespace um_ext\um_unsplash\admin;


if ( ! defined( 'ABSPATH' ) ) exit;


if ( ! class_exists( 'um_ext\um_unsplash\admin\Admin' ) ) {


	/**
	 * Class Admin
	 * @package um_ext\um_unsplash\admin
	 */
	class Admin {


		/**
		 * Admin constructor.
		 */
		function __construct() {
			add_filter( 'um_settings_structure', array( &$this, 'extend_settings' ), 10, 1 );
		}


		/**
		 * Additional Settings for Photos
		 *
		 * @param array $settings
		 *
		 * @return array
		 */
		function extend_settings( $settings ) {

			$settings['licenses']['fields'][] = array(
				'id'        => 'um_unsplash_license_key',
				'label'     => __( 'Unsplash License Key', 'um-unsplash' ),
				'item_name' => 'Unsplash',
				'author'    => 'ultimatemember',
				'version'   => um_unsplash_version,
			);

			$key = ! empty( $settings['extensions']['sections'] ) ? 'um-unsplash' : '';

			$settings['extensions']['sections'][ $key ] = array(
				'title'     => __( 'Unsplash', 'um-unsplash' ),
				'fields'    => array(
					array(
						'id'            => 'unsplash_no_of_photos',
						'type'          => 'text',
						'placeholder'   => '1 to 30',
						'label'         => __( 'No. of photos to display', 'um-unsplash' ),
						'size'          => 'medium',
					),
					array(
						'id'            => 'unsplash_default_keyword',
						'type'          => 'text',
						'placeholder'   => __( 'Example : Light', 'um-unsplash' ),
						'label'         => __( 'Default keyword', 'um-unsplash' ),
						'size'          => 'medium',
						'default'       => 'light',
					)
				)
			);

			return $settings;
		}
	}
}