<?php
function onpiste_styles()
{
	if(is_page('On Piste Landing'))
	{
		
   		wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '1.0', 'all');
   		wp_enqueue_style('bootstrap');
   		wp_register_style('onpiste_style', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
   		wp_enqueue_style('onpiste_style'); // Enqueue it!
	}

	if(is_page('Terms and Conditions') || is_page('Privacy Policy') )
	{
		wp_register_style('onpiste_terms_style', get_template_directory_uri() . '/css/termsandcond.css', array(), '1.0', 'all');
    wp_enqueue_style('onpiste_terms_style'); // Enqueue it!
	}

  if(is_page('Log In') || is_page('Non-Partner') || is_page('Validate') || is_page('Thank You') || is_page('Not Validated') || is_page('Existing Code') || is_page('Partner') || is_page('Not A Valid Code')) 
  {
    	wp_register_style('onpiste_login_style', get_template_directory_uri() . '/css/login.css', array(), '1.0', 'all');
    	wp_enqueue_style('onpiste_login_style'); // Enqueue it!
  }


}

function onpiste_partner_only()
{
	if(is_page('Partner') || is_page('Validate') || is_page('Thank You') || is_page('Not Validated') || is_page('Existing Code') || is_page('Not A Valid Code')) // insert in this if all other pages that should only be accessible to partners and administrators
	{
		//check if the user is logged in
		if(is_user_logged_in())
		{
			global $current_user;

	   		$user_roles = $current_user->roles;

	   		$user_role = array_shift($user_roles);


	    	$url = esc_url(site_url( '/non-partner/' ));

			if( $user_role != 'partner' && $user_role != 'administrator')// check if the user role is not partner
				{
					wp_redirect( $url ); // redirect to the home page
					exit;
				}

		}
		else
		{
			$login = esc_url(site_url( '/login/' ));
			wp_redirect($login); // if the user is not logged in than it redirects the user to the login page
			exit;
		}

	}
}

function campaign_check ( $post_id)
{
	static $is_active = 0;

	if('campaign' == get_post_type()) // do this only if the post type is campaign.
	{
		if($_POST['action'] == 'editpost')
			{

					$args = array (
						'numberposts' => 50,
						'post_type' => "campaign"
					);

					$all_posts = get_posts($args); // get all the campaign posts

					if(!empty($all_posts))
					{
							foreach($all_posts as $c_post)
						{

								if( get_post_status($c_post) == 'publish' && $_POST != $c_post) // count how many posts are active
									{
										$is_active++;
									}
						}

					}

					if($is_active > 1 ) // check if there is anyother active
					{
						 $_POST['post_status'] = 'Draft'; // set the post as draft and display a message
						 echo $_POST['post_status'];
						 remove_action('save_post', 'campaign_check'); // un-hook the action because it is called when updating a post
						 wp_update_post($_POST); // update the post
						 add_action('save_post', 'campaign_check'); // re-hook the action
						  
						 //diplay the message for the user 
		       		   	 ?>

						 <div class="notice notice-error is-dismissible">
		       				 <p><?php _e( 'There is already an active campaign', 'my_plugin_textdomain' ); ?></p>
		    			 </div>

		   				 <?php

					}

					else

					{
						//diplay the message for the user 
						?>
						<div class="notice notice-update is-dismissible">
		       				 <p><?php _e( 'The campaign has been activated', 'my_plugin_textdomain' ); ?></p>
		    			</div>

		   				<?php

					}

			}

	}

}

function campaign_message($post_id)
{
	if('campaign' == get_post_type()) // do this only if the post type is campaign.
	{
		if($_POST['action'] == 'editpost')
		{
			if($_POST['post_status'] == 'Draft')
			{
				?>

					 <div class="notice notice-error is-dismissible">
		     			 <p><?php _e( 'There is already an active campaign', 'sample-text-domain' ); ?></p>
		    		 </div>

				 <?php
			}
			else
			{
				?>
					<div class="notice notice-update is-dismissible">
		       			 <p><?php _e( 'The campaign has been activated', 'sample-text-domain' ); ?></p>
		    		</div>

		   		<?php
			}
		}
		
		
	}
}

function add_custom_query_var( $vars ){
  $vars[] = "c";
  return $vars;
}

function add_custom_query_var_time( $vars ){
  $vars[] = "t";
  return $vars;
}

function code_already_used()
{
	if(is_page('Validate'))
	{
		global $wpdb;
		$my_c = get_query_var( 'c' );

		if($my_c != "")
		{
			static $active_campaign_id;

			$my_post = new WP_Query(array(
        				'post_type' => 'campaign',
        				'post_status' =>'publish'
    					) );


		//get the id and the number of redemptions of the active campaign 
			if ( $my_post->have_posts() )
			{
				while ( $my_post->have_posts() )
				{
					$my_post->the_post(); 
					$active_campaign_id = get_the_ID();			
				} 
			}

			wp_reset_postdata();

			static $table_name = "wp_ucode";

			$sql = "
			select *
			from $table_name;
			";

			
			$codes = $wpdb->get_results($sql, OBJECT);


			if ($codes)
			{				
				foreach($codes as $code)
				{
					if($code->user_code == $my_c)
						{	
							
							$my_t = $code->validation_time;
							if($code->campaign_id == $active_campaign_id)
							{
								$existing_code_url = esc_url( add_query_arg( 't', $my_t, site_url( '/existing-code/' ) ) );
								wp_redirect($existing_code_url); // redirect the user to a page with the message "this code has already been validated during this campaign"
								exit;
							}
						}
				}
			}

		}
		/*else
		{
			$not_a_valid_code_url = esc_url(site_url('/not-a-valid-code'));
			wp_redirect($not_a_valid_code_url);
			exit;
		}
		*/

	}
}



function user_code_validation()
{
	if(is_page('Thank You'))
	{
		global $wpdb;
		global $current_user;
		static $active_campaign_id;
		static $active_campaign_redeems;

		$my_c = get_query_var( 'c' );		

		//get the current active campaign
		$my_post = new WP_Query(array(
        				'post_type' => 'campaign',
        				'post_status' =>'publish'
    					) );


		//get the id and the number of redemptions of the active campaign 
		if ( $my_post->have_posts() )
		{
			while ( $my_post->have_posts() )
			{
				$my_post->the_post(); 
				$active_campaign_id = get_the_ID();
				$active_campaign_redeems = get_field('redeems');
			} 
		}

		wp_reset_postdata();

		static $table_name = "wp_ucode";
		
		if(is_page('Thank You') && $my_c != "")
		{
			
			// select all the ucodes
			$sql = "
			select *
			from $table_name;
			";

			
			$codes = $wpdb->get_results($sql, OBJECT);

			if ($codes)
			{
				static $found = 0;
				foreach($codes as $code)
				{
					if($code->user_code == $my_c)
						{	
							$found = 1;
							$my_t = $code->validation_time;
							if($code->campaign_id == $active_campaign_id)
							{
								$existing_code_url = esc_url( add_query_arg( 't', $my_t, site_url( '/existing-code/' ) ) );
								wp_redirect($existing_code_url); // redirect the user to a page with the message "this code has already been validated during this campaign"
								exit;
							}
							else
							{
								//update the partner id, the campaign id and the validation time
								$wpdb -> update (
									$table_name,
									array (
										'campaign_id' => $active_campaign_id,
										'partner_id' => get_current_user_id(),
										'validation_time' => current_time('mysql')
									),
									array( 'user_code' => $my_c)
								);
									
								//increment the number of validations for the current campaign						
								update_post_meta($active_campaign_id,
								 'redeems',
								 $active_campaign_redeems+1,
								  $active_campaign_redeems );
			
							}
						}
				}
		}

		if($found == 0) // this will run only if this a brand new code
		{
			$wpdb->insert(
				$table_name,
				array (
					'user_code' => $my_c,
					'campaign_id' => $active_campaign_id,
					'partner_id' => get_current_user_id(),
					'validation_time' => current_time('mysql'),
				)
			);
			//increment the number of validations for the current campaign
			update_post_meta($active_campaign_id,
								 'redeems',
								 $active_campaign_redeems+1,
								  $active_campaign_redeems );
			
		}
							
			}
			//if the sent code is not a valid one, or the QR didn't work
			else
			{	$not_a_valid_code_url = esc_url(site_url('/not-a-valid-code/'));
				wp_redirect($not_a_valid_code_url);
				exit;
				
			}
	}	
	
}

add_filter('query_vars', 'add_custom_query_var');
add_filter('query_vars', 'add_custom_query_var_time');
add_action('save_post', 'campaign_check');
add_action('wp', 'code_already_used');
add_action('wp', 'onpiste_partner_only');
add_action('wp', 'user_code_validation');
add_action('wp_enqueue_scripts', 'onpiste_styles');
add_action('admin_notices', 'campaign_message');

?>
