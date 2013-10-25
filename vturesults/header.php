<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>  <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<?php if(is_front_page() && of_get_option('home_title')): ?>
	<title><?php echo of_get_option('home_title'); ?></title>
	<?php else: ?>
	<title><?php bloginfo('name'); ?> <?php wp_title(' - ', true, 'left'); ?></title>
	<?php endif; ?>
	<?php if(is_front_page() && of_get_option('home_meta')): ?>
    <meta name="description" content="<?php echo of_get_option('home_meta'); ?>" /> 
	<?php endif; ?>
	<meta name="viewport" content="width=device-width">
	<?php if(of_get_option('favicon')): ?>
	<link href="<?php echo of_get_option('favicon'); ?>" rel="shortcut icon" /> 
	<?php endif; ?>

	<meta name="viewport" content="width=device-width">
           
        
	<script src="http://maps.google.com/maps/api/js?sensor=true" type="text/javascript"></script>
	<?php wp_head(); ?>
        
	<?php echo '<style type="text/css">'; ?>
		nav {padding-top:<?php echo of_get_option('navigation_padding', '18px'); ?>; }
	.lt-ie8 #logo img, .lt-ie8 #logo {max-width:<?php echo of_get_option('logo_width', '144px'); ?>;}	
	<?php if(of_get_option('retina_logo', 'no') == 'yes'): ?>body #logo img {max-width:100%; height: auto;} .lt-ie9 body #logo {max-width:100%; }<?php endif; ?>
	<?php if(of_get_option('right_sidebar', 'no') == 'yes'): ?>#container-sidebar {float:left;} #sidebar { float:right;}<?php endif; ?>
	<?php if(of_get_option('custom_css')): ?><?php echo of_get_option('custom_css'); ?><?php endif; ?>
	nav, h1, h2, footer h3, footer h4, footer h5, footer h6 {font-family: '<?php echo of_get_option('navigation_font', 'PT Sans'); ?>', sans-serif; }
	input.submit, input.submit-advanced, .featured-price, h3, h4, h5, h6, .listings-address-widget, .page-count, .pagination, .button, .property-information-address, .property-information-price, #child-pages li a {font-family: '<?php echo of_get_option('submenu_font', 'Open Sans'); ?>', sans-serif; font-weight:600;}
	.featured-address-number {font-family: <?php echo of_get_option('featured_address', 'Georgia'); ?>, serif;}
	.featured-address-city, .listings-street-widget, .post-data, .share-section, .property-information-location, .property-highlight, .property-status, .share-section-listing span.share-text {font-family:"<?php echo of_get_option('secondary_address', 'Times New Roman'); ?>", Georgia, serif; }
	
	<?php if(of_get_option('currency_image')): ?>
	input#price-min, input#price-max {background-image:url(<?php echo of_get_option('currency_image', get_template_directory_uri() . '/images/dollar-sign.png'); ?>);}
	<?php endif; ?>
	
	<?php echo '</style>'; ?>
	
	<?php if(of_get_option('custom_js')): ?>
	 
	<?php echo of_get_option('custom_js'); ?>
	<?php echo '</script>'; ?>
	<?php endif; ?>
        
    
        
</head>
<body <?php body_class(''); ?>>

	<div class="header-top">
		<div class="width-container">
			<div class="header-top-left">
				<?php if(of_get_option('phone_number', '(800) 536-3532')): ?>
				<span href="" class="phone-header-top"><?php echo of_get_option('phone_number', '(800) 536-3532'); ?></span>
				<?php endif; ?>
				<?php if(of_get_option('email_address', 'no-reply@progressionstudios.com')): ?>
				<a href="mailto:<?php echo of_get_option('email_address', 'no-reply@progressionstudios.com'); ?>" class="email-header-top"><?php echo of_get_option('email_address', 'no-reply@progressionstudios.com'); ?></a>
				<?php endif; ?>
			</div><!-- close .header-top-left -->
			<div class="social-icons">
					<?php if(of_get_option('rss_link_header')): ?>
					<a class="rss" href="<?php echo of_get_option('rss_link_header'); ?>" target="_blank">r</a>
					<?php endif; ?>
					<?php if(of_get_option('facebook_link_header')): ?>
					<a class="facebook" href="<?php echo of_get_option('facebook_link_header'); ?>" target="_blank">F</a>
					<?php endif; ?>
					<?php if(of_get_option('twitter_link_header')): ?>
					<a class="twitter" href="<?php echo of_get_option('twitter_link_header'); ?>" target="_blank">t</a>
					<?php endif; ?>
					<?php if(of_get_option('skype_link_header')): ?>
					<a class="skype" href="<?php echo of_get_option('skype_link_header'); ?>" target="_blank">s</a>
					<?php endif; ?>
					<?php if(of_get_option('vimeo_link_header')): ?>
					<a class="vimeo" href="<?php echo of_get_option('vimeo_link_header'); ?>" target="_blank">v</a>
					<?php endif; ?>
					<?php if(of_get_option('linkedin_link_header')): ?>
					<a class="linkedin" href="<?php echo of_get_option('linkedin_link_header'); ?>" target="_blank">l</a>
					<?php endif; ?>
					<?php if(of_get_option('dribbble_link_header')): ?>
					<a class="dribbble" href="<?php echo of_get_option('dribbble_link_header'); ?>" target="_blank">d</a>
					<?php endif; ?>
					<?php if(of_get_option('forrst_link_header')): ?>
					<a class="forrst" href="<?php echo of_get_option('forrst_link_header'); ?>" target="_blank">f</a>
					<?php endif; ?>
					<?php if(of_get_option('flickr_link_header')): ?>
					<a class="flickr" href="<?php echo of_get_option('flickr_link_header'); ?>" target="_blank">n</a>
					<?php endif; ?>
					<?php if(of_get_option('google_link_header')): ?>
					<a class="google" href="<?php echo of_get_option('google_link_header'); ?>" target="_blank">g</a>
					<?php endif; ?>
					<?php if(of_get_option('youtube_link_header')): ?>
					<a class="youtube" href="<?php echo of_get_option('youtube_link_header'); ?>" target="_blank">y</a>
					<?php endif; ?>
			</div><!-- close .social-icons -->
		<div class="clearfix"></div>
		</div><!-- close .width-container -->
	</div>

	<header>
		<div class="header-border-top"></div>
		<div class="width-container">
			
			<h1 id="logo"><a href="<?php echo site_url(); ?>"><img src="<?php echo of_get_option('logo', get_template_directory_uri() . '/images/logo.png'); ?>" alt="<?php bloginfo('name'); ?>" /></a></h1>
			
			<nav>
				<?php wp_nav_menu(array('theme_location' => 'main_nav', 'depth' => 4, 'menu_class' => 'sf-menu')); ?>
			</nav>
			
		<div class="clearfix"></div>
		</div><!-- close .width-container -->
		<div class="header-border-bottom"></div>
	</header>

	<div id="search-container">
		<div class="width-container">
			<?php
                        $siteurl=  get_site_url();
                        $searchurl= $siteurl  ;
                         
                        $zillow_option = theme_get_zillow_options();
                        $key=$zillow_option['zillowapikey'];
                        $purl = get_post_type_archive_link('property');
                        $address_description = $zillow_option['zillowaddress'];
                        $city_description = $zillow_option['zillowcity'];
                        $state_description =$zillow_option['zillowstate'];
                        $zip_description = $zillow_option['zillowzip'];
                        //echo "Zillow API Key= ";
                        //echo  $key;
                        //echo "Address description=";
                        //echo  $address_description;
			?>
                    
<script>
 
 $(document).ready(function() {
 
 jQuery.validator.addMethod(
            'defaultCheck', function (value, element) {
                if (element.value == element.defaultValue) {
                    return false;
                }
                return true;
  });
  
 jQuery.validator.addMethod("val_address", function(value, element) {
    //return  (value == '<?php echo $zillow_option['zillowaddress']; ?>');
    if(value == '<?php echo $zillow_option['zillowaddress']; ?>'){
	return false;	
    }
}, "Address must be set to a value other than default...");
 
 jQuery.validator.addMethod("val_city", function(value, element) {
    //return (value == '<?php echo $zillow_option['zillowcity']; ?>');
    if(value == '<?php echo $zillow_option['zillowcity']; ?>'){
	return false;	
    }
}, "City must be set to a value other than default...");


jQuery.validator.addMethod("val_zip", function(value, element) {
    //return (value == '<?php echo $zillow_option['zillowzip']; ?>');
    
    if(value == '<?php echo $zillow_option['zillowzip']; ?>'){
	return false;	
    }else if (!value.match(/[0-9]+/))
	return false;
    }
}, "Zip must be set to a value other than default...");

jQuery.validator.addMethod("val_state", function(value, element) {
    //return (value == '<?php echo $zillow_option['zillowstate']; ?>');
    if(value == '<?php echo $zillow_option['zillowstate']; ?>'){
	return false;	
    }
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
	 
});

</script>                    
			<form method="get" id ="searchform" class="searchform" action="#">
				<input type="hidden" name="basic-property-search" value="basic-property-search" />
                                <input type="text" class="field" name="search_address" id="search_address" style="width:25%" value="Address only here..." />
                                <input type="text" class="field" name="search_city" id="search_city" style="width:20%" value="City only here..." />
                                <input type="text" class="field" name="search_state" id="search_state" style="width:8%" value="State only here..." />
                                <input type="text" class="field" name="search_zip" id="search_zip" style="width:10%" value="Zip only here..." />
                                <div class="errorsearchform">
                                    <div for="search_address" class="errorsearchform" style="color:red;"></div>
				    <div for="search_city" class="errorsearchform" style="color:red;"></div>
				    <div for="search_state" class="errorsearchform" style="color:red;"></div>
				    <div for="search_zip" class="errorsearchform" style="color:red;"></div>
                                 </div>
				 <div class="erroradvsearchform">
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
                
                
		
		 
	<div class="clearfix"></div>
	</div><!-- close #search-container -->

	<div class="width-container">
		<a href="#" class="search-drop-down"><?php _e('Search More','progressionstudios'); ?></a>
	</div>