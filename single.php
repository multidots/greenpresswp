<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package GreenPressWP
 */

get_header();
?>

	<main id="primary" class="site-main green-press-wp u-padding-t20 u-padding-b20 u-padding-t20@max-767 u-padding-b20@max-767">
		<div class="container">
			<div class="single-post-section">
				<?php
				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/content', 'single' );

					endwhile; // End of the loop.
				?>
			</div>
		</div>
	</main><!-- #main -->

<?php
get_footer();
