<?php /* Template Name: Terms and Conditions */ ?>

<?php get_header(); ?>
<?php if (have_posts()): while (have_posts()) : the_post(); ?>
<div class="content_wrapper">
	<div class="top_content">
		<div class="header">
			<div class="logo_content">
				<h1><strong>drink</strong>alike</h1>
				
				
			</div>
			
			
		</div>
	</div>
	
	<div class="shadow">
		
	</div>
	<div class="white_content">
		<div class="top_content">
			<div class="header">
				<div class="coming_soon">
					<p class="c_soon"><strong><?php the_title();?></strong></p>
				</div>
				
				<div class="nav-bar">
					<ul>
					<?php 
						if(have_rows('navigation')):

						 while ( have_rows('navigation') ) : the_row();
					?>
						<li><a href="<?php the_sub_field('page_links'); ?>"><strong><?php the_sub_field('name') ?></strong></a></li>

						<?php
							endwhile;
						endif;
						?>
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
