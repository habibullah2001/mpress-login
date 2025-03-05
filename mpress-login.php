<?php

/**
 * Plugin Name: MpressLogin
 * Plugin URI: https://bargraphic.com/mpress-login/
 * Description: A plugin to customize the WordPress login page and admin panel.
 * Author: Your Name
 * Version: 1.0.0
 * Text Domain: mpress-login
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 */


defined('ABSPATH') || exit;


$plugin_data = get_file_data(__FILE__, array('Version' => 'Version'), false);
$plugin_data_name = get_file_data(__FILE__, array('Plugin Name' => 'Plugin Name'), false);
$plugin_version = $plugin_data['Version'];
$plugin_name = $plugin_data_name['Plugin Name'];
define('MPRESS_NAME', $plugin_name);
define('MPRESS_VERSION', $plugin_version);
define('MPRESS_PATH' , WP_CONTENT_DIR.'/plugins/mpress-login');
define('MPRESS_URL' , plugin_dir_url( __DIR__ ).'mpress-login');
define('MPRESS_INC' , MPRESS_PATH.'/inc');
define('MPRESS_LIB' , MPRESS_PATH.'/lib');
define('MPRESS_ASSETS' , MPRESS_URL.'/inc/assets');
define('MPRESS_TEXTDOMAIN' , 'mpress-login');




// Load required files
require_once MPRESS_LIB . '/codestar-framework/codestar-framework.php';
require_once MPRESS_INC . '/functions.php';
require_once MPRESS_INC . '/settings.php';

/////////////////////////////////////////////////////////////////////////////////////////////////


// function mpresslogin_load_textdomain() {
//     load_plugin_textdomain( 'mpress-login', false, basename( dirname( __FILE__ ) ) . '/languages/' );
// }
// add_action( 'init', 'mpresslogin_load_textdomain' );



// function mpresslogin_font_dashboard() {
//     wp_enqueue_style('general_admin_panel_font', MPRESS_ASSETS . '/css/admin-font-general.css');
//     wp_enqueue_style('custom_admin_panel_font', MPRESS_ASSETS . '/css/font-shabnam.css');
// }



// function mpresslogin_adminbar_css() {
//     if (strpos(implode(' ', get_body_class()), 'admin-bar') !== false) {
//         wp_enqueue_style('custom_admin_panel_font', MPRESS_ASSETS . '/css/font-shabnam.css', array('admin-bar'));
//     }
// }

function mpresslogin_style_dashboard() {
    wp_enqueue_style('custom_admin_panel_style', MPRESS_ASSETS . '/css/style1.css');
}

function mpresslogin_style_dashboard_head() {
    $admin_style1_main_color = mpress_option('admin_color');
    ?>
    <style>
        :root  {
            --var-mpress-login-color-main: <?php echo $admin_style1_main_color; ?> !important;
        }
    </style>
    <?php
}





function mpresslogin_style_login() {
    if (mpress_option('login_style') == '0') { ?>
        <style>
            body.login #backtoblog {
                display: none !important;
            }
        </style>
    <?php }
    $logo_option_mpresslogin = mpress_option('admin_logo');
    if (!empty($logo_option_mpresslogin) && is_array($logo_option_mpresslogin) && !empty($logo_option_mpresslogin['url'])) { ?>
        <style>
            #login h1 a, .login h1 a {
                background-image:  url(<?php echo esc_url($logo_option_mpresslogin['url']); ?>) !important;
                background-repeat: no-repeat;
                background-size: contain;
                width: 100%;
                box-shadow: none !important;
            }
        </style>
    <?php } else { ?>
        <style>
            #login > h1 {
                display: none !important;
            }
        </style>
    <?php }
    $disable_signup_lostpassword = mpress_option('disable_signup_lostpassword') !== '0' ? '1' : '0';
    $disable_backtoblog = mpress_option('disable_backtoblog','1');
    $background_login_picture = mpress_option('admin_bg');
    wp_enqueue_style('login-page-general-styles', MPRESS_ASSETS . '/css/login-page-general.css');
    ?>
    <style>
        #login {
            margin: auto !important;
        }
    </style>
    <?php if (!$disable_signup_lostpassword) { ?>
        <style>
            body.login #nav {
                display: none !important;
            }
        </style>
    <?php } if (!$disable_backtoblog) { ?>
        <style>
            .login #backtoblog {
                display: none !important;
            }
        </style>
    <?php }
    if (!empty($login_other_color)) { ?>
        <style>
            .wp-core-ui .button-secondary .dashicons:before,
            #wp-submit:hover, .wp-core-ui .button-primary:focus, .wp-core-ui .button-primary.active,
            .wp-core-ui .button-primary.active:focus, .wp-core-ui .button-primary:active {
                color: <?php echo $login_other_color;?> !important;
                background: white !important;
            }
            .wp-core-ui .button-primary {
                background: <?php echo $login_other_color;?> !important;
            }
            .login #login_error, .login .message, .login .success {
                border-color: <?php echo $login_other_color;?> !important;
            }
            #user_login:focus, #user_email:focus, #user_pass:focus, .input:focus, .password-input:focus, .login input[type="text"]:focus, input:focus {
                border: 2px solid <?php echo $login_other_color;?> !important;
            }
        </style>
    <?php } if (!empty($login_box_bg_color)) { ?>


        <style>
            #login, #loginform {
                background: <?php echo $login_box_bg_color;?> !important;
            }
        </style>


    <?php } if (!empty($login_text_color)) { ?>


        <style>
            .message-wp-login-mpresslogin, .login form, .login #backtoblog, .login #nav, .login #login_error, .login .message, .login .success, #nav a, #backtoblog a {
                color: <?php echo $login_text_color;?> !important;
            }
        </style>

    <?php } if (!empty($background_login_picture) && is_array($background_login_picture) && !empty($background_login_picture['url']) ) { ?>
        <style>
            body.login {
                background-image: url(<?php echo esc_url($background_login_picture['url']); ?>) !important;
            }
        </style>
    <?php } 

    $wp_language_switcher = mpress_option('disable_wp_language_switcher', 'off') ?>
<?php if ($wp_language_switcher == 'off') {
    
    echo 'success'; ?>
    <style>
            body.login .language-switcher{
                display: none !important;
            }
        </style>
<?php } 

}

function MPRESS_login_headerurl() {
    return home_url();
}

function MPRESS_login_headertext() {
    return '';
}

function MPRESS_login_body_class($classes) {
    $classes[] = 'mpresslogin-login-page-plugin';
    return $classes;
}

function MPRESS_login_display_language_dropdown() {
    if (mpress_option('disable_wp_language_switcher') !== '0') {
        return true;
    } else {
        return false;
    }
}

function MPRESS_enable_login_autofocus() {
    return false;
}

// if (mpress_option('persian_font') !== false) {
//     add_action('wp_enqueue_scripts', 'mpresslogin_adminbar_css');
//     add_action('admin_enqueue_scripts', 'mpresslogin_font_dashboard');
//     add_action('login_enqueue_scripts', 'mpresslogin_font_dashboard');
// }
$admin_style = mpress_option('admin_style', true);


if ($admin_style !== '0') {
    add_action('admin_enqueue_scripts', 'mpresslogin_style_dashboard');
    add_action('admin_head', 'mpresslogin_style_dashboard_head');
}

if (mpress_option('login_style') !== '0') {
    add_action('login_enqueue_scripts', 'mpresslogin_style_login');
    add_action('login_head', 'mpresslogin_style_dashboard_head');
    add_filter('login_headerurl', 'MPRESS_login_headerurl');
    add_filter('login_headertext', 'MPRESS_login_headertext');
    add_filter('login_body_class', 'MPRESS_login_body_class');
    add_filter('login_display_language_dropdown', 'MPRESS_login_display_language_dropdown');
    add_filter('enable_login_autofocus', 'MPRESS_enable_login_autofocus');
}