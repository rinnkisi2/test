<div id="login-img">
	<?php echo $this->Html->image('auto/zz03.png', array('width'=>'400px','alt' => 'CakePHP')); ?>
</div>

<div id="login-form-new">
	新規ユーザー登録
	<?php //echo $this->Session->flash('auth'); ?>
	<?php echo $this->Form->create('TestUser', array('url' => 'add')); ?>
	<?php echo $this->Form->input('name',array('label'=>'ユーザ名')); ?>
	<?php echo $this->Form->end('新規ユーザを作成する'); ?>
</div>

<script>

/*
$(function(){
    // 「id="jQueryBox"」を非表示
    $("#login-form-new").css("display", "none");
    // 「id="jQueryPush"」がクリックされた場合
    $("#switch, #switch2").on('click', function(){
    	 $("#login-form").toggle(1000);
    	 $("#login-form-new").toggle(1000);
    });
});
*/
</script>