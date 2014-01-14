<?php
/** 
 * WebTechGlobal standard PHP and CMS function library
 *
 * @package WTG Core Functions Library
 * 
 * @author Ryan Bayne | ryan@webtechglobal.co.uk
 */
  
/**
* Builds menu for selecting screen permission.
* 
* @todo LOWPRIORITY, currently uses multiselect drop down filter menu...
* consider changing to multiSelect selectables menu and adapting to allow multiple
* captabilities to be selected
* 
* @param mixed $csv2post_ARRAY_capabilities
* @param mixed $page_name
* @param mixed $key
* @param mixed $current
*/
function csv2post_FORM_menu_capabilities($csv2post_ARRAY_capabilities,$page_name,$key,$current){?>
    <select name="csv2post_capabilitiesmenu_<?php echo $page_name;?>_<?php echo $key;?>" id="csv2post_capabilitiesmenu_<?php echo $page_name;?>_<?php echo $key;?>" >
        <?php 
           foreach($csv2post_ARRAY_capabilities as $cap){
               $selected = '';
               if($cap == $current){
                   $selected = 'selected="selected"';
               }
               echo '<option value="'.$cap.'" '.$selected.'>'.$cap.'</option>';
           }
        ?>                                                                                                                     
    </select><?php
} 
?>
