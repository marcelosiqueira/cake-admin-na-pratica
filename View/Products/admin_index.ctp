<div class="row-fluid">
	<ul class="breadcrumb">
		<li><?php 
			echo $this->Html->link(
				'<i class="icon-dashboard"></i> Dashboard', 
				'/admin/',
				array('escape'=>false, 'title'=> 'Dashboard')
			); 
			?> <span class="divider">/</span></li>
		<li class="active"><i class="icon-desktop"></i> Produtos</li>
	</ul>
</div>
<div class="row-fluid">
	<div class="span12">
		<?php
		if($this->Session->check('Message.flash')) {
			echo $this->Session->flash();
		}
		?>

		<h2 class="span10"><i class="icon-desktop"></i> <?php echo __('Produtos'); ?></h2>
		<span class="pull-right">
			<?php 
			echo $this->Html->link(
				'<i class="icon-pencil"></i> Novo Produto', 
				array('action' => 'add'),
				array('class'=>'btn', 'escape'=>false, 'title'=> 'Novo Produto')
			); 
			?>
		</span>

		<table class="table table-striped table-bordered table-condensed" cellpadding="0" cellspacing="0">
		<tr>
				<th><?php echo $this->Paginator->sort('tittle', 'Titulo'); ?></th>
				<th><?php echo $this->Paginator->sort('category', 'Categoria'); ?></th>
				<th><?php echo $this->Paginator->sort('is_active', 'Ativo?'); ?></th>
				<th><?php echo $this->Paginator->sort('created', 'Criado'); ?></th>
				<th class="span4"><?php echo __('Actions'); ?></th>
		</tr>
		<?php foreach ($products as $product): ?>
		<tr>
			<td><?php echo h($product['Product']['title']); ?>&nbsp;</td>
			<td>
				<?php 
				foreach ($product['Category'] as $key => $category) {
					echo h($category['title'] . ($key != end(array_keys($product['Category'])) ? ' > ' : ''));
				}
				?>&nbsp;
			</td>
			<td><?php echo h($product['Product']['is_active'] == 1 ? 'Sim' : 'Não'); ?>&nbsp;</td>
			<td><?php echo h(date("d/m H:i", strtotime($product['Product']['created']))); ?>&nbsp;</td>
			<td class="actions">
				<?php 
				echo $this->Html->link(
					'<i class="icon-picture"></i> Mídia', 
					array('action' => 'media', $product['Product']['id']),
					array('escape'=>false, 'title'=> 'Enviar Imagens e Videos')
				);
				?>
				<?php 
				echo $this->Html->link(
					'<i class="icon-edit"></i> Editar', 
					array('action' => 'edit', $product['Product']['id']),
					array('escape'=>false, 'title'=> 'Editar')
				); 
				?>
				<?php 
				echo $this->Form->postLink(
					'<i class="icon-trash"></i> Remover', 
					array('action' => 'delete', $product['Product']['id']), 
					array('escape'=>false, 'title'=> 'Remover'), 
					__('Tem certeza de que deseja excluir %s?', $product['Product']['title'])
				); 
				?>
			</td>
		</tr>
		<?php endforeach; ?>
		</table>

		<?php echo $this->element("admin/pagination"); ?>
		
	</div>
</div>