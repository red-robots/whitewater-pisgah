<?php
/**
 * Template Name: Wedding
 */

get_header(); 
$blank_image = THEMEURI . "images/rectangle.png";
$square = THEMEURI . "images/square.png";
?>
<style type="text/css">
	.post-type-entries .details {
		position: relative;
		z-index: 1000;
	}
</style>
<div id="primary" data-post="<?php echo get_the_ID()?>" class="content-area-full catering-wedding boxedImagesPage">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php if( get_the_content() ) { ?>
				<div class="intro-text-wrap">
					<div class="wrapper">
						<h1 class="page-title"><span><?php the_title(); ?></span></h1>
						<div class="intro-text"><?php the_content(); ?></div>
					</div>
				</div>
			<?php } ?>
		<?php endwhile;  ?>

		<?php get_template_part("parts/subpage-tabs"); ?>

		<?php
		$postype = 'event-space';
		$venues = get_field("venues");
		$venues_title = get_field("venues_title");
		$event_button = get_field("event_button");
		if($venues) { ?>
		<section id="section-venues" data-section="<?php echo $venues_title ?>" class="section-content">
			<div class="post-type-entries <?php echo $postype ?>">
				<div id="data-container">
					<div class="posts-inner">
						<div class="flex-inner">
							<?php $i=1; foreach ($venues as $p) { 
								$id = $p->ID;
								$title = $p->post_title;
								$pagelink = get_permalink($id);
								$short_description = get_field("short_description",$id);
								$thumbImage = get_field("featured_image",$id);
								$space_features = get_field("space_features",$id);
								$showDetails = get_field('show_details', $id);
								?>
								<div class="postbox animated fadeIn <?php echo ($thumbImage) ? 'has-image':'no-image' ?>">
									<div class="inside">
										
										<?php if($showDetails != 'no'){ ?>
											<a href="<?php echo $pagelink ?>" class="photo wave-effect js-blocks">
										<?php } else { ?>
											<div class="js-blocks">
										<?php } ?>
											<?php if ($thumbImage) { ?>
												<span class="imagediv" style="background-image:url('<?php echo $thumbImage['sizes']['medium_large'] ?>')"></span>
												<img src="<?php echo $thumbImage['url']; ?>" alt="<?php echo $thumbImage['title'] ?>" class="feat-img" style="display:none;">
												<img src="<?php echo $blank_image ?>" alt="" class="feat-img placeholder">
											<?php } else { ?>
												<span class="imagediv"></span>
												<img src="<?php echo $blank_image ?>" alt="" class="feat-img placeholder">
											<?php } ?>
											<span class="boxTitle">
												<span class="twrap">
													<span class="t1"><?php echo $title ?></span>
												</span>
											</span>

											<?php include( locate_template('images/wave-svg.php') ); ?>
										<?php if($showDetails != 'no'){ ?>
											</a>
										<?php } else { ?>
											</div>
										<?php } ?>

										<div class="details">
											<div class="info">
												<h3 class="event-name"><?php echo $title ?></h3>
												
												<?php if ($space_features && array_filter($space_features)) { 
													$filter_space_features = array_filter($space_features); 
													?>
													<div class="pricewrap">
														<div class="price-info">
															<?php foreach ($filter_space_features as $k=>$v) { ?>
																<?php if ( $v && is_array($v) ) {
																	$x_value = ( isset($v['value']) && $v['value'] ) ? $v['value'] : '';
																	$x_label = ( isset($v['label']) && $v['label'] ) ? $v['label'] : '';
																	if($x_value && $x_label) { ?>
																	<span class="<?php echo $x_value ?>"><?php echo $x_label ?></span>
																	<?php } ?>
																<?php } else { ?>
																	<span class="<?php echo $k ?>"><?php echo $v ?></span>
																<?php } ?>
															<?php } ?>
														</div>
													</div>
												<?php } ?>

												<?php if ($short_description) { ?>
												<div class="short-description">
													<?php echo $short_description ?>
												</div>
												<?php } ?>

												<?php if($showDetails != 'no'){ ?>
													<div class="button">
														<a href="<?php echo $pagelink ?>" class="btn-sm"><span>See Details</span></a>
													</div>
												<?php } ?>
												
											</div>
										</div>

									</div>
								</div>
							<?php $i++; } ?>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php } ?>
		
		<?php if($event_button) { 
			$etarget = (isset($event_button['target']) && $event_button['target']) ? $event_button['target']:'_self'; ?>
		<div class="cta-button-wrap black">
			<a href="<?php echo $event_button['url'] ?>" target="<?php echo $etarget ?>" class="ctaBtn"><span><?php echo $event_button['title'] ?></span></a>
		</div>
		<?php } ?>

		<?php  
		$whats_included_title = get_field("wi_title");
		$whats_included = get_field("whats_included");
		$w_title = ( isset($whats_included['title']) && $whats_included['title'] ) ? $whats_included['title'] : '';
		$w_includes = ( isset($whats_included['includes']) && $whats_included['includes'] ) ? $whats_included['includes'] : '';
		$w_button = ( isset($whats_included['button']) && $whats_included['button'] ) ? $whats_included['button'] : '';
		if($whats_included) { ?>
		<section id="section-whatsincluded" data-section="<?php echo $whats_included_title ?>" class="section-content">
			<div class="wrapper narrow text-center">
				<?php if ($w_title) { ?>
				<h2 class="stitle"><?php echo $w_title ?></h2>	
				<?php } ?>

				<?php if ($w_includes) { ?>
				<div class="text"><?php echo $w_includes ?></div>	
				<?php } ?>

				<?php if ($w_button) {
				$wTarget = ( isset($w_button['target']) && $w_button['target'] ) ? $w_button['target'] : '_self'; ?>
				<div class="button">
					<a href="<?php echo $w_button['url'] ?>" target="<?php echo $wTarget ?>" class="btn-sm white"><span><?php echo $w_button['title'] ?></span></a>
				</div>	
				<?php } ?>
			</div>
		</section>
		<?php } ?>
		

		<?php  
		$catering_note = get_field("catering_note");
		$cateringTitle = get_field("cateringTitle");
		$catering_services = get_field("catering_services");
		if($catering_services) { ?>
		<section id="section-catering" data-section="<?php echo $cateringTitle ?>" class="section-content">
			<div class="post-type-entries <?php echo $postype ?>">
				<div id="data-container">
					<div class="posts-inner">
						<div class="flex-inner">
							<?php foreach ($catering_services as $cs) { 
								$title = $cs['title'];
								$description = $cs['description'];
								$thumbImage = $cs['image'];
								$button = $cs['button'];
								$target = ( isset($button['target']) && $button['target'] ) ? $button['target'] : '_self';
								?>
								<div class="postbox animated fadeIn <?php echo ($thumbImage) ? 'has-image':'no-image' ?>">
									<div class="inside">
										<div class="photo wave-effect js-blocks">
											<?php if ($thumbImage) { ?>
												<span class="imagediv" style="background-image:url('<?php echo $thumbImage['sizes']['medium_large'] ?>')"></span>
												<img src="<?php echo $thumbImage['url']; ?>" alt="<?php echo $thumbImage['title'] ?>" class="feat-img" style="display:none;">
												<img src="<?php echo $blank_image ?>" alt="" class="feat-img placeholder">
											<?php } else { ?>
												<span class="imagediv"></span>
												<img src="<?php echo $blank_image ?>" alt="" class="feat-img placeholder">
											<?php } ?>
											<span class="boxTitle">
												<span class="twrap">
													<span class="t1"><?php echo $title ?></span>
												</span>
											</span>
										</div>

										<div class="details">
											<div class="info">
												<h3 class="event-name"><?php echo $title ?></h3>

												<?php if ($description) { ?>
												<div class="short-description">
													<?php echo $description ?>
												</div>
												<?php } ?>

												<?php if ($button) { ?>
												<div class="button">
													<a href="<?php echo $button['url'] ?>" target="<?php echo $target ?>" class="btn-sm"><span><?php echo $button['title'] ?></span></a>
												</div>
												<?php } ?>
								
											</div>
										</div>

									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php } ?>

		<?php if ($catering_note) { ?>
		<div class="note-wrap-red text-center">
			<div class="wrapper"><?php echo $catering_note ?></div>
		</div>	
		<?php } ?>

		<?php  
		$catering_button = get_field("catering_button");
		$catButtonTarget = ( isset($catering_button['target']) && $catering_button['target'] ) ? $catering_button['target'] : '_self';
		if($catering_button) { ?>
		<div class="cta-button-wrap black">
			<a href="<?php echo $catering_button['url'] ?>" target="<?php echo $catButtonTarget ?>" class="ctaBtn"><span><?php echo $catering_button['title'] ?></span></a>
		</div>
		<?php } ?>


		<?php
		$inquiry_text = get_field("inquiry_text");
		$inquiry_button = get_field("inquiry_button");
		$inqButtonTarget = ( isset($inquiry_button['target']) && $inquiry_button['target'] ) ? $inquiry_button['target'] : '_self';
		if($inquiry_text) { ?>
		<div class="inquiry-wrapper full">
			<div class="wrapper narrow text-center">
				<?php echo $inquiry_text ?>
				<?php if ($inquiry_button) { ?>
				<div class="button">
					<a href="<?php echo $inquiry_button['url'] ?>" target="<?php echo $inqButtonTarget ?>" class="btn-sm white"><span><?php echo $inquiry_button['title'] ?></span></a>
				</div>	
				<?php } ?>
			</div>
		</div>
		<?php } ?>

		<?php 
		/* FAQS */
		$customFAQTitle = 'FAQS'; /* Title will have an icon */
		include( locate_template('parts/content-faqs.php') );   
		?>

		<?php $inquiry = get_field("inquire"); ?>
		<?php if ($inquiry) { ?>
		<div class="inquiry-wrapper full">
			<div class="wrapper narrow text-center">
				<?php echo anti_email_spam($inquiry); ?>
			</div>
		</div>
		<?php } ?>



</div><!-- #primary -->

<?php 
include( locate_template('inc/faqs.php') );  
include( locate_template('inc/pagetabs-script.php') );
?>

<?php
get_footer();
