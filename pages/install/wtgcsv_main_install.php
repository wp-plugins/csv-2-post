<?php           
// used to access variable.php configuration
$pageid = 'install';
$pagefolder = 'install';

global $wtgcsv_options_array,$wtgcsv_is_installed,$wtgcsv_adm_set,$wtgcsv_mpt_arr,$wpdb,$wtgcsv_apiservicestatus,$wtgcsv_is_subscribed,$wtgcsv_requirements_missing,$wtgcsv_apisession_array,$wtgcsv_nav_type,$wtgcsv_is_free;

// count number of panels, variable used as in code ID to pass to functions, not the TAB number users can see in url
$panel_number = 0;  

// set tab number variable, a common use is in form hidden values
$wtgcsv_tab_number = wtgcsv_get_tabnumber();
    
// include tab screen file - this system allows us to be dynamic about which file to include  
if( $wtgcsv_is_installed == false ){// change to do a check on $wtgcsv_is_activated for full installs when extended security in place

    wtgcsv_header_page('Install Wordpress CSV Importer',0);  

    // create tab menu for the giving page
    wtgcsv_createmenu($pageid);

    // install tab is the 5th tab, id 4
    echo '<div id="tabs-4">';
    include(WTG_CSV_DIR.'pages/'.$pageid.'/wtgcsv_tab4_'.$pageid.'.php');       
    echo '</div>';
    
    // set $counttabs so that the help pages have correct number assigned
    $counttabs = 5;### TODO: CRITICAL, check what this should be now that help pages have been removed
    
}else{

    if($wtgcsv_nav_type == 'css'){ 

        $tab_number = 0;
        if(isset($_GET['tabnumber'])){
            $tab_number = $_GET['tabnumber'];
        }

        // build form action value, will be appended
        $wtgcsv_form_action = wtgcsv_link_toadmin('wtgcsv_status','&tabnumber=' . $tab_number);
        
        include(WTG_CSV_DIR.'pages/data/wtgcsv_tab'.$tab_number.'_pagedata.php');

    }elseif($wtgcsv_nav_type == 'jquery'){
    
        wtgcsv_header_page($wtgcsv_mpt_arr[$pageid]['title'],0);  
     
        // build tabs navigation
        wtgcsv_createmenu($pageid);
                    
        // loop through tabs - held in menu pages tabs array
        $counttabs = 0;// used as tab id also
        foreach($wtgcsv_mpt_arr[$pageid]['tabs'] as $tab=>$values){
            
            // check if tab is to be displayed, if not, we do not add the div for it    
            if($wtgcsv_mpt_arr[ $pageid ]['tabs'][ $counttabs ]['display'] == true){
                
                // avoid displaying installation actions screen
                if($counttabs != 4){
                    
                    // build form action value, will be appended
                    //$wtgcsv_form_action = wtgcsv_link_toadmin($_GET['page'],'#tabs-' . $counttabs);            
                    $wtgcsv_form_action = '';
                
                    echo '<div id="tabs-'.$counttabs.'">';
                    include(WTG_CSV_DIR.'pages/'.$pagefolder.'/wtgcsv_tab'.$counttabs.'_install.php');
                    echo '</div>';
                }
                         
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
}

wtgcsv_footer();?>
