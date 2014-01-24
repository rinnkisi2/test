<?php
class Problem extends Model{
	public $name = 'Problem';

	//問題のキーワード検索
	function find_key($key){
		return $this->find('all', array( 'conditions' => 
		array('Problem.validityFlag' => 5,
				'Problem.contentType' => 1,
				'or' => array( //問題文か選択肢中にキーワードを含むものを検索	
					array('Problem.sentence like' => "%".$key."%"), 
					array('Problem.choice1 like' => "%".$key."%"), 
					array('Problem.choice2 like' => "%".$key."%"),
					array('Problem.choice3 like' => "%".$key."%"),
					array('Problem.choice4 like' => "%".$key."%")
				)
			)
		));
	}

	//API MoridaiControllerで利用　2013/12/9
	public function getselect($grade,$year,$category){
		if($category==null){//過去問題の試験モード 100問程度を返す
			$data = $this->find('all',array('conditions' => array(
				'grade' => $grade,
				'employ' => $year,
				'validityFlag' => 5
				),'order' => 'number ASC' 
			));
		}else{//学習モード 1問を返す
			switch ($category) {
			    case 7: //その他
			        $category_id = 'riq58saxc06sxjy7wozj0yar659ajst0';
			        break;
			    case 6: //盛岡の歴史
			        $category_id = '3x68wkfo8593k7cbfj3g8ilz6dks76vk';
			        break;
			    case 5: //盛岡の先人/著名人
			        $category_id = '6sbj7jlbitzhjdm0wvuo7ccl6qks81cq';
			        break;
			    case 4: //盛岡の文化
			    	$category_id = 'nba4kr2y7rnnwqgpvftpaajvl3uadq33';
			        break;
			    case 3: //盛岡の産業
			        $category_id = 'unqgao4b1w4z3dxp5r1s4f0fnpa262kj';
			        break;
			    case 2: //盛岡の気候と地理
			    	$category_id = '0ipsv5scr1j0xur13whmsd2uu8d7pfnv';
			        break;
			    case 1: //盛岡の現在
			    	$category_id = 'w1d19ufgah6oybdbdemo66o55rjivx0t';
			        break;
			}
			$data = $this->find('first',array('conditions' => array(
				'grade' => $grade,
				'employ' => $year,
				'categoryId' => $category_id,
				'validityFlag' => 5
				),
				'order' => 'rand()'
			));
		}

		if(!empty($data)){
			//MoridaiQuestionにフォーマットをあわせる
			if($category == null){//試験モード
				foreach ($data as $key => $value) {

					//カテゴリの調整
					switch ($value['Problem']['categoryId']) {
					    case 'riq58saxc06sxjy7wozj0yar659ajst0':
					        $name = "その他";
					        $category_id = 7;
					        break;
					    case '3x68wkfo8593k7cbfj3g8ilz6dks76vk':
					        $name = "盛岡の歴史";
					        $category_id = 6;
					        break;
					    case '6sbj7jlbitzhjdm0wvuo7ccl6qks81cq':
					        $name = "盛岡の先人/著名人";
					        $category_id = 5;
					        break;
					    case 'nba4kr2y7rnnwqgpvftpaajvl3uadq33':
					    	$name = "盛岡の文化";
					    	$category_id = 4;
					        break;
					    case 'unqgao4b1w4z3dxp5r1s4f0fnpa262kj':
					        $name = "盛岡の産業";
					        $category_id = 3;
					        break;
					    case '0ipsv5scr1j0xur13whmsd2uu8d7pfnv':
					    	$name = "盛岡の気候と地理";
					    	$category_id = 2;
					        break;
					    case 'w1d19ufgah6oybdbdemo66o55rjivx0t':
					    	$name = "盛岡の現在";
					    	$category_id = 1;
					        break;
					}
					$data[$key]['MoridaiQuestion']['category_name'] = $name;

					$data[$key]['MoridaiQuestion']['id'] = $value['Problem']["id"];
					$data[$key]['MoridaiQuestion']['question'] = $value['Problem']["sentence"];
					if($value['Problem']['contentType'] == 1){//選択式
						$data[$key]['MoridaiQuestion']['option1'] = $value['Problem']["choice1"];
						$data[$key]['MoridaiQuestion']['option2'] = $value['Problem']["choice2"];
						$data[$key]['MoridaiQuestion']['option3'] = $value['Problem']["choice3"];
						$data[$key]['MoridaiQuestion']['option4'] = $value['Problem']["choice4"];
						$data[$key]['MoridaiQuestion']['right_answer'] = $value['Problem']["answerChoice"];
						$data[$key]['MoridaiQuestion']['format'] = "multiple-choice";
					}else{//記述式
						$data[$key]['MoridaiQuestion']['right_answer'] = $value['Problem']["exsampleAnswer"];
						$data[$key]['MoridaiQuestion']['format'] = "single-choice";
					}
					$data[$key]['MoridaiQuestion']['description'] = "この問題に解説はありません";
					$data[$key]['MoridaiQuestion']['category_id'] = $category_id;
					$data[$key]['MoridaiQuestion']['quiz_type'] = "public";
					
					
					
					unset ($data[$key]['Problem']);
				}
				$output = $data;
			}else{//学習モード
				//pr($data);
				$newdata['MoridaiQuestion']['id'] = $data['Problem']["id"];
				$newdata['MoridaiQuestion']['question'] = $data['Problem']["sentence"];
				if($data['Problem']['contentType'] == 1){//選択式
					$newdata['MoridaiQuestion']['option1'] = $data['Problem']["choice1"];
					$newdata['MoridaiQuestion']['option2'] = $data['Problem']["choice2"];
					$newdata['MoridaiQuestion']['option3'] = $data['Problem']["choice3"];
					$newdata['MoridaiQuestion']['option4'] = $data['Problem']["choice4"];
					$newdata['MoridaiQuestion']['right_answer'] = $data['Problem']["answerChoice"];
					$newdata['MoridaiQuestion']['format'] = "multiple-choice";
				}else{//記述式
					$newdata['MoridaiQuestion']['right_answer'] = $data['Problem']["exsampleAnswer"];
					$newdata['MoridaiQuestion']['format'] = "single-choice";
				}
				$newdata['MoridaiQuestion']['description'] = "この問題に解説はありません";
				$newdata['MoridaiQuestion']['category_id'] = $category;
				$newdata['MoridaiQuestion']['quiz_type'] = "public";
				$output = $newdata;
			}				
		}else{//データが取得できなかった
        	$output['response'] = 'Data is Empty';
		}
		return $output;
	}
}
?>