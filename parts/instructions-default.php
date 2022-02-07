<?php 
$placeholder = THEMEURI . 'images/rectangle.png';
$options[] = array('Price',get_field("price"));
$options[] = array('Ages',get_field("ages"));
$options[] = array('Duration',get_field("duration"));
$options[] = array('Ratio',get_field("ratio"));
?>

<section class="section-price-ages full">
	<div class="flexwrap fourCols">
		<?php foreach ($options as $opt) { 
		$class = sanitize_title($opt[0]); ?>
		<div class="info <?php echo $class ?>">
			<div class="wrap">
				<div class="label"><?php echo $opt[0] ?></div>
				<div class="val"><?php echo $opt[1] ?></div>
			</div>
		</div>
		<?php } ?>
	</div>
</section>
<?php
	$register = get_field("registration_link");
	$registerBtn = ( isset($register['title']) && $register['title'] ) ? $register['title'] : 'Register';
	$registerLink = ( isset($register['url']) && $register['url'] ) ? $register['url'] : '';
	$regiserTarget = ( isset($register['target']) && $register['target'] ) ? $register['target'] : '_self';
?>
<?php if ($registerLink) { ?>
<section id="section-registration" class="section-content section-full-button">
	<a href="<?php echo $registerLink ?>" target="<?php echo $regiserTarget ?>" class="red-button-full stitle"><span><?php echo $registerBtn ?></span></a>
</section>
<?php } ?>

<?php $schedule_items = get_field("schedule_items"); ?>
<?php if ($schedule_items) { ?>
<section id="section-schedule" data-section="SCHEDULE" class="section-schedule section-content">
	<div class="wrapper">
		<div class="shead-icon text-center">
			<div class="icon"><span class="ci-menu"></span></div>
			<h2 class="stitle">SCHEDULE</h2>
		</div>
		<div class="schedules-list">
			<ul class="items">
				<?php foreach ($schedule_items as $s) { 
					$has_full_info = ($s['dates'] && $s['time']) ? 'has-dash':'no-dash';
					?>
					<li class="item <?php echo $has_full_info ?>">
						<?php if ($s['dates'] && $s['time']) { ?>
							<div class="dates"><span><?php echo $s['dates'] ?></span></div>
							<div class="time"><?php echo $s['time'] ?></div>
							<div class="event"><?php echo $s['event'] ?></div>
						<?php } else { ?>
							<?php if ( empty($s['time']) && $s['dates'] ) { ?>
							<div class="time"><?php echo $s['dates'] ?></div>
							<?php } else if ( empty($s['dates']) && $s['time'] ) { ?>
							<div class="time"><?php echo $s['time'] ?></div>
							<?php } ?>
							<?php if ($s['event']) { ?>
								<div class="event"><?php echo $s['event'] ?></div>
							<?php } ?>
						<?php } ?>
					</li>
				<?php } ?>
			</ul>
		</div>
	</div>	
</section>
<?php } ?>

<?php if( $galleries = get_field("gallery") ) { ?>
<section id="section-galleries" class="section-content">
	<div id="carousel-images">
		<div class="loop owl-carousel owl-theme">
		<?php foreach ($galleries as $g) { ?>
			<div class="item">
				<div class="image" style="background-image:url('<?php echo $g['url']?>')">
					<img src="<?php echo $placeholder ?>" alt="" aria-hidden="true" />
				</div>
			</div>
		<?php } ?>
		</div>
	</div>
</section>
<?php } ?>


<?php if( $information = get_field("information_content") ) { ?>
<section id="information-content" data-section="Information" class="section-content gray">
	<div class="wrapper">
		<div class="shead-icon text-center">
			<div class="icon"><span class="ci-info"></span></div>
			<h2 class="stitle">Information</h2>
		</div>
		<div class="text-wrap text-center">
			<?php foreach ($information as $e) { ?>
			<div class="text">
				<?php if ($e['title']) { ?>
					<div class="t1"><?php echo $e['title'] ?></div>
				<?php } ?>
				<?php if ($e['text']) { ?>
					<div class="t2"><?php echo $e['text'] ?></div>
				<?php } ?>
			</div>	
			<?php } ?>
		</div>
	</div>
</section>
<?php } ?>




