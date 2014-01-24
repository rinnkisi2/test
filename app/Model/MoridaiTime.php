<?php
class MoridaiTime extends Model{
	public $belongsTo = array(
		'MoridaiUser' => array(
		'className' => 'MoridaiUser',
		'foreignKey' => 'user_id',
		/* Post側 連結用カラム名を記述 → 相手Genre側の primary key カラムと連結する */
		'conditions' => '',
		'fields' =>array( 'MoridaiUser.user_name'),
		'order' => ''
		)
	);
}
?>