<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
class ShopController extends AppController {

//////////////////////////////////////////////////

    public $components = array(
        'Cart',
        'Paypal',
        'AuthorizeNet'
    );

//////////////////////////////////////////////////

    public $uses = 'Product';

//////////////////////////////////////////////////

    public function beforeFilter() {
        parent::beforeFilter();
        $this->disableCache();
        
        $this->Auth->allow('api_displaycart','removeappcart');  
        //$this->Security->validatePost = false;
    }

//////////////////////////////////////////////////
 
    public function clear() {
        $this->Cart->clear();
        $this->Session->setFlash('All item(s) removed from your shopping cart', 'flash_error');
        return $this->redirect('/');
    }

////////////////////////////////////////////////// 
     public function index() {
         echo "hello";
         exit();
		$this->loadModel('Product'); 
		 
		        $productswatch = $this->Product->find('all', array(
            'recursive' => -1,
            'contain' => array(
                'Brand'
            ),
            'limit' => 4,
            'conditions' => array(
                'Product.active' => 1,
				'Product.category_id' => 2,
                'Brand.active' => 1
            ),
            'order' => array(
                'Product.id' => 'DESC'
            )
        ));
		
		 $products_braslate = $this->Product->find('all', array(
            'recursive' => -1,
            'contain' => array(
                'Brand'
            ),
            'limit' => 4,
            'conditions' => array(
                'Product.active' => 1,
                'Product.category_id' => 3,
                'Brand.active' => 1
            ),
            'order' => array(
                'Product.id' => 'DESC'
            )
        ));
		
		 $products_instagram = $this->Product->find('all', array(
            'recursive' => -1,
            'contain' => array(
                'Brand'
            ),
            'limit' => 12,
            'conditions' => array(
                'Product.active' => 1,
                'Product.category_id' => 4,
                'Brand.active' => 1
            ),
            'order' => array(
                'Product.id' => 'DESC'
            )
        ));
		
		$products_media = $this->Product->find('all', array(
            'recursive' => -1,
            'contain' => array(
                'Brand'
            ),
            'limit' => 12,
            'conditions' => array(
                'Product.active' => 1,
                'Product.category_id' =>5,
                'Brand.active' => 1
            ),
            'order' => array(
                'Product.id' => 'DESC'
            )
        ));
		 
        $this->set(compact('productswatch'));
        $this->set(compact('products_braslate'));
        $this->set(compact('products_instagram'));
        $this->set(compact('products_media'));
		 
	 }

    public function add() {
        if ($this->request->is('post')) {

            $id = $this->request->data['Product']['id'];

            $quantity = isset($this->request->data['Product']['quantity']) ? $this->request->data['Product']['quantity'] : null;

            $productmodId = isset($this->request->data['mods']) ? $this->request->data['mods'] : null;

            $product = $this->Cart->add($id, $quantity, $productmodId);
        }
        if(!empty($product)) {
            $this->Session->setFlash($product['Product']['name'] . ' was added to your shopping cart.', 'flash_success');
        } else {
            $this->Session->setFlash('Unable to add this product to your shopping cart.', 'flash_error');
        }
        $this->redirect($this->referer());
    }
    
    /////////////////////////////////////////

    
       public function api_cart() {
        configure::write('debug', 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        
        $id = $redata->Product->id;
        $uid = $redata->User->uid;
        $quantity = $redata->Quantity->qty;
        $sid = $redata->SnId->sid;
        $productmodId = "";
        //  pr($d=$this->Cart->checkcrt($sid,$id));exit;
        if (!empty($redata)) {
            $d = $this->Cart->checkcrt($sid, $id);
            if (!empty($d)) { 
                $response['error'] = "0";
                $response['data'] = "Product already added in the cart";
            } else {
                if ($this->Cart->appadd($id, $quantity, $productmodId, $uid, $sid)) {
                    $response['error'] = "0";
                    $response['data'] = "cart has been updated!";
                } else {
                    $response['error'] = "1";
                    $response['data'] = "error";
                }
            } 
        }
        echo json_encode($response);
        exit;
    }

//////////////////////////////////////////////////

    public function itemupdate() {
        if ($this->request->is('ajax')) {

            $id = $this->request->data['id'];

            $quantity = isset($this->request->data['quantity']) ? $this->request->data['quantity'] : null;

            if(isset($this->request->data['mods']) && ($this->request->data['mods'] > 0)) {
                $productmodId = $this->request->data['mods'];
            } else {
                $productmodId = null;
            }

            // echo $productmodId ;
            // die;

            $product = $this->Cart->add($id, $quantity, $productmodId);

        }
        $cart = $this->Session->read('Shop');
        echo json_encode($cart);
        $this->autoRender = false;
    }

//////////////////////////////////////////////////

    public function update() {
        $this->Cart->update($this->request->data['Product']['id'], 1);
    }

//////////////////////////////////////////////////

    public function remove($id = null) {
        $product = $this->Cart->remove($id);
        if(!empty($product)) {
            $this->Session->setFlash($product['Product']['name'] . ' was removed from your shopping cart', 'flash_error');
        }
        return $this->redirect(array('action' => 'cart'));
    }
    
    ///////////////////
 
    public function api_removeitems() {
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        $id = $redata->Cart->id;
        $this->loadModel('Cart'); 
        if (!empty($redata)) {
            $this->Cart->id = $id;
            $data = $this->Cart->delete();
            $response['error'] = "0";
            $response['data'] = $data;
        } else {
            $response['error'] = "1";
            $response['data'] = "error";
        }

        echo json_encode($response);
        exit;
    }

//////////////////////////////////////////////////

    public function cartupdate() {
        if ($this->request->is('post')) {
            foreach($this->request->data['Product'] as $key => $value) {
                $p = explode('-', $key);
                $p = explode('_', $p[1]);
                $this->Cart->add($p[0], $value, $p[1]);
            }
            $this->Session->setFlash('Shopping Cart is updated.', 'flash_success');
        }
        return $this->redirect(array('action' => 'cart'));
    }

//////////////////////////////////////////////////

    public function cart() {
        $shop = $this->Session->read('Shop');
        $this->set(compact('shop'));
    }

//////////////////////////////////////////////////

    public function address() {

        $shop = $this->Session->read('Shop');
        if(!$shop['Order']['total']) {
            return $this->redirect('/');
        }

        if ($this->request->is('post')) {
            $this->loadModel('Order');
            $this->Order->set($this->request->data);
            if($this->Order->validates()) {
                $order = $this->request->data['Order'];
                $order['order_type'] = 'creditcard';
                $this->Session->write('Shop.Order', $order + $shop['Order']);
                return $this->redirect(array('action' => 'review'));
            } else {
                $this->Session->setFlash('The form could not be saved. Please, try again.', 'flash_error');
            }
        }
        if(!empty($shop['Order'])) {
            $this->request->data['Order'] = $shop['Order'];
        }

    }

//////////////////////////////////////////////////

    public function step1() {
        $paymentAmount = $this->Session->read('Shop.Order.total');
        if(!$paymentAmount) {
            return $this->redirect('/');
        }
        $this->Session->write('Shop.Order.order_type', 'paypal');
        $this->Paypal->step1($paymentAmount);
    }

//////////////////////////////////////////////////

    public function step2() {

        $token = $this->request->query['token'];
        $paypal = $this->Paypal->GetShippingDetails($token);

        $ack = strtoupper($paypal['ACK']);
        if($ack == 'SUCCESS' || $ack == 'SUCESSWITHWARNING') {
            $this->Session->write('Shop.Paypal.Details', $paypal);
            return $this->redirect(array('action' => 'review'));
        } else {
            $ErrorCode = urldecode($paypal['L_ERRORCODE0']);
            $ErrorShortMsg = urldecode($paypal['L_SHORTMESSAGE0']);
            $ErrorLongMsg = urldecode($paypal['L_LONGMESSAGE0']);
            $ErrorSeverityCode = urldecode($paypal['L_SEVERITYCODE0']);
            echo 'GetExpressCheckoutDetails API call failed. ';
            echo 'Detailed Error Message: ' . $ErrorLongMsg;
            echo 'Short Error Message: ' . $ErrorShortMsg;
            echo 'Error Code: ' . $ErrorCode;
            echo 'Error Severity Code: ' . $ErrorSeverityCode;
            die();
        }

    }

//////////////////////////////////////////////////

    public function review() {

        $shop = $this->Session->read('Shop');

        if(empty($shop)) {
            return $this->redirect('/');
        }

        if ($this->request->is('post')) {

            $this->loadModel('Order');

            $this->Order->set($this->request->data);
            if($this->Order->validates()) {
                $order = $shop;
                $order['Order']['status'] = 1;

                if($shop['Order']['order_type'] == 'paypal') {
                    $paypal = $this->Paypal->ConfirmPayment($order['Order']['total']);
                    //debug($resArray);
                    $ack = strtoupper($paypal['ACK']);
                    if($ack == 'SUCCESS' || $ack == 'SUCCESSWITHWARNING') {
                        $order['Order']['status'] = 2;
                    }
                    $order['Order']['authorization'] = $paypal['ACK'];
                    //$order['Order']['transaction'] = $paypal['PAYMENTINFO_0_TRANSACTIONID'];
                }

                if((Configure::read('Settings.AUTHORIZENET_ENABLED') == 1) && $shop['Order']['order_type'] == 'creditcard') {
                    $payment = array(
                        'creditcard_number' => $this->request->data['Order']['creditcard_number'],
                        'creditcard_month' => $this->request->data['Order']['creditcard_month'],
                        'creditcard_year' => $this->request->data['Order']['creditcard_year'],
                        'creditcard_code' => $this->request->data['Order']['creditcard_code'],
                    );
                    try {
                        $authorizeNet = $this->AuthorizeNet->charge($shop['Order'], $payment);
                    } catch(Exception $e) {
                        $this->Session->setFlash($e->getMessage());
                        return $this->redirect(array('action' => 'review'));
                    }
                    $order['Order']['authorization'] = $authorizeNet[4];
                    $order['Order']['transaction'] = $authorizeNet[6];
                }

                $save = $this->Order->saveAll($order, array('validate' => 'first'));
                if($save) {

                    $this->set(compact('shop'));

                    App::uses('CakeEmail', 'Network/Email');
                    $email = new CakeEmail();
                    $email->from(Configure::read('Settings.ADMIN_EMAIL'))
                            ->cc(Configure::read('Settings.ADMIN_EMAIL'))
                            ->to($shop['Order']['email'])
                            ->subject('Shop Order')
                            ->template('order')
                            ->emailFormat('text')
                            ->viewVars(array('shop' => $shop))
                            ->send();
                    return $this->redirect(array('action' => 'success'));
                } else {
                    $errors = $this->Order->invalidFields();
                    $this->set(compact('errors'));
                }
            }
        }

        if(($shop['Order']['order_type'] == 'paypal') && !empty($shop['Paypal']['Details'])) {
            $shop['Order']['first_name'] = $shop['Paypal']['Details']['FIRSTNAME'];
            $shop['Order']['last_name'] = $shop['Paypal']['Details']['LASTNAME'];
            $shop['Order']['email'] = $shop['Paypal']['Details']['EMAIL'];
            $shop['Order']['phone'] = '888-888-8888';
            $shop['Order']['billing_address'] = $shop['Paypal']['Details']['SHIPTOSTREET'];
            $shop['Order']['billing_address2'] = '';
            $shop['Order']['billing_city'] = $shop['Paypal']['Details']['SHIPTOCITY'];
            $shop['Order']['billing_zip'] = $shop['Paypal']['Details']['SHIPTOZIP'];
            $shop['Order']['billing_state'] = $shop['Paypal']['Details']['SHIPTOSTATE'];
            $shop['Order']['billing_country'] = $shop['Paypal']['Details']['SHIPTOCOUNTRYNAME'];

            $shop['Order']['shipping_address'] = $shop['Paypal']['Details']['SHIPTOSTREET'];
            $shop['Order']['shipping_address2'] = '';
            $shop['Order']['shipping_city'] = $shop['Paypal']['Details']['SHIPTOCITY'];
            $shop['Order']['shipping_zip'] = $shop['Paypal']['Details']['SHIPTOZIP'];
            $shop['Order']['shipping_state'] = $shop['Paypal']['Details']['SHIPTOSTATE'];
            $shop['Order']['shipping_country'] = $shop['Paypal']['Details']['SHIPTOCOUNTRYNAME'];

            $shop['Order']['order_type'] = 'paypal';

            $this->Session->write('Shop.Order', $shop['Order']);
        }

        $this->set(compact('shop'));

    }

//////////////////////////////////////////////////

    public function success() {
        $shop = $this->Session->read('Shop');
        $this->Cart->clear();
        if(empty($shop)) {
            return $this->redirect('/');
        }
        $this->set(compact('shop'));
    }
	
	
	
		 public function newsletter() {
        //ashu $api_key = "35833bae8881ce0ecced3fc3daa81482-us14";    
	    //ashu $list_id = "1a2fe1e7c5";
	     $api_key = "4dbb3c2873e856aeda8402634b580c06-us14";
         $list_id = "bb2c473509";
		//$this->loadModel('Newsletter');
		//$options = array('conditions' => array('Newsletter.' . $this->Newsletter->primaryKey => $id));
		//$data = $this->Newsletter->find('first', $options);
		
		//$api_key = $data['api_key'];
        //$list_id = $data["list_id"];
		
		
      
        require '../Lib/src/Mailchimp.php';
        //require('Mailchimp.php');
        $Mailchimp = new Mailchimp($api_key);
        $Mailchimp_Lists = new Mailchimp_Lists($Mailchimp);
        $subscriber = $Mailchimp_Lists->subscribe($list_id, array('email' => htmlentities($_POST['email'])));
        // print_r($subscriber); 
        if (!empty($subscriber['leid'])) {
            echo "success";
        } else {
            echo "fail";
        }
        exit;
    }
    
    
    public function savereview(){
            $this->loadModel('Review');
            $this->loadModel('Product');
               if ($this->request->is('post')) {
            $product_id = $this->request->data['Review']['product_id'];
            $name  = $this->request->data['Review']['name'];
            $email = $this->request->data['Review']['email'];
            //$price = $this->request->data['Review']['price'] ; 
            $punctuality =  $this->request->data['Review']['punctuality'];
            $text =  $this->request->data['Review']['text'];
            $uid = $this->request->data['Review']['uid'];
            
            $this->request->data['Review']['product_id'] = $product_id;
            $this->request->data['Review']['name'] = $name;
            $this->request->data['Review']['email'] = $email;
           // $this->request->data['Review']['food_quality'] = $food_quality;
            //$this->request->data['Review']['price'] = $price;
            $this->request->data['Review']['punctuality'] = $punctuality;
           // $this->request->data['Review']['courtesy'] = $courtesy;
            $this->request->data['Review']['text'] = $text;
            $this->request->data['Review']['uid'] = $uid;

            $cnt = $this->Review->find('count', array('conditions' => array('AND' => array('Review.uid' => $uid, 'Review.product_id' => $product_id))));
            if ($cnt == 0) {
                $this->Review->save($this->request->data);
               $this->Session->setFlash('Thanks for review', 'flash_success');
               return $this->redirect('http://' .$_POST['server']);
            } else {
                
               $this->Session->setFlash('You have been already submitted the review', 'flash_success');
               return $this->redirect('http://' .$_POST['server']);
            }
         
      }  
  
    }
    
    
    
     public function api_savereview() {
        configure::write('debug', 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        // print_r($redata);
        // $resid = $redata->Review->resid;
        $uid = $redata->Review->uid;
        $text = $redata->Review->text;
        $resid = $redata->Review->resid;
        $email = $redata->Review->email;
        $food_quality = $redata->Review->food_quality;
        $price = $redata->Review->price;
        $punctuality = $redata->Review->price;
        $courtesy = $redata->Review->courtesy;
        $name = $redata->Review->name;

        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        if ($redata) {
            $this->loadModel('Review');
            $this->loadModel('Restaurant');

            $this->request->data['Review']['resid'] = $resid;
            $this->request->data['Review']['name'] = $name;
            $this->request->data['Review']['email'] = $email;
            $this->request->data['Review']['food_quality'] = $food_quality;
            $this->request->data['Review']['price'] = $price;
            $this->request->data['Review']['punctuality'] = $punctuality;
            $this->request->data['Review']['courtesy'] = $courtesy;
            $this->request->data['Review']['text'] = $text;
            $this->request->data['Review']['uid'] = $uid;

            //debug($this->request->data);exit;
            $avg_rtng = $food_quality + $price + $punctuality + $courtesy;
            $cnt = $this->Review->find('count', array('conditions' => array('AND' => array('Review.uid' => $uid, 'Review.resid' => $resid))));
            if ($cnt == 0) {
                $this->Review->save($this->request->data);
                $resrev = $this->Restaurant->find('first', array('conditions' => array('Restaurant.id' => $resid)));
                $rc = $resrev['Restaurant']['review_count'] + 1;
                $avrc = $resrev['Restaurant']['total_avr'] + $avg_rtng;
                ob_start();
                //echo $avrc;
                //echo "here ";
                //echo $rc;
                //echo "here1 ";
                $avg_rtng = ($avrc / $rc) / 4;

                $c = ob_get_clean();
                $fc = fopen('files' . DS . 'review.txt', 'w');
                fwrite($fc, $c);
                fclose($fc);
                $this->Restaurant->updateAll(array('Restaurant.review_count' => $rc, 'Restaurant.review_avg' => $avg_rtng, 'Restaurant.total_avr' => $avrc), array('Restaurant.id' => $resid));
                $response['error'] = "0";
                $response['rating'] = $avg_rtng;
                $response['msg'] = "You have submitted the review";
            } else {
                $response['error'] = "1";
                $response['msg'] = "You have been already submitted the review";
            }
        }
        echo json_encode($response);
        exit;
    }
    
    ////////////////////////////////
    
        public function api_displaycart() {
        configure::write('debug', 0) ;
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
    
        $uid = $redata->User->uid;
        $sid = $redata->SnId->sid; 
     
        if (!empty($redata)) { 
            $data = $this->Cart->appcart($uid, $sid);
            $response['error'] = "0";
            $response['data'] = $data;
        } else { 
            $response['error'] = "1";
            $response['data'] = "error";
        }
  
        echo json_encode($response);
        exit;
    }
    ////////////////////////////////////
    
      private function removeappcart($id = NULL) {
        if ($id) {
            $this->loadModel('Cart');
            $data = $this->Cart->deleteAll(array('Cart.uid' => $id), false);
        }
    }
      
    //////////////////////////
    
    public function api_removeappcart($id = NULL) {      
        
                          $this->layout = 'ajax';
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
          
        if ($this->request->is('post')) {
         if ($redata->User->id) { 
          $this->loadModel('Cart'); 
         $data = $this->Cart->deleteAll(array('Cart.uid' => $redata->User->id), false); 
        if( $data) {
             $response['error'] = 0;
            $response['msg'] = ' cart was removed from your shopping cart';
          
        }else{
             $response['error'] = 1;
            $response['msg'] = 'Sorry try again!';
        }  
        
        }
        
        }
         echo json_encode($response);
        exit;

    }
 
//////////////////////////////////////////////////

}
