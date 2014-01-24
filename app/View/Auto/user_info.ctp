<?php echo $userinfo['AutoUser']['name']; ?>
<br />
<?php echo $this->Html->image('auto/'.$userinfo['AutoUser']['image'] , array('width'=> 100,'alt' => 'kentei')); ?>
<br />
提出した問題数
<?php echo count($userinfo['AutoQuiz']); ?>
