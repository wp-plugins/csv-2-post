<?php
if(!isset($csv2post_project_array['custom_fields'])){
    echo csv2post_notice('No post meta (custom fields) have been saved.','warning','Tiny','','','return');
}else{
    echo csv2post_notice('You have saved post meta settings (custom fields) for this project.','info','Tiny','','','return');
}
?>

<?php
### TODO:LOWPRIORITY, for premium edition, use suggestions in the text field for known themes
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'createbasiccustomfieldrules';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Create Basic Custom Field Rules');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Put your data into custom fields by entering the key and selecting the data column');
$panel_array['panel_help'] = __('You can setup as many custom fields as you wish. Enter your custom field key (meta-key) you wish all your posts to have. Then select the column of data that you wish to populate your custom field value with.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);               
$jsform_set['dialogbox_title'] = 'Save Custom Field Rule';
$jsform_set['noticebox_content'] = 'Do you want to save your new custom field rule and put the selected data into your entered meta-key?';
// TODO:MEDIUMPRIORITY,add option for default value for null data or option for custom field not to be added at all
?>
<?php csv2post_panel_header( $panel_array );?>

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?>
    
    Enter Custom Field Key: <input type="text" name="csv2post_key" />
    
    <br /><br />

    Select Data Column: 
    <select name="csv2post_customfield_select_columnandtable" id="csv2post_customfield_select_columnandtable_formid" class="csv2post_multiselect_menu">
        <?php csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code);?>                                                                                                                     
    </select>
    
    <br />
    
    <?php
    // add the javascript that will handle our form action, prevent submission and display dialog box
    csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);

    // add end of form - dialog box does not need to be within the <form>
    csv2post_formend_standard('Submit',$jsform_set['form_id']);?>

    <?php csv2post_jquery_form_prompt($jsform_set);?>

<?php csv2post_panel_footer();?>

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'deletebasiccustomfieldrules';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Delete Basic Custom Field Rules');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Your basic custom field rules are listed here for reference and to delete');
$panel_array['panel_help'] = __('Deleting a custom field/meta-key rule has no effect on posts already created with your current project. It will only discontinue the custom field from being created for new posts.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);               
$jsform_set['dialogbox_title'] = 'Delete Custom Field Rule';
$jsform_set['noticebox_content'] = 'Do you want to delete your custom field rule and discontinue the meta-key plus value being added to posts created by this project?';
// TODO:MEDIUMPRIORITY,add option for default value for null data or option for custom field not to be added at all
?>
<?php csv2post_panel_header( $panel_array );?>

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?>
    
    <?php csv2post_table_customfield_rules_basic(); ?>

    <?php
    // add the javascript that will handle our form action, prevent submission and display dialog box
    csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);

    // add end of form - dialog box does not need to be within the <form>
    csv2post_formend_standard('Submit',$jsform_set['form_id']);?>

    <?php csv2post_jquery_form_prompt($jsform_set);?>

<?php csv2post_panel_footer();?> 

<?php
if(!$csv2post_is_free){
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'createadvancedcustomfieldrules';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Create Advanced Custom Field Rules');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Create meta data with dynamic and unique content for good SEO');
$panel_array['panel_help'] = __('This feature is used to add meta values to your posts but as a feature we use the Custom Field term. You can setup as many custom field rules as you wish. Most themes require specific keys to be entered, please refer to your themes guide for a list of keys. Enter your custom field key (meta-key) you wish all your posts to have. Then select the column of data that you wish to populate your custom field value with or select a template. The template method allows you to create a template using the WYSIWYG editor on the Content screen. The result can be a very unique value and great for SEO. Keep in mind however that this is a little more work for CSV 2 POST to do during post creation.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,true);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);               
$jsform_set['dialogbox_title'] = 'Save Advanced Custom Field Rule';
$jsform_set['noticebox_content'] = 'Do you want to save your new custom field rule and put the selected data into your entered meta-key?';
### TODO:MEDIUMPRIORITY,add option for default value for null data or option for custom field not to be added at all
?>
<?php csv2post_panel_header( $panel_array );?>

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?>
    
    Enter Custom Field Key: <input type="text" name="csv2post_key" />
    
    <br /><br />

    Select Data Column: 
    <select name="csv2post_customfield_select_columnandtable" id="csv2post_advancedcustomfields_datacolumn" class="csv2post_multiselect_menu">
        <option value="notselected">Not Required</option>       
        <?php csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code);?>                                                                                                                     
    </select>

    <br />
    
    <p>                    
        Design: 
        <select name="csv2post_customfields_selecttemplate" id="csv2post_customfields_selecttemplate" class="csv2post_multiselect_menu">
            <option value="notselected">Not Required</option>
            <?php csv2post_display_contenttemplate_menuoptions();?>                                                                                                                     
        </select>        
    </p> 
    
    <script>
    $(function() {
        $( "#csv2post_advancedcustomfields_updatemeta" ).buttonset();
    });
    </script>

    <div id="csv2post_advancedcustomfields_updatemeta">
        Allow Updating: <input type="radio" id="csv2post_metaupdating_switch_on" name="csv2post_updatesettings_metaupdating_switch_inputname" value="on" /><label for="csv2post_metaupdating_switch_on">Yes</label>
        <input type="radio" id="csv2post_metaupdating_switch_off" name="csv2post_updatesettings_metaupdating_switch_inputname" value="off" /><label for="csv2post_metaupdating_switch_off">No</label>            
    </div>
        
    <?php
    // add the javascript that will handle our form action, prevent submission and display dialog box
    csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);

    // add end of form - dialog box does not need to be within the <form>
    csv2post_formend_standard('Submit',$jsform_set['form_id']);?>

    <?php csv2post_jquery_form_prompt($jsform_set);?>

<?php csv2post_panel_footer();
}?>

<?php 
### TODO:HIGHPRIORITY, ClassiPress panel listing all keys and options for adding data to them
### TODO:HIGHPRIORITY, ShopperPress panel listing all keys
### TODO:LOWPRIORITY, panel for submitting a list of keys for a giving theme name via web service
?>

<?php
if(!$csv2post_is_free){
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'deleteadvancedcustomfieldrules';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Delete Advanced Field Rules');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Your advanced custom field rules are listed here for reference and to delete');
$panel_array['panel_help'] = __('Deleting a custom field/meta-key rule has no effect on posts already created with your current project. It will only discontinue the custom field from being created for new posts.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,true);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);               
$jsform_set['dialogbox_title'] = 'Delete Custom Field Rule';
$jsform_set['noticebox_content'] = 'Do you want to delete your custom field rule and discontinue the meta-key plus value being added to posts created by this project?';
// TODO:MEDIUMPRIORITY,add option for default value for null data or option for custom field not to be added at all
?>
<?php csv2post_panel_header( $panel_array );?>

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?>
    
    <?php csv2post_table_customfield_rules_advanced(); ?>

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
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'usedcustomfieldkeys';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Used Custom Field (meta) Keys *global panel*');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('A list of all distinct meta-keys (used as custom field keys) for reference only');
$panel_array['panel_help'] = __('Any meta-key (custom field key) key you enter for a post will appear in this list. Some of Wordpress own standard/default meta-keys will also show, some will not. I have excluded custom field keys that I feel no one will ever wish to use. Should your project require a standard Wordpress meta-key not displayed in the list or in the menus please request it to be removed from the list of exclusions.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
?>
<?php csv2post_panel_header( $panel_array );?>
<?php csv2post_list_customfields(); ?>
<?php csv2post_panel_footer();?>
