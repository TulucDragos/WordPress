<?php /* Template Name: Validate */ ?>
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
					
				</div>
				
				
			

				<div class = "terms">

					<?php the_content(); ?>

					<div class="val">
						<button id= "valideaza">Valideaza</button>
					</div>
					<div class="not-val">
						<button id= "nu-valideaza">Nu acum</button>
					</div>
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