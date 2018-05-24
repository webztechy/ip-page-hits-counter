<?php
global $wpdb;
$webztechy_page_ip_counter = new webztechy_page_ip_counter();
			
if ( isset($_GET['del']) && $_GET['del'] != ''){
	$wpdb->delete( $webztechy_page_ip_counter->table_ips , array( 'id' => $_GET['del'] ), array( '%d' ) );
}
?>

<div id="post-body-content">
	<table class="widefat">
	<thead>
		<tr>
			<th>#</th>
			<th>IP Address</th>
			<th>User Agent</th>
			<th>Date & Time</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php

			$limit_page = (!isset($_GET['pge'])) ? 0 : $_GET['pge'];
			$per_page = get_option('webztehy_counter_pagination');
			
			$qry = "SELECT * FROM ".$webztechy_page_ip_counter->table_ips."  ORDER BY id ASC LIMIT ".$limit_page.", ".$per_page;
			$result_ips = $wpdb->get_results($qry, ARRAY_A);
			
			foreach($result_ips as $row ){
			$limit_page++;
		?>
		<tr>
			<td><?php echo $limit_page; //$row['id']; ?></td>
			<td><?php echo $row['ip_address']; ?></td>
			<td><?php echo $row['user_agent']; ?></td>
			<td><?php echo $row['datetime']; ?></td>
			<td>
				<a href="<?php echo $url_list_ips; ?>&del=<?php echo $row['id']; ?>" class="dashicons-before dashicons-trash" title="Delete">&nbsp;</a>
			</td>
		</tr>
		
		<?php } ?>
	</tbody>
	</table>
	
	<?php
		$count_ips_hits = $wpdb->get_var( "SELECT COUNT(*) FROM ".$webztechy_page_ip_counter->table_ips );
		$count_ips_hits = ceil($count_ips_hits / $per_page);
		include('pagination.php');
	?>

</div>