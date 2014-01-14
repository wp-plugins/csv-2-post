<?php
/** 
 * WebTechGlobal standard PHP and CMS function library
 *
 * @package WTG Core Functions Library
 * 
 * @author Ryan Bayne | ryan@webtechglobal.co.uk
 */
 
/**
* Main admin page script function, called in main file using admin_footer hook 
*/
function csv2post_WP_adminpage_script() {?>

    <!--
    
    this is causing a conflict with Wordpress Add Media button on WYSIWYG editor - 10th June 2013
    it is for the tips function currently  csv2post_tt()
    
    < s c r i p t type="text/javascript">
    jQuery(document).ready( function() {
        jQuery('.csv2postgivemesometips').tTips();
    });
    </script>
    -->
    
    <?php 
}  
?>
