<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'exportsingletabledata';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Export Single Table');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $wtgcsv_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Export any table from your Wordpress database');
$panel_array['panel_help'] = __('Export a single table from your Wordpress database. Currently this export tool will only export as a .csv file. If you would like the ability to select different export formats i.e. sql, xml, txt, then please let me know');
$panel_array['help_button'] = wtgcsv_helpbutton_text(false,true);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = wtgcsv_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);               
$jsform_set['dialoguebox_title'] = 'Export Selected Database Table';
$jsform_set['noticebox_content'] = 'Do you want to begin export the selected database table as a .csv file?';
// TODO: LOWPRIORITY, added ability to select different export formats
// TODO: LOWPRIORITY, once format selection is available add the selected format too the dialogue message?>
<?php wtgcsv_panel_header( $panel_array );?> 

    <?php wtgcsv_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','wtgcsv_form','');?>

    <p>        
        <select id="wtgpt_dataexport_selecttables" name="wtgpt_exporttable" multiple="no" class="wtgcsv_multiselect_menu">
            <?php wtgcsv_option_items_databasetables();?>
        </select>
    </p>
    
    <script>
    $("#wtgpt_dataexport_selecttables").multiselect({
       multiple: false,
       header: "Select a table",
       noneSelectedText: "Select a table",
       selectedList: 1
    });
    </script>
           
     <?php
    // add the javascript that will handle our form action, prevent submission and display dialogue box
    wtgcsv_jqueryform_singleaction_middle($jsform_set,$wtgcsv_options_array);

    // add end of form - dialogue box does not need to be within the <form>
    wtgcsv_formend_standard('Submit',$jsform_set['form_id']);?>

    <?php wtgcsv_jquery_form_prompt($jsform_set);?>

<?php wtgcsv_panel_footer();?>

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'exportmultipletables';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Export Multiple Tables');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $wtgcsv_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Export more than one database table into a single file as one set of data');
$panel_array['panel_help'] = __('This tool can be used to merge multiple tables of data. You can select any table installed in your Wordpress database.');
$panel_array['help_button'] = wtgcsv_helpbutton_text(true,true);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = wtgcsv_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);               
$jsform_set['dialoguebox_title'] = 'Export Multiple Database Tables';
$jsform_set['noticebox_content'] = 'Do you want to continue creating a CSV file using multiple database tables?';
// TODO: LOWPRIORITY, added ability to select different export formats
// TODO: LOWPRIORITY, once format selection is available add the selected format too the dialogue message
?>
<?php wtgcsv_panel_header( $panel_array );?> 

    <?php wtgcsv_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','wtgcsv_form','');?>

    <script type="text/javascript">
        $(function(){
            $('.multi-select-example2222222').multiSelect();
        });
    </script>

    <div id="<?php echo WTG_CSV_ABB;?>multi-select_csvfiles">
        <select multiple='multiple' id="listtestidtest" class='multi-select-example2222222' name="listtest[]">
            <?php wtgcsv_option_items_databasetables();?> 
        </select>
    </div>

     <?php
    // add the javascript that will handle our form action, prevent submission and display dialogue box
    wtgcsv_jqueryform_singleaction_middle($jsform_set,$wtgcsv_options_array);

    // add end of form - dialogue box does not need to be within the <form>
    wtgcsv_formend_standard('Submit',$jsform_set['form_id']);?>

    <?php wtgcsv_jquery_form_prompt($jsform_set);?>

<?php wtgcsv_panel_footer();?>