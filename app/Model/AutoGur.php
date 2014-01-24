<?php
class AutoGur extends Model{
	var $name = 'AutoGur';

	public $belongsTo = array(
		'AutoGroup' => array(
			'className' => 'AutoGroup',
			'foreignKey' => 'group_id',
			/* Post側 連結用カラム名を記述 → 相手Genre側の primary key カラムと連結する */
			'conditions' => '',
			'fields' =>array( 'AutoGroup.name'),
			'order' => ''
		),
		'AutoUser' => array(
			'className' => 'AutoUser',
			'foreignKey' => 'user_id',
			/* Post側 連結用カラム名を記述 → 相手Genre側の primary key カラムと連結する */
			'conditions' => '',
			'fields' =>array( 'AutoUser.name'),
			'order' => ''
		)

	);

	function find_invader($group_id,$user_id){//グループの部外者を探せ!
		$data = $this->find('first',array('conditions' => array('group_id' => $group_id, 'user_id' => $user_id)));
		return $data;
	}
}
?>