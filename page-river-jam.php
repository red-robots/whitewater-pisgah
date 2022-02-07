<?php
/**
 * Template Name: River Jam
 */

get_header(); 
$blank_image = THEMEURI . "images/square.png";
$square = THEMEURI . "images/square.png";
$rectangle = THEMEURI . "images/rectangle-lg.png";
?>


<div id="primary" data-post="<?php echo get_the_ID()?>" class="content-area-full riverjam">
	<?php while ( have_posts() ) : the_post(); ?>
		<section class="text-centered-section">
			<div class="wrapper text-center">
				<div class="page-header">
					<h1 class="page-title"><?php the_title(); ?></h1>
				</div>
				<?php if ( get_the_content() ) { ?>
				<div class="text"><?php the_content(); ?></div>
				<?php } ?>
			</div>
		</section>
	<?php endwhile;  ?>

	<?php get_template_part("parts/subpage-tabs"); ?>

	<?php /* UPCOMING */ ?>
	<?php if( $upcoming = get_upcoming_bands() ) { ?>
	<section id="upcoming" data-section="Upcoming" class="section-content">
		<div class="redDiv text-center">
			<h2 class="stitle">Upcoming</h2>
		</div>
		<div class="upcoming-posts">
			<div class="flexwrap">
				<?php 
				$noInclude = array();
				foreach ($upcoming as $row) { 
					$pid = $row->ID;
					$noInclude[] = $pid;
					// echo $pid;
					$title = $row->post_title;
					$start_date = ( isset($row->start_date) && $row->start_date ) ? $row->start_date : '';
					// comment out the line below to hide schedule
					$start_day = ($start_date) ? date('l',strtotime($start_date)) : '';
					$image = get_field("thumbnail_image",$pid);
					$helper = THEMEURI . "images/rectangle-lg.png";
					$has_image = ($image) ? 'has-image':'no-image';
					$style = ($image) ? ' style="background-image:url('.$image['url'].')"':'';
					$start_date_format = '';
					if($start_date) {
						$c_month = date('M',strtotime($start_date));
						$period = ($c_month!='MAY') ? '. ':'';
						$start_date_format = date('M',strtotime($start_date)) . $period . date('j',strtotime($start_date));
					}
					$short_description = get_field("short_description",$pid);
					// $schedule = get_field("schedule_repeater",$pid);
					// $schedule_title = get_field("schedule_title",$pid);

					$schedules = array();
					$schedule_title = get_field("rj_heading","option");	
					$scheduleItems = get_field("rj_schedules","option");
					$xstartDay = ($start_day) ? strtolower( preg_replace('/\s+/', '', $start_day) ) : '';
					if($scheduleItems) {
						foreach($scheduleItems as $e) {
							$e_day = $e['day'];
							$e_schedule = $e['schedule'];
							$e_day = ($e_day) ? strtolower( preg_replace('/\s+/', '', $e_day) ) : '';
							if($e_day && ($e_day==$xstartDay) ) {
								$schedules = $e_schedule;
							}
						}
					}
				?>
				<div data-postid='<?php echo $pid ?>' data-startdate="<?php echo $start_date ?>" data-title="<?php echo $start_day ?>" class="entry <?php echo $has_image ?>">
					<div class="inside">
						<div class="titlediv">
							<h2 class="day"><?php echo $start_day ?></h2>
							<p class="date"><?php echo $start_date_format ?></p>
							<h3 class="title"><span><?php echo $title ?></span></h3>
						</div>
						<div class="photo <?php echo $has_image ?>"<?php echo $style ?>>
							<img src="<?php echo $helper ?>" alt="" aria-hidden="true" class="helper">
						</div>
						<?php if ($short_description) { ?>
						<div class="description text-center js-blocks">
							<div class="text"><?php echo $short_description ?></div>
						</div>
						<?php } ?>

						<?php /* SCHEDULE */ 
								// echo '<pre>';
								// print_r($xstartDay);
								// echo '</pre>';

						?>
						<?php if ($schedules) { ?>
						<div class="schedule schedules-list">
							<h3 class="t1"><?php echo ($schedule_title) ? $schedule_title : 'Schedule' ?></h3>
							<ul class="items">
							<?php $ctr=1; foreach ($schedules as $s) { 
								$time = $s['time'];
								if($time) {
									$altText = ( isset($s['alt_text']) && $s['alt_text'] ) ? $s['alt_text']:'';
									$is_pop_up = ( isset($s['popup_info'][0]) && $s['popup_info'][0]=='yes' ) ? true : false;
									$act = ( isset($s['program']) && $s['program'] ) ? $s['program']:'';
									$activityName = '';
									$pageLink = '';
									$pid = '';
									if($act) {
										$pid = $act->ID;
										$activityName = $act->post_title;
										$pageLink = get_permalink($id);
										$altText = ($altText) ? '('.$altText.')' : '';
									}
									?>
									<li class="item timerow-<?php echo $ctr?>">
										<div class="time"><?php echo $time ?></div>
										<div class="event">
											<?php if ($is_pop_up) { ?>
												<?php if ($act) { ?>
													<a href="#" data-url="<?php echo $pageLink ?>" data-action="ajaxGetPageData" data-id="<?php echo $pid ?>" class="actname popdata"><?php echo $activityName ?></a>	
												<?php } ?>
											<?php } else { ?>
												<span class="actname"><?php echo $activityName ?></span>	
											<?php } ?>

											<?php if ($altText) { ?>
											<span class="alttext"><?php echo $altText ?></span>
											<?php } ?>
										</div>
									</li>
								<?php $ctr++; } ?>
							<?php } ?>
							</ul>
						</div>
						<?php } ?>

					</div>
				</div>	
				<?php } ?>
			</div>
		</div>
	</section>
	<?php } ?>

	<?php /* UPCOMING BANDS BY DATE */ ?>
	<?php 
	// get_template_part("parts/filter-river-jam"); 
	// include this way to pass variables. sending post id's from above to not include on the next query
	include(locate_template('parts/filter-river-jam.php'));
	?>


	<?php  
	/* PROGRAMS */
	// $args = array(
	// 	'post_type'				=> 'jam-programs',
	// 	'posts_per_page'	=> -1,
	// 	'post_status'			=> 'publish'
	// );
	// $programs = new WP_Query($args);
	//if( $programs->have_posts() ) { 
	$programs = get_field("rj_programming","option");
	// echo '<pre>';
	// print_r($programs);
	// echo '</pre>';
	if($programs) { ?>	
	<section id="riverjam-programs" data-section="Programs" class="section-content menu-sections">
		<div class="wrapper">
			<div class="shead-icon text-center">
				<div class="icon"><span class="ci-task"></span></div>
				<h2 class="stitle">PROGRAMS</h2>
			</div>
		</div>
		<div class="columns-2 text-and-images">
			<?php $i=1; foreach($programs as $p) {
				$xid = $p->ID;
				$slides = get_field("featured_images",$xid);
				$boxClass = ( $slides ) ? 'half':'full'; 
				$colClass = ($i % 2) ? ' odd':' even';
				//$excerpt = ( get_the_content($xid) ) ? shortenText( strip_tags(get_the_content($xid)),300,' ','...' ) : '';
				//$programText = ($p->post_content) ? shortenText( strip_tags($p->post_content),250,' ','...' ) : '';
				$programText = ($p->post_content) ? strip_shortcodes($p->post_content) : '';
				$programText = ($programText) ? shortenText( strip_tags($programText),280,' ','...' ) : '';
				$title = $p->post_title;
				$pagelink = get_permalink($xid);
				$helper = THEMEURI . 'images/rectangle-narrow.png';
				$excerpt = get_field("short_description",$xid);
				$program_description = '';
				if($excerpt) {
					$program_description = $excerpt;
				} else {
					$program_description = $programText;
				}
				?>
				<div id="section<?php echo $i?>" class="mscol <?php echo $boxClass.$colClass ?>">
					<div class="textcol">
						<div class="inside">
							<div class="info">
								<h3 class="mstitle"><?php echo $title; ?></h3>
								<?php if ($program_description) { ?>
								<div class="textwrap"><?php echo $program_description; ?></div>
								<div class="buttondiv">
									<a href="#" data-url="<?php echo $pagelink; ?>" data-action="ajaxGetPageData" data-id="<?php echo $xid ?>" class="btn-sm xs popdata"><span>See More</span></a>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>

					<?php if ( $slides ) { ?>
					<div class="gallerycol">
						<div class="flexslider">
							<ul class="slides">
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
			<?php  $i++; } ?>
		</div>
	</section>
	<?php } ?>

	<?php
	/* FAQs */
	$customFAQTitle = 'FAQ';
	$customFAQClass = 'custom-class-faq graybg';
	include( locate_template('parts/content-faqs.php') );
	include( locate_template('inc/faqs.php') );
	?>

</div><!-- #primary -->

<div id="activityModal" class="modal customModal fade">
	<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
      	<span id="eventStatusTxt"></span>
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
	$("#activityModal").appendTo('body');

	// $('#gallery').flexslider({
 //    animation: "slide"
 //  });

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
					var event_status = obj.eventstatus;
					var eventStatusTxt = '';
					if(event_status && event_status!='upcoming') {
						eventStatusTxt = '<span>'+event_status+'</span>';
					}
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
						if(eventStatusTxt) {
							$("#eventStatusTxt").html(eventStatusTxt);
						} else {
							$("#eventStatusTxt").html("");
						}
						$("#modalBodyText .modalText").html(textcontent);
						$("#activityModal").modal("show");
						$("#loaderDiv").hide();
						if( $("#activityModal .flexslider").length > 0 ) {
							$('.flexslider').flexslider({
								animation: "fade",
								smoothHeight: true,
								start: function(){

								}
							});
						}
						

					});
					
				}
				
			},
			error:function() {
				$("#loaderDiv").hide();
			}
		});

	});


  $(document).on('facetwp-refresh', function() {
    var start = $('input.flatpickr-alt[placeholder="Start Date"]').val();
    var end = $('input.flatpickr-alt[placeholder="End Date"]').val();
    var pageURL = '<?php echo get_permalink();?>?' + FWP.build_query_string();
    if(start || end) {
	    $("#upcoming-bands-by-date").load(pageURL + " #entries-result",function(){
	    	$("#loaderDiv").show();
	    	setTimeout(function(){
	    		$("#loaderDiv").hide();
	    	},500);
	    });
	  }
 	});

 	// $(document).on('click','#resetFilter',function(e) {
  //   e.preventDefault();
  //   var pageURL = $(this).attr("href");
  //   $("#upcoming-bands-by-date").load(pageURL + " #entries-result",function(){
  //   	history.pushState('',document.title,pageURL);
  //   });
 	// });	


});
</script>
<?php
include( locate_template('inc/pagetabs-script.php') );
get_footer();
?>

