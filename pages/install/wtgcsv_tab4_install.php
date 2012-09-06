<?php
##############################################################################################################
#                                                                                                            #
#                                          INITIAL INSTALLATION SCREEN                                       #
#                                                                                                            #
##############################################################################################################
global $wtgcsv_reinstall_intro_0110,$wtgcsv_reinstall_help_0110,$wtgcsv_uninstall_intro_0210,$wtgcsv_uninstall_help_0210;

if($wtgcsv_is_installed){
    wtgcsv_notice('Activation has already been done, this tab is displayed to 
    aid testing of the other activation choices only. Please do not use any of 
    the features on this tab if you are happy with your current installation of 
    '.WTG_CSV_PLUGINTITLE.'.','info','Small','');
    
    // going to exit here, this tab should never be loaded if the plugin is installed or was installed (it is for first time install only)
    exit;### TODO:HIGHPRIORITY, how does this effect the blog when it happens? it may need to be removed
}?>

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'premiumuseractivation';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Activation Controls');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $wtgcsv_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('The current activation controls are basic but will eventually offer more options');
$panel_array['panel_help'] = __('A key aspect of Wordpress CSV Importer is the remote support provided using web services. The controls will eventually allow users to register their domain on their members account. The plugin will send the domain too the plugins website and it will be stored. This allows the use of remote support features and priority responses for any matters concerning a specific domain. To register a domain from the plugin itself, email authorisation will be required. This simple means the current user of the plugin must have the same email address in their blog as registered on the plugins website. A simple security step to reduce the number of none paying users getting priority support.'); 
$panel_array['help_button'] = wtgcsv_helpbutton_text(false,false);
$panel_array['panel_state'] = 1;// 0=closed 1=open
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = wtgcsv_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);               
$jsform_set['has_options'] = true;// true or false (controls output of selected settings)
$jsform_set['dialoguebox_title'] = 'Installing Wordpress CSV Importer';
$jsform_set['noticebox_content'] = 'Would you like to begin installation of all require option table records, database tables and files?';?>

<?php wtgcsv_panel_header( $panel_array );?>

    <?php wtgcsv_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','wtgcsv_form','');?>

    <h4>Register This Domain (not in use yet)</h4>
    <input type="radio" name="method" value="yes" selected="selected" disabled="disabled" /> Yes<br />
    <input type="radio" name="method" value="no" disabled="disabled" /> No

    <br /><br />
    
    <?php 
    // add the javascript that will handle our form action, prevent submission and display dialogue box
    wtgcsv_jqueryform_singleaction_middle($jsform_set,$wtgcsv_options_array);

    // add end of form - dialogue box does not need to be within the <form>
    wtgcsv_formend_standard('Activate',$jsform_set['form_id']);?>

    <br />        
 
    <?php wtgcsv_jquery_form_prompt($jsform_set);?>

<?php wtgcsv_panel_footer();?>