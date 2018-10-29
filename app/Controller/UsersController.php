<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::import('Vendor', 'Facebook', array('file' => 'Facebook' . DS . 'facebook.php'));
App::import('Vendor', 'Twitter', array('file' => 'Twitter' . DS . 'twitteroauth.php'));
App::import('Vendor', 'Google', array('file' => 'Google' . DS . 'autoload.php'));

class UsersController extends AppController {

////////////////////////////////////////////////////////////

    public function beforeFilter() {
        parent::beforeFilter();

        $this->Auth->allow('login', 'admin_add', 'api_login', 'api_registration', 'reset', 'api_useredit', 'add', 'showwishlist', 'api_showwishlist', 'api_verifyEmail', 'api_forgetpwd', 'api_resetpwd', 'user_ask_ques', 'api_changepassword', 'facebook_connect', 'fblogin', 'twitter_process', 'api_saveimage', 'google_login', 'track_order', 'api_orderHistory', 'api_fbloginapp', 'api_twitterlogin', 'api_googlelogin');
    }

////////////////////////////////////////////////////////////



    public function login() {
        // echo AuthComponent::password('admin');

        if ($this->request->is('post')) {
            //echo $this->request->data['User']['server'];exit;
            $sesid = $this->Session->id();
            if ($this->Auth->login()) {

                $this->User->id = $this->Auth->user('id');
                $this->User->saveField('logins', $this->Auth->user('logins') + 1);
                $this->User->saveField('last_login', date('Y-m-d H:i:s'));
                $this->loadModel('Cart');
                $updatesess = $this->Session->id();
                $this->Cart->updateAll(array('Cart.sessionid' => "'$updatesess'"), array('Cart.sessionid' => $sesid));
                if ($this->Auth->user('role') == 'customer') {
                    return $this->redirect('http://' . $this->request->data['User']['server']);
                } elseif ($this->Auth->user('role') == 'admin') {
                    $uploadURL = Router::url('/') . 'app/webroot/upload';
                    $_SESSION['KCFINDER'] = array(
                        'disabled' => false,
                        'uploadURL' => $uploadURL,
                        'uploadDir' => ''
                    );

                    return $this->redirect(array(
                                'controller' => 'products',
                                'action' => 'index',
                                'manager' => false,
                                'admin' => true
                    ));
                } else {
                    $this->Session->setFlash('Login is incorrect', 'flash_success');
                    return $this->redirect('http://' . $this->request->data['User']['server']);
                }
            } else {
                $this->Session->setFlash('Login is incorrect', 'flash_success');
                return $this->redirect('http://' . $this->request->data['User']['server']);
            }
        } else {

            return $this->redirect(array('controller' => 'shop', 'action' => 'index'));
        }
    }

  //////////////////////////////////////////
	public function admin_profile(){ 
	
	}
  ///////////////////////////////////


    public function fblogin() {

        Configure::load('facebook');
        $appId = Configure::read('Facebook.appId');
        $app_secret = Configure::read('Facebook.secret');
        $facebook = new Facebook(array(
            'appId' => $appId,
            'secret' => $app_secret,
        ));

        $loginUrl = $facebook->getLoginUrl(array(
            'scope' => 'email,read_stream, publish_stream, user_birthday, user_location, user_work_history, user_hometown, user_photos',
            'redirect_uri' => 'http://rupak.crystalbiltech.com/shop/users/facebook_connect',
            'display' => 'popup'
        ));
        $this->redirect($loginUrl);
    } 

////////////////////////////////////////////////////////////

    function facebook_connect() {
      configure::write('debug',0);
        Configure::load('facebook');
        $appId = Configure::read('Facebook.appId');
        $app_secret = Configure::read('Facebook.secret');

        $facebook = new Facebook(array(
            'appId' => $appId,
            'secret' => $app_secret,
        ));

        $user = $facebook->getUser();
       //print_r($user);
       //exit;

        if ($user) {
            try {
                $user_profile = $facebook->api('/me?fields=id,email,name,picture');
            
                $options = array('conditions' => array('User.fboo_ids' => $user_profile['id']));
                $data = $this->User->find('first', $options ,array('User.email' => $user_profile['email']));
//                print_r($data);
//                exit;
                if ($data['User']['id']) {
                    $this->request->data['User']['username'] = $data['User']['username'];
                    $this->request->data['User']['password'] =$user_profile['id'] . 'admin';
                    
                      $this->Auth->login(); 
               
                     
                } else {
                    if ($user_profile['email'] == '') {
                        $user_profile['email'] = $user_profile['id'] . '@facebook.com';
                    }

//print_r($user_profile); 

                    $this->request->data['first_name'] = $user_profile['name'];
                    $this->request->data['username'] = $user_profile['email'];
                    $this->request->data['password'] = $user_profile['id'] . 'admin';
                    $this->request->data['email'] = $user_profile['email'];
                    $this->request->data['fboo_ids'] = $user_profile['id'];
                    $this->request->data['role'] = "customer";
                    $this->request->data['active'] = "1";
                    $this->request->data['image'] = $user_profile['picture']['data']['url'];
                    $this->User->create();
                    $this->User->save($this->request->data);
                    $user_id = $this->User->getLastInsertID();
                     
                    if ($user_id) {
                    $this->request->data['User']['username'] = $user_profile['email'];
                    $this->request->data['User']['password'] = $user_profile['id'] . 'admin';
                      $this->Auth->login();
           
                    
                }
                  
                }
                $params = array('next' => 'http://rupak.crystalbiltech.com/shop/users/facebook_logout');
                $logout = $facebook->getLogoutUrl($params);
                $this->Session->write('User', $user_profile);
                $this->Session->write('logout', $logout);
            } catch (FacebookApiException $e) {
                error_log($e);
                $user = NULL;
            }
        } else {
            $this->Session->setFlash('Sorry.Please try again', 'default', array('class' => 'msg_req'));
            $this->redirect(array('action' => 'index'));
        }
    }

//////////////////////////////////////////

    function facebook_logout() {

        $this->Session->delete('User');
        $this->Session->delete('logout');
        $this->redirect(array('controller' => 'pages', 'action' => '/'));
    }

    ///////////////////////////////
    public function myaccount() {
        Configure::write("debug", 0);
     
        $uid = $this->Auth->user('id');

        //$userId = $this->Session->read('User.id');

        //$usersid = $uid ? $uid : $userId;

        if (empty($uid)) {
            return $this->redirect(array('controller' => 'shop', 'action' => 'index'));
        }
        if ($this->request->is("post")) {
            $image = $this->request->data['User']['image'];
            $uploadFolder = "profile_pic";
            //full path to upload folder
            $uploadPath = WWW_ROOT . '/files/' . $uploadFolder;
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
                move_uploaded_file($image['tmp_name'], $full_image_path);
                $img = Router::url('/', true) . 'files/profile_pic/' . $imageName;
                $this->User->updateAll(array('User.image' => "'$img'"), array('User.id' => $uid));
                return $this->redirect(array('action' => 'myaccount'));

                exit;
            }
        }
        if ($uid) {
            $data = $this->User->find('first', array('conditions' => array('User.id' => $uid)));
            $this->set('data', $data);
        } elseif ($usersid) {
            $data = $this->User->find('first', array('conditions' => array('User.fboo_ids' => $usersid)));
            $this->set('data', $data);
        }

        @$resultzz = $_REQUEST['result'];
        //echo 'ssssssssssssssssss';
        if ($resultzz == 'SUCCESS') {
            //echo 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';

            $this->loadModel("Wallet");
            $status = $this->Wallet->find('all', array('conditions' => array('Wallet.uid' => $uid), 'order' => 'Wallet.id DESC', 'limit' => 1));
            //print_r($status);
            $newwalletmoney = $status[0]['Wallet']['amount'];
            $walletmoneyid = $status[0]['Wallet']['id'];

            $userstatus = $this->User->find('all', array('conditions' => array('User.id' => $uid)));
            //print_r($userstatus);
            //echo '<br/>';
            $oldwalletmoney = $userstatus[0]['User']['loyalty_points'];
            @$totalwalletmoney = $newwalletmoney + $oldwalletmoney;
            $this->User->updateAll(array('User.loyalty_points' => $totalwalletmoney), array('User.id' => $uid));
            $this->Wallet->updateAll(array('Wallet.status' => 1), array('Wallet.uid' => $uid, 'Wallet.id' => $walletmoneyid));

            echo "<script>window.location='http://rupak.crystalbiltech.com/shop/users/myaccount'</script>";
            /* $val = $this->request->data['User']['money'];
              $this->request->data['User']['loyalty_points'] = $val;
              $save = $this->User->save($this->request->data); */
        }
    }

/////////////////////////////////////


    public function edit() {
        configure::write('debug', 0);  
        $id = $this->Auth->user('id');
        $this->User->id = $this->Auth->user('id');
        if (!$this->User->exists($id)) {
            return $this->redirect(array('action' => 'myaccount'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $email = $this->Auth->user('email');
            $username = $this->Auth->user('username');
            if (($email == $this->request->data['User']['email']) && ($username == $this->request->data['User']['username'])) {
                if ($this->User->save($this->request->data)) {
                    $this->Session->setFlash(__('Your profile has been updated.', 'flash_success'));
                    return $this->redirect(array('action' => 'myaccount'));
                } else {
                    $this->Session->setFlash(__('The user could not be saved. Please, try again.', 'flash_success'));
                }
            } else {  
                if ($this->User->save($this->request->data)) {
                    $this->Session->setFlash(__('Your profile has been updated.', 'flash_success'));
                    return $this->redirect(array('action' => 'myaccount'));
                } else {
                    $this->Session->setFlash(__('The user could not be saved. Please, try again.', 'flash_success'));
                }
            }
        } else {
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
            $data = $this->request->data = $this->User->find('first', $options);
            $this->set('data', $data);
        }
    }

    ////////////////////////////


    public function api_saveimage() {



        configure::write('debug', 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);

        $one = $redata->User->img;
        $img = base64_decode($one);
        $im = imagecreatefromstring($img);

        if ($im !== false) {

            $image = "1" . time() . ".png";
            imagepng($im, WWW_ROOT . "files" . DS . "profile_pic" . DS . $image);
            imagedestroy($im);
            $response['msg'] = "image is uploaded";
        } else {
            $response['isSucess'] = 'true';
            $response['msg'] = 'Image did not create';
        }


        $this->User->recursive = 2;
        $this->layout = "ajax";
        if (!empty($redata)) {
            $img = Router::url('/', true) . 'files/profile_pic/' . $image;
            $id = $redata->User->id;
            $name = $redata->User->name;
            $data = $this->User->updateAll(array('User.image' => "'$img'"), array('User.id' => $id));
            $user = $this->User->find('first', array('conditions' => array('User.id' => $id)));

            if ($data) {
                $response['user'] = $user;
                //$response['data'] = $data;  
                $response['error'] = 0;
            }
        }
        echo json_encode($response);
        exit;
    }

    //////////////////////////

    public function api_useredit() {

        configure::write('debug', 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        $this->User->recursive = 2;
        $this->layout = "ajax";
        if (!empty($redata)) {
            $id = $redata->user->id;
            $name = $redata->user->name;
            $phone = $redata->user->phone;
            $zip = $redata->user->zip;
            $country = $redata->user->country;
            $state = $redata->user->state;
			$gender = $redata->user->gender;
            $birth = $redata->user->birth;
            $address = $redata->user->address;
            $city = $redata->user->city;
            $data = $this->User->updateAll(array('User.phone' => "'$phone'", 'User.name' => "'$name'",
                'User.zip' => "'$zip'", 'User.country' => "'$country'",
                'User.state' => "'$state'", 'User.address' => "'$address'", 'User.city' => "'$city'", 'User.gender' => "'$gender'", 'User.birth' => "'$birth'"), array('User.id' => $id));
            if ($data) {
				 $user = $this->User->find('first', array('conditions' => array('User.id' => $id)));
				
                $response['msg'] = 'update successful';
                $response['data'] = $user;
                $response['uid'] = $id;
                $response['error'] = 0;
            }
        }
        echo json_encode($response);
        exit;
    }

    public function logout() {
        $this->Session->setFlash('Good-Bye', 'flash_success');
        $_SESSION['KCEDITOR']['disabled'] = true;
        unset($_SESSION['KCEDITOR']);
        return $this->redirect($this->Auth->logout());
    }

    public function add() {

        Configure::write("debug", 0);
        if ($this->request->is('post')) {

            $this->request->data['User']['email'] = $this->request->data['User']['email'];

            $this->request->data['User']['username'] = $this->request->data['User']['email'];

            // $this->request->data['User']['active'] = 1;

            $this->request->data['User']['gender'] = $this->request->data['User']['gender'];
            $this->request->data['User']['birth'] = $this->request->data['User']['birth'];
            $this->request->data['User']['role'] = 'customer';
			
            if ($this->User->hasAny(array('User.username' => $this->request->data['User']['username']))) {
                $this->Session->setFlash(__('Email already exist!!!', 'flash_success'));
                echo "<script>alert('Email already exist!!!')</script>";
                //echo "<script>window.location.assign('http://rupak.crystalbiltech.com/shop/')</script>";
                return $this->redirect('/shop');
            }
            
            $this->User->create();
            $fu = $this->request->data;


            if ($this->User->save($this->request->data)) {

                $to = $this->request->data['User']['email'];
                $subject = "Welcome To register to our store";
                $txt = "Thanks for registration with us";
                $headers = "From: gurpreet@avainfotech.com";


                $mymail = mail($to, $subject, $txt, $headers);
                if ($mymail) {
                    $this->Session->setFlash('Register has been successfully done check email for account activation!', 'flash_success');
                    $this->__sendActivationEmail($this->User->getLastInsertID());

                    return $this->redirect('http://rupak.crystalbiltech.com/shop');
                }
            } else {
                //$this->Session->setFlash('The user could not be saved. Please, try again.');
                echo "<script>alert('The user could not be saved. Please, try again.')</script>";
                echo "<script>window.location.assign('http://rupak.crystalbiltech.com/shop/')</script>";
            }
        }
    }

////////////////////////////////////////////////////////////
    /* function to send activation email */
    public function __sendActivationEmail($user_id) {
        //echo $user_id;echo "fgfgfgfdgfdgfdgdf</br>";
        //$user = $this->User->find(array('User.id' => $user_id), array('User.email', 'User.username','User.id'));
        $user = $this->User->find('all', array('conditions' => array('User.id' => $user_id)));
        //echo '<pre>';print_r($user);die();
        $usr = $user[0]['User']['email'];
        //print_r($usr);die();
        $urlm = 'http://rupak.crystalbiltech.com/shop/users/activate/' . $user_id . '/' . $this->User->getActivationHash();

        $this->set('username', $this->data['User']['username']);
        //$user['User']['email'];
        //print_r($abcd123);die();
        App::uses('CakeEmail', 'Network/Email');
        $email = new CakeEmail();

        $email->from($usr)
//->cc(Configure::read('Settings.ADMIN_EMAIL'))
//->cc('ajay@futureworktechnologies.com')
                ->to($usr)
                ->subject('Shop Order')
                ->template('activation')
                ->emailFormat('both')
                ->viewVars(array('ds' => $urlm))
                ->send();
        return $this->redirect(array('controller' => 'shop', 'action' => 'index'));
    }

    public function activate($user_id = null, $in_hash = null) {

        $this->User->id = $user_id;
        //echo $this->User->id;die();
        /* $this->Event->id = $id;
          $this->Event->saveField('is_featured', true); */

        if ($this->User->exists() && ($in_hash == $this->User->getActivationHash())) {
            if (empty($this->data)) {

                $this->data = $this->User->read(null, $user_id);
                // Update the active flag in the database
                $this->User->set('active', 1);
                $this->User->saveField('active', true);

                $this->Session->setFlash('Your account has been activated, please log in below.', 'flash_success');
                return $this->redirect(array('controller' => 'shop', 'action' => 'index'));
            }
        }

        // Activation failed, render '/views/user/activate.ctp' which should tell the user.
    }

    ////////////////////////////////////

    public function customer_dashboard() {
        
    }

////////////////////////////////////////////////////////////

    public function admin_dashboard() {
        
    }

////////////////////////////////////////////////////////////

    public function admin_index() {

        $this->Paginator = $this->Components->load('Paginator');

        $this->Paginator->settings = array(
            'User' => array(
                'recursive' => -1,
                'contain' => array(
                ),
                'conditions' => array(
                ),
                'order' => array(
                    'Users.name' => 'ASC'
                ),
                'limit' => 20,
                'paramType' => 'querystring',
            )
        );
        $users = $this->Paginator->paginate();
        $this->set(compact('users'));
    }

////////////////////////////////////////////////////////////

    public function admin_view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException('Invalid user');
        }
        $this->set('user', $this->User->read(null, $id));
    }

////////////////////////////////////////////////////////////

    public function admin_add() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash('The user has been saved', 'flash_success');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The user could not be saved. Please, try again.', 'flash_success');
            }
        }
    }

////////////////////////////////////////////////////////////

    public function admin_edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException('Invalid user');
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash('The user has been saved', 'flash_success');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The user could not be saved. Please, try again.', 'flash_success');
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
        }
    }

////////////////////////////////////////////////////////////

    public function admin_password($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException('Invalid user');
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash('The user has been saved', 'flash_success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The user could not be saved. Please, try again.', 'flash_success');
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
        }
    }

////////////////////////////////////////////////////////////

    public function admin_delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException('Invalid user');
        }
        if ($this->User->delete()) {
            $this->Session->setFlash('User deleted', 'flash_success');
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('User was not deleted', 'flash_success');
        return $this->redirect(array('action' => 'index'));
    }

    /*  public function api_registration() {

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

      $this->request->data['User']['name'] = $redata->first_name . " " . $redata->last_name;
      $this->request->data['User']['username'] = $redata->email ;
      $this->request->data['User']['email'] = $redata->email;
      $this->request->data['User']['password'] = $redata->password;
      $this->request->data['User']['phone'] = $redata->phone;
      // $this->request->data['User']['active'] = 1;
      $this->request->data['User']['role'] = 'customer';


      if ($this->request->is('post')) {

      if ($this->User->hasAny(array('User.email' => $this->request->data['User']['email']))) {

      $response['msg'] = 'Email_id already exist';
      } elseif ($this->User->hasAny(array('User.username' => $this->request->data['User']['username']))) {

      $response['msg'] = 'username already exist';
      } else {
      $this->User->create();
      $save=$this->User->save($this->request->data);
      if($save){
      $response['status'] = true;
      $response['msg'] = 'Registration has been successful';
      // $this->__sendActivationEmail($this->User->getLastInsertID());
      }else {
      $response['status'] = true;
      $response['msg'] = '';
      }
      }
      } else {

      $response['msg'] = 'Sorry please try again';
      }
      echo json_encode($response);
      exit;
      } */

    public function api_registration() {
		configure::write('debug', 0);
        $this->layout = 'ajax';
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'ipn.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
     
        $this->request->data['User']['name'] = $redata->first_name . " " . $redata->last_name;
        $this->request->data['User']['username'] = $redata->email;
        $this->request->data['User']['email'] = $redata->email;
        $this->request->data['User']['password'] = $redata->password;
        $this->request->data['User']['phone'] = $redata->phone;
		
		$this->request->data['User']['gender'] = $redata->gender;
        $this->request->data['User']['birth'] = $redata->birth;
		
        $this->request->data['User']['active'] = 0;
        $this->request->data['User']['role'] = 'customer';
        $verification_code = rand(11111, 99999);
        $this->request->data['User']['verification_code'] = $verification_code;

        if ($this->request->is('post')) {

            if ($this->User->hasAny(array('User.username' => $this->request->data['User']['username']))) {
			 $user = $this->User->find('first', array('conditions' => array('User.username' => $redata->email)));
			if($user['User']['active']== 0){
				
			 $response['msg'] = 'Email_id already exist please verify your account for active';
			 $response['user_id'] = $user['User']['id'];
             $response['email'] = $user['User']['email'];	
			}else{
			$response['msg'] = 'Email_id already exist';	
			}		
				
            } else {
                $this->User->create();
                $savedata = $this->User->save($this->request->data);
                if ($savedata) {

                    $ms = "Welcome to Shop 
                             <b>Verfication Code is: " . $verification_code . " "
                            . "</b><br/>";
                    $l = new CakeEmail('smtp');
                    $l->emailFormat('html')->template('default', 'default')->subject('Registration Successful!!!')->
                            to($this->request->data['User']['email'])->send($ms);

                    $response['isSuccess'] = true;
                    $response['msg'] = 'Verification code has been sent on Email. Please use that to activate your account';
                    $response['user_id'] = $this->User->getLastInsertID();
                    $response['email'] = $this->request->data['User']['email'];


                    $response['status'] = true;
                    //print_r($this->request->data);
                    $response['msg'] = 'Registration successful please check your email for account verification';


                    $response['status'] = true;
                    //print_r($this->request->data);
                    $response['msg'] = 'Registration has been successful';
                }
            }
        } else {

            $response['msg'] = 'Sorry please try again';
        }
        echo json_encode($response);
        exit;
    }

    //////////////////////////////////


    public function api_verifyEmail() {
       configure::write('debug', 0);
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


        if ($this->request->is('post')) {
            $exist = $this->User->find("first", array('conditions' => array(
                    "AND" => array(
                        'User.id' => $redata->user_id,
                        'User.verification_code' => $redata->verification_code,
                        'User.active' => 0
                    )
            )));
            if ($exist) {
                $img = Router::url('/', true) . 'images/default-user.png';
                $updated = $this->User->updateAll(array('User.active' => 1, 'User.verification_code' => NULL,
                    'User.image' => "'$img'"
                        ), array('User.id' => $redata->user_id,
                    'User.verification_code' => $redata->verification_code, 'User.active' => 0)
                );
                if ($updated) {
                    $user = $this->User->find('all', array('conditions' => array('User.id' => $redata->user_id)));


                    $response['isSuccess'] = true;
                    $response['msg'] = "Verified Successfully";

                    $response['data'] = $user;
                } else {
                    $response['isSuccess'] = false;
                    $response['msg'] = "Please verify account with valid verification code. Unable to verify";
                }
            } else {
                $response['isSuccess'] = false;
                $response['msg'] = "Please verify account with valid verification code.";
            }
        } else {
            $response['isSuccess'] = false;
            $response['msg'] = "Only Post Method is allowed";
        }
        echo json_encode($response);
        exit;
    }

////////////////////////////////////////////////////////////
    public function api_login() {
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
        $username = $redata->User->username;
        $password = $redata->User->password;
        $this->request->data['User']['username'] = $username;
        //$this->request->data['email'];        
        $this->request->data['password'] = $password;
        if ($redata) {
			
			     $password_hash = AuthComponent::password($password);
            $check = $this->User->find('first', array('conditions' => array(
                "AND"=>array(
                    "User.username" => $this->request->data['User']['username'],
                    "User.password"=>$password_hash,
                    "User.active"=>1
                )
                ), 'recursive' => '-1'));
            if($check){
                $response['status'] = true;
                $response['msg'] = 'You have successfully logged in';
                $response['name'] = $check;
            }else{
                $response['status'] = false;
                $response['msg'] = 'User is not valid';
            }
			
        }
        echo json_encode($response);
        exit;
    }

    /////////////////////
    public function changepassword() {

        if ($this->request->is('post')) {
            $password = AuthComponent::password($this->data['User']['old_password']);
            $em = $this->Auth->user('username');
            $pass = $this->User->find('first', array('conditions' => array('AND' => array('User.password' => $password, 'User.username' => $em))));
            if ($pass) {
                if ($this->data['User']['new_password'] != $this->data['User']['cpassword']) {
                    $this->Session->setFlash(__("New password and Confirm password field do not match", 'flash_success'));
                } else {
                    $this->User->data['User']['password'] = $this->data['User']['new_password'];
                    $this->User->id = $pass['User']['id'];
                    if ($this->User->exists()) {
                        $pass['User']['password'] = $this->data['User']['new_password'];
                        if ($this->User->save()) {
                            $this->Session->setFlash(__("Password Updated", 'flash_success'));
                            $this->redirect(array('controller' => 'Users', 'action' => 'myaccount'));
                        }
                    }
                }
            } else {
                $this->Session->setFlash(__("Your old password did not match.", 'flash_success'));
            }
        }
    }

    ///////////////////

    public function reset($token = null) {
        configure::write('debug', 0);
        $this->User->recursive = -1;
        if (!empty($token)) {
            $u = $this->User->findBytokenhash($token);
            if ($u) {
                $this->User->id = $u['User']['id'];
                if (!empty($this->data)) {
                    if ($this->data['User']['password'] != $this->data['User']['password_confirm']) {
                        $this->Session->setFlash("Both the passwords are not matching...");
                        return;
                    }
                    $this->User->data = $this->data;
                    $this->User->data['User']['email'] = $u['User']['email'];
                    $new_hash = sha1($u['User']['email'] . rand(0, 100)); //created token
                    $this->User->data['User']['tokenhash'] = $new_hash;
                    if ($this->User->validates(array('fieldList' => array('password', 'password_confirm')))) {
                        if ($this->User->save($this->User->data)) {
                            $this->Session->setFlash('Password Has been Updated', 'flash_success');
                            $this->redirect(array('controller' => 'shop', 'action' => 'index'));
                        }
                    } else {
                        $this->set('errors', $this->User->invalidFields());
                    }
                }
            } else {
                $this->Session->setFlash('Token Corrupted.Please retry the reset link 
                        <a style="cursor: pointer; color: rgb(0, 102, 0); text-decoration: none;
                        background: url("http://files.adbrite.com/mb/images/green-double-underline-006600.gif") 
                        repeat-x scroll center bottom transparent; margin-bottom: -2px; padding-bottom: 2px;"
                        name="AdBriteInlineAd_work" id="AdBriteInlineAd_work" target="_top">works</a> only for once.');
            }
        } else {
            $this->Session->setFlash('Pls try again...');
            $this->redirect(array('controller' => 'pages', 'action' => 'login'));
        }
    }

    //////////////////////////////

    public function forgetpwd() {
        Configure::write("debug", 0);
        $this->User->recursive = -1;
        if (!empty($this->data)) {
            if (empty($this->data['User']['username'])) {
                $this->Session->setFlash('Please Provide Your Username that You used to Register with Us');
            } else {
                $username = $this->data['User']['username'];
                $fu = $this->User->find('first', array('conditions' => array('User.username' => $username)));
                if ($fu['User']['email']) {
                    if ($fu['User']['active'] == "1") {

                        $key = Security::hash(CakeText::uuid(), 'sha512', true);

                        $hash = sha1($fu['User']['email'] . rand(0, 100));

                        $url = Router::url(array('controller' => 'Users', 'action' => 'reset'), true) . '/' . $key . '#' . $hash;

                        $ms = "<p>Click the Link below to reset your password.</p><br /> " . $url;
                        $fu['User']['tokenhash'] = $key;
                        $this->User->id = $fu['User']['id'];
                        if ($this->User->saveField('tokenhash', $fu['User']['tokenhash'])) {
                            $l = new CakeEmail('smtp');
                            $l->emailFormat('html')->template('default', 'default')->subject('Reset Your Password')
                                    ->to($fu['User']['email'])->send($ms);
                            $this->set('smtp_errors', "none");
                            $this->Session->setFlash(__('Check Your Email To Reset your password', true));
                            $this->redirect(array('controller' => 'shop', 'action' => 'index'));
                        } else {
                            $this->Session->setFlash("Error Generating Reset link", 'flash_success');
                        }
                    } else {
                        $this->Session->setFlash('This Account is not Active yet.Check Your mail to activate it', 'flash_success');
                    }
                } else {
                    $this->Session->setFlash('Username does Not Exist', 'flash_success');
                }
            }
        }
    }

    public function showwishlist() {

        $uid = $this->Auth->user('id');
        if (empty($uid)) {
            return $this->redirect(array('controller' => 'shop', 'action' => 'index'));
        }

        $this->loadModel("Wishlist");
        $this->Wishlist->recursive = 1;
        $data = $this->Wishlist->find('all', array('conditions' => array('Wishlist.user_id' => $uid)));

        foreach ($data as $val) {
            if ($val['Wishlist']['get_alert'] == 1 && $val['Product']['on_sale'] == 1 && $val['Wishlist']['user_id'] == $uid)
                ; {

                $salecount = count($val['Wishlist']['get_alert'] == 1 && $val['Product']['on_sale'] == 1 && $val['Wishlist']['user_id'] == $uid);
            }
        }
        $this->Session->write('salecount');
        $val = $this->Session->read('salecount');

        $this->set('datalist', $data);
    }

    public function api_showwishlist() {
        $this->layout = 'ajax';
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        //exit;
        // $uid = $this->Auth->user('id');
        $this->loadModel("Wishlist");

        if ($this->request->is('post')) {
            $this->Wishlist->recursive = 1;
            $data = $this->Wishlist->find('all', array('conditions' => array('Wishlist.user_id' => $redata->User->uid)));

            if ($data) {
				
				
					$cnt = count($data);
		
		  for ($i = 0; $i < $cnt; $i++) { 
                if ($data[$i]['Product']['image']) {
                    $data[$i]['Product']['image'] = Router::url('/', true). 'images/large/'. $data[$i]['Product']['image'];
                } else {
                    $data[$i]['Product']['image'] = Router::url('/', true). 'img/no-image.jpg';
                }
            }
			
				
				
                $response['wishlistdata'] = $data;
                $response['isSucess'] = "true";
            } else {
                $response['isSucess'] = 'true';
                $response['msg'] = 'Your wishlist empty!';
            }
        }
        echo json_encode($response);
        exit;
    }

    public function api_forgetpwd() {
        Configure::write('debug', 0);
        $this->layout = 'ajax';
        $this->layout = "ajax";
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        $username = $redata->User->username;
        $this->User->recursive = -1;
        if (empty($redata)) {
            $response['isSucess'] = 'false';
            $response['msg'] = 'Please Provide Your Username that You used to register with us';
        } else {
            $fu = $this->User->find('first', array('conditions' => array('User.username' => $username)));
            if ($fu['User']['email']) {
                if ($fu['User']['active'] == "1") {
                    $key = Security::hash(CakeText::uuid(), 'sha512', true);
                    $hash = sha1($fu['User']['email'] . rand(0, 100));
                    $url = Router::url(array('controller' => 'users', 'action' => 'api_resetpwd'), true) . '/' . $key . '#' . $hash;
                    $ms = "Welcome to Mobile
      <b><a href='" . $url . "' style='text-decoration:none'>Click here to reset your password.</a></b><br/>";
                    $fu['User']['tokenhash'] = $key;
                    $this->User->id = $fu['User']['id'];
                    if ($this->User->saveField('tokenhash', $fu['User']['tokenhash'])) {
                        $l = new CakeEmail('smtp');
                        $l->emailFormat('html')->template('default', 'default')->subject('Reset Your Password')
                                ->to($fu['User']['email'])->send($ms);
                        $response['isSucess'] = 'true';
                        $response['msg'] = 'Check Your Email ID to reset your password';
                    } else {
                        $response['isSucess'] = 'false';
                        $response['msg'] = 'Error Generating Reset link';
                    }
                } else {
                    $response['isSucess'] = 'false';
                    $response['msg'] = 'This Account is still not Active .Check Your Email ID to activate it';
                }
            } else {
                $response['isSucess'] = 'false';
                $response['msg'] = 'Email ID does Not Exist';
            }
        }
        echo json_encode($response);
        exit;
    }

    /////////////////////////////////////////

    public function api_resetpwd($token = null) {

        configure::write('debug', 0);
        $this->User->recursive = -1;
        if (!empty($token)) {
            $u = $this->User->findBytokenhash($token);
            if ($u) {

                $this->User->id = $u['User']['id'];
                if (!empty($this->data)) {

                    if ($this->data['User']['password'] != $this->data['User']['password_confirm']) {
                        $this->Session->setFlash("Both the passwords are not matching...");
                        return;
                    }
                    $this->User->data = $this->data;
                    $this->User->data['User']['email'] = $u['User']['email'];
                    $new_hash = sha1($u['User']['email'] . rand(0, 100)); //created token
                    $this->User->data['User']['tokenhash'] = $new_hash;
                    if ($this->User->validates(array('fieldList' => array('password', 'password_confirm')))) {
                        if ($this->User->save($this->User->data)) {
                            $this->Session->setFlash('Password Has been Updated');
                            $this->redirect(array('controller' => 'shop', 'action' => 'index'));
                        }
                    } else {
                        $this->set('errors', $this->User->invalidFields());
                    }
                }
            } else {

                $this->Session->setFlash('Token Corrupted, Please Retry.the reset link 
                        <a style="cursor: pointer; color: rgb(0, 102, 0); text-decoration: none;
                        background: url("http://files.adbrite.com/mb/images/green-double-underline-006600.gif") 
                        repeat-x scroll center bottom transparent; margin-bottom: -2px; padding-bottom: 2px;"
                        name="AdBriteInlineAd_work" id="AdBriteInlineAd_work" target="_top">work</a> only for once.');
            }
        } else {
            $this->Session->setFlash('Pls try again...');
            $this->redirect(array('controller' => 'pages', 'action' => 'login'));
        }
    }

    public function user_ask_ques() {

        $this->loadModel('Admin_contact');

        if ($this->request->is('post')) {
            $product_id = $this->request->data['Admin_contact']['product_id'];
            $name = $this->request->data['Admin_contact']['name'];
            $msg = $this->request->data['Admin_contact']['msg'];
            $email = $this->request->data['Admin_contact']['email'];

            $this->request->data['Admin_contact']['product_id'] = $product_id;
            $this->request->data['Admin_contact']['name'] = $name;
            $this->request->data['Admin_contact']['msg'] = $msg;
            $this->request->data['Admin_contact']['email'] = $email;

            $save = $this->Admin_contact->save($this->request->data);
            if ($save) {


                $Email = new CakeEmail();
				
			

                $Email->from(array($email => 'Shop Contact'))
                        ->to('wearorganicclothing@gmail.com')
                        ->subject('Wooden Feedback')
                        ->send($msg);
                $this->Session->setFlash('Thanks for Contact', 'flash_success');
                return $this->redirect('http://' . $_POST['server']);
            } else {
                $this->Session->setFlash('Try again', 'flash_success');
                return $this->redirect('http://' . $_POST['server']);
            }
        }
    }

    public function api_changepassword() {
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
        if ($this->request->is('post')) {
            $password = AuthComponent::password($redata->old_password);
            $id = $redata->uid;
            $pass = $this->User->find('first', array('conditions' => array('AND' => array('User.password' => $password, 'User.id' => $id))));
            if ($pass) {

                $this->User->data['User']['password'] = $redata->new_password;
                $this->User->id = $redata->uid;
                if ($this->User->exists()) {
                    $pass['User']['password'] = $redata->new_password;
                    if ($this->User->save()) {

                        $response['isSucess'] = 'true';
                        $response['msg'] = "your password has been updated";
                    }
                }
            } else {
                $response['isSucess'] = 'false';
                $response['msg'] = "Your old password did not match";
            }
        }

        echo json_encode($response);
        exit;
    }

    /////////////////////////////twitter user check///////////////////////////////

    public function checkUser($oauth_provider, $email, $oauth_uid, $username, $fname, $lname, $locale, $oauth_token, $oauth_secret, $profile_image_url) {

        $exist = $this->User->find("first", array('conditions' => array(
                "AND" => array(
                    'User.oauth_provider' => $oauth_provider,
                    'User.oauth_uid' => $oauth_uid
                )
        )));
		
        if ($exist['User']['id']) {
                 $this->request->data['User']['username'] = $username;
                    $this->request->data['User']['password'] = $username;
                    
                      $this->Auth->login();	
				//return $this->redirect('/users/myaccount/'); 
            $updated = $this->User->updateAll(
                    array('User.oauth_token' => "'$oauth_token'",
                        'User.oauth_secret' => "'$oauth_secret'",
                        'User.oauth_provider' => "'$oauth_provider'",
                        'User.oauth_uid' => "'$oauth_uid'",
                        'User.active' => 1
                    )
            );
        } else {

            $this->request->data['User']['oauth_token'] = $oauth_token;
            $this->request->data['User']['oauth_secret'] = $oauth_secret;
            $this->request->data['User']['oauth_provider'] = $oauth_provider;
            $this->request->data['User']['oauth_uid'] = $oauth_uid;
            $this->request->data['User']['first_name'] = $fname;
            $this->request->data['User']['image'] = $profile_image_url;
            $this->request->data['User']['locale'] = $locale;
            $this->request->data['User']['last_name'] = $lname;
            $this->request->data['User']['username'] = $username;
            $this->request->data['User']['password'] = $username;
            $this->request->data['User']['role'] = 'customer';
            $this->request->data['User']['email'] = $email;
            $this->request->data['User']['active'] = 1;
            $this->User->save($this->request->data);
					$user_id = $this->User->getLastInsertID();
                     
                    if ($user_id) {
                    $this->request->data['User']['username'] = $username;
                    $this->request->data['User']['password'] = $username;
                      $this->Auth->login();
           
                    
                }
			
        }
        $userdata = $this->User->find("first", array('conditions' => array(
                "AND" => array(
                    'User.oauth_provider' => 'twitter',
                    'User.oauth_uid' => $oauth_uid
                )
        )));
        return $userdata;
    }

    //////////////
    public function twitter_process() {
 Configure::write("debug", 0);
        Configure::load('twitter');
        $customer_key = Configure::read('Twitter.CONSUMER_KEY');
        $customer_secret = Configure::read('Twitter.CONSUMER_SECRET');
        $callback = Configure::read('Twitter.OAUTH_CALLBACK');


        if (isset($_REQUEST['oauth_token']) && $this->Session->read('token') !== $_REQUEST['oauth_token']) {

            //If token is old, distroy session and redirect user to index.php
            $this->Session->delete('token');
            return $this->redirect('http://rupak.crystalbiltech.com/shop/');
        } elseif (isset($_REQUEST['oauth_token']) && $this->Session->read('token') == $_REQUEST['oauth_token']) {

            //Successful response returns oauth_token, oauth_token_secret, user_id, and screen_name
            $connection = new TwitterOAuth($customer_key, $customer_secret, $_SESSION['token'], $_SESSION['token_secret']);
            $access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
            if ($connection->http_code == '200') {
                //Redirect user to twitter
                $this->Session->write('status', 'verified');
                $this->Session->write('request_vars', $access_token);

                //Insert user into the database
                $params = array('include_email' => 'true', 'include_entities' => 'false', 'skip_status' => 'true');

                $user_info = $connection->get('account/verify_credentials', $params);

                //$user_info = $connection->get('account/verify_credentials'); 
                $name = explode(" ", $user_info->name);
                $fname = isset($name[0]) ? $name[0] : '';
                $lname = isset($name[1]) ? $name[1] : '';
                //$db_user = new Users();
                $this->checkUser('twitter', $user_info->email, $user_info->id, $user_info->screen_name, $fname, $lname, $user_info->lang, $access_token['oauth_token'], $access_token['oauth_token_secret'], $user_info->profile_image_url);

                //Unset no longer needed request tokens
                $this->Session->delete('token');
                $this->Session->delete('token_secret');

                return $this->redirect('/users/myaccount');
                //header('Location: index.php');
            } else {

                $this->Session->setFlash('error, try again later!', 'flash_success');

                return $this->redirect('/shop');
                //die;
            }
        } else {

            if (isset($_GET["denied"])) {
                return $this->redirect('/shop');
                //die();
            }

            //Fresh authentication
            $connection = new TwitterOAuth($customer_key, $customer_secret);
            $request_token = $connection->getRequestToken($callback);

            //Received token info from twitter
            $this->Session->write('token', $request_token['oauth_token']);
            $this->Session->write('token_secret', $request_token['oauth_token_secret']);
            //$_SESSION['token'] 	        = $request_token['oauth_token'];
            //$_SESSION['token_secret'] 	= $request_token['oauth_token_secret'];
            //Any value other than 200 is failure, so continue only if http code is 200
            if ($connection->http_code == '200') {
                //redirect user to twitter
                $twitter_url = $connection->getAuthorizeURL($request_token['oauth_token']);
                header('Location: ' . $twitter_url);
            } else {
                $this->Session->setFlash('error connecting to twitter! try again later!', 'flash_success');

                return $this->redirect('/shop');
            }
        }
    }

    public function twitter_profile() {
        
    }

    public function twitter_logout() {
        $this->Session->delete('status');
        $this->Session->delete('userdata');
        return $this->redirect('/shop');
    }

    public function google_login() {
       Configure::write("debug", 0);
	   
	   	
			     $client_id = '323825392115-9na4km0k8v5ephvkmcspb51hjf10ks8r.apps.googleusercontent.com';
        $client_secret = 'ZeKh2Vo1XzZcA1czA8LcZqlc';
        $redirect_uri = 'http://rupak.crystalbiltech.com/shop/users/google_login/';

        $client = new Google_Client();
        $client->setClientId($client_id);
        $client->setClientSecret($client_secret);
        $client->setRedirectUri($redirect_uri);
        $client->addScope("email");
        $client->addScope("profile");

        $service = new Google_Service_Oauth2($client);
		
		 if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $client->setAccessToken($_SESSION['access_token']);
			
			
			
			
			
			 $user = $service->userinfo->get();

            if ($user) {
                $this->request->data['User']['name'] = $user->name;
                $this->request->data['User']['email'] = $user->email;
                $this->request->data['User']['username'] = $user->email;
                $this->request->data['User']['password'] = $user->name;
                if ($user->link == NULL) {
                    $this->request->data['User']['link'] = 'no link';
                } else {
                    $this->request->data['User']['link'] = $user->link;
                }

                $name = explode(" ", $user->name);
                $fname = isset($name[0]) ? $name[0] : '';
                $lname = isset($name[1]) ? $name[1] : '';

                // $this->request->data['User']['link'] = $user->link;
                $this->request->data['User']['first_name'] = $fname;
                $this->request->data['User']['last_name'] = $lname;
                $this->request->data['User']['image'] = $user->picture;
                $this->request->data['User']['role'] = 'customer';
                $this->request->data['User']['active'] = 1;
                $this->request->data['User']['google_id'] = $user->id;
                $this->request->data['User']['oauth_provider'] = 'google';

                $exist = $this->User->find("first", array('conditions' => array(
                        "AND" => array(
                            'User.oauth_provider' => 'google',
                            'User.google_id' => $user->id
                        )
                )));
				
				
                if ($exist['User']['id']) {
                   // $this->set(compact('exist'));
                    $this->request->data['User']['username'] = $exist['User']['username'];
                    $this->request->data['User']['password'] = $user->name;
                    
                      $this->Auth->login();	
				return $this->redirect('/users/myaccount/');	
                } else {
					
                    $this->User->save($this->request->data);
					
					$user_id = $this->User->getLastInsertID();
                     
                    if ($user_id) {
                    $this->request->data['User']['username'] = $user->email;
                    $this->request->data['User']['password'] = $user->name;
                      $this->Auth->login();
           
                    
                }
                    return $this->redirect('/users/myaccount/');
                }
            }
			
			
			
			
			
			
			
        } else {
            $authUrl = $client->createAuthUrl();
          	$this->set(compact('authUrl'));
        }

           
        
    }

    ///////////////////////////


    public function track_order() {
        $uid = $this->Auth->user('id'); 
     
        if ($uid) {
            $sql = 'SELECT orders.*, order_items.*, products.* FROM (order_items INNER JOIN orders
            ON order_items.order_id= orders.id)
           INNER JOIN products ON(order_items.product_id= products.id)
            WHERE orders.uid =' . $uid;
            $orderdataa = $this->User->query($sql);
        }

        $this->set(compact('orderdataa'));
    }

    public function api_orderHistory() {
        Configure::write("debug", 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        //  exit;
        $id = $redata->User->uid;

        if (!empty($redata)) {
            $sql = 'SELECT orders.*, order_items.*, products.* FROM (order_items INNER JOIN orders
            ON order_items.order_id= orders.id)
           INNER JOIN products ON(order_items.product_id= products.id)  
            WHERE orders.uid =' . $id;
            $orderdataa = $this->User->query($sql);
			if($orderdataa){
            $response['error'] = "0";
            $response['data'] = $orderdataa;
			}else{
				$response['error'] = "1";
            $response['msg'] ='empty order';
			}
        } else {
            $response['error'] = "1";
            $response['data'] = "error";
        }
        echo json_encode($response);
        exit;
    }

    ///////////////////////////////

    /**
     * facebook login
     */
   public function api_fbloginapp() {
        Configure::write("debug", 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'ipn.txt', 'w');
        fwrite($fc, $c);
        fclose($fc); 

		    if ($this->request->is('post')) {
		
		
		        $this->request->data['username'] = $redata->user->email;
                $this->request->data['name'] = $redata->user->name;
                $this->request->data['email'] = $redata->user->email;
                $this->request->data['fboo_ids'] = $redata->user->facebook_id;
                $this->request->data['session_id'] = $redata->user->session_id;
                $this->request->data['image'] = $redata->user->picture;
  
		 if (!$this->User->hasAny(array(
                        'OR' => array('User.username' =>$redata->user->email, 'User.email' => $redata->user->email)
                    ))) {
                $this->User->create();
                $this->request->data['role'] = "customer";
                $this->request->data['active'] = "1";
                if ($this->User->save($this->request->data)) {
                    $user = $this->User->find('first', array('conditions' => array('email' => $redata->user->email)));
					
                    $this->User->id = $this->User->getLastInsertID();

                    $this->loadModel('Cart');
                    $this->Cart->updateAll(
                        array('Cart.uid'=>$user['User']['id']),
                        array('Cart.sessionid'=>$redata->user->session_id,
                           // 'Cart.uid'=>0
                            )
                        );
                    $this->Cart->updateAll(
                        array('Cart.sessionid'=>$redata->user->session_id),
                        array('Cart.uid'=>$user['User']['id'])
                        );
                    $response['isSucess'] = 'true';
                    $response['data'] = $user;
                } else {
                    $response['isSucess'] = 'false';
                    $response['msg'] = 'Sorry please try again';
                }
            } else {
				
			 $user = $this->User->find('first', array('conditions' => array('email' => $redata->user->email)));
                
                if($user['User']['fboo_ids']!=''){
                    $this->loadModel('Cart');
                    $this->Cart->updateAll(
                        array('Cart.uid'=>$user['User']['id']),
                        array('Cart.sessionid'=>$redata->user->session_id,
                           // 'Cart.uid'=>0
                            )
                        );
                    $this->Cart->updateAll(
                        array('Cart.sessionid'=>$redata->user->session_id),
                        array('Cart.uid'=>$user['User']['id'])
                        );
                    $response['isSucess'] = 'true';
                    $response['data'] = $user;
                }else{
                    $response['isSucess']='false';
                    $response['msg']='This email is already registered.';
                }
                //$this->User->id = $user['User']['id'];
                // $this->User->saveField('image', $this->request->data['User']['image']);
                //$response['isSucess'] = 'true';
                //$response['data'] = $user;
				
				
			}
		
			}

        echo json_encode($response);
        exit;
    }
	
	
    ////////////////////////
    public function api_twitterlogin() {
        Configure::write("debug", 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);


        //  $options = array('conditions' => array('User.oauth_uid' => $redata->user->twitter_id));
        // $data = $this->request->data = $this->User->find('first', $options);   

        $exist = $this->User->find("first", array('conditions' => array(
                "AND" => array(
                    'User.oauth_uid' => $redata->user->twitter_id,
                    'User.oauth_provider' => 'twitter'
                )
        )));


        if (!empty($exist)) {

            $this->User->id = $exist['User']['id'];
            // $this->User->saveField('image', $this->request->data['User']['image']);
            $response['isSucess'] = 'true';
            $response['data'] = $exist;
        } else {


            // $this->request->data['User']['username'] = $redata->user->screen_name;   
            $this->request->data['User']['name'] = $redata->user->screen_name;
            $this->request->data['User']['oauth_provider'] = 'twitter';
            $this->request->data['User']['oauth_uid'] = $redata->user->twitter_id;
            $this->request->data['User']['session_id'] = $redata->user->session_id;
            $this->request->data['User']['role'] = "customer";
            $this->request->data['User']['active'] = "1";
            $this->request->data['User']['image'] = Router::url('/', true) . 'images/default-user.png';
            $this->User->create();
            $user = $this->User->save($this->request->data);
            $ids = $this->User->getLastInsertId();
            $response['isSucess'] = 'true';
            array_push($user['user_id'] = $ids);
            $response['data'] = $user;
        }
        echo json_encode($response);
        exit;
    }

    ////////////////////////
    public function api_googlelogin() {
        Configure::write("debug", 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        
			 $img = Router::url('/', true) . 'images/default-user.png';
            
			if($redata->user->image == ''){
				
				$image = $img;
			}else{
				
				$image = $redata->user->image;
			}
			
		   $this->request->data['User']['username'] = $redata->user->email;
            $this->request->data['User']['email'] = $redata->user->email;
            $this->request->data['User']['name'] = $redata->user->name;
            $this->request->data['User']['oauth_provider'] = 'google';
            $this->request->data['User']['google_id'] = $redata->user->google_id;
            $this->request->data['User']['session_id'] = $redata->user->session_id;
            $this->request->data['User']['image'] = $image;
  
			   if (!$this->User->hasAny(array('User.username' => $redata->user->email)
                    )) {
                $this->User->create();
                $this->request->data['User']['role'] = 'customer';
                $this->request->data['User']['status'] = 1;
                if ($this->User->save($this->request->data)) {
                    $user = $this->User->find('first', array('conditions' => array('email' => $redata->user->email)));
               
                    $this->User->id = $this->User->getLastInsertID();
                    $this->loadModel('Cart');
                    $this->Cart->updateAll(
                        array('Cart.uid'=>$user['User']['id']),
                        array('Cart.sessionid'=>$redata->user->session_id,
                          //  'Cart.uid'=>0
                            )
                        );
                    $this->Cart->updateAll(
                        array('Cart.sessionid'=>$redata->user->session_id),
                        array('Cart.uid'=>$user['User']['id'])
                        );
                    $response['isSuccess'] = true;
                    $response['data'] = $user;
                } else {
                    $response['isSuccess'] = false;
                    $response['msg'] = 'Sorry please try again';
                }
            } else {

				  $user = $this->User->find('first', array('conditions' => array('email' => $redata->user->email)));
            
                
                if($user['User']['google_id']!=''){
                    $this->loadModel('Cart');
                    $this->Cart->updateAll(
                        array('Cart.uid'=>$user['User']['id']),
                        array('Cart.sessionid'=>$redata->user->session_id,
                           // 'Cart.uid'=>0
                            )
                        );
                    $this->Cart->updateAll(
                        array('Cart.sessionid'=>$redata->user->session_id),
                        array('Cart.uid'=>$user['User']['id'])
                        );
                    $response['isSuccess'] = true;
                    $response['data'] = $user;
                }else{
                    $response['isSuccess']=false;
                    $response['msg']='This email is already registered.';
                }
				
			}		

        echo json_encode($response);
        exit;
    }

}
