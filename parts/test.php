function get_race_posts() {
  $url = 'https://center.whitewater.org/wp-json/wp/v2/race?per_page=99';
  $response = wp_remote_get($url);
  if ( is_wp_error( $response ) ) {
    return false;
  }
  $posts = json_decode( wp_remote_retrieve_body( $response ), true );



//   echo '<pre>';
// print_r($posts);
// echo '</pre>';


  $race_posts = array();
  foreach ($posts as $post) {
    $race_post = array(
		'title' => $post['title']['rendered'],
		'pagelink' => $post['link'],
		'start' => $post['acf']['start_date'],
		'end' => $post['acf']['end_date'],
		'hidePostfromMainPage' => $post['acf']['hidePostfromMainPage'],
		'event_date' => $event_date,
		'short_description' => $short_description,
		'eventStatus' => ( $post['acf']['eventstatus'] ) ? $post['acf']['eventstatus']:'upcoming',
		'thumbImage' => $post['acf']['thumbnail_image'],
		'eventlocation' => array(),
		'terms' => array(),
		'loc_terms' => array(),
    );
    if (!empty($post['activity_type'])) {
      $terms = get_terms( array(
        'taxonomy' => 'activity_type',
        'include' => $post['activity_type'],
        'fields' => 'slugs',
      ) );
      $race_post['terms'] = $terms;
    }
    if (!empty($post['acf']['eventlocation'])) {
    	foreach( $post['acf']['eventlocation'] as $rl ){
    		$race_post['eventlocation'][] = array(
		        'value' => $rl['value'], // Store the location value
		        'label' => $rl['label'] // Store the location label
		      );
    		$race_post['eventlocation'] = $race_post;
    		// $race_post['eventlocation'] = $rl;
    	}
	}
    if( empty($post['acf']['hidePostfromMainPage']) && in_array('santee',$race_post['eventlocation'] ) ) {
	    $race_posts[] = $race_post;
	}
 
  }
  return $race_posts;
}