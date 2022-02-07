<?php
$postid = get_the_ID();
$status = get_field('registration_status');
$registerLink = get_field('registrationLink');
$regTarget = get_field('registrationLinkTarget');
$status_custom_message = get_field('status_custom_message');
$registerButton = 'Register';
$registerTarget = ( isset($regTarget[0]) && $regTarget[0]=='yes' ) ? '_blank':'_self'; ?>
<div class="hero-wrapper hero-register-button">
<?php if($status){ ?>
	<?php get_template_part("parts/subpage-banner"); ?>
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