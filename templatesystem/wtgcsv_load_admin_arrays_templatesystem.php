<?php
/**
* Loads files holding arrays
*/
if(is_admin()){
    require_once(WTG_CSV_DIR.'templatesystem/include/variables/wtgcsv_variables_adminset_array.php');
    require_once(WTG_CSV_DIR.'templatesystem/include/variables/wtgcsv_variables_easyset_array.php'); 
    require_once(WTG_CSV_DIR.'templatesystem/include/variables/wtgcsv_variables_templatesystemfiles_array.php');
    require_once(WTG_CSV_DIR.'pages/wtgcsv_variables_tabmenu_array.php');
    require_once(WTG_CSV_DIR.'templatesystem/include/variables/wtgcsv_easyquestions_array.php');
    require_once(WTG_CSV_DIR.'templatesystem/include/variables/wtgcsv_wordpressoptionrecords_array.php');
}?>