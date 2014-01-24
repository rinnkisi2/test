<?php
 echo $this->Form->create('AutoUser', array('url' => 'add'));
 echo $this->Form->input('name',array('label'=>'ユーザ名'));
 echo $this->Form->input('passwd',array('label'=>'パスワード'));
 //echo $this->Form->input('email',array('label'=>'メールアドレス'));
 echo $this->Form->end('新規ユーザを作成する');
?>