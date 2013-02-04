<div class="row-fluid">
	<ul class="breadcrumb">
		<li><?php 
			echo $this->Html->link(
				'<i class="icon-dashboard"></i> Dashboard', 
				'/admin/',
				array('escape'=>false, 'title'=> 'Dashboard')
			); 
			?> <span class="divider">/</span></li>
		<li class="active"><i class="icon-group"></i> Usuários</li>
	</ul>
</div>
<div class="row-fluid">
	<div class="span12">
		<?php
		if($this->Session->check('Message.flash')) {
			echo $this->Session->flash();
		}
		?>
		
		<h2 class="span10"><i class="icon-group"></i> <?php echo __('Usuários'); ?></h2>
		<span class="pull-right">
			<?php 
			echo $this->Html->link(
				'<i class="icon-pencil"></i> Novo Usuário', 
				array('action' => 'add'),
				array('class'=>'btn', 'escape'=>false, 'title'=> 'Novo Usuário')
			); 
			?>
		</span>

		<table class="table table-striped table-bordered table-condensed" cellpadding="0" cellspacing="0">
		<tr>
				<th><?php echo $this->Paginator->sort('name', 'Nome'); ?></th>
				<th><?php echo $this->Paginator->sort('email', 'E-mail'); ?></th>
				<th><?php echo $this->Paginator->sort('created', 'Criado'); ?></th>
				<th class="span4"><?php echo __('Actions'); ?></th>
		</tr>
		<?php
		foreach ($users as $user): ?>
		<tr>
			<td><?php echo h($user['User']['name']); ?>&nbsp;</td>
			<td><?php echo h($user['User']['email']); ?>&nbsp;</td>
			<td><?php echo h(date("d/m H:i", strtotime($user['User']['created']))); ?>&nbsp;</td>
			<td class="actions">
				<?php 
				echo $this->Html->link(
					'<i class="icon-edit"></i> Editar', 
					array('action' => 'edit', $user['User']['id']),
					array('escape'=>false, 'title'=> 'Editar')
				); 
				?>
				<?php 
				echo $this->Form->postLink(
					'<i class="icon-trash"></i> Remover', 
					array('action' => 'delete', $user['User']['id']), 
					array('escape'=>false, 'title'=> 'Remover'), 
					__('Tem certeza de que deseja excluir %s?', $user['User']['name'])
				); 
				?>
			</td>
		</tr>
		<?php endforeach; ?>
		</table>

		<?php echo $this->element("admin/pagination"); ?>
		
	</div>
</div>