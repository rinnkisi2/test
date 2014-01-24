<!-- 通常編集 -->
<?php echo $this->Form->create('AutoQuiz', array('url' => 'quiz_update')); ?>
<?php echo $this->Form->input('id',array(
	'type' => 'hidden',
	'value' => $quiz['AutoQuiz']['id'])); ?>
<?php echo $this->Form->input('sentence',array(
	'label'=>'問題文',
	'value' => $quiz['AutoQuiz']['sentence'],
	'class' => 'longform'
)); ?>
<?php echo $this->Form->input('option1',array(
	'label'=>'選択肢1',
	'value' => $quiz['AutoQuiz']['option1'])); ?>
<?php echo $this->Form->input('option2',array(
	'label'=>'選択肢2',
	'value' => $quiz['AutoQuiz']['option2']));?>
<?php echo $this->Form->input('option3',array(
	'label'=>'選択肢3',
	'value' => $quiz['AutoQuiz']['option3'])); ?>
<?php echo $this->Form->input('right_answer',array(
	'label'=>'選択肢4/正解',
	'value' => $quiz['AutoQuiz']['right_answer'])); ?>
<?php echo $this->Form->input('description',array(
	'label'=>'解説',
	'value' => $quiz['AutoQuiz']['description'])); ?>
<?php echo $this->Form->input('編集を確定',array(
        'type' => "button",
        "class"=>"btn btn-warning",
        "label" => false
    )); ?>
<?php echo $this->Form->end(); ?>

<!-- 自動生成 -->
<?php
	echo $this->Form->create('AutoQuiz', array('url' => 'quiz_update_auto'));
	echo $this->Form->input('id',array('type' => 'hidden','value' => $quiz['AutoQuiz']['id']));
	echo $this->Form->input('sentence',array('type' => 'hidden','value' => $quiz['AutoQuiz']['sentence']));
	echo $this->Form->input('right_answer',array('type' => 'hidden','value' => $quiz['AutoQuiz']['right_answer']));
	// echo $this->Form->input('creator_id',array('type' => 'hidden','value' => $quiz['AutoQuiz']['creator_id']));
	echo $this->Form->input('exam_id',array('type' => 'hidden','value' => $quiz['AutoQuiz']['exam_id']));
	echo $this->Form->input('description',array('type' => 'hidden','value' => $quiz['AutoQuiz']['description']));
	echo $this->Form->input('settime',array('type' => 'hidden',"id"=>"settime",'value' => ""));
	echo $this->Form->input('選択肢自動設定',array(
	    'type' => "button",
	    "class"=>"btn btn-success",
	    "id" => "time1",
	    "label" => false));
	echo $this->Form->end();
?>

<style>
	input.longform{
		width: 600px;
	}
</style>
<script>
//ページロードからsubmitまでの時間計測
var startTime = null;
$(function(){
	startDate = new Date();
	startTime = startDate.getTime();
});

$("button#time1").on('click',function(){
	stopDate = new Date();
	stopTime = stopDate.getTime();
	time = ( stopTime - startTime ) / 1000;
	//alert(time);
	$("input:hidden#settime").val(time);
});
</script>