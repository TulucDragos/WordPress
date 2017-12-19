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
    
     
}

function onpiste_partner_only()
{
	if(is_user_logged_in())
	{
		global $current_user;

    $user_roles = $current_user->roles;
    $user_role = array_shift($user_roles);
    $url = 'http://localhost/wordpress/';

	if(is_page('Partner') && $user_role != 'partner')
	{
		wp_redirect( $url );
		exit;
	}
	}
	else
	{
		wp_redirect($url);
	}
	
}


function onpiste_campaign($new_status, $old_status, $post)
{
	if('campaign' == get_post_type()) // this is to print the message only if the post type is campaign. 
	{
		if ( $new_status == 'publish' && $old_status != 'publish' ) 
		{

			$all_posts = get_post('campaign');

			$is_active = 0; 

			if($all_posts != null)
			{
					foreach($all_posts as $c_post)
				{
					if( get_post_status($c_post) == 'publish')
					{
						$is_active++;
					}
				}
			}
			

			if($is_active > 0 )
			{
				 $post['post_status'] = 'draft';
				 ?>
   				 <div class="error notice">
       				 <p><?php _e( 'There is already a campaign in progress', 'my_plugin_textdomain' ); ?></p>
    			</div>
   				<?php
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

add_action('init', 'onpiste_partner_only');
add_action('transition_post_status', 'onpiste_campaign', 10, 3 );
add_action('wp_enqueue_scripts', 'onpiste_styles');

?>