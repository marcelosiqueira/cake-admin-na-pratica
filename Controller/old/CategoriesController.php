<?php
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * Categories Controller
 *
 * @property Category $Category
 */
class CategoriesController extends AppController 
{

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() 
	{
		$this->Category->recursive = 0;
		$this->set('categories', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) 
	{
		$this->Category->id = $id;
		if (! $this->Category->exists()) {
			throw new NotFoundException(__('Produto inválido!'));
		}
		$this->set('category', $this->Category->read(null, $id));
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
			// Cria slug para URL amigavel
			$this->request->data['Category']['slug'] = Inflector::slug(mb_strtolower($this->request->data['Category']['name']), '-');

			// Insert 
			$this->Category->create();
			if ($this->Category->save($this->request->data)) {
				$this->Session->setFlash(__('O Produto foi salvo.'), 'alerts/inline', array('id' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('O Produto não pode ser salvo. Por favor, Por favor verifique os campos obrigatórios, e tente novamente.'), 'alerts/inline', array('id' => 'error'));
			}
		}
		$categories = $this->Category->find('list');
		$this->set(compact('categories'));
		
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
		$this->Category->id = $id;
		if (! $this->Category->exists()) {
			throw new NotFoundException(__('Produto inválido!'));
		}
		// Foi efetuado um POST?
		if ($this->request->is('post') || $this->request->is('put')) {
			// Cria slug para URL amigavel
			$this->request->data['Category']['slug'] = Inflector::slug(mb_strtolower($this->request->data['Category']['name']), '-');

			// Update
			if ($this->Category->saveAll($this->request->data)) {
				$this->Session->setFlash(__('O Produto foi salvo.'), 'alerts/inline', array('id' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('O Produto não pode ser salvo. Por favor verifique os campos obrigatórios, e tente novamente.'), 'alerts/inline', array('id' => 'error'));
			}
		} else {
			$this->request->data = $this->Category->read(null, $id);
		}
		$categories = $this->Category->find('list');
		$this->set(compact('categories'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_media($id = null) 
	{
		// Foi efetuado um POST ou um PUT?
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Category->saveAll($this->request->data)) {
				$this->Session->setFlash(__('A Mídia foi salvo.'), 'alerts/inline', array('id' => 'success'));
				$this->redirect(array('action' => 'media', $id));
			} else {
				$this->Session->setFlash(__('A Mídia não pode ser salvo. Por favor, tente novamente.'), 'alerts/inline', array('id' => 'error'));
			}
			// debug para mostrar os erros de validação
			//debug($this->Category->validationErrors);
		}
	
		$this->request->data = $this->Category->read(null, $id);
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
		// Se não foi um POST
		if (! $this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Category->id = $id;
		if (! $this->Category->exists()) {
			throw new NotFoundException(__('Produto inválido!'));
		}
		if ($this->Category->delete()) {
			$this->Session->setFlash(__('O Produto foi apagado.'), 'alerts/inline', array('id' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('O Produto não pode ser apagado.'), 'alerts/inline', array('id' => 'error'));
		$this->redirect(array('action' => 'index'));
	}
}