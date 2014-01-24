<?php //pr($data['count']); exit;?>
<table class="table"><tbody>
    <tr>
    	<th> 得点 </th>
    	<th> ユーザ\問</th>
    	<?php for ($i=1; $i <= $data['count']; $i++): ?>
    		<th> <?php echo $i; ?></th>
    	<?php endfor; ?>
    </tr>
    <?php foreach ($data as $key => $value): ?>
    	<tr>
    		<td>
    			<?php echo $value['point']; ?>
	    	</td>
    		<td>
    			<?php echo $key; ?>
	    	</td>
	    	<?php for($i=0; $i < $data['count']; $i++): ?>
	    		<td>
	    			<?php echo $value[$i]; ?>
	    		</td>
	    	<?php endfor;?>
    	</tr>
    <?php endforeach; ?>
</tbody></table>
<?php
//pr($data); 
 // foreach ($data as $key => $value){
 // 	echo $value['TestLog']['flag'];
 // 	if( ($key+1) % 100 == 0){
 // 		echo "<br />";
 // 	}
 // }
/*
    <?php foreach ($data as $key => $value): ?>
    	<tr>
    		<td>
    			<?php echo $value['TestLog']['flag']; ?>
    		</td>
    		<?php if( ($key+1) % 100 ): ?>
    		</tr>
    		<?php endif; ?>
    		<!-- <td>[<?php echo $value['TestUser']['name']; ?>]</td>
	    	<?php for($i=$key; $i < $key+100; $i++): ?>
		      <td><?php echo $data[$i]['TestLog']['flag']; ?></td>
			<?php endfor; ?> -->
    <?php endforeach; ?>
*/
?>