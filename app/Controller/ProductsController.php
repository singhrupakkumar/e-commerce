<?php
App::uses('AppController', 'Controller');
class ProductsController extends AppController {

////////////////////////////////////////////////////////////

    public $components = array(
        'RequestHandler',
    );

////////////////////////////////////////////////////////////

    public function beforeFilter() {
       parent::beforeFilter();
        $this->Auth->allow(array('api_restaurantslist','api_getsingleproduct',
            'api_mobilefilter','addwishlist','api_addwishlist','wishlist_delete',
            'wishlist_deleteall','api_wishlist_delete','api_wishlist_deleteall',
			'get_alerts','admin_add','api_popularprod','api_getalerts','api_productfilter','api_returnpolicy'));
        
      
    }

////////////////////////////////////////////////////////////

    public function index() {
        $products = $this->Product->find('all', array(
            'recursive' => -1,
            'contain' => array(
                'Brand'
            ),
            'limit' => 20,
            'conditions' => array(
                'Product.active' => 1,
                'Brand.active' => 1
            ),
            'order' => array(
                'Product.views' => 'ASC'
            )
        ));
        $this->set(compact('products'));

        $this->Product->updateViews($products);

        $this->set('title_for_layout', Configure::read('Settings.SHOP_TITLE'));
    }

////////////////////////////////////////////////////////////

       public function api_mobilefilter() {
        configure::write('debug', 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        $this->layout = "ajax";
         exit;

        $this->Restaurant->recursive = 2;
        if ($redata) {
            $lat = $redata->data->Restaurant->latitude;
            $long = $redata->data->Restaurant->longitude;
            $this->loadModel("RestaurantsType");
            if ($lat == 0 || $long == 0) {
                return false;
            } else {
                if ($redata->data->Restaurant->typeid == null) {
                    $data = $this->Restaurant->find('all', array(
                        'conditions' => array('AND' => array('Restaurant.review_avg' => $redata->data->Restaurant->review_avg, 'Restaurant.delivery' => $redata->data->Restaurant->delivery, 'Restaurant.takeaway' => $redata->data->Restaurant->takeaway)),
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                        "ORDER BY" => 'DESC',
                    ));
                } else if ($redata->data->Restaurant->review_avg == null) {
                    $data = $this->Restaurant->find('all', array(
                        'conditions' => array('AND' => array('Restaurant.typeid' => $redata->data->Restaurant->typeid, 'Restaurant.delivery' => $redata->data->Restaurant->delivery, 'Restaurant.takeaway' => $redata->data->Restaurant->takeaway)),
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                        "ORDER BY" => 'DESC',
                    ));
                } else if ($redata->data->Restaurant->delivery == NULL) {
                    $data = $this->Restaurant->find('all', array(
                        'conditions' => array('AND' => array('Restaurant.typeid' => $redata->data->Restaurant->typeid, 'Restaurant.review_avg' => $redata->data->Restaurant->review_avg, 'Restaurant.takeaway' => $redata->data->Restaurant->takeaway)),
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                        "ORDER BY" => 'DESC',
                    ));
                } else if ($redata->data->Restaurant->takeaway == NULL) {
                    $data = $this->Restaurant->find('all', array(
                        'conditions' => array('AND' => array('Restaurant.typeid' => $redata->data->Restaurant->typeid, 'Restaurant.review_avg' => $redata->data->Restaurant->review_avg, 'Restaurant.delivery' => $redata->data->Restaurant->delivery)),
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                        "ORDER BY" => 'DESC',
                    ));
                } else if ($redata->data->Restaurant->typeid != null && $redata->data->Restaurant->review_avg != null && $redata->data->Restaurant->takeaway != NULL && $redata->data->Restaurant->delivery != NULL) {
                    $data = $this->Restaurant->find('all', array(
                        'conditions' => array('AND' => array('Restaurant.typeid' => $redata->data->Restaurant->typeid, 'Restaurant.review_avg' => $redata->data->Restaurant->review_avg, 'Restaurant.delivery' => $redata->data->Restaurant->delivery, 'Restaurant.takeaway' => $redata->data->Restaurant->takeaway)),
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                        "ORDER BY" => 'DESC',
                    ));
                } else {
                    $data = $this->Restaurant->find('all', array(
                        "fields" => array("get_distance_in_miles_between_geo_locations($lat,$long,Restaurant.latitude,Restaurant.longitude) as distance", "Restaurant.*,RestaurantsType.*"),
                        "ORDER BY" => 'DESC',
                    ));
                }

                $cnt = count($data);
                for ($i = 0; $i < $cnt; $i++) {
                    if ($data[$i][0]['distance'] < $this->distance) {
                        $data[$i]['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $data[$i]['Restaurant']['logo'];
                    } else {
                        unset($data[$i]);
                    }
                }
                $finaldata = array();
                $j = 0;
                foreach ($data as $d) {
                    $finaldata['Restaurant'][$j] = $d['Restaurant'];
                    $finaldata['Restaurant'][$j]['typename'] = $d['RestaurantsType']['name'];
                    $j++;
                }
            }
        }
        echo json_encode($finaldata);
        $this->render('ajax');
        exit;
    }
	
	////////////////////////////////////
	
	function api_productfilter(){
      Configure::write('debug', 0);
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
			   
			   
			if ($redata[0]->brand != null) {
				
					
				foreach($redata[0]->brand as $key =>$val){
					$band[] = $val;
				}
			
                $conditions[] = array(
                    'Product.brand_id' => $band,
                );
            }   


            if ($redata[1]->woodtype != null) {
				
				foreach($redata[1]->woodtype as $key =>$val){
					$tag[] = $val;
				}
			
                $conditions[] = array(
                    'Product.woodtype_id' => $tag,
                );
            } 
			
			if ($redata[2]->mechanism != null) {
				
				foreach($redata[2]->mechanism as $key =>$val){
					$mach[] = $val;
				}
				
                $conditions[] = array(
                    'Product.mechanism_id' => $mach,
                );
            }
			
			if ($redata[3]->series != null) {
				
				foreach($redata[3]->series as $key =>$val){
					$serise[] = $val;
				}
                $conditions[] = array(
                    'Product.series' => $serise,
                );
            }
			
			if ($redata->category != null) {
				
				foreach($redata->category as $key =>$val){
					$category[] = $val;
				}
                $conditions[] = array(
                    'Product.category_id' => $category,
                );
            }
			
			if ($redata[5]->theme != null) {
				
				foreach($redata[5]->theme as $key =>$val){
					$theme[] = $val;
				}
                $conditions[] = array(
                    'Product.theme_id' => $theme,
                );
            }
			
		     if ($redata[7]->colour != null) {
				
				foreach($redata[7]->colour as $key =>$val){
					$colour[] = $val;
				}
                $conditions[] = array(
                    'Product.colour_id' => $colour,
                );
            }
			
			if ($redata[4]->style != null) {
				
				foreach($redata[4]->style as $key =>$val){
					$style[] = $val;
				}
                $conditions[] = array(
                    'Product.style_id' => $style,
                );
            }
			
			if ($redata[8]->material != null) {
				
				foreach($redata[8]->material as $key =>$val){
					$material[] = $val;
				}
                $conditions[] = array(
                    'Product.material_id' => $material,
                );
            }
			
			if ($redata[6]->gemstone != null) {
				
				foreach($redata[6]->gemstone as $key =>$val){
					$gemstone[] = $val;
				}
                $conditions[] = array(
                    'Product.gemstone_id' => $gemstone,
                );
            }
	
		  $products =  $this->Product->find('all',array(
            'conditions' => $conditions,
        )); 
       

        if (count($products) == 0) {
			$response['error'] = 1; 
           
			$response['msg']= 'Product Not found in this criteria.';
          
        }else{
			
			$cnt = count($products);
		
		  for ($i = 0; $i < $cnt; $i++) { 
                if ($products[$i]['Product']['image']) {
                    $products[$i]['Product']['image'] = Router::url('/', true). 'images/large/'. $products[$i]['Product']['image'];
                } else {
                    $products[$i]['Product']['image'] = Router::url('/', true). 'img/no-image.jpg';
                }
            }
			
			
			
			
			
			$response['error'] = 0;
			 $response['product'] = $products;
		}
			
        }
	
		
		 echo json_encode($response);
        exit;

	}
    
/////////////////////////////////////////////
	 public function api_getsingleproduct() {
        Configure::write('debug', 0);
        $this->layout = 'ajax';
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
	
      $pro_id = $redata->prod_id;

     
        ob_start();
        var_dump($this->request->data);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
	
        $this->Product->recursive = 2;
        if ($pro_id) {
            $resp = $this->Product->find('first', array('conditions' => array('Product.id' => $pro_id)));

            if ($resp['Product']['image']) {
                $resp['Product']['image'] =  Router::url('/', true). 'images/large/' . $resp['Product']['image'];
            } else {
                $resp['Product']['image'] =  Router::url('/', true). 'img/no-image.jpg';
            }
			
			$i =0;
			foreach($resp['Gallary'] as $img){
				
				   if ($img['image']) {
                    $resp['Gallary'][$i]['image'] = Router::url('/', true). 'images/large/'. $img['image'];
                } else {
                    $resp['Gallary'][$i]['image'] = Router::url('/', true). 'img/no-image.jpg';
                }
			$i++;				
			}
		
            $this->loadModel('Alergy');
            $alrg_id = $resp['Product']['alergi'];
            $al_id = explode(',', $alrg_id);
            if ($alrg_id == '') {
                $alrgitems = "No data";
            } else {
                $resp['Product']['AssoAlergy'][] = $this->Alergy->find('all', array('conditions' => array('Alergy.id' => $al_id)));
            }
            $pro_id = unserialize($resp['Product']['pro_id']);
            $pro_id = explode(',', $pro_id);
            // print_r($pro_id);
            if ($pro_id == '') {
                $assoproduct = "No data";
            } else {
                $prodata = $this->Product->find('all', array('conditions' => array('Product.id' => $pro_id)));
                //print_r($prodata);
                foreach ($prodata as $res) {
                    if ($res['Product']['image']) {
                        $res['Product']['image'] =  $this->webroot . 'images/large/'  . $res['Product']['image'];
                    } else {
                        $res['Product']['image'] =  $this->webroot . 'img/no-image.jpg';
                    }
                    $res2[] = $res;
                }
                $resp['Product']['AssoPro'] = $res2;
            }
		

            $response['error'] = 0;
            $response['list'] = $resp;
        } else {
            $response['error'] = 1;
            $response['msg'] = 'Sorry Product has not been found!';
        }
        echo json_encode($response);
        exit;
    }
    
    ///////////////////////////////
    
     

    public function addwishlist(){
 
     
       // echo '<pre>';print_r($_POST);die(); 
   $this->loadModel("Wishlist");
        if ($this->request->is('post')) {
         
            $cnt = $this->Wishlist->find('count', array('conditions' => array('AND' => array('Wishlist.user_id' => $_POST['user_id'] , 'Wishlist.product_id' =>$_POST['product_id']))));
            if ($cnt == 0) {    
            
            $this->Wishlist->create();
            if ($this->Wishlist->save(array('user_id'=> $_POST['user_id'],'product_id'=> $_POST['product_id']))) {
                     
                    $this->Session->setFlash('The Wishlist has been saved', 'flash_success');
               return $this->redirect('http://' .$_POST['server']);
              
            } else {
                    $this->Session->setFlash('The Wishlist could not be saved. Please, try again.', 'flash_success');
            }
            
        }else{
           $this->Session->setFlash('This Item already added in Your Wishlist .', 'flash_success');
            return $this->redirect('http://' .$_POST['server']);
        }
        }
    }
    //////////////////////
    
     public function get_alerts(){
 
      $this->loadModel("Wishlist");
        if ($this->request->is('post')) {
         
            $cnt = $this->Wishlist->find('count', array('conditions' => array('AND' => array('Wishlist.user_id' => $_POST['user_id'] , 'Wishlist.product_id' =>$_POST['product_id']))));
            if ($cnt == 0) {    
            
            $this->Wishlist->create();
            if ($this->Wishlist->save(array('user_id'=> $_POST['user_id'],
                'product_id'=> $_POST['product_id'],
                'get_alert'=> 1
                ))) {
                     
                    $this->Session->setFlash('Your Requst has been saved', 'flash_success');
               return $this->redirect('http://' .$_POST['server']);
              
            } else {
                
                    $this->Session->setFlash('Your Requst could not be saved. Please, try again.', 'flash_success');
            }
            
        }else{
            
          $this->Wishlist->updateAll(array('get_alert'=>1), array('Wishlist.product_id'=>$_POST['product_id'],
              'Wishlist.user_id' => $_POST['user_id']));
            
           $this->Session->setFlash('Your Requst has been updated .', 'flash_success'); 
            return $this->redirect('http://' .$_POST['server']);
        } 
        }
    }
    
    ////////////////
	
	
	 public function api_deletealerts(){

		   
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
				
				$save = $this->Product->updateAll(array('get_alert'=>0), array('Product.id'=>$redata->Product->product_id,'Product.uid'=>$redata->user->user_id));
			  if($save){
			 $response['status'] = true;
			 $response['msg'] = 'Your Notification has been deleted';
			  }else{
				   $response['status'] = false;
			 $response['msg'] = '';
			  }
				
   }
	 echo json_encode($response);
        exit;
	 }
	//////////////
	
	  public function api_getalerts(){
		   
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
			
			
         
            $cnt = $this->Product->find('count', array('conditions' => array('AND' => array('Product.uid' => $redata->user->user_id , 'Product.id' =>$redata->Product->product_id,'Product.get_alert'=>1))));
            if ($cnt == 0) { 

			$save = $this->Product->updateAll(array('get_alert'=>1,'uid'=>$redata->user->user_id), array('Product.id'=>$redata->Product->product_id));
			  if($save){
			 $response['status'] = true;
			 $response['msg'] = 'Your Request has been saved';
			  }else{
				   $response['status'] = false;
			 $response['msg'] = 'Try again';
			  }
           }else{
			 $response['status'] = false;
			 $response['msg'] = 'Your Request already submmited';
           
        }
			
		
				
        }
		echo json_encode($response);
        exit;
		
    }
	////////////////////////
	
	 public function api_notification(){
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
			$data = $this->Product->find('all', array('conditions' => array('AND' => array('Product.uid' => $redata->User->uid, 'Product.get_alert' =>1, 'Product.on_sale' =>1))));
			
			
	
		$cnt = count($data);
		
		  for ($i = 0; $i < $cnt; $i++) { 
                if ($data[$i]['Product']['image']) {
                    $data[$i]['Product']['image'] = Router::url('/', true). 'images/large/'. $data[$i]['Product']['image'];
                } else {
                    $data[$i]['Product']['image'] = Router::url('/', true). 'img/no-image.jpg';
                }
            }
			
			
            if ($data) {
                $response['product'] = $data;
                $response['isSucess'] = "true";
            } else {
                $response['isSucess'] = 'false';
                $response['msg'] = '';
            }
		}
        echo json_encode($response);
        exit;
		 
	 }
	
    ////////////////////////
    
         public function wishlist_delete($id = null) {
           $this->loadModel("Wishlist");  
           $id = $this->request->query('product_id'); 
        if ($this->Wishlist->deleteAll(array('Wishlist.product_id' => $id))) {
            $this->Session->setFlash('Wishlist item deleted successfully', 'flash_success');
            
           $this->redirect(array('controller' => 'Users', 'action' => 'showwishlist')); 
        }
        $this->Session->setFlash('Wishlist item was not deleted', 'flash_success');
        $this->redirect(array('controller' => 'Users', 'action' => 'showwishlist')); 
    }
    /////////////////////////
    public function api_wishlist_delete(){
                 $this->layout = 'ajax';
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
      
        
         $this->loadModel("Wishlist");  
            if ($this->request->is('post')) {
        if ($this->Wishlist->deleteAll(array('Wishlist.product_id' => $redata->product->prod_id))) {
           $response['status'] = true;
          $response['msg'] = 'Wishlist deleted';
        }else{
         $response['status'] = true;
          $response['msg'] = 'try again'; 
            }
          }
          
          echo json_encode($response);
        exit;
    }
    
    ///////////////////
    public function wishlist_deleteall() {
           $this->loadModel("Wishlist");  
           $id = $this->request->query('user_id'); 
        if ($this->Wishlist->deleteAll(array('Wishlist.user_id' => $id))) {
            $this->Session->setFlash('Wishlist deleted', 'flash_success');
            
           $this->redirect(array('controller' => 'Users', 'action' => 'showwishlist')); 
        }
        $this->Session->setFlash('Wishlist was not deleted', 'flash_success');
        $this->redirect(array('controller' => 'Users', 'action' => 'showwishlist')); 
    }
    
    ///////////////////
    
   public function  api_wishlist_deleteall(){
       
                     $this->layout = 'ajax';
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
     
             $this->loadModel("Wishlist");  
            if ($this->request->is('post')) {
        if ($this->Wishlist->deleteAll(array('Wishlist.user_id' => $redata->User->uid))) {
           $response['status'] = true;
          $response['msg'] = 'Wishlist deleted';
        }else{
         $response['status'] = true;
          $response['msg'] = '';
            }
          }
          
          echo json_encode($response);
        exit;
       
   }
    
    
    ////////////////////////
    
    public function api_addwishlist(){
     $this->layout = 'ajax';
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
      //  exit;
     
       // echo '<pre>';print_r($_POST);die(); 
   $this->loadModel("Wishlist");
        if ($this->request->is('post')) {
          
          $cnt = $this->Wishlist->find('count', array('conditions' => array('AND' => array('Wishlist.user_id' => $redata->User->uid, 'Wishlist.product_id' =>$redata->Product->id))));
            if ($cnt == 0) {  
            
            
            $this->Wishlist->create();
            if ($this->Wishlist->save(array('user_id'=> $redata->User->uid,'product_id'=> $redata->Product->id))) {
          $response['status'] = true;
          $response['msg'] = 'The Wishlist has been saved';
              
            } else {
               $response['status'] = true;
               $response['msg'] = 'Sorry try again';     
            }

        }else{
            
          $response['status'] = false;
          $response['msg'] = 'This Item already add in wishlist';   
        }
        } 
        
        echo json_encode($response);
        exit;
        
    }

    public function products() {

        $this->Paginator = $this->Components->load('Paginator');

        $this->Paginator->settings = array(
            'Product' => array(
                'recursive' => -1,
                'contain' => array(
                    'Brand'
                ),
                'limit' => 20,
                'conditions' => array(
                    'Product.active' => 1,
                    'Brand.active' => 1
                ),
                'order' => array(
                    'Product.name' => 'ASC'
                ),
                'paramType' => 'querystring',
            )
        );
        $products = $this->Paginator->paginate();
        $this->set(compact('products'));

        $this->set('title_for_layout', 'All Products - ' . Configure::read('Settings.SHOP_TITLE'));

    }
    /////////////////////////////////////////
    
      public function api_restaurantslist() {    
           configure::write('debug', 0);  
       // $this->Product->recursive = 2;
        //$this->layout = "ajax";
         $data = $this->Product->find('all');

		$cnt = count($data);
		
		  for ($i = 0; $i < $cnt; $i++) { 
                if ($data[$i]['Product']['image']) {
                    $data[$i]['Product']['image'] = Router::url('/', true). 'images/large/'. $data[$i]['Product']['image'];
                } else {
                    $data[$i]['Product']['image'] = Router::url('/', true). 'img/no-image.jpg';
                }
            }

        if ($data) {
            $response['product'] = $data;
            $response['isSucess'] = "true";
        } else {
            $response['isSucess'] = 'false'; 
        }

        echo json_encode($response);
        exit;
    }

////////////////////////////////////////////////////////////

    public function view($id = null) {

        $product = $this->Product->find('first', array(
            'recursive' => -1,
            'contain' => array(
                'Category',
                'Brand'
            ),
            'conditions' => array(
                'Brand.active' => 1,
                'Product.active' => 1,
                'Product.slug' => $id
            )
        ));
       $ids = $product['Product']['id'];
        $this->loadModel("Review"); 
        $review = $this->Review->find('all', array(
            'recursive' => -1,
            'conditions' => array(
                'Review.product_id' => $ids 
            ),
            'order' => array(
                'Review.id' => 'DESC'  
            )
        ));
         $this->loadModel("Admin_contact");
           $qustion = $this->Admin_contact->find('all', array(
            'recursive' => -1,
            'conditions' => array(
                'Admin_contact.product_id' => $ids 
            )
        ));
     
        if (empty($product)) {
            return $this->redirect(array('action' => 'index'), 301);
        }

        $this->Product->updateViews($product);
        
         if (!empty($product)) {
             $products_slider = $this->Product->find('first', array(
            'recursive' => 2,
            'conditions' => array(
                'Product.active' => 1,
                'Product.id' => $ids
            
            )
            
        ));
         }    
        
         $products_braslate = $this->Product->find('all', array(
            'recursive' => 2,
         
            'limit' => 4,
            'conditions' => array(
                'Product.category_id' => 3
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
            'limit' =>  4,
            'conditions' => array(
                'Product.active' => 1,
                'Product.category_id' => 4
              
            ),
            'order' => array(
                'Product.id' => 'DESC'
            )
        ));
       $this->loadModel("Staticpage"); 
       $return = $this->Staticpage->find('first',array('conditions'=>array('AND'=>array('Staticpage.position'=>'return&exchange','Staticpage.status'=>1))));
       $this->set('return',$return); 
        
        

        $this->set(compact('product'));
        $this->set(compact('review'));
        $this->set(compact('qustion'));
        $this->set(compact('products_slider'));
   
        $this->set(compact('products_instagram'));
        $this->set(compact('products_braslate'));  

        $productmods = $this->Product->Productmod->getAllProductMods($product['Product']['id'], $product['Product']['price']);
        $this->set('productmodshtml', $productmods['productmodshtml']);

        $this->set('title_for_layout', $product['Product']['name'] . ' ' . Configure::read('Settings.SHOP_TITLE'));

    }



////////////////////////////////

    public function search() {

        $search = null;
        if(!empty($this->request->query['search']) || !empty($this->request->data['name'])) {
            $search = empty($this->request->query['search']) ? $this->request->data['name'] : $this->request->query['search'];
            $search = preg_replace('/[^a-zA-Z0-9 ]/', '', $search);
            $terms = explode(' ', trim($search));
            $terms = array_diff($terms, array(''));
            $conditions = array(
                'Brand.active' => 1,
                'Product.active' => 1,
            );
            foreach($terms as $term) {
                $terms1[] = preg_replace('/[^a-zA-Z0-9]/', '', $term);
                $conditions[] = array('Product.name LIKE' => '%' . $term . '%');
            }
            $products = $this->Product->find('all', array(
                'recursive' => -1,
                'contain' => array(
                    'Brand'
                ),
                'conditions' => $conditions,
                'limit' => 200,
            ));
            if(count($products) == 1) {
                return $this->redirect(array('controller' => 'products', 'action' => 'view', 'slug' => $products[0]['Product']['slug']));
            }
            $terms1 = array_diff($terms1, array(''));
            $this->set(compact('products', 'terms1'));
        }
        $this->set(compact('search'));

        if ($this->request->is('ajax')) {
            $this->layout = false;
            $this->set('ajax', 1);
        } else {
            $this->set('ajax', 0);
        }

        $this->set('title_for_layout', 'Search');

        $description = 'Search';
        $this->set(compact('description'));

        $keywords = 'search';
        $this->set(compact('keywords'));
    }
	
	
	
	////////////////////////////
	
	////////////////////////////////////////////////////////////

    public function api_search() {
		
		
		     $this->layout = 'ajax';
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'ipn.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);

        $search = null;
        if(!empty($redata->keyword)) {
            $search = $redata->keyword;
            $search = preg_replace('/[^a-zA-Z0-9 ]/', '', $search);
            $terms = explode(' ', trim($search));
            $terms = array_diff($terms, array(''));
            $conditions = array(
                'Brand.active' => 1,
                'Product.active' => 1,
            );
            foreach($terms as $term) {
                $terms1[] = preg_replace('/[^a-zA-Z0-9]/', '', $term);
                $conditions[] = array('Product.name LIKE' => '%' . $term . '%');
            }
            $products = $this->Product->find('all', array(
                'recursive' => -1,
                'contain' => array(
                    'Brand'
                ),
                'conditions' => $conditions,
                'limit' => 200,
            ));
         
		 
		 	
		$cnt = count($products);
		
		  for ($i = 0; $i < $cnt; $i++) { 
                if ($products[$i]['Product']['image']) {
                    $products[$i]['Product']['image'] = Router::url('/', true). 'images/large/'. $products[$i]['Product']['image'];
                } else {
                    $products[$i]['Product']['image'] = Router::url('/', true). 'img/no-image.jpg';
                }
            }
		 
		 
		  if ($products) {
            $response['isSuccess'] = "true";
            $response['product'] = $products;
        }else{
			$response['isSuccess'] = "false";
            $response['msg'] = 'Product not founds';
			
		}
       
        }
           echo json_encode($response); 
		   exit;
    }

////////////////////////////////////////////////////////////

    public function searchjson() {

        $term = null;
        if(!empty($this->request->query['term'])) {
            $term = $this->request->query['term'];
            $terms = explode(' ', trim($term));
            $terms = array_diff($terms, array(''));
            $conditions = array(
                // 'Brand.active' => 1,
                'Product.active' => 1
            );
            foreach($terms as $term) {
                $conditions[] = array('Product.name LIKE' => '%' . $term . '%');
            }
            $products = $this->Product->find('all', array(
                'recursive' => -1,
                'contain' => array(
                    // 'Brand'
                ),
                'fields' => array(
                    'Product.id',
                    'Product.name',
                    'Product.image'
                ),
                'conditions' => $conditions,
                'limit' => 20,
            ));
        }
        // $products = Hash::extract($products, '{n}.Product.name');
        echo json_encode($products);
        $this->autoRender = false;

    }

////////////////////////////////////////////////////////////

    public function sitemap() {
        $products = $this->Product->find('all', array(
            'recursive' => -1,
            'contain' => array(
                'Brand'
            ),
            'fields' => array(
                'Product.slug'
            ),
            'conditions' => array(
                'Brand.active' => 1,
                'Product.active' => 1
            ),
            'order' => array(
                'Product.created' => 'DESC'
            ),
        ));
        $this->set(compact('products'));

        $website = Configure::read('Settings.WEBSITE');
        $this->set(compact('website'));

        $this->layout = 'xml';
        $this->response->type('xml');
    }

////////////////////////////////////////////////////////////

    public function admin_reset() {
        $this->Session->delete('Product');
        return $this->redirect(array('action' => 'index'));
    }

////////////////////////////////////////////////////////////

    public function admin_index() {

        if ($this->request->is('post')) {

            if($this->request->data['Product']['active'] == '1' || $this->request->data['Product']['active'] == '0') {
                $conditions[] = array(
                    'Product.active' => $this->request->data['Product']['active']
                );
                $this->Session->write('Product.active', $this->request->data['Product']['active']);
            } else {
                $this->Session->write('Product.active', '');
            }

            if(!empty($this->request->data['Product']['brand_id'])) {
                $conditions[] = array(
                    'Product.brand_id' => $this->request->data['Product']['brand_id']
                );
                $this->Session->write('Product.brand_id', $this->request->data['Product']['brand_id']);
            } else {
                $this->Session->write('Product.brand_id', '');
            }

            if(!empty($this->request->data['Product']['name'])) {
                $filter = $this->request->data['Product']['filter'];
                $this->Session->write('Product.filter', $filter);
                $name = $this->request->data['Product']['name'];
                $this->Session->write('Product.name', $name);
                $conditions[] = array(
                    'Product.' . $filter . ' LIKE' => '%' . $name . '%'
                );
            } else {
                $this->Session->write('Product.filter', '');
                $this->Session->write('Product.name', '');
            }

            $this->Session->write('Product.conditions', $conditions);
            return $this->redirect(array('action' => 'index'));

        }

        if($this->Session->check('Product')) {
            $all = $this->Session->read('Product');
        } else {
            $all = array(
                'active' => '',
                'brand_id' => '',
                'name' => '',
                'filter' => '',
                'conditions' => ''
            );
        }
        $this->set(compact('all'));

        $this->Paginator = $this->Components->load('Paginator');

        $this->Paginator->settings = array(
            'Product' => array(
                'contain' => array(
                    'Category',
                    'Brand',
                ),
                'recursive' => -1,
                'limit' => 50,
                'conditions' => $all['conditions'],
                'order' => array(
                    'Product.name' => 'ASC'
                ),
                'paramType' => 'querystring',
            )
        );
        $products = $this->Paginator->paginate();

        $brands = $this->Product->Brand->findList();

        $brandseditable = array();
        foreach ($brands as $key => $value) {
            $brandseditable[] = array(
                'value' => $key,
                'text' => $value,
            );
        }

        // $categories= $this->Product->Category->find('list', array(
        //  'recursive' => -1,
        //  'order' => array(
        //      'Category.name' => 'ASC'
        //  )
        // ));

        $categories = $this->Product->Category->generateTreeList(null, null, null, '--');

        $categorieseditable = array();
        foreach ($categories as $key => $value) {
            $categorieseditable[] = array(
                'value' => $key,
                'text' => $value,
            );
        }

        $tags = ClassRegistry::init('Tag')->find('all', array(
            'order' => array(
                'Tag.name' => 'ASC'
            ),
        ));

        $this->set(compact('products', 'brands', 'brandseditable', 'categorieseditable', 'tags'));

    }

////////////////////////////////////////////////////////////

    public function admin_view($id = null) {

        if (($this->request->is('post') || $this->request->is('put')) && !empty($this->request->data['Product']['image']['name'])) {

            $this->Img = $this->Components->load('Img');

            $newName = $this->request->data['Product']['slug'];

            $ext = $this->Img->ext($this->request->data['Product']['image']['name']);

            $origFile = $newName . '.' . $ext;
            $dst = $newName . '.jpg';

            $targetdir = WWW_ROOT . 'images/original';

            $upload = $this->Img->upload($this->request->data['Product']['image']['tmp_name'], $targetdir, $origFile);

            if($upload == 'Success') {
                $this->Img->resampleGD($targetdir . DS . $origFile, WWW_ROOT . 'images/large/', $dst, 800, 800, 1, 0);
                $this->Img->resampleGD($targetdir . DS . $origFile, WWW_ROOT . 'images/small/', $dst, 180, 180, 1, 0);
                $this->request->data['Product']['image'] = $dst;
            } else {
                $this->request->data['Product']['image'] = '';
            }

            if ($this->Product->save($this->request->data)) {
                $this->Session->setFlash($upload);
                return $this->redirect($this->referer());
            } else {
                $this->Session->setFlash('The Product could not be saved. Please, try again.', 'flash_success');
            }
        }

        if (!$this->Product->exists($id)) {
            throw new NotFoundException('Invalid product');
        }
        $product = $this->Product->find('first', array(
            'recursive' => -1,
            'contain' => array(
                'Category',
                'Brand',
            ),
            'conditions' => array(
                'Product.id' => $id
            )
        ));
        $this->set(compact('product'));
    }

////////////////////////////////////////////////////////////

    public function admin_add() {
         configure::write('debug', 0); 
        if ($this->request->is('post')) {
            
         $image = $this->request->data['Product']['image'];
            $uploadFolder = "large";
            //full path to upload folder
            $uploadPath = WWW_ROOT . '/images/' . $uploadFolder;
            //check if there wasn't errors uploading file on serwer
             
            if ($image['error'] == 0) {  
                $imageName = $image['name'];
               
                //check if file exists in upload folder
                if (file_exists($uploadPath . DS . $imageName)) {
                    //create full filename with timestamp
                    $imageName = date('His') . $imageName;
                }
                //create full path with image
                $full_image_path = $uploadPath . DS . $imageName;
                $this->request->data['Product']['image'] = $imageName;
                move_uploaded_file($image['tmp_name'], $full_image_path);
               
            } 
            
            $this->Product->create();
            if ($this->Product->save($this->request->data)) { 
                $this->Session->setFlash('The product has been saved', 'flash_success');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The product could not be saved. Please, try again.', 'flash_success');
            }
        }
        $brands = $this->Product->Brand->find('list');
        $this->set(compact('brands'));
        
          $colours = $this->Product->Colour->find('list');
        $this->set(compact('colours')); 
        
          $themes = $this->Product->Theme->find('list');
        $this->set(compact('themes'));
        
          $styles = $this->Product->Style->find('list');
        $this->set(compact('styles'));
        
         $gemstones = $this->Product->Gemstone->find('list');
        $this->set(compact('gemstones'));
         $materials= $this->Product->Material->find('list');
        $this->set(compact('materials'));
        
     $mechanisms= $this->Product->Mechanism->find('list');
       $this->set(compact('mechanisms')); 
		
		 $series = $this->Product->Series->find('list');
       $this->set(compact('series')); 
	   
	   	 $woodtypes = $this->Product->Woodtype->find('list');
       $this->set(compact('woodtypes')); 

        $categories = $this->Product->Category->generateTreeList(null, null, null, '--');
        $this->set(compact('categories'));
    }

////////////////////////////////////////////////////////////

    public function admin_edit($id = null) {
        if (!$this->Product->exists($id)) {
            throw new NotFoundException('Invalid product');
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            
            
             $image = $this->request->data['Product']['image'];
            $uploadFolder = "large";
            //full path to upload folder
            $uploadPath = WWW_ROOT . '/images/' . $uploadFolder;
            //check if there wasn't errors uploading file on serwer
            if ($image['error'] == 0) {
                //image file name
                $imageName = $image['name'];
                //check if file exists in upload folder
                if (file_exists($uploadPath . DS . $imageName)) {
                    //create full filename with timestamp
                    $imageName = date('His') . $imageName;
                }
                //create full path with image
                $full_image_path = $uploadPath . DS . $imageName;
                $this->request->data['Product']['image'] = $imageName;
                move_uploaded_file($image['tmp_name'], $full_image_path);
                $this->Product->id = $id;
            } else {

                $admin_edit = $this->Product->find('first', array('conditions' => array('Product.id' => $id)));
                $this->request->data['Product']['image'] = !empty($admin_edit['Product']['image']) ? $admin_edit['Product']['image'] : ' ';
            }
            
  
            if ($this->Product->save($this->request->data)) {
                $this->Session->setFlash('The product has been saved', 'flash_success');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The product could not be saved. Please, try again.', 'flash_success');
            }
        } else {
            $product = $this->Product->find('first', array(
                'conditions' => array(
                    'Product.id' => $id
                )
            ));
            $this->request->data = $product;
        }

        $this->set(compact('product'));

        $brands = $this->Product->Brand->find('list');
        $this->set(compact('brands'));
        
              $colours = $this->Product->Colour->find('list');
        $this->set(compact('colours')); 
        
          $themes = $this->Product->Theme->find('list');
        $this->set(compact('themes'));
        
          $styles = $this->Product->Style->find('list');
        $this->set(compact('styles'));
        
        
        $gemstones = $this->Product->Gemstone->find('list');
        $this->set(compact('gemstones'));
        
          $materials = $this->Product->Material->find('list');
        $this->set(compact('materials')); 
        
		 $mechanisms= $this->Product->Mechanism->find('list');
       $this->set(compact('mechanisms'));
	   
	    $series = $this->Product->Series->find('list');
       $this->set(compact('series')); 
	   
	    $woodtypes = $this->Product->Woodtype->find('list');
       $this->set(compact('woodtypes')); 
        

        $categories = $this->Product->Category->generateTreeList(null, null, null, '--'); 
        $this->set(compact('categories'));

       /* $productmods = $this->Product->Productmod->find('all', array(
            'conditions' => array(
                'Productmod.product_id' => $product['Product']['id']
            ) 
        ));
        $this->set(compact('productmods'));*/

    }

////////////////////////////////////////////////////////////
 
    public function admin_tags($id = null) { 

        $tags = ClassRegistry::init('Tag')->find('all', array(
            'recursive' => -1,
            'fields' => array(
                'Tag.name'
            ),
            'order' => array(
                'Tag.name' => 'ASC'
            ),
        ));
        $tags = Hash::combine($tags, '{n}.Tag.name', '{n}.Tag.name');
        $this->set(compact('tags'));

        if ($this->request->is('post') || $this->request->is('put')) {

            $tagstring = '';

            foreach($this->request->data['Product']['tags'] as $tag) {
                $tagstring .= $tag . ', ';
            }

            $tagstring = trim($tagstring);
            $tagstring = rtrim($tagstring, ',');

            $this->request->data['Product']['tags'] = $tagstring;

            $this->Product->save($this->request->data, false);

            return $this->redirect(array('action' => 'tags', $this->request->data['Product']['id']));

        }

        $product = $this->Product->find('first', array(
            'conditions' => array(
                'Product.id' => $id
            )
        ));
        if (empty($product)) {
            throw new NotFoundException('Invalid product');
        }
        $this->set(compact('product'));

        $selectedTags = explode(',', $product['Product']['tags']);
        $selectedTags = array_map('trim', $selectedTags);
        $this->set(compact('selectedTags'));

        $neighbors = $this->Product->find('neighbors', array('field' => 'id', 'value' => $id));
        $this->set(compact('neighbors'));

    }

////////////////////////////////////////////////////////////

    public function admin_csv() {
        $products = $this->Product->find('all', array(
            'recursive' => -1,
        ));
        $this->set(compact('products'));
        $this->layout = false;
    }

////////////////////////////////////////////////////////////

    public function admin_delete($id = null) {
        $this->Product->id = $id;
        if (!$this->Product->exists()) {
            throw new NotFoundException('Invalid product');
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Product->delete()) {
            $this->Session->setFlash('Product deleted', 'flash_success');
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Product was not deleted', 'flash_success');
        return $this->redirect(array('action' => 'index'));
    }
    
    public function api_popularprod(){ 
          Configure::write("debug", 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);

        if($redata){
       $data = $this->Product->find('all',array(
            'order' => array(
                'Product.avg_rating' => $redata->sortBy->popularity
            )
        ));

		
		$cnt = count($data);
		
		  for ($i = 0; $i < $cnt; $i++) { 
                if ($data[$i]['Product']['image']) {
                    $data[$i]['Product']['image'] = Router::url('/', true). 'images/large/'. $data[$i]['Product']['image'];
                } else {
                    $data[$i]['Product']['image'] = Router::url('/', true). 'img/no-image.jpg';
                }
            }
		
       if($data){ 
         $response['isSucess'] = 'true';
            $response['product'] = $data;
       }else{
         $response['error'] = '1';
         $response['data'] = '';   
       }
        }
        
      echo json_encode($response);
        exit;   
    
        
       }
	   
	   ////////////////////////////////////////////////////////////
		public function api_returnpolicy(){
		      $this->loadModel("Staticpage"); 
       $return = $this->Staticpage->find('first',array('conditions'=>array('AND'=>array('Staticpage.position'=>'return&exchange','Staticpage.status'=>1))));
	   
	     if($return){ 
         $response['isSuccess'] = 'true';
         $response['product'] = $return;
       }else{
         $response['error'] = '1';
         $response['data'] = '';   
       }
	   
	       echo json_encode($response);
        exit;  
      
		}
		
		//////////////////////////
		
		
	public function admin_uploadproductimage() {
		  
		configure::write("debug", 0);
		$pro_id = $this->params['url']['pro_id'];
		$product_id = $this->request->data['product_id'];
           
        if (!empty($_FILES)) {
           
            $image = $_FILES['file'];
            $uploadFolder = "large";
            $uploadPath = WWW_ROOT . '/images/' . $uploadFolder;
            if ($image['error'] == 0) {
                $imageName = $image['name'];
                if (file_exists($uploadPath . DS . $imageName)) {
                    $imageName = date('His') . $imageName;
                }
                $full_image_path = $uploadPath . DS . $imageName;
                move_uploaded_file($image['tmp_name'], $full_image_path);
                
                $this->loadModel('Gallery');
                $this->request->data['Gallery']['product_id'] = $product_id;
                $this->request->data['Gallery']['image'] = $imageName;
                $this->Gallery->create();
               // debug($this->request->data);
               $this->Gallery->save($this->request->data);
			   return $this->redirect('http://' .$_POST['server']);
			   
            }
        } else {

            $this->loadModel('Gallery');
            $data = $this->Gallery->find('all', array('conditions' => array('Gallery.product_id' => $pro_id)));
            $this->set('gallery', $data);
            
        }
       
    }

     public function admin_deletegallery($id = null) {
           $this->loadModel("Gallery");  
           $gid = $this->request->query('gid');
		  $pid = $this->request->query('pid'); 
        if ($this->Gallery->deleteAll(array('Gallery.id' => $gid))) {
            $this->Session->setFlash('Gallery item deleted successfully', 'flash_success');
            
         return $this->redirect('http://rupak.crystalbiltech.com/shop/admin/products/uploadproductimage?pro_id='.$pid);
        }
        $this->Session->setFlash('Gallery item was not deleted', 'flash_success');
        return $this->redirect('http://rupak.crystalbiltech.com/shop/admin/products/uploadproductimage?pro_id='.$pid); 
    }

////////////////////////////////////////////////////////////

}