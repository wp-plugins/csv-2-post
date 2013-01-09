<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'ecifreeposttypes';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Step 17: Post Types');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Do you want to create posts or pages?');
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
$panel_array['panel_help'] = __('CSV 2 POST can offer more options than post and pages i.e. custom post types. 
However the Easy CSV Importer system has been simplified. Feel free to hack it so that your required post type
is setup instead, when using the ECI system. Also check out the more complex interface providing in this free
plugin to configure post type.');
$panel_array['dialogdisplay'] = 'no';
// <form> values, seperate from panel value
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
?>

<?php csv2post_panel_header( $panel_array );?>
    
    <?php 
    if($csv2post_ecisession_array['nextstep'] > 17){

        csv2post_n_incontent('This step has been complete.','success','Small','Step Complete');

    }else{?>

        <?php 
        // begin form and add hidden values
        csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
        csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
        ?> 
       
        <script>
        $(function() {
            $( "#csv2post_ecifreedefaultposttype" ).buttonset();
        });
        </script>

        <div id="csv2post_ecifreedefaultposttype">
            
            <?php
            echo '<input type="radio" id="csv2post_ecifreedefaultposttype_post" name="csv2post_radio_defaultpostype" value="post" />
            <label for="csv2post_ecifreedefaultposttype_post">post</label>';
                    
            echo '<input type="radio" id="csv2post_ecifreedefaultposttype_page" name="csv2post_radio_defaultpostype" value="page" />
            <label for="csv2post_ecifreedefaultposttype_page">page</label>';?>
            
        </div>      

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