<?php if(!empty($log)): ?>
	<h2>みんなの活動</h2>
	<div id="mysagscroller" class="sagscroller">
	<ul>
	<?php foreach ($log as $key => $value): ?>
		<li>
			[<?php echo $value["AutoLog"]["created"];?>]
			<?php echo $this->Html->image('auto/'.$value["AutoUser"]["image"],
				array('width'=>'15','height'=>'15')); ; ?>
			<?php echo $value["AutoUser"]["name"]; ?>が

			<?php if($value["AutoLog"]["type"] == '問題'): ?> <!-- 問題作成等 -->
				<?php echo (!empty($value["AutoExam"]["name"]))? $value["AutoExam"]["name"]."に" : ""; ?>
				<?php echo $value["AutoLog"]["type"]; ?>を
				<?php echo $value["AutoLog"]["action"]; ?>しました<br />
			<?php elseif($value["AutoLog"]["type"] == '認証'): ?> <!-- ログイン記録 -->
				<?php echo $value["AutoLog"]["action"]; ?>しました<br />
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
	</ul>
	</div>

	<script>
		/* 文字リスト縦スクロール */
		var sagscroller1=new sagscroller({
		    id:'mysagscroller',
		    mode: 'auto',
		    pause: 3500,
		    animatespeed: 1200
		})
	</script>
<?php endif; ?>