<?php
if(!defined("WTG_C2P_ID")){define("WTG_C2P_ID","27");}
if(!defined("WTG_C2P_FOLDERNAME")){define("WTG_C2P_FOLDERNAME",'csv-2-post');}// The plugins main folder name in the wordpress plugins directory  
if(!defined("WTG_C2P_BASENAME")){define("WTG_C2P_BASENAME", plugin_basename( __FILE__ ) );}// wtgplugintemplate/wtgtemplateplugin.php
if(!defined("WTG_C2P_CONURL")){define("WTG_C2P_CONURL", get_bloginfo('url'));}// http://localhost/wordpress-testing/wtgplugintemplate
if(!defined("WTG_C2P_PHPVERSIONTESTED")){define("WTG_C2P_PHPVERSIONTESTED",$csv2post_php_version_tested);}// The latest version of php the plugin has been tested on and certified to be working 
if(!defined("WTG_C2P_PHPVERSIONMINIMUM")){define("WTG_C2P_PHPVERSIONMINIMUM",$csv2post_php_version_minimum);}// The minimum php version that will allow the plugin to work     
if(!defined("WTG_C2P_CHMOD")){define("WTG_C2P_CHMOD",'0755');}// File permission default CHMOD for any folders or files created by plugin  
if(!defined("WTG_C2P_PANELFOLDER_PATH")){define("WTG_C2P_PANELFOLDER_PATH",WP_PLUGIN_DIR.'/'.WTG_C2P_FOLDERNAME.'/panels/base/');}// directory path to storage folder inside the wp_content folder                            
if(!defined("WTG_C2P_PLUGINTITLE")){define("WTG_C2P_PLUGINTITLE",'CSV 2 POST');}//Visual plugin title 
if(!defined("WTG_C2P_CONTENTFOLDER_DIR")){define("WTG_C2P_CONTENTFOLDER_DIR",WP_CONTENT_DIR.'/'.'wpcsvimportercontent');}// directory path to storage folder inside the wp_content folder  
if(!defined("WTG_C2P_IMAGEFOLDER_URL")){define("WTG_C2P_IMAGEFOLDER_URL",WP_PLUGIN_URL.'/'.WTG_C2P_FOLDERNAME.'/templatesystem/images/');}// directory path to storage folder inside the wp_content folder 
if(!defined("WTG_C2P_DATEFORMAT")){define("WTG_C2P_DATEFORMAT",'Y-m-d H:i:s');}
?>
