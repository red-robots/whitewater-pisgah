<?php /* EXPLORE OTHER ACTIVITIES */ ?>
<?php
$currentPostType = get_post_type();
$similarPosts = get_field("similar_posts_section","option");
$bottomSectionTitle = '';
if($similarPosts) {
	foreach($similarPosts as $s) {
		$posttype = $s['posttype'];
		$sectionTitle = $s['section_title'];
		if($posttype==$currentPostType) {
			$bottomSectionTitle = $sectionTitle;
		}
	}
}
//$bottom_title = get_field("race_bottom_section_title","option");
$args = array(
	'posts_per_page'=> 15,
	'post_type'		=> array('music','festival','camp'),
	'post_status'	=> 'publish',
);
$posts = new WP_Query($args);
if($posts) { ?>
<section class="explore-other-stuff">
	<div class="wrapper">
		<?php if ($bottomSectionTitle) { ?>
			<h3 class="sectionTitle"><?php echo $bottomSectionTitle ?></h3>
		<?php } ?>
		
		<div class="post-type-entries">
			<div class="columns">
				<?php $i=1; while ( $posts->have_posts() ) : $posts->the_post(); ?>
					<div class="entry">
						<a href="<?php echo get_permalink() ?>"><?php echo get_the_title(); ?></a>
					</div>
				<?php $i++; endwhile; wp_reset_postdata(); ?>
			</div>
		</div>
	</div>
</section>
<?php } ?>