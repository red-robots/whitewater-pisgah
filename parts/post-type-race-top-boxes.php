<?php
// echo '<pre>';
// print_r($race_types);
// echo '</pre>';
$register_section_icon = get_field("register_section_icon"); 
$box_section_title = get_field("eventinfo_section_title"); 
$box_types = get_field("event_info_box"); 
$register_section_title = get_field("register_section_title"); 
$race_types = get_field("race_types"); 
$registration_note = get_field("registration_note");

$has_box_types = '';
if ( isset($box_types) && $box_types ) {
	$has_box_types = ($box_types) ? true : false;
}
$has_race_types = '';
if ( isset($race_types[0]['schedule']) && $race_types[0]['schedule'] ) {
	$has_race_types = ($race_types[0]['schedule']) ? true : false;
}


if($box_section_title || $box_types) { ?>
<section id="section-registration" data-section="Registration" class="section-content">
	
	<?php if ($register_section_title) { ?>
	<div class="title-w-icon">
		<div class="wrapper">
			<div class="shead-icon text-center">
				<div class="icon"><span class="ci-editor"></span></div>
				<h2 class="stitle" style="color:#FFF;"><?php echo $box_section_title ?></h2>
			</div>
		</div>
	</div>
	<?php } ?>


	<?php if ($has_box_types) { 
		$count = count($box_types); 
		$type_class = 'one-col';
		if($count==2) {
			$type_class = 'two-col';
		} 
		elseif($count==3) {
			$type_class = 'three-col';
		} 
		elseif($count>3) {
			$type_class = 'multi-col';
		}
		?>
	<div class="race-types <?php echo $type_class; ?>">
		<div class="inner-wrap">
			<div class="flexwrap">
				<?php foreach ($box_types as $r) { 
					$name = $r['name'];
					$details = $r['details'];
					$button = $r['button'];
					$button_target = ( isset($button['target']) && $button['target'] ) ? $button['target']:'_self';
					?>
					<div class="type">
						<div class="inside">
							<?php if ($name) { ?>
								<div class="type-name"><h3><?php echo $name ?></h3></div>
							<?php } ?>

							<?php if ($details) { ?>
								<div class="type-details">
									<ul class="info">
										<?php foreach ($details as $d) { 
											$d_title = $d['title'];
											$d_text = $d['text'];
											$d_note = $d['note'];
											if ($d_title) { ?>
											<li>
												<p class="i-title"><?php echo $d_title ?></p>
												<?php if ($d_note) { ?>
												<p class="i-note"><?php echo $d_note ?></p>	
												<?php } ?>
												<?php if ($d_text) { ?>
												<p class="i-text"><?php echo $d_text ?></p>	
												<?php } ?>
											</li>	
											<?php } ?>
										<?php } ?>
									</ul>

									<?php if ($button) { ?>
									<div class="button">
										<a href="<?php echo $button['url'] ?>" target="<?php echo $button_target ?>" class="btn-sm"><span><?php echo $button['title'] ?></span></a>
									</div>
									<?php } ?>
									
								</div>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php } 
		$eventInfo = get_field("additional_event_info"); 
		$event_info_btn = get_field("event_info_button_name"); 
		?>
		<?php if ($registration_note || $eventInfo) { ?>
		<div class="black-section">
			<div class="wrapper text-center">
				<?php echo $registration_note; ?>
				<?php if ($eventInfo && $event_info_btn) { ?>
					<div class="buttondiv">
						<a data-toggle="modal" data-target="#additionEventInfo" class="btn-sm xs white popup-event-info"><span><?php echo $event_info_btn ?></span></a>
					</div>			
				<?php } ?>		
			</div>
		</div>	
		<?php } ?>
		
	</section>
<?php 
} 
if ($has_race_types) { 
	$count = count($race_types); 
	$type_class = 'one-col';
	if($count==2) {
		$type_class = 'two-col';
	} 
	elseif($count==3) {
		$type_class = 'three-col';
	} 
	elseif($count>3) {
		$type_class = 'multi-col';
}}
?>
