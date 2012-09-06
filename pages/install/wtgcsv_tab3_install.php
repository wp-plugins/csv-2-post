<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'serverconfiguration';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Server Configuration');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $wtgcsv_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Displays details about your server that are important to '.WTG_CSV_PLUGINTITLE.'.');
$panel_array['panel_help'] = __('The list of information indicates configuration important to this software and in some cases will indicate the status of an item i.e. if a required extension is not installed on your server and required for '.WTG_CSV_PLUGINTITLE.' to operate properly this will be made clear.'); 
$panel_array['help_button'] = wtgcsv_helpbutton_text(false,false);?>
<?php wtgcsv_panel_header( $panel_array );?>
            
             <h4>Software</h4>
            <ul>
                <li><strong>PHP Version:</strong> <?php echo phpversion();?></li>
                <li><strong>MySQL Version:</strong> <?php echo wtgcsv_get_mysqlversion();?></li>            
            </ul>           
            
            <h4>Variables</h4>
            <ul>
                <li><strong>HTTP_HOST:</strong> <?php echo $_SERVER['HTTP_HOST'];?></li>
                <li><strong>SERVER_NAME:</strong> <?php echo $_SERVER['SERVER_NAME'];?></li>            
            </ul>
            
            <hr>
            
            <h4>Common PHP Functions (returned value)</h4>
            <ul>
                <li><strong>time():</strong> <?php echo time();?></li>
                <li><strong>date('Y-m-d H:i:s'):</strong> <?php echo date('Y-m-d H:i:s');?></li>
                <li><strong>date('e'):</strong> <?php echo date('e');?> (timezone identifier)</li>
                <li><strong>date('G'):</strong> <?php echo date('G');?> (24-hour format)</li>                   
            </ul>
            
<?php wtgcsv_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'phpsettings';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('PHP Settings (php.ini)');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $wtgcsv_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Checks the status of php settings that effect this plugin.');
$panel_array['panel_help'] = __('This show the status of what are actually called php directives. These are a type of setting that can be configured in the php.ini file used by your server. Your hosting will configure this to suit the service they are providing and the values may effect this plugin.'); 
$panel_array['help_button'] = wtgcsv_helpbutton_text(false,false);?>
<?php wtgcsv_panel_header( $panel_array );?>
            <?php
            function wtgcsv_phpdirectives_list(){

            }
            wtgcsv_phpdirectives_list();?>
<?php wtgcsv_panel_footer();?> 