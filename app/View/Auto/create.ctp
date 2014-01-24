<?php 
if(!empty($output)){ //②作成結果出力
	echo '<form action="check" method="POST" class="create">';

	echo "<div id='make-result-l'>";
	echo "<span class='label'>作成した<h3>一問一答形式問題</h3></span>"."<br />";
	echo "<span class='red'>問題文:</span>";
	echo '<input type="text" name="one[sentence]" value="'.$output['one']['sentence'].'"><br />';
	echo "<span class='red'>正答:</span>";
	echo '<input type="text" name="one[answer]" value="'.$output['one']['answer'].'"><br />';
	echo "</div>";


	echo "<div id='make-result-r'>";
	echo "<span class='label label-warning'>
			生成された
			<h3>多肢選択形式問題</h3>
			選択肢設定の仕方:".$output['class'].
			"</span>"."<br />";
	echo '<input type="hidden" name="class" value="'.$output['class'].'">';
	echo '<input type="hidden" name="group_id" value="'.$info['group_id'].'">';
	echo '<input type="hidden" name="exam_id" value="'.$info['exam_id'].'">';
	echo '<input type="hidden" name="creator_id" value="'.$info['creator_id'].'">';
	echo '<input type="hidden" name="settime" value="'.$info['settime'].'">';
	echo '<input type="hidden" name="settime2" value="" id="settime">';

	echo "<span class='red'>問題文:</span>";
	echo '<input type="text" name="multi[sentence]" value="'.$output['multi']['sentence'].'"><br />';
	//選択肢
	foreach ($output['multi']['option'] as $key => $value) {
		echo "<span class='red'>選択肢".($key+1).":</span>";
		echo '<input type="text" name="multi[option][]" value="'.trim($value).'"><br />';
	}
	echo "</div>";

	echo "<br />";
	echo "<br />";
	echo "<br />";

	echo '<input type="submit" value="確定">';
	echo '</form>';

	echo '<form action="." method="POST">';
	echo '<input type="submit" value="選択肢を設定し直す">';
	echo '</form>';
	// pr($info);
}else{ //①問題作成
	echo $this->Form->create('AutoQuiz',array('url' => 'create', 'class'=>'create-main'));
	echo "<span id='make'>
	問題文を入力して下さい
		</span><br />";

	echo $this->Form->input('sentence', array('type' => 'text', 'label' => false, 'placeholder' => 'このサイトの作成者の名前', 'div'=> false, 'autocomplete' => "off", 'onClick' => 'start();'));
	echo $this->Form->input("end_of_sentence",array("type"=>"select",
		"options"=>array("を答えよ。"=>"を答えよ。","を書きなさい。"=>"を書きなさい。","は何ですか。"=>"は何ですか。"),"selected"=>"を答えよ。",'label'=> false,'div'=> false ));
	echo "<br /><span id='make-a'>
	正答単語を入力して下さい
		</span><br />";
	echo $this->Form->input('answer', array('type' => 'text', 'label' => false, 'placeholder' => 'n0bisuke' ,'autocomplete' => "off"));
	$group = $this->Session->read('group'); //セッションから
	echo $this->Form->input('group_id', array('type' => 'hidden','value' => $group['AutoGroup']['id']));
	echo $this->Form->input('exam_id', array('type' => 'hidden','value' => $info['exam_id']));
	echo $this->Form->input('creator_id', array('type' => 'hidden','value' => $info['creator_id']));
	echo "難易度";
	echo $this->Form->input("type",array("type"=>"select",
		"options"=>array(1=>"激むず",2=>"むずい",3=>"ふつう"),"selected"=>1,'label'=> false,'div'=> false, "after" => "で"));
	echo $this->Form->input("settime",array("type"=>"hidden","id"=>"settime",'value' => ""));
	echo $this->Form->end('作問する');
}
?>

<script>
//ページロードからsubmitまでの時間計測
var startTime = null;
$(function(){
	startDate = new Date();
	startTime = startDate.getTime();
});

$("input:submit").on('click',function(){
	stopDate = new Date();
	stopTime = stopDate.getTime();
	time = ( stopTime - startTime ) / 1000;
	// alert(time);
	$("input:hidden#settime").val(time);
});
</script>