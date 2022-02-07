<?php
/**
 * Template Name: Plan Your Visit
 */

get_header(); 
$placeholder = THEMEURI . 'images/rectangle.png';
?>

<div id="primary" data-post="<?php echo get_the_ID()?>" class="content-area-full activities-parent">
		<?php while ( have_posts() ) : the_post(); ?>
				<div class="intro-text-wrap">
					<div class="wrapper">
						<h1 class="page-title"><span><?php the_title(); ?></span></h1>
						<div class="intro-text"><?php the_content(); ?></div>
					</div>
				</div>
		<?php endwhile;  ?>

		<?php
		$postype = 'page';
		$perpage = -1;
		$args = array(
			'posts_per_page'	=> -1,
			'post_type'				=> $postype,
			'post_status'			=> 'publish',
			'post_parent' => 15
			// 'meta_query'			=> array(
			// 			'relation' => 'OR',
			// 			array(
			// 				'key' => 'doNotShow',
			// 				'compare' => 'NOT EXISTS',
			// 			),
			// 			array(
			// 				'key' => 'doNotShow',
			// 				'value'		=> '',
			// 				'compare' => '='
			// 			),
			// 		)
			);
		$posts = new WP_Query($args);
		if ( $posts->have_posts() ) { ?>
		<section id="section-activities" data-section="Activities" class="section-content camp-activities activities-parent-page">
			<div class="entryList flexwrap">

				<?php $i=1; while ( $posts->have_posts() ) : $posts->the_post();  
					$images = get_field('flexslider_banner');
					$img = ( $images && isset($images[0]) ) ? $images[0] : '';
					$thumbnail = ($img) ? $img['image'] : '';
					$title = get_the_title();
					$pagelink = get_permalink();
					?>
					<div id="entryBlock<?php echo $i?>" class="fbox <?php echo ($thumbnail) ? 'hasImage':'noImage'; ?>">
						<div class="inside text-center">
							<div class="imagediv <?php echo ($thumbnail) ? 'hasImage':'noImage'?>">
								<a href="<?php echo $pagelink; ?>" class="link">
									<?php if ($thumbnail) { ?>
										<span class="img" style="background-image:url('<?php echo $thumbnail['url']?>')"></span>
									<?php } ?>
									<img src="<?php echo $placeholder ?>" alt="" aria-hidden="true" class="placeholder">
								</a>
							</div>
							<div class="titlediv">
								<p class="name"><?php echo $title ?></p>
								<div class="buttondiv">
									<a href="<?php echo $pagelink; ?>" class="btn-sm xs"><span>See Details</span></a>
								</div>
							</div>
						</div>
					</div>
				<?php $i++; endwhile; wp_reset_postdata(); ?>

			</div>
		</section>
		<?php } ?>

</div><!-- #primary -->

<?php
get_footer();
