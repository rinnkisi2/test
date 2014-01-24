<?php echo $this->Session->flash('auth'); ?>

<?php if(!empty($group)): ?>
	<!--グループがある場合-->
	<h3>グループを選択して下さい!
	<a href="https://www.evernote.com/shard/s28/sh/44caed3c-57bc-4831-8f38-de9319c29c44/0a1a729512e8b3f2da938fe516068a11" target="brank" class="label btn-success">使い方はコチラ!</a>
	</h3>
	<?php foreach ($group as $key => $value): ?>
		<div id="group-list">
			<span class="group_name">
				<?php $flag=0; echo $value['AutoGroup']['name']; ?>
			</span>
			<br />
			<?php echo $this->Html->image('auto/'.$value['AutoGroup']['image'] , array('width'=> '100px','alt' => 'kentei')); ?>
			<br />
			<?php echo $value['AutoGroup']['explanation']; ?>
			<br />
			<?php
			foreach ($value['AutoGur'] as $key2 => $value2) {
				if($value2['user_id'] == $user['id']){
					$flag=1;
					break;
				}
			}
			if($flag == 1){//参加済みのグループ
				echo ' <a href="http://sakumon.jp/app/maker/auto/group_top/'.
				$value['AutoGroup']['id'].'" class="btn btn-large btn-primary">グループへ</a>';
			}else{//未参加のグループ
				echo ' <a href="#"
				group_id='.$value['AutoGroup']['id'].'
				name='.$value['AutoGroup']['name'].'
				class="switch btn btn-large btn-primary">グループに参加</a>';
			}
			?>
		</div>
	<?php endforeach; ?>
<?php else: ?>
	<!--グループが無い場合-->
	登録されているグループがありません
<?php endif; ?>

<!--グループへ参加-->
<div id="login-form-new">
	"<span class="name"></span>"グループに参加します．
	<?php echo $this->Session->flash('auth'); ?>
	<?php echo $this->Form->create('AutoUser', array('url' => 'group_join'));?>
	<?php echo $this->Form->input('passwd',array('label'=>'パスワード', 'value'=>'null')); ?>
	<div class="input hidden" id="group_id"></div>
	<?php echo $this->Form->end('グループに参加する'); ?>
</div>

<script>
$(function(){
	/**参加する際のフォームの出現アクション**/
    $("#login-form-new").css("display", "none");
    // 「id="jQueryPush"」がクリックされた場合
    $(".switch").on('click', function(){
    	$("#login-form-new").show(1000);
    	//名前を動的に
    	$(".name").html($(this).attr('name'));
    	//formを動的に生成 group_idを動的に
    	var form = '<input name="data[AutoUser][group_id]" type="hidden" id="AutoUserGroupId" value=';
    	form += $(this).attr("group_id");
    	form += ' />';
    	$("#group_id").html(form);
    });
});
</script>