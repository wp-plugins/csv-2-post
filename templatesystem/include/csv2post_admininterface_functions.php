<?php
function csv2post_page_toppage(){require_once( WTG_C2P_DIR.'pages/pagemain/csv2post_main.php' );}
function csv2post_page_data(){require_once( WTG_C2P_DIR.'pages/data/csv2post_main_data.php' );}
function csv2post_page_projects(){require_once( WTG_C2P_DIR.'pages/projects/csv2post_main_projects.php' );}                
function csv2post_page_creation(){require_once( WTG_C2P_DIR.'pages/creation/csv2post_main_creation.php' );}
function csv2post_page_install(){require_once( WTG_C2P_DIR.'pages/install/csv2post_main_install.php' );}
function csv2post_page_more(){require_once( WTG_C2P_DIR.'pages/more/csv2post_main_more.php' );}

/**
* Wordpress navigation menu
*/
function csv2post_admin_menu(){
   global $csv2post_mpt_arr,$wtgtp_homeslug,$csv2post_pluginname,$csv2post_is_installed,$csv2post_is_free;
     
   $n = $csv2post_pluginname;

    // if file version is newer than install we display the main page only but re-label it as an update screen
    // the main page itself will also change to offer plugin update details. This approach prevent the problem with 
    // visiting a page without permission between installation
    $installed_version = csv2post_WP_SETTINGS_get_version();                
    global $csv2post_currentversion;
  
    if(!$csv2post_is_installed && !isset($_POST['csv2post_plugin_install_now'])){   
       
        // if plugin not installed
        add_menu_page(__('Install',$n.'install'), __('CSV 2 POST Install','home'), 'administrator', 'csv2post', 'csv2post_page_toppage' );
        
    }elseif(isset($csv2post_currentversion) 
    && isset($installed_version) 
    && $installed_version != false
    && $csv2post_currentversion > $installed_version 
    && !isset($_POST['csv2post_plugin_update_now'])){
        
        // if $installed_version = false it indicates no installation so we should not be displaying an update screen
        // update screen will be displayed after installation submission if this is not in place
        
        // main is always set in menu, even in extensions main must exist
        add_menu_page(__('Update',$n.'update'), __('CSV 2 POST Update','home'), 'administrator', 'csv2post', 'csv2post_page_toppage' );
        
    }else{

        // main is always set in menu, even in extensions main must exist
        add_menu_page(__($csv2post_mpt_arr['menu']['main']['title'],$n.$csv2post_mpt_arr['menu']['main']['slug']), __($csv2post_mpt_arr['menu']['main']['menu'],'home'), $csv2post_mpt_arr['menu']['main']['permissions']['defaultcapability'], $n, 'csv2post_page_toppage' ); 

        // loop through sub-pages
        foreach($csv2post_mpt_arr['menu'] as $k => $a){

            // skip none page values such as ['arrayinfo']
            if($k != 'arrayinfo'){
                // skip main page (even extensions use the same main page file but the tab screens may be customised
                if($csv2post_is_free && $a == 'beta' || $k == 'main'){
                    // page is either for paid edition only or is added to the menu elsewhere    
                }else{
                    // if ['active'] is set and not equal to false, if not set we assume true   
                    if(!isset($csv2post_mpt_arr['menu'][$k]['active']) || isset($csv2post_mpt_arr['menu'][$k]['active']) && $csv2post_mpt_arr['menu'][$k]['active'] != false){
                        $required_capability = csv2post_WP_SETTINGS_get_page_capability($k);    
                        add_submenu_page($n, __($csv2post_mpt_arr['menu'][$k]['title'],$n.$csv2post_mpt_arr['menu'][$k]['slug']), __($csv2post_mpt_arr['menu'][$k]['menu'],$n.$csv2post_mpt_arr['menu'][$k]['slug']), $required_capability, $csv2post_mpt_arr['menu'][$k]['slug'], 'csv2post_page_' . $k);
                    }
                }
            }

        }// end page loop
   }
}

/**
* Displays a table of csv2post_option records with ability to view their value or delete them

* @todo LOWPRIORITY, allow output of specific types of options then make use of this on the Un-Install screen
* @param boolean $form true adds checkbox object to each option record (currently used on uninstall panel) 
*/
function csv2post_list_optionrecordtrace($form = false,$size = 'Small',$optiontype = 'all'){
    
    // first get all records that begin with csv2post_
    $csv2postrecords_result = csv2post_WP_SQL_options_beginning_with('csv2post_');
    $counter = 1;
    foreach($csv2postrecords_result as $key => $option ){
        
        if($form){
            $form = '<input type="checkbox" name="csv2post_deleteoptions_array[]" value="'.$option.'" />';
        }
        
        echo csv2post_notice($form . ' ' . $counter . '. ' . $option,'success',$size,'','','return');
        
        ++$counter;
    }
}

function csv2post_navigation_jquery($thepagekey){    
    global $csv2post_is_activated,$csv2post_is_installed,$csv2post_mpt_arr,$csv2post_projectslist_array;?>

    <?php 
    // vertical tab menu CSS
    // TODO:LOWPRIORITY, put this CSS into .css file and provide option for it providing it is ready
    if($csv2post_mpt_arr['menu'][$thepagekey]['vertical'] === true){?>

        <style> 
        #csv2post_maintabs {
            position: relative;
            padding-left: 10em;
        }
        #csv2post_maintabs .ui-tabs-nav {
            position: absolute;
            left: 0.25em;
            top: 0.25em;
            bottom: 0.25em;
            width: 10em;
            padding: 0.2em 0 0.2em 0.2em;
        }
        #csv2post_maintabs .ui-tabs-nav li {
            right: 1px;
            width: 100%;
            border-right: none;
            border-bottom-width: 1px !important;
            border-radius: 4px 0px 0px 4px;
            -moz-border-radius: 4px 0px 0px 4px;
            -webkit-border-radius: 4px 0px 0px 4px;
            overflow: hidden;
        }
        #csv2post_maintabs .ui-tabs-nav li.ui-tabs-selected {
            border-right: 1px solid transparent;
        }
        #csv2post_maintabs .ui-tabs-nav li a {
            float: right;
            width: 100%;
            text-align: right;
        }
        </style>
    <?php }?>       

    <script>
    $(function() {
         $( "#csv2post_maintabs" ).tabs({
            cookie: {
                // store cookie for a day, without, it would be a session cookie
                expires: 1
            },
            select: function(event, ui){
              window.location = ui.tab.href;
            }
        });       
    });
    </script>
                
    <div id="csv2post_maintabs">
        <?php 
        ##########################################################
        #                                                        #
        #          ADD HEADERS FIRST not currently in use        #
        #                                                        #
        ##########################################################
        if($csv2post_mpt_arr['menu'][$thepagekey]['headers'] == true){

            foreach($csv2post_mpt_arr['menu'][$thepagekey]['tabs'] as $tab => $values){

                $pageslug = $csv2post_mpt_arr['menu'][$thepagekey]['slug'];
                $tabslug = $csv2post_mpt_arr['menu'][$thepagekey]['tabs'][$tab]['slug'];
                $tablabel = $csv2post_mpt_arr['menu'][$thepagekey]['tabs'][$tab]['label'];   

                if( csv2post_menu_should_tab_be_displayed($thepagekey,$tab) ){
          
                }
            }
        }?>       
    
    <?php 
    // begin building menu - controlled by jQuery
    echo '<ul>'; 

    // loop through tabs - held in menu pages tabs array 
    foreach($csv2post_mpt_arr['menu'][$thepagekey]['tabs'] as $tab=>$values){
                   
        $pageslug = $csv2post_mpt_arr['menu'][$thepagekey]['slug'];
        $tabslug = $csv2post_mpt_arr['menu'][$thepagekey]['tabs'][$tab]['slug'];
        $tablabel = $csv2post_mpt_arr['menu'][$thepagekey]['tabs'][$tab]['label'];   
                                 
        if( csv2post_menu_should_tab_be_displayed($thepagekey,$tab) ){
        
            // change label for first time users on
            if($thepagekey == 'projects' && !isset($csv2post_projectslist_array) || $thepagekey == 'projects' && !is_array($csv2post_projectslist_array)){
                $tablabel = 'Please create your first Post Creation Project...';
            }   
                            
            // default menu build approach
            echo '<li><a href="#tabs-'.$tab.'">' . $tablabel . '</a></li>';                                
        } 
      
        // discontinue loop if no projects exist so that only the first screen is displayed
        if($thepagekey == 'projects' && !isset($csv2post_projectslist_array) || $thepagekey == 'projects' && !is_array($csv2post_projectslist_array)){
            break;
        }    
                            
    }// for each
    
    echo '</ul>';?>    

    <?php  
}

function csv2post_include_form_processing_php(){

    if(isset($_POST['csv2post_post_processing_required']) && $_POST['csv2post_post_processing_required'] == true){

        global $csv2post_debug_mode;
                                      
        // if $csv2post_debug_mode set to true or 1 on CSV2POST.php we dump $_POST
        if($csv2post_debug_mode){
            echo '<h1>$_POST</h1>';
            csv2post_var_dump($_POST);           
            echo '<h1>$_GET</h1>';
            csv2post_var_dump($_GET);    
        }
  
        // set a variable used to skip further form processing functions, importing when using extensions
        $cont = true;

        // include file that checkes $_POST values and takes required actions    
        require_once(WTG_C2P_DIR.'templatesystem/include/csv2post_form_processing.php');
        
        // include extension post processing file, allowing us to keep post processing all together    
        if(WTG_C2P_EXTENSIONS != 'disable' && defined("WTG_C2P_EXT")){  
            require_once(WTG_C2P_CONTENTFOLDER_DIR . '/extensions/'.WTG_C2P_EXT.'/formprocessing.php');
        }         
    }
}

/**
* Checks all critical template system files and returns
* @uses csv2post_jquery_status_list_portletcsv2posts(), for this function the script is placed at the top of the tab file 
* 
* @todo HIGHPRIORITY, apply a table with a small indicator showing files status, keep it simple
*/
function csv2post_templatefiles_statuslist(){
    global $csv2post_templatesystem_files;

    foreach( $csv2post_templatesystem_files as $key => $fileitem ){
        
        $path = '';
        $viewedpath = '';          
        $path .= WTG_C2P_DIR . 'templatesystem' . $fileitem['path'] . $fileitem['name'];
        $viewedpath .= WTG_C2P_FOLDERNAME . '/templatesystem' . $fileitem['path'] . $fileitem['name'];
                
        $pointer = ' ';
         
        if($fileitem['extension'] != 'folder'){        
            $path .= '.' . $fileitem['extension'];
            $viewedpath .= '.' . $fileitem['extension'];            
            $pointer = '.'; 
        }

        if(!file_exists($path)){
            
            echo '<h4>Found</h4>';
            echo $fileitem['name'].$pointer.$fileitem['extension'];
            echo $viewedpath; 
            
        }else{

            echo '<h4>Missing</h4>';
            echo $fileitem['name'].$pointer.$fileitem['extension'];
            echo $viewedpath; 

        }  
    }
}

/**
 * Adds Script Start and Stylesheets to the beginning of pages
 */
function csv2post_header_page($pagetitle,$layout){
    global $csv2post_mpt_arr,$csv2post_adm_set,$csv2post_pub_set,$csv2post_currentproject_code,$csv2post_is_free;

    $csv2post_adm_set = csv2post_get_option_adminsettings();  
    
    csv2post_jquery_button();?> 

    <!-- Checkbox Hide Show Content Script -->
    <script language="javascript">
    function toggle(divId) {
        var divArray = document.getElementsByTagName("div");
        for(i = 0; i < divArray.length; i++){
            if(divArray[i].className == divId){
                if(divArray[i].style.display != 'none'){
                    divArray[i].style.display = 'none';
                }else{
                    divArray[i].style.display = '';
                }
            }
        }
    }
    </script>

    <div class="wrap">

        <?php       
        csv2post_persistentnotice_output('global');
        
        // decide if user is probably activating for the first time and display message accordingly
        csv2post_first_activation_check();?>
    
        <div id="icon-options-general" class="icon32"><br /></div>
        <h2><?php echo $pagetitle;?></h2>

        <?php 
        // admin triggered automation
        csv2post_admin_triggered_automation();  

        // check existing plugins and give advice or warnings
        csv2post_plugin_conflict_prevention();
                 
        // display form submission result notices
        csv2post_notice_output();
        
        // display persistent notices
        csv2post_persistentnotice_output('page',$_GET['page']);?>
        
        <?php     
        // process global security and any other types of checks here such such check systems requirements, also checks installation status
        $csv2post_requirements_missing = csv2post_check_requirements(true);?>

        <div class="postbox-container" style="width:99%">
            <div class="metabox-holder">
                <div class="meta-box-sortables"><?php
}

/**
* Displays persistent messages.
* The parameters allow filtering to display notices in their intended parts of the interface.
* 
* @param mixed $placement_type global OR page OR screen OR panel
* @param mixed $placement_specific page slug OR screens tab number OR panel id
* @param string $pageid used with screen number, $placement_specific is the screen number
* 
* When $placement_type is global, all other parameteres are false
*/
function csv2post_persistentnotice_output($placement_type,$placement_specific = false,$pageid = false){
    global $csv2post_persistent_array;

    if(!is_array($csv2post_persistent_array) || !isset($csv2post_persistent_array['notifications'])){
        return false;
    }   

    foreach($csv2post_persistent_array['notifications'] as $key => $n){
        if($placement_type == $n['placement_type'] && $placement_specific == $n['placement_specific'] && $pageid == $n['pageid']){
            echo csv2post_persistentnotice_display($n['type'],$n['helpurl'],$n['size'],$n['title'],$n['message'],true,$n['id']);
        }
    }
}

/**
* Returns the current projects name as entered by
*/
function csv2post_get_current_project_name(){
    global $csv2post_currentproject_code,$csv2post_projectslist_array;
    if(!isset($csv2post_projectslist_array[$csv2post_currentproject_code]['name'])){
        return 'No Current Project';
    }else{
        return $csv2post_projectslist_array[$csv2post_currentproject_code]['name'];
    }   
}

/**
* Find if a current project is set or not.
* Works using the project list, if a project is removed from project list then we consider it not available.
* 
* @return boolean 
*/
function csv2post_is_projectset(){
    global $csv2post_currentproject_code,$csv2post_projectslist_array;
    if(!isset($csv2post_projectslist_array[$csv2post_currentproject_code]['name'])){
        return false;
    }else{
        return true;
    }     
}

/**
*  Returns current job name or string indicating no current job if none 
*/
function csv2post_get_current_job_name(){
    global $csv2post_currentjob_code,$csv2post_job_array;
    if(!isset($csv2post_job_array['name'])){
        return 'No Current Job';
    }else{
        return $csv2post_job_array['name'];
    }    
}

/**
* Uses installation and activation state checkers to determine if the plugin
* 1. is being activated in Wordpress
* and
* 2. it is the FIRST time it is being activated (due to no trace of previous installation)
*/
function csv2post_first_activation_check(){
    ### TODO:HIGHPRIORITY, use  csv2post_was_installed  then display message according to result
}

/**
 * Calls wtgtp_jquery_opendialog (with close button)
 * 
 * Intended use is to display information, tutorial video etc
 *
 * @param array
 */
function csv2post_helpbutton_closebox($panel_array){

     extract( shortcode_atts( array(
    'panel_name' => 'invalidpanelname',
    'panel_number' => 'invalidpanelnumber',
    'panel_title' => 'Title Not Found',
    'pageid' => 'invalidpageid',
    'tabnumber' => 'invalidtabnumber',
    'panel_id' => 'invalidpanelid',    
    'panel_intro' => 'No Intro Text Found',
    'panel_help' => 'No Help Text Found',
    'panel_icon' => 'invalid-image-or-image-not-yet-created-notice.png',
    'panel_url' => 'http://www.csv2post.com/support',
    'help_button' => 'Help' 
    ), $panel_array ) );   
               
    // call jquery for dialog on button press
    csv2post_jquery_opendialog_helpbutton($panel_number,$panel_intro,$panel_title,$panel_help,$panel_icon,$panel_name,$panel_url);?>
                                  
    <!-- dialog div, displayed when help button clicked -->
    <div id="csv2post_helpbutton-<?php echo $panel_number;?>" title="<?php echo $panel_title;?>">
        <p style="font-size: 16px;"><?php echo $panel_help;?></p>
    </div> 
    
    <!-- help button -->
    <div class="jquerybutton">
        <button id="csv2post_opener<?php echo $panel_number;?>"><?php echo $help_button;?></button> <?php echo $panel_intro;?>  
    </div>
    
    <?php
    //  BOOKMARK BUTTON FORM
    // adds the current tab as a box on the main page under bookmarks tab
    // TODO: HIGHPRIORITY, complete this form submission, it must update the main page bookmarks
    csv2post_formstart_standard(csv2post_create_formname($panel_name,'_bookmark'),csv2post_create_formid($panel_name,'_bookmark'),'post','csv2post_form','');
    csv2post_hidden_form_values($panel_number,$pageid,$panel_name,$panel_title,$panel_number);
    echo '<input type="hidden" id="'.WTG_C2P_ABB.'hidden_bookmarkrequest" name="'.WTG_C2P_ABB.'hidden_bookmarkrequest" value="'.$tabnumber.'">';    
    echo '</form>';    
}

/**
 * Displays author and adds some required scripts
 */
function csv2post_footer(){?>
 
                    </div><!-- end of tabs - all content must be displayed before this div -->   
                </div><!-- end of post boxes -->
            </div><!-- end of post boxes -->
        </div><!-- end of post boxes -->
    </div><!-- end of wrap - started in header -->

    <script type="text/javascript">
        // <![CDATA[
        jQuery('.postbox div.handlediv').click( function() { jQuery(jQuery(this).parent().get(0)).toggleClass('closed'); } );
        jQuery('.postbox h3').click( function() { jQuery(jQuery(this).parent().get(0)).toggleClass('closed'); } );
        jQuery('.postbox.close-me').each(function(){
        jQuery(this).addClass("closed");
        });
        //-->
     </script><?php
}

/**
* Easy Configuration Questions
* 
* @link http://www.erichynds.com/jquery/jquery-ui-multiselect-widget/
*/
function csv2post_easy_configuration_questionlist_demo(){
    global $csv2post_easyquestions_array;
             
    // count number of each type of question added for adding ID value to script
    $singles_created = 0;// count number of single answer questions added (radio button)
    $multiple_created = 0;
    $text_created = 0;
    $slider_created = 0;
    $noneactive = 0; 
            
    foreach($csv2post_easyquestions_array as $key => $question){
        
        if($question['active'] != true){
        
            ++$slider_created;
            
        }else{
                
            if($question['type'] == 'single'){
                $optionlist = '';
                foreach($question['answers'] as $key => $optanswer){
                    $optionlist .= '<option value="'.$optanswer['value'].'"> '.$optanswer['text'].' </option> ';     
                } 
           
                echo csv2post_notice($question['question'] . ' ' . csv2post_link('?',$question['helpurl'],'','_blank','','return','Click here to get more help for this question') .'
                <p> 
                    <select id="csv2post_single'.$singles_created.'" title="Please click on a single option" multiple="multiple" name="example-basic" class="csv2post_multiselect_menu">
                        '.$optionlist.'
                    </select>
                </p>','question','Small','','','return');?>

                <?php ++$singles_created;
                
            }elseif($question['type'] == 'multiple'){
                // build list of option values
                $opt_array = explode(",", $question['answers']);
                $optionlist = '';
                foreach($opt_array as $key => $optanswer){
                    $optionlist .= '<option value="'.$optanswer.'"> '.$optanswer.' </option> ';     
                } 
                             
                echo csv2post_notice($question['question'] . ' ' . csv2post_link('?',$question['helpurl'],'','_blank','','return','Click here to get more help for this question') .'
                <p> 
                    <select id="csv2post_multiple'.$multiple_created.'" title="You may select multiple options" multiple="multiple" name="example-basic" class="csv2post_multiselect_menu">
                        '.$optionlist.'
                    </select>
                </p>','question','Small','','','return');?>
                                
                <?php ++$multiple_created;
                
            }elseif($question['type'] == 'text'){?>
                
                <script>
                $(function() {
                    
                        <?php
                        $opt_array = explode(",", $question['answers']);
                        $optionlist = 'var availableTags = [';
                        $first = true;
                        foreach($opt_array as $key => $optanswer){
                            if($first == false){$optionlist .= ',';} 
                            $optionlist .= '"'.$optanswer.'"';
                            $first = false;   
                        }
                        $optionlist .= '];';
                        echo $optionlist;?>
                    
                    $( "#<?php echo WTG_C2P_ABB . 'text'.$text_created;?>" ).autocomplete({
                        source: availableTags
                    });
                });
                </script>

                <?php  
                echo csv2post_notice($question['question'] . ' ' . csv2post_link('?',$question['helpurl'],'','_blank','','return','Click here to get more help for this question') .'
                <div class="ui-widget">
                    <p>
                        <label for="csv2post_text'.$text_created .'">Tags: </label>
                        <input id="csv2post_text'.$text_created .'" />
                    </p>
                </div>','question','Small','','','return');?>

                <?php ++$text_created;
            }elseif($question['type'] == 'slider'){?>

                <style>
                #demo-frame > div.demo { padding: 10px !important; };
                </style>
                <script>
                $(function() {
                    $( "#<?php echo WTG_C2P_ABB;?>slider-range-min<?php echo $slider_created;?>" ).slider({
                        range: "min",
                        value: 20,
                        min: 1,
                        max: 5000,
                        slide: function( event, ui ) {
                            $( "#amount<?php echo $slider_created;?>" ).val( "" + ui.value );
                            //                   ^ prepend value
                        }
                    });
                                      
                    $( "#amount<?php echo $slider_created;?>" ).val( "" + $( "#csv2post_slider-range-min<?php echo $slider_created;?>" ).slider( "value" ) );
                    //                   ^ prepend value
                });
                </script>

                <?php  
                echo csv2post_notice($question['question'] . ' ' . csv2post_link('?',$question['helpurl'],'','_blank','','return','Click here to get more help for this question') .'
                <p> 
                    <div id="csv2post_slider-range-min'. $slider_created .'"></div> 
                </p>
                <p>
                    <label for="amount'. $slider_created .'">Maximum price:</label>
                    <input type="text" id="amount'. $slider_created .'" style="border:0; color:#f6931f; font-weight:bold;" />
                </p>','question','Small','','','return');
                
                ++$slider_created;
            }
        }//
    }// end for each question
        
    // output total number of questions if developer information active 
    $csv2post_is_dev = true;// ### TODO:HIGHPRIORITY, change this to the global   
    if($csv2post_is_dev){
        
        echo '<h4>Total Questions</h4>';
        echo '<p>';
        $total = $singles_created + $multiple_created + $text_created + $slider_created;
        echo 'All Questions: '.$total;// count number of single answer questions added (radio button)
        echo '<br />';                       
        echo 'Single Answer Questions: '.$singles_created;// count number of single answer questions added (radio button)
        echo '<br />';
        echo 'Multiple Answer Questions: '.$multiple_created;
        echo '<br />';
        echo 'Text Answer Questions: '.$text_created;
        echo '<br />';
        echo 'Slider Questions:'.$slider_created; 
        echo '</p>';  
        echo '<br />';
        echo 'Inactive Questions:'.$noneactive; 
        echo '</p>';  
         
    }    
}

/**
* Displays notice regarding giving log files status - used to create a list
* 
* @param mixed $logtype
* 
* @todo add delete log file button for log files that exist
*/
function csv2post_logfile_exists_notice($logtype){
    global $csv2post_adm_set;
    $fileexists_result = csv2post_logfile_exists($logtype);
    
    if($fileexists_result){
        if(isset($csv2post_adm_set['log_'.$logtype.'_active']) && $csv2post_adm_set['log_'.$logtype.'_active'] == true){
            echo csv2post_notice('Your '.ucfirst($logtype).' Log file exists and is active'.
            csv2post_formstart_standard('csv2post_activatelogfile_'.$logtype,'none','post','').'
            <button class="button" name="csv2post_deletelogfile">Delete</button>
            <button class="button" name="csv2post_disablelogfile">Disable</button>
            <button class="button" name="csv2post_viewlogfile">View</button>                        
            <input type="hidden" name="csv2post_logtype" value="'.$logtype.'">
        </form>', 'success', 'Small', false,'','return');
        }else{
            echo csv2post_notice('Your '.ucfirst($logtype).' Log file exists but is not active'.
            csv2post_formstart_standard('csv2post_activatelogfile_'.$logtype,'none','post','').'
            <button class="button" name="csv2post_deletelogfile">Delete</button>            
            <button class="button" name="csv2post_activatelogfile">Activate</button>
            <button class="button" name="csv2post_viewlogfile">View</button>            
            <input type="hidden" name="csv2post_logtype" value="'.$logtype.'">
        </form>', 'info', 'Small', false,'','return');
        }
    }elseif(!$fileexists_result){
        echo csv2post_notice('Your '.ucfirst($logtype).' Log file does not exist'.
            csv2post_formstart_standard('csv2post_createlogfile_'.$logtype,'none','post','').'
            <button class="button" name="csv2post_createlogfile">Create</button>
            <input type="hidden" name="csv2post_logtype" value="'.$logtype.'">        
        </form>', 'warning', 'Small', false,'','return');
    }
}

/**
* Displays the status of the content folder with buttons to delete or create the folder
* 
* @param mixed $logtype
*/
function csv2post_contentfolder_display_status(){
    
    $contentfolder_exists = csv2post_contentfolder_exist();
    
    if($contentfolder_exists){

        echo csv2post_notice('Content folder exists'.
        csv2post_formstart_standard('csv2post_deletecontentfolder_form','none','post','').'
            <button class="button" name="csv2post_contentfolder_delete">Delete</button>                        
        </form>', 'success', 'Small', false,'','return');

    }elseif(!$contentfolder_exists){
        echo csv2post_notice('Content folder does not exist please create it'.
        csv2post_formstart_standard('csv2post_createcontentfolder_form','none','post','').'
            <button class="button" name="csv2post_contentfolder_create">Create</button>        
        </form>', 'error', 'Small', false,'','return');
    }
}

/**
* Checks if content folder has been created or not
* 
* @return boolean false if folder does not exist, true if it does 
*/
function csv2post_contentfolder_exist(){
    return file_exists(WTG_C2P_CONTENTFOLDER_DIR);    
}

/**
 * Retrieves history file, displays it in table
 *
 * @param array $filter_array['logfile']: general,sql,admin,user,error (default is general)
 *
 * @todo Attempt to create log file when it does not exist
 * @todo Add more columns to the log tables
 * @todo change the file names to work from variables, maybe constants but only when each one is active
 */
function csv2post_viewhistory($filter_array){

    // select log file
    if($filter_array['logfile'] == 'general'){$log_file = 'csv2post_log_general.csv';$logtype = 'general';}
    elseif($filter_array['logfile'] == 'sql'){$log_file = 'csv2post_log_sql.csv';$logtype = 'sql';}
    elseif($filter_array['logfile'] == 'admin'){$log_file = 'csv2post_log_admin.csv';$logtype = 'admin';}
    elseif($filter_array['logfile'] == 'user'){$log_file = 'csv2post_log_user.csv';$logtype = 'user';}
    elseif($filter_array['logfile'] == 'error'){$log_file = 'csv2post_log_error.csv';$logtype = 'error';}
    else{$log_file = 'csv2post_log_general.csv';$logtype = 'general';}
                
    // check if file exists
    $logfileexists_result = csv2post_logfile_exists($logtype);

    // if file exists continue
    if(!$logfileexists_result){
        
        echo csv2post_notice('The log file for recording installation entries does not appear to exist. This may be because log recording is not active or
        permissions are preventing the history file being created. This is not an error. 
        <br /><br />
        '.csv2post_formstart_standard('csv2post_createlogfile','none','post','').'
            <button class="button" name="csv2post_createlogfile">Create Log File Now</button>
            <input type="hidden" name="csv2post_createlogfile_1" value="true">
            <input type="hidden" name="csv2post_logtype" value="'.$logtype.'">
        </form>', 'warning', 'Extra', __(ucfirst($filter_array['logfile']) . ' Log File Not Located'),'','return');
        
    }else{
        // include PEAR CSV
        csv2post_pearcsv_include();

        // PEAR CSV reads file and gets configuration
        $logfile_conf = File_CSV::discoverFormat(csv2post_logfilepath($filter_array['logfile']));

        // apply Separator
        $logfile_conf['sep'] = ',';

        #### @todo FOR BETA WE WILL HAVE BASIC DETAILS - ADD MORE DETAILS LATER
        ### @todo MISSING <tr>
        $table_head_start = '<table class="widefat post fixed">';     
        $table_head_start .= '<td width="35"></td><td width="125">Project</td>';
        $table_head_start .= '<td width="35"></td><td width="125">Date</td>';
        $table_head_start .= '<td width="35"></td><td>Action</td></tr>';// from COMMENT column;

        // finish table head
        $tablehead_complete = $table_head_start;

        // visual row number counter - also acts as indicator of number
        $visual_row_number = 1;

        // row loop counter
        $rows_looped = 0;
             
        // loop through records
        // exit if we hit speed profile maximum processing time
        while ( ( $logrow = File_CSV::read(csv2post_logfilepath($filter_array['logfile']), $logfile_conf ) ) ){
            // if on first row we echo table title
            if($rows_looped == 0){
                echo $tablehead_complete;
            }else{
                csv2post_log_table($logrow);
            }++$rows_looped;

        }// end while (looping through log file rows)

        echo '</table>';

    }// end if log file exists
}

/**
* Log File Related, creates a row for log table display using a single giving row
* The row is taking from while loop which uses PEAR CSV functions
* 
* PROJECTNAME,DATE,LINE,FILE,FUNCTION,DUMP,COMMENT,SQLRESULT,SQLQUERY,STYLE,CATEGORY  
* 
* @param array $logrow
*/
function csv2post_log_table($logrow){
    $row = '<td width="35"></td><td width="125">'.$logrow['0'].'</td>';// PROJECTDATE
    $row .= '<td width="35"></td><td width="125">'.$logrow['1'].'</td>';// DATE
    $row .= '<td width="35"></td><td>'.$logrow['6'].'</td>';// ACTION
    $row .= '</tr>';
    echo $row;
}
                                        
/**
 * Display a notice box per option record. Where possible defaults are used. So a failure
 * in these checks does not mean a failure in the plugin, it could indicate that the user wants to
 * use the file version of an array and not store it locally.
 * 
 * @todo HIGHPRIORITY, generate this list based on options array. Make outcome more complex. Indicate if option record or not.
 */
function csv2post_install_optionstatus_list(){

    $admin_settings_array = get_option('csv2post_adminset');
    if(is_array($admin_settings_array)){
        echo csv2post_notice('csv2post_adminset is installed', 'success', 'Small', false,'','return');
    }else{
        echo csv2post_notice('csv2post_adminset not installed properly <a class="button" href="'.csv2post_currenturl().'&test=test">Install Now</a>', 'error', 'Small', false,'','return');
    }

    $public_settings_array = get_option('csv2post_publicset');
    if(is_array($public_settings_array)){
        echo csv2post_notice('csv2post_publicset is installed', 'success', 'Small', false,'','return');
    }else{
        echo csv2post_notice('csv2post_publicset not installed properly <a class="button" href="'.csv2post_currenturl().'&test=test">Install Now</a>', 'error', 'Small', false,'','return');
    } 
}

/**
 * Checks if plugins minimum requirements are met and displays notices if not
 * Checks: Internet Connection (required for jQuery), PHP version, Soap Extension
 * 
 * @todo HIGH PRIORITY check the status of all external files mainly jquery then display warnings i.e.  http://hotlink.jquery.com/jqueryui/jquery-1.6.2.js?ver=3.2.1
 * @todo HIGH PRIORITY begin a system to deal with missing jquery if even possible so that the interface is not unusable
 */
function csv2post_check_requirements($display){
    // variable indicates message being displayed, we will only show 1 message at a time
    $requirement_missing = false;

    // php version
    if(defined("WTG_C2P_PHPVERSIONMINIMUM")){
        if(WTG_C2P_PHPVERSIONMINIMUM > phpversion()){
            $requirement_missing = true;
            if($display == true){
                global $csv2post_plugintitle;
                # TODO:LOWPRIORITY, change this to a persistent notice once system in place to track notices already displayed
                csv2post_notice('The plugin detected an older php version than the minimum requirement which 
                is '.WTG_C2P_PHPVERSIONMINIMUM.'. Wordpress itself also operates better with a later version 
                of php than you are using. Most features will work fine but some important ones will not.',
                'warning','Large',$csv2post_plugintitle . ' Requires PHP '.WTG_C2P_PHPVERSIONMINIMUM);
            }
        }
    }
    
    // soap extension and SoapClient class required for Priority Level Support
    global $csv2post_is_domainregistered,$csv2post_plugintitle;
    if($csv2post_is_domainregistered){
        $extensioninstalled_result = csv2post_is_extensionloaded('soap');
        if(!$extensioninstalled_result){
            $requirement_missing = true;
            if($display == true){
                csv2post_notice('Your server does not have the soap extension loaded. This is required for '.$csv2post_plugintitle.' premium edition and the premium services offered by WebTechGlobal.','error','Extra','Soap Extension Required');
            }
        }else{
            // now confirm SoapClient class exists
            if (!class_exists('SoapClient')) {
                $requirement_missing = true;
                if($display == true){
                    csv2post_notice('SoapClient class does not exist and is required by '.$csv2post_plugintitle.' for the premium edition and premium web services.','error','Extra','SoapClient Class Required');            
                }
            }            
        }
    }
    
    return $requirement_missing;
}

/**
 * Calls wtgtp_jquery_opendialog (no buttons) to apply jQuery to button and display dialog box
 * @param integer $used (number of times function used equals number of buttons and $used acts as an ID)
 * @param string $title (title of the dialog box)
 * @param string $content (content in the dialog box)
 * 
 * @todo check if this function is in use, if not remove it. It should be an depreciated function
 */
function csv2post_helpbutton($used,$intro,$title,$content){
    // call jquery for dialog on button press
    csv2post_jquery_opendialog($used);?>

    <div id="csv2post_dialog<?php echo $used;?>" title="<?php echo $title;?>">
        <p><?php echo $content;?></p>
    </div>

    <!--<div class="jquerybutton">-->
    <div class="jquerybutton">
        <button id="csv2post_opener<?php echo $used;?>">Video Tutorial</button> <?php echo $intro;?>
    </div>

    <?php
    // keep count of number of help buttons used on page
    ++$used;
    return $used;
}

/**
 * Displays RSS feed from Google Feedburner
 * @param unknown_type $feed_slug
 */
function csv2post_feedburner_widget($feed_slug) {
    echo '<script src="http://feeds.feedburner.com/'.$feed_slug.'?format=sigpro" type="text/javascript" ></script><noscript><p>Subscribe to RSS headline updates from: <a href="http://feeds.feedburner.com/'.$feed_slug.'"></a><br/>Powered by FeedBurner</p> </noscript>';
}

/**
 * Adds a widget to thedashboard showing plugins RSS updates
 */
function csv2post_add_dashboard_rsswidget() {
    global $csv2post_plugintitle;
    wp_add_dashboard_widget('wtgtp_rsswidget_dashboard', $csv2post_plugintitle.' Updates', 'csv2post_feedburner_widget');
}

/**
 * Echos file size formatted to suit size and ensures file exists before using formatting function
 * @uses eci_csvfileexists
 * @param path $file_path
 *
 * @todo add function to check file_path exists
 */
function csv2post_displayfilesize($file_path){
   //$exists = eci_csvfileexists(basename($filepath), $pro);
   $exists = true;
   if($exists == true){
      echo csv2post_format_file_size(filesize($file_path));
   }else{
      echo 0;
   }
}

/**
* Builds URL to the Contact screen
* 
*/
function csv2post_contactscreen_url(){
    //return get_admin_url(null,'admin.php?page=csv2post_more&csv2post_tab=tab10_more');   OLD TAB METHOD     
    return get_admin_url(null,'admin.php?page=csv2post_more#tabs-9');// new jquery tabs method
}

/**
 * Add hidden form fields, to help with processing and debugging
 * Adds the csv2post_form_processing_required value, required to call the form validation file
 *
 * @param integer $pageid (the id used in page menu array)
 * @param slug $panel_name (panel name form is in)
 * @param string $panel_title (panel title form is in)
 * @param integer $panel_number (the panel number form is in),(tab number passed instead when this function called for support button row)
 * @param integer $step (1 = confirm form, 2 = process request, 3+ alternative processing)
 */
function csv2post_hidden_form_values($tabnumber,$pageid,$panel_name,$panel_title,$panel_number,$step = 1){
    
    // multiple steps - use this to state a step - argument within form validation will process accordingly
    echo '<input type="hidden" id="csv2post_hidden_tabnumber" name="csv2post_hidden_tabnumber" value="'.$tabnumber.'">';

    // multiple steps - use this to state a step - argument within form validation will process accordingly
    echo '<input type="hidden" id="csv2post_hidden_step" name="csv2post_hidden_step" value="'.$step.'">';

    // Main Page ID - mainly used to aid troubleshooting
    echo '<input type="hidden" id="csv2post_hidden_pageid" name="csv2post_hidden_pageid" value="'.$pageid.'">';

    // Panel Name (slug) - mainly used to aid troubleshooting
    echo '<input type="hidden" id="csv2post_hidden_panel_name" name="csv2post_hidden_panel_name" value="'.$panel_name.'">';

    // Panel Title - used to in output and to aid troubleshooting
    echo '<input type="hidden" id="csv2post_hidden_panel_title" name="csv2post_hidden_panel_title" value="'.$panel_title.'">';

    // Panel Number On Tab File - mainly used to aid troubleshooting
    // also used to pass tab number when being included in support button row
    echo '<input type="hidden" id="csv2post_hidden_panels" name="csv2post_hidden_panels" value="'.$panel_number.'">';
}

/**
 * Builds form middle with jquery dialog, flexible options allow a single action with or without many form objects
 * @link http://www.webtechglobal.co.uk/blog/wordpress/wtg-plugin-template/wtg-pt-jquery-dialogue-form
 * @param array $jqueryform_settings (configuration see: )
 * @param array $formobjects_array (list of form object ID for looping through and adding to dialog)
 * 
 * @todo this function requires the form
 */
function csv2post_jqueryform_singleaction_middle($jsform_set,$formobjects_array){         
    extract( shortcode_atts( array(
    'has_options' => false,
    'pageid' => 0,
    'panel_number' => 0,
    'panel_name' => 'nopanelname',
    'panel_title' => 'No Panel Name',    
    'tab_number' => 'error no tab number passed to csv2post_jqueryform_singleaction_middle()',
    'form_id' => 'csv2post_form_id_default',
    'form_name' => 'csv2post_form_name_default',
    ), $jsform_set ) );

    // add the javascript
    csv2post_jquery_opendialog_confirmformaction($jsform_set,$formobjects_array);
}

/**
 * Used in First Time Install panel, adds accordian items to accordian wrapper for option records
 * @param string $option
 */
function csv2post_accordianitem_optioninstall($option){
    global $wpdb;?>
    <h3><a href="#"><?php echo $option;?> - Wordpress Option</a></h3>
    <div>
        <p>
            <strong>Name: <?php echo $option;?></strong><br /><br />
            <strong>Type: Database Record - Array</strong><br /><br />
            <strong>Location: <?php echo $wpdb->prefix;?>option</strong><br /><br />
        </p>
        <p>If there is an existing record in your <?php echo $wpdb->prefix;?>option table with a key named <?php echo $option;?> then it will not be deleted. If you are installing a newer version than used previously and there are new values required in this option array, they will be added to the existing option record.</p>
    </div><?php
}

/**
* Builds text link, also validates it to ensure it still exists else reports it as broken
* 
* The idea of this function is to ensure links used throughout the plugins interface
* are not broken. Over time links may no longer point to a page that exists, we want to 
* know about this quickly then replace the url.
* 
* @return $link, return or echo using $response parameter
* 
* @param mixed $text
* @param mixed $url
* @param mixed $htmlentities, optional (string of url passed variables)
* @param string $target, _blank _self etc
* @param string $class, css class name (common: button)
* @param strong $response [echo][return]
* 
* @todo prepare function to accept the htmlentities string
* @todo check url type, ensure http etc in place
* @todo capture statistcs on links being clicked to establish how often they are actually used
* @todo can we do a check to ensure the html entities as a valid join to the domain? even just ensuring ? exists in url or apply it using $middle
*/
function csv2post_link($text,$url,$htmlentities = '',$target = '_blank',$class = '',$response = 'echo',$title = ''){
    
    // add ? to $middle if there is no proper join after the domain
    $middle = '';
                             
    // decide class
    if($class != ''){$class = 'class="'.$class.'"';}
    
    // build final url
    $finalurl = $url.$middle.htmlentities($htmlentities);
    
    // check the final result is valid else use a default fault page
    $valid_result = csv2post_validate_url($finalurl);
    
    if($valid_result){

        $link = '<a href="'.$finalurl.'" '.$class.' target="'.$target.'" title="'.$title.'">'.$text.'</a>';

    }else{
        ### @todo log this event
        ### @todo send variables for WTG to log and raise the issue in the admin
        $link = '<a href="http://www.webtechglobal.co.uk/blog/help/invalid-application-link" target="_blank">Invalid Link Please Click Here To Report This</a>';        
    }
    
    if($response == 'echo'){
        echo $link;
    }else{
        return $link;
    }     
}   

/**
* Builds link to google search or WTG AdSense search - Used in help content
* 
* @param mixed $text
* @param mixed $subscription
* @param mixed $string
* 
* @todo make use of adsense for none gold users
*/
function csv2post_google_searchlink($text,$subscription,$string){
                                            
    if($subscription == 'gold'){
        // standard google
        $url = 'http://.google.co.uk/search?q='.$text;    
    }else{
        // adsense google
        ### @todo REVENUE - change to a local url, process google adsense form to a search page
        $url = 'http://.google.co.uk/search?q='.$text;   
    }
    
    csv2post_link($text,$url,'_blank',$string);   
}

/**
* Standard interface response to SOAP faults
* 
* @param string $soapcallfunction, the function name that called soap and cause fault
*/
function csv2post_soap_fault_display($soapcallfunction){
    csv2post_notice('Sorry there was a problem contacting WebTechGlobal Web Services for Wordpress.
    Please report this notice with the following information: SOAP Call Function '.$soapcallfunction.'
    returned "soapfault". I think you for your patience. Please repeat your action again while you wait on a
    response as it may be caused by maintenance on the WebTechGlobal site.','error','Extra','WebTechGlobal Web Service Fault');    
}

/**
* Returns array with common values required for forms that need jQuery dialog etc.
* The default values can be overridden by populating the $jsform_set_override array. 
* 
* @param mixed $pageid
* @param mixed $csv2post_tab_number
* @param mixed $panel_number
* @param mixed $panel_name
* @param mixed $panel_title
* @param array $jsform_set_override, (not yet in use) use to customise the return value, not required in most uses
*/
function csv2post_jqueryform_commonarrayvalues($pageid,$csv2post_tab_number,$panel_number,$panel_name,$panel_title,$jsform_set_override = ''){
    ### TODO:MEDIUMPRIORITY  extract the override values after callign global values
    // $jsform_set_override
    // this is so we can pass the override array for custom settings rather than the default
    $jsform_set = array();
    // http://www.webtechglobal.co.uk/blog/wordpress/wtg-plugin-template/wtg-pt-jquery-dialogue-form 
    $jsform_set['pageid'] = $pageid;
    $jsform_set['tab_number'] = $csv2post_tab_number; 
    $jsform_set['panel_number'] = $panel_number;
    $jsform_set['panel_name'] = $panel_name;
    $jsform_set['panel_title'] = $panel_title;                
    // dialog box, javascript
    $jsform_set['dialogbox_id'] = $panel_name.$panel_number;
    $jsform_set['dialogbox_height'] = 300;// false will remove the height entry from the script
    $jsform_set['dialogbox_width'] = 800;// false will remove the width entry from the script
    $jsform_set['dialogbox_autoresize'] = false;// true or false, overrides width and height 
    // form related
    $jsform_set['form_id'] = csv2post_create_formid($panel_name);
    $jsform_set['form_name'] = csv2post_create_formname($panel_name);                                   
    return $jsform_set;
}
 
/**
* Returns standard formatted form name
* 
* @param string $panel_name
* @param string $specificpurpose, used to append a value, important when multiple forms used in a single panel
*/
function csv2post_create_formname($panel_name,$specificpurpose = ''){
    return 'csv2post_form_name_' . $panel_name . $specificpurpose;    
}   

/**
* Returns a standard formatted form ID
* 
* @param string $panel_name
* @param string $specificpurpose, used to append a value, important when multiple forms used in a single panel 
*/
function csv2post_create_formid($panel_name,$specificpurpose = ''){
    return 'csv2post_form_id_' . $panel_name . $specificpurpose;
}

/**
* Returns MySQL version 
*/
function csv2post_get_mysqlversion() { 
    $output = shell_exec('mysql -V'); 
    preg_match('@[0-9]+\.[0-9]+\.[0-9]+@', $output, $version); 
    return $version[0]; 
}

/**
* Displays a table of the CSV files within the plugins storage paths
* 1. displays some statistics of any matching database tables
* 2. displays the age of files for knowing when a file was last updated
* 
* @todo MEDIUMPRIOTITY, use DataTables with ability to click and view more information plus delete files.
* @todo MEDIUMPRIORITY, a file is caused a blank age result, investigate why it happened when the file was edited then uploaded again 
* @todo HIGHPRIORITY, add column for field count using fgetcsv method (currently only has pear method) this will greatly help determine which method is best         
*/
function csv2post_available_csv_file_list(){
    $available = 0;
 
    if (!is_dir(WTG_C2P_CONTENTFOLDER_DIR)) {
    
        echo csv2post_notice('The content folder does not exist, has it been deleted or move?','error','Small','','','return');
                   
    }else{    
        
        @$opendir_result = opendir( WTG_C2P_CONTENTFOLDER_DIR );
        
        if(!$opendir_result){
            
            echo csv2post_notice($csv2post_plugintitle . ' does not have permission to open the plugins content folder','error','Small','','','return');

        }else{

            echo '
            <table class="widefat post fixed">
                <tr class="first">
                    <td width="175"><strong>Name</strong></td>
                    <td width="80"><strong>Separator (plugin)</strong></td>                    
                    <td width="80"><strong>Separator (pear)</strong></td>
                    <td width="75"><strong>Columns (pear)</strong></td>                    
                    <td width="75"><strong>Rows</strong></td>
                    <td><strong>Size</strong></td>                                                       
                </tr>';  
            
            $filesize_total = 0;
                
            while( false != ( $filename = readdir( $opendir_result ) ) ){
                if( ($filename != ".") and ($filename != "..") ){
                    
                    $fileChunks = explode(".", $filename);
                                      
                    // ensure file extension is csv
                    if( isset( $fileChunks[1] ) && $fileChunks[1] == 'csv'){
                        
                        $file_path = WTG_C2P_CONTENTFOLDER_DIR . '/' . $filename;
                        $thefilesize = filesize($file_path);
                        $filesize_total = $thefilesize;

                        $sep_fget = csv2post_establish_csvfile_separator_fgetmethod($filename,false );                           
                        $sep_PEARCSV = csv2post_establish_csvfile_separator_PEARCSVmethod($filename,false); 
                        
                        echo '
                        <tr>
                            <td>'.$filename.'</td>
                            <td>'.$sep_fget.'</td>                            
                            <td>'.$sep_PEARCSV.'</td>
                            <td>'.csv2post_establish_csvfile_fieldcount_PEAR($filename).'</td>                            
                            <td>'.count(file(WTG_C2P_CONTENTFOLDER_DIR . '/' .$filename)).'</td>
                            <td>'.csv2post_format_file_size($thefilesize).'</td>                                                                                    
                        </tr>';                    
                        
                    }// end if csv
                    
                }// end if $filename = .  
            }// end while    
                 
            echo '</table>';
            
            csv2post_notice_filesizetotal($filesize_total);

            // clear stored values
            clearstatcache();

        }// end $opendir_result
    }         
}

function csv2post_list_csvfiles(){
    $available = 0;
 
    if (is_dir(WTG_C2P_CONTENTFOLDER_DIR)) {  
        
        @$opendir_result = opendir( WTG_C2P_CONTENTFOLDER_DIR );
        
        if($opendir_result){
            
            $counter = 0;

            while( false != ( $filename = readdir( $opendir_result ) ) ){
                
                if( ($filename != ".") and ($filename != "..") ){
                    
                    $fileChunks = explode(".", $filename);
                                      
                    // ensure file extension is csv
                    if( isset( $fileChunks[1] ) && $fileChunks[1] == 'csv'){
                        
                        $status = '';
                        
                        $form = '<input type="checkbox" name="csv2post_deletecsvfiles_array[]" value="'.$filename.'" />';
                        
                        echo csv2post_notice($form . ' ' . $counter . '. ' . $filename,'success','Tiny','','','return');
                        
                        ++$counter;                  
                        
                    }// end if csv
                    
                }// end if $filename = .  
            }// end while    

            // clear stored values
            clearstatcache();

        }// end $opendir_result
    }         
}


/**
* This table will list all CSV files and indicate any problems.
* 1. Separator for fgetcsv and PEAR CSV not matching
*/
function csv2post_csv_files_status_list(){
    $available = 0;
 
    if (!is_dir(WTG_C2P_CONTENTFOLDER_DIR)) {
    
        csv2post_notice('The content folder does not exist, has it been deleted or move?','error','Small','','');
                   
    }else{    
        
        @$opendir_result = opendir( WTG_C2P_CONTENTFOLDER_DIR );
        
        if(!$opendir_result){
            global $csv2post_plugintitle;
            csv2post_notice($csv2post_plugintitle . ' does not have permission to open the plugins content folder','error','Small','','');

        }else{

            echo '
            <table class="widefat post fixed">
                <tr class="first">
                    <td width="175"><strong>Name</strong></td>
                    <td><strong>Status</strong></td>
                    <td><strong>Files Age</strong></td>                                                       
                </tr>';  
            
            $filesize_total = 0;
                
            while( false != ( $filename = readdir( $opendir_result ) ) ){
                if( ($filename != ".") and ($filename != "..") ){
                    
                    $fileChunks = explode(".", $filename);
                                      
                    // ensure file extension is csv
                    if( isset( $fileChunks[1] ) && $fileChunks[1] == 'csv'){
                        
                        $status = '';
                        
                        $file_path = WTG_C2P_CONTENTFOLDER_DIR . '/' . $filename;

                        ### TODO:LOWPRIORITY, display status for when a CSV file is older than the last one used
                        //$filemtime = filemtime(WTG_C2P_CONTENTFOLDER_DIR . '/' .$filename);
                        
                        // if csv file parse methods do not determine the same separator we will display a message
                        $sep_fget = csv2post_establish_csvfile_separator_fgetmethod($filename,false );                           
                        $sep_PEARCSV = csv2post_establish_csvfile_separator_PEARCSVmethod($filename,false); 
                        if($sep_fget != $sep_PEARCSV){
                            $status = 'This files separator needs to be set manually to avoid problems.';    
                        }
                        
                        // determine files age in a human readable way
                        if(phpversion() < '5.3'){
                            $fileage = '';### TODO:MEDIUMPRIORITY,add a PHP 5.2 function for determing file age
                        }else{
                            $filemtime = filemtime(WTG_C2P_CONTENTFOLDER_DIR . '/' .$filename);
                            $fileage =  csv2post_ago( date_create(date(WTG_C2P_DATEFORMAT,$filemtime)),true,true,true,true,true,false);
                        }
                                                           
                        echo '
                        <tr>
                            <td>'.$filename.'</td>
                            <td>'.$status.'</td>
                            <td>'.$fileage.'</td>                                                       
                        </tr>';                    
                        
                    }// end if csv
                    
                }// end if $filename = .  
            }// end while    
                 
            echo '</table>';

            // clear stored values
            clearstatcache();

        }// end $opendir_result
    }         
}

/**
* Adds an 's at the end of a string if pluralize required.
* Requires a count of what the string equals i.e. 2 and apple to make apple's
* 
* @param integer $count
* @param string $text
*/
function csv2post_pluralize( $count, $text ) { 
    return $count . ( ( $count == 1 ) ? ( " $text" ) : ( " ${text}s" ) );
}

/**
* Adds comma to the end of giving string based on what has already been added to the string value. 
*/
function csv2post_commas($originalstring){
    if($originalstring != ' '){$result = $originalstring . ',';return $result;}else{return $originalstring;}    
}
          
/**
* Returns human readable age based on giving file modified date
* @todo                           
*/
function csv2post_get_files_age($time){
               
    //echo date("F d Y H:i:s.", filemtime(WTG_C2P_CONTENTFOLDER_DIR .'/'. $filename));
    
    return '1 Day, 1 Hour, 1 Min, 1 Sec';   
}
    
/**
* Displays a table of all data import jobs. Includes a checkbox column for deleting data import jobs.
* 
* @returns the number of data import jobs found
* @todo LOWPRIORITY, replace table using Data Table script
*/
function csv2post_list_dataimportjobs(){
    global $csv2post_dataimportjobs_array;

    if(!$csv2post_dataimportjobs_array){
        echo '<strong>You do not have any data import jobs</strong><br />';
        return 0;
    }else{
        echo '
        <table class="widefat post fixed">
            <tr class="first">
                <td width="50"><strong>Delete</strong></td>        
                <td width="250"><strong>Job Name</strong></td>
                <td><strong>Job Code</strong></td>                                                          
            </tr>';  

        $totaljobs = 0;
        
        // loop through data import jobs
        foreach($csv2post_dataimportjobs_array as $jobid => $job){

            echo '
            <tr>
                <td> <input type="checkbox" name="csv2post_jobcode_array[]" value="'.$jobid.'" /> </td>        
                <td>'.$job['name'].'</td>
                <td>'.$jobid.'</td>            
            </tr>';   
           
           ++$totaljobs;
        }
        
        if($totaljobs == 0){
        echo '
            <tr>
                <td> <input type="checkbox" name="NA" value="NA" disabled /> </td>        
                <td>Not Applicable</td>
                <td>Not Applicable</td>            
            </tr>';
        }
        
        echo '</table>';
    }
    return $totaljobs;    
}

/**
* Adds the opening divs for panels and help button
* 
* @param array $panel_array
*/
function csv2post_panel_header( $panel_array, $boxintro_div = true ){
    global $csv2post_adm_set;
                         
    // establish global panel state for all panels in plugin, done prior 
    $panel_state = ''; 
    if($panel_state){
        $panel_state = 'closed';    
    }    
          
    // override panel state if $panel_array includes specific state
    if(isset($panel_array['panel_state']) && ($panel_array['panel_state'] == 1 || $panel_array['panel_state'] == 'open')){
        $panel_state = 'open';    
    }elseif(isset($panel_array['panel_state']) && ($panel_array['panel_state'] == 0 || $panel_array['panel_state'] == 'closed')){
        $panel_state = 'closed';
    }?>

    <div id="titles" class="postbox <?php echo $panel_state;?>">
        <div class="handlediv" title="Click to toggle"><br /></div>

        <h3 class="hndle"><span><?php echo $panel_array['panel_title'];?></span></h3>

        <div class="inside">

            <?php if($boxintro_div){?>
            <div class="csv2post_boxintro_div">
                <?php csv2post_helpbutton_closebox($panel_array);?>
            </div>
            <?php }?>
            
            <div class="csv2post_boxcontent_div"><?php
            
                // display persistent notices for the current panel
                csv2post_persistentnotice_output('panel',$panel_array['panel_id']);
}

/**
* Adds closing divs for panels 
*/
function csv2post_panel_footer(){
    echo '</div></div></div>';
}

/**
* Outputs the database tables being used in the giving project.
* Returns a single line, each table name separated by comma 
*/
function csv2post_display_projectstables_commaseparated($project_code){
    $project_array = csv2post_get_project_array($project_code);
    $table_name_string = '';
    $count = 0;
    foreach($project_array['tables'] as $test => $table_name){
        if($count != 0){
            $table_name_string .= ', ';        
        }        
        $table_name_string .= $table_name;
        ++$count;         
    }
    return $table_name_string;       
}

/**
* Displays a checkbox menu holding all existing designs
* @todo CRITICAL, improve the id to be more unique per use
* @todo HIGHPRIORITY, display wtgcsvcontent posts that do not have post type set
*/
function csv2post_display_all_post_contentdesigns_buttonlist(){
    
    $args = array(
        'post_type' => 'wtgcsvcontent',
        'numberposts' => 999,
        'meta_query' => array(
            array(
                'key' => '_csv2post_templatetypes',
                'value' => 'postcontent',
            )        
        )
    );
 
    global $post;
    $myposts = get_posts( $args );

    if(count($myposts) == 0){
        echo 'You do not have any content templates';
    }
        
    foreach( $myposts as $post ){?>
        <div class="jquerybutton">
            <input type='submit' value='<?php echo $post->post_title;?> (<?php echo $post->ID;?>)' name="csv2post_templatename_and_id" />
        </div><?php 
    }; 
}

function csv2post_display_all_post_excerptdesigns_buttonlist(){
   
    $args = array(
        'post_type' => 'wtgcsvcontent',
        'numberposts' => 999,
        'meta_query' => array(
            array(
                'key' => '_csv2post_templatetypes',
                'value' => 'postexcerpt',
            )        
        )
    );
 
    global $post;
    $myposts = get_posts( $args );
    
    if(count($myposts) == 0){
        echo 'You do not have any excerpt templates';
    }
        
    foreach( $myposts as $post ){?>
        <div class="jquerybutton">
            <input type='submit' value='<?php echo $post->post_title;?> (<?php echo $post->ID;?>)' name="csv2post_templatename_and_id" />
        </div><?php 
    }; 
}

function csv2post_display_all_contentdesigns_buttonlist(){
   
    $args = array(
        'post_type' => 'wtgcsvcontent',
        'numberposts' => 999
    );

    global $post;
    $myposts = get_posts( $args );
    
    if(count($myposts) == 0){
        echo 'You do not have any content templates linked in your current project';
    }
        
    foreach( $myposts as $post ){?>
        <div class="jquerybutton">
            <input type='submit' value='<?php echo $post->post_title;?> (<?php echo $post->ID;?>)' name="csv2post_templatename_and_id" />
        </div><?php 
    }; 
}

/**
* Displays list of title templates in the form of jquery buttons
* 
* @todo HIGHPRIORITY, filter out other template types 
*/
function csv2post_display_all_titledesigns_buttonlist(){
   
    $args = array(
        'post_type' => 'wtgcsvtitle',
        'numberposts' => 999
    );

    global $post;
    $myposts = get_posts( $args );
    
    if(count($myposts) == 0){
        echo 'You do not have any title templates linked in your current project';
    }
        
    foreach( $myposts as $post ){?>
        <div class="jquerybutton">
            <input type='submit' value='<?php echo $post->post_title;?> (<?php echo $post->ID;?>)' name="csv2post_templatename_and_id" />
        </div><?php 
    }; 
}

/**
* Displays checkbox buttons for project content templates 
*/
function csv2post_displayproject_templates_buttonlist($form_id,$template_type = 'postcontent'){
    global $csv2post_currentproject_code;
    
    $default_template_id = csv2post_get_default_contenttemplate_id( $csv2post_currentproject_code );
    $current_default_template_text = '';
    
    if($template_type == 'all'){
        // this query does not include template type
        $args = array(
            'post_type' => 'wtgcsvcontent',
            'numberposts' => 999,
            'meta_query' => array(
                array(
                    'key' => 'csv2post_project_id',
                    'value' => $csv2post_currentproject_code,
                )     
            )
        );        
    }else{  
        // this query includes template type
        $args = array(
            'post_type' => 'wtgcsvcontent',
            'numberposts' => 999,
            'meta_query' => array(
                array(
                    'key' => 'csv2post_project_id',
                    'value' => $csv2post_currentproject_code,
                ), 
                array(
                    'key' => '_csv2post_templatetypes',
                    'value' => $template_type,
                )        
            )
        );
    }

    $myposts = get_posts( $args );
    if(count($myposts) == 0){
        echo 'You do not have any of these templates linked in your current project';
    }

    foreach( $myposts as $post ){
        
        if( $post->ID == $default_template_id){
            $current_default_template_text = 'Current Default';    
        }
             
        ?>
        <div class="jquerybutton">
                <input type='submit' value='<?php echo $post->post_title;?> (<?php echo $post->ID;?>) <?php echo $current_default_template_text;?>' name="csv2post_templatename_and_id" />
        </div><?php 
    };
}

/**
* Returns the content of default title template post, the design* 
*/
function csv2post_get_default_titletemplate_design($project_code = false){
    if(!$project_code){global $csv2post_currentproject_code;$project_code = $csv2post_currentproject_code;}
    
    $default_template_id = csv2post_get_default_titletemplate_id( $project_code );

    if(!$default_template_id || $default_template_id == '0'){
        return 'No Default Title Design';
    }else{
        // get wtgcsvtemplate post title
        $template_post = get_post($default_template_id); 
        return $template_post->post_content;        
    }      
}
       
/**
* Displays a list of current projects connected title templates in form of jQuery buttons         
* @param mixed $form_id
*/
function csv2post_displayproject_titletemplates_buttonlist($form_id){
    global $csv2post_currentproject_code;
    
    $default_template_id = csv2post_get_default_titletemplate_id( $csv2post_currentproject_code );
    $current_default_template_text = '';
      
    $args = array(
        'post_type' => 'wtgcsvtitle',
        'numberposts' => 999,
        'meta_query' => array(
            array(
                'key' => 'csv2post_project_id',
                'value' => $csv2post_currentproject_code,
            )
        )
    );

    $myposts = get_posts( $args );
    if(count($myposts) == 0){
        echo 'You do not have any title templates linked in your current project';
    }

    foreach( $myposts as $post ){
        
        if( $post->ID == $default_template_id){
            $current_default_template_text = 'Current Default';    
        }
             
        ?>
        <div class="jquerybutton">
                <input type='submit' value='<?php echo $post->post_title;?> (<?php echo $post->ID;?>) <?php echo $current_default_template_text;?>' name="csv2post_templatename_and_id" />
        </div><?php 
    };
} 

/**
* Adds a box to the Content Design edit page. 
*/
function csv2post_add_custom_boxes_contenttemplate() {
    add_meta_box( 
        'csv2post_custombox_templatetype_id',// a unique id of the box being displayed on edit page
        'Template Design Types',// TODO: translate
        'csv2post_custombox_contenttemplatetype',// callback to function that displays html content insie box on page
        'wtgcsvcontent'// post type to display meta box on 
    );
}
        
/**
* Prints html content of custom meta box.
* Displays template type checkboxes.
* 
* @param object $post, Wordpress post object
* @todo HIGHPRIORITY, change the input name and id with proper testing
*/
function csv2post_custombox_contenttemplatetype( $post ) {

    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'csv2post_CSV2POST_noncename' );

    // The actual fields for data entry
    echo '<label for="myplugin_new_field">';
    echo '<strong>Design can be used for the following purposes:</strong>';
    echo '</label> ';

    // get template types - may return an array of values
    $meta_values = get_post_meta($_GET['post'], '_csv2post_templatetypes', false); 

    if(!$meta_values){
        echo '<p>Error: could not establish the content designs purpose</p>';
        return;    
    }

    echo '<ol>';
    
    foreach($meta_values as $key => $type){
               
        switch ($type[0]) {
            case 'postcontent':
                echo '<li>Post/Page Content</li>';
                break;
            case 'customfieldvalue':
                echo '<li>Custom Field Value</li>';
                break;
            case 'categorydescription':
                echo '<li>Category Description</li>';
                break;
            case 'postexcerpt':
                echo '<li>Post Excerpt</li>';
                break;                
            case 'keywordstring':
                echo '<li>Keyword String</li>';
                break;                
            case 'dynamicwidgetcontent':
                echo '<li>Dynamic Widget Content</li>';
                break;               
            case 'seovalue':
                echo '<li>SEO Meta</li>';
                break;                 
        }
    }
    
    echo '</ol>';    
}

/**
* When Content Template Design post type (wtgcsvcontent) is saved, saves our custom data entered in form output by csv2post_custombox_templatetype#
*/
function csv2post_save_postdata_contenttemplate( $post_id ) {
  // if auto-save routine happening, do nothing, also if nonename not set also do nothing else the New Template editor panel will call this
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE || !isset($_POST['csv2post_CSV2POST_noncename']) ){
      return;
  }

  // use plugin nonce name to verify this came from the our screen and with proper authorization (save_post can be triggered at other times)
  if ( !wp_verify_nonce( $_POST['csv2post_CSV2POST_noncename'], plugin_basename( __FILE__ ) ) ){
      return;
  }

  // Check permissions
  if ( !current_user_can( 'edit_post', $post_id ) ){
      return;    
  }

  // we're authenticated: we need to find and save the data

  $mydata = $_POST['myplugin_new_field'];

  ### TODO:CRITICAL
  // Do something with $mydata 
  // probably using add_post_meta(), update_post_meta(), or 
  // a custom table (see Further Reading section below)
}

/**
* When Title Template Design (wtgcsvtitle) post type is saved, saves our custom data entered in form output by csv2post_custombox_templatetype#
*/
function csv2post_save_postdata_titletemplate( $post_id ) {
  // if auto-save routine happening, do nothing, also if nonename not set also do nothing else the New Template editor panel will call this
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE || !isset($_POST['csv2post_CSV2POST_noncename']) ){
      return;
  }

  // use plugin nonce name to verify this came from the our screen and with proper authorization (save_post can be triggered at other times)
  if ( !wp_verify_nonce( $_POST['csv2post_CSV2POST_noncename'], plugin_basename( __FILE__ ) ) ){
      return;
  }

  // Check permissions
  if ( !current_user_can( 'edit_post', $post_id ) ){
      return;    
  }

  // we're authenticated: we need to find and save the data

  $mydata = $_POST['myplugin_new_field'];

  ### TODO:CRITICAL
  // Do something with $mydata 
  // probably using add_post_meta(), update_post_meta(), or 
  // a custom table (see Further Reading section below)
}

/**
* Standard form submission prompt 
*/
function csv2post_jquery_form_prompt($jsform_set){?>
    <!-- dialog box start -->
    <div id="<?php echo $jsform_set['dialogbox_id'];?>" title="<?php echo $jsform_set['dialogbox_title'];?>">
        <?php echo csv2post_notice($jsform_set['noticebox_content'],'question','Small',false,'','return');?>
    </div>
    <!-- dialog box end --> <?php      
} 

/**
 * Tabs menu loader - calls function for css only menu or jquery tabs menu
 * 
 * @param string $thepagekey this is the screen being visited
 */
function csv2post_createmenu($thepagekey){
    global $csv2post_nav_type;
    if($csv2post_nav_type == 'css'){
        csv2post_navigation_css($thepagekey);
    }elseif($csv2post_nav_type == 'jquery'){
        csv2post_navigation_jquery($thepagekey);    
    }elseif($csv2post_nav_type == 'nonav'){
        echo '<div id="csv2post_maintabs">';
    }
}

/**
* Secondary navigation builder - CSS only (use for javascript debugging etc)
* @todo MEDIUMPRIORITY, move the css in function to a .css file and double check no duplicates
* @param mixed $thepagekey
*/
function csv2post_navigation_css($thepagekey){    
    global $csv2post_is_activated,$csv2post_is_installed,$csv2post_mpt_arr;?>

    <?php if($csv2post_mpt_arr['menu'][$thepagekey]['vertical'] == true){?>

    <style> 
    #csv2post_maintabs {
        position: relative;
        padding-left: 10em;
    }
    #csv2post_maintabs .ui-tabs-nav {
        position: absolute;
        left: 0.25em;
        top: 0.25em;
        bottom: 0.25em;
        width: 10em;
        padding: 0.2em 0 0.2em 0.2em;
    }
    #csv2post_maintabs .ui-tabs-nav li {
        right: 1px;
        width: 100%;
        border-right: none;
        border-bottom-width: 1px !important;
        border-radius: 4px 0px 0px 4px;
        -moz-border-radius: 4px 0px 0px 4px;
        -webkit-border-radius: 4px 0px 0px 4px;
        overflow: hidden;
    }
    #csv2post_maintabs .ui-tabs-nav li.ui-tabs-selected {
        border-right: 1px solid transparent;
    }
    #csv2post_maintabs .ui-tabs-nav li a {
        float: right;
        width: 100%;
        text-align: right;
    }
    </style>
    <?php }?>       
            
    <div id="csv2post_maintabs">

    <?php 
    if($csv2post_mpt_arr['menu'][$thepagekey]['headers'] == true){
        
        foreach($csv2post_mpt_arr['menu'][$thepagekey]['tabs'] as $tab=>$values){
            
            $pageslug = $csv2post_mpt_arr['menu'][$thepagekey]['slug'];
            $tabslug = $csv2post_mpt_arr['menu'][$thepagekey]['tabs'][$tab]['slug'];
            $tablabel = $csv2post_mpt_arr['menu'][$thepagekey]['tabs'][$tab]['label'];   
 
             if($csv2post_mpt_arr['menu'][ $thepagekey ]['tabs'][ $tab ]['display'] == true){

                // install menu is handled different
                ### ??? is this correct, is the install page key not install rather than 1
                if($thepagekey == 1){?>
                    <div id="tabs-<?php echo $tab;?>">
                        <?php echo $csv2post_mpt_arr['menu'][$thepagekey]['tabs'][$tab]['label'];?>
                    </div><?php    
                }        
            } 
        }
    }?>       
    
    <?php
    // begin building menu - controlled by jQuery
    echo '<ul>';

    // loop through tabs - held in menu pages tabs array
    foreach($csv2post_mpt_arr['menu'][$thepagekey]['tabs'] as $tab => $values){
        
        $pageslug = $csv2post_mpt_arr['menu'][$thepagekey]['slug'];
        $tabslug = $csv2post_mpt_arr['menu'][$thepagekey]['tabs'][$tab]['slug'];
        $tablabel = $csv2post_mpt_arr['menu'][$thepagekey]['tabs'][$tab]['label'];   
        
        if($csv2post_mpt_arr['menu'][ $thepagekey ]['tabs'][ $tab ]['display'] == true){
                // default menu build approach
                echo '<li><a href="'.csv2post_create_adminurl($pageslug,'').'&tabnumber='.$tab.'">' . $tablabel . '</a></li>';                                
        } 
    }// for each
    
    echo '</ul>';  
}

/**
* If current_project_code is false, will return a string holding "None", for using in strings 
*/
function csv2post_convertvalue_projectcodefalse_toostring(){
    global $csv2post_currentproject_code;
    if(!$csv2post_currentproject_code || $csv2post_currentproject_code == 'false' || $csv2post_currentproject_code === false){
        return 'None';
    }
    return $csv2post_currentproject_code;    
}

/**
* Displays a list of tokens based on projects database columns (all tables selected in project).
* if $csv2post_is_free tokens do not use table name as free edition only allows a single table
* 
* @param mixed $csv2post_currentproject_code
*/
function csv2post_list_replacement_tokens($currentproject_code){
    global $csv2post_is_free;
    
    if(!$currentproject_code || $currentproject_code == false){
        echo 'No Current Project';  
    }else{
        $project_array = csv2post_get_project_array($currentproject_code);
        
        // loop through project tables
        foreach($project_array['tables'] as $key => $table_name){
 
            echo '<h4>' . $table_name . '</h4>';
            
            // confirm table still exists else display warning - great opportunity to let user know they deleted the WRONG table :) 
            if(!csv2post_WP_SQL_does_table_exist($table_name)){
                echo csv2post_notice('This table is missing, have you possibly manually deleted it?','error','Tiny','','','return');
            }
            
            $table_columns = csv2post_WP_SQL_get_tablecolumns($table_name);
            
            if(!$table_columns){
            
                echo csv2post_notice('The database table named '.$table_name.' does not appear to exist anymore. Have you
                deleted it manually using this plugin or when editing the database directly?','error','Small','','','return');
                
            }else{
            
                // excluded columns array
                $excluded_columns = array('csv2post_id','csv2post_postid','csv2post_postcontent','csv2post_inuse','csv2post_imported','csv2post_updated','csv2post_changed','csv2post_applied','csv2post_filemoddate','csv2post_filemoddate1','csv2post_filemoddate2','csv2post_filemoddate3','csv2post_filemoddate4','csv2post_filemoddate5','csv2post_filedone','csv2post_filedone1','csv2post_filedone2','csv2post_filedone3','csv2post_filedone4','csv2post_filedone5');

                // we will count the number of none wtgcsv columns, if 0 we know it is a main project table for multiple table project
                $count_users_columns = 0;
                
                while ($row_column = mysql_fetch_row($table_columns)) { 
                    
                    if(!in_array($row_column[0],$excluded_columns)){
                        
                        // if free edition, do not add the table, we make it a little more simple
                        // it is also more secure for users who may be beginners because database table names are not in use
                        if($csv2post_is_free){
                            echo '#' . $row_column[0].'<br />';                   
                        }else{            
                            echo $table_name . '#' . $row_column[0].'<br />';
                            ++$count_users_columns;
                        }
                    }
                } 
                
                if(!$csv2post_is_free && $count_users_columns == 0){
                    echo '<p><strong>This is your main project table created by this plugin, no columns need to be displayed</strong></p>';
                }
            } 
        }    
    }            
}

/**
* Lists all title templates as form fields for editing.
* Also adds a hidden input with the value being the total number of templates, this is for $_POST processing.
*/
function csv2post_list_titletemplate_foredit(){
    global $csv2post_currentproject_code;
    
    $default_template_id = csv2post_get_default_titletemplate_id( $csv2post_currentproject_code );
    $current_default_template_text = '';
      
    $args = array(
        'post_type' => 'wtgcsvtitle',
    );

    $myposts = get_posts( $args );
    if(count($myposts) == 0){
        echo 'You do not have any title templates yet, please use the Create Title Templates panel';
    }

    $i = 0;
    foreach( $myposts as $post ){
        
        ++$i;
        
        if( $post->ID == $default_template_id){
            $current_default_template_text = ' - Projects Default Title Template';    
        }?>

        <h4>Title Template Name: <?php echo $post->post_title . $current_default_template_text;?></h4>
        <input type="text" name="csv2post_titletemplate_design_<?php echo $i;?>" id="csv2post_title_inputid_<?php echo $i;?>" value="<?php echo $post->post_content;?>" size="65" />
        <input type="hidden" name="csv2post_titletemplate_design_original_<?php echo $i;?>" value="<?php echo $post->post_content;?>">    
        <input type="hidden" name="csv2post_titletemplate_postid_<?php echo $i;?>" value="<?php echo $post->ID;?>">    
        <input type="hidden" name="csv2post_titletemplate_posttitle_<?php echo $i;?>" value="<?php echo $post->post_title;?>"><?php    

    };?>
    
    <input type="hidden" name="csv2post_titletemplate_total" value="<?php echo $i;?>"><?php    
}

/**
* Lists all DISTINCT custom field keys (it actually queries meta-keys).
* There is not a currently any measures that hide none custom field keys.  
*/
function csv2post_list_customfields(){
    $result = csv2post_WP_SQL_get_customfield_keys_distinct();
    foreach ($result as $customfield) {
        echo $customfield->meta_key .'<br />';
    }    
}

/**
* Uses csv2post_WP_SQL_get_customfield_keys_distinct() to get DISTINCT meta-keys then loops and prints them.
* Can be used for custom field related features however there is csv2post_list_customfields() for that also. 
*/
function csv2post_list_metakeys(){
    $result = csv2post_WP_SQL_get_customfield_keys_distinct();
    foreach ($result as $customfield) {
        echo $customfield->meta_key .'<br />';
    }   
}

###########################################################################################
#                                                                                         #
#                                       FORM MENUS                                        #
#                                                                                         #
###########################################################################################
/**
* Used to build post type form. Echos option items, use function inside select object.
*/
function csv2post_display_posttypes_menu_options(){

    $post_types = get_post_types('','names');
    
    foreach ( $post_types as $post_type ) {
        
        // do not display post types that wont be used
        if( $post_type != "revision" && $post_type != "nav_menu_item" ){
            echo '<option value="'.$post_type.'">'.$post_type.'</option>';
        }
    }
}

/**
* Outputs options displaying CSV file headers along side thier database table versions (sql_adapted)
* 
* @param mixed $headers
* @param mixed $current
*/
function csv2post_display_jobs_csvfile_headers_menuoptions($headers,$current = 'NOTSELECTED46436346'){
    
    foreach($headers as $hk => $header ){

        $selected = '';
        if($current == 'NOTSELECTED46436346'){
            $selected = '';
        }else{
            
        }
        
        echo '<option value="'.$header['original'].'" '.$selected.' >CSV File: ' . $header['original'] . ' Database Table: '.$header['sql_adapted'].'</option>';
 
    }
    
}

/**
* Uses header array from Data Import Job array to output menu options offering headers for selection 
*/
function csv2post_display_headers_menuoptions($headers,$jobcode,$current = 'NOTSELECTED4643786'){
    foreach($headers as $hk => $header ){

        $selected = '';
        if($current == 'NOTSELECTED4643786'){
            $selected = '';
        }else{
            
        }
        
        echo '<option value="'.$header['original'].'" '.$selected.' >' . $header['original'] .'</option>';
 
    }    
}

/**
* Display date method with a short description of what the date method does 
*/
function csv2post_display_date_method(){
    global $csv2post_project_array,$csv2post_plugintitle;
    
    if(isset($csv2post_project_array['dates']['currentmethod'])){
        
        if($csv2post_project_array['dates']['currentmethod'] == 'data'){
            echo csv2post_notice('You selected a column in your project database tables for populating the publish dates of your posts.
            Please ensure the date formats in your data is suitable if your dates do not turn out as expected.','info','Large','Pre-Set Data Dates','','return');        
            return;    
        }
                
        if($csv2post_project_array['dates']['currentmethod'] == 'random'){
            echo csv2post_notice('Your project is currently setup to create random publish dates. Your 
            random dates will be generated using the giving start and end dates. All publish dates will fall
            between those giving dates and will not be created with any increment or in order.','info','Large','Random Dates','','return');        
            return;    
        }
        
        if($csv2post_project_array['dates']['currentmethod'] == 'increment'){
            echo csv2post_notice('The current project is setup to use the incremental publish dates method.
            The first publish date will be the Start date you submitted. The increment will then be used to 
            create the next publish date.','info','Large','Incremental Dates','','return');        
            return;    
        }

    }
    
    // display default
    echo csv2post_notice('Your project will use your blogs default publish date. '.$csv2post_plugintitle.' will not apply
    a date or make modifications to the one decided by Wordpress based on your current Date configuration here on
    this screen.','info','Large','Wordpress Default Publish Dates','','return');    
}


/**
* Displays checkbox menu holding all the designs for the giving project
* @todo CRITICAL, improve the id to make it more unique as this menu will be used many times 
*/
function csv2post_display_contenttemplate_menuoptions(){

    $args = array(
        'post_type' => 'wtgcsvcontent'
    );

    global $post;
    $myposts = get_posts( $args );
    foreach( $myposts as $post ){ 
        echo '<option value="'.$post->ID.'">'.$post->post_title.'</option>'; 
    };    
    
}

/**
* Add a selectables list of CSV filesr
* 
* @parameter string $range (all = all csv files) use this to control the range of filesr
* 
* @todo CRITICAL, check the use of this function and apply ID, do not allow it to be optional 
* 
* ### TODO, this should be selectables not a menu like in csv2post_menu_csvfiles
*/
function csv2post_selectables_csvfiles($range = 'all',$id = 'noid'){?>

    <select multiple='multiple' id="csv2post_selectcsvfiles_<?php echo $id;?>" name="csv2post_csvfilearray_<?php echo $id;?>[]" class="csv2post_multiselect_menu">
        <option value="notselected">Select A CSV File</option>
        <?php csv2post_option_items_csvfiles('all');?>
    </select>
     
    <script type="text/javascript">
        $(function(){
            $('#csv2post_selectcsvfiles_<?php echo $id;?>').multiSelect({
              selectableHeader : '<h3>Projects Available</h3>',
              selectedHeader : '<h3>Delete These</h3>'                
            });
        });
    </script><?php    
}

/**
* Use within a form to add a menu of CSV files
* 
* @param mixed $range
* 
* @todo LOWPRIORITY, add ability to create single select or multiselect (once bug fixed to apply single)
*/
function csv2post_menu_csvfiles($range = 'all',$id = 'noid'){?>
    <p>
        <select id="csv2post_multiselect<?php echo $id;?>" name="<?php echo WTG_C2P_ABB . 'csvfiles_menu';?>">
            <option value="notselected">No File Selected</option>
            <?php //csv2post_option_items_csvfiles('all');?>
        </select>
    </p><?php    
}

/**
* Adds option items to a menu for data import tables
* ### TODO:LOWPRIORITY, add results to an array first, then reverse the array, so that job tables are at the top of list
*/
function csv2post_option_items_databasetables($append_job_names = false){
    global $wpdb,$csv2post_is_free;
    $result = mysql_query("SHOW TABLES FROM `".$wpdb->dbname."`");
    while ($row_table = mysql_fetch_row($result)) {
        
        // if $append_job_names is true, we check if a tablename belongs to a job name then append the job name for easier recognition
        $append_string = '';
        if($append_job_names){

            // ensure csv2post_ exists in tablename, otherwise it is not an applicable tablename
            if(strstr( $row_table[0] , 'csv2post_' )){
                $append_string = '(' . csv2post_get_dataimportjob_name_by_table($row_table[0]) . ')';    
            }                                 

        }

        // only allow CSV 2 POST data job tables to be displayed in menu
        if($csv2post_is_free && strstr( $row_table[0] , 'csv2post_' )){
            echo '<option value="'.$row_table[0].'">'.$row_table[0].' '.$append_string.'</option>';            
        }elseif(!$csv2post_is_free){
            echo '<option value="'.$row_table[0].'">'.$row_table[0].' '.$append_string.'</option>';
        }

    }
}

/**
* Adds option items to a menu for data import tables
* ### TODO:LOWPRIORITY, add results to an array first, then reverse the array, so that job tables are at the top of list
*/
function csv2post_tabletotable_option_items_databasetables($append_job_names = false){
    global $wpdb,$csv2post_is_free;
    $result = mysql_query("SHOW TABLES FROM `".$wpdb->dbname."`");
    while ($row_table = mysql_fetch_row($result)) {
        // ensure csv2post_ exists in tablename, otherwise it is not an applicable tablename
        if($csv2post_is_free && strstr( $row_table[0] , 'csv2post_' ) || !$csv2post_is_free){
            echo '<option value="'.$row_table[0].'">'.$row_table[0].'</option>';
        }
    }
}

/**
* Gets and returns data import job name, using tablename
* @returns string which will have a job name, unless $table_name is not a wtgcsv table. If job not found using code, error returned
*/
function csv2post_get_dataimportjob_name_by_table($table_name){
    global $csv2post_dataimportjobs_array;
    
    // confirm $table_name is a wtgcsv table
    if(strstr ( $table_name , 'csv2post_' )){
        
        // remove csv2post_ and be left with code
        $code = str_replace('csv2post_','',$table_name);   

        if(isset($csv2post_dataimportjobs_array[$code]['name'])){
            return $csv2post_dataimportjobs_array[$code]['name'];
        }else{
            return 'Warning:No Job Using Giving Table Name';
        }  
    }
    
    return 'Warning:Job Does Not Exist Using Giving Table Name';  
}

/**
* Outputs option items for menus, does not output the select just the items for CSV files 
*/
function csv2post_option_items_csvfiles($range = 'all'){    
    @$opendir_result = opendir( WTG_C2P_CONTENTFOLDER_DIR ); 
    while( false != ( $filename = readdir( $opendir_result ) ) ){
        if( ($filename != ".") and ($filename != "..") ){
            
            $fileChunks = explode(".", $filename);
                              
            // ensure file extension is csv
            if( isset( $fileChunks[1] ) && $fileChunks[1] == 'csv'){
                
                $logfile_array = array('csv2post_log_error','csv2post_log_general','csv2post_log_sql','csv2post_log_user','csv2post_log_admin');
                // ignore log files
                if(!in_array($fileChunks[0],$logfile_array)){                
                    echo '<option value="'.$filename.'">'.$filename.'</option>';
                }                   
                
            }// end if csv
            
        }// end if $filename = .  
    }// end while    
} 

/**
* Outputs project names as option items for using within a form menu
* @parameter array $existing_values, default is false, pass array of existing saved values to set selected state
*/
function csv2post_option_items_postcreationprojects($existing_values = false){
    global $csv2post_projectslist_array;
    foreach($csv2post_projectslist_array as $project_code => $project){
        echo '<option value="'.$project_code.'">'.$project['name'].'</option>';    
    }    
}

/**
* Displays post types as radio buttons on form with jQuery styling of a button.
*/
function csv2post_display_defaultposttype_radiobuttons(){ 
    global $csv2post_currentproject_code;
    $project_array = csv2post_get_project_array($csv2post_currentproject_code);?> 
    
    <script>
    $(function() {
        $( "#csv2post_defaultposttype_radios_objectid" ).buttonset();
    });
    </script>

    <div id="csv2post_defaultposttype_radios_objectid">
        
        <?php
        // get current projects default post type
        $defaultposttype = csv2post_get_project_defaultposttype($csv2post_currentproject_code);
        
        $post_types = get_post_types('','names');
        $defaultapplied = false;        
        $i = 0; 
        foreach( $post_types as $post_type ){
            
            // dont add "post" as it is added last so that it can be displayed as current default when required
            if($post_type != 'post'){
                $checked = '';
                if($post_type == $defaultposttype){
                    $checked = 'checked="checked"';
                    $defaultapplied = true;    
                }
                echo '<input type="radio" id="csv2post_radio'.$i.'_posttype_objectid" name="csv2post_radio_defaultpostype" value="'.$post_type.'" '.$checked.' />
                <label for="csv2post_radio'.$i.'_posttype_objectid">'.$post_type.'</label>';    
                ++$i;
            }
        }
        
        // add post last, if none of the previous post types are the default, then we display this as default as it would be in Wordpress
        $post_default = '';
        if(!$defaultapplied){
            $post_default = 'checked="checked"';            
        }
        echo '<input type="radio" id="csv2post_radio'.$i.'_posttype_objectid" name="csv2post_radio_defaultpostype" value="post" '.$post_default.' />
        <label for="csv2post_radio'.$i.'_posttype_objectid">post</label>';?>
        
    </div><?php 
}

/**
* Displays a table of basic custom field rules with checkbox for deleting rules
* @todo LOWPRIORITY, add Example Value column and pull data if available from project table 
*/
function csv2post_table_customfield_rules_basic(){
    global $csv2post_currentproject_code;
    
    $project_array = csv2post_get_project_array($csv2post_currentproject_code);
    if(!isset($project_array['custom_fields']['basic'])){
        csv2post_notice('You do not have any basic custom field rules for adding meta data to your posts.','info','Large');
    }else{    
        echo '<table class="widefat post fixed"><tr class="first">
            <td width="50"><strong>Delete</strong></td>
            <td width="200"><strong>Meta-Key</strong></td>
            <td width="200"><strong>Table</strong></td>
            <td><strong>Column</strong></td>                                                                       
        </tr>'; 
        
        foreach( $project_array['custom_fields']['basic'] as $key => $rule ){
            echo '<tr class="first">
                <td><input type="checkbox" name="csv2post_customfield_rule_arraykey" value="'.$key.'" /></td>
                <td>'.$rule['meta_key'].'</td>               
                <td>'.$rule['table_name'].'</td>
                <td>'.$rule['column_name'].'</td>                                                       
            </tr>';
        }
        
        echo '</table>';
    }   
}

/**
* Delete advanced custom field rules  
*/
function csv2post_table_customfield_rules_advanced(){
    global $csv2post_currentproject_code;
    
    $project_array = csv2post_get_project_array($csv2post_currentproject_code);
    if(!isset($project_array['custom_fields']['advanced'])){
        csv2post_notice('You do not have any advanced custom field rules for adding meta data to your posts.','info','Large');
    }else{    
        echo '<table class="widefat post fixed"><tr class="first">
            <td width="50"><strong>Delete</strong></td>
            <td width="200"><strong>Meta-Key</strong></td>
            <td width="200"><strong>Table</strong></td>
            <td><strong>Column</strong></td>
            <td><strong>Template ID</strong></td>
            <td><strong>Updating</strong></td>                                                                                               
        </tr>'; 
        
        foreach( $project_array['custom_fields']['advanced'] as $key => $rule ){

            if(isset($rule['table_name'])){
                $table = $rule['table_name'];
            }else{
                $table = '';
            }
                        
            if(isset($rule['column_name'])){
                $column = $rule['column_name'];
            }else{
                $column = '';
            }
            
            if(isset($rule['update'])){
                $update = $rule['update'];
            }else{
                $update = 'off';
            }
                        
            echo '<tr class="first">
                <td><input type="checkbox" name="csv2post_customfield_rule_arraykey" value="'.$key.'" /></td>
                <td>'.$rule['meta_key'].'</td>               
                <td>'.$table.'</td>
                <td>'.$column.'</td>
                <td>'.$rule['template_id'].'</td>
                <td>'.$update.'</td>                                                                                       
            </tr>';
        }
        
        echo '</table>';
    }   
}

/**
* Builds a table showing all post type rules (by value) with checkboxes for deletion
*/
function csv2post_display_posttyperules_byvalue_table(){
    global $csv2post_currentproject_code;
    
    $project_array = csv2post_get_project_array($csv2post_currentproject_code);
    
    if(!isset($project_array['posttyperules']['byvalue'])){
        csv2post_notice('You do not have any post type rules by specific values for your current project.','info','Small');
        return 0;
    }else{

        echo '<table class="widefat post fixed"><tr class="first">
                <td width="150"><strong>Table</strong></td>
                <td width="150"><strong>Column</strong></td>                
                <td width="50"><strong>Trigger Value</strong></td>
                <td width="100"><strong>Post Type</strong></td>                                                       
            </tr>';
        
        foreach( $project_array['posttyperules']['byvalue'] as $key => $rule ){
            echo '<tr class="first">
                <td width="150">'.$rule['table_name'].'</td>
                <td width="150">'.$rule['column_name'].'</td>                
                <td width="50">'.$rule['trigger_value'].'</td>
                <td width="100">'.$rule['post_type'].'</td>                                                       
            </tr>';
        }
            
        echo '</table>';               
    }
} 

/**
* Builds a table showing all template design rules (by value) with checkboxes for deletion
*/
function csv2post_display_templatedesignrules_byvalue_table(){
    global $csv2post_currentproject_code;
    
    $project_array = csv2post_get_project_array($csv2post_currentproject_code);
    if(!isset($project_array['contenttemplaterules']['byvalue'])){
        csv2post_notice('You do not have any dynamic content design rules triggered by specific values.','info','Small');
        return 0;
    }else{

        echo '<table class="widefat post fixed"><tr class="first">
                <td width="150"><strong>Table</strong></td>
                <td width="150"><strong>Column</strong></td>                
                <td width="50"><strong>Trigger Value</strong></td>
                <td width="100"><strong>Template ID</strong></td>                                                       
            </tr>';
        
        foreach( $project_array['contenttemplaterules']['byvalue'] as $key => $rule ){
            echo '<tr class="first">
                <td width="150">'.$rule['table_name'].'</td>
                <td width="150">'.$rule['column_name'].'</td>                
                <td width="50">'.$rule['trigger_value'].'</td>
                <td width="100">'.$rule['template_id'].'</td>                                                       
            </tr>';
        }
            
        echo '</table>';               
    }
}

/**
* List of notification boxes displaying job tables
*/
function csv2post_list_jobtables(){
    global $csv2post_dataimportjobs_array,$csv2post_jobtable_array;

    if(isset($csv2post_jobtable_array) && $csv2post_jobtable_array != false){
        
        $counter = 1;
 
        foreach( $csv2post_jobtable_array as $key => $table_name ){
            
            $jobcode = str_replace('csv2post_','',$table_name);
              
            $table_exists_result = csv2post_WP_SQL_does_table_exist( $table_name );
            
            if($table_exists_result){
                $table_row_count = csv2post_WP_SQL_counttablerecords($table_name);
                
                $form = '<input type="checkbox" name="csv2post_deletejobtables_array[]" value="'.$table_name.'" />';
            
                echo csv2post_notice($form . ' ' . $counter . '. ' . $table_name,'success','Tiny','','','return');                
                
            }
            
            ++$counter;     
        }   
    }
}

/**
* List of notification boxes displaying folders created by CSV 2 POST.
*/
function csv2post_list_folders(){
    global $csv2post_dataimportjobs_array,$csv2post_jobtable_array;

    $contentfolder_exists = csv2post_contentfolder_exist();
    
    if($contentfolder_exists){

        echo csv2post_notice('<input type="checkbox" name="csv2post_deletefolders_array[]" value="wpcsvimportercontent" />' . ' 1. wpcsvimportercontent','success','Tiny','','','return');                
 
    }
}

/**
* Displays a list of database tables created for data import jobs.         
* Optional checkbox column also.
* 
* @returns count of total tables
* @global $csv2post_dataimportjobs_array, an array of current data import jobs, does not hold history
* @global $csv2post_jobtable_array, array of all data import job tables, holds tables until they are deleted using interface
* 
* @todo HIGHPRIORITY, add checkbox column for deleting tables 
*/
function csv2post_display_jobtables($checkbox_column = false){
    global $csv2post_dataimportjobs_array,$csv2post_jobtable_array;
    
    echo '<table class="widefat post fixed">
    <tr class="first">';
    
    if($checkbox_column){
        echo '<td width="50"><strong>Delete Tables</strong></td>';        
    }
    
    echo '
        <td width="170"><strong>Database Table Names</strong></td>
        <td width="170"><strong>Project Name</strong></td>
        <td><strong>Tables Records</strong></td>                                                               
    </tr>'; 
    
    $table_count = 0;
    
    if(isset($csv2post_jobtable_array) && $csv2post_jobtable_array != false){
               
        foreach( $csv2post_jobtable_array as $key => $table_name ){
            
            $jobcode = str_replace('csv2post_','',$table_name);
            
            // set project value
            if(!isset($csv2post_dataimportjobs_array[$jobcode]['name'])){
                $project = 'Project Deleted';
            }else{
                $project = $csv2post_dataimportjobs_array[$jobcode]['name'];            
            }
            
            $table_exists_result = csv2post_WP_SQL_does_table_exist( $table_name );
            
            if($table_exists_result){
                $table_row_count = csv2post_WP_SQL_counttablerecords($table_name);    
            }else{
                $table_row_count = 'Table Deleted';            
            }

            echo '
            <tr>';

            if($checkbox_column){
                echo '<td><input type="checkbox" name="csv2post_table_array[]" value="'.$table_name.'" /></td>';        
            }
                
            echo '
                <td>'.$table_name.'</td>
                <td>'.$project.'</td>
                <td>'.$table_row_count.'</td>
            </tr>';
            ++$table_count;
        }   
    }
                 
    echo '</table>';
    
    return $table_count;               
}

/**
* Displays a basic table listing all psot creation projects
*/
function csv2post_postcreationproject_table(){
    global $csv2post_projectslist_array;
    
    if(!isset($csv2post_projectslist_array) || $csv2post_projectslist_array == false){
        echo '<h4>You do not have any projects</h4>';    
    }else{?>
        <br />
        <table class="widefat post fixed">
            <tr class="first">
                <td width="120"><strong>Project Code/ID</strong></td>
                <td width="200"><strong>Project Name</strong></td>
                <td><strong>Projects Data Tables</strong></td>                                                                               
            </tr>
            
            <?php
            foreach( $csv2post_projectslist_array as $project_code => $project ){?>
                <tr class="first">
                    <td><?php echo $project_code;?></td>
                    <td><?php echo $project['name'];?></td>
                    <td><?php echo csv2post_display_projectstables_commaseparated($project_code);?></td>                                                                               
                </tr><?php     
            }?>
              
        </table><?php
    }     
}

/**
* Creates table of current projects database table and columns
* @todo LOWPRIORIRTY, add a column indicating the data type for each column
* @todo LOWPRIORITY, add a tooltip that displays a sample of the columns data 
*/
function csv2post_display_project_database_tables_and_columns(){
    global $csv2post_currentproject_code;
    
    if(!isset($csv2post_currentproject_code) || $csv2post_currentproject_code == false){
        echo '<h4>You do not have a Current Project set</h4>';    
    }else{
        
        echo '<br />';
         
        echo '
        <table class="widefat post fixed">
            <tr class="first">
                <td width="120"><strong>Table Names</strong></td>
                <td width="120"><strong>Records</strong></td>                
                <td><strong>Column Names</strong></td>                                                                               
            </tr>';
                  
        $project_array = csv2post_get_project_array($csv2post_currentproject_code);
        $table_name_string = '';
        $count = 0;
        foreach($project_array['tables'] as $test => $table_name){
            
            echo '<tr>';
                echo '<td>'.$table_name.'</td>';
                echo '<td>'.csv2post_WP_SQL_counttablerecords($table_name).'</td>';
                echo '<td></td>';
            echo '</tr>';
                
            $table_columns = csv2post_WP_SQL_get_tablecolumns($table_name);
            if($table_columns == false){
            
                echo '<tr>';                
                    echo '<td></td>';
                    echo '<td></td>';                    
                    echo '<td>Could not get column headers, please seek support for your CSV file</td>';
                echo '</tr>';                          
            }else{
                
                while ($row_column = mysql_fetch_row($table_columns)) {
                    echo '<tr>';                
                        echo '<td></td>';
                        echo '<td></td>';                    
                        echo '<td>'.$row_column[0].'</td>';
                    echo '</tr>'; 
                } 
            
            }
 
            ++$count;         
        }           

        echo '</table>';
    }     
}

/**
* Displays a list of all database tables
*                          
* @param boolean $checkbox_column adds a column of checkboxes to the table for use in forms
* @param boolean $ignore_free checkbox column becomes radio buttons in free edition, unless $ignore_free is set to true
*/
function csv2post_display_databasetables_withjobnames($checkbox_column = false,$ignore_free = false){
    global $csv2post_dataimportjobs_array,$csv2post_jobtable_array,$csv2post_is_free,$csv2post_plugintitle;
    
    // count number of job tables we have registered
    $table_count = 0;
    if(is_array($csv2post_jobtable_array)){
        $table_count = count($csv2post_jobtable_array);
    }
    
    // if no applicable database tables would be displayed, display message
    if($csv2post_is_free && $table_count == 0){
        echo csv2post_notice('Your database does not have any tables created by '.$csv2post_plugintitle.'. You will need to create a Data Import Job which creates a new database table.','warning','Small','','','return');    
    }else{
        
        echo '<table class="widefat post fixed"><tr class="first">';
        
        if($checkbox_column){
            echo '<td width="80"><strong>Select</strong></td>';        
        }
        
        echo '<td width="200"><strong>Table Names</strong></td>
            <td width="150"><strong>Data Import Job</strong></td>
            <td width="100"><strong>Records</strong></td>
            <td width="100"><strong>Used</strong></td>
            <td width="100"><strong>Reset Table</strong></td>
            <td width="100"><strong>Reset Posts</strong></td>                                                                              
        </tr>'; 
        
        $table_count = 0;

        $tables = csv2post_WP_SQL_get_tables();

        while ($table_name = mysql_fetch_row($tables)) {                
               
            // I decided free users should not get a plugin that offers open access to Wordpress database tables.
            // I would like to reduce such access at least until better documentation is released and more security added
            if($csv2post_is_free && !strstr($table_name[0],'csv2post_')){
            
                // we do nothing - we do not add database tables to our table if csv2post_ is not within the name
                // or if user does not want them shown     
                
            }else{
            
                // we want to display data import job names if a table belongs to one
                // first determine if table was created by CSV 2 POST
                $tables_jobname = '.';
                 
                // is current table_name a csv2post_ created table 
                $is_csv2post_table = strstr($table_name[0],'csv2post_');
                if($is_csv2post_table){
                    // remove csv2post_ from string to be left with possible job code (may not be a job)
                    $possible_jobcode = str_replace('csv2post_','',$table_name[0]);
                     
                    if(isset($csv2post_dataimportjobs_array[$possible_jobcode]['name'])){
                        $tables_jobname = $csv2post_dataimportjobs_array[$possible_jobcode]['name'];
                    }               
                }
                        
                $table_row_count = csv2post_WP_SQL_counttablerecords($table_name[0]);    
                               
                echo '<tr>';
         
                if($checkbox_column){
                    if($csv2post_is_free){
                        echo '<td><input type="radio" name="csv2post_databasetables_array" value="'.$table_name[0].'" /></td>';        
                    }else{
                        echo '<td><input type="checkbox" name="csv2post_databasetables_array[]" value="'.$table_name[0].'" /></td>';                
                    }
                }
                           
                echo '<td>'.$table_name[0].'</td>
                <td>'.$tables_jobname.'</td>
                <td>'.$table_row_count.'</td>';
        
                // exclusion list to avoid running queries on certain tables
                $excludedtables = array('csv2post_ryanair_dfformstaff','csv2post_ryanair_eposerrors','csv2post_ryanair_flight','csv2post_ryanair_onlinedf1_products','csv2post_ryanair_producthistory');
                
                // display if a project table has been used or not
                if(strstr($table_name[0],'csv2post_') && !in_array($table_name[0],$excludedtables)){
                                             
                    if(csv2post_is_table_used($table_name[0])){
                        $used = 'Yes';
                    }else{
                        $used = 'No';
                    }
                    
                }else{
                    $used = '';
                }
                
                echo '<td>'.$used.'</td>';                                  
                                      
                // column for checkbox that resets a used table
                if($used == 'Yes'){
                    if($csv2post_is_free){
                        echo '<td><input type="radio" name="csv2post_databasetables_resettable_array" value="'.$table_name[0].'" /></td>';        
                        echo '<td><input type="radio" name="csv2post_databasetables_resetposts_array" value="'.$table_name[0].'" /></td>';
                    }else{
                        echo '<td><input type="checkbox" name="csv2post_databasetables_resettable_array[]" value="'.$table_name[0].'" /></td>';                
                        echo '<td><input type="checkbox" name="csv2post_databasetables_resetposts_array[]" value="'.$table_name[0].'" /></td>';
                    }
                }else{
                    echo '<td></td>';
                    echo '<td></td>';
                }
                echo '</tr>';
    
                ++$table_count;
            }
        }   
                     
        echo '</table>';
    }
    
    return $table_count;               
}

/**
* Echos options for a form menu.
* 
* @param string $current_value, pass the current saved value or the form setting or pass null
* @todo LOWPRIORITY, change this function to display heirarchy properly 
*/
function csv2post_display_categories_options($current_value){

    $cats = get_categories('hide_empty=0&echo=0&show_option_none=&style=none&title_li=');

    foreach( $cats as $c ){ 
        
        // apply selected value to current save
        $selected = '';
        if( $current_value == $c->term_id ) {
            $selected = 'selected="selected"';
        }
        
        echo '<option value="'.$c->term_id.'" '.$selected.'>'. $c->term_id . ' - ' . $c->name .'</option>'; 
    }            
    
}

function csv2post_display_users_options($current_value){

    $blogusers = get_users('blog_id=1&orderby=nicename');

    foreach ($blogusers as $user){ 
        
        // apply selected value to current save
        $selected = '';
        if( $current_value == $user->ID ) {
            $selected = 'selected="selected"';
        }
        
        echo '<option value="'.$user->ID.'" '.$selected.'>'. $user->ID . ' - ' . $user->display_name .'</option>'; 
    }            
    
}

/**
* Outputs the template design options for a form menu.
* 
* @param mixed $current_value
* @param string $template_type the type of template to be displayed (postcontent,customfieldvalue,categorydescription,postexcerpt,keywordstring,dynamicwidgetcontent)
*/
function csv2post_display_template_options($current_value,$template_type = false){

    global $csv2post_project_array;

    $args = array();
    $args['post_type'] =  'wtgcsvcontent';

    // set type singular name
    if($template_type == 'postcontent'){
        $type_singular = 'Post Content';
        $args['meta_query'][0]['key'] = '_csv2post_templatetypes';
        $args['meta_query'][0]['value'] = 'postcontent';     
    }elseif($template_type == 'customfieldvalue'){
        $type_singular = 'Custom Field Value';
        $args['meta_query'][0]['key'] = '_csv2post_templatetypes';
        $args['meta_query'][0]['value'] = 'customfieldvalue';                
    }elseif($template_type == 'categorydescription'){  
        $type_singular = 'Category Description';
        $args['meta_query'][0]['key'] = '_csv2post_templatetypes';
        $args['meta_query'][0]['value'] = 'categorydescription';                
    }elseif($template_type == 'postexcerpt'){
        $type_singular = 'Post Excerpt';
        $args['meta_query'][0]['key'] = '_csv2post_templatetypes';
        $args['meta_query'][0]['value'] = 'postexcerpt';                
    }elseif($template_type == 'keywordstring'){
        $type_singular = 'Keyword String';
        $args['meta_query'][0]['key'] = '_csv2post_templatetypes';
        $args['meta_query'][0]['value'] = 'keywordstring';                
    }elseif($template_type == 'dynamicwidgetcontent'){
        $type_singular = 'Dynamic Widget Content';
        $args['meta_query'][0]['key'] = '_csv2post_templatetypes';
        $args['meta_query'][0]['value'] = 'dynamicwidgetcontent';                
    }else{
        $type_singular = 'Content';        
    }

    global $post;
    $myposts = get_posts( $args );
    
    // if no posts display an option indicating this
    if(count($myposts) == 0){
        echo '<option value="notselected" selected="selected">No '.$type_singular.' Templates</option>';
    }else{
 
        foreach( $myposts as $post ){ 
            
            // apply selected value to current save
            if( $current_value == $post->ID ) {
                $selected = 'selected="selected"';
            }
            
            echo '<option value="'.$post->ID.'" '.$selected.'>'. $post->ID . ' - ' . $post->post_title .'</option>'; 
        } 
    }           
} 

/**
* Establishes the correct text for help button. Has more use during initial development
* but also indicates what features are paid edition only, in the free edition.
* 
* @param mixed $under_construction
* @param mixed $paid_only
* @return string
*/
function csv2post_helpbutton_text($under_construction = false,$paid_only = false){
    global $csv2post_is_free;
    
    if($csv2post_is_free && $paid_only){
        return 'Feature Not Released';// full edition only but possibly coming to the free edition
    }    
    
    if($under_construction){
        return 'New Feature For Testing Only';// used to say "Under Construction"    
    }

    return 'Help';
}

/**
* Displays a list of CSV file for selection. 
* User can select separator and quote also. The table also displays the auto determined separator and quote using PEAR CSV.
* 
*/
function csv2post_display_csvfiles_fornewdataimportjob(){
    global $csv2post_is_free;  

    echo '<table class="widefat post fixed">';
            
    echo '
    <tr>
        <td width="50">Select</td>
        <td width="200">CSV File Name</td>
        <td width="70">Columns</td>        
        <td width="110">Separator</td>
        <td width="80">Quote</td> 
    </tr>';
    
    @$opendir_result = opendir( WTG_C2P_CONTENTFOLDER_DIR ); 
    while( false != ( $filename = readdir( $opendir_result ) ) ){
        if( ($filename != ".") and ($filename != "..") ){
            
            $fileChunks = explode(".", $filename);
                              
            // ensure file extension is csv
            if( isset( $fileChunks[1] ) && $fileChunks[1] == 'csv'){
                
                $logfile_array = array('csv2post_log_error','csv2post_log_general','csv2post_log_sql','csv2post_log_user','csv2post_log_admin');
                
                // ignore log files
                if(!in_array($fileChunks[0],$logfile_array)){     
                    
                    echo '
                    <tr>
                        <td>';
                            
                            // determine radio or checkboxes
                            $object_type = 'checkbox';
                            if($csv2post_is_free){
                                $object_type = 'radio';
                            }?>
                            
                            <script>
                            $(function() {
                                $( "#csv2post_newjob_includefile_<?php echo $object_type;?>_<?php echo $fileChunks[0];?>" ).buttonset();
                            });
                            </script>

                            <div id="csv2post_newjob_includefile_<?php echo $object_type;?>_<?php echo $fileChunks[0];?>">                    
                                <input type="<?php echo $object_type;?>" name="csv2post_newjob_included_csvfiles[]" id="csv2post_newjob_includefile_<?php echo $fileChunks[0];?>" value="<?php echo $filename;?>" />
                                <label for="csv2post_newjob_includefile_<?php echo $fileChunks[0];?>">*</label>                     
                            </div>
                            
                        <?php 
                        ### TODO:HIGHPRIORITY, change the PEARCSVmethod for quote in the fget column
                        echo '</td>
                        <td>'.$filename.'</td>
                        <td><input type="text" name="csv2post_csvfile_fieldcount_'.$fileChunks[0].'" size="2" maxlength="2" value="" /></td>
                        <td>'; ?>

                            <script>
                            $(function() {
                                $( "#csv2post_newjob_separator_radios_<?php echo $fileChunks[0];?>" ).buttonset();
                            });
                            </script>

                            <div id="csv2post_newjob_separator_radios_<?php echo $fileChunks[0];?>">
                                <input type="radio" id="csv2post_separator_comma_<?php echo $fileChunks[0];?>" name="csv2post_newjob_separators<?php echo $fileChunks[0];?>" value="," /><label for="csv2post_separator_comma_<?php echo $fileChunks[0];?>">,</label>
                                <input type="radio" id="csv2post_separator_semicolon_<?php echo $fileChunks[0];?>" name="csv2post_newjob_separators<?php echo $fileChunks[0];?>" value=";" /><label for="csv2post_separator_semicolon_<?php echo $fileChunks[0];?>">;</label>
                                <input type="radio" id="csv2post_separator_tab_<?php echo $fileChunks[0];?>" name="csv2post_newjob_separators<?php echo $fileChunks[0];?>" value="|" /><label for="csv2post_separator_tab_<?php echo $fileChunks[0];?>">|</label>                
                            </div>

                        </td>
                        <td>
                            <script>
                            $(function() {
                                $( "#csv2post_newjob_quote_radios_<?php echo $fileChunks[0];?>" ).buttonset();
                            });
                            </script>

                            <div id="csv2post_newjob_quote_radios_<?php echo $fileChunks[0];?>">
                                <input type="radio" id="csv2post_quote_double_<?php echo $fileChunks[0];?>" name="csv2post_newjob_quote<?php echo $fileChunks[0];?>" value="doublequote" /><label for="csv2post_quote_double_<?php echo $fileChunks[0];?>">"</label>
                                <input type="radio" id="csv2post_quote_single_<?php echo $fileChunks[0];?>" name="csv2post_newjob_quote<?php echo $fileChunks[0];?>" value="singlequote" /><label for="csv2post_quote_single_<?php echo $fileChunks[0];?>">'</label>                
                            </div>                        
                        
                        </td>
                    </tr><?php                         
                }                   
                
            }// end if csv
            
        }// end if $filename = .  
    }// end while
    
    echo '</table>';    
} 

/**
* Displays various notice boxes to help users get a quick idea of the current schedule and auto events setup 
*/
function csv2post_schedulescreen_notices(){
    global $csv2post_schedule_array,$csv2post_projectslist_array;

    // if not allowed today display
    $day = strtolower( date('l') );
    if(!isset($csv2post_schedule_array['days'][$day])){
        echo csv2post_notice('Scheduled events have not been permitted for ' . date('l'),'info','Tiny','','','return');     
    }
    
    // if not allowed this hour display
    $hour = strtolower(date('G'));
    if(!isset($csv2post_schedule_array['hours'][$hour])){
        echo csv2post_notice('Scheduled events have not been permitted for the current hour: ' . date('G'),'info','Tiny','','','return');    
    }
    
    // if no hours array set OR if no boolean true exists for any hours
    if( !isset($csv2post_schedule_array['hours']) ){
        echo csv2post_notice('Schedule is not ready as no hours have been permitted','info','Tiny','','','return');    
    }else{
        // if no hours are boolean true
        $hour_permitted = false;
        foreach( $csv2post_schedule_array['hours'] as $key => $hour ){
            if($hour == true){
                $hour_permitted = true;
                break;    
            }    
        }    
        
        if(!$hour_permitted){
            echo csv2post_notice('Schedule paused because no hours are permitted','info','Tiny','','','return');    
        }
    }
    
    // if no days array set OR if no boolean true exists for any days
    if( !isset($csv2post_schedule_array['days']) ){
        echo csv2post_notice('Schedule is not ready as no days have been permitted','info','Tiny','','','return');    
    }else{
        // if no hours are boolean true
        $days_permitted = false;
        foreach( $csv2post_schedule_array['days'] as $key => $day ){
            if($day == true){
                $days_permitted = true;
                break;    
            }    
        }    
        
        if(!$days_permitted){
            echo csv2post_notice('Schedule has been disabled because no days are permitted','info','Tiny','','','return');    
        }
    }
    
    // if no event types set display this
    if(!isset($csv2post_schedule_array['eventtypes'])){
        echo csv2post_notice('Schedule is not setup, no event types have been activated yet','info','Tiny','','','return');    
    }else{
        // have event types been disabled
        $event_type_set = false;
        foreach($csv2post_schedule_array['eventtypes'] as $event_type){
            if($event_type['switch'] == true){
                $event_type_set = true;
                break;    
            }    
        }
        
        if(!$event_type_set){
            echo csv2post_notice('Schedule has been stopped because all event types are disabled','info','Tiny','','','return');    
        }
    }

    // if current 24 hour period limit reached display this
    if(isset($csv2post_schedule_array['history']['daycounter']) && isset($csv2post_schedule_array['limits']['day']) && $csv2post_schedule_array['history']['daycounter'] >= $csv2post_schedule_array['limits']['day']){
        echo csv2post_notice('The maximum events number for the current 24 hour period has been reached','info','Tiny','','','return');        
    }
    
    // if current 60 minute period limit reached display this
    if(isset($csv2post_schedule_array['history']['hourcounter']) && isset($csv2post_schedule_array['limits']['hour']) && $csv2post_schedule_array['history']['hourcounter'] >= $csv2post_schedule_array['limits']['hour']){
        echo csv2post_notice('The maximum events number for the current 60 minute period has been reached','info','Tiny','','','return');        
    }

    // if no projects are on drip feeding display
    $project_dripfeeding = false;
    if(isset($csv2post_projectslist_array) && is_array($csv2post_projectslist_array)){
        foreach($csv2post_projectslist_array as $project_code => $project_array){
            if(isset($project_array['dripfeeding']) && $project_array['dripfeeding'] == 'on'){
                $project_dripfeeding = true;
                break;
            }        
        }
    }
    
    if(!$project_dripfeeding){
        echo csv2post_notice('You do not have any Post Creation Projects activated for drip-feeding through the plugins schedule','info','Tiny','','','return');    
    } 
}

/**
* Outputs a form menu of the giving database tables columns for single selection
* 
* @param string $table_name
* @param mixed $id used to make ID attribute unique, recommend that it not be a number only if the menu is to be used many times
*/
function csv2post_menu_tablecolumns($table_name,$id = ''){?>  
    <select name="csv2post_table_columns_<?php echo $table_name;?><?php echo $id;?>" id="csv2post_table_columns_<?php echo $table_name;?><?php echo $id;?>_id" class="csv2post_multiselect_menu">
        <?php csv2post_options_tablecolumns($table_name);?>                                                                                                                     
    </select><?php    
}

/**
* Used on Multiple Table Project panel.
* Outputs a form menu of the giving database tables columns for single selection
* 
* @param string $table_name
*/
function csv2post_menu_tablecolumns_multipletableproject($table_name,$current_value = false){
    global $csv2post_project_array;?>         
    <select name="csv2post_multitable_columns_<?php echo $table_name;?>" id="csv2post_multitable_columns_<?php echo $table_name;?>_id" class="csv2post_multiselect_menu">
        <?php csv2post_options_columns($table_name,$current_value);?>                                                                                                                     
    </select><?php    
}

/**
* Outputs the option items for form menu, adding column names from giving database table
* 
* @param mixed $table_name
* @param mixed $current_value, default boolean false, pass the current value to make it selected="selected"
*/
function csv2post_options_tablecolumns($table_name,$current_value = false){
    
    $column_array = csv2post_WP_SQL_get_tablecolumns($table_name,true,true);
     
    if(!$column_array || !is_array($column_array)){
        
        echo '<option value="error">Problem Detected</option>';
            
    }else{
        
        echo '<option value="notrequired">Not Required</option>';
        
        foreach($column_array as $key => $column_name){
            
            $selected = '';
            if($current_value != false && $current_value == $column_name ){
                $selected = 'selected="selected"';     
            }

            echo '<option value="'.$table_name.'_'.$column_name.'" '.$selected.'>'.$column_name.'</option>';    
        }
    }
    
}

/**
* Menu of giving database tables columns
* 
* @param mixed $table_name
* @param mixed $current_value
*/
function csv2post_options_columns($table_name,$current_value = false){
    
    $column_array = csv2post_WP_SQL_get_tablecolumns($table_name,true,true);
     
    if(!$column_array || !is_array($column_array)){
        
        echo '<option value="error">Problem Detected</option>';
            
    }else{
        
        echo '<option value="notrequired">Not Required</option>';
        
        foreach($column_array as $key => $column_name){
            
            $selected = '';
            if($current_value != false && $current_value == $column_name ){
                $selected = 'selected="selected"';     
            }

            echo '<option value="'.$column_name.'" '.$selected.'>'.$column_name.'</option>';    
        }
    }
    
}

/**
* Used on Multiple Tables Project panel for selecting a tables key column
* 
* @param mixed $primary_table
*/
function csv2post_display_menu_keycolumnselection($table_name,$current_table = false,$current_column = false){
    global $csv2post_currentproject_code;?>
    <select name="csv2post_multitable_pairing_<?php echo $table_name;?>" id="csv2post_multitable_pairing_<?php echo $table_name;?>_id" class="csv2post_multiselect_menu">
        <option value="notrequired">Not Required</option>
        <?php csv2post_display_project_columnsandtables_menuoptions($csv2post_currentproject_code,$current_table,$current_column);?>                                                                                                                     
    </select><?php    
}

/**
* Displays a checkbox menu for selecting design type.
* User can select from multiple uses per content design,one design can have many uses.
* @todo LOWPRIORITY, remove lines not required for free edition, the loop and array
*/
function csv2post_display_designtype_menu($post_id){
    global $csv2post_is_free;
    
    // set an array of all the template types
    $templatetypes_array = array();
    $templatetypes_array[0]['slug'] = 'postcontent';
    $templatetypes_array[0]['label'] = 'Post/Page Content';      
    
    // get posts custom field holding template type string
    $customfield_types_array = get_post_meta($post_id, '_csv2post_templatetypes', false);
    if(!$customfield_types_array){array();}?>

    <p>        
        Design Type: 
        <?php $optionmenu = '';?>
        
        <?php $optionmenu .= '<select name="csv2post_designtype[]" id="csv2post_select_designtype" multiple="multiple" class="csv2post_multiselect_menu">';?>
 
            <?php
            // loop through all template types 
            foreach($templatetypes_array as $key => $type){
     
                // set selected status by checking if current $type is in the custom field value for csv2post_templatetypes
                $selected = '';
                if(isset($post_id) && is_numeric($post_id) && $post_id != 0){
                    if(in_array($type['slug'],$customfield_types_array,false)){
                        $selected = ' selected="selected"';
                    }
                }
                
                $optionmenu .= '<option value="';
                $optionmenu .= $type['slug'];
                $optionmenu .= '" ';                
                $optionmenu .= $selected;
                $optionmenu .= '>';
                $optionmenu .= $type['label'];
                $optionmenu .= '</option>';
            }?>
                                                                                                            
        <?php $optionmenu .= '</select>';?>

        <?php echo $optionmenu;?>

    </p>
<?php 
}



/**
* Displays a table of the CSV files within the plugins storage paths that have been used
* 1. displays some statistics of any matching database tables
* 2. displays the age of files for knowing when a file was last updated
* 3. Check for each files stored profile
* 4. Goes through data import projects, adds multiple entries of one file if the file exists in more than one project
*                      
* @todo HIGHPRIORITY, each file may exist in more than one data import project, so we must check this then add the file to table
* @todo MEDIUMPRIORITY, if more than 20 files are listed, create a message recommending cleanup for interface speed improvement
* @todo LOWPRIORITY, use DataTables with ability to click and view more information plus delete files.
* @todo LOWPRIORITY, a file is caused a blank age result, investigate why it happened when the file was edited then uploaded again, it could be because it was changed within seconds ago and that is not active        
* @todo LOWPRIORITY, check CSV files in plugin header and establish a CSV file array
*/
function csv2post_used_csv_file_list(){
    global $csv2post_dataimportjobs_array,$csv2post_plugintitle;
    
    if(!$csv2post_dataimportjobs_array){echo '<strong>You do not have any data import jobs</strong>';return 0;}
    
    $available = 0;
 
    $usedcsvfile_count = 0;
 
    if (!is_dir(WTG_C2P_CONTENTFOLDER_DIR)) {
    
        csv2post_notice('The content folder does not exist, has it been deleted or move?','error','Small','','');
                   
    }else{    
        
        @$opendir_result = opendir( WTG_C2P_CONTENTFOLDER_DIR );
        
        if(!$opendir_result){
            
            csv2post_notice($csv2post_plugintitle . ' does not have permission to open the plugins content folder','error','Small','','');

        }else{

            echo '
            <table class="widefat post fixed">
                <tr class="first">
                    <td width="200"><strong>Job Name</strong></td>                    
                    <td width="200"><strong>Filename</strong></td>                    
                    <td width="75"><strong>Rows</strong></td>
                    <td width="75"><strong>Size</strong></td>
                    <td width="100"><strong>Imported Records</strong></td>                   
                    <td><strong>Files Age</strong></td>                                    
                </tr>';  
            
            $filesize_total = 0;
            
            // loop through data import jobs
            foreach($csv2post_dataimportjobs_array as $jobid => $job){

                // get the jobs own option record
                $jobrecord = csv2post_get_dataimportjob($jobid);
                if(!$jobrecord){
                    csv2post_notice('Failed to locate the option table record for data import job named '.$job['name'].'. Is it possible the record was deleted manually?','error','Extra');
                }else{

                    foreach($jobrecord['files'] as $key => $csvfile_name){

                        if( ($csvfile_name != ".") and ($csvfile_name != "..") ){
                            
                            $fileChunks = explode(".", $csvfile_name);
                                              
                            // ensure file extension is csv
                            if( isset( $fileChunks[1] ) && $fileChunks[1] == 'csv'){
                                
                                $file_path = WTG_C2P_CONTENTFOLDER_DIR . '/' . $csvfile_name;
                                $thefilesize = filesize($file_path);
                                $filesize_total = $thefilesize;
                                
                                $filemtime = filemtime(WTG_C2P_CONTENTFOLDER_DIR . '/' .$csvfile_name);
                                
                                if(phpversion() < '5.3'){
                                    $fileage = '';### TODO:MEDIUMPRIORITY,add a PHP 5.2 function for determing file age
                                }else{
                                    // this line is only suitable for PHP 5.3
                                    $fileage =  csv2post_ago( date_create(date(WTG_C2P_DATEFORMAT,$filemtime)),true,true,true,true,true,false);
                                }
                                   
                                echo '
                                <tr>                               
                                    <td>'.$job['name'].'</td>                                
                                    <td>'.$csvfile_name.'</td>                            
                                    <td>'.count(file(WTG_C2P_CONTENTFOLDER_DIR . '/' .$csvfile_name)).'</td>
                                    <td>'.csv2post_format_file_size($thefilesize).'</td>
                                    <td>'.csv2post_WP_SQL_count_records_forfile('csv2post_'.$jobid,$csvfile_name,$key).'</td>                                                       
                                    <td>'.$fileage.'</td>                            
                                </tr>';                    
                                
                            }// end if csv
                            
                        }// end if $filename = .
                        
                        ++$usedcsvfile_count;
                    }    
                }
            }
   
            echo '</table>';
            
            csv2post_notice_filesizetotal($filesize_total);

            // clear stored values
            clearstatcache();

        }// end $opendir_result
    }
    
    return $usedcsvfile_count;         
}
   
/**
* Returns human readable time passed since giving date.
* Years,months etc all separated with comma and as plurals where required.
* 
* PHP 5.3 or above only
* 
* @param mixed $datetime 
* @param boolean $use_year (this will only be used if value is not 0)
* @param boolean $use_month (this will also only be used if value is not 0)
* @param boolean $use_day
* @param boolean $use_hour
* @param boolean $use_minute
* @param boolean $use_second (false by default)
*/
function csv2post_ago( $datetime,$use_year = true,$use_month = true,$use_day = true,$use_hour = true,$use_minute = true,$use_second = false ){
 
    // PHP 5.3 method is currently the best             
    $interval = date_create('now')->diff( $datetime );
    
    $ago_string = ' ';
             
    // year
    if($use_year){
        if ( $interval->y >= 1 ){
            $ago_string .= csv2post_pluralize( $interval->y, 'year' );        
        } 
    }

    // month
    if($use_month){
        if ( $interval->m >= 1 ){
            $ago_string_with_comma_month = csv2post_commas($ago_string); 
            $ago_string = $ago_string_with_comma_month . csv2post_pluralize( $interval->m, 'month' );        
        } 
    }  
        
    // day
    if($use_day){
        if ( $interval->d >= 1 ){
            $ago_string_with_comma_day = csv2post_commas($ago_string);            
            $ago_string = $ago_string_with_comma_day . csv2post_pluralize( $interval->d, 'day' );        
        } 
    }
    
    // hour
    if($use_hour){
        if ( $interval->h >= 1 ){
            $ago_string_with_comma_hour = csv2post_commas($ago_string);            
            $ago_string = $ago_string_with_comma_hour . csv2post_pluralize( $interval->h, 'hour' );        
        } 
    }       
 
    // minute
    if($use_hour){
        if ( $interval->m >= 1 ){
            $ago_string_with_comma_minute = csv2post_commas($ago_string);            
            $ago_string = $ago_string_with_comma_minute . csv2post_pluralize( $interval->m, 'minute' );        
        } 
    }

    // second
    if($use_second){
        if ( $interval->s >= 1 ){
            $ago_string_with_comma_second = csv2post_commas($ago_string);            
            $ago_string = $ago_string_with_comma_second . csv2post_pluralize( $interval->s, 'second' );        
        } 
    }    
    
    return $ago_string;
}

/**
* Echoes the data import jobs csv files in options for form menu
* 
* @param string $jobcode
*/
function csv2post_menu_options_job_csvfiles($jobcode){
    $job_array = csv2post_get_dataimportjob($jobcode);
    if(!$job_array || !is_array($job_array)){
        echo '<option value="error">Error:job array could not be found</option>';
        return;
    }

    // get job array
    foreach($job_array['files'] as $key => $csv_filename){ 
        // we need to remove ".csv" but do not change filename to lowercase (due to case sensitive file functions)
        $csv_filename_cleaned = str_replace('.csv','',$csv_filename); 
        echo '<option value="'.$csv_filename_cleaned.'">'.$csv_filename.'</option>';
    }   
}  

/**
* Creates url to an admin page
*  
* @param mixed $page, registered page slug i.e. csv2post_install which results in wp-admin/admin.php?page=csv2post_install   
* @param mixed $values, pass a string beginning with & followed by url values
*/
function csv2post_link_toadmin($page,$values = ''){
    return get_admin_url() . 'admin.php?page=' . $page . $values;
}   

/**
* List of CSV files for use on form as it has checkbox/radio for deleting files
*/
function csv2post_csv_files_list(){
    global $csv2post_is_free,$csv2post_plugintitle;
    
    $available = 0;
 
    if (!is_dir(WTG_C2P_CONTENTFOLDER_DIR)) {
    
        echo csv2post_notice('The content folder does not exist, has it been deleted or move?','error','Small','','','return');
                   
    }else{    
        
        @$opendir_result = opendir( WTG_C2P_CONTENTFOLDER_DIR );
        
        if(!$opendir_result){
            
            echo csv2post_notice($csv2post_plugintitle . ' does not have permission to open the plugins content folder','error','Small','','','return');

        }else{

            echo '
            <table class="widefat post fixed">
                <tr class="first">
                    <td width="50"><strong>Delete</strong></td>
                    <td width="175"><strong>Name</strong></td>
                    <td width="80"><strong>Separator (plugin)</strong></td>                    
                    <td width="80"><strong>Separator (pear)</strong></td>
                    <td width="75"><strong>Columns (pear)</strong></td>                    
                    <td width="75"><strong>Rows</strong></td>
                    <td><strong>Size</strong></td>                                                       
                </tr>';  
            
            $filesize_total = 0;
                
            while( false != ( $filename = readdir( $opendir_result ) ) ){
                if( ($filename != ".") and ($filename != "..") ){
                    
                    $fileChunks = explode(".", $filename);
                                      
                    // ensure file extension is csv
                    if( isset( $fileChunks[1] ) && $fileChunks[1] == 'csv'){
                        
                        $file_path = WTG_C2P_CONTENTFOLDER_DIR . '/' . $filename;
                        $thefilesize = filesize($file_path);
                        $filesize_total = $thefilesize;

                        $sep_fget = csv2post_establish_csvfile_separator_fgetmethod($filename,false );                           
                        $sep_PEARCSV = csv2post_establish_csvfile_separator_PEARCSVmethod($filename,false); 
                        
                        echo '
                        <tr>
                            <td>';?>
                            
                            <?php 
                            // if free only allow a single file at a time
                            $objects = 'checkbox';
                            if($csv2post_is_free){
                                $objects = 'radio';
                            }
                            ?>
            
                            <script>
                            $(function() {
                                $( "#csv2post_deletecsvfile_<?php echo $objects;?>_<?php echo $fileChunks[0];?>" ).buttonset();
                            });
                            </script>

                            <div id="csv2post_deletecsvfile_<?php echo $objects;?>_<?php echo $fileChunks[0];?>">                    
                                <input type="<?php echo $objects;?>" name="csv2post_delete_csvfiles[]" id="csv2post_delete_csvfiles_<?php echo $fileChunks[0];?>" value="<?php echo $filename;?>" />
                                <label for="csv2post_delete_csvfiles_<?php echo $fileChunks[0];?>">*</label>                     
                            </div>                         
                         
                        <?php     
                        echo '</td>
                            <td>'.$filename.'</td>
                            <td>'.$sep_fget.'</td>                            
                            <td>'.$sep_PEARCSV.'</td>
                            <td>'.csv2post_establish_csvfile_fieldcount_PEAR($filename).'</td>                            
                            <td>'.count(file(WTG_C2P_CONTENTFOLDER_DIR . '/' .$filename)).'</td>
                            <td>'.csv2post_format_file_size($thefilesize).'</td>                                                                                    
                        </tr>';                    
                        
                    }// end if csv
                    
                }// end if $filename = .  
            }// end while    
                 
            echo '</table>';
            
            csv2post_notice_filesizetotal($filesize_total);

            // clear stored values
            clearstatcache();

        }// end $opendir_result
    }     
}

function csv2post_menu_csvfile_headers($id,$jobcode,$f){
    $job_array = csv2post_get_dataimportjob($jobcode);
    
    // clean filename for appending to object id
    $fc = explode(".", $f);
    
    $menu = '
    <select id="csv2post_csvfileheader_'.$id.'_'.$fc[0].'" name="csv2post_csvfileheader_'.$id.'_'.$fc[0].'" class="csv2post_multiselect_menu">
        <option value="notselected">No Column Header Selected</option>';

        foreach($job_array[$f]['headers'] as $key => $c){

            $menu .= '<option value="'.$c['original'].'">'.$c['original'].'</option>';
        }

    $menu .= '</select>';   
    
    return $menu;   
}  

/**
* Displays menu of all categories
*  
* @param mixed $increment
*/
function csv2post_display_categories_menu($increment){?>
    <select name="csv2post_createcategorymapping<?php echo $increment;?>_select" id="csv2post_createcategorymapping<?php echo $increment;?>_select_id" class="csv2post_multiselect_menu">                               
        <option value="notselected">Not Selected</option>       
        <?php csv2post_display_categories_options($current_value);?>                                                                                                                   
    </select><?php    
}

/**
* Displays a table of data from giving table name
* 
* @param mixed $jt
* @todo add parameter for ORDER DESC and ASC
*/
function csv2post_display_sample_data($table_name,$limit = 10,$columns = '*'){

    // if table does not exist
    if(!csv2post_WP_SQL_does_table_exist($table_name)){
        csv2post_n_incontent('Table named ' . $table_name . ' no longer exists','info','Small');
        return;
    }
    
    // if table does not have any records
    if(csv2post_WP_SQL_counttablerecords($table_name) == 0){
        csv2post_n_incontent('There are no records in the table named ' . $table_name,'info','Small');
        return;
    }
    
    // execute query
    $records = csv2post_WP_SQL_select($table_name,$limit,$columns);

    // build first row of headers
    echo '<table class="widefat post fixed">
        <tr class="first">';

        foreach($records as $key => $r){

            foreach($r as $t => $a){
                echo '<td width="150"><strong>'. $t .'</strong></td>';
            }
            
            break;
        }
            
    echo '</tr>';
        
        foreach($records as $key => $r){
            
            echo '<tr>';
                
            foreach($r as $t => $a){
                echo '<td>'. $a .'</td>';
            }
            
            echo '</tr>';
        }
    
    echo '</table>';           
} 

/**
* Loops through giving projects tables and prints <option> item for menu for each column header.
* Table and column are added to value with comma delimeter. Use csv2post_explode_tablecolumn_returnnode to split the submitted value
* 
* @deprecated 29th January 2013 use csv2post_GUI_menuoptions_project_columnsandtables() instead
*/
function csv2post_display_project_columnsandtables_menuoptions($project_code,$current_table = 'NOTPROVIDED98723462',$current_column = 'NOTPROVIDED09871237'){
    
    if(!$project_code){
        echo '<option value="nocurrentproject">No Current Project</option>';        
    }else{

        global $csv2post_project_array;

        foreach( $csv2post_project_array['tables'] as $key => $table ){
            $table_columns = csv2post_WP_SQL_get_tablecolumns($table);
            
            if($table_columns == false){
                
                echo '<option value="fault">Problem Detected In Relation To Table Named: '.$table.'</option>';        
            
            }else{
                while ($row_column = mysql_fetch_row($table_columns)) {

                    // establish selected status for this option
                    $selected = '';
                    
                    ### TODO:MEDIUMPRIORITY change these not provided values all over the plugin
                    ### we use a random number so that it can never match a users own column name but this approach has not been used everywhere
                    if($current_table != 'NOTPROVIDED98723462' && $current_column != 'NOTPROVIDED09871237'){
                        if($current_table == $table && $current_column == $row_column[0]){
                            $selected = ' selected="selected"';
                        }    
                    } 
                    
                    // must add table name also to avoid confusion when two or more tables share the same column name               
                    echo '<option value="'.$table.','.$row_column[0].'"'.$selected.'>' . $table . ' - '.$row_column[0].'</option>'; 
                }  
            }                        
        } 
    }  
}

/**
* Loops through giving projects tables and prints <option> item for menu for each column header.
* Table and column are added to value with comma delimeter. Use csv2post_explode_tablecolumn_returnnode to split the submitted value
* 1. Save boolean false when the default form item is submitted
*/            
function csv2post_GUI_menuoptions_project_columnsandtables($project_code,$atts){
    if(!$project_code){
        echo '<option value="nocurrentproject">No Current Project</option>';        
    }else{

        global $csv2post_project_array;

        extract( shortcode_atts( array(
                'table' => false,
                'column' => false,
                'usedefault' => true,// boolean, true adds No Selection Made as default option                 
        ), $atts ) );        

        if($usedefault){
            echo '<option value="noselectionmade">No Selection Made</option>';
        }
        
        foreach( $csv2post_project_array['tables'] as $key => $t ){
            $table_columns = csv2post_WP_SQL_get_tablecolumns($t);
            
            if($table_columns == false){
                
                echo '<option value="noselectionmade">Problem Detected In Relation To Table Named: '.$t.'</option>';        
            
            }else{
                while ($row_column = mysql_fetch_row($table_columns)) {

                    // establish selected status for this option (the default for form menus is false)
                    if($table != false 
                    && $table == $t 
                    && $column != false
                    && $column == $row_column[0]){
                        $selected = ' selected="selected"';
                    }else{
                        $selected = '';
                    }    
 
                    // must add table name also to avoid confusion when two or more tables share the same column name               
                    echo '<option value="'.$t.','.$row_column[0].'"'.$selected.'>' . $t . ' - '.$row_column[0].'</option>'; 
                }  
            }                        
        } 
    }  
}                                                                                                             
?>