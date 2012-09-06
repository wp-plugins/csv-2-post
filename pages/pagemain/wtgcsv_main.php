<?php 
global $wtgcsv_mpt_arr,$wpdb,$wtgtp_pluginforum,$wtgtp_pluginblog,$wtgcsv_options_array,$wtgcsv_nav_type,$wtgcsv_is_free;
$pageid = 'main';// used to access variable.php configuration
$pagefolder = 'pagemain';

// main page header
wtgcsv_header_page($wtgcsv_mpt_arr[$pageid]['title'],0);
          
// create tab menu for the giving page
wtgcsv_createmenu($pageid);

// count number of panels, variable used as in code ID to pass to functions, not the TAB number users can see in url
$panel_number = 0;

// set tab number variable, a common use is in form hidden values
$wtgcsv_tab_number = wtgcsv_get_tabnumber();

if($wtgcsv_nav_type == 'css'){ 

    $tab_number = 0;
    if(isset($_GET['tabnumber'])){
        $tab_number = $_GET['tabnumber'];
    }

    // build form action value, will be appended
    $wtgcsv_form_action = wtgcsv_link_toadmin('wtgcsv_yourmain','&tabnumber=' . $tab_number);
    
    include(WTG_CSV_DIR.'pages/data/wtgcsv_tab'.$tab_number.'_pagedata.php');

}elseif($wtgcsv_nav_type == 'jquery'){
    
    // loop through tabs - held in menu pages tabs array
    $counttabs = 0;// used as tab id also
    foreach($wtgcsv_mpt_arr[$pageid]['tabs'] as $tab=>$values){
        
        // chekc if tab is to be displayed, if not, we do not add the div for it    
        if($wtgcsv_mpt_arr[ $pageid ]['tabs'][ $counttabs ]['display'] == true){
            
            // build form action value, will be appended
            //$wtgcsv_form_action = wtgcsv_link_toadmin($_GET['page'],'#tabs-' . $counttabs);            
            $wtgcsv_form_action = '';
                        
            echo '<div id="tabs-'.$counttabs.'">';
            include(WTG_CSV_DIR.'pages/'.$pagefolder.'/'.WTG_CSV_ABB.'tab'.$counttabs.'_'.$pageid.'.php');
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
    
}?>

                </div><!-- end of tabs - all content must be displayed before this div -->   
            </div><!-- end of post boxes -->
        </div><!-- end of post boxes -->
    </div><!-- end of post boxes -->
</div><!-- end of wrap - started in header -->

<script type="text/javascript">
    // <![CDATA[
    jQuery('.postbox div.handlediv').click( function() { jQuery(jQuery(this).parent().get(0)).toggleClass('closed'); } );
    jQuery('.postbox h3').click( function() { jQuery(jQuery(this).parent().get(0)).toggleClass('closed'); } );
    jQuery('.postbox.close-me').each(function(){
    jQuery(this).addClass("closed");
    });
    //-->
</script>