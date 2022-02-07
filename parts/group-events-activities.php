<?php
$placeholder = THEMEURI . 'images/rectangle.png';
$placeholder2 = THEMEURI . 'images/rectangle-narrow.png';
$section_title = 'Activities';
$camp_activities = get_field("activities_flexcontent");
if($camp_activities) { ?>

<section id="section-activities" data-section="<?php echo $section_title ?>" class="section-content group-events-activities">
	<div class="wrapper titlediv">
		<div class="shead-icon text-center">
			<div class="icon"><span class="ci-task"></span></div>
			<h2 class="stitle"><?php echo $section_title ?></h2>
		</div>
	</div>


	<div class="entryList flexwrap">
		<?php $i=1; foreach ($camp_activities as $e) { ?>
			<?php  
			$title = $e['title'];
			$time = $e['time'];
			$thumbnail = $e['image'];
			$description = $e['description'];
			$summary = $e['summary'];
			$isFull = ( isset($e['fullwidth_layout']) && $e['fullwidth_layout'] ) ? true : false;
			$isFullWidth = ($isFull) ? ' fullwidthbox':'';

			$button = $e['button'];
			$buttonName = ( isset($button['title']) && $button['title'] ) ? $button['title']:''; 
			$buttonLink = ( isset($button['url']) && $button['url'] ) ? $button['url']:''; 
			$buttonTarget = ( isset($button['target']) && $button['target'] ) ? $button['target']:'_self'; 

			$details_option = ( isset($e['details_display_option']) && $e['details_display_option'] ) ? $e['details_display_option']:''; 
			$pageLink = ( isset($e['pagelink_button']) && $e['pagelink_button'] ) ? get_permalink($e['pagelink_button']):''; 

			?>
			<div id="entryBlock<?php echo $i?>" class="fbox <?php echo ($thumbnail) ? 'hasImage':'noImage'; ?><?php echo $isFullWidth ?>">
				<div class="inside text-center">
					<div class="imagediv <?php echo ($thumbnail) ? 'hasImage':'noImage'?>">
						<?php if ($thumbnail) { ?>
							<span class="img" style="background-image:url('<?php echo $thumbnail['url']?>')"></span>
						<?php } ?>

						<?php if ($isFull) { ?>
							<img src="<?php echo $thumbnail['url'] ?>" alt="<?php echo $thumbnail['title'] ?>" class="placeholder">
						<?php } else { ?>
							<img src="<?php echo $placeholder ?>" alt="" aria-hidden="true" class="placeholder">
						<?php } ?>
					</div>
					<div class="titlediv">
						<p class="name"><?php echo $title ?></p>
						<?php if ($summary) { ?>
						<div class="summary-block"><?php echo $summary ?></div>	
						<?php } ?>
						
						<?php /* BUTTON */ ?>
						<?php if ($details_option=='pagelink' && $pageLink) { ?>
						<div class="buttondiv">
							<a href="<?php echo $pageLink ?>" class="btn-sm"><span>See Details</span></a>
						</div>
						<?php } else { ?>

							<?php if ($details_option=='popup' && $description) { ?>
							<div class="buttondiv">
								<a data-toggle="modal" data-target="#entryBlock<?php echo $i?>Modal" class="btn-sm"><span>See Details</span></a>
							</div>
							<?php } ?>

						<?php } ?>
						
					</div>

					<?php if ($details_option=='popup' && $description) { ?>
					<!-- DETAILS -->
					<div class="modal customModal fade" id="entryBlock<?php echo $i?>Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-lg" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					      	<div class="modaltitleDiv text-center">
					      		<h5 class="modal-title"><?php echo $title ?></h5>
					      		<?php if ($time) { ?>
					      		<div class="time"><?php echo $time ?></div>	
					      		<?php } ?>
					      	</div>

					      	<?php if ($thumbnail) { ?>
					      	<div class="modalImage">
					      		<img src="<?php echo $thumbnail['url'] ?>" alt="<?php echo $thumbnail['title'] ?>" class="feat-image">
					      	</div>
									<?php } ?>

					      	<div class="modalText">
					      		<div class="text"><?php echo $description ?></div>
					      		<?php if ($buttonName && $buttonLink) { ?>
					      			<div class="buttondiv text-center">
												<a href="<?php echo $buttonLink ?>" target="<?php echo $buttonTarget ?>" class="btn-sm"><span><?php echo $buttonName ?></span></a>
											</div>
					      		<?php } ?>
					      	</div>
					      </div>
					    </div>
					  </div>
					</div>
					<?php } ?>

				</div>
			</div>
		<?php $i++; } ?>
	</div>

</section>

<?php } ?>