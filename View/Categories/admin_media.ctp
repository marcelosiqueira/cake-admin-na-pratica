<div class="row-fluid">
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
			<li class="active"><i class="icon-pencil"></i> Mídia</li>
	</ul>
</div>
<div class="row-fluid">
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
			<legend><i class="icon-pencil"></i> Mídia</legend>
			<?php
			echo $this->Form->hidden('Category.id');
			echo $this->Form->input('Category.title', array(
					'label' => array('text' => 'Titulo da Categoria: '),
					'class' => 'span12',
					'readonly' => 'readonly'
				) 
			);
			echo $this->Form->hidden('Media.0.model', array('value'=>'Category'));
			echo $this->Form->input('Media.0.media', array(
					'label' => array('text' => 'Média: *'),
					'class' => 'span12',
					'type' => 'file'
				) 
			);
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

<div class="row-fluid">
	<div class="span12">
		<?php
		foreach ($medias as $key => $media) {
			echo $this->Html->image('/files/media/'.$media['Media']['dir'].'/small_'.$media['Media']['media'], array('alt'=>$media['Category']['title'], 'class'=>'img-polaroid'));
			echo '<p>'.$this->Form->postLink(
					'<i class="icon-trash"></i> Remover', 
					array('action' => 'media_delete', $media['Media']['id']), 
					array('escape'=>false, 'title'=> 'Remover'), 
					__('Tem certeza de que deseja excluir essa mídia?')
			).'</p>';
		}
        ?>	
	</div>
</div>