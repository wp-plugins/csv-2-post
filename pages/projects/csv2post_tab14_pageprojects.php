<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'defaultauthor';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Default Author');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('Your default author will always be the author applied if you do not setup any other advanced rules.');
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);               
$jsform_set['dialogbox_title'] = 'Save Default Author';
$jsform_set['noticebox_content'] = 'Do you want to save a default author now?';?>
<?php csv2post_panel_header( $panel_array );?>

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?> 
    
    <select name="csv2post_defaultauthor_select" id="csv2post_defaultauthor_select_id" class="csv2post_multiselect_menu">
        
        <?php
        // apply selected to default option when no value has been saved already
        $selected = '';
        $current = ''; 
        if(!isset($csv2post_project_array['defaultuser'])){
            $selected = 'selected="selected"';
        }else{
            $current = $csv2post_project_array['defaultuser'];
        }?>
        
        <option value="notselected" <?php echo $selected;?>>None Selected</option> 
                
        <?php csv2post_display_users_options($current);?>
                                                                                                                             
    </select>  

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
if(!$csv2post_is_free){
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'createauthors';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Create Authors');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('This tool can create users using email address only. CSV 2 POST will generate
a username from the first part of each email address. Where an email address has different domains but results in the
same username, a numeric value will be appended. If you have a column of usernames the plugin can use that instead. This
all happens during post creation so keep in mind that it increases the work CSV 2 POST and Wordpress has to do
per post. The ID generated is assigned to the post so even if your data includes user ID, we cannot use it. If for
any reason you really need existing user ID to be applied, please let us know.');
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);               
$jsform_set['dialogbox_title'] = 'Save Author Creation Settings';
$jsform_set['noticebox_content'] = 'Authors will be generated using this feature. Please check your blogs settings,
Wordpress may send emails to every email address used. Do you wish to continue?';?>
<?php csv2post_panel_header( $panel_array );?>

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?> 
    
    Email Address Column:
    <select name="csv2post_createusers_emailcolumn" id="csv2post_createusers_emailcolumn" class="csv2post_multiselect_menu">
        <option value="notselected">Not Selected</option>    
        <?php 
        if(isset($csv2post_project_array['seo']['basic']['title_table']) && isset($csv2post_project_array['seo']['basic']['title_column'])){
            csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code,$csv2post_project_array['seo']['basic']['title_table'],$csv2post_project_array['seo']['basic']['title_column']);        
        }else{
            csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code);
        }?>                                                                                                                     
    </select>
 
    <br />
    Username Column (optional):
    <select name="csv2post_createusers_usernamecolumn" id="csv2post_createusers_usernamecolumn" class="csv2post_multiselect_menu">
        <option value="notselected">Not Selected</option>    
        <?php 
        if(isset($csv2post_project_array['seo']['basic']['title_table']) && isset($csv2post_project_array['seo']['basic']['title_column'])){
            csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code,$csv2post_project_array['seo']['basic']['title_table'],$csv2post_project_array['seo']['basic']['title_column']);        
        }else{
            csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code);
        }?>                                                                                                                     
    </select>  
    
    <br />
       
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
