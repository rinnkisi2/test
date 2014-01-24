おつかれさまでした!
グループBの方は指示に従って下さい．
<table class="table"><tbody>
    <tr>
    	<th> 順位 </th>
    	<th> 得点 </th>
    	<th> ユーザ</th>
    </tr>
    <?php foreach ($rank as $key => $value): ?>
    	<tr>
    		<td>
    			<?php echo ($key+1); ?>
	    	</td>
    		<td>
    			<?php echo $value['TestUser']['point_b']; ?>
	    	</td>
    		<td>
    			<?php echo $value['TestUser']['name']; ?>
	    	</td>
    	</tr>
    <?php endforeach; ?>
</tbody></table>