<?php
/*
Plugin Name: Page Hits & IP Counter
Version: 1.0.0
Plugin URI: https://www.facebook.com/webztechy
Description: Page hits and IP address counter.
Author: Webztechy
Author URI: https://www.facebook.com/webztechy
License: GPLv3.0 or later
*/


if( !class_exists('webztechy_page_ip_counter_admin') ) {
	
	
	class  webztechy_page_ip_counter_admin{
	
		public function __construct() {
			global $wpdb;
			
			add_action( 'admin_menu', array($this,'settings'));
			add_action( 'admin_enqueue_scripts', array($this, 'stylesheets_scripts') );

		}
		
		/**
		 * This method render a submenu on configuration
		 */
		public function settings(){

			add_menu_page('Page Hits & IP Counter Setting', 'Page Hits & IP Counter Setting', 'administrator', 'page-ip-setting', array(&$this,'admin_update_counter_setting'), 'dashicons-visibility');
				
		}

		/** 
		 * Set admin page settings
		 */
		public function admin_update_counter_setting(){
			if(!empty($_POST)){
			
				foreach($_POST as $name=>$value)
				{
					$value = sanitize_text_field($value);
					update_option($name, $value);
				}

				add_settings_error(
					'pageHitIPSettings',
					esc_attr( 'settings_updated' ),
					'Updated settings',
					'updated'
					);
			}

			include('view/admin_setting.php');
			
		}
		
		/**
		 *	Admin Setting Stylesheets and Scripts
		 * @since    1.0.0
		 */
		
		public function stylesheets_scripts() {
			wp_register_style( 'webztechy-counter-admin-style',  plugin_dir_url( __FILE__ ) . 'css/style.css', false, '1.0.0' );
			wp_enqueue_style( 'webztechy-counter-admin-style' );
		
		}
		
		
		
	} // end class webztechy_page_ip_counter_admin
	
}


/**
 * RUN admin setting class and functions
 * @since    1.0.0
 *
 */
	
if( class_exists('webztechy_page_ip_counter_admin') ) {
	$webztechy_page_ip_counter_admin = new webztechy_page_ip_counter_admin();

}




?>
