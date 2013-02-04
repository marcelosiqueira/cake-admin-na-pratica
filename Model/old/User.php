<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 */
class User extends AppModel 
{

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Informe seu Nome Completo',
			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'O e-mail deve ser válido'
			),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Informe seu e-mail'
			),
			'isunique' => array(
				'rule' => 'isunique',
				'message' => 'Esse e-mail já está cadastrado'
			)
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Por favor, entre com sua Senha'
			),
			'minlength' => array(
				'rule' => array('minlength', 6),
				'message' => 'A senha deve ter pelo menos 6(seis) caracteres'
			),
		),
		'password_confirm' => array(
			'notempty' => array( 
				'rule' => array('passwordConfirm', 'password'),
				'message' => 'As senhas estão difentes',
			),
		),
		'is_active' => array(
			'boolean' => array(
				'rule' => array('boolean'),
			),
		),
	);

/**
 * Checa se as senhas estão iguais
 *
 * @var string
 */

	function passwordConfirm($data)
	{
		if ($this->data['User']['password'] !== $data['password_confirm']) {
			return false;
		}
		return true;
	}

/**
 * Encript password
 *
 * @var string
 */
	public function beforeSave($options = array()) 
	{
		if (isset($this->data[$this->alias]['password'])) {
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
		return true;
	}

}
