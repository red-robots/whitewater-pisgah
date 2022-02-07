<?php
$heroImage = get_field("full_image");
$status = get_field('registration_status');
$registerLink = get_field('registrationLink');
$regTarget = get_field('registrationLinkTarget');
$status_custom_message = get_field('status_custom_message');
$registerButton = 'Register';
$registerTarget = ( isset($regTarget[0]) && $regTarget[0]=='yes' ) ? '_blank':'_self';
$has_red_tag = false;
$excludePostTypes = exclude_post_types_banner();
if ( is_singular( get_post_type() ) && in_array(get_post_type(),$excludePostTypes) ) {
	$show_slide = false;
	if($status) {
		$has_red_tag = true;
	}
}

$eventstatus = get_field("eventstatus");
$eventStatus = ($eventstatus) ? strtoupper($eventstatus) : '';
$heroImageText = get_field("full_image_text");
$single_post_hero = '';

$fieldtrip_banner = get_field("fieldtrip_featured_image");
if($fieldtrip_banner) {
	$heroImage = $fieldtrip_banner;
}

// if (empty($heroImageText)) {
// 	if ($eventStatus) {
// 		echo '<div class="film-event-status"><div class="wrapper">'.$eventStatus.'</div></div>';
// 	}
// }
if ($eventStatus && $eventstatus!='upcoming') {
	echo '<div class="film-event-status"><div class="wrapper">'.$eventStatus.'</div></div>';
}
ob_start(); 
if($heroImage) { ?>
<div id="banner" class="subpageBanner">
	<div class="slides-wrapper static-banner">
		<ul class="slides">
			<li class="slideItem type-image">
				<div class="image-wrapper yes-mobile" style="background-image: url('<?php echo $heroImage['url']?>');">
					<img class="desktop " src="<?php echo $heroImage['url']?>" alt="<?php echo $heroImage['title']?>">
				</div>
				<?php if ($heroImageText) { ?>
				<div class="slideCaption"><div class="text"><?php echo $heroImageText ?></div></div>
				<?php } ?>
			</li>
		</ul>
	</div>
</div>
<?php } 
$single_post_hero = ob_get_contents();
ob_end_clean();
?>

<?php

if($has_red_tag) { ?>
<div class="hero-wrapper hero-register-button<?php echo ($eventStatus) ? ' has-event-status':''; ?>">
<?php if($status){ ?>

	<?php echo $single_post_hero; ?>

	<?php if ($status=='open') { ?>
		<?php if ($registerButton && $registerLink) { ?>
			<div class="stats open"><a href="<?php echo $registerLink ?>" target="<?php echo $registerTarget ?>" class="registerBtn"><?php echo $registerButton ?></a></div>
		<?php } ?>
	<?php } else if($status=='closed') { ?>
		<div class="stats closed">SOLD OUT</div>
	<?php } else if($status=='custom') { ?>

		<?php if ($status_custom_message) { ?>
		<div class="stats closed"><?php echo $status_custom_message ?></div>
		<?php } ?>

	<?php } ?>
<?php } ?>
</div>

<?php } else {
	echo $single_post_hero;
} ?>