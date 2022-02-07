<?php
/**
 * Template Name: Film Series
 */

get_header(); 
$blank_image = THEMEURI . "images/square.png";
$square = THEMEURI . "images/square.png";
?>

<div id="primary" data-post="<?php echo get_the_ID()?>" class="content-area-full film-series-page festival-page">
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

		<?php get_template_part("parts/film-series-filter"); ?>

</div><!-- #primary -->


<!-- DETAILS -->
<div id="modalDetails" class="modal modalFilmSeries customModal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="modalBody" class="modal-body">
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
jQuery(document).ready(function($){
	$("#modalDetails").insertBefore(".site-footer");
	$(".popupinfo").on("click",function(e){
		e.preventDefault();
		var link = $(this).attr("data-href");
		$("#loaderDiv").show();
		$("#modalBody").load(link+" #content-info",function(){
			setTimeout(function(){
				$("#loaderDiv").hide();
				$("#modalDetails").modal('show');
			},1000);
		});
	});
});	
</script>
<?php
get_footer();
