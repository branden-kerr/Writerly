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

$all_roles = UM()->roles()->get_roles();

$forms = get_posts( [
	'post_type'         => 'um_form',
	'posts_per_page'    => -1,
	'meta_query'        => [
		[
			'key'       => '_um_mode',
			'compare'   => '=',
			'value'     => 'profile',
		],
	],
] );

$forms_options = [];
if ( ! empty( $forms ) && ! is_wp_error( $forms ) ) {
	foreach ( $forms as $form ) {
		$forms_options[ $form->ID ] = $form->post_title;
	}
}

UM()->admin_forms( [
	'class'     => 'um-profile-tab-access um-top-label',
	'prefix_id' => 'um_profile_tab',
	'fields'    => [
		[
			'id'        => '_can_have_this_tab_roles',
			'type'      => 'select',
			'options'   => $all_roles,
			'label'     => __( 'Show on these roles profiles', 'um-profile-tabs' ),
			'tooltip'   => __( 'You could select the roles which have the current profile tab at their form. If empty, profile tab is visible for all roles at their forms.', 'um-profile-tabs' ),
			'multi'     => true,
			'value'     => get_post_meta( $tab_id, '_can_have_this_tab_roles', true ),
		],
		[
			'id'        => '_can_have_this_tab_forms',
			'type'      => 'select',
			'options'   => $forms_options,
			'label'     => __( 'Show on these profiles forms', 'um-profile-tabs' ),
			'tooltip'   => __( 'You could select the forms where the current profile tab is visible. If empty, profile tab is visible for all forms.', 'um-profile-tabs' ),
			'multi'     => true,
			'value'     => get_post_meta( $tab_id, '_can_have_this_tab_forms', true ),
		],
	],
] )->render_form(); ?>

<p><?php printf( __( 'More profile menu settings you could set <a href="%s">here</a>', 'um-profile-tabs' ), admin_url( 'admin.php?page=um_options&tab=appearance&section=profile_menu' ) ) ?></p>
