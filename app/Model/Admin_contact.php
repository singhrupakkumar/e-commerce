<?php
App::uses('AppModel', 'Model');
/**
 * Dish Model
 *
 * @property Cat $Cat
 * @property n $n
 */
class Admin_contact extends AppModel {

/**
 * Display field
 *
 * @var string
 */
  public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id', 
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),'Product' => array(
			'className' => 'Product',
			'foreignKey' => 'product_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


}
