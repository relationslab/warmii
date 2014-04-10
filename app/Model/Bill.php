<?php
App::uses('AppModel', 'Model');
/**
 * Bill Model
 *
 * @property Sender $Sender
 * @property Letter $Letter
 */
class Bill extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Sender' => array(
			'className' => 'Sender',
			'foreignKey' => 'sender_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Letter' => array(
			'className' => 'Letter',
			'foreignKey' => 'letter_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
