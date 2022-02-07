<?php
$show_content_only = ( isset($_GET['show']) && $_GET['show']=='contentonly' ) ? true : false;
$rectangle = THEMEURI . "images/rectangle-lg.png";
if($show_content_only) {

		while ( have_posts() ) : the_post(); ?>
			<div class="content-only">
				<?php if( $flexslider = get_field("featured_images") ) {
					$slidesCount = count($flexslider);
					$slide_class = ($slidesCount>1) ? 'flexslider':'static-banner';
					$numSlides = ($slidesCount==1) ? 'single-slide':'multiple-slides';
					?>
					<div class="slideOuterWrap">
						<?php if ($slidesCount>1) { ?>
							<img src="<?php echo $rectangle ?>" alt="" aria-hidden="true" id="initImage" class="helper">
						<?php } ?>
						<div class="slides-wrapper <?php echo $slide_class ?>">
							<ul class="slides <?php echo $numSlides ?>">
								<?php $i=1; foreach ($flexslider as $img) { ?>
									<?php if ($img) { ?>
										<?php if ($slidesCount>1) { ?>
										<li class="slideItem slide<?php echo $i?>" style="background-image:url('<?php echo $img['url'] ?>')">
											<img src="<?php echo $img['url'] ?>" alt="<?php echo $img['title'] ?>" class="actual-image">
										</li>
										<?php } else { ?>
										<li class="slideItem slide<?php echo $i?>">
											<img src="<?php echo $img['url'] ?>" alt="<?php echo $img['title'] ?>" class="actual-image">
										</li>
										<?php } ?>
									<?php $i++; } ?>
								<?php } ?>
							</ul>
						</div>
					</div>
				<?php } ?>
				<?php the_content(); ?>		
			</div>
		<?php endwhile; 

} else {
	get_header(); 
	$post_type = get_post_type();
	$heroImage = get_field("full_image");
	$flexbanner = get_field("flexslider_banner");
	$has_hero = 'no-banner';
	if($heroImage) {
		$has_hero = ($heroImage) ? 'has-banner':'no-banner';
	} else {
		if($flexbanner) {
			$has_hero = ($flexbanner) ? 'has-banner':'no-banner';
		}
	}

	//$customPostTypes = array('activity','festival');
	get_template_part("parts/subpage-banner");
	$post_id = get_the_ID(); 

	?>
		
	<div id="primary" class="content-area-full content-default single-post <?php echo $has_hero;?> post-type-<?php echo $post_type;?>">

			<main id="main" data-postid="post-<?php the_ID(); ?>" class="site-main" role="main">
				<?php while ( have_posts() ) : the_post(); ?>
				<section class="text-centered-section">
					<div id="singleMainContent" class="wrapper text-center">
						<div class="page-header">
							<h1 class="page-title"><?php the_title(); ?></h1>
						</div>
						<?php the_content(); ?>
					</div>
				</section>
				<?php endwhile; ?>

			</main>

	</div>


<?php
get_footer();

} ?>
