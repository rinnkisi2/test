<?php
class TestUser extends Model{
	var $name = 'TestUser';

	public function show_log(){//タイムライン表示
		$hasMany = array(
            'TestLog' => array(
                'className' => 'TestLog',
                'foreignKey' => 'id',
            )
        );
        $this->bindModel(array("hasMany" => $hasMany));
        //return $this->findById($user_id);

		// $belongsTo = array(
		// 	'TestUser' => array( //ユーザ名取得
		// 		'className' => 'TestUser',
		// 		'foreignKey' => 'user_id',
		// 		'fields' =>array('TestUser.name')
		// 	)
		// );
		// $this->bindModel(array("belongsTo" => $belongsTo));
		return $this->find('all',array('order' => array('created' => 'DESC')));
	}
}