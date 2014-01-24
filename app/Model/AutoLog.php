<?php
class AutoLog extends Model{
	public $name = 'AutoLog';

	public function record($data,$func_name){//ログを記録
		if($func_name == "exam_submit"){//問題の提出時 : AutoQuizModel
			$input['AutoLog']['action'] = "提出";
			$input['AutoLog']['type'] = '問題';
			$input['AutoLog']['comment'] = $_SESSION['Auth']['User']['name'].'が問題を提出しました';
			$input['AutoLog']['quiz_id'] = $data['id']; //クイズid
			$input['AutoLog']['exam_id'] = $data['exam_id']; //試験id

		}elseif($func_name == "exam_un_submit"){//問題の差し戻し時 : AutoQuizModel
			$input['AutoLog']['action'] = "差し戻し";
			$input['AutoLog']['type'] = '問題';
			$input['AutoLog']['comment'] = $_SESSION['Auth']['User']['name'].'が問題を差し戻ししました';
			$input['AutoLog']['quiz_id'] = $data['id']; //クイズid
			$input['AutoLog']['exam_id'] = $data['exam_id']; //試験id
		}elseif($func_name == 'login'){//ログインを記録 : AutoController
			$input['AutoLog']['action'] = 'ログイン';
			$input['AutoLog']['type'] = '認証';
		}elseif($func_name == 'prequiz_save'){//下書き : : AutoQuizModel
			$input['AutoLog']['action'] = "下書き";
			$input['AutoLog']['type'] = '問題';
			$input['AutoLog']['quiz_id'] = $data['id']; //クイズid
		}

		$input['AutoLog']['user_id'] = $_SESSION['Auth']['User']['id'];
		$this->save($input);
	}

	public function show_log(){//タイムライン表示
		$belongsTo = array(
			'AutoUser' => array( //ユーザ名取得
				'className' => 'AutoUser',
				'foreignKey' => 'user_id',
				'fields' =>array('AutoUser.name','AutoUser.image')
			),
			'AutoExam' => array( //試験名取得
				'className' => 'AutoExam',
				'foreignKey' => 'exam_id',
				'fields' =>array('AutoExam.name')
			),
			'AutoGroup' => array( //試験名取得
				'className' => 'AutoGroup',
				'foreignKey' => 'Group_id',
				'fields' =>array('AutoGroup.name')
			)
		);
		$this->bindModel(array("belongsTo" => $belongsTo));
		return $this->find('all',array('order' => array('created' => 'DESC')));
	}
}
?>