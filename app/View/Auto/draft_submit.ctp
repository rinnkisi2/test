<div id="createpre">
<?php if(!empty($quiz)): ?>
	<h3>この内容で大丈夫ですか？</h3>
	<!-- 問題一覧 -->
	<?php echo $this->Form->create('AutoQuiz',array('url' => 'draft_submit')); ?>
	    <?php for ($i=0; $i < count($quiz['AutoQuiz']['sentence']); $i++): ?>
	    	<div class="hero-unit"> <!-- ヒーローユニット -->
		    	<p><?php echo ($i+1); ?></p>
		    	<h4><?php echo $quiz['AutoQuiz']['sentence'][$i]; ?></h4>
		    	<?php echo (!empty($quiz['AutoQuiz']['option1'][$i])) ? $quiz['AutoQuiz']['option1'][$i] : null ; ?>
		    	<?php echo (!empty($quiz['AutoQuiz']['option2'][$i])) ? $quiz['AutoQuiz']['option1'][$i] : null ; ?>
		    	<?php echo (!empty($quiz['AutoQuiz']['option3'][$i])) ? $quiz['AutoQuiz']['option1'][$i] : null ; ?>
		    	<?php echo $quiz['AutoQuiz']['right_answer'][$i]; ?>
		    	<?php echo $this->Form->input('sentence][]', array('type' => 'hidden', 'value' => $quiz['AutoQuiz']['sentence'][$i])); ?>
		    	<?php echo $this->Form->input('right_answer][]', array('type' => 'hidden', 'value' => $quiz['AutoQuiz']['right_answer'][$i])); ?>
		    	<?php echo $this->Form->input('flag', array('type' => 'hidden', 'value' => "submit")); ?>
	    	</div>
	    <?php endfor; ?>
	<?php echo $this->Form->input('確定',array('type' => "submit", "class"=>"btn btn-primary", "label" => false)); ?>
<?php endif; ?>
</div>