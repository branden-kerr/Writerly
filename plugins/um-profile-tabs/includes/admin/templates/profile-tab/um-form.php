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

$forms_options = [
	'' => __( 'No form', 'um-profile-tabs' ),
];
if ( ! empty( $forms ) && ! is_wp_error( $forms ) ) {
	foreach ( $forms as $form ) {
		$forms_options[ $form->ID ] = $form->post_title;
	}
}

$selected_form = get_post_meta( $tab_id, 'um_form', true );

if ( $selected_form ) { ?>
	<p>[ultimatemember form_id="<?php echo $selected_form; ?>" /]</p>
<?php }

UM()->admin_forms( [
	'class'     => 'um-profile-tab-um-form um-top-label',
	'prefix_id' => 'um_profile_tab',
	'fields'    => [
		[
			'id'        => '_um_form',
			'type'      => 'select',
			'options'   => $forms_options,
			'label'     => __( 'Custom Profile Form', 'um-profile-tabs' ),
			'value'     => $selected_form,
		],
	],
] )->render_form();