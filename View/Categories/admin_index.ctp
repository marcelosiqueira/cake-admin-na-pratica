<div class="row-fluid">
	<ul class="breadcrumb">
		<li><?php 
			echo $this->Html->link(
				'<i class="icon-dashboard"></i> Dashboard', 
				'/admin/',
				array('escape'=>false, 'title'=> 'Dashboard')
			); 
			?> <span class="divider">/</span></li>
		<li class="active"><i class="icon-sitemap"></i> Categorias</li>
	</ul>
</div>
<div class="row-fluid">
	<div class="span12">
		<?php
		if($this->Session->check('Message.flash')) {
			echo $this->Session->flash();
		}
		?>

		<h2 class="span10"><i class="icon-sitemap"></i> <?php echo __('Categorias'); ?></h2>
		<span class="pull-right">
			<?php 
			echo $this->Html->link(
				'<i class="icon-pencil"></i> Nova Categoria', 
				array('action' => 'add'),
				array('class'=>'btn', 'escape'=>false, 'title'=> 'Nova Categoria')
			); 
			?>
		</span>

		<table class="table table-striped table-bordered table-condensed" cellpadding="0" cellspacing="0">
		<tr>
				<th><?php echo $this->Paginator->sort('Category.tittle', 'Titulo'); ?></th>
				<th><?php echo $this->Paginator->sort('Parent.tittle', 'Parente:'); ?></th>
				<th><?php echo $this->Paginator->sort('Category.is_active', 'Ativo?'); ?></th>
				<th><?php echo $this->Paginator->sort('Category.created', 'Criado'); ?></th>
				<th class="span4"><?php echo __('Actions'); ?></th>
		</tr>
		<?php foreach ($categories as $category): ?>
		<tr>
			<td><?php echo h($category['Category']['title']); ?>&nbsp;</td>
			<td><?php echo h($category['Category']['parent_id'] == 0 ? 'Categoria Pai' : $category['ParentCategory']['title']); ?>&nbsp;</td>
			<td><?php echo h($category['Category']['is_active'] == 1 ? 'Sim' : 'Não'); ?>&nbsp;</td>
			<td><?php echo h(date("d/m H:i", strtotime($category['Category']['created']))); ?>&nbsp;</td>
			<td class="actions">
				<?php 
				echo $this->Html->link(
					'<i class="icon-picture"></i> Mídia', 
					array('action' => 'media', $category['Category']['id']),
					array('escape'=>false, 'title'=> 'Enviar Imagens e Videos')
				);
				?>
				<?php 
				echo $this->Html->link(
					'<i class="icon-edit"></i> Editar', 
					array('action' => 'edit', $category['Category']['id']),
					array('escape'=>false, 'title'=> 'Editar')
				); 
				?>
				<?php 
				echo $this->Form->postLink(
					'<i class="icon-trash"></i> Remover', 
					array('action' => 'delete', $category['Category']['id']), 
					array('escape'=>false, 'title'=> 'Remover'), 
					__('Tem certeza de que deseja excluir %s?', $category['Category']['title'])
				); 
				?>
			</td>
		</tr>
		<?php endforeach; ?>
		</table>

		<?php echo $this->element("admin/pagination"); ?>
		
	</div>
</div>