
(function( $ ) {
	'use strict';


	// igualar cantidad en agregar a carrito
	$('.illantas_qty input.qty').change( function() {
		var link = $(this).parent().parent().find('.add_to_cart_button');
		link.data( 'quantity', $(this).val() );
	});


})( jQuery );