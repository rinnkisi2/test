<span id="flash-message"><?php echo $this->Session->flash('auth');?></span>
<?php if(!empty($quiz)): ?>
	<h3>あなたが作成した提出済の問題</h3>
    <!-- 問題一覧 -->
    <!-- フォーム -->
    <?php echo $this->Form->create('AutoQuiz',array('url' => 'exam_un_submit')); ?>
    	<table class="table"><tbody>
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
            <td>
            	<?php echo $value['AutoExam']['name']; ?>
            </td>
            </tr>
        <?php endforeach; ?>
    	</tbody></table>
    
    <?php //確定ボタン
    echo $this->Form->input('下書きに戻す',array('type' => "submit", "class"=>"btn btn-primary", "label" => false));?>
<?php endif; ?>