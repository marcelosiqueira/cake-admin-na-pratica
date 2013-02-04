// ajax para fazer um get com oas var e retornar um novo select
function category(v) {  
	$('#categoryLoad').show();
	var father = $(v).val();
	var nivel = $(v).data('nivel');
	var counter = parseInt($('#categoryCounter').val());

	for (var i=nivel;i<counter;i++) {
		$('#Category'+(i+1)).remove();
	}
	counter = nivel + 1;

	// Se não foi uma categoria pai não continua
	if (! father) {
		$('#categoryLoad').hide();
		return;
	}

	$.get(
		$(v).data('link'),
		{ fatherId : father, categoryIndex : counter },
		function(data) {
			$('#categoryLoad').hide();
			$('#categoryProduct').append(data);
			$('#categoryCounter').val(counter);
		}
	);
};