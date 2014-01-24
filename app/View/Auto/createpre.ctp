<div id="createpre">
	<?php if(empty($quiz)): ?><!-- 問題登録 -->
		<h6>一度に10問迄作成できます．</h6>
		<?php echo $this->Form->create('AutoQuiz',array('url' => 'createpre')); ?>
		<?php for ($i=0; $i < 10; $i++): ?>
			<p><?php echo $i+1; ?>
			<?php echo $this->Form->input("sentence][]", array('type' => 'textarea','div'=> false,
			'label' => false,  'placeholder' => "問題文", "cols" => 100, "rows" => 2, "wrap" => "soft"
			/*,"name" => "data[AutoQuiz][sentence][]"*/));
			?>
			<?php echo $this->Form->input("right_answer][]", array('type' => 'text', 'div'=> false, 
			'label' => false, 'placeholder' => "答え"/*,"name" => "data[AutoQuiz][right_answer][]"*/)); ?>
			</p>
		<?php endfor; ?>
		<?php echo $this->Form->input('作問',array('type' => "submit", "class"=>"btn btn-primary", "label" => false)); ?>

	<?php else: ?><!-- 問題登録結果のリスト -->
		<?php if(!empty($quiz)): ?>	
			<!-- 問題一覧 -->
			<?php echo $this->Form->create('AutoQuiz',array('url' => 'createpre')); ?>
			<table><tbody>
			    <tr>
			    	<th></th>
					<th>No.</th>
					<th>設問</th>
					<th>正答</th>
		    	</tr>
		    	
			    <?php for ($i=0; $i < count($quiz['AutoQuiz']['sentence']); $i++): ?>
			    	<tr>
			    	<td></td>
			    	<td><?php echo ($i+1); ?></td>
			    	<td><?php echo $quiz['AutoQuiz']['sentence'][$i]; ?></td>
			    	<td><?php echo $quiz['AutoQuiz']['right_answer'][$i]; ?></td>
			    	</tr>
			    	<?php echo $this->Form->input('sentence][]', array('type' => 'hidden', 'value' => $quiz['AutoQuiz']['sentence'][$i])); ?>
			    	<?php echo $this->Form->input('right_answer][]', array('type' => 'hidden', 'value' => $quiz['AutoQuiz']['right_answer'][$i])); ?>
			    	<?php echo $this->Form->input('flag', array('type' => 'hidden', 'value' => "submit")); ?>
			    <?php endfor; ?>
			</tbody></table>
			<?php echo $this->Form->input('確定',array('type' => "submit", "class"=>"btn btn-primary", "label" => false)); ?>

		<?php endif; ?>
	<?php endif; ?>

</div>
<style>
	#createpre{
		height: 600px;
		overflow:scroll;
	}
	textarea, input{
		width: 300px;
	}
</style>