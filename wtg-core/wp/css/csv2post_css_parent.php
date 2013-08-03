<?php
// $side is already set as required parameter
if($side == 'admin' || $csv2post_css_side_override == true){

    /*
    * Do csv2post_css('admin',true); to run the admin lines but also trigger use of them on public side
    * Do csv2post_css('public',true); to use both public and admin lines, must ensure there is no double uses
    */

    // register our jquery style

    /**
    * @todo move this function to an appropriate function file and move add_action to the main file
    */
    
    function csv2post_register_admin_styles() {                                                          
        wp_register_style('csv2post_css_notification',plugins_url(WTG_C2P_FOLDERNAME.'/wtg-core/wp/css/notifications.css'), array(), '1.0.0', 'screen');
        wp_register_style('csv2post_css_admin',plugins_url(WTG_C2P_FOLDERNAME.'/wtg-core/wp/css/admin.css'), __FILE__);
        wp_register_style('csv2post_css_global',plugins_url(WTG_C2P_FOLDERNAME.'/wtg-core/wp/css/global.css'), __FILE__);         
    }

    function csv2post_admin_styles_callback() {
        wp_enqueue_style('csv2post_css_notification');
        wp_enqueue_style('csv2post_css_admin');
        wp_enqueue_style('csv2post_css_global');                  
    }

    // print admin only styles (must be preregistered)
    add_action('admin_print_styles','csv2post_admin_styles_callback');
    add_action('init','csv2post_register_admin_styles');
}

// do not make this an else, this is to allow the admin override to be used AND apply public specific lines
if($side == 'public'){
    
}
?>
