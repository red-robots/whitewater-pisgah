<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package bellaworks
 */

get_header(); 
$placeholder = THEMEURI . 'images/rectangle.png';
$square = THEMEURI . 'images/square.png';
$post_type = get_post_type();
$heroImage = get_field("full_image");
$flexbanner = get_field("flexslider_banner");
$has_hero = 'no-banner';
if($heroImage) {
	$has_hero = ($heroImage) ? 'has-banner':'no-banner';
} else {
	if($flexbanner) {
		$has_hero = ($flexbanner) ? 'has-banner':'no-banner';
	}
}

get_template_part("parts/subpage-banner");
$post_id = get_the_ID(); 
$currentPostId = $post_id;
//$currentpageURL = get_permalink();
$is_filtered = ( isset($_GET['programming']) && $_GET['programming'] ) ? $_GET['programming'] : '';
?>
	
<div id="primary" class="content-area-full content-default single-post <?php echo $has_hero;?> post-type-<?php echo $post_type;?>">

		<main id="main" data-postid="post-<?php the_ID(); ?>" class="site-main" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
			<section class="text-centered-section">
				<div class="wrapper text-center">
					<div class="page-header">
						<h1 class="page-title"><?php the_title(); ?></h1>
					</div>
					<?php the_content(); ?>
				</div>
			</section>

			<?php get_template_part("parts/subpage-tabs"); ?>
				
			<?php 
			$start_date = get_field("start_date");
			$start_date = ($start_date) ? date('F j, Y',strtotime($start_date)):'';
			$price = get_field("price");

			$start = get_field("start_date");
			$end = get_field("end_date");
			//$event_date = get_event_date_range($start,$end); /* with leading zero */
			$event_date = date_range_no_leading_zero($start,$end,true);


			$optionsVal = array($start_date,$price);
			$options[] = array('Date',$event_date);
			$options[] = array('Price',$price);
			?>

			<?php if ($optionsVal && array_filter($optionsVal)) { $countOpts = count(array_filter($optionsVal)); ?>
			<section class="section-price-ages full <?php echo ($countOpts==1) ? 'oneCol':'twoCols';?>">
				<div class="flexwrap">
					<?php foreach ($options as $e) { ?>
						<?php if ($e[1]) { ?>
						<div class="info">
							<div class="wrap">
								<div class="label"><?php echo $e[0]; ?></div>
								<div class="val"><?php echo $e[1]; ?></div>
							</div>
						</div>	
						<?php } ?>	
					<?php } ?>
				</div>
			</section>
			<?php } ?>


			<?php 
			if( $galleries = get_field("gallery") ) { ?>
			<section class="gallery-section full">
				<div id="carousel-images">
					<div class="loop owl-carousel owl-theme">
					<?php foreach ($galleries as $g) { ?>
						<div class="item">
							<div class="image" style="background-image:url('<?php echo $g['url']?>')">
								<img src="<?php echo $placeholder ?>" alt="" aria-hidden="true" />
							</div>
						</div>
					<?php } ?>
					</div>
				</div>
			</section>
			<?php } ?>


		<?php endwhile; ?>


			<?php /* SCHEDULE */ ?>
			<?php
			$activities = get_field("festival_activities");
			$schedule_image = get_field("schedule_image");
			$schedule_dates = get_field("schedule_dates");
			if($activities) { ?>
			<section id="section-schedule" data-section="SCHEDULE" class="section-content">
				<div class="wrapper">
					<div class="shead-icon text-center">
						<div class="icon"><span class="ci-menu"></span></div>
						<h2 class="stitle">SCHEDULE</h2>
						<?php if ($schedule_dates) { ?>
						<p class="eventDates"><?php echo $schedule_dates ?></p>	
						<?php } ?>
					</div>

					<?php
					$options = get_festival_programming_filter( get_the_ID() );
					if($options) { ?>
					<div class="double-filter-wrapper">
						<div class="inside">
					
					<div class="filter-wrapper filterstyle customSelectWrap">
						<div class="wrapper">
							<div class="filter-inner">
								<form action="" method="get" id="filterForm">
									<div class="flexwrap">

										<div class="filter-label">
											<div class="inside"><span>Filter</span></div>
										</div>

										<div class="select-wrap">
											<select name="programming" id="selectByProgram" class="customSelect">
												<option></option>
												<option value="-1">ALL</option>
												<?php foreach ($options as $opt) { 
													$term_name = $opt['term_name'];
													$postArrs = ($opt['term_posts']) ? array_unique($opt['term_posts']) : '';
													$term_posts = ($postArrs) ? implode("%2C",$postArrs):'';
													$term_strs = ($postArrs) ? implode(",",$postArrs):'';
													$selected = ($term_strs==$is_filtered) ? ' selected':'';
													?>
													<option value="<?php echo $term_posts?>"<?php echo $selected?>><?php echo $term_name?></option>
												<?php } ?>
											</select>
										</div>
										
									</div>
								</form>
							</div>
						</div>
					</div>
					
					</div>
					<div class="inside">
						<div class="filter-wrapper filterstyle customSelectWrap diff-filter-wrap hide">
						<div class="wrapper">
							<div class="filter-inner">
								
									<div class="flexwrap">

										<div class="filter-label">
											<div class="inside"><span>Level</span></div>
										</div>
										<?php 
											$diff = get_terms('difficulty', array('hide_empty' => true ));
											// echo '<pre>';
											// print_r($diff);
											// echo '</pre>';
										 ?>
										<div id="fi" class="select-wrap ">
											<div class="types">
										<!-- <select name="programming" id="selectByProgram" class="customSelect"> -->
												<select id="diff" class="option-set clearfix customSelect"  data-filter-group="type" >
												<option value=".all" data-filter-value=".all" class="selected">ALL</option>
												<?php foreach( $diff as $v ) { ?>
													<option value=".<?php echo $v->slug; ?>" data-filter-value=".<?php echo $v->slug; ?>"><?php echo $v->name; ?></option>
												<?php } ?>
												</select>
											</div>
										</div>
										
									</div>
								
							</div>
						</div>
					</div>
					</div>
					</div>
					<?php } ?>
					<?php 
						$schPrompt = get_field('schedule_prompt'); 
						if( $schPrompt != '' ) {
							echo '<div class="sch-prompt">'.$schPrompt.'</div>';
						}
					?>
					<?php

					/*=== SCHEDULE ===*/ 
					if ($is_filtered) { /* FILTERED SCHEDULE */ 
						$posts_selected = explode(",",$is_filtered);
						$filter_activites = array();
						$selected_activities = array();
						foreach ($activities as $a) { 
							$schedules = $a['schedule'];
							$day = $a['day'];
							$daySlug = ($day) ? sanitize_title($day) : '';
							if($schedules) {
								foreach ($schedules as $s) { 
									$time = $s['time'];
									$altText = ( isset($s['alt_text']) && $s['alt_text'] ) ? $s['alt_text']:'';
									$is_pop_up = ( isset($s['popup_info'][0]) && $s['popup_info'][0] ) ? true : false;
									$act = ( isset($s['activity']) && $s['activity'] ) ? $s['activity']:'';
									if($act) {
										$id = $act->ID;
										$act->schedule = $time;
										$act->popup_info = $is_pop_up;
										$act->alt_text = $altText;
										if( in_array($id,$posts_selected) ) {
											$filter_activites[$day][] = $act;
										}
									}
								}
							}
						}

						?>
						
						<?php 
							if ($filter_activites) { 
							$diff = '';?>
						<div class="hide-on-load hide">
							<div id="filterResults" class="full filterResults ">
								<div id="tabSchedules" class="schedules-list-wrap">
									<div id="tabOptions">
										<ul>
										<?php $n=1; foreach ($filter_activites as $day=>$objs) {
											if($day) {
												$tabActive = ($n==1) ? ' active':''; ?>
												<li class="tablink<?php echo $tabActive?>"><a href="#" data-tab="#daygroup<?php echo $n?>"><?php echo ucwords($day)?></a></li>
											<?php $n++; } ?>
										<?php } ?>
										</ul>
									</div>
									<div class="scheduleContent">
									<?php 
									$ctr=1; 
									// echo '<pre>';
									// print_r($filter_activites);
									foreach ($filter_activites as $day=>$items) {
									$isActive = ($ctr==1) ? ' active':'';  
									?>
									<div id="daygroup<?php echo $ctr?>" class="schedules-list<?php echo $isActive?>">
										<h3 class="day" style="display:none;"><?php echo ucwords($day) ?></h3>
										<ul class="items">
											<?php foreach ($items as $m) {
												$pid = $m->ID; 
												$pageLink = get_permalink($pid);
												$activityName = $m->post_title;
												$is_pop_up = (isset($m->popup_info) && $m->popup_info) ? true : false;
												$altText = (isset($m->alt_text) && $m->alt_text) ? $m->alt_text : '';
												
												
												$diff = get_the_terms($m->ID, 'difficulty' );
												$dSlug = $diff[0]->slug;
												$tTime = $m->schedule;
												if( $tTime == $aTime ) {
													$tTime = '';
												}
												// echo '<pre>';
												// print_r($dSlug);
												// echo '</pre>';
												?>
												<!-- filtered results -->
												<li class="item <?php if($dSlug !=''){echo $dSlug;} ?>">
													<div class="time">
														<?php echo $tTime; ?>
													</div>
													<div class="event">
														<?php if ($is_pop_up) { ?>
														<a href="#" data-url="<?php echo $pageLink ?>" data-action="ajaxGetPageData" data-id="<?php echo $pid ?>" class="actname popdata"><?php echo $activityName ?></a>	
														<?php } else { ?>
														<span class="actname"><?php echo $activityName ?></span>	
														<?php } ?>

														<?php if ($altText) { ?>
														<span class="alttext">(<?php echo $altText ?>)</span>
														<?php } ?>
													</div>
												</li>
												<?php $aTime = $m->schedule; ?>
											<?php } ?>
										</ul>
									</div>
									<?php $ctr++; } ?>
									</div>
								</div>
						</div>
							<?php } else { ?>
							<p style="text-align:center;">Nothing found.</p>
							<?php } ?>
							</div>
						<?php } else { ?>
						<div class="hide-on-load hide">
							<?php 
							/* Will not display any data. This is required for the FacetWP dropdown to work. */
							$args = array(
								'posts_per_page'=> 1,
								'post_type'			=> 'festival_activity',
								'orderby' 			=> 'ID',
							  	'order'    			=> 'DESC',
								'post_status'		=> 'publish',
								'facetwp'				=> true
							);
							$festivalActivites = new WP_Query($args);
							if( $festivalActivites->have_posts() ) {
		 						while ( $festivalActivites->have_posts()) : $festivalActivites->the_post();
		 						endwhile; wp_reset_postdata();
							}
							?>
							<?php $diff = ''; ?>
							<div id="filterResults" class="full filterResults">
								<div id="tabSchedules" class="schedules-list-wrap">
									<div id="tabOptions">
										<ul>
										<?php $n=1; foreach ($activities as $a) {
											$day = ($a['day']) ? ucwords($a['day']) : ''; 
											if($day) {
												$tabActive = ($n==1) ? ' active':''; ?>
												<li class="tablink<?php echo $tabActive?>"><a href="#" data-tab="#daygroup<?php echo $n?>"><?php echo $day?></a></li>
											<?php $n++; } ?>
										<?php } ?>
										</ul>
									</div>
									<div class="scheduleContent">
									<?php $ctr=1; foreach ($activities as $a) { 
										
										// echo $a->activity->ID;
										
										$day = $a['day'];
										$aTime = '';
										$daySlug = ($day) ? sanitize_title($day) : '';
										$schedules = $a['schedule'];
										$isActive = ($ctr==1) ? ' active':'';
										if($schedules) { ?>
										<div id="daygroup<?php echo $ctr?>" class="schedules-list<?php echo $isActive?>">
											<?php if ($day) { ?>
											<h3 class="day"><?php echo ucwords($day) ?></h3>
											<?php } ?>
											<ul class="items">
												<?php foreach ($schedules as $s) { 
													$act = ( isset($s['activity']) && $s['activity'] ) ? $s['activity']:'';
													$activityName = ($act) ? $act->post_title :'';
													$activityID = ($act) ? $act->ID :'';
													$is_pop_up = ( isset($s['popup_info'][0]) && $s['popup_info'][0] ) ? true : false;
													$altText = ( isset($s['alt_text']) && $s['alt_text'] ) ? $s['alt_text']:'';
													if($activityName && $altText) {
														$altText = ' ('.$altText.')';
													}
													$pageLink = ($activityID) ? get_permalink($activityID) : '#';
													$dPiD = $s['activity']->ID;
													$diff = get_the_terms($dPiD, 'difficulty' );
													// echo $diff[0]->slug;
													// echo '<pre>';
													// print_r($diff);
													$tTime = $s['time'];
													if( $tTime == $aTime ) {
														$tTime = '';
													}
												?>
												<!-- non filtered results -->
												<li class="item <?php if($diff[0]->slug){echo $diff[0]->slug;} if($tTime==''){echo ' sametime';}else{echo ' diff';}?>">
													<div class="time"><?php echo $tTime//$s['time'] ?></div>
													<div class="event">
														<?php if ($activityName) { ?>
															<?php if ($is_pop_up && $activityID) { ?>
															<a href="#" data-url="<?php echo $pageLink ?>" data-action="ajaxGetPageData" data-id="<?php echo $activityID ?>" class="actname popdata"><?php echo $activityName ?></a>	
															<?php } else { ?>
															<span class="actname"><?php echo $activityName ?></span>	
															<?php } ?>
														<?php } ?>

														<?php if ($altText) { ?>
														<span class="alttext"><?php echo $altText ?></span>
														<?php } ?>
													</div>
												</li>
												<?php $aTime = $s['time']; ?>
												<?php } ?>
											</ul>
										</div>
										<?php $ctr++; } ?>
									<?php } ?>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>

				<?php if ($schedule_image) { ?>
				<div id="eventMap" data-section="Event Map" class="schedule-image-wrap full">
					<div class="wrapper">
						<a href="<?php echo $schedule_image['url']; ?>" target="_blank">
							<img src="<?php echo $schedule_image['url'] ?>" alt="<?php echo $schedule_image['title'] ?>" class="feat-img">
						</a>
					</div>
				</div>					
				<?php } ?>
			</section>
			<?php } ?>
			<?php 
				// echo '<pre>';
				// print_r($schedule_image);
				// echo '</pre>';
			 ?>


			<?php /* ACTIVITIES */ ?>
			<?php if( $bottom_activities = get_field("festival_activities_bottom") ) { 
				$countActivities = count($bottom_activities);
			?>
			<section id="section-activities" data-section="Programming" class="section-content camp-activities countItems<?php echo $countActivities?>">
				<div class="wrapper titlediv">
					<div class="shead-icon text-center">
						<div class="icon"><span class="ci-task"></span></div>
						<h2 class="stitle">Programming</h2>
					</div>
				</div>

				<div class="entryList flexwrap">
					<?php $b=1; foreach ($bottom_activities as $ba) {
						$pid = $ba->ID;
						$title = $ba->post_title;
						$description = ($ba->post_content) ? shortenText(strip_shortcodes(strip_tags($ba->post_content)),300," ","..."):'';
						$excerpt = $ba->post_excerpt;
						$thumbnail = get_field("thumbnail_image",$pid);
						$buttonLink = get_permalink($pid);
						$contentType = get_field("content_display_type",$pid);
						$is_popup = ($contentType=='pagelink') ? false : true;
						$url = get_field("pagelink",$pid);
						$btnURL = ( isset($url['url']) && $url['url'] ) ? $url['url'] : '';
						$btnText = ( isset($url['title']) && $url['title'] ) ? $url['title'] : '';
						$btnTarget = ( isset($url['target']) && $url['target'] ) ? $url['target'] : '_self';
						if($contentType=='nobutton') {
							$is_popup = false;
							$btnURL = '';
							$btnText = '';
						}
					?>
					<div id="entryBlock<?php echo $b?>" class="fbox <?php echo ($thumbnail) ? 'hasImage':'noImage'; ?>">
						<div class="inside text-center">
							<div class="imagediv <?php echo ($thumbnail) ? 'hasImage':'noImage'?>">
								<?php if ($thumbnail) { 
										if ($is_popup) { ?>
											<a href="#" data-url="<?php echo $pageLink ?>" data-action="ajaxGetPageData" data-id="<?php echo $pid ?>" class=" ajaxLoadContent popdata">
										<?php } else { ?>
											<a href="<?php echo $btnURL ?>" target="<?php echo $btnTarget ?>" class=" ">
										<?php } ?>
											<span class="img" style="background-image:url('<?php echo $thumbnail['url']?>')"></span>
										</a>
								<?php } ?>
								<img src="<?php echo $placeholder ?>" alt="" aria-hidden="true" class="placeholder">
							</div>
							<div class="titlediv">
								<p class="name"><?php echo $title ?></p>
								<?php if ($excerpt) { ?>
								<div class="excerpt"><?php echo $excerpt; ?></div>	
								<?php } ?>

								<?php if ($is_popup) { ?>
									<div class="buttondiv">
										<a href="#" data-url="<?php echo $pageLink ?>" data-action="ajaxGetPageData" data-id="<?php echo $pid ?>" class="btn-sm ajaxLoadContent popdata"><span>See Details</span></a>	
									</div>
								<?php } else { ?>
									<?php if ( ($btnURL && $btnText) && $contentType=='pagelink' ) { ?>
									<div class="buttondiv">
										<a href="<?php echo $btnURL ?>" target="<?php echo $btnTarget ?>" class="btn-sm xs btn-link"><span><?php echo $btnText ?></span></a>	
									</div>
									<?php } ?>
								<?php } ?>
							</div>
						</div>
					</div>
					<?php $b++; } ?>
				</div>
			</div>
			</section>

			<?php } ?>


			<?php  /* FAQ */ 
				$customFAQTitle = 'FAQ';
				include( locate_template('parts/content-faqs.php') ); 
			?>


		</main>

	</div>


<?php get_template_part("parts/similar-posts"); ?>


<?php  
/* EVENT SPONSORS */ 
$sponsor_section_title = "Event Sponsors";
if($sponsors = get_field("sponsors_logo")) { ?>
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
	$('.loop').owlCarousel({
    center: true,
    items:2,
    nav: true,
    loop:true,
    margin:15,
    autoplay:true,
    autoplayTimeout:3000,
    autoplayHoverPause:true,
    responsive:{
      600:{
       	items:2
      },
      400:{
       	items:1
      }
    }
	});

	/* Custom Select Style */
	$("select.customSelect").select2({
    placeholder: "ALL",
    allowClear: false
	});

	$("#selectByProgram").on("change",function(){
		//$("#filterForm").trigger("submit");
		var selected = $(this).val();
		var newURL = currentURL;
		
		if(selected=='-1') {
			$(".customSelectWrap").addClass("selected-default");
			window.history.replaceState("",document.title,currentURL);
		} else {
			$(".customSelectWrap").removeClass("selected-default");
			newURL = currentURL + '?programming=' + selected;
			window.history.replaceState("",document.title,newURL);
		}

		$("#loaderDiv").show();

		$("#filterResults").load(newURL + " #tabSchedules",function(){
			$("#filterResults #tabSchedules").addClass("animated fadeIn");
			setTimeout(function(){
				$("#loaderDiv").hide();
			},400);
		});

	});


	$(document).on("click","#tabOptions a",function(e){
		e.preventDefault();
		$("#tabOptions li").removeClass('active');
		$(this).parent().addClass('active');
		$(".schedules-list").removeClass('active');
		var tabContent = $(this).attr("data-tab");
		$(tabContent).addClass('active');
	});

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
				$("#loaderDiv").hide();
			}
		});

	});

});
</script>
<?php
include( locate_template('inc/pagetabs-script.php') );  
include( locate_template('inc/faqs.php') );  
get_footer();
