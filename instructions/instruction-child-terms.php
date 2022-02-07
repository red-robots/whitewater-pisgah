<?php
if( isset($child_terms) && $child_terms ) {
$parent_page_id = ( isset($_GET['pp']) && $_GET['pp'] ) ? $_GET['pp'] : '';
$blank_image = THEMEURI . "images/rectangle.png";
$square = THEMEURI . "images/square.png";
$perpage = -1;
$posttype = 'instructions';
$total = count($child_terms);
// echo '<pre>';
// print_r($child_terms);
// echo '</pre>';
// echo $total;
?>
<section class="section-content entries-with-filter" style="padding-top:0;">
	<div class="post-type-entries boxes-element threecols">
		<div id="data-container">
			<div class="posts-inner result">
				<div id="resultContainer" class="flex-inner align-middle">
					<?php $ctr=1; foreach($child_terms as $child_term_id) { 
						$child = get_term($child_term_id,$taxonomy);
						if($child) {
							$c_term_id = $child->term_id;
							$c_term_name = $child->name;
							$thumbImage = get_field("category_image",$taxonomy.'_'.$c_term_id);
							$pagelink = get_term_link($child,$taxonomy);
							$short_description = ($child->description) ? apply_filters('the_content', $child->description) : '';
							?>
							<div id="postbox<?php echo $ctr?>" class="postbox animated fadeIn <?php echo ($thumbImage) ? 'has-image':'no-image';?>">
								<div class="inside">
									<div class="photo">
										<a href="<?php echo $pagelink ?>" class="link">
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
											<h3 class="event-name"><?php echo $c_term_name ?></h3>
											<?php if ($short_description) { ?>
											<div class="short-description">
												<?php echo $short_description ?>
											</div>
											<?php } ?>
										</div>
									</div>
								</div>
								<div class="button">
									<a href="<?php echo $pagelink ?>" class="btn-sm"><span>See Details</span></a>
								</div>
							</div>
							<?php $ctr++; } ?>
						<?php } ?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php } ?>
