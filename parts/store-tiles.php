<?php
 
if ( have_rows('tile') ) : ?>
<section class="flex-container store-listings full">
	<?php $i=1; while ( have_rows('tile') ) : the_row(); ?>
		<?php 
		$title = get_sub_field('title'); 
		$text = get_sub_field('excerpt');
		$slides = get_sub_field("image_slides");
		$brands = get_sub_field("brands");
		$columnClass = ( $slides && ($text || $brands) ) ? 'half':'full';
		$columnClass .= ($i % 2) ? ' odd':' even';
		?>
		<div id="entry<?php echo $i ?>" data-section="<?php echo $title ?>" class="entry <?php echo $columnClass ?>">
			<div class="flexwrap wow fadeIn">
				
				<?php if ($text || $brands) { ?>
				<div class="block textcol">
					<div class="inside">
						<div class="wrap">
							<div class="text text-center">
								<h2 class="stitle"><?php echo $title ?></h2>
								<?php if ($text) { ?>
									<?php echo $text; ?>
								<?php } ?>
							</div>
							
							<?php if ($brands) { ?>
							<div class="product-brands">
								<?php foreach ($brands as $b) { 
									$imgWebURL = get_field("image_website",$b['ID']);
									$openLink = '';
									$closeLink = '';
									if($imgWebURL) {
										$openLink = '<a href="'.$imgWebURL.'" target="_blank">';
										$closeLink = '</a>';
									} ?>
									<div class="brand"><?php echo $openLink ?><span style="background-image:url('<?php echo $b['url'] ?>');"><img src="<?php echo $b['url'] ?>" alt="<?php echo $b['title'] ?>"></span><?php echo $closeLink ?></div>
								<?php } ?>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>	
				<?php } ?>

				<?php if ($slides) { $count = count($slides); ?>
				<div class="block imagecol">
					<div class="inside">
							<div id="subSlider<?php echo $i?>" class="flexslider posttypeslider <?php echo ($count>1) ? 'doSlider':'noSlider'?>">
								<ul class="slides">
									<?php $helper = THEMEURI . 'images/rectangle-narrow.png'; ?>
									<?php foreach ($slides as $s) { ?>
										<li class="slide-item" style="background-image:url('<?php echo $s['url']?>')">
											<a href="<?php echo $s['url'] ?>" class="zoomPic zoom-image" data-fancybox="gallery<?php echo$i; ?>">
												<img src="<?php echo $helper ?>" alt="" aria-hidden="true" class="placeholder">
												<img src="<?php echo $s['url'] ?>" alt="<?php echo $s['title'] ?>" class="actual-image" />
											</a>
										</li>
									<?php } ?>
								</ul>
							</div>
					</div>
				</div>
				<?php } ?>

			</div>
		</div>
	<?php $i++; endwhile; wp_reset_postdata(); ?>
</section>
<?php endif; ?>

<script type="text/javascript">
jQuery(document).ready(function($){
	// if( $(".doSlider").length>0 ) {
	// 	$(".doSlider").each(function(){
	// 		var slideId = $(this).attr("id");
	// 		$("#"+slideId+".doSlider").flexslider({
	// 	    animation: "slide"
	// 	  });
	// 	});
	// }
});
</script>
