<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'ecifreesetuptitletemplate';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Step 5: Setup Title Template');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Select your titles data and create an editable template');
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
$panel_array['panel_help'] = __('CSV 2 POST creates Content Templates and Title Templates. 
This panel will automatically create a Title Template for you so even if you do not have a suitable
column of values to act as titles on their own, you can edit the template further to suit your needs. In the
situation where you data does not have pre-made titles, simple select any column, save then go to the 
Title Templates screen which you can find in the main Wordpress menu. Locate the Title Template just created
and improve the template by adding more of your CSV files column headers. Please learn how to do that part
properly. The headers must be wrapped in special characters so that CSV 2 POST can identifiy them as tokens
to be replaced by your data during post creation and not permanent text.');
// <form> values, seperate from panel value
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
$jsform_set['dialogbox_title'] = 'Create Title Template';
$jsform_set['noticebox_content'] = 'This will create a title template for editing later, please continue...</p>';
?>

<?php csv2post_panel_header( $panel_array );?>
    
    <?php 
    if($csv2post_ecisession_array['nextstep'] > 5){

        csv2post_n_incontent('This step has been complete and a Title Template was created
        which will have "'.$csv2post_ecisession_array['filenamenoext'].'" in the name. You can edit the template anytime.','success','Small','Step Complete');

    }else{?>                        

        <?php 
        // begin form and add hidden values
        csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
        csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
        ?> 

        <strong>Select Title Column:</strong><?php echo csv2post_menu_csvfile_headers('eci_pair_description',$csv2post_ecisession_array['dijcode'],$csv2post_ecisession_array['filename']);?><br />
        
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