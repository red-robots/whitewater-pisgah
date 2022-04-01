<?php
$x_sect_title = get_field("x_card_sect_title");
$sx_sect_title = sanitize_title_with_dashes($x_sect_title);
$x_icon = get_field("custom_icon_copy");

if ( have_rows('extra_cards') ) : ?>
<section  id="section-<?php echo $sx_sect_title; ?>" data-section="<?php echo $x_sect_title ?>" class="flex-container store-listings full nomtop">
	<div class="wrapper sect-div-pad">
		<div class="shead-icon text-center svg-sec-icon">
			<div class="icon">
				<img src="<?php echo $x_icon['url']; ?>">
			</div>
			
			<h2 class="stitle"><?php echo $x_sect_title; ?></h2>
			<?php if ($stories_text) { ?>
			<div class="subtext">
				<?php echo $stories_text ?>
				<?php if( current_user_can( 'administrator' ) ){ ?>
				<div class="edit-entry"><a href="<?php echo $stories_edit_link ?>" style="text-decoration:underline;">Edit Text</a></div>
				<?php } ?>
			</div>	
			<?php } ?>
		</div>
	</div>
	<?php $i=1; $iRel=1; while ( have_rows('extra_cards') ) : the_row(); ?>
		<?php 
		$iRel++;
		$xtitle = get_sub_field('x_card_sect_title'); 
		$content = get_sub_field('content');
		$slides = get_sub_field("images");
		$cta = get_sub_field("call_to_action");
		$ctaIcon = get_sub_field("call_to_action_icon");
		$rel = 'group-'.$iRel;
				// echo '<pre>';
				// print_r($cta);
				// echo '</pre>';
		// $brands = get_field("brands");
		$columnClass = ( $slides && ($content || $brands) ) ? 'half':'full';
		$columnClass .= ($i % 2) ? ' odd':' even';
		?>
		<div  class="entry <?php echo $columnClass ?>">
		<!-- <div id="entry<?php //echo $i ?>" data-section="<?php //echo $xtitle ?>" class="entry <?php echo $columnClass ?>"> -->
			<div class="flexwrap wow fadeIn">
				
				<?php if ($content || $brands) { ?>
				<div class="block textcol">
					<div class="inside">
						<div class="wrap">
							<div class="text text-center">
								<!-- <h2 class="stitle"><?php echo $title ?></h2> -->
								<?php if ($content) { ?>
									<?php echo $content; ?>
								<?php } ?>
								<?php if ($cta) { ?>
									<div class="buttondiv imgwicon">
										<a href="<?php echo $cta['url']; ?>" target="<?php echo $cta['target']; ?>" class="btn-sm">
											<?php if($ctaIcon){ ?><img src="<?php echo $ctaIcon['url']; ?>"><?php } ?>
											<span><?php echo $cta['title']; ?></span>
										</a>
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
											<a href="<?php echo $s['url'] ?>" class="zoomPic zoom-image" rel="<?php echo $rel; ?>" data-fancybox="gallery<?php echo $i ?>">
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
	<?php $i++; endwhile; //wp_reset_postdata(); ?>
</section>
<?php endif; ?>