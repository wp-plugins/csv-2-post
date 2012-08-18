<?php 
global $csv2post_mpt_arr,$wpdb,$csv2post_options_array,$csv2post_theme_array,$csv2post_nav_type,$csv2post_is_free;
$pageid = 'settings';// used to access variable.php configuration
$pagefolder = 'settings';

// main page header
csv2post_header_page($csv2post_mpt_arr[$pageid]['title'],0);

// create tab menu for the giving page
csv2post_createmenu($pageid);

// count number of panels, variable used as in code ID to pass to functions, not the TAB number users can see in url
$panel_number = 0;

// set tab number variable, a common use is in form hidden values
$csv2post_tab_number = csv2post_get_tabnumber(); 

if($csv2post_nav_type == 'css'){ 

    $tab_number = 0;
    if(isset($_GET['tabnumber'])){
        $tab_number = $_GET['tabnumber'];
    }

    // build form action value, will be appended
    $csv2post_form_action = csv2post_link_toadmin('csv2post_settings','&tabnumber=' . $tab_number);
    
    include(WTG_C2P_DIR.'pages/data/csv2post_tab'.$tab_number.'_pagedata.php');

}elseif($csv2post_nav_type == 'jquery'){
         
    // loop through tabs - held in menu pages tabs array
    $counttabs = 0;// used as tab id also
    foreach($csv2post_mpt_arr[$pageid]['tabs'] as $tab=>$values){
        
        // chekc if tab is to be displayed, if not, we do not add the div for it    
        if($csv2post_mpt_arr[ $pageid ]['tabs'][ $counttabs ]['display'] == true){

            // build form action value, will be appended
            //$csv2post_form_action = csv2post_link_toadmin($_GET['page'],'#tabs-' . $counttabs);            
            $csv2post_form_action = '';
                        
            echo '<div id="tabs-'.$counttabs.'">';
            include(WTG_C2P_DIR.'pages/'.$pagefolder.'/'.WTG_C2P_ABB.'tab'.$counttabs.'_settings.php');
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

csv2post_footer();?>
