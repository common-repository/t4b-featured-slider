<?php
add_action('admin_menu', 't4b_register_menu');
define( 'T4B_DOMAIN', 't4b-featured-slider' );
function t4b_register_menu() {
	add_menu_page('T4B Featured Slider', 'T4B Slider', 'add_users', __FILE__, 't4b_featured_plugin_menu', plugins_url('t4b-featured-slider/images/icon.png'));
	add_submenu_page(__FILE__, __('Usage', T4B_DOMAIN ), __('Usage', T4B_DOMAIN ), 'add_users', __FILE__, 't4b_featured_plugin_menu');
	add_submenu_page(__FILE__, 'Featured', 'Featured', 'add_users', 't4b_featured', 't4b_featured_page');
	add_submenu_page(__FILE__, 'Settings', 'Settings', 'manage_options', 't4b_settings', 't4b_settings_page');
	add_action( 'admin_init', 'register_t4b_settings' );
}
function register_t4b_settings() {
	register_setting( 't4b-settings-group', 't4b_option' );
}
function t4b_featured_plugin_menu() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	include ( T4B_PLUGIN_PATH . 'admin/usage.php' );
}

function t4b_featured_page() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	include ( T4B_PLUGIN_PATH . 'admin/featured.php' );
}
function t4b_settings_page() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	include ( T4B_PLUGIN_PATH . 'admin/settings.php' );
}
include ( T4B_PLUGIN_PATH . 'admin/sidebar.php' );
if((isset($_POST['new_featured_table']) && $_POST['new_featured_table'] == "newfeature") || (isset($_POST['edit_featured_table']) && $_POST['edit_featured_table'] == "editfeature")) {
	if( isset( $_POST['list_id'] ) || isset( $_POST['edit_list_id'] ) ) { t4b_process_featured_post(); }
}
?>