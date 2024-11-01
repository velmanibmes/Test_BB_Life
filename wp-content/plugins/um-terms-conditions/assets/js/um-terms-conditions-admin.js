/* wp-admin scripts for the "Ultimate Member - Terms & Conditions" plugin. */

jQuery( function () {
	var tcae_data = window.um_terms_conditions_agreement_email || {};
	var tcae_form = document.forms['um-tc-agreement-email-form'];
	var tcae_tmpl = wp.template( 'tcae-progress' );

	if ( tcae_data.state === 'run' ) {
		jQuery( '#tcae_progress' ).replaceWith( tcae_tmpl( tcae_data ) );
		tcae_ajax_run();
	}

	jQuery( tcae_form )
			.on( 'submit', tcae_start )
			.on( 'click', '#tcae_start', tcae_start )
			.on( 'click', '#tcae_run', tcae_run )
			.on( 'click', '#tcae_pause', tcae_pause )
			.on( 'click', '#tcae_stop', tcae_stop );

	function tcae_ajax_run() {
		if ( tcae_data.state !== 'run' ) {
			return;
		}

		jQuery( '#tcae_role,#tcae_start' ).attr( 'disabled', true ).next( '.spinner' ).css( 'visibility', 'visible' );

		var data = {
			user_role: tcae_form.elements.user_role.value,
			action: tcae_form.elements.um_adm_action.value,
			_wpnonce: tcae_form.elements._wpnonce.value
		};

		return wp.ajax.post( data.action, data )
				.done( function ( response ) {
					if ( 'object' === typeof response ) {
						if ( 'done' === response.state ) {
							jQuery( '#tcae_role,#tcae_start' ).attr( 'disabled', false ).next( '.spinner' ).css( 'visibility', 'hidden' );
						} else
						if ( 'error' === response.state ) {
							jQuery( '#tcae_role,#tcae_start' ).attr( 'disabled', false ).next( '.spinner' ).css( 'visibility', 'hidden' );
							response.state = '';
						}  else
						if ( 'pause' === tcae_data.state ) {
							response.state = 'pause';
						} else
						if ( 'run' === tcae_data.state ) {
							tcae_ajax_run();
						}

						jQuery.extend( tcae_data, response );
						jQuery( '#tcae_progress' ).replaceWith( tcae_tmpl( tcae_data ) );

						wp.hooks.doAction( 'um_tcae_ajax_run_done', response );
					}
				} )
				.fail( function ( response ) {
					console.warn( 'UM - Terms & Conditions: tcae_ajax_run', response );
				} );
	}

	function tcae_ajax_stop() {

		var data = {
			action: 'terms_conditions_agreement_email_stop',
			_wpnonce: tcae_form.elements._wpnonce.value
		};

		return wp.ajax.post( data.action, data )
				.done( function ( response ) {
					jQuery( '#tcae_role,#tcae_start' ).attr( 'disabled', false ).next( '.spinner' ).css( 'visibility', 'hidden' );
					jQuery( '#tcae_progress' ).html( '' );

					wp.hooks.doAction( 'um_tcae_ajax_stop_done', response );
				} )
				.fail( function ( response ) {
					console.warn( 'UM - Terms & Conditions: tcae_ajax_stop', response );
				} );
	}

	function tcae_pause( e ) {
		e.preventDefault();
		if ( tcae_data.state === 'run' ) {
			tcae_data.state = 'pause';
			jQuery( '#tcae_start' ).next( '.spinner' ).css( 'visibility', 'hidden' );
			jQuery( '#tcae_progress' ).replaceWith( tcae_tmpl( tcae_data ) );
		}
	}

	function tcae_run( e ) {
		e.preventDefault();
		if ( tcae_data.state === 'pause' ) {
			tcae_data.state = 'run';
			jQuery( '#tcae_start' ).next( '.spinner' ).css( 'visibility', 'visible' );
			jQuery( '#tcae_progress' ).replaceWith( tcae_tmpl( tcae_data ) );
			tcae_ajax_run();
		}
	}

	function tcae_start( e ) {
		e.preventDefault();
		if ( tcae_data.state !== 'run' ) {
			tcae_data.state = 'run';
			jQuery( '#tcae_progress' ).html( '' );
			tcae_ajax_run();
		}
	}

	function tcae_stop( e ) {
		e.preventDefault();
		tcae_data.state = '';
		jQuery( '#tcae_progress' ).html( '' );
		tcae_ajax_stop();
	}

} );