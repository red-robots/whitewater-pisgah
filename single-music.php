<?php
$show_content_only = ( isset($_GET['show']) && $_GET['show']=='contentonly' ) ? true : false;
$rectangle = THEMEURI . "images/rectangle-lg.png";
if($show_content_only) {

		while ( have_posts() ) : the_post(); ?>
			<div class="content-only">
				<?php $event_details = get_field("event_details"); ?>

				<?php if ( $event_details ) { ?>
				<div class="other-details"><?php echo $event_details; ?>		</div>
				<?php } ?>

				<?php if ( get_the_content() ) { ?>
				<div class="co-main-text"><?php the_content(); ?>		</div>
				<?php } ?>
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
