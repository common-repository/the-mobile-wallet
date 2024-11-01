<?php 
/*
Plugin Name: The Mobile Wallet
Plugin URI:  https://mobilewallet.cards
Description: The WALLET, a convenient solution for storing digital passes and cards on all your smart devices. The WALLET prioritizes your convenience by offering a hassle-free interface without the pain of a login, password, or registration. Connecting with your favorite brands just got way cooler!
Version: 0.0.1
Author: The Wallet Group Inc
Author URI:  https://mobilewallet.cards/
Text Domain: the-mobile-wallet
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

// If this file is called directly, abort. //
if ( ! defined( 'WPINC' ) ) {die;} // end if

// Let's Initialize Everything
if ( file_exists( plugin_dir_path( __FILE__ ) . 'core-init.php' ) ) {
    require_once( plugin_dir_path( __FILE__ ) . 'core-init.php' );
}

add_action( 'wp_enqueue_scripts', 'tmwcg_register_core_js' );
add_action( 'wp_enqueue_scripts', 'tmwcg_register_core_css' );
add_action('admin_menu', 'tmwcg_menu');
add_action('admin_init', 'tmwcg_dc_register_settings');
add_action('admin_enqueue_scripts', 'tmwcg_dc_admin_scripts');
add_action('wp_footer','tmwcg_frontend_dc_widget_show');
add_action('init','tmwcg_session_set'); 

register_activation_hook(__FILE__, 'tmwcg_dc_install_function');

function tmwcg_dc_install_function()
{
    // Check if account data already exists in options
    $existing_account_data = get_option('tmwcg_wallet_account_data');

    if ($existing_account_data) {
        // Account data already exists, no need to make the API call again
        return;
    }

    tmwcgAccountCreate();
    tmwcgCardCreate();
    tmwcgCardMainSettings();
    tmwcgCardFrontSettings();
    tmwcgCardBacksideSettings();
}
