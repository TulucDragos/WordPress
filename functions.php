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
    
    if(is_page('Log In'))
    {
    	wp_register_style('onpiste_login_style', get_template_directory_uri() . '/css/login.css', array(), '1.0', 'all');
    	wp_enqueue_style('onpiste_login_style'); // Enqueue it!
    }

     
}

function onpiste_partner_only()
{
	if(is_page('Partner')) // insert in this if all other pages that should only be accessible to partners and administrators
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


add_action('save_post', 'campaign_check');
add_action('wp', 'onpiste_partner_only');
add_action('wp_enqueue_scripts', 'onpiste_styles');

?>