<?php
/**
 * Template Name: Instruction Version 2
 */

get_header(); 
$currentPageLink = get_permalink();
$blank_image = THEMEURI . "images/rectangle.png";
$square = THEMEURI . "images/square.png";
$parent_page_id = get_the_ID();
?>

<div id="primary" data-post="<?php echo get_the_ID()?>" class="content-area-full boxedImagesPage instruction-page-v2">
	<?php while ( have_posts() ) : the_post(); ?>
		<div class="intro-text-wrap">
			<div class="wrapper">
				<h1 class="page-title"><span><?php the_title(); ?></span></h1>
				<?php if ( get_the_content() ) { ?>
				<div class="intro-text"><?php the_content(); ?></div>
				<?php } ?>
			</div>
		</div>
	<?php endwhile; ?>


	<?php /* GET PARENT CATEGORIES */ ?>
	<?php  
	$taxonomy = 'instruction_type';
	$hide_empty = true;
	$parent_terms = get_terms( array( 'taxonomy' => $taxonomy, 'parent' => 0, 'hide_empty'=>$hide_empty ) );
	if($parent_terms) { ?>
	<section class="section-content entries-with-filter" style="padding-top:0;">
		<div class="post-type-entries boxes-element threecols instructions">
			<div id="data-container">
				<div class="posts-inner result">
					<div id="resultContainer" class="flex-inner align-middle">
						<?php $i=1; foreach ($parent_terms as $term) { 
							$term_id = $term->term_id;
							$term_name = $term->name;
							$thumbImage = get_field("category_image",$taxonomy.'_'.$term_id);
							$pagelink = get_term_link($term,$taxonomy);
							//$child_terms = get_term_children($term_id,$taxonomy);
							?>
							<div id="postbox<?php echo $i?>" class="postbox animated fadeIn <?php echo ($thumbImage) ? 'has-image':'no-image';?>">
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
											<h3 class="event-name"><?php echo $term_name ?></h3>
										</div>

										<div class="button">
											<a href="<?php echo $pagelink ?>" class="btn-sm"><span>See Details</span></a>
										</div>
									</div>

								</div>
							</div>
						<?php $i++; } ?>

					</div>
				</div>
			</div>
		</div>
	</section>
	<?php } ?>

</div>
<?php
get_footer();
