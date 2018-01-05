<?php /* Template Name: Validate */ ?>
<?php get_header(); ?>

<?php if (have_posts()): while (have_posts()) : the_post(); ?>
<div class="content_wrapper">
	<div class="top_content">
		<div class="header">
			<div class="logo_content">

			</div>
<?php 
$my_c = get_query_var( 'c' );
?>

		</div>
	</div>

	<div class="shadow">

	</div>
	<div class="white_content">
		<div class="top_content">
			<div class="header">
				<div class="coming_soon">

				</div>


				<h3>Active Campaign:

				<?php

				$the_query = new WP_Query(array(
        				'post_type' => 'campaign'

    					) );

				 if ( $the_query->have_posts() ) : ?>
					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

					 <?php the_title(); ?> </h3>
					 <h3> Number of validations: <?php the_field('redeems'); ?> </h3>

					<?php endwhile;
					wp_reset_postdata();
					?>
				<?php else : ?>
					<p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
				<?php endif; ?>

				<div class = "terms">


					<?php the_content(); ?>

					<div class="val">
						<button id= "valideaza"><a href="<?php echo esc_url( add_query_arg( 'c', $my_c, site_url( '/thank-you/' ) ) )?>"/>Valideaza</button>
					</div>
					<div class="not-val">
						<button id= "nu-valideaza"><a href="<?php echo site_url('/not-validated/') ?>"/>Nu acum</button>
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
