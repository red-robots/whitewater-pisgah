<?php
$canceledImage = THEMEURI . "images/canceled.svg";
$blank_image = THEMEURI . "images/square.png";
$square = THEMEURI . "images/square.png";
$rectangle = THEMEURI . "images/rectangle-lg.png";
$paged = ( get_query_var( 'pg' ) ) ? absint( get_query_var( 'pg' ) ) : 1;
$perpage = 12;
$date_range = ( isset($_GET['_river_jam_date_range']) && $_GET['_river_jam_date_range'] ) ? $_GET['_river_jam_date_range'] : '';
$dates = ($date_range) ? explode(",",$date_range) : '';
$startDate = ( isset($dates[0]) && $dates[0] ) ? $dates[0] : '';
$endDate = ( isset($dates[1]) && $dates[1] ) ? $dates[1] : '';
if(empty($startDate)) {
	$startDate = $endDate;
}
if(empty($startDate)) {
	$startDate = $endDate;
}

/* Default */
$today = date('Y-m-d', strtotime(date('Y-m-d H:i:s'). '-1 days'));
// if(empty($date_range)) {
// 	$today = date('Y-m-d', strtotime(date('Y-m-d H:i:s'). '-1 days'));
// 	$startDate = $today;
// 	$offset = ($paged * $perpage) - $perpage;
// 	$end = $perpage-1;
// 	if($offset>0) {
// 		$end = ($offset + $perpage) - 1;
// 	}
	
// 	$endDate = date('Y-m-d', strtotime($today. '+'.$end.' days'));
// }
$section_title = 'Band Schedule';
$section_id = sanitize_title($section_title);
?>

<div id="<?php echo $section_id ?>" data-section="<?php echo $section_title ?>"  class="section-title-div">
	<div class="wrapper">
		<div class="shead-icon text-center">
			<!-- <div class="icon"><span class="ci-calendar"></span></div> -->
			<h2 class="stitle"><?php echo $section_title ?></h2>
		</div>
	</div>
</div>

<div class="filter-wrapper river-jam">
	<div class="wrapper">
		<div class="filter-inner">
			<div class="flexwrap">
				<?php if ( do_shortcode('[facetwp facet="river_jam_date_range"]') ) { ?>
				<div class="select-wrap align-middle">
					<label>View Upcoming Bands By Date</label>
					<?php echo do_shortcode('[facetwp facet="river_jam_date_range"]'); ?>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<?php 
$today = date("Ymd");
$args = array(
    'post_type'      	=> 'music',
    'posts_per_page' 	=> $perpage,
    'facetwp'			=> true,
    'meta_key'       	=> 'start_date',
    'meta_value' => $thedate,
    'meta_compare' => '>',
    'orderby'        	=> 'meta_value',
    'order'          	=> 'ASC',
    'paged'			   	=> $paged,
    'post__not_in'      => $noInclude // look in page-river-jam.php for variable. Don't show upcoming
  );


// if($date_range) {
// $range = array($startDate,$endDate);
// 	$args['meta_query'] = array(
//     array(
//       'key'     => 'start_date',
//       'value'   => $range,
//       'compare' => 'BETWEEN',
//       'type'    => 'date',
//     )
//   );
// } else {
// 	$args['meta_query'] = array(
//     array(
//       'key'     => 'start_date',
//       'value'   => $today,
//       'compare' => '>=',
//       'type'    => 'date',
//     )
//   );
// }
//$posts = get_posts($args);
// echo "<pre>";
// print_r($posts);
// echo "<pre>";

$entries = new WP_Query($args);
if ( $entries->have_posts() ) { ?>
<section id="upcoming-bands-by-date" class="section-content menu-sections">
	<div id="entries-result">
		<div class="post-type-entries music">
			<div id="data-container">
				<div class="posts-inner animate__animated animate__fadeIn">
					<div class="flex-inner result">
						<?php $i=1;  while ( $entries->have_posts() ) : $entries->the_post();
							$id = get_the_ID();
							$title = get_the_title();
							$text = get_the_content();
							$status = get_field("eventstatus");
							$eventStatus = ($status) ? $status:'upcoming';
							$thumbImage = get_field("thumbnail_image");
							$pagelink = get_permalink();
							$start = get_field("start_date");
							$end = get_field("end_date");
							$event_date = get_event_date_range($start,$end,true);
							$short_description = ( get_the_content() ) ? shortenText( strip_tags($text),300,' ','...' ) : '';
							if($event_date) {
								if(strpos($event_date,'-') !== false){
									// Has multiple dates...
								} else {
									$dayOfWeek = date('l',strtotime($start));
									$event_date = $dayOfWeek .', ' . date('F j',strtotime($start));
								}
							}

						?>
						<div class="postbox <?php echo ($thumbImage) ? 'has-image':'no-image' ?> <?php echo $eventStatus ?>">
							<div class="inside">
								<a href="#" data-url="<?php echo $pagelink ?>" data-action="ajaxGetPageData" data-id="<?php echo $id ?>" class="photo popdata">
									<?php if ($thumbImage) { ?>
										<span class="imagediv" style="background-image:url('<?php echo $thumbImage['sizes']['medium_large'] ?>')"></span>
										<img src="<?php echo $rectangle ?>" alt="" class="feat-img placeholder">
										<img src="<?php echo $thumbImage['url']; ?>" alt="<?php echo $thumbImage['title'] ?>" class="feat-img" style="display:none">
									<?php } else { ?>
										<span class="imagediv"></span>
										<img src="<?php echo $rectangle ?>" alt="" class="feat-img placeholder">
									<?php } ?>
									<?php if ($eventStatus=='canceled') { ?>
									<span class="canceledStat">
										<img src="<?php echo $canceledImage ?>" alt="" aria-hidden="true">
									</span>	
									<?php } ?>
								</a>
								<div class="details">
									<div class="info">
										<h3 class="event-name"><?php echo $title ?></h3>
										<?php if ($event_date) { ?>
										<div class="event-date"><?php echo $event_date ?></div>
										<?php } ?>
										<div class="button">
											<a href="#" data-url="<?php echo $pagelink ?>" data-action="ajaxGetPageData" data-id="<?php echo $id ?>" class="btn-sm xs popdata"><span>See Details</span></a>
										</div>
									</div>
								</div>
							</div>
						</div>	
						<?php $i++; endwhile; wp_reset_postdata(); ?>
					</div>
				</div>
			</div>
		</div>

		<?php 
		$total = $entries->found_posts;
		$total_pages = $entries->max_num_pages;
		if ($total > $perpage) { ?> 
			<div class="loadmorediv text-center">
				<div class="wrapper"><a href="#" id="loadMoreEntries" data-current="1" data-count="<?php echo $total?>" data-total-pages="<?php echo $total_pages?>" class="btn-sm wide"><span>Load More</span></a></div>
			</div>

			<div id="pagination" class="pagination-wrapper" style="display:none;">
			    <?php
			    $pagination = array(
						'base' => @add_query_arg('pg','%#%'),
						'format' => '?pg=%#%',
						'mid-size' => 1,
						'current' => $paged,
						'total' => ceil($total / $perpage),
						'prev_next' => True,
						'prev_text' => __( '<span class="fa fa-arrow-left"></span>' ),
						'next_text' => __( '<span class="fa fa-arrow-right"></span>' )
			    );
			    echo paginate_links($pagination); ?>
			</div>
		<?php } ?>

		<div class="next-posts" style="display:none;"></div>
	</div>
</section>
<?php } else { ?>

	<?php if ($date_range) { ?>
		<section id="upcoming-bands-by-date" data-section="Bands Schedule" class="section-content menu-sections">
			<div id="entries-result">
				<div class="wrapper">
					<h3 class="norecord text-center">No result found. <a href="<?php echo get_permalink(); ?>" id="resetFilter">Reset</a></h3>
				</div>
			</div>
		</section>
	<?php } ?>

<?php } ?>


