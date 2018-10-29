<?php

App::uses('AppController', 'Controller');

class CategoriesController extends AppController {

////////////////////////////////////////////////////////////
    public $components = array('Paginator');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('api_catview'));
    }

    public function index() {
        $this->helpers[] = 'Tree';
        $categories = $this->Category->find('all', array(
            'recursive' => -1,
            'order' => array(
                'Category.lft' => 'ASC'
            ),
            'conditions' => array(
            ),
        ));
        $this->set(compact('categories'));
    }

////////////////////////////////////////////////////////////

    public function api_catview() {
        Configure::write("debug", 0);

        $this->helpers[] = 'Tree';
        $categories = $this->Category->find('threaded');
		
        $this->loadModel('Colour');
		$this->loadModel("Woodtype");
        $this->loadModel("Brand");
		$this->loadModel("Series");
        $this->loadModel("Mechanism");
		$this->loadModel("Theme");
        $this->loadModel("Style");
        $this->loadModel("Gemstone");
		
        $colour = $this->Colour->find('all'); 
		$tag = $this->Woodtype->find('all');
		$brand = $this->Brand->find('all');	
		$series = $this->Series->find('all');
		$mechanism = $this->Mechanism->find('all');
		$theme = $this->Theme->find('all');	
		$style = $this->Style->find('all');
		$gemstone = $this->Gemstone->find('all');
			
        if ($categories) {
            $response['isSucess'] = 'true';
            $response['data']['category'] = $categories;
            $response['data']['colour'] = $colour;
			$response['data']['woodtype'] = $tag;
			$response['data']['brand'] = $brand;
			$response['data']['series'] = $series;
			$response['data']['mechanism'] = $mechanism;
			
			$response['data']['theme'] = $theme;
			$response['data']['style'] = $style;
			$response['data']['gemstone'] = $gemstone;
        } else {
            $response['error'] = '1';
            $response['data'] = '';
        }
        echo json_encode($response);
        exit;
    }

    ////////////////////////////////////////////////////////////////   

    public function view($slug = null) {

        configure::write('debug', 0);

        $category = $this->Category->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'Category.slug' => $slug
            )
        ));
        if (empty($category)) {
            return $this->redirect(array('action' => 'index'));
        }
        $this->set(compact('category'));

        // $parent = $this->Category->getParentNode($category['Category']['id']);
        // debug($parent);

        $parents = $this->Category->getPath($category['Category']['id']);
        // debug($parents);
        $this->set(compact('parents'));

        // $totalChildren = $this->Category->childCount($category['Category']['id']);
        // debug($totalChildren);

        $directChildren = $this->Category->children($category['Category']['id']);
        // debug($directChildren);

        $directChildrenIds = Hash::extract($directChildren, '{n}.Category.id');
        array_push($directChildrenIds, $category['Category']['id']);
        $this->set(compact('directChildren'));
        //debug($parents);

        /*  $products = $this->Category->Product->find('all', array(
          'recursive' => 2,
          'conditions' => array(
          'Product.category_id' => $directChildrenIds
          ),
          'order' => array(
          'Product.name' => 'ASC'
          ),
          'limit' => 50
          )); */



        if ($this->request->is('post')) {


            if ($this->request->data['brand'] != null) {
                $conditions[] = array(
                    'Product.brand_id' => $this->request->data['brand'],
                );
            }

            if ($this->request->data['serise'] != null) {
                $conditions[] = array(
                    'Product.series' => $this->request->data['serise'],
                );
            }
            if ($this->request->data['woodtype'] != null) {
				
                $conditions[] = array(
                    'Product.woodtype_id' => $this->request->data['woodtype'],
                );
            }

            if ($this->request->data['category'] != null) {
                $conditions[] = array(
                    'Product.category_id' => $this->request->data['category'],
                );
            }


            if ($this->request->data['theme'] != null) {
                $conditions[] = array(
                    'Product.theme_id' => $this->request->data['theme'],
                );
            }

            if ($this->request->data['colour'] != null) {
                $conditions[] = array(
                    'Product.colour_id' => $this->request->data['colour'],
                );
            }
            if ($this->request->data['style'] != null) {
                $conditions[] = array(
                    'Product.style_id' => $this->request->data['style'],
                );
            }

            if ($this->request->data['material'] != null) {
                $conditions[] = array(
                    'Product.material_id' => $this->request->data['material'],
                );
            }


            if ($this->request->data['gemstone'] != null) {
                $conditions[] = array(
                    'Product.gemstone_id' => $this->request->data['gemstone'],
                );
            }


            if ($this->request->data['mechanism'] != null) {
                $conditions[] = array(
                    'Product.mechanism_id' => $this->request->data['mechanism'],
                );
            }


            if ($_POST['producct_popular'] != null) {
                $orderbypopulardesc = array(
                    'Product.avg_rating' => $_POST['producct_popular']
                );
            }


            if ($this->request->data['r11'] != null) {
                $conditions[] = array('AND' => array('Product.price BETWEEN ? and ?' => array($this->request->data['r11'], $this->request->data['r12']),
                        'Product.category_id' => $category['Category']['id'])
                );
            }
        }


        $condition1 = array(
            'Product.category_id' => $directChildrenIds
        );
        $finalcondition = $conditions ? $conditions : $condition1;

        ///////////////////////////order by condition////////////
        $orderbyname = array(
            'Product.name' => 'ASC'
        );
        $orderby = $orderbypopulardesc ? $orderbypopulardesc : $orderbyname;






        $this->Paginator->settings = array(
            'recursive' => 2,
            'conditions' => $finalcondition, 'order' => $orderby,
            'limit' => 12
        );
        $products = $this->Paginator->paginate('Product');

        if (count($products) == 0) {
            $this->Session->setFlash('Product Not found in this criteria.', 'flash_error');
        }

        $this->set(compact('products'));


        $this->loadModel("Review");
        $this->loadModel("Woodtype");
        $this->loadModel("Brand");
        $this->loadModel("Colour");
        $this->loadModel("Theme");
        $this->loadModel("Style");
        $this->loadModel("Gemstone");
        $this->loadModel("Material");
        $this->loadModel("Series");
        $this->loadModel("Mechanism");

        $alltag = $this->Woodtype->find('all');
        $serise = $this->Series->find('all');
        $brand = $this->Brand->find('all');
        $categorys = $this->Category->find('all');
        $color = $this->Colour->find('all');
        $theme = $this->Theme->find('all');
        $style = $this->Style->find('all');
        $gemstone = $this->Gemstone->find('all');
        $material = $this->Material->find('all');
        $mechanism = $this->Mechanism->find('all');
        $this->set(compact('alltag'));
        $this->set(compact('brand'));
        $this->set(compact('categorys'));
        $this->set(compact('serise'));
        $this->set(compact('color'));
        $this->set(compact('theme'));
        $this->set(compact('style'));
        $this->set(compact('gemstone'));
        $this->set(compact('material'));
        $this->set(compact('mechanism'));




        $this->loadModel('Product');


        $products_instagram = $this->Product->find('all', array(
            'recursive' => -1,
            'contain' => array(
                'Brand'
            ),
            'limit' => 12,
            'conditions' => array(
                'Product.active' => 1,
                'Product.category_id' => 10,
                'Brand.active' => 1
            ),
            'order' => array(
                'Product.id' => 'DESC'
            )
        ));


        $popular = $this->Product->find('all', array(
            'recursive' => 2,
            'limit' => 2,
            'conditions' => array(
                'Product.category_id' => $directChildrenIds
            ),
            'order' => array(
                'Product.avg_rating' => 'DESC'
            )
        ));

        $this->set(compact('products_instagram'));
        $this->set(compact('popular'));
    }

////////////////////////////////////////////////////////////

    public function admin_index() {
        $this->Paginator = $this->Components->load('Paginator');
        $this->Paginator->settings = array(
            'Category' => array(
                'recursive' => 0,
            )
        );
        $this->set('categories', $this->Paginator->paginate());

        $this->helpers[] = 'Tree';
        $categoriestree = $this->Category->find('all', array(
            'recursive' => -1,
            'order' => array(
                'Category.lft' => 'ASC'
            ),
            'conditions' => array(
            ),
        ));
        $this->set(compact('categoriestree'));
    }

////////////////////////////////////////////////////////////

    public function admin_view($id = null) {
        if (!$this->Category->exists($id)) {
            throw new NotFoundException('Invalid category');
        }
        $category = $this->Category->find('first', array(
            'contain' => array(
                'ParentCategory'
            ),
            'conditions' => array(
                'Category.id' => $id
            )
        ));
        $this->set(compact('category'));
    }

////////////////////////////////////////////////////////////

    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Category->create();
            if ($this->Category->save($this->request->data)) {
                $this->Session->setFlash('The category has been saved');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The category could not be saved. Please, try again.');
            }
        }

        $parents = $this->Category->generateTreeList(null, null, null, ' -- ');
        $this->set(compact('parents'));
    }

////////////////////////////////////////////////////////////

    public function admin_edit($id = null) {
        if (!$this->Category->exists($id)) {
            throw new NotFoundException('Invalid category');
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Category->save($this->request->data)) {
                $this->Session->setFlash('The category has been saved');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The category could not be saved. Please, try again.');
            }
        } else {
            $this->request->data = $this->Category->find('first', array('conditions' => array('Category.id' => $id)));
        }

        $parents = $this->Category->generateTreeList(null, null, null, ' -- ');
        $this->set(compact('parents'));
    }

////////////////////////////////////////////////////////////

    public function admin_delete($id = null) {
        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException('Invalid category');
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Category->delete()) {
            $this->Session->setFlash('Category deleted');
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Category was not deleted');
        return $this->redirect(array('action' => 'index'));
    }

////////////////////////////////////////////////////////////
}
