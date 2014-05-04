<?php
/** 
 * main file for post creation section 
 * 
 * @link by http://www.webtechglobal.co.uk
 * 
 * @author Ryan Bayne 
 *
 * @package CSV 2 POST
 */

$c2p_page_name = 'postcreation';
 
global $C2P_WP,$c2p_tab_number,$wpecus_settings,$c2p_mpt_arr,$C2P_WP;

// view header - includes notices output and some admin side automation such as conflict prevention
$C2P_WP->pageheader($c2p_mpt_arr[$c2p_page_name]['title'],0);
                       
// create tab menu for the giving page
$C2P_WP->createmenu($c2p_page_name);

// count number of panels, variable used as in code ID to pass to functions, not the TAB number users can see in url
$panel_number = 0;

// set tab number variable, a common use is in form hidden values
$c2p_tab_number = $C2P_WP->tabnumber();
          
// create screen content 
if( $C2P_WP->should_tab_be_displayed($c2p_page_name,$c2p_tab_number) ){
    include($c2p_mpt_arr[$c2p_page_name]['tabs'][$c2p_tab_number]['path']);
}else{
    $C2P_WP->include_default_screen($c2p_page_name);
}

$C2P_WP->footer();
?>