<?php
/**
 * Template part for displaying single post in single.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package GreenPressWP
 */

?>

<div class="gpwp-post-article">
	<span class="date"><?php echo get_the_date( 'F j, Y' ); ?></span>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->
	<figure class="wp-block-image">
		<?php
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'large' );
		}
		?>
	</figure>  
	<div class="entry-content">
		<?php
		the_content();
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'green-press-wp' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->
</div>	
