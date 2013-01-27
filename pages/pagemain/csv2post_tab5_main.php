<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'plugintheme';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Plugin Theme');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('You can change the look of this plugin using these theme controls.');
$panel_array['panel_help'] = __('Most of the theme is controlled by jQuery User Interface CSS. More themes can be added very easily. Theme control is ideal for developers who have themed the entire Wordpress administration area for clients.'); 
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);
$jsform_set['dialogbox_title'] = 'Change Plugin Theme Settings'; 
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
    // add js for dialog on form submission and the dialog <div> itself
    if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
        csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
        csv2post_jquery_form_prompt($jsform_set);
    }
    ?>
        
    <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>
 
<?php csv2post_panel_footer();?>
         
<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'formsettings';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Form Settings');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Settings allowing the display and visual behaviour of form interaction.');
$panel_array['panel_help'] = __('We have a long term interest in increasing the plugins usability and accessability. Options to configure form preferences is a small step towards that goal. The first setting being added allows users to stop jQuery dialog boxes to appear with an overlay, meaning clicking the Submit buttons will instantly process the form submission and take effect.'); 
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);
$jsform_set['dialogbox_title'] = 'Change Form Settings'; 
$jsform_set['noticebox_content'] = 'Do you want to change form settings?';?>
<?php csv2post_panel_header( $panel_array );?> 
         
    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?>
  
    <h4>Hide/Display Dialog</h4>
    <?php  
    $hide = 'checked';
    $display = '';    
    if(isset($csv2post_adm_set['interface']['forms']['dialog']['status'])){                      
        if($csv2post_adm_set['interface']['forms']['dialog']['status'] == 'hide'){
            $hide = 'checked';
            $display = '';    
        }elseif($csv2post_adm_set['interface']['forms']['dialog']['status'] == 'display'){
            $hide = '';
            $display = 'checked';    
        }
    }?>
    <script>
        $(function() {
            $( "#csv2post_div_<?php echo $panel_array['panel_name'];?>_dialog" ).buttonset();
        });
    </script>    
    <div id="csv2post_div_<?php echo $panel_array['panel_name'];?>_dialog">
        <input type="radio" id="csv2post_<?php echo $panel_array['panel_name'];?>_dialog_hide" name="csv2post_radiogroup_dialog" value="hide" <?php echo $hide;?> /><label for="csv2post_<?php echo $panel_array['panel_name'];?>_dialog_hide">Hide</label>
        <input type="radio" id="csv2post_<?php echo $panel_array['panel_name'];?>_dialog_display" name="csv2post_radiogroup_dialog" value="display" <?php echo $display;?> /><label for="csv2post_<?php echo $panel_array['panel_name'];?>_dialog_display">Display</label>
    </div> 

    <?php 
    // add js for dialog on form submission and the dialog <div> itself
    if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
        csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
        csv2post_jquery_form_prompt($jsform_set);
    }
    ?>
        
    <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>

<?php csv2post_panel_footer();?>

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'screenpermissions';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Screen Permissions');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Set the capability a user must have to access each tabbed screen');
$panel_array['panel_help'] = __('Screens are the individual tabbed parts of the interface. We refer to the whole set
of screens as being on a specific page as selected in the plugins main menu. These settings do not configure Page access,
another panel does this. This panel allows us to set access permissions per tabbed screen (not per page) based on Wordpress user capabilities.
Wordpress capabilities allow specific users to be giving specific permission which
can ignore their role i.e. Editor, Author, Subscriber. This interface allows us to allow specific users access
to individual screens rather than allowing everyone with a specific role to access them.'); 
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);
$jsform_set['dialogbox_title'] = 'Change Screen Permissions'; 
$jsform_set['noticebox_content'] = 'Changing these settings can potentially allow users to access content they are not authorized?';?>
<?php csv2post_panel_header( $panel_array );?> 
         
    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?>
  
    <?php      
    // include capabilities array for ther permissions forms
    require( WTG_C2P_DIR . 'wtg-core/wp/wparrays/wtgcore_wp_capabilities_array.php' );

    ### TODO:CRITICAL, create an array of capabilities and feed it to the capability menu so we are not looping through the roles array many times
    $menu_id = 0;
    foreach($csv2post_mpt_arr['menu'] as $page_name => $page_array){
        
        echo '<h2>' . $page_name . '</h2>';
        echo '<table class="widefat post fixed">';
        echo '<tr><td><strong>Screen Name</strong></td><td><strong>Default Required Capability</strong></td><td><strong>Current Required Capability</strong></td></tr>';
        
        foreach($page_array['tabs'] as $key => $tab_array){
            
            // do not display tab names for screens user is not meant to see
            if(isset($tab_array['display']) && $tab_array['display'] != false){
                                    
                echo '<tr>';
                
                echo '<td>' . $tab_array['label'] . '</td>';
       
                echo '<td>' . csv2post_WP_SETTINGS_get_tab_capability($page_name,$key,true). '</td>';
                
                echo '<td>';

                csv2post_FORM_menu_capabilities($csv2post_ARRAY_capabilities,$page_name,$key,csv2post_WP_SETTINGS_get_tab_capability($page_name,$key,false));     
                                                         
                echo '</td>';
                
                echo '</tr>';
            
                ++$menu_id; 
            }        
        }
        
        echo '</table>';
    }
    
    echo '<input type="hidden" name="csv2post_total_menus" value="'.$menu_id.'">'; 
    ?>

    <?php 
    // add js for dialog on form submission and the dialog <div> itself
    if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
        csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
        csv2post_jquery_form_prompt($jsform_set);
    }
    ?>
        
    <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>

<?php csv2post_panel_footer();?>

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'pagepermissions';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Page Permissions');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Use Wordpress capabilities to configure individual user access to specific Pages (not screens)');
$panel_array['panel_help'] = __('This panel allows you to configure which Wordpess capabilities are required
to access each page. If a user does not have the required capability, the page will not be displayed in the plugins
menu and none of the pages screens can be visited by URL either.'); 
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);
$jsform_set['dialogbox_title'] = 'Change Page Permissions'; 
$jsform_set['noticebox_content'] = 'Changing these settings can potentially allow users to access content they are not authorized?';?>
<?php csv2post_panel_header( $panel_array );?> 
         
    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?>
  
    <?php   
    ### TODO:CRITICAL, create an array of capabilities and feed it to the capability menu so we are not looping through the roles array many times
    echo '<table class="widefat post fixed">';
    echo '<tr><td><strong>Page Name</strong></td><td><strong>Default Required Capability</strong></td><td><strong>Current Required Capability</strong></td></tr>';
            
    foreach($csv2post_mpt_arr['menu'] as $page_name => $page_array){

        echo '<tr>';
        
        echo '<td>' . $page_name . '</td>';

        echo '<td>' . csv2post_WP_SETTINGS_get_page_capability($page_name,true). '</td>';
        
        echo '<td>';

        csv2post_FORM_menu_capabilities($csv2post_ARRAY_capabilities,$page_name,99,csv2post_WP_SETTINGS_get_page_capability($page_name,$key,false));     
                                                                                      
        echo '</td>';
        
        echo '</tr>';
    }
    
    echo '</table>';
    ?>

    <?php 
    // add js for dialog on form submission and the dialog <div> itself
    if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
        csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
        csv2post_jquery_form_prompt($jsform_set);
    }
    ?>
        
    <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>

<?php csv2post_panel_footer();?>
