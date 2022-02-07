<?php
/* CHECK-IN */ 
$rectangle = THEMEURI . "images/rectangle.png";
$square = THEMEURI . "images/square.png";
$checkin_images = array();
$checkin_rows = array();
$points_title = get_field("points_section_title");
$sIcon = get_field("points_section_icon");
// echo '<pre>';
// print_r($sIcon);
// echo '</pre>';
$section4 = ($points_title) ? $points_title : 'Points of Interest';

if( have_rows('points_of_interest') ): ?>
<section id="points-of-interest" data-section="<?php echo $section4 ?>" class="section-content<?php echo $checkin_classes;?>">
	<div class="wrapper">
		<div class="shead-icon text-center svg-sec-icon">
			<div class="icon">
					<img src="<?php echo $sIcon['url']; ?>">
				</div>
			<h2 class="stitle"><?php echo $section4; ?></h2>
			<?php if ($stories_text) { ?>
			<div class="subtext">
				<?php echo $stories_text ?>
				<?php if( current_user_can( 'administrator' ) ){ ?>
				<div class="edit-entry"><a href="<?php echo $stories_edit_link ?>" style="text-decoration:underline;">Edit Text</a></div>
				<?php } ?>
			</div>	
			<?php } ?>
		</div>
	</div>
	<?php while( have_rows('points_of_interest') ): the_row();
	
	


?>

<section id="points-of-interest-inside"  class="section-content<?php echo $checkin_classes;?> has-two-images">
	<div class="wrapper-full">
		<div class="flexwrap">
			<?php  $i=1; 
				$lDesc = get_sub_field('location_description'); 
				$map = get_sub_field('location_map'); 
				
				?>
				<div class="col-left">
					<div class="flex-content largebox has-text">
						<div class="inside with-pad">
							<div><?php echo $lDesc; ?></div>
						</div>
					</div>
					<div class="flex-content largebox has-text">
						<div class="inside with-pad poi-iframe-map">
							<?php echo $map; ?>
						</div>
					</div>
				</div>
				
		</div>
	</div>
</section><!-- end section -->
<?php endwhile; ?><!-- end while --><?php endif;?><!-- end if -->