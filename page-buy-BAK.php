<?php
get_header(); 
$blank_image = THEMEURI . "images/rectangle.png";
$square = THEMEURI . "images/square.png";
$banner = get_field("flexslider_banner");
$has_banner = ($banner) ? 'hasbanner':'nobanner';
?>

<div id="primary" data-post="<?php echo get_the_ID()?>" class="content-area-full page-activity-passes buy-page <?php echo $has_banner ?>">

	<?php while ( have_posts() ) : the_post(); ?>
		<div class="intro-text-wrap">
			<div class="wrapper">
				<h1 class="page-title"><span><?php the_title(); ?></span></h1>
				<div class="intro-text"><?php the_content(); ?></div>
			</div>
		</div>
	<?php endwhile;  ?>

	<?php get_template_part("parts/subpage-tabs"); ?>

	<?php
	$all_access_title = get_field("all_access_title");
	$all_access_feat_image = get_field("all_access_feat_image");
	$all_access_text = get_field("all_access_text");

	$single_access_title = get_field("single_access_title");
	$single_access_feat_image = get_field("single_access_feat_image");
	$single_access_text = get_field("single_access_text");
	$class1 = ( ($all_access_title || $all_access_text) && ($single_access_title || $single_access_text) ) ? 'half':'full';
	?>

	<?php if ( ($all_access_title || $all_access_text) || ($single_access_title || $single_access_text) ) { ?>
	<section id="passes" data-section="Passes" class="twoColSection">
		<div class="twoColInner">
				
			<?php /* ALL ACCESS PASSES */ ?>
			<?php if ($all_access_title || $all_access_text) { ?>
			<div id="section1" class="tcol <?php echo ($all_access_feat_image) ? 'hasphoto':'nophoto' ?>">
				<div class="inner">
					<?php if ($all_access_feat_image) { ?>
						<div class="photo">
							<div class="img" style="background-image:url('<?php echo $all_access_feat_image['url'] ?>');"><img src="<?php echo $blank_image ?>" alt="" aria-hidden="true" class="helper"></div>
						</div>
					<?php } ?>

					<?php
					$pass_args = array(
						'posts_per_page'	=> -1,
						'post_type'				=> 'pass',
						'post_status'			=> 'publish'
					);
					$all_passes = get_posts($pass_args);
					?>
					
					<div class="info text-center">
						<div class="pad">
							<?php if ($all_access_title) { ?>
								<div class="shead-icon text-center">
									<div class="icon"><span class="ci-pass"></span></div>
									<h2 class="stitle"><?php echo $all_access_title ?></h2>
								</div>
							<?php } ?>
							<?php if ($all_access_text) { ?>
								<div class="text"><?php echo $all_access_text ?></div>
							<?php } ?>
							<?php if ($all_passes) { ?>
							<div class="pass-types">
								<?php foreach ($all_passes as $p) { 
									$pid = $p->ID;
									$adult = get_field("adult_price",$pid);
									$young = get_field("young_price",$pid);
									$buyButton = get_field("purchase_button",$pid);
									$buttonName = (isset($buyButton['title']) && $buyButton['title']) ? $buyButton['title']:'Purchase Pass';
									$buttonLink = (isset($buyButton['url']) && $buyButton['url']) ? $buyButton['url']:'';
									$buttonTarget = (isset($buyButton['target']) && $buyButton['target']) ? $buyButton['target']:'_self';
									?>
									<div class="type">
										<div class="pass-name"><?php echo $p->post_title ?></div>
										<div class="price">
											<?php if ($adult) { ?>
											<div class="adult-price pr">Adult &ndash; <?php echo $adult ?></div>	
											<?php } ?>
											<?php if ($young) { ?>
											<div class="young-price pr">Young &ndash; <?php echo $young ?></div>	
											<?php } ?>

											<?php if ($buttonName && $buttonLink) { ?>
											<div class="buttondiv">
												<a href="<?php echo $buttonLink ?>" target="<?php echo $buttonTarget ?>" class="btn-sm"><span><?php echo $buttonName ?></span></a>
											</div>
											<?php } ?>
										</div>
									</div>
								<?php } ?>
							</div>	
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>

			<?php /* SINGLE ACTIVITY PASSES */ ?>
			<?php if ($single_access_title || $single_access_text) { ?>
			<div id="section2" class="tcol <?php echo ($single_access_feat_image) ? 'hasphoto':'nophoto' ?>">
				<div class="inner">
					<?php if ($single_access_feat_image) { ?>
						<div class="photo">
							<div class="img" style="background-image:url('<?php echo $single_access_feat_image['url'] ?>');"><img src="<?php echo $blank_image ?>" alt="" aria-hidden="true" class="helper"></div>
						</div>
					<?php } ?>

					<?php
					$single_pass_args = array(
						'posts_per_page'	=> -1,
						'post_type'				=> 'activity',
						'post_status'			=> 'publish',
						'tax_query'				=> array(
															array(
																'taxonomy' => 'pass_type',
																'field' => 'slug',
																'terms' => 'single-activity-pass',
																'operator' => 'IN'
														  )
														)
					);
					$single_activities = get_posts($single_pass_args);
					$other_activities = get_field("other_activities","option");
					?>

					<div class="info text-center">
						<div class="pad">
							<?php if ($single_access_title) { ?>
								<div class="shead-icon text-center">
									<div class="icon"><span class="ci-ticket"></span></div>
									<h2 class="stitle"><?php echo $single_access_title ?></h2>
								</div>
							<?php } ?>
							<?php if ($single_access_text) { ?>
								<div class="text"><?php echo $single_access_text ?></div>
							<?php } ?>
							<?php if ($single_activities || $other_activities) { ?>
							<div class="single-activities">

								<div class="inner-content">
									<?php /* OTHER ACTIVITIES */ ?>
									<?php if ($other_activities) { ?>
										<?php foreach ($other_activities as $e) { 
											$buy = $e['purchase_button'];
											$price = $e['price'];
											$buy_btn = ( isset($buy['title']) && $buy['title'] ) ? $buy['title']:'Purchase';
											$buy_link = ( isset($buy['url']) && $buy['url'] ) ? $buy['url']:'';
											$buy_target = ( isset($buy['target']) && $buy['target'] ) ? $buy['target']:'_self';
										?>
										<div class="itemrow other-activity">
											<?php if ($e['title']) { ?>
												<span class="activity-name"><span><?php echo $e['title'] ?></span></span>

												<?php if ($price || $buy_btn) { ?>
												<span class="button-group">
													<span class="wrap">
														<?php if ($price) { ?>
														<span class="price"><?php echo $price ?></span>	
														<?php } ?>
														<?php if ($buy_btn && $buy_link) { ?>
														<a href="<?php echo $buy_link ?>" target="<?php echo $buy_target ?>" class="btn-sm"><span><?php echo $buy_btn ?></span></a>
														<?php } ?>
													</span>
												</span>
												<?php } ?>
											<?php } ?>
										</div>	
										<?php } ?>

									<?php } ?>


									<?php /* SINGLE ACTIVITIES */ ?>
									<?php if ($single_activities) { ?>
										<?php foreach ($single_activities as $s) { 
											$id = $s->ID;
											$price = get_field("single_access_price",$id);
											if( $price ) {
												if (strpos($price, '$') !== false) {
													$price = $price;
												} else {
													$price = '$' . $price;
												}
											}
											$buy_link = get_field("single_buy_link",$id);
											$buy_btn = 'Purchase';
											$alt_title = get_field("page_alternative_title",$id);
											$activityName = ($alt_title) ? $alt_title : $s->post_title;
											// $buy_btn = ( isset($buy['title']) && $buy['title'] ) ? $buy['title']:'Purchase Pass';
											// $buy_link = ( isset($buy['url']) && $buy['url'] ) ? $buy['url']:'';
											// $buy_target = ( isset($buy['target']) && $buy['target'] ) ? $buy['target']:'_self';
											$noButton = ($buy_link) ? '':' nobutton';
										?>
										<div class="itemrow singleActivity<?php echo $noButton ?>">
											<span class="activity-name"><span><?php echo $activityName ?></span></span>
											<?php if ($price || $buy_btn) { ?>
												<span class="button-group">
													<span class="wrap">
														<span class="price"><?php echo ($price) ? $price:'<span class="spacer">N/A</span>'; ?></span>	
														<?php if ($buy_btn && $buy_link) { ?>
														<a href="<?php echo $buy_link ?>" target="_blank" class="btn-sm"><span><?php echo $buy_btn ?></span></a>
														<?php } ?>
													</span>
												</span>
											<?php } ?>
										</div>
										<?php } ?>
									<?php } ?>

								</div>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>

		</div>
	</section>
	<?php } ?>

	<?php  
	$parking_title = get_field("parking_title");
	$parking_text = get_field("parking_text");
	$parking_image = get_field("parking_image");
	$parking_button = get_field("parking_button");
	$parkBtnLink = ($parking_button) ? $parking_button['url']:'';
	$parkBtnName = ($parking_button) ? $parking_button['title']:'';
	$parkBtnTarget = ( isset($parking_button['target']) && $parking_button['target'] ) ? $parking_button['target']:'_self';
	$class2 = ( ($parking_title || $parking_text) && $parking_image ) ? 'half':'full';
	if($parking_title || $parking_text || $parking_image) { ?>
	<section id="parking" data-section="<?php echo $parking_title ?>" class="section-content sectionTwoCol <?php echo $class2 ?>">
		<div class="flexwrap">
			<?php if ($parking_image) { ?>
			<div class="imageCol">
				<div class="img" style="background-image:url('<?php echo $parking_image['url'] ?>');"><img src="<?php echo $blank_image ?>" alt="" aria-hidden="true" class="helper"></div>
			</div>	
			<?php } ?>

			<?php if ($parking_title || $parking_text) { ?>
			<div class="textCol">
				<div class="inner text-center">
					<?php if ($parking_title) { ?>
						<div class="shead-icon text-center">
							<div class="icon"><span class="ci-car"></span></div>
							<h2 class="stitle"><?php echo $parking_title ?></h2>
						</div>
					<?php } ?>
					<?php if ($parking_text) { ?>
						<div class="text"><?php echo $parking_text ?></div>
					<?php } ?>
					<?php if ($parking_button) { ?>
						<div class="buttondiv">
							<a href="<?php echo $parkBtnLink ?>" target="<?php echo $parkBtnTarget ?>" class="btn-sm"><span><?php echo $parkBtnName ?></span></a>
						</div>
					<?php } ?>
				</div>
			</div>	
			<?php } ?>
		</div>
	</section>
	<?php } ?>


	<?php  
	/* GIFT CARDS */
	$gc_title = get_field("gc_title");
	$gc_text = get_field("gc_text");
	$gc_image = get_field("gc_image");
	$gc_button = get_field("gc_button");
	$gcBtnLink = ($gc_button) ? $gc_button['url']:'';
	$gcBtnName = ($gc_button) ? $gc_button['title']:'';
	$gcBtnTarget = ( isset($gc_button['target']) && $gc_button['target'] ) ? $gc_button['target']:'_self';
	$class3 = ( ($gc_title || $gc_text) && $gc_image ) ? 'half':'full';
	if($gc_title || $gc_text || $gc_image) { ?>
	<section id="gc" data-section="<?php echo $gc_title ?>" class="section-content sectionTwoCol <?php echo $class3 ?>">
		<div class="flexwrap">
			<?php if ($gc_image) { ?>
			<div class="imageCol">
				<div class="img" style="background-image:url('<?php echo $gc_image['url'] ?>');"><img src="<?php echo $blank_image ?>" alt="" aria-hidden="true" class="helper"></div>
			</div>	
			<?php } ?>

			<?php if ($gc_title || $gc_text) { ?>
			<div class="textCol">
				<div class="inner text-center">
					<?php if ($gc_title) { ?>
						<div class="shead-icon text-center">
							<div class="icon"><span class="ci-gift-card"></span></div>
							<h2 class="stitle"><?php echo $gc_title ?></h2>
						</div>
					<?php } ?>
					<?php if ($gc_text) { ?>
						<div class="text"><?php echo $gc_text ?></div>
					<?php } ?>
					<?php if ($gc_button) { ?>
						<div class="buttondiv">
							<a href="<?php echo $gcBtnLink ?>" target="<?php echo $gcBtnTarget ?>" class="btn-sm"><span><?php echo $gcBtnName ?></span></a>
						</div>
					<?php } ?>
				</div>
			</div>	
			<?php } ?>
		</div>
	</section>
	<?php } ?>


	<?php 
	/* INSTRUCTIONS */  
	$instruction_title = get_field("instruction_title");
	$instruction_text = get_field("instruction_text");
	$instruction_image = get_field("instruction_image");
	$class4 = ( ($instruction_title || $instruction_text) && $instruction_image ) ? 'half':'full';
	if($instruction_title || $instruction_text || $instruction_image) { ?>
	<section id="instructions" data-section="<?php echo $instruction_title ?>" class="section-content sectionTwoCol <?php echo $class4 ?>">
		<div class="flexwrap">
			<?php if ($instruction_image) { ?>
			<div class="imageCol">
				<div class="img" style="background-image:url('<?php echo $instruction_image['url'] ?>');"><img src="<?php echo $blank_image ?>" alt="" aria-hidden="true" class="helper"></div>
			</div>	
			<?php } ?>

			<?php if ($instruction_title || $instruction_text) { ?>
			<div class="textCol">
				<div class="inner text-center">
					<?php if ($instruction_title) { ?>
						<div class="shead-icon text-center">
							<div class="icon"><span class="ci-team-hat"></span></div>
							<h2 class="stitle"><?php echo $instruction_title ?></h2>
						</div>
					<?php } ?>
					<?php if ($instruction_text) { ?>
						<div class="text"><?php echo $instruction_text ?></div>
					<?php } ?>


					<?php /* INSTRUCTIONS POSTS */ 
					$instructions_args = array(
						'posts_per_page'	=> -1,
						'post_type'				=> 'instructions',
						'post_status'			=> 'publish'
					);
					$instructions = get_posts($instructions_args);
					?>
					<div class="pricing text-center">
						<div class="pad">
							<?php if ($instructions) { ?>
							<div class="single-activities">

								<div class="inner-content">
									
									<?php if ($instructions) { ?>
										<?php foreach ($instructions as $s) { 
											$id = $s->ID;
											$activityName = $s->post_title;
											$price = get_field("price",$id);
											if( $price ) {
												if (strpos($price, '$') !== false) {
													$price = $price;
												} else {
													$price = '$' . $price;
												}
											}
											$buy_link = get_field("buy_button",$id);
											$buy_btn = 'Purchase';
											$noButton = ($buy_link) ? '':' nobutton';
										?>
										<div class="itemrow singleActivity<?php echo $noButton ?>">
											<span class="activity-name"><span><?php echo $activityName ?></span></span>
											<?php if ($price || $buy_btn) { ?>
												<span class="button-group">
													<span class="wrap">
														<span class="price"><?php echo ($price) ? $price:'<span class="spacer">N/A</span>'; ?></span>	
														<?php if ($buy_btn && $buy_link) { ?>
														<a href="<?php echo $buy_link ?>" target="_blank" class="btn-sm"><span><?php echo $buy_btn ?></span></a>
														<?php } ?>
													</span>
												</span>
											<?php } ?>
										</div>
										<?php } ?>
									<?php } ?>

								</div>
							</div>
							<?php } ?>
						</div>
					</div>

				</div>
			</div>	
			<?php } ?>
		</div>
	</section>
	<?php } ?>


	<?php  
	/* SUMMER CAMPS */
	$summer_title = get_field("summer_title");
	$summer_text = get_field("summer_text");
	$summer_image = get_field("summer_image");
	$summer_button = get_field("summer_button");
	$summerBtnLink = ($summer_button) ? $summer_button['url']:'';
	$summerBtnName = ($summer_button) ? $summer_button['title']:'';
	$summerBtnTarget = ( isset($summer_button['target']) && $summer_button['target'] ) ? $summer_button['target']:'_self';
	$sc_class = ( ($summer_title || $summer_text) && $summer_image ) ? 'half':'full';
	if($summer_title || $summer_text || $summer_image) { ?>
	<section id="summer-camps" data-section="<?php echo $summer_title ?>" class="section-content sectionTwoCol <?php echo $sc_class ?>">
		<div class="flexwrap">
			<?php if ($summer_image) { ?>
			<div class="imageCol">
				<div class="img" style="background-image:url('<?php echo $summer_image['url'] ?>');"><img src="<?php echo $blank_image ?>" alt="" aria-hidden="true" class="helper"></div>
			</div>	
			<?php } ?>

			<?php if ($summer_title || $summer_text) { ?>
			<div class="textCol">
				<div class="inner text-center">
					<?php if ($summer_title) { ?>
						<div class="shead-icon text-center">
							<div class="icon"><span class="ci-camp"></span></div>
							<h2 class="stitle"><?php echo $summer_title ?></h2>
						</div>
					<?php } ?>
					<?php if ($summer_text) { ?>
						<div class="text"><?php echo $summer_text ?></div>
					<?php } ?>
					<?php if ($summer_button) { ?>
						<div class="buttondiv">
							<a href="<?php echo $summerBtnLink ?>" target="<?php echo $summerBtnTarget ?>" class="btn-sm"><span><?php echo $summerBtnName ?></span></a>
						</div>
					<?php } ?>
				</div>
			</div>	
			<?php } ?>
		</div>
	</section>
	<?php } ?>


	<?php  
	/* ADVENTURE DINING */
	$adventure_title = get_field("adventure_title");
	$adventure_text = get_field("adventure_text");
	$adventure_image = get_field("adventure_image");
	$adventure_button = get_field("adventure_button");
	$adventureBtnLink = ($adventure_button) ? $adventure_button['url']:'';
	$adventureBtnName = ($adventure_button) ? $adventure_button['title']:'';
	$adventureBtnTarget = ( isset($adventure_button['target']) && $adventure_button['target'] ) ? $adventure_button['target']:'_self';
	$adv_class = ( ($adventure_title || $adventure_text) && $adventure_image ) ? 'half':'full';
	if($adventure_title || $adventure_text || $adventure_image) { ?>
	<section id="adventure-dining" data-section="<?php echo $adventure_title ?>" class="section-content sectionTwoCol <?php echo $adv_class ?>">
		<div class="flexwrap">
			<?php if ($adventure_image) { ?>
			<div class="imageCol">
				<div class="img" style="background-image:url('<?php echo $adventure_image['url'] ?>');"><img src="<?php echo $blank_image ?>" alt="" aria-hidden="true" class="helper"></div>
			</div>	
			<?php } ?>

			<?php if ($adventure_title || $adventure_text) { ?>
			<div class="textCol">
				<div class="inner text-center">
					<?php if ($adventure_title) { ?>
						<div class="shead-icon text-center">
							<div class="icon"><span class="ci-eat"></span></div>
							<h2 class="stitle"><?php echo $adventure_title ?></h2>
						</div>
					<?php } ?>
					<?php if ($adventure_text) { ?>
						<div class="text"><?php echo $adventure_text ?></div>
					<?php } ?>
					<?php if ($adventure_button) { ?>
						<div class="buttondiv">
							<a href="<?php echo $adventureBtnLink ?>" target="<?php echo $adventureBtnTarget ?>" class="btn-sm"><span><?php echo $adventureBtnName ?></span></a>
						</div>
					<?php } ?>
				</div>
			</div>	
			<?php } ?>
		</div>
	</section>
	<?php } ?>

</div><!-- #primary -->

<?php
include( locate_template('inc/pagetabs-script.php') );
get_footer();
