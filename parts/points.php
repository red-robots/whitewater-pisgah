<?php 
/* CHECK-IN */
$rectangle = THEMEURI . "images/rectangle.png";
$square = THEMEURI . "images/square.png";
$checkin_images = array();
$checkin_rows = array();

if( have_rows('points_of_interest') ): while( have_rows('points_of_interest') ): the_row();
	$s4_title = get_sub_field("whereto_section_title");
	$section4 = ($s4_title) ? $s4_title : 'Check-In';
	if( have_rows('box_content') ): 
		$ctr=0; 
		while( have_rows('box_content') ): the_row();
			$has_text = get_sub_field('has_text'); 
			$has_text = ($has_text=='yes') ? true : false;
			$text = get_sub_field('flex_content'); 
			$c_img = get_sub_field('flex_image'); 
			if( ($has_text && $text) || $c_img ) {
				$checkin_rows[] = $ctr;
			}
		$ctr++; 
		endwhile;

		$countImages = ($checkin_rows) ? count($checkin_rows) : 0;
		$checkin_classes = '';
		if($countImages==1) {
			$checkin_classes = ' has-one-image';
		}
		if($countImages==2) {
			$checkin_classes = ' has-two-images';
		}

?>
<section id="section-checkin" data-section="<?php echo $section4 ?>" class="section-content<?php echo $checkin_classes;?>">
	<div class="wrapper-full">
		<div class="flexwrap">
		<?php $i=1; 
		while( have_rows('box_content') ): the_row();
			$has_text = get_sub_field('has_text'); 
			$has_text = ($has_text=='yes') ? true : false;
			$image = get_sub_field('flex_image'); 
			$text = get_sub_field('flex_content'); 
			$classList = '';
			$flex_class = '';
			$has_text_image = false;
			$verbiage = '';
			if($has_text && $text) {
				$verbiage = ($text) ? $text : '';
				$classList = ($text && $image) ? ' text-and-image':'';
				$classList .= ' has-text ';
				if($text && $image) {
					$has_text_image = true;
				}
			}
			if($image) {
				$classList .= ' has-image';
			}
			?>
			<?php /* LEFT COLUMN */ ?>
				<?php if($i==1) { ?>
				<div class="col-left">
				<?php } ?>

				<?php if($i<3) { ?>
				<div class="flex-content largebox <?php echo $flex_class.$classList ?>">
					<div class="inside">
					<?php if ($has_text_image) { ?>
						<div class="imagediv" style="background-image:url('<?php echo $image['url'] ?>')">
							<img src="<?php echo $rectangle ?>" alt="">
						</div>
						<div class="caption">
							<div class="text"><?php echo $verbiage ?></div>
						</div>
					<?php } else { ?>
						
						<?php if ($verbiage) { ?>
							<div class="caption">
								<div class="text"><?php echo $verbiage ?></div>
							</div>
						<?php } ?>

						<?php if ($image) { ?>
							<div class="image-only" style="background-image:url('<?php echo $image['url'] ?>')">
								<img src="<?php echo $image['url'] ?>" alt="<?php echo $image['title'] ?>">
							</div>
						<?php } ?>

					<?php } ?>
					</div>
				</div>
				<?php } ?>

				<?php if($i==2) { ?>
				</div>
				<?php } ?>

				<?php /* RIGHT COLUMN */ ?>
				<?php if($i==3) { ?>
				<div class="col-right">
					<div class="flex-content largebox <?php echo $flex_class.$classList ?>">
						<div class="inside">
						<?php if ($has_text_image) { ?>
							<div class="imagediv" style="background-image:url('<?php echo $image['url'] ?>')">
								<img src="<?php echo $rectangle ?>" alt="">
							</div>
						<?php } else { ?>
							<?php if ($verbiage) { ?>
								<div class="caption">
									<div class="text"><?php echo $verbiage ?></div>
								</div>
							<?php } ?>

							<?php if ($image) { ?>
								<div class="image-only" style="background-image:url('<?php echo $image['url'] ?>')">
									<img src="<?php echo $image['url'] ?>" alt="<?php echo $image['title'] ?>" class="actual">
								</div>
							<?php } ?>
						<?php } ?>
						</div>
					</div>
				</div>
				<?php } ?>

		<?php $i++; endwhile;
		?>
		</div>
	</div>
</section>
	<?php 
	endif;
endwhile; endif;

 ?>