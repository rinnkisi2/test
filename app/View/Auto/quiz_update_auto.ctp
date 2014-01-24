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

<?php echo $this->Form->input('settime',array(
	'type' => "hidden",
	"id" => "settime2",
	'value' => $quiz['AutoQuiz']['settime'])); ?>
<?php echo $this->Form->input('settime2',array(
	'type'=>'hidden',
	"id" => "settime1",
	'value' => "")); ?>

<?php echo $this->Form->input('編集を確定',array(
        'type' => "button",
        "class"=>"btn btn-warning",
        "label" => false
    )); ?>
<?php echo $this->Form->end(); ?>

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
	var t1 = $("input:hidden#settime1").val(time);
	var t2 = $("input:hidden#settime2").val();
	alert(t1+t2);
});
</script>