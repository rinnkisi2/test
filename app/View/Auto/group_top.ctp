<?php echo $this->Session->flash('auth'); ?>
<?php $group = $this->Session->read('group'); ?>
<?php //pr($group['AutoGur']); ?>
<div id="group_top" class="row-fluid">
	<div id="left" class="span6"><!-- info -->
		<?php
			echo $this->element('contribute', array(
				"count" => "Oh, this text is very helpful."
			));
		?>
	</div>

	<div id="right" class="span6"><!-- タイムライン -->
		<?php echo $this->element('show_history', array("log" => $log));?>
	</div>
</div>

<!-- ページ下部 -->
<div id="group_bottom" class="well"><!-- 問題提出状況 -->
	<?php echo $this->element('make_status', array("task" => $task));?>
</div>