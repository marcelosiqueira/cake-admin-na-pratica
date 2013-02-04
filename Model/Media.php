<?php
App::uses('AppModel', 'Model');
/**
 * Media Model
 *
 * @property Product $Product
 * @property Category $Category
 */
class Media extends AppModel 
{

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'medias';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'media';

/**
 * actsAs Plugin Upload
 *
 * @var array
 */
	public $actsAs = array(
		'Upload.Upload' => array(
			'media' => array(
				'path' => '{ROOT}webroot{DS}files{DS}{model}{DS}',
				'thumbnailSizes' => array(
					'big' => '620w',
					'normal' => '380w',
					'small' => '140x140',
					'thumb' => '85x85'
				),
			),
		),
	);


/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Product' => array(
			'className' => 'Product',
			'foreignKey' => 'foreign_key',
		),
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'foreign_key',
		),
	);

}
