<?php
/** 
 * Free edition file (applies to paid also) for CSV 2 POST plugin by WebTechGlobal.co.uk
 *
 * @package CSV 2 POST
 * 
 * @author Ryan Bayne | ryan@webtechglobal.co.uk
 */
 
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'operationsettings';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Operation Settings');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);     
$jsform_set['dialogbox_title'] = 'Save Settings';
$jsform_set['noticebox_content'] = 'It is recommended you monitor the plugin for a short time after changing these settings. Do you wish to continue?';?>
<?php csv2post_panel_header( $panel_array );?>

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);?>

    <table class="form-table">
    
        <!-- Option Start -->
        <script>
            $(function() {
                $( "#csv2post_div_<?php echo $panel_array['panel_name'];?>_reporting_logstatus" ).buttonset();
            });
        </script>  
          
        <tr valign="top">
            <th scope="row"> <?php c2p_tt('Log','The plugin creates a lot of user actions and automation. The purpose of the log is for tracking users, debugging during development and monitoring automation is happening when needed. Log entries are stored in a database table named csv2post_log');?> </th>
            <td>
                <?php 
                // if is not set ['admintriggers']['newcsvfiles']['status'] then it is enabled by default
                if(!isset($csv2post_adm_set['reporting']['uselog'])){
                    $radio1_uselog_enabled = 'checked'; 
                    $radio2_uselog_disabled = '';                    
                }else{
                    if($csv2post_adm_set['reporting']['uselog'] == 1){
                        $radio1_uselog_enabled = 'checked'; 
                        $radio2_uselog_disabled = '';    
                    }elseif($csv2post_adm_set['reporting']['uselog'] == 0){
                        $radio1_uselog_enabled = ''; 
                        $radio2_uselog_disabled = 'checked';    
                    }
                }?>
                <div id="csv2post_div_<?php echo $panel_array['panel_name'];?>_reporting_logstatus">
                    <input type="radio" id="csv2post_<?php echo $panel_array['panel_name'];?>_logstatus_enable" name="csv2post_radiogroup_logstatus" value="1" <?php echo $radio1_uselog_enabled;?> />
                    <label for="csv2post_<?php echo $panel_array['panel_name'];?>_logstatus_enable"> Enable</label>
                    <?php csv2post_GUI_br();?>
                    <input type="radio" id="csv2post_<?php echo $panel_array['panel_name'];?>_logstatus_disable" name="csv2post_radiogroup_logstatus" value="0" <?php echo $radio2_uselog_disabled;?> />
                    <label for="csv2post_<?php echo $panel_array['panel_name'];?>_logstatus_disable"> Disable</label>
                </div>     

            </td>
        </tr>
        <!-- Option End -->
        
        <!-- Option Start -->
        <?php
        $log_file_limit = 1000;
        if(isset($csv2post_adm_set['reporting']['loglimit']) && is_numeric($csv2post_adm_set['reporting']['loglimit'])){
            $log_file_limit = $csv2post_adm_set['reporting']['loglimit'];
        } ?>         
        <tr valign="top">
            <th scope="row"> <?php c2p_tt('Log Entries Limit','Control the number of rows stored in the log table. A low number will have little or no different to the performance of your Wordpress but it will improve performance when using the Log screen to perform searches');?> </th>
            <td>
                <label for="csv2post_<?php echo $panel_array['panel_name'];?>_loglimit">
                <input type="text" name="csv2post_loglimit" id="csv2post_<?php echo $panel_array['panel_name'];?>_loglimit" value="<?php echo $log_file_limit;?>"> rows</label>
            </td>
        </tr>
        <!-- Option End -->     

        <!-- Option Start -->
        <tr valign="top">
            <th scope="row"> <?php c2p_tt('Extension System','If you have extension files installed you will need to activate the extension system. You can then use the Extensions screen to manage your extension');?> </th>
            <td>
            
                <script>
                    $(function() {
                        $( "#csv2post_div_<?php echo $panel_array['panel_name'];?>_extensionstatus" ).buttonset();
                    });
                </script>
 
                <?php 
                if(csv2post_option('csv2post_extensions','get') == 'enable'){
                    $radio1_checked_enabled = 'checked';
                    $radio2_checked_disabled = '';    
                }elseif(csv2post_option('csv2post_extensions','get') == 'disable'){
                    $radio1_checked_enabled = '';
                    $radio2_checked_disabled = 'checked';    
                }?>
                <div id="csv2post_div_<?php echo $panel_array['panel_name'];?>_extensionstatus">
                    <input type="radio" id="csv2post_<?php echo $panel_array['panel_name'];?>_enable" name="csv2post_radiogroup_extensionstatus" value="enable" <?php echo $radio1_checked_enabled;?> />
                    <label for="csv2post_<?php echo $panel_array['panel_name'];?>_enable"> Enable</label>
                    <?php csv2post_GUI_br();?>
                    <input type="radio" id="csv2post_<?php echo $panel_array['panel_name'];?>_disable" name="csv2post_radiogroup_extensionstatus" value="disable" <?php echo $radio2_checked_disabled;?> />
                    <label for="csv2post_<?php echo $panel_array['panel_name'];?>_disable"> Disable</label>
                </div>    

                <?php ### TODO:LOWPRIORITY, list present extensions and allow user to select the extension they want to be active.?>      

            </td>
        </tr>
        <!-- Option End -->

    </table>
        
    <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>
   
<?php csv2post_panel_footer();?>

<?php
if(isset($csv2post_adm_set['ecq'][109]) && $csv2post_adm_set['ecq'][109] == 'yes'){
    ++$panel_number;// increase panel counter so this panel has unique ID
    $panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
    $panel_array['panel_name'] = 'screenpermissions';// slug to act as a name and part of the panel ID 
    $panel_array['panel_title'] = __('Screen Permissions');// user seen panel header text 
    $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
    $panel_array['panel_help'] = __('Screens are the individual tabbed parts of the interface. We refer to the whole set
    of screens as being on a specific page as selected in the plugins main menu. These settings do not configure Page access,
    another panel does this. This panel allows us to set access permissions per tabbed screen (not per page) based on Wordpress user capabilities.
    Wordpress capabilities allow specific users to be giving specific permission which
    can ignore their role i.e. Editor, Author, Subscriber. This interface allows us to allow specific users access
    to individual screens rather than allowing everyone with a specific role to access them.'); 
    // Form Settings - create the array that is passed to jQuery form functions
    $jsform_set_override = array();
    $jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);
    $jsform_set['dialogbox_title'] = 'Change Screen Permissions'; 
    $jsform_set['noticebox_content'] = 'Changing these settings can potentially allow users to access content they are not authorized?';?>
    <?php csv2post_panel_header( $panel_array );?> 
             
        <?php 
        // begin form and add hidden values
        csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');
        csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
        ?>
      
        <?php      
        // include capabilities array for ther permissions forms
        require( WTG_C2P_DIR . 'wtg-core/wp/wparrays/wtgcore_wp_capabilities_array.php' );

        ### TODO:CRITICAL, create an array of capabilities and feed it to the capability menu so we are not looping through the roles array many times
        $menu_id = 0;
        foreach($csv2post_mpt_arr['menu'] as $page_name => $page_array){
            
            echo '<h2>' . $page_name . '</h2>';
            csv2post_GUI_tablestart();
            echo '
            <thead>
                <tr>
                    <th>Screen Name</td>
                    <th>Default Required Capability</th>
                    <th>Current Required Capability</th>
                </tr>
            </thead>';
            echo '
            <tfoot>
                <tr>
                    <th>Screen Name</td>
                    <th>Default Required Capability</th>
                    <th>Current Required Capability</th>
                </tr>
            </tfoot>';
            
            echo '<tbody>';
                       
            foreach($page_array['tabs'] as $key => $tab_array){
                
                // do not display tab names for screens user is not meant to see
                if(isset($tab_array['display']) && $tab_array['display'] != false){
                                        
                    echo '<tr>';
                    
                    echo '<td>' . $tab_array['label'] . '</td>';
           
                    echo '<td>' . csv2post_WP_SETTINGS_get_tab_capability($page_name,$key,true). '</td>';
                    
                    echo '<td>';

                    csv2post_FORM_menu_capabilities($csv2post_ARRAY_capabilities,$page_name,$key,csv2post_WP_SETTINGS_get_tab_capability($page_name,$key,false));     
                                                             
                    echo '</td>';
                    
                    echo '</tr>';
                
                    ++$menu_id; 
                }        
            }
            
            echo '<tbody></table>';
        }
        
        echo '<input type="hidden" name="csv2post_total_menus" value="'.$menu_id.'">'; 
        ?>

        <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>

    <?php csv2post_panel_footer();
}?>

<?php
if(isset($csv2post_adm_set['ecq'][109]) && $csv2post_adm_set['ecq'][109] == 'yes'){
    ++$panel_number;// increase panel counter so this panel has unique ID
    $panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
    $panel_array['panel_name'] = 'pagepermissions';// slug to act as a name and part of the panel ID 
    $panel_array['panel_title'] = __('Page Permissions');// user seen panel header text 
    $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
    $panel_array['panel_help'] = __('This panel allows you to configure which Wordpess capabilities are required
    to access each page. If a user does not have the required capability, the page will not be displayed in the plugins
    menu and none of the pages screens can be visited by URL either.'); 
    // Form Settings - create the array that is passed to jQuery form functions
    $jsform_set_override = array();
    $jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);
    $jsform_set['dialogbox_title'] = 'Change Page Permissions'; 
    $jsform_set['noticebox_content'] = 'Changing these settings can potentially allow users to access content they are not authorized?';?>
    <?php csv2post_panel_header( $panel_array );?> 
             
        <?php 
        // begin form and add hidden values
        csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');
        csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
        ?>
      
        <?php   
        ### TODO:CRITICAL, create an array of capabilities and feed it to the capability menu so we are not looping through the roles array many times
        csv2post_GUI_tablestart();
        echo '
        <thead>
            <tr>
                <th>Page Name</td>
                <th>Default Required Capability</th>
                <th>Current Required Capability</th>
            </tr>
        </thead>';
        echo '
        <tfoot>
            <tr>
                <th>Page Name</td>
                <th>Default Required Capability</th>
                <th>Current Required Capability</th>
            </tr>
        </tfoot>';
        
        echo '<tbody>';
                        
        foreach($csv2post_mpt_arr['menu'] as $page_name => $page_array){

            echo '<tr>';
            
            echo '<td>' . $page_name . '</td>';

            echo '<td>' . csv2post_WP_SETTINGS_get_page_capability($page_name,true). '</td>';
            
            echo '<td>';

            csv2post_FORM_menu_capabilities($csv2post_ARRAY_capabilities,$page_name,99,csv2post_WP_SETTINGS_get_page_capability($page_name,$key,false));     
                                                                                          
            echo '</td>';
            
            echo '</tr>';
        }
        
        echo '</tbody></table>';?>
            
        <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>

    <?php csv2post_panel_footer();
}?>