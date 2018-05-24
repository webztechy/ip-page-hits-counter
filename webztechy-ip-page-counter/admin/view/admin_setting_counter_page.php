<?php
global $wpdb;
$webztechy_page_ip_counter = new webztechy_page_ip_counter();

if ( isset($_GET['pg']) && $_GET['pg'] != ''){
	$wpdb->delete( $webztechy_page_ip_counter->table_hits , array( 'page' => $_GET['pg'] ), array( '%s' ) );
}
if ( isset($_GET['rpg']) && $_GET['rpg'] != ''){
	$wpdb->update( $webztechy_page_ip_counter->table_hits , 
					array( 'count' => 0 ),
					array( 'page' => $_GET['rpg'] ),
					
					array( '%d'),
					array( '%s' )
				);
}	
?>
<div id="post-body-content">
	<table class="widefat">
	<thead>
		<tr>
			<th>#</th>
			<th>Page Name</th>
			<th>Hits</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$limit_page = (!isset($_GET['pge'])) ? 0 : $_GET['pge'];
			$per_page = get_option('webztehy_counter_pagination');
			
			$qry = "SELECT * FROM ".$webztechy_page_ip_counter->table_hits."  ORDER BY count DESC LIMIT ".$limit_page.", ".$per_page;
			$result_hits = $wpdb->get_results($qry, ARRAY_A);
			
			foreach($result_hits as $row ){
			$limit_page++;
		?>
		<tr>
			<td><?php echo $limit_page; ?></td>
			<td><?php echo $row['page']; ?></td>
			<td><?php echo $row['count']; ?></td>
			<td>
				<a href="<?php echo $url_list_pages; ?>&pg=<?php echo $row['page']; ?>" class="dashicons-before dashicons-trash" title="Delete">&nbsp;</a>
				<a href="<?php echo $url_list_pages; ?>&rpg=<?php echo $row['page']; ?>" class="dashicons-before dashicons-image-rotate" title="Reset">&nbsp;</a>
			</td>
		</tr>
		
		<?php } ?>
	</tbody>
	</table>
	
	<?php
		$count_ips_hits = $wpdb->get_var( "SELECT COUNT(*) FROM ".$webztechy_page_ip_counter->table_hits );
		$count_ips_hits = ceil($count_ips_hits / $per_page);
		include('pagination.php');
	?>
	
</div>
