<?php
function onpiste_styles()
{
	if(is_page('On Piste Landing'))
	{
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

	    $url = 'http://localhost/wordpress/non-partner/';

			if( $user_role != 'partner' && $user_role != 'administrator')// check if the user role is not partner
				{
					wp_redirect( $url ); // redirect to the home page
					exit;
				}

		}
		else
		{
			wp_redirect('http://localhost/wordpress/login'); // if the user is not logged in than it redirects the user to the login page
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
						 remove_action('save_post', 'campaign_check'); // un-hook the function because it is called when updating a post
						 wp_update_post($_POST); // update the post
						 add_action('save_post', 'campaign_check'); // re-hook the function

						 ?>
		   				 <div class="error notice">
		       				 <p><?php _e( 'There is already a campaign in progress', 'my_plugin_textdomain' ); ?></p>
		    			 </div>
		   				<?php
		   				print_r($_POST);
					}

					else

					{
						?>
						<div class="notice">
		       				 <p><?php _e( 'The campaign has been activated', 'my_plugin_textdomain' ); ?></p>
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


function user_code_validation()
{
	if(is_page('Thank You'))
	{
		global $wpdb;
		global $current_user;
		static $active_campaign_id;
		static $active_campaign_redemptions;

		$my_c = get_query_var( 'c' );		

		$my_post = new WP_Query(array(
        				'post_type' => 'campaign',
        				'post_status' =>'publish'
    					) );

		if ( $my_post->have_posts() )
		{
			while ( $my_post->have_posts() )
			{
				$my_post->the_post(); 
				$active_campaign_id = get_the_ID();
				$active_campaign_redemptions = get_field('redemptions');
			} 
		}

		wp_reset_postdata();

		static $table_name = "wp_ucode";
		

		if(is_page('Thank You') && $my_c != "")
		{
			print_r("variable was found <br />");

			$sql = "
			select *
			from $table_name;
			";

			print_r($active_campaign_id);
			print_r("<br />");
			print_r($active_campaign_redemptions);
			$codes = $wpdb->get_results($sql, OBJECT);

			if ($codes)
			{
				static $found = 0;
				foreach($codes as $code)
				{
					if($code->user_code == $my_c)
						{	
							$found = 1;
							if($code->campaign_id == $active_campaign_id)
							{
								wp_redirect("http://localhost/wordpress/existing-code/"); // redirect the user to a page with the message "this code has already been validated during this campaign"
								exit;
							}
							else
							{
								$wpdb -> update (
									$table_name,
									array (
										'campaign_id' => $active_campaign_id,
										'partner_id' => get_current_user_id(),
										'validation_time' => current_time('mysql')
									),
									array( 'user_code' => $my_c)
								);
														
								$active_campaign_redemptions++;
								wp_update_post($my_post);
								//increment the number of validations for the current campaign
							}
						}
				}
		}

		if($found == 0) // this will run only if this a brand new user code
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
			$active_campaign_redemptions++;
			wp_update_post($my_post);
			//increment the number of validations for the current campaign

		}
				

				//query the db and check if the code is already there

				//if it's not there add the code to the DB and set the campaign ID, partner ID who validated it, the exact time that it was validated and increment the number of validations for the active campaign

				//if the code is in the db, check if it was valided during this campaign

				// if it was validated during this campaign redirect the user to a page with the message "this code was already validated during this campaign"

				// if it was not validated during this campaign set the campaign ID, the partner that validated the code, the exact time and increment the number of validations for the active campaign

			}
			else
			{
				wp_redirect("http://localhost/wordpress/not-a-valid-code/");
				exit;
				
			}
	}
	
	
}

add_filter('query_vars', 'add_custom_query_var' );
add_action('save_post', 'campaign_check');
add_action('wp', 'onpiste_partner_only');
add_action('wp', 'user_code_validation');
add_action('wp_enqueue_scripts', 'onpiste_styles');

?>
