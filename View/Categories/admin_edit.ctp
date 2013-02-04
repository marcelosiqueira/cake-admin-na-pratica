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
				'<i class="icon-sitemap"></i> Categorias', 
				'/admin/categories/',
				array('escape'=>false, 'title'=> 'Categorias')
			); 
			?> <span class="divider">/</span></li>
		<?php if ($this->Session->params['action'] == 'admin_add') { ?>
			<li class="active"><i class="icon-pencil"></i> Nova</li>
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

		echo $this->Form->create('Category', array(
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
					echo __('Nova');
				} else {
					echo '<i class="icon-edit"></i> ';
					echo __('Editar');
				}
				echo '&nbsp;'.__('Categoria');
				?>
			</legend>
			<?php
			echo $this->Form->hidden('Category.id');
			echo $this->Form->input('Category.title', array(
					'label' => array('text' => 'Titulo da Categoria: *'),
					'class' => 'span12',
					'placeholder' => 'Entre com o titulo da categoria', 
					'required' => 'required'
				) 
			);
			echo $this->Form->input('Category.parent_id', array(
					'label' => array('text' => 'Parente: '),
					'class' => 'span12',
					'empty'=> 'Nenhuma Categoria Parente (Essa é uma Categoria Pai)',
					'options' => $categories
				) 
			);
			echo $this->Form->input('Category.is_active', array('type'=>'hidden', 'value'=>'1'));
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

				echo $this->Form->button('Cancelar e Listar Categorias', array(
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