<?php
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');
App::uses('Folder', 'Utility');

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
		// Define o <title>
		$this->set('title_for_layout', __('Categorias'));

		$this->Category->recursive = 0;
		// Variaveis para view
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
		// Testa se a Categoria existe
		$this->Category->id = $id;
		if (! $this->Category->exists()) {
			throw new NotFoundException(__('Produto inválido!'));
		}
		// Variaveis para view
		$this->set('category', $this->Category->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() 
	{
		// Define o <title>
		$this->set('title_for_layout', __('Nova Categoria'));

		// Foi efetuado um POST?
		if ($this->request->is('post')) {
			// Cria slug para URL amigavel
			$this->request->data['Category']['slug'] = Inflector::slug(mb_strtolower($this->request->data['Category']['title']), '-');

			// Insert 
			$this->Category->create();
			if ($this->Category->save($this->request->data)) {
				$this->Session->setFlash(__('O Produto foi salvo.'), 'alerts/inline', array('id' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('O Produto não pode ser salvo. Por favor, Por favor verifique os campos obrigatórios, e tente novamente.'), 'alerts/inline', array('id' => 'error'));
			}
		}
		// Variaveis para view
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
		// Define o <title>
		$this->set('title_for_layout', __('Editar Categoria'));

		// Testa se a Categoria existe
		$this->Category->id = $id;
		if (! $this->Category->exists()) {
			throw new NotFoundException(__('Produto inválido!'));
		}
		// Foi efetuado um POST?
		if ($this->request->is('post') || $this->request->is('put')) {
			// Cria slug para URL amigavel
			$this->request->data['Category']['slug'] = Inflector::slug(mb_strtolower($this->request->data['Category']['title']), '-');

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
		// Variaveis para view
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
		// Define o <title>
		$this->set('title_for_layout', __('Mídia'));
		
		// Testa se a Categoria existe
		$this->Category->id = $id;
		if (! $this->Category->exists()) {
			throw new NotFoundException(__('Categoria inválida!'));
		}		
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
		// Variaveis para o iew - inputs
		$this->request->data = $this->Category->read(null, $id);

		// Variaveis para o view
		$medias = $this->Category->Media->find('all', array('recursive' => 0, 'conditions' => array('Category.id' => $id)));
		$this->set(compact('medias'));

	}

/**
 * admin_media_delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_media_delete($id = null) 
	{
		// Se não foi um POST
		if (! $this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		// Testa se a Media existe
		$this->Category->Media->id = $id;
		if (! $this->Category->Media->exists()) {
			throw new NotFoundException(__('Mídia inválida!'));
		}

		// Apaga o diretorio e os arquivos desse Media
		$path  = new Folder(ROOT.DS.APP_DIR.DS.WEBROOT_DIR.DS.'files'.DS.'media'.DS.$id);
		$path->delete();

		// Apagar registro
		if ($this->Category->Media->delete()) {
			$this->Session->setFlash(__('A Mídia foi apagada.'), 'alerts/inline', array('id' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		// Se chegou aqui deu erro e não pode ser apagada
		$this->Session->setFlash(__('A Mídia não pode ser apagada.'), 'alerts/inline', array('id' => 'error'));
		$this->redirect(array('action' => 'index'));
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
		// Testa se a Categoria existe
		$this->Category->id = $id;
		if (! $this->Category->exists()) {
			throw new NotFoundException(__('Produto inválido!'));
		}
		// Apagar a Categoria
		if ($this->Category->delete()) {
			$this->Session->setFlash(__('O Produto foi apagado.'), 'alerts/inline', array('id' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		// Se chegou aqui deu erro e não pode ser apagada
		$this->Session->setFlash(__('O Produto não pode ser apagado.'), 'alerts/inline', array('id' => 'error'));
		$this->redirect(array('action' => 'index'));
	}
}