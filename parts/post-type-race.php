<?php 
$page_title = get_the_title();
while ( have_posts() ) : the_post(); ?>
	
	<section class="main-description">
		<div class="wrapper text-center">
			<h1 class="pagetitle"><span><?php echo get_the_title(); ?></span></h1>
			<?php if ( get_the_content() ) { ?>
			<div class="main-text"><?php the_content(); ?></div>
			<?php } ?>
		</div>
	</section>
	

	<div id="pageTabs"></div>

	<?php 
	/* REGISTRATION */
	$register_section_icon = get_field("register_section_icon"); 
	$register_section_title = get_field("register_section_title"); 
	$race_types = get_field("race_types"); 
	$registration_note = get_field("registration_note");

	$has_race_types = '';
	if ( isset($race_types[0]['schedule']) && $race_types[0]['schedule'] ) {
		//$rtypes =implode("",$race_types[0]['schedule']);
		//$rtypes = '';
		$has_race_types = ($race_types[0]['schedule']) ? true : false;
	}


	if($register_section_title || $race_types) { ?>
	<section id="section-registration" data-section="Registration" class="section-content">
		
		<?php if ($register_section_title) { ?>
		<div class="title-w-icon">
			<div class="wrapper">
				<div class="shead-icon text-center">
					<div class="icon"><span class="ci-editor"></span></div>
					<h2 class="stitle" style="color:#FFF;"><?php echo $register_section_title ?></h2>
				</div>
			</div>
		</div>
		<?php } ?>


		<?php if ($has_race_types) { 
			$count = count($race_types); 
			$type_class = 'one-col';
			if($count==2) {
				$type_class = 'two-col';
			} 
			elseif($count==3) {
				$type_class = 'three-col';
			} 
			elseif($count>3) {
				$type_class = 'multi-col';
			}
			?>
		<div class="race-types <?php echo $type_class; ?>">
			<div class="inner-wrap">
				<div class="flexwrap">
					<?php foreach ($race_types as $r) { 
						$name = $r['name'];
						$details = $r['details'];
						$button = $r['button'];
						$button_target = ( isset($button['target']) && $button['target'] ) ? $button['target']:'_self';
						?>
						<div class="type">
							<div class="inside">
								<?php if ($name) { ?>
									<div class="type-name"><h3><?php echo $name ?></h3></div>
								<?php } ?>

								<?php if ($details) { ?>
									<div class="type-details">
										<ul class="info">
											<?php foreach ($details as $d) { 
												$d_title = $d['title'];
												$d_text = $d['text'];
												$d_note = $d['note'];
												if ($d_title) { ?>
												<li>
													<p class="i-title"><?php echo $d_title ?></p>
													<?php if ($d_note) { ?>
													<p class="i-note"><?php echo $d_note ?></p>	
													<?php } ?>
													<?php if ($d_text) { ?>
													<p class="i-text"><?php echo $d_text ?></p>	
													<?php } ?>
												</li>	
												<?php } ?>
											<?php } ?>
										</ul>

										<?php if ($button) { ?>
										<div class="button">
											<a href="<?php echo $button['url'] ?>" target="<?php echo $button_target ?>" class="btn-sm"><span><?php echo $button['title'] ?></span></a>
										</div>
										<?php } ?>
										
									</div>
								<?php } ?>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php } ?>

		<?php 
		$eventInfo = get_field("additional_event_info"); 
		$event_info_btn = get_field("event_info_button_name"); 
		?>
		<?php if ($registration_note || $eventInfo) { ?>
		<div class="black-section">
			<div class="wrapper text-center">
				<?php echo $registration_note; ?>
				<?php if ($eventInfo && $event_info_btn) { ?>
					<div class="buttondiv">
						<a data-toggle="modal" data-target="#additionEventInfo" class="btn-sm xs white popup-event-info"><span><?php echo $event_info_btn ?></span></a>
					</div>			
				<?php } ?>		
			</div>
		</div>	
		<?php } ?>
		
	</section>
	<?php } ?>


	<?php
	/* TEXT AND IMAGE BLOCKS */
	$textImageData = get_field("textImageCol"); ?>
	<?php if ($textImageData) { ?>
	<section class="text-and-image-blocks nomtop">
		<div class="columns-2">
		<?php $i=1; foreach ($textImageData as $s) { 
			$e_title = $s['title'];
			$e_text = $s['text'];
			$btn = $s['button'];
			$btnName = ( isset($btn['title']) && $btn['title'] ) ? $btn['title'] : '';
			$btnLink = ( isset($btn['url']) && $btn['url'] ) ? $btn['url'] : '';
			$btnTarget = ( isset($btn['target']) && $btn['target'] ) ? $btn['target'] : '_self';
			$slides = $s['images'];
			$boxClass = ( ($e_title || $e_text) && $slides ) ? 'half':'full';
			if( ($e_title || $e_text) || $slides) {  $colClass = ($i % 2) ? ' odd':' even'; ?>
			<div id="section<?php echo $i?>" class="mscol <?php echo $boxClass.$colClass ?>">
					<?php if ( $e_title || $e_text ) { ?>
					<div class="textcol">
						<div class="inside">

							<div class="info">
								<?php if ($e_title) { ?>
									<h3 class="mstitle"><?php echo $e_title ?></h3>
								<?php } ?>

								<?php if ($e_text) { ?>
									<div class="textwrap">
										<div class="mstext"><?php echo $e_text ?></div>
									</div>
								<?php } ?>

								<?php if ($btnName && $btnLink) { ?>
								<div class="buttondiv">
									<a href="<?php echo $btnLink ?>" target="<?php echo $btnTarget ?>" class="btn-sm xs"><span><?php echo $btnName ?></span></a>
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
			<?php $i++; } ?>
		<?php } ?>
		</div>
	</section>	
	<?php } ?>


	<?php 
	/* SCHEDULE */
	$sched_section_icon = get_field("sched_section_icon"); 
	$sched_section_title = get_field("sched_section_title"); 
	$optional_text = get_field("optional_text"); 
	$sched_section_icon = '';
	$start = get_field("start_date");
	$end = get_field("end_date");
	$event_date = get_event_date_range($start,$end,true);
	if($sched_section_title || $has_race_types) { ?>
	<section id="section-schedule" data-section="Schedule" class="section-content">
		<?php if ($sched_section_title) { ?>
			<div class="title-w-icon">
				<div class="wrapper">
					<div class="shead-icon text-center">
						<div class="icon"><span class="ci-menu"></span></div>
						<h2 class="stitle"><?php echo $sched_section_title ?></h2>
						<?php if ($event_date) { ?>
						<div class="event-date"><?php echo $event_date ?></div>	
						<?php } ?>
					</div>
					<?php if( $optional_text ) { ?>
						<div class="optional-text">
							<?php echo $optional_text; ?>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>


		<?php 
		$stat_filter = get_field("filter_on_off");
		$show_filter = ($stat_filter=='off') ? false : true;
		if ( $has_race_types ) {
				$total_options = ($race_types) ? count($race_types) : 0; ?>
				<div class="filter-section two-options">
					<div class="wrapper">

						<?php if ($show_filter) { ?>
							<?php if($total_options>1) {  ?>
							<div class="filter-wrapper filterstyle customSelectWrap custom-select-wrap2">
								<div class="wrapper">
									<div class="flexwrap">
										<div class="filter-field-group align-center">
											<div class="filter-label">
												<div class="inside"><span>Filter By</span></div>
											</div>

											<div class="select-wrap custom-select-wrap">
												<select id="race-type-option" class="filter-select customSelect">
												<?php $i=1; foreach ($race_types as $r) { 
													$actualName = $r['name']; 
													$alias = $r['alias'];
													$name = ($alias) ? $alias : $actualName;
													$slug = sanitize_title($name);
													$schedule = $r['schedule'];
													?>
													<option value="race-opt<?php echo $i?>"><?php echo $name ?></option>
												<?php $i++; } ?>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php } ?>
						<?php } ?>

						<div class="schedule-information">
							<?php $i=1; 
							$totalTypes = count($race_types);
							foreach ($race_types as $r) { 
								$actualName = $r['name']; 
								$alias = $r['alias'];
								$name = ($alias) ? $alias : $actualName;
								$slug = sanitize_title($name);
								$sched = $r['schedule'];
								$startdate = ( isset($sched['date']) && $sched['date'] ) ? $sched['date'] : '';
								$enddate = ( isset($sched['enddate']) && $sched['enddate'] ) ? $sched['enddate'] : '';
								$singleDay = ($startdate) ? date('l, F j, Y',strtotime($startdate)) : '';
								if($totalTypes==1) {
									$singleDay = ($startdate) ? date('l',strtotime($startdate)) : '';
								}
								$activities = ( isset($sched['schedule']) && $sched['schedule'] ) ? $sched['schedule'] : '';
								$is_active = ($i==1) ? ' active':'';
								$dateRange = '';
								if($startdate && $enddate) {
									$dateRange = get_event_date_range($startdate,$enddate,true);
								}
								$day = ($dateRange) ? $dateRange : $singleDay;
								?>
								<div id="race-opt<?php echo $i?>" class="schedule-info schedule <?php echo $is_active ?>">
									<?php if ($day) { ?>
									<div class="day"><span><?php echo $day ?></span></div>	
									<?php } ?>

									<?php if ($activities) { ?>
									<ul class="activities">
										<?php foreach ($activities as $a) { 
											$time = $a['time'];
											$event = $a['action'];
											if($time || $action) { ?>
											<li class="info">
												<div class="wrap">
													<span class="time"><span><?php echo $time ?></span></span>
													<span class="event"><span><?php echo $event ?></span></span>
												</div>
											</li>	
											<?php } ?>
										<?php } ?>
									</ul>	
									<?php } ?>
								</div>
							<?php $i++; } ?>
						</div>
					</div>
				</div>
		<?php } ?>


	</section>
	<?php } ?>

	<?php 
	/* COURSE MAP */
	//$course_section_icon = get_field("course_section_icon"); 
	$course_section_title = get_field("course_section_title"); 
	$course_images = get_field("course_images"); 
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

		<?php if ($course_images) { 
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
		<?php } ?>
	</section>
	<?php } ?>

	<?php
	/* AWARDS */
	$awards = get_field("awards");
	$a_col_icon1 = ( isset($awards['COL1_icon']) && $awards['COL1_icon'] ) ? $awards['COL1_icon']:'';
	$a_col_title1 = ( isset($awards['COL1_title']) && $awards['COL1_title'] ) ? $awards['COL1_title']:'';
	$a_col_desc1 = ( isset($awards['COL1_description']) && $awards['COL1_description'] ) ? $awards['COL1_description']:'';
	$a_col_text1 = ( isset($awards['COL1_text1']) && $awards['COL1_text1'] ) ? $awards['COL1_text1']:'';
	$a_col_text2 = ( isset($awards['COL1_text2']) && $awards['COL1_text2'] ) ? $awards['COL1_text2']:'';
	
	$a_col_icon2 = ( isset($awards['COL2_icon']) && $awards['COL2_icon'] ) ? $awards['COL2_icon']:'';
	$a_col_title2 = ( isset($awards['COL2_title']) && $awards['COL2_title'] ) ? $awards['COL2_title']:'';
	$a_col_content2 = ( isset($awards['COL2_columns']) && $awards['COL2_columns'] ) ? $awards['COL2_columns']:'';
	
	$awards_content = array($a_col_title1,$a_col_desc1,$a_col_text1,$a_col_text2);
	if( ($awards_content && array_filter($awards_content )) || ($a_col_title2 && $a_col_content2) ) { ?>
	<section id="section-awards" data-section="Results & Awards" class="section-content">
		<div class="flexwrap">

			<?php if ($awards_content && array_filter($awards_content )) { ?>
				<div class="awards-columns awards">
					<div class="inside">
						<?php if ( $a_col_icon1 || $a_col_title1 ) { ?>
							<div class="col-title">
								<?php if ($a_col_icon1) { ?>
									<div class="icon-img"><span style="background-image:url('<?php echo  $a_col_icon1['url']?>')"></span></div>
								<?php } ?>
								<?php if ($a_col_title1) { ?>
									<h2 class="stitle"><?php echo $a_col_title1 ?></h2>
								<?php } ?>
							</div>
						<?php } ?>
						
						<?php if ( $a_col_desc1 || $a_col_text1 ||  $a_col_text2 ) { ?>
							<div class="col-content">
								<?php if ($a_col_desc1) { ?>
								<div class="text1<?php echo (empty($a_col_text1)) ? ' nombottom':'' ?>	"><?php echo $a_col_desc1 ?></div>	
								<?php } ?>

								<?php if ($a_col_text1) { ?>
								<div class="text2">
									<?php
									$a_col_text1 = str_replace('|',' <span class="red">|</span> ',$a_col_text1); 
									echo $a_col_text1 
									?>
									
								</div>	
								<?php } ?>

								<?php if ($a_col_text2) { ?>
								<div class="text3 ribbon">
									<div class="layer1">
										<div class="layer2"><?php echo $a_col_text2 ?></div>
									</div>
								</div>	
								<?php } ?>
							</div>
						<?php } ?>
					</div>
				</div>
			<?php } ?>

			<?php if ($a_col_title2 && $a_col_content2) { ?>
				<?php $col_count = ($a_col_content2) ? count($a_col_content2) : 0;  ?>
				<div class="awards-columns result col-count-<?php echo $col_count?>">
					<div class="inside">
						<div class="col-title">
							<?php if ($a_col_icon2) { ?>
								<div class="icon-img"><span style="background-image:url('<?php echo  $a_col_icon2['url']?>')"></span></div>
							<?php } ?>

							<?php if ($col_count==1) { ?>

								<?php if ( isset($a_col_content2[0]['title']) && $a_col_content2[0]['title'] ) { ?>
								<h2 class="stitle"><?php echo $a_col_content2[0]['title']; ?></h2>
								<?php } else { ?>
									<?php if ($a_col_title2) { ?>
										<h2 class="stitle"><?php echo $a_col_title2 ?></h2>
									<?php } ?>
								<?php } ?>
								
							<?php } else { ?>
								<?php if ($a_col_title2) { ?>
									<h2 class="stitle"><?php echo $a_col_title2 ?></h2>
								<?php } ?>
							<?php } ?>
						</div>

						<?php if ($a_col_content2) { ?>
						<div class="col-content col-count-<?php echo $col_count?>">
							<div class="wrap">
								<?php foreach ($a_col_content2 as $col) { 
									$c_title = $col['title'];
									$c_text = $col['text'];
									if($c_title || $c_text) { ?>
									<div class="result-data">

										<?php if ($col_count>1) { ?>
											<?php if ($c_title) { ?>
											<h3 class="h3"><?php echo $c_title ?></h3>	
											<?php } ?>
										<?php } ?>

										<?php if ($c_text) { ?>
										<div class="rtext"><?php echo $c_text ?></div>	
										<?php } ?>
									</div>
									<?php } ?>
								<?php } ?>
							</div>
						</div>	
						<?php } ?>
					</div>
				</div>
			<?php } ?>

		</div>
	</section>
	<?php } ?>


	<?php 
	/* FAQ */ 
	//get_template_part("parts/content-faqs-race"); 
	//$faqVisible = get_field("faqs_visibility");
	//$showFAQs = ( isset($faqVisible[0]) && $faqVisible[0]=='hide' ) ? false : true;
	if( is_faqs_visible() ) {
		$useDefaultFAQIcon = true;
		$customFAQTitle = (get_field("faq_section_title")) ? get_field("faq_section_title") : 'FAQ';
		include( locate_template('parts/content-faqs.php') ); 
		include( locate_template('inc/faqs-script.php') );  /* FAQS JAVASCRIPT */
	} ?>
<?php endwhile; ?>

<?php  
/* Similar Events */ 
get_template_part("parts/similar-posts"); 
?>


<?php
/* EVENT SPONSORS */
$sponsor_section_title = get_field("sponsor_section_title");  
$sponsors = get_field("race_sponsors_logo");  
if($sponsors) { ?>
<section id="section-sponsors" class="section-content">
	<div class="wrapper">
		<?php if ($sponsor_section_title) { ?>
		<div class="titlediv">
			<h2 class="sectionTitle text-center"><?php echo $sponsor_section_title ?></h2>
		</div>
		<?php } ?>
		
		<div class="sponsors-list">
			<div class="flexwrap">
				<?php foreach ($sponsors as $s) { 
				$link = get_field("image_website",$s['ID']);
				?>
				<span class="sponsor">
					<?php if ($link) { ?>
						<a href="<?php echo $link ?>" target="_blank"><img src="<?php echo $s['url'] ?>" alt="<?php echo $s['title'] ?>"></a>
					<?php } else { ?>
						<img src="<?php echo $s['url'] ?>" alt="<?php echo $s['title'] ?>">
					<?php } ?>
				</span>	
				<?php } ?>
			</div>
		</div>
	</div>
</section>
<?php } ?>

<?php /* ADDITIONAL EVENT INFO MODAL */ ?>
<?php if ($eventInfo) { ?>
<div class="modal customModal fade" id="additionEventInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<!-- <div class="modaltitleDiv text-center">
      		<h5 class="modal-title"><?php //echo $page_title ?></h5>
      	</div> -->
      	<div class="modalText">
      		<div class="text"><?php echo $eventInfo ?></div>
      	</div>
      </div>
    </div>
  </div>
</div>
<?php } ?>

<script>
jQuery(document).ready(function($){

	if( $(".customModal").length>0 ) {
		$(".customModal").insertAfter("#page");
	}

	$("select.customSelect").select2({
    placeholder: "ALL",
    allowClear: false,
    dropdownParent: $('.custom-select-wrap')
	});

	// $("select.jsselect2").select2({
 //    placeholder: "ALL",
 //    allowClear: false,
 //    dropdownParent: $('.custom-select-wrap')
	// });

	$("#race-type-option").on('change',function(){
		var opt = $(this).val();
		$(".schedule-info").removeClass("active");
		$(".schedule-info#" + opt).addClass('active');
	});

	/* FAQS */
	// $(".faqsItems .collapsible").on("click",function(){
	// 	if( $(this).hasClass('active') ) {
	// 		$(this).removeClass("active fadeIn");
	// 	} else {
	// 		$(".faqsItems .collapsible").removeClass("active fadeIn");
	// 		$(this).addClass("active fadeIn");
	// 	}
	// });

	/* page anchors */
	if( $('[data-section]').length > 0 ) {
		var tabs = '';
		$('[data-section]').each(function(){
			var name = $(this).attr('data-section');
			var id = $(this).attr("id");
			tabs += '<span class="mini-nav"><a href="#'+id+'">'+name+'</a></span>';
		});
		$("#pageTabs").html('<div class="wrapper"><div id="tabcontent">'+tabs+'</div></div>');
	}

});	
</script>