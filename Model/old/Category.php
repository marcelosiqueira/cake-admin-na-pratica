<?php
App::uses('AppModel', 'Model');
/**
 * Event Model
 *
 * @property Media $Media
 * @property User $User
 */
class Category extends AppModel 
{

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Entre com o titulo da Categoria',
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Parent' => array(
			'className' => 'Category',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Parent' => array(
			'className' => 'Parent',
			'foreignKey' => 'parent_id'
		),
		'Media' => array(
			'className' => 'Media',
			'foreignKey' => 'foreign_key',
			'conditions' => array(
				'Media.model' => 'Category',
			),
		)
	);

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Product' => array(
			'className' => 'Product',
			'joinTable' => 'categories_products',
			'foreignKey' => 'category_id',
			'associationForeignKey' => 'product_id',
			'unique' => 'keepExisting',
		),
	);

}
