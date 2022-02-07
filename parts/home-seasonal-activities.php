<?php  
$row5_columns = get_field("row5_columns");
$icon_placeholder = THEMEURI . "images/square.png";
$blank_image = THEMEURI . "images/rectangle.png";
if($row5_columns) { 
$has_content = array();
foreach ($row5_columns as $c) { 
	$title = $c['title'];
	$description = $c['description'];
	if($title || $description) {
		$has_content[] = array($title,$description);
	}
}
if($has_content) { ?>
<section id="section-seasonal" class="homerow row5">
	<div class="wrapper-full">
		<div class="flexwrap">
		<?php foreach ($row5_columns as $c) { 
			$icon = $c['icon'];
			$title = $c['title'];
			$description = $c['description'];
			$buttonName = $c['button_text'];
			$buttonLink = $c['button_link'];
			$featured_image = $c['featured_image'];
			if($title || $description) { ?>
			<div class="infocol seasonal-event">
				<div class="inside">

					<div class="details">
						<?php if ($icon) { ?>
						<div class="icon-img"><span style="background-image:url('<?php echo $icon['url'] ?>')"></span></div>
						<?php } ?>

						<?php if ($title) { ?>
						<h2 class="stitle"><?php echo $title ?></h2>
						<?php } ?>

						<?php if ($description) { ?>
						<div class="description"><?php echo $description ?></div>
						<?php } ?>

						<?php if ($buttonName && $buttonLink) { $target = ($buttonLink['target']) ? ' target="'.$buttonLink['target'].'"':''; ?>
						<div class="button"><a href="<?php echo $buttonLink['url'] ?>"<?php echo $target; ?> class="btn-sm"><span><?php echo $buttonName ?></span></a></div>
						<?php } ?>
					</div>

					<?php if ($featured_image) { ?>
					<div class="featured-image">
						<div class="img" style="background-image:url('<?php echo $featured_image['url']; ?>')"></div>
						<img src="<?php echo $blank_image ?>" alt="" aria-hidden="true">
					</div>
					<div class="mirror-image" style="background-image:url('<?php echo $featured_image['url']; ?>')"><img src="<?php echo $blank_image ?>" alt="" aria-hidden="true"></div>
					<?php } ?>
				</div>
			</div>
			<?php } ?>
		<?php } ?>
		</div>
	</div>
</section>
<?php } ?>
<?php } ?>