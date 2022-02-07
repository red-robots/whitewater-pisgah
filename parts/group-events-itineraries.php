<?php
$placeholder = THEMEURI . 'images/rectangle.png';
$placeholder2 = THEMEURI . 'images/rectangle-narrow.png';
$section_title = get_field("sample_itineraries_title");
$accordion = get_field("accordion_content");
if($accordion) { ?>
<section id="section-itineraries" data-section="<?php echo $section_title ?>" class="section-content">
	<div class="wrapper titlediv">
		<div class="shead-icon text-center">
			<div class="icon"><span class="ci-menu"></span></div>
			<h2 class="stitle"><?php echo $section_title ?></h2>
		</div>
	</div>
	<div class="accordiondata wrapper narrow">
		<div class="accordion-wrapper">
			<?php $n=1; foreach ($accordion as $a) { 
				$title = $a['grouptitle'];
				$entries = $a['entries'];
				$isActive = ($n==1) ? ' active':'';
				$display = ($n==1) ? ' style="display:block"':'';
				if($entries) { ?>
				<div class="accordion-item<?php echo $isActive?>">
					<div class="accordion-title"><?php echo $title ?><i class="arrow"></i></div>
					<div class="accordion-text"<?php echo $display ?>>
						<?php foreach ($entries as $e) { 
							$e_title = $e['title'];
							$e_text = $e['text'];
							$e_image = $e['image'];
							$e_class = ( ($e_title || $e_text) && $e_image ) ? 'half':'full';
							?>
							<div class="subdata <?php echo $e_class ?>">
								<div class="flexwrap">
								<?php if ($e_title || $e_text) { ?>
									<div class="subcol left">
										<?php if ($e_title) { ?>
											<h3 class="etitle"><?php echo $e_title ?></h3>
										<?php } ?>
										<?php if ($e_text) { ?>
											<div class="etext"><?php echo $e_text ?></div>
										<?php } ?>
									</div>
								<?php } ?>

								<?php if ($e_image) { ?>
									<div class="subcol right image">
										<div class="image" style="background-image:url('<?php echo $e_image['sizes']['medium_large'] ?>')"></div>
										<img src="<?php echo $placeholder ?>" alt="" aria-hidden="true">
									</div>
								<?php } ?>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
				<?php $n++; } ?>
			<?php } ?>
		</div>
	</div>
</section>
<?php } ?>

<script type="text/javascript">
jQuery(document).ready(function($){
	$(document).on("click",".accordion-title",function(){
		//$(".accordion-item").removeClass("active");
		//var parent = $(this).parents(".accordion-item");
		$(this).parent().toggleClass('active');
		$(this).parent().find(".accordion-text").slideToggle();
	});
});
</script>