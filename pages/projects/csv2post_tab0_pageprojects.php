<?php             
if(count($csv2post_projectslist_array) == 0){
    echo csv2post_notice('Start here on this screen if you want to create posts. You need to create a project, then continue by clicking on the other tabs above.','warning','Tiny','','','return');
}
 
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'createpostcreationproject';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Create Post Creation Project');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('Create a new project for creating posts. This should be done after you have 
imported your data to your Wordpress database or already have a suitable table holding your data. 
CSV 2 POST allows us to use multiple database tables in a single project. You can make use of columns from 
one table and some columns from a totally different table. More tables equals more work for Wordpress so 
please only added essential tables. If you do not select a table created by CSV 2 POST, one will be created 
for tracking project progress and acting as a link between all other tables. This is also where Mapping Type 
comes into play. This is a very advanced feature and will no doubt need more development over 2012 to suit 
everyones needs so please contact us if your unsure. If you use multiple tables, you have further configuration 
to do in the Multiple Table Project panel. This panel offers the ability to reset a used project table and to
delete posts as part of the reset process. You can only reset posts related to a table if the table is also
selected for reset, this is a safety measure and the alternative is not usually a requirement.');
$panel_array['panel_url'] = 'http://www.csv2post.com/feature-guides/create-post-creation-project';
$panel_array['video'] = 'http://www.youtube.com/embed/b1K__laYifc';
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
$jsform_set['dialogbox_title'] = 'Create Post Creation Project';
$jsform_set['noticebox_content'] = 'Do you want to continue creating a new Post Creation Project? <p>Please note after submitting this form you will need to configure your project settings and tell the plugin exactly how you want your posts to be.</p>';
// create nonce - done in csv2post_ajax_is_dataimportjobname_used
$nonce = wp_create_nonce( "csv2post_referer_createproject_checkprojectname" );?>

<?php csv2post_panel_header( $panel_array );?>
    
    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?> 
    
    <?php // set ID and NAME variables
    $projectname_id = 'csv2post_projectname_id_' . $panel_array['panel_name'];
    $projectname_name = 'csv2post_projectname_name_' . $panel_array['panel_name'];?>
    
    <script type='text/javascript'>
    <!--
    var count = 0;

    // When the document loads do everything inside here ...
    jQuery(document).ready(function(){

        // run validation on data import job name when key is pressed
        $("#<?php echo $projectname_id;?>").change(function() { 

            var usr = $("#<?php echo $projectname_id;?>").val();

            if(usr.length >= 4){
                
                // remove any status display by adding blank value to html
                $("#csv2post_status_<?php echo $jsform_set['form_id'];?>").html('');
                                                                        
                jQuery.ajax({
                    type: "post",url: "admin-ajax.php",data: { action: 'action_createproject_checkprojectname', csv2post_projectname: escape( jQuery( '#<?php echo $projectname_id;?>' ).val() ), _ajax_nonce: '<?php echo $nonce; ?>' },
                    beforeSend: function() {jQuery("#<?php echo $jsform_set['form_id'];?>loading_projectnamechange").fadeIn('fast');
                    jQuery("#<?php echo $jsform_set['form_id'];?>formstatus").fadeOut("fast");}, //fadeIn loading just when link is clicked
                    success: function(html){ //so, if data is retrieved, store it in html
                        jQuery("#<?php echo $jsform_set['form_id'];?>loading_projectnamechange").fadeOut('slow');
                        jQuery("#<?php echo $jsform_set['form_id'];?>formstatus").html( html ); //show the html inside formstatus div
                        jQuery("#<?php echo $jsform_set['form_id'];?>formstatus").fadeIn("fast"); //animation
                    }
                }); //close jQuery.ajax
                     
            }else{
                $("#csv2post_status_<?php echo $jsform_set['form_id'];?>").html('<font color="red">' + 'The username should have at least <strong>4</strong> characters.</font>');
                $("#<?php echo $projectname_id;?>").removeClass('object_ok'); // if necessary
                $("#<?php echo $projectname_id;?>").addClass("object_error");
            }

        });
    })
    -->
    </script>

    <style type='text/css'>
    #<?php echo $jsform_set['form_id'];?>loading_projectnamechange { clear:both; background:url(images/loading.gif) center top no-repeat; text-align:center;padding:33px 0px 0px 0px; font-size:12px;display:none; font-family:Verdana, Arial, Helvetica, sans-serif; }                
    </style>
    
    <?php 
    if($csv2post_is_free){?>
        <input type='hidden' name='csv2post_projectname_name' value='Project' /><?php 
    }else{?>
        <p>Enter Project Name: <input type='text' name='csv2post_projectname_name' id='<?php echo $projectname_id;?>' value='' /><span id="csv2post_status_<?php echo $jsform_set['form_id'];?>"></span></p><?php 
    }?>
    
    <!-- jquery and ajax output start -->
    <div id='<?php echo $jsform_set['form_id'];?>loading_projectnamechange'>Checking Project Name Please Wait 10 Seconds</div>                 
    <div id='<?php echo $jsform_set['form_id'];?>formstatus'></div>  
    <!-- jquery and ajax output end --> 
               
    <h4>Select Database Tables</h4>
    <?php if(!$csv2post_is_free){?>
    <p>Selecting more than one file will create a more complex project and require the plugin to perform more
    advanced management of your data. Some data and configurations may not work as expected. Please seek advice if issues arise with your project.</p>
    <?php }?>
    
    <?php csv2post_display_databasetables_withjobnames(true);?>

    <?php // TODO: LOWPRIORITY, only display mapping methods when user selects more than 1 table, only show the third method when user selects 3 or more 
    // also do not display this option at all in free edition, we dont want to have to mention paid edition, this is our policy?>
    <h4>Select Table Mapping Type <?php if($csv2post_is_free){echo '(not required)';}?></h4>
    <script>
    $(function() {
        $( "#csv2post_projecttableselection_mapping_option" ).buttonset();
    });
    </script>

    <div id="csv2post_projecttableselection_mapping_option">
        <?php
        $checked_defaultorder = '';
        $checked_singlekeycolumn = '';
        $checked_manykeycolumns = '';
        if(isset($csv2post_project_array['mappingmethod']) && $csv2post_project_array['mappingmethod'] == 'defaultorder'){
            $checked_defaultorder = 'checked'; 
        }elseif(isset($csv2post_project_array['mappingmethod']) && $csv2post_project_array['mappingmethod'] == 'singlekeycolumn'){
            $checked_singlekeycolumn = 'checked';    
        }elseif(isset($csv2post_project_array['mappingmethod']) && $csv2post_project_array['mappingmethod'] == 'manykeycolumns'){
            $checked_manykeycolumns = 'checked';                 
        }else{
            $checked_defaultorder = 'checked';    
        }?>

        <input type="radio" id="csv2post_projecttables_mappingmethod_defaultorder" name="csv2post_projecttables_mappingmethod_inputname" value="defaultorder" <?php echo $checked_defaultorder;?> <?php if($csv2post_is_free){echo 'disabled="disabled"';}?> /><label for="csv2post_projecttables_mappingmethod_defaultorder">Default Order</label>
        <input type="radio" id="csv2post_projecttables_mappingmethod_singlekeycolumn" name="csv2post_projecttables_mappingmethod_inputname" value="singlekeycolumn" <?php echo $checked_singlekeycolumn;?> <?php if($csv2post_is_free){echo 'disabled="disabled"';}?> /><label for="csv2post_projecttables_mappingmethod_singlekeycolumn">Single Key Column</label>          
        <?php ### TODO:LOWPRIORITY, add multiplekeycolumns mapping type: this method will allow mapping of different columns holding different data between multiple project tables ?>
    </div>
    
    <h4>Ping Status</h4>
    <script>
    $(function() {
        $( "#csv2post_pingstatus" ).buttonset();
    });
    </script>
    
    <div id="csv2post_pingstatus"><?php      
        $o = ''; $c = 'checked';
        if(isset($csv2post_project_array['pingstatus']) && $csv2post_project_array['pingstatus'] == 'open'){
            $o = 'checked'; $c = '';
        }elseif(isset($csv2post_project_array['pingstatus']) && $csv2post_project_array['pingstatus'] == 'closed'){
            $o = ''; $c = 'checked'; 
        }else{
            // project ping default not set so we now make use of the blogs default ping
            $d = get_option('default_ping_status');
            if($d == 'closed'){
                $o = ''; $c = 'checked';        
            }elseif($d == 'open'){
                $o = 'checked'; $c = '';
            }
        }?>
        <input type="radio" id="csv2post_pingstatus_open_id" name="csv2post_pingstatus" value="open" <?php echo $o;?> /><label for="csv2post_pingstatus_open_id">Open</label>
        <input type="radio" id="csv2post_pingstatus_closed_id" name="csv2post_pingstatus" value="closed" <?php echo $c;?> /><label for="csv2post_pingstatus_closed_id">Closed</label>          
    </div>
         
    <h4>Comment Status</h4>
    <script>
    $(function() {
        $( "#csv2post_commentstatus" ).buttonset();
    });
    </script>
    
    <div id="csv2post_commentstatus"><?php
        $o = ''; $c = 'checked';
        if(isset($csv2post_project_array['commentstatus']) && $csv2post_project_array['commentstatus'] == 'open'){
            $o = 'checked'; $c = '';
        }elseif(isset($csv2post_project_array['commentstatus']) && $csv2post_project_array['commentstatus'] == 'closed'){
            $o = ''; $c = 'checked'; 
        }else{
            // project ping default not set so we now make use of the blogs default ping
            $d = get_option('default_comment_status');
            if($d == 'closed'){
                $o = ''; $c = 'checked';        
            }elseif($d == 'open'){
                $o = 'checked'; $c = '';
            }
        }?>
        <input type="radio" id="csv2post_commentstatus_open_id" name="csv2post_commentstatus" value="open" <?php echo $o;?> /><label for="csv2post_commentstatus_open_id">Open</label>
        <input type="radio" id="csv2post_commentstatus_closed_id" name="csv2post_commentstatus" value="closed" <?php echo $c;?> /><label for="csv2post_commentstatus_closed_id">Closed</label>          
    </div>

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
if(isset($csv2post_projectslist_array) && is_array($csv2post_projectslist_array)){ 
    if(!$csv2post_is_free){
                
        ++$panel_number;// increase panel counter so this panel has unique ID
        $panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
        $panel_array['panel_name'] = 'selectcurrentproject';// slug to act as a name and part of the panel ID 
        $panel_array['panel_title'] = __('Set Your Current Project');// user seen panel header text 
        $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
        if($csv2post_is_free){$panel_array['panel_intro'] = __('Full edition allows multiple projects to be created');}else{$panel_array['panel_intro'] = __('The "Current Project" is the one currently being worked on');}
        $panel_array['panel_help'] = __('This panel allows you to make any of your projects your Current project. Your current project settings will be displayed in the Your Projects screens. The Your Project screens also allow you to change global settings so take care when making changes if you are running multiple projects.');
        // Form Settings - create the array that is passed to jQuery form functions
        $jsform_set_override = array();
        $jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
        $jsform_set['dialogbox_title'] = 'Change Your Current Project';
        $jsform_set['noticebox_content'] = 'You are about to change your currently activated project. All project settings will re-load to reflect the newly activated project, please remember this when making changes. Do you wish to continue?';?>

        <?php csv2post_panel_header( $panel_array );?>

            <?php 
            // begin form and add hidden values
            csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
            csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
            ?> 
        
            <?php csv2post_JQUERY_buttonset('csv2post_radios_'.$panel_array['panel_name']);?>
            <div id="csv2post_radios_<?php echo $panel_array['panel_name'];?>">
                
                <?php
                if(!isset($csv2post_projectslist_array) || $csv2post_projectslist_array == false){
                    
                    echo '<strong>You do not have any projects</strong>';
                        
                }else{
                    
                    $i = 0; 
                    foreach($csv2post_projectslist_array as $project_code => $project ){
                        if($project_code != 'arrayinfo'){
                            $checked = '';
                            if($csv2post_currentproject_code == $project_code){
                                $checked = 'checked="checked"';    
                            }
                            echo '<input type="radio" id="csv2post_radio'.$i.$panel_array['panel_name'].'" name="csv2post_radio_projectcode" value="'.$project_code.'" '.$checked.' /><label for="csv2post_radio'.$i.$panel_array['panel_name'].'">'.$project['name'].'</label>';    
                            ++$i;
                        }
                    }
                }
                ?>
                
            </div>           

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
    if(!$csv2post_is_free){
        ++$panel_number;// increase panel counter so this panel has unique ID
        $panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
        $panel_array['panel_name'] = 'multipletableproject';// slug to act as a name and part of the panel ID 
        $panel_array['panel_title'] = __('Multiple Table Project');// user seen panel header text 
        $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
        $panel_array['panel_help'] = __('Multiple table projects require the user to tell CSV 2 POST what columns can be used to link the tables together. In database speak, these columns are Primary Key and Foreign Key. The important thing to know is that all tables must be mapped by a key column so they their data is included. Select the column in each table that is that tables primary key. Then in the second menu, select the column that the primary column matches exactly in terms of data (column names can be different). The second selection creates a relationship between the tables. You do not need to select a secondary column for one of the tables, it is recommended that you do this with the table that contains the most important data, the bulk of what will make up posts.');
        $panel_array['panel_url'] = 'http://www.csv2post.com/feature-guides/multiple-table-project-panel';
        // Form Settings - create the array that is passed to jQuery form functions
        $jsform_set_override = array();
        $jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
        $jsform_set['dialogbox_title'] = 'Save Multiple Table Configuration';
        $jsform_set['noticebox_content'] = 'You are about to save your projects multiple table configuration, getting this wrong will not create the posts you need, please backup your database if you are unsure about your choices. Do you wish to continue saving now?';?>
        <?php csv2post_panel_header( $panel_array );?>

            <?php 
            // 1.check if project exists 2.check if current project has more than one table
            if(!isset($csv2post_projectslist_array) || $csv2post_projectslist_array == false){
                echo '<strong>You do not have any projects</strong>';
            }elseif( count($csv2post_project_array['tables']) == 1 ){
                echo '<strong>Your project is not a multiple file project, you do not need to use this panel so its contents have been hidden</strong>';
            }else{
                
                // begin form and add hidden values
                csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
                csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
             
        
                echo '<table class="widefat post fixed">';
                
                echo '<tr><td width="150"><strong>Project Tables</strong></td><td><strong>Key Column</strong></td><td><strong>Other Tables Key Column</strong></td>';
                            
                foreach( $csv2post_project_array['tables'] as $key => $table_name ){
                    
                    echo '<tr><td>'.$table_name.'</td><td>';

                        // we need to get the current values - lets not assume they are set for the tables we cycle through
                        $current_value = false;  
                        if(isset($csv2post_project_array['multipletableproject']['relationships'][$table_name]['primarykey']) && $csv2post_project_array['multipletableproject']['relationships'][$table_name]['primarykey'] != 'notselected'){
                            $current_value = $csv2post_project_array['multipletableproject']['relationships'][$table_name]['primarykey'];
                        }

                        csv2post_menu_tablecolumns_multipletableproject($table_name,$current_value);
                    
                    echo '</td><td>';
                    
                        // we need to get the current values - lets not assume they are set for the tables we cycle through
                        $current_table = false;
                        $current_column = false;  
                        if( isset( $csv2post_project_array['multipletableproject']['relationships'][$table_name]['foreignkey_table'] ) && $csv2post_project_array['multipletableproject']['relationships'][$table_name]['foreignkey_table'] != 'notselected'
                        && isset( $csv2post_project_array['multipletableproject']['relationships'][$table_name]['foreignkey_column'] ) && $csv2post_project_array['multipletableproject']['relationships'][$table_name]['foreignkey_column'] != 'notselected' ){
                           
                            $current_table = $csv2post_project_array['multipletableproject']['relationships'][$table_name]['foreignkey_table'];
                            $current_column = $csv2post_project_array['multipletableproject']['relationships'][$table_name]['foreignkey_column'];             
                        }                

                        csv2post_display_menu_keycolumnselection($table_name,$current_table,$current_column);
                    
                    echo '</td></tr>';       
                }
                
                echo '</table>';


                // add js for dialog on form submission and the dialog <div> itself
                if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
                    csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
                    csv2post_jquery_form_prompt($jsform_set);
                }
                ?>
                    
                <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);    
            }?>

        <?php csv2post_panel_footer();
    }?>
      
    <?php
    if(!$csv2post_is_free){
        ++$panel_number;// increase panel counter so this panel has unique ID
        $panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
        $panel_array['panel_name'] = 'postcreationprojectlist';// slug to act as a name and part of the panel ID 
        $panel_array['panel_title'] = __('Post Creation Project List');// user seen panel header text 
        $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
        $panel_array['panel_help'] = __('All your post creation projects are listed here. You must not delete a project if you plan to update data in the Wordpress database that is related to posts in any way. The project configuration data includes history/statistical values that may be required for future changes to posts created by the project.');?>
        <?php csv2post_panel_header( $panel_array );?>
            <?php csv2post_postcreationproject_table();?>
        <?php csv2post_panel_footer();
    }?> 

    <?php
    ++$panel_number;// increase panel counter so this panel has unique ID
    $panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
    $panel_array['panel_name'] = 'deleteprojects';// slug to act as a name and part of the panel ID 
    $panel_array['panel_title'] = __('Delete Project');// user seen panel header text 
    $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
    $panel_array['panel_help'] = __('You can select multiple project to be deleted. This cannot be reversed, please take care when selecting your projects.');
    // Form Settings - create the array that is passed to jQuery form functions
    $jsform_set_override = array();
    $jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
    $jsform_set['dialogbox_title'] = 'Delete Project';
    $jsform_set['noticebox_content'] = 'Are you sure you want to delete the selected post creation projects?';?>
    <?php csv2post_panel_header( $panel_array );?>

        <?php 
        // begin form and add hidden values
        csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
        csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
        ?> 
        
        <?php 
        if(!isset($csv2post_projectslist_array) || $csv2post_projectslist_array == false){
            
            if($csv2post_is_free){
                echo '<strong>You have not created your project yet, there is nothing to be deleted</strong>';
            }else{
                echo '<strong>You do not have any projects</strong>';
            }
                
        }else{
            
            if($csv2post_is_free){
                // display nothing - free edition works with a single project    
            }else{?>
                
                <br />
                <div id="csv2post-multiselect-createnewproject-div-id">
                    <select multiple='multiple' id="csv2post_project_listid" class='csv2post_multiselect_projects_deleteprojects' name="csv2post_projectcodes_array[]">
                        <?php csv2post_option_items_postcreationprojects();?> 
                    </select>
                </div> 
                           
                <script type="text/javascript">
                    $(function(){
                        $('.csv2post_multiselect_projects_deleteprojects').multiSelect({
                          selectableHeader : '<h3>Projects Available</h3>',
                          selectedHeader : '<h3>Delete These</h3>'                
                        });
                    });
                </script><?php 
            }

            // add js for dialog on form submission and the dialog <div> itself
            if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
                csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
                csv2post_jquery_form_prompt($jsform_set);
            }
            ?>
                
            <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);    
        }?>

    <?php csv2post_panel_footer();

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
        if(!is_array($csv2post_projectslist_array)){
            echo '<p>The $csv2post_projectslist_array is not an array!</p>';    
        }else{     
            csv2post_var_dump($csv2post_projectslist_array);
        }
        ?>

    <?php csv2post_panel_footer();
}?>