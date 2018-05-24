<?php
/**
 * @package     Page & IP Counter
 * @Version: 	1.0.0
 * @author      Webztechy <https://www.facebook.com/webztechy>
 * @copyright   Copyright (c) 2016-2017, Webztechy
 * @license     
 */
 
?>

<div class="webztechy-counter-wrap">
	<ul class="webztechy-counter-list">
		<?php
			$count_ip_hit =  $this->webztechy_page_ip_counter->count_ip_hit();
			$count_ip_hit =  str_pad($count_ip_hit, 5, "0", STR_PAD_LEFT);
			for($num=0;$num<=strlen($count_ip_hit)-1;$num++){
		?>
			<li><?php echo $count_ip_hit[$num]; ?></li>
		<?php } ?>
	</ul>
</div>

