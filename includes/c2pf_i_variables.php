<?php
// expected folder name - used for making up path too plugin files
if(!defined('C2PFOLDER')){define('C2PFOLDER','/csv-2-post/');}

// complete path too plugin files
if(!defined('C2PPATH')){define('C2PPATH',WP_PLUGIN_DIR.C2PFOLDER);}

// default csv storage folder path
//if(!defined('C2PCSVFOLDER')){define('C2PCSVFOLDER',WP_CONTENT_DIR . '/ecifiles/');}
if(!defined('C2PCSVFOLDER')){define('C2PCSVFOLDER',C2PPATH);}

// plugin authorisation level (0 for testing but 10 for final launch)
if(!defined('C2PAUTHLEV')){define('C2PAUTHLEV','10');}
?>