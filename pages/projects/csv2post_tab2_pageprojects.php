<?php 
if(!isset($csv2post_project_array['default_titletemplate_id'])){
    echo csv2post_notice('You have not selected a title template yet, this is a requirement for all projects.','warning','Tiny','','','return');
}else{
    echo csv2post_notice('Your project has a title template setup.','success','Tiny','','','return');
}
?>

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'defaulttitletemplate';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Set Default Title Template');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('There is a token for each of your database columns and for all tables included in your project. These are replaced with data from the column they represent. Please be aware that any content which matches these strings will also be replaced however the asterix between table name and column name should help to prevent this. Column names may be appended with a number value. This is done to prevent two tables sharing the same column names conflicting with each other. Another approach to prevent conflict is being added however and you may not see appended numbers.');?>
<?php csv2post_panel_header( $panel_array );?>

    <form id="csv2post_form_opentitletemplate_id" action="<?php echo $csv2post_form_action;?>" method="post" name="csv2post_form_opentitletemplate">
        <input type="hidden" id="csv2post_post_processing_required" name="csv2post_post_processing_required" value="true">               
        
        <input type="hidden" name="csv2post_current_project_id" value="<?php echo $csv2post_currentproject_code;?>">
        <input type="hidden" name="csv2post_change_default_titletemplate" value="true">        

        <h4>Current Projects Default Title Template</h4> 
        Template Name: <?php echo csv2post_get_default_titletemplate_name();?><br />
        Template Design: <?php echo csv2post_get_default_titletemplate_design(csv2post_get_default_titletemplate_id($csv2post_currentproject_code));?>

        <h4>Current Project Title Templates</h4>
        <?php csv2post_displayproject_titletemplates_buttonlist('csv2post_selecttemplate_fromproject_id');?>          
    
        <h4>All Title Templates</h4>
        <?php csv2post_display_all_titledesigns_buttonlist();?>            

    </form>    

<?php csv2post_panel_footer();?>

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'columnreplacementtokens2';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Column Replacement Tokens');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('There is a token for each of your database columns and for all tables included in your project. These are replaced with data from the column they represent. Please be aware that any content which matches these strings will also be replaced however the asterix between table name and column name should help to prevent this.');?>
<?php csv2post_panel_header( $panel_array );?>

<?php csv2post_list_replacement_tokens($csv2post_currentproject_code);?>

<?php csv2post_panel_footer();?>

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'createtitletemplates';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Create Title Templates *global panel*');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('The plugin allows us to create multiple post title templates for selecting when creating a new project. Over 2012 I will be adding features to allow dynamic or random designs to be applied based on values within your data or any other criteria users want to be taking into consideration.');
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);   
$jsform_set['dialogbox_title'] = 'Creating New Title Template';
$jsform_set['noticebox_content'] = 'Do you want to create your new title template now?';
// TODO: LOWPRIORITY, add a checkbox to allow user to save design for the mapping approach?>
<?php csv2post_panel_header( $panel_array );?>

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?>    
    
    <h4>Title Template Design Name</h4>
    <input type="text" name="csv2post_titletemplate_name" size="65" value="" id="csv2post_titletemplate_form_id" /> 
    
    <h4>Title Template (add column replacement tokens)</h4>                                 
    <input type="text" name="csv2post_titletemplate_title" size="65" value="" id="title" />

    <br /><br />

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
$panel_array['panel_name'] = 'edittitletemplates';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Edit Title Templates *global panel*');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('You can edit existing title templates here. Please note that changes these does not automatically update posts already created using the designs. The feature to do that will be added to the plugin but as I write this it does not exist, try searching on the plugins site for instructions.217');
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);   
$jsform_set['dialogbox_title'] = 'Update Title Templates';
$jsform_set['noticebox_content'] = 'Do you want to update any changes made to your title templates, all posts made after the update will use the new design?';
// TODO: LOWPRIORITY, add a checkbox to allow user to save design for the mapping approach?>
<?php csv2post_panel_header( $panel_array );?>

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?> 
    
    <?php csv2post_list_titletemplate_foredit();?> 
    
    <br />
     
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
$panel_array['panel_name'] = 'titlecolumn';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Set Title Column');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('Selecting a title column will override title templates. You can only use one method, this is the most simple but requires your data to already have title strings in a single column. If you do not have pre-made title strings you should not use this single column feature.');
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);   
$jsform_set['dialogbox_title'] = 'Save Title Column';
$jsform_set['noticebox_content'] = 'You are saving a column of data to be used as titles alone, do you wish to continue?';
// TODO: LOWPRIORITY, add a checkbox to allow user to save design for the mapping approach?>
<?php csv2post_panel_header( $panel_array );?>

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?> 
    
    <p>        
        Data Column: 
        <select name="csv2post_titlecolumn_menu" id="csv2post_titlecolumn_menu" class="csv2post_multiselect_menu">
            <?php 
            $current_table = '';
            if(isset($csv2post_project_array['posttitles']['table'])){
                $current_table = $csv2post_project_array['posttitles']['table'];
            }

            $current_column = '';
            if(isset($csv2post_project_array['posttitles']['column'])){
                $current_column = $csv2post_project_array['posttitles']['column'];
            }
                        
            csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code,$current_table,$current_column);?>                                                                                                                     
        </select>
    </p>
           
    <?php 
    // add js for dialog on form submission and the dialog <div> itself
    if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
        csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
        csv2post_jquery_form_prompt($jsform_set);
    }
    ?>
        
    <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>

<?php csv2post_panel_footer();?>