<?php
App::uses('AppModel', 'Model');
class Product extends AppModel {

////////////////////////////////////////////////////////////

    public $validate = array(
        'name' => array( 
            'rule1' => array(
                'rule' => array('between', 3, 100), 
                'message' => 'Name is required',
                'allowEmpty' => false,
                'required' => false,
            ),
            'rule2' => array(
                'rule' => array('isUnique'),
                'message' => 'Name already exists',
                'allowEmpty' => false,
                'required' => false,
            ),
        ),
        'slug' => array(
            'rule1' => array(
                'rule' => array('between', 3, 100),
                'message' => 'Slug is required',
                'allowEmpty' => false,
                'required' => false,
            ),
            
            'rule3' => array(
                'rule' => array('isUnique'),
                'message' => 'Slug already exists',
                'allowEmpty' => false,
                'required' => false,
            ),
        ),
        'price' => array(
            'notempty' => array(
                'rule' => array('decimal'),
                'message' => 'Price is invalid',
                //'allowEmpty' => false,
                //'required' => true,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'weight' => array(
            'notempty' => array(
                'rule' => array('decimal'),
                'message' => 'Weight is invalid',
                //'allowEmpty' => false,
                //'required' => true,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

    
    public $hasMany = array(
        'Productmod',
        'Review' => array(
            'className' => 'Review',
            'foreignKey' => 'product_id',
            'dependent' => false, 
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Gallary' => array(
            'className' => 'Gallary', 
            'foreignKey' => 'product_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        )
    );
////////////////////////////////////////////////////////////

    public $belongsTo = array(
        'Category' => array(
            'className' => 'Category',
            'foreignKey' => 'category_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ),
        'Brand' => array(
            'className' => 'Brand',
            'foreignKey' => 'brand_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ),
		'Series' => array(
            'className' => 'Series',
            'foreignKey' => 'series',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        )
        ,
		'Woodtype' => array(
            'className' => 'Woodtype', 
            'foreignKey' => 'woodtype_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ),
        'Colour' => array(
            'className' => 'Colour', 
            'foreignKey' => 'colour_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ),
        'Theme' => array(
            'className' => 'Theme', 
            'foreignKey' => 'theme_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        )
        ,
        'Style' => array(
            'className' => 'Style', 
            'foreignKey' => 'style_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        )
         ,
        'Material' => array(
            'className' => 'Material',  
            'foreignKey' => 'material_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        )
         ,
        'Gemstone' => array(
            'className' => 'Gemstone', 
            'foreignKey' => 'gemstone_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        )
		,
        'Mechanism' => array(
            'className' => 'Mechanism', 
            'foreignKey' => 'mechanism_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        )
  
    ); 

////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////

    public function updateViews($products) {

        if(!isset($products[0])) {
            $a = $products;
            unset($products);
            $products[0] = $a;
        }

        $this->unbindModel(
            array('belongsTo' => array('Category', 'Brand','Theme','Colour','Style'))   
        );

        $productIds = Set::extract('/Product/id', $products);

        $this->updateAll(
            array(
                'Product.views' => 'Product.views + 1',
            ),
            array('Product.id' => $productIds)
        );


    }

////////////////////////////////////////////////////////////

}