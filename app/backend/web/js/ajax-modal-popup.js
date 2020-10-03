$(function(){
	//Obtenemos el evento "Click" del elemento con class="showModalButton"
	$(document).on('click', '.showModalButton', function(){
		//Comprueba sin el modal esta siendo visible en este momento
		if($('#modal').data('bs.modal').isShown){
			$('#modal').find('#modalContent')
				.load($(this).attr('value'));
			//Colocamos el header del modal
			document.getElementById('modalHeader').innerHTML = '<h4>'+$(this).attr('title')+'</h4>';
		} else {//Si el modal no esta abierto, se abre y se carga el contenido
			$('#modal').modal('show')
						.find('#modalContent')
						.load($(this).attr('value'));
			//colocamos el header del modal
			document.getElementById('modalHeader').innerHTML = '<h4>'+$(this).attr('title')+'</h4>';
		}
	});
});