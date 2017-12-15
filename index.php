<?php get_header(); ?>

<?php
 $backgroundimage = get_field('background_image');
 $headerframe = get_field('header_frame', get_the_ID());
 $buttonimage = get_field('button_image');



?>



	<div class="orange_content">
	<div class="content_wrapper">
	<div class="top_content">
		<div class="header">
			<div class="iphone" style="background-image: url(<?php echo $headerframe ?>)">
				<img src="<?php the_field('header_image');?>" alt="" />
			</div>
			<div class="logo_content">
				<h1><strong>drink</strong>alike</h1>
				<h3>The <strong>EASIEST</strong> way to know, <strong>wat to drink next?</strong></h3>
				<p> <?php the_field('header_text'); ?></p>
				<a href="#" class="get_notified" style="background-image: url( <?php echo $buttonimage ?>);"><strong>Get Notified</strong> on the day of launch!</a>
			</div>
		</div>
	</div>

<div class="shadow"></div>
	<div class="white_content">
		<div class="top_content">
			<div class="header">
				<div class="coming_soon">
					<p class="c_soon">we're <br/> <strong>Coming Soon</strong> <br/> to your iPhone</p>
				</div>

				<ul class="social">
					<?php
					$socialmediaimages = get_field('social_media_images');
					if( have_rows('social_media') ):

 	// loop through the rows of data
    while ( have_rows('social_media') ) : the_row();

        // display a sub field value"
				?>
        <li><a href='<?php the_sub_field('social_page'); ?>' class="<?php the_sub_field('social_link'); ?>" style = "background-image: url( <?php echo  $socialmediaimages ?>)" > <?php the_sub_field('social_link_name') ?> </a></li>

<?php
    endwhile;

else :

    // no rows found

endif;

?>
					
				</ul>

							<!-- footer -->
			<footer class="footer" role="contentinfo">

				<!-- copyright -->
				<div class="copyright"><p>Copyright 2013. <br/> All Rights Reserved. <br/> <span><strong>drink</strong>alike</span></p></div>
				</div>
		</div>
	</div>



			</footer>
			<!-- /footer -->

		</div>


		<?php  get_footer(); ?>