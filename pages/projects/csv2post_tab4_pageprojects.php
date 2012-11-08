<?php
if(!isset($csv2post_project_array['defaultposttype'])){
    echo wtgcore_notice('Current posts type is "post"','info','Tiny','','','return');    
}else{
    echo wtgcore_notice('Current posts type is "'.$csv2post_project_array['defaultposttype'].'"','info','Tiny','','','return');    
}
?>                                                                            
                                                            
<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'defaultposttype';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Set Default Post Type');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('In most cases the default post type is "post" itself but you can change that');
$panel_array['panel_help'] = __('If you need all your new posts to be "page" or a custom post type rather than actually being "post" then all you need to do is change the default post type. You can use other features to apply a mix of post types based on values per record but such advanced use of the plugin is not required for most projects. CSV 2 POST does not have custom post type management features. Custom post types registered by Wordpress and other plugins will show on the form in this panel. Please use a post type plugin if you wish to register more.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);       
$jsform_set['dialoguebox_title'] = 'Change Default Post Type';
$jsform_set['noticebox_content'] = 'Are you sure you want to change your default post type?';?>
<?php csv2post_panel_header( $panel_array );?>

    <?php csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');?>

    <?php csv2post_display_defaultposttype_radiobuttons();?>

    <?php // add current default post type to hidden input for comparison in $_POST processing
    $default_post_type = csv2post_get_project_defaultposttype($csv2post_currentproject_code);?>
    <input type="hidden" name="csv2post_defaultpostype_original" value="<?php echo $default_post_type;?>">    
    
    <?php
    // add the javascript that will handle our form action, prevent submission and display dialogue box
    csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);

    // add end of form - dialogue box does not need to be within the <form>
    csv2post_formend_standard('Submit',$jsform_set['form_id']);?>

    <?php csv2post_jquery_form_prompt($jsform_set);?>

<?php csv2post_panel_footer();?>

<?php
if(!$csv2post_is_free){
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'dynamicposttype';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Create Post Type Rules');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Create rules to apply different post types depending on values in your own data');
$panel_array['panel_help'] = __('If your data has different types of products or services, you can filter the post creation so that each type of product or service is put into a matching post type. You must have high quality data for it to work. Your selection of the proper values will determine a good outcome.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,true);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);       
$jsform_set['dialoguebox_title'] = 'Save Post Type Rule';
$jsform_set['noticebox_content'] = 'Do you want to save your new post type rule?';?>
<?php csv2post_panel_header( $panel_array );?>

    <?php csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');?>

    <p>        
        Data Column: 
        <select name="csv2post_dynamicposttype_select_columnandtable" id="csv2post_dynamicposttype_select_columnandtable_formid" class="csv2post_multiselect_menu">
            <?php csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code);?>                                                                                                                     
        </select>
    </p>

    <script>
    $("#csv2post_dynamicposttype_select_columnandtable_formid").multiselect({
       multiple: false,
       header: "Select Database Column (table - column)",
       noneSelectedText: "Select Database Column",
       selectedList: 1
    });
    </script>
    
    <?php //TODO: MEDIUMPRIORITY, change too a menu populated with unique values from selected table ?>
    <p>        
        Trigger Value: <input type="text" name="csv2post_dynamicposttype_text_trigger" id="csv2post_dynamicposttype_text_trigger_formid" value="" />
    </p>
     
    <p>                    
        Post Type: 
        <select name="csv2post_dynamicposttype_select_posttype" id="csv2post_dynamicposttype_select_posttype_formid" class="csv2post_multiselect_menu">
            <?php csv2post_display_posttypes_menu_options();?>                                                                                                                     
        </select>        
    </p>
    <script>
    $("#csv2post_dynamicposttype_select_posttype_formid").multiselect({
       multiple: false,
       header: "Post Type",
       noneSelectedText: "Post Type",
       selectedList: 1
    });
    </script>
    
    <?php csv2post_display_posttyperules_byvalue_table();?>
            
    <?php
    // add the javascript that will handle our form action, prevent submission and display dialogue box
    csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);

    // add end of form - dialogue box does not need to be within the <form>
    csv2post_formend_standard('Submit',$jsform_set['form_id']);?>

    <?php csv2post_jquery_form_prompt($jsform_set);?>

<?php csv2post_panel_footer();
}?> 