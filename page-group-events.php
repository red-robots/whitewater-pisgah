<?php
/**
 * Template Name: Group & Events
 */

get_header(); 
$blank_image = THEMEURI . "images/rectangle.png";
$square = THEMEURI . "images/square.png";
$currentPageLink = get_permalink();
?>

<div id="primary" data-post="<?php echo get_the_ID()?>" class="content-area-full summer-camp-page">
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
		$group_type_title = get_field("group_type_title");
		$group_type_text = get_field("group_type_text");
		$group_type_ctabutton = get_field("group_type_ctabutton");
		$group_types = get_field("group_types");
		if($group_types) { ?>
		<section id="section-group-types" class="section-content padding gray">
			<div class="wrapper">
				<?php if ($group_type_title) { ?>
				<div class="shead-icon text-center">
					<div class="icon"><span class="ci-people"></span></div>
					<h2 class="stitle"><?php echo $group_type_title ?></h2>
				</div>
				<?php } ?>
				<?php if ($group_type_text) { ?>
				<div class="event-text-intro">
					<?php echo $group_type_text ?>
				</div>
				<?php } ?>

				<div class="group-types">
					<div class="flexwrap">
					<?php foreach ($group_types as $g) {
						$type_name = $g['title'];
						$type_icon = $g['custom_icon'];
						if($type_name) { ?>
						<div class="typebox">
							<div class="inner">
								<?php if ($type_icon) { ?>
								<div class="typeIcon"><i class="<?php echo $type_icon ?>"></i></div>	
								<?php } ?>
								<h3><?php echo $type_name ?></h3>
							</div>
						</div>
						<?php } ?>
					<?php } ?>
					</div>
				</div>
			</div>
		</section>
		<?php } ?>

		<?php if ($group_type_ctabutton && do_shortcode($group_type_ctabutton)) { ?>
			<div class="subpage-tabs-wrapper">
				<div class="wrapper">
					<div class="buttondiv"><?php echo do_shortcode($group_type_ctabutton) ?></div>
					<?php get_template_part("parts/subpage-tabs"); ?>
				</div>
			</div>
		<?php } else { ?>
			<div class="noButtonTop"><?php get_template_part("parts/subpage-tabs"); ?></div>
		<?php } ?>

		<?php
			//SERVICES 
			get_template_part("parts/group-events-services");
		?>

		<?php
			//ACTIVITIES 
			get_template_part("parts/group-events-activities");
		?>

		<?php
			//SAMPLE ITINERARIES 
			get_template_part("parts/group-events-itineraries");
		?>

		<?php
		$customFAQTitle = 'FAQ';
		$customFAQClass = 'custom-class-faq';
		include( locate_template('parts/content-faqs.php') );
		?>

</div><!-- #primary -->

<?php  
include( locate_template('inc/faqs.php') );
include( locate_template('inc/pagetabs-script.php') );
?>
<script type="text/javascript">
jQuery(document).ready(function($){
	
});
</script>
<?php
get_footer();
