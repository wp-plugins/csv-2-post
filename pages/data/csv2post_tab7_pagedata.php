<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'basicdatasearch';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Basic Data Search');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Locate records that include a specific value');
$panel_array['panel_help'] = __('This tool allows you to search your imported data and return records that include a value you enter. You can tell the plugin which tables to search and which columns. It is recommended that you provide as much search criteria as possible so that the search is not on a wide scope with the resulting process taking far longer than needed i.e. if the value you enter is only within a single table, please select that table so that the query is only performed on a single table rather than the entire Wordpress database.');
$panel_array['help_button'] = csv2post_helpbutton_text(true,true);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);               
$jsform_set['dialogbox_title'] = 'Perform Basic Data Search';
$jsform_set['noticebox_content'] = 'Please be aware that the number of records you have in your data will determine how long the search will take. Would you like to continue?';?>
<?php csv2post_panel_header( $panel_array );?> 

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?> 
    
    <?php
    // TODO: MEDIUMPRIORITY
    /**
    * 2012
    * First the Data Tables plugin will be added for advanced data display.
    * 
    * 1. Select ALL TABLES, SPECIFIC TABLE
    * 2. Select ALL COLUMNS, SPECIFIC COLUMNS from the selected tables or ALL TABLES
    * 3. Add a limit of returned records, default 100
    * 4. Will then list records within a table, record ID will be listed
    * 
    * 2013
    * 1. Click on a record to view the entire record, queried on click, query can use records ID
    * 2. Delete record button
    * 3. View records post button
    * 4. Edit fields
    */
    ?>

    <p>This feature is expected to be added during the second half of 2012</p>

     <?php 
    // add js for dialog on form submission and the dialog <div> itself
    if(csv2post_SETTINGS_form_submit_dialog($panel_array)){
        csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
        csv2post_jquery_form_prompt($jsform_set);
    }
    ?>
        
    <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>

<?php csv2post_panel_footer();?>
 
<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'advanceddatasearch';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Advanced Data Search');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Locate records based on specific values and use rules to ignore records with other values');
$panel_array['panel_help'] = __('A slightly more complex search tool than the basic one above. This allows you to not only search for records holding specific values but you can have the query ignore some of the records it finds if they hold other values you state. You may also search and locate records with number values higher or lower than the value you enter i.e. if you want to find all items below 9.99 then possibly increase the prices. I must make clear however that editing records on this page may not be possible until 2013 but that depends on demand for it.');
$panel_array['help_button'] = csv2post_helpbutton_text(true,true);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);               
$jsform_set['dialogbox_title'] = 'Perform Advanced Data Search';
$jsform_set['noticebox_content'] = 'Please be aware that the number of records you have in your data will determine how long the search will take. Would you like to continue?';?>
<?php csv2post_panel_header( $panel_array );?> 

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?> 
    
    <?php
    // TODO: MEDIUMPRIORITY
    /**
    * 2012
    * First the Data Tables plugin will be added for advanced data display.
    * 
    * 1. Select ALL TABLES, SPECIFIC TABLE
    * 2. Select ALL COLUMNS, SPECIFIC COLUMNS from the selected tables or ALL TABLES
    * 3. Add a limit of returned records, default 100
    * 4. Rules: ignore records with specific value within specific column, only return values with a specific column having a specific numeric value or higher or lower
    * 5. SQL Query Fields: ability to paste shorts lines of query that will add to the automatic qury5t456b45
    * 4. Will then list records within a table, record ID will be listed
    * 
    * 2013
    * 1. Click on a record to view the entire record, queried on click, query can use records ID
    * 2. Delete record button
    * 3. View records post button
    * 4. Edit fields
    */
    ?>

    <p>This feature is expected to be added during the second half of 2012</p>

     <?php 
    // add js for dialog on form submission and the dialog <div> itself
    if(csv2post_SETTINGS_form_submit_dialog($panel_array)){
        csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
        csv2post_jquery_form_prompt($jsform_set);
    }
    ?>
        
    <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>

<?php csv2post_panel_footer();?>
