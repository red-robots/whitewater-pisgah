<?php
$postid = get_the_ID();
$faq_icon = get_field("faq_section_icon");
$faq_title = get_field("faq_section_title");
$faqs = get_faq_listings($postid);
if($faqs) { ?>
<section id="section-faqs" data-section="FAQ" class="section-content no-image faqs-race">
	<div class="wrapper">
		<div class="col faqs">
			
			<?php if ($faq_title) { ?>
			<div class="titlediv">
				<?php if ($faq_icon) { ?>
					<div class="icon-img text-center"><span style="background-image:url('<?php echo  $faq_icon['url']?>')"></span></div>
				<?php } ?>
				<h2 class="sectionTitle text-center"><?php echo $faq_title ?></h2>
			</div>
			<?php } ?>

			<div class="faqsItems">
				<?php foreach ($faqs as $q) { 
					$faq_id = $q['ID'];
					$faq_title = $q['title'];
					$faq_items = $q['faqs'];
					if($faq_items) { ?>
						<div id="faq-<?php echo $faq_id?>" class="faq-group">
							<?php $n=1; foreach ($faq_items as $f) { 
								$question = $f['question'];
								$answer = $f['answer'];
								$isFirst = ($n==1) ? ' first':'';
								if($question && $answer) { ?>
								<div class="faq-item collapsible<?php echo $isFirst ?>">
									<h3 class="option-name"><?php echo $question ?><span class="arrow"></span></h3>
									<div class="option-text"><?php echo $answer ?></div>
								</div>
								<?php } ?>

							<?php $n++; } ?>
						</div>
					<?php } ?>
				<?php } ?>
			</div>	

		</div>
	</div>

</section>
<?php } ?>