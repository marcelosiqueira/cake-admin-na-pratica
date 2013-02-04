<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Pagina {:page} de {:pages}, mostrando {:current} registros de uma total de {:count} total, a partir de registo {:start}, que termina em {:end}.')
	));
	?>
</p>

<?php if ($this->Paginator->hasPrev() || $this->Paginator->hasNext()) { ?>

<div class="pagination pagination-centered">
	<ul>
	<?php
		echo $this->Paginator->prev(
			'<span><< </span>', 
			array(), 
			null, 
			array('escape' => false, 'class' => 'disabled', 'tag' => 'li')
		);

		echo $this->Paginator->numbers(
			array('before' => '<span>', 'after' => '</span>', 'separator' => '', 'tag' => 'li', 'currentClass' => 'active')
		);

		echo $this->Paginator->next(
			'<span> >></span>', 
			array(), 
			null, 
			array('escape' => false, 'class' => 'disabled', 'tag' => 'li')
		);
	?>
	</ul>
</div>
<?php } ?>