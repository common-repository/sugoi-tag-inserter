<div>
</div>
<div class="wrap">
	<!-- define JS variables from PHP variables-->
	<?php 
	  $isGtmEnabled = $this->settings['sugotag_gtm_enabled'];
	  $isAwEnabled = $this->settings['sugotag_aw_enabled'];
	  $isGaEnabled = $this->settings['sugotag_ga_enabled'];
	  $isCrossDomainEnabled = $this->settings['sugotag_cross_domain_enabled'];
	?>
	<!-- END variable declaration-->
	<h2><?php echo $this->plugin->displayName; ?> &raquo; <?php _e('Settings', $this->plugin->name); ?></h2>
	<?php
    if (isset($this->message)) {
        ?>
        <div class="updated fade"><p><?php echo $this->message; ?></p></div>  
        <?php
    }
    if (isset($this->errorMessage)) {
        ?>
        <div class="error fade"><p><?php echo $this->errorMessage; ?></p></div>  
        <?php
    }
	?> 
	<div class='flex icon-header'>
	    <img class='icon' id="icon" src='<?php echo plugins_url("icons/icon_128.png", __FILE__ )?>'/>
	    <span class='logo'>
		<span><a href='https://github.com/akiras7171/sugoi-tag-inserter'>Sugoi Tag Inserter</a></span><br/>
		<span>Google Tags Made Easy: simpler, the better, always</span>
		</span> 
	</div>	

	<div id="poststuff">
    	<form action="options-general.php?page=<?php echo $this->plugin->name;?>" method="post">
    		<div id="post-body" class="metabox-holder columns-2">
    			<div id="post-body-content">
					<div id="normal-sortables" class="meta-box-sortables ui-sortable">                        
				   
					    <div class="postbox">
							<h3 class="hndle title-text" style="font-size:24px;">Easy Set-Up for Google Tags</h3>
							<div class="google-tag">
	
						    	<form action="options-general.php?page=<?php echo $this->plugin->name; ?>" method="post">
							   
								<div class="flex gtm-radio">
									 <span class='google-title' id='check-gtm'>Google Tag Maneger</span>
									<div class="custom-control custom-radio">
  								    	<input name='sugotag_gtm_enabled' type="radio" class="custom-control-input" id="gtm-yes" value="true" <?php echo $isGtmEnabled==="true"?"checked":""?>>
  										<label class="custom-control-label" for="gtm-yes">YES</label>
									</div>
									<div class="custom-control custom-radio gtm-no">
  										<input name='sugotag_gtm_enabled' type="radio" class="custom-control-input" id="gtm-no" value="false" <?php echo $isGtmEnabled!=="true"?"checked":""?>>
  										<label class="custom-control-label" for="gtm-no">NO</label>
									</div>
									<input name="sugotag_gtm_id" value="<?php echo $this->settings['sugotag_gtm_id']; ?>" class="id-input" id="gtm-id-input" placeholder="GTM-______">
								</div>    	
							
								<div class='flex aw-radio'id='gtag-aw'>
    		 						<span class='google-title' id='check-aw'>Google Ads (Global Site Tag: gtag.js)</span>
   							    	<div class="custom-control custom-radio aw-yes">
  										<input name="sugotag_aw_enabled" type="radio" class="custom-control-input" id="aw-yes" value="true" <?php echo $isAwEnabled==="true"?"checked":""?>>
  										<label class="custom-control-label" for="aw-yes">YES</label>
									</div>
									<div class="custom-control custom-radio aw-no">
  										<input name="sugotag_aw_enabled" type="radio" class="custom-control-input" id="aw-no" value="false" <?php echo $isAwEnabled!=="true"?"checked":""?>>
  										<label class="custom-control-label" for="aw-no">NO</label>
									</div>
									<input name='sugotag_aw_id' value="<?php echo $this->settings['sugotag_aw_id']; ?>" class="id-input" id="aw-id-input" placeholder="AW-______">
								</div>

								<div class="flex ga-radio" id='gtag-ga'>
    				 				<span class='google-title' id='check-ga'>Google Analytics (Global Site Tag: gtag.js)</span>
									 <div class="custom-control custom-radio ga-yes">
  										<input name="sugotag_ga_enabled" type="radio" class="custom-control-input" id="ga-yes" value="true" <?php echo $isGaEnabled==="true"?"checked":""?>>
  										<label class="custom-control-label" for="ga-yes">YES</label>
									</div>
									<div class="custom-control custom-radio ga-no">
  										<input name="sugotag_ga_enabled" type="radio" class="custom-control-input" id="ga-no" value="false" <?php echo $isGaEnabled!=="true"?"checked":""?>>
  										<label class="custom-control-label" for="ga-no">NO</label>
									</div>
									<input name='sugotag_ga_id' value="<?php echo $this->settings['sugotag_ga_id'];?>" class="id-input" id="ga-id-input" placeholder="UA-_______-_"> 
								</div>

								<div class="flex cross-domain-checkbox-parent" id='cross-domain'>
									<div class="cross-domain-input">					
									　<input name="sugotag_cross_domain_enabled" type="checkbox" id="sugotag-cross-domain-checkbox" <?php echo $isCrossDomainEnabled==="on"?"checked":""?>>
  									  <label class="form-check-label checkbox-label" for="sugotag-cross-domain-checkbox">
								   		 	Cross Domain Set-up for gtag
  										</label>
									  　<input name="sugotag_cross_domain_1st" value="<?php echo $this->settings['sugotag_cross_domain_1st']; ?>" class="id-input cross-domain-id-input" id="sugotag-cross-domain-1st" placeholder="domainA.com">
     								 	<input name="sugotag_cross_domain_2nd" value="<?php echo $this->settings['sugotag_cross_domain_2nd']; ?>" class="id-input cross-domain-id-input" id="sugotag-cross-domain-2nd" placeholder="domainB.net">
									</div>
								</div>
							</div> <!-- google-tags -->

							<h3 class="hndle title-text title-text-custom-script" style="font-size:24px;">Custom HTML Scripts</h3>

							<div class="custom-script">
								<p>
		                    		<label for="sugotag_insert_header"><strong><?php _e('CUSTOM HTML Scripts in <code>&lt;head&gt;</code>', $this->plugin->name); ?></strong></label>
		                    		<textarea name="sugotag_insert_header" id="sugotag_insert_header" class="widefat" rows="8" style="font-family:Courier New;"><?php echo $this->settings['sugotag_insert_header']; ?></textarea>	
		                    	</p>
		                    	<p>
		                    		<label for="sugotag_insert_footer"><strong><?php _e('CUSTOM HTML Scripts in <code>&lt;body&gt;</code>', $this->plugin->name); ?></strong></label>
		                    		<textarea name="sugotag_insert_footer" id="sugotag_insert_footer" class="widefat" rows="8" style="font-family:Courier New;"><?php echo $this->settings['sugotag_insert_footer']; ?></textarea>	
		                   		</p>
								<div class='hide' style="display:none;">
									<p>
				            		 	<label for="sugotag_insert_hidden_header"><strong><?php _e('CUSTOM HTML Scripts in <code>&lt;head&gt;</code>', $this->plugin->name); ?></strong></label>
				                   		<textarea name="sugotag_insert_hidden_header" id="sugotag-insert-hidden-header" class="widefat" rows="8" style="font-family:Courier New;"><?php echo $this->settings['sugotag_insert_hidden_header']; ?></textarea>	
				             		</p>
					 		    	<p>
		    	               			<label for="sugotag_insert_hidden_footer"><strong><?php _e('CUSTOM HTML Scripts in <code>&lt;body&gt;</code>', $this->plugin->name); ?></strong></label>
		        	           			<textarea name="sugotag_insert_hidden_footer" id="sugotag-insert-hidden-footer" class="widefat" rows="8" style="font-family:Courier New;"><?php echo $this->settings['sugotag_insert_hidden_footer']; ?></textarea>	
		            	   			</p>
						        </div>
						    	<?php wp_nonce_field($this->plugin->name, $this->plugin->name.'_nonce'); ?>
		                   		<p>
									<input name="submit" type="submit" name="Submit" class="button button-primary" value="<?php _e('Save Settings', $this->plugin->name); ?>" /> 
								</p>
							</div> <!-- / custom-script -->	
						</div> <!-- /postbox -->
    				</div> <!-- /normal-sortables -->
				</div> <!-- /post-body-content -->
			</div> <!-- /post-body -->
   	  </form>
	</div>  <!-- /post-stuff -->
</div>  <!-- /wrap -->