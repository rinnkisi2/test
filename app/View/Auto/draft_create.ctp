<div id="createpre">
	<?php if(empty($quiz)): ?><!-- ①問題登録 -->
		<p>
			一度に5問迄作成できます．
			<a href="draft_import" class="btn btn-info">Excelから</a>
		</p>
		<?php echo $this->Form->create('AutoQuiz',array('url' => 'draft_submit')); ?>
		<?php for ($i=0; $i < 5; $i++): ?>
			<div class="hero-unit">
				<p><?php echo $i+1; ?>
				<?php echo $this->Form->input("sentence][]", array('type' => 'textarea',
					'div'=> false,
					'label' => false,
					'placeholder' => "問題文",
					"cols" => 100,
					"rows" => 2,
					"wrap" => "soft",
					"class" => 'sentence'));
				?>
				<?php echo $this->Form->input("description][]", array('type' => 'textarea',
					'div'=> false,
					'label' => false,
					'placeholder' => "解説/URL等",
					"cols" => 100,
					"rows" => 2,
					"wrap" => "soft",
					"class" => 'description'));
				?>
				</p>
				<?php echo $this->Form->input("option1][]", array('type' => 'text', 'div'=> false, 
				'label' => false, 'placeholder' => "誤答選択肢1"/*,"name" => "data[AutoQuiz][right_answer][]"*/)); ?>
							<?php echo $this->Form->input("option2][]", array('type' => 'text', 'div'=> false, 
				'label' => false, 'placeholder' => "誤答選択肢2"/*,"name" => "data[AutoQuiz][right_answer][]"*/)); ?>
							<?php echo $this->Form->input("option3][]", array('type' => 'text', 'div'=> false, 
				'label' => false, 'placeholder' => "誤答選択肢2"/*,"name" => "data[AutoQuiz][right_answer][]"*/)); ?>


				<?php echo $this->Form->input("right_answer][]", array('type' => 'text', 'div'=> false, 
				'label' => false, 'placeholder' => "答え"/*,"name" => "data[AutoQuiz][right_answer][]"*/)); ?>
				
			</div>
		<?php endfor; ?>
		<?php echo $this->Form->input('作問',array('type' => "submit", "class"=>"btn btn-primary", "label" => false)); ?>
	<?php endif; ?>

</div>

<style>
	.hero-unit{
		padding: 5px;
		padding-left: 10px;
		padding-right: 10px;
		margin-bottom: 10px;
	}
</style>