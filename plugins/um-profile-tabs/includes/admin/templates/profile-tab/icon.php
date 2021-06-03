<?php if ( ! defined( 'ABSPATH' ) ) exit;

global $post;

$tab_id = $post->ID;
if ( UM()->external_integrations()->is_wpml_active() ) {
	global $sitepress;

	$default_lang_tab_id = $sitepress->get_object_id( $tab_id, 'um_profile_tabs', true, $sitepress->get_default_language() );
	if ( $default_lang_tab_id && $default_lang_tab_id != $tab_id ) {
		$tab_id = $default_lang_tab_id; ?>

		<p><?php _e( 'These settings are obtained from a Profile tab in the default language', 'um-profile-tabs' ) ?></p>
	<?php }
}

UM()->admin_forms( [
	'class'     => 'um-profile-tab-icon um-top-label',
	'prefix_id' => 'um_profile_tab',
	'fields'    => [
		[
			'id'    => '_icon',
			'type'  => 'icon',
			'label' => __( 'Icon', 'um-profile-tabs' ),
			'value' => get_post_meta( $tab_id, 'um_icon', true ),
		],
	],
] )->render_form();