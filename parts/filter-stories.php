<form action="" id="filter-form" method="GET">
		<input type="hidden" id="baseurl_input" value="<?php echo $pageLink ?>">
		<div class="filterbytxt">Filter By:</div>
		<div class="flexwrap">
			<?php if ($terms) { ?>
			<div class="select-wrap">
				<label for="category">Category</label>
				<div class="selectdiv">
					<select name="category" id="category" class="select-single select-filter">
						<option value="all">All</option>
						<?php foreach ($terms as $term) { 
							$is_cat_selected = ( isset($_GET['category']) && ($_GET['category']==$term->term_id) ) ? ' selected':'';
						?>
						<option value="<?php echo $term->term_id ?>"<?php echo $is_cat_selected ?>><?php echo $term->name ?></option>	
						<?php } ?>
					</select>
				</div>
			</div>
			<?php } ?>

			<?php if ($types) { ?>
			<div class="select-wrap">
				<label for="activity_type">Type</label>
				<div class="selectdiv">
					<select name="activity_type" id="activity_type" class="select-single select-filter">
						<option value="all">All</option>
						<?php foreach ($types as $type) { 
							$is_type_selected = ( isset($_GET['activity_type']) && ($_GET['activity_type']==$type->term_id) ) ? ' selected':'';
						?>
						<option value="<?php echo $type->term_id ?>"<?php echo $is_type_selected ?>><?php echo $type->name ?></option>	
						<?php } ?>
					</select>
				</div>
			</div>
			<?php } ?>
		</div>
		<input type="submit" id="filterBtn" value="Filter" style="display:none;">
</form>