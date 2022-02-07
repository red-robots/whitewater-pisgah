<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package bellaworks
 */

get_header(); 
$post_type = get_post_type();
$heroImage = get_field("post_image_full");
$has_hero = ($heroImage) ? 'has-banner':'no-banner';
//$customPostTypes = array('activity','festival');
//get_template_part("parts/subpage-banner");
$post_id = get_the_ID(); 
$registerLink = get_field('adventure_dining_register_link','option');
$registerButton = ( isset($registerLink['title']) && $registerLink['title'] ) ? $registerLink['title'] : '';
$registerLink = ( isset($registerLink['url']) && $registerLink['url'] ) ? $registerLink['url'] : '';
$registerTarget = ( isset($registerLink['target']) && $registerLink['target'] ) ? $registerLink['target'] : '_self';

$registration_status = get_field("registration_status",$post_id); 
$status = ($registration_status) ? $registration_status : 'open';
$blank_image = THEMEURI . "images/square.png";
$status_custom_message = get_field("status_custom_message");
?>
	
<div id="primary" class="content-area-full content-default single-post <?php echo $has_hero;?> post-type-<?php echo $post_type;?>">

		<?php if ($heroImage) { ?>
		<div class="post-hero-image">
			<?php if ($status=='open') { ?>

				<?php if ($registerButton && $registerLink) { ?>
					<div class="stats open"><a href="<?php echo $registerLink ?>" target="<?php echo $registerTarget ?>" class="registerBtn"><?php echo $registerButton ?></a></div>
				<?php } ?>
			<?php } else if($status=='closed') { ?>
			<div class="stats closed">SOLD OUT</div>
			<?php } else if($status=='custom') { ?>

				<?php if ($status_custom_message) { ?>
				<div class="stats closed custom-message-banner"><div class="innerTxt"><?php echo $status_custom_message ?></div></div>
				<?php } ?>
			
			<?php } ?>
			<img src="<?php echo $heroImage['url'] ?>" alt="<?php echo $heroImage['title'] ?>" class="featured-image">
		</div>
		<?php } ?>

		<main id="main" data-postid="post-<?php the_ID(); ?>" class="site-main" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				
				<?php
				$short_description = get_the_content();
				if($short_description) { ?>
				<section class="text-centered-section">
					<div class="wrapper text-center">
						<div class="page-header">
							<h1 class="page-title"><?php the_title(); ?></h1>
						</div>
						<?php echo anti_email_spam($short_description); ?>
					</div>
				</section>
				<?php } ?>

				<?php get_template_part("parts/subpage-tabs"); ?>

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

			<?php endwhile; ?>
		</main>
	</div>
<?php
include( locate_template('inc/pagetabs-script.php') ); 
get_footer();