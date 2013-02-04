<?php
class PagesController extends AppController 
{

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

	public function home() 
	{
		//Define o <title>
		$this->set('title_for_layout', '');
		
	}

	public function admin_dashboard() 
	{
		//Define o <title>
		$this->set('title_for_layout', __('Dashboard'));
		
	}


/**
 * Displays a view
 *
 * @param string What page to display
 */
	public function display() 
	{
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage'));
		$this->set('title_for_layout', $title);
		$this->render(implode('/', $path));
	}

}
