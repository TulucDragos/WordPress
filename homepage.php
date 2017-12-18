<?php /* Template Name: Home Page */ ?>

<?php get_header(); ?>


<?php
 $backgroundimage = get_field('background_image');
 $headerframe = get_field('header_frame');
 $buttonimage = get_field('button_image');



?>




	
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

						<div class="nav-bar">
					<ul>
					<?php 
						if(have_rows('navigation')):

						 while ( have_rows('navigation') ) : the_row();
					?>
						<li><a href="<?php the_sub_field('page_link'); ?>"><strong><?php the_sub_field('name') ?></strong></a></li>

						<?php
							endwhile;
						endif;
						?>
					</ul>
				</div>
		</div>
	</div>



			</div>
			<!-- /footer -->

		</div>


		<!-- /wrapper -->
		

		<?php get_footer(); ?>
