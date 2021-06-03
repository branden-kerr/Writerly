<?php
/**
 * Polite Social Icons menu widget
 *
 * @since 1.0.0
 */

if (!class_exists('Polite_Social_Widget')) :

    /**
     * Social widget class.
     */
    class Polite_Social_Widget extends WP_Widget
    {
         private function defaults()
        {
            $defaults = array(
                'title'    => esc_html__( 'Follow Us', 'polite' ),
           );
            return $defaults;
        }

        /**
         * Constructor.
         */
        public function __construct()
        {
            $opts = array(
                'classname' => 'polite-menu-social',
                'description' => esc_html__('Social Menu Widget', 'polite'),
            );
            parent::__construct('polite-social-icons', esc_html__('Polite Social', 'polite'), $opts);
        }

        /**
         * Widget content.
         */
        public function widget($args, $instance)
        {
            $instance = wp_parse_args( (array) $instance, $this->defaults() );

            $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

            echo $args['before_widget'];

            if (!empty($title)) {
                echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
            }

            if (has_nav_menu('social')) {
                wp_nav_menu(array('theme_location' => 'social', 'menu_class' => 'social-menu'));
            }

            echo $args['after_widget'];

        }

        /**
         * Update
         */
        public function update($new_instance, $old_instance)
        {
            $instance = $old_instance;

            $instance['title'] = sanitize_text_field($new_instance['title']);

            return $instance;
        }

        /**
         * Form
         */
        public function form($instance)
        {
             $instance  = wp_parse_args( (array )$instance, $this->defaults() );

            ?>
            <p>
                <label
                    for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'polite'); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                       name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                       value="<?php echo esc_attr($instance['title']); ?>"/>
            </p>

            <?php if (!has_nav_menu('social')) : ?>
            <p>
                <?php esc_html_e('Go to Appearance > Customize > Menus and create a menu and assign to Social.', 'polite'); ?>
            </p>
        <?php endif; ?>
        <?php
        }
    }

endif;