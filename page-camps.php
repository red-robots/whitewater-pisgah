<?php
/**
 * Template Name: Camps
 */

get_header(); 
$blank_image = THEMEURI . "images/square.png";
$square = THEMEURI . "images/square.png";
$rectangle = THEMEURI . "images/rectangle-lg.png";
?>

<div id="primary" data-post="<?php echo get_the_ID()?>" class="content-area-full festival-page">
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
		$postype = 'camp';
		$perpage = 16;
		$paged = ( get_query_var( 'pg' ) ) ? absint( get_query_var( 'pg' ) ) : 1;
		$result = custom_query_posts($postype,$perpage,$paged,'ASC');
		$posts = ( isset($result['records']) && $result['records'] ) ? $result['records']:'';
		$total = ( isset($result['total']) && $result['total'] ) ? $result['total']:0;
		$canceledImage = THEMEURI . "images/canceled.svg";
		$total_pages = ($posts) ? ceil($total / $perpage):0;

		if ( $posts ) { ?>
		<div class="post-type-entries <?php echo $postype ?>">
			<div id="data-container">
				<div class="posts-inner animate__animated animate__fadeIn">
					<div class="flex-inner">
						<?php $i=1; foreach ($posts as $p) { 
							$id = $p->ID;
							$title = $p->post_title;
							$pagelink = get_permalink($id);
							$start = get_field("start_date",$id);
							$end = get_field("end_date",$id);
							$event_date = get_event_date_range($start,$end);
							$short_description = get_field("short_description",$id);
							$eventStatus = (isset($p->eventstatus) && $p->eventstatus) ? $p->eventstatus:'active';
							$thumbImage = get_field("thumbnail_image",$id);
							?>
							<div class="postbox <?php echo ($thumbImage) ? 'has-image':'no-image' ?> <?php echo $eventStatus ?>">
								<div class="inside">
									<?php if ($eventStatus=='completed') { ?>
										<div class="event-completed"><span>Event Complete</span></div>
									<?php } ?>
									<a href="<?php echo $pagelink ?>" class="photo wave-effect js-blocks">
										<?php if ($thumbImage) { ?>
											<div class="imagediv" style="background-image:url('<?php echo $thumbImage['sizes']['medium_large'] ?>')"></div>
											<img src="<?php echo $thumbImage['url']; ?>" alt="<?php echo $thumbImage['title'] ?>" class="feat-img">
										<?php } else { ?>
											<div class="imagediv"></div>
											<img src="<?php echo $blank_image ?>" alt="" class="feat-img placeholder">
										<?php } ?>
										<span class="boxTitle">
											<span class="twrap">
												<span class="t1"><?php echo $title ?></span>
												<?php if ($event_date) { ?>
												<span class="t2"><?php echo $event_date ?></span>
												<?php } ?>
											</span>
										</span>
										<span class="wave">
												<svg class="waveSvg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
													<defs>
													<path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"></path>
													</defs>
													<g class="waveAnimation">
													<use xlink:href="#gentle-wave" x="48" y="7" fill="#000"></use>
													</g>
												</svg>
										</span>
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
											<?php if ($short_description) { ?>
											<div class="short-description"><?php echo $short_description; ?></div>	
											<?php } ?>
											<div class="button">
												<a href="<?php echo $pagelink ?>" class="btn-sm"><span>See Details</span></a>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php $i++; } ?>
					</div>
				</div>
			</div>

			<div class="next-posts" style="display:none;"></div>

				<?php if ($total > $perpage) { ?> 
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
						    echo paginate_links($pagination);
						?>
					</div>
				
				<?php } ?>
		</div>

		<?php if ($total > $perpage) { ?> 
		<div class="loadmorediv text-center">
			<div class="wrapper"><a href="#" id="loadMoreBtn" data-current="1" data-end="<?php echo $total_pages?>" class="btn-sm wide"><span>Load More Festivals</span></a></div>
		</div>
		<?php } ?>

		<?php } ?>

</div><!-- #primary -->

<?php
get_footer();
