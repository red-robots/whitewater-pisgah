<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package bellaworks
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
define('THEMEURI',get_template_directory_uri() . '/');

function bellaworks_body_classes( $classes ) {
    // Adds a class of group-blog to blogs with more than 1 published author.
    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }

    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    if ( is_front_page() || is_home() ) {
        $classes[] = 'homepage';
    } else {
        $classes[] = 'subpage';
    }

    $browsers = ['is_iphone', 'is_chrome', 'is_safari', 'is_NS4', 'is_opera', 'is_macIE', 'is_winIE', 'is_gecko', 'is_lynx', 'is_IE', 'is_edge'];
    $classes[] = join(' ', array_filter($browsers, function ($browser) {
        return $GLOBALS[$browser];
    }));

    return $classes;
}
add_filter( 'body_class', 'bellaworks_body_classes' );


function add_query_vars_filter( $vars ) {
  $vars[] = "pg";
  return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );


function shortenText($string, $limit, $break=".", $pad="...") {
  // return with no change if string is shorter than $limit
  if(strlen($string) <= $limit) return $string;

  // is $break present between $limit and the end of the string?
  if(false !== ($breakpoint = strpos($string, $break, $limit))) {
    if($breakpoint < strlen($string) - 1) {
      $string = substr($string, 0, $breakpoint) . $pad;
    }
  }

  return $string;
}

/* Fixed Gravity Form Conflict Js */
add_filter("gform_init_scripts_footer", "init_scripts");
function init_scripts() {
    return true;
}

function get_page_id_by_template($fileName) {
    $page_id = 0;
    if($fileName) {
        $pages = get_pages(array(
            'post_type' => 'page',
            'meta_key' => '_wp_page_template',
            'meta_value' => $fileName.'.php'
        ));

        if($pages) {
            $row = $pages[0];
            $page_id = $row->ID;
        }
    }
    return $page_id;
}

function string_cleaner($str) {
    if($str) {
        $str = str_replace(' ', '', $str); 
        $str = preg_replace('/\s+/', '', $str);
        $str = preg_replace('/[^A-Za-z0-9\-]/', '', $str);
        $str = strtolower($str);
        $str = trim($str);
        return $str;
    }
}

function format_phone_number($string) {
    if(empty($string)) return '';
    $append = '';
    if (strpos($string, '+') !== false) {
        $append = '+';
    }
    $string = preg_replace("/[^0-9]/", "", $string );
    $string = preg_replace('/\s+/', '', $string);
    return $append.$string;
}

function get_instagram_setup() {
    global $wpdb;
    $result = $wpdb->get_row( "SELECT option_value FROM $wpdb->options WHERE option_name = 'sb_instagram_settings'" );
    if($result) {
        $option = ($result->option_value) ? @unserialize($result->option_value) : false;
    } else {
        $option = '';
    }
    return $option;
}


function get_social_links() {
    $social_types = social_icons();
    $social = array();
    foreach($social_types as $k=>$icon) {
        if( $value = get_field($k,'option') ) {
            $social[$k] = array('link'=>$value,'icon'=>$icon);
        }
    }
    return $social;
}

function social_icons() {
    $social_types = array(
        'facebook'  => 'fab fa-facebook-square',
        'twitter'   => 'fab fa-twitter-square',
        'linkedin'  => 'fab fa-linkedin',
        'instagram' => 'fab fa-instagram',
        'youtube'   => 'fab fa-youtube',
        'vimeo'  => 'fab fa-vimeo',
    );
    return $social_types;
}

function parse_external_url( $url = '', $internal_class = 'internal-link', $external_class = 'external-link') {

    $url = trim($url);

    // Abort if parameter URL is empty
    if( empty($url) ) {
        return false;
    }

    //$home_url = parse_url( $_SERVER['HTTP_HOST'] );     
    $home_url = parse_url( home_url() );  // Works for WordPress

    $target = '_self';
    $class = $internal_class;

    if( $url!='#' ) {
        if (filter_var($url, FILTER_VALIDATE_URL)) {

            $link_url = parse_url( $url );

            // Decide on target
            if( empty($link_url['host']) ) {
                // Is an internal link
                $target = '_self';
                $class = $internal_class;

            } elseif( $link_url['host'] == $home_url['host'] ) {
                // Is an internal link
                $target = '_self';
                $class = $internal_class;

            } else {
                // Is an external link
                $target = '_blank';
                $class = $external_class;
            }
        } 
    }

    // Return array
    $output = array(
        'class'     => $class,
        'target'    => $target,
        'url'       => $url
    );

    return $output;
}


function GetDays($sStartDate, $sEndDate){  
    // Firstly, format the provided dates.  
    // This function works best with YYYY-MM-DD  
    // but other date formats will work thanks  
    // to strtotime().  
    $sStartDate = gmdate("Y-m-d", strtotime($sStartDate));  
    $sEndDate = gmdate("Y-m-d", strtotime($sEndDate));  

    // Start the variable off with the start date  
    $aDays[] = $sStartDate;  

    // Set a 'temp' variable, sCurrentDate, with  
    // the start date - before beginning the loop  
    $sCurrentDate = $sStartDate;  

    // While the current date is less than the end date  
    while($sCurrentDate < $sEndDate){  
        // Add a day to the current date  
        $sCurrentDate = gmdate("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));  

        // Add this new day to the aDays array  
        $aDays[] = $sCurrentDate;  
    }  

    // Once the loop has finished, return the  
    // array of days.  
    return $aDays;  
}  


function get_event_date_range($start,$end,$fullMonth=false) {
    $event_date = '';
    $date_range = array($start,$end);
    if($date_range && array_filter($date_range) ) {
        $dates = array_filter( array_unique($date_range) );
        $count = count($dates);
        if($count>1) {
            $s_day =  date('d',strtotime($start));
            $e_day =  date('d',strtotime($end));
            
            /* If the same year */
            if( date("Y",strtotime($start)) == date("Y",strtotime($end)) ) {
                $year = date('Y',strtotime($start));

                if( date("m",strtotime($start)) == date("m",strtotime($end)) ) {
                    if($fullMonth) {
                        $month = date('F',strtotime($start));
                    } else {
                        $month = date('M',strtotime($start));
                    }
                    $event_date = $month . ' ' . $s_day . '-' . $e_day . ', ' . $year;
                }
                if( date("m",strtotime($start)) != date("m",strtotime($end)) ) {
                    $event_date_start = date('M',strtotime($start)) . ' ' . $s_day;
                    $event_date_end = date('M',strtotime($end)) . ' ' . $e_day;
                    $event_date = $event_date_start . ' - ' . $event_date_end . ', ' . $year;
                }

            } else {

                $year_start = date('Y',strtotime($start));
                $year_end = date('Y',strtotime($end));
                $event_date_start = date('M',strtotime($start)) . ' ' . $s_day . ', ' . $year_start;
                $event_date_end = date('M',strtotime($end)) . ' ' . $e_day . ', ' . $year_end;
                $event_date = $event_date_start . ' - ' . $event_date_end;

            }

        } else {

            if($start) {
                if($fullMonth) {
                    $event_date = date('F d, Y', strtotime($start));
                } else {
                    $event_date = date('M d, Y', strtotime($start));
                }
                
            }
            
        } 

    }
    return $event_date;
}

add_action('admin_head', 'my_custom_admin_css');
function my_custom_admin_css() { ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() ?>/css/admin.css">
<style type="text/css">
[data-name="child_menu_pagelink"] .acf-label {position:relative;}
[data-name="child_menu_pagelink_target"],
#menu-posts-instructions ul.wp-submenu li:last-child{display:none!important}
<?php 
$has_expiration_post_types = array('festival','music'); 
foreach($has_expiration_post_types as $pt) { ?>
    body.post-type-<?php echo $pt?> div.acf-field[data-name="is_event_completed"] h2.hndle,
    body.post-type-<?php echo $pt?> div.acf-field[data-name="is_event_completed"] .acf-input,
    body.post-type-<?php echo $pt?> div.acf-field[data-name="is_event_completed"] .acf-label label {
        display: none;
    }
<?php } ?>
</style>
<?php }

/*===== START ADMIN CUSTOM SCRIPTS ======*/
add_action('admin_footer', 'my_custom_admin_js');
function my_custom_admin_js() { ?>
<script type="text/javascript">
jQuery(document).ready(function($){

    $('[data-name="call-to-actions"] tr.acf-row').each(function(){
        $(this).find("td.acf-field-link").append('<a href="#" title="Click to copy" class="txtshortcode">[call-to-action]</a>');
    });

    $(document).on("click","a.txtshortcode",function(e){
        e.preventDefault();
        var parent = $(this).parents("tr.acf-row");
        var num = parent[0].rowIndex;
        var code = '[call-to-action id="'+num+'"]';
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(code).select();
        document.execCommand("copy");
        $temp.remove();
        var msg = '<i class="copied">Copied to clipboard!</i>';
        $(msg).insertAfter( parent.find('.txtshortcode') );
        setTimeout(function(){
            parent.find('.copied').hide();
        },500);
    });

    /* Move `Child Menu Pagelink Target` */
    $('[data-name="child_menu_pagelink_target"]').each(function(){
        var parent = $(this).parents('[data-layout="child_menu_data"]');
        $(this).find('.acf-input').appendTo( )
        parent.find('[data-name="child_menu_pagelink_target"] .acf-input').appendTo( parent.find('[data-name="child_menu_pagelink"] .acf-input-wrap') );
    });

    /* ACF Flexible Content For Other Activities */
    if( $('[data-name="other_activities"]').length > 0 ) {
        $('[data-layout="other_activity"]').each(function(){
            var str = $(this).find('[data-name="title"] .acf-input-wrap input').val();
            var title = ( str.replace(/\s+/g,'').trim() ) ? str.replace(/\s+/g,' ').trim() : '(Blank)';
            $(this).find(".acf-fc-layout-handle").attr("data-title",title);
        });
    }

    /* ACF Flexible Content For Buy Page */
    if( $('[data-name="repeater_blocks"]').length > 0 ) {
        $('[data-name="repeater_blocks"] [data-layout="section"]').each(function(){
            var str = $(this).find('[data-name="title"] .acf-input-wrap input').val();
            var title = ( str.replace(/\s+/g,'').trim() ) ? str.replace(/\s+/g,' ').trim() : '(Blank)';
            $(this).find(".acf-fc-layout-handle").attr("data-title",title);
        });
    }

    if( $('.acf-flexible-content [data-layout="section2"]').length > 0 ) {
        $('.acf-flexible-content [data-layout="section2"]').each(function(){
            var str = $(this).find('[data-name="title"] .acf-input-wrap input').val();
            var title = ( str.replace(/\s+/g,'').trim() ) ? str.replace(/\s+/g,' ').trim() : '(Blank)';
            $(this).find(".acf-fc-layout-handle").attr("data-title",title);
        });
    }

    /* ACF Flexible Content For Group Events Itineraries */
    if( $('[data-name="accordion_content"]').length > 0 ) {
        $('[data-layout="accordion_entry"]').each(function(){
            var str = $(this).find('[data-name="grouptitle"] .acf-input-wrap input').val();
            var title = ( str.replace(/\s+/g,'').trim() ) ? str.replace(/\s+/g,' ').trim() : '(Blank)';
            $(this).find(".acf-fc-layout-handle").attr("data-title",title);
        });
    }

    /* ACF Flexible Content For Group Events Services */
    if( $('[data-name="groupevents_featuredservices"]').length > 0 ) {
        $('[data-layout="services"]').each(function(){
            var str = $(this).find('[data-name="title"] .acf-input-wrap input').val();
            var title = ( str.replace(/\s+/g,'').trim() ) ? str.replace(/\s+/g,' ').trim() : '(Blank)';
            $(this).find(".acf-fc-layout-handle").attr("data-title",title);
        });
    }

    /* ACF Flexible Content For Camp Activities */
    if( $('[data-name="activities_flexcontent"]').length > 0 ) {
        $('[data-layout="activities"]').each(function(){
            var str = $(this).find('[data-name="title"] .acf-input-wrap input').val();
            var title = ( str.replace(/\s+/g,'').trim() ) ? str.replace(/\s+/g,' ').trim() : '(Blank)';
            $(this).find(".acf-fc-layout-handle").attr("data-title",title);
        });
    }

    /* Catering Services (Weddings) */
    if( $('[data-layout="catering"]').length > 0 ) {
        $('[data-layout="catering"]').each(function(){
            var str = $(this).find('[data-name="title"] .acf-input-wrap input').val();
            var title = ( str.replace(/\s+/g,'').trim() ) ? str.replace(/\s+/g,' ').trim() : '(Blank)';
            $(this).find(".acf-fc-layout-handle").attr("data-title",title);
        });
    }

    /* ACF Flexible Content for Menu Options */
    if( $("#acf-group_5f1912cfb5ecf").length > 0 ) {
        $('[data-layout="menu_group"]').each(function(){
            var parent = $(this).find('[data-name="parent_menu_name"] .acf-input-wrap input').val();
            var parentMenu = ( parent.replace(/\s+/g,'').trim() ) ? parent.replace(/\s+/g,' ').trim() : '(Blank)';
            var parentMenu_child = ( parent.replace(/\s+/g,'').trim() ) ? parent.replace(/\s+/g,' ').trim() : '';
            $(this).attr("data-parenttext",parentMenu);
            $(this).find('[data-layout="child_menu_data"]').attr("data-parenttext","- "+parentMenu_child);
        });
    }

    if( $('[data-layout="race_type').length > 0 ) {
        $('[data-layout="race_type').each(function(e){
            var tab = $(this).find('[data-name="name"] .acf-input-wrap input').val();
            var tabName = ( tab.replace(/\s+/g,'').trim() ) ? tab.replace(/\s+/g,' ').trim() : '(Untitle)';
            $(this).attr("data-parenttext",tabName);
        });
    }


    if( ($('body.post-php div.acf-field[data-name="is_event_completed"]').length > 0) && ($("#expirationdatediv").length > 0) ) {
        $("#expirationdatediv").appendTo('div.acf-field[data-name="is_event_completed"]');
        //var acfLabel = $('body.post-php div.acf-field[data-name="is_event_completed"] .acf-label label').text();
        var acfLabel = 'Enable post expiration if event is completed';
        $('div.acf-field #expirationdatediv label[for="enable-expirationdate"]').html('<strong>'+acfLabel+'</strong>');
    }

    if( $("#acf-group_5f460b222fe52").length > 0 ) {
        $('[data-layout="activity"]').each(function(){
            var parent = $(this).find('[data-name="type"] .acf-input-wrap input').val();
            var tabTitle = ( parent.replace(/\s+/g,'').trim() ) ? parent.replace(/\s+/g,' ').trim() : '(Untitled)';
            //var parentMenu_child = ( parent.replace(/\s+/g,'').trim() ) ? parent.replace(/\s+/g,' ').trim() : '';
            //$(this).find(".acf-fc-layout-handle").attr("data-parenttext",parentMenu);
            $(this).find(".acf-fc-layout-handle").append('<span class="customTabName">'+tabTitle+'</span>');
        });
        $(document).on("keyup",'[data-layout="activity"] [data-name="type"] .acf-input-wrap input',function(){
            var str = $(this).val().replace(/\s+/g,' ').trim();
            var parent = $(this).parents('[data-layout="activity"]');
            parent.find(".customTabName").text(str);
        });
    }

    /* ACF Flexible Content For Festival Activities */
    if( $('.acf-field-flexible-content [data-layout="festivalActivities"]').length > 0 ) {
        $('.acf-field-flexible-content [data-layout="festivalActivities"]').each(function(){
            var str = $(this).find('[data-name="day"] .acf-input select option:selected').text();
            var title = ( str.replace(/\s+/g,'').trim() ) ? str.replace(/\s+/g,' ').trim() : '(Blank)';
            $(this).find(".acf-fc-layout-handle").attr("data-title",title);
        });
    }


    if( $("body.wp-admin.post-type-activity_schedule").length > 0 ) {
        //$('[data-name="eventDateSchedule"] input.hasDatepicker').focus();
        $("#titlewrap").append('<span class="cover"></span>');
        $("#titlewrap input").blur();
        $('[data-name="eventDateSchedule"]').focus();
        // $(document).on("keyup change blur",'[data-name="eventDateSchedule"] input.hasDatepicker',function(){
        //     var defaultVal = $("#titlewrap input").val();
        //     var str = $(this).val().replace(/\s+/g,' ').trim();
        //     $("#titlewrap input").val(str).addClass("focus-visible");
        //     $("#title-prompt-text").addClass("screen-reader-text");
        //     if(defaultVal) {
        //         $(".button.edit-slug").trigger("click");
        //         $("#new-post-slug").val("");
        //         $(".button.save").trigger("click");
        //     }
        // });
    }

    /* select custom icons */
    if( $('div.acf-field[data-name="custom_icon"]').length>0 ) {
        var customIconDiv = $('div.acf-field[data-name="custom_icon"]');
        //var input = $(this).find('div.acf-field[data-name="custom_icon"] .acf-input-wrap input');
        // var input = $('div.acf-field[data-name="custom_icon"] .acf-input-wrap input');
        // var id = input.attr("id");
        // var icon = input.val();
        // var label = (icon) ? 'Edit' : 'Add Icon';
        // var btn = '<span class="cusIcon"><i class="'+icon+'"></i></span><a href="#" data-icon="'+icon+'" class="iconOptBtn">'+label+'</a>';
        // $(btn).insertAfter(input);
        customIconDiv.each(function(){
            var input = $(this).find('.acf-input-wrap input');
            var id = input.attr("id");
            var icon = input.val();
            var label = (icon) ? 'Edit' : 'Add Icon';
            var btn = '<span class="cusIcon"><i class="'+icon+'"></i></span><a href="#" data-icon="'+icon+'" class="iconOptBtn">'+label+'</a>';
            $(btn).insertAfter(input);
        });
        
        $(document).on("click",".customIconBtn",function(e){
            e.preventDefault();
            $("#customIconsContainer").show();
        });
        $(document).on("click",".iconOptBtn",function(e){
            e.preventDefault();
            var icon = $(this).attr("data-icon");
            //var parent = customIconDiv;
            var parent = $(this).parents('[data-name="custom_icon"]');
            var inputId = parent.find(".acf-input-wrap input").attr("id");
            $("#customIconsContainer").show();
            parent.addClass("selected");
            if(icon) {
                //$("#customIconsContainer").attr("data-assign",inputId);
                $('.iconBox .w[data-icon="'+icon+'"]').parent().addClass("selected");
            }
        });

        $(document).on("click","#closeIconList",function(e){
            e.preventDefault();
            $("#customIconsContainer").hide();
            $("#customIconsContainer").attr("data-assign","");
            $("#customIconsContainer .iconBox").removeClass('selected');
            $('div.acf-field[data-name="custom_icon"]').removeClass('selected');
        });
        $(document).on("click",".iconBox .w",function(e){
            e.preventDefault();
            var icon = $(this).attr("data-icon");
            // var input = customIconDiv.find('.acf-input-wrap input');
            // var inputId = $("#customIconsContainer").attr("data-assign");
            // var parent = customIconDiv;
            var parent = $('div.acf-field[data-name="custom_icon"].selected');
            var input = parent.find('.acf-input-wrap input');
            input.val(icon);
            parent.find("span.cusIcon i").removeAttr("class").addClass(icon);
            parent.find(".iconOptBtn").attr("data-icon",icon);
            parent.find(".iconOptBtn").text('Edit');
            $("#closeIconList").trigger("click");
        });
    }

    if( $('th[data-name="custom_icon"]').length>0 ) {
        // $('th[data-name="custom_icon"]').each(function(){
        //     var iconLink = '<a href="#" class="customIconBtn">Click here to select icons</a>';
        //     $(this).append(iconLink);
        // });

        $('tbody td[data-name="custom_icon"]').each(function(k){
            var ctr = k+1;
            var input = $(this).find(".acf-input-wrap input");
            var id = input.attr("id");
            var icon = input.val();
            var label = (icon) ? 'Edit' : 'Add Icon';
            var btn = '<span class="cusIcon"><i class="'+icon+'"></i></span><a href="#" data-icon="'+icon+'" class="iconOptBtn">'+label+'</a>';
            $(btn).insertAfter(input);
        });
        
        $(document).on("click",".customIconBtn",function(e){
            e.preventDefault();
            $("#customIconsContainer").show();
        });
        $(document).on("click","#closeIconList",function(e){
            e.preventDefault();
            $("#customIconsContainer").hide();
            $("#customIconsContainer").attr("data-assign","");
            $("#customIconsContainer .iconBox").removeClass('selected');
        });
        $(document).on("click",".iconBox .w",function(e){
            e.preventDefault();
            var icon = $(this).attr("data-icon");
            var inputId = $("#customIconsContainer").attr("data-assign");
            var parent = $('td[data-name="custom_icon"]').find("input#"+inputId).parent();
            $(('td[data-name="custom_icon"]')).find("input#"+inputId).val(icon);
            parent.find("span.cusIcon i").removeAttr("class").addClass(icon);
            parent.find(".iconOptBtn").attr("data-icon",icon);
            parent.find(".iconOptBtn").text('Edit');
            $("#closeIconList").trigger("click");
        });

        $(document).on("click",".iconOptBtn",function(e){
            e.preventDefault();
            var icon = $(this).attr("data-icon");
            var parent = $(this).parents('td[data-name="custom_icon"]');
            var inputId = parent.find(".acf-input-wrap input").attr("id");
            $("#customIconsContainer").show();
            $("#customIconsContainer").attr("data-assign",inputId);
            $('.iconBox .w[data-icon="'+icon+'"]').parent().addClass("selected");
        });

        function copyToClipboard(str) {
          var $temp = $("<input>");
          $("body").append($temp);
          $temp.val(str).select();
          document.execCommand("copy");
          $temp.remove();
        }
    }

});
</script>
<div id="customIconsContainer">
<?php echo displayCustomIcons(); ?>
</div>
<?php
}
/*===== END ADMIN CUSTOM SCRIPTS ======*/

/*===== CUSTOM ICONS ======*/
// $test = 'https://wwc.bellaworksdev.com/wp-content/themes/usnwc-2020/assets/sass/_fonts.scss';
// ob_start();
// $content = file_get_contents($test);
// ob_get_contents();
// ob_end_clean();
// print_r($content);



displayCustomIcons();
function displayCustomIcons() {
    $fonts = '';
    $fontsFile = get_template_directory() . '/assets/sass/_fonts.scss';
    ob_start();
    include($fontsFile);
    $fonts = ob_get_contents();
    ob_end_clean();
    $parts = explode("/*==custom icons==*/",$fonts);
    $fontStyle = '';
    if( isset($parts[2]) ) {
        unset($parts[2]);
        $fontStyle = implode("",$parts);
    }
    
    $fontURL = get_stylesheet_directory_uri() . '/fonts/';
    //$path = get_stylesheet_directory_uri() . '/assets/sass/_fonts.scss';
    //$content = file_get_contents($path);
    $content = str_replace("fonts/",$fontURL,$fontStyle);
    $styleSheet = $content;
    $iconList = array();
    $output = '';
    ob_start();
    if( isset($parts[1]) && $parts[1] ) {
        $iconData = str_replace(" ","",$parts[1]);
        $iconsClasses = preg_replace('/\s+/', '', $iconData);
        $icons = explode(";}",$iconsClasses);
        if( $lists = array_filter($icons) ) {
            foreach($lists as $str) {
                $strings = explode(":before",$str);
                $iconList[] = str_replace(".","",$strings[0]);
            }
            if($iconList) { ?>
            <style type="text/css"><?php echo $styleSheet ?></style>
            <div class="customIconList">
                <a href="#" id="closeIconList"><span>x</span></a>
                <div class="iconContainer">
                <?php foreach($iconList as $i) {?>
                <div class="iconBox">
                    <div class="w" data-icon="<?php echo $i ?>">
                        <i class="iconClass <?php echo $i?>"></i>
                        <div class="iconName">.<?php echo $i ?></div>
                    </div>
                </div>
                <?php } ?>
                </div>
            </div>
            <?php }
        }
    }
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

/* ACF CUSTOM OPTIONS TABS */
// if( function_exists('acf_add_options_page') ) {
//     acf_add_options_page();
// }
function be_acf_options_page() {
    if ( ! function_exists( 'acf_add_options_page' ) ) return;
    
    $acf_option_tabs = array(
        array( 
            'title'      => 'Today Options',
            'capability' => 'manage_options',
        ),
        array( 
            'title'      => 'Menu Options',
            'capability' => 'manage_options',
        ),
        array( 
            'title'      => 'Global Options',
            'capability' => 'manage_options',
        )
    );

    foreach($acf_option_tabs as $options) {
        acf_add_options_page($options);
    }
}
add_action( 'acf/init', 'be_acf_options_page' );

/* Options page under Story custom post type */
if( function_exists('acf_add_options_page') ) {
    acf_add_options_sub_page(array(
        'page_title'     => 'Other Activities',
        'menu_title'    => 'Other Activities',
        'parent_slug'    => 'edit.php?post_type=activity',
    ));
}

function get_vimeo_data($vimeoId) {
    if (empty($vimeoId)) return '';
    $obj = @unserialize(file_get_contents("https://vimeo.com/api/v2/video/".$vimeoId.".php"));
    return ($obj) ? $obj[0] : '';
    //$json_url = 'http://vimeo.com/api/v2/video/'.$vimeoId.'.json?callback=showThumb';
    // $json_data = @file_get_contents($json_url);
    // if($json_data) {
    //     $json_parts = str_replace("/**/showThumb(","",$json_data);
    //     $json_parts = str_replace("}])","}]",$json_parts);
    //     $data = json_decode($json_parts);
    //     return ($data) ? $data[0] : '';
    // }
}

function get_pass_type_category($term_id) {
    $taxonomy = 'pass_type';
    $args = array(
        'posts_per_page'=> -1,
        'post_type'     => 'pass',
        'post_status'   => 'publish',
        'tax_query' => array(
            array(
                'taxonomy' => $taxonomy,
                'field' => 'term_id',
                'terms' => $term_id
            )
        )
        
    );
    $posts = get_posts($args);
    return ($posts) ? $posts : '';
}


function get_faqs_by_single_post($post_id) {
    global $wpdb;
    $faq_posts = array();
    $faq_post_types = array();

    $post_type = get_post_type($post_id);

    $query = "SELECT p.ID, m.meta_value as content_type FROM {$wpdb->posts} p, {$wpdb->postmeta} m
              WHERE m.post_id=p.ID AND p.post_type='faqs' AND p.post_status='publish' AND m.meta_key='content'";
    $result = $wpdb->get_results($query);
    if($result) {
        foreach($result as $row) {
            $faq_post_id = $row->ID;
            $type = $row->content_type; /* single or multiple */
            if($type) {
                $metaKey = $type . '_type'; /* This may result `single_type` or `multiple_type` */ 
                $meta = get_content_type_data($faq_post_id,$metaKey);
                if($type=='single') {
                    
                    if($meta) {
                        if( $metaPostIds = $meta->meta_value ) {
                            if( in_array($post_id, $metaPostIds) ) {
                                $faq_posts[] = $faq_post_id;
                            }
                        }
                    }
                } elseif($type=='multiple') {
                    /* get post type assigned */
                    if($post_type) {
                        if( $assigned_posttypes = $meta->meta_value ) {
                            if( in_array($post_type, $assigned_posttypes) ) {
                                $faq_posts[] = $faq_post_id;
                            }
                        }
                    }
                }
            }
        }
    }

    return $faq_posts;
}


function get_content_type_data($post_id,$metaKey) {
    global $wpdb;
    $query = "SELECT * FROM {$wpdb->postmeta} m 
              WHERE m.post_id=".$post_id." AND m.meta_key='".$metaKey."'";
    $result = $wpdb->get_row($query);
    if($result) {
        $metaVal = ($result->meta_value) ? @unserialize($result->meta_value) : '';
        $result->meta_value = $metaVal;
    }
    return ($result) ? $result : '';
}

function get_faqs_by_assigned_page_id($postIds) {
    $faqs = array();
    if( empty($postIds) ) return '';
    foreach($postIds as $id) {
        $parent = get_the_title($id);
        $children = get_field("faqs",$id);
        if($children) {
            $item['ID'] = $id;
            $item['title'] = $parent;
            $item['faqs'] = $children;
            $faqs[] = $item;
        }
    }

    return $faqs;
}


function get_faq_listings($post_id) {
    $faqs = '';
    if( $faqsIds = get_faqs_by_single_post($post_id) ) {
        $faqs = get_faqs_by_assigned_page_id($faqsIds);
    }
    return $faqs;
}

function get_page_id_by_permalink($url) {
    global $wpdb;
    $siteURL = get_site_url();
    if( empty($url) ) return '';

    /* Check if internal or external link */
    $parse = parse_external_url($url);
    $basename = basename($url);
    if( $parse['class']=='internal-link' ) {
        $query = "SELECT p.ID, p.post_type FROM {$wpdb->posts} p 
                  WHERE p.post_name='".$basename."'";
        $result = $wpdb->get_row($query);
        return ($result) ? $result : '';
    } else {
        return '';
    }
}

function get_categories_by_page_id($post_id,$taxonomy,$related=null) {
    global $wpdb;
    $related_posts = array();
    $related_terms = ( isset($related['terms']) && $related['terms'] ) ? $related['terms'] : '';
    $related_taxonomy = ( isset($related['taxonomy']) && $related['taxonomy'] ) ? $related['taxonomy'] : '';
    
    $related_post_type = ( isset($related['post_type']) && $related['post_type'] ) ? $related['post_type'] : '';

    $query = "SELECT rel.object_id as post_id, tax.term_id, terms.name, terms.slug, tax.taxonomy FROM {$wpdb->terms} terms, {$wpdb->term_taxonomy} tax, {$wpdb->term_relationships} rel
              WHERE rel.term_taxonomy_id=tax.term_taxonomy_id AND tax.term_id=terms.term_id AND tax.taxonomy='".$taxonomy."' AND rel.object_id=".$post_id;

    $result = $wpdb->get_results($query);
    if($result) {
      foreach($result as $row) {
        $term_id = $row->term_id;
        $query2 = "SELECT p.*, terms.term_id, terms.name, terms.slug, tax.taxonomy FROM {$wpdb->posts} p, {$wpdb->terms} terms, {$wpdb->term_taxonomy} tax, {$wpdb->term_relationships} rel
                  WHERE p.ID=rel.object_id AND p.post_type='".$related_post_type."' AND p.post_status='publish' 
                  AND rel.term_taxonomy_id=tax.term_taxonomy_id AND tax.term_id=".$term_id." AND terms.term_id=tax.term_id GROUP BY p.ID ORDER BY p.post_date DESC";
        $related = $wpdb->get_results($query2);

        $limit = 2;
        if($related) {
          $i=1; foreach($related as $rel) {
            $post_terms = get_the_terms($rel,$related_taxonomy);
            if($post_terms) {
              foreach($post_terms as $p) {
                $p_term_slug = $p->slug;
                
                if( $related_terms && in_array($p_term_slug,$related_terms) ) {

                  $related_term_id = $p->related_terms;
                  
                  if($i<=$limit) {
                    $rel->related_terms = $p;
                    $related_posts[] = $rel; 
                  }

                  $i++;
                }

              }
            }
          }
        }

      }
    }

    return $related_posts;
}


function get_current_activity_schedule($postype) {
    global $wpdb;
    $dateNow = date('Y-m-d');
    ///$today = date('l, F jS, Y');
    //$today_slug = sanitize_title($today);
    $today_slug = sanitize_title($dateNow);
    $query = "SELECT * FROM {$wpdb->posts} p WHERE p.post_type='".$postype."' AND p.post_status='publish' AND p.post_name='".$today_slug."'";
    $result = $wpdb->get_row($query);
    return ($result) ? $result : '';
}

function update_post_status_if_expired() {
   global $wpdb;
   $dateNow = date('Y-m-d');
   $dateNowStr = strtotime( date('Ymd') );
   $query = "SELECT p.ID,p.post_title,p.post_type, date_format(str_to_date(m.meta_value, '%Y%m%d'),'%Y-%m-%d') AS start_date
           FROM {$wpdb->posts} p,{$wpdb->postmeta} m
           WHERE p.ID=m.post_id AND p.post_status='publish' 
           AND m.meta_key='start_date' AND (m.meta_value IS NOT NULL OR m.meta_value <> '') ORDER BY start_date ASC";
   $result = $wpdb->get_results($query); 
   $last_updated = get_last_post_status_updated();

   $exception = array('completed','canceled');
   $is_updated = array();

   if( empty($last_updated) || $last_updated!=$dateNow ) {

      if($result) {
         foreach($result as $row) {
            $post_id = $row->ID;
            $start_date = $row->start_date;
            $end_date = get_field("end_date",$post_id);
            $status = get_field('eventstatus',$post_id);
            $based_date = ($start_date) ? strtotime($start_date) : '';
            if($end_date) {
               $based_date = strtotime($end_date);
            }
            $row->eventstatus = $status;
            if($based_date) {
               if( !in_array($status,$exception) ) {
                  if($based_date<$dateNowStr) {
                     $updated = update_post_meta($post_id,'eventstatus','completed');
                     if($updated) {
                        $is_updated[] = $post_id;
                     }
                  }
               }
            }
         }
      }

   }   
   

   if($is_updated) {
      update_option('last_post_status_updated', $dateNow);
   }

   return $is_updated;
}

function get_last_post_status_updated() {
    global $wpdb;
    $query = "SELECT opt.option_value FROM {$wpdb->options} opt WHERE opt.option_name='last_post_status_updated'";
    $result = $wpdb->get_row($query); 
    $output = '';
    if($result) {
        $output = $result->option_value;
    } else {
        add_option('last_post_status_updated', NULL);
    }
    return $output;
}


function custom_query_posts($posttype,$perpage,$offset,$order='ASC') {
   global $wpdb;
   $dateToday = date('Y-m-d');
   $dateNow = strtotime($dateToday);
   $final = '';
   $total = 0;


   /* Fist option */
   // $query = "SELECT p.*,date_format(str_to_date(m.meta_value, '%Y%m%d'),'%Y-%m-%d') AS start_date
   //         FROM {$wpdb->posts} p,{$wpdb->postmeta} m
   //         WHERE p.ID=m.post_id AND p.post_type='".$posttype."' AND p.post_status='publish'
   //         AND m.meta_key='start_date' AND (m.meta_value IS NOT NULL OR m.meta_value <> '') 
   //         AND DATE(m.meta_value) >= CURDATE()";

  /* Query first the posts with start dates */
  $init_query1 = "SELECT p.*,date_format(str_to_date(m.meta_value, '%Y%m%d'),'%Y-%m-%d') AS start_date FROM {$wpdb->posts} p, {$wpdb->postmeta} m WHERE p.ID=m.post_id AND p.post_type='".$posttype."' AND m.meta_key='start_date' AND m.meta_value<>'' ORDER BY start_date {$order}";

  /* No Start Date */
  $init_query2 = "SELECT p.*,date_format(str_to_date(m.meta_value, '%Y%m%d'),'') AS start_date FROM {$wpdb->posts} p, {$wpdb->postmeta} m WHERE p.ID=m.post_id AND p.post_type='".$posttype."' AND m.meta_key='start_date' AND m.meta_value='' GROUP BY p.ID ORDER BY p.ID DESC";

  // /* Event Status */
  // $init_query3 = "SELECT p.*, m.meta_value AS eventstatus
  //     FROM {$wpdb->posts} p,{$wpdb->postmeta} m
  //     WHERE p.ID=m.post_id AND p.post_type='".$posttype."' AND p.post_status='publish'
  //     AND m.meta_key='eventstatus' AND m.meta_value<>'active'";

  $entries = array();
  $active_entries = array();
  $non_active = array();
  $res1 = $wpdb->get_results($init_query1);
  $res2 = $wpdb->get_results($init_query2);
  $res_merged = array_merge($res1,$res2); 

  if($res_merged && array_filter($res_merged)) {
    foreach($res_merged as $row) {
      $id = $row->ID;
      $status = get_field("eventstatus",$id);
      $row->eventstatus = $status;
      if($status=='active') {
        $active_entries[] = $row;
      } else {
        $non_active[] = $row;
      }
    }
  }

  $merged_entries = array_merge($active_entries,$non_active);
  if( $merged_entries && array_filter($merged_entries) ) {
    $entries = array_filter($merged_entries);
  }
  
  $final = ($entries) ? $entries : '';
  $total = ($final) ? count($final) : 0;
 
  $records = array();

   if($final) {
      $offset = $offset-1;
      if($offset<=0) {
         $offset = 0;
      }

      $start = $offset;
      $end = $perpage;
      if($offset>0) {
         $start = (($offset+1) * $perpage) - $perpage;
         $end = ($offset+1) * $perpage;
      }
      
      for($i=$start; $i<$end; $i++) {
         if( isset($final[$i]) ) {
            $data = $final[$i];
            $records[] = $data;
         }
      }
   }

   $output['total'] = $total;
   $output['records'] = $records;
   return $output;
}


function get_template_by_id($post_id,$template=null) {
    global $wpdb;
    if($template) {
        $result = $wpdb->get_row( "SELECT p.ID FROM {$wpdb->posts} p, {$wpdb->postmeta} m WHERE p.ID=m.post_id AND m.post_id=".$post_id." AND m.meta_key='_wp_page_template' AND m.meta_value='".$template."'" );
    } else {
        $result = $wpdb->get_row( "SELECT ID FROM $wpdb->posts WHERE ID=".$post_id );
    }
    
    return ($result) ? $result->ID : '';
}

add_action('acf/save_post', 'my_custom_acf_save_post');
function my_custom_acf_save_post( $post_id ) {
    $post_type = get_post_type($post_id);
    if($post_type=='activity_schedule') {
        /* Update slug when event date is changed */
        $event_date = get_field("eventDateSchedule");
        if($event_date) {
            $post_title = date('l, F jS, Y',strtotime($event_date));
            $post_slug = sanitize_title($event_date);
            $my_post = array(
                'ID'            =>  $post_id,
                'post_title'    => $post_title,
                'post_name'     => $post_slug
            );
            wp_update_post( $my_post );
        }
    }
}

/* Shortcode for Company Name */
function contact_shortcode_company_name( $atts ){
  $company = get_field("company_name","option");
  return ($company) ? '<span class="contact-info-company">'.$company.'</span>':'';
}
add_shortcode( 'company', 'contact_shortcode_company_name' );

/* Shortcode for Address */
function contact_shortcode_address( $atts ){
  $a = shortcode_atts( array(
    'icon' => '',
  ), $atts );
  $icon = $a['icon'];
  $address = get_field("address","option");
  if($icon) {
    $address = '<i class="fa fa-map-marker-alt"></i> ' . $address;
  }
  return ($address) ? '<span class="contact-info-address">'.$address.'</span>':'';
}
add_shortcode( 'address', 'contact_shortcode_address' );

/* Shortcode for Phone */
function contact_shortcode_phone( $atts ){
  $a = shortcode_atts( array(
    'icon' => '',
  ), $atts );
  $icon = $a['icon'];
  $phone = get_field("phone","option");
  if($icon) {
    $phone = '<i class="fa fa-phone"></i> <a href="tel:'.format_phone_number($phone).'">' . $phone . '</a>';
  }
  return ($phone) ? '<span class="contact-info-phone">'.$phone.'</span>':'';
}
add_shortcode( 'phone', 'contact_shortcode_phone' );

/* Shortcode for Email */
function contact_shortcode_email( $atts ){
  $a = shortcode_atts( array(
    'icon' => '',
  ), $atts );
  $icon = $a['icon'];
  $email = get_field("email","option");
  if($icon) {
    $email = '<i class="fa fa-envelope"></i> <a href="mailto:'.antispambot($email,1).'">'.antispambot($email).'</a>';
  }
  return ($email) ? '<span class="contact-info-email">'.$email.'</span>':'';
}
add_shortcode( 'email', 'contact_shortcode_email' );


/* Hide Default WP Richtext Editor */
add_action( 'load-page.php', 'hide_tinyeditor_wp' );
function hide_tinyeditor_wp() {
    global $wpdb;
    if( !isset( $_GET['post'] ) )
        return;
    $pages = array();
    $post_id = $_GET['post'];
    $page_option_id = get_site_page_option_id();
    $templates = array('page-food-beverage');
    if($templates) {
        foreach($templates as $filename) {
            $filename .= ".php";
            $id = get_template_by_id($post_id,$filename);
            if($id) {
                $pages[] = $id;
            }
        }
    }

    if( $pages && in_array($post_id, $pages) ) {
        remove_post_type_support('page', 'editor');
    }

    /* Hide other custom field not related to 'Options' */
    if($post_id==$page_option_id) {
        $elementsToHide[] = 'a.page-title-action'; 
        $elementsToHide[] = '.wp-heading-inline'; 
        $elementsToHide[] = '#edit-slug-box'; 
        $elementsToHide[] = '#acf_after_title-sortables'; 
        $elementsToHide[] = '#pageparentdiv';
        $elementsToHide[] = '#postimagediv';
        $elementsToHide[] = '.misc-pub-revisions';
        $elementsToHide[] = '.misc-pub-curtime';
        $elementsToHide[] = '.misc-pub-post-status';
        $elementsToHide[] = '#minor-publishing-actions';
        $elementsToHide[] = '#screen-meta-links';
        $elements = implode(",",$elementsToHide);
        echo '<style>'.$elements.'{display:none!important;}</style>';
        remove_post_type_support('page','editor','thumbnail');
    } 
}


/* Hide Special Pages */
function wpse_hide_special_pages($query) {
    global $typenow;
    $page_option_id = get_site_page_option_id();

    // Only do this for pages
    if ( 'page' == $typenow) {
        // Don't show the special pages (get the IDs of the pages and replace these)
        $query->set( 'post__not_in', array($page_option_id) );
        return;
    }
}
add_action('pre_get_posts', 'wpse_hide_special_pages');


/* ======= ACF OPTIONS PAGE Save Form fixed =======
* This is the temporary fix for ACF Options issue when saving the form.
* Issue: Redirects to 404 when saving
*/
add_action('admin_footer', 'acfOptionFixJS');
function acfOptionFixJS() { 
  $post_id = (isset($_GET['post']) && $_GET['post']) ? $_GET['post'] : 0;
  $page_option_id = get_site_page_option_id();
  if( $page_option_id ) { 
    $post_edit_link = get_admin_url() . "post.php?post=".$page_option_id."&action=edit";
    $options_page_url = get_admin_url() . "admin.php?page=acf-options";
    ?>
    <script type="text/javascript">

    jQuery(document).ready(function($){
      if( $(".toplevel_page_acf-options-global-options").length>0 ) {
        $(".toplevel_page_acf-options-global-options").attr("href","<?php echo $post_edit_link ?>");

        <?php if( $page_option_id==$post_id ) { ?>
        $("li#menu-pages").removeClass("wp-menu-open wp-has-current-submenu");
        $("li#menu-pages a").removeClass("wp-has-current-submenu wp-menu-open");
        $("li#toplevel_page_acf-options-global-options").addClass('current');
        $("li#toplevel_page_acf-options-global-options a").addClass('current');
        <?php } ?>
      }
    });   
    </script>
    <?php
  }
}

function get_site_page_option_id() {
    global $wpdb;
    $query_data = "SELECT ID FROM ".$wpdb->prefix."posts WHERE post_name='acf-site-options' AND post_status='private' AND post_type='page'";
    $result = $wpdb->get_row($query_data);
    return ($result) ? $result->ID : '';
}

function _acf_do_save_post102320( $post_id = 0 ) {
  
  $site_option_post_id = get_site_page_option_id(); /* Get the post ID of "Site Options" page */
  $post_id = (isset($_POST['post_ID']) && $_POST['post_ID']) ? $_POST['post_ID'] : 0;
  if($post_id==$site_option_post_id) {

    if( $_POST['acf'] ) {
      acf_update_values( $_POST['acf'], $site_option_post_id ); /* Saves fields under `Site Options` page */
      acf_update_values( $_POST['acf'], "options" ); /* Saves fields under `Options` page */
    }

  } 

}
add_action( 'acf/save_post', '_acf_do_save_post102320' );

/* ======= end of ACF OPTIONS PAGE Save Form fixed ======= */


function extractURLFromString($string) {
    $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
    if(preg_match($reg_exUrl, $string, $url)) {
        return ($url) ? $url[0] : '';
    } else {
        return '';
    }
}


add_action('wp_ajax_nopriv_posts_load_more', 'posts_load_more');
add_action('wp_ajax_posts_load_more', 'posts_load_more');
function posts_load_more(){
    global $wpdb;
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        $posttype = ($_POST['posttype']) ? $_POST['posttype'] : '';
        $perpage = ($_POST['perpage']) ? $_POST['perpage'] : 6;
        $baseurl = ($_POST['baseurl']) ? $_POST['baseurl'] : '';
        $paged = ($_POST['paged']) ? $_POST['paged'] : 1;
        $content = '';
        $placeholder = THEMEURI . 'images/rectangle.png';
        $imageHelper = THEMEURI . 'images/rectangle-narrow.png';

        $args = array(
            'posts_per_page'   => $perpage,
            'orderby'          => 'date',
            'order'            => 'DESC',
            'post_type'        => $posttype,
            'post_status'      => 'publish',
            'paged'            => $paged
        );

        $blogs = new WP_Query($args);
        ob_start();
        if ( $blogs->have_posts() ) {
            $sec=.1; $i=1; while ( $blogs->have_posts() ) : $blogs->the_post();
            $thumbId = get_post_thumbnail_id(); 
            $featImg = wp_get_attachment_image_src($thumbId,'large');
            $featThumb = wp_get_attachment_image_src($thumbId,'thumbnail');
            $content = get_the_content();
            $title = get_the_title();
            $divclass = (($content || $title) && $featImg) ? 'half':'full';
            $pagelink = get_permalink();
            $divclass .= ($i % 2) ? ' odd':' even';
            $divclass .= ($i==1) ? ' first':'';
            include( get_stylesheet_directory() . '/parts/content-post.php' );
            ?>
            <?php
            $sec =  $sec + .1;
            $i++; endwhile; wp_reset_postdata();
        }

        $content = ob_get_contents();
        ob_end_clean();

        $return['result'] = $content;
        echo json_encode($return);

    } else {
        header("Location: ".$_SERVER["HTTP_REFERER"]);
    }
    die();
}

add_action('wp_ajax_nopriv_ajaxGetPageData', 'ajaxGetPageData');
add_action('wp_ajax_ajaxGetPageData', 'ajaxGetPageData');
function ajaxGetPageData(){
    global $wpdb;
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        $postid = ( isset($_REQUEST['ID']) && $_REQUEST['ID'] ) ? $_REQUEST['ID'] : '';
        $content = array();
        if($postid) {
            if( $post = get_post($postid) ) {
                $full_image = get_field("full_image",$postid);
                $thumbnail = get_field("thumbnail_image",$postid);
                $content['featured_image'] = ($full_image) ? $full_image:'';
                $content['thumbnail_image'] = ($thumbnail) ? $thumbnail:'';
                $content['raw'] = $post;
                $content['post_title'] = $post->post_title; 
                $textcontent = '';
                $postlink = get_permalink($postid) . '?show=contentonly';
                // $arrContextOptions=array(
                //       "ssl"=>array(
                //             "verify_peer"=>false,
                //             "verify_peer_name"=>false,
                //         ),
                //     );  
                // $textcontent = file_get_contents($postlink, false, stream_context_create($arrContextOptions));
                //$content['post_content'] = $textcontent;
                $content['postlink'] = $postlink;
                $content['post_content'] = ($post->post_content) ? apply_filters('the_content', $post->post_content):''; 
            }
        }
        echo json_encode($content);

    } else {
        header("Location: ".$_SERVER["HTTP_REFERER"]);
    }
    die();
}

function fwp_archive_per_page( $query ) {
    if ( is_tax( 'category' ) ) {
        $query->set( 'posts_per_page', 20 );
    }
}
add_filter( 'pre_get_posts', 'fwp_archive_per_page' );


function child_templates($template) {
    global $post;

    if ($post->post_parent) {
        // get top level parent page
        $parent = get_post(
            reset(array_reverse(get_post_ancestors($post->ID)))
        );

        // find the child template based on parent's slug or ID
        $child_template = locate_template(
            [
                'child-' . $parent->post_name . '.php',
                'child-' . $parent->ID . '.php',
                'child.php',
            ]
        );

        if ($child_template) return $child_template;
    }

    return $template;
}
add_filter( 'page_template', 'child_templates' );

function callToActionButtonFunc( $atts ) {
    $a = shortcode_atts( array(
        'id' => '',
    ), $atts );

    $buttons = get_field("call-to-actions");
    $id = $a['id'];
    $output = '';
    if($buttons) {
        $i=1; foreach($buttons as $b) {
            if( $btn = $b['ctabutton'] ) {
                $btnName = $btn['title'];
                $btnLink = $btn['url'];
                $btnTarget = ( isset($btn['target']) && $btn['target'] ) ? $btn['target'] : '_self';
                if($id==$i) {
                    $output .= '<a href="'.$btnLink.'" target="'.$btnTarget.'" class="btn-sm btn-cta"><span>'.$btnName.'</span></a>';
                }
            }
            $i++;
        }
    }

    return $output;
}
add_shortcode( 'call-to-action', 'callToActionButtonFunc' );


add_action('wp_ajax_nopriv_get_faq_group', 'get_faq_group');
add_action('wp_ajax_get_faq_group', 'get_faq_group');
function get_faq_group(){
    global $wpdb;
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        $post_id = ($_POST['post_id']) ? $_POST['post_id'] : '';
        $output = getFaqs($post_id);
        $return['result'] = $output;
        echo json_encode($return);
    } else {
        header("Location: ".$_SERVER["HTTP_REFERER"]);
    }
    die();
}

function getFaqs($post_id) {
    $output = '';
    $questions = get_field("faqs",$post_id);
    ob_start();
    if($questions) { ?>
    <div class="faqsItems">
        <div class="shead-icon text-center">
            <h2 class="stitle"><?php echo get_the_title($post_id); ?></h2>
        </div>
        <div id="faq-<?php echo $post_id?>" class="faq-group">
            <?php $n=1; foreach ($questions as $f) { 
                $question = $f['question'];
                $answer = $f['answer'];
                $isFirst = ($n==1) ? ' first':'';
                if($question && $answer) { ?>
                <div class="faq-item collapsible<?php echo $isFirst ?>">
                    <h3 class="option-name"><?php echo $question ?><span class="arrow"></span></h3>
                    <div class="option-text"><?php echo $answer ?></div>
                </div>
                <?php } ?>

            <?php $n++; } ?>
        </div>
    </div>
    <?php }
    $output = ob_get_contents();
    ob_end_clean(); 
    return $output;
}

/* Remove ACF Fields on specific post */
$postid = ( isset($_GET['post']) && $_GET['post'] ) ? $_GET['post'] : 0;
if ( ($pagenow == 'post.php' && get_post_type($postid) == 'instructions') ||  ($pagenow == 'post-new.php' && $_GET['post_type'] == 'instructions') ) {
    add_action('admin_head', 'ins_custom_admin_css');
    function ins_custom_admin_css() { ?>
    <style type="text/css">
        #instructions-template-tabs,
        #instructions-template-add-toggle{display:none!important;}
        #instructions-template-all.tabs-panel {
            border: none;
        }
    </style>
    <?php
    }
    add_action('admin_footer', 'ins_custom_admin_js');
    function ins_custom_admin_js() { ?>
    <script type="text/javascript">
    jQuery(document).ready(function($){

      /* This will add a category as `Default` */
      if( $('#instructions-templatechecklist li input[type="checkbox"]').length>0 ) {
        var hasChecks = [];

        $('#instructions-templatechecklist li input[type="checkbox"]').on("click",function(){
          if( this.checked ) {
            var opt = $(this).val();
            $('#instructions-templatechecklist li input[type="checkbox"]').each(function(){
              if( $(this).val()==opt ) {
                $(this).prop("checked",true);
              } else {
                $(this).prop("checked",false);
              }
            });
          } else {
            $('#instructions-templatechecklist label').each(function(){
              if( $(this).text().trim()=='Default' ) {
                $(this).find("input").prop("checked",true);
              }
            });
          }
        });

        $('#instructions-templatechecklist input[type="checkbox"]').each(function(){
          if(this.checked) {
            hasChecks.push( $(this).val() );
          }
        });
        if(hasChecks.length>0) {

        } else {
          $('#instructions-templatechecklist label').each(function(){
            if( $(this).text().trim()=='Default' ) {
              $(this).find("input").prop("checked",true);
            }
          });
        }
      }

    });
    </script>
    <?php
    }
}

/* Remove Category Meta Box on Instructions Post type */
// add_action( 'admin_menu' , 'remove_instructions_categories');
// function remove_instructions_categories(){
//     remove_meta_box( 'instructions-templatediv' , 'instructions' , 'side' );
// }


// /* Custom FacetWP - Festival Activities Programming */
// add_filter( 'facetwp_facet_types', function( $facet_types ) {
//     $facet_types['fp_slug'] = new FacetWP_Facet_Festival();
//     return $facet_types;
// });

// class FacetWP_Facet_Festival {
//     function __construct() {
//         $this->label = __( 'Festival Programming', 'fwp' );
//     }
//     /**
//      * Load the available choices
//      */
//     function load_values( $params ) {
//         global $wpdb,$post;
//         $id = ( isset($post->ID) && $post->ID ) ? $post->ID:'';
//         if( empty($id) ) return '';

//         $facet = $params['facet'];
//         $terms_table = $wpdb->prefix . 'terms cat';
//         $from_clause = $wpdb->prefix . 'term_relationships rel';
//         //$where_clause = $params['where_clause'];
//         $where_clause = "object_id=".$id;

//         $limit = ctype_digit( $facet['count'] ) ? $facet['count'] : 10;
//         $from_clause = apply_filters( 'facetwp_facet_from', $from_clause, $facet );
//         $where_clause = apply_filters( 'facetwp_facet_where', $where_clause, $facet );

//         $sql = "SELECT rel.object_id AS post_id, cat.term_id, cat.name, cat.slug FROM $from_clause, $terms_table WHERE rel.term_taxonomy_id=cat.term_id AND $where_clause 
//                 GROUP BY cat.term_id ORDER BY cat.name ASC LIMIT $limit";
//         return $wpdb->get_results( $sql, ARRAY_A );
//     }

//     /**
//      * Generate the output HTML
//      */
//     function render( $params ) {

//         $output = '';
//         $facet = $params['facet'];
//         $values = (array) $params['values'];
//         $selected_values = (array) $params['fp_slug'];

//         $key = 0;
//         foreach ( $values as $key => $result ) {
//             $selected = in_array( $result['slug'], $selected_values ) ? ' checked' : '';
//             $selected .= ( 0 == $result['counter'] && '' == $selected ) ? ' disabled' : '';
//             $output .= '<div class="facetwp-link' . $selected . '" data-value="' . esc_attr( $result['slug'] ) . '">';
//             $output .= esc_html( $result['slug'] );
//             $output .= '</div>';
//         }

//         return $output;
//     }

//     /**
//      * Return array of post IDs matching the selected values
//      * using the wp_facetwp_index table
//      */
//     function filter_posts( $params ) {
//         global $wpdb;
//         $id = ( isset($post->ID) && $post->ID ) ? $post->ID:0;
//         $output = [];
//         $facet = $params['facet'];
//         $selected_values = $params['fp_slug'];

//         $sql = $wpdb->prepare( "SELECT DISTINCT term_id,name,slug
//             FROM {$wpdb->prefix}terms term, {$wpdb->prefix}term_relationships rel';
//             WHERE term.term_id=rel. term.slug = %s AND ",
//             $facet['name']
//         );

//         foreach ( $selected_values as $key => $value ) {
//             $results = facetwp_sql( $sql . " AND facet_value IN ('$value')", $facet );
//             $output = ( $key > 0 ) ? array_intersect( $output, $results ) : $results;

//             if ( empty( $output ) ) {
//                 break;
//             }
//         }

//         return $output;
//     }

// }


function get_festival_programming_filter($currentPostId) {
    global $wpdb;
    if( empty($currentPostId) ) return false;
    $selectedIds = array();
    $taxonomy = 'festival_programming';
    $programming = array();
    $options = array();
    //echo "<pre>";

    $activities = get_field("festival_activities",$currentPostId);
    $post_items = array();
    $postIds = array();
    $selected_activities = array();

    if($activities) {
        foreach ($activities as $a) { 
            $schedules = $a['schedule'];
            $day = $a['day'];
            $daySlug = ($day) ? sanitize_title($day) : '';
            if($schedules) {
                foreach ($schedules as $s) { 
                    $time = $s['time'];
                    $altText = ( isset($s['alt_text']) && $s['alt_text'] ) ? $s['alt_text']:'';
                    $is_pop_up = ( isset($s['popup_info'][0]) && $s['popup_info'][0] ) ? true : false;
                    $act = ( isset($s['activity']) && $s['activity'] ) ? $s['activity']:'';
                    if($act) {
                        $id = $act->ID;
                        $act->schedule = $time;
                        $act->popup_info = $is_pop_up;
                        $act->alt_text = $altText;
                        $selected_activities[$day][] = $act;
                        $postIds[] = $id;
                    }
                }
            }
        }
    }

    if($postIds) {
        foreach($postIds as $id) {
            $query = "SELECT cat.term_id,cat.name,cat.slug,p.ID FROM {$wpdb->prefix}posts p, {$wpdb->prefix}term_relationships rel, {$wpdb->prefix}terms cat, {$wpdb->prefix}term_taxonomy tax
                      WHERE rel.term_taxonomy_id=cat.term_id AND tax.term_id=cat.term_id AND tax.taxonomy='{$taxonomy}' 
                      AND rel.object_id=".$id. " AND p.ID=".$id." ORDER BY cat.name ASC";
            $result = $wpdb->get_row( $query );
            if($result) {
                $termId = $result->term_id;
                $programming[$termId][] = $result;
            }
        }
    }

    if($programming) {
        foreach($programming as $term_id=>$items) {
            $catName = $items[0]->name;
            $posts = array();
            $arg['term_name'] = $catName;
            $arg['term_id'] = $term_id;
            foreach($items as $row) {
                $posts[] = $row->ID;
            }
            $arg['term_posts'] = $posts;
            $options[] = $arg;
        }
    }
    
    // echo "<pre>";
    // print_r($options);
    // echo "</pre>";
    return $options;
}

function getUpcomingEvents($postTypes,$limit=8) {
    global $wpdb;
    $items = array();
    $output = array();
    foreach($postTypes as $type) {
        $query = "SELECT p.ID,p.post_title,p.post_type FROM ".$wpdb->prefix."posts p, ".$wpdb->prefix."postmeta m 
              WHERE p.ID=m.post_id AND m.meta_key='show_on_homepage' AND m.meta_value='yes' AND p.post_type='".$type."' AND p.post_status='publish' ORDER BY p.post_date DESC";
        $result = $wpdb->get_results($query);
        if($result) {
            foreach($result as $row) {
                $postid = $row->ID;
                $start_date = get_field("start_date",$postid);
                $start = ($start_date) ? strtotime($start_date) : $postid . '_nodates';
                $arg['ID'] = $postid;
                $arg['post_title'] = $row->post_title;
                $arg['post_type'] = $row->post_type;
                $arg['start_date_unix'] = $start;
                $arg['start_date'] =($start_date) ? date('m/d/Y',strtotime($start_date)) : '';
                $items[] = $arg;
            }
        }
    }
    if($items) {
        usort($items, function($a, $b) {
            return $a['start_date_unix'] <=> $b['start_date_unix'];
        });

        for($i=0; $i<$limit; $i++) {
            if( isset($items[$i]) && $items[$i] ) {
                $output[] = $items[$i];
            }
        }
    }
    return $output;
}

/* CRON JOB => Change event status automatically if completed */
function myprefix_custom_cron_schedule( $schedules ) {
$schedules['every_twelve_hours'] = array(
        'interval' => 43200, // Every 12 hours
        'display'  => __( 'Every 12 hours' ),
    );
    return $schedules;
}
add_filter( 'cron_schedules', 'myprefix_custom_cron_schedule' );

//Schedule an action if it's not already scheduled
if ( ! wp_next_scheduled( 'myprefix_cron_hook' ) ) {
    wp_schedule_event( time(), 'every_twelve_hours', 'myprefix_cron_hook' );
}

///Hook into that action that'll fire every six hours
add_action( 'myprefix_cron_hook', 'myprefix_cron_function' );

function myprefix_cron_function() {
    global $wpdb;
    $query = "SELECT p.ID, p.post_title, m.meta_value FROM ".$wpdb->prefix."posts p, ".$wpdb->prefix."postmeta m WHERE p.ID=m.post_id AND m.meta_key='start_date' AND p.post_status='publish'";
    $result = $wpdb->get_results($query);
    $datetoday = date('Ymd');
    $now = strtotime($datetoday);
    $updatedPosts = array();
    if($result) {
        foreach($result as $row) {
            $id = $row->ID;
            $start = ($row->meta_value) ? strtotime($row->meta_value) : '';
            $status = get_post_meta($id,"eventstatus","meta_value");
            if($status && $start) {
                if($status=='active') {
                    if($start<$now) {
                        $metaVal = 'completed';
                        update_post_meta($id,"eventstatus",$metaVal);
                        $updatedPosts[] = $id;
                    }
                }
            }
        }
    }
    return $updatedPosts;
}

function get_homepage_id() {
    global $wpdb;
    $query = "SELECT p.ID FROM ".$wpdb->prefix."posts p WHERE  p.post_title='Homepage' AND p.post_status='publish'";
    $result = $wpdb->get_row($query);
    return ($result) ? $result->ID : '';
}


/* Shortcode for Company Name */
function stories_text_shortcode( $atts ){
  $stories_text = get_field("stories_text","option");
  return ($stories_text) ? '<div class="stories-text">'.$stories_text.'</div>':'';
}
add_shortcode( 'stories_text', 'stories_text_shortcode' );

