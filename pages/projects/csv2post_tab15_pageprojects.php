<?php     
// all variables first
// array indicating themes that have extra support
$csv2post_supported_themes = array();

// count supported themes
$st = 0;

######################################################
#                                                    #
#                        CLASSIPRESS                 #
#                                                    #
######################################################
$csv2post_supported_themes[$st]['name'] = 'ClassiPress';
$csv2post_supported_themes[$st]['supported'] = true;
$csv2post_supported_themes[$st]['filename'] = 'classipress';
// datatypes
$csv2post_supported_themes[$st]['keys']['cp_zipcode']['datatype'] = 'string';
$csv2post_supported_themes[$st]['keys']['cp_street']['datatype'] = 'string';
$csv2post_supported_themes[$st]['keys']['cp_state']['datatype'] = 'string';
$csv2post_supported_themes[$st]['keys']['cp_size']['datatype'] = 'string';
$csv2post_supported_themes[$st]['keys']['cp_region']['datatype'] = 'string'; 
$csv2post_supported_themes[$st]['keys']['cp_price']['datatype'] = 'numeric';
$csv2post_supported_themes[$st]['keys']['cp_feedback']['datatype'] = 'string';
$csv2post_supported_themes[$st]['keys']['cp_country']['datatype'] = 'string';
$csv2post_supported_themes[$st]['keys']['cp_city']['datatype'] = 'string';
$csv2post_supported_themes[$st]['keys']['cp_cell_brand']['datatype'] = 'string';
$csv2post_supported_themes[$st]['keys']['cp_daily_count']['datatype'] = 'numeric';
$csv2post_supported_themes[$st]['keys']['cp_payment_method']['datatype'] = 'string';
$csv2post_supported_themes[$st]['keys']['cp_sys_ad_duration']['datatype'] = 'numeric';
$csv2post_supported_themes[$st]['keys']['cp_sys_feat_price']['datatype'] = 'string';
$csv2post_supported_themes[$st]['keys']['cp_sys_feat_price']['datatype'] = 'string';
$csv2post_supported_themes[$st]['keys']['cp_sys_total_ad_cost']['datatype'] = 'string';
$csv2post_supported_themes[$st]['keys']['cp_total_count']['datatype'] = 'string';
// required
$csv2post_supported_themes[$st]['keys']['cp_zipcode']['required'] = false;
$csv2post_supported_themes[$st]['keys']['cp_street']['required'] = false;
$csv2post_supported_themes[$st]['keys']['cp_state']['required'] = false;
$csv2post_supported_themes[$st]['keys']['cp_size']['required'] = false;
$csv2post_supported_themes[$st]['keys']['cp_region']['required'] = false; 
$csv2post_supported_themes[$st]['keys']['cp_price']['required'] = true;
$csv2post_supported_themes[$st]['keys']['cp_feedback']['required'] = false;
$csv2post_supported_themes[$st]['keys']['cp_country']['required'] = false;
$csv2post_supported_themes[$st]['keys']['cp_city']['required'] = false;
$csv2post_supported_themes[$st]['keys']['cp_cell_brand']['required'] = false;
$csv2post_supported_themes[$st]['keys']['cp_daily_count']['required'] = false;
$csv2post_supported_themes[$st]['keys']['cp_payment_method']['required'] = false;
$csv2post_supported_themes[$st]['keys']['cp_sys_ad_duration']['required'] = false;
$csv2post_supported_themes[$st]['keys']['cp_sys_feat_price']['required'] = false;
$csv2post_supported_themes[$st]['keys']['cp_sys_feat_price']['required'] = false;
$csv2post_supported_themes[$st]['keys']['cp_sys_total_ad_cost']['required'] = false;
$csv2post_supported_themes[$st]['keys']['cp_total_count']['required'] = false;


// get then display current theme
$blogtheme = get_current_theme();
echo csv2post_notice($blogtheme,'success','Small','Theme Detected: ','','return');

// does plugin provide extra/easier support for the active theme?
$theme_support_extra = false;
foreach($csv2post_supported_themes as $key => $theme){
    if(isset($theme['name']) && $theme['name'] == $blogtheme){
        $theme_support_extra = true;
        $theme_key = $key;    
    }    
}

if(!$theme_support_extra){
    echo csv2post_notice('CSV 2 POST works with any theme in the standard way most plugins do. This page offers 
    extra support for known
    themes i.e. it knows what custom field keys are required and the data requirement for each
    custom field value. Your Wordpress theme does not currently have extra support on this page. Let us know
    if you would like our plugin to support your theme even more so that it is a little easier to configure.',
    'info','Large','Standard Theme Support','','return');
    return;
}?>

<?php 
// if not free edition include panel file for the theme
if(!$csv2post_is_free){
    require_once( WTG_C2P_PANELFOLDER_PATH . 'themesupport/'.$csv2post_supported_themes[$theme_key]['filename'].'.php');
}
?>

<?php 
### TODO:MEDIUMPRIORITY, for premium edition, add form and menus for quickly setting up all required custom fields (will be basic custom field rules)
### TODO:LOWPRIORITY, for premium edition, create admin setting to display example data in the notifications
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'postcustomfieldschecklist';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Post Custom Fields Checklist');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('A checklist for '.$csv2post_supported_themes[$theme_key]['name'].' post custom field configuration');
$panel_array['panel_help'] = __('This panel compares your themes custom field keys against those
setup in your project on the Custom Field screen. Overall it gives an indication if your project 
is ready to create posts that will meet your themes needs. You should refer to the '.$csv2post_supported_themes[$theme_key]['name'].' 
documentation for more information on your themes requirements. It is important to understand the terms "post meta"
and "custom fields".');
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);?>
<?php csv2post_panel_header( $panel_array );?>

    <?php
    foreach($csv2post_supported_themes[$theme_key]['keys'] as $cfkey => $field){
        
        // change switch if user has $cfkey setup in project
        $cfset = false;
        
        // is the $cfkey part of projects basic post custom fields?
        if(isset($csv2post_project_array['custom_fields']['basic'])){
            foreach($csv2post_project_array['custom_fields']['basic'] as $key => $meta){
                if(isset($meta['meta_key']) && $meta['meta_key'] == $cfkey){
                    $cfset = true;
                }   
            }    
        }
        
        // is the $cfkey part of projects advanced post custom fields?
        if(isset($csv2post_project_array['custom_fields']['advanced'])){
            foreach($csv2post_project_array['custom_fields']['basic'] as $key => $meta){
                if(isset($meta['meta_key']) && $meta['meta_key'] == $cfkey){
                    $cfset = true;
                }   
            }     
        }       
        
        // display status for current custom field key ($cfkey)
        if($cfset){
            echo csv2post_notice($cfkey . ': Ready','success','Tiny','Set and ready','','return');
        }else{
            if($field['required']){
                echo csv2post_notice($cfkey . ': Not Setup - Required','error','Tiny','Set and ready','','return');
            }else{
                echo csv2post_notice($cfkey . ': Not Setup - Optional','warning','Tiny','Set and ready','','return');
            }
        } 
    }
    ?>

<?php csv2post_panel_footer();?>
