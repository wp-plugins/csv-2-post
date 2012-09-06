<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'reinstall';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Re-Install');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $wtgcsv_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = 'Re-install all or selected parts of the plugin.';
$panel_array['panel_help'] = 'Select the specific items you would like to re-install. In most cases you would select them all for a complete fresh install but in some cases you might want to keep existing data/settings to save time configuring your new installation of the plugin.';
$panel_array['help_button'] = wtgcsv_helpbutton_text(false,false); 
?>
<div id="titles" class="postbox closed">
    <div class="handlediv" title="Click to toggle"><br /></div>

    <h3 class="hndle"><span><?php echo $panel_array['panel_title'];?></span></h3>

    <div class="inside" id="<?php echo $panel_array['panel_name'];?>-box-inside-icon"> 
 
        <?php
        if(!$wtgcsv_is_installed){
            
### TODO:HIGHPRIORITY, use wtgcsv_was_installed to create a more dynamic message 
        
            wtgcsv_notice(__('The plugin has not been installed, please use the First-Time Install feature above to begin using it.'), 'info', 'Extra', false);
           
        }else{?>
            <div class="<?php echo WTG_CSV_ABB;?>boxintro_div">
                <?php wtgcsv_helpbutton_closebox($panel_array);?>
            </div>
            <div class="<?php echo WTG_CSV_ABB;?>boxcontent_div">
                <?php
                // check existing plugins and give advice or warnings
                $conflict_found = wtgcsv_plugin_conflict_prevention();
                
                if($wtgcsv_requirements_missing == true && $conflict_found == false){
                    
                   // important requirement not met
                    wtgcsv_notice(__('Re-Install options have been hidden as your Wordpress installation does not meet requirements for this plugin to operate properly. The reason should be displayed in another message above.'),'info','Large',false);
                
               }elseif($wtgcsv_requirements_missing == false && $conflict_found == true){
                    
                    // a critical conflict has been found
                    wtgcsv_notice(__('A known and potentially problematic conflict is preventing this plugin being re-installed. This is to protect your blog, please seek support. The conflict should be displayed in another message above.'),'info','Large',false);

               }elseif($wtgcsv_requirements_missing == false && $conflict_found == false){
                     
                    // Form Settings - create the array that is passed to jQuery form functions
                    $jsform_set_override = array();
                    $jsform_set = wtgcsv_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override); 
                    // make require alterations to form settings 
                    $jsform_set['has_options'] = true;// true or false (controls output of selected settings)
                    $jsform_set['dialoguebox_title'] = 'Re-Installing '.WTG_CSV_PLUGINTITLE;
                    // wtg notice box display
                    $jsform_set['noticebox_content'] = __('Do you want to re-install '.WTG_CSV_PLUGINTITLE.' by deleting all existing installed parts then re-installing them?');

                    wtgcsv_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','wtgcsv_form','');?>

                    <?php wtgcsv_jquery_graphiccheckboxes();?>

                      <script type='text/javascript'>
                      $(function(){
                              $(document).ready(function() {
                                // change checkbox state check .checkbox-select click happens
                                $(".checkbox-select").click(function() {
                                    $(this).closest("li").find(":checkbox").attr("checked",true);
                                });
                                $(".checkbox-deselect").click(function() {
                                    $(this).closest("li").find(":checkbox").attr("checked",false);
                                })
                            });
                      });
                      </script>
                    
                    <fieldset>
                            <legend><?php _e('Choose what to re-install, cannot be reversed please take your time...');?></legend>
                            <br />
                            <ul class="checklist">
   
                                <?php
                                // loop through the options array to add form items
                                $i = 0;
                                $exclusions = array(WTG_CSV_ABB . 'was_installed');// this is never removed, helps to indicate plugin has been used on blog but we dont show it too user
                                foreach( $wtgcsv_options_array as $arraykey => $parameter){
                                    
                                    if( $parameter['public'] == 'true'){
                                        echo ' <li>
                                                    <input name="reinstall_object_name_'.$arraykey.'" value="'.$parameter['name'].'" type="checkbox" id="'.$arraykey.'" checked="checked"/>
                                                    <label for="'.$arraykey.'">'.$parameter['name'].' '.$arraykey.'</label>
                                                    <a class="checkbox-select" href="#">Select</a>
                                                    <a class="checkbox-deselect" href="#">Click To Exclude</a>
                                            </li>';
                                        ++$i;
                                    }
                                    
                                } ?>
                                
                            </ul>
                            <div style="clear: both;"></div>
                    </fieldset>

                    <?php                    
                    // add the javascript that will handle our form action, prevent submission and display dialogue box
                    // we need to pass form objects array as 2nd parameter but in this case the options array doubles as a form options array
                    wtgcsv_jqueryform_singleaction_middle($jsform_set,$wtgcsv_options_array);

                    // add end of form - dialogue box does not need to be within the <form>
                    wtgcsv_formend_standard('Submit',$jsform_set['form_id']);?>

                    <?php wtgcsv_jquery_form_prompt($jsform_set);?>

            <?php }// end if requirements met for installation

                echo '</div>';

            }// is already installed??>

    </div>
</div>

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'uninstall';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Un-Install');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $wtgcsv_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_array['panel_number'];// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = 'Delete the plugins settings, uploaded files and database tables';
$panel_array['panel_help'] = 'This tool allows you to delete existing records, files and database tables so that there is no longer a trace of the installation. Settings are stored in the Wordpress options table and will be removed from there. You can leave some elements of the installation in your blog for using in future or possibly to support another plugin. Just ignore this ability if your not sure what it means or you want the most simple way to remove the plugin. Just remember if you do this and then attempt to install the blog in future you may get error type messages simply letting you know something was not installed but really indicating that it already exists.';
$panel_array['help_button'] = wtgcsv_helpbutton_text(false,false); 
?>
<div id="titles" class="postbox closed">
    <div class="handlediv" title="Click to toggle"><br /></div>

    <h3 class="hndle"><span><?php echo $panel_array['panel_title'];?></span></h3>

    <div class="inside" id="<?php echo $panel_array['panel_name'];?>-box-inside-icon">

        <?php
        if(!$wtgcsv_is_installed){
            
            ### TODO:HIGHPRIORITY, use wtgcsv_was_installed to create a more dynamic message
            ### can we change the boxes displayed for each option, like a warning of some sort
            wtgcsv_notice(__('This plugin has not been installed, please use the First-Time Install feature above to begin using it.'), 'info', 'Extra', false);
        
        }else{?>
            <div class="<?php echo WTG_CSV_ABB;?>boxintro_div">
                <?php wtgcsv_helpbutton_closebox($panel_array);?>
            </div>
            <div class="<?php echo WTG_CSV_ABB;?>boxcontent_div">
                <?php
                     // Form Settings - create the array that is passed to jQuery form functions
                    $jsform_set_override = array();
                    $jsform_set = wtgcsv_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);                    
                    // make require alterations to form settings
                    $jsform_set['has_options'] = true;// true or false (controls output of selected settings
                    $jsform_set['dialoguebox_title'] = 'Un-Installing '.WTG_CSV_PLUGINTITLE;
                    // wtg notice box display
                    $jsform_set['noticebox_content'] = 'Do you want to un-install some or all of '.WTG_CSV_PLUGINTITLE.'?';

                    wtgcsv_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','wtgcsv_form','');?>

                    <?php wtgcsv_jquery_graphiccheckboxes();?>

                      <script type='text/javascript'>
                      $(function(){
                              $(document).ready(function() {
                                $(".checkbox-select").click(function() {
                                    $(this).closest("li").find(":checkbox").attr("checked",true);
                                });
                                $(".checkbox-deselect").click(function() {
                                    $(this).closest("li").find(":checkbox").attr("checked",false);
                                })
                            });
                      });
                      //]]>
                      </script>


                    <fieldset>
                        <legend><?php _e('Choose what to keep in the blog and what to remove...');?></legend>
                        <br />
                        <ul class="checklist">

                            <?php
                            // loop through the options array to add form items
                            $i = 0;
                            foreach( $wtgcsv_options_array as $arraykey => $parameter){

                                if( $parameter['public'] == 'true'){
                                    echo '<li>
                                                <input name="uninstall_object_name_'.$arraykey.'" value="'.$parameter['name'].'" type="checkbox" id="'.$arraykey.'" checked="checked"/>
                                                <label for="'.$arraykey.'">'.$parameter['name'].' '.$arraykey.'</label>
                                                <a class="checkbox-select" href="#">Select</a>
                                                <a class="checkbox-deselect" href="#">Click To Exclude</a>
                                        </li>';
                                    ++$i;
                                }
                            }?>
                        </ul>
                        <div style="clear: both;"></div>
                    </fieldset>

                    <?php
                    // add the javascript that will handle our form action, prevent submission and display dialogue box
                    // we need to pass form objects array as 2nd parameter but in this case the options array doubles as a form options array
                    wtgcsv_jqueryform_singleaction_middle($jsform_set,$wtgcsv_options_array);

                    // add end of form - dialogue box does not need to be within the <form>
                    wtgcsv_formend_standard('Submit',$jsform_set['form_id']);?>

                    <?php wtgcsv_jquery_form_prompt($jsform_set);?>
            </div>
        <?php } ?>
    </div>
</div>