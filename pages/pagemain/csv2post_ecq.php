<?php global $csv2post_options_array;?> 
                                 
<?php
if(!$csv2post_is_free){
    ++$panel_number;// increase panel counter so this panel has unique ID
    $panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
    $panel_array['panel_name'] = 'easyconfigurationquestions';// slug to act as a name and part of the panel ID 
    $panel_array['panel_title'] = __('Easy Configuration Questions');// user seen panel header text 
    $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique   
    // Form Settings - create the array that is passed to jQuery form functions
    $jsform_set_override = array();
    $jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
    $jsform_set['dialogbox_title'] = 'Save Easy Configuration Questions';
    $jsform_set['noticebox_content'] = 'Some features may be hidden when you save your answers. Please remember that you can reset the answers. Do you wish to save your answers now?';?>
    <?php csv2post_panel_header( $panel_array );?>

        <?php 
        // begin form and add hidden values
        csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
        csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
        
        echo '<p>None of these questions are mandatory and you may answer any that suit your needs.</p>';
        
        csv2post_easy_configuration_questionlist();

        echo '<h4>Key</h4>';
        csv2post_n_incontent('Not yet answered','question','Tiny');
        csv2post_n_incontent('Yes answer giving','success','Tiny');           
        csv2post_n_incontent('No answer giving','error','Tiny');         
        csv2post_n_incontent('Unsure answer giving','warning','Tiny');
        ?>
            
        <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>

    <?php csv2post_panel_footer();
}?>