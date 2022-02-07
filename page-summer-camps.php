<?php
/**
 * Template Name: Summer Camp
 */

get_header(); 
$blank_image = THEMEURI . "images/rectangle.png";
$square = THEMEURI . "images/square.png";
$canceledImage = THEMEURI . "images/canceled.svg";
$currentPageLink = get_permalink();
$ages = ( isset($_GET['age']) && $_GET['age'] ) ? explode(",",$_GET['age']) : '';
$hideReset = ($ages) ? '':' hide';
$postype = 'camp';
$perpage = 16;
?>

<div id="primary" data-post="<?php echo get_the_ID()?>" class="content-area-full summer-camp-page">
	<div id="pageContent">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php if( get_the_content() ) { ?>
					<div class="intro-text-wrap">
						<div class="wrapper">
							<h1 class="page-title"><span><?php the_title(); ?></span></h1>
							<div class="intro-text"><?php the_content(); ?></div>
						</div>
					</div>
				<?php } ?>
			<?php endwhile;  ?>

			<div id="filter" class="filter-wrapper non-facetwp">
				<div class="wrapper">
					<div class="filter-inner">
						<div class="flexwrap">
								<div class="select-wrap align-middle event-status">
									<label>Age</label>
									<div class="customselectdiv">
										<select name="age" id="agelist" class="js-select2" multiple="multiple">
										<?php 
										$min=8; $max=18;
										for($i=$min; $i<=$max; $i++) { 
												$selected = '';
												if($ages && in_array($i,$ages)) {
													$selected = ' selected';
												}
											?>
											<option value="<?php echo $i?>" data-badge=""<?php echo $selected ?>><?php echo $i?></option>
										<?php } ?>
										</select>
									</div>
									<a href="<?php echo get_permalink(); ?>" class="resetBtn summer-camps<?php echo $hideReset?>"><span>Reset</span></a>
								</div>
						</div>
					</div>
				</div>
			</div>

			<?php 
			if($ages) {
				include( locate_template('parts/filter-summer-camps.php') );
			} else {
				include( locate_template('parts/summer-camps-list.php') );
			}
			?>
	</div>
</div><!-- #primary -->

<div class="next-posts" style="display:none;"></div>

<script type="text/javascript">
jQuery(document).ready(function($){

	$(document).on("change","select#agelist",function(){
		var opt = $(this).val();
		var newURL = '<?php echo $currentPageLink?>' + '?age=' + opt.join("%2C");
		$("#loaderDiv").show();
		$("#primary").load(newURL+" #pageContent",function(){

			setTimeout(function(){
				$("#loaderDiv").hide();
			},500);

			$(".js-select2").select2({
				closeOnSelect : false,
				placeholder : "Select...",
				allowHtml: true,
				allowClear: true,
				tags: true 
			});

			history.pushState("",document.title,newURL);
			if( $('.resetBtn').length>0 ) {
				$('.resetBtn').removeClass('hide');
			}

		});

		$(".loadmorediv").load(newURL+" .wrapper",function(){
			
		});

		

	});

	$(document).on("click","#loadMoreEntries2",function(e){
		e.preventDefault();
		get_next_items();
	});

	function get_next_items() {
		var loadMoreBtn = $('.loadMoreEntriesBtn');
		var current = loadMoreBtn.attr('data-current');
		var next = parseInt(current) + 1;
		var totalPages = loadMoreBtn.attr('data-total-pages');
		loadMoreBtn.attr('data-current',next);

		var opts = $('select#agelist').val();

		if( opts ) {
			opts = opts.join("%2C");
			var newURL = currentURL + '?age=' + opts + '&pg=' + next;
		} else {
			var newURL = currentURL + '?pg=' + next;
		}
		history.replaceState("",document.title,newURL);

		$("#loaderDiv").show();
		$(".next-posts").load(newURL+" .result",function(){
			var content = $(".next-posts").html();
			$('.next-posts .postbox').addClass("animated fadeIn").appendTo("#data-container .flex-inner");
			setTimeout(function(){
				$("#loaderDiv").hide();
			},500);
		});

		if(next==totalPages) {
			$(".loadmorediv").hide();
		}
	}

	$(document).on("click",".resetBtn",function(e){
		e.preventDefault();
		var link = $(this).attr("href");
		$("#primary").load(link+" #pageContent",function(){
			$(".js-select2").select2({
				closeOnSelect : false,
				placeholder : "Select...",
				allowHtml: true,
				allowClear: true,
				tags: true 
			});
			history.replaceState('',document.title,link);
		});
	});
});
</script>
<?php
get_footer();
