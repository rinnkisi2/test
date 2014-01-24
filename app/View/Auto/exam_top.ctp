<?php echo $this->Session->flash('auth'); ?>
<div id="exam_list">
	<?php if(!empty($quiz)): ?>	
	<?php //pr($quiz); ?>
		<!-- 問題一覧 -->
		<table class="table"><tbody>
		    <tr>
		      <th>No.</th>
		      <th>設問</th>
		      <th>選択肢①</th>
		      <th>選択肢②</th>
		      <th>選択肢③</th>
		      <th>選択肢④／正答</th>
		      <th>解説</th>
		      <th>作成者</th>
		    </tr>
		    <?php foreach ($quiz as $key => $value): ?>
			    <tr>
			      <td><?php echo ($key+1); ?></td>
			      <td><?php echo $value['AutoQuiz']['sentence']; ?></td>
			      <td><?php echo $value['AutoQuiz']['option1']; ?></td>
			      <td><?php echo $value['AutoQuiz']['option2']; ?></td>
			      <td><?php echo $value['AutoQuiz']['option3']; ?></td>
			      <td><?php echo $value['AutoQuiz']['right_answer']; ?></td>
			      <td><?php echo $value['AutoQuiz']['description']; ?></td>
			      <td><?php echo $value['AutoUser']['name']; ?></td>	      
			    </tr>
		    <?php endforeach; ?>
		</tbody></table>
	<?php else: ?>
		問題が未登録です泣
	<?php endif; ?>
</div>