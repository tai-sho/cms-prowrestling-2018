<?php
// テーマカスタマイザー
const REDSPICE_IMAGE_SECTION = 'redspice_image_section';
const REDSPICE_MAIN_VISUAL_URL = 'redspice_main_visual_url';
const REDSPICE_MAIN_VISUAL_SP_URL = 'redspice_main_visual_sp_url';
const REDSPICE_CAMPUS_LIFE_VISUAL_URL = 'redspice_campus_life_visual_url';
define( 'REDSPICE_CAMPUS_LIFE_VISUAL_TYPE_LIST' , range( 1 , 9 ) );
add_action( 'customize_register', function( $wp_customize ) {
    $wp_customize->add_section( REDSPICE_IMAGE_SECTION , array(
        'title' => '受験生ページ画像設定',
        'priority' => 30,
        'description' => '画像アップロード',
    ) );

    $wp_customize->add_setting( REDSPICE_MAIN_VISUAL_URL );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, REDSPICE_MAIN_VISUAL_URL , array(
        'label' => 'メインビジュアル',
        'section' => REDSPICE_IMAGE_SECTION,
        'settings' => REDSPICE_MAIN_VISUAL_URL,
        'description' => 'メインビジュアル'
    ) ) );
    $wp_customize->add_setting( REDSPICE_MAIN_VISUAL_SP_URL );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, REDSPICE_MAIN_VISUAL_SP_URL , array(
        'label' => 'メインビジュアル(SP)',
        'section' => REDSPICE_IMAGE_SECTION,
        'settings' => REDSPICE_MAIN_VISUAL_SP_URL,
        'description' => 'メインビジュアル(SP)'
    ) ) );
    foreach( REDSPICE_CAMPUS_LIFE_VISUAL_TYPE_LIST as $value ) {
        $type = REDSPICE_CAMPUS_LIFE_VISUAL_URL . '_' . $value;
        $wp_customize->add_setting( $type );
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $type, array(
            'label' => 'CAMPUS LIFE('. $value. ')',
            'section' => REDSPICE_IMAGE_SECTION,
            'settings' => $type,
            'description' => 'CAMPUS LIFEのセクションにて、一定時間ごとに切り替わる画像です。'
        ) ) );
    }
} );

function redspice_get_custom_image_url( $id , $default_path = null ) {
    $path = esc_url( get_theme_mod( $id ) );
    return empty($path) ? $default_path : $path;
}
