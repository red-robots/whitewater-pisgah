<?php
$placeholder = THEMEURI . 'images/rectangle.png';
$imageHelper = THEMEURI . 'images/rectangle-narrow.png';
$pageLink = get_permalink();
$baseURL = $pageLink;
$post_type = 'post';
$taxonomy = 'category'; 
$perPage = 6;
$paged = ( get_query_var( 'pg' ) ) ? absint( get_query_var( 'pg' ) ) : 1;
// $args = array(
// 	'posts_per_page'   => $perPage,
// 	'post_type'        => 'post',
// 	'post_status'      => 'publish',
// 	'facetwp' 				 => true,
// 	'paged'			   		 => $paged
// );

// $get_is_all = array();
// $count_get = 0;
// if( isset($_GET) ) {
// 	$n=1; foreach($_GET as $k=>$v) {
// 		$delimited = ($n==1) ? '?':'&';
// 		$baseURL .= $delimited . $k."=".$v;

// 		if($v=='all') {
// 			$get_is_all[$k] = $v;
// 		}
// 		$n++;
// 	}
// 	$count_get = count($_GET);
// }

// if($get_is_all && ($count_get!=count($get_is_all)) ) {

	

// 	if( isset($_GET['_categories']) || $_GET['_activity_types'] ) {
// 		$cat_id = ($_GET['_categories'] && $_GET['_categories']!='all') ? $_GET['_categories'] : 0;
// 		$activity_type_id = ($_GET['_activity_types'] && $_GET['_activity_types']!='all') ? $_GET['_activity_types'] : 0;


// 		$tax_query[] = array(
// 			'taxonomy' => 'category',
// 			'field' => 'term_id',
// 			'terms' => $cat_id,
// 			'operator' => 'IN'
//     );

//     $tax_query[] = array(
// 			'taxonomy' => 'activity_type',
// 			'field' => 'term_id',
// 			'terms' => $activity_type_id,
// 			'operator' => 'IN'
//     );

//     $count_query = ($tax_query) ? count($tax_query):0;
// 		if($count_query>1) {
// 			$tax_query['relation'] = 'OR';
// 		}

// 		$args['tax_query'] = $tax_query;
// 	}

// }


// $blogs = new WP_Query($args);
// $terms = get_terms( array(
// 	    'taxonomy' => $taxonomy,
// 	    'post_types'=> array($post_type),
// 	    'hide_empty' => true,
// 	) );

// $types = get_terms( array(
// 	    'taxonomy' => 'activity_type',
// 	    'post_types'=> array($post_type),
// 	    'hide_empty' => true,
// 	) );

// if ( $blogs->have_posts() ) {  $totalFound = $blogs->found_posts; 
$response = wp_remote_get( 'https://whitewater.org/wp-json/wp/v2/posts?per_page=9' );
// $response = wp_remote_get( 'https://whitewater.org/wp-json/wp/v2/posts?per_page=9&page=2' );
// echo '<pre style="background-color: #fff;">';
// print_r($response);
// echo '<?pre>';
        if( is_array($response) ) :
            $code = wp_remote_retrieve_response_code( $response );
            if(!empty($code) && intval(substr($code,0,1))===2): 
                $body = json_decode(wp_remote_retrieve_body( $response),true);

                ?>

<div id="load-post-div">
	<div id="load-data-div">
		<div class="filter-wrapper">
			<div class="wrapper">
				
				<div class="filter-inner">
					<!-- <div class="filterbytxt" align="center">Filter By:</div> -->
					<div class="flexwrap">

						<?php if ( do_shortcode('[facetwp facet="activity_types"]') ) { ?>
						<!-- <div class="select-wrap align-middle"> -->
						<div class="select-wrap">
							<label for="activity_type">Activity</label>
							<?php echo do_shortcode('[facetwp facet="activity_types" pager="true"]'); ?>
						</div>
						<?php } ?>

						<?php if ( do_shortcode('[facetwp facet="film_write_up"]') ) { ?>
						<div class="select-wrap">
							<label for="film_write_up">Format</label>
							<?php echo do_shortcode('[facetwp facet="film_write_up" pager="true"]'); ?>
						</div>
						<?php } ?>

						<button onclick="FWP.reset()" class="resetBtn jobs"><span>Reset</span></button>

					</div>
				</div>
				

				<?php
					/* Custom Filtering by Lisa */ 
					//include( get_stylesheet_directory() . '/parts/filter-stories.php' ); ?>
			</div>
		</div>

		<div class="archive-posts-wrap">
			<div id="postLists" class="posts-inner countItems<?php echo $totalFound?>">

				<?php 
					$sec=.1; $i=1; 

					// while ( $blogs->have_posts() ) : $blogs->the_post();
					foreach ($body as $post) :
					// $thumbId = get_post_thumbnail_id(); 
					// $featImg = wp_get_attachment_image_src($thumbId,'large');
					$featImg = $post['fimg_url'];
					// $featThumb = wp_get_attachment_image_src($thumbId,'thumbnail');
					$featThumb = $post['acf']['image']['url'];

					$content = $post['content'];
					$title = $post['title']['rendered'];
					$divclass = (($content || $title) && $featImg) ? 'half':'full';
					$pagelink = $post['link'];
					$divclass .= ($i % 2) ? ' odd':' even';
					$divclass .= ($i==1) ? ' first':'';
					$catId = $post['category']['0'];
					echo '<pre style="background-color: #fff;">';
					print_r($post);
					echo '<?pre>';
					include( get_stylesheet_directory() . '/parts/content-post-rest.php' );
					?>
				<?php
				$sec =  $sec + .1;
				$i++; endforeach; //wp_reset_postdata(); ?>

			</div>
		</div>

		<div id="tempContainer" style="display:none;"></div>
		<div id="tempNext" style="display:none;"></div>

		<?php
      $total_pages = $blogs->max_num_pages;
      if ($total_pages > 1){ ?>
          <div id="pagination" style="width:100%;float:left;display:none">
            <?php
            $pagination = array(
                'base' => @add_query_arg('pg','%#%'),
                'format' => '?paged=%#%',
                'current' => $paged,
                'total' => $total_pages,
                'prev_text' => __( '&laquo;', 'usnwc' ),
                'next_text' => __( '&raquo;', 'usnwc' ),
                'type' => 'plain'
            );
            echo paginate_links($pagination); ?>
          </div>

						<div class="morebuttondiv">
							<span class="moreBtnSpan"> <?php /* id="loadMoreBtn2" */ ?>
								<a class="moreBtn" id="loadMoreBtn3" data-totalpages="<?php echo $total_pages?>" data-perpage="<?php echo $perPage?>" data-posttype="<?php echo $post_type?>" data-page="2" data-baseurl="<?php echo $pageLink?>" data-filterby=""><span class="loadtxt">Load More</span></a>
								<div class="wait"><span class="fas fa-sync-alt rotate"></span></div>
							</span>
						</div>
      <?php } ?>


	</div>
</div>

<?php 
 
endif; 
endif; 
?>