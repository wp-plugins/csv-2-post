<?php     
// all variables first
// array indicating themes that have extra support
$csv2post_supported_themes = array();

// count supported themes
$st = 0;

######################################################
#                                                    #
#               THEME SUPPORT ARRAY                  #
#    used in features to provide extra support       #
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
echo csv2post_notice($blogtheme,'success','Tiny','Theme Detected: ','','return');

// does plugin provide extra/easier support for the active theme?
$theme_support_extra = false;
foreach($csv2post_supported_themes as $key => $theme){
    if(isset($theme['name']) && $theme['name'] == $blogtheme){
        $theme_support_extra = true;
        $theme_key = $key;    
    }    
}

if(!$theme_support_extra){
    echo csv2post_notice('CSV 2 POST works with any theme, usually all we need to setup is
    custom fields even for the best premium themes. However we try to provide extra theme
    support on this screen when possible.','info','Tiny','Standard Theme Support','','return');
}?>

<?php 
// if not free edition include panel file for the theme
if(!$csv2post_is_free && $theme_support_extra){
    require_once( WTG_C2P_PANELFOLDER_PATH . 'themesupport/'.$csv2post_supported_themes[$theme_key]['filename'].'.php');
}
?>

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
if(!$csv2post_is_free){$panel_array['panel_name'] = 'postformatpaid';}else{$panel_array['panel_name'] = 'postformatfree';} 
$panel_array['panel_title'] = __('Post Format');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['dialogdisplay'] = 'no';
// <form> values, seperate from panel value
$jsform_set_override = array();### TODO:LOWPRIORITY, we can remove these lines and add array() to the functions parameter
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
?>

<?php csv2post_panel_header( $panel_array );?>

    <?php 
    if ( current_theme_supports( 'post-formats' ) ) {
        
        // begin form and add hidden values
        csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
        csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);?>
        
            <h4>Default Post Format</h4>
            <p>Set a default post format, allowing us to apply the same format to all posts...</p>
            <script>
            $(function() {
                $( "#csv2post_eci_postformat_radios" ).buttonset();
            });
            </script>

            <div id="csv2post_eci_postformat_radios">
                <?php         
                $post_formats = get_theme_support( 'post-formats' );
                if ( is_array( $post_formats[0] ) ) {
                    
                    foreach($post_formats[0] as $key => $format){

                        if(isset($csv2post_project_array['postformat']['default']) && $csv2post_project_array['postformat']['default'] == $format){
                            $statuschecked = 'checked="checked"';
                        }else{
                            $statuschecked = '';
                        }
                                                            
                        echo '<input type="radio" id="csv2post_radio'.$format.'_postformat_objectid_'.$panel_number.'" name="csv2post_radio_postformat" value="'.$format.'" '.$statuschecked.' />
                        <label for="csv2post_radio'.$format.'_postformat_objectid_'.$panel_number.'">'.$format.'</label>';
                        
                        if($csv2post_guitheme != 'jquery'){echo '<br>';}                                 
                    }
                    
                    if($statuschecked == ''){$statuschecked = 'checked="checked"';}
                    
                    echo '<input type="radio" id="csv2post_radiostandard_postformat_objectid_'.$panel_number.'" name="csv2post_radio_postformat" value="standard" '.$statuschecked.' />
                    <label for="csv2post_radiostandard_postformat_objectid_'.$panel_number.'">standard (default)</label>';               
                        
                }?>
            </div>
            
            <?php 
            if(!$csv2post_is_free){?>
            <h4>Post Format Data Column</h4> 
            <p>If you have a column of data with post formats you can select it here...</p>
            <select name="csv2post_postformat_tablecolumn" class="csv2post_multiselect_menu">
                <option value="notselected">Not Required</option>    
                <?php 
                if(isset($csv2post_project_array['postformat']['title_table']) && isset($csv2post_project_array['postformat']['title_column'])){
                    csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code,$csv2post_project_array['postformat']['title_table'],$csv2post_project_array['postformat']['title_column']);        
                }else{
                    csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code);
                }?>                                                                                                                     
            </select><br>
            <?php }?>
         
        <?php               
        // add js for dialog on form submission and the dialog <div> itself
        if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
            csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
            csv2post_jquery_form_prompt($jsform_set);
        } 
        ?>
            
        <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>   

    <?php 
    }else{
        csv2post_n_incontent('Your theme does not support Post Formats.','info','Small','Theme Checked');    
    }

csv2post_panel_footer();?>

<?php 
/*
### TODO:MEDIUMPRIORITY, warn user about custom fields required and not setup
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'postcustomfieldschecklist';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Post Custom Fields Checklist');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('This panel compares your themes custom field keys against those
setup in your project on the Custom Field screen. Overall it gives an indication if your project 
is ready to create posts that will meet your themes needs. You should refer to the '.$csv2post_supported_themes[$theme_key]['name'].' 
documentation for more information on your themes requirements. It is important to understand the terms "post meta"
and "custom fields".');?>
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

<?php csv2post_panel_footer();*/
?>
