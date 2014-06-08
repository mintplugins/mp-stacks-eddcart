jQuery(document).ready(function($){
		
	//When a new item has been added to the cart using ajax in EDD
	$(document).on('edd_quantity_updated', function(event){
		
		setTimeout(function () {		
			$( '.mp-stacks-eddcart-cart-btn .edd-cart-quantity' ).animate({
				padding: 6,
				top: -3.5,
				right: -3.5
			}, 50, function() {
				// Animation complete.
				$( '.mp-stacks-eddcart-cart-btn .edd-cart-quantity' ).animate({
					padding: 2,
					top: 0,
					right: 0
				}, 150);
			});
		}, 50 );
	});	
});