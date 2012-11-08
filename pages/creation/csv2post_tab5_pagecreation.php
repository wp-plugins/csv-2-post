<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'createcategories';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Create Categories');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Create categories now instead of the plugin doing it during post creation');
$panel_array['panel_help'] = __('You do not need to use this tool for category creation. The plugin will create
categories based on your category settings, during post creation. However this tool allows us to use CSV 2 POST
for category creation only or to test our category creation settings and data prior to making posts. Multiple
levels of category creation can be very complex, occasionally the outcome is not perfect first time around. We 
recommend that you run tests on test blog and also backup your database for the live blog.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,true);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);     
$jsform_set['dialoguebox_title'] = 'Create Categories Now';
$jsform_set['noticebox_content'] = 'You are about to create categories using all of your category data, based on your category settings. Do you wish to continue?';
// TODO:MEDIUMPRIORITY, add optional date criteria to restrict deletion to a publish date range ?>

<?php csv2post_panel_header( $panel_array );?>

    <?php csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');?>

    <?php
    // we will run some initial checks to ensure category settings have been saved else notifications are displayed
    // if no category settings saved at all
    if(!isset($csv2post_project_array['categories'])){
        
        echo wtgcore_notice( 'No category settings have been saved for your current project. You must save some category settings to make categories as the plugin does not know what columns your category data is in or the order of categories.','warning','Large','No Category Settings',
        'www.csv2post.com/notifications/no-category-settings-saved-for-testing','return');
    
    }else{

        echo wtgcore_notice('Do not use this tool until you have complete your Category settings. We also
        recommend that you backup your database. Click submit when you are ready to continue.','warning','Large','Warning','','return');

        // add the javascript that will handle our form action, prevent submission and display dialogue box
        csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);

        // add end of form - dialogue box does not need to be within the <form>
        csv2post_formend_standard('Submit',$jsform_set['form_id']);

        csv2post_jquery_form_prompt($jsform_set);        
             
    }?>
                
<?php csv2post_panel_footer();?>