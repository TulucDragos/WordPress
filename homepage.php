<?php /* Template Name: Home Page */ ?>

<?php get_header(); ?>

<?php
 $headerframe = get_field('header_frame');
 $buttonimage = get_field('button_image');

?>

<?php if (have_posts()): while (have_posts()) : the_post(); ?>
	
	<div class="top_content">
			<div class="wrapper">

			<div class="row" id="orange_content">

				<div class="col col-lg-5" id="right_content">
					<h1>This is the Title</h1>
					<h3>This is the subtitle</h3>

					<p> Duis est orci, accumsan ut hendrerit sed, semper eget nulla. Cras ullamcorper sapien ut dui faucibus vulputate. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>

					<a href="#" class="get_notified" style="background-image: url( <?php echo $buttonimage ?>);"><strong>Get Notified</strong> on the day of launch!</a>
				</div>


				<div class="col col-lg-5" id="photo">
					
					<div class="iphone" style="background-image: url(<?php echo $headerframe ?>)">
						<img src="<?php the_field('header_image');?>" alt="" />
					</div>
				</div>

				
			</div>
		</div>

		</div>

		<div class="white_content">
			<div class="wrapper">
			<div class="row">

				<div class="col col-lg-4">
					<div class="nav-bar">
						<ul>
					
							<li><a href="<?php echo site_url(); ?>"><strong>Home</strong></a></li>
							<li><a href="<?php echo site_url('/terms-and-conditions'); ?>"><strong>Terms And Conditions</strong></a></li>
							<li><a href="<?php echo site_url('/privacy-policy'); ?>"><strong>Privacy Policy</strong></a></li>

						
						</ul>
					</div>
				</div>
				
				

				<div class="col col-lg-4" id="social_links">
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
				</div>

				<div class="col col-lg-3" id="coming_soon">
					<p class="c_soon">we're  <strong>Coming Soon</strong>  to your iPhone</p>
				</div>

			</div>
		</div>

		</div>

		<!-- /wrapper -->
	<?php 
	endwhile;
	endif;
?>
	

		<?php get_footer(); ?>
