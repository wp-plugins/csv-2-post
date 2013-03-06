<?php
if(!isset($csv2post_projectslist_array) || $csv2post_projectslist_array == false){
    
    echo '<strong>You do not have any post creation projects, please create a project on the Your Projects page</strong>';
        
}else{

    $i = 0;
    $panel_number = 0; 
    foreach($csv2post_projectslist_array as $project_code => $project ){
        if($project_code != 'arrayinfo'){
            
            ++$panel_number;// increase panel counter so this panel has unique ID
            $panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
            $panel_array['panel_name'] = 'createpostsproject'.$panel_number;// slug to act as a name and part of the panel ID 
            $panel_array['panel_title'] = __('Create Posts: ' . $project['name']);// user seen panel header text 
            $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
            $panel_array['panel_help'] = __('This panel allows you to create posts manually. Use the slider to decide how many posts to create using the records imported to your projects data table. The slider will take the number of records available into consideration and set a limit. If you are using multiple database tables, the default approach is for CSV 2 POST to link records in each table together by the order they come in. The alternative is using primary key columns and manually mapping the tables to each other. This is considered an advanced feature and watching tutorials is recommended. Importer more rows from your CSV file if you have not finished doing so to create more records in your projects data tables.');
            // Form Settings - create the array that is passed to jQuery form functions
            $jsform_set_override = array();
            $jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);   
            $jsform_set['dialogbox_title'] = 'Create Posts';
            $jsform_set['noticebox_content'] = 'You are about to create posts based on the configuration applied on the Your Projects screen, do you want to begin?';
            $jsform_set['form_id'] = $jsform_set['form_id'] . $i;?>
                
                <?php csv2post_panel_header( $panel_array );?>

                    <?php 
                    // begin form and add hidden values
                    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');
                    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
                    ?>
                    
                    <?php 
                    $project_array = csv2post_get_project_array($project_code);
                     
                    $requirements_met = true;
                    
                    // ensure content template selected
                    if(!isset($project_array['default_contenttemplate_id'])){
                        ## TODO:LOWPRIORITY, once we have decided on our approach with links, link this to the content screen
                        echo csv2post_notice('your project does not have a default post content template. Please create
                        a content template or select an existing one.','error','Small','No Content Template: ','','return');
                        $requirements_met = false;
                    }
                    
                    // ensure title template selected
                    if(!isset($project_array['default_titletemplate_id']) 
                    && !isset($csv2post_project_array['posttitles']['table'])
                    && !isset($csv2post_project_array['posttitles']['column'])){
                        ## TODO:LOWPRIORITY, once we have decided on our approach with links, link this to the content screen
                        echo csv2post_notice('Your project requires a title template to be setup or
                        you could select a column that holds pre-made titles.','error','Small','No Titles Setup','','return');
                        $requirements_met = false;
                    }
                                  
                    // skip rest of 
                    if($requirements_met){        
                        // display special information about the configuration the user has selected
                        // and how it will effect their post creation
                        if(isset($project_array['defaultposttype']) && $project_array['defaultposttype'] == 'page'){    
                            if(isset($project_array['subpages']['status']) && $project_array['subpages']['status'] == true){          
                                // is the method permalinks (search a pre-made permalink against existing)
                                if(isset($project_array['subpages']['method']) && $project_array['subpages']['method'] == 'permalinks'){
                                    
                                    csv2post_n_incontent('Your project is setup for creating Sub-Pages using
                                    the permalink method. It will require multiple submissions, each submission
                                    creating the pages for a single level.','info','Small','Sub-Pages Active');
                                    
                                    // ensure required columns set
                                    if(isset($project_array['subpages']['levelcolumn']['table']) 
                                    && isset($project_array['subpages']['levelcolumn']['column'])
                                    && isset($project_array['subpages']['slug']['table'])
                                    && isset($project_array['subpages']['slug']['column'])
                                    && isset($project_array['subpages']['stage'])){
                                        
                                        // we now need to check what stage the sub-pages process is at
                                        // this allows us to use the correct column and correct value to establish new pages parent
                                        if($project_array['subpages']['stage'] == 1){
                                            csv2post_n_incontent('You need to create the first level of pages. Once
                                            the pages are created, please submit again to create the second level of pages.',
                                            'warning','Small','Level One');
                                        }elseif($project_array['subpages']['stage'] == 2){
                                            csv2post_n_incontent('You need to create the second level of pages. Once
                                            the pages are created, please submit again to create the third level of pages
                                            if your project requires it.',
                                            'warning','Small','Level Two');                                    
                                        }elseif($project_array['subpages']['stage'] == 3){
                                            csv2post_n_incontent('You need to create the third level of pages. Once
                                            the pages are created, please submit again to create the fourth level of pages
                                            if your project requires it.',
                                            'warning','Small','Level Three');
                                        }elseif($project_array['subpages']['stage'] == 4){
                                            csv2post_n_incontent('All levels of pages have been created. If your
                                            require the plugin to create more levels of sub-pages please let the author
                                            know.',
                                            'success','Small','Level Three');
                                        }
                                        
                                    }else{
                                        csv2post_n_incontent('Your project is setup for sub-pages to be created but
                                        the settings are not complete. Please re-visit the Sub-Pages panels and submit
                                        the require form again. Please report this if it continues to happen without
                                        any obvious cause or if you feel the cause is a fault.','error','Small','Sub-Pages Settings Data Missing');                                
                                    }
                                }
                            }
                        }?>
                         
                        <table class="widefat post fixed">
                            <tr class="first">
                                <td width="120"><strong>Table Names</strong></td>
                                <td width="120"><strong>Total Records</strong></td>                                                                                               
                            </tr>
                                    
                            <?php
                            ### TODO:MEDIUMPRIORITY,add columns showing number of records used, number void, number available
                            $table_name_string = '';
                            $tablerecords_leastcounted = 99999999;// least counted will be the number of posts that can be created
                            foreach($project_array['tables'] as $test => $table_name){
                                
                                $tablerecords_count = csv2post_WP_SQL_counttablerecords( $table_name );
                                
                                // if current table has less records then it becomes the least counted 
                                if($tablerecords_count < $tablerecords_leastcounted){
                                    $tablerecords_leastcounted = $tablerecords_count;    
                                }
                                
                                echo '
                                <tr class="first">
                                    <td width="120"><strong>'.$table_name.'</strong></td>
                                    <td width="120"><strong>'.$tablerecords_count.'</strong></td>
                                </tr>';
                            }?>
                        
                        </table>
                        
                        <?php 
                        // TODO:HIGHPRIORITY, get project posts total created
                        $project_posts_total_created = 0;
                        ?>
                        
                        <h4>Total Posts Created In This Project: <?php echo $project_array['stats']['postscreated'];?></h4>
                        
                        <?php 
                        // deduct number of posts already created from lowest record count, this tells us the number of posts that can be made
                        $tablerecords_leastcounted = $tablerecords_leastcounted - $project_posts_total_created;
                        ?>

                        <?php 
                        // if free edition, hide the slider bars script, free edition will use all records at once for even easier use
                        if(!$csv2post_is_free){?>
                        
                            <script>
                            $(function() {
                                $( "#csv2post_createposts_slider_<?php echo $project_code; ?>" ).slider({
                                    range: "min",
                                    value: 1,
                                    min: 1,
                                    max: <?php echo $tablerecords_leastcounted;?>,
                                    slide: function( event, ui ) {
                                        $( "#csv2post_postsamount_<?php echo $project_code; ?>" ).val( "" + ui.value + "" );
                                    }
                                });
                                $( "#csv2post_postsamount_<?php echo $project_code; ?>" ).val( "" + $( "#csv2post_createposts_slider_<?php echo $project_code; ?>" ).slider( "value" ) + "" );
                            });
                            </script>

                            <br />
                            
                            <p>
                                Create <input type="text" name="csv2post_postsamount" id="csv2post_postsamount_<?php echo $project_code; ?>" style="border:0; color:#f6931f; font-weight:bold;" size="20" /> Posts
                                <div id="csv2post_postsamount_<?php echo $project_code; ?>"></div>
                            </p>

                            <div id="csv2post_createposts_slider_<?php echo $project_code; ?>"></div>
                            <br />
                             
                        <?php }?>
           
                        <script>
                        $(function() {
                            $( "#csv2post_poststatus_radios_<?php echo $i;?>" ).buttonset();
                        });
                        </script>

                        <div id="csv2post_poststatus_radios_<?php echo $i;?>">
                            
                            <?php
                            // establish current status check
                            $statuschecked_publish = '';
                            $statuschecked_pending = '';
                            $statuschecked_draft = 'checked="checked"';
                            $statuschecked_private = '';
                            if(isset($csv2post_project_array['poststatus'])){
                                
                                // publish
                                if($csv2post_project_array['poststatus'] == 'publish'){
                                    $statuschecked_publish = 'checked="checked"';
                                    $statuschecked_draft = '';
                                }
                                
                                // pending
                                if($csv2post_project_array['poststatus'] == 'pending'){
                                    $statuschecked_pending = 'checked="checked"';
                                    $statuschecked_draft = '';
                                }
                                
                                // draft - the default
                                if($csv2post_project_array['poststatus'] == 'draft'){
                                    $statuschecked_draft = 'checked="checked"';
                                }else{
                                    $statuschecked_draft = '';
                                }
                                
                                // private
                                if($csv2post_project_array['poststatus'] == 'private'){
                                    $statuschecked_private = 'checked="checked"';
                                    $statuschecked_draft = '';
                                }
                                                                                                     
                            }   
                            
                            echo '<input type="radio" id="csv2post_radiopublish_poststatus_objectid_'.$i.'" name="csv2post_radio_poststatus" value="publish" '.$statuschecked_publish.' />
                            <label for="csv2post_radiopublish_poststatus_objectid_'.$i.'">publish</label>';
                            
                            echo '<input type="radio" id="csv2post_radiopending_poststatus_objectid_'.$i.'" name="csv2post_radio_poststatus" value="pending" '.$statuschecked_pending.' />
                            <label for="csv2post_radiopending_poststatus_objectid_'.$i.'">pending</label>';                    
                            
                            echo '<input type="radio" id="csv2post_radiodraft_poststatus_objectid_'.$i.'" name="csv2post_radio_poststatus" value="draft" '.$statuschecked_draft.' />
                            <label for="csv2post_radiodraft_poststatus_objectid_'.$i.'">draft</label>';   
                            
                            echo '<input type="radio" id="csv2post_radioprivate_poststatus_objectid_'.$i.'" name="csv2post_radio_poststatus" value="private" '.$statuschecked_private.' />
                            <label for="csv2post_radioprivate_poststatus_objectid_'.$i.'">private</label>';                                     
                            ?>
                            
                        </div>                
                     
                        <input type="hidden" name="csv2post_project_code" value="<?php echo $project_code; ?>">
                        <input type="hidden" name="csv2post_post_creation_request" value="true">
                        
                    <?php 
                    // add js for dialog on form submission and the dialog <div> itself
                    if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
                        csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
                        csv2post_jquery_form_prompt($jsform_set);
                    }
                    ?>
                        
                    <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>
                                                    
                <?php 
                }// if requirements met
                ?>

                <?php
                if($csv2post_is_dev && isset($csv2post_projectslist_array)){
                    echo '<h4>Project Array Dump</h4>';
                    echo '<pre>';     
                    csv2post_var_dump($csv2post_project_array);
                    echo '</pre>';
                }?>
   
            <?php csv2post_panel_footer();?> 
             
            <?php             
            ++$i;
        }// end if arrayinfo
    }
}?>

<?php
if($csv2post_is_dev && isset($csv2post_projectslist_array)){
    ++$panel_number;// increase panel counter so this panel has unique ID
    $panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
    $panel_array['panel_name'] = 'projectslistarraydump';// slug to act as a name and part of the panel ID 
    $panel_array['panel_title'] = __('Projects List Array Dump');// user seen panel header text 
    $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
    $panel_array['panel_help'] = __('Every project has its own array stored in the Wordpress options table but all projects are also added to the $csv2post_projectslist_array. It is used to list projects and holds a small amount of key information for when querying none specific projects on specific criteria i.e. a project with changed configuration since posts were created. That can tell us that there are posts that need updated.');?>
    <?php csv2post_panel_header( $panel_array );?>  
               
        <h4>Entire Array</h4>
        <?php 
        echo '<pre>';     
        csv2post_var_dump($csv2post_projectslist_array);
        echo '</pre>';?>

    <?php csv2post_panel_footer();
}?>