<?php
/**
 * Template Name: Activity Schedule
 */

get_header(); 
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

<div id="primary" data-post="<?php echo get_the_ID()?>" class="content-area-full activity-schedule <?php echo $has_banner ?>">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php 
				$custom_page_title = get_field("custom_page_title"); 
				$page_title = ($custom_page_title) ? $custom_page_title : get_the_title();
			?>
			<div class="text-centered-section intro-text-wrap">
				<div class="wrapper">
					<?php the_content(); ?>
				</div>
			</div>
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

				<?php get_template_part("parts/subpage-tabs"); ?>

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
																<?php if ($start) { ?>
																<span class="time-start"><?php echo $start ?></span>	
																<?php } ?>
																<?php echo $delimiter ?>
																<?php if ($end) { ?>
																<span class="time-end"><?php echo $end ?></span>	
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

</div><!-- #primary -->


<script type="text/javascript">
jQuery(document).ready(function($){
	if( $(".activities h3.type").length > 0 ) {
		$(".activities h3.type").each(function(){
			var text = $(this).text().replace(/\s+/g,' ').trim();
			var wrap = $(this).parents(".activity-info");
			var parentId = wrap.attr("id");
			var tab = '<span class="mini-nav"><a href="#'+parentId+'">'+text+'</a></span>';
			$("#tabcontent").append(tab);
		});
		$("#pageTabs").show().addClass("show-tabs");
	}
});
</script>

<?php
get_footer();
