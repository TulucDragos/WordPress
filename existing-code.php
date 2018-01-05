<?php /* Template Name: Existing Code */ ?>
<?php get_header(); ?>

<?php if (have_posts()): while (have_posts()) : the_post(); ?>

<?php 
$my_t = get_query_var( 't' );
?>
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
					 <?php the_content(); ?> <?php echo $my_t; ?> 
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