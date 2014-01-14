<?php
/** 
 * Free edition file (applies to paid also) for CSV 2 POST plugin by WebTechGlobal.co.uk
 *
 * @package CSV 2 POST
 * 
 * @author Ryan Bayne | ryan@webtechglobal.co.uk
 */
 
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'ecifreeimportdata';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Step 3: Import Data');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
// <form> values, seperate from panel value
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
?>

<?php csv2post_panel_header( $panel_array );?>
    
    <?php 
    if($csv2post_ecisession_array['nextstep'] > 3){

        csv2post_n_incontent('All rows in your file CSV file named '.$csv2post_ecisession_array['filename'].' 
        were imported, you should have data for creating posts with.','success','Small','Step Complete');

    }else{?>


        <p>Submission will import your data from your CSV file named to a new database table. CSV 2 POST works with the data from there and you can create posts more effeciently.</p>
        
        <h4>Import Dates</h4>
        <label for="csv2post_datecolumn_select_columnandtable_formid">Select Column: </label>
        <select name="csv2post_datecolumn_select_columnandtable" id="csv2post_datecolumn_select_columnandtable_formid" >
            
            <?php
            $table = ''; 
            if(isset($csv2post_project_array['dates']['date_column']['table_name'])){
                $table = $csv2post_project_array['dates']['date_column']['table_name'];    
            }
            
            $column = ''; 
            if(isset($csv2post_project_array['dates']['date_column']['column_name'])){
                $column = $csv2post_project_array['dates']['date_column']['column_name'];    
            }        
            ?>
            
            <?php csv2post_GUI_project_columnsandtables($csv2post_ecisession_array['dijcode'],$table,$column);?>                                                                                                                     
        </select>
      
        <br>
      
        <label for="csv2post_datecolumn_format_objectid">Select Date Format: </label>
        <select name="csv2post_datecolumn_format" id="csv2post_datecolumn_format_objectid" >
            
            <?php
            $format = ''; 
            if(isset($csv2post_project_array['dates']['date_column']['format'])){
                $format = $csv2post_project_array['dates']['date_column']['format'];    
            }     
            ?>
            
            <option value="unsure">Unsure</option>
            <option value="noformat">Do Not Format (use date data as it is)</option>        
            <option value="uk">UK (will be formatted to MySQL standard)</option>
            <option value="us">US (will be formatted to MySQL standard)</option>
            <option value="mysql">MySQL (will still be formatted to be sure)</option>
            <option value="custom">Custom/Other (contact us)</option> 
                                                                                                                               
        </select>
                    
    
        <?php 
        // begin form and add hidden values
        csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
        csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
        
        global $csv2post_currentjob_code;?> 

            
        <?php csv2post_formend_standard('Import Data',$jsform_set['form_id']);?>            
     
    <?php 
    }?>
    
<?php csv2post_panel_footer();?>