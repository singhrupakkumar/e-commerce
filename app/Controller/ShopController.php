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
        
        $this->Auth->allow('api_displaycart','removeappcart','api_cartupdate','api_checkout');    
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

		$this->loadModel('Product'); 
                $this->loadModel('Staticpage'); 
                
     $galleryimages = $this->Staticpage->find('all',array('conditions'=>array('Staticpage.position'=> 'home' ) ));
		
      $this->set('sliderimage',$galleryimages);  
		 
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

    
    ////////////////////////////////////
   
       public function api_cartupdate() { 
           
                  $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
           exit;  
           
        if ($this->request->is('post')) {  
            foreach($this->request->data['Product'] as $key => $value) {
                $p = explode('-', $key);
                $p = explode('_', $p[1]);
               $updat= $this->Cart->add($p[0], $value, $p[1]);
               
               if($updat){
                        
             $response['error'] = "0";
            $response['msg'] = 'Shopping Cart is updated.'; 
               }else{
                 $response['error'] = "1";
            $response['msg'] = 'Sorry try again.';  
               }
            }
      
           
        }
        
        
        echo json_encode($response);
        exit;
             
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
                //$order['order_type'] = 'creditcard';
                 $order['order_type'] = 'paypal';
                
                $this->Session->write('Shop.Order', $order + $shop['Order']);
               // return $this->redirect(array('action' => 'review'));
                 return $this->redirect(array('action' => 'address?panel=2'));
                
            } else {
                $this->Session->setFlash('The form could not be saved. Please, try again.', 'flash_error');
            }
        }
        if(!empty($shop['Order'])) { 
            $this->request->data['Order'] = $shop['Order'];
        }
        
              $this->set(compact('shop')); 
        
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
            
            if(array_key_exists('order_type',$shop['Order'])){
			
            $this->loadModel('Order');
 
            $this->Order->set($this->request->data);
            if($this->Order->validates()) {
                $order = $shop; 
    
                if($shop['Order']['order_type'] == 'paypal') {  
           
                    $val = $order['Order']['total'];
                    $order['Order']['status'] = 1;
                    $order['Order']['order_type'] = $shop['Order']['order_type'];
                    $save = $this->Order->saveAll($order, array('validate' => 'first'));
                    $email = $order['Order']['email'];
                   
                    
                    if ($save) {
                        $last_id = $this->Order->getLastInsertId();
                        ///////////////////////////////////////////////payment////////////////////////////////////////////////
                        echo ".<form name=\"_xclick\" action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\">
                    <input type=\"hidden\" name=\"cmd\" value=\"_xclick\">
                    <input type=\"hidden\" name=\"email\" value=\"$email\">
                    <input type=\"hidden\" name=\"business\" value=\"wearorganicclothing@gmail.com\">
                    <input type=\"hidden\" name=\"currency_code\" value=\"USD\">
                    <input type=\"hidden\" name=\"custom\" value=\"$last_id\">
                    <input type=\"hidden\" name=\"amount\" value=\"$val\">
                    <input type=\"hidden\" name=\"return\" value=\"http://rupak.crystalbiltech.com/shop/shop/success\">
                    <input type=\"hidden\" name=\"notify_url\" value=\"http://rupak.crystalbiltech.com/shop/shop/ipn\"> 
                    </form>";
//                    exit;
                        echo "<script>document._xclick.submit();</script>";
                        ////////////////////////////////////////////////////////////////////////////////////////////////////////
                    }else {
                    $errors = $this->Order->invalidFields();
                    $this->set(compact('errors'));
                }
           
                }else{
               return $this->redirect(array('action' => 'address?panel=2'));        
               $this->Session->setFlash('Please fill address field.', 'flash_error');    
                }

            }else{
                 return $this->redirect(array('action' => 'address?panel=2'));       
               $this->Session->setFlash('Please fill address field.', 'flash_error');  
            }
            
        
		} else{	
		 $this->Session->setFlash('Please fill address field.', 'flash_error');	
			 return $this->redirect(array('action' => 'address?panel=2'));  
				
			
			} 
            
            
        }else{
                 return $this->redirect(array('action' => 'address?panel=2'));       
               $this->Session->setFlash('Try again.', 'flash_error');  
            }
 
        $this->set(compact('shop'));

    }

//////////////////////////////////////////////////

     
      public function ipn() { 
        $fc = fopen('files/ipn.txt', 'wb');
        ob_start();
        print_r($this->request);
        $req = 'cmd=' . urlencode('_notify-validate');
        foreach ($_POST as $key => $value) {
            $value = urlencode(stripslashes($value));
            $req .= "&$key=$value";
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.sandbox.paypal.com/cgi-bin/webscr');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: www.developer.paypal.com'));
        $res = curl_exec($ch);
        curl_close($ch);
        if (strcmp($res, "VERIFIED") == 0) {
            $custom_field = $_POST['custom'];
            $payer_email = $_POST['payer_email'];
            $trn_id = $_POST['txn_id'];
            $this->loadModel('Order');
            $this->Order->query("UPDATE `orders` SET `status` = 1, `paypal_status` = '$res',`paypal_transaction_id`='$trn_id', `paypal_price`='$pay' WHERE `id` ='$custom_field';");
            $l = new CakeEmail('smtp');
            $l->emailFormat('html')->template('default', 'default')->subject('Payment')->to($payer_email)->send('Payment Done Successfully');
            $this->set('smtp_errors', "none");
        } else if (strcmp($res, "INVALID") == 0) {
            
        }
        $xt = ob_get_clean();
        fwrite($fc, $xt);
        fclose($fc);
        $this->render('payment_confirm', 'ajax');
    }
    
    
    //////////////////////////////////////////

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
	     $api_key = "28fc3b98ea178034dad0a5e5572899be-us15";
         $list_id = "04c2a8d117";
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
	if(isset($_POST['prod_avg_rate'])){
		$reve	= $_POST['prod_avg_rate'];
		$av_reiew = $reve?$reve:1;
   $this->Product->updateAll(array('Product.avg_rating' =>$av_reiew),
    array('Product.id' => $product_id));
	}
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
    Configure::write("debug", 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);    
        $uid = $redata->user_id;
        $text = $redata->text;
        $prod_id = $redata->prod_id;
        $name  = $redata->name;
        $rating = $redata->rating;
        
  
        if ($redata) {
            $this->loadModel('Review');
            $this->loadModel('Product');
            $this->request->data['Review']['product_id'] = $prod_id;
            $this->request->data['Review']['name'] = $name;
            $this->request->data['Review']['punctuality'] = $rating;
            $this->request->data['Review']['text'] = $text;
            $this->request->data['Review']['uid'] = $uid;
		
		$avg_rtng = $rating;

            $cnt = $this->Review->find('count', array('conditions' => array('AND' => array('Review.uid' => $uid, 'Review.product_id' => $prod_id))));
            if ($cnt == 0) {
                $this->Review->save($this->request->data);
				
				$resrev = $this->Product->find('first', array('conditions' => array('Product.id' => $prod_id)));
                $rc = $resrev['Product']['review_count'] + 1;
                $avrc = $resrev['Product']['avg_rating'] + $avg_rtng;
                $avg_rtng = ($avrc / $rc) / 5;
                $this->Product->updateAll(array('Product.review_count' => $rc, 'Product.avg_rating' => $avg_rtng, 'Product.avg_rating' => $avrc), array('Product.id' => $prod_id));

                $response['error'] = "0";
                $response['msg'] = "You  review successfully submitted";
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
    
    ////////////////////////////////////////
    
    
     public function api_checkout() {

           configure::write('debug', 0) ; 
                             $this->layout = 'ajax';
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'ipn.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);   
     
        if ($redata) { 
            $order = array();
           // $order['Order']['order_type'] = $redata->payment->mode;
            $order['Order']['uid'] = $redata->User->uid;   
            $order['Order']['total'] = $redata->cart->total;
            // $order['Order']['order_item_count'] = $redata->products->prod->data[0]->order_item_count;
            $order['Order']['quantity'] = $redata->cart->quantity;
            $order['Order']['weight'] = $redata->cart->weight;
            $order['Order']['subtotal'] = $redata->cart->subtotal;
            $order['Order']['status'] = 1;
            $order['Order']['shop'] = 1;
            $order['Order']['first_name'] = $redata->User->first_name;
            $order['Order']['last_name'] = $redata->User->last_name;  
            $order['Order']['phone'] = $redata->User->phone;
            $order['Order']['email'] = $redata->User->email;
            $order['Order']['shipping_address'] = $redata->User->address;
            $order['Order']['shipping_country'] = $redata->User->country;
            $order['Order']['shipping_state'] = $redata->User->state;
            $order['Order']['shipping_zip'] = $redata->User->zip;
            $order['Order']['shipping_city'] = $redata->User->city;  
            
           // $order['Order']['shipping_address'] = $redata->address->shipping->address;
            //$order['Order']['shipping_city'] = $redata->address->shipping->city;
           // $order['Order']['shipping_state'] = $redata->address->shipping->state;
           // $order['Order']['shipping_zip'] = $redata->address->shipping->zip;
           // $order['Order']['notes'] = $redata->notes->notes; 
            if ($redata->delivery->status) { 
                $order['Order']['delivery_status'] = $redata->delivery->status;
            }
            if ($redata->Table->no) {
                $order['Order']['table_no'] = $redata->Table->no;
            }
            if ($redata->paypal->paymentid) {
                $order['Order']['paypal_transaction_id'] = $redata->paypal->paymentid;
                $order['Order']['paypal_status'] = $redata->paypal->status;
            }
            $arr = array();
            foreach ($redata->products->prod as $key => $value) {  
                $ky = $redata->products->prod[$key]->Cart->product_id;
                $order['OrderItem'][$ky . '_0']['product_id'] = $redata->products->prod[$key]->Cart->product_id;
                 $order['OrderItem'][$ky . '_0']['image'] = $redata->products->prod[$key]->Cart->image;   
                $order['OrderItem'][$ky . '_0']['name'] = $redata->products->prod[$key]->Cart->name;
                $order['OrderItem'][$ky . '_0']['weight'] = $redata->products->prod[$key]->Cart->weight;
                $order['OrderItem'][$ky . '_0']['price'] = $redata->products->prod[$key]->Cart->price;
                $order['OrderItem'][$ky . '_0']['quantity'] = $redata->products->prod[$key]->Cart->quantity;
                $order['OrderItem'][$ky . '_0']['subtotal'] = $redata->products->prod[$key]->Cart->subtotal;
                //$order['OrderItem'][$ky.'_0']['totalweight']=$redata->products->prod->data[1][$key]->Cart->totalweight;
                $order['OrderItem'][$ky . '_0']['Product'] = (array) $redata->products->prod[$key]->Cart;    
                //$order['Order']['restaurant_id'] = $redata->products->prod->data[1][$key]->Cart->resid; 
            }  
     
            $this->loadModel('Order');
            $save = $this->Order->saveAll($order, array('validate' => 'first'));
            $order_id = $this->Order->getInsertID();
            if ($save) {

                $this->removeappcart($redata->User->id);
//            App::uses('CakeEmail', 'Network/Email');
//            $email = new CakeEmail();
//            $email->from('restaurants@test.com')
//                    ->cc('ashutosh@avainfotech.com')
//                    ->to($order['Order']['email'])
//                    ->subject('Shop Order')
//                    ->template('order')
//                    ->emailFormat('text')
//                    ->viewVars(array('shop' => $order))
//                    ->send(); 
                $this->Order->recursive = 2;
                $data = $this->Order->find('first', array('conditions' => array('Order.id' => $order_id)));
                $response['error'] = "0";
                $response['data'] = $data;
            } else {
                $response['error'] = "1";
                $response['data'] = "Error"; 
            }
        }
        echo json_encode($response);
        exit;
    }
    
    //////////////////////////
   
    public function api_increaseqty() {
        configure::write('debug', 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);


        $id = $redata->Cart->id;
        $this->loadModel('Cart');
        $data = $this->Cart->find('all', array('conditions' => array('Cart.id' => $id)));

        foreach ($data as $d) {
            $qty = $d['Cart']['quantity'] + 1;
            $weight_total = $d['Cart']['weight_total'] + $d['Cart']['weight'];
            $subtotal = $d['Cart']['subtotal'] + $d['Cart']['price'];
        }

        $update= $this->Cart->updateAll(array('Cart.subtotal' => $subtotal, 'Cart.quantity' => $qty, 'Cart.weight_total' => $weight_total), array('Cart.id' => $id)
        );
 
        if ($update) {
            $response['msg'] = "updated";
            $response['error'] = "0";
        } else {
             $response['msg'] = "Try again";
            $response['error'] = "1";
        }

        echo json_encode($response);

        exit;
    }

    //////////////////
    
       public function api_decreaseqty() {
        configure::write('debug', 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);


        $id = $redata->Cart->id;
        $this->loadModel('Cart');
        $d = $this->Cart->find('all', array('conditions' => array('Cart.id' => $id)));


        if ($d[0]['Cart']['quantity'] > 1) {
            $qty = $d[0]['Cart']['quantity'] - 1;
            $weight_total = $d[0]['Cart']['weight_total'] - $d[0]['Cart']['weight'];
            $subtotal = $d[0]['Cart']['subtotal'] - $d[0]['Cart']['price'];



           $save = $this->Cart->updateAll(array('Cart.subtotal' => $subtotal, 'Cart.quantity' => $qty, 'Cart.weight_total' => $weight_total), array('Cart.id' => $id)
            );
        }
        if ($save ) {
            $response['msg'] = "updated";
            $response['error'] = "0";
        } else {
            $response['error'] = "1";
             $response['msg'] = "Try again";
        }

        echo json_encode($response);

        exit;
    }
    
    //////////////////////////////////////////////
 

}
