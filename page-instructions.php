<?php
/**
 * Template Name: Instruction Version 1
 */

get_header(); 
$currentPageLink = get_permalink();
?>

<div id="primary" data-post="<?php echo get_the_ID()?>" class="content-area-full boxedImagesPage instruction-page">
	<?php while ( have_posts() ) : the_post(); ?>
		<div class="intro-text-wrap">
			<div class="wrapper">
				<h1 class="page-title"><span><?php the_title(); ?></span></h1>
				<?php if ( get_the_content() ) { ?>
				<div class="intro-text"><?php the_content(); ?></div>
				<?php } ?>
			</div>
		</div>
	<?php endwhile; ?>

	<?php 
	include( locate_template('parts/filter-instructions.php') );
	?>

	<div class="next-posts" style="display:none;"></div>
</div><!-- #primary -->

<script type="text/javascript">
jQuery(document).ready(function($){

	var maxColumns = 3;

	$("#resultContainer .postbox").each(function(k){
		var n = k+1;
		$(this).attr("id","postnum"+n);
	});

	/* Reset Button */
	$(document).on("click",".resetLink",function(e){
		e.preventDefault();
		var link = $(this).attr("href");
		history.pushState("",document.title,link);
		$("#loaderDiv").show();
		$("#filter-data-container").load(link + " .inner-data-content",function(){

			setTimeout(function(){
				$("#loaderDiv").hide();
			},500);

			activate_js_select();

		});
		
	});
	
	$(document).on("change","select.js-select",function(){
		var fieldValues = $("#instruction-filter").serialize();
		var newURL = currentURL;
		if( $(this).val() ) {
			newURL = currentURL + '?' + fieldValues;
		} 
		$("input#baseURL").val(newURL);
		history.pushState("",document.title,newURL);

		$("#loaderDiv").show();

		// $("#data-container").load(newURL + " .result",function(){
		// 	$(".resetdiv").removeClass('hide');

		// 	setTimeout(function(){
		// 		$("#loaderDiv").hide();
		// 	},500);

		// 	activate_js_select();
		// });


		$("#filter-data-container").load(newURL + " .inner-data-content",function(){
			
			$(".resetdiv").removeClass('hide');

			setTimeout(function(){
				$("#loaderDiv").hide();
			},500);

			activate_js_select();

			if( $("#data-container").length>0 ) {
				var count = $("#resultContainer .postbox").length;
				if( count<maxColumns ) {
					$("#resultContainer").addClass("align-middle");
				}
			} 
		});


	});

	$(document).on("click","#nextPageBtn",function(e){
		e.preventDefault();
		//get_next_items();
		var current = $(this).attr('data-current');
		var next = parseInt(current) + 1;
		var totalPages = $(this).attr('data-total-pages');
		$(this).attr('data-current',next);

		if( $("#pagination a.page-numbers").length>0 ) {
			var baseURL = $("#pagination a.page-numbers").eq(0).attr("href");
			var parts = baseURL.split("pg=");
			var newURL = parts[0] + 'pg=' + next;
			var nxt = next+1;
			var newURL = '<?php echo get_site_url() ?>' + newURL;
			$("#loaderDiv").show();
			$(".next-posts").load(newURL+" .result",function(){
				var content = $(".next-posts .result").html();
				$('.next-posts .postbox').addClass("animated fadeIn").appendTo("#data-container #resultContainer");
				setTimeout(function(){
					$("#loaderDiv").hide();
				},500);
				var n=1;

				$("#resultContainer .postbox").each(function(){
					$(this).attr("id","postnum"+n);
					n++;
				});
			});

			var last = next + 1;
			if(next==totalPages) {
				$(".loadmorediv").hide();
			}
		}
		
	});

	function get_next_items() {
		var loadMoreBtn = $('#nextPageBtn');
		var current = loadMoreBtn.attr('data-current');
		var next = parseInt(current) + 1;
		var totalPages = loadMoreBtn.attr('data-total-pages');
		var baseURL = $("input#baseURL").val();
		loadMoreBtn.attr('data-current',next);

		var hasFilter = [];
		$(".js-select").each(function(){
			if( $(this).val() ) {
				hasFilter.push( $(this).val() );
			}
		});

		$("#loaderDiv").show();
		
		if( baseURL.indexOf('?') !== -1 ) {
			baseURL += '&pg=' + next;
		} else {
			baseURL = currentURL + '?pg=' + next;
		}

		history.pushState("",document.title,baseURL);

		$(".next-posts").load(baseURL+" #resultContainer",function(){

			if( $("#data-container").length>0 ) {
				var content = $(".next-posts #resultContainer").html();
				$(content).appendTo("#data-container .flex-inner");
			} 

			//$(".loadmorediv").hide();

			setTimeout(function(){
				$("#loaderDiv").hide();
			},500);

			activate_js_select();
		});

		$(".loadmorediv .wrapper").load(baseURL + " #nextPageBtn",function(){

		});


	}

	$(document).on("click",".select2",function (e) { 
		var selectdiv = $(".customselectdiv").outerWidth();
		$(".select2-container--default").css("width",selectdiv+"px");
	});

	activate_js_select();
	function activate_js_select() {
		if( $("select.js-select").length>0 ) {
			$("select.js-select").each(function(){
				var selectID = $(this).attr("id");
				$("select#"+selectID).select2({
					closeOnSelect : false,
					placeholder : "Select...",
					allowHtml: true,
					allowClear: true,
					tags: true
				});
			});
		}
	}
});
</script>

<?php
get_footer();
