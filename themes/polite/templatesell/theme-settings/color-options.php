<?php 
/* Primary Color Section Inside Core Color Option */
$wp_customize->add_setting( 'polite_options[polite_primary_color]',
    array(
        'default'           => $default['polite_primary_color'],
        'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(
    new WP_Customize_Color_Control(                 
        $wp_customize,
        'polite_options[polite_primary_color]',
        array(
            'label'       => esc_html__( 'Primary Color', 'polite' ),
            'description' => esc_html__( 'Change your whole site color from here. More are available in premium version.', 'polite' ),
            'section'     => 'colors',  
        )
    )
);

