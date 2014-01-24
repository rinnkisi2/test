<div id="login-form">
	<?php echo $this->Form->create('TestUser', array('url' => 'login')); ?>
	<?php echo $this->Form->input('name', array('type' => 'hidden','value'=>$data['TestUser']['name'])); ?>
	<?php echo $this->Form->input('passwd', array('type' => 'hidden','value'=>$data['TestUser']['passwd'])); ?>
	<?php echo $this->Form->end('試験を開始する'); ?>
</div>

<div id="login-img">
	<?php echo $this->Html->image('auto/zz03.png', array('width'=>'400px','alt' => 'CakePHP')); ?>
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