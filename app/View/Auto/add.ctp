<br />
<br />
<br />
<br />
<br />
<br />
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('AutoUser', array('url' => 'add')); ?>
<?php echo $this->Form->input('name',array('label'=>'ユーザ名')); ?>
<?php echo $this->Form->input('passwd',array('label'=>'パスワード')); ?>
<?php echo $this->Form->input('passwd',array('label'=>'パスワード確認', "name" => "pass_check")); ?>
<?php echo $this->Form->input('email',array('label'=>'メールアドレス'));?>
<?php echo $this->Form->end('新規ユーザを作成する'); ?>