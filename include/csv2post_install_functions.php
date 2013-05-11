<?php
/**
* Not to be confused with csv2post_install_core()
* 1. use this to install elements related to the build, not the core
* 2. this function does not belong in wtgcore_wp_install.php which is where csv2post_install_core() is  
*/
function csv2post_install_plugin(){
    
    $overall_install_result = true;
    
    #################################################
    #                                               #
    #                INSTALL ECI ARRAY              #
    #                                               #
    #################################################
    $csv2post_qs_array = array();
    $csv2post_qs_array['arrayupdated'] = time();
    $csv2post_qs_array['nextstep'] = 1;  
    if( !csv2post_option('csv2post_ecisession','add',serialize($csv2post_qs_array)) ){
        // should never happen - csv2post_uninstall() used at the beginning of csv2post_install_core()
        csv2post_notice('Quick Start settings are already installed, no changes were made to those settings.','warning','Tiny',false,'','echo');          
    }else{
        csv2post_notice('Installed the Quick Start settings','success','Tiny',false,'','echo');
    }    
    
    // register custom post types (currently one for post content designs)
    csv2post_install_customposttypes();### MEDIUMPRIORITY, should be moved or contents moved to main file as it only has add_action() ???
    
    // create or confirm content folder for storing main uploads - false means no folder wanted, otherwise a valid path is expected
    if( defined("WTG_C2P_CONTENTFOLDER_DIR")){$overall_install_result = csv2post_install_contentfolder_wpcsvimportercontent(WTG_C2P_CONTENTFOLDER_DIR);}        

    return $overall_install_result;
}

/**
* Call this function to check everything that can be checked.
* Add functions to this function that create notice output only. The idea is that the user
* gets a very descriptive status of the plugin and for troubleshooting we can browse a long list
* of notifications for anything unusual.* 
* 
* @todo complete this function
*/
function csv2post_diagnostic_core(){
    
    # Update the options array with core options and use it to detect the installation status or use existing fuction that does that
    
    ######################################
    #                                    #
    #     CUSTOM PLUGIN DIAGNOSTICS      #
    #                                    #
    ######################################
    csv2post_diagnostic_custom();
    
}

/**
* This diagnostic is specific to the custom plugin i.e. CSV 2 POST or Quick Start.
* 1. Call this function in csv2post_diagnostic_core
*/
function csv2post_diagnostic_custom(){
    
    # Check CSV 2 POST option records, not core options records such as menu or installation status records
    
    # check status of all projects database table, if any missing alert, if any still do not have records alert
    
    # MAYBE query posts not updated since project change 
    
    # MAYBE query posts not updated since thier record was changed (a way to idendify updating not frequent enough)
    
} 

/**
 * NOT IN USE
 * @todo LOWPRIORITY, make this function perform a 100% uninstallation including CSV files, tables, option records the whole lot. This should be offered clearly as a destructive process for anyone who wants to continue using the plugin.
 */
function csv2post_uninstall(){
    $uninstall_outcome = true;

    // delete administration only settings
    delete_option('csv2post_adminset');
    
    // delete public related settings
    delete_option('csv2post_publicset');

    // delete tab navigation array settings
    delete_option('csv2post_tabmenu');

    return $uninstall_outcome;
}  

/**
* Must be called using add_action( 'init', 'csv2post_register_customposttype_contentdesigns' )
* Registers custom post type for content only
* 
* @todo MEDIUMPRIORITY, add installation status check on install status screen for this custom post type using http://codex.wordpress.org/Function_Reference/post_type_exists
*/
function csv2post_register_customposttype_contentdesigns() {
    $labels = array(
        'name' => _x('Content Templates', 'post type general name'),
        'singular_name' => _x('Content Template', 'post type singular name'),
        'add_new' => _x('Create', 'wtgcsvcontent'),
        'add_new_item' => __('Create Content Template'),
        'edit_item' => __('Edit Content Template'),
        'new_item' => __('Create Content Template'),
        'all_items' => __('All Content Templates'),
        'view_item' => __('View Content Template'),
        'search_items' => __('Search Content Templates'),
        'not_found' =>  __('No content templates found'),
        'not_found_in_trash' => __('No content templates found in Trash'), 
        'parent_item_colon' => '',
        'menu_name' => 'Content Templates'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => false,
        'show_ui' => true, 
        'show_in_menu' => true, 
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true, 
        'hierarchical' => false,
        'menu_position' => 20,
        'supports' => array( 'title', 'editor','custom-fields' )
    );   

    register_post_type( 'wtgcsvcontent', $args );
}

/**
* Register custom post type for title templates 
*/
function csv2post_register_customposttype_titledesigns() {
    $labels = array(
        'name' => _x('Title Templates', 'post type general name'),
        'singular_name' => _x('Title Template', 'post type singular name'),
        'add_new' => _x('Create', 'wtgcsvcontent'),
        'add_new_item' => __('Create Title Template'),
        'edit_item' => __('Edit Title Template'),
        'new_item' => __('Create Title Template'),
        'all_items' => __('All Title Templates'),
        'view_item' => __('View Title Template'),
        'search_items' => __('Search Title Templates'),
        'not_found' =>  __('No title templates found'),
        'not_found_in_trash' => __('No title templates found in Trash'), 
        'parent_item_colon' => '',
        'menu_name' => 'Title Templates'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => false,
        'show_ui' => true, 
        'show_in_menu' => true, 
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true, 
        'hierarchical' => false,
        'menu_position' => 20,
        'supports' => array( 'title', 'editor','custom-fields' )
    );   

    register_post_type( 'wtgcsvtitle', $args );
}

/**
* Called in installation process to add_action for custom post types
*/
function csv2post_install_customposttypes(){
    add_action( 'init', 'csv2post_register_customposttype_contentdesigns' );        
}
?>