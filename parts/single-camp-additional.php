<section id="section-requirements" data-section="Additional Information" class="section-content">
	<?php /* REQUIREMENTS */ ?>
	<?php 
	$placeholder = THEMEURI . 'images/rectangle.png';
	$square = THEMEURI . 'images/square.png';
	$requirements = get_field("activity_requirements"); 
	?>
	<?php if ($requirements) { ?>
		<?php  
			$countReqs = count($requirements); 
			$reqsClass = 'columns1';
			if($countReqs==1) {
				$reqsClass = 'columns1';
			}
			else if($countReqs==2) {
				$reqsClass = 'columns2';
			}
			else if($countReqs>2) {
				$reqsClass = 'columns3';
			}
		?>
		<div class="camp-requirements full <?php echo $reqsClass ?>">
			<div class="flexwrap">
				<?php foreach ($requirements as $r) { 
					$img = $r['image'];
					$title = $r['title'];
					$text = $r['description'];
					$rbutton = $r['button'];
					$rbuttonName = ( isset($rbutton['title']) && $rbutton['title'] ) ? $rbutton['title']:'See Details'; 
					$rbuttonLink = ( isset($rbutton['url']) && $rbutton['url'] ) ? $rbutton['url']:''; 
					$rbuttonTarget = ( isset($rbutton['target']) && $rbutton['target'] ) ? $rbutton['target']:'_self'; 
					$rhasButton = ($rbuttonName && $rbuttonLink) ? 'hasButton':'noButton';
					?>
					
					<?php if ($title || $text) { ?>
					<div class="req-block text-center <?php echo $rhasButton ?>">
						<div class="inside">
							<div class="reqImage <?php echo ($img) ? 'hasImage':'noImage' ?>">
								<?php if ($img) { ?>
								<div class="pic" style="background-image:url('<?php echo $img['url']?>')"></div>
								<?php } ?>
								<img src="<?php echo $placeholder ?>" alt="" aria-hidden="true" class="helper">
							</div>
							<div class="reqText">
								<?php if ($title) { ?>
									<h2 class="rtitle"><?php echo $title ?></h2>
								<?php } ?>
								<?php if ($text) { ?>
									<div class="rtext"><?php echo $text ?></div>
								<?php } ?>
								<?php if ($rbuttonName && $rbuttonLink) { ?>
									<div class="buttondiv">
										<a href="<?php echo $rbuttonLink ?>" target="<?php echo $rbuttonTarget ?>" class="btn-sm xs"><span><?php echo $rbuttonName ?></span></a>
									</div>	
								<?php } ?>
							</div>
						</div>
					</div>
					<?php } ?>

				<?php } ?>
			</div>
		</div>
	<?php } ?>
</section>