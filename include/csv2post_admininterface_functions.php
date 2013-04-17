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
    global $csv2post_currentversion,$csv2post_mpt_arr,$wtgtp_homeslug,$csv2post_pluginname,$csv2post_is_installed,$csv2post_is_free;
     
    $n = $csv2post_pluginname;

    // if file version is newer than install we display the main page only but re-label it as an update screen
    // the main page itself will also change to offer plugin update details. This approach prevent the problem with 
    // visiting a page without permission between installation
    $installed_version = csv2post_WP_SETTINGS_get_version();                

    if(!$csv2post_is_installed && !isset($_POST['csv2post_plugin_install_now'])){   
       
        // if URL user is attempting to visit any screen other than page=csv2post then redirect to it
        if(isset($_GET['page']) && strstr($_GET['page'],'csv2post_')){
            wp_redirect( get_bloginfo('url') . '/wp-admin/admin.php?page=csv2post' );           
            exit;    
        }
        
        // if plugin not installed
        add_menu_page(__('Install',$n.'install'), __('CSV 2 POST Install','home'), 'administrator', 'csv2post', 'csv2post_page_toppage' );
        
    }elseif(isset($csv2post_currentversion) 
    && isset($installed_version) 
    && $installed_version != false
    && $csv2post_currentversion > $installed_version 
    && !isset($_POST['csv2post_plugin_update_now'])){
        
        // if URL user is attempting to visit any screen other than page=csv2post then redirect to it
        if(isset($_GET['page']) && strstr($_GET['page'],'csv2post_')){
            wp_redirect( get_bloginfo('url') . '/wp-admin/admin.php?page=csv2post' );
            exit;    
        }
                
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
    $counter = 1;?>
        
        <script language="JavaScript">
        function csv2post_deleteoptions_checkboxtoggle(source) {
          checkboxes = document.getElementsByName('csv2post_deleteoptions_array[]');
          for(var i in checkboxes)
            checkboxes[i].checked = source.checked;
        }
        </script>

        <input type="checkbox" onClick="csv2post_deleteoptions_checkboxtoggle(this)" /> Select All Options<br/>
    
    <?php       
    foreach($csv2postrecords_result as $key => $option ){
        
        if($form){
            $form = '<input type="checkbox" name="csv2post_deleteoptions_array[]" value="'.$option.'" />';
        }
        
        echo csv2post_notice($form . ' ' . $counter . '. ' . $option,'success',$size,'','','return');
        
        ++$counter;
    }
}

/**
* Outputs details of the current project, used under the title 
*/
function csv2post_GUI_currentproject(){
    global $csv2post_is_free,$csv2post_dataimportjobs_array;
    // main page header
    if(!$csv2post_is_free){
        $jobcode = csv2post_get_option_currentjobcode();

        $jobname = 'None';
        if($jobname_result = csv2post_current_jobname()){
            $jobname = $jobname_result;
        }
        
        csv2post_n_screeninfo('Post Creation Project','
        <strong>Data Import Job:</strong> '. $jobname .'<br />
        <strong>Post Creation Project:</strong> ' . csv2post_get_current_project_name() );
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
 * 
 * @deprecated 16th February 2013 use csv2post_display_accordianpanel_buttons()
 */
function csv2post_panel_support_buttons($panel_array){
    csv2post_display_accordianpanel_buttons($panel_array);  
}

/**
* Easy Configuration Questions
* 
* @link http://www.erichynds.com/jquery/jquery-ui-multiselect-widget/
*/
function csv2post_easy_configuration_questionlist_demo(){
    global $csv2post_ecq_array;
             
    // count number of each type of question added for adding ID value to script
    $singles_created = 0;// count number of single answer questions added (radio button)
    $multiple_created = 0;
    $text_created = 0;
    $slider_created = 0;
    $noneactive = 0; 
            
    foreach($csv2post_ecq_array as $key => $question){
        
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
 * Adds a widget to thedashboard showing plugins RSS updates
 */
function csv2post_add_dashboard_rsswidget() {
    global $csv2post_plugintitle;
    wp_add_dashboard_widget('wtgtp_rsswidget_dashboard', $csv2post_plugintitle.' Updates', 'csv2post_feedburner_widget');
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
        
        if($opendir_result){?>
        
            <script language="JavaScript">
            function csv2post_deletecsvfiles_checkboxtoggle(source) {
              checkboxes = document.getElementsByName('csv2post_deletecsvfiles_array[]');
              for(var i in checkboxes)
                checkboxes[i].checked = source.checked;
            }
            </script>

            <input type="checkbox" onClick="csv2post_deletecsvfiles_checkboxtoggle(this)" /> Select All Files<br/>
            
            <?php $counter = 0;

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
                <td width="25"></td>        
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



###########################################################################################
#                                                                                         #
#                                       FORM MENUS                                        #
#                                                                                         #
###########################################################################################
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
* Adds option items to a menu for data import tables. A CSV 2 POST 
* exclusive function because it uses csv2post_get_dataimportjob_name_by_table()
* 
* @uses csv2post_get_dataimportjob_name_by_table()
* 
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
        if($project_code != 'arrayinfo'){
            echo '<option value="'.$project_code.'">'.$project['name'].'</option>';
        }    
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
* Outputs form objects: post statuses as form radio buttons
* 
* @param mixed $i
*/
function csv2post_FORMOBJECT_poststatus_radios($i){ 
    foreach(get_post_statuses() as $status_name => $status_title){

        if(isset($csv2post_project_array['poststatus']) && $csv2post_project_array['poststatus'] == $status_name){
            $statuschecked = 'checked';
        }else{
            $statuschecked = '';
        }
        
        // apply default
        if($status_name == 'publish' && $statuschecked == ''){
            $statuschecked = 'checked';
        }                              
              
        echo '<input type="radio" id="csv2post_radio'.$status_name.'_poststatus_objectid_'.$i.'" name="csv2post_radio_poststatus" value="'.$status_name.'" '.$statuschecked.' />
        <label for="csv2post_radio'.$status_name.'_poststatus_objectid_'.$i.'">'.$status_title.'</label>';                                 
    }  
} 

/**
* Outputs post formats as form radio objects 
* 
* @param mixed $i
*/
function csv2post_FORMOBJECT_postformat_radios($i){ 
    if ( current_theme_supports( 'post-formats' ) ) {
        $post_formats = get_theme_support( 'post-formats' );

        if ( is_array( $post_formats[0] ) ) {
            
            foreach($post_formats[0] as $key => $format){

                if(isset($csv2post_project_array['postformat']['default']) && $csv2post_project_array['postformat']['default'] == $format){
                    $statuschecked = 'checked="checked"';
                }else{
                    $statuschecked = '';
                }
                                                    
                echo '<input type="radio" id="csv2post_radio'.$format.'_postformat_objectid_'.$i.'" name="csv2post_radio_postformat" value="'.$format.'" '.$statuschecked.' />
                <label for="csv2post_radio'.$format.'_postformat_objectid_'.$i.'">'.$format.'</label>';                                 
            }
            
            if($statuschecked == ''){$statuschecked = 'checked="checked"';}
            
            echo '<input type="radio" id="csv2post_radiostandard_postformat_objectid_'.$i.'" name="csv2post_radio_postformat" value="standard" '.$statuschecked.' />
            <label for="csv2post_radiostandard_postformat_objectid_'.$i.'">standard (default)</label>';               
                
        }    
      
    }else{
        echo '<input type="radio" id="csv2post_radiostandard_postformat_objectid_'.$i.'" name="csv2post_radio_postformat" value="standard" checked="checked" />
        <label for="csv2post_radiostandard_postformat_objectid_'.$i.'">Your Theme Does Not Support Post Formats</label>';        
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
            
            $t = 'None';
            if(isset($rule['template_id'])){$t = $rule['template_id'];} 
                       
            echo '<tr class="first">
                <td><input type="checkbox" name="csv2post_customfield_rule_arraykey" value="'.$key.'" /></td>
                <td>'.$rule['meta_key'].'</td>               
                <td>'.$table.'</td>
                <td>'.$column.'</td>
                <td>'.$t.'</td>
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
        
        $counter = 1;?>
        
        <script language="JavaScript">
        function csv2post_deletejobtables_checkboxtoggle(source) {
          checkboxes = document.getElementsByName('csv2post_deletejobtables_array[]');
          for(var i in checkboxes)
            checkboxes[i].checked = source.checked;
        }
        </script>

        <input type="checkbox" onClick="csv2post_deletejobtables_checkboxtoggle(this)" /> Select All Tables<br/>
        
        <?php
        foreach( $csv2post_jobtable_array as $key => $table_name ){
            
            $jobcode = str_replace('csv2post_','',$table_name);
              
            $table_exists_result = csv2post_WP_SQL_does_table_exist( $table_name );
            
            if($table_exists_result){
                $table_row_count = csv2post_WP_SQL_counttablerecords($table_name);
                
                $form = '<input type="checkbox" name="csv2post_deletejobtables_array[]" id="csv2post_deletejobtables_array" value="'.$table_name.'" />';
               
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
    
    if($contentfolder_exists){?>
        
        <script language="JavaScript">
        function csv2post_deletefolders_checkboxtoggle(source) {
          checkboxes = document.getElementsByName('csv2post_deletefolders_array[]');
          for(var i in checkboxes)
            checkboxes[i].checked = source.checked;
        }
        </script>

        <input type="checkbox" onClick="csv2post_deletefolders_checkboxtoggle(this)" /> Select All Folders<br/>
        
        <?php echo csv2post_notice('<input type="checkbox" name="csv2post_deletefolders_array[]" value="wpcsvimportercontent" />' . ' 1. wpcsvimportercontent','success','Tiny','','','return');                
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
            foreach( $csv2post_projectslist_array as $project_code => $project ){
                if($project_code != 'arrayinfo'){?>
                    <tr class="first">
                        <td><?php echo $project_code;?></td>
                        <td><?php echo $project['name'];?></td>
                        <td><?php echo csv2post_display_projectstables_commaseparated($project_code);?></td>                                                                               
                    </tr><?php 
                }    
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
    global $csv2post_dataimportjobs_array,$csv2post_jobtable_array,$csv2post_is_free,$csv2post_plugintitle,$csv2post_adm_set;
    
    // count number of job tables we have registered
    $table_count = 0;
    if(is_array($csv2post_jobtable_array)){
        $table_count = count($csv2post_jobtable_array);
    }
    
    // if no applicable database tables would be displayed, display message
    if($csv2post_is_free && $table_count == 0){
        echo csv2post_notice('Your database does not have any tables created by CSV 2 POST. 
        You will need to create a Data Import Job, that will create a new database table for storing
        your data. Then return here to create a Post Creation Project.',
        'warning','Small','','','return');    
    }else{
        
        echo '<table class="widefat post fixed"><tr class="first">';
        
        if($checkbox_column){
            echo '<td width="25"></td>';        
        }
        
        echo '<td width="200"><strong>Table Names</strong></td>
            <td width="150"><strong>Data Import Job</strong></td>
            <td width="100"><strong>Records</strong></td>
            <td width="100"><strong>Used</strong></td>
            <td width="100"><strong>Reset Table</strong></td>
            <td><strong>Reset Posts</strong></td>                                                                              
        </tr>'; 
        
        $table_exclusions = array('csv2post_log','csv2post_ryanair_aircraft','csv2post_ryanair_dfformstaff','csv2post_ryanair_eposerrors','csv2post_ryanair_flight','csv2post_ryanair_onlinedf1_products','csv2post_ryanair_producthistory','csv2post_ryanair_session');
        
        $table_count = 0;

        $tables = csv2post_WP_SQL_get_tables();

        while ($table_name = mysql_fetch_row($tables)) {                
            
            // should table name be shown
            $show_table = true;
            
            if($show_table){   
                // I decided free users should not get a plugin that offers open access to Wordpress database tables.
                // I would like to reduce such access at least until better documentation is released and more security added
                if($csv2post_is_free && !strstr($table_name[0],'csv2post_') || in_array($table_name[0],$table_exclusions)){
                
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
                        if($csv2post_is_free || isset($csv2post_adm_set['ecq'][112]) && $csv2post_adm_set['ecq'][112] == 'no' ){
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
        }   
                     
        echo '</table>';
    }
    
    return $table_count;               
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
* Displays a list of CSV file for selection. 
* User can select separator and quote also. The table also displays the auto determined separator and quote using PEAR CSV.
* 
* @todo LOWPRIORITY, consider using pathinfo() to check if file has .csv and use  RecursiveDirectoryIterator to cycle through files
*/
function csv2post_display_csvfiles_fornewdataimportjob(){
    global $csv2post_is_free,$csv2post_adm_set;  

    // if no CSV files in content folder do not display table header (added March 2013)
    if(!csv2post_does_folder_contain_file_type(WTG_C2P_CONTENTFOLDER_DIR,'csv')){
        
        csv2post_n_incontent('You have not uploaded any CSV file to the plugins content folder which should be
        in the Wordpress "wp-content" directory. You can upload using the plugin or FTP.','info','Small','No CSV Files');
        
        return false;
    }
    
    echo '<table class="widefat post fixed">';
            
    echo '
    <tr>
        <td width="25"></td>
        <td width="150">CSV File Name</td>
        <td width="70">Columns</td>        
        <td width="90">Separator</td>
        <td>Quote</td> 
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
                            
                            // radio or checkboxes
                            $object_type = 'checkbox';
                            if($csv2post_is_free || isset($csv2post_adm_set['ecq'][110]) && $csv2post_adm_set['ecq'][110] == 'no'){
                                $object_type = 'radio';
                            }?>
               
                            <input type="<?php echo $object_type;?>" name="csv2post_newjob_included_csvfiles[]" id="csv2post_newjob_includefile_<?php echo $fileChunks[0];?>" value="<?php echo $filename;?>" />
                   
                        <?php 
                        ### TODO:HIGHPRIORITY, change the PEARCSVmethod for quote in the fget column
                        echo '</td>
                        <td>'.$filename.'</td>
                        <td><input type="text" name="csv2post_csvfile_fieldcount_'.$fileChunks[0].'" size="2" maxlength="2" value="" /></td>
                        <td>'; ?>
                  
                            <input type="radio" id="csv2post_separator_comma_<?php echo $fileChunks[0];?>" name="csv2post_newjob_separators<?php echo $fileChunks[0];?>" value="," /><label for="csv2post_separator_comma_<?php echo $fileChunks[0];?>"> <strong>,</strong> </label>
                            <br><input type="radio" id="csv2post_separator_semicolon_<?php echo $fileChunks[0];?>" name="csv2post_newjob_separators<?php echo $fileChunks[0];?>" value=";" /><label for="csv2post_separator_semicolon_<?php echo $fileChunks[0];?>"> <strong>;</strong> </label>
                            <br><input type="radio" id="csv2post_separator_tab_<?php echo $fileChunks[0];?>" name="csv2post_newjob_separators<?php echo $fileChunks[0];?>" value="|" /><label for="csv2post_separator_tab_<?php echo $fileChunks[0];?>"> <strong>|</strong> </label>                
                  
                        </td>
                        <td>
          
                            <input type="radio" id="csv2post_quote_double_<?php echo $fileChunks[0];?>" name="csv2post_newjob_quote<?php echo $fileChunks[0];?>" value="doublequote" /><label for="csv2post_quote_double_<?php echo $fileChunks[0];?>"> <strong>"</strong></label>
                            <br><input type="radio" id="csv2post_quote_single_<?php echo $fileChunks[0];?>" name="csv2post_newjob_quote<?php echo $fileChunks[0];?>" value="singlequote" /><label for="csv2post_quote_single_<?php echo $fileChunks[0];?>"> <strong>'</strong></label>                
                                               
                        </td>
                    </tr><?php                         
                }                   
                
            }// end if csv
            
        }// end if $filename = .  
    }// end while
    
    echo '</table>';    
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

                        // if file no longer exists
                        if(!csv2post_files_does_csvfile_exist($csvfile_name)){
                            
                            echo '
                            <tr>                               
                                <td>Unknown</td>                                
                                <td>'.$csvfile_name.' (file no longer exists)</td>                            
                                <td></td>
                                <td></td>
                                <td></td>                                                       
                                <td></td>                            
                            </tr>';  
                            
                        }else{
                            
                            
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
                        }// end if file exists
                        
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
                    <td width="25"></td>
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
           
                            <input type="<?php echo $objects;?>" name="csv2post_delete_csvfiles[]" id="csv2post_delete_csvfiles_<?php echo $fileChunks[0];?>" value="<?php echo $filename;?>" />                    
                          
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
* Displays menu of all categories for use in CSV 2 POST mapping 
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
*/
function csv2post_display_project_columnsandtables_menuoptions($project_code,$current_table = 'NOTPROVIDED98723462',$current_column = 'NOTPROVIDED09871237'){
    
    if(!$project_code){
        echo '<option value="nocurrentproject">No Current Project</option>';        
    }else{

        global $csv2post_project_array;

        // hide operation columns
        $exclude = array('csv2post_id','csv2post_postid','csv2post_postcontent','csv2post_inuse'
        ,'csv2post_importer','csv2post_updated','csv2post_changed','csv2post_applied','csv2post_catid'
        ,'csv2post_filemoddate','csv2post_filedone');

        // category splitter special columns
        if(!isset($csv2post_project_array['categories']['splitter']['table']) 
        || !isset($csv2post_project_array['categories']['splitter']['column'])
        || !isset($csv2post_project_array['categories']['splitter']['separator'])){
            $exclude = array_merge($exclude,array('splitcat1','splitcat2','splitcat3','splitcat4','splitcat5'));
        }
        
        $tables_count = count($csv2post_project_array['tables']);
            
        foreach( $csv2post_project_array['tables'] as $key => $table ){
            $table_columns = csv2post_WP_SQL_get_tablecolumns($table);
            
            if($table_columns == false){
                echo '<option value="fault">Problem Detected In Relation To Table Named: '.$table.'</option>';        
            }else{
                while ($row_column = mysql_fetch_row($table_columns)) {

                    // establish selected status for this option
                    $selected = '';
                    
                    // we use a random number so that it can never match a users own column
                    if($current_table != 'NOTPROVIDED98723462' && $current_column != 'NOTPROVIDED09871237'){
                        if($current_table == $table && $current_column == $row_column[0]){
                            $selected = ' selected="selected"';
                        }    
                    } 
                    
                    // must add table name also to avoid confusion when two or more tables share the same column name               
                    if(!in_array($row_column[0],$exclude)){
                        
                        if($tables_count > 1){    
                            $option_title = $table . ' - '.$row_column[0];    
                        }else{
                            $option_title = $row_column[0];
                        }
                        
                        echo '<option value="'.$table.','.$row_column[0].'"'.$selected.'>' . $option_title .'</option>'; 
                    }
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
            echo '<option value="notselected">No Selection Made</option>';
        }
        
        foreach( $csv2post_project_array['tables'] as $key => $t ){
            $table_columns = csv2post_WP_SQL_get_tablecolumns($t);
            
            if($table_columns == false){
                
                echo '<option value="notselected">Problem Detected In Relation To Table Named: '.$t.'</option>';        
            
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

function csv2post_GUI_datajob_columnsandtables_menu($current_table = 'NOTPROVIDED256786767',$current_column = 'NOTPROVIDED434588814'){

    global $csv2post_currentjob_code;
    if(!$csv2post_currentjob_code){
        echo '<option value="notselected">No Data Import Job</option>';        
    }else{

        // hide operation columns
        $exclude = array('csv2post_id','csv2post_postid','csv2post_postcontent','csv2post_inuse'
        ,'csv2post_importer','csv2post_updated','csv2post_changed','csv2post_applied','csv2post_catid'
        ,'csv2post_filemoddate','csv2post_filedone');

        $table = 'csv2post_' . $csv2post_currentjob_code;
        
        $tables_count = count($table);
            
        $table_columns = csv2post_WP_SQL_get_tablecolumns($table);
        
        if($table_columns == false){
            echo '<option value="fault">Problem Detected In Relation To Table Named: '.$table.'</option>';        
        }else{
            while ($row_column = mysql_fetch_row($table_columns)) {

                // establish selected status for this option
                $selected = '';
                
                ### TODO:MEDIUMPRIORITY change these not provided values all over the plugin
                ### we use a random number so that it can never match a users own column name but this approach has not been used everywhere
                if($current_table != 'NOTPROVIDED256786767' && $current_column != 'NOTPROVIDED434588814'){
                    if($current_table == $table && $current_column == $row_column[0]){
                        $selected = ' selected="selected"';
                    }    
                } 
                
                // must add table name also to avoid confusion when two or more tables share the same column name               
                if(!in_array($row_column[0],$exclude)){
                    
                    if($tables_count > 1){    
                        $option_title = $table . ' - '.$row_column[0];    
                    }else{
                        $option_title = $row_column[0];
                    }
                    
                    echo '<option value="'.$table.','.$row_column[0].'"'.$selected.'>' . $option_title .'</option>'; 
                }
            }  
        }                        
    }  
}                                                                                                              
?>