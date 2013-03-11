<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'ecifreeimportdata';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Step 3: Import Data');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
// <form> values, seperate from panel value
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
$jsform_set['dialogbox_title'] = 'Import Your Data';
$jsform_set['noticebox_content'] = 'Every row from your CSV file will be
imported and used to create a record in the temporary database table. A
very large file may take many seconds to process. Do you wish to
continue?';
?>

<?php csv2post_panel_header( $panel_array );?>
    
    <?php 
    if($csv2post_ecisession_array['nextstep'] > 3){

        csv2post_n_incontent('All rows in your file CSV file named '.$csv2post_ecisession_array['filename'].' 
        were processed, you should have data for working with.','success','Small','Step Complete');

    }else{?>

        <?php 
        // begin form and add hidden values
        csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
        csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
        ?> 

        <p>Submission will import your data to a temporary database table where
        you can work with it if you need to before continuing.</p>
                
        <?php 
        // add js for dialog on form submission and the dialog <div> itself
        if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
            csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
            csv2post_jquery_form_prompt($jsform_set);
        } 
        ?>
            
        <?php csv2post_formend_standard('Import Data',$jsform_set['form_id']);?>            
     
    <?php 
    }?>
    
<?php csv2post_panel_footer();?>