<?php 
### TODO:MEDIUMPRIORITY
// 'post_password'  => [ ? ] //password for post?    boolean I THINK! 
?>

<?php
if(!isset($csv2post_project_array['defaultposttype'])){
    echo csv2post_notice('Current posts type is "post"','info','Tiny','','','return');    
}else{
    echo csv2post_notice('Current posts type is "'.$csv2post_project_array['defaultposttype'].'"','info','Tiny','','','return');    
}
?>                                                                            
                                                            
<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'defaultposttype';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Set Default Post Type');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('If you need all your new posts to be "page" or a custom post type rather than actually being "post" then all you need to do is change the default post type. You can use other features to apply a mix of post types based on values per record but such advanced use of the plugin is not required for most projects. CSV 2 POST does not have custom post type management features. Custom post types registered by Wordpress and other plugins will show on the form in this panel. Please use a post type plugin if you wish to register more.');
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);       
$jsform_set['dialogbox_title'] = 'Change Default Post Type';
$jsform_set['noticebox_content'] = 'Are you sure you want to change your default post type?';?>
<?php csv2post_panel_header( $panel_array );?>

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?>
    
    <?php csv2post_display_defaultposttype_radiobuttons();?>

    <?php // add current default post type to hidden input for comparison in $_POST processing
    $default_post_type = csv2post_get_project_defaultposttype($csv2post_currentproject_code);?>
    <input type="hidden" name="csv2post_defaultpostype_original" value="<?php echo $default_post_type;?>">    
    
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
if(!$csv2post_is_free){
    ++$panel_number;// increase panel counter so this panel has unique ID
    $panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
    $panel_array['panel_name'] = 'dynamicposttype';// slug to act as a name and part of the panel ID 
    $panel_array['panel_title'] = __('Create Post Type Rules');// user seen panel header text 
    $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
    $panel_array['panel_help'] = __('If your data has different types of products or services, you can filter the post creation so that each type of product or service is put into a matching post type. You must have high quality data for it to work. Your selection of the proper values will determine a good outcome.');
    // Form Settings - create the array that is passed to jQuery form functions
    $jsform_set_override = array();
    $jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);       
    $jsform_set['dialogbox_title'] = 'Save Post Type Rule';
    $jsform_set['noticebox_content'] = 'Do you want to save your new post type rule?';?>
    <?php csv2post_panel_header( $panel_array );?>

        <?php 
        // begin form and add hidden values
        csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');
        csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
        ?>
        
        <p>        
            Data Column: 
            <select name="csv2post_dynamicposttype_select_columnandtable" id="csv2post_dynamicposttype_select_columnandtable_formid" class="csv2post_multiselect_menu">
                <?php csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code);?>                                                                                                                     
            </select>
        </p>
        
        <?php //TODO: MEDIUMPRIORITY, change to a menu populated with unique values from selected table ?>
        <p>        
            Trigger Value: <input type="text" name="csv2post_dynamicposttype_text_trigger" id="csv2post_dynamicposttype_text_trigger_formid" value="" />
        </p>
         
        <p>                    
            Post Type: 
            <select name="csv2post_dynamicposttype_select_posttype" id="csv2post_dynamicposttype_select_posttype_formid" class="csv2post_multiselect_menu">
                <?php csv2post_display_posttypes_menu_options();?>                                                                                                                     
            </select>        
        </p>
         
        <?php csv2post_display_posttyperules_byvalue_table();?>
                
         <?php 
        // add js for dialog on form submission and the dialog <div> itself
        if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
            csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
            csv2post_jquery_form_prompt($jsform_set);
        }
        ?>
            
        <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>

    <?php csv2post_panel_footer();
}?> 

<?php
if(!$csv2post_is_free && isset($csv2post_project_array['defaultposttype']) && $csv2post_project_array['defaultposttype'] == 'page'){
    ++$panel_number;// increase panel counter so this panel has unique ID
    $panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
    $panel_array['panel_name'] = 'subpagesbypermalinks';// slug to act as a name and part of the panel ID 
    $panel_array['panel_title'] = __('Sub-Pages By Permalinks/Slugs');// user seen panel header text 
    $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
    $panel_array['panel_help'] = __('This method is called Permalinks but it is actually the slug part of
    a pages data that is important. For this method to work the data must must have two columns with
    suitably prepared. A column that indicates the level of page
    each record is meant to create and a colum holding the slug of the parent page. 
    CSV 2 POST needs to query the records in order, creating the first level of
    pages first so that no matter what 2nd level page the plugin creates. The parent should be there, providing
    the data is good. Despite any sample data we may provide or examples in videos or screenshots. The
    columns can have any header/title. If you use Sub-Pages you cannot use page type rules or it
    may cause faults.');
    // Form Settings - create the array that is passed to jQuery form functions
    $jsform_set_override = array();
    $jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);       
    $jsform_set['dialogbox_title'] = 'Activate Sub-Pages by Permalinks/Slugs';
    $jsform_set['noticebox_content'] = 'You are about to apply configuration to your project that
    requires data prepared for this specific method. Do you wish to continue?';?>
    <?php csv2post_panel_header( $panel_array );?>

        <?php 
        // begin form and add hidden values
        csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');
        csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
        ?>
        
        <script>
        $(function() {
            $( "#csv2post_subpage_permalinks_switch" ).buttonset();
        });
        </script>

        <div id="csv2post_subpage_permalinks_switch">
            <?php
            if(isset($csv2post_project_array['subpages']['status']) 
            && $csv2post_project_array['subpages']['status'] == true
            && isset($csv2post_project_array['subpages']['method'])
            && $csv2post_project_array['subpages']['method'] == 'permalinks'){
                $s_1 = 'checked="checked"';
                $s_2 = '';    
            }else{
                $s_1 = '';
                $s_2 = 'checked="checked"';                 
            }
            ?>
            <input type="radio" id="csv2post_subpage_permalinks_radio_on_id" name="csv2post_subpage_permalinks_radio" value="on" <?php echo $s_1;?> />
            <label for="csv2post_subpage_permalinks_radio_on_id">On</label>
            <input type="radio" id="csv2post_subpage_permalinks_radio_off_id" name="csv2post_subpage_permalinks_radio" value="off" <?php echo $s_2;?> />
            <label for="csv2post_subpage_permalinks_radio_off_id">Off</label>        
        </div>
        
        <br />

        <?php
        if(isset($csv2post_project_array['subpages']['levelcolumn']['table']) 
        && isset($csv2post_project_array['subpages']['levelcolumn']['column'])){
            $t1 = $csv2post_project_array['subpages']['levelcolumn']['table'];
            $c1 = $csv2post_project_array['subpages']['levelcolumn']['column'];
        }else{
            $t1 = false;
            $c1 = false;                      
        } 
        ?>                          
        <label for="csv2post_subpages_bypermalinks_level_id">Select Level Column: 
        <select name="csv2post_subpages_bypermalinks_level" id="csv2post_subpages_bypermalinks_level_id" class="csv2post_multiselect_menu">
            <?php $atts = array('table' => $t1,'column' => $c1,'usedefault' => false);
            csv2post_GUI_menuoptions_project_columnsandtables($project_code,$atts);?>        
        </select></label>        
        
        <br />
                                                                                                                                                                                                    
        <?php
        if(isset($csv2post_project_array['subpages']['slugscolumn']['table']) && isset($csv2post_project_array['subpages']['slugscolumn']['column'])){
            $levone1t = $csv2post_project_array['subpages']['slugscolumn']['table'];
            $levone1c = $csv2post_project_array['subpages']['slugscolumn']['column'];
        }else{
            $levone1t = 'hasnotbeenset';
            $levone1c = 'hasnotbeenset';
        } 
        ?>                
        <label for="csv2post_subpages_bypermalinks_slug_id">Slug Column: 
        <select name="csv2post_subpages_bypermalinks_slug" id="csv2post_subpages_bypermalinks_slug_id" class="csv2post_multiselect_menu">
            <?php $atts = array('table' => $levone1t,'column' => $levone1c,'usedefault' => false);
            csv2post_GUI_menuoptions_project_columnsandtables($project_code,$atts);?>
        </select></label>        
        
        <br />

        <?php 
        // add js for dialog on form submission and the dialog <div> itself
        if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
            csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
            csv2post_jquery_form_prompt($jsform_set);
        }
        ?>
            
        <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>

    <?php csv2post_panel_footer();
}?>

<?php
$testing = 1;
if(!$csv2post_is_free && isset($csv2post_project_array['defaultposttype']) && $csv2post_project_array['defaultposttype'] == 'page' && $testing == 2){
    ++$panel_number;// increase panel counter so this panel has unique ID
    $panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
    $panel_array['panel_name'] = 'subpagesbygroupingtwocolumn';// slug to act as a name and part of the panel ID 
    $panel_array['panel_title'] = __('Sub-Pages By Grouping (Two Columns) BETA');// user seen panel header text 
    $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
    $panel_array['panel_help'] = __('Beta feature added 28th January 2013');
    // Form Settings - create the array that is passed to jQuery form functions
    $jsform_set_override = array();
    $jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);       
    $jsform_set['dialogbox_title'] = 'BETA';
    $jsform_set['noticebox_content'] = 'BETA';?>
    <?php csv2post_panel_header( $panel_array );?>

        <?php 
        // begin form and add hidden values
        csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');
        csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
        ?>
        
        This method requires a column of group ID's and a column indicating if a record is the parent or not. All
        none parents automatically being assigned to the parent. 
        
        <script>
        $(function() {
            $( "#csv2post_subpage_grouping_switch" ).buttonset();
        });
        </script>

        <div id="csv2post_subpage_grouping_switch">
            <input type="radio" id="csv2post_subpage_grouping_radio_on_id" name="csv2post_subpage_grouping_radio" value="on" />
            <label for="csv2post_subpage_grouping_radio_on_id">On</label>
            <input type="radio" id="csv2post_subpage_grouping_radio_off_id" name="csv2post_subpage_grouping_radio" value="off" />
            <label for="csv2post_subpage_grouping_radio_off_id">Off</label>        
        </div>
        
        <br />
        
        <label for="csv2post_subpages_bygrouping_parent_id">Select Group ID Column: 
        <select name="csv2post_subpages_bygrouping_parent" id="csv2post_subpages_bygrouping_parent_id" class="csv2post_multiselect_menu">
            <?php $atts = array('table' => 'TBC','column' => 'TBC','usedefault' => false);
            csv2post_GUI_menuoptions_project_columnsandtables($project_code,$atts);?>        
        </select></label>        
        
        <br />
        
        <label for="csv2post_subpages_bygrouping_sub1_id">Select Type Column: 
        <select name="csv2post_subpages_bygrouping_sub1" id="csv2post_subpages_bygrouping_sub1_id" class="csv2post_multiselect_menu">
            <?php $atts = array('table' => 'TBC','column' => 'TBC','usedefault' => false);
            csv2post_GUI_menuoptions_project_columnsandtables($project_code,$atts);?>
        </select></label> 
        
        <br />
                              
        <?php 
        // add js for dialog on form submission and the dialog <div> itself
        if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
            csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
            csv2post_jquery_form_prompt($jsform_set);
        }
        ?>
            
        <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>

    <?php csv2post_panel_footer();
}?>