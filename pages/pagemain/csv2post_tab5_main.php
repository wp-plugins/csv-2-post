<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'plugintheme';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Plugin Theme');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('You can change the look of this plugin using these theme controls.');
$panel_array['panel_help'] = __('Most of the theme is controlled by jQuery User Interface CSS. More themes can be added very easily. Theme control is ideal for developers who have themed the entire Wordpress administration area for clients.'); 
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);
$jsform_set['dialoguebox_title'] = 'Change Plugin Theme Settings'; 
$jsform_set['noticebox_content'] = 'Do you want to change theme settings?';?>
<?php csv2post_panel_header( $panel_array );?> 
         
    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?> 
    
    <script>
    $(function() {
        $( "#csv2post_theme_selection" ).buttonset();
    });
    </script>

    <div id="csv2post_theme_selection">
        <?php 
        $i = 0;
        foreach($csv2post_theme_array as $key => $theme){
            echo '<input type="radio" id="radio'.$i.'" name="radio" value="'.$theme['name'].'" />                               
            <label for="radio'.$i.'"> <img src="'.WTG_C2P_IMAGEFOLDER_URL.'themethumbs/theme_90_'. str_replace('-','_',$theme['name'] ) .'.png" alt="'.$theme['name'].' theme" width="80" height="80" /><br />'. $theme['name'] .'</label>';    
            ++$i;
        }                     
        ?>                      
    </div>

     <?php 
    // add js for dialogue on form submission and the dialogue <div> itself
    if(csv2post_SETTINGS_form_submit_dialogue($panel_array)){
        csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
        csv2post_jquery_form_prompt($jsform_set);
    }
    ?>
        
    <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>
 
<?php csv2post_panel_footer();?>

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'formsettings';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Form Settings');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Settings allowing the display and visual behaviour of form interaction.');
$panel_array['panel_help'] = __('We have a long term interest in increasing the plugins usability and accessability. Options to configure form preferences is a small step towards that goal. The first setting being added allows users to stop jQuery dialogue boxes to appear with an overlay, meaning clicking the Submit buttons will instantly process the form submission and take effect.'); 
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);
$jsform_set['dialoguebox_title'] = 'Change Form Settings'; 
$jsform_set['noticebox_content'] = 'Do you want to change form settings?';?>
<?php csv2post_panel_header( $panel_array );?> 
         
    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?>
  
    <h4>Hide/Display Dialogue</h4>
    <?php  
    $hide = 'checked';
    $display = '';    
    if(isset($csv2post_adm_set['interface']['forms']['dialogue']['status'])){                      
        if($csv2post_adm_set['interface']['forms']['dialogue']['status'] == 'hide'){
            $hide = 'checked';
            $display = '';    
        }elseif($csv2post_adm_set['interface']['forms']['dialogue']['status'] == 'display'){
            $hide = '';
            $display = 'checked';    
        }
    }?>
    <script>
        $(function() {
            $( "#csv2post_div_<?php echo $panel_array['panel_name'];?>_dialogue" ).buttonset();
        });
    </script>    
    <div id="csv2post_div_<?php echo $panel_array['panel_name'];?>_dialogue">
        <input type="radio" id="csv2post_<?php echo $panel_array['panel_name'];?>_dialogue_hide" name="csv2post_radiogroup_dialogue" value="hide" <?php echo $hide;?> /><label for="csv2post_<?php echo $panel_array['panel_name'];?>_dialogue_hide">Hide</label>
        <input type="radio" id="csv2post_<?php echo $panel_array['panel_name'];?>_dialogue_display" name="csv2post_radiogroup_dialogue" value="display" <?php echo $display;?> /><label for="csv2post_<?php echo $panel_array['panel_name'];?>_dialogue_display">Display</label>
    </div> 

       <?php 
    // add js for dialogue on form submission and the dialogue <div> itself
    if(csv2post_SETTINGS_form_submit_dialogue($panel_array)){
        csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
        csv2post_jquery_form_prompt($jsform_set);
    }
    ?>
        
    <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>

<?php csv2post_panel_footer();?>