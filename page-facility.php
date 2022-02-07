<?php
/**
 * Template Name: Facility Map
 */
$placeholder = THEMEURI . 'images/rectangle.png';
$square = THEMEURI . 'images/square.png';
$banner = get_field("flexslider_banner");
$has_banner = ($banner) ? 'hasbanner':'nobanner';
get_header(); ?>

<div id="primary" class="content-area-full about-page <?php echo $has_banner ?>">
	<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php if( get_the_content() ) { ?>
			<div class="intro-text-wrap">
				<div class="wrapper">
					<h1 class="page-title"><span><?php the_title(); ?></span></h1>
					<div class="intro-text"><?php the_content(); ?></div>
				</div>
			</div>
			<?php } ?>

			<?php if( $facility_maps = get_field("facility_maps") ) { 
				$block_title = get_field("block_title");
				$custom_icon = get_field("custom_icon");
				$count = count($facility_maps);
				$mapClass = ($count>1) ? 'half':'full';
			?>

			<?php get_template_part("parts/subpage-tabs"); ?>

			<section class="facility-map-section <?php echo $mapClass ?>">
				<div class="wrapper">
					<div class="shead-icon text-center">
						<div class="icon"><span class="<?php echo $custom_icon ?>"></span></div>
						<h2 class="stitle"><?php echo $block_title ?></h2>
					</div>
				</div>

				<div class="columns-wrapper maps-above-the-other">
					<?php $n=1; foreach ($facility_maps as $m) {
						$title = $m['title']; 
						$image = $m['image'];
						$width = $m['blockwidth'];
						if($width) {
							$style = ($width) ? ' style="width:'.$width.'%"' : '';
						} else {
							$style = ($width) ? ' style="max-width:1200px;width:100%"' : '';
						}
						if($image) { ?>
							<div class="map-wrap mcol<?php echo $n ?>">
								<div id="mapcol<?php echo $n ?>" class="mapcol c<?php echo $n ?>"<?php echo $style ?> data-section="<?php echo $title ?>">
									<div class="inside" style="background-image:url('<?php echo $image['url'] ?>')">
										<a href="<?php echo $image['url'] ?>" data-fancybox>
											<img src="<?php echo $image['url'] ?>" alt="<?php echo $image['title'] ?>" />
											<span class="zoom-icon"><i class="fas fa-search"></i></span>
										</a>
									</div>
								</div>
							</div>
						<?php $n++; } ?>
					<?php } ?>
				</div>
			</section>
			<?php } ?>
			
		<?php endwhile; ?>

	</main><!-- #main -->
</div><!-- #primary -->
<?php include( locate_template('inc/pagetabs-script.php') ); ?>
<?php
get_footer();
