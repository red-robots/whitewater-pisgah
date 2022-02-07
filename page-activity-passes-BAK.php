<?php
get_header(); 
$blank_image = THEMEURI . "images/rectangle.png";
$square = THEMEURI . "images/square.png";
$banner = get_field("flexslider_banner");
$has_banner = ($banner) ? 'hasbanner':'nobanner';
?>

<div id="primary" data-post="<?php echo get_the_ID()?>" class="content-area-full page-activity-passes <?php echo $has_banner ?>">

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
	<section class="twoColSection <?php echo $class1 ?>">
		<div class="twoColInner">
				
			<?php /* ALL ACCESS PASSES */ ?>
			<?php if ($all_access_title || $all_access_text) { ?>
			<div id="section1" data-section="<?php echo $all_access_title ?>" class="tcol <?php echo ($all_access_feat_image) ? 'hasphoto':'nophoto' ?>">
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
						<?php if ($all_access_title) { ?>
							<h2 class="stitle"><?php echo $all_access_title ?></h2>
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
										<div class="young-price pr">Youth &ndash; <?php echo $young ?></div>	
										<?php } ?>

										<?php if ($buttonName && $buttonLink) { ?>
										<div class="buttondiv">
											<a href="<?php echo $buttonLink ?>" target="<?php echo $buttonTarget ?>" class="btn-sm xs"><span><?php echo $buttonName ?></span></a>
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
			<?php } ?>


			<?php /* SINGLE ACTIVITY PASSES */ ?>
			<?php if ($single_access_title || $single_access_text) { ?>
			<div id="section2" data-section="<?php echo $single_access_title ?>" class="tcol <?php echo ($single_access_feat_image) ? 'hasphoto':'nophoto' ?>">
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
						<?php if ($single_access_title) { ?>
							<h2 class="stitle"><?php echo $single_access_title ?></h2>
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
										$otherName = $e['title'];
										$buy = $e['purchase_button'];
										$price = $e['price'];
										$buy_btn = ( isset($buy['title']) && $buy['title'] ) ? $buy['title']:'Purchase';
										$buy_link = ( isset($buy['url']) && $buy['url'] ) ? $buy['url']:'';
										$buy_target = ( isset($buy['target']) && $buy['target'] ) ? $buy['target']:'_self';
										if($otherName) {  $title_slug = sanitize_title($otherName); ?>
										<div id="custom-<?php echo $title_slug?>" class="itemrow other-activity">
											<?php if ($e['title']) { ?>
												<span class="activity-name"><span><?php echo $e['title'] ?></span></span>

												<?php if ($price || $buy_btn) { ?>
												<span class="button-group">
													<span class="wrap">
														<?php if ($price) { ?>
														<span class="price"><?php echo $price ?></span>	
														<?php } ?>
														<?php if ($buy_btn && $buy_link) { ?>
														<a href="<?php echo $buy_link ?>" target="<?php echo $buy_target ?>" class="btn-sm xs"><span><?php echo $buy_btn ?></span></a>
														<?php } ?>
													</span>
												</span>
												<?php } ?>
											<?php } ?>
										</div>
										<?php } ?>
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
										$noButton = ($buy_link) ? '':' nobutton';
										if($price || ($buy_btn && $buy_link)) { ?>
										<div id="item_activity_<?php echo $id ?>" class="itemrow singleActivity<?php echo $noButton ?>">
											<span class="activity-name"><span><?php echo $activityName ?></span></span>
											<?php if ($price || $buy_btn) { ?>
												<span class="button-group">
													<span class="wrap">
														<span class="price"><?php echo ($price) ? $price:''; ?></span>	
														<?php if ($buy_btn && $buy_link) { ?>
														<a href="<?php echo $buy_link ?>" target="_blank" class="btn-sm xs"><span><?php echo $buy_btn ?></span></a>
														<?php } ?>
													</span>
												</span>
											<?php } ?>
										</div>
										<?php } ?>
									<?php } ?>
								<?php } ?>

							</div>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
			<?php } ?>

		</div>
	</section>
	<?php } ?>


	<?php
	$activities_args = array(
		'posts_per_page'	=> -1,
		'post_type'				=> 'activity',
		'post_status'			=> 'publish'
	);
	$activities = new WP_Query($activities_args);
	$activities_section_title = get_field("activities_section_title");
	$sectionTitle = ($activities_section_title) ? $activities_section_title : '';
	if( $activities->have_posts() ) { ?>
	<section id="section-activities" data-section="Activities" class="section-content camp-activities">
			<?php if ($sectionTitle) { ?>
				<div class="wrapper titlediv">
					<div class="shead-icon text-center">
						<h2 class="stitle"><?php echo $sectionTitle ?></h2>
					</div>
				</div>
			<?php } ?>

			<div class="entryList flexwrap">
				<?php while ( $activities->have_posts()) : $activities->the_post(); 
					$imgType = get_field("flexslider_banner");
					$thumbnail = '';
					$video_iframe = '';
					$featuredType = '';
					if($imgType) {
						$row = $imgType[0];
						$i_type = $row['video_or_image'];
						$featuredType = $i_type;
						if($i_type=='image') {
							$thumbnail = $row['image']['url'];
						}
						else if($i_type=='video') {
							$video_iframe = $row['video'];
						}
					}

					$entryClass = ($thumbnail || $video_iframe) ? 'hasImage':'noImage';
				?>
				<div id="entryBlock<?php echo $i?>" class="fbox activity-blocks <?php echo $entryClass; ?>">
					<div class="inside text-center">
						<div class="imagediv <?php echo ($entryClass) ? 'hasImage':'noImage'?>">
							<?php if ($featuredType=='image') { ?>
								<?php if ($thumbnail) { ?>
									<span class="img" style="background-image:url('<?php echo $thumbnail?>')"></span>
								<?php } ?>
							<?php } else if($featuredType=='video') { ?>
								<?php if ($video_iframe) { ?>
									<?php echo $video_iframe ?>
								<?php } ?>
							<?php } ?>
							<img src="<?php echo $blank_image ?>" alt="" aria-hidden="true" class="placeholder">
						</div>
						<div class="titlediv">
							<p class="name"><?php the_title(); ?></p>
							<div class="buttondiv">
								<a href="<?php echo get_permalink(); ?>" class="btn-sm xs"><span>See Details</span></a>
							</div>
						</div>
					</div>
				</div>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
			
		</div>
	</section>
	<?php } ?>


	<?php
	$customFAQTitle = 'FAQ';
	$customFAQClass = 'custom-class-faq';
	include( locate_template('parts/content-faqs.php') );
	include( locate_template('inc/faqs.php') );
	?>


</div><!-- #primary -->

<?php
include( locate_template('inc/pagetabs-script.php') );
get_footer();
