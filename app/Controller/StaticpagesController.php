<?php

App::uses('AppController', 'Controller');

/**

 * Staticpages Controller

 *

 * @property Staticpage $Staticpage

 * @property PaginatorComponent $Paginator

 */

class StaticpagesController extends AppController {

    

    public function beforeFilter() {

        parent::beforeFilter();

        $this->Auth->allow(array('terms','wooden_watches','wooden_bracelets',
		'organict_shirts','shop_instagram','our_story','cust_reviews','about_wear_org','api_aboutus'));
        $this->loadModel("Product");
        $this->loadModel("Review");
        $this->loadModel("Tag"); 
        $this->loadModel("Brand");
        $this->loadModel("Category");
		$this->loadModel("Series");
        
    }

  

    /**

 * Components

 *

 * @var array

 */

	public $components = array('Paginator');



/**

 * index method

 *

 * @return void

 */

	public function index() {

		$this->Staticpage->recursive = 0;

		$this->set('staticpages', $this->Paginator->paginate());

	}
        
   



/**

 * view method

 *

 * @throws NotFoundException

 * @param string $id

 * @return void

 */

	public function view($id = null) {

		if (!$this->Staticpage->exists($id)) {

			throw new NotFoundException(__('Invalid staticpage'));

		}

		$options = array('conditions' => array('Staticpage.' . $this->Staticpage->primaryKey => $id));

		$this->set('staticpage', $this->Staticpage->find('first', $options));

	}



/**

 * add method

 *

 * @return void

 */

	public function add() {

		if ($this->request->is('post')) {

			$this->Staticpage->create();

			if ($this->Staticpage->save($this->request->data)) {

				$this->Session->setFlash(__('The staticpage has been saved.'));

				return $this->redirect(array('action' => 'index'));

			} else {

				$this->Session->setFlash(__('The staticpage could not be saved. Please, try again.'));

			}

		}

	}



/**

 * edit method

 *

 * @throws NotFoundException

 * @param string $id

 * @return void

 */

	public function edit($id = null) {

		if (!$this->Staticpage->exists($id)) {

			throw new NotFoundException(__('Invalid staticpage'));

		}

		if ($this->request->is(array('post', 'put'))) {

			if ($this->Staticpage->save($this->request->data)) {

				$this->Session->setFlash(__('The staticpage has been saved.'));

				return $this->redirect(array('action' => 'index'));

			} else {

				$this->Session->setFlash(__('The staticpage could not be saved. Please, try again.'));

			}

		} else {

			$options = array('conditions' => array('Staticpage.' . $this->Staticpage->primaryKey => $id));

			$this->request->data = $this->Staticpage->find('first', $options);

		}

	}



/**

 * delete method

 *

 * @throws NotFoundException

 * @param string $id

 * @return void

 */

	public function delete($id = null) {

		$this->Staticpage->id = $id;

		if (!$this->Staticpage->exists()) {

			throw new NotFoundException(__('Invalid staticpage'));

		}

		$this->request->allowMethod('post', 'delete');

		if ($this->Staticpage->delete()) {

			$this->Session->setFlash(__('The staticpage has been deleted.'));

		} else {

			$this->Session->setFlash(__('The staticpage could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
/**

 * admin_index method

 *

 * @return void

 */

	public function admin_index() {

		$this->Staticpage->recursive = 0;

                 if($this->request->is("post")){

            if($this->request->data["keyword"]){

                    $keyword = trim($this->request->data["keyword"]);

                $this->paginate = array("limit"=>20,"conditions"=>array("OR"=>array(

                    "Staticpage.title LIKE"=>"%".$keyword."%",
                    "Staticpage.image LIKE"=>"%".$keyword."%",
                    "Staticpage.created LIKE"=>"%".$keyword."%"

                )));

            $this->set("keyword",$keyword);

            }

        }
		$this->set('staticpages', $this->Paginator->paginate());

	}
/**

 * admin_view method

 *

 * @throws NotFoundException

 * @param string $id

 * @return void

 */

	public function admin_view($id = null) {

		if (!$this->Staticpage->exists($id)) {

			throw new NotFoundException(__('Invalid staticpage'));

		}

		$options = array('conditions' => array('Staticpage.' . $this->Staticpage->primaryKey => $id));

		$this->set('staticpage', $this->Staticpage->find('first', $options));

	}



/**

 * admin_add method

 *

 * @return void

 */
        static public function slugify($text)
    {
  // replace non letter or digits by -
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  // trim
  $text = trim($text, '-');

  // remove duplicate -
  $text = preg_replace('~-+~', '-', $text);

  // lowercase
  $text = strtolower($text);

  if (empty($text)) {
    return 'n-a';
  }

  return $text;
    }
        
        
        
        

	public function admin_add() {

	if ($this->request->is('post')) {
           $text = $this->request->data['Staticpage']['title'];
            $slug = $this->slugify($text );
            $this->request->data['Staticpage']['slug']=  $slug;  
            $one = $this->request->data['Staticpage']['image'];

            $image_name = $this->request->data['Staticpage']['image'] = date('dmHis') . $one['name'];

            $this->Staticpage->create();

            if ($this->Staticpage->save($this->request->data)) {

                if ($one['error'] == 0) {

                    $pth = 'files' . DS . 'staticpage' . DS . $image_name;

                    move_uploaded_file($one['tmp_name'], $pth);

                }

                $this->Session->setFlash(__('The staticpage has been saved'));

                $this->redirect(array('action' => 'index'));

            } else {

                $this->Session->setFlash(__('The staticpage could not be saved. Please, try again.'));

            }

          }

	}



/**

 * admin_edit method

 *

 * @throws NotFoundException

 * @param string $id

 * @return void

 */

	public function admin_edit($id = null) {

		$this->Staticpage->id = $id;

        if (!$this->Staticpage->exists()) {

            throw new NotFoundException(__('Invalid Staticpage'));

        }

        if ($this->request->is('post') || $this->request->is('put')) {

			if(@$this->request->data['Staticpage']['image']){

            $one = $this->request->data['Staticpage']['image'];
			

            $image_name = $this->request->data['Staticpage']['image'] = date('dmHis') . $one['name'];

            if ($one['name'] != "") {

                $x = $this->Staticpage->read('image', $id);

                $x = 'files' . DS . 'staticpage' . DS . $x['Staticpage']['image'];

//                unlink($x);

                $pth = 'files' . DS . 'staticpage' . DS . $image_name;

                move_uploaded_file($one['tmp_name'], $pth);

            }

            if ($one['name'] == "") {

                $xc = $this->Staticpage->read('image', $id);

                $this->request->data['Staticpage']['image'] = $xc['Staticpage']['image'];

            }
			}

            if ($this->Staticpage->save($this->request->data)) {

                $this->Session->setFlash(__('The Staticpage has been saved'));

                $this->redirect(array('action' => 'admin_index'));

            } else {

                $this->Session->setFlash(__('The Staticpage could not be saved. Please, try again.'));

            }

        } else {

            $this->request->data = $this->Staticpage->read(null, $id);

        }

        $this->set('admin_edit', $this->Staticpage->find('first', array('conditions' => array('Staticpage.id' => $id))));

    }



/**

 * admin_delete method

 *

 * @throws NotFoundException

 * @param string $id

 * @return void

 */

	public function admin_delete($id = null) {

		$this->Staticpage->id = $id;

		if (!$this->Staticpage->exists()) {

			throw new NotFoundException(__('Invalid staticpage'));

		}

		$this->request->allowMethod('post', 'delete');

		if ($this->Staticpage->delete()) {

			$this->Session->setFlash(__('The staticpage has been deleted.'));

		} else {

			$this->Session->setFlash(__('The staticpage could not be deleted. Please, try again.'));

		}

		return $this->redirect(array('action' => 'index'));

	}

        public function admin_activate($id = null) {
        $this->Staticpage->id = $id;
        if ($this->Staticpage->exists()) {
            $x = $this->Staticpage->save(array(
                'Staticpage' => array(
                    'status' => '1'
                )
            ));
            $this->Session->setFlash(__("Activated successfully."));
            $this->redirect($this->referer());
        } else {
            $this->Session->setFlash(__("Unable to activate."));
            $this->redirect($this->referer());
        }
    }

    public function admin_deactivate($id = null) {
        $this->Staticpage->id = $id;
        if ($this->Staticpage->exists()) {
            $x = $this->Staticpage->save(array(
                'User' => array(
                    'status' => '0'
                )
            ));
            $this->Session->setFlash(__("Activated successfully."));
            $this->redirect($this->referer());
        } else {
            $this->Session->setFlash(__("Unable to activate."));
            $this->redirect($this->referer());
        }
    }

        public function term_conditon(){

            $data=$this->Staticpage->find('all',array('conditions'=>array('AND'=>array('Staticpage.position'=>'t&c','Staticpage.status'=>1))));

            $this->set('tc',$data);

        }

        

         public function wooden_watches(){
			  configure::write('debug', 0);
       $this->Product->recursive = 2;  

	    if ($this->request->is('post')) {
			
			
			 if($this->request->data['brand'] !=null) {
			 $conditions[] = array(
                'Product.brand_id' => $this->request->data['brand'],
            );
			}
			
				 if($this->request->data['serise']!= null) {
			 $conditions[] = array(
                'Product.series' => $this->request->data['serise'],
            );
			}
			 if($this->request->data['tag']!= null) {
			 $conditions[] = array(
                'Product.tags' => $this->request->data['tag'],
            );
			}
			
			 if($this->request->data['category']!= null) {
			 $conditions[] = array(
                'Product.category_id' => $this->request->data['category'],
            );
			}
			
		$this->Paginator->settings = array(
        'conditions' =>$conditions,
        'limit' =>12
		);
			$productswatchpage = $this->Paginator->paginate('Product');
		
			if(count($productswatchpage)==0){
			 $this->Session->setFlash('Product Not found in this criteria.', 'flash_error');
			}
			
          /*  if(!empty($this->request->data['brand'])) {
                $conditions[] = array(
                    'Product.brand_id' => $this->request->data['brand']
                );
                
            } else {
                $conditions[] = array(
                    'Product.brand_id' => null
                );
            }

              if(!empty($this->request->data['tag'])) {
                $conditions[] = array(
                    'Product.tags' => $this->request->data['tag']
                );
                
            } else {
                 $conditions[] = array(
                    'Product.tags' =>null
                );
            }
			
			 if(!empty($this->request->data['serise'])) {
                $conditions[] = array(
                    'Product.series' => $this->request->data['serise']
                );
               
            } else {
                $conditions[] = array(
                    'Product.series' => null
                );
            }
			
		
				 $productswatchpage = $this->Product->find('all', array(
          
            'conditions' => array($conditions),
            'order' => array(
                'Product.id' => 'DESC'
            )
        ));*/

		}else{
			
			$this->Paginator->settings = array(
        'conditions' =>array(
				'Product.category_id' => 2 ),
        'limit' => 12 
		);
			$productswatchpage = $this->Paginator->paginate('Product');
		
		}
	   
      
   
         $alltag = $this->Tag->find('all');
		 $serise = $this->Series->find('all');	
         $brand = $this->Brand->find('all');
         $category = $this->Category->find('all'); 
         $this->set(compact('alltag')); 
         $this->set(compact('brand'));
         $this->set(compact('category'));
		 $this->set(compact('serise'));
     
                
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
           //$this->Product->recursive = 2;   
           // $review  = $this->Product->find('all');
       
           $this->set('productswatchpage',$productswatchpage);
            $this->set(compact('products_instagram'));
        }
        
           public function wooden_bracelets(){
               $this->Product->recursive = 2;  
                $products_braslate = $this->Product->find('all', array(
          
            'conditions' => array(
				'Product.category_id' => 3 ),
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
            
                $this->set(compact('products_instagram'));
                $this->set(compact('products_braslate'));
       
           }
           
              public function organict_shirts(){}
              
                 public function shop_instagram(){
                     
                  $products_instagram = $this->Product->find('all', array(
            'recursive' => -1,
            'contain' => array(
                'Brand'
            ),
           
            'conditions' => array(
                'Product.active' => 1,
                'Product.category_id' => 4,
                'Brand.active' => 1
            ),
            'order' => array(
                'Product.id' => 'DESC'
            )
        ));    
              $this->set(compact('products_instagram'));        
                 }
                 
                 
                 public function our_story(){
                     
                     		$outstory = $this->Staticpage->find('all',array('conditions'=>array('AND'=>array('Staticpage.position'=>'outstory','Staticpage.status'=>1))));
                $this->set('outstory',$outstory);  		
					
                     
                 }
                    public function about_us(){
				$about = $this->Staticpage->find('all',array('conditions'=>array('AND'=>array('Staticpage.position'=>'about','Staticpage.status'=>1))));
                $this->set('abouts',$about);  		
						
					}
					
					//////////////////
			    public function faq(){	  
				$faq = $this->Staticpage->find('all',array('conditions'=>array('AND'=>array('Staticpage.position'=>'faq','Staticpage.status'=>1))));
                $this->set('faqs',$faq);  		  
					  }
					  
					  ///////////////////////
	 public function contact_us(){
          $this->loadModel('User'); //FOR CONTACT US PAGE ADMIN EMAIL
          $contact=$this->User->find('all',array('conditions'=>array('AND'=>array('User.role'=>'admin','User.id'=>1))));
          $this->set('adminemail',$contact);                                    
                                                
            }
					  ////////////////////////
					  
			public function privacy_policy(){
			$privacy = $this->Staticpage->find('all',array('conditions'=>array('AND'=>array('Staticpage.position'=>'privacypolicy','Staticpage.status'=>1))));
            $this->set('privacy',$privacy);  			   
						   
		    }
					   
					    ////////////////////////
					  
					   public function cust_reviews() {
                                               $this->Review->recursive = 2; 
                                            $reviews = $this->Review->find('all');
                                            $this->set('reviews',$reviews);       
                                               
                                           } 
					      
					    ////////////////////////
					   
					   public function blog(){
                                           $blog = $this->Staticpage->find('all',array('conditions'=>array('AND'=>array('Staticpage.position'=>'blog','Staticpage.status'=>1))));
                                            $this->set('blogs',$blog);     
                                               
                                           }
                                           
                                              public function green_plant(){ 
                                           $green = $this->Staticpage->find('all',array('conditions'=>array('AND'=>array('Staticpage.position'=>'green&plant','Staticpage.status'=>1))));
                                            $this->set('greenplant',$green);      
                                               
                                           }
                                           
                                           public function about_wear_org(){ 
                                           $about_wear_org = $this->Staticpage->find('all',array('conditions'=>array('AND'=>array('Staticpage.position'=>'about_wear_org','Staticpage.status'=>1))));
                                            $this->set('about_wear_org',$about_wear_org);       
                                               
                                           }
										   
					public function api_aboutus(){
						$about = $this->Staticpage->find('all',array('conditions'=>array('AND'=>array('Staticpage.position'=>'about','Staticpage.status'=>1,'Staticpage.show_main'=>0))));
						
						$about1 = $this->Staticpage->find('first',array('conditions'=>array('AND'=>array('Staticpage.position'=>'about','Staticpage.status'=>1,'Staticpage.show_main'=>1))));
					if($about){
						
						
						$cnt = count($about);
		
		  for ($i = 0; $i < $cnt; $i++) { 
                if ($about[$i]['Staticpage']['image']) {
                    $about[$i]['Staticpage']['image'] = Router::url('/', true). 'files/staticpage/'. $about[$i]['Staticpage']['image'];
                } else {
                    $about[$i]['Staticpage']['image'] = Router::url('/', true). 'img/no-image.jpg';
                }
            }
						
						
						
						$response['isSucess'] = 'true';
						$response['data']['aboutloop'] = $about;
						$response['data']['aboutmain'] = $about1;
					}else{
						$response['isSucess'] = 'false';
						$response['msg'] = 'Content has not be found';
					}
					
					 echo json_encode($response);
					exit;			
					
					}				   
					

}

