<?php
if(!isset($i)) {$i = 1;}
if(!isset($id)) {$id = 0;}
?>
<div id="<?="Category{$i}"?>" data-original-title="resumo" data-content="<?="$i"?>">
	<?php 
	echo $this->Form->input("Category.{$i}.parent_id", array('value' => $father, 'type'=>'hidden'));
	echo $this->Form->input("Category.{$i}.id", array(
			'label' => array('text' => "Categoria Parente {$i}:"),
			'id' => "CategorySelect{$i}",
			'div' => false,
			'class' => 'span12 CategorySelect',
			'data-link' => $this->Html->url('/admin/products/add_category'),
			'data-nivel' => $i,
			'onChange' => 'javascript:category(this);',
			'empty'=> 'Escolha a Categoria',
			'options' => $categories,
			'selected' => $id
		)
	);
	?>
</div>