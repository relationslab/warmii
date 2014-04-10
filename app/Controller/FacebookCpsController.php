<?php

App::uses('Controller', 'Controller');
App::import('Vendor', 'Facebook',array('file'=>'Facebook'.DS.'facebook.php'));	

class FacebookCpsController extends AppController {
	
	public $name = 'FacebookCps';
	public $uses=array();
	public $components = array('RequestHandler');

	public function index(){
		$this->layout=false;
	  	
	}
	
	public function edit($edit_feed_number){
		 $this->layout=false;
		 $this->set('feed_num',$edit_feed_number);
		 $this->set("referer", $this->referer());
		 $this->set("redirect", $this);
	  	
	}
	
	public function preview($edit_feed_number){
		App::uses('Sanitize', 'Utility');
		//$this->RequestHandler->respondAs('application/pdf');
		$this->layout=false;
		$this->set('feed_num',$edit_feed_number);
		$this->set("referer", $this->referer());
		$this->set("redirect", $this);
		
		if($this->request->isPost()){
			//$edit_message = $this->request->data['input_message'];
			$edit_message = $this->request->data['input_message'];
			//$edit_message = strip_tags($edit_message); // HTML�^�O�����O����
		} else {
            $edit_message = '�i�{���Ȃ��j';
        }
		$this -> set("edit_message", Sanitize::stripAll($edit_message));
	  	
	}
	
	function login()
	{
		Configure::load('facebook');
		$appId=Configure::read('Facebook.appId');
		$app_secret=Configure::read('Facebook.secret');
		$facebook = new Facebook(array(
				'appId'		=>  $appId,
				'secret'	=> $app_secret,
				));
		$loginUrl = $facebook->getLoginUrl(array(
			'scope'			=> 'read_stream, publish_stream, user_photos',
			'redirect_uri'	=> BASE_URL.'facebook_cps/facebook_connect',
			'display'=>'popup'
			));
		$this->redirect($loginUrl);
   	}
	
	function facebook_connect()
	{
	    Configure::load('facebook');
	    $appId=Configure::read('Facebook.appId');
	    $app_secret=Configure::read('Facebook.secret');
	   
	   	 $facebook = new Facebook(array(
		'appId'		=>  $appId,
		'secret'	=> $app_secret,
		));
	
	    $user = $facebook->getUser();
	
		
		if($user){
	     	try{
	     			//�A�N�Z�X�g�[�N���i�ꎞ�I�Ȍ����j���擾
	     			$access_token = $facebook->getAccessToken();
	     			
	     			//�v���t�B�[�������擾
					$user_profile = $facebook->api('/me');
					
					//���O�A�E�g�pAPI
					$params=array('next' => BASE_URL.'facebook_cps/facebook_logout');
					$logout =$facebook->getLogoutUrl($params);
					
					//�E�H�[���̎擾
					$getCnt = 50;
					$user_wall = $facebook->api('/me/feed',array('limit' => $getCnt, 'access_token' => $access_token ));
					
					//�ʐ^�f�[�^�̎擾
					$user_photos = $facebook ->api('/me/photos',array('access_token' => $access_token ));
					//$feed_photos = $facebook ->api('//
					
					//�A���o��
					$user_albums = $facebook->api('/me/albums', array('access_token' => $access_token ));
					//$user_images = $facebook ->api('/'.$user_albums.'/photos',array('access_token' => $access_token ));
					
					
					//�����o��
			        $this->Session->write('User',$user_profile);
					$this->Session->write('logout',$logout);
					$this->Session->write('wall',$user_wall);
					$this->Session->write('photos',$user_photos);
					$this->Session->write('albums',$user_albums);
					//$this->Session->write('images',$user_images);

			}
			catch(FacebookApiException $e){
					error_log($e);
					$user = NULL;
			}		
		}
		
	   else
	   {
		    $this->Session->setFlash('Sorry.Please try again','default',array('class'=>'msg_req'));   
		   $this->redirect(array('action'=>'index'));
	   }
   }
   
   function facebook_logout(){
	   
	$this->Session->delete('User');
	$this->Session->delete('logout');   
	   $this->redirect(array('action'=>'index'));
   }
	
}
