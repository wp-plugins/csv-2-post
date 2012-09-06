<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'plugintheme';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Plugin Theme');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $wtgcsv_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('You can change the look of this plugin using these theme controls.');
$panel_array['panel_help'] = __('Most of the theme is controlled by jQuery User Interface CSS. More themes can be added very easily. Theme control is ideal for developers who have themed the entire Wordpress administration area for clients.'); 
$panel_array['help_button'] = wtgcsv_helpbutton_text(false,false);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = wtgcsv_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);
$jsform_set['dialoguebox_title'] = 'Change Plugin Theme Settings'; 
$jsform_set['noticebox_content'] = 'Do you want to change theme settings?';?>
<?php wtgcsv_panel_header( $panel_array );?> 
         
    <?php wtgcsv_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','wtgcsv_form','');
    
    wtgcsv_hidden_form_values($wtgcsv_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);?>

    <script>
    $(function() {
        $( "#radio321" ).buttonset();
    });
    </script>

    <div id="radio321">
        <?php 
        $i = 0;
        foreach($wtgcsv_theme_array as $key => $theme){
            echo '<input type="radio" id="radio'.$i.'" name="radio" value="'.$theme['name'].'" />                               
            <label for="radio'.$i.'"> <img src="'.WTG_CSV_IMAGEFOLDER_URL.'themethumbs/theme_90_'. str_replace('-','_',$theme['name'] ) .'.png" alt="'.$theme['name'].' theme" width="80" height="80" /><br />'. $theme['name'] .'</label>';    
            ++$i;
        }                     
        ?>                      
    </div>

    <?php 
    // add the javascript that will handle our form action, prevent submission and display dialogue box
    wtgcsv_jqueryform_singleaction_middle($jsform_set,$wtgcsv_options_array);

    // add end of form - dialogue box does not need to be within the <form>
    wtgcsv_formend_standard(__('Save'),$jsform_set['form_id']);?>
     
    <?php wtgcsv_jquery_form_prompt($jsform_set);?>
 
<?php wtgcsv_panel_footer();?>