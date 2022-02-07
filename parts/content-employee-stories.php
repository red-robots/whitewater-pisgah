<?php
$placeholder = THEMEURI . "images/rectangle.png";
$title5 = get_field("title5");
$args = array(
	'posts_per_page'	=> -1,
	'post_type'				=> 'post',
	'post_status'			=> 'publish'
);

$args['tax_query'] = array(
	array(
		'taxonomy' => 'category',
		'field' => 'slug',
		'terms' => 'employment-designation',
		'operator' => 'IN'
  )
);

$stories = new WP_Query($args);
if( $stories->have_posts() ) { ?>
<section id="section5" data-section="<?php echo $title5 ?>" class="section-content employee-stories grid-images">
	<?php if ($title5) { ?>
	<div class="shead-icon text-center">
		<div class="wrapper">
			<div class="icon"><span class="ci-book"></span></div>
			<h2 class="stitle"><?php echo $title5 ?></h2>
		</div>
	</div>
	<?php } ?>

	<div class="entryList flexwrap">
	<?php $i=1; while ( $stories->have_posts()) : $stories->the_post();
		$thumbid = get_post_thumbnail_id(); 
		$img = wp_get_attachment_image_src($thumbid,'large');
		$hasImage = ($img) ? 'hasImage':'noImage';
		?>
		<div id="entryBlock<?php echo $i;?>" class="fbox <?php echo $hasImage ?>">
			<div class="inside text-center">
					<div class="imagediv hasImage">
						<?php if ($img) { ?>
						<span class="img" style="background-image:url('<?php echo $img[0] ?>')"></span>
						<?php } ?>
						<img src="<?php echo $placeholder ?>" alt="" aria-hidden="true" class="placeholder">
					</div>
					<div class="titlediv">
						<p class="name"><?php the_title(); ?></p>
						<div class="buttondiv">
							<a href="<?php echo get_permalink(); ?>" class="btn-sm"><span>Read Story</span></a>
						</div>
					</div>
				</div>
		</div>

	<?php $i++; endwhile; wp_reset_postdata(); ?>
	</div>

</section>
<?php } ?>


