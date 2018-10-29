<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class OrdersController extends AppController {

////////////////////////////////////////////////////////////

    public function admin_index() {

        $this->Paginator = $this->Components->load('Paginator');

        $this->Paginator->settings = array(
            'Order' => array(
                'recursive' => -1,
                'contain' => array(
                ),
                'conditions' => array(
                ),
                'order' => array(
                    'Order.created' => 'DESC'
                ),
                'limit' => 20,
                'paramType' => 'querystring',
            )
        );
        $orders = $this->Paginator->paginate();

        $this->set(compact('orders'));
		
	    if ($this->request->is('post')) {

			$orderid = $_POST['orderid'];
			
			if($_POST['orderstatus']==3){
				
			
			$user_email = $_POST['user_email'];
			//print_r($user_email);die;
			 $shop = $this->Order->find('first', array(
            'recursive' => 1,
            'conditions' => array(
                'Order.id' => $orderid
            )
            
        ));
       		$shop['order_status']=$_POST['orderstatus'];
       		// App::uses('CakeEmail', 'Network/Email');
          $email = new CakeEmail();
           $email->from('info@shop.com')
                    ->to($user_email)
                    ->subject('Order Detail')
                    ->template('order')
                   ->emailFormat('html')
                  ->viewVars(array('shop' => $shop))
                   ->send(); 
                   
                 //  die('here');
                   
                  

       		
	    //$l = new CakeEmail('smtp');
           // $l->emailFormat('html')->template('default', 'default')->subject('Order Cancelled')->to($user_email)->send('Order has been Cancelled');
           // $l->emailFormat('html')->template('order', 'order')->subject('Order Cancelled')->to($user_email)->send('Order has been Cancelled');
            $this->set('smtp_errors', "none");
				
			}
			
		$save = $this->Order->updateAll(array('Order.status' => $_POST['orderstatus']), array('Order.id' => $orderid));	
		if($save){
		$this->Session->setFlash(__('status changed'));
		return $this->redirect(array('action' => 'index'));
	}	
}
		
    }

////////////////////////////////////////////////////////////

    public function admin_view($id = null) {
        $order = $this->Order->find('first', array(
            'recursive' => 1,
            'conditions' => array(
                'Order.id' => $id
            )
        ));
        if (empty($order)) {
            return $this->redirect(array('action'=>'index'));
        }
        $this->set(compact('order'));
    }

////////////////////////////////////////////////////////////

    public function admin_edit($id = null) {
        $this->Order->id = $id;
        if (!$this->Order->exists()) {
            throw new NotFoundException('Invalid order');
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Order->save($this->request->data)) {
                $this->Session->setFlash('The order has been saved');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The order could not be saved. Please, try again.');
            }
        } else {
            $this->request->data = $this->Order->read(null, $id);
        }
    }

////////////////////////////////////////////////////////////

    public function admin_delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Order->id = $id;
        if (!$this->Order->exists()) {
            throw new NotFoundException('Invalid order');
        }
        if ($this->Order->delete()) {
            $this->Session->setFlash('Order deleted');
            return $this->redirect(array('action'=>'index'));
        }
        $this->Session->setFlash('Order was not deleted');
        return $this->redirect(array('action' => 'index'));
    }

////////////////////////////////////////////////////////////

}
