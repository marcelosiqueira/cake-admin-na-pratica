<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController 
{

/**
 * admin_logout method (Logout de usuários)
 *
 * @return void
 */
	public function recovery() 
	{
		// Carrega o layout de login
		$this->layout = 'login';
		// Difine o <title>
		$this->set('title_for_layout', __('Recuperar senha'));	
		
		// Foi efetuado um POST?
		if ($this->request->is('post')) {
			$this->User->recursive = 0;
			$user = $this->User->find('first', array('conditions'=>array('User.email'=>$this->request->data['User']['email']), ''));

			if (count($user) > 0) {
				$this->User->id = $user['User']['id'];
				$this->User->saveField('reset', String::uuid());

				// Enviar e-mail com o recovery

		
				$this->Session->setFlash('Logo irá receber um e-mail para confirmar sua troca de senha.', 'alerts/inline', array('id' => 'success'), 'auth');
			} else {
				$this->Session->setFlash('E-mail não cadastrado. Por favor, verifique se o e-mail digitado está correto.', 'alerts/inline', array('id' => 'error'), 'auth');
			}
	    }			
	}
/**
 * admin_login method (Login de usuários)
 *
 * @return void
 */
	public function admin_login() 
	{
		// Carrega o layout de login
		$this->layout = 'login';
		//Define o <title>
		$this->set('title_for_layout', __('Login'));

		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$this->Session->write($this->Auth->sessionKey, $this->Auth->user());
				
				$this->User->id = $this->Auth->user('id');
				$this->User->saveField('last_access', date(DATE_ATOM));
				
				return $this->redirect('/admin');
			} else {
				$this->Session->setFlash('Falha no login. Por favor, verifique se o usuário e senha digitado estão corretos.', 'alerts/inline', array('id' => 'error'), 'auth');
			}
	    }
	}
	
/**
 * admin_logout method (Logout de usuários)
 *
 * @return void
 */
	public function admin_logout() 
	{
		// Apaga a sessão 
		$this->Session->delete($this->Auth->sessionKey);
		// Redireciona para local configurado no app_controller
		$this->redirect($this->Auth->logout());
	}

/**
 * admin_recovery method (Recuperar senha de usuários)
 *
 * @return void
 */
	public function admin_recovery() 
	{
		$this->layout = 'admin_login';
		$this->set('title_for_layout', __('Recuperar senha'));	
		
		// Foi efetuado um POST?
		if ($this->request->is('post')) {
			$this->User->recursive = 0;
			$user = $this->User->find('first', array('conditions'=>array('User.email'=>$this->request->data['User']['email']), ''));

			if (count($user) > 0) {
				$this->User->id = $user['User']['id'];
				$this->User->saveField('reset', String::uuid());

				// Enviar e-mail com o recovery

		
				$this->Session->setFlash('Logo irá receber um e-mail para confirmar sua troca de senha.', 'alerts/inline', array('id' => 'success'), 'auth');
			} else {
				$this->Session->setFlash('E-mail não cadastrado. Por favor, verifique se o e-mail digitado está correto.', 'alerts/inline', array('id' => 'error'), 'auth');
			}
	    }			
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() 
	{
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() 
	{
		// Foi efetuado um POST?
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('O Usuário foi salvo.'), 'alerts/inline', array('id' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('O Usuário não pode ser salvo. Por favor verifique os campos obrigatórios, e tente novamente.'), 'alerts/inline', array('id' => 'error'));
			}
			// debug para mostrar os erros de validação
			//debug($this->User->validationErrors);

		}
		$states = $this->User->estadosBrasil;
		$this->set(compact('states'));

		// usando o mesmo template do EDIT
		$this->render('admin_edit');
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) 
	{
		$this->User->id = $id;
		if (! $this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		// Foi efetuado um POST ou um PUT?
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('O Usuário foi salvo.'), 'alerts/inline', array('id' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('O Usuário não pode ser salvo. Por favor verifique os campos obrigatórios, e tente novamente.'), 'alerts/inline', array('id' => 'error'));
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
		}
		$states = $this->User->estadosBrasil;
		$this->set(compact('states'));
	}

/**
 * admin_delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) 
	{
		if (! $this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->User->id = $id;
		if (! $this->User->exists()) {
			throw new NotFoundException(__('Usuário inválido.'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash(__('O Usuário foi apagado.'), 'alerts/inline', array('id' => 'success')); 
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('O Usuário não pode ser apagado.'), 'alerts/inline', array('id' => 'error'));
		$this->redirect(array('action' => 'index'));
	}
}
