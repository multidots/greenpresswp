<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package GreenPressWP
 */

get_header();
?>

<main id="primary" class="green-press-wp site-main">
	<div class="container">
		<div class="post-section">
			<?php
			if ( have_posts() ) :

				if ( is_home() && ! is_front_page() ) :
					?>
					<header>
						<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
					</header>
					<?php
				endif;
				?>
					<?php
					$posts_page_id = get_option( 'page_for_posts' );

					if ( $posts_page_id ) {
						$posts_page = get_post( $posts_page_id );
						$content    = apply_filters( 'the_content', $posts_page->post_content );
						if ( ! empty( $content ) ) {
							echo wp_kses_post( $content );
						}
					}

					?>
				<div class="gpwp-post-wrapper">
					<?php
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						/*
						* Include the Post-Type-specific template for the content.
						* If you want to override this in a child theme, then include a file
						* called content-___.php (where ___ is the Post Type name) and that will be used instead.
						*/
						get_template_part( 'template-parts/content', get_post_type() );

					endwhile;

					the_posts_navigation();

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>
				</div> <!-- .gpwp-post-wrapper -->
		</div> <!-- .post-section -->
	</div> <!-- .container -->
</main><!-- #main -->

<?php
get_footer();
