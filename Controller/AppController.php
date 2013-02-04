<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 */
class AppController extends Controller 
{
	public $components = array(
			'Session', 
			'Cookie', 
			'RequestHandler', 
			'Auth' => array(
				'loginError' => 'Falha no login. Por favor, verifique se o usuário e senha digitado estão corretos.',
				'authError' => 'Desculpe, você precisa estar autenticado para acessar esta página.',
				'flash' => array(
					'element' => 'alerts/inline',
					'key' => 'auth',
					'params' => array(
						'id' => 'error'
					)
				),
				'sessionKey' => 'Auth.User',
				'loginAction' => '/admin/users/login',
				'loginRedirect' => '/',
				'authenticate' => array(
					'Form' => array(
						'userModel' =>'User',
						'fields' => array(
							'username' => 'email', 
							'password' => 'password'
						),
						'scope' => array(
							'User.is_active' => true
						),
					)					
				)
			)
		);

	public $helpers = array(
			'Session',
			'Js',
			'Html',
			'Form'
		);
	    
	public $paginate = array('limit'=>20);

	/**
	 * Antes de filtrar as actions da aplicação
	 * 
	 * Troca o layout do admin 
	 */
	public function beforeFilter() 
	{
		parent::beforeFilter();

		// AuthComponent para o "Admin"
		if (isset($this->request->params['prefix']) && ($this->request->params['prefix'] == 'admin')) {
			$this->layout = 'admin';
		} else {
			$this->Auth->allow('*');
		}
	}
 
	/**
	 * Define se um usuário pode acessar uma página
	 * 
	 * @param array $user
	 */
	function isAuthorized($user) 
	{
		return $this->Session->check($this->Auth->sessionKey);
	}
}
