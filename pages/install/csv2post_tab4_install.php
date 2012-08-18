<?php
##############################################################################################################
#                                                                                                            #
#                                          INITIAL INSTALLATION SCREEN                                       #
#                                                                                                            #
##############################################################################################################
global $csv2post_reinstall_intro_0110,$csv2post_reinstall_help_0110,$csv2post_uninstall_intro_0210,$csv2post_uninstall_help_0210;

if($csv2post_is_installed){
    csv2post_notice('Activation has already been done, this tab is displayed to 
    aid testing of the other activation choices only. Please do not use any of 
    the features on this tab if you are happy with your current installation of 
    '.WTG_C2P_PLUGINTITLE.'.','info','Small','');
    
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
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('The current activation controls are basic but will eventually offer more options');
$panel_array['panel_help'] = __('A key aspect of CSV 2 POST is the remote support provided using web services. The controls will eventually allow users to register their domain on their members account. The plugin will send the domain too the plugins website and it will be stored. This allows the use of remote support features and priority responses for any matters concerning a specific domain. To register a domain from the plugin itself, email authorisation will be required. This simple means the current user of the plugin must have the same email address in their blog as registered on the plugins website. A simple security step to reduce the number of none paying users getting priority support.'); 
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
$panel_array['panel_state'] = 1;// 0=closed 1=open
$panel_array['panel_url'] = 'http://www.csv2post.com/how-to-articles/installing-csv-2-post';
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);               
$jsform_set['has_options'] = true;// true or false (controls output of selected settings)
$jsform_set['dialoguebox_title'] = 'Installing CSV 2 POST';
$jsform_set['noticebox_content'] = 'Would you like to begin installation of all require option table records, database tables and files?';?>

<?php csv2post_panel_header( $panel_array );?>

    <?php csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');?>

    <h4>Register This Domain (not in use yet)</h4>
    <input type="radio" name="method" value="yes" selected="selected" disabled="disabled" /> Yes<br />
    <input type="radio" name="method" value="no" disabled="disabled" /> No

    <br /><br />
    
    <?php 
    // add the javascript that will handle our form action, prevent submission and display dialogue box
    csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);

    // add end of form - dialogue box does not need to be within the <form>
    csv2post_formend_standard('Activate',$jsform_set['form_id']);?>

    <br />        
 
    <?php csv2post_jquery_form_prompt($jsform_set);?>

<?php csv2post_panel_footer();?>
