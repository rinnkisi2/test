<?php if(empty($quiz)): ?> <!-- 入力 -->
	<h3>Excelからコピー＆ペーストして下さい</h3>
	<h5>一問一答形式のみ</h5>
	<?php echo $this->Form->create('AutoQuiz', array('url' => 'draft_import')); ?>
	<?php echo $this->Form->input('contents',array(
		'type' => 'textarea',
		'label' => false));?>
	<?php echo $this->Form->end("取込む"); ?>
<?php else: ?>

	<h3>この内容で大丈夫ですか?</h3>
	<?php //pr($quiz); ?>
	<!-- 問題一覧 -->
	<?php echo $this->Form->create('AutoQuiz',array('url' => 'draft_submit')); ?>
	    <?php for ($i=0; $i < count($quiz); $i++): ?>
	    	<div class="hero-unit"> <!-- ヒーローユニット -->
		    	<p><?php echo ($i+1); ?></p>
		    	<h4><?php echo $quiz[$i]['sentence']; ?></h4>

		    	<?php echo (!empty($quiz[$i]['option1'])) ? $quiz[$i]['option1'] : null ; ?>
		    	<?php echo (!empty($quiz[$i]['option2'])) ? $quiz[$i]['option2'] : null ; ?>
		    	<?php echo (!empty($quiz[$i]['option3'])) ? $quiz[$i]['option3'] : null ; ?>
		    	
		    	<h5>
		    	<?php echo $quiz[$i]['right_answer']; ?>
		    	</h5>
		    	<?php echo $quiz[$i]['discription']; ?>

		    	<?php echo $this->Form->input('sentence][]', array('type' => 'hidden', 'value' => $quiz[$i]['sentence'])); ?>
		    	<?php echo $this->Form->input('right_answer][]', array('type' => 'hidden', 'value' => $quiz[$i]['right_answer'])); ?>
		    	<?php //echo $this->Form->input('option1][]', array('type' => 'hidden', 'value' => $quiz[$i]['option1'])); ?>
		    	<?php //echo $this->Form->input('option2][]', array('type' => 'hidden', 'value' => $quiz[$i]['option2'])); ?>
		    	<?php //echo $this->Form->input('option3][]', array('type' => 'hidden', 'value' => $quiz[$i]['option3'])); ?>
		    	<?php echo $this->Form->input('discription][]', array('type' => 'hidden', 'value' => $quiz[$i]['discription'])); ?>

		    	<?php echo $this->Form->input('flag', array('type' => 'hidden', 'value' => "submit")); ?>
	    	</div>
	    <?php endfor; ?>
	<?php echo $this->Form->input('確定',array('type' => "submit", "class"=>"btn btn-primary", "label" => false)); ?>

<?php endif; ?>


<style>
textarea{
	width: 900px;
	height: 400px;
}
</style>
