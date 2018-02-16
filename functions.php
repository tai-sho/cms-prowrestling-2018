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

function redspice_get_custom_image_url( $id , $size = 'medium', $default_path = null ) {
    $path = esc_url( get_theme_mod( $id ) );
    $image_id = redspice_get_image_id($path);
    $image_thumb = wp_get_attachment_image_src($image_id, redspice_size_detection());
    return empty($image_thumb[0]) ? $default_path : $image_thumb[0];
}
function redspice_get_image_id($image_url) {
    global $wpdb;
    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ));
    return $attachment[0];
}
function redspice_size_detection() {
  $size = 'large'; // tablet
  if(redspice_is_iphone()) {// iphone
    $size = 'large';
  } elseif(redspice_is_mobile()) { // mobile
    $size = 'large';
  } elseif(!wp_is_mobile()) { // PC
    $size = 'original';
  }
  return $size;
}
function redspice_is_iphone() {
    return (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPhone');
}
//スマートフォンを判別
function redspice_is_mobile(){
    $useragents = array(
        'iPhone', // iPhone
        'iPod', // iPod touch
        'Android.*Mobile', // 1.5+ Android *** Only mobile
        'Windows.*Phone', // *** Windows Phone
        'dream', // Pre 1.5 Android
        'CUPCAKE', // 1.5+ Android
        'blackberry9500', // Storm
        'blackberry9530', // Storm
        'blackberry9520', // Storm v2
        'blackberry9550', // Storm v2
        'blackberry9800', // Torch
        'webOS', // Palm Pre Experimental
        'incognito', // Other iPhone browser
        'webmate' // Other iPhone browser

    );
    $pattern = '/'.implode('|', $useragents).'/i';
    return preg_match($pattern, $_SERVER['HTTP_USER_AGENT']);
}
// スタイルの省略可能属性を削除
add_filter('style_loader_tag', function($src) {
    return str_replace("type='text/css'", '', $src);
});
add_action('wp_enqueue_scripts', function() {
    // CSS読み込み
    $assets = [
      'vtngq900000002qh.css', [], 'all and (min-width: 641px)',
      'vtngq900000002qc.css', [], 'screen and (min-width: 0px) and (max-width: 640px)',
      'vtngq900000002q7.css', [], 'print',
      'prospect.css', [], '',
    ];
    foreach($assets as $key => $value) {
        wp_enqueue_style("cmsp-css{$key}",  get_template_directory_uri(). "/css/{$value[0]}", $value[1], $value[2]);
    }
    $assets = [
        'vtngq900000002r1.js', [], null, true,
        'vtngq900000002qw.js', [], null, true,
        'vtngq900000002qr.js', [], null, true,
        'vtngq900000002qm.js', [], null, true,
        'vtngq900000002rb.js', [], null, true,
        'vtngq900000002r6.js', [], null, true,
        'jquery-1.12.4.min.js', [], null, true,
        'vtngq900000002qw.js', [], null, true,
        'prospect.js', [], null, true,
    ];
    // JS読み込み
    foreach($assets as $key => $value) {
        wp_enqueue_script("cmsp-script{$key}", get_template_directory_uri(). '/js/'. $value[0], $value[1], $value[2], $value[3]);
    }
}, 1);

