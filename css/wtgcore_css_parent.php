<?php
// $side is already set as required parameter
if($side == 'admin' || $c2p_css_side_override == true){

    function csv2post_register_admin_styles() {
        wp_register_style('csv2post_css_notification',plugins_url('csv-2-post/css/notifications.css'), array(), '1.0.0', 'screen');
        wp_register_style('csv2post_css_admin',plugins_url('csv-2-post/css/admin.css'), __FILE__);          
    }

    function csv2post_admin_styles_callback() {
        wp_enqueue_style('csv2post_css_notification');
        wp_enqueue_style('csv2post_css_admin');               
    }

    // print admin only styles (must be preregistered)
    add_action('admin_print_styles','csv2post_admin_styles_callback');
    add_action('init','csv2post_register_admin_styles');
}

// do not make this an else, this is to allow the admin override to be used AND apply public specific lines
if($side == 'public'){
    
}
?>
