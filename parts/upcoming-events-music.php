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
			<div class="icondiv"><span class="calendar"></span></div>
			<h2 class="stitle"><?php echo $row3_title ?></h2>
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
$args = array(
	'numberposts'	=> -1,
	'post_type'		=> 'music',
	'post_status'	=> 'publish',
	'meta_key'		=> 'show_on_homepage',
	'meta_value'	=> 'yes'
);
$posts = new WP_Query($args);
if ( $posts->have_posts() ) {  
$count = $posts->found_posts;	
$dateNow = date('Y-m-d');
?>
<div class="featured-events-section full">
	<div class="wrapper-full">
		<div class="flexwrap">
		<?php $i=1; while ( $posts->have_posts() ) : $posts->the_post();  
			$title = get_the_title();
			$pagelink = get_permalink();
			$thumbImage = get_field("thumbnail_image");
			$start = get_field("start_date");
			$end = get_field("end_date");
			$event_date = get_event_date_range($start,$end);
			?>
			<div class="postbox <?php echo ($thumbImage) ? 'has-image':'no-image' ?>">
				<a href="<?php echo $pagelink ?>" class="inside boxlink">
					<?php if ($thumbImage) { ?>
						<div class="imagediv" style="background-image:url('<?php echo $thumbImage['url'] ?>')"></div>
						<img src="<?php echo $thumbImage['url']; ?>" alt="<?php echo $thumbImage['title'] ?>" class="feat-img">
					<?php } else { ?>
						<img src="<?php echo $blank_image ?>" alt="" class="feat-img no-image">
					<?php } ?>
					<div class="details">
						<div class="info">
							<div class="event-name"><?php echo $title ?></div>
							<?php if ($event_date) { ?>
							<div class="event-date"><?php echo $event_date ?></div>
							<?php } ?>
						</div>

						<div class="wave">
							<div class="wave-svg"></div>
						</div>

					</div>
				</a>
			</div>
		<?php $i++; endwhile; wp_reset_postdata(); ?>
		</div>
	</div>
</div>
<?php } ?>

</section>
