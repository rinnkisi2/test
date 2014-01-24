<?php
class TestLog extends Model{
	var $name = 'TestLog';

	public function show_log($type){//指定されたタイプによって内容を変更
		if($type == 'pre'){
			$field = 'point';
		}elseif($type == 'b'){
			$field = 'point_b';
		}elseif($type == 'a'){
			$field = 'point_a';
		}

		$belongsTo = array(
			'TestUser' => array( //ユーザ名取得
				'className' => 'TestUser',
				'foreignKey' => 'user_id',
				'fields' =>array('TestUser.name','TestUser.'.$field)
			)
		);
		$this->bindModel(array("belongsTo" => $belongsTo));
		$data = $this->find('all',array(
			'conditions' => array(
				'quiz_id like' => "%".$type."%"
			)));
			//array('order' => array('created' => 'DESC')));

		for ($i=0; $i < count($data); $i++){
			$name = $data[$i]['TestUser']['name'];
			$newdata[$name][] = $data[$i]['TestLog']['flag'];
			//得点
			$point = $data[$i]['TestUser'][$field];
			$newdata[$name]['point'] = $point;
		}

		$newdata['count'] = count($data) / count($newdata); //ログ わる ユーザ = 問題数
		if($type=='a'){
			$newdata['count'] = 50;
		}
		return $newdata;
	}
}