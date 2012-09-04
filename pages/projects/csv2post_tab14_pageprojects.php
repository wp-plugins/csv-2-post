<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'defaultauthor';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Default Author');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Select a user in your blog to be applied as the author by default');
$panel_array['panel_help'] = __('Your default author will always be the author applied if you do not setup any other advanced rules.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);               
$jsform_set['dialoguebox_title'] = 'Save Default Author';
$jsform_set['noticebox_content'] = 'Do you want to save a default author now?';?>
<?php csv2post_panel_header( $panel_array );?>

    <?php csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');?>

    <select name="csv2post_defaultauthor_select" id="csv2post_defaultauthor_select_id" class="csv2post_multiselect_menu">
        
        <?php
        // apply selected too default option when no value has been saved already
        $selected = '';
        $current = ''; 
        if(!isset($csv2post_project_array['defaultuser'])){
            $selected = 'selected="selected"';
        }else{
            $current = $csv2post_project_array['defaultuser'];
        }?>
        
        <option value="notselected" <?php echo $selected;?>>ID - Category Name (None Selected)</option> 
                
        <?php csv2post_display_users_options($current);?>
                                                                                                                             
    </select>  
      
    <script>
    $("#csv2post_defaultauthor_select_id").multiselect({
       multiple: false,
       header: "Select Default Author",
       noneSelectedText: "Select Default Author",
       selectedList: 1
    });
    </script>
    
    <br />
       
    <?php
    // add the javascript that will handle our form action, prevent submission and display dialogue box
    csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);

    // add end of form - dialogue box does not need to be within the <form>
    csv2post_formend_standard('Submit',$jsform_set['form_id']);?>

    <?php csv2post_jquery_form_prompt($jsform_set);?>

<?php csv2post_panel_footer();?>