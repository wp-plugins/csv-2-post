<?php
/** 
 * Public functions for CSV 2 POST by WebTechGlobal.co.uk
 * 
 * Widgets, theme enhancements etc
 * 
 * @package CSV 2 POST
 * 
 * @author Ryan Bayne | ryan@webtechglobal.co.uk
 */

/**
* Sidebar widget for displaying information about the current CSV 2 POST created post and button to force an update on it.
*
* @package CSV 2 POST
* @since 7.0.4  
*/
function csv2post_widget_webmasterinfo_display($args) {
    global $current_user;
    
    // process returns reasons
    if(!isset($current_user->ID)){return;}
    if(!user_can($current_user->ID,'activate_plugins')){return false;}    
    if(!isset($GLOBALS['post']->ID)){return;}
    
    // get post values
    $project_code = get_post_meta( $GLOBALS['post']->ID, 'csv2post_project_code', true );
    if(!$project_code || empty($project_code)){return;}
    $recordid = get_post_meta( $GLOBALS['post']->ID, 'csv2post_record_id', true );
    if(!$recordid || empty($recordid)){$recordid = '';}
    $lastupdate = get_post_meta( $GLOBALS['post']->ID, 'csv2post_last_update', true );
    if(!$lastupdate || empty($lastupdate)){$lastupdate = '';}    
    $templateid = get_post_meta( $GLOBALS['post']->ID, 'csv2post_template', true );
    if(!$templateid || empty($templateid)){$templateid = '';}   
    $outdated = get_post_meta( $GLOBALS['post']->ID, 'csv2post_outdated', true );
    if(!$outdated || empty($outdated)){$outdated = '';}     
    
    extract($args);
    echo $before_widget;
    echo $before_title . 'CSV 2 POST Post Info' . $after_title;

    echo '<strong>Post ID:</strong><br> ' . $GLOBALS['post']->ID;
    echo '<br><br>';
    echo '<strong>Project ID:</strong><br> ' . $project_code;
    echo '<br><br>';
    echo '<strong>Imported Row ID:</strong><br> ' . $project_code;
    echo '<br><br>';
    echo '<strong>Post Modified (wp):</strong><br> ' . $GLOBALS['post']->post_modified;
    echo '<br><br>';
    echo '<strong>Last Update (csv2post):</strong><br> ' . $lastupdate;
    echo '<br><br>';
    echo '<strong>Template ID:</strong><br> 34' . $templateid;
    echo '<br><br>';

    if($outdated == 'yes'){
        global $csv2post_is_free;
        if($csv2post_is_free){
            echo '<p>This post is outdated. <a href="http://www.webtechglobal.co.uk/csv-2-post/">Premium edition</a> allows automatic and manual post updating to make your job easier!</p>';            
        }else{
            echo '<p>This post is outdated. You can configure updating to update more frequently or run manual updating now.</p>';
        }
    }
      
    echo '<a href="http://www.webtechglobal.co.uk/wordpress/csv-2-post-webmaster-tools-widget-wordpress/" target="_blank">About CSV 2 POST Webmaster Tool</a>';
    
    echo $after_widget;
}

wp_register_sidebar_widget(
    'csv2post_widget_webmasterinfo',     
    'CSV 2 POST Post Info',        
    'csv2post_widget_webmasterinfo_display', 
    array(  
        'description' => 'Shows for administrators only'
    )
);
?>