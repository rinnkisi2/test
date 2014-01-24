<?php echo $this->Form->create('AutoQuiz', array('url' => 'search')); ?>
<?php echo $this->Form->input('keyword',array(
	'type' => 'text',
	'label' => false));?>が含まれる問題を
<?php echo $this->Form->end("検索する"); ?>

<div id="search">
<?php if(!empty($quiz)): ?>
	<?php foreach ($quiz as $key => $value): ?>
	<div class="hero-unit">
		<h4><?php echo $value['Problem']['sentence']; ?></h4>
		<p>
		1.<?php echo $value['Problem']['choice1']; ?>
		2.<?php echo $value['Problem']['choice2']; ?>
		3.<?php echo $value['Problem']['choice3']; ?>
		4.<?php echo $value['Problem']['choice4']; ?>
		</p>
	</div>
	<?php endforeach; ?>
	<?php //pr($quiz); ?>
<?php endif; ?>
</div>

<script src="http://johannburkard.de/resources/Johann/jquery.highlight-4.closure.js"></script>
<script>
$(function(){
	javascript:void($('#search')
		.removeHighlight()
		.highlight($('input:text').val()));
});
</script>
<style>
	.highlight{
		background-color: yellow
	}
	#search{
	}
</style>