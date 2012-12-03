<?php           
// used to access variable.php configuration
$pageid = 'install';
$pagefolder = 'install';

global $csv2post_file_profiles,$csv2post_options_array,$csv2post_is_installed,$csv2post_adm_set,$csv2post_mpt_arr,$wpdb,$csv2post_apiservicestatus,$csv2post_is_subscribed,$csv2post_requirements_missing,$csv2post_apisession_array,$csv2post_nav_type,$csv2post_is_free,$csv2post_plugintitle;

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
        foreach($csv2post_mpt_arr[$pageid]['tabs'] as $tab=>$values){
            
            // check if tab is to be displayed, if not, we do not add the div for it    
            if($csv2post_mpt_arr[ $pageid ]['tabs'][ $tab ]['display'] == true){
                
                // avoid displaying installation actions screen
                if($tab != 4){
                    
                    // build form action value, will be appended            
                    $csv2post_form_action = '';
                        
                    echo '<div id="tabs-'.$tab.'">';                                                                                            
                    include($csv2post_mpt_arr[$pageid]['tabs'][$tab]['path']);    
                    echo '</div>';
                }
                         
            }
        }
        
    }elseif($csv2post_nav_type == 'nonav'){
        
        // loop through tabs - held in menu pages tabs array
        foreach($csv2post_mpt_arr[$pageid]['tabs'] as $tab => $values){
            
            // chekc if tab is to be displayed, if not, we do not add the div for it    
            if($csv2post_mpt_arr[ $pageid ]['tabs'][ $tab ]['display'] == true){
                
                $csv2post_form_action = csv2post_link_toadmin($_GET['page'],'#tabs-' . $tab);            

                include(WTG_C2P_DIR.'pages/'.$pagefolder.'/csv2post_tab'.$tab.'_page'.$pageid.'.php');
            
            }
        }    
    }  
}

csv2post_footer();?>
