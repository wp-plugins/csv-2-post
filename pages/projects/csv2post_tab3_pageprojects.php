<?php   
global $csv2post_seoplugins_array;

// if no SEO plugin installed that we know, display persistent message asking user to request upgrade
$seo_plugin_installed = false;
foreach($csv2post_seoplugins_array as $seo_plugin_id => $seo_plugin){
    if(is_plugin_active($seo_plugin['folder'] . '/'. $seo_plugin['file'])){
        $seo_plugin_installed = true;
        // break loop even if user has more seo plugins, we will focus on one for now. $key is used further down also.
        break;    
    }    
}
     
if(!$seo_plugin_installed){
    echo csv2post_notice('No known SEO plugin was detected in your blog. To help us improve integration pease let us know what SEO
    plugin you are using. This does not mean CSV 2 POST does not work with your plugin. It means
    there are no features to make configure quicker.','info','Tiny','','','return',true);
}else{
    echo csv2post_notice('CSV 2 POST has detected '.$csv2post_seoplugins_array[$seo_plugin_id]['name'].' is installed and active.','info','Tiny','','','return');
} 

if(!isset($csv2post_project_array['seo']['basic']['title_key'])
&& !isset($csv2post_project_array['seo']['basic']['description_key'])
&& !isset($csv2post_project_array['seo']['basic']['keywords_key'])){
    echo csv2post_notice('Basic SEO settings have not been saved yet.','warning','Tiny','','','return');
    $basic_seo_not_saved = true;    
} 
?>

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'basicseooptions';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Basic SEO Options');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('Basic SEO options offer the ability to quickly setup meta values that will be applied to the page by your SEO plugin. You must enter the correct meta keys for your plugin and if you change SEO plugins after posts have been made you will need to take action to re-make meta values to work with your new SEO plugin.');
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);     
$jsform_set['dialogbox_title'] = 'Save Basic SEO Options';
$jsform_set['noticebox_content'] = 'These options will add meta values to your posts to work with your SEO plugin. Do you wish to continue?';
// TODO:LOWPRIORITY, add column replacement tokens to a dialog window and button and do the same for other panels that require them?>
<?php csv2post_panel_header( $panel_array );?>

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?>
    
    <h4>Meta Title</h4>
    <?php $title_key = '';
    if(isset($csv2post_project_array['seo']['basic']['title_key'])){
        $title_key = $csv2post_project_array['seo']['basic']['title_key'];
    }elseif(isset($seo_plugin_installed) && isset($seo_plugin_id)){
        $title_key = $csv2post_seoplugins_array[$seo_plugin_id]['seotitle'];    
    }?>
    Title Meta Key:<input type="text" name="csv2post_seo_key_title" value="<?php echo $title_key;?>" size="38"><br /> 
    Select Meta Title Column:
    <select name="csv2post_seo_title" id="csv2post_seo_title_id" class="csv2post_multiselect_menu">
        <?php 
        if(isset($csv2post_project_array['seo']['basic']['title_table']) && isset($csv2post_project_array['seo']['basic']['title_column'])){
            csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code,$csv2post_project_array['seo']['basic']['title_table'],$csv2post_project_array['seo']['basic']['title_column']);        
        }else{
            csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code);
        }?>                                                                                                                     
    </select>
   
    <h4>Select Description Column</h4>
    <?php $description_key = '';
    if(isset($csv2post_project_array['seo']['basic']['description_key'])){
        $description_key = $csv2post_project_array['seo']['basic']['description_key'];
    }elseif(isset($seo_plugin_installed) && isset($seo_plugin_id)){
        $description_key = $csv2post_seoplugins_array[$seo_plugin_id]['seodescription'];    
    }?>    
    Description Meta Key:<input type="text" name="csv2post_seo_key_description" value="<?php echo $description_key;?>" size="38"><br />    
    Select Meta Description Column:<select name="csv2post_seo_description" id="csv2post_seo_description_id" class="csv2post_multiselect_menu">
        <?php 
        if(isset($csv2post_project_array['seo']['basic']['description_table']) && isset($csv2post_project_array['seo']['basic']['description_column'])){
            csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code,$csv2post_project_array['seo']['basic']['description_table'],$csv2post_project_array['seo']['basic']['description_column']);        
        }else{
            csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code);
        }?>                                                                                                                     
    </select>
       
    <h4>Select Keywords Column</h4>
    <?php $keyword_key = '';
    if(isset($csv2post_project_array['seo']['basic']['keywords_key'])){
        $keyword_key = $csv2post_project_array['seo']['basic']['keywords_key'];
    }elseif(isset($seo_plugin_installed) && isset($seo_plugin_id)){
        $keyword_key = $csv2post_seoplugins_array[$seo_plugin_id]['seokeywords'];    
    }?>        
    Keyword Meta Key:<input type="text" name="csv2post_seo_key_keywords" value="<?php echo $keyword_key;?>" size="38"><br />
    Select Meta Keyword Column:<select name="csv2post_seo_keywords" id="csv2post_seo_keywords_id" class="csv2post_multiselect_menu">
        <?php 
        if(isset($csv2post_project_array['seo']['basic']['keywords_table']) && isset($csv2post_project_array['seo']['basic']['keywords_column'])){
            csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code,$csv2post_project_array['seo']['basic']['keywords_table'],$csv2post_project_array['seo']['basic']['keywords_column']);        
        }else{
            csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code);
        }?>                                                                                                                     
    </select>        
    
    <br />
        
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
$panel_array['panel_name'] = 'advancedseooptions';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Advanced SEO Options');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('Advanced SEO features will do more to help you populate meta values. You can use template designs in the same way that we design posts main content and post titles. If you submit the Basic SEO Options form and also submit the Advanced SEO Options form, the advanced options will get priority. Where the advanced options or data determine that a value cannot be generated using more advanced approaches, the plugin will default too the basic options i.e. if a record does not having enough text data to generate good SEO meta values.');
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);     
$jsform_set['dialogbox_title'] = 'Save Advanced SEO Options';
$jsform_set['noticebox_content'] = 'These options will add meta values to your posts to work with your SEO plugin. Do you wish to continue?';
// TODO:MEDIUMPRIORITY, consider transferring template into project array to avoid quering post during post creation, we could store projects using a template in post meta, when post edited we can update the project arrays
?>
<?php csv2post_panel_header( $panel_array );?>

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?>
    
    <?php 
    $args = array(
    'numberposts'     => 50,
    'orderby'         => 'post_date',
    'order'           => 'DESC',  
    'meta_key'        => '_csv2post_templatetypes',
    'meta_value'      => 'seovalue',
    'post_type'       => 'wtgcsvcontent' );   

    $posts_array = get_posts( $args );?>

    <h4>Select Template Designs</h4>
    <p>Create unique values for maximum SEO using any of your templates.</p>
    Select Meta Title Template:
    <select name="csv2post_seo_title_advanced" id="csv2post_seo_title_advanced_id" class="csv2post_multiselect_menu">
        <option value="notrequired">Not Required</option>
        <?php    
        foreach($posts_array as $key => $template){
            
            $selected = '';
            if(isset($csv2post_project_array['seo']['advanced']['title_template']) && $csv2post_project_array['seo']['advanced']['title_template'] == $template->ID){
                $selected = 'selected="selected"';    
            }  
                      
            echo '<option value="'.$template->ID.'" '.$selected.'>'.$template->post_title.'</option>';   
        }?>
    </select>  
    
    <br />
    
    Select Meta Description Template:
    <select name="csv2post_seo_description_advanced" id="csv2post_seo_description_advanced_id" class="csv2post_multiselect_menu">
        <option value="notrequired">Not Required</option>
        <?php 
        foreach($posts_array as $key => $template){
            
            $selected = '';
            if(isset($csv2post_project_array['seo']['advanced']['description_template']) && $csv2post_project_array['seo']['advanced']['description_template'] == $template->ID){
                $selected = 'selected="selected"';    
            }
                        
            echo '<option value="'.$template->ID.'" '.$selected.'>'.$template->post_title.'</option>';   
        }?>
    </select> 
    
    <br />
    
    Select Meta Keywords Template:
    <select name="csv2post_seo_keywords_advanced" id="csv2post_seo_keywords_advanced_id" class="csv2post_multiselect_menu">
        <option value="notrequired">Not Required</option>
        <?php 
        foreach($posts_array as $key => $template){
            
            $selected = '';
            if(isset($csv2post_project_array['seo']['advanced']['keywords_template']) && $csv2post_project_array['seo']['advanced']['keywords_template'] == $template->ID){
                $selected = 'selected="selected"';    
            }
                        
            echo '<option value="'.$template->ID.'" '.$selected.'>'.$template->post_title.'</option>';   
        }?>
    </select>  

    <h4>Select SEO Plugin Custom Field/Meta Keys</h4> 
    <p>Selecting your SEO plugin here will ensure the correct meta key is used for each SEO value.</p>

    Select Meta Title Plugin:
    <select name="csv2post_seo_titlekey_advanced" id="csv2post_seo_titlekey_advanced_id" class="csv2post_multiselect_menu">
        <option value="notrequired">Not Required</option>
        <?php 
        foreach($csv2post_seoplugins_array as $key => $seo_plugin){
            $selected = '';
            if(isset($csv2post_project_array['seo']['advanced']['title_key']) && $csv2post_project_array['seo']['advanced']['title_key'] == $seo_plugin['seotitle']){
                $selected = 'selected="selected"';
            }
            echo '<option value="'.$seo_plugin['seotitle'].'" '.$selected.'>'.$seo_plugin['name'].'</option>';   
        }?>
    </select>  
    
    <br />

    Select Meta Description Plugin:
    <select name="csv2post_seo_descriptionkey_advanced" id="csv2post_seo_descriptionkey_advanced_id" class="csv2post_multiselect_menu">
        <option value="notrequired">Not Required</option>
        <?php 
        foreach($csv2post_seoplugins_array as $key => $seo_plugin){
            $selected = '';
            if(isset($csv2post_project_array['seo']['advanced']['description_key']) && $csv2post_project_array['seo']['advanced']['description_key'] == $seo_plugin['seodescription']){
                $selected = 'selected="selected"';
            }            
            echo '<option value="'.$seo_plugin['seodescription'].'" '.$selected.'>'.$seo_plugin['name'].'</option>';   
        }?>
    </select>  
    
    <br />
   
    Select Meta Keywords Plugin:  
    <select name="csv2post_seo_keywordskey_advanced" id="csv2post_seo_keywordskey_advanced_id" class="csv2post_multiselect_menu">
        <option value="notrequired">Not Required</option>
        <?php 
        foreach($csv2post_seoplugins_array as $key => $seo_plugin){
            $selected = '';
            if(isset($csv2post_project_array['seo']['advanced']['keywords_key']) && $csv2post_project_array['seo']['advanced']['keywords_key'] == $seo_plugin['seokeywords']){
                $selected = 'selected="selected"';
            }            
            echo '<option value="'.$seo_plugin['seokeywords'].'" '.$selected.'>'.$seo_plugin['name'].'</option>';   
        }?>
    </select>                                 
    
    <br />    

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
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'extraseosupport';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Extra "SEO Plugins" Support');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
?>
<?php csv2post_panel_header( $panel_array );?>

    <p>All SEO plugins are supported but some have extra support to make configuration quicker and easier
    for beginners i.e. we detect the SEO plugin installed and fill out forms with required values for
    that plugin. Simple really! Our premium plugin has even more support for SEO in general.</p>

    <h4>SEO Plugins With Extra Support</h4>
    <table class="widefat post fixed">
        <tr class="first">
            <td width="200"><strong>SEO Plugin Name</strong></td>
            <td><strong>Plugins Website</strong></td>                                                       
        </tr>  

        <?php 
        $seo_plugin_installed = false;
        foreach($csv2post_seoplugins_array as $seo_plugin_id => $seo_plugin){
            if(is_plugin_active($seo_plugin['folder'] . '/'. $seo_plugin['file'])){
                $seo_plugin_installed = true;
            } ?>
              
            <tr>
                <td width="200"><?php echo $seo_plugin['name'];?></td>
                <td><a href="<?php echo $seo_plugin['pluginsite'];?>" title="Visit SEO Plugin Website for <?php echo $seo_plugin['name'];?>">Visit Website</a></td>                                                       
            </tr> 
                    
        <?php      
        }
        ?>
        
    </table>
    
<?php csv2post_panel_footer();?>

<?php
if($csv2post_is_dev){
    ++$panel_number;// increase panel counter so this panel has unique ID
    $panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
    $panel_array['panel_name'] = 'basicsearraydump';// slug to act as a name and part of the panel ID 
    $panel_array['panel_title'] = __('Basic SEO Options Array Dump');// user seen panel header text 
    $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
    $panel_array['panel_help'] = __('Basic SEO options offer the ability to quickly setup meta values that will be applied to the page by your SEO plugin. You must enter the correct meta keys for your plugin and if you change SEO plugins after posts have been made you will need to take action to re-make meta values to work with your new SEO plugin.');?>
    <?php csv2post_panel_header( $panel_array );?>

    <?php
    if(!isset($csv2post_project_array['seo'])){
        echo '<p>No [seo] array found, your project is not prepared for adding seo meta values to your posts</p>';
    }else{ 
        csv2post_var_dump($csv2post_project_array['seo']);
    }?>
        
<?php csv2post_panel_footer();
}?>