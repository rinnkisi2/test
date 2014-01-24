<span id="flash-message"><?php echo $this->Session->flash('auth');?></span>
<?php if(!empty($quiz)): ?>
	<h3>下書きした問題</h3>
    <!-- 問題一覧 -->
    <!-- フォーム -->
    <?php echo $this->Form->create('AutoQuiz',array(
      'url' => 'exam_submit',
      'onsubmit'=>'return false;'
      )); ?>
	
    <?php //pr($quiz);
    	if(!empty($arr)){ //selectフォーム
    		echo "<h6>下書きを提出する場合は提出先を選び，提出する問題をチェックして下さい</h6>";

  			echo $this->Form->input('exam_id', array(
  			'type' => 'select',
  			'options' => $arr,
  			'label' => false,
  			'before' => "提出先テスト",
  			'style' => 'color: #ff0000' ) );
  		}
	?>
    	<table id="data-list" class="table">
    	<!-- タイトル行 -->
        <tr>
            <th></th>
            <th>No.</th>
            <th>設問</th>
            <th>誤答選択肢1</th>
            <th>誤答選択肢2</th>
            <th>誤答選択肢3</th>
            <th class="red">正答</th>
            <th></th>
        </tr>
        
        <!-- 中身 -->
        <?php foreach ($quiz as $key => $value): ?>
            <tr>
            
            <td class="edit-id">
              <label for=<?php echo $key+1;?>>
              <?php echo $this->Form->input("quiz_id", array(
    		      	'type' => 'checkbox', 
    		      	'value' => $value['AutoQuiz']['id'],
    		      	'name' => "data[AutoQuiz][quiz_id][$key]",
    		      	'label' => false,
    		      	'id' => $key+1
    		      )); ?>
              </label>
              <?php echo $this->Form->input("id", array(
                'type' => 'hidden', 
                'value' => $value['AutoQuiz']['id'],
                'class' => 'edit-id'
              )); ?>
		        </td>

            <td><?php echo ($key+1); ?></td>
            <td class="edit" title='li'>
            	<?php echo $value['AutoQuiz']['sentence']; ?>
            </td>
            <td class="edit" title='li'>
              <?php echo $value['AutoQuiz']['option1']; ?>
            </td>
            <td class="edit" title='li'>
              <?php echo $value['AutoQuiz']['option2']; ?>
            </td>
            <td class="edit" title='li'>
              <?php echo $value['AutoQuiz']['option3']; ?>
            </td>
            <td class="edit" title='li'>
              <?php echo $value['AutoQuiz']['right_answer']; ?>
            </td>

            <?php //user_note 編集ボタン
            	echo (!empty($arr))? '
            	<td>
              <input type="hidden">
              <input type="hidden">
              <a href="quiz_update/'.$value['AutoQuiz']['id'].'">
            	<span class="label btn-success">編集</span>
            	</a>

              </td>' : null;
            ?>
			
            <?php //user_made 投稿した試験名を表示
            	echo (!empty($value['AutoExam']['name']))? "<td>".$value['AutoExam']['name']."</	td>":null;
            ?>
            </tr>
        <?php endforeach; ?>
    	</table>
    
    <?php
    //確定ボタン
    if(!empty($arr)){ 
    	echo $this->Form->input('確定',array(
        'type' => "button",
        "class"=>"btn btn-primary",
        "label" => false,
        "onClick" => "submit();"
        ));
    }?>
<?php endif; ?>

<script>
    (function(documet){    
    $(document).ready(function(){
        $("#data-list > tbody > tr > .edit").click(edit_toggle());
    });

    function edit_toggle(){
        var edit_flag = false;
        return function(){
            if(edit_flag) return;
            var $input = $("<input>")
            .attr("type","text")
            .attr("title","li")
            .val(jQuery.trim($(this).text()));//trim()してテキスト表示
            $(this).html($input);
            $("input", this).focus().blur(function(){
                save(this);
                $(this).after($(this).val()).unbind().remove();
                edit_flag = false;
            });
            edit_flag = true;
        }
    }
    
    function save(elm){
        //行数を取得し，編集するidを取得する．
        var rec_num = $("input").index(elm) / 4; //何行目か
        rec_num = Math.floor(rec_num) - 1;
        var edit_id = $("input.edit-id:eq("+rec_num+")").val();; //行の先頭:idを取得

        //列数を取得し，編集するカラム名を取得する
        var colcount = 5; //指定フィールド数
        var colnum = $("[title='li']").index(elm) /*% colcount*/;
        colnum = colnum - (colcount * rec_num) + 1;
        var edit_col = $("th:eq("+colnum+")").text(); //カラム名を取得する．
        // console.log(edit_col);

        //変種内容をポスト送信する
        $.post('quiz_update_post',
            {
                'edit_mes': $(elm).val(), //編集内容
                'edit_id': edit_id, //編集するid
                'edit_col': edit_col //編集するフィールド
            },
            function(data){
                //alert(data);
                console.log(data.edit);
                //window.location.reload();   //ページをリロード
            }
        );
    }
})(document);

</script>