$(document).ready(function(){

	// curtesy of johan @ #db-o-webb, irc.bsnet.se
	$("#view #save").on('click', function(event) { 
		$this = $(this); 
		if ($this.data('url')) { 
			$('#view').attr('action',  $this.data('url')); 
		} 
	});

	// i made this
	$("#view #delete").on('click', function(event) { 

		event.preventDefault();
		$( "#dialog-confirm" ).dialog({
				resizable: false,
				height:130,
				modal: true,
				buttons: {
					"Ta bort": function() {
							$('#view').attr('action',  $('#delete').data('url'));
							$('#view').submit();
					},
					"Avbryt": function() {
						$( this ).dialog( "close" );
					}
				}
		});

	});

});