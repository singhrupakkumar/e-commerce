<?php
App::uses('AppModel', 'Model');
class Woodtype extends AppModel {

////////////////////////////////////////////////////////////

    public $order = array('Woodtype.name' => 'ASC');

////////////////////////////////////////////////////////////

    public $validate = array(
        'name' => array(
            'rule1' => array(
                'rule' => array('between', 3, 50),
                'message' => 'Name is required',
                'allowEmpty' => false,
                'required' => false,
            ),
            'rule2' => array(
                'rule' => '/^[0-9a-z\-\ ]{3,50}$/',
                'message' => 'Only lowercase letters, numbers, dashes, spaces, between 3-50 characters',
                'allowEmpty' => false,
                'required' => false,
            ),
            'rule3' => array(
                'rule' => array('isUnique'),
                'message' => 'Name already exists',
                'allowEmpty' => false,
                'required' => false,
            ),
        ),
    );

	
	  public $hasMany = array(
        'Product' => array(
            'className' => 'Product',
            'foreignKey' => 'woodtype_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );

////////////////////////////////////////////////////////////

     public function findList() { 
        return $this->find('list', array( 
            'order' => array(
                'Woodtype.name' => 'ASC' 
            )
        ));
    }
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////

}
