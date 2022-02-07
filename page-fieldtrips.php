<?php
/**
 * Template Name: Field Trips
 */

get_header(); 
$rectangle = THEMEURI . "images/rectangle.png";
$square = THEMEURI . "images/square.png";
?>

<div id="primary" data-post="<?php echo get_the_ID()?>" class="content-area-full field-trips-page">
		<?php while ( have_posts() ) : the_post(); ?>
			<div class="intro-text-wrap">
				<div class="wrapper">
					<h1 class="page-title"><span><?php the_title(); ?></span></h1>
					<?php if ( get_the_content() ) { ?>
					<div class="intro-text"><?php the_content(); ?></div>
					<?php } ?>
				</div>
			</div>
		<?php endwhile;  ?>

		<?php get_template_part("parts/subpage-tabs"); ?>

		<?php
		$args = array(
			'posts_per_page'=> -1,
			'post_type'		=> 'fieldtrips',
			'post_status'	=> 'publish'
		);
		$trips = new WP_Query($args);

		if ( $trips->have_posts() ) { 
			$count = $trips->found_posts;
			$wrapClass = ($count==2) ? 'twocol':'default';
		?>
		<section id="classes" data-section="Classes" class="section-content section-classes post-type-entries <?php echo $wrapClass ?>">
			<div id="data-container">
				<div class="posts-inner">
					<div class="flex-inner">
					<?php $i=1; while ( $trips->have_posts() ) : $trips->the_post(); 
						$id = get_the_ID();
						$title = get_the_title();
						$pagelink = get_permalink();
						$thumbImage = get_field("fieldtrip_thumbnail_image");
						$short_description = get_field("fieldtrip_short_description");
						$opt = get_field("fieldtrip_options");
					?>
					<div class="postbox animated fadeIn <?php echo ($thumbImage) ? 'has-image':'no-image' ?>">
						<div class="inside">
							<a href="<?php echo $pagelink ?>" class="photo">
								<?php if ($thumbImage) { ?>
									<span class="imagediv" style="background-image:url('<?php echo $thumbImage['sizes']['medium_large'] ?>')"></span>
									<img src="<?php echo $rectangle ?>" alt="" class="feat-img placeholder">
								<?php } else { ?>
									<span class="imagediv"></span>
									<img src="<?php echo $rectangle ?>" alt="" class="feat-img placeholder">
								<?php } ?>
							</a>

							<div class="details">
								<div class="info">
									<h3 class="event-name"><?php echo $title ?></h3>
									<?php if ($short_description) { ?>
									<div class="short-description">
										<?php echo $short_description ?>
									</div>
									<?php } ?>

									<?php if( isset($opt['educational_programs']) && $opt['educational_programs']>0 ) { ?>
									<div class="option-info">
										<p class="t1"><strong>Educational Programs</strong></p>
										<p class="t2"><?php echo $opt['educational_programs']; ?></p>
									</div>
									<?php } ?>

									<?php if( isset($opt['pass_activities']) ) { ?>
									<div class="option-info">
										<p class="t1"><strong>Pass Activities</strong></p>
										<p class="t2"><?php echo $opt['pass_activities']; ?></p>
									</div>
									<?php } ?>

									<?php if( isset($opt['grades']) ) { ?>
									<div class="option-info">
										<p class="t1"><strong>Grades</strong></p>
										<p class="t2"><?php echo $opt['grades']; ?></p>
									</div>
									<?php } ?>

									<?php if( isset($opt['price']) ) { ?>
									<div class="option-info price">
										<p class="t1"><strong>Price</strong></p>
										<p class="t2"><?php echo $opt['price']; ?></p>
									</div>
									<?php } ?>
								</div>
							</div>
						</div>
						<div class="button">
							<a href="<?php echo $pagelink ?>" class="btn-sm"><span>See Details</span></a>
						</div>
					</div>
					<?php $i++; endwhile; wp_reset_postdata(); ?>
					</div>
				</div>
			</div>
		</section>
		<?php } ?>

		<?php
		/* FAQs */
		$customFAQTitle = 'FAQ';
		$customFAQClass = 'custom-class-faq graybg';
		include( locate_template('parts/content-faqs.php') );
		include( locate_template('inc/faqs.php') );
		?>

		<?php
		/* FORM */
		$form_title = get_field("fieldtrip_form_title");
		$form = get_field("fieldtrip_form");
		if($form) { ?>
		<section id="group-outings-form" data-section="<?php echo $form_title ?>" class="section-content group-form-section">
			<div class="wrapper narrow">
				<?php if ($form_title) { ?>
				<h2 class="stitle text-center"><?php echo $form_title ?></h2>
				<?php } ?>
				<div class="form-content"><?php echo $form ?></div>
			</div>
		</section>
		<?php } ?>

</div><!-- #primary -->

<?php
include( locate_template('inc/pagetabs-script.php') );
get_footer();
