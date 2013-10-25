<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js?ver=1.8.1'></script>
<script type='text/javascript' src='http://dimitri.clientdemos.pw/wp-content/themes/Freehold-child/lib/js/jquery.validate.js?ver=3.5.1'></script>
<script>
 
 $(document).ready(function() {
 
/*   
   jQuery.validator.addMethod(
            'defaultCheck', function (value, element) {
                if (element.value == element.defaultValue) {
                    return false;
                }
                return true;
  });*/
 
 jQuery.validator.addMethod("val_address", function(value, element) {
	if(value == 'Address only here...'){
		return false;	
	}
    //return  (value == 'Address only here...');
}, "Address must be set to a value other than default...");
 
 jQuery.validator.addMethod("val_city", function(value, element) {
	if(value == 'City only here...'){
		return false;	
	}
    //return (value == 'City only here...');
    
}, "City must be set to a value other than default...");


jQuery.validator.addMethod("val_zip", function(value, element) {
    if(value == 'Zip only here...'){
	return false;	
    }else if (!value.match(/[0-9]+/)){
	return false;
    }
    
}, "Zip must be set to a value other than default...");

jQuery.validator.addMethod("val_state", function(value, element) {
	if(value == 'State only here...'){
		return false;	
	}
    //return (value == 'State only here...');
}, "State must be set to a value other than default...");
     
     
    
    var ruleSetaddress = {
        val_address : true,
        required: true
        
    };
    
    var ruleSetcity = {
        val_city : true,
        required: true
        
    };
    
    var ruleSetstate = {
        val_state : true,
        required: true
        
    };
    
    var ruleSetzip = {
        val_zip : true,
        required: true
        
    };
     
    $("#advanced-searchform").validate({
	rules: {        	        		
	search_address: ruleSetaddress,
        search_city: ruleSetcity,
        search_state: ruleSetstate,
        search_zip: ruleSetzip	 
                        
			 	
    	},  
	    errorClass: "erroradvsearchform", //Defines error class as 'error'
            errorElement: "div",
	    messages: {
    		search_address: " Enter Address",
    		search_city: " Enter City",
    		search_state: " Enter State",
    		search_zip: " Enter Zip",
    		 
	    }
	});
        
        
     $("#searchform").validate({
		rules: {        	        		
		search_address: ruleSetaddress,
        search_city: ruleSetcity,
        search_state: ruleSetstate,
        search_zip: ruleSetzip
                        
			 	
    	},  
	    errorClass: "errorsearchform", //Defines error class as 'error'
            errorElement: "div",
	    messages: {
    		search_address: " Enter Address",
    		search_city: " Enter City",
    		search_state: " Enter State",
    		search_zip: " Enter Zip",
    		 
	    }
	});
	$(".errorsearchform").show(); 
});

</script>
                    
			<form method="get" id ="searchform" class="searchform" action="#">
				<input type="hidden" name="basic-property-search" value="basic-property-search" />
                                <input type="text" class="field" name="search_address" id="search_address" style="width:25%" value="Address only here..." />
                                <input type="text" class="field" name="search_city" id="search_city" style="width:20%" value="City only here..." />
                                <input type="text" class="field" name="search_state" id="search_state" style="width:8%" value="State only here..." />
                                <input type="text" class="field" name="search_zip" id="search_zip" style="width:10%" value="Zip only here..." />
                                <div  style="display:block;">
                                    <div for="search_address" class="errorsearchform" style="color:red;"></div>
				    <div for="search_city" class="errorsearchform" style="color:red;"></div>
				    <div for="search_state" class="errorsearchform" style="color:red;"></div>
				    <div for="search_zip" class="errorsearchform" style="color:red;"></div>
                                 </div>
                                <input type="submit" class="submit" name="submit" id="searchsubmit"  style="width:20%" />
				
				<div class="clearfix"></div>
				<div id="panel-search">
					
					<div class="header-advanced-pricing">
						<input type="text" class="field" name="price-min" id="price-min" placeholder="Min Price" />
					</div>
					
					<div class="price-range">to</div>
					
					<div class="header-advanced-pricing">
						<input type="text" class="field" name="price-max" id="price-max" placeholder="Max Price" />
					</div>
					
					
		
					<div class="hidden-values">
						<select name="city"> 
							<option value="" selected="selected">Choose City</option> 
							 
						</select>
						<select name="state">
							<option value="" selected="selected">State</option>
							 
						</select>
						<select name="zip"> 
							<option value="" selected="selected">Zip</option> 
							 
						</select>
					</div>
					
		
					
					<div class="header-advanced-bedbath">
						<select name="beds"> 
							<option value="" selected="selected">Beds</option> 
							<option value="1">1+ bd</option> 
							<option value="2">2+ bd</option> 
							<option value="3">3+ bd</option> 
							<option value="4">4+ bd</option> 
							<option value="5">5+ bd</option> 
						</select>
					</div>		
					
					
					<div class="header-advanced-bedbath">
						<select name="baths"> 
							<option value="" selected="selected">Baths</option> 
							<option value="1">1+ ba</option> 
							<option value="2">2+ ba</option> 
							<option value="3">3+ ba</option> 
							<option value="4">4+ ba</option> 
							<option value="5">5+ ba</option> 
						</select>
					</div>
					
					
					
					<div class="header-prop-typestatus">
						<select name="sqft"> 
							<option value="" selected="selected">Square Feet</option> 
							<option value="250">250+ sqft</option> 
							<option value="500">500+ sqft</option> 
							<option value="1000">1000+ sqft</option> 
							<option value="1250">1250+ sqft</option> 
							<option value="1500">1500+ sqft</option> 
							<option value="2000">2000+ sqft</option> 
							<option value="2500">2500+ sqft</option> 
							<option value="3000">3000+ sqft</option> 
							<option value="3500">3500+ sqft</option> 
							<option value="4000">4000+ sqft</option> 
						</select>
					</div>

										
					<div class="header-prop-typestatus hidden-value-tablet">
						<select name="status"> 
							<option value="" selected="selected">Property Status</option> 
							<option value="For Rent">For Rent</option> 
							<option value="For Sale">For Sale</option> 
							<option value="Open House">Open House</option> 
							<!--option value="Reduced">Recently Reduced</option--> 
						</select>
					</div>
					
					<a class="more-search-options" href="http://dimitri.clientdemos.pw/?post_type=property">More search options</a>
			
				</div>
				
			</form>
		</div><!-- close width-container -->
                
                
