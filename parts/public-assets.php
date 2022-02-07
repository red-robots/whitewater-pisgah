<?php /* ACTIVITIES */ ?>
<?php if( $bottom_activities = get_field("public_assets") ) { 
	$countActivities = count($bottom_activities);
	$sTitle = get_field('popup_section_title');
?>
<section id="section-activities" data-section="Programming" class="section-content camp-activities countItems<?php echo $countActivities?>">
	<?php if( $sTitle ){ ?>
	<div class="wrapper titlediv">
		<div class="shead-icon text-center">
			<div class="icon"><span class="ci-task"></span></div>
			<h2 class="stitle"><?php echo $sTitle; ?></h2>
		</div>
	</div>
	<?php } ?>

	<div class="entryList flexwrap">
		<?php $b=1; foreach ($bottom_activities as $ba) {
			
			$pid = $ba->ID;
			$title = $ba->post_title;
			// $pExcerpt = $ba->post_excerpt;
			$pExcerpt = get_field('excerpt',$pid);
			// $description = ($ba->post_content) ? shortenText(strip_shortcodes(strip_tags($ba->post_content)),300," ","..."):'';
			$description = get_field('content',$pid);;
			if( $pExcerpt ) {
				$description = $pExcerpt;
			}
			$thumbnail = get_field("thumbnail_image",$pid);
			$buttonLink = get_permalink($pid);
			$pageLink = '#';
			$contentType = get_field("content_display_type",$pid);
			$is_popup = ($contentType=='pagelink') ? false : true;
			$url = get_field("pagelink",$pid);
			$btnURL = ( isset($url['url']) && $url['url'] ) ? $url['url'] : '';
			$btnText = ( isset($url['title']) && $url['title'] ) ? $url['title'] : '';
			$btnTarget = ( isset($url['target']) && $url['target'] ) ? $url['target'] : '_self';
			if($contentType=='nobutton') {
				$is_popup = false;
				$btnURL = '';
				$btnText = '';
			}
			
		?>
		<div id="entryBlock<?php echo $b?>" class="fbox <?php echo ($thumbnail) ? 'hasImage':'noImage'; ?>">
			<div class="inside text-center">
				<div class="imagediv <?php echo ($thumbnail) ? 'hasImage':'noImage'?>">
					<?php if ($thumbnail) { 
							if ($is_popup) { ?>
								<a href="#" data-url="<?php echo $pageLink ?>" data-action="ajaxGetPageData" data-id="<?php echo $pid ?>" class=" ajaxLoadContent popdata">
							<?php } else { ?>
								<a href="<?php echo $btnURL ?>" target="<?php echo $btnTarget ?>" class=" ">
							<?php } ?>
								<span class="img" style="background-image:url('<?php echo $thumbnail['url']?>')"></span>
							</a>
					<?php } ?>
					<img src="<?php echo $placeholder ?>" alt="" aria-hidden="true" class="placeholder">
				</div>
				<div class="titlediv">
					<p class="name"><?php echo $title ?></p>
					<?php if ($description) { ?>
					<div class="excerpt"><?php echo $description; ?></div>	
					<?php } ?>

					<?php if ($is_popup) { ?>
						<div class="buttondiv">
							<a href="#" data-url="<?php echo $pageLink ?>" data-action="ajaxGetPageData" data-id="<?php echo $pid ?>" class="btn-sm ajaxLoadContent popdata"><span>See Details</span></a>	
						</div>
					<?php } else { ?>
						<?php if ( ($btnURL && $btnText) && $contentType=='pagelink' ) { ?>
						<div class="buttondiv">
							<a href="<?php echo $btnURL ?>" target="<?php echo $btnTarget ?>" class="btn-sm xs btn-link"><span><?php echo $btnText ?></span></a>	
						</div>
						<?php } ?>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php $b++; } ?>
	</div>
</div>
</section>

<?php } ?>