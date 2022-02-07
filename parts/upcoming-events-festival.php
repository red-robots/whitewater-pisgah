<section class="homerow row3 wow fadeIn">

<?php
/*===== ROW 2 =====*/
$row3_title = get_field('row3_title');  
$row3_button_name = get_field('row3_button_name');  
$row3_button_link = get_field('row3_button_link');  
$blank_image = THEMEURI . "images/square.png";
?>

<?php if ($row3_title) { ?>
	<div class="title-area full">
		<?php if ($row3_title) { ?>
		<div class="wrapper inner-content text-center">

			<div class="shead-icon text-center">
				<div class="icon"><span class="ci-calendar-alt"></span></div>
				<h2 class="stitle"><?php echo $row3_title ?></h2>
			</div>
			
			<?php if ($row3_button_name && $row3_button_link) { ?>
			<div class="buttondiv">
				<a href="<?php echo $row3_button_link['url'] ?>" target="<?php echo $row3_button_link['target'] ?>" class="btn-sm"><span><?php echo $row3_button_name ?></span></a>
			</div>	
			<?php } ?>
		</div>
		<?php } ?>
	</div>
<?php } ?>


<?php
// $postype = 'festival';
// $args = array(
// 	'posts_per_page'=> 8,
// 	'post_type'		=> array('festival','music','race'),
// 	'post_status'	=> 'publish',
// 	'meta_key'		=> 'show_on_homepage',
// 	'meta_value'	=> 'yes'
// );
// $posts = new WP_Query($args);
$rectangle = get_bloginfo('template_url') . '/images/rectangle-narrow.png';
$square = get_bloginfo('template_url') . '/images/square.png';
$events = array('festival','music','race');
$results = getUpcomingEvents($events,9);
if ( $results ) {  
$dateNow = date('Y-m-d');
?>
<div class="featured-events-section full">
	<div class="wrapper-full">
		<div class="flexwrap">
		<?php $i=1; foreach( $results as $row ) {  
			$pid = $row['ID'];
			$title = get_the_title($pid);
			$pagelink = get_permalink($pid);
			$thumbImage = get_field("full_image",$pid);
			$mobileBannerImg = get_field("mobile-banner",$pid);
			$mobileImage2 = get_field("mobile_image",$pid);

			$mobileThumbURL = '';
			$mobileThumbALT = '';
			if($mobileBannerImg) {
				$mobileThumbURL = $mobileBannerImg['url'];
				$mobileThumbALT = $mobileBannerImg['title'];
			} else {
				if($mobileImage2) {
					$mobileThumbURL = $mobileImage2['url'];
					$mobileThumbALT = $mobileImage2['title'];
				}
			}

			$start = get_field("start_date",$pid);
			$end = get_field("end_date",$pid);
			$event_date = get_event_date_range($start,$end);
			?>
			<div class="postbox view-full <?php echo ($thumbImage) ? 'has-image':'no-image' ?>">
				<a href="<?php echo $pagelink ?>" class="inside boxlink wave-effect">
					
					<?php if ($mobileThumbURL) { ?>
						<div class="imagediv image-square">
							<div class="img" style="background-image:url('<?php echo $mobileThumbURL ?>')">
								<img src="<?php echo $square ?>" alt="" class="feat-img placeholder no-image">
								<img src="<?php echo $mobileThumbURL ?>" alt="<?php echo $mobileThumbALT ?>" class="feat-img image-square" style="display:none!important;">
							</div>
						</div>
					<?php } else { ?>
						<div class="imagediv noImage">
							<img src="<?php echo $square ?>" alt="" class="feat-img placeholder no-image">
						</div>
					<?php } ?>

					<div class="details">
						<div class="info">
							<div class="event-name"><?php echo $title ?></div>
							<?php if ($event_date) { ?>
							<div class="event-date"><?php echo $event_date ?></div>
							<?php } ?>
						</div>
					</div>
					<span class="wave">
						<svg class="waveSvg" shape-rendering="auto" preserveAspectRatio="none" viewBox="0 24 150 28" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><defs><path id="a" d="m-160 44c30 0 58-18 88-18s58 18 88 18 58-18 88-18 58 18 88 18v44h-352z"/></defs><g class="waveAnimation"><use x="85" y="5" xlink:href="#a"/></g></svg>
					</span>
				</a>
			</div>
		<?php $i++; } wp_reset_postdata(); ?>
		</div>
	</div>
</div>
<?php } ?>

</section>
