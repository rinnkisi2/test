<div id="exam_list">
<?php if(!empty($quiz)): ?>
	<?php echo $this->Form->create('AutoQuiz',array('url' => 'create')); ?>
	<!-- 問題一覧 -->
	<table>
	  <tbody>
	    <tr>
	      <th></th>
	      <th>No.</th>
	      <th>設問</th>
	      <th>誤答選択肢</th>
	      <th>誤答選択肢</th>
	      <th>誤答選択肢</th>
	      <th>正解選択肢</th>
	      <th>解説</th>
	    </tr>
	    <?php foreach ($quiz as $key => $value): ?>
		    <tr>
		      <td>
		      	<?php echo $this->Form->input('creator_id', array('type' => 'hidden', 'value' => $user['id'])); ?>
		      	<input type="checkbox">
		      </td>
		      <td>
		      	<?php echo $value['AutoQuiz']['id']; ?>
		      </td>
		      <td>
		      	<?php echo $value['AutoQuiz']['sentence']; ?>
		      </td>
		      <td>
		      	<?php echo $value['AutoQuiz']['option1']; ?>
		      </td>
		      <td>
		      	<?php echo $value['AutoQuiz']['option2']; ?>
		      </td>
		      <td>
		      	<?php echo $value['AutoQuiz']['option3']; ?>
		      </td>
		      <td>
		      	<?php echo $value['AutoQuiz']['right_answer']; ?>
		      </td>
		      <td>
		      	<?php echo $value['AutoQuiz']['description']; ?>
		      </td>
		    </tr>
	    <?php endforeach; ?>
	  </tbody>
	</table>
	<?php echo $this->Form->end('出題'); ?>
<?php else: ?>
	問題が未登録です泣
<?php endif; ?>
</div>