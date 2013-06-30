<?php
$csv2post_contenttemplates_array = array();
$csv2post_contenttemplates_array[0]['name'] = 'Text and Image';
$csv2post_contenttemplates_array[0]['html'] = 'x-DESCRIPTION-x<a href="x-LINK-X"><img class="alignleft size-thumbnail wp-image-12" title="" src="x-IMAGE-x" alt="" width="150" height="150" /></a>';

++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'ecifreesetupcontenttemplate';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Step 4: Setup Content');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
// <form> values, seperate from panel value
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
?>

<?php csv2post_panel_header( $panel_array );?>
    
    <?php 
    if($csv2post_ecisession_array['nextstep'] > 4){
        csv2post_n_incontent('You complete this step and a Content Template was created
        which you can edit at anytime. It will include "'.$csv2post_ecisession_array['filenamenoext'].'" in 
        the name of the template.','success','Small','Step Complete');
    }else{?>

        <?php 
        // begin form and add hidden values
        csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
        csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);

        global $csv2post_project_array,$csv2post_currentproject_code;
                               
        // establish a template name so we can make the user aware
        $templatename = $csv2post_project_array['name'] . ' Content Template';
        
        $table_name = csv2post_get_project_maintable($csv2post_currentproject_code);
        
        // confirm table still exists else display warning - great opportunity to let user know they deleted the WRONG table :) 
        if(!csv2post_WP_SQL_does_table_exist($table_name)){
            echo csv2post_notice('Your table of imported data table is missing, 
            have you possibly manually deleted it?','error','Tiny','','','return');
        }
        
        $table_columns = csv2post_WP_SQL_get_tablecolumns($table_name);
        
        if(!$table_columns){
        
            echo csv2post_notice('Your imported data table named '.$table_name.' may have
            been deleted. You will need to reset Quick Start so that a new database table 
            is created. Please report this if you feel something is wrong.','error','Small','','','return');
            
        }else{?>
        
            <p>Below is a list of tokens we call Column Replacement Tokens. Copy and paste them into the editor wherever you want their
            representing data to appear in each of your posts. Tokens can be used as many times as you like and you can use them
            in your HTML to populate links and other HTML attributes. You may paste your Google AdSense code</p>            
            
            <?php 
            // excluded columns array
            $excluded_columns = array('csv2post_id','csv2post_postid','csv2post_postcontent','csv2post_inuse','csv2post_imported',
            'csv2post_updated','csv2post_changed','csv2post_applied','csv2post_filemoddate','csv2post_filemoddate1','csv2post_filemoddate2',
            'csv2post_filemoddate3','csv2post_filemoddate4','csv2post_filemoddate5','csv2post_filedone','csv2post_filedone1',
            'csv2post_filedone2','csv2post_filedone3','csv2post_filedone4','csv2post_filedone5');

            // we will count the number of none wtgcsv columns, if 0 we know it is a main project table for multiple table project
            $count_users_columns = 0;
            
            while ($row_column = mysql_fetch_row($table_columns)) { 
                
                if(!in_array($row_column[0],$excluded_columns)){
                    
                    // if free edition, do not add the table, we make it a little more simple
                    // it is also more secure for users who may be beginners because database table names are not in use
                    if($csv2post_is_free){
                        echo '#' . $row_column[0].'<br />';                   
                    }else{            
                        echo $table_name . '#' . $row_column[0].'<br />';
                        ++$count_users_columns;
                    }
                }
            } 
        }?>
        
        <div id="poststuff">
            <?php wp_editor('Replace this text with your tokens, you can even add tokens to HTML on the Text tab...','csv2postwysiwygeditor',array('textarea_name' => 'csv2post_wysiwyg_editor'));?>
        </div>
        
        <input type="hidden" name="csv2post_contentname" value="<?php echo $templatename;?>">
        
        <P>Your new Content Template will be named "<strong><?php echo $templatename;?></strong>", you may edit it at anytime by visiting 'Content Template'.</p>
 
        <?php 
        // add js for dialog on form submission and the dialog <div> itself
        if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
            csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
            csv2post_jquery_form_promptdiv($jsform_set);
        } 
        ?>
            
        <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>            
     
    <?php 
    }?>
    
<?php csv2post_panel_footer();?>