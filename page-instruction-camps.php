<?php
/**
 * Template Name: Instruction + Camps
 */

get_header(); 
$placeholder = THEMEURI . 'images/rectangle.png';
?>

<div id="primary" data-post="<?php echo get_the_ID()?>" class="content-area-full activities-parent">
		<?php while ( have_posts() ) : the_post(); ?>
				<div class="intro-text-wrap">
					<div class="wrapper">
						<h1 class="page-title"><span><?php the_title(); ?></span></h1>
						<div class="intro-text"><?php the_content(); ?></div>
					</div>
				</div>
		<?php endwhile;  ?>

		<?php if( $entries = get_field("ins_camp_entries") ) { ?>
		<section id="section-activities" class="section-content section-grid-images columns4 activities-parent-page">
			<div class="entryList flexwrap">
				<?php $i=1; foreach ($entries as $e) { 
					$thumbnail = $e['thumbnail'];
					$item = $e['link'];
					if($item) { 
						$title = $item->post_title;
						$pagelink = get_permalink($item->ID);
						?>
						<div id="entryBlock<?php echo $i?>" class="fbox <?php echo ($thumbnail) ? 'hasImage':'noImage'; ?>">
							<div class="inside text-center">
								<div class="imagediv <?php echo ($thumbnail) ? 'hasImage':'noImage'?>">
									<?php if ($thumbnail) { ?>
										<a href="<?php echo $pagelink; ?>" class=" ">
											<span class="img" style="background-image:url('<?php echo $thumbnail['url']?>')"></span>
										</a>
									<?php } ?>
										<img src="<?php echo $placeholder ?>" alt="" aria-hidden="true" class="placeholder">
								</div>
								<div class="titlediv">
									<p class="name"><?php echo $title ?></p>
									<div class="buttondiv">
										<a href="<?php echo $pagelink; ?>" class="btn-sm xs"><span>See Details</span></a>
									</div>
								</div>
							</div>
						</div>
					<?php $i++; } ?>
				<?php } ?>
			</div>
		</section>
		<?php } ?>

</div><!-- #primary -->

<?php
get_footer();
