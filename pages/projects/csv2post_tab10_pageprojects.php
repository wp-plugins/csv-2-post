<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'postslug';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Post Name/Slug/Permalink Column');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('A slug is the version of a post title in lower-case, no special characters and
spaces replaced with hyphens. Many users will call this the permalink but the permalink is the full URL once
the slug is set and post created. Post "name" is the term used in code. So this explains Name/Slug/Permalink, it is
to help anyone interested in either find this panel. This panel allows us to select a column of slug data which as
already stated is your column titles pre-prepared for use in URL. If your pre-made slugs are no different than
what Wordress would create by default based on post titles you create. Then you do not need to use this feature, you
will not need pre-made slugs in your CSV file and should remove them. If however your slugs are custom and different
from the default Wordpress would create based on your post titles then this feature is suitable.');
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);     
$jsform_set['dialogbox_title'] = 'Apply Slug Data';
$jsform_set['noticebox_content'] = 'Do you want to apply your own slug data rather than allow Wordpress to create them based on your post titles?';?>
<?php csv2post_panel_header( $panel_array );?>

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?> 
    
    <?php 
    $default = 'selected="selected"';
    $ct = false; $cc = false;
    if(!isset($csv2post_project_array['slugs']['custom']['tablename']) || !isset($csv2post_project_array['slugs']['custom']['columnname'])){
        $default = '';    
    }else{
        if(isset($csv2post_project_array['slugs']['custom']['tablename'])){
            $ct = $csv2post_project_array['slugs']['custom']['tablename'];
        }
        
        if(isset($csv2post_project_array['slugs']['custom']['columnname'])){
            $cc = $csv2post_project_array['slugs']['custom']['columnname'];
        }        
    }?>
    
    Select Slug Data Column: 
    <select name="csv2post_slug_columnandtable" id="csv2post_slug_columnandtable_id" class="csv2post_multiselect_menu">
        <option value="notselected" <?php echo $default;?>>Not Selected</option>
        <?php csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code,$ct,$cc);?>                                                                                                                     
    </select>    

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
if(!$csv2post_is_free){
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'projectcloakingsettings';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('URL/Link Cloaking');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('Select the columns you would like cloaking to be applied to. Each
URL used in content will get its own cloak. This requires a custom field per cloaked URL which holds
the original URL. A cloak URL is used in your content, a URL with your own domain and is very short. This
gives the appearance of a local link. CSV 2 POST processes a click on these cloaks and forwards the visitor to
the original URL.');
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);     
$jsform_set['dialogbox_title'] = 'Save Project URL Cloaking Settings';
$jsform_set['noticebox_content'] = 'Do you want to continue saving cloaking settings for this project?';?>
<?php csv2post_panel_header( $panel_array );?>

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?> 
    
    <?php
    ### TODO:LOWPRIORITY, this covers a single table, we need to cover multiple tables
    $mainTable = csv2post_get_project_maintable($csv2post_currentproject_code);
    $urlColumns_array = csv2post_WP_SQL_return_cols_with_data_type($mainTable,'URL');
    if(!is_array($urlColumns_array) || !count($urlColumns_array)){
        csv2post_n_incontent('You do not have any URL data columns suitable
        for cloaking.','info','Small','No URL Data');        
    }else{?>  
             
        <table class="widefat post fixed">
            <tr>
                <td width="50"><strong>Cloak</strong></td><td width="150"><strong>Column Name</strong></td><td><strong>Table Name</strong></td>
            </tr>
            <?php
            if(!is_array($urlColumns_array)){
                
            }else{
                foreach($urlColumns_array['matches'] as $k => $c){
                    
                    $checked = '';
                    if(isset($csv2post_project_array['urlcloaking'])){
                        foreach($csv2post_project_array['urlcloaking'] as $key => $array){
                            if(isset($array['table']) && $array['table'] == $mainTable && isset($array['column']) && $array['column'] == $c){
                                $checked = 'checked';
                            }
                        } 
                    }   

                    echo '<tr><td><input type="checkbox" name="csv2post_cloakcolumns[]" value="'.$mainTable.','.$c.'" '.$checked.'></td><td>'.$c.'</td><td>'.$mainTable.'</td></tr>';    
                }
            }?>
        </table>
        
    <?php 
    }?>
    
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