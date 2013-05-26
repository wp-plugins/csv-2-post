<?php
/**
* Main admin page script function, called in main file using admin_footer hook 
*/
function csv2post_WP_adminpage_script() {?>
    <script type="text/javascript">
    jQuery(document).ready( function() {
        jQuery('.givemesometips').tTips();
    });
    </script><?php 
}  
?>
