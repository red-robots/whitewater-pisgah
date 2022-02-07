<?php 
	$placeholder = THEMEURI . 'images/rectangle.png';
	$post_type = get_post_type();
	$heroImage = get_field("full_image");
	$heroImageText = get_field("full_image_text");
	$flexbanner = get_field("flexslider_banner");
	$has_hero = 'no-banner';
	if($heroImage) {
		$has_hero = ($heroImage) ? 'has-banner':'no-banner';
	} else {
		if($flexbanner) {
			$has_hero = ($flexbanner) ? 'has-banner':'no-banner';
		}
	}

	$eventstatus = get_field("eventstatus");
	$eventStatus = ($eventstatus) ? strtoupper($eventstatus) : '';

if ( isset($_GET['display']) && $_GET['display']=='ajax' ) { ?>
	
<div id="content-info" class="content-full-info">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php
		$film_disclaimer = get_field("film_disclaimer");
		$film_trailer = get_field("film_trailer");
		$film_trailer_video_code = get_field("film_trailer_video_code");
		?>		
		<section class="text-centered-section">
			<div class="wrapper narrow text-center">
				<div class="modaltitleDiv text-center">
					<h5 class="modal-title"><?php the_title(); ?></h5>
				</div>
				<?php the_content(); ?>
			</div>
		</section>

		<?php
		$start_date = get_field("start_date");
		$event_time = get_field("event_time");
		$start_date = ($start_date) ? date('l, F jS Y',strtotime($start_date)) : '';
		$cost = get_field("cost");
		$weather = get_field("weather");
		$event_note = get_field("event_note");
		if($event_note) {
			if($event_time) {
				$event_time = $event_time . ' ' . '<div class="quick-note">'.$event_note.'</div>';
			} else {
				$event_time = $event_note;
			}
		}
		?>

		<section class="film-event-details full">
			<div class="wrapper narrow">
				<div class="shead-icon text-center">
					<h2 class="stitle">EVENT DETAILS</h2>
				</div>

				<div class="details">
					<?php if ($start_date) { ?>
					<div class="info date cap">
						<div class="sub">Date</div>
						<div class="val"><?php echo $start_date ?></div>
					</div>	
					<?php } ?>

					<?php if ($event_time) { ?>
					<div class="info time cap">
						<div class="sub">Time</div>
						<div class="val"><?php echo $event_time ?></div>
					</div>	
					<?php } ?>

					<?php if ($cost) { ?>
					<div class="info cost cap">
						<div class="sub">Cost</div>
						<div class="val"><?php echo $cost ?></div>
					</div>	
					<?php } ?>

					<?php if ($weather) { ?>
					<div class="info">
						<div class="sub">Weather</div>
						<div class="val"><?php echo $weather ?></div>
					</div>	
					<?php } ?>
				</div>
			</div>
		</section>

		<?php if ($film_disclaimer) { ?>
		<div class="film-disclaimer">
			<div class="wrapper"><?php echo $film_disclaimer ?></div>
		</div>	
		<?php } ?>
	<?php endwhile; ?>
</div>

<?php } else { ?>

	<?php
	get_header(); 
	get_template_part("parts/subpage-banner");
	?>

	<div id="primary" class="content-area-full film-series-page <?php echo $has_banner ?>">
		<main id="main" class="site-main full" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php
				$film_disclaimer = get_field("film_disclaimer");
				$film_trailer = get_field("film_trailer");
				$film_trailer_video_code = get_field("film_trailer_video_code");
				?>
				<section class="text-centered-section">
					<div class="wrapper narrow text-center">
						<div class="page-header">
							<h1 class="page-title"><?php the_title(); ?></h1>
						</div>
						<?php the_content(); ?>
						<?php if ($film_trailer_video_code) { ?>
						<div class="video-frame">
							<?php echo $film_trailer_video_code ?>
							<img src="<?php echo $placeholder ?>" alt="" aria-hidden="true" class="helper">		
						</div>	
						<?php } ?>
					</div>
				</section>

				<?php if ($film_disclaimer) { ?>
				<div class="film-disclaimer">
					<div class="wrapper"><?php echo $film_disclaimer ?></div>
				</div>	
				<?php } ?>

				<?php
				$start_date = get_field("start_date");
				$event_time = get_field("event_time");
				$start_date = ($start_date) ? date('l, F jS Y',strtotime($start_date)) : '';
				$cost = get_field("cost");
				$weather = get_field("weather");
				$event_note = get_field("event_note");
				if($event_note) {
					if($event_time) {
						$event_time = $event_time . ' ' . '<div class="quick-note">'.$event_note.'</div>';
					} else {
						$event_time = $event_note;
					}
				}
				?>


				<section class="film-event-details full">
					<div class="wrapper narrow">
						<div class="shead-icon text-center">
							<div class="icon"><span class="ci-menu"></span></div>
							<h2 class="stitle">EVENT DETAILS</h2>
						</div>

						<div class="details">
							<?php if ($start_date) { ?>
							<div class="info date cap">
								<div class="sub">Date</div>
								<div class="val"><?php echo $start_date ?></div>
							</div>	
							<?php } ?>

							<?php if ($event_time) { ?>
							<div class="info time cap">
								<div class="sub">Time</div>
								<div class="val"><?php echo $event_time ?></div>
							</div>	
							<?php } ?>

							<?php if ($cost) { ?>
							<div class="info cost cap">
								<div class="sub">Cost</div>
								<div class="val"><?php echo $cost ?></div>
							</div>	
							<?php } ?>

							<?php if ($weather) { ?>
							<div class="info">
								<div class="sub">Weather</div>
								<div class="val"><?php echo $weather ?></div>
							</div>	
							<?php } ?>
						</div>
					</div>
				</section>

			<?php endwhile; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php /* EXPLORE OTHER ACTIVITIES */ ?>
	<?php get_template_part("parts/similar-posts"); ?>

<?php
get_footer();

} ?>