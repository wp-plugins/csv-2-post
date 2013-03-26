<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'panelone';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Panel One');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('Settings related to data import, manipulation and updating.');
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
            <th scope="row">CSV Read Method</th>
            <td>
        
                <script>
                    $(function() {
                        $( "#csv2post_div_<?php echo $panel_array['panel_name'];?>_csvreadmethod" ).buttonset();
                    });
                </script>

                <?php 
                // if is not set ['admintriggers']['newcsvfiles']['status'] then it is enabled by default
                if(!isset($csv2post_adm_set['data']['csvimportmethod'])){
                    $radio1_checked_none = 'checked';     
                    $radio2_checked_utf8 = '';                    
                }else{
                    if($csv2post_adm_set['data']['csvimportmethod'] == 'fgetcsv'){
                        $radio1_checked_none = 'checked'; 
                        $radio2_checked_utf8 = '';    
                    }elseif($csv2post_adm_set['data']['csvimportmethod'] == 'pearcsv'){
                        $radio1_checked_none = ''; 
                        $radio2_checked_utf8 = 'checked';    
                    }
                }?>
                <div id="csv2post_div_<?php echo $panel_array['panel_name'];?>_csvreadmethod">
                    <input type="radio" id="csv2post_<?php echo $panel_array['panel_name'];?>_csvreadmethod_fgetcsv" name="csv2post_radiogroup_csvreadmethod" value="fgetcsv" <?php echo $radio1_checked_fgetcsv;?> /><label for="csv2post_<?php echo $panel_array['panel_name'];?>_csvreadmethod_fgetcsv">fgetcsv (default)</label>
                    <input type="radio" id="csv2post_<?php echo $panel_array['panel_name'];?>_csvreadmethod_pearcsv" name="csv2post_radiogroup_csvreadmethod" value="pearcsv" <?php echo $radio2_checked_pearcsv;?> /><label for="csv2post_<?php echo $panel_array['panel_name'];?>_csvreadmethod_pearcsv">PEAR CSV</label>
                </div> 
                
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