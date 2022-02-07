<?php
/**
 * Template Name: Activity Passes
 */

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
								// need ability to hide and showd
								$show = get_field("show_on_activities_page",$pid);
								// echo '<pre>';
								// print_r($show);
								// echo '</pre>';
								$buyButton = get_field("purchase_button",$pid);
								$buttonName = (isset($buyButton['title']) && $buyButton['title']) ? $buyButton['title']:'Purchase Pass';
								$buttonLink = (isset($buyButton['url']) && $buyButton['url']) ? $buyButton['url']:'';
								$buttonTarget = (isset($buyButton['target']) && $buyButton['target']) ? $buyButton['target']:'_self';

								if( $show == 'show' ) {
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
					$single_activities = get_single_activity_passes_list('default'); /* see inc/func-activity-passes.php */
					?>
					<div class="info text-center">
						
						<?php if ($single_access_title) { ?>
							<h2 class="stitle"><?php echo $single_access_title ?></h2>
						<?php } ?>
						<?php if ($single_access_text) { ?>
							<div class="text"><?php echo $single_access_text ?></div>
						<?php } ?>

						<?php if ($single_activities) { ?>
						<div class="single-activities">
							<?php foreach ($single_activities as $e) { 
								$s_custom = ( isset($e['custom']) && $e['custom'] ) ? $e['custom'] : '';
								$s_price = ( isset($e['price']) && $e['price'] ) ? $e['price'] : '';
								$s_name = ( isset($e['name']) && $e['name'] ) ? $e['name'] : '';
								$s_id = ( isset($e['id']) && $e['id'] ) ? $e['id'] : '';
								$buy = ( isset($e['button']) && $e['button'] ) ? $e['button'] : '';
								$buy_btn = ( isset($buy['title']) && $buy['title'] ) ? $buy['title']:'Purchase';
								$buy_link = ( isset($buy['url']) && $buy['url'] ) ? $buy['url']:'';
								$buy_target = ( isset($buy['target']) && $buy['target'] ) ? $buy['target']:'_self';
								$title_slug = sanitize_title($s_name);
								$item_class = ($s_custom) ? 'other-activity':'singleActivity';
								$item_id = ($s_custom) ? "custom-" . $title_slug : 'post-activity-' . $s_id;
								?>
								<div id="<?php echo $item_id?>" class="itemrow <?php echo $item_class?>">
									<span class="activity-name"><span><?php echo $s_name ?></span></span>
									<?php if ($s_price || $buy_btn) { ?>
										<span class="button-group">
											<span class="wrap">
												<?php if ($s_price) { ?>
												<span class="price"><?php echo $s_price ?></span>	
												<?php } ?>
												<?php if ($buy_btn && $buy_link) { ?>
												<a href="<?php echo $buy_link ?>" target="<?php echo $buy_target ?>" class="btn-sm xs"><span><?php echo $buy_btn ?></span></a>
												<?php } ?>
											</span>
										</span>
									<?php } ?>
								</div>
							<?php } ?>
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
	$activities_args['meta_query'] = array(
																		'relation' => 'OR',
																	array(
																		'key' => 'doNotShow',
																		'compare' => 'NOT EXISTS',
																	),
																	array(
																		'key' => 'doNotShow',
																		'value'		=> '',
																		'compare' => '='
																	)
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
						<a href="<?php the_permalink(); ?>" class="photo wave-effect js-blocks">
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
						</a>
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
