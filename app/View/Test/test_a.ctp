<style>
	#testmoriken{
		text-align: left;
	}
</style>
<div id="testmoriken">
<?php
	echo $this->Form->create('TestLog',array(
			'type' => 'post','url' => 'check_a'));
	foreach($quizzes as $key => $value){
		echo "<div class='hero-unit'>";
		$quiz = "";
		$quiz .= "[".($key+1)." / 50問]";
		if( ($key+1) == 16){

			$quiz .= "<br /><img src ='http://gyazo.com/837d8cce30e082544e82b06f94b1d5f8.png' /><br />";
		}
		$quiz .= trim($value['Problem']['sentence']);
		$quiz .= '<br />';

		// フォーム
		$option = array(
			1 => $value['Problem']['choice1'],
			2 => $value['Problem']['choice2'],
			3 => $value['Problem']['choice3'],
			4 => $value['Problem']['choice4'],
		);
		$quiz .= $this->Form->input('TestLog.choice.'.$key, array(
			'legend' => false,
			'type' => 'radio',
			'options' => $option));
		echo $this->Html->tag('h4',$quiz);
		//echo '<hr />';
		echo '</div>';
	}
	echo $this->Form->submit('解答する');
?>
</div>