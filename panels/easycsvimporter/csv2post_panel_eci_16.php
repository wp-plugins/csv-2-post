<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'ecifreepostupdating';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Step 16: Extra Theme Support');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('CSV 2 POST works with any theme, but we can make the configuration easier');
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
$panel_array['panel_help'] = __('We consider this a smart ability. The work going into perfecting it is
extensive. The plugin detects the theme and configures its interface to suit the theme i.e. custom fields
are populated with the keys required by your theme saving the using from entering them. This level of help
to configure the plguin is not provided in the free edition at this time but you can still use CSV 2 POST with
any advanced theme such as ShopperPress or ClassiPress.');
$panel_array['dialogdisplay'] = 'no';
// <form> values, seperate from panel value
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
?>

<?php csv2post_panel_header( $panel_array );?>
    
    <?php 
    if($csv2post_ecisession_array['nextstep'] > 11){

        csv2post_n_incontent('This step is not currently available in the free edition.
        However we welcome you to hack the plugin and provide it for that purpose. Guidance for hacking
        CSV 2 POST is provided at www.csv2post.com.','success','Small','Step Skipped');

    }else{?>

        <?php 
        // begin form and add hidden values
        csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
        csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
        ?>


        <?php csv2post_n_incontent('This step is not currently available in the free edition.
        However we welcome you to hack the plugin and provide it for that purpose. Guidance for hacking
        CSV 2 POST is provided at www.csv2post.com.','success','Small','Step Skipped'); ?> 
         
 
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