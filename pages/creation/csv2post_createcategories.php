<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'createcategoriesperlevel';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Create Categories Per Level');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('This category creation method was added February 2013 and is the recommended
form to use. This method allows us to monitor category creation by level, allowing for diagnostics if we run into
troubles and by creating categories manually we reduce processing time during post creation. This method updates
a column in the data import job database tables named csv2post_catid. The csv2post_catid column is updated with the
category ID that applies to each record. During post creation the string of ID are easily added to each posts data.');
$panel_array['video'] = 'http://www.youtube.com/embed/gkmY31MycsA';
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);     
$jsform_set['dialogbox_title'] = 'Create Next Category Level';
$jsform_set['noticebox_content'] = 'You are about to create your next level of categories. Do you wish to continue?';
// TODO:MEDIUMPRIORITY, add optional date criteria to restrict deletion to a publish date range ?>

<?php csv2post_panel_header( $panel_array );?>
      
    <?php
    // we will run some initial checks to ensure category settings have been saved else notifications are displayed
    // if no category settings saved at all
    if(!isset($csv2post_project_array['categories'])){
        
        echo csv2post_notice( 'No category settings have been saved for your current project. You must save some category settings to make categories as the plugin does not know what columns your category data is in or the order of categories.','warning','Large','No Category Settings','www.csv2post.com/notifications/no-category-settings-saved-for-testing','return');
    
    }else{

        // begin form and add hidden values
        csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
        csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
                
        echo csv2post_notice('This is the newer category creation form that requires multiple submission.
        This allows us to ensure each level is in place and narrow down any issues in category data to
        specific levels or settings being applied per level.','info','Small','Category Creation Method 2013','','return');

        // count number of category levels user has setup
        $category_levels = 0;
        $nextlevel = 1;
        $nextlevel_changed = false;
        for($i=1;$i<=6;$i++){
            if(isset($csv2post_project_array['categories']['level'.$i])){
                
                // establish the completion status of level
                if(isset($csv2post_project_array['categories']['level'.$i]['complete']) && $csv2post_project_array['categories']['level'.$i]['complete'] == true){
                    csv2post_n_incontent('You have created level '.$i.' categories.','success','Small','Level '.$i.' Complete');    
                }else{
                    if($nextlevel_changed == false){
                        $nextlevel = $i;
                        $nextlevel_changed = true;
                    }
                    csv2post_n_incontent('Not created level '.$i.' categories yet.','error','Small','Level '.$i.' Waiting');                           
                }
                
                ++$category_levels;
            }
        }
        
        // submit the next level to be created
        echo '<input type="hidden" name="csv2post_categories_next_level" value="'.$nextlevel.'">';
        
        // add js for dialog on form submission and the dialog <div> itself
        if(csv2post_WP_SETTINGS_form_submit_dialog($panel_array)){
            csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
            csv2post_jquery_form_prompt($jsform_set);
        } 
        
        csv2post_formend_standard('Create Level '.$nextlevel.' Categories',$jsform_set['form_id']);   
             
    }?>
  
<?php csv2post_panel_footer();?>