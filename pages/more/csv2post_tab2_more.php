<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'latestpluginversion';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Latest Plugin Version');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Download the latest version of '.$csv2post_plugintitle.', requires premium activation.');
$panel_array['panel_help'] = __('If you activate Premium Services for '.$csv2post_plugintitle.' you will be able to download the plugin from this panel. Do not copy the download link offered on this page, it only works once and only works within this blog. Too many attempts to use the same download URL can result in this service being automatically suspended for you account, do not share the linke online.'); 
$panel_array['help_button'] = csv2post_helpbutton_text(true,false);
?>
<?php csv2post_panel_header( $panel_array );?>
               <p>Service not currently available</p>
<?php csv2post_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'previouspluginversion';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Previous Plugin Versions');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Download past versions of '.$csv2post_plugintitle.', requires premium activation.');
$panel_array['panel_help'] = __('If you activate Premium Services for '.$csv2post_plugintitle.' you will be able to download previous versions of the plugin from this panel. Do not copy the download links offered on this page, they only works once and they only work within this blog. Too many attempts to use the same download URL can result in this service being automatically suspended for you account, do not share the link online.');
$panel_array['help_button'] = csv2post_helpbutton_text(true,false);
?>
<?php csv2post_panel_header( $panel_array );?>
               <p>Service not currently available</p>
 <?php csv2post_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'wtgplugins';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('WTG Plugins');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __($csv2post_plugintitle.' is one of many plugins I provide, download my other plugins here.');
$panel_array['panel_help'] = __('In 2011 I begin plans to create a strong plugin range supported by web services. By the end of 2012 I should have many basic and free plugins with plans to improve the popular ones in 2013. By 2014 I hope to have some key premium plugins selling and use profits to begin creating themes that compete with the best.');
$panel_array['help_button'] = csv2post_helpbutton_text(true,false);
?>
<?php csv2post_panel_header( $panel_array );?>
               <p>No plugins available yet</p>
 <?php csv2post_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'integratedplugins';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Integrated Plugins');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Plugins that work well with '.$csv2post_plugintitle);
$panel_array['panel_help'] = __('Please let me know any plugins you like to use with  '.$csv2post_plugintitle.' and any idea you might have for integration features.');
$panel_array['help_button'] = csv2post_helpbutton_text(true,false);
?>
<?php csv2post_panel_header( $panel_array );?>

              <p>No plugins submitted</p>
<?php csv2post_panel_footer();?> 