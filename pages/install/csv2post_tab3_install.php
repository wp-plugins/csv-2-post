<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'pluginconfigvalues';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Plugin Config Values');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('This show the status of what are actually called php directives. These are a type of setting that can be configured in the php.ini file used by your server. Your hosting will configure this to suit the service they are providing and the values may effect this plugin.'); ?>
<?php csv2post_panel_header( $panel_array );?>

    <h2>Package Values</h2>
    <ul>
        <li><strong>Plugin Version:</strong> <?php echo $csv2post_currentversion;?></li>
        <li><strong>Tested PHP:</strong> <?php echo $csv2post_php_version_tested;?></li>
        <li><strong>Minimum PHP:</strong> <?php echo $csv2post_php_version_minimum;?></li>
        <li><strong>Free Override:</strong> <?php echo $csv2post_is_free_override;?></li>
        <li><strong>Demo Mode:</strong> <?php echo $csv2post_demo;?></li>
        <li><strong>Is Free Edition:</strong> <?php echo $csv2post_is_free;?></li>        
        <li><strong>WTG_C2P_ABB:</strong> <?php echo WTG_C2P_ABB;?></li>        
        <li><strong>WTG_C2P_NAME:</strong> <?php echo WTG_C2P_NAME;?></li>
        <li><strong>WTG_C2P_ID:</strong> <?php echo WTG_C2P_ID;?></li>
        <li><strong>WTG_C2P_PHPVERSIONTESTED:</strong> <?php echo WTG_C2P_PHPVERSIONTESTED;?></li>
        <li><strong>WTG_C2P_PHPVERSIONMINIMUM:</strong> <?php echo WTG_C2P_PHPVERSIONMINIMUM;?></li>
        <li><strong>WTG_C2P_CHMOD:</strong> <?php echo WTG_C2P_CHMOD;?></li>
        <li><strong>WTG_C2P_DATEFORMAT:</strong> <?php echo WTG_C2P_DATEFORMAT;?></li>
        <li><strong>WTG_C2P_EXTENSIONS:</strong> <?php echo WTG_C2P_EXTENSIONS;?></li>
    </ul> 
    
    <h2>Variables</h2>   
    <ul>    
        <li><strong>Debug Mode:</strong> <?php echo $csv2post_debug_mode;?></li>                                                             
        <li><strong>Developer Mode:</strong> <?php echo $csv2post_is_dev;?></li>                                                             
        <li><strong>Plugin Title:</strong> <?php echo $csv2post_plugintitle;?></li>                                                             
        <li><strong>Plugin Name:</strong> <?php echo $csv2post_pluginname;?></li>                                                             
        <li><strong>Home Slug:</strong> <?php echo $csv2post_homeslug;?></li>
        <li><strong>Being Activated:</strong> <?php echo $csv2post_isbeingactivated;?></li>
        <li><strong>Disable API:</strong> <?php echo $csv2post_disableapicalls;?></li>
        <li><strong>Is Event:</strong> <?php echo $csv2post_is_event;?></li>
        <li><strong>CSV Handler:</strong> <?php echo $csv2post_csvmethod;?></li>
        <li><strong>Menu Type:</strong> <?php echo $csv2post_nav_type;?></li>
        <li><strong>Installation Drive:</strong> <?php echo $csv2post_installation_required;?></li>
        <li><strong>API Service Status:</strong> <?php echo $csv2post_apiservicestatus;?></li>
        <li><strong>Web Service Available:</strong> <?php echo $csv2post_is_webserviceavailable;?></li>
        <li><strong>Is Subscribed:</strong> <?php echo $csv2post_is_subscribed;?></li>
        <li><strong>Is Installed:</strong> <?php echo $csv2post_is_installed;?></li>
        <li><strong>Was Installed:</strong> <?php echo $csv2post_was_installed;?></li>
        <li><strong>Domain Registered:</strong> <?php echo $csv2post_is_domainregistered;?></li>
        <li><strong>Email Authorised:</strong> <?php echo $csv2post_is_emailauthorised;?></li>
        <li><strong>Log Main Dir:</strong> <?php echo $csv2post_log_maindir;?></li>
        <li><strong>Call Code:</strong> <?php echo $csv2post_callcode;?></li>                                                        
    </ul>    
      
    <h2>Users Configuration</h2>
    <ul>
        <li><strong>Current Project:</strong> <?php echo $csv2post_currentproject;?></li>
        <li><strong>Extension Loaded:</strong> <?php echo $csv2post_extension_loaded;?></li>
        <li><strong>GUI Theme:</strong> <?php echo $csv2post_guitheme;?></li>
        <li><strong>Current Job Code:</strong> <?php echo $csv2post_currentjob_code;?></li>
        <li><strong>Current Project Code:</strong> <?php echo $csv2post_currentproject_code;?></li>
    </ul>  
    
    <h2>File Paths</h2>
    <ul>
        <li><strong>Plug</strong> <?php echo WTG_C2P_ABB;?></li>
        <li><strong>WTG_C2P_URL</strong> <?php echo WTG_C2P_URL;?></li>
        <li><strong>WTG_C2P_DIR</strong> <?php echo WTG_C2P_DIR;?></li>
        <li><strong>WTG_C2P_FOLDERNAME</strong> <?php echo WTG_C2P_FOLDERNAME;?></li>
        <li><strong>WTG_C2P_BASENAME</strong> <?php echo WTG_C2P_BASENAME;?></li>                    
        <li><strong>WTG_C2P_PANELFOLDER_PATH</strong> <?php echo WTG_C2P_PANELFOLDER_PATH;?></li>
        <li><strong>WTG_C2P_CONTENTFOLDER_DIR</strong> <?php echo WTG_C2P_CONTENTFOLDER_DIR;?></li>
        <li><strong>WTG_C2P_IMAGEFOLDER_URL</strong> <?php echo WTG_C2P_IMAGEFOLDER_URL;?></li>
    <ul>  

<?php csv2post_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'pluginfunctiontests';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Plugin Function Tests');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('Remove'); ?>
<?php csv2post_panel_header( $panel_array );?>
    <ul>
        <li><strong>Blog Charset:</strong> <?php echo get_option('blog_charset'); ?></li>
        <li><strong>Database Charset:</strong> <?php echo DB_CHARSET; ?></li>
        <li><strong>Encoding Clean String:</strong> <?php echo csv2post_encoding_clean_string('???'); ?></li>
        <li><strong>UTF-8 Encode:</strong> <?php echo utf8_encode('beta testing only ???'); ?></li>        
        <li><strong>UTF-8 Encode (special characters only):</strong> <?php echo utf8_encode('???'); ?></li>
        <li><strong>UTF-8 Decode (special characters only):</strong> <?php echo utf8_decode('???'); ?></li>
    </ul>        
<?php csv2post_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'serverconfiguration';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Server Configuration');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('The list of information indicates configuration important to this software and in some cases will indicate the status of an item i.e. if a required extension is not installed on your server and required for '.$csv2post_plugintitle.' to operate properly this will be made clear.');?>
<?php csv2post_panel_header( $panel_array );?>
            
    <ul>
        <li><strong>PHP Version:</strong> <?php echo phpversion();?></li>
        <li><strong>MySQL Version:</strong> <?php echo csv2post_get_mysqlversion();?></li>                          
        <li><strong>HTTP_HOST:</strong> <?php echo $_SERVER['HTTP_HOST'];?></li>
        <li><strong>SERVER_NAME:</strong> <?php echo $_SERVER['SERVER_NAME'];?></li>           
    </ul>
             
    <hr>
    
    <h2>Common Functions (returned value)</h2>
    <ul>
        <li><strong>time():</strong> <?php echo time();?></li>
        <li><strong>date('Y-m-d H:i:s'):</strong> <?php echo date('Y-m-d H:i:s');?></li>
        <li><strong>date('e'):</strong> <?php echo date('e');?> (timezone identifier)</li>
        <li><strong>date('G'):</strong> <?php echo date('G');?> (24-hour format)</li>
        <li><strong>get_admin_url():</strong> <?php echo get_admin_url();?></li>
        <li><strong>csv2post_link_toadmin():</strong> <?php echo csv2post_link_toadmin('examplepage');?></li>                   
    </ul>

<?php csv2post_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'wordpressconfiguration';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Wordpress Configuration');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('Please send this information to us when seeking support on very complex problems.'); ?>
<?php csv2post_panel_header( $panel_array );?>
    <ul>
        <li><strong>Wordpress Database Charset:</strong> <?php echo DB_CHARSET; ?></li>
        <li><strong>Wordpress Blog Charset:</strong> <?php echo get_option('blog_charset'); ?></li>
        <li><strong>WP_MEMORY_LIMIT:</strong> <?php echo WP_MEMORY_LIMIT;?></li>            
        <li><strong>WP_POST_REVISIONS:</strong> <?php echo WP_POST_REVISIONS;?></li>                                    
    </ul> 
<?php csv2post_panel_footer();?> 