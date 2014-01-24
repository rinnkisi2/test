<?php
class AutoQuiz extends Model{
	public $name = 'AutoQuiz';
	var $actsAs = array(
		'CsvImport' => array(
			'delimiter'  => ',',
		)
	);
	//public $hasOne = 'AutoExam';
	// public $hasOne = array(
 //        'AutoExam' => array(
 //            'className' => 'AutoExam',
 //            'foreignKey' => 'id',
 //           // 'conditions'   => array('Profile.published' => '1'),
 //            'dependent'    => true
 //        )
 //    );
	// public $belongsTo = array(
	// 	'AutoExam' => array(
	// 		'className' => 'AutoExam',
	// 		'foreignKey' => 'exam_id',
	// 		 //Post側 連結用カラム名を記述 → 相手Genre側の primary key カラムと連結する 
	// 		'conditions' => '',
	// 		'fields' =>array( 'AutoExam.name'),
	// 		'order' => ''
	// 	)
	// );

	/**
	クイズを検索したときに、クイズが属している試験名も取得
	利用: user_made
	**/
	function find_examname($para1,$para2){
		$belongsTo = array(
			'AutoExam' => array(
				'className' => 'AutoExam',
				'foreignKey' => 'exam_id',
				'fields' =>array( 'AutoExam.name')
			));
		$this->bindModel(array("belongsTo" => $belongsTo));
		$data = $this->find($para1,$para2);
		return $data;
	}
	/**
	クイズを検索したときに、クイズを作成者も取得
	利用: exam_top
	**/
	function find_creator($para1,$id){
		$belongsTo = array(
			'AutoUser' => array(
				'className' => 'AutoUser',
				'foreignKey' => 'creator_id',
				'fields' =>array( 'AutoUser.name')
			));
		$this->bindModel(array("belongsTo" => $belongsTo));
		$data = $this->find($para1,array('conditions' => array('AutoQuiz.exam_id'  => $id)));
		return $data;
	}
	/**
	下書き 連続insert
	利用: createpre
	**/
	function prequiz_save($data,$i){
		$this->create();
		$input['AutoQuiz']['type'] = 1; //一問一答式
		$input['AutoQuiz']['creator_id'] = $_SESSION['Auth']['User']['id'];
		$input['AutoQuiz']['group_id'] = 37; //もりけんグループ
		$input['AutoQuiz']['sentence'] = $data['AutoQuiz']["sentence"][$i];
		if(!empty($input['AutoQuiz']['option1']))$input['AutoQuiz']['option1'] = $data['AutoQuiz']["option1"][$i];
		if(!empty($input['AutoQuiz']['option2']))$input['AutoQuiz']['option2'] = $data['AutoQuiz']["option2"][$i];
		if(!empty($input['AutoQuiz']['option3']))$input['AutoQuiz']['option3'] = $data['AutoQuiz']["option3"][$i];
		$input['AutoQuiz']['right_answer'] = $data['AutoQuiz']["right_answer"][$i];
		if(!empty($input['AutoQuiz']['description']))$input['AutoQuiz']['description'] = $data['AutoQuiz']["description"][$i];
		$this->save($input);

		//ログる
		App::import('Model','AutoLog');
		$AutoLog = new AutoLog();
		$AutoLog->record(array('id'=>$this->getLastInsertID()),__FUNCTION__); //id,関数名
	}

	/**
	下書きから試験の提出を行う
	利用: user_note -> exam_submit
	**/
	function exam_submit($quiz){
		//移動する問題リストを作成
		foreach ($quiz['AutoQuiz']['quiz_id'] as $key => $value)if($value != 0)$submit_quiz[] = $value;
		//移動
		foreach ($submit_quiz as $key => $value){
			$this->create();
			$input['AutoQuiz']['id'] = $value;
			$input['AutoQuiz']['exam_id'] = $quiz['AutoQuiz']['exam_id'];
			$this->save($input);
			
			//ログる
			App::import('Model','AutoLog');
			$AutoLog = new AutoLog();
			$AutoLog->record($input['AutoQuiz'],__FUNCTION__); //id,関数名
		}
	}
	/**
	試験から下書きへ
	利用: exam_un_submit
	**/
	function exam_un_submit($quiz){
		//移動する問題リストを作成
		foreach ($quiz['AutoQuiz']['quiz_id'] as $key => $value)if($value != 0)$submit_quiz[] = $value;
		//移動
		foreach ($submit_quiz as $key => $value){
			$this->create();
			$input['AutoQuiz']['id'] = $value; 
			$input['AutoQuiz']['exam_id'] = 0; //exam_idを0に -> 下書きへ
			$this->save($input);

			//ログる
			App::import('Model','AutoLog');
			$AutoLog = new AutoLog();
			$AutoLog->record($input['AutoQuiz'],__FUNCTION__); //id,関数名
		}
	}

	/**
	試験毎の進捗状況(作問数)を取得
	利用: group_top
	**/
	function progress($exam_list){
		//試験名を取得
		$belongsTo = array(
			"AutoExam" => array(
				"className" => "AutoExam",
				"foreignKey" => "exam_id",
				"fields" => "AutoExam.name"
				)
			);
		$count = count($exam_list);

		for ($i=0; $i < $count; $i++){ //試験分ループ 各試験の作問数を取得
			$this->bindModel(array("belongsTo" => $belongsTo)); //for文の中でバインドしないといけないっぽい
			$exam_tmp[$i] = $this->find('all', array('conditions' => array('exam_id' => $exam_list[$i]['id'])));	
		}

		//アウトプット用に整形
		for ($i=0; $i < $count; $i++) {
			if(empty($exam_tmp[$i][0]['AutoQuiz']['exam_id'])){//試験に問題数が0の場合
				$exam_task[$i]['id'] = $exam_list[$i]; //試験ID
				$exam_task[$i]['name'] = null; //試験名
			}else{ //問題数が1問以上
				$exam_task[$i]['id'] = $exam_tmp[$i][0]['AutoQuiz']['exam_id']; //試験ID
				$exam_task[$i]['name'] = $exam_tmp[$i][0]['AutoExam']['name']; //試験名
			}	
			$exam_task[$i]['quizcount'] = count($exam_tmp[$i]); //現時点での作問数
		}

		return $exam_task; //試験id, 試験名, 作問数  のarray()
	}
}
?>