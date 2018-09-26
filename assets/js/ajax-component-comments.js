/*
 * функция удаления uk-alert
 */
 

jQuery(function($) {      
	$("#submit").click(function() {
		setTimeout(function() {
			UIkit.alert('.uk-alert').close()		
		}, 2000);
	});
});


 $('.error').attr('placeholder', 'Search for Stuff');


jQuery(function($) {
  // If i use jquery i have to link the file
	$("#submit").click( function(e) {
	  var $inputValue = $('.error').val();
	  if($inputValue) {
	    // with value
	    $('#respond').parent().children('.children').append(newComment);
	  } else {
	    // without value
	    UIkit.notification({
		    message: 'my-message!',
		    status: 'danger',
		    pos: 'top-right',
		    timeout: 2000
			});
	  }
	  e.preventDefault();
	});
});
