(function( $ ) {
	'use strict';

	function um_terms_conditions_toggle_terms( me ) {
		$( ".um-terms-conditions-content" ).toggle( "fast", function() {
			if( $( ".um-terms-conditions-content" ).is(':visible') ){
				me.text( me.data('toggle-hide') );
			}

			if( $( ".um-terms-conditions-content" ).is(':hidden') ){
				me.text( me.data('toggle-show') );
			}

			wp.hooks.doAction( 'um_terms_conditions_toggle_terms', me );
		});
	}

	$(document).on('click', "a.um-toggle-terms" ,function() {
		um_terms_conditions_toggle_terms( $(this) );
	});


	$(document).on('click', "a.um-hide-terms" ,function() {
		let me = $(this).parents('.um-field-area' ).find('a.um-toggle-terms');
		um_terms_conditions_toggle_terms( me );
	});
})( jQuery );
