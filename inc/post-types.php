<?php 
/*
 * Custom Post Types 
 * DASH ICONS = https://developer.wordpress.org/resource/dashicons/
 * Example: 'menu_icon' => 'dashicons-admin-users'
*/

add_action('init', 'js_custom_init', 1);
function js_custom_init() {
    $post_types = array(
        array(
            'post_type' => 'activity',
            'menu_name' => 'Activities',
            'plural'    => 'Activities',
            'single'    => 'Activity',
            'menu_icon' => 'dashicons-sos',
            'supports'  => array('title','editor')
        ),
        array(
            'post_type' => 'accommodation',
            'menu_name' => 'Accommodations',
            'plural'    => 'Accommodations',
            'single'    => 'Accommodation',
            'menu_icon' => 'dashicons-admin-home',
            'supports'  => array('title','editor')
        ),
        array(
            'post_type' => 'public_assets',
            'menu_name' => 'Public Assets',
            'plural'    => 'Public Assets',
            'single'    => 'Public Asset',
            'menu_icon' => 'dashicons-admin-site',
            'supports'  => array('title','editor', 'excerpt')
        ),
        // array(
        //     'post_type' => 'public_activity',
        //     'menu_name' => 'Public Activities',
        //     'plural'    => 'Public Activities',
        //     'single'    => 'Public Activity',
        //     'menu_icon' => 'dashicons-admin-site',
        //     'supports'  => array('title','editor')
        // ),
        // array(
        //     'post_type' => 'activity_schedule',
        //     'menu_name' => 'Activity Schedule',
        //     'plural'    => 'Activity Schedules',
        //     'single'    => 'Activity Schedule',
        //     'menu_icon' => 'dashicons-calendar-alt',
        //     'supports'  => array('title')
        // ),
        // array(
        //     'post_type' => 'pass',
        //     'menu_name' => 'Passes',
        //     'plural'    => 'Passes',
        //     'single'    => 'Pass',
        //     'menu_icon' => 'dashicons-tickets-alt',
        //     'supports'  => array('title','editor')
        // ),
        // array(
        //     'post_type' => 'race',
        //     'menu_name' => 'Race Series',
        //     'plural'    => 'Races',
        //     'single'    => 'Race',
        //     'menu_icon' => 'dashicons-location-alt',
        //     'supports'  => array('title','editor')
        // ),
        // array(
        //     'post_type' => 'film-series',
        //     'menu_name' => 'Film Series',
        //     'plural'    => 'Film Series',
        //     'single'    => 'Film Series ',
        //     'menu_icon' => 'dashicons-video-alt2',
        //     'supports'  => array('title','editor')
        // ),
        // array(
        //     'post_type' => 'music',
        //     'menu_name' => 'River Jam Bands',
        //     'plural'    => 'River Jam Bands',
        //     'single'    => 'River Jam Band ',
        //     'menu_icon' => 'dashicons-format-audio',
        //     'supports'  => array('title','editor')
        // ),
        // array(
        //   'post_type' => 'jam-programs',
        //   'menu_name' => 'River Jam Programs',
        //   'plural'    => 'River Jam Programs',
        //   'single'    => 'River Jam Program',
        //   'menu_icon' => 'dashicons-format-audio',
        //   'supports'  => array('title','editor')
        // ),
        // array(
        //     'post_type' => 'festival',
        //     'menu_name' => 'Festival',
        //     'plural'    => 'Festival',
        //     'single'    => 'Festival ',
        //     'menu_icon' => 'dashicons-megaphone',
        //     'supports'  => array('title','editor')
        // ),
        // array(
        //     'post_type' => 'festival_activity',
        //     'menu_name' => 'Festival Activities',
        //     'plural'    => 'Festival Activities',
        //     'single'    => 'Festival Activity',
        //     'menu_icon' => 'dashicons-megaphone',
        //     'supports'  => array('title','editor','excerpt')
        // ),
        // array(
        //     'post_type' => 'camp',
        //     'menu_name' => 'Camps',
        //     'plural'    => 'Camps',
        //     'single'    => 'Camp',
        //     'menu_icon' => 'dashicons-location',
        //     'supports'  => array('title','editor')
        // ),
        // array(
        //     'post_type' => 'fieldtrips',
        //     'menu_name' => 'Field Trips',
        //     'plural'    => 'Field Trips',
        //     'single'    => 'Field Trip',
        //     'menu_icon' => 'dashicons-car',
        //     'supports'  => array('title','editor')
        // ),
        array(
            'post_type' => 'brewery',
            'menu_name' => 'Breweries',
            'plural'    => 'Breweries',
            'single'    => 'Brewery',
            'menu_icon' => 'dashicons-beer',
            'supports'  => array('title','editor')
        ),
        // array(
        //     'post_type' => 'dining',
        //     'menu_name' => 'Adventure Dining',
        //     'plural'    => 'Adventure Dining',
        //     'single'    => 'Adventure Dining',
        //     'menu_icon' => 'dashicons-coffee',
        //     'supports'  => array('title','editor')
        // ),
        array(
            'post_type' => 'event-space',
            'menu_name' => 'Event Spaces',
            'plural'    => 'Event Spaces',
            'single'    => 'Event Space',
            'menu_icon' => 'dashicons-buddicons-community',
            'supports'  => array('title','editor')
        ),
        // array(
        //     'post_type' => 'stores',
        //     'menu_name' => 'Outfitters',
        //     'plural'    => 'Outfitters',
        //     'single'    => 'Outfitter',
        //     'menu_icon' => 'dashicons-store',
        //     'supports'  => array('title','editor')
        // ),
        array(
            'post_type' => 'instructions',
            'menu_name' => 'Instructions',
            'plural'    => 'Instructions',
            'single'    => 'Instruction',
            'menu_icon' => 'dashicons-book-alt',
            'supports'  => array('title','editor')
        ),
        // array(
        //     'post_type' => 'job',
        //     'menu_name' => 'Jobs',
        //     'plural'    => 'Jobs',
        //     'single'    => 'Job',
        //     'menu_icon' => 'dashicons-index-card',
        //     'supports'  => array('title','editor')
        // ),
        array(
            'post_type' => 'faqs',
            'menu_name' => 'FAQs',
            'plural'    => 'FAQs',
            'single'    => 'FAQ',
            'menu_icon' => 'dashicons-info',
            'supports'  => array('title','editor')
        ),
        array(
            'post_type' => 'teamdev',
            'menu_name' => 'Team Developement',
            'plural'    => 'Team Developement',
            'single'    => 'Team Developement',
            'menu_icon' => 'dashicons-groups',
            'supports'  => array('title','editor')
        ),
        // array(
        //     'post_type' => 'employeestories',
        //     'menu_name' => 'Employee Stories',
        //     'plural'    => 'Employee Stories',
        //     'single'    => 'Employee Story',
        //     'menu_icon' => 'dashicons-format-status',
        //     'supports'  => array('title','editor')
        // ),
        array(
            'post_type' => 'route',
            'menu_name' => 'Routes',
            'plural'    => 'Routes',
            'single'    => 'Route',
            'menu_icon' => 'dashicons-location-alt',
            'supports'  => array('title','editor')
        ),
    );
    
    if($post_types) {
        foreach ($post_types as $p) {
            $p_type = ( isset($p['post_type']) && $p['post_type'] ) ? $p['post_type'] : ""; 
            $single_name = ( isset($p['single']) && $p['single'] ) ? $p['single'] : "Custom Post"; 
            $plural_name = ( isset($p['plural']) && $p['plural'] ) ? $p['plural'] : "Custom Post"; 
            $menu_name = ( isset($p['menu_name']) && $p['menu_name'] ) ? $p['menu_name'] : $p['plural']; 
            $menu_icon = ( isset($p['menu_icon']) && $p['menu_icon'] ) ? $p['menu_icon'] : "dashicons-admin-post"; 
            $supports = ( isset($p['supports']) && $p['supports'] ) ? $p['supports'] : array('title','editor','custom-fields','thumbnail'); 
            $taxonomies = ( isset($p['taxonomies']) && $p['taxonomies'] ) ? $p['taxonomies'] : array(); 
            $parent_item_colon = ( isset($p['parent_item_colon']) && $p['parent_item_colon'] ) ? $p['parent_item_colon'] : ""; 
            $menu_position = ( isset($p['menu_position']) && $p['menu_position'] ) ? $p['menu_position'] : 20; 
            
            if($p_type) {
                
                $labels = array(
                    'name' => _x($plural_name, 'post type general name'),
                    'singular_name' => _x($single_name, 'post type singular name'),
                    'add_new' => _x('Add New', $single_name),
                    'add_new_item' => __('Add New ' . $single_name),
                    'edit_item' => __('Edit ' . $single_name),
                    'new_item' => __('New ' . $single_name),
                    'view_item' => __('View ' . $single_name),
                    'search_items' => __('Search ' . $plural_name),
                    'not_found' =>  __('No ' . $plural_name . ' found'),
                    'not_found_in_trash' => __('No ' . $plural_name . ' found in Trash'), 
                    'parent_item_colon' => $parent_item_colon,
                    'menu_name' => $menu_name
                );
            
            
                $args = array(
                    'labels' => $labels,
                    'public' => true,
                    'publicly_queryable' => true,
                    'show_ui' => true, 
                    'show_in_menu' => true, 
                    'show_in_rest' => true,
                    'query_var' => true,
                    'rewrite' => true,
                    'capability_type' => 'post',
                    'has_archive' => false, 
                    'hierarchical' => false, // 'false' acts like posts 'true' acts like pages
                    'menu_position' => $menu_position,
                    'menu_icon'=> $menu_icon,
                    'supports' => $supports
                ); 
                
                register_post_type($p_type,$args); // name used in query
                
            }
            
        }
    }
}



/* ##########################################################
 * Add new taxonomy, make it hierarchical (like categories)
 * Custom Taxonomies
*/
add_action( 'init', 'build_taxonomies', 0 ); 
function build_taxonomies() {

  $post_types = array(
    array(
      'post_type' => array('music'),
      'menu_name' => 'Location',
      'plural'    => 'Location',
      'single'    => 'Location',
      'taxonomy'  => 'event-location'
    ),
    array(
      'post_type' => array('activity', 'pass'),
      'menu_name' => 'Pass Type',
      'plural'    => 'Pass Types',
      'single'    => 'Pass Type',
      'taxonomy'  => 'pass_type',
      'rewrite'   => 'pass-type'
    ),
    array(
      'post_type' => array('film', 'activity','post'),
      'menu_name' => 'Activity',
      'plural'    => 'Activities',
      'single'    => 'Activity',
      'taxonomy'  => 'activity_type',
      'rewrite'   => 'activity-type'
    ),
    array(
      'post_type' => array('faqs'),
      'menu_name' => 'FAQ Type',
      'plural'    => 'FAQ Types',
      'single'    => 'FAQ Type',
      'taxonomy'  => 'faq_type',
      'rewrite'   => 'faq-type'
    ),
    array(
      'post_type' => array('festival_activity'),
      'menu_name' => 'Programming',
      'plural'    => 'Programming',
      'single'    => 'Programming',
      'taxonomy'  => 'festival_programming',
      'rewrite'   => 'festival-programming'
    ),
    array(
      'post_type' => array('festival_activity'),
      'menu_name' => 'Festival Name',
      'plural'    => 'Festival Names',
      'single'    => 'Festival Name',
      'taxonomy'  => 'festival'
    ),
    array(
      'post_type' => array('festival_activity'),
      'menu_name' => 'Festival Day',
      'plural'    => 'Festival Days',
      'single'    => 'Festival Day',
      'taxonomy'  => 'festival_day',
      'rewrite'   => 'festival-day'
    ),
    array(
      'post_type' => array('festival_activity'),
      'menu_name' => 'Difficulty',
      'plural'    => 'Difficulty',
      'single'    => 'Difficulty',
      'taxonomy'  => 'difficulty',
      'rewrite'   => 'difficulty'
    ),
    array(
      'post_type' => array('story'),
      'menu_name' => 'Editions',
      'plural'    => 'Editions',
      'single'    => 'Edition',
      'taxonomy'  => 'edition'
    ),
    array(
      'post_type' => array('job'),
      'menu_name' => 'Job Types',
      'plural'    => 'Job Types',
      'single'    => 'Job Type',
      'taxonomy'  => 'jobtype'
    ),
    array(
      'post_type' => array('job'),
      'menu_name' => 'Job Locations',
      'plural'    => 'Job Locations',
      'single'    => 'Job Location',
      'taxonomy'  => 'joblocation'
    ),
    array(
      'post_type' => array('job'),
      'menu_name' => 'Departments',
      'plural'    => 'Departments',
      'single'    => 'Department',
      'taxonomy'  => 'department'
    ),
    array(
      'post_type' => array('instructions'),
      'menu_name' => 'Instruction Types',
      'plural'    => 'Instruction Types',
      'single'    => 'Instruction Type',
      'taxonomy'  => 'instruction_type',
      'rewrite'   => 'instruction-type',
      'query_var' => true,
      'show_admin_column'=>true
    ),
    array(
      'post_type' => array('instructions'),
      'menu_name' => 'Lesson Format',
      'plural'    => 'Lesson Format',
      'single'    => 'Lesson Format',
      'taxonomy'  => 'instructions-lesson-format',
      'query_var' => false,
      'show_admin_column'=>false
    ),
    array(
      'post_type' => array('instructions'),
      'menu_name' => 'Experience Level',
      'plural'    => 'Experience Level',
      'single'    => 'Experience Level',
      'taxonomy'  => 'instructions-experience-level',
      'query_var' => false,
      'show_admin_column'=>false
    ),
    array(
      'post_type' => array('instructions'),
      'menu_name' => 'Duration',
      'plural'    => 'Duration',
      'single'    => 'Duration',
      'taxonomy'  => 'instructions-duration',
      'query_var' => false,
      'show_admin_column'=>false
    ),
    array(
      'post_type' => array('instructions'),
      'menu_name' => 'Instructions Template',
      'plural'    => 'Instructions Templates',
      'single'    => 'Instructions Template',
      'taxonomy'  => 'instructions-template',
      'query_var' => false,
      'show_admin_column'=>false
    ),
    array(
      'post_type' => array('event-space'),
      'menu_name' => 'Number of Guests',
      'plural'    => 'Number of Guest',
      'single'    => 'Number of Guest',
      'taxonomy'  => 'number-guest',
      'query_var' => false,
      'show_admin_column'=>1
    ),
    array(
      'post_type' => array('event-space'),
      'menu_name' => 'Venue Size',
      'plural'    => 'Venue Size',
      'single'    => 'Venue Size',
      'taxonomy'  => 'venue-size',
      'query_var' => false,
      'show_admin_column'=>1
    ),
    array(
      'post_type' => array('route'),
      'menu_name' => 'Route Type',
      'plural'    => 'Route Type',
      'single'    => 'Route Type',
      'taxonomy'  => 'route-type',
      'query_var' => false,
      'show_admin_column'=>1
    ),
    // array(
    //   'post_type' => array('jam-programs'),
    //   'menu_name' => 'Programming',
    //   'plural'    => 'Programming',
    //   'single'    => 'Programming',
    //   'taxonomy'  => 'riverjam-programming',
    //   'rewrite'   => 'riverjam-programming'
    // ),
  );

  if($post_types) {
    foreach($post_types as $p) {
      $p_type = ( isset($p['post_type']) && $p['post_type'] ) ? $p['post_type'] : ""; 
      $single_name = ( isset($p['single']) && $p['single'] ) ? $p['single'] : "Custom Post"; 
      $plural_name = ( isset($p['plural']) && $p['plural'] ) ? $p['plural'] : "Custom Post"; 
      $menu_name = ( isset($p['menu_name']) && $p['menu_name'] ) ? $p['menu_name'] : $p['plural'];
      $taxonomy = ( isset($p['taxonomy']) && $p['taxonomy'] ) ? $p['taxonomy'] : "";
      $rewrite = ( isset($p['rewrite']) && $p['rewrite'] ) ? $p['rewrite'] : $taxonomy;
      $query_var = ( isset($p['query_var']) && $p['query_var'] ) ? $p['query_var'] : true;
      $show_admin_column = ( isset($p['show_admin_column']) ) ? $p['show_admin_column'] : true;

      $labels = array(
        'name' => _x( $menu_name, 'taxonomy general name' ),
        'singular_name' => _x( $single_name, 'taxonomy singular name' ),
        'search_items' =>  __( 'Search ' . $plural_name ),
        'popular_items' => __( 'Popular ' . $plural_name ),
        'all_items' => __( 'All ' . $plural_name ),
        'parent_item' => __( 'Parent ' .  $single_name),
        'parent_item_colon' => __( 'Parent ' . $single_name . ':' ),
        'edit_item' => __( 'Edit ' . $single_name ),
        'update_item' => __( 'Update ' . $single_name ),
        'add_new_item' => __( 'Add New ' . $single_name ),
        'new_item_name' => __( 'New ' . $single_name ),
      );

      register_taxonomy($taxonomy, $p_type, array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_admin_column' => $show_admin_column,
        'query_var' => $query_var,
        'show_ui' => true,
        'show_in_rest' => true,
        'public' => true,
        '_builtin' => true,
        'rewrite' => array( 'slug' => $rewrite ),
      ));

    }
  }

}



// Add the custom columns to the position post type:
add_filter( 'manage_posts_columns', 'set_custom_cpt_columns' );
function set_custom_cpt_columns($columns) {
    global $wp_query;
    $query = isset($wp_query->query) ? $wp_query->query : '';
    $post_type = ( isset($query['post_type']) ) ? $query['post_type'] : '';
    
    if($post_type=='music') {
        unset($columns['taxonomy-event-location']);
        unset($columns['expirationdate']);
        unset($columns['date']);
        $columns['title'] = __( 'Name', 'bellaworks' );
        $columns['show_on_homepage'] = __( 'Show on<br>Homepage', 'bellaworks' );
        $columns['featimage'] = __( 'Image', 'bellaworks' );
        $columns['taxonomy-event-location'] = __( 'Location', 'bellaworks' );
        $columns['date'] = __( 'Date', 'bellaworks' );
        $columns['expirationdate'] = __( 'Expires', 'bellaworks' );
    }

    if($post_type=='post') {
        unset($columns['tags']);
        unset($columns['author']);
        unset($columns['categories']);
        unset($columns['taxonomy-activity_type']);
        unset($columns['expirationdate']);
        unset($columns['date']);
        $columns['title'] = __( 'Name', 'bellaworks' );
        $columns['show_on_homepage'] = __( 'Show on<br>Homepage', 'bellaworks' );
        $columns['taxonomy-activity_type'] = __( 'Activity', 'bellaworks' );
        $columns['categories'] = __( 'Category', 'bellaworks' );
        $columns['author'] = __( 'Author', 'bellaworks' );
        $columns['date'] = __( 'Date', 'bellaworks' );
        $columns['expirationdate'] = __( 'Expires', 'bellaworks' );
    }

    if($post_type=='camp') {
        unset($columns['expirationdate']);
        unset($columns['date']);
        $columns['title'] = __( 'Name', 'bellaworks' );
        $columns['eventdate'] = __( 'Event Dates', 'bellaworks' );
        $columns['date'] = __( 'Date', 'bellaworks' );
        $columns['expirationdate'] = __( 'Expires', 'bellaworks' );
    }

    if($post_type=='faqs') {
        unset($columns['expirationdate']);
        unset($columns['date']);
        unset($columns['taxonomy-faq_type']);
        $columns['title'] = __( 'Name', 'bellaworks' );
        $columns['icon'] = __( 'Icon', 'bellaworks' );
        $columns['taxonomy-faq_type'] = __( 'FAQ Type', 'bellaworks' );
        $columns['date'] = __( 'Date', 'bellaworks' );
        $columns['expirationdate'] = __( 'Expires', 'bellaworks' );
    }

    if($post_type=='instructions') {
        unset($columns['taxonomy-instructions-template']);
    }
    
    return $columns;
}

//Add the data to the custom columns for the book post type:
add_action( 'manage_posts_custom_column' , 'custom_post_column', 10, 2 );
function custom_post_column( $column, $post_id ) {
    global $wp_query;
    $query = isset($wp_query->query) ? $wp_query->query : '';
    $post_type = ( isset($query['post_type']) ) ? $query['post_type'] : '';
    
    if($post_type=='music') {
        switch ( $column ) {

            case 'show_on_homepage' :
                $show = get_field('show_on_homepage',$post_id);
                if($show=='yes') {
                    echo '<span style="display:inline-block;width:50px;text-align:center;"><i class="dashicons dashicons-star-filled" style="color:#f1b429;font-size:25px;"></i></span>';
                } 
                break;

            case 'featimage' :
                $img = get_field('thumbnail_image',$post_id);
                $img_src = ($img) ? $img['sizes']['medium'] : '';
                $the_photo = '<span class="tmphoto" style="display:inline-block;width:50px;height:50px;background:#e2e1e1;text-align:center;border:1px solid #CCC;overflow:hidden;">';
                if($img_src) {
                   $the_photo .= '<span style="display:block;width:100%;height:100%;background:url('.$img_src.') top center no-repeat;background-size:cover;transform:scale(1.2)"></span>';
                } else {
                    $the_photo .= '<i class="dashicons dashicons-format-image" style="font-size:25px;position:relative;top:13px;left: -3px;opacity:0.3;"></i>';
                }
                $the_photo .= '</span>';
                echo $the_photo;
                break;
        }
    }

    if($post_type=='post') {
        switch ( $column ) {

            case 'show_on_homepage' :
                $show = get_field('show_on_homepage',$post_id);
                if($show=='yes') {
                    echo '<span style="display:inline-block;width:50px;text-align:center;"><i class="dashicons dashicons-star-filled" style="color:#f1b429;font-size:25px;"></i></span>';
                } 
                break;

        }
    }

    if($post_type=='camp') {
        switch ( $column ) {
            case 'eventdate' :
                $dates = get_field('date_range',$post_id);
                echo ($dates) ? $dates:'';
                break;
        }
    }

    if($post_type=='faqs') {
        switch ( $column ) {
            case 'icon' :
                $icon = get_field('custom_icon',$post_id);
                echo ($icon) ? '<span class="'.$icon.'" style="font-size:25px;line-height:1"></span>':'';
                break;
        }
    }
    
}
