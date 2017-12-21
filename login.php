<?php /* Template Name: Login */ ?>
<?php get_header(); ?>

<?php if (have_posts()): while (have_posts()) : the_post(); ?>
<div class="content_wrapper">
	<div class="top_content">
		<div class="header">
			<div class="logo_content">
	
			</div>
			
			
		</div>
	</div>

	<div class="shadow">
		
	</div>
	<div class="white_content">
		<div class="top_content">
			<div class="header">
				<div class="coming_soon">
					<p class="c_soon"><strong><?php the_title(); ?></strong></p>
				</div>
				
				
			

				<div class = "terms">
					<p style="color:black"> <?php the_content(); ?>  </p>
				</div>
			</div>
		</div>
	</div>
	
</div>

<?php 
	endwhile;
	endif;
?>

<?php get_footer(); ?>