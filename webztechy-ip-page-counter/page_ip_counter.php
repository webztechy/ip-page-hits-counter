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


require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

/**
* @class   webztechy_page_ip_counter
* @version	1.0.0
*/
 
if( !class_exists('webztechy_page_ip_counter') ) {
	
	/**
	 * Call IP Couter Widget
	 */
	require( plugin_dir_path( __FILE__ ) .'widget_ip_counter.php');
	
	/**
	 * Call IP Couter Widget
	 */
	require( plugin_dir_path( __FILE__ ) .'widget_page_counter.php');
	
	/**
	 * Call ADMIN Setting
	 */
	require( plugin_dir_path( __FILE__ ) .'admin/page_ip_counter_admin.php');
	
	
	
	class  webztechy_page_ip_counter{
		
		var $table_ips;
		var $table_hits;
		private	$wpdb;
		
		
		 /**
		  * Initialize the class and set its properties.
		  * @since    1.0.0
		  * @param      string    $table_ips       Table for IP address.
		  * @param      string    $table_hits      Table for {set page name or URL address by default}.
		  */
		 
		  public function __construct() {
			global $wpdb;

			$this->wpdb = $wpdb;
			$this->table_ips = $this->wpdb->prefix . "webztechy_ips";
			$this->table_hits = $this->wpdb->prefix . "webztechy_hits";
	
		  }
		
		/**
		 * Creating Database Tables, and add setting {webztehy_counter_page_hit_auto} = {on/off}
		 * @since    1.0.0
		 *
		 */
		
		 public function create_tables() {
			
		   $sql_info = "CREATE TABLE IF NOT EXISTS
						".$this->table_ips." (id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id), ip_address VARCHAR(30), user_agent VARCHAR(150), datetime VARCHAR(25));";
		   $sql_hits = "CREATE TABLE IF NOT EXISTS
						".$this->table_hits." (page char(100),PRIMARY KEY(page),count int(15));";
						
		   $table_ips = $this->table_ips;
		   $table_hits = $this->table_hits;

			if($this->wpdb->get_var("SHOW TABLES LIKE '$table_ips'") != $table_ips) {
				 dbDelta( $sql_info );
			}
			
			if($this->wpdb->get_var("SHOW TABLES LIKE '$table_hits'") != $table_hits) {
				 dbDelta( $sql_hits );
			}
			
			add_option( 'webztehy_counter_page_hit_auto', 'off');
			add_option( 'webztehy_counter_pagination', '5');
			
		 }
		
		/**
		 * Hit Counter {given page name}
		 * Automatically save post {post-title} if empty
		 *
		 * @since    1.0.0
		 * @page_name  string	Set page name
		 *
		 */
		
		public function hit_counter($page_name = null){

			
			if ( empty($page_name) ){
				$post_id = get_the_ID();
				$page_name = get_the_title();
			}
			
			if ( !empty($page_name) ){
				$table_hits = $this->table_hits;
				$count_page = $this->wpdb->get_var( "SELECT COUNT(*) FROM $table_hits WHERE page = '$page_name'" );
				
				if($count_page > 0){
					$this->wpdb->query(" UPDATE $table_hits SET count = count+1 WHERE page = '$page_name' ");
				}else{
					$this->wpdb->insert( $table_hits, array( 'page' => $page_name, 'count' => 1 ), array('%s', '%d' ) );
				}
			}
		}
		
		/**
		 * Creating tables 
		 * Automatically save IP address
		 *
		 * @since    1.0.0
		 * @param    string    $ip          Server remoter address.
		 * @param    string    $agent       Server user agent.
		 * @param    string    $datetime    Current date and time.
		 */
		
		public function save_ip(){
			$ip = $_SERVER["REMOTE_ADDR"]; 
			$agent = $_SERVER["HTTP_USER_AGENT"];
			$datetime = date('Y-m-d H:i:s') ;

			$table_ips = $this->table_ips;
			
			$count_ip = $this->wpdb->get_var( "SELECT COUNT(*) FROM $table_ips WHERE ip_address = '$ip' " );
			
			if($count_ip == 0){
				$this->wpdb->insert( $table_ips, array( 'ip_address' => $ip, 'user_agent' => $agent, 'datetime' => $datetime ), array('%s', '%s', '%s' ) );
			}
		}
		
		/**
		 * Page Hit Counter {by page name}
		 * @since    1.0.0
		 *
		 */
		public function count_page_hit($page_name = null){
			$table_hits = $this->table_hits;
			
			$webztehy_counter_page_hit_auto = get_option( 'webztehy_counter_page_hit_auto');
			if ( $webztehy_counter_page_hit_auto == 'on'){
				if ( empty($page_name) ){
					$post_id = get_the_ID();
					$page_name = get_the_title();
				}
			}
			
			$count_hits = $this->wpdb->get_row( "SELECT * FROM $table_hits WHERE page = '$page_name' ", ARRAY_A );
			
			return $count_hits['count'];
		}
		
		/**
		 * Unique IP Address Counter
		 * @since    1.0.0
		 *
		 */
		public function count_ip_hit(){
			$table_ips = $this->table_ips;
			
			$count_ip_hits = $this->wpdb->get_var( "SELECT COUNT(*) FROM $table_ips " );
			
			return $count_ip_hits;
		}
		
		/**
		 * RUN Counter Shortcode and Parameters
		 * @shortcode  default [webztechy_counter]
		 *
		 * @since    1.0.0
		 *
		 */
		public function webztechy_counter_func( $atts, $content=""  ) {
			 extract( shortcode_atts( array(
				  'page_name' => '',
				  'save_ip' => 1,
				  
				  'show_ip_counter' => 0,
				  'show_page_counter' => 0 
			 ), $atts ) );
			
			// Save page name
			 $this->hit_counter($page_name); 
			 
			 // Save IP address
			 if ( $save_ip == '1' ){ $this->save_ip(); } 
			 
			 // Show IP total
			 if ( $show_ip_counter == '1' ){ return $this->count_ip_hit(); } 
			 
			 // Show Current Page total
			 if ( $show_page_counter == '1' &&  empty($page_name) ){ return $this->count_page_hit(); }
			 
			  // Show Page Name total
			 if ( $show_page_counter == '1' && !empty($page_name) ){ return $this->count_page_hit($page_name); }
			 
		}
		
		
		/**
		 *	Widgets Stylesheets and Scripts
		 * @since    1.0.0
		 */
		
		public function stylesheets_scripts() {
			wp_enqueue_style( 'webztechy-counter-style', plugin_dir_url( __FILE__ ). 'assets/css/style.css' );
		
		}
		
		/**
		 * PUtT short code in all opages
		 * @since    1.0.0
		 *
		 */
		 
		public function put_shotcode_to_post( $content ) {
			global $post;
		  
			  if( ! $post instanceof WP_Post ) return $content;

			  switch( $post->post_type ) {
			  
				case 'page':
				  return $content . '[webztechy_counter] ';

				default:
				  return $content;
			  }
		  
		}

	} // end class webztechy_page_ip_counter
	
}


/**
 * RUN main class and functions
 * @since    1.0.0
 *
 *@add_filter	the_content	Run shortcode to all pages
 *@webztehy_counter_page_hit_auto	string		page auto save hits setting {on/off}
 */
	
if( class_exists('webztechy_page_ip_counter') ) {
	$webztechy_page_ip_counter = new webztechy_page_ip_counter();
	
	$webztechy_page_ip_counter->create_tables();
	
	add_shortcode( 'webztechy_counter', array( $webztechy_page_ip_counter, 'webztechy_counter_func' ) );
	
	$webztehy_counter_page_hit_auto = get_option( 'webztehy_counter_page_hit_auto');
	if ( $webztehy_counter_page_hit_auto == 'on'){
		add_filter( 'the_content', array($webztechy_page_ip_counter, 'put_shotcode_to_post')  );
	}

}




?>
