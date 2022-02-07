<?php
$show_content_only = ( isset($_GET['show']) && $_GET['show']=='contentonly' ) ? true : false;
$pContent = get_field('content');
$pBtn = get_field('button');
			// echo '<pre>';
			// print_r($pBtn);
			// echo '</pre>';
if($show_content_only) {

		while ( have_posts() ) : the_post(); ?>
			<div class="content-only"><?php echo $pContent; ?></div>
			<?php if( $pBtn ) { ?>
				<div class="popbtn">
					<div class="buttondiv">
						<a href="<?php echo $pBtn['url'] ?>" target="<?php echo $pBtn['target'] ?>" class="btn-sm xs btn-link"><span><?php echo $pBtn['title'] ?></span></a>	
					</div>
				</div>
			<?php } ?>
		<?php endwhile; 

} else {
	get_header(); 
	$post_type = get_post_type();
	$heroImage = get_field("full_image");
	$flexbanner = get_field("flexslider_banner");
	$has_hero = 'no-banner';
	if($heroImage) {
		$has_hero = ($heroImage) ? 'has-banner':'no-banner';
	} else {
		if($flexbanner) {
			$has_hero = ($flexbanner) ? 'has-banner':'no-banner';
		}
	}

	//$customPostTypes = array('activity','festival');
	get_template_part("parts/subpage-banner");
	$post_id = get_the_ID(); 
	$pBtn = get_field('button');
			echo '<pre>';
			print_r($pBtn);
			echo '</pre>';
	?>
		
	<div id="primary" class="content-area-full content-default single-post <?php echo $has_hero;?> post-type-<?php echo $post_type;?>">

			<main id="main" data-postid="post-<?php the_ID(); ?>" class="site-main" role="main">
				<?php while ( have_posts() ) : the_post(); ?>
				<section class="text-centered-section">
					<div id="singleMainContent" class="wrapper text-center">
						<div class="page-header">
							<h1 class="page-title"><?php the_title(); ?></h1>
						</div>
						<?php the_content(); ?>
					</div>
				</section>
				<?php endwhile; ?>

			</main>

	</div>


<?php
get_footer();

} ?>
