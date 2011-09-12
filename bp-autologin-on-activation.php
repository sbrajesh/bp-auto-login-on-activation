<?php

/*
 * Plugin Name: BP Auto Login on Activation
 * Plugin URI: http://buddydev.com/plugins/bp-autologin-on-activation/
 * Author: Brajesh Singh
 * Author URI: http://buddydev.com/members/sbrajesh
 * Version: 1.0.1
 * Network: true
 * Description: This plugin automatically logs in the user and redirects them to their profile when they activate their account
 * License: GPL
 * Last Modified: September 11, 2011
 */
add_action("bp_core_activated_user","bp_autologin_on_activation",40,3);
function bp_autologin_on_activation($user_id,$key,$user) {
	global $bp, $wpdb;
		

                //simulate Bp activation
		/* Check for an uploaded avatar and move that to the correct user folder, just do what bp does */
		if ( is_multisite() )
			$hashed_key = wp_hash( $key );
		else
			$hashed_key = wp_hash( $user_id );

		/* Check if the avatar folder exists. If it does, move rename it, move it and delete the signup avatar dir */
		if ( file_exists( BP_AVATAR_UPLOAD_PATH . '/avatars/signups/' . $hashed_key ) )
			@rename( BP_AVATAR_UPLOAD_PATH . '/avatars/signups/' . $hashed_key, BP_AVATAR_UPLOAD_PATH . '/avatars/' . $user_id );

		bp_core_add_message( __( 'Your account is now active!', 'buddypress' ) );

		$bp->activation_complete = true;
	//now login and redirect
              wp_set_auth_cookie($user_id,true,false);
             bp_core_redirect(apply_filters ("bpdev_autoactivate_redirect_url",bp_core_get_user_domain($user_id ),$user_id));      
                
	
}
?>