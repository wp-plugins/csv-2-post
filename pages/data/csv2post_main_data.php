<?php              
global $csv2post_file_profiles,$csv2post_mpt_arr,$wpdb,$csv2post_options_array,$csv2post_nav_type,$csv2post_is_free,$csv2post_job_array,$csv2post_is_dev,$csv2post_dataimportjobs_array,$csv2post_jobtable_array;
$pageid = 'data';// used to access variable.php configuration
$pagefolder = 'data';// the folder in pages folder holding this pages files

csv2post_header_page($csv2post_mpt_arr['menu'][$pageid]['title'],0);
 
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
    $csv2post_form_action = csv2post_link_toadmin('csv2post_yourdata','&tabnumber=' . $tab_number);

    include(WTG_C2P_DIR.'pages/data/csv2post_tab'.$tab_number.'_pagedata.php');

}elseif($csv2post_nav_type == 'jquery'){
    
    // loop through tabs - held in menu pages tabs array
    foreach($csv2post_mpt_arr['menu'][$pageid]['tabs'] as $tab=>$values){
        
        // check if tab is to be displayed, if not, we do not add the div for it    
        if(csv2post_menu_should_tab_be_displayed($pageid,$tab)){
      
            // build form action value, will be appended            
            $csv2post_form_action = '';
            
            echo '<div id="tabs-'.$tab.'">';
            
            // check users permissions for this screen
            if(current_user_can(csv2post_WP_SETTINGS_get_tab_capability($pageid,$tab))){
                
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
