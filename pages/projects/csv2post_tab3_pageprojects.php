<?php 
// array of all known SEO plugins that have extra support
$seo_plugins_array = array();
// All In One SEO
$seo_plugins_array[0]['name'] = 'All In One SEO Pack';
$seo_plugins_array[0]['folder'] = 'all-in-one-seo-pack';
$seo_plugins_array[0]['file'] = 'all_in_one_seo_pack.php';
$seo_plugins_array[0]['seotitle'] = '_aioseop_title';
$seo_plugins_array[0]['seodescription'] = '_aioseop_description'; 
// Yoast
$seo_plugins_array[1]['name'] = 'SEO By Yoast';
$seo_plugins_array[1]['folder'] = 'wordpress-seo';
$seo_plugins_array[1]['file'] = 'wp-seo.php';
$seo_plugins_array[1]['seotitle'] = '_yoast_wpseo_title';
$seo_plugins_array[1]['seodescription'] = '_yoast_wpseo_metadesc';
$seo_plugins_array[1]['seokeywords'] = '_yoast_wpseo_metakeywords';
   
// if no SEO plugin installed that we know, display persistent message asking user to request upgrade
$seo_plugin_installed = false;
foreach($seo_plugins_array as $key => $seo_plugin){
    if(is_plugin_active($seo_plugin['folder'] . '/'. $seo_plugin['file'])){
        $seo_plugin_installed = true;    
    }    
}
     
if(!$seo_plugin_installed){
    echo csv2post_notice('No known SEO plugin was detected in your blog. To help us improve integration pease let us know what SEO
    plugin you are using. This does not mean CSV 2 POST does not work with your plugin. It means
    there are no features to make it even easier.','info','Small','','','return',true);
}
?>

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'basicseooptions';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Basic SEO Options');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Select columns that hold the values you wish to use for SEO values');
$panel_array['panel_help'] = __('Basic SEO options offer the ability to quickly setup meta values that will be applied to the page by your SEO plugin. You must enter the correct meta keys for your plugin and if you change SEO plugins after posts have been made you will need to take action to re-make meta values to work with your new SEO plugin.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);     
$jsform_set['dialoguebox_title'] = 'Save Basic SEO Options';
$jsform_set['noticebox_content'] = 'These options will add meta values to your posts to work with your SEO plugin. Do you wish to continue?';
// TODO:LOWPRIORITY, add column replacement tokens too a dialogue window and button and do the same for other panels that require them?>
<?php csv2post_panel_header( $panel_array );?>

    <?php csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');?>
    
    <h4>Meta Title</h4>
    <?php $title_key = '';
    if(isset($csv2post_project_array['seo']['basic']['title_key'])){$title_key = $csv2post_project_array['seo']['basic']['title_key'];}?>
    Title Meta Key:<input type="text" name="csv2post_seo_key_title" value="<?php echo $title_key;?>"><br /> 
    Select Meta Title Column:<select name="csv2post_seo_title" id="csv2post_seo_title_id" class="csv2post_multiselect_menu">
        <?php 
        if(isset($csv2post_project_array['seo']['basic']['title_table']) && isset($csv2post_project_array['seo']['basic']['title_column'])){
            csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code,$csv2post_project_array['seo']['basic']['title_table'],$csv2post_project_array['seo']['basic']['title_column']);        
        }else{
            csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code);
        }?>                                                                                                                     
    </select>

    <script>
    $("#csv2post_seo_title_id").multiselect({
       multiple: false,
       header: "Select Database Column (table - column)",
       noneSelectedText: "Select Database Table",
       selectedList: 1
    });
    </script>
            
    <h4>Select Description Column</h4>
    <?php $description_key = '';
    if(isset($csv2post_project_array['seo']['basic']['description_key'])){$description_key = $csv2post_project_array['seo']['basic']['description_key'];}?>    
    Description Meta Key:<input type="text" name="csv2post_seo_key_description" value="<?php echo $description_key;?>"><br />    
    Select Meta Description Column:<select name="csv2post_seo_description" id="csv2post_seo_description_id" class="csv2post_multiselect_menu">
        <?php 
        if(isset($csv2post_project_array['seo']['basic']['description_table']) && isset($csv2post_project_array['seo']['basic']['description_column'])){
            csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code,$csv2post_project_array['seo']['basic']['description_table'],$csv2post_project_array['seo']['basic']['description_column']);        
        }else{
            csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code);
        }?>                                                                                                                     
    </select>

    <script>
    $("#csv2post_seo_description_id").multiselect({
       multiple: false,
       header: "Select Database Column (table - column)",
       noneSelectedText: "Select Database Table",
       selectedList: 1
    });
    </script>
        
    <h4>Select Keywords Column</h4>
    <?php $keyword_key = '';
    if(isset($csv2post_project_array['seo']['basic']['keywords_key'])){$keyword_key = $csv2post_project_array['seo']['basic']['keywords_key'];}?>        
    Keyword Meta Key:<input type="text" name="csv2post_seo_key_keywords" value="<?php echo $keyword_key;?>"><br />
    Select Meta Keyword Column:<select name="csv2post_seo_keywords" id="csv2post_seo_keywords_id" class="csv2post_multiselect_menu">
        <?php 
        if(isset($csv2post_project_array['seo']['basic']['keywords_table']) && isset($csv2post_project_array['seo']['basic']['keywords_column'])){
            csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code,$csv2post_project_array['seo']['basic']['keywords_table'],$csv2post_project_array['seo']['basic']['keywords_column']);        
        }else{
            csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code);
        }?>                                                                                                                     
    </select>        
    
    <script>
    $("#csv2post_seo_keywords_id").multiselect({
       multiple: false,
       header: "Select Database Column (table - column)",
       noneSelectedText: "Select Database Table",
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
if(!$csv2post_is_free){
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'advancedseooptions';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Advanced SEO Options');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Use template designs to create more advanced SEO meta values');
$panel_array['panel_help'] = __('Advanced SEO features will do more to help you populate meta values. You can use template designs in the same way that we design posts main content and post titles. If you submit the Basic SEO Options form and also submit the Advanced SEO Options form, the advanced options will get priority. Where the advanced options or data determine that a value cannot be generated using more advanced approaches, the plugin will default too the basic options i.e. if a record does not having enough text data to generate good SEO meta values.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);     
$jsform_set['dialoguebox_title'] = 'Save Advanced SEO Options';
$jsform_set['noticebox_content'] = 'These options will add meta values to your posts to work with your SEO plugin. Do you wish to continue?';
// TODO:MEDIUMPRIORITY, consider transferring template into project array to avoid quering post during post creation, we could store projects using a template in post meta, when post edited we can update the project arrays
?>
<?php csv2post_panel_header( $panel_array );?>

    <?php csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');?>
    
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
            echo '<option value="'.$template->ID.'">'.$template->post_title.'</option>';   
        }?>
    </select>
    <script>
    $("#csv2post_seo_title_advanced_id").multiselect({
       multiple: false,
       header: "Select Template",
       noneSelectedText: "Select Template",
       selectedList: 1
    });
    </script>    
    
    <br />
    
    Select Meta Description Template:
    <select name="csv2post_seo_description_advanced" id="csv2post_seo_description_advanced_id" class="csv2post_multiselect_menu">
        <option value="notrequired">Not Required</option>
        <?php 
        foreach($posts_array as $key => $template){
            echo '<option value="'.$template->ID.'">'.$template->post_title.'</option>';   
        }?>
    </select>
    <script>
    $("#csv2post_seo_description_advanced_id").multiselect({
       multiple: false,
       header: "Select Template",
       noneSelectedText: "Select Template",
       selectedList: 1
    });
    </script>    
    
    <br />
    
    Select Meta Keywords Template:
    <select name="csv2post_seo_keywords_advanced" id="csv2post_seo_keywords_advanced_id" class="csv2post_multiselect_menu">
        <option value="notrequired">Not Required</option>
        <?php 
        foreach($posts_array as $key => $template){
            echo '<option value="'.$template->ID.'">'.$template->post_title.'</option>';   
        }?>
    </select>
    <script>
    $("#csv2post_seo_keywords_advanced_id").multiselect({
       multiple: false,
       header: "Select Template",
       noneSelectedText: "Select Template",
       selectedList: 1
    });
    </script>     

    <h4>Select SEO Plugin Custom Field/Meta Keys</h4> 
    <p>Selecting your SEO plugin here will ensure the correct meta key is used for each SEO value.</p>
    
    Select Meta Title Plugin:
    <select name="csv2post_seo_titlekey_advanced" id="csv2post_seo_titlekey_advanced_id" class="csv2post_multiselect_menu">
        <option value="notrequired">Not Required</option>
        <?php 
        foreach($seo_plugins_array as $key => $seo_plugin){
            echo '<option value="'.$seo_plugin['seotitle'].'">'.$seo_plugin['name'].'</option>';   
        }?>
    </select>
    <script>
    $("#csv2post_seo_titlekey_advanced_id").multiselect({
       multiple: false,
       header: "Select SEO Plugin",
       noneSelectedText: "Select SEO Plugin",
       selectedList: 1
    });
    </script>    
    
    <br />

    Select Meta Description Plugin:
    <select name="csv2post_seo_descriptionkey_advanced" id="csv2post_seo_descriptionkey_advanced_id" class="csv2post_multiselect_menu">
        <option value="notrequired">Not Required</option>
        <?php 
        foreach($seo_plugins_array as $key => $seo_plugin){
            echo '<option value="'.$seo_plugin['seodescription'].'">'.$seo_plugin['name'].'</option>';   
        }?>
    </select>
    <script>
    $("#csv2post_seo_descriptionkey_advanced_id").multiselect({
       multiple: false,
       header: "Select SEO Plugin",
       noneSelectedText: "Select SEO Plugin",
       selectedList: 1
    });
    </script>    
    
    <br />
   
    Select Meta Keywords Plugin:
    <select name="csv2post_seo_keywordskey_advanced" id="csv2post_seo_keywordskey_advanced_id" class="csv2post_multiselect_menu">
        <option value="notrequired">Not Required</option>
        <?php 
        foreach($seo_plugins_array as $key => $seo_plugin){
            echo '<option value="'.$seo_plugin['seokeywords'].'">'.$seo_plugin['name'].'</option>';   
        }?>
    </select>
    <script>
    $("#csv2post_seo_keywordskey_advanced_id").multiselect({
       multiple: false,
       header: "Select SEO Plugin",
       noneSelectedText: "Select SEO Plugin",
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

<?php csv2post_panel_footer();
}?>

<?php
if($csv2post_is_dev){
    ++$panel_number;// increase panel counter so this panel has unique ID
    $panel_array = array();
    $panel_array['panel_name'] = 'basicseooptionsarraydump';// slug to act as a name and part of the panel ID 
    $panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
    $panel_array['panel_title'] = __('Basic SEO Options Array Dump');// user seen panel header text 
    $panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
    $panel_array['tabnumber'] = $csv2post_tab_number; 
    $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
    $panel_array['panel_intro'] = __('Select columns that hold the values you wish to use for SEO values');
    $panel_array['panel_help'] = __('Basic SEO options offer the ability to quickly setup meta values that will be applied to the page by your SEO plugin. You must enter the correct meta keys for your plugin and if you change SEO plugins after posts have been made you will need to take action to re-make meta values to work with your new SEO plugin.');
    $panel_array['help_button'] = csv2post_helpbutton_text(false,false);?>
    <?php csv2post_panel_header( $panel_array );?>

    <?php
    if(!isset($csv2post_project_array['seo'])){
        echo '<p>No [seo] array found, your project is not prepared for adding seo meta values too your posts</p>';
    }else{ 
        echo '<pre>';
        var_dump($csv2post_project_array['seo']);
        echo '</pre>';
    }?>
        
<?php csv2post_panel_footer();
}?>