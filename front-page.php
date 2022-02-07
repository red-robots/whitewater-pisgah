<?php 
get_header(); 
$rectangle = THEMEURI . "images/rectangle-narrow.png";
?>
<div id="primary" class="content-area full">
	<?php while ( have_posts() ) : the_post(); ?>

		<?php
		/*===== ROW 1 =====*/
		$row1_text = get_field('row1_text');  
		$row1_text2 = get_field('row1_text2');  
		$row1_bg_image = get_field('row1_bg_image');  
		$row1_style = ($row1_bg_image) ? ' style="background-image:url('.$row1_bg_image['url'].')"':'';
		$enable = get_field("enable_row_1");
		if($enable=='on') { ?>
			<?php if ($row1_text) { ?>
				<section class="homerow row1 wow fadeIn"<?php echo $row1_style ?>>
					<div class="wrapper">
						<div class="textwrap">
							<div class="t1"><?php echo $row1_text ?></div>
							<?php if ($row1_text2) { 
								$text2 = preg_replace('/\s(?!\s)/', ' ', $row1_text2);
								$parts = explode("|",$text2);
								$count = count($parts)
							?>
							<div class="t2 <?php echo ( $parts && count($parts)> 1 ) ? 'items':'item'; ?>">
								<?php if ($parts) { ?>
									<?php foreach ($parts as $p) { ?>
									<span class="feat"><?php echo $p; ?></span>
									<?php } ?>
								<?php } ?>
							</div>
							<?php } ?>
						</div>
					</div>
				</section>
			<?php } ?>
		<?php } ?>


		<?php
		/*===== ROW 2 =====*/
		$row2_title = get_field('row2_title');  
		$row2_button_name = get_field('row2_button_name');  
		$row2_button_link = get_field('row2_button_link');  
		$activities = get_field('activities');  
		?>
		<?php if ($row2_title || $activities) { ?>
		<section id="section-activities" class="homerow row2">

			<?php if ($row2_title) { ?>
			<div class="wrapper inner-content text-center">
				<div class="shead-icon text-center">
					<div class="icon"><span class="ci-pine-tree"></span></div>
					<h2 class="stitle"><?php echo $row2_title ?></h2>
				</div>
				<?php if ($row2_button_name && $row2_button_link) { ?>
				<div class="buttondiv">
					<a href="<?php echo $row2_button_link['url'] ?>" target="<?php echo $row2_button_link['target'] ?>" class="btn-sm"><span><?php echo $row2_button_name ?></span></a>
				</div>	
				<?php } ?>
			</div>
			<?php } ?>

			<?php /*===== ACTIVITIES =====*/ ?>
			<?php if ($activities) { ?>
			<div class="activities row1">
				<div class="wrappe-full full text-center">
					<div class="flexwrap">
						<?php foreach ($activities as $a) {
							$a_image = $a['image'];
							$a_title = $a['title'];
							$a_link = $a['link'];
							$open_link = '<div class="wrap">';
							$close_link = '</div>';
							if($a_link) {
								$open_link = '<a href="'.$a_link['url'].'" target="'.$a_link['target'].'" class="wrap">';
								$close_link = '</a>';
							}
							if($a_image) { ?>
							<div class="imagebox">
								<?php echo $open_link; ?>
									<?php if ($a_title) { ?>
									<span class="title"><?php echo $a_title ?></span>	
									<?php } ?>
									<span class="imgwrap">
										<span class="bg" style="background-image:url('<?php echo $a_image['url']; ?>')">
											<img src="<?php echo $rectangle ?>" alt="" aria-hidden="true">
										</span>
									</span>
								<?php echo $close_link; ?>
							</div>
							<?php } ?>
						<?php } ?>
					</div>
				</div>
			</div>
			<?php } ?>

		</section>
		<?php } ?>


	<?php endwhile; ?>


	<?php /*===== ROW 3: UPCOMING EVENTS =====*/ ?>
	<?php get_template_part('parts/upcoming-events','festival'); ?>


	<?php /*===== ROW 4: STORIES =====*/
	get_template_part('parts/home-stories-videos'); ?>


	<?php /*===== ROW 5: SEASONAL ACTIVITIES =====*/
	get_template_part('parts/home-seasonal-activities'); ?>



	
</div><!-- #primary -->
<?php
get_footer();