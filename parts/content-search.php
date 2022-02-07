<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package bellaworks
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php  
	$blank_image = THEMEURI . "images/square.png";
	$thumbnail_image = get_field("thumbnail_image");
	$thumbId = get_post_thumbnail_id();
	$default_image = wp_get_attachment_image_src($thumbId,'large');
	$image_src = '';
	if($thumbnail_image) {
		$image_src = $thumbnail_image['url'];
	} elseif($default_image) {
		$image_src = $default_image[0];
	}
	?>
	<div class="text-wrapper <?php echo ($image_src) ? 'has-image':'no-image'; ?>">
		<div class="flexwrap">
			<?php if ($image_src) { ?>
			<figure class="image-col">
				<div class="imagediv" style="background-image:url('<?php echo $image_src ?>')"></div>
				<img src="<?php echo $blank_image ?>" alt="" aria-hidden="true">
			</figure>
			<?php } ?>

			<div class="text-col">
				<div class="wrap">
					<header class="entry-header">
						<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

						<?php if ( 'post' === get_post_type() ) : ?>
						<div class="entry-meta">
							<?php bellaworks_posted_on(); ?>
						</div><!-- .entry-meta -->
						<?php endif; ?>
					</header><!-- .entry-header -->

					<div class="entry-summary">
						<?php the_excerpt(); ?>
						<div class="button-wrap"><a href="<?php echo get_permalink(); ?>" class="more btn-sm"><span>Continue Reading &rarr;</span></a></div>
					</div><!-- .entry-summary -->

					<!-- <footer class="entry-footer">
						<?php //bellaworks_entry_footer(); ?>
					</footer> -->
					<!-- .entry-footer -->
				</div>
			</div>
		</div>
	</div>
</article><!-- #post-## -->
