<?php
if(!$csv2post_is_free){
    global $csv2post_dataimportjobs_array;
    ++$panel_number;// increase panel counter so this panel has unique ID
    $panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
    $panel_array['panel_name'] = 'datasplitter';// slug to act as a name and part of the panel ID 
    $panel_array['panel_title'] = __('Data Splitter Rule');// user seen panel header text 
    $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
    $panel_array['panel_help'] = __('Use this tool to split values from one column into multiple
    different columns. This happens during data import, it is not sorted after the initial import.
    We select the column of data that has a string of values separated 
    by a single character, known as a delimiter or we may refer to it as a separator sometimes to
    sort of indicate what gets done with it within the plugins functionality. We also select
    the multiple columns that our data is to be moved to. This is obviously more advanced than most
    features found in data importers so please seek further instructions if unsure. Some extra database
    table columns exist initially but you may need more. As I type this there is no tool to modify the
    table in that way but we can provide on request if needed.');
    // Form Settings - create the array that is passed to jQuery form functions
    $jsform_set_override = array();
    $jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);               
    $jsform_set['dialogbox_title'] = 'Split Data';
    $jsform_set['noticebox_content'] = 'You are about to split one column of values into multiple database table columns, overwriting any values already in those columns. Do you wish to continue?';
    ### TODO:HIGHPRIORITY, add default category option ?>
    <?php csv2post_panel_header( $panel_array );?>

        <?php 
        // begin form and add hidden values
        csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');
        csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
        ?>
              
        <h4>Select Separator/Delimitar</h4>  
        <select name="csv2post_sep">
            <option value="notselected">Not Selected</option>
            <?php
            $current_sep = '';
            $forwardslash = '';
            $comma = '';
            $pipe = '';
            if(isset($csv2post_job_array['splitter']['separator'])){
                $current_sep = $csv2post_job_array['splitter']['separator'];
                if($current_sep == '/'){$forwardslash = 'selected="selected"';}
                if($current_sep == ','){$comma = 'selected="selected"';}
                if($current_sep == '|'){$pipe = 'selected="selected"';}
            } 
            ?>    
            <option value="/" <?php echo $forwardslash;?>>/</option>
            <option value="," <?php echo $comma;?>>,</option>
            <option value="|" <?php echo $pipe;?>>|</option>        
        </select> 
           
        <br>

        <h4>Source Column</h4>
        <select name="csv2post_sourcecolumn">
            <option value="notselected">Not Selected</option>
            <?php                    
            if(isset($csv2post_job_array['splitter']['sourcetable']) && isset($csv2post_job_array['splitter']['sourcecolumn'])){
                csv2post_GUI_datajob_columnsandtables_menu($csv2post_job_array['splitter']['sourcetable'],$csv2post_job_array['splitter']['sourcecolumn']);
            }else{
                csv2post_GUI_datajob_columnsandtables_menu();            
            }
            ?>                                                                                                                            
        </select> 
                   
        <br>
              
        <h4>Select Receiving Column 1</h4>
        <select name="csv2post_catcol1">
            <option value="notselected">Not Selected</option>
            <?php                    
            if(isset($csv2post_job_array['splitter']['table1']) && isset($csv2post_job_array['splitter']['column1'])){
                csv2post_GUI_datajob_columnsandtables_menu($csv2post_job_array['splitter']['table1'],$csv2post_job_array['splitter']['column1']);
            }else{
                csv2post_GUI_datajob_columnsandtables_menu();            
            }
            ?>                                                                                                                            
        </select> 
        
        <h4>Select Receiving Column 2</h4>
        <select name="csv2post_catcol2">
            <option value="notselected">Not Selected</option>
            <?php 
            if(isset($csv2post_job_array['splitter']['table2']) && isset($csv2post_job_array['splitter']['column2'])){
                csv2post_GUI_datajob_columnsandtables_menu($csv2post_job_array['splitter']['table2'],$csv2post_job_array['splitter']['column2']);    
            }else{
                csv2post_GUI_datajob_columnsandtables_menu();            
            }
            ?>                                                                                                                            
        </select>

        <h4>Select Receiving Column 3</h4>
        <select name="csv2post_catcol3">
            <option value="notselected">Not Selected</option>
            <?php 
            if(isset($csv2post_job_array['splitter']['table3']) && isset($csv2post_job_array['splitter']['column3'])){
                csv2post_GUI_datajob_columnsandtables_menu($csv2post_job_array['splitter']['table3'],$csv2post_job_array['splitter']['column3']);    
            }else{
                csv2post_GUI_datajob_columnsandtables_menu();            
            }
            ?>                                                                                                                            
        </select>
        
        <br>
         
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
/*
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'replacevalues';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Replace Values');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
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
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);       
$jsform_set['dialogbox_title'] = 'Save Replace Value Rule';
$jsform_set['noticebox_content'] = 'This rule will replace the specified value in your data before it is used in posts. Do you wish to continue and create the new value relace rule?';?>
<?php csv2post_panel_header( $panel_array );?> 

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?> 
    
    Select Data Column: 
    <select name="csv2post_datarule_replacevalue_column" id="csv2post_datarule_replacevalue_column" class="csv2post_multiselect_menu">
        <?php csv2post_display_jobs_csvfile_headers_menuoptions($csv2post_currentjob_code);?>                                                                                                                     
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
$panel_array['panel_name'] = 'modifyvalues';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Modify Values');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('The purpose of this tool is to modify your data before it is used to create posts. You can create as many rules as you want to apply to different columns or multiple different values within the same column. This is a feature I recommend more reading on and watching tutorials before applying a lot of modification rules to your project.');
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);       
$jsform_set['dialogbox_title'] = 'Save Modify Value Rule';
$jsform_set['noticebox_content'] = 'Do you want to continue saving a new modify value rule?';?>
<?php csv2post_panel_header( $panel_array );?> 

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?> 
    
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
$panel_array['panel_name'] = 'discardrecords';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Discard Records');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('You can skip a row and it will not be imported at all or you can import all rows from a CSV file but void it within the database table so that it is never used. Voiding allows us to build more statistics and at some stage I could add features that allow us to improve the data or make other uses of the data that has been voided.');
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);       
$jsform_set['dialogbox_title'] = 'Save Discard Record Rule';
$jsform_set['noticebox_content'] = 'This feature can void or actually delete records so they are never used. Are you sure you want to continue and save the new rule?';?>
<?php csv2post_panel_header( $panel_array );?> 

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?> 
    
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
    // add js for dialog on form submission and the dialog <div> itself
    if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
        csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
        csv2post_jquery_form_prompt($jsform_set);
    }
    ?>
        
    <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>

<?php csv2post_panel_footer();
*/?>
