<?php
/**
* Loads files holding arrays
*/
if(is_admin()){
    require_once(WTG_C2P_DIR.'templatesystem/include/variables/csv2post_variables_adminset_array.php');
    require_once(WTG_C2P_DIR.'templatesystem/include/variables/csv2post_variables_easyset_array.php'); 
    require_once(WTG_C2P_DIR.'templatesystem/include/variables/csv2post_variables_templatesystemfiles_array.php');
    require_once(WTG_C2P_DIR.'pages/csv2post_variables_tabmenu_array.php');
    require_once(WTG_C2P_DIR.'templatesystem/include/variables/csv2post_easyquestions_array.php');
    require_once(WTG_C2P_DIR.'templatesystem/include/variables/csv2post_wordpressoptionrecords_array.php');
}?>