<?php /* Template Name: Terms and Conditions */ ?>

<?php get_header(); ?>
<?php if (have_posts()): while (have_posts()) : the_post(); ?>
<div class="content_wrapper">
	<div class="top_content">
		<div class="scale">
		<div class="header">
			<div class="logo_content">
				<h1><strong>drink</strong>alike</h1>			
			</div>
		</div>
			
			
		</div>
	</div>
	
	<div class="shadow">
		
	</div>
	<div class="white_content">

		
		<div class="scale">
		<div class="top_content">
			
				<div class="coming_soon">
					<p class="c_soon"><strong><?php the_title();?></strong></p>
				</div>
				
				<div class="nav-bar">
					<ul>
					
						<li><a href="<?php echo site_url(); ?>"><strong>Home</strong></a></li>
						<li><a href="<?php echo site_url('/terms-and-conditions'); ?>"><strong>Terms And Conditions</strong></a></li>
						<li><a href="<?php echo site_url('/privacy-policy'); ?>"><strong>Privacy Policy</strong></a></li>
					</ul>
				</div>
				
			

				<div class = "terms">					
					 <?php the_content()?> 
				</div>
			
		</div>
	</div>
	</div>

		
</div>


<?php endwhile ?>
<?php endif ?>

<?php get_footer(); ?>
