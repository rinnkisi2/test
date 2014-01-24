<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('AutoUser', array('url' => 'login')); ?>
<?php echo $this->Form->input('name', array('label' => 'ユーザ名')); ?>
<?php echo $this->Form->input('passwd', array('label' => 'パスワード')); ?>
<?php echo $this->Form->end('ログイン'); ?>