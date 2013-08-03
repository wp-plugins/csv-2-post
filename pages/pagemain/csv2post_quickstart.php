<?php       
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'ecireset';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Reset Quick Start');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique 
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);
$jsform_set['dialogbox_title'] = 'Reset Quick Start'; 
$jsform_set['noticebox_content'] = 'Doing this will not deleted Data Import Jobs, Post Creation Projects or any posts created already but it will reset progress made on this screen. Do you wish to continue?';

// begin form and add hidden values
csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');
csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
?>

<?php csv2post_formend_standard('Reset Quick Start Steps',$jsform_set['form_id']);?>

<?php  
// get eci array, if not installed we display an introduction plus activation button
// Quick Start Array (tracks progress)
$csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray();

if(!$csv2post_ecisession_array || !is_array($csv2post_ecisession_array)){
    csv2post_n_incontent('Required settings for the Quick Start to work have not been installed. 
    Please perform a re-install of the plugin on the Install screen or contact the plugin author
    for help and advice. This issue should not happen, we would like to hear from you.','warning','Large','No Quick Start Settings');
    return;
}
       
####################################
#                                  #
#        18. CREATE POSTS          #
#                                  #
####################################
if($csv2post_ecisession_array['nextstep'] >= 18){
    if($csv2post_is_free){
        require(WTG_C2P_PANELFOLDER_PATH . 'quickstart/csv2post_panel_eci_18.php');
    }else{
        require(WTG_C2P_DIR . 'fulledition/panels/quickstart/csv2post_panel_eci_18.php');
    }    
}

####################################
#                                  #
#        17. POST TYPE             #
#                                  #
####################################
if($csv2post_ecisession_array['nextstep'] >= 17){
    if($csv2post_is_free){
        require(WTG_C2P_PANELFOLDER_PATH . 'quickstart/csv2post_panel_eci_17.php');
    }else{
        require(WTG_C2P_DIR . 'fulledition/panels/quickstart/csv2post_panel_eci_17.php');
    }    
}

####################################
#                                  #
#     16. EXTRA THEME SUPPORT      #
#            PAID ONLY             #
####################################
if($csv2post_ecisession_array['nextstep'] >= 16){
    if($csv2post_is_free){
        require(WTG_C2P_PANELFOLDER_PATH . 'quickstart/csv2post_panel_eci_16.php');
    }else{
        require(WTG_C2P_DIR . 'fulledition/panels/quickstart/csv2post_panel_eci_16.php');
    }    
}

####################################
#                                  #
#           15. AUTHORS            #
#                                  #
####################################
if($csv2post_ecisession_array['nextstep'] >= 15){
    if($csv2post_is_free){
        require(WTG_C2P_PANELFOLDER_PATH . 'quickstart/csv2post_panel_eci_15.php');
    }else{
        require(WTG_C2P_DIR . 'fulledition/panels/quickstart/csv2post_panel_eci_15.php');
    }    
}

####################################
#                                  #
#      14. TEXT SPINNING           #
#          PAID ONLY               #
####################################
if($csv2post_ecisession_array['nextstep'] >= 14){
    if($csv2post_is_free){
        require(WTG_C2P_PANELFOLDER_PATH . 'quickstart/csv2post_panel_eci_14.php');
    }else{
        require(WTG_C2P_DIR . 'fulledition/panels/quickstart/csv2post_panel_eci_14.php');
    }    
}

####################################
#                                  #
#            13. TAGS              #
#                                  #
####################################
if($csv2post_ecisession_array['nextstep'] >= 13){
    if($csv2post_is_free){
        require(WTG_C2P_PANELFOLDER_PATH . 'quickstart/csv2post_panel_eci_13.php');
    }else{
        require(WTG_C2P_DIR . 'fulledition/panels/quickstart/csv2post_panel_eci_13.php');
    }  
}

####################################
#                                  #
#            12. IMAGES            #
#                                  #
####################################
if($csv2post_ecisession_array['nextstep'] >= 12){
    if($csv2post_is_free){
        require(WTG_C2P_PANELFOLDER_PATH . 'quickstart/csv2post_panel_eci_12.php');
    }else{
        require(WTG_C2P_DIR . 'fulledition/panels/quickstart/csv2post_panel_eci_12.php');
    }    
}

####################################
#                                  #
#        11. UPDATE OPTIONS        #
#            PAID ONLY             #
####################################
if($csv2post_ecisession_array['nextstep'] >= 11){
    if($csv2post_is_free){
        require(WTG_C2P_PANELFOLDER_PATH . 'quickstart/csv2post_panel_eci_11.php');
    }else{
        require(WTG_C2P_DIR . 'fulledition/panels/quickstart/csv2post_panel_eci_11.php');
    }    
}

####################################
#                                  #
#        10. CATEGORIES            #
#                                  #
####################################
if($csv2post_ecisession_array['nextstep'] >= 10){
    if($csv2post_is_free){
        require(WTG_C2P_PANELFOLDER_PATH . 'quickstart/csv2post_panel_eci_10.php');
    }else{
        require(WTG_C2P_DIR . 'fulledition/panels/quickstart/csv2post_panel_eci_10.php');
    }    
} 

####################################
#                                  #
#        9. CUSTOM FIELDS          #
#                                  #
####################################
if($csv2post_ecisession_array['nextstep'] >= 8){
    if($csv2post_is_free){
        require(WTG_C2P_PANELFOLDER_PATH . 'quickstart/csv2post_panel_eci_9.php');
    }else{
        require(WTG_C2P_DIR . 'fulledition/panels/quickstart/csv2post_panel_eci_9.php');
    }    
}

/*  
####################################
#                                  #
#          8. POST DATES           #
#                                  #
####################################
if($csv2post_ecisession_array['nextstep'] >= 8){
    if($csv2post_is_free){
        require(WTG_C2P_PANELFOLDER_PATH . 'quickstart/csv2post_panel_eci_8.php');
    }else{
        require(WTG_C2P_DIR . 'fulledition/panels/quickstart/csv2post_panel_eci_8.php');
    }    
}
*/

####################################
#                                  #
#        7. POST STATUS            #
#                                  #
####################################
if($csv2post_ecisession_array['nextstep'] >= 7){
    if($csv2post_is_free){
        require(WTG_C2P_PANELFOLDER_PATH . 'quickstart/csv2post_panel_eci_7.php');
    }else{
        require(WTG_C2P_DIR . 'fulledition/panels/quickstart/csv2post_panel_eci_7.php');
    }    
}

####################################
#                                  #
#              6. SEO              #
#            PAID ONLY             #
####################################
if($csv2post_ecisession_array['nextstep'] >= 6){
    if($csv2post_is_free){
        require(WTG_C2P_PANELFOLDER_PATH . 'quickstart/csv2post_panel_eci_6.php');
    }else{
        require(WTG_C2P_DIR . 'fulledition/panels/quickstart/csv2post_panel_eci_6.php');
    }    
}
        
####################################
#                                  #
#     5. SELECT TITLE TEMPLATE     #
#                                  #
####################################
if($csv2post_ecisession_array['nextstep'] >= 5){           
    if($csv2post_is_free){
        // select premade title
        require(WTG_C2P_PANELFOLDER_PATH . 'quickstart/csv2post_panel_eci_5.php');
    }else{
        // build a title by selecting columns with ability to insert values between them (still no tokens)
        require(WTG_C2P_DIR . 'fulledition/panels/quickstart/csv2post_panel_eci_5.php');
    }    
}

####################################
#                                  #
#         4. SETUP CONTENT         #
#                                  #
####################################
if($csv2post_ecisession_array['nextstep'] >= 4){
    if($csv2post_is_free){
        // user pairs columns to a list of default tokens and selects from a small list of hardcoded templates that use those tokens
        require(WTG_C2P_PANELFOLDER_PATH . 'quickstart/csv2post_panel_eci_4.php');
    }else{
        // user can select a custom design, display instructions on creating one, or they can do as done in free edition
        require(WTG_C2P_DIR . 'fulledition/panels/quickstart/csv2post_panel_eci_4.php');
    }    
}

####################################
#                                  #
#         3. IMPORT DATA           #
#                                  #
####################################
if($csv2post_ecisession_array['nextstep'] >= 3){                                               
    if($csv2post_is_free){
        require(WTG_C2P_PANELFOLDER_PATH . 'quickstart/csv2post_panel_eci_3.php');
    }else{
        require(WTG_C2P_DIR . 'fulledition/panels/quickstart/csv2post_panel_eci_3.php');
    }    
}
                    
####################################
#                                  #
#     2. USER CONFIRMS FORMAT      #
#                                  #
####################################
if($csv2post_ecisession_array['nextstep'] >= 2){                                               
    if($csv2post_is_free){
        require(WTG_C2P_PANELFOLDER_PATH . 'quickstart/csv2post_panel_eci_2.php');
    }else{
        require(WTG_C2P_DIR . 'fulledition/panels/quickstart/csv2post_panel_eci_2.php');
    }    
}
    
####################################
#                                  #
#      1. UPLOAD CSV FILE          #
#                                  #
####################################                                                                                         
if($csv2post_ecisession_array['nextstep'] >= 1){                                               
    if($csv2post_is_free){
        require(WTG_C2P_PANELFOLDER_PATH . 'quickstart/csv2post_panel_eci_1.php');
    }else{
        require(WTG_C2P_DIR . 'fulledition/panels/quickstart/csv2post_panel_eci_1.php');
    }    
}
?>