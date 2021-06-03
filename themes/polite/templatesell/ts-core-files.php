<?php
/**
 * Load Core Files
 *
 * @since 1.0.0
*/
/**
 * Enqueue CSS and JS
 */
require get_template_directory() . '/templatesell/enqueue.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/templatesell/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/templatesell/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/templatesell/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/templatesell/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/templatesell/jetpack.php';
}

/**
 * Load sanitize functions file
 */
require get_template_directory() . '/templatesell/sanitize-functions.php';

/**
 * Load category dropdown functions
 */
require get_template_directory() . '/templatesell/customizer-category-control.php';

/**
 * Load category dropdown functions
 */
require get_template_directory() . '/templatesell/customizer-radio-image-control.php';

/**
 * Dynamic CSS file load
 */
require get_template_directory() . '/templatesell/dynamic-css.php';

/**
 * load custom widgets
 */
require get_template_directory() . '/templatesell/widgets/widget-init.php';
require get_template_directory() . '/templatesell/widgets/ts-author-widget.php';
require get_template_directory() . '/templatesell/widgets/ts-recent-posts-widget.php';
require get_template_directory() . '/templatesell/widgets/ts-social-widget.php';

/**
 * Load Hooks
*/
require get_template_directory() . '/templatesell/hooks/related-posts.php';
require get_template_directory() . '/templatesell/hooks/posts-navigation.php';
require get_template_directory() . '/templatesell/hooks/breadcrumb.php';
require get_template_directory() . '/templatesell/hooks/social-sharing.php';
require get_template_directory() . '/templatesell/hooks/sections.php';
require get_template_directory() . '/templatesell/hooks/footer.php';
require get_template_directory() . '/templatesell/hooks/masonry.php';

/**
 * Load Filters
*/
require get_template_directory() . '/templatesell/filters/excerpt.php';
require get_template_directory() . '/templatesell/filters/jetpack-widget.php';
require get_template_directory() . '/templatesell/filters/body-class.php';

/**
 * Upgrade to pro
 */
 require get_template_directory() . '/templatesell/upgrade/class-customize.php';

/**
 * For Admin Page
 */
if ( is_admin() ) {
 require get_template_directory() . '/templatesell/about/about.php';
 require get_template_directory() . '/templatesell/pro-notice/pro-notice.php';
}
