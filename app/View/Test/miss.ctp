<h3>誤回答</h3>
<?php if(!empty($mis)): ?>
	<?php
		foreach ($mis as $key => $value) {
			$wlist[] = $value['TestLog']['choice'];
		}
		$wlist = array_count_values($wlist);
		arsort($wlist);
	?>

	<table class="table"><tbody>
	    <tr>
	    	<th> 誤回答 </th>
	    	<th> 件数 </th>
	    </tr>    	
		<?php foreach ($wlist as $key => $value):?>
		<tr>
    		<td><?php echo $key; ?></td>
    		<td><?php echo $value; ?></td>
    	</tr>
    	<?php endforeach; ?>
	</tbody></table>

<?php else: ?>
	<?php pr($misall); ?>
<?php endif; ?>