試験を作成する
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('AutoExam', array('url' => 'exam_add')); ?>
<?php echo $this->Form->input('name',array('label'=>'試験名')); ?>
<?php echo $this->Form->input('explanation',array('label'=>'試験の説明'));?>
<?php echo $this->Form->input('creator_id',array('type'=>'hidden','value' => $user['id']));?>
<?php echo $this->Form->input('group_id',array('type'=>'hidden','value' => $group_id));?>
<?php echo $this->Form->end('試験を作成する'); ?>