<?php      
global $csv2post_mpt_arr,$wpdb,$csv2post_options_array,$csv2post_projectslist_array,$csv2post_currentproject_code,$csv2post_nav_type,$csv2post_project_array,$csv2post_is_free,$csv2post_is_dev,$csv2post_textspin_array;
$pageid = 'projects';// used to access variable.php configuration
$pagefolder = 'projects';// the folder in pages folder holding this pages files

// main page header
if($csv2post_is_free){
    $page_title_string = 'Your Project Configuration';    
}else{
    $page_title_string = $csv2post_mpt_arr['menu'][$pageid]['title'] . csv2post_get_current_project_name() . ' (ID: '.csv2post_convertvalue_projectcodefalse_toostring().')';
}

csv2post_header_page($page_title_string,0);
             
// create tab menu for the giving page
csv2post_createmenu($pageid);

// count number of panels, variable used as in code ID to pass to functions, not the TAB number users can see in url
$panel_number = 0;

// set tab number variable, a common use is in form hidden values
$csv2post_tab_number = csv2post_get_tabnumber();

// we can change the navigation type to CSS only, important for debugging javascript bugs
if($csv2post_nav_type == 'css'){ 

    $tab_number = 0;
    if(isset($_GET['tabnumber'])){
        $tab_number = $_GET['tabnumber'];
    }

    // build form action value, will be appended
    $csv2post_form_action = csv2post_link_toadmin('csv2post_yourprojects','&tabnumber=' . $tab_number);
    
    include(WTG_C2P_DIR.'pages/data/csv2post_tab'.$tab_number.'_pagedata.php');

}elseif($csv2post_nav_type == 'jquery'){
    
    // loop through tabs - held in menu pages tabs array
    foreach($csv2post_mpt_arr['menu'][$pageid]['tabs'] as $tab=>$values){
        
        // chekc if tab is to be displayed, if not, we do not add the div for it    
        if(csv2post_menu_should_tab_be_displayed($pageid,$tab)){
            
            // build form action value, will be appended
            $csv2post_form_action = csv2post_link_toadmin($_GET['page'],'#tabs-' . $tab);            

            echo '<div id="tabs-'.$tab.'">';
                      
            // check users permissions for this screen
            if(current_user_can(csv2post_SETTINGS_get_tab_capability($pageid,$tab))){
                
                // display persistent notices for the current screen
                csv2post_persistentnotice_output('screen',$tab,$pageid);                
                // create screen content 
                include($csv2post_mpt_arr['menu'][$pageid]['tabs'][$tab]['path']);   
                 
            }else{
                csv2post_n_incontent('Your Wordpress user account does not have permission to access this screen.','info','Small','No Permission: ');    
            }
            
            echo '</div>';
                     
        }
    } 

}elseif($csv2post_nav_type == 'nonav'){
    
    // loop through tabs - held in menu pages tabs array
    foreach($csv2post_mpt_arr['menu'][$pageid]['tabs'] as $tab=>$values){
        
        // chekc if tab is to be displayed, if not, we do not add the div for it    
        if(csv2post_menu_should_tab_be_displayed($pageid,$tab)){
            
            $csv2post_form_action = csv2post_link_toadmin($_GET['page'],'#tabs-' . $tab);            

            include(WTG_C2P_DIR.'pages/'.$pagefolder.'/csv2post_tab'.$tab.'_page'.$pageid.'.php');
        
        }
    }    
    
} 
      
csv2post_footer(); ?>