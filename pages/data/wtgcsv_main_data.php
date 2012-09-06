<?php      
global $wtgcsv_mpt_arr,$wpdb,$wtgcsv_options_array,$wtgcsv_nav_type,$wtgcsv_is_free,$wtgcsv_job_array,$wtgcsv_is_dev,$wtgcsv_dataimportjobs_array,$wtgcsv_jobtable_array;
$pageid = 'data';// used to access variable.php configuration
$pagefolder = 'data';// the folder in pages folder holding this pages files

// main page header
if(!wtgcsv_get_option_currentjobcode()){$id_string = '';}else{$id_string = ' (ID: '.wtgcsv_get_option_currentjobcode().')';}
wtgcsv_header_page($wtgcsv_mpt_arr[$pageid]['title'] . wtgcsv_get_current_job_name() . $id_string,0);
 
// create tab menu for the giving page
wtgcsv_createmenu($pageid); 

// count number of panels, variable used as in code ID to pass to functions, not the TAB number users can see in url
$panel_number = 0;

// set tab number variable, a common use is in form hidden values
$wtgcsv_tab_number = wtgcsv_get_tabnumber();

// we can change the navigation type to CSS only, important for debugging javascript bugs
if($wtgcsv_nav_type == 'css'){ 

    $tab_number = 0;
    if(isset($_GET['tabnumber'])){
        $tab_number = $_GET['tabnumber'];
    }

    // build form action value, will be appended
    $wtgcsv_form_action = wtgcsv_link_toadmin('wtgcsv_yourdata','&tabnumber=' . $tab_number);

    include(WTG_CSV_DIR.'pages/data/wtgcsv_tab'.$tab_number.'_pagedata.php');

}elseif($wtgcsv_nav_type == 'jquery'){
    
    // loop through tabs - held in menu pages tabs array
    $counttabs = 0;// used as tab id also
    foreach($wtgcsv_mpt_arr[$pageid]['tabs'] as $tab=>$values){
        
        // chekc if tab is to be displayed, if not, we do not add the div for it    
        if($wtgcsv_mpt_arr[ $pageid ]['tabs'][ $counttabs ]['display'] == true){
            
            // build form action value, will be appended
            //$wtgcsv_form_action = wtgcsv_link_toadmin('wtgcsv_yourdata','#tabs-' . $counttabs);            
            $wtgcsv_form_action = '';
            
            echo '<div id="tabs-'.$counttabs.'">';
            include(WTG_CSV_DIR.'pages/data/wtgcsv_tab'.$counttabs.'_pagedata.php');
            echo '</div>';        
        }
        
        ++$counttabs;
    } 
    
}elseif($wtgcsv_nav_type == 'nonav'){
    
    // loop through tabs - held in menu pages tabs array
    $counttabs = 0;// used as tab id also
    foreach($wtgcsv_mpt_arr[$pageid]['tabs'] as $tab=>$values){
        
        // chekc if tab is to be displayed, if not, we do not add the div for it    
        if($wtgcsv_mpt_arr[ $pageid ]['tabs'][ $counttabs ]['display'] == true){
            
            $wtgcsv_form_action = wtgcsv_link_toadmin($_GET['page'],'#tabs-' . $counttabs);            

            include(WTG_CSV_DIR.'pages/'.$pagefolder.'/wtgcsv_tab'.$counttabs.'_page'.$pageid.'.php');
        
        }
        
        ++$counttabs;
    }    
    
}
     
wtgcsv_footer(); ?>
