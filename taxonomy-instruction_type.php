<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package bellaworks
 */

get_header(); 
//$parent_page_id = ( isset($_GET['pp']) && $_GET['pp'] ) ? $_GET['pp'] : '';


$obj = get_queried_object();
$current_term_id = $obj->term_id;
$current_term_name = $obj->name;
$taxonomy = $obj->taxonomy;
// Tweak #1 to get term order. See below for tweak #2
// $child_terms = get_term_children($current_term_id,$taxonomy); 
$child_terms = get_terms( array(
	'child_of' => $current_term_id, 
	'orderby' => 'term_order',
    'order' => 'ASC',
    'taxonomy' => $taxonomy
));
$blank_image = THEMEURI . "images/rectangle-narrow.png";

// echo '<pre>';
// print_r($child_terms);
// echo '</pre>';

$category_image = get_field("category_image",$taxonomy.'_'.$current_term_id);
if($category_image) { ?>
<div id="banner" class="taxonomy-banner">
	<div class="slides-wrapper static-banner" style="background-image:url('<?php echo $category_image['url'] ?>')">
		<img src="<?php echo $category_image['url'] ?>" alt="<?php echo $category_image['title'] ?>" class="actual-image">
		<img src="<?php echo $blank_image ?>" alt="" aria-hidden="true" class="helper">
	</div>
</div>
<?php	} ?>

<div id="primary" data-term-id="" class="content-area-full boxedImagesPage instruction-taxonomy-page">
	<div class="intro-text-wrap">
		<div class="wrapper">
			<h1 class="page-title" style="margin-bottom:0;"><span><?php echo $current_term_name; ?></span></h1>
		</div>
	</div>

	<?php /* If has children terms */ ?>
	<?php 
	$has_items = array();
	if($child_terms) {
		// foreach($child_terms as $c_term_id) {
		// 	$args = array(
		// 		'post_type' => 'instructions',
		// 		'posts_per_page' =>  -1,
		// 		'post_status'    => 'publish',
		// 		'tax_query' => array(
		// 		    array(
		// 		    'taxonomy' => 'recipe_tx',
		// 		    'field' => 'term_id',
		// 		    'terms' => $c_term_id
		// 		     )
		// 		  )
		// 	);
		// 	$posts = get_posts($args);
		// 	if($posts) {
		// 		$has_items[] = $posts;
		// 	}
		// }		

		foreach ( $child_terms as $child ) {
			$termID = $child->term_id;
			// Tweak #2 to get term order
	    	// $term = get_term_by( 'id', $child, $taxonomy ); . 
			$term = get_term_by( 'id', $termID, $taxonomy );
	    if($term->count > 0){
	       $has_items[] = $term;
	    }
		}

	}
	if(!$has_items) {
		$child_terms = false;
	}

	if ($child_terms) { 
		include( locate_template('instructions/instruction-child-terms.php') );
	} else {  
		include( locate_template('instructions/instruction-posts.php') );
	} 
	?>
</div><!-- #primary -->
<?php
get_footer();
