<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package GreenPressWP
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="gpwp-post-article">
		<?php if ( ! is_front_page() ) : ?>
			<header class="entry-header">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</header><!-- .entry-header -->
		<?php endif; ?>

		<?php \GreenPressWP\Includes\Template_Tags::get_instance()->post_thumbnail(); ?>

		<div class="entry-content">
			<?php
			the_content();
			?>
		</div><!-- .entry-content -->

	</div>	
</article><!-- #post-<?php the_ID(); ?> -->
