<?php
if (isset($_POST['wpvisr_reset_votes']))
{
	if(current_user_can('activate_plugins'))
	{
		wpvisr_reset_votes();
	}
	
}
if (isset($_REQUEST['reset_post_id']))
{
 
	global $wpdb;
 $post_id= $_REQUEST['reset_post_id'];
 $prefix =  $wpdb->prefix;
  $tabel =  $prefix.'wpvisr_rating';
   $tabel2 =  $prefix.'wpvisr_votes';
  $wpdb->query("DELETE FROM $tabel WHERE post_id =".$_REQUEST['reset_post_id']);
 	
 $wpdb->query("DELETE FROM $tabel2 WHERE post_id =".$_REQUEST['reset_post_id']);
 
 
 ?>
<script type="text/javascript">
 
window.location = "post.php?post=<?php echo  $_REQUEST['reset_post_id'];?>&action=edit";
 
</script>
	<?php 
}

if (isset($_POST['wpvisr_feedback_form'])){
	
	
		if ( ! function_exists( 'get_plugins' ) ) 
		{
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		global $success;
		$all_plugins = get_plugins();
		foreach($all_plugins as $plugin)
		{
			$plugins_name[] = $plugin['Name'];
		}
		$plugin_name = implode(',', $plugins_name);
		$plugin_name = explode(',', $plugin_name);
		$plugin_list = '<ol>';
		foreach($plugin_name as $plugins){
		$plugin_list .= '<li>';
		$plugin_list.= $plugins;
		$plugin_list .='</li>';
		}
		$plugin_list .='</ol>';
		
		/*Get Activated Plugins List*/
		$active_plugin=get_option('active_plugins');
		$actived_plugin ='<ol>';
    	foreach($active_plugin as $key => $value)
    	{
        $string = explode('/',$value); // Folder name will be displayed
        $actived_plugin .='<li>';
        $actived_plugin .=$string[0];
        $actived_plugin .='</li>';
    	}
    	$actived_plugin .='</ol>';
		$all_themes = get_themes();
		$theme_name = implode(',', $all_themes);
		$theme_name = explode(',', $theme_name);
		foreach($all_themes as $theme)
		{
			$themes_name[] = $theme['Name'];
		}
		
		$theme_list = '<ol>';
		foreach($theme_name as $themes){
		$theme_list .= '<li>';
		$theme_list.= $themes;
		$theme_list .='</li>';
		}
		$theme_list .='</ol>';
		/*Get Active Theme*/
		$active_theme = wp_get_theme();
		$admin_email = sanitize_email($_POST['feedback_email']);
		if(isset($admin_email))
		{
				$from = $admin_email; 	
		}
		else
		{
		$from = get_option('admin_email');		
		}
		$to = 'supportntest@gmail.com';
		$header = "From: '.$from.'" . "\r\n" .
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-type: text/html\r\n";		
		$subj = sanitize_text_field($_POST['feedback_subject']);
		$sub = 'The '.$from.' has sent this message.'.'<br/>';
		$subject= sanitize_text_field($_POST['feedback_subject']);
		$bodyy = sanitize_text_field($_POST['feedback_comment']);
		$body = '<html><body><label><span style="font-weight:bold">Message: </span></label>'.$bodyy.'<br/><br/>';
		$body .='The <strong>'.$from.'</strong> has sent this message.<br/><br/>';
		$body .='<label><span style="font-weight:bold">Website Information: </span></lable>This site has all theses themes:';
		$body .= $theme_list; 
		$body .='and plugins installed:'.$plugin_list.'';
		$body .='The activated Theme: is <span style="font-weight:bold">'.$active_theme.'</span><br/><br/>';
		$body .='The activated plugins are: '.$actived_plugin.'';
		$body .= '</body></html>';
		wp_mail($to,$subject,$body,$header);
		//echo "<pre>";
		//print_r($body);
		$success="Thanks For Submitting Review. We will contact you Soon.";
}
wpvisr_save_options();
$options=wpvisr_options();

wp_enqueue_script('wpvisr_admin_back', plugins_url('/js/wpvisr_admin_back.js', __FILE__), array('jquery'), NULL);
wp_localize_script('wpvisr_admin_back', 'wpvisr_ajax_object', array('scale'=>$options['scale'], 'wpvisr_type'=>$options['color'].$options['shape']));
?>
<h1>WP Vivacity Star Rating Option</h1>
 <form name="form" method="POST" action="" style="margin-top:15px;">
<div id="tabs">
  <ul>
   <li><a href="#tabs-1"><?php _e('General Settings','wp-vivacity-star-rating');?></a></li>
	<li><a href="#tabs-2"><?php _e('Stars','wp-vivacity-star-rating');?></a></li>
	<li><a href="#tabs-3" class="button button-primary button-large"><?php _e('Save Settings','wp-vivacity-star-rating');?></a></li>
  </ul>
  <div id="tabs-1">
	<div class="tab_box">
		<div class="info">
				<span class="wpvisr_adm_label"><label><h3><?php _e('Enable/Disable','wp-vivacity-star-rating');?></h3></label></span>
		   	<span><input type="checkbox" class="chkbo _on" name="wpvisr_activated" id="wpvisr_activated" value="<?php echo $options['activated']; ?>" <?php checked($options['activated'], 1, true); ?>></span>
		</div>
      <div class="wpvisr_hint tooltip-right" data-tooltip="Choose whether you want to enable or disable the plugin"></div>
  </div>
  	
  	<div class="tab_box">	
  		<div class="info">
	  		<span class="wpvisr_adm_label"><label><h3><?php _e('Allow guests to vote','wp-vivacity-star-rating');?></h3></label></span>
	   	<span><input type="checkbox" class="chkbo _on" name="wpvisr_allow_guest_vote" id="wpvisr_allow_guest_vote" value="<?php echo $options['allow_guest_vote']; ?>" <?php checked($options['allow_guest_vote'], 1, true); ?>></span>
	   </div>
      <div class="wpvisr_hint tooltip-right" data-tooltip="If this check box is checked then only user will be able to Vote. Guests vote will be tracked by IP instead of UserId."></div>
   </div>  
     	<div class="tab_box">	
  		<div class="info">
	  		<span class="wpvisr_adm_label"><label><h3><?php _e('Show on Woocommerce shop page','wp-vivacity-star-rating');?></h3></label></span>
	   	<span><input type="checkbox" class="chkbo _on" name="wpvisr_allow_woo_shop" id="wpvisr_allow_woo_shop" value="<?php echo $options['allow_woo_shop']; ?>" <?php checked($options['allow_woo_shop'], 1, true); ?>></span>
	   </div>
      <div class="wpvisr_hint tooltip-right" data-tooltip="SHow rating on Woocommerce shop page"></div>
   </div>  
    <div class="tab_box"> 
      <div class="info">
      	<span  class="wpvisr_adm_label"><label><h3><?php _e('Show vote count','wp-vivacity-star-rating');?></h3></label></span>
     		<span><input type="checkbox" class="chkbo _on" name="wpvisr_show_vote_count" id="wpvisr_show_vote_count" value="<?php echo $options['show_vote_count']; ?>" <?php checked($options['show_vote_count'], 1, true); ?>></span>
		</div>
		<div class="wpvisr_hint tooltip-right" data-tooltip="Check this to show the count of Stars."></div>	
	</div>	
	
		<div class="tab_box">
		<div class="info">
		<span class="wpvisr_adm_label"><label><h3><?php _e('Where to add rating','wp-vivacity-star-rating');?></h3></label></span>
      <?php echo wpvisr_get_post_types_for();  ?>
      </div>
      <div class="wpvisr_hint tooltip-right" data-tooltip="Where do you want to show your rating:- Page, Post and Custom Post."></div>
      </div>
      
      <div class="tab_box">
      <span class="wpvisr_adm_label"><label><h3><?php _e('Position of the Stars','wp-vivacity-star-rating');?></h3></label></span>
      <p>
      	 <select name="wpvisr_position" id="wpvisr_position" class="wpvisr_admin_input">
                 <option value="before" <?php selected($options['position'], 'before', true); ?>>Before Content</option>
                 <option value="after" <?php selected($options['position'], 'after', true); ?>>After Content</option>
           </select>
      </p>		
		</div>
  </div>
  <div id="tabs-2">
	<div class="tab_box"> 
	 <span  class="wpvisr_adm_label"><label><h3><?php _e('Shape of the Stars','wp-vivacity-star-rating');?></h3></label></span>
                <p>
                    <select name="wpvisr_shape" id="wpvisr_shape" class="wpvisr_admin_input">
                        <option value="s" <?php selected($options['shape'], 's', true); ?>>Stars</option>
                        <option value="c" <?php selected($options['shape'], 'c', true); ?>>Circles</option>
                        <option value="h" <?php selected($options['shape'], 'h', true); ?>>Hearts</option>
                    </select>
                </p>
    </div>            
	<div class="tab_box">                
                <span  class="wpvisr_adm_label"><label><h3><?php _e('Color of the Stars','wp-vivacity-star-rating');?></h3></label></span>
              <p>
                    <select name="wpvisr_color" id="wpvisr_color" class="wpvisr_admin_input">
                        <option value="y" <?php selected($options['color'], 'y', true); ?>>Yellow</option>
                        <option value="r" <?php selected($options['color'], 'r', true); ?>>Red</option>
                        <option value="p" <?php selected($options['color'], 'p', true); ?>>Purple</option>                        
                        <option value="b" <?php selected($options['color'], 'b', true); ?>>Blue</option>
                        <option value="g" <?php selected($options['color'], 'g', true); ?>>Green</option>
                    </select>
                </p>
    </div>      
       <div class="tab_box">         
                <span  class="wpvisr_adm_label"><label><h3><?php _e('Alignment in Respect To Posts','wp-vivacity-star-rating');?></h3></label></span>
                <p>
                    <select name="wpvisr_alignment" id="wpvisr_alignment" class="wpvisr_admin_input">
                        <option value="center" <?php selected($options['alignment'], 'center', true); ?>>Center</option>
                        <option value="right" <?php selected($options['alignment'], 'right', true); ?>>Right</option>
                        <option value="left" <?php selected($options['alignment'], 'left', true); ?>>Left</option>
                    </select>
                </p>
			</div>
			<div class="tab_box">
                <div class="info">
                <span  class="wpvisr_adm_label"><label><h3><?php _e('Amount of Stars','wp-vivacity-star-rating');?></h3></label></span>
                <span><input type="text" size="10" maxlength="200" name="wpvisr_scale" id="wpvisr_scale" value="<?php echo $options['scale']; ?>" class="wpvisr_admin_input"></span>
                </div>
                
            	<div class="wpvisr_hint tooltip-right" data-tooltip="Allowed Values are 3-10"></div>
            </div>
  </div>
  <div id="tabs-3">
	<p><input type="submit" style="margin-top:10px;" class='button button-primary button-large' value="<?php _e('Save settings','wp-vivacity-star-rating');?>"></p>
  </div>
</div>
</form> 
<div id="postbox-container-1" class="postbox-container" style="float: right;display:inline-block;width: 280px;margin-right:20px;">
    <div class="postbox ">
        <h3 class="wpvisr_widget_title">
            <span><?php _e('Live Preview','wp-vivacity-star-rating');?></span>
        </h3>
        <div class="inside">         
            <div id="wpvisr_container"><div class="wpvisr_visual_container"><?php echo wpvisr_show_voting(5, 25, $options['show_vote_count']); ?></div></div>
        </div>
    </div>

	<div class="postbox ">
        <h3 class="wpvisr_widget_title">
            <span><?php _e('Reset Votes','wp-vivacity-star-rating');?></span>
        </h3>
        <div class="inside">         
            <form method="post" onsubmit="return confirm('Do you really want to reset votes?')">
                <?php _e('You can reset votes by pressing button below.','wp-vivacity-star-rating');?><br/>
                <input type="hidden" name="wpvisr_reset_votes" value="1">
                <input class="wpvisr_button button button-primary button-small" type="submit" value="<?php _e('Reset votes','wp-vivacity-star-rating');?>">
           </form>
        </div>
    </div>
    
    <div class="postbox ">
        <h3 class="wpvisr_widget_title">
            <span><?php _e('Feedback Form','wp-vivacity-star-rating');?></span>
        </h3>
        <div class="inside">         
            <form method="post" name="feedback_form" id="feedback_form" >
                <div class="success"><h3><?php _e($success,'wp-vivacity-star-rating');?></h3></div>
                <?php if($success == ''){?>
                Do you Found a bug? Or you maybe have a new feature request? Please fill this form and let me know!.<br/>
                <input type="hidden" name="wpvisr_feedback_form" value="1">
                <?php 
                $from = get_option('admin_email');
                ?>
                <label><?php _e('Ener Your Email ID','wp-vivacity-star-rating');?></label><br/>
                <input type="text" name="feedback_email" id="feedback_email" size="25" value="<?php echo $from;?>">
                <label><?php _e('Ener Your Subject','wp-vivacity-star-rating');?></label><br/>
                <input type="text" name="feedback_subject" id="feedback_subject" size="25">
                <label><?php _e('Ener Your Comments','wp-vivacity-star-rating');?></label><br/>
                <textarea name="feedback_comment" id ="feedback_comment" rows="4" cols="25"></textarea>
                <input class="wpvisr_button button button-primary button-small feedback" type="submit" value="Submit">
           		 <?php }?>
           </form>
           
        </div>
    </div>
</div>      
    
 
