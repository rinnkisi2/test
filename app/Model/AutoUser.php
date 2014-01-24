<?php
class AutoUser extends Model{
	public $name = 'AutoUser';

	public $validate = array(
            'name' => array(
                'notempty' => array(
                    'rule' => array('notempty'),
                    'message' => '文字を入力してください。',
                    //'allowEmpty' => false,
                    //'required' => false,
                    //'last' => false, // Stop validation after this rule
                    //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
                'maxlength' => array(
                    'rule' => array('maxlength',10),
                    'message' => '文字数が多いので、１０文字以下にしてください。',
                    //'allowEmpty' => false,
                    //'required' => false,
                    //'last' => false, // Stop validation after this rule
                    //'on' => 'create', // Limit validation to 'create' or 'update' operations
                    ),
                ),
            	'isUnique' => array(
		            'rule'    => 'isUnique',
		            'message' =>'* 入力された名前は既に登録されています。'
		        ),
            'passwd' => array(
                'notempty' => array(
                    'rule' => array('notempty'),
                    //'message' => 'Your custom message here',
                    //'allowEmpty' => false,
                    //'required' => false,
                    //'last' => false, // Stop validation after this rule
                    //'on' => 'create', // Limit validation to 'create' or 'update' operations
                    ),
                ),
            );
    /**
    ユーザーの情報をゲット
    利用: user_info
    **/
    public function find_info($user_id){
        //ユーザの作問情報を得るためにAutoQuizとバインド
        $hasMany = array(
            'AutoQuiz' => array(
                'className' => 'AutoQuiz',
                'foreignKey' => 'creator_id',
                'conditions' => array(
                    'exam_id !=' => 0 //提出済のもの (試験IDが0でない)
                )
            )
        );
        $this->bindModel(array("hasMany" => $hasMany));
        return $this->findById($user_id);
    }

    /**
    ユーザー
    **/
    public function find_ssinfo($user_id){
        //ユーザの作問情報を得るためにAutoQuizとバインド
        $hasMany = array(
            'AutoQuiz' => array(
                'className' => 'AutoQuiz',
                'foreignKey' => 'creator_id',
            )
        );
        $this->bindModel(array("hasMany" => $hasMany));
        return $this->find('all');
    }
}
?>