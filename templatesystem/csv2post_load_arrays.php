<?php
/**
* Loads files holding arrays
* 
* @todo establish which of these files could be called when needed i.e installation and get_option function which triggers the install of the related array
*/
if(is_admin()){      
    require_once(WTG_C2P_DIR.'templatesystem/include/variables/csv2post_variables_templatesystemfiles_array.php');
    require_once(WTG_C2P_DIR.'templatesystem/include/variables/csv2post_easyquestions_array.php');
    require_once(WTG_C2P_DIR.'templatesystem/include/variables/csv2post_wordpressoptionrecords_array.php');    
}else{
    // load arrays that are public only, although there is probably few reasons to do this as most data will be required on admin side
}

#############################################################
#                                                           #
#            LOAD ARRAYS FOR BOTH ADMIN AND PUBLIC          #
#                                                           #
#############################################################
require_once(WTG_C2P_DIR.'templatesystem/include/variables/csv2post_logfile_array.php');?>