<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'operationsettings';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Operation Settings');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('A mix of settings that change how
the plugin operates. These are global settings and apply to all projects.');
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
            <th scope="row">All Log Files</th>
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
                    <input type="radio" id="csv2post_<?php echo $panel_array['panel_name'];?>_logstatus_enable" name="csv2post_radiogroup_logstatus" value="1" <?php echo $radio1_uselog_enabled;?> /><label for="csv2post_<?php echo $panel_array['panel_name'];?>_logstatus_enable">Enable</label>
                    <input type="radio" id="csv2post_<?php echo $panel_array['panel_name'];?>_logstatus_disable" name="csv2post_radiogroup_logstatus" value="0" <?php echo $radio2_uselog_disabled;?> /><label for="csv2post_<?php echo $panel_array['panel_name'];?>_logstatus_disable">Disable</label>
                </div>     

            </td>
        </tr>
        <!-- Option End -->
        
        <!-- Option Start -->
        <?php
        // establish log file size limit
        $log_file_limit = 307200;
        if(isset($csv2post_adm_set['reporting']['loglimit']) && is_numeric($csv2post_adm_set['reporting']['loglimit'])){
            $log_file_limit = $csv2post_adm_set['reporting']['loglimit'];
        } ?>         
        <tr valign="top">
            <th scope="row">Log File Size Limit (<?php echo 'currently: ' . csv2post_format_file_size($log_file_limit);?>)</th>
            <td>
                <label for="csv2post_<?php echo $panel_array['panel_name'];?>_loglimit">
                <input type="text" name="csv2post_loglimit" id="csv2post_<?php echo $panel_array['panel_name'];?>_loglimit" value="<?php echo $log_file_limit;?>"></label>
            </td>
        </tr>
        <!-- Option End -->     

        <!-- Option Start -->
        <tr valign="top">
            <th scope="row">Detect New CSV Files Status</th>
            <td>
                <script>
                    $(function() {
                        $( "#csv2post_div_<?php echo $panel_array['panel_name'];?>_detectnewcsvfiles" ).buttonset();
                    });
                </script>

                <?php 
                // if is not set ['admintriggers']['newcsvfiles']['status'] then it is enabled by default
                if(!isset($csv2post_adm_set['admintriggers']['newcsvfiles']['status'])){
                    $radio1_checked_enabled = 'checked'; 
                    $radio2_checked_disabled = '';                    
                }else{
                    if($csv2post_adm_set['admintriggers']['newcsvfiles']['status'] == 1){
                        $radio1_checked_enabled = 'checked'; 
                        $radio2_checked_disabled = '';    
                    }elseif($csv2post_adm_set['admintriggers']['newcsvfiles']['status'] == 0){
                        $radio1_checked_enabled = ''; 
                        $radio2_checked_disabled = 'checked';    
                    }
                }?>
                <div id="csv2post_div_<?php echo $panel_array['panel_name'];?>_detectnewcsvfiles">
                    <input type="radio" id="csv2post_<?php echo $panel_array['panel_name'];?>_detectnewcsvfiles_enable" name="csv2post_radiogroup_detectnewcsvfiles" value="1" <?php echo $radio1_checked_enabled;?> /><label for="csv2post_<?php echo $panel_array['panel_name'];?>_detectnewcsvfiles_enable">Enable</label>
                    <input type="radio" id="csv2post_<?php echo $panel_array['panel_name'];?>_detectnewcsvfiles_disable" name="csv2post_radiogroup_detectnewcsvfiles" value="0" <?php echo $radio2_checked_disabled;?> /><label for="csv2post_<?php echo $panel_array['panel_name'];?>_detectnewcsvfiles_disable">Disable</label>
                </div>  

            </td>
        </tr>
        <!-- Option End --> 

        <!-- Option Start -->
        <tr valign="top">
            <th scope="row">Detect New CSV Files Output</th>
            <td>

                <script>
                    $(function() {
                        $( "#csv2post_div_<?php echo $panel_array['panel_name'];?>_detectnewcsvfiles_display" ).buttonset();
                    });
                </script>

                <?php 
                // if is not set ['admintriggers']['newcsvfiles']['display'] then it is enabled by default
                if(!isset($csv2post_adm_set['admintriggers']['newcsvfiles']['display'])){
                    $radio1_checked_enabled = 'checked'; 
                    $radio2_checked_disabled = '';                    
                }else{
                    if($csv2post_adm_set['admintriggers']['newcsvfiles']['display'] == 1){
                        $radio1_checked_enabled = 'checked'; 
                        $radio2_checked_disabled = '';    
                    }elseif($csv2post_adm_set['admintriggers']['newcsvfiles']['display'] == 0){
                        $radio1_checked_enabled = ''; 
                        $radio2_checked_disabled = 'checked';    
                    }
                }?>
                <div id="csv2post_div_<?php echo $panel_array['panel_name'];?>_detectnewcsvfiles_display">
                    <input type="radio" id="csv2post_<?php echo $panel_array['panel_name'];?>_detectnewcsvfiles_display_enable" name="csv2post_radiogroup_detectnewcsvfiles_display" value="1" <?php echo $radio1_checked_enabled;?> /><label for="csv2post_<?php echo $panel_array['panel_name'];?>_detectnewcsvfiles_display_enable">Display</label>
                    <input type="radio" id="csv2post_<?php echo $panel_array['panel_name'];?>_detectnewcsvfiles_display_disable" name="csv2post_radiogroup_detectnewcsvfiles_display" value="0" <?php echo $radio2_checked_disabled;?> /><label for="csv2post_<?php echo $panel_array['panel_name'];?>_detectnewcsvfiles_display_disable">Hide</label>
                </div>     

            </td>
        </tr>
        <!-- Option End --> 

        <!-- Option Start -->
        <tr valign="top">
            <th scope="row">Post Filter</th>
            <td>
            
                <script>
                    $(function() {
                        $( "#csv2post_div_<?php echo $panel_array['panel_name'];?>_postfilter" ).buttonset();
                    });
                </script>

                <?php 
                // if is not set ['admintriggers']['newcsvfiles']['status'] then it is enabled by default
                if(isset($csv2post_adm_set['postfilter']['status']) && $csv2post_adm_set['postfilter']['status'] == true){
                    $radio1_checked_enabled = 'checked'; 
                    $radio2_checked_disabled = '';                    
                }else{
                    $radio1_checked_enabled = ''; 
                    $radio2_checked_disabled = 'checked';    
                }?>
                <div id="csv2post_div_<?php echo $panel_array['panel_name'];?>_postfilter">
                    <input type="radio" id="csv2post_<?php echo $panel_array['panel_name'];?>_postfilter_enable" name="csv2post_radiogroup_postfilter" value="1" <?php echo $radio1_checked_enabled;?> /><label for="csv2post_<?php echo $panel_array['panel_name'];?>_postfilter_enable">Enable</label>
                    <input type="radio" id="csv2post_<?php echo $panel_array['panel_name'];?>_postfilter_disable" name="csv2post_radiogroup_postfilter" value="0" <?php echo $radio2_checked_disabled;?> /><label for="csv2post_<?php echo $panel_array['panel_name'];?>_postfilter_disable">Disable</label>
                </div>
                 
            </td>
        </tr>
        <!-- Option End -->

        <!-- Option Start -->
        <tr valign="top">
            <th scope="row">Spinner Token Re-spin (requires Post Filter)</th>
            <td>
        
                <script>
                    $(function() {
                        $( "#csv2post_div_<?php echo $panel_array['panel_name'];?>_spinnertokenrespin" ).buttonset();
                    });
                </script>

                <?php 
                // if is not set ['admintriggers']['newcsvfiles']['status'] then it is enabled by default
                if(isset($csv2post_adm_set['postfilter']['tokenrespin']['status']) && $csv2post_adm_set['postfilter']['tokenrespin']['status'] == true){
                    $radio1_checked_enabled = 'checked'; 
                    $radio2_checked_disabled = '';                    
                }else{
                    $radio1_checked_enabled = ''; 
                    $radio2_checked_disabled = 'checked';    
                }?>
                <div id="csv2post_div_<?php echo $panel_array['panel_name'];?>_spinnertokenrespin">
                    <input type="radio" id="csv2post_<?php echo $panel_array['panel_name'];?>_spinnertokenrespin_enable" name="csv2post_radiogroup_spinnertokenrespin" value="1" <?php echo $radio1_checked_enabled;?> /><label for="csv2post_<?php echo $panel_array['panel_name'];?>_spinnertokenrespin_enable">Enable</label>
                    <input type="radio" id="csv2post_<?php echo $panel_array['panel_name'];?>_spinnertokenrespin_disable" name="csv2post_radiogroup_spinnertokenrespin" value="0" <?php echo $radio2_checked_disabled;?> /><label for="csv2post_<?php echo $panel_array['panel_name'];?>_spinnertokenrespin_disable">Disable</label>
                </div>  
                    
            </td>
        </tr>
        <!-- Option End -->

        <!-- Option Start -->
        <tr valign="top">
            <th scope="row">Encoding</th>
            <td>
        
                <script>
                    $(function() {
                        $( "#csv2post_div_<?php echo $panel_array['panel_name'];?>_encoding" ).buttonset();
                    });
                </script>

                <?php 
                // if is not set ['admintriggers']['newcsvfiles']['status'] then it is enabled by default
                if(!isset($csv2post_adm_set['encoding']['type'])){
                    $radio1_checked_none = 'checked';     
                    $radio2_checked_utf8 = '';                    
                }else{
                    if($csv2post_adm_set['encoding']['type'] == 'none'){
                        $radio1_checked_none = 'checked'; 
                        $radio2_checked_utf8 = '';    
                    }elseif($csv2post_adm_set['encoding']['type'] == 'utf8'){
                        $radio1_checked_none = ''; 
                        $radio2_checked_utf8 = 'checked';    
                    }
                }?>
                <div id="csv2post_div_<?php echo $panel_array['panel_name'];?>_encoding">
                    <input type="radio" id="csv2post_<?php echo $panel_array['panel_name'];?>_encoding_none" name="csv2post_radiogroup_encoding" value="none" <?php echo $radio1_checked_none;?> /><label for="csv2post_<?php echo $panel_array['panel_name'];?>_encoding_none">None</label>
                    <input type="radio" id="csv2post_<?php echo $panel_array['panel_name'];?>_encoding_utf8" name="csv2post_radiogroup_encoding" value="utf8" <?php echo $radio2_checked_utf8;?> /><label for="csv2post_<?php echo $panel_array['panel_name'];?>_encoding_utf8">UTF-8 (utf8_encode)</label>
                </div> 
                
            </td>
        </tr>
        <!-- Option End -->

        <!-- Option Start -->
        <tr valign="top">
            <th scope="row">Extension Status</th>
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
                    <input type="radio" id="csv2post_<?php echo $panel_array['panel_name'];?>_enable" name="csv2post_radiogroup_extensionstatus" value="enable" <?php echo $radio1_checked_enabled;?> /><label for="csv2post_<?php echo $panel_array['panel_name'];?>_enable">Enable</label>
                    <input type="radio" id="csv2post_<?php echo $panel_array['panel_name'];?>_disable" name="csv2post_radiogroup_extensionstatus" value="disable" <?php echo $radio2_checked_disabled;?> /><label for="csv2post_<?php echo $panel_array['panel_name'];?>_disable">Disable</label>
                </div>    

                <?php ### TODO:LOWPRIORITY, list present extensions and allow user to select the extension they want to be active.?>      

            </td>
        </tr>
        <!-- Option End -->

    </table>
    
    <?php 
    // add js for dialog on form submission and the dialog <div> itself
    if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
        csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
        csv2post_jquery_form_prompt($jsform_set);
    }
    ?>
        
    <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>
   
<?php csv2post_panel_footer();?>

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'interfacesettings';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Interface Settings');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('Change how the plugins interface
operates and how it appears.'); 
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);
$jsform_set['dialogbox_title'] = 'Change Plugin Interface Settings'; 
$jsform_set['noticebox_content'] = 'Do you want to change interface settings?';?>
<?php csv2post_panel_header( $panel_array );?> 
         
    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?> 
    
    <?php csv2post_n_incontent('Added Feb 2013. This feature is not complete, it will strip the interface down to minimum
    functionality. Some features become hidden until work is finished.','warning','Small','Beta');?>
                   
    <?php if($csv2post_guitheme == 'jquery'){?>
    <script>
    $(function() {
        $( "#csv2post_theme_selection" ).buttonset();
    });
    </script>
    <?php }?>

    <div id="csv2post_theme_selection">
        <?php 
        if(!isset($csv2post_guitheme) || $csv2post_guitheme == 'jquery'){
            $j = 'checked="checked"'; 
            $w = '';         
        }elseif($csv2post_guitheme == 'wordpresscss'){
            $j = ''; 
            $w = 'checked="checked"';            
        }

        echo '<input type="radio" id="csv2post_themeoption_jqueryui" name="csv2post_themeradios" value="jquery" '.$j.' />';
        echo '<label for="csv2post_themeoption_jqueryui">';
        if($csv2post_guitheme == 'jquery'){ echo '<img src="'.WTG_C2P_IMAGEFOLDER_URL.'jquerytheme.png" alt="Use jQuery UI Theming" width="80" height="80" /><br />';}
        echo 'jQuery UI</label>';  
        
        if($csv2post_guitheme != 'jquery'){echo '<br />';}
          
        echo '<input type="radio" id="csv2post_themeoption_wordpresscss" name="csv2post_themeradios" value="wordpresscss" '.$w.' />';
        echo '<label for="csv2post_themeoption_wordpresscss">'; 
        if($csv2post_guitheme == 'jquery'){ echo '<img src="'.WTG_C2P_IMAGEFOLDER_URL.'wordpressthemecss.png" alt="Use Wordpress Theming CSS Only" width="80" height="80" /><br />';}
        echo 'Wordpress CSS</label>';?>                      
    </div>
     
    <h4>Form Submission Dialog Popups</h4>
    <?php  
    $hide = '';
    $display = 'checked';    
    if(isset($csv2post_adm_set['interface']['forms']['dialog']['status'])){                      
        if($csv2post_adm_set['interface']['forms']['dialog']['status'] == 'hide'){
            $hide = 'checked';
            $display = '';    
        }elseif($csv2post_adm_set['interface']['forms']['dialog']['status'] == 'display'){
            $hide = '';
            $display = 'checked';    
        }
    }?>
    <script>
        $(function() {
            $( "#csv2post_div_<?php echo $panel_array['panel_name'];?>_dialog" ).buttonset();
        });
    </script>    
    <div id="csv2post_div_<?php echo $panel_array['panel_name'];?>_dialog">
        <input type="radio" id="csv2post_<?php echo $panel_array['panel_name'];?>_dialog_hide" name="csv2post_radiogroup_dialog" value="hide" <?php echo $hide;?> /><label for="csv2post_<?php echo $panel_array['panel_name'];?>_dialog_hide">Hide</label>
        <input type="radio" id="csv2post_<?php echo $panel_array['panel_name'];?>_dialog_display" name="csv2post_radiogroup_dialog" value="display" <?php echo $display;?> /><label for="csv2post_<?php echo $panel_array['panel_name'];?>_dialog_display">Display</label>
    </div>
    
    <h4>Panel Support Buttons</h4>
    <?php  
    $hide = '';
    $display = 'checked';    
    if(isset($csv2post_adm_set['interface']['panels']['supportbuttons']['status'])){                      
        if($csv2post_adm_set['interface']['panels']['supportbuttons']['status'] == 'hide'){
            $hide = 'checked';
            $display = '';    
        }elseif($csv2post_adm_set['interface']['panels']['supportbuttons']['status'] == 'display'){
            $hide = '';
            $display = 'checked';    
        }
    }?>
    <script>
        $(function() {
            $( "#csv2post_div_<?php echo $panel_array['panel_name'];?>_supportbuttons" ).buttonset();
        });
    </script>    
    <div id="csv2post_div_<?php echo $panel_array['panel_name'];?>_supportbuttons">
        <input type="radio" id="csv2post_<?php echo $panel_array['panel_name'];?>_supportbuttons_hide" name="csv2post_radiogroup_supportbuttons" value="hide" <?php echo $hide;?> /><label for="csv2post_<?php echo $panel_array['panel_name'];?>_supportbuttons_hide">Hide</label>
        <input type="radio" id="csv2post_<?php echo $panel_array['panel_name'];?>_supportbuttons_display" name="csv2post_radiogroup_supportbuttons" value="display" <?php echo $display;?> /><label for="csv2post_<?php echo $panel_array['panel_name'];?>_supportbuttons_display">Display</label>
    </div> 
     

    <?php 
    // add js for dialog on form submission and the dialog <div> itself
    if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
        csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
        csv2post_jquery_form_prompt($jsform_set);
    }
    ?>
        
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
            echo '<table class="widefat post fixed">';
            echo '<tr><td><strong>Screen Name</strong></td><td><strong>Default Required Capability</strong></td><td><strong>Current Required Capability</strong></td></tr>';
            
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
            
            echo '</table>';
        }
        
        echo '<input type="hidden" name="csv2post_total_menus" value="'.$menu_id.'">'; 
        ?>

        <?php 
        // add js for dialog on form submission and the dialog <div> itself
        if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
            csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
            csv2post_jquery_form_prompt($jsform_set);
        }
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
        echo '<table class="widefat post fixed">';
        echo '<tr><td><strong>Page Name</strong></td><td><strong>Default Required Capability</strong></td><td><strong>Current Required Capability</strong></td></tr>';
                
        foreach($csv2post_mpt_arr['menu'] as $page_name => $page_array){

            echo '<tr>';
            
            echo '<td>' . $page_name . '</td>';

            echo '<td>' . csv2post_WP_SETTINGS_get_page_capability($page_name,true). '</td>';
            
            echo '<td>';

            csv2post_FORM_menu_capabilities($csv2post_ARRAY_capabilities,$page_name,99,csv2post_WP_SETTINGS_get_page_capability($page_name,$key,false));     
                                                                                          
            echo '</td>';
            
            echo '</tr>';
        }
        
        echo '</table>';?>

        <?php 
        // add js for dialog on form submission and the dialog <div> itself
        if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
            csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
            csv2post_jquery_form_prompt($jsform_set);
        }
        ?>
            
        <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>

    <?php csv2post_panel_footer();
}?>