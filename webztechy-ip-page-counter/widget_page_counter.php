<?php
/**
 * @package     Page & IP Counter
 * @Version: 	1.0.0
 * @author      Webztechy <https://www.facebook.com/webztechy>
 * @copyright   Copyright (c) 2016-2017, Webztechy
 * @license     
 */


/**
 * Adds Webztechy_Counter_Widget widget.
 */
class Webztechy_Page_Counter_Widget extends WP_Widget {
	
	
	var $webztechy_page_ip_counter;
	
	/**
	 * Register widget with WordPress.
	 *
	 */
	function __construct() {
		parent::__construct(
			'webztechy_page_counter_Widget', // Base ID
			__( 'Webztechy: Page Counter ', 'webztechy-counter' ), // Name
			array( 'description' => __( 'A webztechy Page counter widget', 'webztechy-counter' ), ) // Args
		);
		
		/**
		 * Call Plugin main class
		 */
		$this->webztechy_page_ip_counter = new webztechy_page_ip_counter();
		
		add_action( 'wp_enqueue_scripts', array( $this->webztechy_page_ip_counter, 'stylesheets_scripts' ) );
		
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		echo $args['before_widget'];
		
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		
		if ( ! empty( $instance['page_selection'] ) ) {
			require( plugin_dir_path( __FILE__ ) .'view/widget_page.php');
		}
		
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		global $wpdb;
		
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Webztechy Page Counter', 'webztechy-counter' );
		$page_selection = ! empty( $instance['page_selection'] ) ? $instance['page_selection'] : 0 ;
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'page_selection' ); ?>"><?php _e( 'Select Page:' ); ?></label> 
			<select class="widefat" id="<?php echo $this->get_field_id( 'page_selection' ); ?>" name="<?php echo $this->get_field_name( 'page_selection' ); ?>">
				<?php 
				$webztehy_counter_page_hit_auto = get_option( 'webztehy_counter_page_hit_auto');
				if ( $webztehy_counter_page_hit_auto == 'on'){
				?>
					<option value="auto-page" <?php echo (esc_attr( $page_selection ) ==  '0' ) ? 'selected' : '' ; ?>>Auto Page Counter</option>
				<?php } ?>
				<?php
					$table_hits = $this->webztechy_page_ip_counter->table_hits;
					$qry = "SELECT * FROM `".$table_hits."` ORDER BY `page` ASC ";
					$pages = $wpdb->get_results($qry, ARRAY_A);
					foreach($pages as $page){
						$is_selected = (esc_attr( $page_selection ) ==  $page['page'] ) ? 'selected' : '' ;
						echo '<option value="'.$page['page'].'" '.$is_selected.'>'.$page['page'].'</option>';
					}
				?>
			</select>
		</p>
		
	
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['page_selection'] = ( ! empty( $new_instance['page_selection'] ) ) ? strip_tags( $new_instance['page_selection'] ) : '';

		return $instance;
	}
	
	
} // class Webztechy_Page_Counter_Widget


// register Webztechy_Page_Counter_Widget widget
function register_webztechy_page_counter_widget() {
    register_widget( 'Webztechy_Page_Counter_Widget' );
}
add_action( 'widgets_init', 'register_webztechy_page_counter_widget' );

?>