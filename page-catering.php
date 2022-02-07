<?php
/**
 * Template Name: Catering
 */

get_header(); 
$blank_image = THEMEURI . "images/square.png";
$placeholder = THEMEURI . 'images/rectangle.png';
?>
<div id="primary" data-post="<?php echo get_the_ID()?>" class="content-area-full catering-page">
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
		if( $galleries = get_field("gallery") ) { ?>
		<div class="carousel-wrapper-section full">
			<div id="carousel-images">
				<div class="loop owl-carousel owl-theme">
				<?php foreach ($galleries as $g) { ?>
					<div class="item">
						<div class="image" style="background-image:url('<?php echo $g['url']?>')">
							<img src="<?php echo $placeholder ?>" alt="" aria-hidden="true" />
						</div>
					</div>
				<?php } ?>
				</div>
			</div>
		</div>
		<?php } ?>


		<?php 
		/* FAQS */
		$customFAQTitle = 'FAQS'; /* Title will have an icon */
		include( locate_template('parts/content-faqs.php') );   
		?>

		<?php $inquiry = get_field("inquire"); ?>
		<?php if ($inquiry) { ?>
		<div class="inquiry-wrapper full">
			<div class="wrapper narrow text-center">
				<?php echo anti_email_spam($inquiry); ?>
			</div>
		</div>
		<?php } ?>



</div><!-- #primary -->

<?php include( locate_template('inc/faqs.php') );  ?>
<script type="text/javascript">
jQuery(document).ready(function($){
	$('.loop').owlCarousel({
    center: true,
    items:2,
    nav: true,
    loop:true,
    margin:15,
    autoplay:true,
    autoplayTimeout:3000,
    autoplayHoverPause:true,
    responsive:{
      600:{
       	items:2
      },
      400:{
       	items:1
      }
    }
	});
});
</script>

<?php
get_footer();
