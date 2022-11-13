<?php
/**
 * Cafe Business Functions
*/

add_action( 'wp_enqueue_scripts', 'cafe_business_enqueue_styles',999 );
function cafe_business_enqueue_styles() {

    $parent_style = 'twentytwentyone-style'; // This is 'twentyseventeen-style' for the Twenty Seventeen theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );

    wp_enqueue_style( 'twentytwentyone-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );

    wp_enqueue_style( "twentytwentyone-child", get_stylesheet_directory_uri() . '/custom.js', array( 'jquery' ), wp_get_theme()->get('Version') );

    // wp_enqueue_style( 'twentytwentyone-child-style',
    //     get_stylesheet_directory_uri() . '/style.css',
    //     array( $parent_style ),
    //     wp_get_theme()->get('Version')
    // );
}
