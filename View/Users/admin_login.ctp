<div class="content">
	<div class="row">
		<div class="login-form">
			<?php
			if($this->Session->check('Message.auth')) {
				echo $this->Session->flash('auth');
			}
			?>
			<h2>Login</h2>
			<?php 

			echo $this->Form->create('Category', array(
					'url' => array('controller' => 'users', 'action' => 'login'),
					'class' => 'login', 
					'inputDefaults' => array(
						'div' => array(
							'class' => 'input-prepend'
						),
						'label' => false,
					)
				)
			);
			?>
			<fieldset>
				<?php
				echo $this->Form->input('User.email', array(
						'placeholder' => 'Seu E-mail', 
						'between' => '<span class="add-on"><i class="icon-envelope"></i></span>'
					));
				echo $this->Form->input('User.password', array(
						'placeholder' => 'Sua Senha', 
						'between' => '<span class="add-on"><i class="icon-lock"></i></span>',
					));
				?>
				<button class="btn btn-large btn-primary pull-right" type="submit">Entrar</button>
			</fieldset>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
<?php //echo $this->Html->link(__('Esqueceu sua senha?'), array('controller' => 'users', 'action' => 'recover'), array('glyph' => true, 'icon' => 'key')); ?>
