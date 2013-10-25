<form method="get" id ="searchform" class="searchform" action="#">
				<input type="hidden" name="basic-property-search" value="basic-property-search" />
                                <input type="text" class="field" name="search_address" id="search_address" style="width:25%" value="Address only here..." />
                                <input type="text" class="field" name="search_city" id="search_city" style="width:20%" value="City only here..." />
                                <input type="text" class="field" name="search_state" id="search_state" style="width:8%" value="State only here..." />
                                <input type="text" class="field" name="search_zip" id="search_zip" style="width:10%" value="Zip only here..." />
                                <div class="errorsearchformtest" >
                                    <div for="search_address" class="field errorsearchform" style="color:red;"></div>
				    <div for="search_city" class="field errorsearchform" style="color:red;"></div>
				    <div for="search_state" class="field errorsearchform" style="color:red;"></div>
				    <div for="search_zip"  class="field errorsearchform" style="color:red;"></div>
                                 </div>
                                <input type="submit" class="submit" name="submit" id="searchsubmit"  style="width:20%" />

				<div class="clearfix"></div>
				<div id="panel-search">

					<div class="header-advanced-pricing">
						<input type="text" class="field" name="price-min" id="price-min" placeholder="<?php _e('Min Price','progressionstudios'); ?>" />
					</div>

					<div class="price-range"><?php _e('to','progressionstudios'); ?></div>

					<div class="header-advanced-pricing">
						<input type="text" class="field" name="price-max" id="price-max" placeholder="<?php _e('Max Price','progressionstudios'); ?>" />
					</div>



					<div class="hidden-values">
						<select name="city">
							<option value="" selected="selected"><?php echo of_get_option('city_text', 'Choose City'); ?></option>
							<?php foreach($city as $c): ?>
							<option value="<?php echo $c; ?>" <?php if($_GET['city'] == $c): ?>selected="selected"<?php endif; ?>><?php echo $c; ?></option>
							<?php endforeach; ?>
						</select>
						<select name="state">
							<option value="" selected="selected"><?php echo of_get_option('state_text', 'State'); ?></option>
							<?php foreach($state as $s): ?>
							<option value="<?php echo $s; ?>" <?php if($_GET['state'] == $s): ?>selected="selected"<?php endif; ?>><?php echo $s; ?></option>
							<?php endforeach; ?>
						</select>
						<select name="zip">
							<option value="" selected="selected"><?php echo of_get_option('zip_text', 'Zip code'); ?></option>
							<?php foreach($zip as $z): ?>
							<option value="<?php echo $z; ?>" <?php if($_GET['zip'] == $z): ?>selected="selected"<?php endif; ?>><?php echo $z; ?></option>
							<?php endforeach; ?>
						</select>
					</div>



					<div class="header-advanced-bedbath">
						<select name="beds">
							<option value="" selected="selected"><?php echo of_get_option('beds_text', 'Beds'); ?></option>
							<option value="1">1+ <?php echo of_get_option('beds_text_short', 'bd'); ?></option>
							<option value="2">2+ <?php echo of_get_option('beds_text_short', 'bd'); ?></option>
							<option value="3">3+ <?php echo of_get_option('beds_text_short', 'bd'); ?></option>
							<option value="4">4+ <?php echo of_get_option('beds_text_short', 'bd'); ?></option>
							<option value="5">5+ <?php echo of_get_option('beds_text_short', 'bd'); ?></option>
						</select>
					</div>


					<div class="header-advanced-bedbath">
						<select name="baths">
							<option value="" selected="selected"><?php echo of_get_option('baths_text', 'Baths'); ?></option>
							<option value="1">1+ <?php echo of_get_option('baths_text_short', 'ba'); ?></option>
							<option value="2">2+ <?php echo of_get_option('baths_text_short', 'ba'); ?></option>
							<option value="3">3+ <?php echo of_get_option('baths_text_short', 'ba'); ?></option>
							<option value="4">4+ <?php echo of_get_option('baths_text_short', 'ba'); ?></option>
							<option value="5">5+ <?php echo of_get_option('baths_text_short', 'ba'); ?></option>
						</select>
					</div>



					<div class="header-prop-typestatus">
						<select name="sqft">
							<option value="" selected="selected"><?php echo of_get_option('square_feet_text', 'Square Feet'); ?></option>
							<option value="250">250+ <?php echo of_get_option('square_feet_text_small', 'sqft'); ?></option>
							<option value="500">500+ <?php echo of_get_option('square_feet_text_small', 'sqft'); ?></option>
							<option value="1000">1000+ <?php echo of_get_option('square_feet_text_small', 'sqft'); ?></option>
							<option value="1250">1250+ <?php echo of_get_option('square_feet_text_small', 'sqft'); ?></option>
							<option value="1500">1500+ <?php echo of_get_option('square_feet_text_small', 'sqft'); ?></option>
							<option value="2000">2000+ <?php echo of_get_option('square_feet_text_small', 'sqft'); ?></option>
							<option value="2500">2500+ <?php echo of_get_option('square_feet_text_small', 'sqft'); ?></option>
							<option value="3000">3000+ <?php echo of_get_option('square_feet_text_small', 'sqft'); ?></option>
							<option value="3500">3500+ <?php echo of_get_option('square_feet_text_small', 'sqft'); ?></option>
							<option value="4000">4000+ <?php echo of_get_option('square_feet_text_small', 'sqft'); ?></option>
						</select>
					</div>

					<?php
					$ptype = get_terms('property_type');
					if($ptype):
					?>
					<div class="header-prop-typestatus">
						<select name="ptype">
							<option value="" selected="selected"><?php echo of_get_option('property_type_text', 'Property Type'); ?></option>
							<?php foreach($ptype as $pt): ?>
							<?php if($pt->name != 'Featured'): ?>
							<?php if($pt->name != 'Homepage'): ?>
							<?php if($pt->name != 'Widget'): ?>
								<?php if($pt->name != 'featured'): ?>
								<?php if($pt->name != 'homepage'): ?>
								<?php if($pt->name != 'widget'): ?>
							<option value="<?php echo $pt->slug; ?>"><?php echo $pt->name; ?></option>
							<?php endif; ?>
							<?php endif; ?>
							<?php endif; ?>
							<?php endif; ?>
							<?php endif; ?>
							<?php endif; ?>

							<?php endforeach; ?>
						</select>
					</div>
					<?php endif; ?>

					<div class="header-prop-typestatus hidden-value-tablet">
						<select name="status">
							<option value="" selected="selected"><?php echo of_get_option('property_status_text', 'Property Status'); ?></option>
							<option value="For Rent"><?php _e('For Rent','progressionstudios'); ?></option>
							<option value="For Sale"><?php _e('For Sale','progressionstudios'); ?></option>
							<option value="Open House"><?php _e('Open House','progressionstudios'); ?></option>
							<!--option value="Reduced">Recently Reduced</option-->
						</select>
					</div>

					<a class="more-search-options" href="<?php echo $purl; ?>"><?php _e('More search options','progressionstudios'); ?></a>

				</div>



			</form>