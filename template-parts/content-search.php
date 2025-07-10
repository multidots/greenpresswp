<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package GreenPressWP
 */

$template_tags_class = \GreenPressWP\Includes\Template_Tags::get_instance();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="gpwp-post-article">
		<header class="entry-header">
			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

			<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php
				$template_tags_class->posted_on();
				$template_tags_class->posted_by();
				?>
			</div><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->

	</div>
</article><!-- #post-<?php the_ID(); ?> -->
