<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'createrandomvalueshortcodes';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Create Advanced Random Value Shortcodes *global panel*');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Create custom shortcodes for copying and pasting into content designs');
$panel_array['panel_help'] = __('Warning, not all content types will currently processing shortcodes i.e. custom field
content designs or category description content. This will eventually change but as I write this shortcode are intended
for use in post content designs. These shortcodes allow us to apply a random html value to our post html
content. This means we can randomise everything from plain text too html code such as images or links. We can add the random
value to any part of our content using shortcodes. There are endless things we can do, some simple, some complex. Not
everything CSV 2 POST can do is obvious from looking at the interface, so if you have specific text spinning
needs please contact us.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,true);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);     
$jsform_set['dialoguebox_title'] = 'Save Text Spinning Rules';
$jsform_set['noticebox_content'] = 'Please remember to copy and paste text spinning shortcodes into your templates. Your changes to any rules in this panel will effect all posts using the related shortcodes, do you wish to continue?';?>
<?php csv2post_panel_header( $panel_array );?>

    <?php csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');?>

    Shortcode Name: <input type="text" name="csv2post_shortcodename" size="40" value="" />
    <br /><br />
    Value 1: <input type="text" name="csv2post_textspin_v1" size="60" value="" />
    <br />                
    Value 2: <input type="text" name="csv2post_textspin_v2" size="60" value="" />
    <br />                
    Value 3: <input type="text" name="csv2post_textspin_v3" size="60" value="" />
    <br />
    Value 4: <input type="text" name="csv2post_textspin_v4" size="60" value="" />
    <br />
    Value 5: <input type="text" name="csv2post_textspin_v5" size="60" value="" />
    <br />
    Value 6: <input type="text" name="csv2post_textspin_v6" size="60" value="" />
    <br />
    Value 7: <input type="text" name="csv2post_textspin_v7" size="60" value="" />
    <br />
    Value 8: <input type="text" name="csv2post_textspin_v8" size="60" value="" />

    <?php 
    // if more fields are added, must update functions like this one csv2post_shortcode_textspinning_random as they expect 8
    ?>
    
    <br />
                                                 
    <?php
    // add the javascript that will handle our form action, prevent submission and display dialogue box
    csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);

    // add end of form - dialogue box does not need to be within the <form>
    csv2post_formend_standard('Submit',$jsform_set['form_id']);
                 
    csv2post_jquery_form_prompt($jsform_set);?>

<?php csv2post_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'deleterandomvalueshortcodes';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Delete Advanced Random Value Shortcodes *global panel*');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Delete any of the advanced random value shortcodes previously created');
$panel_array['panel_help'] = __('Warning, if you delete advanced shortcodes that have already been used in post content. 
The shortcode will fail, the shortcode will be displayed as the raw shortcode. This is a standard behaviour by 
Wordpress if the supporting plugin is no longer active. This this case these advanced shortcodes in Wordpress
CSV Importer require the rules/settings data entered by the user to be kept stored in the Wordpress database.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,true);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);     
$jsform_set['dialoguebox_title'] = 'Delete Text Spinning Rules';
$jsform_set['noticebox_content'] = 'Deleting advanced text spinning rules that have already been used in post content will cause the shortcodes to be displayed instead of content. Do you still want to continue?';
### TODO:LOWPRIORITY,improve the list of values so when many characters is used each line is clear?>
<?php csv2post_panel_header( $panel_array );?>

    <?php csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form','');?>
    
    <p><strong>WARNING: Do not delete shortcode rules that are in use</strong></p>
    <?php 
    if(!isset($csv2post_textspin_array['randomvalue'])){
        echo '<p><strong>You do not have any advanced random shortcodes setup</strong></p>';    
    }else{
        
        echo '<table class="widefat post fixed">';
        echo '<tr><td width="50"><strong>Delete</strong></td><td width="200"><strong>Shortcode Name</strong></td><td><strong>Shortcode (Ctrl+C then Ctrl+V)</strong></td><td><strong>Values</strong></td></tr>';
        ### TODO:LOWPRIORITY, add a column that indicates when shortcode was last detected in use.
        ### we can register use during processing OR when a post is being opened.
        ### This will allow us to put in some protection and make it easy to keep the list of rules organised.
        
        foreach($csv2post_textspin_array['randomvalue'] as $name => $shortcode){

            echo '<tr><td><input type="checkbox" name="csv2post_shortcodeadvanced_delete[]" value="'.$name.'" /></td><td><strong>'.$name.'</strong></td><td><strong>[csv2post_random_advanced name="'.$name.'"]</strong></td>';
            
            echo '<td>';
            
            foreach($shortcode['values'] as $key => $v){
                echo $v . '<br />';
            }
            
            echo '</td></tr>';   
        }
        
        echo '</table>';
    }
    ?>
                                                 
    <?php
    // add the javascript that will handle our form action, prevent submission and display dialogue box
    csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);

    // add end of form - dialogue box does not need to be within the <form>
    csv2post_formend_standard('Submit',$jsform_set['form_id']);
                 
    csv2post_jquery_form_prompt($jsform_set);?>

<?php csv2post_panel_footer();?>


<?php
### TODO: MEDIUMPRIORITY, add multiple level shortcodes (requested by Tylar Smith tyler@loftopia.com) 
//You can now use multiple levels of spinners, e.g. Your key is {1,2,3{4,5,6{7,8}}} 
//The logic for the example there is to output either 1 2 or 3, and if it's 3 then 4, 5 or 6 will follow, 
//and if it's 6 then 7 or 8 will follow that. Here's all the possibilities for that small example: 
//Your key is 1 Your key is 2 Your key is 34 Your key is 35 Your key is 367 Your key is 368
  ?>

<?php
if($csv2post_is_dev){
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'textspingarraydump';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Text Spin Array Dump');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Create custom shortcodes for copying and pasting into content designs');
$panel_array['panel_help'] = __('A dump of the text spin array. It holds all rules for text spinning.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,true);?>
<?php csv2post_panel_header( $panel_array );?>
<?php
    if(!isset($csv2post_textspin_array) || !is_array($csv2post_textspin_array)){
        echo '<p>Text Spin array variable $csv2post_textspin_array is not set or is not an array so nothing can be displayed at this time.</p>';
    }else{
        echo '<pre>';
        var_dump($csv2post_textspin_array);
        echo '</pre>';        
    }    
csv2post_panel_footer();
}?> 