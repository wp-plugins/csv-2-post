<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'ecifreepoststatus';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Step 7: Post Status');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['dialogdisplay'] = 'no';
// <form> values, seperate from panel value
$jsform_set_override = array();### TODO:LOWPRIORITY, we can remove these lines and add array() to the functions parameter
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
$jsform_set['dialogbox_title'] = 'DIALOGUE NOT IN USE';
$jsform_set['noticebox_content'] = 'THIS DIALOGUE IS CURRENTLY NOT IN USE';
?>

<?php csv2post_panel_header( $panel_array );?>
    
    <?php 
    if($csv2post_ecisession_array['nextstep'] > 7){

        $poststatus = 'publish';
        if(isset($csv2post_project_array['poststatus'])){
            $poststatus = $csv2post_project_array['poststatus'];    
        }
        
        csv2post_n_incontent('This step was complete and '.$poststatus.' is set as your status.','success','Small','Step Complete');

    }else{?>

        <?php 
        // begin form and add hidden values
        csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
        csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
        ?>

            <script>
            $(function() {
                $( "#csv2post_eci_poststatus_radios" ).buttonset();
            });
            </script>

            <div id="csv2post_eci_poststatus_radios">
                
                <?php
                // establish current status check                
                echo '<input type="radio" id="csv2post_eci_radiopublish_poststatus_objectid" name="csv2post_radio_poststatus" value="publish" />
                <label for="csv2post_eci_radiopublish_poststatus_objectid">publish</label>';
                
                echo '<input type="radio" id="csv2post_eci_radiopending_poststatus_objectid" name="csv2post_radio_poststatus" value="pending" />
                <label for="csv2post_eci_radiopending_poststatus_objectid">pending</label>';                    
                
                echo '<input type="radio" id="csv2post_eci_radiodraft_poststatus_objectid" name="csv2post_radio_poststatus" value="draft" />
                <label for="csv2post_eci_radiodraft_poststatus_objectid">draft</label>';   
                
                echo '<input type="radio" id="csv2post_eci_radioprivate_poststatus_objectid" name="csv2post_radio_poststatus" value="private" />
                <label for="csv2post_eci_radioprivate_poststatus_objectid">private</label>';                                     
                ?>
                
            </div>  

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