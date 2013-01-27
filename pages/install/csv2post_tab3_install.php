<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'serverconfiguration';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Server Configuration');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Displays details about your server that are important to '.$csv2post_plugintitle.'.');
$panel_array['panel_help'] = __('The list of information indicates configuration important to this software and in some cases will indicate the status of an item i.e. if a required extension is not installed on your server and required for '.$csv2post_plugintitle.' to operate properly this will be made clear.'); 
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);?>
<?php csv2post_panel_header( $panel_array );?>
            
    <h4>Software</h4>
    <ul>
        <li><strong>PHP Version:</strong> <?php echo phpversion();?></li>
        <li><strong>MySQL Version:</strong> <?php echo csv2post_get_mysqlversion();?></li>                          
    </ul> 
                                
    <h4>Variables</h4>
    <ul>
        <li><strong>HTTP_HOST:</strong> <?php echo $_SERVER['HTTP_HOST'];?></li>
        <li><strong>SERVER_NAME:</strong> <?php echo $_SERVER['SERVER_NAME'];?></li>            
    </ul>
    
    <hr>
    
    <h4>Common Functions (returned value)</h4>
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
$panel_array['panel_intro'] = __('Variable values created by Wordpress core and used by this plugin.');
$panel_array['panel_help'] = __('Please send this information to us when seeking support on very complex problems.'); 
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);?>
<?php csv2post_panel_header( $panel_array );?>
    <ul>
        <li><strong>Wordpress Database Charset:</strong> <?php echo DB_CHARSET; ?></li>
        <li><strong>Wordpress Blog Charset:</strong> <?php echo get_option('blog_charset'); ?></li>                           
    </ul> 
<?php csv2post_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'phpsettings';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('PHP Settings (php.ini)');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Checks the status of php settings that effect this plugin.');
$panel_array['panel_help'] = __('This show the status of what are actually called php directives. These are a type of setting that can be configured in the php.ini file used by your server. Your hosting will configure this to suit the service they are providing and the values may effect this plugin.'); 
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);?>
<?php csv2post_panel_header( $panel_array );?>
    <?php
    function csv2post_phpdirectives_list(){

    }
    csv2post_phpdirectives_list();?>
<?php csv2post_panel_footer();?> 