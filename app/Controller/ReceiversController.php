<?php
App::uses('Controller', 'Controller');

class ReceiversController extends AppController {
	
	//使うモデルを明示
	public $uses = array('Receiver', 'Sender');
	
	public function index(){
	
		//セッション内のユーザーデータを持ってくる
		$user_id = $this->Session->read('User');
		//DBからfacebookにログインされたユーザーに関連するリストを持ってくる
		$receiver_datas = $this->Receiver->find('all', array( 'conditions' => array( 'Sender.face_book_id' => $user_id['id'])));
		//debug($receiver_datas);
		//ビューにわたすよー
		$this->set('receiver_datas', $receiver_datas);
	}
	
	public function registration(){
		$user_id = $this->Session->read('User');
		if($this->request->isPost()){
			$this->Receiver->create();
			//debug($user_id);
		$sender = $this->Sender->find('first', array( 'conditions' => array( 'Sender.face_book_id' => $user_id['id'])));
			//debug($sender);
			$this->request->data['Receiver']['sender_id'] = $sender['Sender']['id'];
		
			if($this->Receiver->save($this->request->data)){
				$this->Session->setFlash('登録できました。');
				//$this->redirect(array('action' => 'index')); //なんか動かないのでsetActionで代替
				$this->setAction('index');
			}
			else{
				$this->Session->setFlash('登録できませんでした。');
			}
		}
		
	}
}