	$(function(){
        $('#contact-form').submit(function(){
        	
/*        	//check if terms of use checkbox was checked
        	if(!document.getElementById("accept_terms").checked){
        		alert('<? echo $terms_check_alert ?>');
        		return false;
        	}*/
        	
        	var invalid_inputs = $('#contact-form').validate(validation_rules).invalid;
        	if($('#contact-form').valid()){
        		//TODO add flag for accepted terms
          	$.post('./assets/includes/authentification.php?registration', {email: $('#registrationemail').val(), password: $('#password1').val()	, name: $('#name').val()}, 
	        	function(response){
	        		if(response == 201){
	        	      	window.location.href = "index.php?registration_successful";
	        	    }else if(response == 400){
	        	    	error_msg("<? echo $registrationError ?>");
	        	    }else if(response == 401){
	        	    	error_msg("<? echo $registrationInvalid ?>");
	        	    }else if(response == 403 || response == 405){
	        	    	error_msg("<? echo $registrationNotAllowed ?>");
	        	    }else{
	        	    	toggle_visibility('registration_fail');
	        	    }
	    		});
          	}else{
          		alert('<? echo $invalid_input ?>');
          	}
          return false;
        });
    });