<?php
function onpiste_styles()
{
	if(is_page('On Piste Landing'))
	{
		wp_register_style('onpiste_style', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
    	wp_enqueue_style('onpiste_style'); // Enqueue it!
	}

	if(is_page('Terms and Coditions'))
	{
		wp_register_style('onpiste_terms_style', get_template_directory_uri() . '/css/termsandcond.css', array(), '1.0', 'all');
    	wp_enqueue_style('onpiste_terms_style'); // Enqueue it!
	}
    
     
}

add_action('wp_enqueue_scripts', 'onpiste_styles');

?>