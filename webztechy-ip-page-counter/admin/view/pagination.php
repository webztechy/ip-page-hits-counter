<ul class="counter-list pull-right">
		<?php
			$per_page_inc = 0;
			
			 $tab_page = (isset($_GET['tab'])) ? "&tab=".$_GET['tab'] : '';
			
			for($inc=1;$inc<=$count_ips_hits;$inc++){
			$limit = ($per_page_inc == '0') ? '' : '&pge='.$per_page_inc ;
			$current = ($per_page_inc == '0') ? 'class="current"' : '';
			if ($_GET['pge'] > 0){
				$current = ($_GET['pge'] == $per_page_inc) ? 'class="current"' : '';
			}
		?>
				<li><a href="<?php echo site_url(); ?>/wp-admin/admin.php?page=<?php echo $_GET['page'].$tab_page.$limit; ?>" <?php echo $current; ?>><?php echo $inc; ?></a></li>
		<?php 
				$per_page_inc = $per_page_inc + $per_page;
			}
		?>
	</ul>