<?php
function wtgcsv_page_toppage(){wtgcsv_include_form_processing_php();require_once(WTG_CSV_DIR.'pages/pagemain/wtgcsv_main.php');}
function wtgcsv_page_data(){wtgcsv_include_form_processing_php();require_once(WTG_CSV_DIR.'pages/data/wtgcsv_main_data.php');}
function wtgcsv_page_projects(){wtgcsv_include_form_processing_php();require_once(WTG_CSV_DIR.'pages/projects/wtgcsv_main_projects.php');}                
function wtgcsv_page_creation(){wtgcsv_include_form_processing_php();require_once(WTG_CSV_DIR.'pages/creation/wtgcsv_main_creation.php');}
function wtgcsv_page_settings(){wtgcsv_include_form_processing_php();require_once(WTG_CSV_DIR.'pages/settings/wtgcsv_main_settings.php');}
function wtgcsv_page_install(){wtgcsv_include_form_processing_php();require_once(WTG_CSV_DIR.'pages/install/wtgcsv_main_install.php');}
function wtgcsv_page_more(){wtgcsv_include_form_processing_php();require_once(WTG_CSV_DIR.'pages/more/wtgcsv_main_more.php');}

function wtgcsv_include_form_processing_php(){
    global $wtgcsv_debug_mode;
    
    // if $wtgcsv_debug_mode set to true or 1 on wordpresscsvimporter.php we dump $_POST
    if($wtgcsv_debug_mode){
        echo '<h1>$_POST</h1>';
        echo '<pre>';
        var_dump($_POST);
        echo '</pre>';            
        echo '<h1>$_GET</h1>';
        echo '<pre>';
        var_dump($_GET);
        echo '</pre>';    
    }
    
    // include file that checkes $_POST values and takes required actions    
    require_once(WTG_CSV_DIR.'templatesystem/include/wtgcsv_form_processing.php');
}
 
/**
* Wordpress navigation menu
*/
function wtgcsv_admin_menu(){
   global $wtgcsv_mpt_arr,$wtgtp_homeslug,$wtgcsv_pluginname,$wtgcsv_is_installed;
                         
   $n = $wtgcsv_pluginname;
    
   // if plugin not installed (manual action by admin) then display install page wtgcsv_is_installed set
   if(!$wtgcsv_is_installed){
        add_menu_page(__('Install',$n.$wtgcsv_mpt_arr['install']['slug']), __($wtgcsv_mpt_arr['install']['menu'],'install'), 'administrator', $wtgcsv_mpt_arr['install']['slug'], WTG_CSV_ABB . 'page_install' );
   }else{
        add_menu_page(__($wtgcsv_mpt_arr['main']['title'],$n.$wtgcsv_mpt_arr['main']['slug']), __($wtgcsv_mpt_arr['main']['menu'],'home'), $wtgcsv_mpt_arr['main']['role'], $n, WTG_CSV_ABB . 'page_toppage' );
        add_submenu_page($n, __($wtgcsv_mpt_arr['data']['title'],$n.$wtgcsv_mpt_arr['data']['slug']), __($wtgcsv_mpt_arr['data']['menu'],$n.$wtgcsv_mpt_arr['data']['slug']), $wtgcsv_mpt_arr['data']['role'], $wtgcsv_mpt_arr['data']['slug'], WTG_CSV_ABB . 'page_data');        
        add_submenu_page($n, __($wtgcsv_mpt_arr['settings']['title'],$n.$wtgcsv_mpt_arr['settings']['slug']), __($wtgcsv_mpt_arr['settings']['menu'],$n.$wtgcsv_mpt_arr['settings']['slug']), $wtgcsv_mpt_arr['settings']['role'], $wtgcsv_mpt_arr['settings']['slug'], WTG_CSV_ABB . 'page_settings');
        add_submenu_page($n, __($wtgcsv_mpt_arr['install']['title'],$n.$wtgcsv_mpt_arr['install']['slug']), __('Plugin Status',$n.$wtgcsv_mpt_arr['install']['slug']), $wtgcsv_mpt_arr['install']['role'], $wtgcsv_mpt_arr['install']['slug'], WTG_CSV_ABB . 'page_install');
    }
}

/**
* Checks all critical template system files and returns
* @uses wtgcsv_jquery_status_list_portlets(), for this function the script is placed at the top of the tab file 
*/
function wtgcsv_templatefiles_statuslist(){
    global $wtgcsv_templatesystem_files;
    
    wtgcsv_jquery_status_list_portlets();
    
    foreach( $wtgcsv_templatesystem_files as $key => $fileitem ){
        
        $path = '';
        $viewedpath = '';          
        $path .= WTG_CSV_DIR . 'templatesystem' . $fileitem['path'] . $fileitem['name'];
        $viewedpath .= WTG_CSV_FOLDERNAME . '/templatesystem' . $fileitem['path'] . $fileitem['name'];
                
        $pointer = ' ';
         
        if($fileitem['extension'] != 'folder'){        
            $path .= '.' . $fileitem['extension'];
            $viewedpath .= '.' . $fileitem['extension'];            
            $pointer = '.'; 
        }

        if(!file_exists($path)){?>
            <div class="portlet">
                <div class="portlet-header-2"> <?php echo $fileitem['name'].$pointer.$fileitem['extension'];?> </div>
                <div class="portlet-content"><?php echo $viewedpath; ?></div>
            </div><?php 
        }else{?><div class="portlet">
                <div class="portlet-header"> <?php echo $fileitem['name'].$pointer.$fileitem['extension'];?> </div>
                <div class="portlet-content"><?php echo $viewedpath; ?></div>
            </div><?php 
           
        }  
    }
}

/**
 * Adds Script Start and Stylesheets to the beginning of pages
 */
function wtgcsv_header_page($pagetitle,$layout){
    global $wtgcsv_mpt_arr,$wtgcsv_adm_set,$wtgcsv_pub_set,$wtgcsv_currentproject_code,$wtgcsv_is_free;

    $wtgcsv_adm_set = get_option('wtgcsv_adminset');  
    $wtgcsv_pub_set = get_option('wtgcsv_pubicset');

    wtgcsv_jquery_button();?> 

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
        // decide if user is probably activating for the first time and display message accordingly
        wtgcsv_first_activation_check();?>
    
        <div id="icon-options-general" class="icon32"><br /></div>
        <h2><?php echo $pagetitle;?></h2>

        <?php 
        // display all notifications (both new ones as a result of form submission and persistent messages)
        wtgcsv_notice_output();?>
        
        <?php 
        // process global security and any other types of checks here such such check systems requirements, also checks installation status
        $wtgcsv_requirements_missing = wtgcsv_check_requirements(true);?>

        <div class="postbox-container" style="width:99%">
                <div class="metabox-holder">
                        <div class="meta-box-sortables"><?php
}

/**
* Returns the current projects name as entered by
*/
function wtgcsv_get_current_project_name(){
    global $wtgcsv_currentproject_code,$wtgcsv_projectslist_array;
    if(!isset($wtgcsv_projectslist_array[$wtgcsv_currentproject_code]['name'])){
        return 'No Current Project';
    }else{
        return $wtgcsv_projectslist_array[$wtgcsv_currentproject_code]['name'];
    }   
}

/**
*  Returns current job name or string indicating no current job if none 
*/
function wtgcsv_get_current_job_name(){
    global $wtgcsv_currentjob_code,$wtgcsv_job_array;
    if(!isset($wtgcsv_job_array['name'])){
        return 'No Current Job';
    }else{
        return $wtgcsv_job_array['name'];
    }    
}

/**
* Uses installation and activation state checkers to determine if the plugin
* 1. is being activated in Wordpress
* and
* 2. it is the FIRST time it is being activated (due to no trace of previous installation)
*/
function wtgcsv_first_activation_check(){
    ### TODO:HIGHPRIORITY, use  wtgcsv_was_installed  then display message according to result
}

/**
 * Calls wtgtp_jquery_opendialog (with close button)
 * 
 * Intended use is to display information, tutorial video etc
 *
 * @param array
 */
function wtgcsv_helpbutton_closebox($panel_array){

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
    'panel_url' => 'http://www.importcsv.eu/support',
    'help_button' => 'Help' 
    ), $panel_array ) );   
    
    // call jquery for dialogue on button press
    wtgcsv_jquery_opendialog_helpbutton($panel_number,$panel_intro,$panel_title,$panel_help,$panel_icon,$panel_name,$panel_url);?>
                                  
    <!-- dialogue div, displayed when help button clicked -->
    <div id="wtgcsv_helpbutton-<?php echo $panel_number;?>" title="<?php echo $panel_title;?>">
        <p style="font-size: 16px;"><?php echo $panel_help;?></p>
    </div> 
    
    <!-- help button -->
    <div class="jquerybutton">
        <button id="wtgcsv_opener<?php echo $panel_number;?>"><?php echo $help_button;?></button> <?php echo $panel_intro;?>
    </div>
    
    <?php
    //  BOOKMARK BUTTON FORM
    // adds the current tab as a box on the main page under bookmarks tab
    // TODO: HIGHPRIORITY, complete this form submission, it must update the main page bookmarks
    wtgcsv_formstart_standard(wtgcsv_create_formname($panel_name,'_bookmark'),wtgcsv_create_formid($panel_name,'_bookmark'),'post','wtgcsv_form','');
    wtgcsv_hidden_form_values($panel_number,$pageid,$panel_name,$panel_title,$panel_number);
    echo '<input type="hidden" id="'.WTG_CSV_ABB.'hidden_bookmarkrequest" name="'.WTG_CSV_ABB.'hidden_bookmarkrequest" value="'.$tabnumber.'">';    
    echo '</form>';    
}

/**
 * Displays author and adds some required scripts
 */
function wtgcsv_footer(){?>
 
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
function wtgcsv_easy_configuration_questionlist_demo(){
    global $wtgcsv_easyquestions_array;
             
    // count number of each type of question added for adding ID value to script
    $singles_created = 0;// count number of single answer questions added (radio button)
    $multiple_created = 0;
    $text_created = 0;
    $slider_created = 0;
    $noneactive = 0; 
            
    foreach($wtgcsv_easyquestions_array as $key => $question){
        
        if($question['active'] != true){
        
            ++$slider_created;
            
        }else{
                
            if($question['type'] == 'single'){?>
                        
                <script type="text/javascript">
                $(function(){
                    $("select#<?php echo WTG_CSV_ABB.'single'.$singles_created;?>").multiselect({
                       // TODO: LOWPRIORITY, get single select working, it still shows checkboxes instead of a radio button approach
                       selectedList: 10,
                       minWidth: 600,
                       multiple: false,
                       header: "Please select a single option",
                       noneSelectedText: "Please select a single option",
                       selectedList: 1   
                    });
                });
                </script>

                <?php
                // build list of option values
                $opt_array = explode(",", $question['answers']);
                $optionlist = '';
                foreach($opt_array as $key => $optanswer){
                    $optionlist .= '<option value="'.$optanswer.'"> '.$optanswer.' </option> ';     
                } 
           
                echo wtgcsv_notice($question['question'] . ' ' . wtgcsv_link('?',$question['helpurl'],'','_blank','','return','Click here to get more help for this question') .'
                <p> 
                    <select id="'.WTG_CSV_ABB.'single'.$singles_created.'" title="Please click on a single option" multiple="multiple" name="example-basic" class="wtgcsv_multiselect_menu">
                        '.$optionlist.'
                    </select>
                </p>','question','Small','','','return');?>

                <?php ++$singles_created;
                
            }elseif($question['type'] == 'multiple'){?>
                   
                <script type="text/javascript">
                $(function(){
                    $("select#<?php echo WTG_CSV_ABB.'multiple'.$multiple_created;?>").multiselect({
                        selectedList: 10,
                        minWidth: 600,
                        header: "Please select one or more options",
                        noneSelectedText: "Please select one or more options",
                    });
                });
                </script>

                <?php 
                // build list of option values
                $opt_array = explode(",", $question['answers']);
                $optionlist = '';
                foreach($opt_array as $key => $optanswer){
                    $optionlist .= '<option value="'.$optanswer.'"> '.$optanswer.' </option> ';     
                } 
                             
                echo wtgcsv_notice($question['question'] . ' ' . wtgcsv_link('?',$question['helpurl'],'','_blank','','return','Click here to get more help for this question') .'
                <p> 
                    <select id="'.WTG_CSV_ABB.'multiple'.$multiple_created.'" title="You may select multiple options" multiple="multiple" name="example-basic" class="wtgcsv_multiselect_menu">
                        '.$optionlist.'
                    </select>
                </p>','question','Small','','','return');?>
                
                <script type="text/javascript">
                $("select#<?php echo WTG_CSV_ABB.'multiple'.$multiple_created;?>").multiselect().multiselectfilter();
                </script>
                
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
                    
                    $( "#<?php echo WTG_CSV_ABB . 'text'.$text_created;?>" ).autocomplete({
                        source: availableTags
                    });
                });
                </script>

                <?php  
                echo wtgcsv_notice($question['question'] . ' ' . wtgcsv_link('?',$question['helpurl'],'','_blank','','return','Click here to get more help for this question') .'
                <div class="ui-widget">
                    <p>
                        <label for="'. WTG_CSV_ABB . 'text'.$text_created .'">Tags: </label>
                        <input id="'. WTG_CSV_ABB . 'text'.$text_created .'" />
                    </p>
                </div>','question','Small','','','return');?>

                <?php ++$text_created;
            }elseif($question['type'] == 'slider'){?>

                <style>
                #demo-frame > div.demo { padding: 10px !important; };
                </style>
                <script>
                $(function() {
                    $( "#<?php echo WTG_CSV_ABB;?>slider-range-min<?php echo $slider_created;?>" ).slider({
                        range: "min",
                        value: 20,
                        min: 1,
                        max: 5000,
                        slide: function( event, ui ) {
                            $( "#amount<?php echo $slider_created;?>" ).val( "" + ui.value );
                            //                   ^ prepend value
                        }
                    });
                                      
                    $( "#amount<?php echo $slider_created;?>" ).val( "" + $( "#<?php echo WTG_CSV_ABB;?>slider-range-min<?php echo $slider_created;?>" ).slider( "value" ) );
                    //                   ^ prepend value
                });
                </script>

                <?php  
                echo wtgcsv_notice($question['question'] . ' ' . wtgcsv_link('?',$question['helpurl'],'','_blank','','return','Click here to get more help for this question') .'
                <p> 
                    <div id="wtgcsv_slider-range-min'. $slider_created .'"></div> 
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
    $wtgcsv_is_dev = true;// ### TODO:HIGHPRIORITY, change this to the global   
    if($wtgcsv_is_dev){
        
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
function wtgcsv_logfile_exists_notice($logtype){
    global $wtgcsv_adm_set;
    $fileexists_result = wtgcsv_logfile_exists($logtype);
    
    if($fileexists_result){
        if($wtgcsv_adm_set['log_'.$logtype.'_active'] == true){
            echo wtgcsv_notice('Your '.ucfirst($logtype).' Log file exists and is active'.
            wtgcsv_formstart_standard('wtgcsv_activatelogfile_'.$logtype,'none','post','').'
            <button class="button" name="wtgcsv_deletelogfile">Delete</button>
            <button class="button" name="wtgcsv_disablelogfile">Disable</button>
            <button class="button" name="wtgcsv_viewlogfile">View</button>                        
            <input type="hidden" name="wtgcsv_logtype" value="'.$logtype.'">
        </form>', 'success', 'Small', false,'','return');
        }else{
            echo wtgcsv_notice('Your '.ucfirst($logtype).' Log file exists but is not active'.
            wtgcsv_formstart_standard('wtgcsv_activatelogfile_'.$logtype,'none','post','').'
            <button class="button" name="wtgcsv_deletelogfile">Delete</button>            
            <button class="button" name="wtgcsv_activatelogfile">Activate</button>
            <button class="button" name="wtgcsv_viewlogfile">View</button>            
            <input type="hidden" name="wtgcsv_logtype" value="'.$logtype.'">
        </form>', 'info', 'Small', false,'','return');
        }
    }elseif(!$fileexists_result){
        echo wtgcsv_notice('Your '.ucfirst($logtype).' Log file does not exist'.
            wtgcsv_formstart_standard('wtgcsv_createlogfile_'.$logtype,'none','post','').'
            <button class="button" name="wtgcsv_createlogfile">Create</button>
            <input type="hidden" name="wtgcsv_logtype" value="'.$logtype.'">        
        </form>', 'warning', 'Small', false,'','return');
    }
}

/**
* Displays the status of the content folder with buttons to delete or create the folder
* 
* @param mixed $logtype
*/
function wtgcsv_contentfolder_display_status(){
    
    $contentfolder_exists = wtgcsv_contentfolder_exist();
    
    if($contentfolder_exists){

        echo wtgcsv_notice('Content folder exists'.
        wtgcsv_formstart_standard('wtgcsv_deletecontentfolder_form','none','post','').'
            <button class="button" name="wtgcsv_contentfolder_delete">Delete</button>                        
        </form>', 'success', 'Small', false,'','return');

    }elseif(!$contentfolder_exists){
        echo wtgcsv_notice('Content folder does not exist'.
        wtgcsv_formstart_standard('wtgcsv_createcontentfolder_form','none','post','').'
            <button class="button" name="wtgcsv_contentfolder_create">Create</button>        
        </form>', 'error', 'Small', false,'','return');
    }
}

/**
* Checks if content folder has been created or not
* 
* @return boolean false if folder does not exist, true if it does 
*/
function wtgcsv_contentfolder_exist(){
    return file_exists(WTG_CSV_CONTENTFOLDER_DIR);    
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
function wtgcsv_viewhistory($filter_array){

    // select log file
    if($filter_array['logfile'] == 'general'){$log_file = 'wtgcsv_log_general.csv';$logtype = 'general';}
    elseif($filter_array['logfile'] == 'sql'){$log_file = 'wtgcsv_log_sql.csv';$logtype = 'sql';}
    elseif($filter_array['logfile'] == 'admin'){$log_file = 'wtgcsv_log_admin.csv';$logtype = 'admin';}
    elseif($filter_array['logfile'] == 'user'){$log_file = 'wtgcsv_log_user.csv';$logtype = 'user';}
    elseif($filter_array['logfile'] == 'error'){$log_file = 'wtgcsv_log_error.csv';$logtype = 'error';}
    else{$log_file = 'wtgcsv_log_general.csv';$logtype = 'general';}
                
    // check if file exists
    $logfileexists_result = wtgcsv_logfile_exists($logtype);

    // if file exists continue
    if(!$logfileexists_result){
        
        wtgcsv_notice('The log file for recording installation entries does not appear to exist. This may be because log recording is not active or
        permissions are preventing the history file being created. This is not an error. 
        <br /><br />
        '.wtgcsv_formstart_standard('wtgcsv_createlogfile','none','post','').'
            <button class="button" name="wtgcsv_createlogfile">Create Log File Now</button>
            <input type="hidden" name="wtgcsv_createlogfile_1" value="true">
            <input type="hidden" name="wtgcsv_logtype" value="'.$logtype.'">
        </form>', 'warning', 'Extra', __(ucfirst($filter_array['logfile']) . ' Log File Not Located'));
        
    }else{
        // include PEAR CSV
        wtgcsv_pearcsv_include();

        // PEAR CSV reads file and gets configuration
        $logfile_conf = File_CSV::discoverFormat(wtgcsv_logfilepath($filter_array['logfile']));

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
        while ( ( $logrow = File_CSV::read(wtgcsv_logfilepath($filter_array['logfile']), $logfile_conf ) ) ){
            // if on first row we echo table title
            if($rows_looped == 0){
                echo $tablehead_complete;
            }else{
                wtgcsv_log_table($logrow);
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
function wtgcsv_log_table($logrow){
    $row = '<td width="35"></td><td width="125">'.$logrow['0'].'</td>';// PROJECTDATE
    $row .= '<td width="35"></td><td width="125">'.$logrow['1'].'</td>';// DATE
    $row .= '<td width="35"></td><td>'.$logrow['6'].'</td>';// ACTION
    $row .= '</tr>';
    echo $row;
}
                                        
/**
 * Display a notice box per option record
 * 
 * @todo finish urls
 */
function wtgcsv_install_optionstatus_list(){

    if(get_option('wtgcsv_adminset')){
        wtgcsv_notice('wtgcsv_adminset is installed', 'success', 'Small', false);
    }else{
        wtgcsv_notice('wtgcsv_adminset not installed <a class="button" href="'.wtgcsv_currenturl().'&test=test">Install Now</a>', 'error', 'Small', false);
    }

    if(get_option('wtgcsv_publicset')){
        wtgcsv_notice('wtgcsv_publicset is installed', 'success', 'Small', false);
    }else{
        wtgcsv_notice('wtgcsv_publicset not installed <a class="button" href="'.wtgcsv_currenturl().'&test=test">Install Now</a>', 'error', 'Small', false);
    } 
}

/**
 * Checks if plugins minimum requirements are met and displays notices if not
 * Checks: Internet Connection (required for jQuery), PHP version, Soap Extension
 * 
 * @todo HIGH PRIORITY check the status of all external files mainly jquery then display warnings i.e.  http://hotlink.jquery.com/jqueryui/jquery-1.6.2.js?ver=3.2.1
 * @todo HIGH PRIORITY begin a system to deal with missing jquery if even possible so that the interface is not unusable
 */
function wtgcsv_check_requirements($display){
    // variable indicates message being displayed, we will only show 1 message at a time
    $requirement_missing = false;

    // php version
    if(defined("WTG_CSV_PHPVERSIONMINIMUM")){
        if(WTG_CSV_PHPVERSIONMINIMUM > phpversion()){
            $requirement_missing = true;
            if($display == true){
                wtgcsv_notice('The plugin detected an older php version than the minimum requirement which is '.WTG_CSV_PHPVERSIONMINIMUM.'. Wordpress itself also operates better with a later version of php than you are using. Most features will work fine but some important ones will not.','warning','Large','Wordpress CSV Importer Requires PHP '.WTG_CSV_PHPVERSIONMINIMUM);
            }
        }
    }
    
    // soap extension and SoapClient class required for Priority Level Support
    global $wtgcsv_is_domainregistered;
    if($wtgcsv_is_domainregistered){
        $extensioninstalled_result = wtgcsv_is_extensionloaded('soap');
        if(!$extensioninstalled_result){
            $requirement_missing = true;
            if($display == true){
                wtgcsv_notice('Your server does not have the soap extension loaded. This is required for '.WTG_CSV_PLUGINTITLE.' premium edition and the premium services offered by WebTechGlobal.','error','Extra','Soap Extension Required');
            }
        }else{
            // now confirm SoapClient class exists
            if (!class_exists('SoapClient')) {
                $requirement_missing = true;
                if($display == true){
                    wtgcsv_notice('SoapClient class does not exist and is required by '.WTG_CSV_PLUGINTITLE.' for the premium edition and premium web services.','error','Extra','SoapClient Class Required');            
                }
            }            
        }
    }
    
    return $requirement_missing;
}

/**
 * Calls wtgtp_jquery_opendialog (no buttons) to apply jQuery to button and display dialogue box
 * @param integer $used (number of times function used equals number of buttons and $used acts as an ID)
 * @param string $title (title of the dialogue box)
 * @param string $content (content in the dialogue box)
 * 
 * @todo check if this function is in use, if not remove it. It should be an depreciated function
 */
function wtgcsv_helpbutton($used,$intro,$title,$content){
    // call jquery for dialogue on button press
    wtgcsv_jquery_opendialog($used);?>

    <div id="<?php echo WTG_CSV_ABB;?>dialog<?php echo $used;?>" title="<?php echo $title;?>">
        <p><?php echo $content;?></p>
    </div>

    <!--<div class="jquerybutton">-->
    <div class="jquerybutton">
        <button id="<?php echo WTG_CSV_ABB;?>opener<?php echo $used;?>">Video Tutorial</button> <?php echo $intro;?>
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
function wtgcsv_feedburner_widget($feed_slug) {
    echo '<script src="http://feeds.feedburner.com/'.$feed_slug.'?format=sigpro" type="text/javascript" ></script><noscript><p>Subscribe to RSS headline updates from: <a href="http://feeds.feedburner.com/'.$feed_slug.'"></a><br/>Powered by FeedBurner</p> </noscript>';
}

/**
 * Adds a widget to thedashboard showing plugins RSS updates
 */
function wtgcsv_add_dashboard_rsswidget() {
    global $wtgcsv_plugintitle;
    wp_add_dashboard_widget('wtgtp_rsswidget_dashboard', $wtgcsv_plugintitle.' Updates', 'wtgcsv_feedburner_widget');
}

/**
 * Echos file size formatted to suit size and ensures file exists before using formatting function
 * @uses eci_csvfileexists
 * @param path $file_path
 *
 * @todo add function to check file_path exists
 */
function wtgcsv_displayfilesize($file_path){
   //$exists = eci_csvfileexists(basename($filepath), $pro);
   $exists = true;
   if($exists == true){
      echo wtgcsv_format_file_size(filesize($file_path));
   }else{
      echo 0;
   }
}

/**
* Builds URL too the Contact screen
* 
*/
function wtgcsv_contactscreen_url(){
    //return get_admin_url(null,'admin.php?page=wtgcsv_more&wtgcsv_tab=tab10_more');   OLD TAB METHOD     
    return get_admin_url(null,'admin.php?page=wtgcsv_more#tabs-9');// new jquery tabs method
}

/**
 * Add hidden form fields, to help with processing and debugging
 * Adds the wtgcsv_form_processing_required value, required to call the form validation file
 *
 * @param integer $pageid (the id used in page menu array)
 * @param slug $panel_name (panel name form is in)
 * @param string $panel_title (panel title form is in)
 * @param integer $panel_number (the panel number form is in),(tab number passed instead when this function called for support button row)
 * @param integer $step (1 = confirm form, 2 = process request, 3+ alternative processing)
 */
function wtgcsv_hidden_form_values($tabnumber,$pageid,$panel_name,$panel_title,$panel_number,$step = 1){
    
    // multiple steps - use this to state a step - argument within form validation will process accordingly
    echo '<input type="hidden" id="wtgcsv_hidden_tabnumber" name="wtgcsv_hidden_tabnumber" value="'.$tabnumber.'">';

    // multiple steps - use this to state a step - argument within form validation will process accordingly
    echo '<input type="hidden" id="wtgcsv_hidden_step" name="wtgcsv_hidden_step" value="'.$step.'">';

    // Main Page ID - mainly used to aid troubleshooting
    echo '<input type="hidden" id="wtgcsv_hidden_pageid" name="wtgcsv_hidden_pageid" value="'.$pageid.'">';

    // Panel Name (slug) - mainly used to aid troubleshooting
    echo '<input type="hidden" id="wtgcsv_hidden_panel_name" name="wtgcsv_hidden_panel_name" value="'.$panel_name.'">';

    // Panel Title - used to in output and to aid troubleshooting
    echo '<input type="hidden" id="wtgcsv_hidden_panel_title" name="wtgcsv_hidden_panel_title" value="'.$panel_title.'">';

    // Panel Number On Tab File - mainly used to aid troubleshooting
    // also used to pass tab number when being included in support button row
    echo '<input type="hidden" id="wtgcsv_hidden_panels" name="wtgcsv_hidden_panels" value="'.$panel_number.'">';
}

/**
 * Builds form middle with jquery dialogue, flexible options allow a single action with or without many form objects
 * @link http://www.webtechglobal.co.uk/blog/wordpress/wtg-plugin-template/wtg-pt-jquery-dialogue-form
 * @param array $jqueryform_settings (configuration see: )
 * @param array $formobjects_array (list of form object ID for looping through and adding to dialogue)
 * 
 * @todo this function requires the form
 */
function wtgcsv_jqueryform_singleaction_middle($jsform_set,$formobjects_array){

    extract( shortcode_atts( array(
    'has_options' => false,
    'pageid' => 0,
    'panel_number' => 0,
    'panel_name' => 'nopanelname',
    'panel_title' => 'No Panel Name',    
    'tab_number' => 'error no tab number passed too wtgcsv_jqueryform_singleaction_middle()',
    'form_id' => WTG_CSV_ABB.'form_id_default',
    'form_name' => WTG_CSV_ABB.'form_name_default',
    ), $jsform_set ) );

    // add the javascript
    wtgcsv_jquery_opendialog_confirmformaction($jsform_set,$formobjects_array);

    // add wtg hidden form values (for debugging)
    wtgcsv_hidden_form_values($tab_number,$pageid,$panel_name,$panel_title,$panel_number);
}

/**
 * Used in First Time Install panel, adds accordian items to accordian wrapper for option records
 * @param string $option
 */
function wtgcsv_accordianitem_optioninstall($option){
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
function wtgcsv_link($text,$url,$htmlentities = '',$target = '_blank',$class = '',$response = 'echo',$title = ''){
    
    // add ? to $middle if there is no proper join after the domain
    $middle = '';
                             
    // decide class
    if($class != ''){$class = 'class="'.$class.'"';}
    
    // build final url
    $finalurl = $url.$middle.htmlentities($htmlentities);
    
    // check the final result is valid else use a default fault page
    $valid_result = wtgcsv_validate_url($finalurl);
    
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
* Creates url to an admin page
*  
* @param mixed $page, registered page slug i.e. wtgcsv_install which results in wp-admin/admin.php?page=wtgcsv_install   
* @param mixed $values, pass a string beginning with & followed by url values
*/
function wtgcsv_link_toadmin($page,$values = ''){
    return get_admin_url() . 'admin.php?page=' . $page . $values;
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
function wtgcsv_google_searchlink($text,$subscription,$string){
                                            
    if($subscription == 'gold'){
        // standard google
        $url = 'http://.google.co.uk/search?q='.$text;    
    }else{
        // adsense google
        ### @todo REVENUE - change to a local url, process google adsense form to a search page
        $url = 'http://.google.co.uk/search?q='.$text;   
    }
    
    wtgcsv_link($text,$url,'_blank',$string);   
}

/**
* Standard interface response to SOAP faults
* 
* @param string $soapcallfunction, the function name that called soap and cause fault
*/
function wtgcsv_soap_fault_display($soapcallfunction){
    wtgcsv_notice('Sorry there was a problem contacting WebTechGlobal Web Services for Wordpress.
    Please report this notice with the following information: SOAP Call Function '.$soapcallfunction.'
    returned "soapfault". I think you for your patience. Please repeat your action again while you wait on a
    response as it may be caused by maintenance on the WebTechGlobal site.','error','Extra','WebTechGlobal Web Service Fault');    
}

/**
* Returns array with common values required for forms that need jQuery dialogue etc.
* The default values can be overridden by populating the $jsform_set_override array. 
* 
* @param mixed $pageid
* @param mixed $wtgcsv_tab_number
* @param mixed $panel_number
* @param mixed $panel_name
* @param mixed $panel_title
* @param array $jsform_set_override, (not yet in use) use to customise the return value, not required in most uses
*/
function wtgcsv_jqueryform_commonarrayvalues($pageid,$wtgcsv_tab_number,$panel_number,$panel_name,$panel_title,$jsform_set_override = ''){
    ### @todo  extract the override values after callign global values
    // $jsform_set_override
    // this is so we can pass the override array for custom settings rather than the default
    
    $jsform_set = array();
    
    // http://www.webtechglobal.co.uk/blog/wordpress/wtg-plugin-template/wtg-pt-jquery-dialogue-form 
    $jsform_set['pageid'] = $pageid;
    $jsform_set['tab_number'] = $wtgcsv_tab_number; 
    $jsform_set['panel_number'] = $panel_number;
    $jsform_set['panel_name'] = $panel_name;
    $jsform_set['panel_title'] = $panel_title;                
    // dialogue box, javascript
    $jsform_set['dialoguebox_id'] = $panel_name.$panel_number;
    $jsform_set['dialoguebox_height'] = 300;// false will remove the height entry from the script
    $jsform_set['dialoguebox_width'] = 800;// false will remove the width entry from the script
    $jsform_set['dialoguebox_autoresize'] = false;// true or false, overrides width and height 
    // form related
    $jsform_set['form_id'] = wtgcsv_create_formid($panel_name);
    $jsform_set['form_name'] = wtgcsv_create_formname($panel_name);  
    
                                              
    return $jsform_set;
}
 
/**
* Returns standard formatted form name
* 
* @param string $panel_name
* @param string $specificpurpose, used to append a value, important when multiple forms used in a single panel
*/
function wtgcsv_create_formname($panel_name,$specificpurpose = ''){
    return 'wtgcsv_form_name_' . $panel_name . $specificpurpose;    
}   

/**
* Returns a standard formatted form ID
* 
* @param string $panel_name
* @param string $specificpurpose, used to append a value, important when multiple forms used in a single panel 
*/
function wtgcsv_create_formid($panel_name,$specificpurpose = ''){
    return 'wtgcsv_form_id_' . $panel_name . $specificpurpose;
}

/**
* Returns MySQL version 
*/
function wtgcsv_get_mysqlversion() { 
    $output = shell_exec('mysql -V'); 
    preg_match('@[0-9]+\.[0-9]+\.[0-9]+@', $output, $version); 
    return $version[0]; 
}

/**
* Displays notice if combined CSV file size is more than recommended for the interface to easily handle
* 104857600 = 100 MB 
*/
function wtgcsv_notice_filesizetotal($mb){
    if($mb > 104857600){
        wtgcsv_notice('Your CSV files combined size is larger than 100MB, it is recommended that you delete any files
        not in use to reduce memory usage and increase plugin interface performance','notice','Tiny','','');
    }      
}

/**
* Displays a table of the CSV files within the plugins storage paths
* 1. displays some statistics of any matching database tables
* 2. displays the age of files for knowing when a file was last updated
* 
* @todo MEDIUMPRIOTITY, use DataTables with ability to click and view more information plus delete files.
* @todo MEDIUMPRIORITY, a file is caused a blank age result, investigate why it happened when the file was edited then uploaded again         
*/
function wtgcsv_available_csv_file_list(){
    $available = 0;
 
    if (!is_dir(WTG_CSV_CONTENTFOLDER_DIR)) {
    
        wtgcsv_notice('The content folder does not exist, has it been deleted or move?','error','Small','','');
                   
    }else{    
        
        @$opendir_result = opendir( WTG_CSV_CONTENTFOLDER_DIR );
        
        if(!$opendir_result){
            
            wtgcsv_notice(WTG_CSV_PLUGINTITLE . ' does not have permission to open the plugins content folder','error','Small','','');

        }else{

            echo '
            <table class="widefat post fixed">
                <tr class="first">
                    <td width="175"><strong>Name</strong></td>
                    <td width="85"><strong>Separator (plugin)</strong></td>                    
                    <td width="85"><strong>Separator (pear)</strong></td>                    
                    <td width="75"><strong>Rows</strong></td>
                    <td width="75"><strong>Size</strong></td>                   
                    <td><strong>Files Age</strong></td>                                    
                </tr>';  
            
            $filesize_total = 0;
                
            while( false != ( $filename = readdir( $opendir_result ) ) ){
                if( ($filename != ".") and ($filename != "..") ){
                    
                    $fileChunks = explode(".", $filename);
                                      
                    // ensure file extension is csv
                    if( isset( $fileChunks[1] ) && $fileChunks[1] == 'csv'){
                        
                        $file_path = WTG_CSV_CONTENTFOLDER_DIR . '/' . $filename;
                        $thefilesize = filesize($file_path);
                        $filesize_total = $thefilesize;
                        
                        $filemtime = filemtime(WTG_CSV_CONTENTFOLDER_DIR . '/' .$filename);
                        
                        $sep_fget = wtgcsv_establish_csvfile_separator_fgetmethod($filename,false );                           
                        $sep_PEARCSV = wtgcsv_establish_csvfile_separator_PEARCSVmethod($filename,false); 
                        
                        
                        if(phpversion() < '5.3'){
                            $fileage = '';### TODO:MEDIUMPRIORITY,add a PHP 5.2 function for determing file age
                        }else{
                            // this line is only suitable for PHP 5.3
                            $fileage =  wtgcsv_ago( date_create(date(WTG_CSV_DATEFORMAT,$filemtime)),true,true,true,true,true,false);
                        }    
                                                      
                        echo '
                        <tr>
                            <td>'.$filename.'</td>
                            <td>'.$sep_fget.'</td>                            
                            <td>'.$sep_PEARCSV.'</td>                            
                            <td>'.count(file(WTG_CSV_CONTENTFOLDER_DIR . '/' .$filename)).'</td>
                            <td>'.wtgcsv_format_file_size($thefilesize).'</td>                                                        
                            <td>'.$fileage.'</td>                            
                        </tr>';                    
                        
                    }// end if csv
                    
                }// end if $filename = .  
            }// end while    
                 
            echo '</table>';
            
            wtgcsv_notice_filesizetotal($filesize_total);

            // clear stored values
            clearstatcache();

        }// end $opendir_result
    }         
}

/**
* This table will list all CSV files and indicate any problems.
* 1. Separator for fgetcsv and PEAR CSV not matching
*/
function wtgcsv_csv_files_status_list(){
    $available = 0;
 
    if (!is_dir(WTG_CSV_CONTENTFOLDER_DIR)) {
    
        wtgcsv_notice('The content folder does not exist, has it been deleted or move?','error','Small','','');
                   
    }else{    
        
        @$opendir_result = opendir( WTG_CSV_CONTENTFOLDER_DIR );
        
        if(!$opendir_result){
            
            wtgcsv_notice(WTG_CSV_PLUGINTITLE . ' does not have permission to open the plugins content folder','error','Small','','');

        }else{

            echo '
            <table class="widefat post fixed">
                <tr class="first">
                    <td width="175"><strong>Name</strong></td>
                    <td><strong>Status</strong></td>                                                       
                </tr>';  
            
            $filesize_total = 0;
                
            while( false != ( $filename = readdir( $opendir_result ) ) ){
                if( ($filename != ".") and ($filename != "..") ){
                    
                    $fileChunks = explode(".", $filename);
                                      
                    // ensure file extension is csv
                    if( isset( $fileChunks[1] ) && $fileChunks[1] == 'csv'){
                        
                        $status = '';
                        
                        $file_path = WTG_CSV_CONTENTFOLDER_DIR . '/' . $filename;

                        ### TODO:LOWPRIORITY, display status for when a CSV file is older than the last one used
                        //$filemtime = filemtime(WTG_CSV_CONTENTFOLDER_DIR . '/' .$filename);
                        
                        // if csv file parse methods do not determine the same separator we will display a message
                        $sep_fget = wtgcsv_establish_csvfile_separator_fgetmethod($filename,false );                           
                        $sep_PEARCSV = wtgcsv_establish_csvfile_separator_PEARCSVmethod($filename,false); 
                        if($sep_fget != $sep_PEARCSV){
                            $status = 'This files separator needs to be set manually to avoid problems, do this on the Import Jobs screen once you use this file to create a Data Import Job.';    
                        }
                                   
                        echo '
                        <tr>
                            <td>'.$filename.'</td>
                            <td>'.$status.'</td>                                                       
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
function wtgcsv_pluralize( $count, $text ) { 
    return $count . ( ( $count == 1 ) ? ( " $text" ) : ( " ${text}s" ) );
}

/**
* Adds comma to the end of giving string based on what has already been added to the string value. 
*/
function wtgcsv_commas($originalstring){
    if($originalstring != ' '){$result = $originalstring . ',';return $result;}else{return $originalstring;}    
}
          
/**
* Returns human readable age based on giving file modified date
* @todo                           
*/
function wtgcsv_get_files_age($time){
               
    //echo date("F d Y H:i:s.", filemtime(WTG_CSV_CONTENTFOLDER_DIR .'/'. $filename));
    
    return '1 Day, 1 Hour, 1 Min, 1 Sec';   
}

/**
* Displays a table of all data import jobs. Includes a checkbox column for deleting data import jobs.
* 
* @returns the number of data import jobs found
* @todo LOWPRIORITY, replace table using Data Table script
*/
function wtgcsv_list_dataimportjobs(){
    global $wtgcsv_dataimportjobs_array;

    if(!$wtgcsv_dataimportjobs_array){
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
        foreach($wtgcsv_dataimportjobs_array as $jobid => $job){

            echo '
            <tr>
                <td> <input type="checkbox" name="wtgcsv_jobcode_array[]" value="'.$jobid.'" /> </td>        
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
function wtgcsv_panel_header( $panel_array, $boxintro_div = true ){
    global $wtgcsv_panels_closed;
    
    // establish global panel state
    $global_panel_state = ''; 
    if($wtgcsv_panels_closed){
        $global_panel_state = 'closed';    
    }
    
    // override panel state if $panel_array includes specific state
    if(isset($panel_array['panel_state']) && $panel_array['panel_state'] == 1){
        $global_panel_state = 'closed';    
    }elseif(isset($panel_array['panel_state']) && $panel_array['panel_state'] == 0){
        $global_panel_state = '';
    }?>

    <div id="titles" class="postbox <?php echo $global_panel_state;?>">
        <div class="handlediv" title="Click to toggle"><br /></div>

        <h3 class="hndle"><span><?php echo $panel_array['panel_title'];?></span></h3>

        <div class="inside">

            <?php if($boxintro_div){?>
            <div class="wtgcsv_boxintro_div">
                <?php wtgcsv_helpbutton_closebox($panel_array);?>
            </div>
            <?php }?>
            
            <div class="wtgcsv_boxcontent_div"><?php
}

/**
* Adds closing divs for panels 
*/
function wtgcsv_panel_footer(){
    echo '</div></div></div>';
}

/**
* Displays a table of wtgcsv_option records with ability to view their value or delete them
* 
* @todo MEDIUMPRIORITY, add delete buttons with ajax 
* @todo MEDIUMPRIORITY, add button to view option record value in a dialogue 
*/
function wtgcsv_display_optionrecordtrace(){
    
    // first get all records that begin with wtgcsv_
    $wtgcsvrecords_result = wtgcsv_get_options_beginning_with('wtgcsv_');
    $counter = 1;
    foreach($wtgcsvrecords_result as $key => $option ){
        echo wtgcsv_notice($counter . '. ' . $option,'info','Small','','','return');
        ++$counter;
    }
}

/**
* Outputs the database tables being used in the giving project.
* Returns a single line, each table name separated by comma 
*/
function wtgcsv_display_projectstables_commaseparated($project_code){
    $project_array = wtgcsv_get_project_array($project_code);
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
* @todo HIGHPRIORITY, filter out other design types, only show content templates
*/
function wtgcsv_display_all_contentdesigns_buttonlist(){
   
    $args = array(
        'post_type' => 'wtgcsvcontent'
    );

    global $post;
    $myposts = get_posts( $args );
    
    if(count($myposts) == 0){
        echo 'You do not have any content templates linked in your current project';
    }
        
    foreach( $myposts as $post ){?>
        <div class="jquerybutton">
            <input type='submit' value='<?php echo $post->post_title;?> (<?php echo $post->ID;?>)' name="wtgcsv_templatename_and_id" />
        </div><?php 
    }; 
}

/**
* Displays list of title templates in the form of jquery buttons
* 
* @todo HIGHPRIORITY, filter out other template types 
*/
function wtgcsv_display_all_titledesigns_buttonlist(){
   
    $args = array(
        'post_type' => 'wtgcsvtitle'
    );

    global $post;
    $myposts = get_posts( $args );
    
    if(count($myposts) == 0){
        echo 'You do not have any title templates linked in your current project';
    }
        
    foreach( $myposts as $post ){?>
        <div class="jquerybutton">
            <input type='submit' value='<?php echo $post->post_title;?> (<?php echo $post->ID;?>)' name="wtgcsv_templatename_and_id" />
        </div><?php 
    }; 
}

/**
* Displays checkbox menu holding all the designs for the giving project
* @todo CRITICAL, improve the id to make it more unique as this menu will be used many times 
*/
function wtgcsv_displayproject_contenttemplates_buttonlist($form_id){
    global $wtgcsv_currentproject_code;
    
    $default_template_id = wtgcsv_get_default_contenttemplate_id( $wtgcsv_currentproject_code );
    $current_default_template_text = '';
      
    $args = array(
        'post_type' => 'wtgcsvcontent',
        'meta_query' => array(
            array(
                'key' => 'wtgcsv_project_id',
                'value' => $wtgcsv_currentproject_code,
            )
        )
    );

    $myposts = get_posts( $args );
    if(count($myposts) == 0){
        echo 'You do not have any content templates linked in your current project';
    }

    foreach( $myposts as $post ){
        
        if( $post->ID == $default_template_id){
            $current_default_template_text = 'Current Default';    
        }
             
        ?>
        <div class="jquerybutton">
                <input type='submit' value='<?php echo $post->post_title;?> (<?php echo $post->ID;?>) <?php echo $current_default_template_text;?>' name="wtgcsv_templatename_and_id" />
        </div><?php 
    };
}

/**
* Returns the content of default title template post, the design* 
*/
function wtgcsv_get_default_titletemplate_design($project_code = false){
    if(!$project_code){global $wtgcsv_currentproject_code;$project_code = $wtgcsv_currentproject_code;}
    
    $default_template_id = wtgcsv_get_default_titletemplate_id( $project_code );

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
function wtgcsv_displayproject_titletemplates_buttonlist($form_id){
    global $wtgcsv_currentproject_code;
    
    $default_template_id = wtgcsv_get_default_titletemplate_id( $wtgcsv_currentproject_code );
    $current_default_template_text = '';
      
    $args = array(
        'post_type' => 'wtgcsvtitle',
        'meta_query' => array(
            array(
                'key' => 'wtgcsv_project_id',
                'value' => $wtgcsv_currentproject_code,
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
                <input type='submit' value='<?php echo $post->post_title;?> (<?php echo $post->ID;?>) <?php echo $current_default_template_text;?>' name="wtgcsv_templatename_and_id" />
        </div><?php 
    };
} 

/**
* Adds a box to the Content Design edit page. 
*/
function wtgcsv_add_custom_boxes_contenttemplate() {
    add_meta_box( 
        'wtgcsv_custombox_templatetype_id',// a unique id of the box being displayed on edit page
        'Template Design Types',// TODO: translate
        'wtgcsv_custombox_contenttemplatetype',// callback to function that displays html content insie box on page
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
function wtgcsv_custombox_contenttemplatetype( $post ) {

    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'wtgcsv_wordpresscsvimporter_noncename' );

    // The actual fields for data entry
    echo '<label for="myplugin_new_field">';
    echo '<strong>Design can be used for the following purposes:</strong>';
    echo '</label> ';

    // get template types - may return an array of values
    $meta_values = get_post_meta($_GET['post'], '_wtgcsv_templatetypes', false); 
       
    if(!$meta_values){
        echo '<p>Error: could not establish the content designs purpose</p>';
        return;    
    }

    echo '<ol>';
    
    foreach($meta_values as $key => $type){
        
        switch ($type) {
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
* When Content Template Design post type (wtgcsvcontent) is saved, saves our custom data entered in form output by wtgcsv_custombox_templatetype#
*/
function wtgcsv_save_postdata_contenttemplate( $post_id ) {
  // if auto-save routine happening, do nothing, also if nonename not set also do nothing else the New Template editor panel will call this
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE || !isset($_POST['wtgcsv_wordpresscsvimporter_noncename']) ){
      return;
  }

  // use plugin nonce name to verify this came from the our screen and with proper authorization (save_post can be triggered at other times)
  if ( !wp_verify_nonce( $_POST['wtgcsv_wordpresscsvimporter_noncename'], plugin_basename( __FILE__ ) ) ){
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
* When Title Template Design (wtgcsvtitle) post type is saved, saves our custom data entered in form output by wtgcsv_custombox_templatetype#
*/
function wtgcsv_save_postdata_titletemplate( $post_id ) {
  // if auto-save routine happening, do nothing, also if nonename not set also do nothing else the New Template editor panel will call this
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE || !isset($_POST['wtgcsv_wordpresscsvimporter_noncename']) ){
      return;
  }

  // use plugin nonce name to verify this came from the our screen and with proper authorization (save_post can be triggered at other times)
  if ( !wp_verify_nonce( $_POST['wtgcsv_wordpresscsvimporter_noncename'], plugin_basename( __FILE__ ) ) ){
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
function wtgcsv_jquery_form_prompt($jsform_set){?>
    <!-- dialogue box -->
    <div id="<?php echo $jsform_set['dialoguebox_id'];?>" title="<?php echo $jsform_set['dialoguebox_title'];?>">
        <?php echo wtgcsv_notice($jsform_set['noticebox_content'],'question','Small',false,'','return');?>
    </div><?php      
} 

/**
 * Tabs menu loader - calls function for css only menu or jquery tabs menu
 * 
 * @param string $thepagekey this is the screen being visited
 */
function wtgcsv_createmenu($thepagekey){
    global $wtgcsv_nav_type;
    if($wtgcsv_nav_type == 'css'){
        wtgcsv_navigation_css($thepagekey);
    }elseif($wtgcsv_nav_type == 'jquery'){
        wtgcsv_navigation_jquery($thepagekey);    
    }elseif($wtgcsv_nav_type == 'nonav'){
        echo '<div id="wtgcsv_maintabs">';
    }
}


function wtgcsv_navigation_jquery($thepagekey){    
    global $wtgcsv_is_activated,$wtgcsv_is_installed,$wtgcsv_mpt_arr;?>

    <?php 
    // TODO:LOWPRIORITY, once syntax plugin installed add this too a page then remove from here should we wish to use it in future
    if($wtgcsv_mpt_arr[$thepagekey]['vertical'] === true){?>

    <style> 
    #wtgcsv_maintabs {
        position: relative;
        padding-left: 10em;
    }
    #wtgcsv_maintabs .ui-tabs-nav {
        position: absolute;
        left: 0.25em;
        top: 0.25em;
        bottom: 0.25em;
        width: 10em;
        padding: 0.2em 0 0.2em 0.2em;
    }
    #wtgcsv_maintabs .ui-tabs-nav li {
        right: 1px;
        width: 100%;
        border-right: none;
        border-bottom-width: 1px !important;
        border-radius: 4px 0px 0px 4px;
        -moz-border-radius: 4px 0px 0px 4px;
        -webkit-border-radius: 4px 0px 0px 4px;
        overflow: hidden;
    }
    #wtgcsv_maintabs .ui-tabs-nav li.ui-tabs-selected {
        border-right: 1px solid transparent;
    }
    #wtgcsv_maintabs .ui-tabs-nav li a {
        float: right;
        width: 100%;
        text-align: right;
    }
    </style>
    <?php }?>       

    <script>
    $(function() {
         $( "#wtgcsv_maintabs" ).tabs({
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
                
    <div id="wtgcsv_maintabs">

    <?php 
    if($wtgcsv_mpt_arr[$thepagekey]['headers'] == true){
        $counttabs = 0;
        foreach($wtgcsv_mpt_arr[$thepagekey]['tabs'] as $tab=>$values){
            
            $pageslug = $wtgcsv_mpt_arr[$thepagekey]['slug'];
            $tabslug = $wtgcsv_mpt_arr[$thepagekey]['tabs'][$counttabs]['slug'];
            $tablabel = $wtgcsv_mpt_arr[$thepagekey]['tabs'][$counttabs]['label'];   
  
             if($wtgcsv_mpt_arr[ $thepagekey ]['tabs'][ $counttabs ]['display'] == true){

                // install menu is handled different
                ### ??? is this correct, is the install page key not install rather than 1
                if($thepagekey == 1){?>
                    <div id="tabs-<?php echo $counttabs;?>">
                        <?php echo $wtgcsv_mpt_arr[$thepagekey]['tabs'][$counttabs]['label'];?>
                    </div><?php    
                }        
            } 
            
            ++$counttabs;
        }
    }?>       
    
    <?php
    // begin building menu - controlled by jQuery
    echo '<ul>';

    // loop through tabs - held in menu pages tabs array
    $counttabs = 0;
    foreach($wtgcsv_mpt_arr[$thepagekey]['tabs'] as $tab=>$values){
        
        $pageslug = $wtgcsv_mpt_arr[$thepagekey]['slug'];
        $tabslug = $wtgcsv_mpt_arr[$thepagekey]['tabs'][$counttabs]['slug'];
        $tablabel = $wtgcsv_mpt_arr[$thepagekey]['tabs'][$counttabs]['label'];   
  
        if($wtgcsv_mpt_arr[ $thepagekey ]['tabs'][ $counttabs ]['display'] == true){

            // TODO:LOWPRIORITY, if( $wtgcsv_is_activated == 'true' ){    if not fully installed it will be dealt with on status screen

            // install menu is handled different
            if($thepagekey == 'install' ){ 
             
                if( $wtgcsv_is_installed == 'true' ){                
                    // do not show installation tab
                    if($counttabs != 4){ 
                        echo '<li><a href="'.wtgcsv_create_adminurl($pageslug,'').'#tabs-'.$counttabs.'">'.$tablabel.'</a></li>';       
                    }

                }else{
                   
                    // only show installation tab
                    if($counttabs == 4){ 
                        echo '<li><a href="'.wtgcsv_create_adminurl($pageslug,'').'#tabs-'.$counttabs.'">'.$tablabel.'</a></li>';       
                        ++$counttabs;
                        // break the loop to prevent loop through further pages
                        break;
                    }            
                }
                
            }else{
                // default menu build approach
                echo '<li><a href="'.wtgcsv_create_adminurl($pageslug,'').'#tabs-'.$counttabs.'">' . $tablabel . '</a></li>';                                
            }
            
        } 
        
        ++$counttabs;
    }// for each
    
    echo '</ul>';?>    

    <?php  
}

/**
* Secondary navigation builder - CSS only (use for javascript debugging etc)
* @todo MEDIUMPRIORITY, move the css in function too a .css file and double check no duplicates
* @param mixed $thepagekey
*/
function wtgcsv_navigation_css($thepagekey){    
    global $wtgcsv_is_activated,$wtgcsv_is_installed,$wtgcsv_mpt_arr;?>

    <?php if($wtgcsv_mpt_arr[$thepagekey]['vertical'] == true){?>

    <style> 
    #wtgcsv_maintabs {
        position: relative;
        padding-left: 10em;
    }
    #wtgcsv_maintabs .ui-tabs-nav {
        position: absolute;
        left: 0.25em;
        top: 0.25em;
        bottom: 0.25em;
        width: 10em;
        padding: 0.2em 0 0.2em 0.2em;
    }
    #wtgcsv_maintabs .ui-tabs-nav li {
        right: 1px;
        width: 100%;
        border-right: none;
        border-bottom-width: 1px !important;
        border-radius: 4px 0px 0px 4px;
        -moz-border-radius: 4px 0px 0px 4px;
        -webkit-border-radius: 4px 0px 0px 4px;
        overflow: hidden;
    }
    #wtgcsv_maintabs .ui-tabs-nav li.ui-tabs-selected {
        border-right: 1px solid transparent;
    }
    #wtgcsv_maintabs .ui-tabs-nav li a {
        float: right;
        width: 100%;
        text-align: right;
    }
    </style>
    <?php }?>       
            
    <div id="wtgcsv_maintabs">

    <?php 
    if($wtgcsv_mpt_arr[$thepagekey]['headers'] == true){
        $counttabs = 0;
        foreach($wtgcsv_mpt_arr[$thepagekey]['tabs'] as $tab=>$values){
            
            $pageslug = $wtgcsv_mpt_arr[$thepagekey]['slug'];
            $tabslug = $wtgcsv_mpt_arr[$thepagekey]['tabs'][$counttabs]['slug'];
            $tablabel = $wtgcsv_mpt_arr[$thepagekey]['tabs'][$counttabs]['label'];   
 
             if($wtgcsv_mpt_arr[ $thepagekey ]['tabs'][ $counttabs ]['display'] == true){

                // install menu is handled different
                ### ??? is this correct, is the install page key not install rather than 1
                if($thepagekey == 1){?>
                    <div id="tabs-<?php echo $counttabs;?>">
                        <?php echo $wtgcsv_mpt_arr[$thepagekey]['tabs'][$counttabs]['label'];?>
                    </div><?php    
                }        
            } 
            
            ++$counttabs;
        }
    }?>       
    
    <?php
    // begin building menu - controlled by jQuery
    echo '<ul>';

    // loop through tabs - held in menu pages tabs array
    $counttabs = 0;
    foreach($wtgcsv_mpt_arr[$thepagekey]['tabs'] as $tab=>$values){
        
        $pageslug = $wtgcsv_mpt_arr[$thepagekey]['slug'];
        $tabslug = $wtgcsv_mpt_arr[$thepagekey]['tabs'][$counttabs]['slug'];
        $tablabel = $wtgcsv_mpt_arr[$thepagekey]['tabs'][$counttabs]['label'];   
        
        if($wtgcsv_mpt_arr[ $thepagekey ]['tabs'][ $counttabs ]['display'] == true){

            // TODO:LOWPRIORITY, if( $wtgcsv_is_activated == 'true' ){    if not fully installed it will be dealt with on status screen          
            
            // install menu is handled different
            if($thepagekey == 'install' ){ 
             
                if( $wtgcsv_is_installed == 'true' ){                
                    // do not show installation tab
                    if($counttabs != 4){ 
                        echo '<li><a href="'.wtgcsv_create_adminurl($pageslug,'').'#tabs-'.$counttabs.'">'.$tablabel.'</a></li>';       
                    }

                }else{
                   
                    // only show installation tab
                    if($counttabs == 4){ 
                        echo '<li><a href="'.wtgcsv_create_adminurl($pageslug,'').'#tabs-'.$counttabs.'">'.$tablabel.'</a></li>';       
                        ++$counttabs;
                        // break the loop to prevent loop through further pages
                        break;
                    }            
                }
                
            }else{
                // default menu build approach
                echo '<li><a href="'.wtgcsv_create_adminurl($pageslug,'').'&tabnumber='.$counttabs.'">' . $tablabel . '</a></li>';                                
            }
            
        } 
        
        ++$counttabs;
    }// for each
    
    echo '</ul>';  
}

/**
* If current_project_code is false, will return a string holding "None", for using in strings 
*/
function wtgcsv_convertvalue_projectcodefalse_toostring(){
    global $wtgcsv_currentproject_code;
    if(!$wtgcsv_currentproject_code || $wtgcsv_currentproject_code == 'false' || $wtgcsv_currentproject_code === false){
        return 'None';
    }
    return $wtgcsv_currentproject_code;    
}

/**
* Displays a list of tokens based on projects database columns (all tables selected in project).
* if $wtgcsv_is_free tokens do not use table name as free edition only allows a single table
* 
* @param mixed $wtgcsv_currentproject_code
*/
function wtgcsv_list_replacement_tokens($currentproject_code){
    global $wtgcsv_is_free;
    
    if(!$currentproject_code || $currentproject_code == false){
        echo 'No Current Project';  
    }else{
        $project_array = wtgcsv_get_project_array($currentproject_code);
        
        // loop through project tables
        foreach($project_array['tables'] as $key => $table_name){
 
            echo '<h4>' . $table_name . '</h4>';
            
            // confirm table still exists else display warning - great opportunity to let user know they deleted the WRONG table :) 
            if(!wtgcsv_does_table_exist($table_name)){
                echo wtgcsv_notice('This table is missing, have you possibly manually deleted it?','error','Tiny','','','return');
            }
            
            $table_columns = wtgcsv_sql_get_tablecolumns($table_name);
            
            if(!$table_columns){
            
                echo wtgcsv_notice('The database table named '.$table_name.' does not appear to exist anymore. Have you
                deleted it manually using this plugin or when editing the database directly?','error','Small','','','return');
                
            }else{
            
                // excluded columns array
                $excluded_columns = array('wtgcsv_id','wtgcsv_postid','wtgcsv_postcontent','wtgcsv_inuse','wtgcsv_imported','wtgcsv_updated','wtgcsv_changed','wtgcsv_applied','wtgcsv_filemoddate','wtgcsv_filemoddate1','wtgcsv_filemoddate2','wtgcsv_filemoddate3','wtgcsv_filemoddate4','wtgcsv_filemoddate5','wtgcsv_filedone','wtgcsv_filedone1','wtgcsv_filedone2','wtgcsv_filedone3','wtgcsv_filedone4','wtgcsv_filedone5');

                // we will count the number of none wtgcsv columns, if 0 we know it is a main project table for multiple table project
                $count_users_columns = 0;
                
                while ($row_column = mysql_fetch_row($table_columns)) { 
                    
                    if(!in_array($row_column[0],$excluded_columns)){
                        
                        // if free edition, do not add the table, we make it a little more simple
                        // it is also more secure for users who may be beginners because database table names are not in use
                        if($wtgcsv_is_free){
                            echo '#' . $row_column[0].'<br />';                   
                        }else{            
                            echo $table_name . '#' . $row_column[0].'<br />';
                            ++$count_users_columns;
                        }
                    }
                } 
                
                if(!$wtgcsv_is_free && $count_users_columns == 0){
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
function wtgcsv_list_titletemplate_foredit(){
    global $wtgcsv_currentproject_code;
    
    $default_template_id = wtgcsv_get_default_titletemplate_id( $wtgcsv_currentproject_code );
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
        <input type="text" name="wtgcsv_titletemplate_design_<?php echo $i;?>" id="wtgcsv_title_inputid_<?php echo $i;?>" value="<?php echo $post->post_content;?>" size="65" />
        <input type="hidden" name="wtgcsv_titletemplate_design_original_<?php echo $i;?>" value="<?php echo $post->post_content;?>">    
        <input type="hidden" name="wtgcsv_titletemplate_postid_<?php echo $i;?>" value="<?php echo $post->ID;?>">    
        <input type="hidden" name="wtgcsv_titletemplate_posttitle_<?php echo $i;?>" value="<?php echo $post->post_title;?>"><?php    

    };?>
    
    <input type="hidden" name="wtgcsv_titletemplate_total" value="<?php echo $i;?>"><?php    
}

/**
* Lists all DISTINCT custom field keys (it actually queries meta-keys).
* There is not a currently any measures that hide none custom field keys.  
*/
function wtgcsv_list_customfields(){
    $result = wtgcsv_get_customfield_keys_distinct();
    foreach ($result as $customfield) {
        echo $customfield->meta_key .'<br />';
    }    
}

/**
* Uses wtgcsv_get_customfield_keys_distinct() to get DISTINCT meta-keys then loops and prints them.
* Can be used for custom field related features however there is wtgcsv_list_customfields() for that also. 
*/
function wtgcsv_list_metakeys(){
    $result = wtgcsv_get_customfield_keys_distinct();
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
function wtgcsv_display_posttypes_menu_options(){

    $post_types = get_post_types('','names');
    
    foreach ( $post_types as $post_type ) {
        
        // do not display post types that wont be used
        if( $post_type != "revision" && $post_type != "nav_menu_item" ){
            echo '<option value="'.$post_type.'">'.$post_type.'</option>';
        }
    }
}

/**
* Loops through giving projects tables and prints <option> item for menu for each column header.
* Table and column are added to value with comma delimeter. Use wtgcsv_explode_tablecolumn_returnnode to split the submitted value
* 
* Use script for jQuery display 
* <script>
*    $("#wtgcsv_customfield_select_columnandtable_formid").multiselect({
*       multiple: false,
*       header: "Select Database Column (table - column)",
*       noneSelectedText: "Select Database Table",
*       selectedList: 1
*    });
* </script>
*/
function wtgcsv_display_project_columnsandtables_menuoptions($project_code,$current_table = 'NOTPROVIDED98723462',$current_column = 'NOTPROVIDED09871237'){
    
    if(!$project_code){
        echo '<option value="nocurrentproject">No Current Project</option>';        
    }else{

        global $wtgcsv_project_array;

        foreach( $wtgcsv_project_array['tables'] as $key => $table ){
            $table_columns = wtgcsv_sql_get_tablecolumns($table);
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

function wtgcsv_display_job_column_menuoptions($job_code,$current_table = 'NOTPROVIDED98723462',$current_column = 'NOTPROVIDED09871237'){
    
    
    /*
    if(!$project_code){
        echo '<option value="nocurrentproject">No Current Project</option>';        
    }else{

        $project_array = wtgcsv_get_project_array($project_code);
        
        foreach( $project_array['tables'] as $key => $table ){
            $table_columns = wtgcsv_sql_get_tablecolumns($table);
            while ($row_column = mysql_fetch_row($table_columns)) {
                
                // establish selected status for this option
                $selected = '';
                if($current_table != 'NOTPROVIDED98723462' && $current_column != 'NOTPROVIDED09871237'){
                    if($current_table == $table && $current_column == $row_column[0]){
                        $selected = 'selected="selected"';
                    }    
                } 
                
                // must add table name also to avoid confusion when two or more tables share the same column name               
                echo '<option value="'.$table.','.$row_column[0].'" '.$selected.' >' . $table . ' - '.$row_column[0].'</option>'; 
            }                          
        } 
    }
    */  
}

/**
* Display date method with a short description of what the date method does 
*/
function wtgcsv_display_date_method(){
    global $wtgcsv_project_array;
    
    if(isset($wtgcsv_project_array['dates']['currentmethod'])){
        
        if($wtgcsv_project_array['dates']['currentmethod'] == 'data'){
            echo wtgcsv_notice('You selected a column in your project database tables for populating the publish dates of your posts.
            Please ensure the date formats in your data is suitable if your dates do not turn out as expected.','info','Large','Pre-Set Data Dates','','return');        
            return;    
        }
                
        if($wtgcsv_project_array['dates']['currentmethod'] == 'random'){
            echo wtgcsv_notice('Your project is currently setup to create random publish dates. Your 
            random dates will be generated using the giving start and end dates. All publish dates will fall
            between those giving dates and will not be created with any increment or in order.','info','Large','Random Dates','','return');        
            return;    
        }
        
        if($wtgcsv_project_array['dates']['currentmethod'] == 'increment'){
            echo wtgcsv_notice('The current project is setup to use the incremental publish dates method.
            The first publish date will be the Start date you submitted. The increment will then be used to 
            create the next publish date.','info','Large','Incremental Dates','','return');        
            return;    
        }

    }
    
    // display default
    echo wtgcsv_notice('Your project will use your blogs default publish date. Wordpress CSV Importer will not apply
    a date or make modifications to the one decided by Wordpress based on your current Date configuration here on
    this screen.','info','Large','Wordpress Default Publish Dates','','return');    
}


/**
* Displays checkbox menu holding all the designs for the giving project
* @todo CRITICAL, improve the id to make it more unique as this menu will be used many times 
*/
function wtgcsv_display_contenttemplate_menuoptions(){

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
* ### TODO, this should be selectables not a menu like in wtgcsv_menu_csvfiles
*/
function wtgcsv_selectables_csvfiles($range = 'all',$id = 'noid'){?>

    <select multiple='multiple' id="wtgcsv_selectcsvfiles_<?php echo $id;?>" name="wtgcsv_csvfilearray_<?php echo $id;?>[]" class="wtgcsv_multiselect_menu">
        <option value="notselected">Select A CSV File</option>
        <?php wtgcsv_option_items_csvfiles('all');?>
    </select>
     
    <script type="text/javascript">
        $(function(){
            $('#wtgcsv_selectcsvfiles_<?php echo $id;?>').multiSelect({
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
* @todo HIGHPRIORITY, fix the bug that forces multiselect instead of single select
* @todo LOWPRIORITY, add ability to create single select or multiselect (once bug fixed to apply single)
*/
function wtgcsv_menu_csvfiles($range = 'all',$id = 'noid'){?>
    <p>
        <select id="wtgcsv_multiselect<?php echo $id;?>" name="<?php WTG_CSV_ABB . 'csvfiles_menu';?>" class="wtgcsv_multiselect_menu">
            <option value="notselected">No File Selected</option>
            <?php wtgcsv_option_items_csvfiles('all');?>
        </select>
    </p>
    
    <script>
    $("#wtgcsv_multiselect<?php echo $id;?>").multiselect({
       multiple: false,
       header: "Select CSV File",
       noneSelectedText: "Select CSV File",
       selectedList: 1
    });
    </script> 
    <?php    
}

/**
* Adds option items to a menu for data import tables
* ### TODO:LOWPRIORITY, add results too an array first, then reverse the array, so that job tables are at the top of list
*/
function wtgcsv_option_items_databasetables($append_job_names = false){
    global $wpdb,$wtgcsv_is_free;
    $result = mysql_query("SHOW TABLES FROM `".$wpdb->dbname."`");
    while ($row_table = mysql_fetch_row($result)) {
        
        // if $append_job_names is true, we check if a tablename belongs to a job name then append the job name for easier recognition
        $append_string = '';
        if($append_job_names){

            // ensure wtgcsv_ exists in tablename, otherwise it is not an applicable tablename
            if(strstr( $row_table[0] , 'wtgcsv_' )){
                $append_string = '(' . wtgcsv_get_dataimportjob_name_by_table($row_table[0]) . ')';    
            }                                 

        }

        // only allow Wordpress CSV Importer data job tables to be displayed in menu
        if($wtgcsv_is_free && strstr( $row_table[0] , 'wtgcsv_' )){
            echo '<option value="'.$row_table[0].'">'.$row_table[0].' '.$append_string.'</option>';            
        }elseif(!$wtgcsv_is_free){
            echo '<option value="'.$row_table[0].'">'.$row_table[0].' '.$append_string.'</option>';
        }

    }
}

/**
* Gets and returns data import job name, using tablename
* @returns string which will have a job name, unless $table_name is not a wtgcsv table. If job not found using code, error returned
*/
function wtgcsv_get_dataimportjob_name_by_table($table_name){
    global $wtgcsv_dataimportjobs_array;
    
    // confirm $table_name is a wtgcsv table
    if(strstr ( $table_name , 'wtgcsv_' )){
        
        // remove wtgcsv_ and be left with code
        $code = str_replace('wtgcsv_','',$table_name);   

        if(isset($wtgcsv_dataimportjobs_array[$code]['name'])){
            return $wtgcsv_dataimportjobs_array[$code]['name'];
        }else{
            return 'Warning:No Job Using Giving Table Name';
        }  
    }
    
    return 'Warning:Job Does Not Exist Using Giving Table Name';  
}

/**
* Outputs option items for menus, does not output the select just the items for CSV files 
*/
function wtgcsv_option_items_csvfiles($range = 'all'){    
    @$opendir_result = opendir( WTG_CSV_CONTENTFOLDER_DIR ); 
    while( false != ( $filename = readdir( $opendir_result ) ) ){
        if( ($filename != ".") and ($filename != "..") ){
            
            $fileChunks = explode(".", $filename);
                              
            // ensure file extension is csv
            if( isset( $fileChunks[1] ) && $fileChunks[1] == 'csv'){
                
                $logfile_array = array('wtgcsv_log_error','wtgcsv_log_general','wtgcsv_log_sql','wtgcsv_log_user','wtgcsv_log_admin');
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
function wtgcsv_option_items_postcreationprojects($existing_values = false){
    global $wtgcsv_projectslist_array;
    foreach($wtgcsv_projectslist_array as $project_code => $project){
        echo '<option value="'.$project_code.'">'.$project['name'].'</option>';    
    }    
}

###########################################################################################
#                                                                                         #
#                           OTHER FORM OBJECTS (other than menus)                         #
#                                                                                         #
###########################################################################################
/**
* Displays post types as radio buttons on form with jQuery styling of a button.
*/
function wtgcsv_display_defaultposttype_radiobuttons(){ 
    global $wtgcsv_currentproject_code;
    $project_array = wtgcsv_get_project_array($wtgcsv_currentproject_code);?> 
    
    <script>
    $(function() {
        $( "#wtgcsv_defaultposttype_radios_objectid" ).buttonset();
    });
    </script>

    <div id="wtgcsv_defaultposttype_radios_objectid">
        
        <?php
        // get current projects default post type
        $defaultposttype = wtgcsv_get_project_defaultposttype($wtgcsv_currentproject_code);
        
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
                echo '<input type="radio" id="wtgcsv_radio'.$i.'_posttype_objectid" name="wtgcsv_radio_defaultpostype" value="'.$post_type.'" '.$checked.' />
                <label for="wtgcsv_radio'.$i.'_posttype_objectid">'.$post_type.'</label>';    
                ++$i;
            }
        }
        
        // add post last, if none of the previous post types are the default, then we display this as default as it would be in Wordpress
        $post_default = '';
        if(!$defaultapplied){
            $post_default = 'checked="checked"';            
        }
        echo '<input type="radio" id="wtgcsv_radio'.$i.'_posttype_objectid" name="wtgcsv_radio_defaultpostype" value="post" '.$post_default.' />
        <label for="wtgcsv_radio'.$i.'_posttype_objectid">post</label>';?>
        
    </div><?php 
}


###########################################################################################
#                                                                                         #
#                                       TABLES                                            #
#                                                                                         #
###########################################################################################
/**
* Displays a table of basic custom field rules with checkbox for deleting rules
* @todo LOWPRIORITY, add Example Value column and pull data if available from project table 
*/
function wtgcsv_table_customfield_rules_basic(){
    global $wtgcsv_currentproject_code;
    
    $project_array = wtgcsv_get_project_array($wtgcsv_currentproject_code);
    if(!isset($project_array['custom_fields']['basic'])){
        wtgcsv_notice('You do not have any basic custom field rules for adding meta data to your posts.','info','Large');
    }else{    
        echo '<table class="widefat post fixed"><tr class="first">
            <td width="50"><strong>Delete</strong></td>
            <td width="200"><strong>Meta-Key</strong></td>
            <td width="200"><strong>Table</strong></td>
            <td><strong>Column</strong></td>                                                                       
        </tr>'; 
        
        foreach( $project_array['custom_fields']['basic'] as $key => $rule ){
            echo '<tr class="first">
                <td><input type="checkbox" name="wtgcsv_customfield_rule_arraykey" value="'.$key.'" /></td>
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
function wtgcsv_table_customfield_rules_advanced(){
    global $wtgcsv_currentproject_code;
    
    $project_array = wtgcsv_get_project_array($wtgcsv_currentproject_code);
    if(!isset($project_array['custom_fields']['advanced'])){
        wtgcsv_notice('You do not have any advanced custom field rules for adding meta data to your posts.','info','Large');
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
                <td><input type="checkbox" name="wtgcsv_customfield_rule_arraykey" value="'.$key.'" /></td>
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
function wtgcsv_display_posttyperules_byvalue_table(){
    global $wtgcsv_currentproject_code;
    
    $project_array = wtgcsv_get_project_array($wtgcsv_currentproject_code);
    
    if(!isset($project_array['posttyperules']['byvalue'])){
        wtgcsv_notice('You do not have any post type rules by specific values for your current project.','info','Small');
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
function wtgcsv_display_templatedesignrules_byvalue_table(){
    global $wtgcsv_currentproject_code;
    
    $project_array = wtgcsv_get_project_array($wtgcsv_currentproject_code);
    if(!isset($project_array['contenttemplaterules']['byvalue'])){
        wtgcsv_notice('You do not have any dynamic content design rules triggered by specific values.','info','Small');
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
* Displays a list of database tables created for data import jobs.         
* Optional checkbox column also.
* 
* @returns count of total tables
* @global $wtgcsv_dataimportjobs_array, an array of current data import jobs, does not hold history
* @global $wtgcsv_jobtable_array, array of all data import job tables, holds tables until they are deleted using interface
* 
* @todo HIGHPRIORITY, add checkbox column for deleting tables 
*/
function wtgcsv_display_jobtables($checkbox_column = false){
    global $wtgcsv_dataimportjobs_array,$wtgcsv_jobtable_array;
    
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
               
    foreach( $wtgcsv_jobtable_array as $key => $table_name ){
        
        $jobcode = str_replace('wtgcsv_','',$table_name);
        
        // set project value
        if(!isset($wtgcsv_dataimportjobs_array[$jobcode]['name'])){
            $project = 'Project Deleted';
        }else{
            $project = $wtgcsv_dataimportjobs_array[$jobcode]['name'];            
        }
        
        $table_exists_result = wtgcsv_does_table_exist( $table_name );
        
        if($table_exists_result){
            $table_row_count = wtgcsv_sql_counttablerecords($table_name);    
        }else{
            $table_row_count = 'Table Deleted';            
        }

        echo '
        <tr>';

        if($checkbox_column){
            echo '<td><input type="checkbox" name="wtgcsv_table_array[]" value="'.$table_name.'" /></td>';        
        }
            
        echo '
            <td>'.$table_name.'</td>
            <td>'.$project.'</td>
            <td>'.$table_row_count.'</td>
        </tr>';
        ++$table_count;
    }   
                 
    echo '</table>';
    
    return $table_count;               
}

/**
* Displays a basic table listing all psot creation projects
*/
function wtgcsv_postcreationproject_table(){
    global $wtgcsv_projectslist_array;
    
    if(!isset($wtgcsv_projectslist_array) || $wtgcsv_projectslist_array == false){
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
            foreach( $wtgcsv_projectslist_array as $project_code => $project ){?>
                <tr class="first">
                    <td><?php echo $project_code;?></td>
                    <td><?php echo $project['name'];?></td>
                    <td><?php echo wtgcsv_display_projectstables_commaseparated($project_code);?></td>                                                                               
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
function wtgcsv_display_project_database_tables_and_columns(){
    global $wtgcsv_currentproject_code;
    
    if(!isset($wtgcsv_currentproject_code) || $wtgcsv_currentproject_code == false){
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
                  
        $project_array = wtgcsv_get_project_array($wtgcsv_currentproject_code);
        $table_name_string = '';
        $count = 0;
        foreach($project_array['tables'] as $test => $table_name){
            
            echo '<tr>';
                echo '<td>'.$table_name.'</td>';
                echo '<td>'.wtgcsv_sql_counttablerecords($table_name).'</td>';
                echo '<td></td>';
            echo '</tr>';
                
            $table_columns = wtgcsv_sql_get_tablecolumns($table_name);
            while ($row_column = mysql_fetch_row($table_columns)) {
                echo '<tr>';                
                    echo '<td></td>';
                    echo '<td></td>';                    
                    echo '<td>'.$row_column[0].'</td>';
                echo '</tr>'; 
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
function wtgcsv_display_databasetables_withjobnames($checkbox_column = false,$ignore_free = false){
    global $wtgcsv_dataimportjobs_array,$wtgcsv_jobtable_array,$wtgcsv_is_free;
    
    // if no applicable database tables would be displayed, display message
    if($wtgcsv_is_free && $table_count == 0){
        echo wtgcsv_notice('Your database does not have any tables created by Wordpress CSV Importer. You will need to create a Data Import Job which creates a new database table.','warning','Small','','','return');    
    }else{
        
        echo '<table class="widefat post fixed"><tr class="first">';
        
        if($checkbox_column){
            echo '<td width="80"><strong>Select</strong></td>';        
        }
        
        echo '<td width="200"><strong>Table Names</strong></td>
            <td width="150"><strong>Data Import Job</strong></td>
            <td width="100"><strong>Records</strong></td>                                                              
        </tr>'; 
        
        $table_count = 0;

        $tables = wtgcsv_sql_get_tables();

        while ($table_name = mysql_fetch_row($tables)) {                
               
            // I decided free users should not get a plugin that offers open access to Wordpress database tables.
            // I would like to reduce such access at least until better documentation is released and more security added
            if($wtgcsv_is_free && !strstr($table_name[0],'wtgcsv_')){
            
                // we do nothing - we do not add database tables to our table if wtgcsv_ is not within the name     
                
            }else{
            
                // we want to display data import job names if a table belongs to one
                // first determine if table was created by Wordpress CSV Importer
                $tables_jobname = '.'; 
                $is_wtgcsv_table = strstr($table_name[0],'wtgcsv_');
                if($is_wtgcsv_table){
                    // remove wtgcsv_ from string to be left with possible job code (may not be a job)
                    $possible_jobcode = str_replace('wtgcsv_','',$table_name[0]);
                     
                    if(isset($wtgcsv_dataimportjobs_array[$possible_jobcode]['name'])){
                        $tables_jobname = $wtgcsv_dataimportjobs_array[$possible_jobcode]['name'];
                    }               
                }
            
                $table_row_count = wtgcsv_sql_counttablerecords($table_name[0]);    

                echo '<tr>';
         
                if($checkbox_column){
                    if($wtgcsv_is_free){
                        echo '<td><input type="radio" name="wtgcsv_databasetables_array" value="'.$table_name[0].'" /></td>';        
                    }else{
                        echo '<td><input type="checkbox" name="wtgcsv_databasetables_array[]" value="'.$table_name[0].'" /></td>';                
                    }
                }
                    
                echo '<td>'.$table_name[0].'</td>
                    <td>'.$tables_jobname.'</td>
                    <td>'.$table_row_count.'</td></tr>';
                    
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
function wtgcsv_display_categories_options($current_value){

    global $wtgcsv_project_array;
    
    $cats = get_categories('hide_empty=0&echo=0&show_option_none=&style=none&title_li=');

    foreach( $cats as $c ){ 
        
        // apply selected value to current save
        if( $current_value == $c->term_id ) {
            $selected = 'selected="selected"';
        }
        
        echo '<option value="'.$c->term_id.'" '.$selected.'>'. $c->term_id . ' - ' . $c->name .'</option>'; 
    }            
    
}

/**
* Outputs the template design options for a form menu.
* 
* @param mixed $current_value
* @param string $template_type the type of template to be displayed (postcontent,customfieldvalue,categorydescription,postexcerpt,keywordstring,dynamicwidgetcontent)
*/
function wtgcsv_display_template_options($current_value,$template_type = false){

    global $wtgcsv_project_array;

    // set type singular name
    if($template_type = 'postcontent'){
        $type_singular = 'Post Content';        
    }elseif($template_type = 'customfieldvalue'){
        $type_singular = 'Custom Field Value';        
    }elseif($template_type = 'categorydescription'){
        $type_singular = 'Category Description';        
    }elseif($template_type = 'postexcerpt'){
        $type_singular = 'Post Excerpt';        
    }elseif($template_type = 'keywordstring'){
        $type_singular = 'Keyword String';        
    }elseif($template_type = 'dynamicwidgetcontent'){
        $type_singular = 'Dynamic Widget Content';        
    }else{
        $type_singular = 'Content';        
    }
 
    // post query argument for get_posts function
    $args = array(
        'post_type' => 'wtgcsvcontent'
    );

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
function wtgcsv_helpbutton_text($under_construction = false,$paid_only = false){
    global $wtgcsv_is_free;
    
    if($wtgcsv_is_free && $paid_only){
        return 'Paid Edition Only';
    }    
    
    if($under_construction){
        return 'Feature Under Construction';    
    }

    return 'Help';
}

/**
* Displays a list of CSV file for selection. 
* User can select separator and quote also. The table also displays the auto determined separator and quote using PEAR CSV.
* 
*/
function wtgcsv_display_csvfiles_fornewdataimportjob(){
    global $wtgcsv_is_free;  

    echo '<table class="widefat post fixed">';
        
    echo '
    <tr>
        <td width="50">Select</td>
        <td>CSV File Name</td>
        <td width="80">Columns</td>        
        <td width="110">Separator</td>
        <td>Quote</td>    
    </tr>';
    
    @$opendir_result = opendir( WTG_CSV_CONTENTFOLDER_DIR ); 
    while( false != ( $filename = readdir( $opendir_result ) ) ){
        if( ($filename != ".") and ($filename != "..") ){
            
            $fileChunks = explode(".", $filename);
                              
            // ensure file extension is csv
            if( isset( $fileChunks[1] ) && $fileChunks[1] == 'csv'){
                
                $logfile_array = array('wtgcsv_log_error','wtgcsv_log_general','wtgcsv_log_sql','wtgcsv_log_user','wtgcsv_log_admin');
                
                // ignore log files
                if(!in_array($fileChunks[0],$logfile_array)){     
                    
                    echo '
                    <tr>
                        <td>';
                            
                            // determine radio or checkboxes
                            $object_type = 'checkbox';
                            if($wtgcsv_is_free){
                                $object_type = 'radio';
                            }?>
                            
                            <script>
                            $(function() {
                                $( "#wtgcsv_newjob_includefile_<?php echo $object_type;?>_<?php echo $fileChunks[0];?>" ).buttonset();
                            });
                            </script>

                            <div id="wtgcsv_newjob_includefile_<?php echo $object_type;?>_<?php echo $fileChunks[0];?>">                    
                                <input type="<?php echo $object_type;?>" name="wtgcsv_newjob_included_csvfiles[]" id="wtgcsv_newjob_includefile_<?php echo $fileChunks[0];?>" value="<?php echo $filename;?>" />
                                <label for="wtgcsv_newjob_includefile_<?php echo $fileChunks[0];?>">*</label>                     
                            </div>
                            
                        <?php 
                        ### TODO:HIGHPRIORITY, change the PEARCSVmethod for quote in the fget column
                        echo '</td>
                        <td>'.$filename.'</td>
                        <td><input type="text" name="wtgcsv_csvfile_fieldcount_'.$fileChunks[0].'" size="2" maxlength="2" value="" /></td>
                        <td>'; ?>

                            <script>
                            $(function() {
                                $( "#wtgcsv_newjob_separator_radios_<?php echo $fileChunks[0];?>" ).buttonset();
                            });
                            </script>

                            <div id="wtgcsv_newjob_separator_radios_<?php echo $fileChunks[0];?>">
                                <input type="radio" id="wtgcsv_separator_comma_<?php echo $fileChunks[0];?>" name="wtgcsv_newjob_separators<?php echo $fileChunks[0];?>" value="," /><label for="wtgcsv_separator_comma_<?php echo $fileChunks[0];?>">,</label>
                                <input type="radio" id="wtgcsv_separator_semicolon_<?php echo $fileChunks[0];?>" name="wtgcsv_newjob_separators<?php echo $fileChunks[0];?>" value=";" /><label for="wtgcsv_separator_semicolon_<?php echo $fileChunks[0];?>">;</label>
                                <input type="radio" id="wtgcsv_separator_tab_<?php echo $fileChunks[0];?>" name="wtgcsv_newjob_separators<?php echo $fileChunks[0];?>" value="|" /><label for="wtgcsv_separator_tab_<?php echo $fileChunks[0];?>">|</label>                
                            </div>

                        </td>
                        <td>
                            <script>
                            $(function() {
                                $( "#wtgcsv_newjob_quote_radios_<?php echo $fileChunks[0];?>" ).buttonset();
                            });
                            </script>

                            <div id="wtgcsv_newjob_quote_radios_<?php echo $fileChunks[0];?>">
                                <input type="radio" id="wtgcsv_quote_double_<?php echo $fileChunks[0];?>" name="wtgcsv_newjob_quote<?php echo $fileChunks[0];?>" value="doublequote" /><label for="wtgcsv_quote_double_<?php echo $fileChunks[0];?>">"</label>
                                <input type="radio" id="wtgcsv_quote_single_<?php echo $fileChunks[0];?>" name="wtgcsv_newjob_quote<?php echo $fileChunks[0];?>" value="singlequote" /><label for="wtgcsv_quote_single_<?php echo $fileChunks[0];?>">'</label>                
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
function wtgcsv_schedulescreen_notices(){
    global $wtgcsv_schedule_array,$wtgcsv_projectslist_array;

    // if not allowed today display
    $day = strtolower( date('l') );
    if(!isset($wtgcsv_schedule_array['times']['days'][$day])){
        echo wtgcsv_notice('Scheduled events have not been permitted for ' . date('l'),'info','Tiny','','','return');     
    }
    
    // if not allowed this hour display
    $hour = strtolower(date('G'));
    if(!isset($wtgcsv_schedule_array['times']['hours'][$hour])){
        echo wtgcsv_notice('Scheduled events have not been permitted for the current hour: ' . date('G'),'info','Tiny','','','return');    
    }
    
    // if no hours array set OR if no boolean true exists for any hours
    if( !isset($wtgcsv_schedule_array['times']) || !isset($wtgcsv_schedule_array['times']['hours']) ){
        echo wtgcsv_notice('Schedule is not ready as no hours have been permitted','info','Tiny','','','return');    
    }else{
        // if no hours are boolean true
        $hour_permitted = false;
        foreach( $wtgcsv_schedule_array['times']['hours'] as $key => $hour ){
            if($hour == true){
                $hour_permitted = true;
                break;    
            }    
        }    
        
        if(!$hour_permitted){
            echo wtgcsv_notice('Schedule paused because no hours are permitted','info','Tiny','','','return');    
        }
    }
    
    // if no days array set OR if no boolean true exists for any days
    if( !isset($wtgcsv_schedule_array['times']) || !isset($wtgcsv_schedule_array['times']['days']) ){
        echo wtgcsv_notice('Schedule is not ready as no days have been permitted','info','Tiny','','','return');    
    }else{
        // if no hours are boolean true
        $days_permitted = false;
        foreach( $wtgcsv_schedule_array['times']['days'] as $key => $day ){
            if($day == true){
                $days_permitted = true;
                break;    
            }    
        }    
        
        if(!$days_permitted){
            echo wtgcsv_notice('Schedule has been disabled because no days are permitted','info','Tiny','','','return');    
        }
    }
    
    // if no event types set display this
    if(!isset($wtgcsv_schedule_array['eventtypes'])){
        echo wtgcsv_notice('Schedule is not setup, no event types have been activated yet','info','Tiny','','','return');    
    }else{
        // have event types been disabled
        $event_type_set = false;
        foreach($wtgcsv_schedule_array['eventtypes'] as $event_type){
            if($event_type == true){
                $event_type_set = true;
                break;    
            }    
        }
        
        if(!$event_type_set){
            echo wtgcsv_notice('Schedule has been stopped because all event types are disabled','info','Tiny','','','return');    
        }
    }

    // if current 24 hour period limit reached display this
    if(isset($wtgcsv_schedule_array['history']['daycounter']) && $wtgcsv_schedule_array['history']['daycounter'] >= $wtgcsv_schedule_array['limits']['day']){
        echo wtgcsv_notice('The maximum events number for the current 24 hour period has been reached','info','Tiny','','','return');        
    }
    
    // if current 60 minute period limit reached display this
    if(isset($wtgcsv_schedule_array['history']['hourcounter']) && $wtgcsv_schedule_array['history']['hourcounter'] >= $wtgcsv_schedule_array['limits']['hour']){
        echo wtgcsv_notice('The maximum events number for the current 60 minute period has been reached','info','Tiny','','','return');        
    }

    // if no projects are on drip feeding display
    $project_dripfeeding = false;
    foreach($wtgcsv_projectslist_array as $project_code => $project_array){
        if(isset($project_array['dripfeeding']) && $project_array['dripfeeding'] == 'on'){
            $project_dripfeeding = true;
            break;
        }        
    }
    
    if(!$project_dripfeeding){
        echo wtgcsv_notice('You do not have any Post Creation Projects activated for drip-feeding through the plugins schedule','info','Tiny','','','return');    
    } 
}

/**
* Outputs a form menu of the giving database tables columns for single selection
* 
* @param string $table_name
*/
function wtgcsv_menu_tablecolumns($table_name){?>
            
    <select name="wtgcsv_table_columns_<?php echo $table_name;?>" id="wtgcsv_table_columns_<?php echo $table_name;?>_id" class="wtgcsv_multiselect_menu">
        <?php wtgcsv_options_tablecolumns($table_name);?>                                                                                                                     
    </select>        

    <script>
    $("#wtgcsv_table_columns_<?php echo $table_name;?>_id").multiselect({
       multiple: false,
       header: "Table Columns",
       noneSelectedText: "Table Columns",
       selectedList: 1
    });
    </script><?php    
}

/**
* Used on Multiple Table Project panel.
* Outputs a form menu of the giving database tables columns for single selection
* 
* @param string $table_name
*/
function wtgcsv_menu_tablecolumns_multipletableproject($table_name,$current_value = false){
    global $wtgcsv_project_array;?>
            
    <select name="wtgcsv_multitable_columns_<?php echo $table_name;?>" id="wtgcsv_multitable_columns_<?php echo $table_name;?>_id" class="wtgcsv_multiselect_menu">
        <?php wtgcsv_options_columns($table_name,$current_value);?>                                                                                                                     
    </select>        

    <script>
    $("#wtgcsv_multitable_columns_<?php echo $table_name;?>_id").multiselect({
       multiple: false,
       header: "Table Columns",
       noneSelectedText: "Table Columns",
       selectedList: 1
    });
    </script><?php    
}

/**
* Outputs the option items for form menu, adding column names from giving database table
* 
* @param mixed $table_name
* @param mixed $current_value, default boolean false, pass the current value to make it selected="selected"
*/
function wtgcsv_options_tablecolumns($table_name,$current_value = false){
    
    $column_array = wtgcsv_sql_get_tablecolumns($table_name,true,true);
     
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
function wtgcsv_options_columns($table_name,$current_value = false){
    
    $column_array = wtgcsv_sql_get_tablecolumns($table_name,true,true);
     
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
function wtgcsv_display_menu_keycolumnselection($table_name,$current_table = false,$current_column = false){
    global $wtgcsv_currentproject_code;?>
    <select name="wtgcsv_multitable_pairing_<?php echo $table_name;?>" id="wtgcsv_multitable_pairing_<?php echo $table_name;?>_id" class="wtgcsv_multiselect_menu">
        <option value="notrequired">Not Required</option>
        <?php wtgcsv_display_project_columnsandtables_menuoptions($wtgcsv_currentproject_code,$current_table,$current_column);?>                                                                                                                     
    </select>

    <script>
    $("#wtgcsv_multitable_pairing_<?php echo $table_name;?>_id").multiselect({
       multiple: false,
       header: "Select Database Column (table - column)",
       noneSelectedText: "Select Database Table",
       selectedList: 1
    });
    </script><?php    
}

/**
* Displays a checkbox menu for selecting design type.
* User can select from mulitple uses per content design,one design can have many uses.
* @todo LOWPRIORITY, remove lines not required for free edition, the loop and array
*/
function wtgcsv_display_designtype_menu($post_id){
    global $wtgcsv_is_free;
    
    // set an array of all the template types
    $templatetypes_array = array();
    $templatetypes_array[0]['slug'] = 'postcontent';
    $templatetypes_array[0]['label'] = 'Post/Page Content';      
    
    // get posts custom field holding template type string
    $customfield_types_array =  get_post_meta($post_id, '_wtgcsv_templatetypes', false);?>

    <p>        
        Design Type: 
        <?php $optionmenu = '';?>
        
        <?php $optionmenu .= '<select name="wtgcsv_designtype[]" id="wtgcsv_select_designtype" multiple="multiple" class="wtgcsv_multiselect_menu">';?>
 
            <?php
            // loop through all template types 
            foreach($templatetypes_array as $key => $type){
     
                // set selected status by checking if current $type is in the custom field value for wtgcsv_templatetypes
                $selected = '';
                if(in_array($type['slug'],$customfield_types_array,false)){
                    $selected = ' selected="selected"';
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
        
        <script>
        $("#wtgcsv_select_designtype").multiselect({
        multiple: true,
        header: "Select Template Types",
        noneSelectedText: "Select Template Types",
        selectedList: 1
        });
        </script>
            
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
* @todo HIGHPRIORITY, each file may exist in more than one data import project, so we must check this then add the file too table
* @todo MEDIUMPRIORITY, if more than 20 files are listed, create a message recommending cleanup for interface speed improvement
* @todo LOWPRIORITY, use DataTables with ability to click and view more information plus delete files.
* @todo LOWPRIORITY, a file is caused a blank age result, investigate why it happened when the file was edited then uploaded again, it could be because it was changed within seconds ago and that is not active        
* @todo LOWPRIORITY, check CSV files in plugin header and establish a CSV file array
*/
function wtgcsv_used_csv_file_list(){
    global $wtgcsv_dataimportjobs_array          ;
    
    if(!$wtgcsv_dataimportjobs_array){echo '<strong>You do not have any data import jobs</strong>';return 0;}
    
    $available = 0;
 
    $usedcsvfile_count = 0;
 
    if (!is_dir(WTG_CSV_CONTENTFOLDER_DIR)) {
    
        wtgcsv_notice('The content folder does not exist, has it been deleted or move?','error','Small','','');
                   
    }else{    
        
        @$opendir_result = opendir( WTG_CSV_CONTENTFOLDER_DIR );
        
        if(!$opendir_result){
            
            wtgcsv_notice(WTG_CSV_PLUGINTITLE . ' does not have permission to open the plugins content folder','error','Small','','');

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
            foreach($wtgcsv_dataimportjobs_array as $jobid => $job){

                // get the jobs own option record
                $jobrecord = wtgcsv_get_dataimportjob($jobid);
                if(!$jobrecord){
                    wtgcsv_notice('Failed to locate the option table record for data import job named '.$job['name'].'. Is it possible the record was deleted manually?','error','Extra');
                }else{

                    foreach($jobrecord['files'] as $key => $csvfile_name){

                        if( ($csvfile_name != ".") and ($csvfile_name != "..") ){
                            
                            $fileChunks = explode(".", $csvfile_name);
                                              
                            // ensure file extension is csv
                            if( isset( $fileChunks[1] ) && $fileChunks[1] == 'csv'){
                                
                                $file_path = WTG_CSV_CONTENTFOLDER_DIR . '/' . $csvfile_name;
                                $thefilesize = filesize($file_path);
                                $filesize_total = $thefilesize;
                                
                                $filemtime = filemtime(WTG_CSV_CONTENTFOLDER_DIR . '/' .$csvfile_name);
                                
                                if(phpversion() < '5.3'){
                                    $fileage = '';### TODO:MEDIUMPRIORITY,add a PHP 5.2 function for determing file age
                                }else{
                                    // this line is only suitable for PHP 5.3
                                    $fileage =  wtgcsv_ago( date_create(date(WTG_CSV_DATEFORMAT,$filemtime)),true,true,true,true,true,false);
                                }
                                   
                                echo '
                                <tr>                               
                                    <td>'.$job['name'].'</td>                                
                                    <td>'.$csvfile_name.'</td>                            
                                    <td>'.count(file(WTG_CSV_CONTENTFOLDER_DIR . '/' .$csvfile_name)).'</td>
                                    <td>'.wtgcsv_format_file_size($thefilesize).'</td>
                                    <td>'.wtgcsv_sql_count_records_forfile('wtgcsv_'.$jobid,$csvfile_name,$key).'</td>                                                       
                                    <td>'.$fileage.'</td>                            
                                </tr>';                    
                                
                            }// end if csv
                            
                        }// end if $filename = .
                        
                        ++$usedcsvfile_count;
                    }    
                }
            }
   
            echo '</table>';
            
            wtgcsv_notice_filesizetotal($filesize_total);

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
function wtgcsv_ago( $datetime,$use_year = true,$use_month = true,$use_day = true,$use_hour = true,$use_minute = true,$use_second = false ){
 
    // PHP 5.3 method is currently the best             
    $interval = date_create('now')->diff( $datetime );
    
    $ago_string = ' ';
             
    // year
    if($use_year){
        if ( $interval->y >= 1 ){
            $ago_string .= wtgcsv_pluralize( $interval->y, 'year' );        
        } 
    }

    // month
    if($use_month){
        if ( $interval->m >= 1 ){
            $ago_string_with_comma_month = wtgcsv_commas($ago_string); 
            $ago_string = $ago_string_with_comma_month . wtgcsv_pluralize( $interval->m, 'month' );        
        } 
    }  
        
    // day
    if($use_day){
        if ( $interval->d >= 1 ){
            $ago_string_with_comma_day = wtgcsv_commas($ago_string);            
            $ago_string = $ago_string_with_comma_day . wtgcsv_pluralize( $interval->d, 'day' );        
        } 
    }
    
    // hour
    if($use_hour){
        if ( $interval->h >= 1 ){
            $ago_string_with_comma_hour = wtgcsv_commas($ago_string);            
            $ago_string = $ago_string_with_comma_hour . wtgcsv_pluralize( $interval->h, 'hour' );        
        } 
    }       

    // minute
    if($use_hour){
        if ( $interval->m >= 1 ){
            $ago_string_with_comma_minute = wtgcsv_commas($ago_string);            
            $ago_string = $ago_string_with_comma_minute . wtgcsv_pluralize( $interval->m, 'minute' );        
        } 
    }

    // second
    if($use_second){
        if ( $interval->s >= 1 ){
            $ago_string_with_comma_second = wtgcsv_commas($ago_string);            
            $ago_string = $ago_string_with_comma_second . wtgcsv_pluralize( $interval->s, 'second' );        
        } 
    }    
    
    return $ago_string;
}
?>
