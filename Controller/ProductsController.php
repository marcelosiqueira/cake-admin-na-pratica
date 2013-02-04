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
		$this->Product->recursive = 1;		
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
		// Testa se o Produto existe
		$this->Product->id = $id;
		if (! $this->Product->exists()) {
			throw new NotFoundException(__('Produto inválido!'));
		}

		// Variavel para o view
		$this->set('product', $this->Product->read(null, $id));
	}

/**
 * admin_add_category method
 *
 * @return void
 */
	public function admin_add_category() 
	{
		// A requisição veio por Ajax?
		if($this->request->is('ajax')) {
			$i = 1;
			// Se existe um _GET categoryIndex
			if(isset($this->request->query['categoryIndex']) && $this->request->query['categoryIndex'] != null) {
				$i = Sanitize::paranoid($this->request->query['categoryIndex']);
			}

			// Se existe um _GET fatherId
			if(isset($this->request->query['fatherId']) && $this->request->query['fatherId'] != null) {
				$father = Sanitize::paranoid($this->request->query['fatherId']);
				$categories = $this->Product->Category->find('list', array('conditions' => array('Category.parent_id' => $father)));
			}

			// Se não existir categorias filhos return
			if (count($categories) == 0) {
				$this->render(false);
				return;
			}

			// Variaveis para o view
			$this->set(compact('i', 'father', 'categories'));
			$this->render('add_category');
			return;
		}

		// Se existe um _GET index
		if(isset($this->passedArgs['index']) && is_numeric($this->passedArgs['index'])) {
			$i = $this->passedArgs['index'];

			// Se existe um _GET id
			if(isset($this->passedArgs['id'])) {
				$id = $this->passedArgs['id'];

				$father = $this->passedArgs['fatherId'];

				$categories = $this->Product->Category->find('list', array('conditions' => array('Category.parent_id' => $father)));

				// Se não existir categorias filhos return
				if (count($categories) == 0) {
					$this->render(false);
					return;
				}
			}

			// Variaveis para o view
			$this->set(compact('i', 'id', 'father', 'categories'));
			$this->render('add_category');
			return;
		}		
		// Se não for requeste e tentarem abrir a pagina
		throw new MethodNotAllowedException();
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() 
	{
		// Define o <title>
		$this->set('title_for_layout', __('Novo Produto'));

		// Foi efetuado um POST?
		if ($this->request->is('post')) {
			// Cria slug para URL amigavel
			$this->request->data['Product']['slug'] = Inflector::slug(mb_strtolower($this->request->data['Product']['title']), '-');

			// Elimina variaveis que não serão salvas
			unset($this->request->data['Category']['counter']);			

			// Insert 
			$this->Product->create();
			if ($this->Product->saveAll($this->request->data)) {
				// Salva ategorias relacionadas ao produto
				foreach ($this->request->data['Category'] as $key => $category) {
					if ($category['id']) {
						$data = array(
							'CategoriesProduct' => array(
								'product_id' => $this->Product->id,
								'category_id' => $category['id'],
								'created' => date("Y-m-d H:i:s"),
							)
						);
						pr($data);
						$this->Product->CategoriesProduct->create();
						$this->Product->CategoriesProduct->save($data);
					}
				}
				$this->Session->setFlash(__('O Produto foi salvo.'), 'alerts/inline', array('id' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('O Produto não pode ser salvo. Por favor, Por favor verifique os campos obrigatórios, e tente novamente.'), 'alerts/inline', array('id' => 'error'));
			}
		}

		// Variaveis para o view
		$categories = $this->Product->Category->find('list', array('conditions' => array('Category.parent_id  IS NULL')));
		$this->set(compact('categories'));
		
		// Usando o mesmo template do EDIT
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
		$this->set('title_for_layout', __('Editar Produto'));

		// Testa se o Produto existe
		$this->Product->id = $id;
		if (! $this->Product->exists()) {
			throw new NotFoundException(__('Produto inválido!'));
		}

		// Foi efetuado um POST ou PUT?
		if ($this->request->is('post') || $this->request->is('put')) {
			// Cria slug para URL amigavel
			$this->request->data['Product']['slug'] = Inflector::slug(mb_strtolower($this->request->data['Product']['title']), '-');

			// Elimina variaveis que não serão salvas
			unset($this->request->data['Category']['counter']);

			//pr($this->request->data); exit();

			if ($this->Product->saveAll($this->request->data)) {

				// Apaga todos os regitros desse Produto na tabela categories_products
				$categories = $this->Product->CategoriesProduct->find('all', array('conditions' => array('CategoriesProduct.product_id' => $id)));
				foreach ($categories as $key => $cat) {
					$this->Product->CategoriesProduct->id = $cat['id'];
					$this->Product->CategoriesProduct->delete();
				}

				// Salva ategorias relacionadas ao produto
				foreach ($this->request->data['Category'] as $key => $category) {
					if ($category['id']) {
						$data = array(
							'CategoriesProduct' => array(
								'product_id' => $this->Product->id,
								'category_id' => $category['id'],
								'created' => date("Y-m-d H:i:s"),
							)
						);
						pr($data);
						$this->Product->CategoriesProduct->create();
						$this->Product->CategoriesProduct->save($data);
					}
				}

				$this->Session->setFlash(__('O Produto foi salvo.'), 'alerts/inline', array('id' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('O Produto não pode ser salvo. Por favor verifique os campos obrigatórios, e tente novamente.'), 'alerts/inline', array('id' => 'error'));
			}
			// debug para mostrar os erros de validação
			debug($this->Product->validationErrors);

		} else {
			// Variaveis para o view - inputs
			$this->request->data = $this->Product->read(null, $id);
		}
		// Variaveis para o view
		$categories = $this->Product->Category->find('list', array('conditions' => array('Category.parent_id  IS NULL')));
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

		if ($this->request->is('post') || $this->request->is('put')) {
			//pr($this->request->data); exit();

			if ($this->Product->saveAll($this->request->data)) {
				$this->Session->setFlash(__('A Mídia foi salvo.'), 'alerts/inline', array('id' => 'success'));
				$this->redirect(array('action' => 'media', $id));
			} else {
				$this->Session->setFlash(__('A Mídia não pode ser salvo. Por favor, tente novamente.'), 'alerts/inline', array('id' => 'error'));
			}
		}
		// variaveis para o view - inputs
		$this->request->data = $this->Product->read(null, $id);
		
		// Variaveis para o view
		$medias = $this->Product->Media->find('all', array('recursive' => 0, 'conditions' => array('Product.id' => $id)));
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
		$this->Product->Media->id = $id;
		if (! $this->Product->Media->exists()) {
			throw new NotFoundException(__('Mídia inválida!'));
		}

		// Apaga o diretorio e os arquivos desse Media
		$path  = new Folder(ROOT.DS.APP_DIR.DS.WEBROOT_DIR.DS.'files'.DS.'media'.DS.$id);
		$path->delete();

		// Apagar registro
		if ($this->Product->Media->delete()) {
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
		// Testa se o Produto existe
		$this->Product->id = $id;
		if (! $this->Product->exists()) {
			throw new NotFoundException(__('Produto inválido!'));
		}
		
		// Apaga o Produto
		if ($this->Product->delete()) {
			$this->Session->setFlash(__('O Produto foi apagado.'), 'alerts/inline', array('id' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		
		// Se chegou aqui deu erro e não pode ser apagada
		$this->Session->setFlash(__('O Produto não pode ser apagado.'), 'alerts/inline', array('id' => 'error'));
		$this->redirect(array('action' => 'index'));
	}
	
}