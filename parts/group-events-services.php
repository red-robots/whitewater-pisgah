<?php
$placeholder = THEMEURI . 'images/rectangle.png';
$placeholder2 = THEMEURI . 'images/rectangle-narrow.png';
$section_title = 'Activities';
$services = get_field("groupevents_featuredservices");
if($services) { ?>
<div class="group-services-wrapper">
	<?php $i=1; foreach ($services as $e) { 
		$title = $e['title'];
		$description = $e['description'];
		$button = ( isset($e['button']) && $e['button'] ) ? $e['button'] : "";
		$buttonName = ( isset($button['title']) && $button['title'] ) ? $button['title']:''; 
		$buttonLink = ( isset($button['url']) && $button['url'] ) ? $button['url']:''; 
		$buttonTarget = ( isset($button['target']) && $button['target'] ) ? $button['target']:'_self'; 
		$slides = $e['gallery'];
		$buttonList = $e['buttons'];

		$boxClass = ( ($title || $description) && $slides ) ? 'half':'full';
			if( ($title || $description) || $slides) {
				$colClass = ($i % 2) ? ' odd':' even'; ?>
			<section id="services<?php echo $i?>" data-section="<?php echo $title ?>" class="section-content menu-sections group-events-services">
				<div class="columns-2">
					<div class="mscol <?php echo $boxClass.$colClass ?>">
						
						<?php if ( $title || $description ) { ?>
						<div class="textcol">
							<div class="inside">

								<div class="info">
									<?php if ($title) { ?>
										<h3 class="mstitle"><?php echo $title ?></h3>
									<?php } ?>

									<?php if ($description) { ?>
										<div class="textwrap">
											<div class="mstext"><?php echo $description ?></div>
										</div>
									<?php } ?>

									<?php /* Button */ ?>
									<?php //if ($buttonName && $buttonLink) { ?>
									<!-- <div class="buttondiv">
										<a href="<?php //echo $buttonLink ?>" target="<?php //echo $buttonTarget ?>" class="btn-sm pagelink"><span><?php //echo $buttonName ?></span></a>
									</div> -->
									<?php // } ?>


									<?php /* Multiple Buttons */ ?>
									<?php if ($buttonList) { ?>
										<div class="buttonGroup">
											<?php foreach ($buttonList as $arr) { 
												if( $b = $arr['button'] ) {
													$btnName = ( isset($b['title']) && $b['title'] ) ? $b['title'] : '';
													$btnLink = ( isset($b['url']) && $b['url'] ) ? $b['url'] : '';
													$btnTarget = ( isset($b['target']) && $b['target'] ) ? $b['target'] : '_self';
													if($btnName && $btnLink) { ?>
													<div class="buttondiv"><a href="<?php echo $btnLink ?>" class="btn-sm pagelink" target="<?php echo $btnTarget ?>"><span><?php echo $btnName ?></span></a></div>
													<?php } ?>
												<?php } ?>
											<?php } ?>
										</div>
									<?php } ?>

								</div><!-- .info -->

							</div><!-- .inside -->
						</div><!-- .textcol -->	
						<?php } ?>

						<?php if ( $slides ) { ?>
						<div class="gallerycol">
							<div class="flexslider">
								<ul class="slides">
									<?php $helper = THEMEURI . 'images/rectangle-narrow.png'; ?>
									<?php foreach ($slides as $s) { ?>
										<li class="slide-item" style="background-image:url('<?php echo $s['url']?>')">
											<img src="<?php echo $helper ?>" alt="" aria-hidden="true" class="placeholder">
											<img src="<?php echo $s['url'] ?>" alt="<?php echo $s['title'] ?>" class="actual-image" />
										</li>
									<?php } ?>
								</ul>
							</div>
						</div>	
						<?php } ?>

					</div>
				</div>
			</section>
	
		<?php $i++; } ?>

	<?php } ?>

</div>
<?php } ?>