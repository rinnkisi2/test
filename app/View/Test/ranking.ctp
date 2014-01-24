この画面で待機していて下さい． 

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
    			<?php echo $value['TestUser']['point']; ?>
	    	</td>
    		<td>
    			<?php echo $value['TestUser']['name']; ?>
	    	</td>
    	</tr>
    <?php endforeach; ?>
</tbody></table>

<a href="test_a">グループAの人はこちら</a>
<br />
<br /><br /><br />
<a href="test_b">グループBの人はこちら</a>