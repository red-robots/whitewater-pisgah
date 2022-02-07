<div id="filter-data-container">
	<div class="inner-data-content">
	<?php  
		$postype = 'instructions';
		$blank_image = THEMEURI . "images/rectangle.png";
		$square = THEMEURI . "images/square.png";
		$currentPageLink = get_permalink();
		$disciplineList = get_instruction_discipline();
		$terms_lesson_format = get_terms( array(
		  'taxonomy' => 'instructions-lesson-format',
		  'hide_empty' => false
		));

		$terms_experience_level = get_terms( array(
		  'taxonomy' => 'instructions-experience-level',
		  'hide_empty' => false
		));

		$terms_duration = get_terms( array(
		  'taxonomy' => 'instructions-duration',
		  'hide_empty' => false
		));
		$currentPage = get_permalink();
		$sel_discipline = ( isset($_GET['discipline']) && $_GET['discipline'] ) ? $_GET['discipline'] : '';
		$sel_lesson = ( isset($_GET['lesson']) && $_GET['lesson'] ) ? $_GET['lesson'] : '';
		$sel_experience = ( isset($_GET['experience']) && $_GET['experience'] ) ? $_GET['experience'] : '';
		$sel_duration = ( isset($_GET['duration']) && $_GET['duration'] ) ? $_GET['duration'] : '';

		$params = array();
		$perpage = 15;
		$paged = ( get_query_var( 'pg' ) ) ? absint( get_query_var( 'pg' ) ) : 1;
		$filter_fields = array('discipline','lesson','experience','duration');
		$has_filter = array();
		$uri_params = '';
		if( isset($_GET) && $_GET ) {
			$n=1; foreach($_GET as $k=>$val) {
				if( in_array($k, $filter_fields) ) {
					$has_filter[$k] = $val;
					$del = ($n>1) ? '&':'';
					$uri_params .= $del . $k . '=' . $val;
					$n++;
				}
			}
			if($has_filter) {
				$params['meta_key']['discipline'] = $sel_discipline;
				$params['taxonomy']['instructions-lesson-format'] = $sel_lesson;
				$params['taxonomy']['instructions-experience-level'] = $sel_experience;
				$params['taxonomy']['instructions-duration'] = $sel_duration;
				$nextpage = $paged + 1;
				$currentPageLink .= '?' . $uri_params;
			}
		}
		$res = get_instructions_result($params,$paged,$perpage);
		$records = ( isset($res['record']) && $res['record'] ) ? $res['record'] : '';
		$total = ( isset($res['total']) && $res['total'] ) ? $res['total'] : '';
		$flexClass = ($total<3) ? ' align-middle':'';
		?>
		<?php /* FILTER OPTIONS */ ?>
		<div class="filter-wrapper label-small non-facetwp options4">
			<div class="wrapper wide">
				<div class="filter-inner">
					<form action="<?php echo $currentPage ?>" method="get" id="instruction-filter">
						<div class="flexwrap">
								<?php /* align-middle  */ ?>
								<?php if ($disciplineList) { ?>
								<div class="select-wrap event-status single-select">
									<label>Activity / Discipline</label>
									<div class="customselectdiv">
										<select name="discipline" id="discipline" class="js-select" style="width:100%">
											<option></option>
											<?php foreach ($disciplineList as $d) { 
												$d_discipline = $d;
												$d_selected = ($sel_discipline && $d_discipline==$sel_discipline) ? ' selected':''; ?>
												<option value="<?php echo $d_discipline ?>"<?php echo $d_selected ?>><?php echo $d ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<?php } ?>

								<?php if ( $terms_lesson_format ) { ?>
								<div class="select-wrap event-status single-select">
									<label>Lesson Format</label>
									<div class="customselectdiv">
										<select name="lesson" id="lesson" class="js-select" style="width:100%"> 
											<option></option>
											<?php foreach ($terms_lesson_format as $less) { 
												$less_slug = $less->slug;
												$ls_selected = ($sel_lesson && $less_slug==$sel_lesson) ? ' selected':''; ?>
												<option value="<?php echo $less_slug ?>"<?php echo $ls_selected ?>><?php echo $less->name ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<?php } ?>

								<?php if ($terms_experience_level) { ?>
								<div class="select-wrap event-status single-select">
									<label>Experience Level</label>
									<div class="customselectdiv">
										<select name="experience" id="experience" class="js-select" style="width:100%">
											<option></option>
											<?php foreach ($terms_experience_level as $ex) {
												$exp_slug = $ex->slug;
												$ex_selected = ($sel_experience && $exp_slug==$sel_experience) ? ' selected':''; ?>
												<option value="<?php echo $exp_slug ?>"<?php echo $ex_selected ?>><?php echo $ex->name ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<?php } ?>

								<?php if ($terms_duration) { ?>
								<div class="select-wrap event-status single-select">
									<label>Duration</label>
									<div class="customselectdiv">
										<select name="duration" id="duration" class="js-select" style="width:100%">
											<option></option>
											<?php foreach ($terms_duration as $dur) {
												$dur_slug = $dur->slug;
												$dur_selected = ($sel_duration && $dur_slug==$sel_duration) ? ' selected':''; ?>
												<option value="<?php echo $dur_slug ?>"<?php echo $dur_selected ?>><?php echo $dur->name ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<?php } ?>
							
						</div>
						<input type="submit" value="Filter" id="filterBtn" style="display:none;">
						<input type="hidden" id="baseURL" value="<?php echo $currentPageLink ?>">
						<div class="resetdiv<?php echo ($has_filter) ? ' ':' hide' ?>"><a href="<?php echo get_permalink(); ?>" class="resetLink">Reset</a></div>
					</form>
					
				</div>
			</div>
		</div>

		<?php /* RESULT */ ?>
		<?php if ($records) { ?>
		<section class="section-content entries-with-filter" style="padding-top:0;">
			<div class="post-type-entries boxes-element threecols <?php echo $postype ?>">
				<div id="data-container">
					<div class="posts-inner result">
						<div id="resultContainer" class="flex-inner<?php echo $flexClass ?>">
							<?php $ctr=1; foreach ($records as $row) {
								$pid = $row->ID; 
								$title = $row->post_title;
								$pagelink = get_permalink($pid);
								$short_description = get_field("short_description",$pid);
								$thumbImage = get_field("thumbnail_image",$pid);
								$price = get_field("price",$pid);
								$ages = get_field("ages",$pid);
								$duration = get_field("duration",$pid);
								//$schedules = get_field("schedule_items");
								$schedules = get_field("schedules_alt",$pid);
								$options1 = array($price,$ages,$duration);
								$options2 = array("ages"=>$ages,"duration"=>$duration,"price"=>$price);
								?>
								<div class="postbox animated fadeIn <?php echo ($thumbImage) ? 'has-image':'no-image';?>">
									<div class="inside">
										<div class="photo">
											<a href="<?php echo $pagelink ?>" class="link">
											<?php if ($thumbImage) { ?>
												<span class="imagediv" style="background-image:url('<?php echo $thumbImage['sizes']['medium_large'] ?>')"></span>
												<img src="<?php echo $thumbImage['url']; ?>" alt="<?php echo $thumbImage['title'] ?>" class="feat-img" style="display:none;">
												<img src="<?php echo $blank_image ?>" alt="" class="feat-img placeholder">
											<?php } else { ?>
												<span class="imagediv"></span>
												<img src="<?php echo $blank_image ?>" alt="" class="feat-img placeholder">
											<?php } ?>
											</a>
										</div>
										<div class="details">
											<div class="info">
												<h3 class="event-name"><?php echo $title ?></h3>
												
												<?php if ( $options1 && array_filter($options1) ) { ?>
												<div class="pricewrap">
													<div class="price-info">
														<?php foreach ($options2 as $k=>$v) { ?>
															<?php if ($v) { ?>
															<span class="<?php echo $k?>">
																<?php if ($k=='ages') { echo 'Age '; } ?><?php echo $v?>		
															</span>
															<?php } ?>	
														<?php } ?>
													</div>
												</div>
												<?php } ?>

												<?php if ($schedules) { ?>
												<div class="dates compact">
													<?php echo $schedules ?>
												</div>
												<?php } ?>

												<?php if ($short_description) { ?>
												<div class="short-description">
													<?php echo $short_description ?>
												</div>
												<?php } ?>
											</div>
										</div>
									</div>
									<div class="button">
										<a href="<?php echo $pagelink ?>" class="btn-sm"><span>See Details</span></a>
									</div>
								</div>
							<?php $ctr++; } ?>
						</div>
					</div>
				</div>
			</div>
		</section>

		<?php 
		$total_pages = ceil($total / $perpage);
		if ($total > $perpage) { ?> 
			<div class="loadmorediv text-center">
				<div class="wrapper"><a href="#" id="nextPageBtn" data-current="1" data-count="<?php echo $total?>" data-total-pages="<?php echo $total_pages?>" data-baseurl="<?php echo $currentPageLink; ?>" class="btn-sm wide loadMoreEntriesBtn"><span>Load More</span></a></div>
			</div>

			<div id="pagination" class="pagination-wrapper" style="display:none">
		    <?php
		    $pagination = array(
					'base' => @add_query_arg('pg','%#%'),
					'format' => '?pg=%#%',
					'mid-size' => 1,
					'current' => $paged,
					'total' => $total_pages,
					'prev_next' => True,
					'prev_text' => __( '<span class="fa fa-arrow-left"></span>' ),
					'next_text' => __( '<span class="fa fa-arrow-right"></span>' )
		    );
		    echo paginate_links($pagination); ?>
			</div>

		<?php } ?>

		<?php } else { ?>
			<div class="wrapper">
				<h3 class="norecord">Nothing found.</h3>
			</div>
		<?php } ?>

	</div>
</div>

