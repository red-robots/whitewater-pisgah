<!DOCTYPE html>
<html>
<head>

<link rel='stylesheet' id='bellaworks-style-css'  href='<?php bloginfo('template_url'); ?>/style.css' type='text/css' media='all' />
<script type='text/javascript' src='https://code.jquery.com/jquery-3.3.1.min.js?ver=3.5.1' id='jquery-js'></script>
<style type="text/css">
	#primary.activity-schedule-onsite {
		margin-top: 0;
		border: 0;
	}
	#primary.activity-schedule-onsite .wrapper {
		max-width: 100%;
		font-size: 36px;
		font-weight: bold;
	}
	#primary.activity-schedule-onsite .wrapper h3 {
		font-weight: bold;
	}
	#primary.activity-schedule-onsite .intro-text-wrap {
		padding-top: 0;
		padding-bottom: 0;
	}
	#primary.activity-schedule-onsite .status-legend {
		padding-top: 10px;
	}
	#primary.activity-schedule-onsite .date-hours {
		margin-top: 0;
	}
	#primary.activity-schedule-onsite .activities {
		/*display: flex;
		flex-direction: row;
		flex-wrap: wrap;
		justify-content: space-around;*/
	}
	#primary.activity-schedule-onsite {

	}
	#primary.activity-schedule-onsite .activity-info {
		/*flex-basis: 45%;*/
		margin-bottom: 50px;
		max-width: 96%;
	}
	#primary.activity-schedule-onsite span.redclosed {
		width: auto;
		padding: 2px 10px;
		background-color: #BA0D30;
		color: #fff;
	}
	.daily-content, .daily-container {
		width: 100%;
		float: left;
		background-color: #fff;
	}
	.daily-container {
		/*padding: 5px;*/
		height: 4000px;
	}
	.schedule-activities-info.new-layout .activities .activity-info ul.list .cell.cell-open:before, .schedule-activities-info.new-layout .activities .activity-info ul.list .cell.cell-closed:before {
		width: 20px;
		height: 20px;
		left: -10px;
		top: 15px;
	}
	.schedule-activities-info.new-layout .activities .activity-info h3.type {
		font-size: 42px;
	}
</style>
</head>
<body>


<?php
/**
 * Template Name: Activity Schedule On Site
 */

//get_header(); 
$blank_image = THEMEURI . "images/square.png";
$square = THEMEURI . "images/square.png";
$flexslider = get_field( "flexslider_banner" );
$slidesCount = ($flexslider) ? count($flexslider) : 0;
$slideImages = array();
if($flexslider) {
	foreach($flexslider as $r) {
		if( isset($r['image']['url']) ) {
			$slideImages[] = $r['image']['url'];
		}
	}
}
$has_banner = ($slideImages) ? 'has-banner':'no-banner';
?>

<div id="primary" data-post="<?php echo get_the_ID()?>" class="content-area-full activity-schedule-onsite <?php echo $has_banner ?>">
	<div class="daily-container">
		<div class="daily-content">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php 
				$custom_page_title = get_field("custom_page_title"); 
				$page_title = ($custom_page_title) ? $custom_page_title : get_the_title();
			?>
			<!-- <div class="text-centered-section intro-text-wrap">
				<div class="wrapper">
					<?php the_content(); ?>
				</div>
			</div> -->
		<?php endwhile;  ?>

		<div class="schedule-activities-info new-layout full">
			<?php
			//$dateToday = date('l, F jS, Y'); /* example result: SATURDAY, OCTOBER 17TH, 2020 */
			$dateToday = date('l, F j'); /* example resul: SATURDAY, OCTOBER 17 */
			$postype = 'activity_schedule';
			$post = get_current_activity_schedule($postype);
			if($post) { 
				$postID = $post->ID;
				$post_title = $post->post_title;
				$pass_hours = get_field("pass_hours",$postID);
				$note = get_field("note",$postID);
				$scheduled_activities = get_field("scheduled_activities",$postID);
				?>
				
				<div class="subhead">
					<div class="date-hours">
						<h2 class="event-date"><?php echo $dateToday ?></h2>
						<?php if ($pass_hours) { ?>
						<div class="pass-hours"><span class="ph">Pass Hours:</span> <?php echo $pass_hours ?></div>	
						<?php } ?>
					</div>

					<?php if ($note) { ?>
					<div class="note"><?php echo $note ?></div>	
					<?php } ?>
				</div>

				<?php //get_template_part("parts/subpage-tabs"); ?>

				<div class="entries full">
					<div class="status-legend">
						<div class="wrapper">
							<span class="open">Activity Open</span>
							<span class="closed">Activity Closed</span>
						</div>
					</div>
					<div class="wrapper">
					<?php if ($scheduled_activities) { ?>
						<div class="activities">
							<?php $i=1; foreach ($scheduled_activities as $a) { 
								$type = $a['type'];
								$activities = $a['activities'];
								if($type || $activities) { ?>
									<div id="activity<?php echo $i?>" class="activity-info info">
										<?php if ($type) { ?>
											<h3 class="type"><?php echo $type ?></h3>
										<?php } ?>
										<?php if ($activities) { ?>
											<ul class="list">
												<?php foreach ($activities as $e) { 
												$is_custom = ( isset($e['types']) && $e['types']=='custom' ) ? true : false;
												$customName = ( isset($e['customText']) && $e['customText'] ) ? $e['customText'] : "";
												$name = ( isset($e['name']) && $e['name'] ) ? $e['name']->post_title : '';
												$start = $e['time_start'];
												$end = $e['time_end'];
												$status = ( isset($e['status']) && $e['status'] ) ? $e['status'] : 'open';
												$delimiter = '';
												if($start && $end) {
													$delimiter = '<span class="dashed">&ndash;</span>';
												}
												if($is_custom) {
													if(preg_replace("/\s+/", "",$customName)) {
														$name = preg_replace("/\s+/", " ",$customName);
													} else {
														$name = "";
													}
												}
												if($name) { ?>
													<li class="data" data-status="<?php echo $status?>">
														<div class="cell name cell-<?php echo $status?>">
															<span class="cellTxt"><span class="ct <?php echo $status?>"><?php echo $name ?></span></span>
														</div>
														<div class="cell time">
															<span class="cellTxt">
																<?php if( $status == 'open' ) { ?>
																	<?php if ($start) { ?>
																	<span class="time-start"><?php echo $start ?></span>	
																	<?php } ?>
																	<?php echo $delimiter ?>
																	<?php if ($end) { ?>
																	<span class="time-end"><?php echo $end ?></span>	
																	<?php } ?>
																<?php } else { ?>
																	<span class="redclosed">CLOSED</span>
																<?php } ?>
															</span>
														</div>
													</li>
													<?php } ?>
												<?php } ?>
											</ul>
										<?php } ?>
									</div>	
								<?php $i++; } ?>
							<?php } ?>
						</div>
					<?php } ?>
					</div>
					<span id="timer"></span> s
				</div>

			<?php } else { ?>
				
				<div class="subhead">
					<div class="date-hours">
						<h2 class="event-date"><?php echo $dateToday ?></h2>
						<div class="pass-hours">NO SCHEDULED ACTIVITY TODAY</div>	
					</div>
				</div>
			
			<?php } ?>

		</div>
</div>
</div>
</div><!-- #primary -->


<script type="text/javascript">
	jQuery(document).ready(function ($) {




		// $("html, body").animate({ scrollTop: $(document).height() }, 4000);
		// setTimeout(function() {
		//    $('html, body').animate({scrollTop:0}, 4000); 
		// },4000);
		// setInterval(function(){
		//      // 4000 - it will take 4 secound in total from the top of the page to the bottom
		// 	$("html, body").animate({ scrollTop: $(document).height() }, 60000);
		// 	setTimeout(function() {
		// 	   $('html, body').animate({scrollTop:0}, 4000); 
		// 	},4000);
		    
		// },8000);

function scroll_to_bottom_looped(duration,page_height){
	$('html, body').animate({ 
	   scrollTop: page_height},
	   duration,
	   "swing"
	).promise().then(function(){
	  scroll_to_top_looped(duration,page_height);
	});
}
function scroll_to_top_looped(duration,page_height){
	$('html, body').animate({ 
	   scrollTop: 0},
	   duration,
	   "swing"
	).promise().then(function(){
	  scroll_to_bottom_looped(duration,page_height);
	});
}
function repeat_scroller(duration,page_height,repeats,i){
	if( i < repeats ){
		$('html, body').animate({ 
		   scrollTop: page_height},
		   duration,
		   "swing"
		).promise().then(function(){
			$('html, body').animate({ 
			   scrollTop: 0},
			   duration,
			   "swing"
			).promise().then(function(){
			  i++;			 
			  repeat_scroller(duration,page_height,repeats,i);
			});
		});
	}else{
		return false;
	}
}

jQuery(document).ready(function ($) {	
	// force window to top of page
	$(this).scrollTop(0);
	// define vars
	let page_height = $(document).height()-$(window).height();
	let duration = 60000;

	// begin the neverending scrollage festival
	scroll_to_bottom_looped(duration,page_height);

	// or, use a set number of repeats
	let repeats = 3;
	let i = 0;
	// repeat_scroller(duration,page_height,repeats,i);
});
// setInterval(() => {
//   alert("Hello"); 
// }, 3000);
		// console.log();




		// var startTime = Date.now();

		// var interval = setInterval(function() {
		//     var elapsedTime = Date.now() - startTime;
		//     document.getElementById("timer").innerHTML = (elapsedTime / 1000).toFixed(3);
		// }, 100);



		
		 
		//  $("html, body").animate({ scrollTop: $(document).height() }, 20000);
		
		// setTimeout(function() {
		//    $('html, body').animate({scrollTop:0}, 4000); 
		// },400);

		// setInterval(function(){
		//      // 4000 - it will take 4 secound in total from the top of the page to the bottom
		// 	$("html, body").animate({ scrollTop: $(document).height() }, 24000);
			
		// 	setTimeout(function() {
		// 	   $('html, body').animate({scrollTop:0}, 24000); 
		// 	},400);
		    
		// },8000);


// 		var Height = document.documentElement.scrollHeight;
// var currentHeight = 0;
// var bool = true;
// var step = 1;
// var speed = 10;
// var interval = setInterval(scrollpage, speed)

// function scrollpage() {
//     if (currentHeight < 0 || currentHeight > Height) 
//         bool = !bool;
//     if (bool) {
//         window.scrollTo(0, currentHeight += step);
//     } else {
//         // if you don't want to continue scroll 
//         // clearInterval(interval) use clearInterval
//         window.scrollTo(0, currentHeight -= step);
//     }
// }



  });// END

// $(document).ready(function() {

//     if ($('.daily-container').height() > $('.daily-content').height()) {
//         setInterval(function () {

//             start();
//        }, 3000); 
   
//     }
//     console.log( $('.daily-container').height() );
//     console.log( $('.daily-content').height() );
// });

// function animateContent(direction) {  
//     // var animationOffset = $('.daily-container').height() - $('.daily-content').height();
//     var animationOffset = $(document).height();
//     if (direction == 'up') {
//         animationOffset = 0;
//     }

//     console.log("animationOffset:"+animationOffset);
//     // $('.daily-content').animate({ "marginTop": (animationOffset)+ "px" }, 5000);
//     $("html, body").animate({ scrollTop: $(document).height() }, 5000);
// }

// function up(){
//     animateContent("up")
// }
// function down(){
//     animateContent("down")
// }

// function start(){
//  setTimeout(function () {
//  	console.log("down...");
//     down();
// }, 2000);
//  setTimeout(function () {
//  	console.log("up...");
//     up();
// }, 2000);
//    setTimeout(function () {
//     console.log("wait...");
// }, 5000);
// }  
// jQuery(document).ready(function ($) {
// //scroll to bottom
// setInterval(function(){

//     //time to scroll to bottom
//     $("html, body").animate({ scrollTop: $(document).height() }, 2000, 'linear');
//     // console.log( $(document).height() );
//     //scroll to top
//     setTimeout(function() {
//        $('html, body').animate({scrollTop:0}, 11000);
//     },2);//call every 2000 miliseconds

// },2);//call every 2000 miliseconds
// });// END
</script>
</body>
</html>
<?php
//get_footer();
