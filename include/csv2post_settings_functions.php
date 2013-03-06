<?php
/**
* Determines if dialog should be displayed or not for the giving panel when user submits form
* 
* @todo currently only works with global setting and not individual panel configuration 
*/
function csv2post_WP_SETTINGS_form_submit_dialog($panel_array){
    
    global $csv2post_guitheme,$csv2post_adm_set;

    if($csv2post_guitheme != 'jquery'){
        return false;
    }
    
    // coded ['dialoguedisplay'] over-rides users settings to hide all dialog to ensure critical actions are always giving attention
    // i.e. Re-Install Database Tables panel
    if(isset($panel_array['dialogdisplay'])){ 
        if($panel_array['dialogdisplay'] == 'yes'){ 
            return true;
        }
        
        // changing to boolean 4th March 2013    
        if($panel_array['dialogdisplay'] == true){ 
            return true;
        }          
    }
   
    if(isset($csv2post_adm_set['interface']['forms']['dialog']['status']) && $csv2post_adm_set['interface']['forms']['dialog']['status'] == 'display' || !isset($csv2post_adm_set['interface']['forms']['dialog']['status'])){
        return true;
    } 
    
    return false;       
}

/**
* Decides a tab screens required capability in order for dashboard visitor to view it
* 
* @param mixed $page_name the array key for pages
* @param mixed $tab_key the array key for tabs within a page
*/
function csv2post_WP_SETTINGS_get_tab_capability($page_name,$tab_key,$default = false){
    global $csv2post_mpt_arr;
    $codedefault = 'activate_plugins';
    if(isset($csv2post_mpt_arr['menu'][$page_name]['tabs'][$tab_key]['permissions']['customcapability']) && !$default){
        return $csv2post_mpt_arr['menu'][$page_name]['tabs'][$tab_key]['permissions']['customcapability'];    
    }else{ 
        if(isset($csv2post_mpt_arr['menu'][$page_name]['tabs'][$tab_key]['permissions']['defaultcapability'])){
            return $csv2post_mpt_arr['menu'][$page_name]['tabs'][$tab_key]['permissions']['defaultcapability'];    
        }else{
            return $codedefault;    
        }                    
    }
    return $codedefault;   
}

function csv2post_WP_SETTINGS_get_page_capability($page_name,$default = false){
    global $csv2post_mpt_arr;
    $thisdefault = 'update_core';
    if(!isset($csv2post_mpt_arr['menu'][$page_name]['permissions']['customcapability']) || $default == true){
        if(!isset($csv2post_mpt_arr['menu'][$page_name]['permissions']['defaultcapability'])){
            return $thisdefault;    
        }else{
            return $csv2post_mpt_arr['menu'][$page_name]['permissions']['defaultcapability'];    
        }
    }else{
        return $csv2post_mpt_arr['menu'][$page_name]['permissions']['customcapability'];  
    }
    return $thisdefault;   
}

function csv2post_WP_SETTINGS_get_eciarray(){
    return maybe_unserialize(csv2post_option('csv2post_ecisession','get'));
}

function csv2post_WP_SETTINGS_get_version(){
    return get_option('csv2post_installedversion');    
}
         
/**
* Initiates panel array values, some of which are also values changed by settings within this function and later in panel script
*/
function csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number){
    $panel_array = array();                             
    $panel_array['panel_name'] = 'defaultpanelnamepleasechange';// slug to act as a name and part of the panel ID 
    $panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
    $panel_array['panel_title'] = __('Default Panel Title Please Change');// user seen panel header text 
    $panel_array['pageid'] = $pageid;// must be set on panels lines
    $panel_array['tabnumber'] = $csv2post_tab_number; 
    $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
    $panel_array['panel_help'] = false;// default of false causes Info button to be hidden
    $panel_array['form_button'] = 'Submit';
    $panel_array['dialogdisplay'] = false; // yes or no - this value when used over-rides the global setting for hiding all dialogue
    return $panel_array;   
}
?>
