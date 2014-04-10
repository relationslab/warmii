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
			//$edit_message = strip_tags($edit_message); // HTMLタグを除外する
		} else {
            $edit_message = '（本文なし）';
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
	     			//アクセストークン（一時的な権限）を取得
	     			$access_token = $facebook->getAccessToken();
	     			
	     			//プロフィール情報を取得
					$user_profile = $facebook->api('/me');
					
					//ログアウト用API
					$params=array('next' => BASE_URL.'facebook_cps/facebook_logout');
					$logout =$facebook->getLogoutUrl($params);
					
					//ウォールの取得
					$getCnt = 50;
					$user_wall = $facebook->api('/me/feed',array('limit' => $getCnt, 'access_token' => $access_token ));
					
					//写真データの取得
					$user_photos = $facebook ->api('/me/photos',array('access_token' => $access_token ));
					//$feed_photos = $facebook ->api('//
					
					//アルバム
					$user_albums = $facebook->api('/me/albums', array('access_token' => $access_token ));
					//$user_images = $facebook ->api('/'.$user_albums.'/photos',array('access_token' => $access_token ));
					
					
					//書き出し
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
