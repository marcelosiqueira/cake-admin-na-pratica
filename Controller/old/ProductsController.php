<?php
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * Products Controller
 *
 * @property Product $Product
 */
class ProductsController extends AppController 
{

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() 
	{
		$this->set('products', $this->paginate());
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
		$this->Product->id = $id;
		if (! $this->Product->exists()) {
			throw new NotFoundException(__('Produto inválido!'));
		}
		$this->set('product', $this->Product->read(null, $id));
	}

/**
 * admin_add_category method
 *
 * @return void
 */
	public function admin_add_category() 
	{
		if($this->request->is('ajax')) {
			$i = 1;

			if(isset($this->request->query['categoryIndex']) && $this->request->query['categoryIndex'] != null) {
				$i = Sanitize::paranoid($this->request->query['categoryIndex']);
			}

			if(isset($this->request->query['fatherId']) && $this->request->query['fatherId'] != null) {
				$father = Sanitize::paranoid($this->request->query['fatherId']);
				$categories = $this->Product->Category->find('list', array('conditions' => array('Category.parent_id' => $father)));
			}

			if (count($categories) == 0) {
				$this->render(false);
				return;
			}

			$this->set(compact('i', 'father', 'categories'));
			$this->render('add_category');
			return;
		}
	
		throw new MethodNotAllowedException();
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() 
	{
		if ($this->request->is('post')) {
			// Cria slug para URL amigavel
			$this->request->data['Product']['slug'] = Inflector::slug(mb_strtolower($this->request->data['Product']['title']), '-');

			// elimina variaveis que não serão salvas
			unset($this->request->data['Category']['counter']);			

			// pr($this->request->data); exit();
			// insert 
			$this->Product->create();
			if ($this->Product->saveAll($this->request->data)) {
				// salva ategorias relacionadas ao produto
				foreach ($this->request->data['Category'] as $key => $category) {
					$this->request->data['CategoriesProduct']['product_id'] = $this->Product->id;
					$this->request->data['CategoriesProduct']['category_id'] = $category['id'];
					$this->request->data['CategoriesProduct']['created'] = 'CURRENT_TIMESTAMP';
					$this->Product->CategoriesProduct->create();
					$this->Product->CategoriesProduct->save($this->request->data);
				}
				$this->Session->setFlash(__('O Produto foi salvo.'), 'alerts/inline', array('id' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('O Produto não pode ser salvo. Por favor, Por favor verifique os campos obrigatórios, e tente novamente.'), 'alerts/inline', array('id' => 'error'));
			}
		}
		$categories = $this->Product->Category->find('list', array('conditions' => array('Category.parent_id  IS NULL')));
		$this->set(compact('categories'));
		
		// usando o mesmo template do EDIT
		$this->render('admin_edit');
	}

/**
 * admin_edit method
 *
 * NÃO FINALIZADO
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) 
	{
		$this->Product->id = $id;
		if (! $this->Product->exists()) {
			throw new NotFoundException(__('Produto inválido!'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {
			// Cria slug para URL amigavel
			$this->request->data['Product']['slug'] = Inflector::slug(mb_strtolower($this->request->data['Product']['name']), '-');
			// atribui o registo ao usuário q está logado
			$this->request->data['Product']['user_id'] = $this->Session->read('Auth.User.id');

			//pr($this->request->data); exit();
			if ($this->Product->saveAll($this->request->data)) {
				$this->Session->setFlash(__('O Produto foi salvo.'), 'alerts/inline', array('id' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('O Produto não pode ser salvo. Por favor verifique os campos obrigatórios, e tente novamente.'), 'alerts/inline', array('id' => 'error'));
			}
		} else {
			$this->request->data = $this->Product->read(null, $id);
		}
		$categories = $this->Product->Category->find('list');
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
		if ($this->request->is('post') || $this->request->is('put')) {
			//pr($this->request->data); exit();

			if ($this->Product->saveAll($this->request->data)) {
				$this->Session->setFlash(__('A Mídia foi salvo.'), 'alerts/inline', array('id' => 'success'));
				$this->redirect(array('action' => 'media', $id));
			} else {
				$this->Session->setFlash(__('A Mídia não pode ser salvo. Por favor, tente novamente.'), 'alerts/inline', array('id' => 'error'));
			}
			// debug para mostrar os erros de validação
			//debug($this->Product->validationErrors);
		}
	
		$this->request->data = $this->Product->read(null, $id);
	}

/**
 * admin_delete method
 *
 * NÃO FINALIZADO
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
		$this->Product->id = $id;
		if (! $this->Product->exists()) {
			throw new NotFoundException(__('Produto inválido!'));
		}
		if ($this->Product->delete()) {
			$this->Session->setFlash(__('O Produto foi apagado.'), 'alerts/inline', array('id' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('O Produto não pode ser apagado.'), 'alerts/inline', array('id' => 'error'));
		$this->redirect(array('action' => 'index'));
	}
	
}