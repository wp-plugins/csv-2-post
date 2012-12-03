<?php
/**
* Determines if dialogue should be displayed or not for the giving panel when user submits form
* 
* @todo currently only works with global setting and not individual panel configuration 
*/
function csv2post_SETTINGS_form_submit_dialogue($panel_array){
    global $csv2post_adm_set;
    if(isset($csv2post_adm_set['interface']['forms']['dialogue']['status']) && $csv2post_adm_set['interface']['forms']['dialogue']['status'] == 'display' || !isset($csv2post_adm_set['interface']['forms']['dialogue']['status'])){
        return true;
    } 
    return false;       
}
         
/**
* Initiates panel array values, some of which are also values changed by settings within this function and later in panel script
*/
function csv2post_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number){
    $panel_array = array();                             
    $panel_array['panel_name'] = 'defaultpanelnamepleasechange';// slug to act as a name and part of the panel ID 
    $panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
    $panel_array['panel_title'] = __('Default Panel Title Please Change');// user seen panel header text 
    $panel_array['pageid'] = $pageid;// must be set on panels lines
    $panel_array['tabnumber'] = $csv2post_tab_number; 
    $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
    $panel_array['panel_intro'] = __('Default panel introduction please change it');
    $panel_array['panel_help'] = __('Default panel help text please change it');
    $panel_array['help_button'] = csv2post_helpbutton_text(false,false);
    $panel_array['form_button'] = 'Submit';
    return $panel_array;   
}
?>
