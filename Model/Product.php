<?php
App::uses('AppModel', 'Model');
/**
 * Product Model
 *
 * @property Media $Media
 * @property Category $Category
 */
class Product extends AppModel {

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
				'message' => 'O titulo do produto é um campo obrigatório',
			),
		),
		'slug' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'O slug do produto é um campo Obrigatório',
			),
		),
		'description' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'O descrição do produto é um campo obrigatório',
			),
		),
	);

//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Media' => array(
			'className' => 'Media',
			'foreignKey' => 'foreign_key',
			'conditions' => array(
				'Media.model' => 'Product',
			),
		)
	);

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Category' => array(
			'className' => 'Category',
			'joinTable' => 'categories_products',
			'foreignKey' => 'product_id',
			'associationForeignKey' => 'category_id',
			'unique' => 'keepExisting',
		)
	);

}