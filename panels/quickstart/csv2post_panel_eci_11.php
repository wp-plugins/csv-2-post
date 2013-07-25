<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'ecifreepostupdating';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Step 10: Post Updating');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['dialogdisplay'] = 'no';
// <form> values, seperate from panel value
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
?>

<?php csv2post_panel_header( $panel_array );?>
    
    <?php 
    if($csv2post_ecisession_array['nextstep'] > 11){

        csv2post_n_incontent('Post updating, custom field updating and doing it in an intelligent
        way is something we offer in our premium services at www.csv2post.com. Our updating functionality
        allows automation, scheduling and we can exclude specific content from bring updated. The nature of such
        features demands high support and requires backing of a premium level of support which we are ready to
        provide you.','success','Small','Premium Step');

    }else{?>

        <?php 
        // begin form and add hidden values
        csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
        csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
        ?>
  
        <?php  csv2post_n_incontent('Post updating, custom field updating and doing it in an intelligent
        way is something we offer in our premium services at www.csv2post.com. Our updating functionality
        allows automation, scheduling and we can exclude specific content from bring updated. The nature of such
        features demands high support and requires backing of a premium level of support which we are ready to
        provide you.','info','Small','Premium Step'); ?> 

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