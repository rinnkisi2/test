<?php
class AutoGroup extends Model{
	var $name = 'AutoGroup';
	
	// public $belongsTo = array(
	// 	'AutoGur' => array(
	// 	'className' => 'AutoGur',
	// 	'foreignKey' => 'id',
	// 	 Post側 連結用カラム名を記述 → 相手Genre側の primary key カラムと連結する 
	// 	'conditions' => '',
	// 	'fields' =>array( 'AutoGur.user_id'),
	// 	'order' => ''
	// 	)
	// );

	// public $hasMany = array(
	// 	'AutoGur' => array(
	// 		'className' => 'AutoGur',
	// 		'foreignKey' => 'group_id',
	// 	)
	// );

	function find_plus_gur(){//グループとユーザのリレーション
		$hasMany = array(
			'AutoGur' => array(
				'className' => 'AutoGur',
				'foreignKey' => 'group_id',
			)
		);
		$this->bindModel(array("hasMany" => $hasMany));
		$data = $this->find('all'); //find all		
		return $data;
	}

	function find_plus_all($id){//グループとグループに属する試験
		$hasMany = array(
			//試験テーブルと結合
			'AutoExam' => array(
				'className' => 'AutoExam',
				'foreignKey' => 'group_id',
				'order' => array(
					'name' => 'DESC',
				)
			),
			//ユーザ:グループ連結テーブルと結合
			'AutoGur' => array(
				'className' => 'AutoGur',
				'foreignKey' => 'group_id',
			)
		);
		$this->bindModel(array("hasMany" => $hasMany));
		$data = $this->findById($id);
		return $data;
	}

	function save_plus_g($data){//グループ作成と同時にリレーションも作成
		$this->save($data); //グループを保存
		
		App::import('Model','AutoGur');
		$AutoGur = new AutoGur;
		
		$tmp['AutoGur']['group_id'] = $this->getLastInsertID(); //保存したグループのID
		$tmp['AutoGur']['user_id'] = $data['user_id']; //作成したユーザのID
		$AutoGur->save($tmp); //グループを作成したユーザとグループを紐付け
	}
}
?>