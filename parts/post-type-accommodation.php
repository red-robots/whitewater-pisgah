<?php 
$postid = get_the_ID();
while ( have_posts() ) : the_post(); 
	$top_notification = get_field("top_notification");
	$main_description = get_field("accommodation_descr");
	$taxonomy = 'pass_type';
	$categories = get_the_terms($postid,$taxonomy);
	$catSlugs = array();
	if($categories) {
		foreach($categories as $c) {
			$catSlugs[] = $c->slug;
		}
	}

	/* Show description if category slug is 'all-access-pass' */
	//$show_main_description = false;
	// if( $categories &&  in_array('all-access-pass',$catSlugs) ) {
	// 	$show_main_description = true;
	// }

	$show_main_description = true;
	$pageTabs = array('intro','options','what to wear','check-in','faq');
	?>
	
	<?php if ($show_main_description && $main_description) { ?>
	<section class="main-description">
		<div class="wrapper text-center">
			<h1 class="pagetitle"><span><?php echo get_the_title(); ?></span></h1>
			<?php echo $main_description ?>
		</div>
	</section>
	<?php } ?>

	<?php 
		$purchase_link = get_field("purchase_link");
		$reservation = get_field("reservation_data");

		if ($purchase_link) { 
			$btn_title = $purchase_link['title'];
			$btn_link = $purchase_link['url'];
			$btn_target = $purchase_link['target'];
			$target = ($btn_target) ? ' target="'.$btn_target.'"':'';
	?>
			<section class="accomm-purchase">
				<div class="button text-center">
					<a href="<?php echo $btn_link ?>" class="btn-border"<?php echo $target ?>>
						<span><?php echo $btn_title ?></span>
					</a>
				</div>	
			</section>
	<?php } ?>

	<div id="pageTabs"></div>


	


	<?php 
	/* INTRO */
	$galleries = '';
	$galleryData = get_field("gallery_content");
	if( isset($galleryData['g_images']) && $galleryData['g_images'] ) {
		$galleries = $galleryData['g_images'];
	}
	$left_icon = ( isset($galleryData['g_icon']) && $galleryData['g_icon'] ) ? $galleryData['g_icon']:'';
	$left_text = ( isset($galleryData['g_description']) && $galleryData['g_description'] ) ? $galleryData['g_description']:'';
	$introClass = ($left_text && $galleries) ? 'half':'full';
	$placeholder = THEMEURI . 'images/rectangle.png';
	$gallery_section_title = get_field("gallery_section_title");
	$section1 = ($gallery_section_title) ? ' data-section="'.$gallery_section_title.'"':'';
	?>

	<?php if ($left_text || $galleries) { ?>
	<section id="section-intro" class="section-content intro-galleries <?php echo $introClass ?>"<?php echo $section1 ?>>
		<div class="flexwrap">
			<?php if ($left_text) { ?>
			<div class="leftcol textcol">
				<div class="wrap">
					<div class="inner">
						<?php if ($left_icon) { ?>
						<div class="icon-col">
							<span style="background-image:url('<?php echo $left_icon['url'] ?>')"></span>
						</div>	
						<?php } ?>
						<?php echo $left_text ?>	
					</div>	
				</div>
			</div>	
			<?php } ?>

			<?php if ($galleries) { 
				$count = count($galleries); 
				$slider_class = ($count>1) ? 'subpage-sliders flexslider':'subpage-slider-static';
				?>
			<div class="rightcol galleryCol">
				<div id="subpageSlides" class="rightcol <?php echo $slider_class ?>">
					<ul class="slides">
						<?php foreach ($galleries as $g) { ?>
						<li class="sub-slide-item">
							<a href="<?php echo $g['url'] ?>" class="zoomPic zoom-image" data-fancybox="gallery">
								<div class="slide-image" style="background-image:url('<?php echo $g['url']?>')">
									<img src="<?php echo $placeholder ?>" alt="">
								</div>
							</a>
						</li>	
						<?php } ?>
					</ul>
				</div>	
			</div>
			<?php } ?>
		</div>
	</section>	
	<?php } ?>

	<?php 
	/* FLEXIBLE CONTENT */
	$flex_section_title = get_field("flexcontent_section_title");
	$flex_blocks = get_field("flexcontent_text_image");
	$margin = ($flex_section_title) ? '':' nomtop';
	if($flex_blocks) { ?>
		<section id="flexible-content" data-section="<?php echo $flex_section_title ?>" class="section-content">
			<?php if ($flex_section_title) { ?>
			<div class="section-title-div">
				<div class="wrapper">
					<div class="shead-icon text-center">
						<!-- <div class="icon"><span class="ci-calendar"></span></div> -->
						<h2 class="stitle"><?php echo $flex_section_title ?></h2>
					</div>
				</div>
			</div>
			<?php } ?>

			<div class="text-and-image-blocks<?php echo $margin ?>">
				<div class="columns-2">
					<?php $x=1; foreach ($flex_blocks as $b) { 
						$f_title = $b['title'];
						$f_text = $b['description'];
						$f_image = $b['gallery_image'];
						$fbutton = $b['button'];
						if($f_title || $f_text || $f_image) { 
							$colClass = ($x % 2==0) ? 'even':'odd';
							if( ($f_title || $f_text) && $f_image ) {
								$colClass .= ' half';
							} else {
								$colClass .= ' full';
							}
							$buttonTitle = (isset($fbutton['title']) && $fbutton['title']) ? $fbutton['title'] : '';
							$buttonLink = (isset($fbutton['url']) && $fbutton['url']) ? $fbutton['url'] : '';
							$buttonTarget = (isset($fbutton['target']) && $fbutton['target']) ? $fbutton['target'] : '_self';

							$imageCount = ($f_image) ? count($f_image) : 0;
						?>
						<div id="frow<?php echo $x?>" class="mscol <?php echo $colClass ?>">
							<?php if ($f_title || $f_text) { ?>
							<div class="textcol">
								<div class="inside">
									<div class="info">
										<?php if($f_title) { ?>
											<h3 class="mstitle"><?php echo $f_title ?></h3>
										<?php } ?>
										<?php if($f_text || ($buttonTitle && $buttonLink) ) { ?>
											<div class="textwrap">
												<div class="mstext"><?php echo $f_text ?></div>
												<?php if ($buttonTitle && $buttonLink) { ?>
												<div class="buttondiv">
													<a href="<?php echo $buttonLink ?>" target="<?php echo $buttonTarget ?>" class="btn-sm xs"><span><?php echo $buttonTitle ?></span></a>
												</div>
												<?php } ?>
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
							<?php } ?>
							
							<?php if ($f_image) { ?>
							<div class="gallerycol">

								<?php if ($imageCount==1) { ?>
								<div class="singlepic">
									<img src="<?php echo $f_image[0]['url'] ?>" alt="<?php echo $f_image[0]['title'] ?>">
								</div>
								<?php } else { ?>
									<div class="flexslider">
										<ul class="slides">
											<?php $helper = THEMEURI . 'images/rectangle-narrow.png'; ?>
											<?php foreach ($f_image as $s) { ?>
												<li class="slide-item" style="background-image:url('<?php echo $s['url']?>')">
													<img src="<?php echo $helper ?>" alt="" aria-hidden="true" class="placeholder">
													<img src="<?php echo $s['url'] ?>" alt="<?php echo $s['title'] ?>" class="actual-image" />
												</li>
											<?php } ?>
										</ul>
									</div>
								<?php } ?>
							</div>
							<?php } ?>
						</div>
						<?php $x++; } ?>
					<?php } ?>
				</div>
			</div>
		</section>
	<?php } ?>

	<?php  
	/* OPTIONS */
	$activities = get_field("activities");
	$options_class = ($activities && $categories) ? 'half':'full';
	$legend = get_field("activity_legend","option");
	$s2_title = get_field("activities_section_title");
	$section2 = ($s2_title) ? $s2_title : 'Options';
	if($activities || $categories) { ?>
	<section id="section-options" data-section="<?php echo $section2 ?>" class="section-content <?php echo $options_class ?>">
		<div class="wrapper">
			<?php if ($activities) { ?>
			<div class="optcol activities">
			
				<?php if ($legend) { ?>
				<div class="legend-for-mobile">
					<?php foreach ($legend as $e) { 
						$color = $e['color'];
						$level = $e['level'];
						if($color && $level) { ?>
						<div class="levelblock"><span class="level"><em class="right"><span><?php echo $color ?></span></em><em class="left"><?php echo $level ?></em></span></div>
						<?php } ?>
					<?php } ?>
				</div>
				<?php } ?>

				<?php 
					//$options_heading = array('Options','Difficulty','Qualifiers'); 
					$options_heading = get_field("activity_options_heading","option"); 
				?>

				<div class="flex-items">
					<?php if ($options_heading) { ?>
					<div id="items-head" class="item headings">
						<?php $h=1; foreach ($options_heading as $opt) { 
							$optName = $opt['activityOptTitle']; 
							$optName = ($optName) ? trim(preg_replace('/\s+/',' ', $optName)) : '';
							if( trim(preg_replace('/\s+/','', $optName)) ) { ?>
							
								<?php if ($optName=='Difficulty') { ?>
								<div class="cell hd<?php echo $h?>">
									<?php if ($legend) { ?>
										<span class="txt"><?php echo $optName ?> <i id="legend-info">i</i></span>
										<span id="legendData" class="legend">
											<?php foreach ($legend as $e) { 
												$color = $e['color'];
												$level = $e['level'];
												if($color && $level) { ?>
												<span><em class="right"><?php echo $color ?></em><em class="left"><?php echo $level ?></em></span>
												<?php } ?>
											<?php } ?>
										</span>
									<?php } else { ?>
										<?php echo $optName ?>
									<?php } ?>
								</div>
								<?php } else { ?>
									<div class="cell hd<?php echo $h?>"><?php echo $optName ?></div>
								<?php } ?>

							<?php } ?>

						<?php $h++; } ?>
					</div>
					<?php } ?>

					<?php $i=1; foreach ($activities as $a) {
						$a_name = $a['name'];
						$a_note = ( isset($a['spnote']) && $a['spnote'] ) ? $a['spnote'] : '';
						$a_description = $a['description'];
						$a_difficulty = $a['difficulty'];
						$a_qualifiers = $a['qualifiers'];
						$a_show = $a['show']; 
						$show_this_option = ($a_show=='yes') ? true : false;
						if($show_this_option) { ?>
						<div id="item-<?php echo $i?>" class="item">

							<?php /* OPTIONS */ ?>
							<?php if ($a_name) { ?>
								<div class="item-title">
									<h2 class="type">
										<?php echo $a_name ?>
										<?php if ($a_note) { ?>
										<em><?php echo $a_note; ?></em>	
										<?php } ?>
									</h2>
								</div>
							<?php } ?>
							<div class="cell desc-col">
								<?php if ($a_description) { ?>
								<div class="desc"><?php echo $a_description ?></div>	
								<?php } ?>
							</div>
							
							<?php /* DIFFICULTY */ ?>
							<div class="cell diff-col">
								<span class="cell-label">Difficulty:</span>
								<?php if ($a_difficulty) { ?>
									<?php foreach ($a_difficulty as $diff) { 
										$dSlug = sanitize_title($diff); ?>
										<span class="diff <?php echo $dSlug ?>"></span>
									<?php } ?>
								<?php } ?>
							</div>

							<?php /* AGE */ ?>
							<div class="cell age-col">
								<span class="cell-label">Age:</span>
								<?php if ($a_qualifiers) { ?>
								<span class="age"><?php echo $a_qualifiers ?></span>
								<?php } ?>
							</div>
						</div>	
						<?php $i++; } ?>
					<?php } ?>
				</div>

			</div>	
			<?php } ?>

			<?php if ($categories || $reservation) { ?>
			<div class="optcol categories passOptions">
				<?php if ($categories) { ?>
					<div class="inner graybox">
						<h2 class="box-title">Pass Options</h2>
						<div class="box-content">
							<ul class="cats">
							<?php foreach ($categories as $cat) {
								$cat_id = $cat->term_id;
								$pass_types = get_pass_type_category($cat_id); 
								$pass_types_list = '';
								if($pass_types) {
									foreach($pass_types as $k=>$v) {
										$comma = ($k>0) ? ', ':'';
										$pass_types_list .= $comma . ucwords( strtolower($v->post_title)); 
									}
								}
								?>
								<li class="cat-item">
									<span class="icon"></span>
									<span class="catName">
										<?php echo $cat->name; ?>
										<?php if ($pass_types_list) { ?>
										<small>(<?php echo $pass_types_list ?>)</small>	
										<?php } ?>
									</span>
								</li>
							<?php } ?>
							</ul>

							<?php if ($purchase_link) { 
								$btn_title = $purchase_link['title'];
								$btn_link = $purchase_link['url'];
								$btn_target = $purchase_link['target'];
								$target = ($btn_target) ? ' target="'.$btn_target.'"':'';
							?>
							<div class="button text-center">
								<a href="<?php echo $btn_link ?>" class="btn-border"<?php echo $target ?>>
									<span><?php echo $btn_title ?></span>
								</a>
							</div>	
							<?php } ?>
						</div>
					</div>
				<?php } ?>

				<?php if ($reservation) {
					$res_title =  ( isset($reservation['title']) && $reservation['title'] ) ? $reservation['title']:'';
					$res_text =  (isset($reservation['text']) && $reservation['text']) ? $reservation['text']:'';
					$res_button =  ( isset($reservation['button']) && $reservation['button'] ) ? $reservation['button']:'';
					$res_target = ( isset($res_button['target']) && $res_button['target'] ) ? ' target="'.$res_button['target'].'"':'';
					$res_link = ( isset($res_button['url']) && $res_button['url'] ) ? $res_button['url']:'';
					$res_buttonText = ( isset($res_button['title']) && $res_button['title'] ) ? $res_button['title']:'';
					?>
					<div class="inner graybox reservationDiv">
						<div class="wrap">
							
							
							<?php if ($res_text || $res_button || $res_title) { ?>
								<div class="box-content">
									<div class="inner-wrap">
										<?php if ($res_title) { ?>
											<h2 class="box-title"><?php echo $res_title ?></h2>
										<?php } ?>
										<?php if ($res_text) { ?>
											<div class="text"><?php echo $res_text ?></div>
										<?php } ?>
										<?php if ($res_link && $res_buttonText) { ?>
											<div class="button">
												<a href="<?php echo $res_link ?>" class="btn-border-white"<?php echo $res_target ?>>
													<span><?php echo $res_buttonText ?></span>
												</a>
											</div>
										<?php } ?>
									</div>
								</div>
							<?php } ?>

						</div>
					</div>	
				<?php } ?>
			</div>	
			<?php } ?>
		</div>
	</section>
	<?php } ?>


	<?php
	/* WHAT TO WEAR */ 
	$wtw_section_title = get_field("wtw_section_title");  
	$wtw_default_image = get_field("wtw_default_image");  
	$wtw_options = get_field("wtw_options");  
	$s3_title = get_field("whereto_section_title");
	$section3 = ($s3_title) ? $s3_title : 'What to wear';
	$wtw_class = ($wtw_default_image && $wtw_options) ? 'half':'full';
	if ($wtw_options) { ?>
	<section id="section-whattowear" data-section="<?php echo $section3 ?>" class="section-content <?php echo $wtw_class ?>">
		<div class="wrapper">
			<div class="flexwrap">
				<?php if ($wtw_default_image) { ?>
				<div class="col model">
					<div id="defaultModel" class="default" data-default="<?php echo $wtw_default_image['url'] ?>" style="background-image:url('<?php echo $wtw_default_image['url'] ?>')">
						<?php if ($wtw_options) { ?>
							<?php $i=1; foreach ($wtw_options as $m) { 
								$wImg = $m['w_image']; 
								if($wImg) { ?>
								<div id="partImg<?php echo $i?>" class="part partImg animated" data-src="<?php echo $wImg['url'] ?>" style="background-image:url('<?php echo $wImg['url'] ?>')"></div>
								<?php } ?>
							<?php $i++; } ?>
						<?php } ?>
					</div>
				</div>	
				<?php } ?>

				<?php if ($wtw_options) { ?>
				<div class="col options">
					<?php if ($wtw_section_title) { ?>
					<div class="titlediv"><h2 class="sectionTitle"><?php echo $wtw_section_title ?></h2></div>	
					<?php } ?>

					<?php if ($wtw_options) { ?>
					<div class="wtw-options">
						<?php $n=1; foreach ($wtw_options as $m) { 
							$title = $m['w_title'];
							$description = $m['w_text'];
							$image_part = $m['w_image']; 
							$hasMapImage = ($image_part) ? 'has-map-image':'no-map-image';
							if($title) { ?>
							<div id="wtw<?php echo $n?>" data-part="#partImg<?php echo $n?>" class="wtw-row collapsible <?php echo $hasMapImage ?><?php echo ($n==1) ? ' first':''; ?>">
								<?php if ($title) { ?>
									<h3 class="option-name"><?php echo $title ?> <span class="arrow"></span></h3>
								<?php } ?>

								<?php if ($description) { ?>
									<div class="option-text"><?php echo $description ?></div>
								<?php } ?>
							</div>
							<?php } ?>
						<?php $n++; } ?>
					</div>	
					<?php } ?>
				</div>	
				<?php } ?>
			</div>
		</div>
	</section>
	<?php } ?>

	
<?php endwhile; ?>


	
	<?php
	/* CHECK-IN */ 
	$rectangle = THEMEURI . "images/rectangle.png";
	$square = THEMEURI . "images/square.png";
	$checkin_images = array();
	$checkin_rows = array();
	$s4_title = get_field("whereto_section_title");
	$section4 = ($s4_title) ? $s4_title : 'Check-In';
	if( have_rows('checkin_box') ) { 
		$ctr=0; while ( have_rows('checkin_box') ) : the_row(); 
			$has_text = get_sub_field('has_text'); 
			$has_text = ($has_text=='yes') ? true : false;
			$text = get_sub_field('flex_content'); 
			$c_img = get_sub_field('flex_image'); 
			if( ($has_text && $text) || $c_img ) {
				$checkin_rows[] = $ctr;
			}
		$ctr++; endwhile;

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
				<?php  $i=1; while ( have_rows('checkin_box') ) : the_row(); 
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

				<?php $i++; endwhile; ?>
			</div>
		</div>
	</section>
	<?php } ?>

	<?php include(locate_template('parts/points-of-interest.php')); ?>
	

	<?php /* MAPS */ ?>
	<?php if( $maps = get_field("maps") ) { 
	$map_title = get_field("map_section_title");
	$map_icon = get_field("custom_icon");
	$mclass = count($maps); ?>
	<section id="section-trail-maps" data-section="<?php echo $map_title ?>" class="section-content section-flex-columns blocks<?php echo $mclass;?>">
		<?php if ($map_title) { ?>
		<div class="wrapper">
			<div class="shead-icon text-center">
				<div class="icon"><span class="<?php echo $map_icon ?>"></span></div>
				<h2 class="stitle"><?php echo $map_title ?></h2>
			</div>
		</div>
		<?php } ?>

		<div class="columns-wrapper">
			<div class="flexwrap">
			<?php foreach ($maps as $img) { 
				$image = $img['image'];
				$width = ($img['width']) ? $img['width'] : '100';
				$width = ($width) ? str_replace('%','',$width) : '';
				if($image) { ?>
				<div class="flexcol" style="width:<?php echo $width ?>%;background-image:url('<?php echo $image['url'] ?>')">
					<img src="<?php echo $image['url'] ?>" alt="<?php echo $image['title'] ?>">
				</div>
				<?php } ?>
			<?php } ?>
			</div>
		</div>
	</section>
	<?php } ?>

	<?php include(locate_template('parts/extra-cards.php')); ?>

	<?php include(locate_template('parts/public-assets.php')); ?>

	<?php /* FAQ */ ?>
	<?php 
		$customFAQTitle = get_field("faq_section_title");
		//get_template_part("parts/content-faqs"); 
		include( locate_template('parts/content-faqs.php') ); 
	?>

	<?php /* Featured Articles */ ?>
	<?php get_template_part("parts/bottom-content-activity"); ?>

	<?php
	/* FAQS JAVASCRIPT */ 
	include( locate_template('inc/faqs-script.php') ); 
	?>

	<div id="activityModal" class="modal customModal fade">
		<div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div id="modalBodyText" class="modal-body">
	      </div>
	    </div>
	  </div>
	</div>

	<script type="text/javascript">
jQuery(document).ready(function($){
	// $('.loop').owlCarousel({
 //    center: true,
 //    items:2,
 //    nav: true,
 //    loop:true,
 //    margin:15,
 //    autoplay:true,
 //    autoplayTimeout:3000,
 //    autoplayHoverPause:true,
 //    responsive:{
 //      600:{
 //       	items:2
 //      },
 //      400:{
 //       	items:1
 //      }
 //    }
	// });

	// /* Custom Select Style */
	// $("select.customSelect").select2({
 //    placeholder: "ALL",
 //    allowClear: false
	// });

	// $("#selectByProgram").on("change",function(){
	// 	//$("#filterForm").trigger("submit");
	// 	var selected = $(this).val();
	// 	var newURL = currentURL;
		
	// 	if(selected=='-1') {
	// 		$(".customSelectWrap").addClass("selected-default");
	// 		window.history.replaceState("",document.title,currentURL);
	// 	} else {
	// 		$(".customSelectWrap").removeClass("selected-default");
	// 		newURL = currentURL + '?programming=' + selected;
	// 		window.history.replaceState("",document.title,newURL);
	// 	}

	// 	$("#loaderDiv").show();

	// 	$("#filterResults").load(newURL + " #tabSchedules",function(){
	// 		$("#filterResults #tabSchedules").addClass("animated fadeIn");
	// 		setTimeout(function(){
	// 			$("#loaderDiv").hide();
	// 		},400);
	// 	});

	// });


	// $(document).on("click","#tabOptions a",function(e){
	// 	e.preventDefault();
	// 	$("#tabOptions li").removeClass('active');
	// 	$(this).parent().addClass('active');
	// 	$(".schedules-list").removeClass('active');
	// 	var tabContent = $(this).attr("data-tab");
	// 	$(tabContent).addClass('active');
	// });

	$(document).on("click",".popdata",function(e){
		e.preventDefault();
		var pageURL = $(this).attr('data-url');
		var actionName = $(this).attr('data-action');
		var pageID = $(this).attr('data-id');

		$.ajax({
			url : frontajax.ajaxurl,
			type : 'post',
			dataType : "json",
			data : {
				'action' : actionName,
				'ID' : pageID
			},
			beforeSend:function(){
				$("#loaderDiv").show();

			},
			success:function( obj ) {
				
				var content = '';
				if(obj) {
					content += '<div class="modaltitleDiv text-center"><h5 class="modal-title">'+obj.post_title+'</h5></div>';
					if(obj.featured_image) {
						var img = obj.featured_image;
						content += '<div class="modalImage"><img src="'+img.url+'" alt="'+img.title+'p" class="feat-image"></div>';
					}
					content += '<div class="modalText"></div>';

					if(content) {
						$("#modalBodyText").html(content);
					}

					$.get(obj.postlink,function(data){
						var textcontent = '<div class="text">'+data+'</div></div>';
						$("#modalBodyText .modalText").html(textcontent);
						$("#activityModal").modal("show");
						$("#loaderDiv").hide();
					});
					
				}
				
			},
			error:function() {
				// alert('error');
				$("#loaderDiv").hide();
			}
		});

	});

});
</script>
