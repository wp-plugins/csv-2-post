<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'partialuninstall';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Un-Install');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_array['panel_number'];// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = 'Delete selected parts of the plugins installation, clean-up time!';
$panel_array['panel_help'] = 'This tool allows you to delete existing records, files and database tables so that there is no longer a trace of the installation. Settings are stored in the Wordpress options table and will be removed from there. You can leave some elements of the installation in your blog for using in future or possibly to support another plugin. Just ignore this ability if your not sure what it means or you want the most simple way to remove the plugin. Just remember if you do this and then attempt to install the blog in future you may get error type messages simply letting you know something was not installed but really indicating that it already exists.';
$panel_array['help_button'] = csv2post_helpbutton_text(false,false); 
?>
<div id="titles" class="postbox">
    <div class="handlediv" title="Click to toggle"><br /></div>

    <h3 class="hndle"><span><?php echo $panel_array['panel_title'];?></span></h3>

    <div class="inside" id="<?php echo $panel_array['panel_name'];?>-box-inside-icon">

        <?php
        if(!$csv2post_is_installed){
            
            ### TODO:HIGHPRIORITY, use csv2post_was_installed to create a more dynamic message
            ### can we change the boxes displayed for each option, like a warning of some sort
            csv2post_notice(__('This plugin has not been installed, please use the First-Time Install feature above to begin using it.'), 'info', 'Extra', false);
        
        }else{?>
            <div class="<?php echo WTG_C2P_ABB;?>boxintro_div">
                <?php csv2post_helpbutton_closebox($panel_array);?>
            </div>
            <div class="<?php echo WTG_C2P_ABB;?>boxcontent_div">
                <?php
                     // Form Settings - create the array that is passed to jQuery form functions
                    $jsform_set_override = array();
                    $jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);                    
                    // make require alterations to form settings
                    $jsform_set['has_options'] = true;// true or false (controls output of selected settings
                    $jsform_set['dialoguebox_title'] = 'Un-Installing '.$csv2post_plugintitle;
                    // wtg notice box display
                    $jsform_set['noticebox_content'] = 'Do you want to un-install the selected items?';

                    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');?>

                    <?php 
                    ### TODO:LOWPRIORITY,adapt these functions, use the counters and display a notice when no items exist
                    ?>
                    
                    <h4>Data Import Job Tables</h4>
                    <?php csv2post_list_jobtables(); ?>
                    
                    <h4>CSV Files</h4>
                    <?php csv2post_list_csvfiles(); ?>
                           
                    <h4>Folders</h4>
                    <?php csv2post_list_folders(); ?>
                                                            
                    <?php ### TODO:LOWPRIORITY, display option records in groups and adapt csv2post_list_optionrecordtrace() for it?> 
                    <h4>Option Records</h4>
                    <?php csv2post_list_optionrecordtrace(true,'Tiny'); ?>                    
                                                  
                    <?php
                    // add the javascript that will handle our form action, prevent submission and display dialogue box
                    // we need to pass form objects array as 2nd parameter but in this case the options array doubles as a form options array
                    csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);

                    // add end of form - dialogue box does not need to be within the <form>
                    csv2post_formend_standard('Un-Install',$jsform_set['form_id']);?>

                    <?php csv2post_jquery_form_prompt($jsform_set);?>
            </div>
        <?php } ?>
    </div>
</div>