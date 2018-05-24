<?php 
$webztehy_counter_page_hit_auto = get_option('webztehy_counter_page_hit_auto');
$webztehy_counter_pagination = get_option('webztehy_counter_pagination');

?>

<form id="form-counter-page-auto-hit" method="post">
<table class="form-table">
	<tbody>
		<tr>
			<th scope="row">Auto save page and hit</th>
			<td>
				<select id="webztehy_counter_page_hit_auto" name="webztehy_counter_page_hit_auto" style="width:100px">
					<option value="on" <?php echo ($webztehy_counter_page_hit_auto == 'on' ) ? 'selected' : ''; ?>>On</option>
					<option value="off" <?php echo ($webztehy_counter_page_hit_auto == 'off' ) ? 'selected' : ''; ?>>Off</option>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row">Record per page:</th>
			<td><input type="number" name="webztehy_counter_pagination" id="webztehy_counter_pagination" value="<?php echo $webztehy_counter_pagination; ?>"></td>
		</tr>
		<tr>
			<th scope="row">&nbsp;</th>
			<td><p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Submit"></p></td>
		</tr>
		
	</tbody>
</table>
</form>