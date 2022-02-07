<?php
/**
 * Template Name: Summer Camps
 */
$placeholder = THEMEURI . 'images/rectangle.png';
$square = THEMEURI . 'images/square.png';
$imgNotAvailable = THEMEURI . 'images/image-not-available.jpg';
$banner = get_field("full_image");
$has_banner = ($banner) ? 'hasbanner':'nobanner';
$currentPostType = get_post_type();
$currentPostId = get_the_ID();
get_header(); ?>
<?php get_template_part("parts/single-banner"); ?>
<div id="primary" class="content-area-full event-space-single <?php echo $has_banner ?>">
	<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<section class="text-centered-section full<?php echo ($banner) ? '':' noBanner' ?>">
				<div class="wrapper text-center">
					<div class="page-header">
						<h1 class="page-title"><?php the_title(); ?></h1>
					</div>
					<?php if ( get_the_content() ) { ?>
					<div class="text"><?php the_content(); ?></div>
					<?php } ?>
				</div>
			</section>

			<?php  
			$features = get_field_object("space_features");
			$featuresFields['area_size'] = 'Size';
			$featuresFields['capacity'] = 'Capacity';
			$featuresFields['type'] = 'Setting';
			$featuresFields['price'] = 'Price (Per Tent)';
			//$featuresFields['ceiling_height'] = 'Ceiling Height';
			$feats = ( isset($features['value']) && $features['value'] ) ? $features['value'] : '';
			?>

			<?php if ($feats) {  ?>
			<div class="space-features-wrap full">
				<div class="flexwrap">
					<?php foreach ($featuresFields as $key=>$val) { 
						$fieldVal = ( isset($feats[$key]) && $feats[$key] ) ? $feats[$key]:'N/A';
						if($fieldVal && $key=='type') {
							$fieldVal = $fieldVal['label'];
						} ?>
						<div class="info">
							<div class="wrap">
								<div class="label title3"><?php echo $val; ?></div>
								<div class="val"><?php echo $fieldVal; ?></div>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>	
			<?php } ?>

			<?php
			/* FLOOR PLANS */
			$floorplan_title = get_field("floorplan_title");
			$floorplan = get_field("floorplan");
			if($floorplan) { ?>
			<div class="floor-plan-section full">
				<div class="wrapper text-center">
					<?php if ($floorplan_title) { ?>
						<h2 class="title3"><?php echo $floorplan_title ?></h2>
					<?php } ?>
					<div class="floorplans">
					<?php foreach ($floorplan as $p) { 
						$fp_title = $p['title'];
						$attachment =  (isset($p['attachment']) && $p['attachment']) ? $p['attachment'] : '';
						$fp_image = '';
						//$fp_image = (isset($p['image']) && $p['image']) ? $p['image'] : '';
						//$fp_image_url = ( isset($fp_image['url']) && $fp_image['url'] ) ? $fp_image['url'] : $imgNotAvailable;
						//$fp_image_url = ( isset($fp_image['url']) && $fp_image['url'] ) ? $fp_image['url'] : '';

						if($fp_title && $attachment) { 
							$type = $attachment['type'];
							$pageURL = $attachment['url'];
							
							if($type=='image') { ?>
							<span class="plan">
								<a href="<?php echo $pageURL ?>" data-fancybox="gallery" data-caption="<?php echo $fp_title ?>">
									<span class="plan-name"><?php echo $fp_title ?></span>
								</a>
							</span>
							<?php } else if( $type=='application' ) { ?>
							<span class="plan">
								<a href="<?php echo $attachment['url'] ?>" target="_blank">
									<span class="plan-name"><?php echo $fp_title ?></span>
								</a>
							</span>
							<?php } ?>

						<?php } ?>


					<?php } ?>
					</div>
				</div>
			</div>
			<?php } ?>

			<?php if( $galleries = get_field("gallery") ) { ?>
			<section class="section-price-ages full">
				<div id="carousel-images">
					<div class="loop owl-carousel owl-theme">
					<?php foreach ($galleries as $g) { ?>
						<div class="item">
							<div class="image" style="background-image:url('<?php echo $g['url']?>')">
								<img src="<?php echo $placeholder ?>" alt="" aria-hidden="true" />
							</div>
						</div>
					<?php } ?>
					</div>
				</div>
			</section>
			<?php } ?>

			<?php
			/* LOCATION */
			$map_title = get_field("map_title");
			$map_text = get_field("map_text");
			$map_image_1 = get_field("map_image_1");
			$map_image_2 = get_field("map_image_2");
			$mapClass = ($map_image_1 && $map_image_2) ? 'half':'full';
			$has_text = ($map_title || $map_text) ? ' has-text':'';
			$colLeftClass = ( $map_image_1 && ($map_title || $map_text) ) ? ' has-text-and-image':'';
			if($map_image_1 || $map_image_2) { ?>
			<section id="section-checkin" class="section-content location-section <?php echo $mapClass ?>">
				<div class="wrapper-full">
					<?php if ($map_image_1 || $map_image_2) { ?>
						<div class="col-left column <?php echo $has_text.$colLeftClass ?>">
							<?php if ($map_title || $map_text) { ?>
								<div class="flex-content largebox has-text">
									<div class="inside">
										<div class="caption">
											<div class="text">
												<?php if ($map_title) { ?>
													<h2><?php echo $map_title ?></h2>
												<?php } ?>
												<?php if ($map_text) { ?>
													<?php echo $map_text; ?>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>

							<?php if ($map_image_1) { ?>
								<div class="flex-content largebox has-image">
									<div class="image" style="background-image:url('<?php echo $map_image_1['url']?>')">
										<img src="<?php echo $placeholder ?>" alt="" aria-hidden="true" />
									</div>
								</div>
							<?php } ?>
						</div>

						<?php if ($map_image_2) { ?>
						<div class="col-right column">
							<div class="flex-content largebox  has-image">
								<div class="inside">
									<img src="<?php echo $map_image_2['url'] ?>" alt="<?php echo $map_image_2['title'] ?>" class="big-image">
								</div>
							</div>
						</div>
						<?php } ?>
					<?php } ?>
				</div>
			</section>
			<?php } else { ?>

				<div style="display:none;">
				<?php if ($map_title || $map_text) { ?>
						<div class="col-full full text-center <?php echo $has_text ?>">
							<?php if ($map_title || $map_text) { ?>
								<div class="wrapper">
										<?php if ($map_title) { ?>
											<h2><?php echo $map_title ?></h2>
										<?php } ?>
										<?php if ($map_text) { ?>
											<?php echo $map_text; ?>
										<?php } ?>
								</div>
							<?php } ?>
						</div>
				<?php } ?>
				</div>

			<?php } ?>
			
			
			<?php  
			/* EQUIPMENTS */
			$equipment_title = get_field("equipment_title");
			$equipments = get_field("equipments");
			if($equipments) { ?>
			<section class="equipments-section full">
				<div class="wrapper narrow text-center">
					<?php if ( $equipment_title ) { ?>
					<div class="shead-icon text-center">
						<div class="icon"><span class="ci-cable"></span></div>
						<h2 class="stitle"><?php echo $equipment_title ?></h2>
					</div>
					<?php } ?>

					<?php if ( $equipments ) { ?>
					<div class="text"><?php echo $equipments ?></div>
					<?php } ?>
				</div>
			</section>
			<?php } ?>


		<?php endwhile; ?>




		<?php
		/* SIMILAR VENUES */
		$currentPostType = get_post_type();
		$similarPosts = get_field("similar_posts_section","option");
		$bottomSectionTitle = '';
		if($similarPosts) {
			foreach($similarPosts as $s) {
				$posttype = $s['posttype'];
				$sectionTitle = $s['section_title'];
				if($posttype==$currentPostType) {
					$bottomSectionTitle = $sectionTitle;
				}
			}
		}
		$args = array(
			'posts_per_page'=> 20,
			'post_type'			=> $currentPostType,
			'orderby' 			=> 'rand',
		  'order'    			=> 'ASC',
			'post_status'		=> 'publish',
			'post__not_in' 	=> array($currentPostId)
		);
		$posts = new WP_Query($args);
		?>
		<section class="explore-other-stuff">
			<div class="wrapper">
				<?php if ($bottomSectionTitle) { ?>
				<h3 class="sectionTitle"><?php echo $bottomSectionTitle ?></h3>
				<?php } ?>
				<div class="post-type-entries">
					<div class="columns">
						<?php $i=1; while ( $posts->have_posts() ) : $posts->the_post(); ?>
						<div class="entry">
							<a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a>
						</div>
						<?php $i++; endwhile; wp_reset_postdata(); ?>
					</div>
				</div>
			</div>
		</section>


		<?php  /* FAQ */ 
			$customFAQTitle = 'FAQ';
			$customFAQClass = 'custom-class-faq';
			include( locate_template('parts/content-faqs.php') ); 
		?>


		<?php
		/* GET MORE INFORMATION */
		$bottom_title = get_field("event_space_bottom_title","option");
		$event_space_bottom_form = get_field("event_space_bottom_form","option");
		$bottom_button = get_field("event_space_bottom_button","option");
		$buttonTarget = ( isset($bottom_button['target']) && $bottom_button['target'] ) ? $bottom_button['target']:'_self';
		if($bottom_title) { ?>
		<div class="redbar-full text-center">
			<div class="wrapper">
				<h2 class="stitle"><?php echo $bottom_title ?></h2>
				<?php if ($bottom_button) { ?>
				<div class="buttondiv">
					<a href="<?php echo $bottom_button['url'] ?>" target="<?php echo $buttonTarget ?>" class="btn-sm btn-cta white"><span><?php echo $bottom_button['title'] ?></span></a>
				</div>
				<?php } ?>

				<?php if ($event_space_bottom_form) { ?>
				<div class="event-form-wrap">
					<?php echo $event_space_bottom_form ?>
				</div>	
				<?php } ?>
			</div>		
		</div>
		<?php } ?>

	</main><!-- #main -->
</div><!-- #primary -->


<?php 
include( locate_template('inc/faqs.php') );  
?>

<script type="text/javascript">
jQuery(document).ready(function($){
	$('.loop').owlCarousel({
    center: true,
    items:2,
    nav: true,
    loop:true,
    margin:15,
    autoplay:true,
    autoplayTimeout:3000,
    autoplayHoverPause:true,
    responsive:{
      600:{
       	items:2
      },
      400:{
       	items:1
      }
    }
	});
});
</script>
<?php
get_footer();
