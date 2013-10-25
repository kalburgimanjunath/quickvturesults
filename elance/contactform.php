<?php include("header.php");?>
<script src="js/register.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="css/credmine.css">
<body onload="load()">
<div class="row-fluid">
	<div class="container">
		<?php include("nav.php");?>
		<div class="row-fluid"  class="scrollspy-example" data-offset="0" data-target="#navbarExample" data-spy="scroll">
            
			<div class="container" >	<br/><br/><br/>
			    <ul class="breadcrumb">
					<li>
					<a href="index.php">Home</a> <span class="divider">/</span>
					</li>
					<li>
					<a href="contactform.php">Contact us</a> <span class="divider">/</span>
					</li>				
				</ul>
				<div class="page-header">Contact Us</div>
			  <div class="span10">
			  Please tell us how we can help you and we will follow up with you shortly. If you need an even faster response, feel free to give us a call.
			  </div>
			  <div class="span6">
				<!-- Form Code Start -->
					<form id='contactus' class="well" method='post' accept-charset='UTF-8'>
				
					<fieldset>
						<div class="control-group">
							<label for="name" class="control-label">Your Full name</label>
							<div class="controls">
							  <input type="text" id="name" class="input-xlarge">
							  <p class="help-block"></p>
							</div>
					    </div>
						<div class="control-group">
							<label for="input01" class="control-label">Your Email</label>
							<div class="email">
							  <input type="text" id="email" class="input-xlarge">
							  <p class="help-block"></p>
							</div>
					    </div>
						<div class="control-group">
							<label for="message" class="control-label">Message</label>
							<div class="controls">
							  <textarea rows="3" id="message" class="input-xlarge"></textarea>
							  <p class="help-block"></p>
							</div>
					    </div>
						<div class="form-actions">
							<button class="btn btn-primary" id="contact_submit" type="submit">Submit</button>
							
						</div>
					</fieldset>
					</form>
					
					
			  </div>
			  
			  <div class="span12"></div>	
			<div class="span12"></div>
			<div class="span12"></div>
		  </div>
		  
			</div><!--/row-->
         
			
        </div><!--/span-->

<?php include("footer.php");?>	

<script language="javascript" type="text/javascript">
	$(document).ready(function() {		
		$("#name").focusin(
			function() {
			    $(this).css("border-color", "#000099");
		    }
		);

		$("#name").focusout(
			function() {
			    $(this).css("border-color", "#CCCCCC");
			}
		);

		
		
		$("#name").inputTip({
            goodText: "Ok!",
            badText: "Can't leave this blank",
            tipText: "Enter your full name",
            validateText: function(inputValue, callback) {
                if (inputValue.length > 0) callback(1);
                else callback(0);
            },
            validateInRealTime: false
        });
		
		
		
		

        $("#email").inputTip({
            goodText: "Ok!",
            badText: "Please enter a valid email",
            tipText: "Enter your email address",
            validateText: function(inputValue, callback) {
                var emailRegexp = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if (emailRegexp.test(inputValue)) callback(1);
                else callback(0);
            },
            validateInRealTime: false
        });
		
		$("#message").inputTip({
            goodText: "Ok!",
            badText: "Can't leave this blank",
            tipText: "Enter your full name",
            validateText: function(inputValue, callback) {
                if (inputValue.length > 0) callback(1);
                else callback(0);
            },
            validateInRealTime: false
        });
		
		
		
    });

	$("#contact_submit").click(function(event) {
		//alert ("Register");
	    var data = getFormData();

	    //validation
	    if (validateform(data)) {
	        // post here
	        var postUrl = "contact_form.php";
	       
	       $.ajax({
	                 type: "POST",
	                 url: postUrl,
	                 dataType: 'json',
	                 data:  { request : JSON.stringify(data)  } ,
	                 success: function(response, status){
							
		                         alert("Thank you for using our mail form");
		                         //var signinurl = "contact_form.php";
		                     	 window.location.href = "contact_form.php";
		                   
	                 },
	                 error: function(response) {
						///alert("Error: " + response.message + " code : " + response.code);
	                 }
	         });
	    } 

	    return false;
			
	});

    function getFormData() {

    	//user_name, #user_screen_name, #user_password, #user_email
	    var account = { 
	    	'account' : {
		        'name' : $("#name").val(),
				'email' : $("#email").val(),
				'message' : $("#message").val()
		    }
	    };
	    return account;
    }

    function validateform(data) {

	    var valid = true;
	/*
	    if (isEmpty(data.account.name)) {
	        $("#name").html("Name is required");
	        $("#name").addClass("inputerror");
	        valid=false;
		} else {
	        $("#nameerror").html("");
	    }
	
	    if (! validateEmail(data.account.email)) {
	        $("#emailerror").html("A valid email is required");
	        $("#email").addClass("inputerror");
	        valid=false;
	    } else {
	        $("#emailerror").html("");
	    }
		
		if (isEmpty(data.account.message)) {
	        $("#messageerror").html("Message is required");
	        $("#name").addClass("inputerror");
	        valid=false;
		} else {
	        $("#messageerror").html("");
	    }
	*/
	    return valid;   
    }
	function load(){
	var str='http://manjunathmstore.wordpress.com/contact-me/';
		//location.replace(str);
	}
	
</script>		
