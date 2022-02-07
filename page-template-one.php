<?php
/**
 * Template Name: Template One
 */

get_header(); ?>

<div id="primary" data-post="<?php echo get_the_ID()?>" class="content-area-full template-one">
		
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

</div><!-- #primary -->

<?php
get_footer();
