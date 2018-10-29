<?php
App::uses('AppModel', 'Model');
class Order extends AppModel {

//////////////////////////////////////////////////

    public $validate = array(
        'name' => array(
            'rule1' => array(
                'rule' => array('notempty'),
                'message' => 'Name is invalid',
            ),
        ),
        'email' => array(
            'rule1' => array(
                'rule' => array('email'),
                'message' => 'Email is invalid',
            ),
        )
		, 
        'billing_address' => array(
            'rule1' => array(
                'rule' => array('notempty'),
                'message' => 'Billing Address is invalid',
            ),
        ),
        'billing_city' => array(
            'rule1' => array(
                'rule' => array('notempty'),
                'message' => 'Billing City is invalid',
            ),
        ),
        'billing_state' => array(
            'rule1' => array(
                'rule' => array('notempty'),
                'message' => 'Billing State is invalid',
            ),
        ),
  
    );

//////////////////////////////////////////////////

    public $hasMany = array(
 
        'OrderItem' => array(
            'className' => 'OrderItem',
            'foreignKey' => 'order_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => '',
        )
    );

//////////////////////////////////////////////////

}
