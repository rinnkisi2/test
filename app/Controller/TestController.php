<?php
/*
 実験
*/

class TestController extends AppController {
	public $name = 'Test'; //class name
	public $uses = array('Problem','TestUser','TestLog','AutoQuiz');
	public $layout = "test";
	public $title_for_layout = "実験システム";
	/****認証周り*****/
	public $components = array(
		//'Session',
		'DebugKit.Toolbar', //デバッグきっと
		'RequestHandler', //PDF作成ツール
		'Auth' => array(
			'authenticate' => array(
				'Form' => array(
					'userModel' => 'TestUser',
					'fields' => array('username' => 'name','password' => 'passwd')
				)
			),
			//ログイン後の移動先
			'loginRedirect' => array('controller' => 'test', 'action' => './index'),
			//ログアウ後の移動先
			'logoutRedirect' => array('controller' => 'test', 'action' => 'add'),
			//ログインページのパス
			'loginAction' => array('controller' => 'test', 'action' => 'login'),
			//未ログイン時のメッセージ
			'authError' => 'あなたのお名前とパスワードを入力して下さい。',
		)
	);

	function beforeFilter(){//login処理の設定
		parent::beforeFilter();//親クラスを継承
	 	$this->Auth->allow('login','logout','add','test_c','miss');//ログインしないで、アクセスできるアクションを登録する
	 	$this->set('user',$this->Auth->user()); // ctpで$userを使えるようにする 。
	}

	//ユーザー追加（認証が不要なページ）
	function add(){
		//POST送信なら
		if($this->request->is('post')) {
			$this->request->data['TestUser']['passwd'] = $this->request->data['TestUser']['name'];
			$this->Session->write('login',$this->request->data);
			//パスワードのハッシュ値変換
			$this->request->data['TestUser']['passwd'] = AuthComponent::password($this->request->data['TestUser']['passwd']);
			
			//ユーザーの作成
			$this->TestUser->create();
			//リクエストデータを保存できたら
			if ($this->TestUser->save($this->request->data)) {
				$this->Session->setFlash(__('新規ユーザーを追加しました'));
			} else { //保存できなかったら
				$this->Session->setFlash(__('登録できませんでした。やり直して下さい'));
			}
			$this->redirect(array('action' => './login'));//リダイレクト	
		}
	}


	function login(){ //ログイン処理
		//POST送信なら
		if($this->request->is('post')){
		
			//ログインOKなら
			if($this->Auth->login()) {
				$this->Session->delete('Auth.redirect'); //前回ログアウト時のリンクを記録させない
				//$this->AutoLog->record(array(),__FUNCTION__); //ログ: ログイン
				return $this->redirect($this->Auth->redirect()); //Auth指定のログインページへ移動
			}else{ //ログインNGなら
				$this->Session->setFlash(__('ユーザ名かパスワードが違います'), 'default', array(), 'auth');
			}
		}else{
			$data = $this->Session->read('login');
			if(empty($data)){
				$this->redirect('add');
			}else{
				$this->set('data',$this->Session->read('login'));
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

	/**
	機能
	**/
	function index(){ //出題
		$quizzes = $this->Problem->find('all',array(
			'conditions' => array(
				'Problem.employ' => 2010,
				'Problem.grade' => 3
			),
			'order' => 'Problem.number ASC'
			));
		$this->Session->write('quizzes',$quizzes);
		$this->set('quizzes', $quizzes);
	}

	function check(){ //確認
		if($this->request->is('post')){
			$quizzes = $this->Session->read('quizzes');
			
			$this->set('quizzes', $quizzes);
			$this->set('check', $this->request->data);
		}
	}

	function result(){ //結果を保存
		if($this->request->is('post')){
			$quizzes = $this->Session->read('quizzes');
			$count = 0;

			//正解数計算
			for ($i=0; $i < 100; $i++){
				$this->TestLog->create();
				if(isset($this->request->data['TestLog']['choice'][$i])){
					if($this->request->data['TestLog']['choice'][$i] == $quizzes[$i]['Problem']['answerChoice']){
						$count++;

						$input['TestLog']['user_id'] = $this->Auth->user('id');
						$input['TestLog']['quiz_id'] = "pre-".($i+1);
						$input['TestLog']['choice'] = $this->request->data['TestLog']['choice'][$i];
						$input['TestLog']['flag'] = 1;	
					}else{
						$input['TestLog']['user_id'] = $this->Auth->user('id');
						$input['TestLog']['quiz_id'] = "pre-".($i+1);

						if(empty($this->request->data['TestLog']['choice'][$i])){
							$input['TestLog']['choice'] = 0;
						}else{
							$input['TestLog']['choice'] = $this->request->data['TestLog']['choice'][$i];
						}
						$input['TestLog']['flag'] = 0;
					}
				}
				$this->TestLog->save($input);
			}

			//点数を記録
			$point['TestUser']['point'] = $count;
			$point['TestUser']['id'] = $this->Auth->user('id');
			$this->TestUser->save($point);

			$this->set('count', $count);
			$this->set('check', $this->request->data);
		}
	}

	function show($type){//タイプを指定 pre,a,b
		$data = $this->TestLog->show_log($type);	
		$this->set("data",$data);
	}

	function group(){
		$data = $this->TestUser->find('all', array('order' => 'TestUser.point DESC'));
		$this->set('data',$data);

		$count = count($data); //データ件数
		foreach ($data as $key => $value) {
			$array = array(
					'name' => $value['TestUser']['name'],
					'point' => $value['TestUser']['point']
					);
			
			if($key % 2 == 0){//偶数
				$group['a'][] = $array;
			}else{//奇数
				$group['b'][] = $array;
			}
		}

		$this->set('group',$group);
	}

	function ranking(){
		$rank = $this->TestUser->find('all', array('order' => 'TestUser.point DESC'));
		$this->set('rank',$rank);
	}

	function ranking_b(){
		$rank = $this->TestUser->find('all', array('order' => 'TestUser.point_b DESC'));
		$this->set('rank',$rank);	
	}

	function hoge(){//2011年度3級
		$quizzes = $this->Problem->find('all',array(
			'conditions' => array(
				'Problem.employ' => 2011,
				'Problem.grade' => 3,

			),
			'order' => 'Problem.number ASC'
			));
		$this->set('quizzes',$quizzes);
	}
	function test_a(){//実験2 - a
		$quizzes = $this->Problem->find('all', array( 'conditions' => 
			array('Problem.employ' => 2011,
					'Problem.grade' => 3,
					'or' => array(
						array('Problem.number' => 1),
						array('Problem.number' => 2),
						array('Problem.number' => 6),
						array('Problem.number' => 7),
						array('Problem.number' => 9),
						array('Problem.number' => 10),
						array('Problem.number' => 13),
						array('Problem.number' => 14),
						array('Problem.number' => 18),
						array('Problem.number' => 19),
						array('Problem.number' => 20),
						array('Problem.number' => 21),
						array('Problem.number' => 22),
						array('Problem.number' => 24),
						array('Problem.number' => 28),
						array('Problem.number' => 29),
						array('Problem.number' => 32),
						array('Problem.number' => 33),
						array('Problem.number' => 36),
						array('Problem.number' => 37),
						array('Problem.number' => 39),
						array('Problem.number' => 40),
						array('Problem.number' => 41),
						array('Problem.number' => 42),
						array('Problem.number' => 45),
						array('Problem.number' => 46),
						array('Problem.number' => 54),
						array('Problem.number' => 56),
						array('Problem.number' => 62),
						array('Problem.number' => 63),
						array('Problem.number' => 64),
						array('Problem.number' => 66),
						array('Problem.number' => 67),
						array('Problem.number' => 69),
						array('Problem.number' => 70),
						array('Problem.number' => 71),
						array('Problem.number' => 72),
						array('Problem.number' => 73),
						array('Problem.number' => 74),
						array('Problem.number' => 75),
						array('Problem.number' => 77),
						array('Problem.number' => 79),
						array('Problem.number' => 80),
						array('Problem.number' => 81),
						array('Problem.number' => 83),
						array('Problem.number' => 84),
						array('Problem.number' => 85),
						array('Problem.number' => 86),
						array('Problem.number' => 89),
						array('Problem.number' => 91),
						array('Problem.number' => 93),
						array('Problem.number' => 100)
							
					)
				),
			'order' => 'Problem.number ASC'
			));
		$this->Session->write('test_a',$quizzes);
		$this->set('quizzes',$quizzes);
	}
	function check_a(){
		if($this->request->is('post')){
			$quizzes = $this->Session->read('test_a');
			
			$this->set('quizzes', $quizzes);
			$this->set('check', $this->request->data);
		}
	}

	function result_a(){
		if($this->request->is('post')){
			$quizzes = $this->Session->read('test_a');
			$count = 0;

			//正解数計算
			for ($i=0; $i < 100; $i++){
				$this->TestLog->create();
				if(isset($this->request->data['TestLog']['choice'][$i])){
					if($this->request->data['TestLog']['choice'][$i] == $quizzes[$i]['Problem']['answerChoice']){
						$count++;

						$input['TestLog']['user_id'] = $this->Auth->user('id');
						$input['TestLog']['quiz_id'] = "a-".($i+1);
						$input['TestLog']['choice'] = $this->request->data['TestLog']['choice'][$i];
						$input['TestLog']['flag'] = 1;	
					}else{
						$input['TestLog']['user_id'] = $this->Auth->user('id');
						$input['TestLog']['quiz_id'] = "a-".($i+1);

						if(empty($this->request->data['TestLog']['choice'][$i])){
							$input['TestLog']['choice'] = 0;
						}else{
							$input['TestLog']['choice'] = $this->request->data['TestLog']['choice'][$i];
						}
						$input['TestLog']['flag'] = 0;
					}
				}
				$this->TestLog->save($input);
			}

			//点数を記録
			$point['TestUser']['point_a'] = $count;
			$point['TestUser']['group'] = "a";
			$point['TestUser']['id'] = $this->Auth->user('id');
			$this->TestUser->save($point);

			$this->set('count', $count);
			$this->set('check', $this->request->data);
		}
	}

	function test_b(){//実験1 
		$quizzes = $this->AutoQuiz->find('all',array(
			'conditions' => array(
				'AutoQuiz.created' => '2013-11-13 12:13:02',
			)//,
			//'order' => 'Problem.number ASC'
			));
		$this->Session->write('test_b',$quizzes);
		$this->set('quizzes',$quizzes);
	}

	function check_b(){
		if($this->request->is('post')){
			$test_b = $this->Session->read('test_b');
			
			$this->set('test_b', $test_b);
			$this->set('check', $this->request->data);
		}
	}

	function result_b(){
		if($this->request->is('post')){
			$quizzes = $this->Session->read('test_b');
			$count = 0;

			//正解数計算
			for ($i=0; $i < 50; $i++){
				$this->TestLog->create();
				if(isset($this->request->data['TestLog']['answer'][$i])){
					if($this->request->data['TestLog']['answer'][$i] == $quizzes[$i]['AutoQuiz']['right_answer']){
						$count++;

						$input['TestLog']['user_id'] = $this->Auth->user('id');
						$input['TestLog']['quiz_id'] = "b-".($i+1);
						$input['TestLog']['choice'] = $this->request->data['TestLog']['answer'][$i];
						$input['TestLog']['flag'] = 1;	
					}else{
						$input['TestLog']['user_id'] = $this->Auth->user('id');
						$input['TestLog']['quiz_id'] = "b-".($i+1);

						if(empty($this->request->data['TestLog']['choice'][$i])){
							$input['TestLog']['choice'] = $this->request->data['TestLog']['answer'][$i];
						}else{
							$input['TestLog']['choice'] = $this->request->data['TestLog']['answer'][$i];
						}
						$input['TestLog']['flag'] = 0;
					}
				}
				$this->TestLog->save($input);
			}

			//点数を記録
			$point['TestUser']['point_b'] = $count;
			$point['TestUser']['group'] = "b";
			$point['TestUser']['id'] = $this->Auth->user('id');
			$this->TestUser->save($point);

			$this->set('count', $count);
			$this->set('check', $this->request->data);
		}
	}

	function test_c(){
		$quizzes = $this->AutoQuiz->find('all',array(
			'conditions' => array(
				'AutoQuiz.created' => '2013-11-13 12:13:02',
			)//,
			//'order' => 'Problem.number ASC'
			));
		$this->Session->write('test_c',$quizzes);
		$this->set('quizzes',$quizzes);
	}

	function miss($id){
		if(!empty($id)){//idがあれば，一件分
			$mis = $this->TestLog->find('all',array(
				'conditions' => array(
					//'TestLog.quiz_id like' => '%b%',
					'TestLog.flag' => '0',
					'TestLog.quiz_id' => 'b-'.$id
				)
			));
			$this->set('mis',$mis);
		}else{
			$mis = $this->TestLog->find('all',array(
				'conditions' => array(
					//'TestLog.quiz_id like' => '%b%',
					'TestLog.flag' => '0',
					'TestLog.quiz_id like' => 'b-%'
				)
			));
			$this->set('misall',$mis);
		}
	}
}
?>