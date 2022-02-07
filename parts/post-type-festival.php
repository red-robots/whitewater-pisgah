<?php 
$postid = get_the_ID();
while ( have_posts() ) : the_post(); 
	// $top_notification = get_field("top_notification");
	// $main_description = get_field("activity_descr");
	// $main_description = get_the_content();
	// $taxonomy = 'pass_type';
	// $categories = get_the_terms($postid,$taxonomy);
	// $catSlugs = array();
	// if($categories) {
	// 	foreach($categories as $c) {
	// 		$catSlugs[] = $c->slug;
	// 	}
	// }
	?>
	
	<?php if ( get_the_content() ) { ?>
	<section class="main-description">
		<div class="wrapper text-center">
			<h1 class="pagetitle"><span><?php echo get_the_title(); ?></span></h1>
			<div class="main-text"><?php the_content(); ?></div>
		</div>
	</section>
	<?php } ?>


<?php endwhile; ?>