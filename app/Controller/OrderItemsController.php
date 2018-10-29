<?php
class OrderItemsController extends AppController {

////////////////////////////////////////////////////////////

    public $scaffold = 'admin';

////////////////////////////////////////////////////////////

    public function admin_view($id = null){
	 
		   if (!$this->OrderItem->exists($id)) {
            throw new NotFoundException('Invalid OrderItem');
        }
        $orderitem = $this->OrderItem->find('first', array(
            'recursive' => -1,
          
            'conditions' => array(
                'OrderItem.id' => $id
            )
        ));
        $this->set(compact('orderitem'));
	 
	 
     }
	 
	 
	   public function admin_edit($id = null){
	 
		   if (!$this->OrderItem->exists($id)) {
            throw new NotFoundException('Invalid OrderItem');
        }
        $orderitem = $this->OrderItem->find('first', array(
            'recursive' => -1,
          
            'conditions' => array(
                'OrderItem.id' => $id
            )
        ));
        $this->set(compact('orderitem'));
	 
	 
     }

}
