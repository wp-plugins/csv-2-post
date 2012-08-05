<?php
if(!isset($csv2post_project_array['categories'])){ 
    echo csv2post_notice('No categories setup, all posts will be assigned to your blogs default','warning','Tiny','','','return');
}else{
    echo csv2post_notice('Category settings have been saved for your project.','info','Tiny','','','return');
}    
?>

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'defaultcategory';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Set Default Category');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Select an existing category in to act as a default');
$panel_array['panel_help'] = __('If you do not have category data you should select a default category. The menu will allow you to select any category already in your blog. It is recommended that you select a default category even if you want to use category data however it should not be used if your category data is complete. If any issues do arise when trying to create categories using your data, then you can expect to find posts in your default. If this does ever happen, please investigate it and seek support if you feel your data is complete.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);               
$jsform_set['dialoguebox_title'] = 'Save Default Category';
$jsform_set['noticebox_content'] = 'Do you want to save a default category now?';
### TODO:HIGHPRIORITY, add default category option ?>
<?php csv2post_panel_header( $panel_array );?>

    <?php csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');?>

    <select name="csv2post_defaultcategory_select" id="csv2post_defaultcategory_select_id" class="csv2post_multiselect_menu">
        
        <?php
        $selected = ''; 
        if(!isset($csv2post_project_array['categories']['default'])){
            $selected = 'selected="selected"';
        }?>
        
        <option value="notselected" <?php echo $selected;?>>ID - Category Name (None Selected)</option> 
                
        <?php csv2post_display_categories_options($current_value);?>
                                                                                                                             
    </select>  
      
    <script>
    $("#csv2post_defaultcategory_select_id").multiselect({
       multiple: false,
       header: "Select Default Category",
       noneSelectedText: "Select Default Category",
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

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'standardcategories';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Set Standard Categories');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Create categories using your data and configure them to suit your theme');
$panel_array['panel_help'] = __('Category features will get more advanced during 2012. A full description and help content will be created when this panel has all planned options added. Currently you can create five levels of categories using your data simply by selecting each category column individually. This panel does not handle multiple levels of categories stored in a single column, that requires the Category Splitter approach.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);               
$jsform_set['dialoguebox_title'] = 'Saving Category Columns';
$jsform_set['noticebox_content'] = 'Please ensure you have backed up your Wordpress database before running category creation. Would you like to save your category setup now?';
### TODO:HIGHPRIORITY, add default category option ?>
<?php csv2post_panel_header( $panel_array );?>

    <?php csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');?>

    <h4>Setup Category Data Columns</h4>

    <select name="csv2post_categorylevel1_select_columnandtable" id="csv2post_categorylevel1_select_columnandtable_objectid" class="csv2post_multiselect_menu">
        <option value="notselected">Exclude Level One</option>
        <?php 
        if(isset($csv2post_project_array['categories']['level1']['table']) && isset($csv2post_project_array['categories']['level1']['column'])){
            csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code,$csv2post_project_array['categories']['level1']['table'],$csv2post_project_array['categories']['level1']['column']);    
        }else{
            csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code);            
        }
        ?>                                                                                                                            
    </select>
    
    <script>
    $("#csv2post_categorylevel1_select_columnandtable_objectid").multiselect({
       multiple: false,
       header: "Select Level One Categories",
       noneSelectedText: "Select Level One Categories",
       selectedList: 1
    });
    </script>
        
    <br />
        
    <select name="csv2post_categorylevel2_select_columnandtable" id="csv2post_categorylevel2_select_columnandtable_objectid" class="csv2post_multiselect_menu">
        <option value="notselected">Exclude Level Two</option>
        <?php 
        if(isset($csv2post_project_array['categories']['level2']['table']) && isset($csv2post_project_array['categories']['level2']['column'])){
            csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code,$csv2post_project_array['categories']['level2']['table'],$csv2post_project_array['categories']['level2']['column']);    
        }else{
            csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code);            
        }
        ?>                                                                                                                     
    </select>
        
    <script>
    $("#csv2post_categorylevel2_select_columnandtable_objectid").multiselect({
       multiple: false,
       header: "Select Level Two Categories",
       noneSelectedText: "Select Level Two Categories",
       selectedList: 1
    });
    </script>
    
    <br />
        
    <select name="csv2post_categorylevel3_select_columnandtable" id="csv2post_categorylevel3_select_columnandtable_objectid" class="csv2post_multiselect_menu">
        <option value="notselected">Exclude Level Three</option>
        <?php 
        if(isset($csv2post_project_array['categories']['level3']['table']) && isset($csv2post_project_array['categories']['level3']['column'])){
            csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code,$csv2post_project_array['categories']['level3']['table'],$csv2post_project_array['categories']['level3']['column']);    
        }else{
            csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code);            
        }
        ?>                                                                                                                     
    </select>  
      
    <script>
    $("#csv2post_categorylevel3_select_columnandtable_objectid").multiselect({
       multiple: false,
       header: "Select Level Three Categories",
       noneSelectedText: "Select Level Three Categories",
       selectedList: 1
    });
    </script>

    <br />
    
    <?php 
    // if free edition we do not allow use of 4th and 5th level categories
    // bypassing this will only cause faults later, level 4 and 5 is connected to advanced fetures which require more support so are not provided free
    if(!$csv2post_is_free){?>
        
        <select name="csv2post_categorylevel4_select_columnandtable" id="csv2post_categorylevel4_select_columnandtable_objectid" class="csv2post_multiselect_menu">
            <option value="notselected">Exclude Level Four</option>
            <?php 
            if(isset($csv2post_project_array['categories']['level4']['table']) && isset($csv2post_project_array['categories']['level4']['column'])){
                csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code,$csv2post_project_array['categories']['level4']['table'],$csv2post_project_array['categories']['level4']['column']);    
            }else{
                csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code);            
            }
            ?>                                                                                                                     
        </select>  
          
        <script>
        $("#csv2post_categorylevel4_select_columnandtable_objectid").multiselect({
           multiple: false,
           header: "Select Level Four Categories",
           noneSelectedText: "Select Level Four Categories",
           selectedList: 1
        });
        </script>

        <br />
        
        <select name="csv2post_categorylevel5_select_columnandtable" id="csv2post_categorylevel5_select_columnandtable_objectid" class="csv2post_multiselect_menu">
            <option value="notselected">Exclude Level Five</option>
            <?php 
            if(isset($csv2post_project_array['categories']['level5']['table']) && isset($csv2post_project_array['categories']['level5']['column'])){
                csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code,$csv2post_project_array['categories']['level5']['table'],$csv2post_project_array['categories']['level5']['column']);    
            }else{
                csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code);            
            }
            ?>                                                                                                                     
        </select>  
          
        <script>
        $("#csv2post_categorylevel5_select_columnandtable_objectid").multiselect({
           multiple: false,
           header: "Select Level Five Categories",
           noneSelectedText: "Select Level Five Categories",
           selectedList: 1
        });
        </script>
        
        <br />
    <?php }?>
               
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
$panel_array['panel_name'] = 'advancedcategories';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Set Advanced Categories');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Take full control of category creation with more advanced category creation features');
$panel_array['panel_help'] = __('If you require a category description or mapping too existing categories rather than creating or only creating new categories, you will need to use this panel
. The plugin will need to do more during category creation, please keep this in mind when running post creation events.');
$panel_array['help_button'] = csv2post_helpbutton_text(true,true);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);               
$jsform_set['dialoguebox_title'] = 'Saving Advanced Categories';
$jsform_set['noticebox_content'] = 'Please ensure you have backed up your Wordpress database before running category creation. Would you like to save your category setup now?';
### TODO:HIGHPRIORITY, add default category option ?>
<?php csv2post_panel_header( $panel_array );?>

    <?php csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');?>

    <h4>Setup Category Data Columns</h4>

    <table>
    
        <tr><td>
        Level One:</td><td><select name="csv2post_categorylevel1_advanced" id="csv2post_categorylevel1_advanced" class="csv2post_multiselect_menu">
            <option value="notselected">Exclude</option>
            <?php 
            if(isset($csv2post_project_array['categories']['level1']['table']) && isset($csv2post_project_array['categories']['level1']['column'])){
                csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code,$csv2post_project_array['categories']['level1']['table'],$csv2post_project_array['categories']['level1']['column']);    
            }else{
                csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code);            
            }?>                                                                                                                            
        </select>
        
        <script>
        $("#csv2post_categorylevel1_advanced").multiselect({
           multiple: false,
           header: "Select Level One Categories",
           noneSelectedText: "Select Level One Categories",
           selectedList: 1
        });
        </script>
        </td></tr>
        <tr><td>    
        Level Two:</td><td><select name="csv2post_categorylevel2_advanced" id="csv2post_categorylevel2_advanced" class="csv2post_multiselect_menu">
            <option value="notselected">Exclude</option>
            <?php 
            if(isset($csv2post_project_array['categories']['level2']['table']) && isset($csv2post_project_array['categories']['level2']['column'])){
                csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code,$csv2post_project_array['categories']['level2']['table'],$csv2post_project_array['categories']['level2']['column']);    
            }else{
                csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code);            
            }?>                                                                                                                     
        </select>
            
        <script>
        $("#csv2post_categorylevel2_advanced").multiselect({
           multiple: false,
           header: "Select Level Two Categories",
           noneSelectedText: "Select Level Two Categories",
           selectedList: 1
        });
        </script>
        </td></tr>
        <tr><td>    
        Level Three:</td><td><select name="csv2post_categorylevel3_advanced" id="csv2post_categorylevel3_advanced" class="csv2post_multiselect_menu">
            <option value="notselected">Exclude</option>
            <?php 
            if(isset($csv2post_project_array['categories']['level3']['table']) && isset($csv2post_project_array['categories']['level3']['column'])){
                csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code,$csv2post_project_array['categories']['level3']['table'],$csv2post_project_array['categories']['level3']['column']);    
            }else{
                csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code);            
            }?>                                                                                                                     
        </select>  
          
        <script>
        $("#csv2post_categorylevel3_advanced").multiselect({
           multiple: false,
           header: "Select Level Three Categories",
           noneSelectedText: "Select Level Three Categories",
           selectedList: 1
        });
        </script>
        </td></tr>
        <tr><td>
        Level Four:</td><td><select name="csv2post_categorylevel4_advanced" id="csv2post_categorylevel4_advanced" class="csv2post_multiselect_menu">
            <option value="notselected">Exclude</option>
            <?php 
            if(isset($csv2post_project_array['categories']['level4']['table']) && isset($csv2post_project_array['categories']['level4']['column'])){
                csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code,$csv2post_project_array['categories']['level4']['table'],$csv2post_project_array['categories']['level4']['column']);    
            }else{
                csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code);            
            }?>                                                                                                                     
        </select>  
          
        <script>
        $("#csv2post_categorylevel4_advanced").multiselect({
           multiple: false,
           header: "Select Level Four Categories",
           noneSelectedText: "Select Level Four Categories",
           selectedList: 1
        });
        </script>
        </td></tr>
        <tr><td>
        Level Five:</td><td><select name="csv2post_categorylevel5_advanced" id="csv2post_categorylevel5_advanced" class="csv2post_multiselect_menu">
            <option value="notselected">Exclude</option>
            <?php 
            if(isset($csv2post_project_array['categories']['level5']['table']) && isset($csv2post_project_array['categories']['level5']['column'])){
                csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code,$csv2post_project_array['categories']['level5']['table'],$csv2post_project_array['categories']['level5']['column']);    
            }else{
                csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code);            
            }?>                                                                                                                     
        </select>  
          
        <script>
        $("#csv2post_categorylevel5_advanced ").multiselect({
           multiple: false,
           header: "Select Level Five Categories",
           noneSelectedText: "Select Level Five Categories",
           selectedList: 1
        });
        </script>
        </td></tr>
    
    </table>
    
    <br />

    <h4>Category Description Templates</h4>
    <?php 
    if(csv2post_count_contenttemplates('categorydescription') == 0){
        echo '<p><strong>You do not have any category description templates. Please create one or more on the Content screen.</strong></p>';
    }else{?>

        <table>
        
            <tr><td>Level One:</td><td>
            <select name="csv2post_categorylevel1_description" id="csv2post_categorylevel1_description" class="csv2post_multiselect_menu">
                <option value="notselected">No Description Required</option>
                
                <?php 
                $current_value = '';
                if(isset($csv2post_project_array['categories']['level1']['description'])){$current_value = $csv2post_project_array['categories']['level1']['description'];}
                ?>
                 
                <?php csv2post_display_template_options($current_value,'categorydescription');?>
                                                                                                                            
            </select>  
              
            <script>
            $("#csv2post_categorylevel1_description ").multiselect({
               multiple: false,
               header: "Select Level One Template",
               noneSelectedText: "Select Level One Template",
               selectedList: 1
            });
            </script>    
            </td></tr>

            <tr><td>Level Two:</td><td>
            <select name="csv2post_categorylevel2_description" id="csv2post_categorylevel2_description" class="csv2post_multiselect_menu">
                <option value="notselected">No Description Required</option>
                
                <?php 
                $current_value = '';
                if(isset($csv2post_project_array['categories']['level2']['description'])){$current_value = $csv2post_project_array['categories']['level2']['description'];}
                ?>
                 
                <?php csv2post_display_template_options($current_value,'categorydescription');?>
                                                                                                                            
            </select>  
              
            <script>
            $("#csv2post_categorylevel2_description ").multiselect({
               multiple: false,
               header: "Select Level Two Template",
               noneSelectedText: "Select Level Two Template",
               selectedList: 1
            });
            </script>    
            </td></tr>

            <tr><td>Level Three:</td><td>
            <select name="csv2post_categorylevel3_description" id="csv2post_categorylevel3_description" class="csv2post_multiselect_menu">
                <option value="notselected">No Description Required</option>
                
                <?php 
                $current_value = '';
                if(isset($csv2post_project_array['categories']['level3']['description'])){$current_value = $csv2post_project_array['categories']['level3']['description'];}
                ?>
                
                <?php csv2post_display_template_options($current_value,'categorydescription');?>
                                                                                                                            
            </select>  
              
            <script>
            $("#csv2post_categorylevel3_description ").multiselect({
               multiple: false,
               header: "Select Level Three Template",
               noneSelectedText: "Select Level Three Template",
               selectedList: 1
            });
            </script>    
            </td></tr>
            
            <tr><td>Level Four:</td><td>
            <select name="csv2post_categorylevel4_description" id="csv2post_categorylevel4_description" class="csv2post_multiselect_menu">
                <option value="notselected">No Description Required</option>
                
                <?php 
                $current_value = '';
                if(isset($csv2post_project_array['categories']['level4']['description'])){$current_value = $csv2post_project_array['categories']['level4']['description'];}
                ?>
                 
                <?php csv2post_display_template_options($current_value,'categorydescription');?>
                                                                                                                            
            </select>  
              
            <script>
            $("#csv2post_categorylevel4_description ").multiselect({
               multiple: false,
               header: "Select Level Four Template",
               noneSelectedText: "Select Level Four Template",
               selectedList: 1
            });
            </script>    
            </td></tr>
            
            <tr><td>Level Five:</td><td>
            <select name="csv2post_categorylevel5_description" id="csv2post_categorylevel5_description" class="csv2post_multiselect_menu">

                <?php 
                $current_value = '';
                $default_selected = '';
                if(isset($csv2post_project_array['categories']['level5']['description'])){$current_value = $csv2post_project_array['categories']['level5']['description'];}
                else{$default_selected = 'selected="selected"';}
                ?>
                
                <option value="notselected" <?php echo $default_selected;?>>No Description Required</option>
                                 
                <?php csv2post_display_template_options($current_value,'categorydescription');?>
                                                                                                                            
            </select>  
              
            <script>
            $("#csv2post_categorylevel5_description ").multiselect({
               multiple: false,
               header: "Select Level Five Template",
               noneSelectedText: "Select Level Five Template",
               selectedList: 1
            });
            </script>    
            </td></tr>
                                        
        </table>
    
    <?php }?>
        
    <br />
    
    <?php
    // add the javascript that will handle our form action, prevent submission and display dialogue box
    csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);

    // add end of form - dialogue box does not need to be within the <form>
    csv2post_formend_standard('Submit',$jsform_set['form_id']);?>

    <?php csv2post_jquery_form_prompt($jsform_set);?>

<?php csv2post_panel_footer();
}?> 

<?php
if(!$csv2post_is_free){
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'createcategorymappingrules';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Set Category Map');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Map values in your data to categories in your blog');
$panel_array['panel_help'] = __('This feature will overwrite category creation i.e. instead of using a term in your data to create a category, the post will be put in a category you have mapped the term to. This feature is for users who are auto-blogging but their data does not have matching category values. In that situation you can pair values to existing categories in your blog. You can do it with none category data, just as long as the values are small. This is not just an advanced feature but can be very complex. Consider what happens when a term in your data, is paired with an existing category. The plugin will use the existing categories ID, however if done wrong the next level of category term may not exist under the existing category as a child. I can add more settings to adapt how category creation works, please contact me to discuss your requirements.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,true);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);               
$jsform_set['dialoguebox_title'] = 'Save Category Mapping Rules';
$jsform_set['noticebox_content'] = 'Do you want to save category mapping rules now?';
### TODO:HIGHPRIORITY, add default category option ?>
<?php csv2post_panel_header( $panel_array );?>

    <?php csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');?>

    <?php 
    function csv2post_display_categories_menu($increment){?>
     
        <select name="csv2post_createcategorymapping<?php echo $increment;?>_select" id="csv2post_createcategorymapping<?php echo $increment;?>_select_id" class="csv2post_multiselect_menu">
                  
            <option value="notselected">Not Selected</option> 
                    
            <?php csv2post_display_categories_options($current_value);?>
                                                                                                                                 
        </select>  
          
        <script>
        $("#csv2post_createcategorymapping<?php echo $increment;?>_select_id").multiselect({
           multiple: false,
           header: "Select Category",
           noneSelectedText: "Select Category",
           selectedList: 1
        });
        </script><?php    
        return '';
    }
    ?>
    
    <?php
    // we need to loop 5 times, once for each level
    $levels_looped = 0;// used in hidden input
    for($i = 1; $i <= 5; $i++){?> 
    
        <h1>Category Level <?php echo $i;?></h1>
        <?php 
        // is level one category set
        if(!isset($csv2post_project_array['categories']['level'.$i.'']['table']) || !isset($csv2post_project_array['categories']['level'.$i.'']['column'])){
        
            echo '<p><strong>You have not setup a level one category, this is required for any category creation or mapping</strong></p>';
        
        }else{
            
            // using level 1 table, query that there are records
            $records_count = csv2post_sql_counttablerecords($csv2post_project_array['categories']['level'.$i.'']['table']);
            if(!$records_count || $records_count == 0){
                
                echo '<p><strong>No records were found in the column and table being used for your level one categories</strong></p>';
            
            }else{
                
                $distinct_values_array = csv2post_sql_column_distinctvalues($csv2post_project_array['categories']['level'.$i]['table'],$csv2post_project_array['categories']['level'.$i]['column']);
                
                echo '<table>';
                    
                echo '<tr><td>Distinct Values</td><td>Blog Categories</td></tr>';
                
                // loop through distinct values, creating a table row for each, with menu for selecting category
                $increment = 0;// increment counts number if distinct values    
                foreach($distinct_values_array as $key => $distinct_value){
                    
                    ++$increment;
                    
                    $current_distinct_value = $distinct_value[ $csv2post_project_array['categories']['level'.$i]['column'] ];
                    
                    echo '<tr><td><input type="text" name="csv2post_distinct_value_lev'.$i.'_inc'.$increment.'" value="' . $current_distinct_value . '" size="30" ></td><td>';?>

                    <?php 
                    // check if DISTINCT value has been stored with a category already, if so pass the current value
                    $current_value = '';
                    $notselected = '';
                    if(isset($csv2post_project_array['categories']['level'.$i]['mapping'][ $current_distinct_value ])){
                        $current_value = $csv2post_project_array['categories']['level'.$i]['mapping'][ $current_distinct_value ];   
                    }else{
                        $notselected = 'selected="selected"';
                    }?>

                    <select name="csv2post_createcategorymapping_lev<?php echo $i;?>_inc<?php echo $increment;?>_select" id="csv2post_createcategorymapping_lev<?php echo $i;?>_inc<?php echo $increment;?>_select_id" class="csv2post_multiselect_menu">
                              
                        <option value="notselected" <?php echo $notselected;?>>Not Selected</option> 
                                
                        <?php csv2post_display_categories_options($current_value);?>
                                                                                                                                             
                    </select>  
                      
                    <script>
                    $("#csv2post_createcategorymapping_lev<?php echo $i;?>_inc<?php echo $increment;?>_select_id").multiselect({
                       multiple: false,
                       header: "Select Category",
                       noneSelectedText: "Select Category",
                       selectedList: 1
                    });
                    </script><?php

                }

                echo '</table>';             

                // add hidden value for holding total number of DISTINCT values
                echo '<input type="hidden" name="csv2post_distinct_values_count_lev'.$i.'" value="'.$increment.'">';
            }
     
            ++$levels_looped;
        }

    }// for
  
    echo '<input type="hidden" name="csv2post_category_levels" value="'.$levels_looped.'">';
             
    ?>
      
    <br />
       
    <?php
    // add the javascript that will handle our form action, prevent submission and display dialogue box
    csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);

    // add end of form - dialogue box does not need to be within the <form>
    csv2post_formend_standard('Submit',$jsform_set['form_id']);?>

    <?php csv2post_jquery_form_prompt($jsform_set);?>

<?php csv2post_panel_footer();
}?>

<?php ### TODO:HIGHPRIORITY, add panel for Single Column Categories (category splitter approach)?>

<?php ### TODO:LOWPRIORITY,add panel that shows columns created with heirarchy ?> 

<?php ### TODO:LOWPRIORITY, add category tools panel (undo categories,categories data test for any possible issues based on settings)?> 
