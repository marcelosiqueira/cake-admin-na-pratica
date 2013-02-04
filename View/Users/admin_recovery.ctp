<div class="account-container">
	<div class="content clearfix">
		<h1>Recuperar</h1>	

		<?php
		if($this->Session->check('Message.auth')) {
			echo $this->Session->flash('auth');
		}
		?>
		
		<div class="login-fields">
			<?php
			echo $this->Form->create('User', array(
				'/manager/recovery',
				'inputDefaults' => array(
					'label' => false,
					'div' => 'input-prepend',
					'class' => 'login',
					'requerid' => 'requerid',
					'error' => array (
						'attributes'=>array(
							'wrap' => 'span',
						    'id' => false,
						    'class' => 'label label-important',
						),
					)
				)
			));	

			echo $this->Form->input('email', array(
						'between' => '<span class="add-on img-field"><i class="icon-envelope"></i></span>',
						'placeholder' => 'Seu E-mail',
						'id'=>'username',
						'class' => 'login username-field'
					)
			);

			echo $this->Form->button(' Enviar ', array('type'=>'submit', 'class'=>'button btn btn-success btn-large'));
			echo $this->Form->end(null);
			?>
		</div> <!-- /login-fields -->
		
	</div> <!-- /content -->
</div> <!-- /account-container -->
<!-- Text Under Box -->
<div class="login-extra">
	<?php 
	echo 'Lembrou, quer entrar agora? '.$this->Html->link('Lembrei', '/admin/login'); 
	?>
</div> <!-- /login-extra -->