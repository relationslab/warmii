<?php
App::uses('AppModel', 'Model');
/**
 * Content Model
 *
 * @property Letter $Letter
 */
class Content extends AppModel {


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
