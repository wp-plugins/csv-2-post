<?php 
/**
* Enqueues scripts using Wordpress functions.
* This is where new .js files should be added. 
*/
function csv2post_print_admin_scripts() {
         
     // $csv2post_js_switch and similiar variables set in main file
     $csv2post_js_switch = true;
     if($csv2post_js_switch == true){
        
        ########################################
        #                                      #
        #                jquery                #
        #                                      #
        ######################################## 
        wp_deregister_script( 'jquery' );
            //wp_register_script( 'jquery');                
            wp_register_script( 'jquery','http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
            //wp_register_script( 'jquery','http://ajax.googleapis.com/ajax/libs/jquery/1.8.23/jquery.min.js');
            //wp_register_script( 'jquery',WTG_C2P_URL.'templatesystem/script/jquery-1.7.1.js');
        wp_enqueue_script( 'jquery' );
                                                                                                
        ########################################
        #                                      #
        #                jquery-ui             #
        #                                      #
        ########################################    
        wp_deregister_script( 'jquery-ui' );
            //wp_register_script( 'jquery-ui');
            //wp_register_script( 'jquery-ui', 'http://jquery-ui.googlecode.com/svn/tags/latest/ui/jquery-ui.js');
            wp_register_script( 'jquery-ui', WTG_C2P_URL.'templatesystem/script/jquery-ui.js');
        wp_enqueue_script( 'jquery-ui' );
        
        #####################################################################################
        #                                                                                   #
        #                        SCRIPTS NOT PACKAGED WITH WORDPRESS                        #
        #                                                                                   #
        #####################################################################################
        // multiselect (checkbox menus)
        wp_register_script('jquery-multiselect',WTG_C2P_URL.'templatesystem/script/multiselect/src/jquery.multiselect.js');
        wp_enqueue_script('jquery-multiselect');
        
        // multiselect (theming I think)
        wp_register_script('jquery-multiselect-prettify',WTG_C2P_URL.'templatesystem/script/multiselect/assets/prettify.js');
        wp_enqueue_script('jquery-multiselect-prettify');
                
        // multiselect menu filter (filter may not be used much until 2013 but the menu is used a lot)
        wp_register_script('jquery-multiselect-filter',WTG_C2P_URL.'templatesystem/script/multiselect/src/jquery.multiselect.filter.js');
        wp_enqueue_script('jquery-multiselect-filter');
                
        // multi-select (lists, not the same as multiselect menus)
        wp_register_script('jquery-multi-select',WTG_C2P_URL.'templatesystem/script/multi-select-basic/jquery.multi-select.js');
        wp_enqueue_script('jquery-multi-select');
        
        // multi-select (lists, not the same as multiselect menus)
        wp_register_script('jquery-cookie',WTG_C2P_URL.'templatesystem/script/jquery.cookie.js');
        wp_enqueue_script('jquery-cookie');        
     }
}
               
/**
 * Checks existing plugins and displays notices with advice or informaton
 * This is not only for code conflicts but operational conflicts also especially automated processes
 *
 * $return $critical_conflict_result true or false (true indicatesd a critical conflict found, prevents installation, this should be very rare)
 * 
 * @todo make this function available to process manually so user can check notices again
 * @todo re-enable warnings for none activated plugins is_plugin_inactive, do so when Notice Boxes have closure button
 */
function csv2post_plugin_conflict_prevention(){
    // track critical conflicts, return the result and use to prevent installation
    // only change $conflict_found to true if the conflict is critical, if it only effects partial use
    // then allow installation but warn user
    $conflict_found = false;
    
    // we create an array of profiles for plugins we want to check
    $plugin_profiles = array();

    // Tweet My Post (javascript conflict and a critical one that breaks entire interface)
    $plugin_profiles[0]['switch'] = 1;//used to use or not use this profile, 0 is no and 1 is use
    $plugin_profiles[0]['title'] = 'Tweet My Post';
    $plugin_profiles[0]['slug'] = 'tweet-my-post/tweet-my-post.php';
    $plugin_profiles[0]['author'] = 'ksg91';
    $plugin_profiles[0]['title_active'] = 'Tweet My Post Conflict';
    $plugin_profiles[0]['message_active'] = __('On 16th August 2012 a critical and persistent conflict was found 
    between Tweet My Post 
    and CSV 2 POST. It breaks the plugins dialogue boxes (jQuery UI Dialogue) while the plugin is active,
    you may not be able to install CSV 2 POST due to this. After some searching we found many others to be having
    JavaScript related conflicts with this plugin, which the author responded too. Please ensure you have the latest
    version installed.
    The closest cause I found in terms of code was line 40 where a .js file (jquery-latest) is registered. This
    file is not used in CSV 2 POST so at this time we are not sure why the conflict happens. Please let us know
    if your urgently need this conflict fixed. We will investigate but due to the type of plugin, it is not urgent.
    Auto-tweeting is not recommended during auto blogging due to the risk of spamming Twitter. If you know the plugin
    well you can avoid spamming however and so let us know if this conflict is a problem for you.');
    $plugin_profiles[0]['title_inactive'] = 'title inactive';
    $plugin_profiles[0]['message_inactive'] = __('message inactive');
    $plugin_profiles[0]['type'] = 'info';//passed to the message function to apply styling and set type of notice displayed
    $plugin_profiles[0]['criticalconflict'] = true;// true indicates that the conflict will happen if plugin active i.e. not specific settings only, simply being active has an effect
    
    // Wordpress HTTPS
    $plugin_profiles[1]['switch'] = 1;//used to use or not use this profile, 0 is no and 1 is use
    $plugin_profiles[1]['title'] = 'Wordpress HTTPS';
    $plugin_profiles[1]['slug'] = 'wordpress-https/wordpress-https.php';
    $plugin_profiles[1]['author'] = 'Mvied';
    $plugin_profiles[1]['title_active'] = 'Wordpress HTTPS Conflict';
    $plugin_profiles[1]['message_active'] = __('On 15th August 2012 a critical and persistent conflict was found 
    between Wordpress HTTPS and CSV 2 POST. It breaks the jQuery UI tabs by making all panels/features show on
    one screen rather than on individual tabbed screens. A search on Google found many posts regarding the
    plugin causing JavaScript related conflicts, responded too my the plugins author. So please ensure you
    have the latest version. One of the posts suggested the fault, was exactly as we found to be causing our
    broken interface in CSV 2 POST. URL were being re-written, specifically those passed through jQuery UI functions
    were having a slash removed. It would not just break the interface but submitting some forms would fail
    because the action location URL would be wrong. This sounds like the fault described by a Wordpress HTTPS user,
    before the author responded to it. So not sure what is going on but right now we do not feel we can provide the
    fix. Please still let us know if you are seeing this message, we need to know how popular the conflicting plugin
    is while using CSV 2 POST for auto-blogging.');
    $plugin_profiles[1]['title_inactive'] = 'title inactive';
    $plugin_profiles[1]['message_inactive'] = __('message inactive');
    $plugin_profiles[1]['type'] = 'info';//passed to the message function to apply styling and set type of notice displayed
    $plugin_profiles[1]['criticalconflict'] = true;// true indicates that the conflict will happen if plugin active i.e. not specific settings only, simply being active has an effect

    /*******  type values =  success,warning,error,question,processing,stop    *****/
                                  
    // loop through the profiles now
    if(isset($plugin_profiles) && $plugin_profiles != false){
        foreach($plugin_profiles as $key=>$plugin){   
            if( is_plugin_active( $plugin['slug']) ){ 
               
                // recommend that the user does not use the plugin
                csv2post_notice($plugin['message_active'],'warning','Large',$plugin['title_active'],'','echo');

                // if the conflict is critical, we will prevent installation
                if($plugin['criticalconflict'] == true){
                    $conflict_found = true;// indicates critical conflict found
                }
                
            }elseif(is_plugin_inactive($plugin['slug'])){
                // warn user about potential problems if they active the plugin
                // csv2post_notice($plugin['message_inactive'],'info','Tiny',false);
            }
        }
    }

    return $conflict_found;
}
    
/**
* Put the function in the head of a file to prevent it being called directly. 
* Uses function_exists to check if a common Wordpress function has loaded, indicating
* Wordpress has loaded. Wordpress security would the be in effect. 
*/
function csv2post_exit_forbidden_request($file = 'Unknown'){
    if (!function_exists('add_action')) {
        header('Status: 403 Forbidden');
        header('HTTP/1.1 403 Forbidden');
        exit();
    }
}

/**
* When request will display maximum php errors including Wordpress errors 
*/
function csv2post_debugmode(){
    global $csv2post_debug_mode;
    if($csv2post_debug_mode){
        global $wpdb;
        ini_set('display_errors',1);
        error_reporting(E_ALL);
        $wpdb->show_errors();
        $wpdb->print_error();
    }
}

/**
* Compares plugins required minimum php version too the servers. 
* Uses wp_die if version does not match and displays message 
*/
function csv2post_php_version_check_wp_die(){
    global $csv2post_php_version_minimum,$csv2post_currentversion;
    if ( version_compare(PHP_VERSION, $csv2post_php_version_minimum, '<') ) {
        if ( is_admin() && (!defined('DOING_AJAX') || !DOING_AJAX) ) {
            require_once ABSPATH.'/wp-admin/includes/plugin.php';
            deactivate_plugins( 'csv-2-post' );
            csv2post_notice('Wordpress 3.2.1 (or a later version) and '.WTG_C2P_PLUGINTITLE.' '.$csv2post_currentversion.' requires PHP '.$csv2post_php_version_minimum.' 
            or later to operate fully. Your PHP version was detected as '.PHP_VERSION.', it is recommended that you upgrade your PHP
            on your hosting for security and reliability. You can get suitable hosting here at <a href="http://www.webtechglobal.co.uk">WebTechGlobal Hosting</a> for
            free simply for trying the plugin.','error','Extra','CSV 2 POST Requires PHP 5.3 Above','','echo');
        }
    }
}

function csv2post_data_import_from_csvfile_basic( $csvfile_name, $table_name, $target = 1, $jobcode ){
    
    global $wpdb;
    
    csv2post_pearcsv_include();    

    // get files modification time
    $csvfile_modtime = filemtime(WTG_C2P_CONTENTFOLDER_DIR .'/'. $csvfile_name);
    
    // set job statistics
    $inserted = 0;// INSERT to table
    $updated = 0;// UPDATE on a record in table
    $deleted = 0;// DELETE record when CSV file does not appear to still include it
    $void = 0;// IMPORTED OR UPDATE, but then made void so it cannot be used
    $dropped = 0;// number or rows that have been skipped, possibly through failure or users configuration
    $duplicates = 0;
    // NEW VARIABLES
    $continue = false;// when set to true it indicates that the loop has passed all rows already processed
    $new_rows_processed = 0;// $new_rows_processed is the counter when a record is created in database ready to update row data to    
    $while_start = 0;// counter increased at very beginning of while loop
    $while_end = 0;// counter increased at very end of while loop
        
    // get the data import job array
    $dataimportjob_array = csv2post_get_dataimportjob($jobcode); 
      
    // TEMPORARY VARIABLES TODO: HIGHPRIORITY, set these variables using the job details
    $multiplefile_project = true;
    $duplicate_check = false;
    $default_order = true;
    
    // set configuration array
    $conf = array();
    $conf['sep'] = $dataimportjob_array[$csvfile_name]['separator'];
    $conf['quote'] = $dataimportjob_array[$csvfile_name]['quote'];
    $conf['fields'] = $dataimportjob_array[$csvfile_name]['fields']; 
    
    // get files past progress - this is used to skip CSV file rows until reaching a row not yet processed
    $progress = 0;
    if(isset($dataimportjob_array['stats']['allevents']['progress'])){
        $progress = $dataimportjob_array['stats']['allevents']['progress'];
    }
       
    // point where loop finished last - we loop until at the record after it (this includes the header row)
    $lastrow = 0;
    if(isset($dataimportjob_array['stats'][$csvfile_name]['lastrow'])){
        $lastrow = $dataimportjob_array['stats'][$csvfile_name]['lastrow'];
    }

    // loop through records using PEAR CSV File_CSV::read   
    while ( ( $record = File_CSV::read( WTG_C2P_CONTENTFOLDER_DIR .'/'. $csvfile_name, $conf ) ) ) {        
        ++$while_start;// used to know where we should continue in new events 
            
        // if 2nd row or after
        if($while_start > 1){

            if($while_start > $lastrow ){
                     
                // set $record_id too false, it will need to be an integer before row is updated too record (applies too single or multi file)
                $record_id = false;

                # This is where we could locate existing record id for updating events
                                               
                // if $record_id still false, default to creating a new record
                if( $record_id === false ){ 
                    $record_id = csv2post_query_insert_new_record( $table_name, $csvfile_modtime ); 
                    ++$new_rows_processed;   
                }
                           
                /**
                * UPDATE RATHER THAN INSERT
                * 
                * Statistics will be recorded as an INSERT because the CSV file row is being used for the first time.
                * My approach of creating the record first is required for multiple file import. So although an SQL
                * UPDATE query is used, we are in the eyes of users, inserting the data for the first time.
                * 
                * This makes this function suitable for user requested data updating
                */

                $updaterecord_result = csv2post_sql_update_record_dataimportjob( $record, $csvfile_name, $conf['fields'], $jobcode,$record_id, $dataimportjob_array[$csvfile_name]['headers'],$dataimportjob_array['filegrouping'] );

                if($updaterecord_result){  
                    ++$inserted;    
                }else{             
                    ++$dropped;
                } 
            }
        } 
        
        // if $new_rows_processed == $target break loop (we met users requested rows)
        if($new_rows_processed == $target){
            break;
        }

        // unset variables
        unset($updaterecord_result);
        unset($record_id);
        
        ++$while_end;        
    }
 
    #############################################################################
    #                                                                           #
    #             END OF DATA IMPORT JOB EVENT - STORE STATISTICS               #
    #                                                                           #
    #############################################################################
    // update last event values
    $dataimportjob_array['stats']['lastevent']['loop_count'] = $while_start;    
    $dataimportjob_array['stats']['lastevent']['processed'] = $new_rows_processed;
    $dataimportjob_array['stats']['lastevent']['inserted'] = $inserted;    
    $dataimportjob_array['stats']['lastevent']['updated'] = $updated;    
    $dataimportjob_array['stats']['lastevent']['deleted'] = $deleted;        
    $dataimportjob_array['stats']['lastevent']['void'] = $void;        
    $dataimportjob_array['stats']['lastevent']['dropped'] = $dropped;        
    $dataimportjob_array['stats']['lastevent']['duplicates'] = $duplicates;
    // update all event values
    $dataimportjob_array['stats']['allevents']['progress'] = $while_start + $dataimportjob_array['stats']['allevents']['progress'];
    $dataimportjob_array['stats']['allevents']['inserted'] = $inserted + $dataimportjob_array['stats']['allevents']['inserted'];    
    $dataimportjob_array['stats']['allevents']['updated'] = $updated + $dataimportjob_array['stats']['allevents']['updated'];
    $dataimportjob_array['stats']['allevents']['deleted'] = $deleted + $dataimportjob_array['stats']['allevents']['deleted'];
    $dataimportjob_array['stats']['allevents']['void'] = $void + $dataimportjob_array['stats']['allevents']['void'];    
    $dataimportjob_array['stats']['allevents']['dropped'] = $dropped + $dataimportjob_array['stats']['allevents']['dropped'];    
    $dataimportjob_array['stats']['allevents']['duplicates'] = $duplicates + $dataimportjob_array['stats']['allevents']['duplicates'];    
    // update the current files statistics
    $dataimportjob_array['stats'][$csvfile_name]['lastrow'] = $while_start; 
    $dataimportjob_array['stats'][$csvfile_name]['progress'] = $while_start + $dataimportjob_array['stats'][$csvfile_name]['progress'];
    $dataimportjob_array['stats'][$csvfile_name]['inserted'] = $inserted + $dataimportjob_array['stats'][$csvfile_name]['inserted'];    
    $dataimportjob_array['stats'][$csvfile_name]['updated'] = $updated + $dataimportjob_array['stats'][$csvfile_name]['updated'];
    $dataimportjob_array['stats'][$csvfile_name]['deleted'] = $deleted + $dataimportjob_array['stats'][$csvfile_name]['deleted'];
    $dataimportjob_array['stats'][$csvfile_name]['void'] = $void + $dataimportjob_array['stats'][$csvfile_name]['void'];    
    $dataimportjob_array['stats'][$csvfile_name]['dropped'] = $dropped + $dataimportjob_array['stats'][$csvfile_name]['dropped'];    
    $dataimportjob_array['stats'][$csvfile_name]['duplicates'] = $duplicates + $dataimportjob_array['stats'][$csvfile_name]['duplicates'];
                       
    // save the $function_result_array in the job array
    csv2post_save_dataimportjob($dataimportjob_array,$jobcode);
        
    return $dataimportjob_array;    
}   

/**
* CSV file test - uses the configuration established through fget function and over-rides the configuration
* established using PEAR CSV. This is to test File_CSV::read works when giving correct config. 
*/
function csv2post_test_csvfile_countfields_fgetpriority( $csvfile_name, $separator, $quote ){
    
    global $wpdb;
    
    csv2post_pearcsv_include();  
    
    ################################################################################################
    #                                                                                              #
    #           FGET FIRST - USE COLUMN COUNT IN PEAR CSV TO DETERMINE IF THE RESULT IS EQUAL      #
    #                                                                                              #
    ################################################################################################
    
    // get the header row
    if (($handle = fopen(WTG_C2P_CONTENTFOLDER_DIR . '/' . $csvfile_name, "r")) !== FALSE) {

        // one row at a time we will count each possible Separator
        while (($header_row_string = fgets($handle, 4096)) !== false) {
            break;                        
        }  

        fclose($handle); 
    }    

    // if PEAR CSV somehow could not get header row we end the test here
    if(!$header_row_string){
        csv2post_notice('The plugin could not retrieve the header row from your CSV file while running a test. Please ensure you select the correct separator then try again and seek support if you continue to experience problems.','error','Large','Test 4: Count CSV File Column Headers Using fget','','echo');
        return;
    } 

    $header_array = explode($separator,$header_row_string);// explode the header row 
    $fgetcsv_header_count = count( $header_array );// count number of values in array 
    
    ###############################################################################################
    #                                                                                             #
    #        PEAR CSV NOW - DO NOT USE File_CSV::discoverFormat WE WILL SET $conf ourselves       #
    #                                                                                             #
    ###############################################################################################
    
    // use pear to read csv file
    $conf = File_CSV::discoverFormat( WTG_C2P_CONTENTFOLDER_DIR .'/'. $csvfile_name );
    $conf['fields'] = $fgetcsv_header_count;
    
    // apply auto determined or user defined separator and quote values
    if(isset($dataimportjob_array[$csvfile_name]['separator'])){
        $conf['sep'] = $separator;        
    }
    
    if(isset($dataimportjob_array[$csvfile_name]['quote'])){
        $conf['quote'] = $quote;        
    }    

    // loop through records   
    while ( ( $record = File_CSV::read( WTG_C2P_CONTENTFOLDER_DIR .'/'. $csvfile_name, $conf ) ) ) {        
        $PEARCSV_count = count($record);
    }

    if(!isset($PEARCSV_count)){
        csv2post_notice('Could not establish CSV file column header number using PEAR CSV, possibly due to the 
        wrong separator being used. Please ensure the correct separator is in use then run more tests or 
        seek support.','warning','Large','Test 4: Count CSV File Column Headers Using PEAR CSV','','echo');    
        return;
    }else{
        
        // compare both counts
        if($PEARCSV_count != $fgetcsv_header_count){
            csv2post_notice('Two methods of counting your CSV files returned different results. This is not a fault,
            it happens with certain formats of CSV file i.e. no quotes or tab instead of comma. This test is to 
            establish the best method to read your CSV file '.$csvfile_name.'.
            Below are the returned counts.<br /><br />
             <ul>
             <li><strong>PEAR CSV: '.$conf['fields'].'</strong></li>
             <li><strong>fgetcsv: '.$fgetcsv_header_count.'</strong></li>             
             </ul><br /><br />You must use the method that has counted the correct number of columns or alter your
             CSV file so that both methods works. PEAR CSV is the plugins default.','warning','Large','Test 4: Count CSV File Column Headers Using All Methods (fget is priority)','','echo');
            return;
        }     
        csv2post_notice('I counted '.$conf['fields'].' fields/columns in '.$csvfile_name.'. If this happens to be incorrect it must be investigated. This test
        establishes your files configuration using fget and over-rides the PEAR CSV method.','success','Large','Test 4: Count CSV File Column Headers Using All Methods (fget is priority)','','echo');
    }  
}   

/**
* CSV file test - this test will show a fail if the config from PEAR CSV File_CSV::discoverFormat
* does not match the fget result. This will usually indicate user needs to use fget method.
*/
function csv2post_test_csvfile_countfields_pearcsvpriority( $csvfile_name, $separator, $quote ){
    
    global $wpdb;
    
    csv2post_pearcsv_include();  
    
    ################################################################################################
    #                                                                                              #
    #           FGET FIRST - USE COLUMN COUNT IN PEAR CSV TO DETERMINE IF THE RESULT IS EQUAL      #
    #                                                                                              #
    ################################################################################################
    
    // get the header row
    if (($handle = fopen(WTG_C2P_CONTENTFOLDER_DIR . '/' . $csvfile_name, "r")) !== FALSE) {

        // one row at a time we will count each possible Separator
        while (($header_row_string = fgets($handle, 4096)) !== false) {
            break;                        
        }  

        fclose($handle); 
    }    

    // if PEAR CSV somehow could not get header row we end the test here
    if(!$header_row_string){
        csv2post_notice('The plugin could not retrieve the header row from your CSV file while running a test. Please ensure you select the correct separator then try again and seek support if you continue to experience problems.','error','Large','Test 5: Count CSV File Column Headers Using fget','','echo');
        return;
    } 

    $header_array = explode($separator,$header_row_string);// explode the header row 
    $fgetcsv_header_count = count( $header_array );// count number of values in array 
    
    ###############################################################################################
    #                                                                                             #
    #        PEAR CSV NOW - DO NOT USE File_CSV::discoverFormat WE WILL SET $conf ourselves       #
    #                                                                                             #
    ###############################################################################################
    
    // use pear to read csv file
    $conf = File_CSV::discoverFormat( WTG_C2P_CONTENTFOLDER_DIR .'/'. $csvfile_name );

    // apply auto determined or user defined separator and quote values
    if(isset($dataimportjob_array[$csvfile_name]['separator'])){
        $conf['sep'] = $separator;        
    }
    
    if(isset($dataimportjob_array[$csvfile_name]['quote'])){
        $conf['quote'] = $quote;        
    }    

    // loop through records   
    while ( ( $record = File_CSV::read( WTG_C2P_CONTENTFOLDER_DIR .'/'. $csvfile_name, $conf ) ) ) {        
        $PEARCSV_count = count($record);
    }

    if(!isset($PEARCSV_count) || $PEARCSV_count == 1){
        csv2post_notice('Could not establish CSV file column headers number using PEAR CSV. If you are sure that
        all quotes and separators are in the correct place. You should use the fget method for reading your CSV file
        rather then PEAR CSV.','warning','Large','Test 5: Count CSV File Column Headers Using PEAR CSV','','echo');    
        return;
    }else{
        
        // compare both counts
        if($PEARCSV_count != $fgetcsv_header_count){
            csv2post_notice('Two methods of counting your CSV files returned different results. This is not a fault,
            it happens with certain formats of CSV file i.e. no quotes or tab instead of comma. This test is to 
            establish the best method to read your CSV file '.$csvfile_name.'.
            Below are the returned counts.<br /><br />
             <ul>
             <li><strong>PEAR CSV: '.$conf['fields'].'</strong></li>
             <li><strong>fgetcsv: '.$fgetcsv_header_count.'</strong></li>             
             </ul><br /><br />You must use the method that has counted the correct number of columns or alter your
             CSV file so that both methods works. PEAR CSV is the plugins default.','warning','Large','Test 5: Count CSV File Column Headers Using All Methods','','echo');
            return;
        }     
        csv2post_notice('I counted '.$conf['fields'].' fields/columns in '.$csvfile_name.'. If this happens to be incorrect it must be investigated. This test
        establishes your files configuration using fget and also does it using PEAR CSV. Comparison of field/column count is made
        to help establish what method of reading CSV files is suitable for '.$csvfile_name.'.','success','Large','Test 5: Count CSV File Column Headers Using All Methods','','echo');
    }  
}

/**
* Updates empty premade record in data job table using CSV file row.
* Reports errors too server log.
* 
* @returns boolean, true if an update was done with success else returns false
* 
* @param mixed $record
* @param mixed $csvfile_name
* @param mixed $fields
* @param mixed $jobcode
* @param mixed $record_id
* @param mixed $headers_array
*/
function csv2post_sql_update_record_dataimportjob( $record, $csvfile_name, $fields, $jobcode,$record_id, $headers_array,$filegrouping ){
    // using new record id - update the record
    $updaterecord_result = csv2post_sql_update_record( $record, $csvfile_name, $fields, $jobcode,$record_id, $headers_array, $filegrouping );
    // increase $inserted counter if the update was a success, the full process counts as a new inserted record            
    if($updaterecord_result === false){
        return false;
        csv2post_error_log('CSV 2 POST: csv2post_sql_update_record() returned FALSE for JOB:'.$jobcode.' FILE:'.$csvfile_name.'. Please investigate.');                
    }elseif($updaterecord_result === 1){ 
        return true;   
    }elseif($updaterecord_result === 0){
        csv2post_error_log('CSV 2 POST: csv2post_sql_update_record() returned 0 for JOB:'.$jobcode.' FILE:'.$csvfile_name.'. Please investigate.');
        return false;
    }  
}   
                
/**
* Establishes the giving files ID within the giving job
* 
* @param mixed $_POST
* @returns integer $fileid, if a match is found, the ID applies to the giving job and file only. It is appened too table column names
* @returns boolean false if csv file loop does not match a file up too the giving $csvfile_name
*/
function csv2post_get_csvfile_id($csvfile_name,$jobcode){
    $dataimportjob_array = csv2post_get_dataimportjob($jobcode);
    // loop through the jobs files until we reach the giving file name then return its ID
    foreach($dataimportjob_array['files'] as $fileid => $filename ){
        if($filename == $csvfile_name){
            return $fileid;
        }
    }
    return false;
}

/**
* Loads scripts
* 
* @param string $side, admin, public
*/
function csv2post_script($side = 'admin'){
    global $csv2post_mpt_arr;
    include_once(WTG_C2P_DIR.'templatesystem/script/csv2post_script_parent.php');
}

/**
* Loads CSS
* 
* @param string $side, admin, public
*/
function csv2post_css($side = 'admin'){
    include_once(WTG_C2P_DIR.'templatesystem/css/csv2post_css_parent.php');
}

/**
 * Standard HTTP forwarding
 * @param array $attributes_array
 * @property string status (standard http code i.e. 301 Moved Permanently)
 * @property url location (must begin with http)#
 * 
 * @todo add log recording and possibly statistical storing
 * @todo validate passed url before forwarding, provide option to not apply validation also
 * @todo ensure url validation includes forward slash at end
 * @todo validate status to expected values
 */
function csv2post_header_forward($atts){
    extract( shortcode_atts( array(
            'status' => '301 Moved Permanently',
            'location' => 'http://www.webtechglobal.co.uk',
    ), $atts ) );

    // clear cache then return result
    $wpdb->flush();
    
    // TODO: LOWPRIORITY, confirm this is the best way to do this in Wordpress (is there possibly a Wordpress method)
    header("HTTP/1.1 ".$status."");
    header("Status: ".$status."");
    header("Location: ".$location."");
    header("Connection: close");
    exit(0); // Optional, prevents any accidental output
}

/**
 * Establishes if an arrays element count is odd or even (currently divided by 2)
 * For using when balancing tables
 * @param array $array
 * 
 * @todo divide by any giving number, validate the number, the function that builds the table will need to handle that
 */
function csv2post_oddeven_arrayelements($array){
    $oddoreven_array = array();

    // store total number of items in totalelements key
    $oddoreven_array['totalelements'] = count($array);

    // store the calculation result from division before rounding up or down, usually up
    $oddoreven_array['divisionbeforerounded'] = $oddoreven_array['totalelements'] / 2;

    // round divisionbeforerounded using ceil and store the answer in columnlimitceil, this is the first columns maximum number of items
    $oddoreven_array['columnlimitceil'] = ceil($oddoreven_array['divisionbeforerounded']);

    // compare our maths answer with the ceil value - if they are not equal then the total is odd
    // if the total is oddd we then know the last column must have one less item, a blank row in the table
    if($oddoreven_array['divisionbeforerounded'] == $oddoreven_array['columnlimitceil']){
        $oddoreven_array['balance'] = 'even';
    }else{
        $oddoreven_array['balance'] = 'odd';
    }

    return $oddoreven_array;
}

/**
 * Starts A Timer - Used To Time Scripts
 * @return the current time in micro
 * 
 * @todo microtime function has caused problems with some users, research alternatives if any
 * @todo put error reporting in this to handle problems better
 */
function csv2post_microtimer_start(){
    list($utime, $time) = explode(" ", microtime());
    return ((float)$utime + (float)$time);
}

/**
 * Validate a url (http https ftp)
 * @return true if valid false if not a valid url
 * @param url $url
 */
function csv2post_validate_url($url){
	if (!preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i',$url)){
            return false;
	} else {
            return true;
	}
}

/**
 * Checks if a database table exist
 * @param string $table_name (possible database table name)
 *
 * @todo SHOW TABLES can cause problems, invistagate another approach such as querying the table, ignoring the error if it does not exist
 */
function csv2post_database_table_exist( $table_name ){
	global $wpdb;
	
	// check if table name exists in wordpress database
	if( $wpdb->get_var("SHOW TABLES LIKE `".$table_name."`") != $table_name) {
            return false;
	}else{
            return true;
	}
}

/**
 * Generates a username using a single value by incrementing an appended number until a none used value is found
 * @param string $username_base
 * @return string username, should only fail if the value passed to the function causes so
 * 
 * @todo log entry functions need to be added, store the string, resulting username
 */
function csv2post_create_username($username_base){
    $attempt = 0;
    $limit = 500;// maximum trys - would we ever get so many of the same username with appended number incremented?
    $exists = true;// we need to change this to false before we can return a value

    // clean the string
    $username_base = preg_replace('/([^@]*).*/', '$1', $username_base );

    // ensure giving string does not already exist as a username else we can just use it
    $exists = username_exists( $username_base );
    if( $exists == false ){
        return $username_base;
    }else{
        // if $suitable is true then the username already exists, increment it until we find a suitable one
        while( $exists != false ){
            ++$attempt;
            $username = $username_base.$attempt;

            // username_exists returns id of existing user so we want a false return before continuing
            $exists = username_exists( $username );

            // break look when hit limit or found suitable username
            if($attempt > $limit || $exists == false ){
                break;
            }
        }

        // we should have our login/username by now
        if ( $exists == false ) {
            return $username;
        }
    }
}


/**
 * Includes PEAR CSV
 */
function csv2post_pearcsv_include(){
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'){
        ini_set('include_path',rtrim(ini_get('include_path'),';').';'.dirname(__FILE__).'/pear/');
    }else{
        ini_set('include_path',rtrim(ini_get('include_path'),':').':'.dirname(__FILE__).'/pear/');
    }
    require_once 'File/CSV.php';
}

/**
 * Checks if the giving history file (by label not filename) is active
 * @global array $csv2post_adm_set
 * @param string $historyfile (not file name: general,sql,admin,user,error)
 * @return true or false
 */
function csv2post_ishistory_active($historyfile = false){
    if(!$historyfile){
        return false;
    }else{
        global $csv2post_adm_set;// set in csv2post_variables.php       
        if($csv2post_adm_set['log_general_active'] == false
            && $csv2post_adm_set['log_sql_active'] == false
                && $csv2post_adm_set['log_admin_active'] == false
                    && $csv2post_adm_set['log_user_active'] == false
                        && $csv2post_adm_set['log_error_active'] == false){
            return false;
        }else{
            if($historyfile == 'any'){
                return true;
            }else{
                return $csv2post_adm_set['log_'.$historyfile.'_active'];
            }
        }
    }
    return false;
}

/**
 * Returns the current url as viewed with all variables etc
 * @return string current url with all GET variables
 */
function csv2post_currenturl() {
    $pageURL = 'http';
    if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
    
        $pageURL .= "://";
        
    if (isset($_SERVER["SERVER_PORT"]) && $_SERVER["SERVER_PORT"] != "80" && isset($_SERVER["SERVER_NAME"]) && isset($_SERVER["REQUEST_URI"])) {

        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];

    }elseif(isset($_SERVER["SERVER_NAME"]) && isset($_SERVER["REQUEST_URI"])){
        
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        
    }else{
        
        return 'Error Unexpected State In Current URL Function';
        
    }
    return $pageURL;
}

/**
 * Checks if history file exists
 * @param string $historytype (general,sql,admin,user,error)
 * @return boolean
 * 
 * @todo adapt to allow log file location to be changed and this function too use the new location not the default   
 */
function csv2post_logfile_exists($logtype){
    return file_exists(csv2post_logfilepath($logtype));
}

/**
* Deletes log file if over specific size 
* Must ensure file exists before calling this function
* 
* @param string $logtype (general,error,sql,admin,user)
* @param integer $sizelimit, state the maximum bytes (307200 = 300kb which is a reasonable size and is default)
*/
function csv2post_logfile_autodelete($logtype,$sizelimit = 307200){
    // check file size - delete if over 300kb as stated on Log page
    if( filesize( csv2post_logfilepath($logtype) ) > $sizelimit ){
        return unlink( csv2post_logfilepath($logtype) );
    }    
}             
                    
/**
* Returns the full path to giving log file
* 
* @param string $logtype (admin,user,error,sql,general = default)
*/
function csv2post_logfilepath($logtype = 'general'){
    return WTG_C2P_CONTENTFOLDER_DIR.'/'.WTG_C2P_ABB.'log_'.$logtype.'.csv'; 
}                        

/**
* Checks if a domain exists by ensuring a site is online
* 
* @return boolean, false if domain does not exist or site is not online, true otherwise
* 
* @param string $domain
*/
function csv2post_domain_online($domain){
    // @todo look into these 2 lines, benefits they have when used in Wordpress if any
   //ini_set("default_socket_timeout","05");
   //set_time_limit(5);
   $f = @fopen($domain,"r");
   if($f == false){
       return false;
   }else{
       $r=fread($f,1000);
       fclose($f);
       if(strlen($r)>1) {
           return true;
       }
       else {
           return false;
       }      
   }  
}

/**
* Returns a value for Tab Number, if $_GET[WTG_##_ABB . 'tabnumber'] not set returns 0 
*/
function csv2post_get_tabnumber(){                      
    if(!isset($_GET['csv2post_tabnumber'])){
        return 0;
    }else{
        return $_GET['csv2post_tabnumber'];                   
    }                                                      
}     

/**
 * Intercepts and processes form subsmission, requiring user to be logged in, adding further security 
 * to the blog within this plugin.
 */
function csv2post_form_submission_processing(){  
    if(is_user_logged_in()){

        if(isset($_POST['csv2post_post_processing_required'])){
            
            // if csv2post_post_processing_required true 
            if($_POST['csv2post_post_processing_required']){
                
                // has $_POST dump been request?
                global $csv2post_debug_mode;// set in main file for development use only
                if($csv2post_debug_mode){
                    echo '<h1>$_POST</h1>';
                    echo '<pre>';
                    var_dump($_POST);
                    echo '</pre>';            
                    echo '<h1>$_GET</h1>';
                    echo '<pre>';
                    var_dump($_GET);
                    echo '</pre>';                  
                }
                
                // include file that handles $_POST submission
                require_once(WTG_C2P_DIR.'templatesystem/include/csv2post_form_processing.php');                  
            }
        }

    } 
}

/**
* Updates the current project , calls project array globally 
*/
function csv2post_update_currentproject_array(){
    
}

/**
* Called when plugin is being activated in Wordpress.
* I am avoiding anything actually being installed during this process. * 
*/
function csv2post_register_activation_hook(){
    global $csv2post_isbeingactivated;
    $csv2post_isbeingactivated = true;// used to avoid loading files not required during activation
}

/**
* Wrapper, uses csv2post_link_toadmin to create local admin url
* 
* @param mixed $page
* @param mixed $values 
*/
function csv2post_create_adminurl($page,$values = ''){
    return csv2post_link_toadmin($page,$values);    
}

/**
* Returns the admin theme 
*/
function csv2post_get_theme(){
    return get_option(WTG_C2P_ABB.'theme');
}

/**
* Update admin theme
* 
* @param mixed $theme_name
*/
function csv2post_update_theme($theme_name){
    update_option(WTG_C2P_ABB.'theme',$theme_name);  
}

 /**
 * Delets plugin main navigation 
 */
function csv2post_delete_tabmenu(){
    return delete_option(WTG_C2P_ABB . 'tabmenu');
}
                  
/**
 * Template used to create new functions, uses utility functions and common globals etc
 * Copy and paste this function
 */
function csv2post_templatefunction(){

    // standard option update with standard result output - only if your updating option else remove
    csv2post_option_array_update( $option_key, $option_value, $line = __LINE__, $file = __FILE__, $function = __FUNCTION__ );

    // general result
    if($function_result_success){
        return true;
    }else{
        return false;
    }
}

/**
 * Creates a new notification with a long list of style options available.
 * Can return the message for echo or add it to an array, which can also be stored for persistent messages.
 * Requires visitor to be logged in and on an admin page, dont need to do prevalidation before calling function
 *     
 * Dont include a title attribute if you want to use defaults and stick to a standard format
 *  
 * @param string $message, main message
 * @param mixed $type, determines colour styling (question,info,success,warning,error,processing,stop,step)
 * @param mixed $size, determines box size (Tiny,Small,Large,Extra)
 * @param mixed $title, a simple header
 * @param mixed $helpurl, when required can offer link too help content (will be added closer to 2013)
 * @param mixed $output_type, how to handle message (echo will add notice too $csv2post_notice_array and passing return will return the entire html)
 * @param mixed $persistent, boolean (true will mean the message stays until user deletes it manually)
 * 
 * @todo MEDIUMPRIORITY, when a notification is to be returned AND is persistent, it needs to be persistent where ever it is displayed, need to check if user has already closed notification by storing its ID in notification array
 * @todo LOWPRIORITY, provide permanent closure button, will this be done with a dialogue ID to prevent it opening again 
 * @todo LOWPRIORITY, add url to all notifications, this could take days!
 * @todo LOWPRIORITY, add a paragraphed section of the message for a second $message variable for extra information
 */
function csv2post_notice($message,$type = 'success',$size = 'Extra',$title = false, $helpurl = 'www.csv2post.com/support', $output_type = 'echo',$persistent = false,$clickable = false){
    if(is_admin()){
        
        // change unexpected values into expected values (for flexability and to help avoid fault)
        if($type == 'accepted'){$type == 'success';}
        if($type == 'fault'){$type == 'error';}
        if($type == 'next'){$type == 'step';}
        
        // prevent div being clickable if help url giving (we need to more than one link in the message)
        if($helpurl != false && $helpurl != '' && $helpurl != 'www.csv2post.com/support'){$clickable = false;}
            
        if($output_type == 'return'){
            return csv2post_notice_display($type,$helpurl,$size,$title,$message,$clickable,$persistent);
        }else{
            global $csv2post_notice_array;

            // establish next array key
            $next_key = 0;
            if(isset($csv2post_notice_array['notifications'])){
                $next_key = csv2post_get_array_nextkey($csv2post_notice_array['notifications']);
            }
            
            // add new message to the notifications array
            $csv2post_notice_array['notifications'][$next_key]['message'] = $message;
            $csv2post_notice_array['notifications'][$next_key]['type'] = $type;
            $csv2post_notice_array['notifications'][$next_key]['size'] = $size;
            $csv2post_notice_array['notifications'][$next_key]['title'] = $title;
            $csv2post_notice_array['notifications'][$next_key]['helpurl'] = $helpurl; 
            $csv2post_notice_array['notifications'][$next_key]['clickable'] = $clickable;
            $csv2post_notice_array['notifications'][$next_key]['persistent'] = $persistent;
            
            // if notification is persistent requiring user to delete it (not adding the value otherwise makes the array lighter)
            if($persistent){
                csv2post_update_option_schedule_array($csv2post_notice_array);    
            }          
        }
    }
}

/**
* Returns notification HTML.
* This function has the html and css to make all notifications standard.

* @param mixed $type
* @param string $helpurl
* @param string $size
* @param string $title
* @param string $message
* @param bool $clickable
*/
function csv2post_notice_display($type,$helpurl,$size,$title,$message,$clickable,$persistent = false){
    // begin building output
    $output = '';

    // if clickable (only allowed when no other links being used) - $helpurl will actually be a local url too another plugin or Wordpress page
    if($clickable && !$persistent){
        $output .= '<div class="stepLargeTest"><a href="'.$helpurl.'">';
    }

    // start div
    $output .= '<div class="'.$type.$size.'">';
        
        // if is not clickable (entire div) and help url is not null
        ### TODO:LOWPRIORITY, add the $type to the class ($type.$size.'HelpLink) and create styles for each type plus images to suit the styles. This could be a job to give to someone else.
        if($helpurl != '' && $helpurl != false){
            $output .= '<a href="'.$helpurl.'" target="_blank">
            <img class="'.$size.'HelpLink" src="'.WTG_C2P_IMAGEFOLDER_URL.'link-icon.png" />
            </a>';
        }   
       
        // set h4 when required
        if($size == 'Large' || $size == 'Extra'){$output .= '<h4>'.$title.'</h4>';}
        elseif($size == 'Small'){$output .= $title;}

    // if persistent message, add link for deleting the message
    ### TODO:MEDIUMPRIORITY, complete persistent messages
        
    $output .= $message.'</div>';

    if($clickable && !$persistent){$output .= '</a></div>';}

    return $output;    
}

/**
* Outputs the contents of $csv2post_notice_array, used in csv2post_header_page.
* Will hold new and none persistent notifications. May also hold persistent. 
*/
function csv2post_notice_output(){
    global $csv2post_notice_array;
    if(isset($csv2post_notice_array['notifications'])){
        foreach($csv2post_notice_array['notifications'] as $key => $notice){
            echo csv2post_notice_display($notice['type'],$notice['helpurl'],$notice['size'],$notice['title'],$notice['message'],$notice['clickable'],$notice['persistent']);                                               
        }
    }  
}

/**
* Returns the html for a notice box that can be clicked on and styled as the "Next Step".
* This is easier to use than wtgcsv_notice() for when the next step box is required.
* 
* 1. Do not add links inside the message content as the entire div is linked
* 2. This is only be used to suggest the next step users should take
* 3. This function always returns, it cannot be used to update the notifications array
* 
* @param mixed $type
* @param mixed $helpurl
* @param mixed $size
* @param mixed $title
* @param mixed $message
* @todo MEDIUMPRIORITY, do a check to determine if user is already on the clickable url, if they are then we suggest it on the message
*/
function csv2post_notice_display_step($helpurl,$title,$message){
    $output = '<div class="stepLargeTest"><a href="'.$helpurl.'">    
    <div class="stepLarge"><h4>'.$title.'</h4>'. $message .'</div></a></div>';
    return $output;    
}

/**
 * Adds a jquery effect submit button, for using in form
 * 
 * @param string $panel_name (original use for in panels,panel name acts as an identifier)
 * @uses csvip_helpbutton function uses jquery script required by this button to have any jquery effect
 */
function csv2post_formsubmitbutton_jquery($form_name){?>
    <div class="jquerybutton"><input type="submit" name="<?php echo WTG_C2P_ABB;?><?php echo $form_name;?>_submit" value="Submit"/></div><?php
}

/**
 * Displays a simple and standard wordpress formatted message, this is not the WTG Notice Boxes function
 * Should only be used in processing functions, not header functions i.e. hooks
 */
function csv2post_mes($title,$content,$type,$button_array = false){
    // only output anything if user logged and is on admin page
    if(is_user_logged_in() && is_admin()){
        // does user want buttons for actions in footer of the notice? this will add a table of buttons to end of notice
        if($button_array){
                $content .= csv2post_form_buttons_table_return($button_array);}

        // build final notice (only if admin logged in)
        if($type==0){$id='message';$class='updated';}elseif($type==1){$id='error';$class='$error';}
        echo '<div id="'.$id.'" class="'.$class.'"><strong>'.$title.'</strong><p>'. $content .'</p></div>';
    }
}

/**
 * Updates option array, records history to aid debugging
 * @return true on success or false on failure
 * @param string $option_key (wordpress options table key value)
 * @param mixed $option_value (can be string or array)
 * @param integer $line (line number passed by __LINE__)
 * @param string $file (file name passed by __FILE__)
 * @param string $function (function name passed by __FUNCTION__)
 * 
 * @todo check if including the php constants in the attributes applyes where this function is or where it is used
 * @todo what is the best way to determine if update actually failed or there was no difference in array ?
 * @todo complete logging (no output that will be handled where function called)
 */
function csv2post_option_array_update( $option_key, $option_value, $line = __LINE__, $file = __FILE__, $function = __FUNCTION__ ){
    // store an array of values indicating the update time and where it occured
    $change = array();
    $change['date'] = date("Y-m-d H:i:s");
    $change['time'] = time();
    $change['line'] = $line;
    $change['file'] = $file;

    $option_value['arrayhistory'] = $change;

    $option_update_result = update_option($option_key,$option_value);

    if($option_update_result){
            // log result
    }else{
            // log result
    }

    return $change;
}

/**
 * Exit on error or use misconfiguration but offer help information, links etc
 * The information will be based on keywords related to the area of the plugin that the user is experiencing problems with
 * @param array $keywords (an array of keywords that will be used to determine extra help content)
 * @param url $url (link from a big button to the related page for the feature the exit is used in connection with)
 * 
 * @todo display notice box that will hold the help button
 * @todo design or have designed a suitable help button
 * @todo display further possible help options crawled on the plugins site
 * @todo display Google AdWords search lastly
 */
function csv2post_exit($url,$keywords){
    // call a function here that displays a notice box of helpful information including links and a humerous image
    // in relation to any sort of problem

    // we'll use the keywords to retrieve the information using RSS or API, not 100% sure at this time
    exit;
}

/**
 * Echos the html beginning of a form and beginning of widefat post fixed table
 * 
 * @param string $name (a unique value to identify the form)
 * @param string $method (optional, default is post, post or get)
 * @param string $action (optional, default is null for self submission - can give url)
 * @param string $enctype (pass enctype="multipart/form-data" to create a file upload form)
 */
function csv2post_formstart_standard($name,$id = 'none', $method = 'post',$class,$action = '',$enctype = ''){
    if($class){
        $class = 'class="'.$class.'"';
    }else{
        $class = '';         
    }
    echo '<form '.$class.' '.$enctype.' id="'.$id.'" method="'.$method.'" name="'.$name.'" action="'.$action.'">
    <input type="hidden" id="'.WTG_C2P_ABB.'post_processing_required" name="'.WTG_C2P_ABB.'post_processing_required" value="true">';
}

/**
 * Adds <button> with jquerybutton class and </form>, for using after a function that outputs a form
 * Add all parameteres or add none for defaults
 * @param string $buttontitle
 * @param string $buttonid
 */
function csv2post_formend_standard($buttontitle = 'Submit',$buttonid = 'notrequired'){
    if($buttonid == 'notrequired'){
        $buttonid = 'csv2post_notrequired';
    }else{
        $buttonid = $buttonid.'_formbutton';
    }?>

    <br />
    
    <div class="jquerybutton">
        <button id="<?php echo $buttonid;?>"><?php echo $buttontitle;?></button>
    </div>
    
    </form><?php
}


/**
 * Used to build a query history file,intention is to display the history
 * Type Values: general,sql,admin,user,error
 * General History File Filters: install

 * @var WTG_C2P_RECORD_ALL_SQL_QUERIES boolean switch to disable this logging
 * @global $wpdb
 * @uses extract, shortcode_atts
 *
 * @param string Project name (usually csv filename)
 * @param integer line __LINE__
 * @param string file __FILE__
 * @param string function __FUNCTION__
 * @param string type indicates what log file to write to (general,sql,admin,user,error)
 * @param mixed dump this is the main variable that holds sql query, comments, results etc
 * @param string comment comment by developer that may help users or help other developers
 * @param string sql_result mysql result, use csv2post_log_sql_default for ease
 * @param string sql_query mysql query,  use csv2post_log_sql_default for ease
 *
 * @todo create other constants like the one setup for sql log entries
 * @todo create option to add entries to server error log file
 */
function csv2post_log($atts){
    
    /* COPY AND PASTE ARRAY
    $atts = array();
    $atts['projectname'] = 'NA';// Project name (usually csv file name)
    $atts['projectid'] = 'Unknown';    
    $atts['jobcode'] = 'Unknown';    
    $atts['csvfile'] = 'Unknown';                   
    $atts['date'] = csv2post_date();// csv2post_date()   
    $atts['line'] = __LINE__;
    $atts['file'] = __FILE__;
    $atts['function'] = __FUNCTION__;
    $atts['logtype'] = 'general';// general, sql, admin, user, error (can be others but all fit into these categories)
    $atts['dump'] = 'None';// anything, variable, text, url, html, php
    $atts['comment'] = 'None';// comment to help users or developers (recommended 60-80 characters long)
    $atts['sql_result'] = 'NA';// wordpress sql result value
    $atts['sql_query'] = 'NA';// wordpress sql query value
    $atts['style'] = 'success';// Notice box style (info,success,warning,error,question,processing,stop)
    $atts['category'] = 'Unknown';// used to filter entries, a lowercase keyword // TODO: make this comma seperated values but also make the log viewer search through them
    csv2post_log($atts);*/    
    
    extract( shortcode_atts( array(
        'projectname' => 'NA',// Project name or ID (usually csv file name)               
        'date' => csv2post_date(),// csv2post_date()   
        'line' => 'Unknown',// __LINE__
        'file' => 'Unknown',// __FILE__
        'function' => 'Unknown',// __FUNCTION__
        'logtype' => 'general',// general, sql, admin, user, error (can be others but all fit into these categories)
        'dump' => 'None',// anything, variable, text, url, html, php
        'comment' => 'None',// comment to help users or developers (recommended 60-80 characters long)
        'sql_result' => 'NA',// wordpress sql result value
        'sql_query' => 'NA',// wordpress sql query value
        'style' => 'success',// Notice box style (info,success,warning,error,question,processing,stop)
        'category' => 'Unknown',// used to filter entries, a lowercase keyword // TODO: make this comma seperated values but also make the log viewer search through them
    ), $atts ) );
    
    /**
    * USED CATEGORIES
    * 1. Data Import Job
    */    

    // ensure the log file giving is active
    $historyfileactive = csv2post_ishistory_active($logtype);

    if($historyfileactive){
        // boolean switch prevents log writing until it is confirmed settings require it
        $write_to_log = false;
        // is log request sql and does user or plugin author want sql logging
        if($logtype == 'general' || $logtype == 'install' || $logtype == 'installation' || $logtype == 'uninstall' || $logtype == 'reinstal'){
            
            $write_to_log = true;
            $logfile_path = csv2post_logfilepath('general');
            
        }elseif($logtype == 'sql' || $logtype == 'database' || $logtype == 'mysql'){ 
        
            if(defined(WTG_C2P_RECORD_ALL_SQL_QUERIES) && WTG_C2P_RECORD_ALL_SQL_QUERIES == true){
                $write_to_log = true;
                $logfile_path = csv2post_logfilepath('sql');
            }
            
        }elseif($logtype == 'admin' || $logtype == 'administrator' || $logtype == 'owner' || $logtype == 'adm'){
            
            $write_to_log = true;
            $logfile_path = csv2post_logfilepath('admin');
                       
        }elseif($logtype == 'user' || $logtype == 'users' || $logtype == 'public' || $logtype == 'visitors'){
            
            $write_to_log = true;
            $logfile_path = csv2post_logfilepath('user');
            
        }elseif($logtype == 'error' || $logtype == 'err' || $logtype == 'fault' || $logtype == 'bug' || $logtype == 'problem'){
            
            $write_to_log = true;
            $logfile_path = csv2post_logfilepath('error');
                      
        }
              
        // if required continue to make log entry
        if($write_to_log){
            global $wpdb;
                      
            // check if file exists, else create it with a header
            if(!csv2post_logfile_exists($logtype)){
                csv2post_create_logfile($logtype);
            }else{
                csv2post_logfile_autodelete($logtype,307200);// TODO: LOW PRIORITY,create setting for auto delete size limit
            }

            // make final write to log, this will also create the log file if it does not exist            
            $write = array( '"'.$projectname.'"','"'.csv2post_date().'"','"'.$line.'"','"'.$file.'"','"'.$function.'"','"'.$dump.'"','"'.$comment.'"','"'.$sql_result.'"','"'.$sql_query.'"','"'.$style.'"','"'.$category.'"' );
            @$fp = fopen( $logfile_path, 'a');
            @fputcsv($fp, $write);
            @fclose($fp);
            
        }// if write to log or not
    }// is history file active
}

/**
* Returns the plugins standard date with common format used in code, not seen by user in most cases
* 
* @param integer $timeaddition, number of seconds to add to the current time to create a future date and time
* @todo adapt this to return various date formats to suit interface
*/
function csv2post_date($timeaddition = 0){
    return date('Y-m-d H:i:s',time()+$timeaddition);    
} 

/**
* Determines if giving varaible is WP_Error or not
* Logs error if boolean true result determined
* 
* @uses class WP_Error($code, $message, $data)
* @uses is_wp_error(),$wpval->get_error_data(),$wpval->get_error_message() 
* @param mixed $v is the value being checked as possible Wordpress error
* @param boolean $returnv, default is false, true causes $v to be returned instead of boolean when value is NOT an error
* @returns boolean true if giving value is WP_Error and false if not
*/
function csv2post_is_WP_Error($wpval,$returnv = false){
    if(is_wp_error($wpval)){

        $atts = array();
        $atts['projectname'] = 'NA';// TODO:LOWPRIORITY, get current project name from global
        //$atts['date'] = csv2post_date();// csv2post_date()   
        $atts['logtype'] = 'error';
        $atts['dump'] = 'Data Value: ' . $wpval->get_error_data();
        $atts['comment'] = 'Created by csv2post_is_WP_Error, Wordpress message is: ' . $wpval->get_error_message();
        $atts['style'] = 'error';

        csv2post_log($atts);  
        
        $result = true;   
    }else{
        $result = false;
    }

    if($result == false && $returnv == true){
        // not an error and value to be returned
        return $wpval;
    } elseif($result == true){
        // is an error or request needs boolean returned
        return true;
    }elseif($result == false && $returnv == false){
        // not an error but request wants boolean returned, false to indicate not WP_Error
        return false;
    }
}

/**
* Uses error_log to record an error too servers main error log.
*  
* @param string $m, the message to be recorded
*/
function csv2post_error_log($m){ 
   error_log($m);
}

function csv2post_get_default_contenttemplate_name(){
    global $csv2post_currentproject_code;
    $default_template_id = csv2post_get_default_contenttemplate_id( $csv2post_currentproject_code );

    if(!$default_template_id || $default_template_id == '0'){
        return 'No Default Content Template';
    }else{
        // get wtgcsvtemplate post title
        $template_post = get_post($default_template_id); 

        return $template_post->post_title;        
    }
}

function csv2post_get_default_excerpttemplate_name(){
    global $csv2post_currentproject_code;
    $default_template_id = csv2post_get_default_excerpttemplate_id( $csv2post_currentproject_code );

    if(!$default_template_id || $default_template_id == '0'){
        return 'No Default Excerpt Template';
    }else{
        // get wtgcsvtemplate post title
        $template_post = get_post($default_template_id); 
        return $template_post->post_title;        
    }
}

function csv2post_get_default_titletemplate_name(){
    global $csv2post_currentproject_code;
    $default_template_id = csv2post_get_default_titletemplate_id( $csv2post_currentproject_code );

    if(!$default_template_id || $default_template_id == '0'){
        return 'No Default Title Template';
    }else{
        // get wtgcsvtemplate post title
        $template_post = get_post($default_template_id); 
        return $template_post->post_title;        
    }
}

/**
* Gets the content of giving title template ID (also a post id)
* 
* @returns string indicating fault and includes giving ID
* @param mixed $project_array
*/
function csv2post_get_titletemplate_design($title_template_id){
    $template_post = get_post($title_template_id);
    if(!$template_post){
        return 'Fault:title template post not found with ID ' . $title_template_id;
    } 
    return $template_post->post_content;    
}

/**
* Gets the content of giving content template id (also a post id)
* 
* @param mixed $title_template_id
*/
function csv2post_get_template_design($content_template_id){
    $template_post = get_post($content_template_id);
    if(!$template_post){
        return 'Fault:template post not found with ID ' . $content_template_id .', you have possibly deleted it by mistake?';
    } 
    return $template_post->post_content;    
}
         
/**
* Gets the default content template id (post_id for wtgcsvcontent post type) for the giving project
* 
* @param mixed $project_code
* @returns false if no current project or current project has no default template yet
*/
function csv2post_get_default_contenttemplate_id( $project_code ){
    if(!isset($project_code)){
        return false;
    }else{
        $project_array = csv2post_get_project_array($project_code);
        if(isset($project_array['default_contenttemplate_id'])){
            return $project_array['default_contenttemplate_id'];            
        }
    }  
    return false;  
}

function csv2post_get_default_excerpttemplate_id( $project_code ){
    if(!isset($project_code)){
        return false;
    }else{
        $project_array = csv2post_get_project_array($project_code);
        if(isset($project_array['default_excerpttemplate_id'])){
            return $project_array['default_excerpttemplate_id'];            
        }
    }  
    return false;  
}

/**
* Gets the default title template id (post_id for wtgcsvtitle post type) for the giving project
* 
* @param mixed $csv2post_currentproject_code
* @returns false if no current project or current project has no default title template yet
*/
function csv2post_get_default_titletemplate_id( $csv2post_currentproject_code ){
    if(!isset($csv2post_currentproject_code)){
        return false;
    }else{
        $project_array = csv2post_get_project_array($csv2post_currentproject_code);

        if(isset($project_array['default_titletemplate_id'])){
            return $project_array['default_titletemplate_id'];            
        }
    }  
    return false;  
}

/**
* Returns the Wordpress option record value for giving project code
* 
* @uses unserialize before return 
* @param mixed $project_code
* @return mixed, false on fail or no option record exists
* 
* @link http://www.csv2post.com/hacking/project-array-csv2post_project_array
*/
function csv2post_get_project_array($project_code){
    $getproject_array = get_option( 'csv2post_' . $project_code );
    $getproject_array_unserialized = maybe_unserialize($getproject_array);
    return $getproject_array_unserialized;
}

/**
* Updates (also adds) new option record for post creation project
* 
* @param string $project_code
* @param array $project_array
*/
function csv2post_update_option_postcreationproject($project_code,$project_array){
    $project_array_serialized = maybe_serialize($project_array);
    $update_result = update_option('csv2post_' . $project_code,$project_array_serialized);
    return $update_result;    
}

/**
* Returns specified part of array resulting from explode on string.
* Can only be used properly when the number of values in resulting array is known
* and when the returned parts type is known.
* 
* @param mixed $delimeter
* @param mixed $returnpart
* @param mixed $string
*/
function csv2post_explode_tablecolumn_returnnode($delimeter,$returnpart,$string){
    $explode_array = explode($delimeter,$string);
    return $explode_array[$returnpart];    
}

/**
* add new post creation project too data import job array
* @param mixed $project_code
* @param mixed $project_name
* @return bool
*/
function csv2post_update_option_postcreationproject_list_newproject($project_code,$project_name){
    global $csv2post_projectslist_array;
    if(!is_array($csv2post_projectslist_array)){$csv2post_projectslist_array = array();}
    $csv2post_projectslist_array[$project_code]['name'] = $project_name; 
    return update_option('csv2post_projectslist',serialize($csv2post_projectslist_array));     
}

/**
* Returns array of all existing projects, used to create a list of projects
* @returns false if no option for csv2post_projectslist exists else returns unserialized array 
*/
function csv2post_get_projectslist(){
    $get_projectlist_result = get_option('csv2post_projectslist');
    if(!$get_projectlist_result){
        return false;
    }
    return unserialize(get_option('csv2post_projectslist'));
}

/**
* Returns last key from giving array. Sorts the array by key also (only works if not mixed numeric alpha).
* Use before adding new entry to array. This approach allows the key to be displayed to user for reference or returned for other use.
* 
* @uses ksort, sorts array key order should the keys be random order
* @uses end, moves internal pointer too end of array
* @uses key, returns the key for giving array element
* @returns mixed, key value could be string or numeric depending on giving array
*/
function csv2post_get_array_lastkey($array){
    ksort($array);
    end($array);
    return key($array);
}

/**
* Gets the schedule array from wordpress option table.
* Array [times] holds permitted days and hours.
* Array [limits] holds the maximum post creation numbers 
*/
function csv2post_get_option_schedule_array(){
    $getschedule_array = get_option( 'csv2post_schedule');
    return maybe_unserialize($getschedule_array);    
}

/**
* Updates the schedule array from wordpress option table.
* Array [times] holds permitted days and hours.
* Array [limits] holds the maximum post creation numbers 
*/
function csv2post_update_option_schedule_array($schedule_array){
    $schedule_array_serialized = maybe_serialize($schedule_array);
    return update_option('csv2post_schedule',$schedule_array_serialized);    
}

/**
* Updates notifications array in Wordpress options table
* 
* @param array $notifications_array
* @return bool
*/
function csv2post_update_option_notifications_array($notifications_array){
    $notifications_array_serialized = maybe_serialize($notifications_array);
    return update_option('csv2post_notifications',$notifications_array_serialized);    
}

function csv2post_update_option_adminsettings($admin_settings_array){
    $admin_settings_array_serialized = maybe_serialize($admin_settings_array);
    return update_option('csv2post_adminset',$admin_settings_array_serialized);    
}

function csv2post_get_option_adminsettings(){
    $admin_settings_array = get_option( 'csv2post_adminset');
    return maybe_unserialize($admin_settings_array);    
}

/**
* Gets notifications array if it exists in Wordpress options table else returns empty array
*/
function csv2post_get_option_notifications_array(){
    $a = get_option('csv2post_notifications');
    $v = maybe_unserialize($a);
    if(!is_array($v)){
        return array();    
    }
    return $val;    
}

/**
* Gets array of data import jobs and returns it as it is from Wordpress options record
* @returns false if no array stored or problem accessing options table 
*/
function csv2post_get_option_dataimportjobs_array(){
    $dataimportjobs_array = get_option('csv2post_dataimportjobs');
    $val = maybe_unserialize($dataimportjobs_array);
    if(!is_array($val)){
        return false;    
    }
    return $val;
}

/**
* Gets array of job tables and returns it as it is from Wordpress options record.
* Can use this to check what tables belong to which jobs and for quickly deleting all job tables etc.
* 
* @returns false if no array stored or problem accessing options table 
*/
function csv2post_get_option_jobtable_array(){
    $jobtables_array = get_option('csv2post_jobtables');
    $val = maybe_unserialize($jobtables_array);
    if(!is_array($val)){
        return false;
    }
    return $val;    
}

/**
* Gets the text spin array ($csv2post_textspin_array) if stored in wp_option table 
*/
function csv2post_get_option_textspin_array(){
    $textsspin_array = get_option('csv2post_textspin');
    $val = maybe_unserialize($textsspin_array);
    if(!is_array($val)){
        return false;
    }
    return $val;    
}

/**
* Updates option record for $csv2post_textspin_array
* 
* @param mixed $textspin_array
*/
function csv2post_update_option_textspin($textspin_array){
    $textspin_array_seralized = maybe_serialize($textspin_array);
    $result = update_option('csv2post_textspin',$textspin_array_seralized);
    $wperror_result = csv2post_is_WP_Error($result);
    if($wperror_result){
        return false;
    }else{
        return true;
    }    
}

/**
* Creates or updates existing a job tables array record in wordpress options table
*/
function csv2post_update_option_jobtables_array($csv2post_jobtable_array){
    $jobtables_array_seralized = maybe_serialize($csv2post_jobtable_array);
    $result = update_option('csv2post_jobtables',$jobtables_array_seralized);
    $wperror_result = csv2post_is_WP_Error($result);
    if($wperror_result){
        return false;
    }else{
        return true;
    }
}

/**
* Gets a data import job option record using the giving code
* @return false if get_option does not return an array else the array is returned
*/
function csv2post_get_dataimportjob($jobcode){
    $val = maybe_unserialize(get_option('csv2post_' . $jobcode));// should return an array
    if(!is_array($val)){
        return false;    
    }
    return $val;    
}

/**
* Returns just the headers for a single giving CSV file within a single giving job
*/
function csv2post_get_dataimportjob_headers_singlefile($jobcode,$csvfile_name){
    $dataimportjob_array = csv2post_get_dataimportjob($jobcode);
    return $dataimportjob_array[$csvfile_name]['headers'];    
} 

/**
* Creates or updates existing data import job record in wordpress options table
* 
* @param mixed $jobarray
* @param string $code
* @returns boolean, true if success or false if failed
*/
function csv2post_save_dataimportjob($jobarray,$code){
    $jobarray_seralized = maybe_serialize($jobarray);
    $result = update_option('csv2post_' . $code,$jobarray_seralized);
    $wperror_result = csv2post_is_WP_Error($result);
    if($wperror_result){
        return false;
    }else{
        return true;
    }
} 

/**
* Uses csv2post_save_dataimportjob which uses update_option and serialize on the $jobarray
* 
* @param mixed $jobarray
* @param mixed $code
* @return boolean,
*/
function csv2post_update_dataimportjob($jobarray,$code){
    return csv2post_save_dataimportjob($jobarray,$code);
}    

/**
* Gets and unserializes public settings array (publicset) 
*/
function csv2post_get_option_publicset(){
    return unserialize(get_option('csv2post_publicset'));
}

/**
* Deletes the option record for giving data import job code
* 
* @param mixed $jobcode
*/
function csv2post_delete_dataimportjob_optionrecord($jobcode){
    return delete_option('csv2post_' . $jobcode);    
}

/**
* Updates data import jobs array
*/
function csv2post_update_option_dataimportjobs($dataimportjob_array){
    $dataimportjob_array_serialized = maybe_serialize($dataimportjob_array);
    update_option('csv2post_dataimportjobs',$dataimportjob_array_serialized);
}

/**
* add new job to data import job array
* 
* @param string $code, acts as an ID for the job but I never called it ID due to so many other ID existing in Wordpress
* @param string $jobname, human identifier of the job
*/
function csv2post_add_dataimportjob_to_list($code,$jobname){
    global $csv2post_dataimportjobs_array;
    if(!$csv2post_dataimportjobs_array || $csv2post_dataimportjobs_array == false){
        $csv2post_dataimportjobs_array = array();    
    }
    $csv2post_dataimportjobs_array[$code]['name'] = $jobname;
    csv2post_update_option_dataimportjobs($csv2post_dataimportjobs_array);    
}

# truncate string to a specific length

/**
* truncate string to a specific length 
* 
* @param string $string, string to be shortened if too long
* @param integer $max_length, maximum length the string is allowed to be
* @return string, possibly shortened if longer than
*/
function csv2post_truncatestring( $string, $max_length ){
    if (strlen($string) > $max_length) {
        $split = preg_split("/\n/", wordwrap($string, $max_length));
        return ($split[0]);
    }
    return ( $string );
}

/**
* Checks if DOING_AJAX is set, indicating header is loaded for ajax request only
* @return boolean true if Ajax request ongoing else false        
*/
function csv2post_DOING_AJAX(){
    if(defined('DOING_AJAX')){
        return true;
    }
    return false;    
}

/**
* Uses fget, not PEAR CSV, to get header row of csv file and count number of fields/columns
* @return int
*/
function csv2post_establish_csvfile_fieldnumber($csvfile_name,$separator){
     // get the header row
    if (($handle = fopen(WTG_C2P_CONTENTFOLDER_DIR . '/' . $csvfile_name, "r")) !== FALSE) {

        // one row at a time we will count each possible Separator
        while (($header_row_string = fgets($handle, 4096)) !== false) {
            break;                        
        }  

        fclose($handle); 
    }    

    $header_array = explode($separator,$header_row_string);// explode the header row 
    return count( $header_array );// count number of values in array    
}     

/**
* Get arrays next key (only works with numeric key)
*/
function csv2post_get_array_nextkey($array){
    if(!is_array($array)){
        ### TODO:CRITICAL,log this issue,a bug has been reported with it. 
        return 1;   
    }
    
    ksort($array);
    end($array);
    return key($array) + 1;
} 

/**
* Returns a project table, either the already set [main] table or the first one in the list as default 
*/
function csv2post_get_project_maintable($project_code){
    // get project array
    $project_array = csv2post_get_project_array($project_code);
    if(isset($project_array['maintable'])){
        return $project_array['maintable'];
    }elseif(isset($project_array['tables'][0])){
        return $project_array['tables'][0];
    }else{
        return 'ERROR:csv2post_get_project_maintable could not determine main project table';
    }
} 

/**
* Establishes if giving project has any posts.
* Currently it only does this based on projects tables 
* 
* @param mixed $project_code
*/
function csv2post_does_project_have_posts($project_code){
    
    $project_array = csv2post_get_project_array($project_code);

    $usedrecords = csv2post_sql_used_records($project_array['maintable'],1);
    
    if($usedrecords){
        return true;
    }else{
        return false;
    }   
}

/**
* Determines if a giving CSV file name is in use (used to prevent delection of a file or using more than once)
* 
* @param mixed $file_is_in_use
* @param mixed $output
*/
function csv2post_is_csvfile_in_use($csv_file_name,$output = true){
    global $csv2post_job_array,$csv2post_dataimportjobs_array;
    // if file is in a data import job (user can delete the data import job and database table stays)
    foreach($csv2post_dataimportjobs_array as $jobid => $job){

        // get the jobs own option record
        $jobrecord = csv2post_get_dataimportjob($jobid);
        if(!$jobrecord && $output == true){
            csv2post_notice('Failed to locate the option table record for data import job named '.$job['name'].'. Is it possible the record was deleted manually?','error','Tiny','','','echo');
        }else{

            foreach($jobrecord['files'] as $key => $csvfile_name){
                if($csv_file_name == $csvfile_name){
                    return true;
                } 
            } 
               
        }
    }
    
    return false;
}

/**
* Flags the giving post by adding _csv2post_flagged meta value which is used in the flagging system.
*     
* @param integer $post_ID
* @param integer $priority, 1 = low priority (info style notification), 2 = unsure of priority (warning style notification), 3 = high priority (error style notification)
* @param integer $time, time() when possible problem was detected with post
* @param string $reason, as much information as required for user to take the required action or know they can delete the flag
* @param string $type, keyword to enhance search ability (USED:updatefailure )
*/
function csv2post_flag_post($post_ID,$priority,$time,$reason,$type){
    // if a value is missing return
    if(!isset($post_ID) || !isset($priority) || !isset($time) || !isset($reason) || !isset($type)){
        ### LOG THIS
        return false;
    }
    
    $testarray['priority'] = $priority;
    $testarray['time'] = $time;
    $testarray['reason'] = $reason;
    $testarray['type'] = 'updatefailure';
    add_post_meta($post_ID,'_csv2post_flagged',$testarray,false);   
}
?>
