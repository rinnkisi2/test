<?php //pr($check); ?>
確認
<?php
	echo $this->Form->create('TestLog',array(
			'type' => 'post','url' => 'result'));

	foreach($quizzes as $key => $value){
		echo "<div class='hero-unit'>";
		$quiz = "";
		$quiz .= "[".($key+1)." / 100問]";
		$quiz .= trim($value['Problem']['sentence']);
		$quiz .= '<br />';

		//チェックボックスが未選択のものの値は0とする
		if($check['TestLog']['choice'][$key] == null){
			$check['TestLog']['choice'][$key] = 0;
		}

		for ($i=1; $i <= 4; $i++) { 
			if($check['TestLog']['choice'][$key] == $i){ //1〜4の選択肢を選択
				$quiz .= '<i class="icon-ok-sign"></i>'.
						"<span class='green'>"
						.$value['Problem']["choice$i"]
						."</span>";
				$quiz .= $this->Form->input('TestLog.choice.'.$key, array(
					'type' => 'hidden',
					'value' => $i));
			}elseif($check['TestLog']['choice'][$key] == 0){ //選択肢を未選択
				$quiz .= $this->Form->input('TestLog.choice.'.$key, array(
					'type' => 'hidden',
					'value' => 0));
				//continue;
			}else{
				$quiz .= $value['Problem']["choice$i"];
			}
			$quiz .= '<br />';
		}
		echo $this->Html->tag('h4',$quiz);
		echo '</div>';
	}
	//pr($check);
	echo $this->Form->submit('解答する');
?>
<br />
※解答内容を変更する場合はブラウザの戻るボタンで戻って下さいm__m
<style>
	.green{
		color:green;
	}
</style>