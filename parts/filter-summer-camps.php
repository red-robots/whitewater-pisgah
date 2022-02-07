<?php
$result = get_ages_from_camp($ages);
$groupItems = array();
$finalList = array();
$paged = ( get_query_var( 'pg' ) ) ? absint( get_query_var( 'pg' ) ) : 1;
?>

<?php if($result) { ?>
<div class="post-type-entries <?php echo $postype ?>">
	<div id="data-container">
		<div class="posts-inner result">
				<?php
					$i=1;
					foreach ($result as $row) { 
						$id = $row->ID;
						$start = get_field("start_date",$id);
						$eventStatus = ( get_field("eventstatus") ) ? get_field("eventstatus"):'upcoming';
						$groupItems[$eventStatus][] = $row;
						$i++; 
					} 

					krsort($groupItems);
					foreach($groupItems as $k=>$items) {
						foreach($items as $item) {
							$finalList[] = $item;
						}
					}

					$start = 0;
		      $stop = $perpage-1;
		      if($paged>1) {
		        $stop = (($paged+1) * $perpage) - $perpage;
		        $start = $stop - $perpage;
		        $stop = $stop - 1;
		      }
		      $totalItems = count($finalList);
				?>

				<div class="flex-inner entriesCount<?php echo $totalItems?>">
					<?php  for($i=$start; $i<=$stop; $i++) {
		      	if( isset($finalList[$i]) && $finalList[$i] ) {
		      		$p = $finalList[$i];
		      		$id = $p->ID;
		      		$title = $p->post_title;
		      		$pagelink = get_permalink($id);
		      		$start = get_field("start_date",$id);
							$short_description = get_field("short_description",$id);
							$eventStatus = get_field("eventstatus",$id);
							$thumbImage = get_field("thumbnail_image",$id);
							$price = get_field("price",$id);
							$ages = get_field("ages",$id);
							$date_range = get_field("date_range",$id);
							$dates = ($date_range) ?  array_filter( explode(",",$date_range) ):'';
							$age_prices = array($ages,$price);
							$agePriceInfo = ($age_prices && array_filter($age_prices)) ? true : false;
							?>

							<div class="postbox animated fadeIn <?php echo ($thumbImage) ? 'has-image':'no-image' ?> <?php echo $eventStatus ?>">
								<div class="inside">
									<a href="<?php echo $pagelink ?>" class="photo wave-effect js-blocks">
										<?php if ($thumbImage) { ?>
											<span class="imagediv" style="background-image:url('<?php echo $thumbImage['sizes']['medium_large'] ?>')"></span>
											<img src="<?php echo $thumbImage['url']; ?>" alt="<?php echo $thumbImage['title'] ?>" class="feat-img" style="display:none;">
											<img src="<?php echo $blank_image ?>" alt="" class="feat-img placeholder">
										<?php } else { ?>
											<span class="imagediv"></span>
											<img src="<?php echo $blank_image ?>" alt="" class="feat-img placeholder">
										<?php } ?>
										<span class="boxTitle">
											<span class="twrap">
												<span class="t1"><?php echo $title ?></span>
											</span>
										</span>

										<?php include( locate_template('images/wave-svg.php') ); ?>

										<?php if ($eventStatus=='canceled') { ?>
										<span class="canceledStat">
											<img src="<?php echo $canceledImage ?>" alt="" aria-hidden="true">
										</span>	
										<?php } ?>
									</a>

									<div class="details">
										<div class="info">
											<h3 class="event-name"><?php echo $title ?></h3>
											<?php if ($agePriceInfo) { ?>
											<div class="pricewrap">
												<div class="price-info">
													<?php if ($ages) { ?>
													<span class="age"><?php echo $ages ?></span>	
													<?php } ?>
													<?php if ($price) { ?>
													<span class="price"><?php echo $price ?></span>	
													<?php } ?>
												</div>
											</div>
											<?php } ?>

											<?php if ($dates) { ?>
											<ul class="dates">
												<?php foreach ($dates as $date) { ?>
													<li class="date"><?php echo $date ?></li>	
												<?php } ?>
											</ul>
											<?php } ?>

											<?php if ($short_description) { ?>
											<div class="short-description">
												<?php echo $short_description ?>
											</div>
											<?php } ?>

											<div class="button">
												<a href="<?php echo $pagelink ?>" class="btn-sm"><span>See Details</span></a>
											</div>
											
										</div>
									</div>

								</div>
							</div>

						<?php } ?>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php } ?>

<?php 
$total = ($result) ? count($result) : 0;
$total_pages = ceil($total / $perpage);
if ($total > $perpage) { ?> 
	<div class="loadmorediv text-center">
		<div class="wrapper"><a href="#" id="loadMoreEntries2" data-current="1" data-count="<?php echo $total?>" data-total-pages="<?php echo $total_pages?>" class="btn-sm wide loadMoreEntriesBtn"><span>Load More</span></a></div>
	</div>
<?php } ?>

