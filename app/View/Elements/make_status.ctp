<h2>問題提出状況</h2>
	
	<?php $limit = array(100,100,50); ?>
	<?php $classtype = array('info','success','danger'); ?>
	
	<!-- 進捗状況 -->
	<?php foreach ($task as $key => $value): ?>
		<?php if(!empty($value['name'])): ?>
			<?php $percent = $value['quizcount']/$limit[$key]*100; ?>
			<?php echo $value['name']; ?>
			<?php echo $value['quizcount']."/".$limit[$key] ." (進捗率".$percent."%)"; ?>

			<div class="progress progress-<?php echo $classtype[$key]; ?>">
				<div class="bar" style="width: <?php echo $percent; ?>%;"></div>
			</div>
		<?php endif; ?>
	<?php endforeach; ?>