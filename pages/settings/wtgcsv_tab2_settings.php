<?php global $wtgcsv_options_array;?> 
                                 
<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'easyconfigurationquestions';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Easy Configuration Questions');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $wtgcsv_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Answer questions to configure the plugin interface the way you need it');
$panel_array['panel_help'] = __('Easy Configuration Questions act like settings and your answers will allow the plugins interface to adapt. The objective is to make the plugin easier to use by hiding features you will never need. The main thing to remember is just that, features may be hidden. You can reset your answers should you find something is missing and you need it. These questions are nothing to do with individual projects, the are global and apply to the entire plugin including all projects. There are different questions on another screen for quick project configuration.'); 
$panel_array['help_button'] = wtgcsv_helpbutton_text(false,false);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = wtgcsv_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
$jsform_set['dialoguebox_title'] = 'Save Easy Configuration Questions';
$jsform_set['noticebox_content'] = 'Some features may be hidden when you save your answers. Please remember that you can reset the answers. Do you wish to save your answers now?';?>
<?php wtgcsv_panel_header( $panel_array );?>

    <?php wtgcsv_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','wtgcsv_form','');?>

    <?php 
    if($wtgcsv_is_free){
        echo '<p><strong>For now this feature only works in the paid edition only, these questions are samples</strong></p>';
        wtgcsv_easy_configuration_questionlist_demo();
    }else{
        wtgcsv_easy_configuration_questionlist();    
    }?>    
    
    <?php     
    // add the javascript that will handle our form action, prevent submission and display dialogue box
    wtgcsv_jqueryform_singleaction_middle($jsform_set,$wtgcsv_options_array);

    // add end of form - dialogue box does not need to be within the <form>
    wtgcsv_formend_standard('Save Questions',$jsform_set['form_id']);
            
    wtgcsv_jquery_form_prompt($jsform_set);?>

<?php wtgcsv_panel_footer();?>