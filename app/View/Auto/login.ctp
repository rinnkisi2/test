<div id="login-form">
	<span id="flash-message"><?php echo $this->Session->flash('auth');?></span>
	<?php echo $this->Form->create('AutoUser', array('url' => 'login')); ?>
	<?php echo $this->Form->input('name', array('label' => 'ユーザ名')); ?>
	<?php echo $this->Form->input('passwd', array('label' => 'パスワード')); ?>
	<?php echo $this->Form->end('ログイン'); ?>
	<a href="#" id="switch" class="label btn-primary">新規登録</a>
</div>

<div id="login-img">
	<?php echo $this->Html->image('auto/zz03.png', array('width'=>'400px','alt' => 'CakePHP')); ?>
</div>

<div id="login-form-new">
	新規ユーザー登録
	<?php echo $this->Session->flash('auth'); ?>
	<?php echo $this->Form->create('AutoUser', array('url' => 'add')); ?>
	<?php echo $this->Form->input('name',array('label'=>'ユーザ名')); ?>
	<?php echo $this->Form->input('passwd',array('label'=>'パスワード')); ?>
	<?php echo $this->Form->input('passwd',array('label'=>'パスワード確認', "name" => "pass_check")); ?>
	<?php echo $this->Form->input('email',array('label'=>'メールアドレス'));?>	
	<script>
		alert("こんにちはようこそ！!");
	</script>
	<?php echo $this->Form->end('新規ユーザを作成する'); ?>	
	<a href="#" id="switch2" class="label btn-primary">ログインへ</a>
</div>

<script>
$(function(){
    // 「id="jQueryBox"」を非表示
    $("#login-form-new").css("display", "none");
    // 「id="jQueryPush"」がクリックされた場合
    $("#switch, #switch2").on('click', function(){
    	 $("#login-form").toggle(1000);
    	 $("#login-form-new").toggle(1000);
    });
});
</script>
