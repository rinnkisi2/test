<?php if(empty($group_id)): ?>
	グループを作成する
	<?php echo $this->Session->flash('auth'); ?>
	<?php echo $this->Form->create('AutoGroup', array('url' => 'group_add','enctype' => 'multipart/form-data')); ?>
	<?php echo $this->Form->input('name',array('label'=>'グループ名')); ?>
	<?php echo $this->Form->input('explanation',array('label'=>'グループの説明'));?>
	<?php echo $this->Form->input('image', array('type'=>'file' )); ?>
	<?php echo $this->Form->input('user',array('type'=>'hidden','name'=>'user_id','value' => $user['id']));?>
	<?php echo $this->Form->end('グループを作成する'); ?>
<?php else: ?>
	<?php pr($group_id); ?>
<?php endif; ?>