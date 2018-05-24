<?php
$url_list_ips = site_url().'/wp-admin/admin.php?page=page-ip-setting';
$url_list_pages = site_url().'/wp-admin/admin.php?page=page-ip-setting&amp;tab=page-hits-list';
$url_list_setting = site_url().'/wp-admin/admin.php?page=page-ip-setting&amp;tab=auto-page-hit';
?>
<div class="wrap">	
	<h2>Page Hits & IP Address Counter</h2>
	<?php settings_errors(); ?>
	
	<h2 class="nav-tab-wrapper">
		<a href="<?php echo $url_list_ips; ?>" class="nav-tab <?php echo (!isset($_GET['tab']) ) ? 'nav-tab-active': ''; ?>">IP Counter</a>
		
		<a href="<?php echo $url_list_pages; ?>" class="nav-tab <?php echo (isset($_GET['tab']) && $_GET['tab'] == 'page-hits-list'  ) ? 'nav-tab-active': ''; ?>">Page Hits Counter</a>
		
		<a href="<?php echo $url_list_setting; ?>" class="nav-tab <?php echo (isset($_GET['tab']) && $_GET['tab'] == 'auto-page-hit'  ) ? 'nav-tab-active': ''; ?>">Auto Page Hit & Pagination</a>
		
	</h2>
	
	<div class="counter-setting-wrapper">
		<?php
			if (!isset($_GET['tab'])):
				include_once('admin_setting_counter_ip.php');
		
			elseif ( isset($_GET['tab']) && $_GET['tab'] == 'page-hits-list'  ) :
				include_once('admin_setting_counter_page.php');
			
			elseif ( isset($_GET['tab']) && $_GET['tab'] == 'auto-page-hit'  ) :
				include_once('admin_setting_page_auto.php');
			
			endif;
		?>
	
	</div> 
</div>
