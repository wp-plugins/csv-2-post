<?php      
global $csv2post_file_profiles,$csv2post_mpt_arr,$wpdb,$csv2post_options_array,$csv2post_nav_type,$csv2post_is_free,$csv2post_job_array,$csv2post_is_dev,$csv2post_dataimportjobs_array,$csv2post_jobtable_array;
$pageid = 'data';// used to access variable.php configuration
$pagefolder = 'data';// the folder in pages folder holding this pages files

// main page header
if(!csv2post_get_option_currentjobcode()){$id_string = '';}else{$id_string = ' (ID: '.csv2post_get_option_currentjobcode().')';}
csv2post_header_page($csv2post_mpt_arr[$pageid]['title'] . csv2post_get_current_job_name() . $id_string,0);
 
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
    foreach($csv2post_mpt_arr[$pageid]['tabs'] as $tab=>$values){
        
        // check if tab is to be displayed, if not, we do not add the div for it    
        if($csv2post_mpt_arr[ $pageid ]['tabs'][ $tab ]['display'] == true && $csv2post_mpt_arr[$pageid]['tabs'][$tab]['active'] == true){
        ### TODO:LOWPRIORITY, apply the ['active'] value to all menu build methods and to all page files like this one
      
            // build form action value, will be appended            
            $csv2post_form_action = '';
            
            echo '<div id="tabs-'.$tab.'">';                                                                                            
            include($csv2post_mpt_arr[$pageid]['tabs'][$tab]['path']);    
            echo '</div>';        
        }
    } 
    
}elseif($csv2post_nav_type == 'nonav'){
    
    // loop through tabs - held in menu pages tabs array
    foreach($csv2post_mpt_arr[$pageid]['tabs'] as $tab=>$values){
        
        // chekc if tab is to be displayed, if not, we do not add the div for it    
        if($csv2post_mpt_arr[ $pageid ]['tabs'][ $tab ]['display'] == true){
            
            $csv2post_form_action = csv2post_link_toadmin($_GET['page'],'#tabs-' . $tab);            

            include(WTG_C2P_DIR.'pages/'.$pagefolder.'/csv2post_tab'.$tab.'_page'.$pageid.'.php');
        
        }
    }    
    
}
     
csv2post_footer(); ?>
