<form action="checksave" method="POST" class="create" name="check">
	<span class='label'>
		作成した
		<h3>一問一答形式問題</h3>
	</span><br />
	<span class='red'>問題文:</span>
		<?php echo $data['one']['sentence']; ?><br />
	<span class='red'>正答:</span>
		<?php echo $data['one']['answer']; ?><br />

	<hr>
	<span class='label label-warning'>
		生成された
		<h3>多肢選択形式問題</h3>
		選択肢設定の仕方:<?php echo $data["class"]; ?>
	</span><br />
	<span class='red'>問題文:</span>
		<?php echo $data['multi']['sentence']; ?><br />

	<span class='red'>選択肢1:</span>
		<?php echo $data['multi']['option'][0]; ?><br />
	<span class='red'>選択肢2:</span>
		<?php echo $data['multi']['option'][1]; ?><br />
	<span class='red'>選択肢3:</span>
		<?php echo $data['multi']['option'][2]; ?><br />
	<span class='red'>選択肢4:</span>
		<?php echo $data['multi']['option'][3]; ?><br />

	<input type="hidden" name="one[sentence]" value=<?php echo $data['one']['sentence']; ?>>
	<input type="hidden" name="one[answer]" value=<?php echo $data['one']['answer']; ?>>
	<input type="hidden" name="multi[sentence]" value=<?php echo $data['multi']['sentence']; ?>>
	<input type="hidden" name="multi[option][]" value=<?php echo $data['multi']['option'][0]; ?>>
	<input type="hidden" name="multi[option][]" value=<?php echo $data['multi']['option'][1]; ?>>
	<input type="hidden" name="multi[option][]" value=<?php echo $data['multi']['option'][2]; ?>>
	<input type="hidden" name="multi[option][]" value=<?php echo $data['multi']['option'][3]; ?>>
	<input type="hidden" name="multi[option][]" value=<?php echo $data['multi']['option'][3]; ?>>
	<input type="hidden" name="group_id" value=<?php echo $data['group_id']; ?>>
	<input type="hidden" name="exam_id" value=<?php echo $data['exam_id']; ?>>
	<input type="hidden" name="creator_id" value=<?php echo $data['creator_id']; ?>>	
	<input type="hidden" name="class" value=<?php echo $data["class"]; ?>>
	<input type="hidden" name="settime" value=<?php echo $data["settime"]; ?>>
	<input type="hidden" name="settime2" value=<?php echo $data["settime2"]; ?>>

	<input type="submit" value="確定">
</form>
一問一答: 
<?php echo $data["settime"]; ?>秒
<br />
多肢選択(選択肢): 
<?php echo $data["settime2"]; ?>秒