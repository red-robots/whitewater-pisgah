<?php
get_header(); 
$blank_image = THEMEURI . "images/rectangle.png";
$square = THEMEURI . "images/square.png";
$currentPageLink = get_permalink();
?>

<div id="primary" data-post="<?php echo get_the_ID()?>" class="content-area-full page-events-page">
	
		<?php while ( have_posts() ) : the_post(); ?>
			<?php if( get_the_content() ) { ?>
				<div class="intro-text-wrap">
					<div class="wrapper">
						<h1 class="page-title"><span><?php the_title(); ?></span></h1>
						<div class="intro-text"><?php the_content(); ?></div>
					</div>
				</div>
			<?php } ?>
		<?php endwhile;  ?>


		<?php
		$canceledImage = THEMEURI . "images/canceled.svg";
		$postype = 'event-space';
		$perpage = 12;
		$paged = ( get_query_var( 'pg' ) ) ? absint( get_query_var( 'pg' ) ) : 1;
		$args = array(
			'post_type'				=> $postype,
			'posts_per_page'	=> $perpage,
			'post_status'			=> 'publish',
			'facetwp'					=> true
		);
		$posts = new WP_Query($args);
		if( $posts->have_posts() ) { ?>

			<?php /* Filter Options */ ?>
			<div class="filter-wrapper optionsnum3">
				<div class="wrapper">
					
					<div class="filter-inner">
						<div class="filterbytxt">Filter By:</div>
						<div class="flexwrap">

							<?php if ( do_shortcode('[facetwp facet="event_space_num_guests"]') ) { ?>
							<div class="select-wrap">
								<label>Number of Guests</label>
									<?php echo do_shortcode('[facetwp facet="event_space_num_guests"]'); ?>
							</div>
							<?php } ?>

							<?php if ( do_shortcode('[facetwp facet="event_space_venue"]') ) { ?>
							<div class="select-wrap">
								<label>Venue Size</label>
								<?php echo do_shortcode('[facetwp facet="event_space_venue"]'); ?>
							</div>
							<?php } ?>

							<?php if ( do_shortcode('[facetwp facet="event_space_loctype"]') ) { ?>
							<div class="select-wrap">
								<label>Indoor / Outdoor</label>
								<?php echo do_shortcode('[facetwp facet="event_space_loctype"]'); ?>
							</div>
							<?php } ?>

						</div>
					</div>

				</div>
			</div>

			<?php /* Entries */ ?>
			<div class="post-type-entries columns3 <?php echo $postype ?>">
				<div id="data-container">
					<div class="posts-inner">
						<div class="flex-inner">
							<?php $i=1; while ( $posts->have_posts()) : $posts->the_post(); ?>
								<?php
								$id = get_the_ID();
								$title = get_the_title();
								$pagelink = get_permalink();
								$short_description = get_field("short_description");
								$thumbImage = get_field("featured_image");
								$space_features = get_field("space_features");
								$space_variables = array('capacity','area_size','type');

								?>
								<div class="postbox animated fadeIn <?php echo ($thumbImage) ? 'has-image':'no-image' ?>">
									<div class="inside">

										<a href="<?php echo $pagelink ?>" class="photo wave-effect js-blocks">
											<?php if ($thumbImage) { ?>
												<span class="imagediv" style="background-image:url('<?php echo $thumbImage['sizes']['medium_large'] ?>')"></span>
												<img src="<?php echo $thumbImage['url']; ?>" alt="<?php echo $thumbImage['title'] ?>" class="feat-img" style="display:none;">
												<img src="<?php echo $blank_image ?>" alt="" class="feat-img placeholder">
											<?php } else { ?>
												<span class="imagediv"></span>
												<img src="<?php echo $blank_image ?>" alt="" class="feat-img placeholder">
											<?php } ?>
											<span class="boxTitle">
												<span class="twrap">
													<span class="t1"><?php echo $title ?></span>
												</span>
											</span>
											<?php include( locate_template('images/wave-svg.php') ); ?>
										</a>

										<div class="details">
											<div class="info">
												<h3 class="event-name"><?php echo $title ?></h3>

												<?php if ($short_description) { ?>
												<div class="short-description">
													<?php echo $short_description ?>
												</div>
												<?php } ?>

												<?php if ($space_features) { ?>
												<div class="space-features">
													<?php foreach ($space_features as $k=>$v) { ?>
														<?php if ( in_array($k, $space_variables) ) {  ?>
															<?php 
																if ($k=='type') {
																	if( isset($v['value']) && $v['value']!='na' ) {
																		$v = ( isset($v['label']) && $v['label'] ) ? $v['label'] : $v;
																	} else {
																		$v = '';
																	}
																} ?>	
															
															<?php if ($v) { ?>
																<span class="sf"><?php echo $v ?></span>
															<?php } ?>
															
														<?php } ?>
													<?php } ?>
												</div>
												<?php } ?>

												<div class="button">
													<a href="<?php echo $pagelink ?>" class="btn-sm"><span>See Details</span></a>
												</div>
												
											</div>
										</div>
									</div>
								</div>
							<?php $i++; endwhile; wp_reset_postdata(); ?>
						</div>
					</div>
				</div>

				<div class="hidden-entries" style="display:none;"></div>
			</div>

			<?php
			$total_pages = $posts->max_num_pages;
			if ($total_pages > 1){ ?> 
			<div class="loadmorediv text-center">
				<div class="wrapper"><a href="#" id="nextPostsBtn" data-current="1" data-baseurl="<?php echo $currentPageLink ?>" data-end="<?php echo $total_pages?>" class="btn-sm wide"><span>Load More Venue</span></a></div>
			</div>
			<?php } ?>

		<?php } ?>

		<?php
		$customFAQTitle = 'FAQ';
		$customFAQClass = 'custom-class-faq';
		include( locate_template('parts/content-faqs.php') );
		include( locate_template('inc/faqs.php') );
		?>

</div><!-- #primary -->

<script type="text/javascript">
jQuery(document).ready(function($){
	$(document).on("click","#nextPostsBtn",function(e){
		e.preventDefault();
		var button = $(this);
		var baseURL = $(this).attr("data-baseurl");
		var currentPageNum = $(this).attr("data-current");
		var nextPageNum = parseInt(currentPageNum) + 1;
		var pageEnd = $(this).attr("data-end");
		var nextURL = baseURL + '?pg=' + nextPageNum;
		button.attr("data-current",nextPageNum);
		if(nextPageNum==pageEnd) {
			$(".loadmorediv").remove();
		}
		$(".hidden-entries").load(nextURL+" #data-container",function(){
			if( $(this).find(".posts-inner .flex-inner").length>0 ) {
				var entries = $(this).find(".posts-inner .flex-inner").html();
				$("#loaderDiv").addClass("show");
				if(entries) {
					$("#data-container .flex-inner").append(entries);
					setTimeout(function(){
						$("#loaderDiv").removeClass("show");
					},500);
				}
			}
		});
	});
});
</script>
<?php
get_footer();
