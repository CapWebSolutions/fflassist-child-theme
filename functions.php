<?php
/*
 * This is the child theme for Kadence theme, generated with Generate Child Theme plugin by catchthemes.
 *
 * (Please see https://developer.wordpress.org/themes/advanced-topics/child-themes/#how-to-create-a-child-theme)
 */
add_action( 'wp_enqueue_scripts', 'fflassist_child_theme_enqueue_styles' );
function fflassist_child_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
    );
}
/*
 * Your code goes below
 */
function custom_nav_menu_items($items, $args) {
    if ($args->theme_location == 'primary') {
        if (is_user_logged_in()) {
            $loginoutlink = '<li><a class="loginout" href="' . wp_logout_url() . '">Log Out</a></li>';
        } else {
            $loginoutlink = '<li><a class="loginout" href="' . wp_login_url() . '">Log In</a></li>';
        }
        $items .= $loginoutlink;
    }
    error_log( print_r( (object)
    [
        'file' => __FILE__,
        'method' => __METHOD__,
        'line' => __LINE__,
        'dump' => [
            $items,
        ],
    ], true ) );
    return $items;
}
// add_filter('wp_nav_menu_items', 'custom_nav_menu_items', 10, 2);
