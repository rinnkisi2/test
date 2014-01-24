<?php
class AutoDiscuss extends Model{
	public $name = 'AutoDiscuss';
	public $belongsTo = array(
		'AutoUser' => array(
			'className' => 'AutoUser',
			'foreignKey' => 'creator_id',
			/* Post側 連結用カラム名を記述 → 相手Genre側の primary key カラムと連結する */
			'conditions' => '',
			'fields' =>array('AutoUser.name','AutoUser.image'),
			'order' => ''
		));
}
?>