<?php 
$page_title = get_the_title();
while ( have_posts() ) : the_post(); ?>
	
	<section class="main-description">
    <div class="wrapper text-center">
      <h1 class="pagetitle"><span><?php echo get_the_title(); ?></span></h1>
      <?php if ( $short_description = get_field("short_description") ) { ?>
        <div class="main-text"><?php echo $short_description; ?></div>
      <?php } ?>
    </div>
  </section>
	

	<div id="pageTabs"></div>

	<?php 
	// Check value exists.
	if( have_rows('route') ):

	    // Loop through rows.
	    while ( have_rows('route') ) : the_row();

	        /* 

	        	Case: Gallery layout section.

	        	########################################

	        */
	        if( get_row_layout() == 'gallery' ):
	            $imgs = get_sub_field('gallery');
	            foreach( $imgs as $img ) {
	            	echo '<img src="'.$img['url'].'" />';
	            }

	        /* 

	        	Case: Details with icons

	        	########################################

	        */
	        elseif( get_row_layout() == 'detail' ): 
	            $detail = get_sub_field('detail');
	            if( have_rows('detail') ): while( have_rows('detail') ): the_row();
		            	$icon = get_sub_field('icon');
		            	$dTitle = get_sub_field('detail_title');
		            	$dDesc  = get_sub_field('detail');
		            	echo '<img src="'.$icon['url'].'"/>';
		            	echo $dTitle;
		            	echo $dDesc;
	            	endwhile;
	            endif;

            /* 

	        	Case: Display Map.

	        	########################################

	        */
	        elseif( get_row_layout() == 'map' ): 
	            $map = get_sub_field('map_shortcode');
	            echo do_shortcode( $map );

	        /* 

	        	Case: Long Form Stroy.

	        	########################################

	        */
	        elseif( get_row_layout() == 'long_form_story' ): 
	            $story = get_sub_field('story');
	            echo $story;

	        /* 

	        	Case: Download layout.

	        	########################################

	        */
	        elseif( get_row_layout() == 'information' ): 
	            $info = get_sub_field('information');
	            if( have_rows('information') ): while( have_rows('information') ): the_row();
		            	$tabTitle = get_sub_field('tab_title');
		            	$panel = get_sub_field('tab_info');
		            	echo '<h3>'.$tabTitle.'</h3>';
		            	echo '<div class="panel">'.$panel.'</div>';
	            	endwhile;
	            endif;

	        endif;

	    // End loop.
	    endwhile;

	// No value.
	else :
	    // Do something...
	endif;
	 ?>

<?php endwhile; ?>

<?php  
/* Similar Events */ 
get_template_part("parts/similar-posts"); 
?>






<script>
jQuery(document).ready(function($){


	/* page anchors */
	if( $('[data-section]').length > 0 ) {
		var tabs = '';
		$('[data-section]').each(function(){
			var name = $(this).attr('data-section');
			var id = $(this).attr("id");
			tabs += '<span class="mini-nav"><a href="#'+id+'">'+name+'</a></span>';
		});
		$("#pageTabs").html('<div class="wrapper"><div id="tabcontent">'+tabs+'</div></div>');
	}

});	
</script>