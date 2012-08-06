<?php
// $side is already set as required parameter
if($side == 'admin'){

    // register our jquery style
    
    /**
    * Applicable themes stated with $csv2post_theme_array, defined in csv2post_variables_admin.php
    */   
    
    /**
    * Registers all administration area CSS sources 
    */
    function csv2post_register_admin_styles() {
        global $csv2post_jqueryuitheme;
        
        // now load jquery styles and addons etc
        wp_deregister_style(WTG_C2P_ABB . 'jquery_styles');
        wp_register_style(WTG_C2P_ABB . 'jquery_styles',plugins_url(WTG_C2P_FOLDERNAME.'/templatesystem/css/jquerythemes/'.$csv2post_jqueryuitheme.'/jquery-ui-1.8.17.custom.css'), array(), '1.0.0', 'screen');
        wp_register_style(WTG_C2P_ABB . 'css_notification',plugins_url(WTG_C2P_FOLDERNAME.'/templatesystem/css/notifications.css'), array(), '1.0.0', 'screen');

        // load the plugins own styles
        wp_register_style(WTG_C2P_ABB . 'css_admin',plugins_url(WTG_C2P_FOLDERNAME.'/templatesystem/css/admin.css'), __FILE__);
        wp_register_style(WTG_C2P_ABB . 'css_global',plugins_url(WTG_C2P_FOLDERNAME.'/templatesystem/css/global.css'), __FILE__);

        // multiselect (checkbox menus)
        wp_register_style(WTG_C2P_ABB . 'css_jquerymultiselect',plugins_url(WTG_C2P_FOLDERNAME.'/templatesystem/script/multiselect/jquery.multiselect.css'), __FILE__);   
        
        wp_register_style(WTG_C2P_ABB . 'css_jquerymultiselect_prettify',plugins_url(WTG_C2P_FOLDERNAME.'/templatesystem/script/multiselect/assets/prettify.css'), __FILE__);
        wp_register_style(WTG_C2P_ABB . 'css_jquerymultiselect_filter',plugins_url(WTG_C2P_FOLDERNAME.'/templatesystem/script/multiselect/jquery.multiselect.filter.css'), __FILE__);

        // multi-select (not the same as multiselect, these are lists)
        wp_register_style(WTG_C2P_ABB . 'css_jquerymulti-select',plugins_url(WTG_C2P_FOLDERNAME.'/templatesystem/css/jquery.multi-select.css'), __FILE__);

        // file uploader @ http://pixelcone.com/fileuploader/demo/
        wp_register_style(WTG_C2P_ABB . 'css_fileuploader',plugins_url(WTG_C2P_FOLDERNAME.'/templatesystem/css/fileuploader.css'), __FILE__);                
    }

    add_action('init','csv2post_register_admin_styles');

    // print admin only styles (must be preregistered)
    add_action('admin_print_styles','csv2post_styles_callback');
    
    function csv2post_styles_callback() {
        // jQuery UI Styling
        wp_enqueue_style('csv2post_jquery_styles');
        // notifications
        wp_enqueue_style('csv2post_css_notification');
        // plugins own style sheets
        wp_enqueue_style('csv2post_css_admin');
        wp_enqueue_style('csv2post_css_global');

        // multiselect (checkbox menus)
        wp_enqueue_style('csv2post_css_jquerymultiselect');
        wp_enqueue_style('csv2post_css_jquerymultiselect_asset');
        wp_enqueue_style('csv2post_css_jquerymultiselect_prettify');

        // multi-select (not the same as multiselect, these are lists)
        wp_enqueue_style('csv2post_css_jquerymulti-select');

        // accordian
        wp_enqueue_style('csv2post_css_jqueryaccordion');
        
        // file uploader @ file uploader @ http://pixelcone.com/fileuploader/demo/
        wp_enqueue_style('csv2post_css_fileuploader');                     
    }
    
}
?>