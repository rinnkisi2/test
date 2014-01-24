<?php
class MoridaiQuestion extends Model{
	public $belongsTo = array(
		'MoridaiCategory' => array(
		'className' => 'MoridaiCategory',
		'foreignKey' => 'category_id',
		/* Post側 連結用カラム名を記述 → 相手Genre側の primary key カラムと連結する */
		'conditions' => '',
		'fields' =>array( 'MoridaiCategory.name'),
		'order' => ''
		)
	);
}
?>