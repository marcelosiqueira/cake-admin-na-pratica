<div class="row">
	<ul class="breadcrumb">
		<li><?php 
			echo $this->Html->link(
				'<i class="icon-dashboard"></i> Dashboard', 
				'/admin/',
				array('escape'=>false, 'title'=> 'Dashboard')
			); 
			?> <span class="divider">/</span></li>
		<li><?php 
			echo $this->Html->link(
				'<i class="icon-desktop"></i> Produtos', 
				'/admin/products/',
				array('escape'=>false, 'title'=> 'Produtos')
			); 
			?> <span class="divider">/</span></li>
		<?php if ($this->Session->params['action'] == 'admin_add') { ?>
			<li class="active"><i class="icon-pencil"></i> Novo</li>
		<?php } else { ?>
			<li class="active"><i class="icon-edit"></i> Editar</li>
		<?php } ?>
	</ul>
</div>
<div class="row">
	<div class="span12">
		<?php 
		if($this->Session->check('Message.flash')) {
			echo $this->Session->flash();
		}

		echo $this->Form->create('Product', array(
				'class' => 'form-horizontal', 
				'type' => 'file',
				'inputDefaults' => array(
					'div' => array(
						'class' => 'control-group'
					),
					'label' => array(
						'class' => 'control-label'
					)

				)
			)
		);
		?>
		<fieldset>
			<legend>
				<?php 
				if ($this->Session->params['action'] == 'admin_add') { 
					echo '<i class="icon-pencil"></i> ';
					echo __('Novo');
				} else {
					echo '<i class="icon-edit"></i> ';
					echo __('Editar');
				}
				echo '&nbsp;'.__('Produto');
				?>
			</legend>
			<?php
			echo $this->Form->hidden('Product.id');
			echo $this->Form->input('Product.title', array(
					'label' => array('text' => 'Titulo do Producto: *'),
					'class' => 'span12',
					'placeholder' => 'Entre com o titulo do produto', 
					'required' => 'required'
				) 
			);
			echo $this->Form->input('Category.0.id', array(
					'label' => array('text' => 'Categoria Pai: *'),
					'id' => 'CategorySelect0',
					'class' => 'span12 CategorySelect',
					'data-link' => $this->Html->url('/admin/products/add_category'),
					'data-nivel' => '0',
					'onChange' => 'javascript:category(this);',
					'empty'=> 'Escolha a Categoria',
					'options' => $categories
				) 
			);
			?>
			<div id="categoryProduct">
				<?php 
				echo $this->Form->input('Category.counter', array('type' => 'hidden', 'value' => 0, 'id' => 'categoryCounter'));
				$counter = 0;
				if(isset($this->request->data['Category']) && !empty($this->request->data['Category'])) {
					foreach($this->request->data['Category'] as $key => $category) {
						// Se não foi a Categoria pai faz um request
						if ($key > 0) {
							echo $this->requestAction("/admin/products/add_category/index:".$key."/fatherId:".$category['parent_id']."/id:".$category['id']);
							$counter++;
						}
					}
				}
				echo $this->Html->scriptBlock('$("#categoryCounter").val('. $counter .')', array('inline'=>false)); ?>
			</div>
			<div id="categoryLoad" class="hide"><i class="icon-spinner icon-spin icon-2x pull-left"></i><br /></div>
			<br />
			<?php
			echo $this->Form->input('Product.description', array(
					'label' => array('text' => 'Descrição: *'),
					'class' => 'span12 ckeditor'
				) 
			);
			echo $this->Form->input('Product.is_active', array('type'=>'hidden', 'value'=>'1'));
			?>
		</fieldset>

		<div class="control-group">
			(*) Campos obrigatórios.
		</div>

		<div class="control-group">
	    	<div class="form-actions">
				<?php
				echo $this->Form->button('Salvar', array('type' => 'submit', 'class'=>'btnb tn btn-large btn-primary'));
				?>
				<?php
				echo $this->Form->button('Cancelar e Listar Produtos', array(
						'onclick' => "window.location='".$this->Html->url(array('action'=>'index'))."';",
						'type' => 'button', 
						'class'=>'btnb tn btn-large btn-success'
					)
				);
				?>
			</div>
		</div>
	</div>
	<?php echo $this->Form->end(null); ?>
	</div>
</div>
<?php
// Carrega o ckeditor
echo $this->Html->script(array(
		'ckeditor/ckeditor.js'
	),
	array('inline' => false)
);