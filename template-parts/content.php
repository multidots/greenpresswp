<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package GreenPressWP
 */

$template_tags_class = \GreenPressWP\Includes\Template_Tags::get_instance();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="gpwp-post-article">
		<?php $template_tags_class->post_thumbnail(); ?>
		<div class="gpwp-post-content">
			<header class="entry-header">
				<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

				<span class="date"><?php echo get_the_date( 'F j, Y' ); ?></span>

			</header><!-- .entry-header -->

				<?php
				$excerpt         = get_the_excerpt( $post );
				$trimmed_excerpt = wp_trim_words( $excerpt, 20, '...' );

				// Check if the excerpt is longer than the limit (20 words).
				$show_read_more = ( str_word_count( $excerpt ) > 20 );

				// Display the excerpt.
				echo '<div class="wp-block-latest-posts__post-excerpt">' . esc_html( $trimmed_excerpt );

				// Conditionally add the "Read More" link if the excerpt was trimmed.
				if ( $show_read_more ) {
					echo '<a class="wp-block-latest-posts__read-more" href="' . esc_url( get_permalink() ) . '">Read More</a>';
				}

				echo '</div>';
				?>
		</div>
	</div>	
</article><!-- #post-<?php the_ID(); ?> -->
