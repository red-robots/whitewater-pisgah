<?php
get_header(); 
?>
<div id="primary" class="content-area-full job-info-page">
	<main id="main" class="site-main full" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php
			$film_disclaimer = get_field("film_disclaimer");
			$film_trailer = get_field("film_trailer");
			$film_trailer_video_code = get_field("film_trailer_video_code");
			?>
			<section class="text-centered-section">
				<div class="wrapper narrow text-center">
					<div class="page-header">
						<h1 class="page-title"><?php the_title(); ?></h1>
					</div>
					<?php if ($film_trailer_video_code) { ?>
					<div class="video-frame">
						<?php echo $film_trailer_video_code ?>
						<img src="<?php echo $placeholder ?>" alt="" aria-hidden="true" class="helper">		
					</div>	
					<?php } ?>
				</div>
			</section>

			<section class="main-post-text job-description">
				<div class="wrapper narrow">
					<div class="flexwrap">
						<div class="textcol">
							<div class="inside">
								<?php the_content(); ?>
								<?php if( $applyLink = get_field("apply_link") ) { ?>
								<div class="buttondiv" style="margin-top:30px">
									<a href="<?php echo $applyLink ?>" target="_blank" class="btn-sm red xs"><span>Apply Now</span></a>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</section>

		<?php endwhile; ?>

	</main><!-- #main -->
</div><!-- #primary -->


<?php
get_footer();