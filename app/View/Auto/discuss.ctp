出題ネタなどを共有しましょう!
<?php echo $this->Form->create('AutoDiscuss', array('url' => 'discuss')); ?>
<?php echo $this->Form->input('comment',array(
	'type' => 'textarea',
    // 'cols' => '80',
    // 'rows' => '2',
	'label' => false));?>
<?php echo $this->Form->end("投稿する"); ?>

<div id="discuss">
<?php if(!empty($data)): ?>
    <h3>コメント<?php echo count($data); ?>件</h3>
	<?php foreach ($data as $key => $value): ?>
		<?php if($value['AutoDiscuss']['creator_id'] == $user['id']): ?>
			<!-- 自分の投稿 -->
			<div class="well">
                <!-- 投稿日時 -->
                <strong>
                    [<?php echo $value['AutoDiscuss']['created']; ?> ]

                    from
                    <?php echo $this->Html->image('auto/'.$value["AutoUser"]["image"],
                        array('width'=>'15','height'=>'15')); ; ?>
                    <?php echo $value["AutoUser"]["name"]; ?>
                </strong>
                <!-- 投稿内容 -->
                <h4>

                    <?php echo $value['AutoDiscuss']['comment']; ?>
                </h4>
                <!-- スクショ＆リンク -->
                <?php if(!empty($value['AutoDiscuss']['source'])){
                    echo '<a href="'.$value['AutoDiscuss']['source'].'" target="brank">';
                    echo '<img src="http://s.wordpress.com/mshots/v1/'.$value['AutoDiscuss']['source'].'?w=100" />';
                    echo '</a>';
                }?>
                <a href="discuss_del/<?php echo $value['AutoDiscuss']['id']; ?>"><i class='icon-trash'></i></a>
			</div>
		<?php else: ?>
			<!-- 自分以外の投稿 -->
			<div class="fukidashi_you">
    			<span class="from">匿名希望</span>
    			<?php echo $value['AutoDiscuss']['comment']; ?>
    		</div>
		<?php endif; ?>	
	<?php endforeach; ?>
<?php else: ?>
	コメントがありません。
<?php endif; ?>
</div>