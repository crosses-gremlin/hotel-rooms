(function( $ ) {
	'use strict';
	$(document).ready(function() {
		if ($('.hotel-rooms').length) {
			$( ".hotel-rooms" ).each(function( ) {
				let $block = $(this);
				var ajaxdata = {
					action     : 'get_hotel_rooms',
					nonce_code : hotel_rooms.vars.nonce,
					rooms: $(this).attr('data-rooms'),
					numberposts:  $(this).attr('data-numberposts'),
					orderby:  $(this).attr('data-orderby'),
					order:  $(this).attr('data-order'),
				};
				$.get( hotel_rooms.vars.ajaxurl, ajaxdata )
				.done( function( response ) {
						$block.find('.hotel-rooms-list').html(response);
					} )
					.fail( function() {
						$block.find('.hotel-rooms-list').text('<p class="hotel-rooms-list__error">' + hotel_rooms.vars.error + '</p>');
					} )
			})
		}
	})
})( jQuery );
