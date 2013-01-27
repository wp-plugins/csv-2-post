<?php
// renamed from Create Advanced Random Value Shortcodes *global panel*
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'createrandomvalueshortcodes';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Create Advanced Text Spinners *global panel*');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Create custom text spinners that can be used to make short-codes or tokens');
$panel_array['panel_help'] = __('Create a Text Spinner for spinning text randomly or you can
cycle through the values. You can set a delay between spins with the ability to randomise the delay
a little by setting the earliest and latest delay in seconds. 

<h4>Spin Type<h4>
You can allow spinning to be random or cycle through your values. Cycling requires a meta value to be stored
for your post which holds the last value used then the spin simply uses the next value.

<h4>Delay The Spin</h4>
We can use settings to apply a delay to all short-codes. The delay forces a minimum number
of seconds between spins. The spin only happens when the post is opened so it can be triggered long after
the minimum delay has been reached. There is no maximum waiting time for a spin, it would require too much processing in a blog
with thousands of posts. What is important is that spinning does not happen more frequent than we want. 

<h4>Delay Range</h4>
Using the delay range we can randomise the delay applied each time the spin happens. The number of seconds in
the delay will be within your set range. 

<h4>Delay Tracking</h4>
To apply a delay we need to store the last time a spin was done. Then with simple maths we establish if a spin
should be done when a post is opened. The last spin time is stored in post meta with a key i.e.
csv2post_textspindelay_SPINNERNAME with "SPINNERNAME" being the name we give to a new spinner. We need to 
create a spinner again if we wish to use the same one many times in a post and we do not want each instance of
the same short-code to use the same spun text plus delay. If we want multiple short-code to operate in the same
way, plus use the same values, we still need to use the spinner form and create a new spinner but with a different
name.');

$panel_array['help_button'] = csv2post_helpbutton_text(false,true);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);     
$jsform_set['dialogbox_title'] = 'Save Text Spinner';
$jsform_set['noticebox_content'] = 'Please remember to copy and paste text spinner shortcode or token into your templates. Your changes to any rules in this panel will effect all posts using the related spinners, do you wish to continue?';?>
<?php csv2post_panel_header( $panel_array );?>

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?> 
    
    Spinner Name: <input type="text" name="csv2post_shortcodename" size="40" value="" />
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
    <br />
    Value 9: Do you need more fields? Eventually we will use Ajax to allow users to create more
    <?php 
    // if more value fields are added, must update functions like this one csv2post_shortcode_textspinning_random as they expect 8
    ?>
    
    <br />
    
    <h4>Cycle Through Values</h4>
    <script>
    $(function() {
        $( "#csv2post_radios_spinnercycleswitch" ).buttonset();
    });
    </script>

    <div id="csv2post_radios_spinnercycleswitch">
        <input type="radio" id="csv2post_radio_spinnercycleswitch_cycleoon" name="csv2post_radio_spinnercycleswitch" value="on" /><label for="csv2post_radio_spinnercycleswitch_cycleoon">Cycling On</label>    
        <input type="radio" id="csv2post_radio_spinnercycleswitch_cycleoff" name="csv2post_radio_spinnercycleswitch" value="off" /><label for="csv2post_radio_spinnercycleswitch_cycleoff">Cycling Off</label>
    </div>          
    
    <h4>Spin Delay Range</h4>
    <p>Set to 0 - 0 for no delay and no delay monitoring by creating a meta value per post</p> 
    <?php ### TODO:LOWPRIORITY, create setting for max spin delay so user can increase the default on the bar ?>
    <?php ### TODO:LOWPRIORITY, display how many hours the seconds total to while user is sliding ?>
    <?php ### TODO:MEDIUMPRIORITY, put min and max into different fields ?>
    <?php ### TODO:MEDIUMPRIORITY, update slider bar when user edits fields manually ?>       
    <script>
    $(function() {
        $( "#csv2post_increment_slider_spinnerdelay" ).slider({
            range: true,
            min: 0,
            max: 86400,
            values: [ 0, 1440 ],
            slide: function( event, ui ) {
                $( "#csv2post_increment_range_spinnerdelay" ).val( "" + ui.values[ 0 ] + " - " + ui.values[ 1 ] );
            }
        });
        $( "#csv2post_increment_range_spinnerdelay" ).val( "" + $( "#csv2post_increment_slider_spinnerdelay" ).slider( "values", 0 ) +
            " - " + $( "#csv2post_increment_slider_spinnerdelay" ).slider( "values", 1 ) );
    });
    </script>

    <div id="csv2post_increment_slider_spinnerdelay"></div>  
        
    <p>
        <input type="text" name="csv2post_increment_range_spinnerdelay" id="csv2post_increment_range_spinnerdelay" style="border:0; color:#f6931f; font-weight:bold;" /> (seconds)
    </p>
    
    <h4>Re-spin Tokens</h4>
    <p>Tokens insert text to the content in database rather than content having short-codes. CSV 2 POST
    still allows a re-spin and it is done through the plugins schedule system. If you do not plan to use
    this spinner in the token form, you can ignore this setting.</p>
    <script>
    $(function() {
        $( "#csv2post_radios_spinnercycle_respintokens" ).buttonset();
    });
    </script>

    <div id="csv2post_radios_spinnercycle_respintokens">
        <input type="radio" id="csv2post_radio_spinner_token_respin_on" name="csv2post_radio_spinner_tokenrespinswitch" value="on" /><label for="csv2post_radio_spinner_token_respin_on">Token Re-Spin On</label>    
        <input type="radio" id="csv2post_radio_spinner_token_respin_off" name="csv2post_radio_spinner_tokenrespinswitch" value="off" /><label for="csv2post_radio_spinner_token_respin_off">Token Re-Spin Off</label>
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
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'deleterandomvalueshortcodes';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Your Advanced Text Spinners *global panel*');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Delete any text spinner');
$panel_array['panel_help'] = __('Deleting a text spinner in use by posts will leave the short-code or
token as it is seen in your template, in the live content itself. If you wish to remove CSV 2 POST from your
blog but allow the short-codes to operate please contact us. We can arrange functions to be added to your theme or
a lighter plugin that continues to operate the short-codes.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,true);
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);     
$jsform_set['dialogbox_title'] = 'Delete Text Spinners';
$jsform_set['noticebox_content'] = 'Deleting advanced text spin rules that have already been used in post content will cause the shortcodes to be displayed instead of content. Do you still want to continue?';
### TODO:LOWPRIORITY,improve the list of values so when many characters is used each line is clear?>
<?php csv2post_panel_header( $panel_array );?>

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?> 
   
    <?php 
    ### TODO:MEDIUMPRIORITY, when deleting a shortcode, do a search on posts created by CSV 2 POST to determine if the shortcode is in use
    
    ### TODO:MEDIUMPRIORITY, provide a button for user to click to establish which shortcodes are in use, indicate it on this panel and provide button here also

    if(!isset($csv2post_textspin_array['spinners'])){
        echo '<p><strong>You do not have any advanced text spinners setup</strong></p>';    
    }else{
        
        echo '<table class="widefat post fixed">';
        echo '<tr><td width="50"><strong>Delete</strong></td><td width="180"><strong>Shortcode Name</strong></td><td><strong>Shortcode (Ctrl+C then Ctrl+V)</strong></td><td><strong>Values</strong></td></tr>';
         
        foreach($csv2post_textspin_array['spinners'] as $name => $shortcode){
        
            // build the short-code
            $the_shortcode = '[csv2post_spinner_advanced name="'.$name.'"]'; 
                        
            // display short-code
            echo '<tr>
                <td>
                    <input type="checkbox" name="csv2post_shortcodeadvanced_delete[]" value="'.$name.'" />
                </td>
                <td>
                    <strong>'.$name.'</strong>
                </td>
                <td>
                    <strong>'.$the_shortcode.'</strong>
                </td>';
            
            echo '<td>';
            
            foreach($shortcode['values'] as $key => $v){
                echo $v . '<br />';
            }
            
            echo '</td></tr>';
            
        }
        
        echo '</table>';
    }
    
 
    csv2post_n_incontent('Deleting a shortcode in use will leave the shortcode
    itself in your live post content. Contact us if you would like to remove CSV 2 POST
    but continue using the short-codes in existing posts. We can create a lighter plugin 
    or add functions to your theme.','warning','Small','Delete With Care');   
    ?>
                                                 
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
### TODO: MEDIUMPRIORITY, add multiple level shortcodes (requested by Tylar Smith tyler@loftopia.com) 
//You can now use multiple levels of spinners, e.g. Your key is {1,2,3{4,5,6{7,8}}} 
//The logic for the example there is to output either 1 2 or 3, and if it's 3 then 4, 5 or 6 will follow, 
//and if it's 6 then 7 or 8 will follow that. Here's all the possibilities for that small example: 
//Your key is 1 Your key is 2 Your key is 34 Your key is 35 Your key is 367 Your key is 368
?>

<h1>Using Spinners</h1>

<?php 
csv2post_n_incontent('Please use a Spinner (token or short-code) once in your content unless your
happy for the same value to be inserted more than once. Right now CSV 2 POST does not count the number of
spinner in use and ensure each one spins a different value. This is slightly more complex than most people need
but less us know if you do need it.','warning','Small','Use Spinners Once');

csv2post_n_incontent('Use the spinner names in the list above to generate random values
during post creation. This method does not change the value during page refresh like the
shortcode method does. This inserts a permanent value to your content. <br /><br />
To do this simply add textspin#NAME#textspin to your content template. Replace "NAME" with the name
of your shortcode below.','info','Small','Tokens: One Time Spin Method');

csv2post_n_incontent('Activate the Re-Spin setting when creating a Spinner if you plan to use it as
a token and want re-spin. You should fully understand the limits of this feature added 21st January 2013
before using it. Spinners like the token method are normally done once during post creation. A value
is spun and injected into the posts content. This is the case with our tokens however we also have a system
in place to re-spin the value. It is not without flaw if not used correctly. All spin values must be unique
among the full content body, else more than just the original spun text will be replaced during re-spin. 
Individual words are not usually suitable, even 2-3 words may be problematic. We are considering a way around
this. Please let us know if you would like this ability to get better.
<br /><br />
<strong>Do the same as explained for One Time Spin Method, other than activating the Re-spin setting. The
difference is that the re-spin setting will cause a meta value (custom field) to be added to your post to track
the last value spun. Meta key is something like csv2post_spinval_SPINNERNAME.</strong>','info','Small','Tokens: Re-spin Method');

csv2post_n_incontent('In this method we add our randomised values to the short-code
itself in our content template. This short-code is lighter for Wordpress and CSV 2 POST to handle
than the advanced method but does not allow the growing range of abilities the
advanced short-code. If you do not need advanced settings, we recommend this ability which uses
smaller functions and less processing during spin.<br /><br />
<strong>Example:</strong> [csv2post_random_basic values="red,blue,green,purple,pink,orange"]','info','Small','Short-Codes: Basic Method');

csv2post_n_incontent('This example is much like the example above with the values attribute. However
this one has the values stored in CSV 2 POST settings and goes fishing there for a random value (or cycled value
if the setting is applied). This method allows us to edit our values with the change being instant to all
posts using the short-code.<br /><br />
<strong>Example: </strong> [csv2post_spinner_advanced name="Colors"]','info','Small','Short-Codes: Advanced Method');
?>

<?php
if($csv2post_is_dev){
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'textspingarraydump';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Text Spin Array Dump');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Create custom shortcodes for copying and pasting into content designs');
$panel_array['panel_help'] = __('A dump of the text spin array. It holds all rules for text spinning.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,true);?>
<?php csv2post_panel_header( $panel_array );?>
<?php
    if(!isset($csv2post_textspin_array) || !is_array($csv2post_textspin_array)){
        echo '<p>Text Spin array variable $csv2post_textspin_array is not set or is not an array so nothing can be displayed at this time.</p>';
    }else{
        csv2post_var_dump($csv2post_textspin_array);        
    }    
csv2post_panel_footer();
}?> 
