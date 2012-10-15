<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'admintriggeredautomation';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Admin Triggered Automation');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Settings related to automatic events, processing the user does not need to initiate');
$panel_array['panel_help'] = __('Admin Triggered Automation settings basically activate or disable triggers
which do various checks/events/processing whenever someone is using the Wordpress administration area and is an
administrator. This allows us to perform tasks without it effecting visitors and output notifications to help
us get some idea on exactly what CSV 2 POST is doing. Most of the processing happens in the header of the plugins pages and
will output messages when something vital changes. The settings in this panel allow us to disable individual 
functionality happening at all and disable the visual outputs for that functionality. We can tailor
Admin Triggered Automation to suit our needs in great detail.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);     
$jsform_set['dialoguebox_title'] = 'Save Automation Settings';
$jsform_set['noticebox_content'] = 'Please ensure the schedule settings are setup to suit your needs before allowing automatic events. Do you wish to continue?';?>
<?php csv2post_panel_header( $panel_array );?>

    <?php csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');?>

    <table class="widefat post fixed">
        <tr class="first">
            <td width="200"><strong>Action</strong></td>
            <td width="200"><strong>Status</strong></td>                
            <td><strong>Output</strong></td>                                                                               
        </tr>
        <tr>
            <td>Detect New CSV Files</td>        
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
    </table>
    
    <?php
    // add the javascript that will handle our form action, prevent submission and display dialogue box
    csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);

    // add end of form - dialogue box does not need to be within the <form>
    csv2post_formend_standard('Submit',$jsform_set['form_id']);?>

    <?php csv2post_jquery_form_prompt($jsform_set);?>
   
<?php csv2post_panel_footer();?>

<?php 
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'encodingsettings';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Encoding');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Put CSV file data through encoding before it is inserted to database');
$panel_array['panel_help'] = __('The main requirement is putting data through a php function named utf8_encode(). Try and test all available encoding options. Encoding functions are being tested and we are discussion required features for encoding.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);     
$jsform_set['dialoguebox_title'] = 'Save Encoding Settings';
$jsform_set['noticebox_content'] = 'These encoding settings may effect your data during import and after import. You
should ensure you have made the correct selections by doing some testing. Do you wish to continue?';?>
<?php csv2post_panel_header( $panel_array );?>

    <?php csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');?>   

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
        if($csv2post_adm_set['encoding']['type'] == 0){
            $radio1_checked_none = 'checked'; 
            $radio2_checked_utf8 = '';    
        }elseif($csv2post_adm_set['encoding']['type'] == 'utf8'){
            $radio1_checked_none = ''; 
            $radio2_checked_utf8 = 'checked';    
        }
    }?>
    <div id="csv2post_div_<?php echo $panel_array['panel_name'];?>_encoding">
        <input type="radio" id="csv2post_<?php echo $panel_array['panel_name'];?>_encoding_none" name="csv2post_radiogroup_encoding" value="0" <?php echo $radio1_checked_none;?> /><label for="csv2post_<?php echo $panel_array['panel_name'];?>_encoding_none">None</label>
        <input type="radio" id="csv2post_<?php echo $panel_array['panel_name'];?>_encoding_utf8" name="csv2post_radiogroup_encoding" value="utf8" <?php echo $radio2_checked_utf8;?> /><label for="csv2post_<?php echo $panel_array['panel_name'];?>_encoding_utf8">UTF-8 (utf8_encode)</label>
    </div 

    <br />
    <?php
    // add the javascript that will handle our form action, prevent submission and display dialogue box
    csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);

    // add end of form - dialogue box does not need to be within the <form>
    csv2post_formend_standard('Submit',$jsform_set['form_id']);?>

    <?php csv2post_jquery_form_prompt($jsform_set);?>
   
    <br />           
    <?php 
    echo csv2post_notice('We are currently testing encoding functions.','info','Small','Encoding Testing: ','','return');
    ?>
    
    <h4>WP Blog Charset</h4>
    <?php echo get_option('blog_charset' );?> 
    
    <h4>WP Database Charset</h4>
    <?php echo DB_CHARSET;?>     
    
    <h4>Swedish Characters: wtgcore_encoding_clean_string('���')</h4>
    <?php echo wtgcore_encoding_clean_string('���');?>
    
    <h4>Swedish Characters: utf8_encode('���')</h4>
    <?php echo utf8_encode('���');?> (these are the characters being giving to all functions in code)   

    <h4>Swedish Characters and english characters: utf8_encode('beta testing only ���')</h4>
    <?php echo utf8_encode('beta testing only ���');?> 
    
    <h4>Swedish Characters: utf8_decode('���')</h4>
    <?php echo utf8_decode('���');?>      
   
<?php csv2post_panel_footer();?>

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'extensionsettings';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Extensions');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Configure the plugins extension ability');
$panel_array['panel_help'] = __('CSV 2 POST extension settings. If you do not have any extensions present
these settings will have no effect. Extensions are used to re-configure the CSV 2 POST core into what can be
seen as a totally different software. The extension system is provided in the free plugin but support for it is not.
If you wish to create an extension that uses the CSV 2 POST core you will need to access the information and
support through our premium services. This is an advanced system which requires guidance and possibly consultation.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);     
$jsform_set['dialoguebox_title'] = 'Save Extension Settings';
$jsform_set['noticebox_content'] = 'These settings will change the look and functionality of CSV 2 POST. Do you wish to continue?';?>
<?php csv2post_panel_header( $panel_array );?>

    <?php csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');?>

    <script>
        $(function() {
            $( "#csv2post_div_<?php echo $panel_array['panel_name'];?>_extensionstatus" ).buttonset();
        });
    </script>

    <h4>Extension Status</h4>
    <?php 
    if(WTG_C2P_EXTENSIONS == 'enable'){
        $radio1_checked_enabled = 'checked';
        $radio2_checked_disabled = '';    
    }elseif(WTG_C2P_EXTENSIONS == 'disable'){
        $radio1_checked_enabled = '';
        $radio2_checked_disabled = 'checked';    
    }?>
    <div id="csv2post_div_<?php echo $panel_array['panel_name'];?>_extensionstatus">
        <input type="radio" id="csv2post_<?php echo $panel_array['panel_name'];?>_enable" name="csv2post_radiogroup_extensionstatus" value="enable" <?php echo $radio1_checked_enabled;?> /><label for="csv2post_<?php echo $panel_array['panel_name'];?>_enable">Enable</label>
        <input type="radio" id="csv2post_<?php echo $panel_array['panel_name'];?>_disable" name="csv2post_radiogroup_extensionstatus" value="disable" <?php echo $radio2_checked_disabled;?> /><label for="csv2post_<?php echo $panel_array['panel_name'];?>_disable">Disable</label>
    </div>    

    <?php
    ### TODO:LOWPRIORITY, list present extensions and allow user to select the extension they want to be active.
    ?>      

    <?php
    // add the javascript that will handle our form action, prevent submission and display dialogue box
    csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);

    // add end of form - dialogue box does not need to be within the <form>
    csv2post_formend_standard('Submit',$jsform_set['form_id']);?>

    <?php csv2post_jquery_form_prompt($jsform_set);?>
   
<?php csv2post_panel_footer();?>