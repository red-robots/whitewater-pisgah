<?php
// Single Retreat.


get_header(); 
$post_type = get_post_type();
$dClass = '';
$mClass = '';
$heroImage = get_field("post_image_full");
$mobileBanner = get_field('mobile-banner');
if( $mobileBanner ) {
	$dClass = 'desktop';
	$mClass = 'mobile';
}
$has_hero = ($heroImage) ? 'has-banner':'no-banner';


$registration_status = get_field("registration_status"); 
$status = ($registration_status) ? $registration_status : 'open';
$blank_image = THEMEURI . "images/square.png";
$status_custom_message = get_field("status_custom_message");
$passport = get_field('passport_btn');
$passLabel = get_field('passport_label');
$idArray = array('266','267','268','269','270','271');
if( $passport == 'all' ) {
	$pp = 'data-accesso-launch';
} elseif(in_array($passport, $idArray )) {
	$pp = 'data-accesso-package="'.$passport.'"';
} else {
	$pp = 'data-accesso-keyword="'.$passport.'"';
}
// echo '<pre>';
// print_r($pp);
// echo '</pre>';
?>
<div id="primary" class="content-area-full  outfitters post-type-dining single-post <?php echo $has_hero ?>">
	<?php if ($heroImage) { ?>
		<div class="post-hero-image <?php echo $status; ?>">
			<img src="<?php echo $heroImage['url'] ?>" alt="<?php echo $heroImage['title'] ?>" class="featured-image <?php echo $dClass; ?>">

			<img src="<?php echo $mobileBanner['url'] ?>" alt="<?php echo $mobileBanner['title'] ?>" class="featured-image <?php echo $mClass; ?>">
			<?php if ($status=='open') { ?>

				<?php if($passport){ ?>
					<div class="stats open">
						<a <?php if($passport){echo $pp;} ?> href="#" target="<?php echo $buttonTarget ?>" class="registerBtn">
							<?php if($passLabel){echo $passLabel;}else{echo 'Buy';} ?>
						</a>
					</div>
				<?php }else{ ?>
					<?php if ($registerButton && $registerLink) { ?>
						<div class="stats open"><a href="<?php echo $registerLink ?>" target="<?php echo $registerTarget ?>" class="registerBtn"><?php echo $registerButton ?></a></div>
					<?php } ?>
				<?php } ?>
			<?php } else if($status=='closed') { ?>
			<div class="stats closed">SOLD OUT</div>
			<?php } else if($status=='custom') { ?>

				<?php if ($status_custom_message) { ?>
				<div class="stats closed custom-message-banner"><div class="innerTxt"><?php echo $status_custom_message ?></div></div>
				<?php } ?>
			
			<?php } ?>
			
		</div>
	<?php } ?>
	<main id="main" class="site-main fw-left" role="main">
		<?php while ( have_posts() ) : the_post(); ?>

			<?php if( get_the_content() ) { ?>
				<div class="intro-text-wrap">
					<div class="wrapper">
						<h1 class="page-title"><span><?php the_title(); ?></span></h1>
						<div class="intro-text"><?php the_content(); ?></div>
					</div>
				</div>
			<?php } ?>

			<?php get_template_part("parts/subpage-tabs"); ?>

		<?php endwhile; ?>


		<?php  
				/* EVENT DETAILS */
				$details = get_field("event_details");
				$event_title = get_field("event_title");
				$event_button = get_field("event_button");
				$button = ( isset($event_button['button_type']) && $event_button['button_type'] ) ? $event_button['button_type']:'';
				$buttonName = '';
				$buttonLink = '';
				$buttonTarget = '';
				if($button && $button=='pdf') {
					$buttonPDF = $event_button['button_pdf'];
					if($buttonPDF['pdf_button_name'] && $buttonPDF['pdf_button_link']) {
						$buttonName = $buttonPDF['pdf_button_name'];
						$buttonLink = $buttonPDF['pdf_button_link']['url'];
						$buttonTarget = '_blank';
					}
				} else if($button && $button=='pagelink') {
					$buttonPage = $event_button['button_pagelink'];
					$buttonName = $buttonPage['title'];
					$buttonLink = $buttonPage['url'];
					$buttonTarget = ( isset($buttonPage['target']) && $buttonPage['target'] ) ? $buttonPage['target']:'_self';
				}
				$cta_buttons = get_field("event_cta_buttons");
				if($details) { ?>
				<section id="section-event-details" data-section="<?php echo $event_title ?>" class="section-content dining-event-details">
					<div class="wrapper">
						<?php if ($event_title) { ?>
						<div class="shead-icon text-center">
							<div class="icon"><span class="ci-menu"></span></div>
							<h2 class="stitle"><?php echo $event_title ?></h2>
						</div>
						<?php } ?>
						
						<div class="details text-center">
							<?php foreach ($details as $d) { 
								$title = $d['title'];
								$text = $d['description'];
								?>
								<div class="wrapper narrow info">
									<?php if ($title) { ?>
										<h3 class="infoTitle"><?php echo $title ?></h3>
									<?php } ?>
									<?php if ($text) { ?>
										<div class="infoText"><?php echo $text ?></div>
									<?php } ?>
								</div>
							<?php } ?>
							
							<?php if ( $status!='closed' && $cta_buttons ) { ?>
								<div class="buttondiv">
								<?php foreach ($cta_buttons as $btn) { 
										$buttonType = $btn['button_type'];
										if($buttonType) { 
											$b_type = 'button_' . $buttonType;
											$b_val = $btn[$b_type];
											if( $b_val ) {
												if($buttonType=='pdf') { 
													$btn_name = $b_val['pdf_button_name'];
													$btn_link = ( isset($b_val['pdf_button_link']['url']) && $b_val['pdf_button_link']['url'] ) ? $b_val['pdf_button_link']['url']:'';
													if($btn_name && $btn_link) { ?>
														<a href="<?php echo $btn_link ?>" target="_blank" class="btn-sm btn-pdf"><span><?php echo $btn_name ?></span></a>
													<?php } ?>

												<?php } else { 
													$btn_name = ( isset($b_val['title']) && $b_val['title'] ) ? $b_val['title'] : '';
													$btn_link = ( isset($b_val['url']) && $b_val['url'] ) ? $b_val['url'] : '';
													$btn_target = ( isset($b_val['target']) && $b_val['target'] ) ? $b_val['target'] : '_self';
													?>
													<a href="<?php echo $btn_link ?>" target="<?php echo $btn_target ?>" class="btn-sm btn-pagelink"><span><?php echo $btn_name ?></span></a>
												<?php } ?>

											<?php } ?>

										<?php } ?>
								<?php } ?>
								</div>
							<?php } ?>

						</div>
					</div>
				</section>
				<?php } ?>	


				<?php  
				/* MAP */
				$map_title = get_field("map_title");
				$map_image_1 = get_field("map_image_1");
				$map_image_2 = get_field("map_image_2");
				$mapClass = ($map_image_1 && $map_image_2) ? 'half':'full';
				if ( $map_image_1 || $map_image_2 ) { ?>
				<section id="section-map" data-section="<?php echo $map_title ?>" class="section-content dining-section-map <?php echo $mapClass ?>">
					<?php if ($map_title) { ?>
						<div class="shead-icon text-center">
							<div class="wrapper">
								<div class="icon"><span class="ci-map"></span></div>
								<h2 class="stitle"><?php echo $map_title ?></h2>
							</div>
						</div>
					<?php } ?>
					<div class="flexwrap imageWrapper">
						<?php if ($map_image_1) { ?>
						<div class="imageBlock">
							<div class="inside">
								<span class="image" style="background-image:url('<?php echo $map_image_1['url'] ?>')"></span>
								<img src="<?php echo $map_image_1['url'] ?>" alt="<?php echo $map_image_1['title'] ?>" />
							</div>
						</div>
						<?php } ?>

						<?php if ($map_image_2) { ?>
						<div class="imageBlock">
							<div class="inside">
								<span class="image" style="background-image:url('<?php echo $map_image_2['url'] ?>')"></span>
								<img src="<?php echo $map_image_2['url'] ?>" alt="<?php echo $map_image_2['title'] ?>" />
							</div>
						</div>
						<?php } ?>
					</div>
				</section>
				<?php } ?>

		<?php 
		function sortCourseByDay($courses) {
		    // Get the current day of the week (0 = Sunday, 1 = Monday, etc.)
		    $currentDayOfWeek = date('w');

		    // Split the array into two parts: the days before the current day and the days after
		    $daysBeforeCurrentDay = array_slice($courses, $currentDayOfWeek);
		    $daysAfterCurrentDay = array_slice($courses, 0, $currentDayOfWeek);

		    // Combine the two parts and return the sorted array
		    $sortedCourses = array_merge($daysBeforeCurrentDay, $daysAfterCurrentDay);

		    return $sortedCourses;
		}

		$myDays = get_field('schedule_days');

		$sortedCourses = sortCourseByDay($myDays);
		// echo '<pre>';
		// print_r($myDays);
		// echo '</pre>';


		if( have_rows('schedule_days') ): ?>
			<section class="instr-schedule">
				<div class="wwrapper">
					<div class="shead-icon text-center">
						<h2 class="stitle"><img src="<?php bloginfo('template_url'); ?>/images/icons/bw_calendar2.svg" width="30"  /> Upcoming</h2>
					</div>
				</div>
				<div id="inst-sched" class="flexslider-instr flexslider carousel">
					<ul class="slides">
					<?php foreach($sortedCourses as $day) { 
						$courseinfo = $day['coursetime'];
						$day_image = $day['day_image'];

					?>
						<li id="<?php echo $day['day_name'] ?>" class="slide-item">
							<div class="day">
								<?php if($day_image){ ?>
									<div class="image">
										<img src="<?php echo $day_image['url']; ?>">
									</div>
								<?php } ?>
								<div class="contents js-blocks">
									<h3><?php echo $day['day_name'] ?></h3>
									<?php foreach( $courseinfo as $c ) { 
										$product_link = $c['product_link'];
										$idArray = array('266','267','268','269','270','271');
										if( $product_link == 'all' ) {
											$pp = 'data-accesso-launch';
										} elseif(in_array($product_link, $idArray )) {
											$pp = 'data-accesso-package="'.$product_link.'"';
										} else {
											$pp = 'data-accesso-keyword="'.$product_link.'"';
										}
										?>
										<div class="row">
											<div class="left"><?php echo $c['time']; ?></div>
											<div class="right">
												<?php if($product_link){ echo '<a '.$pp.' href="#">'; } ?>
												<?php echo $c['course']; ?>
												<?php if($product_link){ echo '</a>'; }?>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>
						</li>
					<?php } ?>
					</ul>
				</div>
			</section>
		<?php endif; ?>

		<?php include(locate_template('parts/adventure-dining-map-v-two.php')); ?>

		<?php include(locate_template('parts/text-image-blocks-instruction.php')); ?>

				<?php  
				/* WHAT TO BRING */
				$wb_title = get_field("wb_title");
				$wb_text = get_field("wb_text");
				if ( $wb_title && $wb_text ) { ?>
				<section id="section-whattobring" data-section="<?php echo $wb_title ?>" class="section-content dining-section-whattobring">
					<div class="flexwrap">
						<div class="wrapper narrow text-center">
							<?php if ($wb_title) { ?>
								<div class="shead-icon text-center">
									<div class="icon"><span class="ci-backpack"></span></div>
									<h2 class="stitle"><?php echo $wb_title ?></h2>
								</div>
							<?php } ?>
							<div class="text"><?php echo $wb_text ?></div>
						</div>
					</div>
				</section>
				<?php } ?>

				<?php /* FAQ */ ?>
				<?php 
				$faq_title = get_field("faq_title");
				if( $faqs = get_faq_listings($post_id) ) { ?>
					<?php
						$customFAQTitle = $faq_title;
						include( locate_template('parts/content-faqs.php') ); 
						include( locate_template('inc/faqs.php') ); 
					?>
				<?php } ?>

		

			<?php
			/* FAQS JAVASCRIPT */ 
			//include( locate_template('inc/faqs-script.php') ); 
			?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php include( locate_template('inc/pagetabs-script.php') );  ?>
<?php
get_footer();
