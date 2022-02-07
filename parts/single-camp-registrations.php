<?php 
$placeholder = THEMEURI . 'images/rectangle.png';
$square = THEMEURI . 'images/square.png';
$registration_title = "Registration";
$form_title = "FORMS";

$use_global_options = get_field("use_global_options");
if($use_global_options=='no') {
		$formtypes = get_field("formtypes");
		$payment_options = get_field("payment_options");
		$steps = get_field("steps");
		$sectionContent = array($steps,$payment_options);
		if( $sectionContent && array_filter($sectionContent) ) { ?>
		<section id="section-registration" data-section="<?php echo $registration_title ?>" class="section-content">

			<?php if ($steps) { ?>
			<div class="steps-wrapper">
				<div class="wrapper">
					<div class="flexwrap stepsdata">
						<?php $n=1; foreach ($steps as $s){ 
							$s_icon = $s['icon'];
							$s_title = $s['title'];
							if($s_title) { ?>
							<div class="step">
								<div class="stepnum">Step <?php echo $n ?></div>
								<div class="wrap">
									<div class="text">
										<?php if ($s_icon) { ?>
											<div class="icon"><span style="background-image:url('<?php echo $s_icon['url']?>')"></span></div>
										<?php } ?>
										<?php if ($s_title) { ?>
											<div class="title"><?php echo $s_title ?></div>
										<?php } ?>
									</div>
									<img src="<?php echo $placeholder ?>" alt="" aria-hidden="true" class="placeholder">
								</div>
							</div>	
							<?php $n++; } ?>
						<?php  } ?>
					</div>
					<div class="dashed"><div></div></div>
				</div>
			</div>	
			<?php } ?>

			<?php if ($registration_title) { ?>
			<div class="titlediv registerdiv">
				<div class="wrapper">
					<div class="shead-icon text-center">
						<div class="icon"><span class="ci-editor"></span></div>
						<h2 class="stitle"><?php echo $registration_title ?></h2>
					</div>
				</div>
			</div>
			<?php } ?>

			<?php /* PAYMENT OPTIONS */ ?>
			<?php if ($payment_options) { 
				$countOpts = count($payment_options); 
				$poClass = 'columns1';
				if($countOpts==1) {
					$poClass = 'columns1';
				}
				else if($countOpts==2) {
					$poClass = 'columns2';
				}
				else if($countOpts>2) {
					$poClass = 'columns3';
				}
				?>
			<div class="camps-payment-options full <?php echo $poClass ?>">
				<div class="flexwrap">
					<?php foreach ($payment_options as $p) {
						$type = $p['type'];
						$description = $p['description'];
						$button = $p['button'];
						$buttonName = ( isset($button['title']) && $button['title'] ) ? $button['title']:''; 
						$buttonLink = ( isset($button['url']) && $button['url'] ) ? $button['url']:''; 
						$buttonTarget = ( isset($button['target']) && $button['target'] ) ? $button['target']:'_self'; 
						if($type) { ?>
						<div class="fcol">
							<div class="inside">
								<div class="titlediv js-blocks"><h2 class="type"><?php echo $type ?></h2></div>
								<div class="textwrap">
									<div class="text"><?php echo $description ?></div>
									<?php if ($buttonName && $buttonLink) { ?>
									<div class="buttondiv">
										<a href="<?php echo $buttonLink ?>" target="<?php echo $buttonTarget ?>" class="btn-sm"><span><?php echo $buttonName ?></span></a>
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
		<?php } ?>

		<?php /* FORMS */ ?>
		<?php
		$form_text = get_field("form_text");
		$form_note = get_field("form_note");
		if( $formtypes || $form_note || $form_text ) { ?>
			<section id="section-forms" data-section="<?php echo $form_title ?>" class="section-content">
				<div class="camp-form-types full">
					<div class="wrapper">
						<?php if ($form_title) { ?>
							<div class="shead-icon text-center">
								<div class="icon"><span class="ci-board"></span></div>
								<h2 class="stitle"><span><?php echo $form_title ?></span></h2>
							</div>
						<?php } ?>
						<?php if ($form_text) { ?>
							<div class="form-text text-center">
								<?php echo $form_text ?>
							</div>
						<?php } ?>
					</div>

					<?php
					if($formtypes) {
						$countTypes = count($formtypes); 
						$typesClass = 'columns1';
						if($countTypes==1) {
							$typesClass = 'columns1';
						}
						else if($countTypes==2) {
							$typesClass = 'columns2';
						}
						else if($countTypes>2) {
							$typesClass = 'columns3';
						}
						?>
						<div class="form-types <?php echo $typesClass ?>">
							<div class="flexwrap">
							<?php foreach ($formtypes as $e) { 
								$f_title = $e['title'];
								$f_text = $e['description'];
								$f_button = $e['button'];
								$f_buttonName = ( isset($f_button['title']) && $f_button['title'] ) ? $f_button['title']:''; 
								$f_buttonLink = ( isset($f_button['url']) && $f_button['url'] ) ? $f_button['url']:''; 
								$f_buttonTarget = ( isset($f_button['target']) && $f_button['target'] ) ? $f_button['target']:'_self'; 
								$has_button = ($f_buttonName && $f_buttonLink) ? 'hasButton':'noButton';
								if($f_title || $f_text) { ?>
								<div class="block text-center <?php echo $has_button ?>">
									<div class="inner">
										<?php if ($f_title) { ?>
											<div class="ftitle">
												<h2><?php echo $f_title ?></h2>
											</div>
										<?php } ?>

										<div class="ftextwrap">
											<?php if ($f_text) { ?>
												<div class="ftext">
													<?php echo $f_text ?>
												</div>
											<?php } ?>

											<?php if ($f_buttonName && $f_buttonLink) { ?>
												<div class="buttondiv">
													<a href="<?php echo $f_buttonLink ?>" target="<?php echo $f_buttonTarget ?>" class="btn-sm"><span><?php echo $f_buttonName ?></span></a>
												</div>	
											<?php } ?>
										</div>

									</div>
								</div>
								<?php } ?>
							<?php } ?>
							<?php //echo do_shortcode('[camp_forms]'); ?>
							</div>
						</div>
					<?php } ?>

					<?php if ($form_note) { ?>
						<div class="form-note text-center">
							<?php echo $form_note ?>
						</div>
					<?php } ?>

				</div>
			</section>
		<?php } ?>
		

<?php } else { ?>


	<?php /* GLOBAL OPTIONS */ ?>

	<?php 
		$formtypes = get_field("formtypes","option");
		$payment_options = get_field("payment_options","option");
		$steps = get_field("steps","option");
		$sectionContent = array($steps,$payment_options);
		if( $sectionContent && array_filter($sectionContent) ) { ?>
		<section id="section-registration" data-section="<?php echo $registration_title ?>" class="section-content">

			<?php if ($steps) { ?>
			<div class="steps-wrapper">
				<div class="wrapper">
					<div class="flexwrap stepsdata">
						<?php $n=1; foreach ($steps as $s){ 
							$s_icon = $s['icon'];
							$s_title = $s['title'];
							if($s_title) { ?>
							<div class="step">
								<div class="stepnum">Step <?php echo $n ?></div>
								<div class="wrap">
									<div class="text">
										<?php if ($s_icon) { ?>
											<div class="icon"><span style="background-image:url('<?php echo $s_icon['url']?>')"></span></div>
										<?php } ?>
										<?php if ($s_title) { ?>
											<div class="title"><?php echo $s_title ?></div>
										<?php } ?>
									</div>
									<img src="<?php echo $placeholder ?>" alt="" aria-hidden="true" class="placeholder">
								</div>
							</div>	
							<?php $n++; } ?>
						<?php  } ?>
					</div>
					<div class="dashed"><div></div></div>
				</div>
			</div>	
			<?php } ?>

			<?php if ($registration_title) { ?>
			<div class="titlediv registerdiv">
				<div class="wrapper">
					<div class="shead-icon text-center">
						<div class="icon"><span class="ci-editor"></span></div>
						<h2 class="stitle"><?php echo $registration_title ?></h2>
					</div>
				</div>
			</div>
			<?php } ?>

			<?php /* PAYMENT OPTIONS */ ?>
			<?php if ($payment_options) { 
				$countOpts = count($payment_options); 
				$poClass = 'columns1';
				if($countOpts==1) {
					$poClass = 'columns1';
				}
				else if($countOpts==2) {
					$poClass = 'columns2';
				}
				else if($countOpts>2) {
					$poClass = 'columns3';
				}
				?>
			<div class="camps-payment-options full <?php echo $poClass ?>">
				<div class="flexwrap">
					<?php foreach ($payment_options as $p) {
						$type = $p['type'];
						$description = $p['description'];
						$button = $p['button'];
						$buttonName = ( isset($button['title']) && $button['title'] ) ? $button['title']:''; 
						$buttonLink = ( isset($button['url']) && $button['url'] ) ? $button['url']:''; 
						$buttonTarget = ( isset($button['target']) && $button['target'] ) ? $button['target']:'_self'; 
						if($type) { ?>
						<div class="fcol">
							<div class="inside">
								<div class="titlediv js-blocks"><h2 class="type"><?php echo $type ?></h2></div>
								<div class="textwrap">
									<div class="text"><?php echo $description ?></div>
									<?php if ($buttonName && $buttonLink) { ?>
									<div class="buttondiv">
										<a href="<?php echo $buttonLink ?>" target="<?php echo $buttonTarget ?>" class="btn-sm"><span><?php echo $buttonName ?></span></a>
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
		<?php } ?>

		<?php
		$form_text = get_field("form_text","option");
		$form_note = get_field("form_note","option");
		if( $formtypes || $form_note || $form_text ) { ?>
		<section id="section-forms" data-section="<?php echo $form_title ?>" class="section-content">
			<div class="camp-form-types full">
				<div class="wrapper">
					<?php if ($form_title) { ?>
						<div class="shead-icon text-center">
							<div class="icon"><span class="ci-board"></span></div>
							<h2 class="stitle"><span><?php echo $form_title ?></span></h2>
						</div>
					<?php } ?>
					<?php if ($form_text) { ?>
						<div class="form-text text-center">
							<?php echo $form_text ?>
						</div>
					<?php } ?>
				</div>

				<?php
				if( $formtypes ) {
					$countTypes = count($formtypes); 
					$typesClass = 'columns1';
					if($countTypes==1) {
						$typesClass = 'columns1';
					}
					else if($countTypes==2) {
						$typesClass = 'columns2';
					}
					else if($countTypes>2) {
						$typesClass = 'columns3';
					}
					?>
					<div class="form-types <?php echo $typesClass ?>">
						<div class="flexwrap">
						<?php foreach ($formtypes as $e) { 
							$f_title = $e['title'];
							$f_text = $e['description'];
							$f_button = $e['button'];
							$f_buttonName = ( isset($f_button['title']) && $f_button['title'] ) ? $f_button['title']:''; 
							$f_buttonLink = ( isset($f_button['url']) && $f_button['url'] ) ? $f_button['url']:''; 
							$f_buttonTarget = ( isset($f_button['target']) && $f_button['target'] ) ? $f_button['target']:'_self'; 
							$has_button = ($f_buttonName && $f_buttonLink) ? 'hasButton':'noButton';
							if($f_title || $f_text) { ?>
							<div class="block text-center <?php echo $has_button ?>">
								<div class="inner">
									<?php if ($f_title) { ?>
										<div class="ftitle">
											<h2><?php echo $f_title ?></h2>
										</div>
									<?php } ?>

									<div class="ftextwrap">
										<?php if ($f_text) { ?>
											<div class="ftext">
												<?php echo $f_text ?>
											</div>
										<?php } ?>

										<?php if ($f_buttonName && $f_buttonLink) { ?>
											<div class="buttondiv">
												<a href="<?php echo $f_buttonLink ?>" target="<?php echo $f_buttonTarget ?>" class="btn-sm"><span><?php echo $f_buttonName ?></span></a>
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

				<?php if ($form_note) { ?>
					<div class="form-note text-center">
						<?php echo $form_note ?>
					</div>
				<?php } ?>

			</div>
		</section>
		<?php } ?>

<?php } ?>