<?php
App::uses('AppModel', 'Model');
/**
 * Cover Model
 *
 * @property Letter $Letter
 */
class Cover extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Letter' => array(
			'className' => 'Letter',
			'foreignKey' => 'letter_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
