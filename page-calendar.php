<?php
/**
 * Template Name: Calendar
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package bellaworks
 */

$placeholder = THEMEURI . 'images/rectangle.png';
$banner = get_field("flexslider_banner");
$has_banner = ($banner) ? 'hasbanner':'nobanner';
get_header(); ?>

<div id="primary" class="content-area-full content-default page-default-template <?php echo $has_banner ?>">
	<main id="main" class="site-main wrapper" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<section class="text-centered-section">
				<div class="wrapper text-center">
					<div class="page-header">
						<h1 class="page-title"><?php the_title(); ?></h1>
					</div>
					<?php 

					the_content(); 

					echo do_shortcode('[tribe_events]');
					?>
				</div>
			</section>

		<?php endwhile; ?>

	</main><!-- #main -->
</div><!-- #primary -->
<link rel='stylesheet' id='calendar-styles-css'  href='<?php bloginfo('url'); ?>/wp-content/plugins/events-override/calendar-styles.css?ver=1.4' type='text/css' media='all' />
<?php
get_footer();
