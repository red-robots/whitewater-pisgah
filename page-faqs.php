<?php
/**
 * Template Name: FAQs
 */

$placeholder = THEMEURI . 'images/rectangle.png';
$banner = get_field("flexslider_banner");
$has_banner = ($banner) ? 'hasbanner':'nobanner';
get_header(); ?>

<div id="primary" class="content-area-full content-faqs-page <?php echo $has_banner ?>">
	<main id="main" class="site-main" role="main">

		<div id="faqs"></div>

		<?php while ( have_posts() ) : the_post(); ?>
			<section class="text-centered-section">
				<div class="wrapper text-center">
					<div class="page-header">
						<h1 class="page-title"><?php the_title(); ?></h1>
					</div>
					<?php the_content(); ?>
				</div>
			</section>
		<?php endwhile; ?>

		<?php  
		$faqTerms = get_terms( array(
		    'taxonomy' => 'faq_type',
		    'hide_empty' => true,
		));
		if($faqTerms) { ?>
		<section class="faq-categories">
			<div class="wrapper">
				<div id="faqTabs" class="flexwrap2">
					<!-- <div class="faqcat">
						<a href="#" data-termid="all" class="faqType active">All</a>
					</div>	 -->
					<?php 
					$a = 1;
					foreach ($faqTerms as $t) { 
						if($a==1) {
							$first_faq_group = strval('faqterm-'.$t->term_id);
							$class = 'active';
						} else {
							$class = '';
						}
						?>
					<div class="faqcat">
						<a href="#" id="faqterm-<?php echo $t->term_id?>" data-termid="<?php echo $t->term_id?>" class="faqType <?php echo $class; ?> <?php echo $first_faq_group; ?>"><?php echo $t->name?></a>
					</div>	
					<?php $a++; }  ?>
				</div>
				<div id="faqSelect"></div>
			</div>
		</section>
		<?php } ?>

		<?php
			$args = array(
				'posts_per_page'   => -1,
				'post_type'        => 'faqs',
				'post_status'      => 'publish'
			);
			$faqs = new WP_Query($args);
			$first_faq = '';
			if ( $faqs->have_posts() ) {  ?>
			<section class="main-faqs-icons">
				<div class="wrapper">
					<div class="flexwrap">
						<?php $i=1; while ( $faqs->have_posts() ) : $faqs->the_post(); 
								$id = get_the_ID();
								$icon = get_field("custom_icon");
								$title = get_the_title();
								if($i==1) {
									$first_faq = $id;
								} 
								$postTerms = get_the_terms($id,'faq_type');
								$postTermId = ($postTerms) ? $postTerms[0]->term_id : '';
								$termClass = ($postTermId) ? ' faqterm-'.$postTermId:'';

								$faqNum = 'faqterm-'.$postTermId;
								if( $first_faq_group == $faqNum ) {
									$styleIt = 'style=""';
								} else {
									$styleIt = 'style="display: none;"';
								}
								// var_dump($first_faq_group);
								// var_dump($faqNum);
							?>
							<a href="#" data-id="<?php echo $id ?>" data-termid="<?php echo $postTermId ?>" class="faq faqGroup faqpid-<?php echo $id.$termClass ?> " <?php echo $styleIt; ?>>
								<?php if ($icon) { ?>
								<span class="icon"><i class="<?php echo $icon ?>"></i></span>	
								<?php } ?>
								<?php if ($title) { ?>
								<span class="title"><?php echo $title ?></span>	
								<?php } ?>
							</a>
						<?php $i++; endwhile; wp_reset_postdata(); ?>
					</div>
				</div>
			</section>


			<div class="main-faq-items" id="faqItems" style="display:none">
				<div class="wrapper narrow">
					<div id="faqsContainer">
						<?php echo ($first_faq) ? getFaqs($first_faq) : ''; ?>
					</div>
				</div>
			</div>
			<?php } ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php include( locate_template('inc/faqs.php') ); ?>
<script type="text/javascript">
jQuery(document).ready(function($){
	if( $(".faqType").length>0 ) {
		var faq_select = '<select class="faq-selection">';
		faq_select += '<option value="all">All</option>';
		$(".faqType").each(function(){
			var cat = $(this).text();
			var termid = $(this).attr("data-termid");
			faq_select += '<option value="'+termid+'">'+cat+'</option>';
		});
		faq_select += '</select>';
		$("#faqSelect").html(faq_select);
	}
	

	$(document).on("click",".faqType",function(e){
		e.preventDefault();
		var id = $(this).attr("data-termid");
		$(".faqType").removeClass('active');
		$(".faqGroup").removeClass('active');
		$(this).addClass("active");

		if(id=='all') {
			$(".faqGroup").each(function(){
				$(this).addClass("animated fadeIn").show();
			});
		} else {
			$("#faqItems").hide();
			$(".faqGroup").removeClass("animated fadeIn");
			$(".faqGroup").show();
			$(".faqGroup").each(function(){
				var termid = $(this).attr("data-termid");
				if(termid==id) {
					$(this).addClass("animated fadeIn");
				} else {
					$(this).removeClass("animated fadeIn").hide();
				}
			});
		}
		var pageURL = '<?php echo get_permalink(); ?>';
		history.replaceState('',document.title,pageURL);
	});

	$(document).on("change","select.faq-selection",function(e){
		e.preventDefault();
		var id = $(this).val();
		$(".faqGroup").removeClass('active');
		if(id=='all') {
			$(".faqGroup").each(function(){
				$(this).addClass("animated fadeIn").show();
			});
		} else {
			$(".faqType").removeClass('active');
			$('#faqterm-'+id).addClass("active");
			$("#faqItems").hide();
			$(".faqGroup").removeClass("animated fadeIn");
			$(".faqGroup").show();
			$(".faqGroup").each(function(){
				var termid = $(this).attr("data-termid");
				if(termid==id) {
					$(this).addClass("animated fadeIn");
				} else {
					$(this).removeClass("animated fadeIn").hide();
				}
			});
		}
		
	});
});
</script>
<?php
get_footer();
