<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'ecifreeimages';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Step 12: Featured Images');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Select the column of data that holds image paths');
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
$panel_array['panel_help'] = __('You must have valid image paths in your data to use this feature.
You can make use of Wordpress featured image ability by selecting your image column here. As with all
CSV 2 POST features your column name does not matter i.e. it can be images,image,IMAGES,IMGS,pictures.');
$panel_array['dialogdisplay'] = 'no';
// <form> values, seperate from panel value
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
$jsform_set['dialogbox_title'] = 'NOT IN USE';
$jsform_set['noticebox_content'] = 'NOT IN USE';
?>

<?php csv2post_panel_header( $panel_array );?>
    
    <?php 
    if($csv2post_ecisession_array['nextstep'] > 12){

         csv2post_n_incontent('This step has been complete.','success','Small','Step Complete');

    }else{?>

        <?php 
        // begin form and add hidden values
        csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
        csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
        ?>

        <script>
        $(function() {
            $( "#csv2post_eci_freefeaturedimage_switch" ).buttonset();
        });
        </script>

        <div id="csv2post_eci_freefeaturedimage_switch">
            <input type="radio" id="csv2post_eci_freefeaturedimage_no" name="csv2post_eci_freefeaturedimages_methods" value="no" /><label for="csv2post_eci_freefeaturedimage_no">Do Not Create Featured Images</label>
            <input type="radio" id="csv2post_eci_freefeaturedimage_yes" name="csv2post_eci_freefeaturedimages_methods" value="yes" /><label for="csv2post_eci_freefeaturedimage_yes">Create Featured Images</label>               
        </div>

        <br />
                
        <strong>Select Featured Image Column:</strong><?php echo csv2post_menu_csvfile_headers('eci_freefeaturedimages',$csv2post_ecisession_array['dijcode'],$csv2post_ecisession_array['filename']);?><br />        
 
        <?php 
        // add js for dialog on form submission and the dialog <div> itself
        if(csv2post_SETTINGS_form_submit_dialog($panel_array)){
            csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
            csv2post_jquery_form_prompt($jsform_set);
        } 
        ?>
            
        <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>            
     
    <?php 
    }?>
    
<?php csv2post_panel_footer();?>
