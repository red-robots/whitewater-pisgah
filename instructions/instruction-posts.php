<?php
if( isset($current_term_id) && $current_term_id ) {
$blank_image = THEMEURI . "images/rectangle.png";
$square = THEMEURI . "images/square.png";
$perpage = -1;
$posttype = 'instructions';
$args = array(
	'posts_per_page'   => $perpage,
	'post_type'        => $posttype,
	'post_status'      => 'publish'
);

$args['tax_query'][] = array(
			'taxonomy' => $taxonomy,
			'field' => 'term_id',
			'terms' => $current_term_id
		);

$entries = new WP_Query($args); 
if ( $entries->have_posts() ) { 
$total = $entries->found_posts;
$flexClass = ($total<3) ? ' align-middle':'';
?>
<section class="section-content entries-with-filter" style="padding-top:0;">
	<div class="post-type-entries boxes-element threecols <?php echo $posttype ?>">
		<div id="data-container">
			<div class="posts-inner result">
				<div id="resultContainer" class="flex-inner<?php echo $flexClass ?>">
					<?php $ctr=1; while ( $entries->have_posts() ) : $entries->the_post(); 
						$pid = get_the_ID();
						$title = get_the_title();
						$pagelink  = get_permalink();
						$short_description = get_field("short_description");
						$thumbImage = get_field("thumbnail_image");
						$price = get_field("price");
						$ages = get_field("ages");
						$duration = get_field("duration");
						$schedules = get_field("schedules_alt");
						$options1 = array($price,$ages,$duration);
						$options2 = array("ages"=>$ages,"duration"=>$duration,"price"=>$price);
						$register = get_field("registration_link");
						$registerLink = ( isset($register['url']) && $register['url'] ) ? $register['url'] : '';
						$registerText = ( isset($register['title']) && $register['title'] ) ? $register['title'] : '';
						$registerTarget = ( isset($register['target']) && $register['target'] ) ? $register['target'] : '_self';
						$information = get_field("information_content");
						$categories = get_the_terms($pid,'instruction_type');

						/* For Yoga only */
						$is_yoga = false;
						$instructor_photo = get_field("instructor_photo",$pid);
						$instructor_title = get_field("instructor_title",$pid);
						$instructor_text = get_field("instructor_text",$pid);
						if($categories) {
							foreach($categories as $cat) {
								$slug = $cat->slug;
								if($slug=='yoga') {
									$is_yoga = true;
								}
							}
						}
						$gotopage = get_field("gotopage");
						?>
						<div class="postbox animated fadeIn <?php echo ($thumbImage) ? 'has-image':'no-image';?>">
							<div class="inside">

								<?php if ($gotopage) { ?>
									
									<div class="photo">
										<a href="<?php echo $pagelink ?>" class=" ">
											<?php if ($thumbImage) { ?>
												<span class="imagediv" style="background-image:url('<?php echo $thumbImage['sizes']['medium_large'] ?>')"></span>
												<img src="<?php echo $thumbImage['url']; ?>" alt="<?php echo $thumbImage['title'] ?>" class="feat-img" style="display:none;">
												<img src="<?php echo $blank_image ?>" alt="" class="feat-img placeholder">
											<?php } else { ?>
												<span class="imagediv"></span>
												<img src="<?php echo $blank_image ?>" alt="" class="feat-img placeholder">
											<?php } ?>
										</a>
									</div>
									<div class="details">
										<div class="info">
											<h3 class="event-name"><?php echo $title ?></h3>
										</div>
										<div class="button">
											<a href="<?php echo $pagelink ?>" class="btn-sm"><span>See Details</span></a>
										</div>
									</div>

								<?php } else { ?>
									<div class="photo">
										<?php if ($thumbImage) { ?>
											<span class="imagediv" style="background-image:url('<?php echo $thumbImage['sizes']['medium_large'] ?>')"></span>
											<img src="<?php echo $thumbImage['url']; ?>" alt="<?php echo $thumbImage['title'] ?>" class="feat-img" style="display:none;">
											<img src="<?php echo $blank_image ?>" alt="" class="feat-img placeholder">
										<?php } else { ?>
											<span class="imagediv"></span>
											<img src="<?php echo $blank_image ?>" alt="" class="feat-img placeholder">
										<?php } ?>
									</div>
									<div class="details">
										<div class="info">
											<h3 class="event-name"><?php echo $title ?></h3>
											
											<?php if ( $options1 && array_filter($options1) ) { ?>
											<div class="pricewrap">
												<div class="price-info">
													<?php foreach ($options2 as $k=>$v) { ?>
														<?php if ($v) { ?>
														<span class="<?php echo $k?>">
															<?php if ($k=='ages') { echo 'Age '; } ?><?php echo $v?>		
														</span>
														<?php } ?>	
													<?php } ?>
												</div>
											</div>
											<?php } ?>

											<?php if ($schedules) { ?>
											<div class="dates compact">
												<?php echo $schedules ?>
											</div>
											<?php } ?>

											<?php if ($short_description) { ?>
											<div class="short-description">
												<?php echo $short_description; ?>
											</div>
											<?php } ?>

											<?php if ($information) { ?>
											<div class="other-info">
												<?php foreach ($information as $e) { ?>
												<div class="text">
													<?php if ($e['title']) { ?>
														<div class="t1"><strong><?php echo $e['title'] ?></strong></div>
													<?php } ?>
													<?php if ($e['text']) { ?>
														<div class="t2"><?php echo emailize($e['text']) ?></div>
													<?php } ?>
												</div>	
												<?php } ?>
											</div>
											<?php } ?>

											<?php if($is_yoga) {  ?>
											<div class="about-instructor-btn">
												<a data-toggle="modal" data-target="#entryBlock-<?php echo $pid?>-modal" class="btn-link">
													<span>Learn more about the instructor</span>
												</a>
											</div>	
											<?php } ?>
										</div>
									</div>

									<?php if ($registerLink && $registerText) { ?>
									<div class="button">
										<a href="<?php echo $registerLink ?>" class="btn-sm xs"><span><?php echo $registerText ?></span></a>
									</div>
									<?php } ?>
							
								<?php } ?>
							</div>
							

							<?php 
							/* About Instructor Modal */ 
							if($is_yoga) { 
								if( $instructor_text ) { ?>
								<div class="modal customModal fade about-instructor-modal" id="entryBlock-<?php echo $pid?>-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								  <div class="modal-dialog modal-lg" role="document">
								    <div class="modal-content">
								      <div class="modal-header">
								        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								          <span aria-hidden="true">&times;</span>
								        </button>
								      </div>
								      <div class="modal-body">
								      	<div class="modaltitleDiv text-center">
								      		<p>About the Instructor</p>
									      	<?php if ($instructor_title) { ?>
									      		<h5 class="modal-title"><?php echo $instructor_title ?></h5>
									      	<?php } ?>
								      	</div>
								      
								      	<?php if ($instructor_photo) { ?>
								      	<div class="modalImage">
								      		<img src="<?php echo $instructor_photo['url'] ?>" alt="<?php echo $instructor_photo['title'] ?>" class="feat-image">
								      	</div>
												<?php } ?>

								      	<div class="modalText">
								      		<div class="text"><?php echo $instructor_text ?></div>
								      	</div>
								      </div>
								    </div>
								  </div>
								</div>
								<?php } ?>
							<?php } ?>
						</div>
					<?php $ctr++; endwhile; wp_reset_postdata(); ?>
				</div>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
jQuery(document).ready(function($){
	if( $(".customModal").length>0 ) {
		$(".customModal").each(function(){
			$(this).insertAfter('#page');
		});
	}
});
</script>

<?php }
}  ?>