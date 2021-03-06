<?php
$sTitle = get_field('popup_section_title');

$placeholder = THEMEURI . 'images/rectangle.png';
$perpage = -1;
$posttype = 'public_assets';
$args = array(
	'posts_per_page'   => $perpage,
	'post_type'        => $posttype,
	'post_status'      => 'publish'
);
$entries = new WP_Query($args); 
if ( $entries->have_posts() ) { ?>
<section id="section-activities" data-section="<?php echo $sTitle; ?>" class="section-content flex-container store-listings full countItems<?php echo $countActivities?>">
<section class="flex-container store-listings full">
	<?php if( $sTitle ){ ?>
	<div class="wrapper titlediv sect-div-pad">
		<div class="shead-icon text-center">
			<div class="icon"><span class="ci-task"></span></div>
			<h2 class="stitle"><?php echo $sTitle; ?></h2>
		</div>
	</div>
	<?php } ?>
	<?php $i=1; while ( $entries->have_posts() ) : $entries->the_post(); ?>
		<?php 
		$title = get_the_title(); 
		$text = get_the_content();
		$slides = get_field("image_slides");
		$brands = get_field("brands");
		$btns = get_field('link_buttons');
		// echo '<pre>';
		// print_r($btns);
		// echo '</pre>';
		$columnClass = ( $slides && ($text || $brands) ) ? 'half':'full';
		$columnClass .= ($i % 2) ? ' odd':' even';
		?>
		<div id="entry<?php echo $i ?>"  class="entry <?php echo $columnClass ?>">
			<!-- <div id="entry<?php echo $i ?>" data-section="<?php echo $title ?>" class="entry <?php echo $columnClass ?>"> -->
			<div class="flexwrap wow fadeIn">
				
				<?php if ($text || $brands) { ?>
				<div class="block textcol">
					<div class="inside">
						<div class="wrap">
							<div class="text text-center">
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
							
								<h2 class="stitle"><?php echo $title ?></h2>
								<?php if ($text) { ?>
									<?php echo $text; ?>
								<?php } ?>
								<?php foreach ($btns as $bbb) { 
										// echo '<pre>';
										// print_r($bbb);
										// echo '</pre>';
										$buttonTitle = (isset($bbb['button_label']) && $bbb['button_label']) ? $bbb['button_label'] : '';
										$buttonLink = (isset($bbb['link']) && $bbb['link']) ? $bbb['link'] : '';
										$buttonTarget = (isset($bbb['target']) && $bbb['target']) ? $bbb['target'] : '_self';
				?>
										<div class="buttondiv">
											<a href="<?php echo $buttonLink ?>" target="<?php echo $buttonTarget ?>" class="btn-sm xs"><span><?php echo $buttonTitle ?></span></a>
										</div>
									<?php } ?>
							</div>
							
							
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
<?php } ?>

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
