<?php
/* [Moridai Project]
自動生成したいプログラム
 */

class AutoController extends AppController {
	public $name = 'Auto'; //class name
	public $uses = array('AutoQuiz','AutoWrong','AutoClass','Problem','AutoUser','AutoGroup','AutoGur','AutoExam','AutoDiscuss','AutoLog');
	public $layout = "auto";
	public $title_for_layout = "自動生成-";
	public $end_of_sentence = array("漢字で書きなさい","書きなさい","答えよ","何ですか");
	public $counter = 0;
	/****認証周り*****/
	public $components = array(
		//'Session',
		'DebugKit.Toolbar', //デバッグきっと
		'RequestHandler', //PDF作成ツール
		'Auth' => array(
			'authenticate' => array(
				'Form' => array(
					'userModel' => 'AutoUser',
					'fields' => array('username' => 'name','password' => 'passwd')
				)
			),
			//ログイン後の移動先
			'loginRedirect' => array('controller' => 'auto', 'action' => './index'),
			//ログアウ後の移動先
			'logoutRedirect' => array('controller' => 'auto', 'action' => 'login'),
			//ログインページのパス
			'loginAction' => array('controller' => 'auto', 'action' => 'login'),
			//未ログイン時のメッセージ
			'authError' => 'あなたのお名前とパスワードを入力して下さい。',
		)
	);

	function beforeFilter(){//login処理の設定
		parent::beforeFilter();//親クラスを継承
	 	$this->Auth->allow('login','logout','add');//ログインしないで、アクセスできるアクションを登録する
	 	$this->set('user',$this->Auth->user()); // ctpで$userを使えるようにする 。
		if($this->action != "exam_top" ||
			 		//$this->action != "exam_csv" //||
			$this->action != "create"
			){
			//$this->Session->delete('current_exam');
		}
	}

	function login(){ //ログイン処理
		//POST送信なら
		if($this->request->is('post')) {
			//ログインOKなら
			if($this->Auth->login()) {
				$this->Session->delete('Auth.redirect'); //前回ログアウト時のリンクを記録させない
				$this->AutoLog->record(array(),__FUNCTION__); //ログ: ログイン
				return $this->redirect($this->Auth->redirect()); //Auth指定のログインページへ移動
			}else{ //ログインNGなら
				$this->Session->setFlash(__('ユーザ名かパスワードが違います'), 'default', array(), 'auth');
			}
		} 
	}

	//ログアウトアクション（認証が不要なページ）
	function logout(){
		$this->Auth->logout();
		$this->Session->destroy(); //セッションを完全削除
		$this->Session->setFlash(__('ログアウトしました'));
		$this->redirect(array('action' => './login'));
	}

	//ユーザー追加（認証が不要なページ）
	function add(){
		//POST送信なら
		if($this->request->is('post')) {
			//パスワードのハッシュ値変換
			$this->request->data['AutoUser']['passwd'] = AuthComponent::password($this->request->data['AutoUser']['passwd']);
			//パスワードチェックの値もハッシュ値変換
			$this->request->data['pass_check'] = AuthComponent::password($this->request->data['pass_check']);
			//入力したパスワートとパスワードチェックの値が一致
			if($this->request->data['pass_check'] === $this->request->data['AutoUser']['passwd']){
				//ユーザーの作成
				$this->AutoUser->create();
				//リクエストデータを保存できたら
				if ($this->AutoUser->save($this->request->data)) {
					$this->Session->setFlash(__('新規ユーザーを追加しました'));
				} else { //保存できなかったら
					$this->Session->setFlash(__('登録できませんでした。やり直して下さい'));
				}
			}else{
				$this->Session->setFlash(__('パスワード確認の値が一致しません．'));
			}
			$this->redirect(array('action' => './index'));//リダイレクト	
		}
	}

	/**
	グループ管理
	**/
	function group_add(){//グループ作成＆グループに参加
		if($this->request->is('post')){//POST送信
			//グループ作成
			if ($this->AutoGroup->save_plus_g($this->request->data)){ //登録
				$this->Session->setFlash(__('新規グループを追加しました'));
			}else{
				$this->Session->setFlash(__('登録できませんでした。やり直して下さい'));
			}
			$this->redirect(array('action' => './index')); //トップに戻る
		}
	}

	function group_join(){//グループに参加する処理
		if($this->request->is('post')){//POST送信
			$data = $this->AutoGroup->findById($this->request->data['AutoUser']['group_id']);				
			//パスワードが合っていればグループに参加する
			if($data['AutoGroup']['passwd'] == $this->request->data['AutoUser']['passwd'] ||
				$data['AutoGroup']['passwd'] == null
				){
				$inputdata['AutoGur']['user_id'] = $this->Auth->user('id');
				$inputdata['AutoGur']['group_id'] = $data['AutoGroup']['id'];
				$inputdata['AutoGur']['authority'] = 'general';
				$this->AutoGur->save($inputdata);
				$this->Session->setFlash(__('グループに参加しました'));
			}else{
				$this->Session->setFlash(__('パスワードが間違っています'));
			}
			$this->redirect(array('action' => './index')); //トップに戻る
		}
	}

	function group_top($id){//グループトップページ
		//グループ外の人を排除
		if($this->AutoGur->find_invader($id,$this->Auth->user('id')) == null)$this->redirect(array('action' => './index')); //トップに戻る	
		
		//グループ内の情報を取得
		$this->AutoGroup->recursive = 2;
		$group = $this->AutoGroup->find_plus_all($id); //グループに所属する試験とメンバー
		$this->Session->write('group',$group);
		
		//タイムライン
		$log = $this->AutoLog->show_log();
		$this->set('log',$log);

		//進捗状況
		$task = $this->AutoQuiz->progress($group['AutoExam']); //試験id の リスト
		$this->set('task',$task);
	}

	/**
	ユーザーの情報など
	**/
	//ユーザーの情報
	function user_info($user_id){
		if(!empty($user_id)){
			$userinfo = $this->AutoUser->find_info($user_id);
			$this->set('userinfo',$userinfo);
		}else{//id指定が無ければ
			$this->redirect($this->referer()); //直前ページに戻る
		}
	}

	//下書き
	function user_note(){
		$quiz = $this->AutoQuiz->find('all',array('conditions' => array(
			'AutoQuiz.creator_id' => $this->Auth->user('id')
			,'exam_id' => 0 //試験に未提出
			)));
		$this->set('quiz',$quiz);

		//selectフォーム用のリスト生成
		$group = $this->Session->read('group');
		foreach($group['AutoExam'] as $key => $value)$exam_list[$value['id']] = $value['name'];
		$this->set("arr",$exam_list);
	}

	//提出済み
	function user_made(){
		$quiz = $this->AutoQuiz->find_examname('all',array('conditions' => array(
			'AutoQuiz.creator_id' => $this->Auth->user('id')
			,'exam_id !=' => 0 //試験に提出済
		)));
		$this->set('quiz',$quiz);
	}

	/**
	試験管理 exam
	**/
	function exam_add(){//試験作成
		//POST送信
		if($this->request->is('post')) {
			if($this->AutoExam->save($this->request->data)){ //登録
				$this->Session->setFlash(__('新規試験を追加しました'));
			}else{
				$this->Session->setFlash(__('登録できませんでした。やり直して下さい'));
			}
			$this->redirect(array('action' => './group_top?id='.$this->request->data['AutoExam']['group_id'])); //グループのトップに戻る
		}else{
			$this->set('group_id',$this->request->query['id']); //グループIDを渡す
		}
	}

	//下書き -> 試験に提出
	function exam_submit(){
		if($this->request->is('post')){
			foreach ($this->request->data['AutoQuiz']['quiz_id'] as $key => $value)if($value != 0)$submit_quiz[] = $value;
			if(empty($submit_quiz)){
				$this->Session->setFlash(__('提出する問題にチェックを入れて下さい'), 'default', array(), 'auth');
				$this->redirect($this->referer()); //直前ページに戻る
			}
			$this->AutoQuiz->exam_submit($this->request->data); //提出
			$this->redirect($this->referer()); //直前ページに戻る
		}
	}
	//試験 -> 下書きに戻す
	function exam_un_submit(){
		foreach ($this->request->data['AutoQuiz']['quiz_id'] as $key => $value)if($value != 0)$submit_quiz[] = $value;
		if(empty($submit_quiz)){
			$this->Session->setFlash(__('下書きへ戻す問題にチェックを入れて下さい'), 'default', array(), 'auth');
			$this->redirect($this->referer()); //直前ページに戻る
		}

		if($this->request->is('post')){
			$this->AutoQuiz->exam_un_submit($this->request->data); //提出
			$this->redirect($this->referer()); //直前ページに戻る
		}
	}

	//試験トップページ
	function exam_top($id){
		if(!empty($id)){//idがセットされていれば
			$quiz = $this->AutoQuiz->find_creator('all',$id);
			//$quiz = $this->AutoQuiz->find('all',array('conditions' => array('AutoQuiz.exam_id'  => $id)));
			$this->set('quiz',$quiz);
		}
	}

	function exam_csv(){//csvファイルから試験を読み込み
		//pr($this->request->data);
		$file_path = "files/auto/csv/";
		$csv = $this->request->data['AutoQuiz']['csv'];
		if(is_uploaded_file($csv["tmp_name"])) {
			if(move_uploaded_file($csv["tmp_name"], $file_path . $csv["name"])) {
				chmod($file_path . $csv["name"], 0644);
			    echo $csv["name"] . "をアップロードしました。";
			}else{
			    echo "ファイルをアップロードできません。";
			}
		}else{
			echo "ファイルが選択されていません。";
		}

		$filename = $file_path . $csv["name"];
		if(file_exists($filename)){//ファイルが存在するか
			$handle = fopen( $filename,"r");
			$load = fgets ($handle, 4096);
			//文字化け対応
			$moji_code = mb_detect_encoding($load);
			if($moji_code != "UTF-8")$load = mb_convert_encoding($load, "UTF-8", "SJIS,EUC-JP,auto");
			//改行コードで分割
			$list = explode("\x0d", $load);
			foreach ($list as $key => $value) {
				$new_list[] = explode(",", $value);
			}
			//一行毎に読み込み
			foreach ($new_list as $key => $value){
				//連想配列へ
				$quiz[$key]['AutoQuiz']['id'] = $key+1;
				$quiz[$key]['AutoQuiz']['sentence'] = $value[0];
				$quiz[$key]['AutoQuiz']['option1'] = $value[1];
				$quiz[$key]['AutoQuiz']['option2'] = $value[2];
				$quiz[$key]['AutoQuiz']['option3'] = $value[3];
				$quiz[$key]['AutoQuiz']['right_answer'] = $value[4];
				$quiz[$key]['AutoQuiz']['description'] = $value[5];
				$quiz[$key]['AutoQuiz']['image'] = "hoge.png";
				$quiz[$key]['AutoQuiz']['type'] = 0;
				$quiz[$key]['AutoQuiz']['exam_id'] = 5;
				$quiz[$key]['AutoQuiz']['group_id'] = 1;
				$quiz[$key]['AutoQuiz']['creator_id'] = $this->Auth->user('id');
			}
			fclose($handle);
			$this->set('quiz',$quiz);
		}else{
			print("file error");
		}
	}
	/**
	その他 編集 検索
	**/
	//検索
	function search(){
		if(!empty($this->request->data['AutoQuiz']['keyword'])){
			$key = $this->request->data['AutoQuiz']['keyword'];
			$quiz = $this->Problem->find_key($key);
			$this->set("quiz",$quiz);
		}
	}

	//ディスカッション
	function discuss(){
		$group = $this->Session->read('group'); //セッションからグループ情報取得
		if(!empty($this->request->data['AutoDiscuss']['comment'])){ //投稿
			$data = $this->request->data['AutoDiscuss']; //可読性UP
			//URLが含まれていれば URLを抜き出して $matchへ $matchは配列
			if(preg_match("/(?:^|[\s　]+)((?:https?|ftp):\/\/[^\s　]+)/",$data['comment'],$match)){
				//URLをsourceフィールドへ
				$input['AutoDiscuss']['source'] = trim($match[0]);
				//URL以外とcommentフィールドへ
				$this->request->data['AutoDiscuss']['comment'] = preg_replace('/(?:^|[\s　]+)((?:https?|ftp):\/\/[^\s　]+)/','',trim($data['comment']));
			}
			$input['AutoDiscuss']['comment'] = $this->request->data['AutoDiscuss']['comment'];
			$input['AutoDiscuss']['creator_id'] = $this->Auth->user('id');
			$input['AutoDiscuss']['exam_id'] = 0;
			$input['AutoDiscuss']['group_id'] = $group['AutoGroup']['id'];
			$this->AutoDiscuss->save($input);
		}
		//取得
		$data = $this->AutoDiscuss->find('all',array(
			'conditions' => array('group_id' => $group['AutoGroup']['id']),
			'order' => array('created' => 'desc')
		));
		$this->set("data",$data);
	}

	//ディスカッションの削除	
	function discuss_del($id){
		$this->AutoDiscuss->delete($id);
		$this->redirect($this->referer());
	}

	//編集機能
	function quiz_update($id){
		if(!empty($id)){//①これから編集
			$result = $this->AutoQuiz->findById($id);
			$this->set('quiz',$result);
		}else{
			if($this->request->is('post')){//②編集終わり
				$this->AutoQuiz->save($this->request->data);
				$this->redirect(array("action" => "user_note"));
			}else{//url直うち
				$this->redirect("index");
			}
		}
	}
	
	//自動生成機能
	function quiz_update_auto(){
		$this->set('title_for_layout', $this->title_for_layout.'create');//タイトル

		//直リンク回避
		// if(empty($this->request->data['AutoQuiz']['creator_id'])){
		// 	$this->redirect('index');
		// }else{
		// 	$this->set('info', $this->request->data['AutoQuiz']);	
		// }
		//pr($this->request->data);
		//入力後処理
		if(!empty($this->request->data['AutoQuiz']['sentence'])&&
			!empty($this->request->data['AutoQuiz']['right_answer'])){
			//型合わせ
			$this->request->data['sentence'] = $this->request->data['AutoQuiz']['sentence'];
			$this->request->data['right_answer'] = $this->request->data['AutoQuiz']['right_answer'];
			$this->request->data['end_of_sentence'] = $this->request->data['AutoQuiz']['end_of_sentence'];
			$this->request->data['settime'] = $this->request->data['AutoQuiz']['settime'];
			
			
			//[選択肢自動生成]
			//1st:誤回答DB -> 2nd:既存問題DB -> 3rd:wikipedia
			if(empty($this->request->data['flag'])){//初回
				//誤回答DBに登録情報確認
				$data = $this->AutoWrong->find('all', array( 'conditions' => 
					array('AutoWrong.parent_word' => $this->request->data['right_answer']),
					'order' => array("AutoWrong.weight DESC")
					));
				// //スイッチ
				// if(!empty($data)){
				// 	$flag = 1;
				// }else{
				// 	$flag = 2;
				// }

				//誤回答DBに単語が登録されている場合
				if(!empty($data)){//[1st: 誤回答]
					//選択肢２つ
					for($i=0; $i < 2 ; $i++) { //2回ループ
						$output['multi']['option'][] = $data[$i]["AutoWrong"]["word"].":".$data[$i]["AutoWrong"]["weight"];
						unset($data[$i]);
					}
					//３つ目の選択肢 重みが４つ目以降と同じ場合はランダム
					if($data[$i]["AutoWrong"]["weight"] - $data[$i+1]["AutoWrong"]["weight"] <= 1){
						for($n=3; $n < count($data); $n++){//
							if($data[$n]["AutoWrong"]["weight"] - $data[$n+1]["AutoWrong"]["weight"] >= 1)break;
						}
						$new_i = mt_rand(2, $n);
						$output['multi']['option'][] = $data[$new_i]["AutoWrong"]["word"]/*.":".$data[$new_i]["AutoWrong"]["weight"]*/;
					}
					//対象概念
					$output['class'] = "誤回答";
				//登録されていない場合
				}else{

					//既存問題DBに登録情報確認
					$data = $this->Problem->find('all', array( 'conditions' => 
					array('Problem.validityFlag' => 5,
							'Problem.contentType' => 1,
							'or' => array(
								array('Problem.choice1 like' => "%".$this->request->data['right_answer']."%"),
								array('Problem.choice2 like' => "%".$this->request->data['right_answer']."%"),
								array('Problem.choice3 like' => "%".$this->request->data['right_answer']."%"),
								array('Problem.choice4 like' => "%".$this->request->data['right_answer']."%")
							)
						)
					));
					if(!empty($data)){//[2nd: 既存問題]
						//全ての選択肢を集約
						foreach ($data as $key => $value) {
							// if($value["Problem"]["choice1"] != $this->request->data['right_answer'] &&
							// 	$value["Problem"]["choice2"] != $this->request->data['right_answer'] &&
							// 	$value["Problem"]["choice3"] != $this->request->data['right_answer'] &&
							// 	$value["Problem"]["choice4"] != $this->request->data['right_answer']){
							// }
							$tmp_options[] = $value["Problem"]["choice1"];
							$tmp_options[] = $value["Problem"]["choice2"];
							$tmp_options[] = $value["Problem"]["choice3"];
							$tmp_options[] = $value["Problem"]["choice4"];
						}
						shuffle($tmp_options); //ランダムにする
						$output['multi']['option'][] = $tmp_options[0];
						$output['multi']['option'][] = $tmp_options[1];
						$output['multi']['option'][] = $tmp_options[2];

						//対象概念
						$output['class'] = "過去問題";
					}else{//[3rd: 外部API]

							$sentence = $this->request->data['sentence'];
						$url = "http://jlp.yahooapis.jp/MAService/V1/parse?appid=fwwK2g6xg67iIgoKhY3qoXo5rLV.sX5siuZpT.E.j5eQjeMWdJtcYvSWZHO9Cyw-&sentence=".$sentence;
						$xml =  simplexml_load_file($url);
						foreach ($xml->ma_result->word_list->word as $key => $value) {
							if((string)$value->pos === "名詞"){
								$surface[] = (string)$value->surface;
							}
						}
						$tmp_options = $this->onto($this->request->data['right_answer'],$surface); //wikipediaオントロジー
						//選択肢を入れこむ
						if(!empty($tmp_options['option'][0]) &&
							!empty($tmp_options['option'][1]) &&
							!empty($tmp_options['option'][2])){
							$output['multi']['option'][] = $tmp_options['option'][0];
							$output['multi']['option'][] = $tmp_options['option'][1];
							$output['multi']['option'][] = $tmp_options['option'][2];
						}
						//対象概念
						if($tmp_options['class'])$output['class'] = $tmp_options['class'];
					}
				}

				//問題情報整形-一問一答形式
				$output['one']['sentence'] = $this->request->data['sentence'].$this->request->data['end_of_sentence'];
				if(empty($tmp_options['keyword'])){
					$output['one']['right_answer'] = $this->request->data['right_answer'];
					$output['multi']['option'][] = $this->request->data['right_answer'];
				}else{
					$output['one']['right_answer'] = $tmp_options['keyword'];
					$output['multi']['option'][] = $tmp_options['keyword'];
				}
				//$this->request->data['answer']
				//問題情報整形-多肢選択形式
				$output['multi']['sentence'] = $this->request->data['sentence']."を選びなさい。";
				//$output['multi']['option'][] = $tmp_options['keyword']; //正答選択肢
				$this->set('info',$this->request->data['AutoQuiz']);

				$quiz['AutoQuiz']['id'] = $this->request->data['AutoQuiz']['id'];
				$quiz['AutoQuiz']['sentence'] = $output['multi']['sentence'];
				$quiz['AutoQuiz']['option1'] = $output['multi']['option'][0];
				$quiz['AutoQuiz']['option2'] = $output['multi']['option'][1];
				$quiz['AutoQuiz']['option3'] = $output['multi']['option'][2];
				$quiz['AutoQuiz']['right_answer'] = $this->request->data['AutoQuiz']['right_answer'];
				$quiz['AutoQuiz']['description'] = $this->request->data['AutoQuiz']['description'];
				$quiz['AutoQuiz']['settime'] = $this->request->data['AutoQuiz']['settime'];
				
				$this->set('quiz',$quiz);
			}else{
				//Data is Empty
			}
		}else{//二回目以降

		}
	}

	//jquery.postによるAJAX
	function quiz_update_post(){
		if(!empty($this->request->data['edit_mes'])){
			$input['AutoQuiz']['id'] = $this->request->data['edit_id'];
			switch ($this->request->data['edit_col']){
				case '設問':
					$input['AutoQuiz']['sentence'] = trim($this->request->data['edit_mes']);
					break;
				case '選択肢1':
					$input['AutoQuiz']['option1'] = trim($this->request->data['edit_mes']);
					break;
				case '選択肢2':
					$input['AutoQuiz']['option2'] = trim($this->request->data['edit_mes']);
					break;
				case '選択肢3':
					$input['AutoQuiz']['option3'] = trim($this->request->data['edit_mes']);
					break;
				case '正答':
					$input['AutoQuiz']['right_answer'] = trim($this->request->data['edit_mes']);
					break;
				default:
					break;
			}
			$this->AutoQuiz->save($input);
		}
	}

	function output_pdf(){
		// Content-Type
		$this->RequestHandler->respondAs('application/pdf');
		// レイアウトを使用しない
		$this->layout = '';

		$quiz = $this->AutoQuiz->find_creator('all',7); //3級=5, 2級=9 1級=7
		//$quiz = $this->AutoQuiz->find('all',array('conditions' => array('AutoQuiz.exam_id'  => $id)));
		$this->set('quiz',$quiz);
	}

	/**
	下書き
	**/
	//下書き作問
	function draft_create(){}

	//Excel等からインポート
	function draft_import(){
		if(!empty($this->request->data['AutoQuiz']['contents'])){
			$tmp = $this->request->data['AutoQuiz']['contents'];
			$contents = explode("\n", $tmp); //改行 で設問毎に区切る
			//$contents = preg_split("[\n|\t]", $tmp); //改行 とタブで設問毎に区切る

			foreach ($contents as $key => $value){
				$quiztmp = explode("\t", $value); //タブで設問と正答に区切る
				//問題文
				$quiztmp[0] = mb_convert_encoding($quiztmp[0], "UTF-8", "auto");
				$quiz[$key]['sentence'] = $quiztmp[0];
				//正答
				$quiztmp[1] = mb_convert_encoding($quiztmp[1], "UTF-8", "auto");
				$quiz[$key]['right_answer'] = $quiztmp[1];

				// $quiztmp[2] = mb_convert_encoding($quiztmp[2], "UTF-8", "auto");
				// $quiz[$key]['option1'] = $quiztmp[2];

				// $quiztmp[3] = mb_convert_encoding($quiztmp[3], "UTF-8", "auto");
				// $quiz[$key]['option2'] = $quiztmp[3];

				// $quiztmp[4] = mb_convert_encoding($quiztmp[4], "UTF-8", "auto");
				// $quiz[$key]['option3'] = $quiztmp[4];
				//解説
				$quiztmp[2] = mb_convert_encoding($quiztmp[2], "UTF-8", "auto");
				$quiz[$key]['discription'] = $quiztmp[2];
			}
			$this->set("quiz",$quiz);
		}
	}

	//下書き確定
	function draft_submit(){
		if(isset($this->request->data['AutoQuiz']['right_answer'])){
			if($this->request->data['AutoQuiz']['flag'] != "submit"){//②一覧表示
				//空の配列を削除
				$this->request->data['AutoQuiz']['sentence'] = array_values(array_filter($this->request->data['AutoQuiz']['sentence'],"strlen"));
				//$this->request->data['AutoQuiz']['option1'] = array_values(array_filter($this->request->data['AutoQuiz']['option1'],"strlen"));
				//$this->request->data['AutoQuiz']['option2'] = array_values(array_filter($this->request->data['AutoQuiz']['option2'],"strlen"));
				//$this->request->data['AutoQuiz']['option3'] = array_values(array_filter($this->request->data['AutoQuiz']['option3'],"strlen"));				
				$this->request->data['AutoQuiz']['right_answer'] = array_values(array_filter($this->request->data['AutoQuiz']['right_answer'],"strlen"));
				$this->request->data['AutoQuiz']['description'] = array_values(array_filter($this->request->data['AutoQuiz']['description'],"strlen"));
				$sentence = $this->request->data['AutoQuiz']['sentence'];
				$right_answer = $this->request->data['AutoQuiz']['right_answer'];
				if(count($sentence) != 0 && count($right_answer) != 0){
					$this->set("quiz",$this->request->data);
				}
			}else{//③確定 save
				$scount = count($this->request->data['AutoQuiz']["sentence"]);
				for($i=0; $i < $scount; $i++)$this->AutoQuiz->prequiz_save($this->request->data,$i); //下書き保存 * 作問した数
				$this->redirect("./user_note");
			}
		}
	}


	/**
	本機能 
	**/
	//パターン
	public function edit_end_word($sentence,$pattern,$add_word){
		if (preg_match('/'.$pattern[0].'/', $sentence)){ //書きなさい
			$tmp = explode($pattern[0], $sentence);
			$tmp_sentence = $tmp[0].$add_word;

			if (preg_match('/'.$pattern[1].'/', $tmp_sentence)){ //漢字で
				$tmp = explode($pattern[1], $tmp_sentence);
				$tmp_sentence = $tmp[0].$tmp[1];

				//$pattern以前に文章が完結している場合は文末をカット
				if(preg_match('/。'.$add_word.'/', $tmp_sentence)){
					$tmp_sentence = $tmp[0];
				}
				return $tmp_sentence;
			}else{
				return $tmp_sentence;
			}
		}else{
				return $sentence;
		}
	}


	function index(){
		$group = $this->AutoGroup->find_plus_gur(); //グループ＆ユーザリレーション情報を取得
		$this->set("group",$group);
	}



	//データ入力用 非公開 としよう
	function input(){
		$this->set('title_for_layout', $this->title_for_layout.'input');
		if(!empty($this->request->query['user_id']) == "n0bisuke"){
			// if($this->request->data['datas']){
			// 	foreach ($this->request->data['datas'] as $key => $value) {
			// 		$tmp['AutoWrong']["id"] = null;
			// 		$tmp['AutoWrong']["parent_word"] = "（ハル）";
			// 		$value2 = explode(":", $value);
			// 		$tmp['AutoWrong']["word"] = $value2[0];
			// 		$tmp['AutoWrong']["weight"] = $value2[1];
			// 		$this->AutoWrong->save($tmp);
			// 	}
			// }
		}else{
			$this->redirect("./");
		}
	}

	


	//自動生成エンジン
	function create(){
		$this->set('title_for_layout', $this->title_for_layout.'create');//タイトル

		//直リンク回避
		if(empty($this->request->data['AutoQuiz']['creator_id'])){
			$this->redirect('index');
		}else{
			$this->set('info', $this->request->data['AutoQuiz']);	
		}
		
		//入力後処理
		if(!empty($this->request->data['AutoQuiz']['sentence'])&&
			!empty($this->request->data['AutoQuiz']['answer'])){
			//型合わせ
			$this->request->data['sentence'] = $this->request->data['AutoQuiz']['sentence'];
			$this->request->data['answer'] = $this->request->data['AutoQuiz']['answer'];
			$this->request->data['end_of_sentence'] = $this->request->data['AutoQuiz']['end_of_sentence'];
			$this->request->data['settime'] = $this->request->data['AutoQuiz']['settime'];
			
			
			//[選択肢自動生成]
			//1st:誤回答DB -> 2nd:既存問題DB -> 3rd:wikipedia
			if(empty($this->request->data['flag'])){//初回
				//誤回答DBに登録情報確認
				$data = $this->AutoWrong->find('all', array( 'conditions' => 
					array('AutoWrong.parent_word' => $this->request->data['answer']),
					'order' => array("AutoWrong.weight DESC")
					));
				// //スイッチ
				// if(!empty($data)){
				// 	$flag = 1;
				// }else{
				// 	$flag = 2;
				// }

				//誤回答DBに単語が登録されている場合
				if(!empty($data)){//[1st: 誤回答]
					//選択肢２つ
					for($i=0; $i < 2 ; $i++) { //2回ループ
						$output['multi']['option'][] = $data[$i]["AutoWrong"]["word"].":".$data[$i]["AutoWrong"]["weight"];
						unset($data[$i]);
					}
					//３つ目の選択肢 重みが４つ目以降と同じ場合はランダム
					if($data[$i]["AutoWrong"]["weight"] - $data[$i+1]["AutoWrong"]["weight"] <= 1){
						for($n=3; $n < count($data); $n++){//
							if($data[$n]["AutoWrong"]["weight"] - $data[$n+1]["AutoWrong"]["weight"] >= 1)break;
						}
						$new_i = mt_rand(2, $n);
						$output['multi']['option'][] = $data[$new_i]["AutoWrong"]["word"]/*.":".$data[$new_i]["AutoWrong"]["weight"]*/;
					}
					//対象概念
					$output['class'] = "誤回答";
				//登録されていない場合
				}else{

					//既存問題DBに登録情報確認
					$data = $this->Problem->find('all', array( 'conditions' => 
					array('Problem.validityFlag' => 5,
							'Problem.contentType' => 1,
							'or' => array(
								array('Problem.choice1 like' => "%".$this->request->data['answer']."%"),
								array('Problem.choice2 like' => "%".$this->request->data['answer']."%"),
								array('Problem.choice3 like' => "%".$this->request->data['answer']."%"),
								array('Problem.choice4 like' => "%".$this->request->data['answer']."%")
							)
						)
					));
					if(!empty($data)){//[2nd: 既存問題]
						//全ての選択肢を集約
						foreach ($data as $key => $value) {
							// if($value["Problem"]["choice1"] != $this->request->data['answer'] &&
							// 	$value["Problem"]["choice2"] != $this->request->data['answer'] &&
							// 	$value["Problem"]["choice3"] != $this->request->data['answer'] &&
							// 	$value["Problem"]["choice4"] != $this->request->data['answer']){
							// }
							$tmp_options[] = $value["Problem"]["choice1"];
							$tmp_options[] = $value["Problem"]["choice2"];
							$tmp_options[] = $value["Problem"]["choice3"];
							$tmp_options[] = $value["Problem"]["choice4"];
						}
						shuffle($tmp_options); //ランダムにする
						$output['multi']['option'][] = $tmp_options[0];
						$output['multi']['option'][] = $tmp_options[1];
						$output['multi']['option'][] = $tmp_options[2];

						//対象概念
						$output['class'] = "過去問題";
					}else{//[3rd: 外部API]

							$sentence = $this->request->data['sentence'];
						$url = "http://jlp.yahooapis.jp/MAService/V1/parse?appid=fwwK2g6xg67iIgoKhY3qoXo5rLV.sX5siuZpT.E.j5eQjeMWdJtcYvSWZHO9Cyw-&sentence=".$sentence;
						$xml =  simplexml_load_file($url);
						foreach ($xml->ma_result->word_list->word as $key => $value) {
							if((string)$value->pos === "名詞"){
								$surface[] = (string)$value->surface;
							}
						}
						$tmp_options = $this->onto($this->request->data['answer'],$surface); //wikipediaオントロジー
						//選択肢を入れこむ
						if(!empty($tmp_options['option'][0]) &&
							!empty($tmp_options['option'][1]) &&
							!empty($tmp_options['option'][2])){
							$output['multi']['option'][] = $tmp_options['option'][0];
							$output['multi']['option'][] = $tmp_options['option'][1];
							$output['multi']['option'][] = $tmp_options['option'][2];
						}
						//対象概念
						if($tmp_options['class'])$output['class'] = $tmp_options['class'];
					}
				}

				//問題情報整形-一問一答形式
				$output['one']['sentence'] = $this->request->data['sentence'].$this->request->data['end_of_sentence'];
				if(empty($tmp_options['keyword'])){
					$output['one']['answer'] = $this->request->data['answer'];
					$output['multi']['option'][] = $this->request->data['answer'];
				}else{
					$output['one']['answer'] = $tmp_options['keyword'];
					$output['multi']['option'][] = $tmp_options['keyword'];
				}
				//$this->request->data['answer']
				//問題情報整形-多肢選択形式
				$output['multi']['sentence'] = $this->request->data['sentence']."を選びなさい。";
				//$output['multi']['option'][] = $tmp_options['keyword']; //正答選択肢
				$this->set('info',$this->request->data['AutoQuiz']);
				$this->set('output',$output);
			}else{
				//Data is Empty
			}
		}else{//二回目以降

		}
	}

	function check(){
		if(empty($this->request->data['check'])){
			$this->set("data",$this->request->data);
		}else{ //かくていを押した．
			
		}
	}
	function checksave(){
		//pr($this->request->data);
			for($i = 0; $i < 3; $i++){
				
				$data = $this->AutoWrong->find("first",	array('conditions'
					=> array('AutoWrong.parent_word' => $this->request->data['one']['answer'],
						'AutoWrong.word' => $this->request->data['multi']['option'][$i]
						)));
				if($data){//DBに既にある場合は
					$savedata["AutoWrong"]['id'] = $data["AutoWrong"]['id'];
					$savedata["AutoWrong"]['parent_word'] = $this->request->data['one']['answer'];
					$savedata["AutoWrong"]['word'] = $this->request->data['multi']['option'][$i];
					$savedata["AutoWrong"]['weight'] = $data["AutoWrong"]['weight'] + 1;
					$this->AutoWrong->save($savedata);
					$last_id = $savedata["AutoWrong"]['id'];
				}else{//DBに未登録なら登録
					$savedata["AutoWrong"]['id'] = null;
					$savedata["AutoWrong"]['parent_word'] = $this->request->data['one']['answer'];
					$savedata["AutoWrong"]['word'] = $this->request->data['multi']['option'][$i];
					$this->AutoWrong->save($savedata);
					$last_id = $this->AutoWrong->getLastInsertID();
				}

				$saveclass["AutoClass"]['id'] = null;
				$saveclass["AutoClass"]['name'] = $this->request->data['class'];
				$saveclass["AutoClass"]['word_id'] = $last_id;
				$this->AutoClass->save($saveclass);

				$savequiz['AutoQuiz']['sentence'] = $this->request->data['multi']['sentence'];
				$savequiz['AutoQuiz']['option1'] = $this->request->data['multi']['option'][0];
				$savequiz['AutoQuiz']['option2'] = $this->request->data['multi']['option'][1];
				$savequiz['AutoQuiz']['option3'] = $this->request->data['multi']['option'][2];
				$savequiz['AutoQuiz']['right_answer'] = $this->request->data['multi']['option'][3];
				$savequiz['AutoQuiz']['exam_id'] = $this->request->data['exam_id'];
				$savequiz['AutoQuiz']['group_id'] = $this->request->data['group_id'];
				$savequiz['AutoQuiz']['creator_id'] = $this->request->data['creator_id'];
				$savequiz['AutoQuiz']['maketime'] = $this->request->data['settime'];
				$savequiz['AutoQuiz']['selecttime'] = $this->request->data['settime2'];
				
				$savequiz['AutoQuiz']['type'] = 0;
				
				$this->AutoQuiz->save($savequiz);
			}
			$this->redirect("http://sakumon.jp/app/maker/auto/group_top/37");
	}
	
	function wiki(){
		$keyword = "仙台";
		$keyword = mb_convert_encoding($keyword, 'UTF-8', 'auto');
		$keyword = urlencode($keyword);
		$url = "http://ja.wikipedia.org/wiki/%E7%89%B9%E5%88%A5:%E3%83%87%E3%83%BC%E3%82%BF%E6%9B%B8%E3%81%8D%E5%87%BA%E3%81%97/".$keyword;
		$xml = simplexml_load_file($url);
		pr($xml);
	}

	function wikionto(){
		header("Content-type: text/html; charset=utf-8");
		
		$surface = array("久慈市","舞台","朝","テレビ","小説","脚本家","名前");

		$keyword = "宮藤官九郎";
		pr($keyword);
		$result = $this->onto($keyword,$surface);
		if($result){
			pr($result);
		}else{
			pr("error");
		}

	}

	//キーワードを補正する
	public function revision($keyword){
		//キーワードをグーグル検索
		$google_api_key = "AIzaSyBHsm2w601cvHTC611GySLfKJbS4d_5rTI";
		//$google_api_key = "AIzaSyClhN56AyvZtM-59cLCcvcqWXy2xj41mEs";
		$google_search_id = "002032689784564599474:4sqff_jkexm";
		//$google_search_id = "002032689784564599474:7tfugap97zy";
		$url = "https://www.googleapis.com/customsearch/v1?key=".$google_api_key.
		"&cx=".$google_search_id.
		"&q=wiki+".$keyword.
		"&alt=json&hl=ja";
		$json = file_get_contents($url);
		$dec_arr=json_decode($json,true);
		//pr($dec_arr);
		//wikipedia情報で判定
		$judge_url = "ja.wikipedia.org"; 
		foreach ($dec_arr['items'] as $key => $value) {
			if($value['displayLink'] === $judge_url){
				$tmp = explode("/", $value['formattedUrl']);
				$revision_keywords[] = end($tmp);
			}
		}
		//shuffle($revision_keywords);//しゃっふる
		$revision_keyword = $revision_keywords[0];
		return $revision_keyword;
	}

	//オントロジーから検索
	public function onto($keyword,$surface,$flag=0){
		//検索開始 データ整形(json) ①
		$keyword = mb_convert_encoding($keyword, 'UTF-8', 'auto');
		$en_keyword = urlencode($keyword);
		$json = file_get_contents("http://www.wikipediaontology.org/data/instance/".$en_keyword.".json");

		if($json != "{}"){//wikiontologyにワードがあれば。
			$json = str_replace('"\n  ",',"",$json);//謎の改行を削除
			$dec_arr=json_decode($json,true);
			$new_array = array_values($dec_arr[3]);
			//単語に関する概念を抽出 ②
			$data = array();
			foreach ($new_array as $key => $value) {
				if(!empty($value[0]) && $value[0] == "rdf:type" || //クラス
					!empty($value[0]) && $value[0] == "jwo:hyper"){ //上位概念
					$data[] = str_replace('http://www.wikipediaontology.org/class/',"",$value[1]["rdf:resource"]);//単語抽出
				}
			}
			//スクレイピング失敗時は似ている単語で再検出 2.5
			if($data == null){
				foreach ($new_array as $key => $value) {
					if(!empty($value[0]) && $value[0] == "jwo:nearly"){
						$kword = str_replace('http://www.wikipediaontology.org/instance/',"",$value[1]["rdf:resource"]);//単語抽出
						return $this->onto($kword,$surface); //再検索
					}
				}
			}else{
				//検索する概念を選定 ③ 問題文に含まれる名詞情報に一致する概念はどれか
				foreach ($data as $key => $value) {
					foreach ($surface as $key2 => $value2) {
						//概念名[]に対して単語[]を比較
						if (mb_strpos($value, $value2) === FALSE) {
							
						}else{
							$class[] = $value;
						}
					}
				}
				if(empty($class)){ //問題文と一致する概念が無い
					shuffle($data); //ランダム
					$class_result = $data[0];
				}else{
					shuffle($class);
					$class_result = $class[0];
				}

				// pr($data);
				// pr($class);
				// pr($surface);
				// pr($class_result);

				//関連ワードを抽出(スクレイピング) ④
				$html = file_get_contents("http://www.wikipediaontology.org/pages/list/".$class_result);
				$tmp = explode("Instance:", strip_tags($html));
				foreach ($tmp as $key => $value) {
					if($key==0)continue; //整形
					if($key== count($tmp)-1){//整形
						$vtmp = explode("RDF", $value);
		            	$words[] = trim($vtmp[0]);
					}else{
						$words[] = $value;
					}
				}
				
				//ワードを3つ推薦 ⑤
				shuffle($words); //しゃっふる

				$result = array("class" => $class_result,
					"option" => array($words[0],$words[1],$words[2]),
					"keyword" => $keyword
					);
				return $result;
			}
		}else{//ワードがそんざいしない
			if($flag == 0){//一回だけ補正を掛けて再検索
				$keyword = $this->revision($keyword); //補正
				$flag = 1;
				return $this->onto($keyword,$surface); //再検索
			}else{//二回目はエラーを返す
				return false;
			}
		}
	}
	// function index(){
	// 			$this->set('title_for_layout', $this->title_for_layout.'index');
	// 	$output = $this->Problem->find('list',
	// 			array( 'conditions' => 
	// 				array('Problem.grade' => 1,
	// 					'and' => array(
	// 						array('Problem.sentence like' => "%書きなさい%")
	// 						// array('Problem.sentence not like' => "%書きなさい%"),
	// 						// array('Problem.sentence not like' => "%どれですか%"),
	// 						// array('Problem.sentence not like' => "%だれですか%"),
	// 						// array('Problem.sentence not like' => "%誰ですか%"),
	// 						// array('Problem.sentence not like' => "%何ですか%"),
	// 						// array('Problem.sentence not like' => "%なんですか%"),
	// 						// array('Problem.sentence not like' => "%どこですか%"),
	// 						// array('Problem.sentence not like' => "%のはどこ%"),
	// 						// array('Problem.sentence not like' => "%いつですか%")
	// 					)
	// 				),
	// 			// 'order' => array("AutoWrong.weight DESC")
	// 			'fields' => Array('Problem.sentence')
	// 			));
	// 	//変更したい文末表現
	// 	$pattern[] = "書きなさい";
	// 	$pattern[] = "漢字で";
		
	// 	//最終的な分末表現
	// 	$add_word = "選びなさい。";
	// 	$i=1;
	// 	foreach ($output as $key => $value) {
	// 		$output[$key] = str_replace(array("\r\n","\r","\n"), '', $output[$key]); //改行コードを削除
	// 		$output[$key] = $this->edit_end_word($output[$key], $pattern,$add_word);
	// 		$output[$key] = $i .":".$output[$key];
	// 		$i++;
	// 	}
	// 	$this->set('output',$output);
	// }
}
?>