<?php
if(isset($csv2post_project_array['tags']['method'])){
    if($csv2post_project_array['tags']['method'] == 'generator'){
        echo wtgcore_notice('Tags settings in use is the "Generate Tags" method','info','Tiny','','','return');
    }elseif($csv2post_project_array['tags']['method'] == 'premade'){
        echo wtgcore_notice('Tags settings in use is the "Pre-made Tags" method','info','Tiny','','','return');
    }
}else{
    echo wtgcore_notice('You have not yet set tag settings saved.','warning','Tiny','','','return');    
}
?>

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'premadetagscolumn';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Pre-made Tags Column');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Select a column of pre-made tags as your default tags data if you have it');
$panel_array['panel_help'] = __('This feature does not generate tags for you. The plugin can generate tags for you and there are options to configure them for the best results but those features are in other panels. This is also an area I am willing to adapt to suit specific users needs should they request it. The default tags column must be a column of pre-made tags separated by comma. Comma is required by Wordpress, if you have tags separated by another character I could add a feature to replace them.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);     
$jsform_set['dialoguebox_title'] = 'Save Default Tags Column';
$jsform_set['noticebox_content'] = 'Posts created from here on will use the data in the selected column as tags, do you wish to continue?';
// TODO: MEDIUMPRIORITY, add ajax for adding and deleting tags
// TODO: LOWPRIORITY, add this panel too main settings to apply a global default to all projects, this panel will start by using those settings on first use?>
<?php csv2post_panel_header( $panel_array );?>

    <?php csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');?>

    <p>         
        <select name="csv2post_defaulttagsdata_select_columnandtable" id="csv2post_defaulttagsdata_select_columnandtable_formid" class="csv2post_multiselect_menu">
            <option value="notselected">Tags Not Required</option>
            <?php 
            if(isset($csv2post_project_array['tags']['default']['table'])){
                $table = $csv2post_project_array['tags']['default']['table'];    
            }else{
                $table = 'Value Not Set';
            }   
            
            if(isset($csv2post_project_array['tags']['default']['column'])){
                $column = $csv2post_project_array['tags']['default']['column'];    
            }else{
                $column = 'Value Not Set';    
            }   
            ?>      
            <?php csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code,$table,$column);?>                                                                                                                     
        </select>
    </p>

    <script>
    $("#csv2post_defaulttagsdata_select_columnandtable_formid").multiselect({
       multiple: false,
       header: "Select Tags Data Column (table - column)",
       noneSelectedText: "Select Tags Data Column",
       selectedList: 1
    });
    </script>
         
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
$panel_array['panel_name'] = 'generatetags';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Generate Tags');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Generate tags from any text in your data');
$panel_array['panel_help'] = __('If you make good use of the Tag Rules you can create high quality tags. We can generate a large list of tags on a per post basis that are not only applicable but good for SEO. The tags generated can then be used in SEO Keywords generation, making it a little quicker, rather than generating both seperate. Select the columns you would like to be included in tag generation.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,true);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);     
$jsform_set['dialoguebox_title'] = 'Save Your Generate Tags Settings';
$jsform_set['noticebox_content'] = 'Saving these settings will activate advanced tag generation which will be giving priority over pre-made tags data setting.';
// TODO: MEDIUMPRIORITY, add ajax for adding and deleting tags
// TODO: LOWPRIORITY, add this panel too main settings to apply a global default to all projects, this panel will start by using those settings on first use?>
<?php csv2post_panel_header( $panel_array );?>

    <?php csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');?>

    <p>

        <script>
        $(function() {
            $( "#csv2post_taggenerator_checkboxes_<?php echo $panel_array['panel_name'];?>" ).buttonset();
        });
        </script>

        <div id="csv2post_taggenerator_checkboxes_<?php echo $panel_array['panel_name'];?>">                    
                                
            <?php
            if(!isset($csv2post_projectslist_array) || $csv2post_projectslist_array == false){
                
                echo '<strong>You do not have any projects</strong>';
                    
            }else{
                

                foreach( $csv2post_project_array['tables'] as $key => $table ){
                    
                    // if is multiple file project, display table name
                    if(count($csv2post_project_array['tables']) > 1){
                        echo '<h4>' . $table . '</h4>';
                    }
                    
                    // get current $table columns
                    $table_columns = csv2post_sql_get_tablecolumns($table);
                    
                    $i = 0;
                    while ($row_column = mysql_fetch_row($table_columns)) {
                        
                        // do not display column names that have csv2post_ in them
                        if(!strstr($row_column[0],'csv2post_')){
                            
                            // establish selected status for this option - loop through saved columns
                            $checked = '';
                            if(isset($csv2post_project_array['tags']['generator']['data'])){
                                foreach( $csv2post_project_array['tags']['generator']['data'] as $key => $table_column ){

                                    if( $table_column['table'] == $table && $table_column['column'] == $row_column[0] ){
                                        $checked = 'checked';    
                                    }

                                }
                            }
                            
                            // must add table name also to avoid confusion when two or more tables share the same column name
                            echo '<input type="checkbox" name="csv2post_taggenerator_columns[]" id="csv2post_checkbox'.$table.$i.$panel_array['panel_name'].'" value="'.$table.','.$row_column[0].'" '.$checked.' />
                            <label for="csv2post_checkbox'.$table.$i.$panel_array['panel_name'].'">'.$row_column[0].'</label>';                      
                            echo '<br />';
                            
                            ++$i;
                        }
                    }                          
                }                 
            }
            ?>
            
        </div>           

    </p>        
                     
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
$panel_array['panel_name'] = 'tagrules';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Tag Rules *global panel*');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('This panel has not been complete, thank you for your patience');
$panel_array['panel_help'] = __('This panel has not been complete, thank you for your patience');
$panel_array['help_button'] = csv2post_helpbutton_text(false,true);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);     
$jsform_set['dialoguebox_title'] = 'Save Tag Rules';
$jsform_set['noticebox_content'] = 'Your changes will effect all posts created from here on, do you wish to continue?';
// TODO: MEDIUMPRIORITY, add ajax for adding and deleting tags
// TODO: LOWPRIORITY, add this panel too main settings to apply a global default to all projects, this panel will start by using those settings on first use?>
<?php csv2post_panel_header( $panel_array );?>

    <?php csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');?>

    <h4>This panel is still under construction, thank you for your patience.<h4>
        
    <script>
    $(function() {
        $( "#csv2post_tags_allownumeric" ).buttonset();
    });
    </script>

    <?php
    $disallow_numeric_check = '';$allow_numeric_checked = '';
    if(isset($csv2post_project_array['tags']['rules']['numericterms']) && $csv2post_project_array['tags']['rules']['numericterms'] = 'off'){
        $disallow_numeric_check = 'checked';    
    }elseif(isset($csv2post_project_array['tags']['rules']['numericterms']) && $csv2post_project_array['tags']['rules']['numericterms'] = 'on'){
        $allow_numeric_checked = 'checked';    
    }
    ?>
    
    <div id="csv2post_tags_allownumeric">
        <input type="radio" id="csv2post_numerics_1" name="csv2post_numerics" <?php echo $disallow_numeric_check;?> /><label for="csv2post_numerics_1">Disallow Numerics</label>
        <input type="radio" id="csv2post_numerics_2" name="csv2post_numerics" <?php echo $allow_numeric_checked;?> /><label for="csv2post_numerics_2">Allow Numerics</label>
    </div>

    <br /><br />
    
    <?php 
    $tag_string_length = '';
    if(isset($csv2post_project_array['tags']['rules']['tagstringlength'])){$tag_string_length = $csv2post_project_array['tags']['rules']['tagstringlength'];}
    ?>    
    Tag String Length:<input type="text" name="csv2post_tagstringlength" size="5" value="<?php echo $tag_string_length;?>" />
    
    <br /><br />
    
    
    <?php 
    $tags_per_post = '';
    if(isset($csv2post_project_array['tags']['rules']['tagsperpost'])){$tags_per_post = $csv2post_project_array['tags']['rules']['tagsperpost'];}
    ?>    
    Tags Per Post:<input type="text" name="csv2post_tagsperpost" size="5" value="<?php echo $tags_per_post;?>" />
    
    <br /><br />
    
    Enter Excluded Tags:<input type="text" name="csv2post_excludedtag" size="55" /> (comma seperated)
    
    <br /><br />        

    
    <script>
        $(function() {
            $( ".csv2post_tagexclusioncheckboxes" ).button();
        });
    </script>
    <style>
        #format { margin-top: 2em; }
    </style>

    <?php if(!isset($csv2post_project_array['tags']['rules']['excluded'])){
        
        echo '<p><strong>You do not have any excluded tag terms saved for this project</strong></p>';        
        
    }else{?>
  
    <table class="widefat post fixed">
        <tr class="first">
            <td width="78"></td>                    
            <td><strong>Your Excluded Terms</strong></td>                                                                                  
        </tr>
        
        <?php 
        if(isset($csv2post_project_array['tags']['rules']['excluded'])){
            $term_count = 0;
            foreach( $csv2post_project_array['tags']['rules']['excluded'] as $key => $term ){?>
                <tr>
                    <td><input type="checkbox" name="csv2post_tagslist_delete[]" id="csv2post_tag<?php echo $term_count;?>" value="<?php echo $term;?>" class="csv2post_tagexclusioncheckboxes" /><label for="csv2post_tag<?php echo $term_count;?>">Delete</label></td>                                            
                    <td><?php echo $term;?></td>                                                                                                               
                </tr><?php
                ++$term_count;         
            }            
        }
        ?>
                                                                                                             
    </table>
    
    <?php }?>

    <?php
    // add the javascript that will handle our form action, prevent submission and display dialogue box
    csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);

    // add end of form - dialogue box does not need to be within the <form>
    csv2post_formend_standard('Submit',$jsform_set['form_id']);?>

    <?php csv2post_jquery_form_prompt($jsform_set);?>

<?php csv2post_panel_footer();
}?> 