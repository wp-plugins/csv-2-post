<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'replacevalues';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Replace Values');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $wtgcsv_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Automatically replace values in specific database table');
$panel_array['panel_help'] = __('This tool allows us to do two things. We can replace values
in our data and make them more suitable for either human reading or use with software. We
can also avoid creating more columns of data within our CSV file to suit a purpose that
a more basic or original form of data i.e. there is no need to create a column holding
Available and Sold Out values in-line with a stock column that holds numbers only. 
However if you require both forms of such an example, you can use a shortcodes to 
replace the original value at the point of the post being created. Once again you 
do not need to create another column of values, you can simply change the value at 
the point of using it in post content. See other tools in the Your Projects area 
to apply that similar ability.');
$panel_array['help_button'] = wtgcsv_helpbutton_text(true,true);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = wtgcsv_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);       
$jsform_set['dialoguebox_title'] = 'Save Replace Value Rule';
$jsform_set['noticebox_content'] = 'This rule will replace the specified value in your data before it is used in posts. Do you wish to continue and create the new value relace rule?';?>
<?php wtgcsv_panel_header( $panel_array );?> 

    <?php wtgcsv_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','wtgcsv_form','');?>

    Select Data Column: 
    <select name="wtgcsv_datarule_replacevalue_column" id="wtgcsv_datarule_replacevalue_column" class="wtgcsv_multiselect_menu">
        <?php wtgcsv_display_job_column_menuoptions($wtgcsv_currentjob_code);?>                                                                                                                     
    </select>
    
    
    <table class="widefat post fixed">
        <tr class="first">
            <td width="25"><strong>ID</strong></td>
            <td width="170"><strong>Project Name</strong></td>
            <td width="170"><strong>Table Column</strong></td>                        
            <td width="170"><strong>Original Value</strong></td>
            <td><strong>New Value</strong></td>                                                                                 
        </tr>
        <tr>
            <td>1</td>
            <td>My Test Project</td>
            <td>prices</td>                        
            <td>$</td>
            <td>£</td>                                    
        </tr>
        <tr>
            <td>2</td>
            <td>My Test Project</td>
            <td>prices</td>                        
            <td>0.00</td>
            <td>Free</td>                                    
        </tr>
        <tr>
            <td>3</td>
            <td>My Test Project</td>
            <td>stock</td>                        
            <td>0</td>
            <td>Sold Out</td>                                    
        </tr>                                        
    </table>    

    <?php
    // add the javascript that will handle our form action, prevent submission and display dialogue box
    wtgcsv_jqueryform_singleaction_middle($jsform_set,$wtgcsv_options_array);

    // add end of form - dialogue box does not need to be within the <form>
    wtgcsv_formend_standard('Submit',$jsform_set['form_id']);?>

    <?php wtgcsv_jquery_form_prompt($jsform_set);?>

   <?php wtgcsv_panel_footer();?>

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'modifyvalues';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Modify Values');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $wtgcsv_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Modify values using mathematical or grammer rules');
$panel_array['panel_help'] = __('The purpose of this tool is to modify your data before it is used to create posts. You can create as many rules as you want to apply to different columns or multiple different values within the same column. This is a feature I recommend more reading on and watching tutorials before applying a lot of modification rules to your project.');
$panel_array['help_button'] = wtgcsv_helpbutton_text(true,true);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = wtgcsv_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);       
$jsform_set['dialoguebox_title'] = 'Save Modify Value Rule';
$jsform_set['noticebox_content'] = 'Do you want to continue saving a new modify value rule?';?>
<?php wtgcsv_panel_header( $panel_array );?> 

    <?php wtgcsv_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','wtgcsv_form','');?>        

    <table class="widefat post fixed">
        <tr class="first">
            <td width="25"><strong>ID</strong></td>
            <td width="170"><strong>Project Name</strong></td>
            <td width="170"><strong>Table Column</strong></td>                        
            <td width="170"><strong>Original Value (nr)</strong></td>
            <td><strong>Modifier</strong></td>                        
            <td><strong>Test Example</strong></td>                                                                                 
        </tr>
        <tr>
            <td>1</td>
            <td>My Test Project</td>
            <td>prices</td>                        
            <td>50.00</td>
            <td>Multiple By 2</td>
            <td>100.00</td>                                                            
        </tr>
        <tr>
            <td>2</td>
            <td>My Test Project</td>
            <td>prices</td>                        
            <td>(NA)</td>
            <td>Deduct 10%</td>
            <td>45.00</td>                                                             
        </tr>
        <tr>
            <td>3</td>
            <td>My Test Project</td>
            <td>stock</td>                        
            <td>ryan bayne</td>
            <td>Capitalise</td>
            <td>Zara Walsh</td>                                                            
        </tr>                                        
    </table>  

    <?php
    // add the javascript that will handle our form action, prevent submission and display dialogue box
    wtgcsv_jqueryform_singleaction_middle($jsform_set,$wtgcsv_options_array);

    // add end of form - dialogue box does not need to be within the <form>
    wtgcsv_formend_standard('Submit',$jsform_set['form_id']);?>

    <?php wtgcsv_jquery_form_prompt($jsform_set);?>

  <?php wtgcsv_panel_footer();?>


<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'discardrecords';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Discard Records');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $wtgcsv_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Create rules that void or skip rows to help improve the quality of your data');
$panel_array['panel_help'] = __('You can skip a row and it will not be imported at all or you can import all rows from a CSV file but void it within the database table so that it is never used. Voiding allows us to build more statistics and at some stage I could add features that allow us to improve the data or make other uses of the data that has been voided.');
$panel_array['help_button'] = wtgcsv_helpbutton_text(true,true);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = wtgcsv_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);       
$jsform_set['dialoguebox_title'] = 'Save Discard Record Rule';
$jsform_set['noticebox_content'] = 'This feature can void or actually delete records so they are never used. Are you sure you want to continue and save the new rule?';?>
<?php wtgcsv_panel_header( $panel_array );?> 

    <?php wtgcsv_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','wtgcsv_form','');?>

    <table class="widefat post fixed">
        <tr class="first">
            <td width="25"><strong>ID</strong></td>
            <td width="170"><strong>Project Name</strong></td>
            <td width="170"><strong>Table Column</strong></td>                        
            <td width="170"><strong>Cause Value</strong></td>
            <td><strong>Discard Type</strong></td>                        
            <td><strong>Times Applied</strong></td>                                                                                 
        </tr>
        <tr>
            <td>1</td>
            <td>My Test Project</td>
            <td>image</td>                        
            <td>NULL</td>
            <td>Void</td>
            <td>12</td>                                                            
        </tr>
        <tr>
            <td>2</td>
            <td>My Test Project</td>
            <td>image</td>                        
            <td>URL Test</td>
            <td>Void</td>
            <td>3</td>                                                            
        </tr>  
        <tr>
            <td>3</td>
            <td>My Test Project</td>
            <td>prices</td>                        
            <td>Less Than 10</td>
            <td>NULL</td>
            <td>12</td>                                                            
        </tr>                                                                              
    </table>                 

    <?php
    // add the javascript that will handle our form action, prevent submission and display dialogue box
    wtgcsv_jqueryform_singleaction_middle($jsform_set,$wtgcsv_options_array);

    // add end of form - dialogue box does not need to be within the <form>
    wtgcsv_formend_standard('Submit',$jsform_set['form_id']);?>

    <?php wtgcsv_jquery_form_prompt($jsform_set);?>

<?php wtgcsv_panel_footer();?>
