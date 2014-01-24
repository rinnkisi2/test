<?php if(!empty($quiz)): ?>
	<h3>
		<?php echo $mes; ?>
	</h3>
    <!-- 問題一覧 -->
    <!-- フォーム -->
    <?php echo $this->Form->create('AutoQuiz',array('url' => 'exam_un_submit')); ?>
	
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
    	<table><tbody>
    	<!-- タイトル行 -->
        <tr>
            <th></th>
            <th>No.</th>
            <th>設問</th>
            <th>選択肢1</th>
            <th>選択肢2</th>
            <th>選択肢3</th>
            <th class="red">正答</th>
            <th>解説</th>
            <th><!-- 提出済試験名 --></th>
        </tr>
        
        <!-- 中身 -->
        <?php foreach ($quiz as $key => $value): ?>
            <tr>
            
            <td><?php echo $this->Form->input("quiz_id", array(
		      	'type' => 'checkbox', 
		      	'value' => $value['AutoQuiz']['id'],
		      	'name' => "data[AutoQuiz][quiz_id][$key]",
		      	'label' => false,
		      	'id' => $key+1
		      )); ?>
		  	</td>

            <td><?php echo ($key+1); ?></td>
            <td><label for=<?php echo $key+1;?>>
            	<?php echo $value['AutoQuiz']['sentence']; ?>
            </label></td>
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
            <td class="edit" title='li'>
              <?php echo $value['AutoQuiz']['description']; ?>
            </td>
            
            <?php //user_note 編集ボタン
            	echo (!empty($arr))? '
            	<td><a href="quiz_update/'.$value['AutoQuiz']['id'].'">
            	<span class="label btn-success">編集</span>
            	</a></td>' : null;
            ?>
			
            <?php //user_made 投稿した試験名を表示
            	echo (!empty($value['AutoExam']['name']))? "<td>".$value['AutoExam']['name']."</	td>":null;
            ?>
            </tr>
        <?php endforeach; ?>
    	</tbody></table>
    
    <?php
    //確定ボタン
    //if(!empty($arr)){ 
    	echo $this->Form->input('下書きに戻す',array('type' => "submit", "class"=>"btn btn-primary", "label" => false));
    //}
    ?>
<?php endif; ?>