<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'quickstartfreethemesupport';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Step 16: Extended Theme Support');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['dialogdisplay'] = 'no';
// <form> values, seperate from panel value
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
?>

<?php csv2post_panel_header( $panel_array );?>
    
    <?php 
    if($csv2post_ecisession_array['nextstep'] > 16){

        csv2post_n_incontent('This step was complete.','success','Small','Step Complete');

    }else{?>

        <?php 
        // begin form and add hidden values
        csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
        csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
        ?>

            <p>Your theme <?php echo get_current_theme();?> is supported.</p>

            <h4>Post Formats</h4>
            <?php 
            if ( current_theme_supports( 'post-formats' ) ) {?>
            
                <p>Apply the same Post Format to all posts (premium offers more options)</p>
                <script>
                $(function() {
                    $( "#csv2post_eci_postformat_radios" ).buttonset();
                });
                </script>

                <div id="csv2post_eci_postformat_radios">
                    <?php csv2post_FORMOBJECT_postformat_radios('quickstart');?>
                </div>  

            <?php 
            }else{
                csv2post_n_incontent('Your theme does not support Post Formats. This is something you must speak to your theme author about.',
                'info','Tiny','No Post Format Support');        
            }?> 
         
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