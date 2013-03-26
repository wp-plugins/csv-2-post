<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'ecifreedefaultauthor';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Step 15: Default Author');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['dialogdisplay'] = 'no';
// <form> values, seperate from panel value
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
?>

<?php csv2post_panel_header( $panel_array );?>
    
    <?php        
    if($csv2post_ecisession_array['nextstep'] > 15){

         csv2post_n_incontent('This step has been complete.','success','Small','Step Complete');

    }else{?>

        <?php 
        // begin form and add hidden values
        csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
        csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
        ?>

            <select name="csv2post_ecifreedefaultauthor_select" id="csv2post_ecifreedefaultauthor_select_id" class="csv2post_multiselect_menu">
                
                <?php
                // apply selected to default option when no value has been saved already
                $selected = '';
                $current = ''; 
                if(!isset($csv2post_project_array['defaultuser'])){
                    $selected = 'selected="selected"';
                }else{
                    $current = $csv2post_project_array['defaultuser'];
                }?>
    
                <?php csv2post_display_users_options($current);?>
                                                                                                                                     
            </select>  
                          
            <br />
                    
        <?php 
        echo csv2post_WP_SETTINGS_form_submit_dialog($panel_array);
        
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
