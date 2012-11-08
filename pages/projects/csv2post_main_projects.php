<?php      
global $csv2post_mpt_arr,$wpdb,$csv2post_options_array,$csv2post_projectslist_array,$csv2post_currentproject_code,$csv2post_nav_type,$csv2post_project_array,$csv2post_is_free,$csv2post_is_dev,$csv2post_textspin_array;
$pageid = 'projects';// used to access variable.php configuration
$pagefolder = 'projects';// the folder in pages folder holding this pages files

// main page header
if($csv2post_is_free){
    $page_title_string = 'Your Project Configuration';    
}else{
    $page_title_string = $csv2post_mpt_arr[$pageid]['title'] . csv2post_get_current_project_name() . ' (ID: '.csv2post_convertvalue_projectcodefalse_toostring().')';
}

csv2post_header_page($page_title_string,0);
 
// if no projects have been set, display notice telling user a project is required
if(!isset($csv2post_currentproject_code) || $csv2post_currentproject_code == false){
    echo wtgcore_notice_display_step('http://www.games-hq.com/testing/wpcsvimp/wp-admin/admin.php?page=csv2post_yourprojects#tabs-0','Please Create A Project','You do not have any projects or no project has been set as your current one. Please either create a project on the Projects screen below or use the Select Current Project panel.');
}
                    
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
    $counttabs = 0;// used as tab id also
    foreach($csv2post_mpt_arr[$pageid]['tabs'] as $tab=>$values){
        
        // chekc if tab is to be displayed, if not, we do not add the div for it    
        if($csv2post_mpt_arr[ $pageid ]['tabs'][ $counttabs ]['display'] == true){
            
            // build form action value, will be appended
            $csv2post_form_action = csv2post_link_toadmin($_GET['page'],'#tabs-' . $counttabs);### TODO:HIGHPRIORITY,is this variable still in use? if not remove it from entire plugin            
            //$csv2post_form_action = '';
                      
            echo '<div id="tabs-'.$counttabs.'">';                                                                                            
            include($csv2post_mpt_arr[$pageid]['tabs'][$counttabs]['path']);    
            echo '</div>';
                     
        }
        
        ++$counttabs;
    } 

}elseif($csv2post_nav_type == 'nonav'){
    
    // loop through tabs - held in menu pages tabs array
    $counttabs = 0;// used as tab id also
    foreach($csv2post_mpt_arr[$pageid]['tabs'] as $tab=>$values){
        
        // chekc if tab is to be displayed, if not, we do not add the div for it    
        if($csv2post_mpt_arr[ $pageid ]['tabs'][ $counttabs ]['display'] == true){
            
            $csv2post_form_action = csv2post_link_toadmin($_GET['page'],'#tabs-' . $counttabs);            

            include(WTG_C2P_DIR.'pages/'.$pagefolder.'/csv2post_tab'.$counttabs.'_page'.$pageid.'.php');
        
        }
        
        ++$counttabs;
    }    
    
} 
      
csv2post_footer(); ?>
