(function($) {
  $( '.ajax-post' ).on( 'click', function( e ) {
    e.preventDefault();
    var post_id = $(this).attr( 'data-id-post' );
    $.ajax({
      //cache: false,
      //timeout: 8000,
      url: php_array.admin_ajax,
      type: "POST",
      data: ({ action:'theme_post_example', id:post_id }),
      beforeSend: function() {
          $( '.ajax-response' ).html( '<div class="uk-flex uk-flex-center uk-padding" uk-spinner="ratio: 2"></div>' );
      },
      success: function( data, textStatus, jqXHR ){
        var $ajax_response = $( data );
        $( '.ajax-response' ).html( $ajax_response );
      },
      error: function( jqXHR, textStatus, errorThrown ){
        console.log( 'The following error occured: ' + textStatus, errorThrown );
      },
      complete: function( jqXHR, textStatus ){
      }
    });
  });
})(jQuery);
