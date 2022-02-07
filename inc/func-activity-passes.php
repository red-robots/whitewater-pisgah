<?php
function get_single_activity_passes_list($option=false) {
    global $wpdb;
    $single_activity_passes_id = 3; /* term id for 'single activity passes' */
    $output = '';

    if( $option=='custom' ) {

        $other_activities = get_field("other_activities","option");
        $query = "SELECT p.ID,p.post_title FROM ".$wpdb->prefix."posts p, ".$wpdb->prefix."term_relationships rel WHERE p.ID=rel.object_id AND rel.term_taxonomy_id=".$single_activity_passes_id." AND p.post_type='activity' AND p.post_status='publish' ORDER BY p.post_title ASC";
        $result = $wpdb->get_results($query);
        $lists = array();
        if($result) {
            foreach($result as $row) {
                $pid = $row->ID;
                $price = get_field("single_access_price",$pid);
                if( $price ) {
                    if (strpos($price, '$') !== false) {
                        $price = $price;
                    } else {
                        $price = '$' . $price;
                    }
                }
                $buy_link = get_field("single_buy_link",$pid);
                $alt_title = get_field("page_alternative_title",$pid);
                $activityName = ($alt_title) ? $alt_title : $row->post_title;
                $abtn = array();
                if($buy_link) {
                    $abtn['title'] = 'Purchase';
                    $abtn['url'] = $buy_link;
                    $abtn['target'] = '_blank';
                }

                $lists[] = array('name'=>$activityName,'price'=>$price,'button'=>$abtn,'id'=>$pid,'custom'=>false);
            }
        }

        $others = array();
        if($other_activities) {
            $i=1; foreach($other_activities as $e) {
                $e_title = $e['title'];
                $e_price = $e['price'];
                $btn = (isset($e['purchase_button']) && $e['purchase_button']) ? $e['purchase_button'] : '';
                $e_btn_title = ( isset($btn['title']) && $btn['title'] ) ? $btn['title'] : '';
                $e_btn_url = ( isset($btn['url']) && $btn['url'] ) ? $btn['url'] : '';
                $e_btn_target = ( isset($btn['target']) && $btn['target'] ) ? $btn['target'] : '';
                if($e_title) {
                    $slug = sanitize_title($e_title) . '_' . $i;
                    $lists[] = array('name'=>$e_title,'price'=>$e_price,'button'=>$btn,'id'=>'','custom'=>1);
                    $i++;
                }
            }   
        }

        if($lists) {
            $output = customSortArray($lists,'name');
        }
        
    } else {
    
        /* DEFAULT */
        $lists = array();
        $args = array(
            'posts_per_page'    => -1,
            'post_type'         => 'activity',
            'post_status'       => 'publish',
            'tax_query'         => array(
                                    array(
                                        'taxonomy' => 'pass_type',
                                        'field' => 'term_id',
                                        'terms' => $single_activity_passes_id,
                                        'operator' => 'IN'
                                    )
                                )
            );

        $entries = get_posts($args);
        if($entries) {
            foreach($entries as $e) {
                $pid = $e->ID;
                $price = get_field("single_access_price",$pid);
                if( $price ) {
                    if( is_numeric($price) ) {
                        if (strpos($price, '$') !== false) {
                            $price = $price;
                        } else {
                            $price = '$' . $price;
                        }
                    } 
                }
                $buy_link = get_field("single_buy_link",$pid);
                $alt_title = get_field("page_alternative_title",$pid);
                $title = ($alt_title) ? $alt_title : $e->post_title;
                $btn = array();
                if($buy_link) {
                    $parse = parse_external_url($buy_link);
                    $target = $parse['target'];
                    $btn['title'] = 'Purchase';
                    $btn['url'] = $buy_link;
                    $btn['target'] = $target;
                }
                $lists[] = array('name'=>$title,'price'=>$price,'button'=>$btn,'id'=>$pid,'custom'=>'');
            }
        }

        $output = ($lists) ? $lists : '';

    }

    return $output;
}


function customSortArray($data, $field) {
    foreach ($data as $key => $row) {
        $vc_array_name[$key] = $row;
    }
    array_multisort($vc_array_name, SORT_ASC, $data);
    return $vc_array_name;
}



