( function ( document, $, undefined ) {
	'use strict';

	// Initiate side menu
	$( '#edit-toggle' ).sidr({
		name: 'edit-post',
		side: 'left',
		renaming: false,
		// displace: false,
		onOpen: function() {
			// Set aria-pressed is true
			$( '#edit-toggle' ).attr( 'aria-pressed', function() {
				return 'true';
			});
		},
		onClose: function() {
			// Set aria-pressed to false
			$( '#edit-toggle' ).attr( 'aria-pressed', function() {
				return 'false';
			});
		},
	});

	// Close the navigation if close link is clicked
	$( '.edit-close' ).on( 'click', function() {
		var $this = $( this );
		$this.attr( 'aria-pressed', function() {
			return 'false';
		});
		$.sidr( 'close' , 'edit-post' );
	});

})( this, jQuery );