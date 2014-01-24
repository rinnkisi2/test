<?php
	echo $this->Form->create('TestLog',array(
			'type' => 'post','url' => 'check_b'));
	foreach($quizzes as $key => $value){
		echo "<div class='hero-unit'>";
		$quiz = "";
		$quiz .= "[".($key+1)." / 50問]";
		if( ($key+1) == 12){
			$quiz .= "<br /><img src ='http://gyazo.com/35d3f2262d450ed81763a36d4f9185bd.png' /><br />";
		}
		$quiz .= trim($value['AutoQuiz']['sentence']);
		$quiz .= '<br />';
		//$quiz .= trim($value['AutoQuiz']['right_answer']);
		// $quiz .= $this->Form->input('TestLog.answer.'.$key, array(
		// 	'legend' => false,
		// 	'label' => false,
		// 	'type' => 'text'));
		echo $this->Html->tag('h4',$quiz);
		//echo '<hr />';
		echo '</div>';
	}
	//echo $this->Form->submit('解答する');
?>