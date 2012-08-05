<?php           
// used to access variable.php configuration
$pageid = 'install';
$pagefolder = 'install';

global $csv2post_options_array,$csv2post_is_installed,$csv2post_adm_set,$csv2post_mpt_arr,$wpdb,$csv2post_apiservicestatus,$csv2post_is_subscribed,$csv2post_requirements_missing,$csv2post_apisession_array,$csv2post_nav_type,$csv2post_is_free;

// count number of panels, variable used as in code ID to pass to functions, not the TAB number users can see in url
$panel_number = 0;  

// set tab number variable, a common use is in form hidden values
$csv2post_tab_number = csv2post_get_tabnumber();
    
// include tab screen file - this system allows us to be dynamic about which file to include  
if( $csv2post_is_installed == false ){// change to do a check on $csv2post_is_activated for full installs when extended security in place

    csv2post_header_page('Install CSV 2 POST',0);  

    // create tab menu for the giving page
    csv2post_createmenu($pageid);

    // install tab is the 5th tab, id 4
    echo '<div id="tabs-4">';
    include(WTG_C2P_DIR.'pages/'.$pageid.'/csv2post_tab4_'.$pageid.'.php');       
    echo '</div>';
    
    // set $counttabs so that the help pages have correct number assigned
    $counttabs = 5;### TODO: CRITICAL, check what this should be now that help pages have been removed
    
}else{

    if($csv2post_nav_type == 'css'){ 

        $tab_number = 0;
        if(isset($_GET['tabnumber'])){
            $tab_number = $_GET['tabnumber'];
        }

        // build form action value, will be appended
        $csv2post_form_action = csv2post_link_toadmin('csv2post_status','&tabnumber=' . $tab_number);
        
        include(WTG_C2P_DIR.'pages/data/csv2post_tab'.$tab_number.'_pagedata.php');

    }elseif($csv2post_nav_type == 'jquery'){
    
        csv2post_header_page($csv2post_mpt_arr[$pageid]['title'],0);  
     
        // build tabs navigation
        csv2post_createmenu($pageid);
                    
        // loop through tabs - held in menu pages tabs array
        $counttabs = 0;// used as tab id also
        foreach($csv2post_mpt_arr[$pageid]['tabs'] as $tab=>$values){
            
            // check if tab is to be displayed, if not, we do not add the div for it    
            if($csv2post_mpt_arr[ $pageid ]['tabs'][ $counttabs ]['display'] == true){
                
                // avoid displaying installation actions screen
                if($counttabs != 4){
                    
                    // build form action value, will be appended
                    //$csv2post_form_action = csv2post_link_toadmin($_GET['page'],'#tabs-' . $counttabs);            
                    $csv2post_form_action = '';
                
                    echo '<div id="tabs-'.$counttabs.'">';
                    include(WTG_C2P_DIR.'pages/'.$pagefolder.'/csv2post_tab'.$counttabs.'_install.php');
                    echo '</div>';
                }
                         
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
}

csv2post_footer();?>
