<?php
$csv2post_contenttemplates_array = array();
$csv2post_contenttemplates_array[0]['name'] = 'Text and Image';
$csv2post_contenttemplates_array[0]['html'] = 'x-DESCRIPTION-x<a href="x-LINK-X"><img class="alignleft size-thumbnail wp-image-12" title="" src="x-IMAGE-x" alt="" width="150" height="150" /></a>';

++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'ecifreesetupcontenttemplate';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Step 4: Setup Content');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Select columns to overwrite tokens in the default content template');
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
$panel_array['panel_help'] = __('CSV 2 POST has an advanced content template system but we have
reduced the functionality for new users to help them adjust. This feature will appear to simply
save some settings but it will actually create a new content template post which you can view and edit
under the "Content Templates" menu. You will find your own column headers in the new template, this is
required and how the plugin operates. Normally users paste the column headers into templates using a
WYSIWYG editor but we have removed that difficulty for Easy CSV Importer. Just keep in mind there is
a lot more you can do with your designs before creating posts.');
// <form> values, seperate from panel value
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
$jsform_set['dialogbox_title'] = 'Save Content Template';
$jsform_set['noticebox_content'] = 'A new Content Template will be created so that you may edit it at
any time, please continue saving...</p>';
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
        ?> 

        <strong>Main Text:</strong><?php echo csv2post_menu_csvfile_headers('eci_pair_description',$csv2post_ecisession_array['dijcode'],$csv2post_ecisession_array['filename']);?><br />
        <strong>Image URL:</strong><?php echo csv2post_menu_csvfile_headers('eci_pair_image',$csv2post_ecisession_array['dijcode'],$csv2post_ecisession_array['filename']);?><br />
        <strong>Link URL:</strong><?php echo csv2post_menu_csvfile_headers('eci_pair_link',$csv2post_ecisession_array['dijcode'],$csv2post_ecisession_array['filename']);?><br />

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