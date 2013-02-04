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
				'<i class="icon-group"></i> Usuários', 
				'/admin/users/',
				array('escape'=>false, 'title'=> 'Usuários')
			); 
			?> <span class="divider">/</span></li>
		<?php if ($this->Session->params['action'] == 'admin_add') { ?>
			<li class="active"><i class="icon-pencil"></i> Novo</li>
		<?php } else { ?>
			<li class="active"><i class="icon-edit"></i> Editar</li>
		<?php } ?>
	</ul>
</div>
<div class="row-fluid">
	<div class="span12">
		<?php 
		if($this->Session->check('Message.flash')) {
			echo $this->Session->flash();
		}

		echo $this->Form->create('User', array(
				'class' => 'form-horizontal', 
				'type' => 'file',
				'inputDefaults' => array(
					'div' => array(
						'class' => 'control-group'
					),
					'label' => array(
						'class' => 'control-label'
					),
					'class'  => 'span12',
				)
			)
		);
		?>
		<fieldset>
			<legend>
				<?php 
				if ($this->Session->params['action'] == 'admin_add') { 
					echo '<i class="icon-pencil"></i> '.__('Novo');
				} else {
					echo '<i class="icon-edit"></i> '.__('Editar');
				}
				echo '&nbsp;'.__('Usuário');
				?>
			</legend>
			<?php
			echo $this->Form->input('User.id', array('type'=>'hidden'));
			echo $this->Form->input('User.name', array(
					'label' => array('text' => 'Nome do Usuário: *'),
					'placeholder' => 'Entre com o seu nome', 
					'required' => 'required'
				) 
			);
			echo $this->Form->input('User.email', array(
					'label' => array('text' => 'E-mail/Login: *'),
					'placeholder' => 'Entre com o seu e-mail que também será seu usuário de login', 
					'required' => 'required'
				) 
			);
			echo '<div class="row-fluid">';
			echo $this->Form->input('User.password', array(
					'label' => array('text' => 'Senha: ' ),
					'div' => array('class' => 'control-group span6'),
					'type' => 'password',
					'placeholder' => 'Entre com a sua senha', 
					'value' => '',
				) 
			);
			echo $this->Form->input('User.password_confirm', array(
					'label' => array('text' => 'Repetir a Senha: '),
					'div' => array('class' => 'control-group span6'),
					'type' => 'password',
					'placeholder' => 'Entre novamente com a sua senha', 
					'value' => '',
				) 
			);
			echo '</div>';
			echo $this->Form->input('User.is_active', array('type'=>'hidden', 'value'=>'1'));
			?>
		</fieldset>

		<div class="control-group">
			<p><small>Caso preencha o campo de senha, sua senha será alterada, se não quiser alterá-la, basta deixa-lá em branco, que irá continuar a mesma.</small></p>
			<p>(*) Campos obrigatórios.</p>
		</div>

		<div class="control-group">
	    	<div class="form-actions">
				<?php
				echo $this->Form->button('Salvar', array('type' => 'submit', 'class'=>'btnb tn btn-large btn-primary'));
				?>
				<?php
				echo $this->Form->button('Cancelar e Listar Usuários', array(
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
