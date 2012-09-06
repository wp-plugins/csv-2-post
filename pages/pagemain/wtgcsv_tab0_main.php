<?php 
echo wtgcsv_notice('This plugin is very new, released June 2012. We would appreciate it greatly if you submit
feedback on the plugins
<a href="http://wordpress.org/support/plugin/wordpress-csv-importer">support forum</a>. Please use the 
"Test CSV File" tool if you have any difficutly using your file with the plugin and submit the results to us.','info','Large','New For 2012','','return');
?>

<style>
#sortablewtg { list-style-type: none; margin: 0; padding: 0; }
#sortablewtg li { margin: 3px 3px 3px 0; padding: 1px; float: left; width: 100px; height: 100px; font-size: 1em; text-align: center; }
</style>

<?php //TODO: LOWPRIORITY, get sortable boxes holding memory and allow sorting again ?>

<!--
<script>
$(function() {
    $( "#sortablewtg" ).sortable();
    $( "#sortablewtg" ).disableSelection();
});
</script>
-->
    
<ul id="sortablewtg"> 

    <li class="ui-state-default">
        <a href="<?php get_admin_url(); ?>admin.php?page=wtgcsv_settings#tabs-0">
        <img src="<?php echo WTG_CSV_IMAGEFOLDER_URL;?>pageicons/generalsettings.png" width="90" height="70" />            
        </a>General Settings
    </li>
        
    <li class="ui-state-default">
        <a href="<?php get_admin_url(); ?>admin.php?page=wtgcsv_settings#tabs-1">
        <img src="<?php echo WTG_CSV_IMAGEFOLDER_URL;?>pageicons/interfacesettings.png" width="90" height="70" />            
        </a>Interface Settings
    </li>
    
    <li class="ui-state-default">
        <a href="<?php get_admin_url(); ?>admin.php?page=wtgcsv_install#tabs-0">
        <img src="<?php echo WTG_CSV_IMAGEFOLDER_URL;?>pageicons/installactions.png" width="90" height="70" />            
        </a>Install Actions
    </li>
    
    <li class="ui-state-default">
        <a href="<?php get_admin_url(); ?>admin.php?page=wtgcsv_install#tabs-2">
        <img src="<?php echo WTG_CSV_IMAGEFOLDER_URL;?>pageicons/installstatus.png" width="90" height="70" />            
        </a>Install Status
    </li>
    
    <li class="ui-state-default">
        <a href="<?php get_admin_url(); ?>admin.php?page=wtgcsv_more#tabs-0">
        <img src="<?php echo WTG_CSV_IMAGEFOLDER_URL;?>pageicons/support.png" width="90" height="70" />            
        </a>Support
    </li>
    
    <li class="ui-state-default">
        <a href="<?php get_admin_url(); ?>admin.php?page=wtgcsv_more#tabs-1">
        <img src="<?php echo WTG_CSV_IMAGEFOLDER_URL;?>pageicons/community.png" width="90" height="70" />            
        </a>Community
    </li>
    
    <li class="ui-state-default">
        <a href="<?php get_admin_url(); ?>admin.php?page=wtgcsv_more#tabs-2">
        <img src="<?php echo WTG_CSV_IMAGEFOLDER_URL;?>pageicons/downloads.png" width="90" height="70" />            
        </a>Downloads
    </li>
    
    <li class="ui-state-default">
        <a href="<?php get_admin_url(); ?>admin.php?page=wtgcsv_more#tabs-3">
        <img src="<?php echo WTG_CSV_IMAGEFOLDER_URL;?>pageicons/affiliates.png" width="90" height="70" />            
        </a>Affiliates
    </li>
    
    <li class="ui-state-default">
        <a href="<?php get_admin_url(); ?>admin.php?page=wtgcsv_more#tabs-7">
        <img src="<?php echo WTG_CSV_IMAGEFOLDER_URL;?>pageicons/mytickets.png" width="90" height="70" />            
        </a>My Tickets
    </li>
    
    <li class="ui-state-default">
        <a href="<?php get_admin_url(); ?>admin.php?page=wtgcsv_more#tabs-8">
        <img src="<?php echo WTG_CSV_IMAGEFOLDER_URL;?>pageicons/myaccount.png" width="90" height="70" />            
        </a>My Account
    </li>
    
    <li class="ui-state-default">
        <a href="<?php get_admin_url(); ?>admin.php?page=wtgcsv_more#tabs-9">
        <img src="<?php echo WTG_CSV_IMAGEFOLDER_URL;?>pageicons/contact.png" width="90" height="70" />            
        </a>Contact
    </li>
</ul>

<div style="clear:both;"></div>