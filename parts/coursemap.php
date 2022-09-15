<?php 
/* COURSE MAP */
//$course_section_icon = get_field("course_section_icon"); 
$course_section_title = get_field("course_section_title"); 
$course_images = get_field("course_images"); 
$imgFrame = get_field('img_iframe');
$key = get_field('map_key');
$iframe = get_field('iframe');
$gpx = get_field('gpx_files');
if($course_section_title) { ?>
<section id="section-coursemap" data-section="Course Map" class="section-content">
	<?php if ($course_section_title) { ?>
		<div class="title-w-icon">
			<div class="wrapper">
				<div class="shead-icon text-center">
					<div class="icon"><span class="ci-map"></span></div>
					<h2><?php echo $course_section_title ?></h2>
				</div>
			</div>
		</div>
	<?php } ?>

	<?php 
		if( $imgFrame !== 'iframe' || $imgFrame == '' ) {
		if ($course_images) { 
		$ci_images[] = array('img1','img1_width');
		$ci_images[] = array('img2','img2_width');
		$countImages = 0;
		$courseImagesArrs = array();
		foreach ($ci_images as $c) { 
			$img_field = ( isset($c[0]) && $c[0] ) ? $c[0] : '';
			$img_width = ( isset($c[1]) && $c[1] ) ? $c[1] : '';
			$img = ( isset($course_images[$img_field]) && $course_images[$img_field] ) ? $course_images[$img_field]:'';
			$percent = ( isset($course_images[$img_width]) && $course_images[$img_width] ) ? $course_images[$img_width]:'50';
			if($img) {
				$courseImagesArrs[$img_field] = $img;
			}
		}

		$count_images = ($courseImagesArrs) ? count($courseImagesArrs) : 0;
		if($courseImagesArrs) { ?>
		<div class="course-images images-count-<?php echo $count_images?>">
			<div class="inner">
				<?php foreach ($ci_images as $c) { 
					$img_field = ( isset($c[0]) && $c[0] ) ? $c[0] : '';
					$img_width = ( isset($c[1]) && $c[1] ) ? $c[1] : '';
					$img = ( isset($course_images[$img_field]) && $course_images[$img_field] ) ? $course_images[$img_field]:'';
					$percent = ( isset($course_images[$img_width]) && $course_images[$img_width] ) ? $course_images[$img_width]:'50';
					if($img) { ?>
						<div class="img" style="width:<?php echo $percent?>%">
							<a href="<?php echo $img['url'] ?>" class="zoomPic zoom-image">
								<div class="wrap" style="background-image:url('<?php echo $img['url'] ?>')">
									<img src="<?php echo $img['url'] ?>" alt="<?php echo $img['title'] ?>" style="visibility:hidden"/>
								</div>
							</a>
						</div>
					<?php } ?>
				<?php } ?>
			</div>
		</div>
		<?php } ?>
	<?php }} ?>
	<?php if( $imgFrame == 'iframe' ) { ?>
		<div class="course-images">
			<div class="inner">
				<div class="map-wrap">
					<?php if($key) { ?><div class="frame-left"><?php } ?>
						<?php echo $iframe; ?>
					<?php if($key) { ?></div><?php } ?>
					<?php if($key) { ?>
						<div class="frame-right">
							<div class="key">
								<h3>Map Key</h3>
								<?php if(have_rows('map_key')): while(have_rows('map_key')): the_row(); 
										$lClass = '';
										$mapColor = get_sub_field('route_color');
										$mapName = get_sub_field('route_name');
										$mapLine = get_sub_field('route_type');
										$mapColorT = get_sub_field('route_2_color');
										$mapLineT = get_sub_field('route_2_type');
										if( $mapColorT ) {
											$lClass = 'two';
										}
									?>
									<div class="map-detail">
										<div class="line <?php echo $lClass; ?>" 
										style="border-bottom: 3px <?php echo $mapColor. ' '.$mapLine ?>; ">&nbsp;</div>
										<?php if( $mapColorT ){ ?>
											<div class="line <?php echo $lClass; ?>" 
											style="border-bottom: 3px <?php echo $mapColorT. ' '.$mapLineT ?>; ">&nbsp;</div>
										<?php } ?>
										<div class="key-label"><?php echo $mapName; ?></div>
									</div>
								<?php endwhile; endif; ?>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
			
		</div>
	<?php } ?>
	<?php if( $gpx ){ ?>
        <div class="center-text">
        	<?php foreach ($gpx as $d) { ?>
              <div class="gpx-download">
                <a href="<?php echo $d['gpx_file']; ?>"><?php echo $d['gpx_button_label']; ?> <i class="far fa-cloud-download-alt"></i></a>
              </div>
          	<?php } ?>
        </div>
  	<?php } ?>
</section>
<?php } ?>