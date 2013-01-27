<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'ecifreecustomfields';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Step 9: Custom Fields');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Setup post meta/custom fields to make your posts work with any theme');
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
$panel_array['panel_help'] = __('Wordpress posts can have meta values added, extra values that can be used
by themes and plugins. CSV 2 POST allows full compatability with any theme including ClassiPress.
You may know these values as Custom Fields. They are the values you will see on the Edit Post screen once
posts are created.');
$panel_array['dialogdisplay'] = 'no';
// <form> values, seperate from panel value
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
$jsform_set['dialogbox_title'] = 'NOT IN USE';
$jsform_set['noticebox_content'] = 'NOT IN USE';
?>

<?php csv2post_panel_header( $panel_array );?>
    
    <?php 
    if($csv2post_ecisession_array['nextstep'] > 9){

        csv2post_n_incontent('This step is complete and your custom field entries were saved.','success','Small','Step Complete');

    }else{?>

        <?php 
        // begin form and add hidden values
        csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
        csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
        ?> 

        <table class="widefat post fixed"> 
            <?php 
            $csv2post_ecisession_array = csv2post_WP_SETTINGS_get_eciarray(); 
            
            // loop through original headers, on submission convert to the require header for settings
            $job_headers_array = csv2post_get_dataimportjob_headers_singlefile($csv2post_ecisession_array['dijcode'],$csv2post_ecisession_array['filename']);
            
            foreach($job_headers_array as $key => $header){
                echo '<tr><td width="200"><strong>' . $header['original'] . '</strong></td><td><input type="text" name="csv2post_ecifree_cf_'.$key.'" size="30"></td></tr>';
            }
            ?>
        </table>
        
        <?php 
        // add js for dialog on form submission and the dialog <div> itself
        if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
            csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
            csv2post_jquery_form_prompt($jsform_set);
        } 
        ?>
            
        <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>            
     
    <?php 
    }?>
    
<?php csv2post_panel_footer();?>