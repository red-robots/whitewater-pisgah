<?php
/**
 * Template Name: Buy
 */

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

	$single_access_hide = get_field("hide_section");
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
									// need ability to hide and showd
									$show = get_field("show_on_buy_page",$pid);
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
												<a href="<?php echo $buttonLink ?>" target="<?php echo $buttonTarget ?>" class="btn-sm"><span><?php echo $buttonName ?></span></a>
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
			</div>
			<?php } ?>

			<?php /* SINGLE ACTIVITY PASSES */ ?>
			<?php 
			if( $single_access_hide != 'hide' ):
			if ($single_access_title || $single_access_text) { ?>
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
														),
						'meta_query'			=> array(
													'relation' => 'OR',
													array(
														'key' => 'doNotShow',
														'compare' => 'NOT EXISTS',
													),
													array(
														'key' => 'doNotShow',
														'value'		=> '',
														'compare' => '='
													),
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
											if($price) { ?>
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
									<?php } ?>

								</div>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<?php }
			 endif;  ?>

		</div>
	</section>
	<?php } ?>


	<?php if( $blocks = get_field("repeater_blocks") ) { $i=1;
		 	foreach($blocks as $e) {  
		 		$title = $e['title'];
		 		$text = $e['text'];
				$sectionId = ($title) ? sanitize_title($e['title']) : 'content-row-' . $i; 
				$image = $e['image'];
				$bgsize = ($e['image_bgsize']) ? $e['image_bgsize'] : 'cover';
				$button = $e['button'];
				$buttonTarget = ( isset($button['target']) && $button['target'] ) ? $button['target'] : '_self';
				$icon = $e['custom_icon'];
				$sectionClass = ( ($title || $text) && $image ) ? 'half':'full';
				?>
				<section id="<?php echo $sectionId ?>" data-section="<?php echo $title ?>" class="section-content sectionTwoCol <?php echo $sectionClass ?>">
					<div class="flexwrap">
						<?php if ($image) { ?>
						<div class="imageCol">
							<div class="img" style="background-image:url('<?php echo $image['url'] ?>');background-size:<?php echo $bgsize ?>"><img src="<?php echo $blank_image ?>" alt="" aria-hidden="true" class="helper"></div>
						</div>	
						<?php } ?>

						<?php if ($title || $text) { ?>
						<div class="textCol">
							<div class="inner text-center">
								<?php if ($title) { ?>
									<div class="shead-icon text-center">
										<?php if ($icon) { ?>
										<div class="icon"><span class="<?php echo $icon ?>"></span></div>
										<?php } ?>
										<h2 class="stitle"><?php echo $title ?></h2>
									</div>
								<?php } ?>
								<?php if ($text) { ?>
									<div class="text"><?php echo $text ?></div>
								<?php } ?>
								<?php if ($button) { ?>
									<div class="buttondiv">
										<a href="<?php echo $button['url'] ?>" target="<?php echo $buttonTarget ?>" class="btn-sm"><span><?php echo $button['title'] ?></span></a>
									</div>
								<?php } ?>
							</div>
						</div>	
						<?php } ?>

					</div>
				</section>
		<?php $i++; } ?>
	<?php } ?>

</div><!-- #primary -->

<?php
include( locate_template('inc/pagetabs-script.php') );
get_footer();
