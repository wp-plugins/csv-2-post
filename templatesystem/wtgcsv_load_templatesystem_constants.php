<?php
if(!defined("WTG_CSV_ID")){define("WTG_CSV_ID","27");}
if(!defined("WTG_CSV_FOLDERNAME")){define("WTG_CSV_FOLDERNAME",'wordpress-csv-importer');}// The plugins main folder name in the wordpress plugins directory  
if(!defined("WTG_CSV_BASENAME")){define("WTG_CSV_BASENAME", plugin_basename( __FILE__ ) );}// wtgplugintemplate/wtgtemplateplugin.php
if(!defined("WTG_CSV_CONURL")){define("WTG_CSV_CONURL", get_bloginfo('url'));}// http://localhost/wordpress-testing/wtgplugintemplate
if(!defined("WTG_CSV_PHPVERSIONTESTED")){define("WTG_CSV_PHPVERSIONTESTED",$wtgcsv_php_version_tested);}// The latest version of php the plugin has been tested on and certified to be working 
if(!defined("WTG_CSV_PHPVERSIONMINIMUM")){define("WTG_CSV_PHPVERSIONMINIMUM",$wtgcsv_php_version_minimum);}// The minimum php version that will allow the plugin to work     
if(!defined("WTG_CSV_CHMOD")){define("WTG_CSV_CHMOD",'0755');}// File permission default CHMOD for any folders or files created by plugin  
if(!defined("WTG_CSV_PANELFOLDER_PATH")){define("WTG_CSV_PANELFOLDER_PATH",WP_PLUGIN_DIR.'/'.WTG_CSV_FOLDERNAME.'/panels/base/');}// directory path to storage folder inside the wp_content folder                            
if(!defined("WTG_CSV_PLUGINTITLE")){define("WTG_CSV_PLUGINTITLE",'Wordpress CSV Importer');}//Visual plugin title 
if(!defined("WTG_CSV_CONTENTFOLDER_DIR")){define("WTG_CSV_CONTENTFOLDER_DIR",WP_CONTENT_DIR.'/'.'wpcsvimportercontent');}// directory path to storage folder inside the wp_content folder  
if(!defined("WTG_CSV_IMAGEFOLDER_URL")){define("WTG_CSV_IMAGEFOLDER_URL",WP_PLUGIN_URL.'/'.WTG_CSV_FOLDERNAME.'/templatesystem/images/');}// directory path to storage folder inside the wp_content folder 
if(!defined("WTG_CSV_DATEFORMAT")){define("WTG_CSV_DATEFORMAT",'Y-m-d H:i:s');}
?>
