<?php
/**
 * Template Name: Accomodations
 */

get_header(); 
$blank_image = THEMEURI . "images/square.png";
$square = THEMEURI . "images/square.png";
$rectangle = THEMEURI . "images/rectangle-lg.png";
?>

<div id="primary" data-post="<?php echo get_the_ID()?>" class="content-area-full festival-page race-series-page">
		<?php while ( have_posts() ) : the_post(); ?>
			
				<div class="intro-text-wrap">
					<div class="wrapper">
						<h1 class="page-title"><span><?php the_title(); ?></span></h1>
						<?php if( get_the_content() ) { ?>
						<div class="intro-text"><?php the_content(); ?></div>
						<?php } ?>
					</div>
				</div>
			
		<?php endwhile;  ?>


		<?php if($accomodations = get_field("accomodations")) { ?>

		<div class="accomodations <?php echo ( get_the_content() ) ? 'padtop':'nopadtop'?>">
			<div class="wrapper">
			<?php foreach ($accomodations as $a) { 
				$logo = $a['logo'];
				$title1 = $a['title1'];
				$title2 = $a['title2'];
				$contact = $a['contact'];
				$website = $a['website'];
				$contactArr = array($title1,$title2,$website,$contact);
				$has_contact = ( array_filter($contactArr) ) ? true : false;
				$box_class = ( $logo && $has_contact ) ? 'full':'half';
				$link_open = '';
				$link_close = '';
				if($website) {
					$link_open = '<a href="'.$website.'" target="_blank">';
					$link_close = '</a>';
				}
				?>
				<div class="info <?php echo $box_class ?>">
					<div class="flexwrap">
						<?php if ($logo) { ?>
						<div class="leftcol">
							<?php echo $link_open ?>
								<span class="img" style="background-image:url('<?php echo $logo['url'] ?>')">
									<img src="<?php echo $square ?>" alt="" aria-hidden="true" class="helper">
								</span>
								<img src="<?php echo $logo['url'] ?>" alt="<?php echo $logo['title'] ?>" class="logo-img">
							<?php echo $link_close ?>
						</div>	
						<?php } ?>

						<?php if ($has_contact) { ?>
						<div class="rightcol">
							<div class="inner">
							<?php if ($title1 || $title2) { ?>
							<div class="titlediv">
								<?php if ($title1) { ?>
								<h3 class="t1"><?php echo $link_open . $title1 . $link_close ?></h3>	
								<?php } ?>

								<?php if ($title2) { ?>
								<h4 class="t2"><?php echo $title2 ?></h4>	
								<?php } ?>
							</div>
							<?php } ?>
							

							<?php if ($contact) { ?>
							<div class="text"><?php echo $contact ?></div>	
							<?php } ?>
							</div>
						</div>	
						<?php } ?>
					</div>
				</div>
			<?php } ?>
			</div>
		</div>

		<?php } ?>

</div><!-- #primary -->
<script type="text/javascript">
jQuery(document).ready(function($){

});
</script>
<?php
get_footer();
