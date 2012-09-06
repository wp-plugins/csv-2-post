<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'uploadcsvfile';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Upload CSV File');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $wtgcsv_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Upload a new .csv file to the plugins own content folder.');
$panel_array['help_button'] = wtgcsv_helpbutton_text(false,false);
$panel_array['panel_help'] = __('Upload a new .csv file to the plugins own content folder. This file uploader allows .csv files to be uploaded to the plugins own content folder which you will find in the wp-content directory.');
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = wtgcsv_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
$jsform_set['dialoguebox_title'] = 'Upload CSV File';
$jsform_set['noticebox_content'] = 'You are about to upload a CSV file, it will overwrite any existing CSV file with the same name. Do you want to upload the file now?';?>
<?php wtgcsv_panel_header( $panel_array );?>
  
    <h4><?php _e('Upload CSV File')?> <?php echo ini_get( "upload_max_filesize").'B Limit';?></h4>
       <form method="post" enctype="multipart/form-data" name="uploadform" class="form-table">                
           <input type="file" name="file" size="70" /><br /><br />

            <div class="jquerybutton">
                <input class="button-primary" type="submit" value="Upload CSV File" name="eci_csvupload_submit" />
            </div>  
    <?php
    // add the javascript that will handle our form action, prevent submission and display dialogue box
    wtgcsv_jqueryform_singleaction_middle($jsform_set,$wtgcsv_options_array);?>
    </form>

    <?php wtgcsv_jquery_form_prompt($jsform_set);?>

<?php wtgcsv_panel_footer();?>        
        
<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'createdataimportjobcsvfiles';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Create Data Import Jobs With CSV Files');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $wtgcsv_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Create a data import job using one or more CSV files');
$panel_array['help_button'] = wtgcsv_helpbutton_text(false,false);
$panel_array['panel_help'] = __('Select the files you want to import, each files separator, quote and enter
the number of fields/columns each file has. The plugin will try to establish all of these automatically however
for accurate results you should enter the values manually.');
// <form> values, seperate from panel value
$jsform_set_override = array();
$jsform_set = wtgcsv_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
$jsform_set['dialoguebox_title'] = 'Create Data Import Job';
$jsform_set['noticebox_content'] = 'Do you want to continue creating a new Data Import Job? <p>Please note that this
action will not import data. You must begin data importing on the Import tab.</p>';
// create nonce - done in wtgcsv_ajax_is_dataimportjobname_used
$nonce = wp_create_nonce( "wtgcsv_referer_" . $panel_array['panel_name'] );
// TODO: HIGHPRIORITY, when existing table is selected, display another form option to select the existing table?>

<?php wtgcsv_panel_header( $panel_array );?>
    
    <?php wtgcsv_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','wtgcsv_form',$wtgcsv_form_action);?>

    <?php // set ID and NAME variables
    $jobname_id = 'wtgcsv_jobname_id_' . $panel_array['panel_name'];
    $jobname_name = 'wtgcsv_jobname_name_' . $panel_array['panel_name'];?>
    
    <script  type='text/javascript'>
    <!--
    var count = 0;

    // When the document loads do everything inside here ...
    jQuery(document).ready(function(){

        // run validation on data import job name when key is pressed
        $("#<?php echo $jobname_id;?>").change(function() { 

            var usr = $("#<?php echo $jobname_id;?>").val();

            if(usr.length >= 4){
                
                // remove any status display by adding blank value too html
                $("#wtgcsv_status_<?php echo $jsform_set['form_id'];?>").html('');
                                                 
                                       
                jQuery.ajax({
                    type: "post",url: "admin-ajax.php",data: { action: 'action_createdataimportjobcsvfiles_validatefield', wtgcsv_jobname: escape( jQuery( '#<?php echo $jobname_id;?>' ).val() ), _ajax_nonce: '<?php echo $nonce; ?>' },
                    beforeSend: function() {jQuery("#<?php echo $jsform_set['form_id'];?>loading_jobnamechange").fadeIn('fast');
                    jQuery("#<?php echo $jsform_set['form_id'];?>formstatus").fadeOut("fast");}, //fadeIn loading just when link is clicked
                    success: function(html){ //so, if data is retrieved, store it in html
                        jQuery("#<?php echo $jsform_set['form_id'];?>loading_jobnamechange").fadeOut('slow');
                        jQuery("#<?php echo $jsform_set['form_id'];?>formstatus").html( html ); //show the html inside formstatus div
                        jQuery("#<?php echo $jsform_set['form_id'];?>formstatus").fadeIn("fast"); //animation
                    }
                }); //close jQuery.ajax
                     
            }else{
                $("#wtgcsv_status_<?php echo $jsform_set['form_id'];?>").html('<font color="red">' + 'The username should have at least <strong>4</strong> characters.</font>');
                $("#<?php echo $jobname_id;?>").removeClass('object_ok'); // if necessary
                $("#<?php echo $jobname_id;?>").addClass("object_error");
            }

        });
    })
    -->
    </script>

    <!-- TODO:LOWPRIORITY, put this style into stylesheet -->
    <style type='text/css'>
    #<?php echo $jsform_set['form_id'];?>loading_jobnamechange { clear:both; background:url(images/loading.gif) center top no-repeat; text-align:center;padding:33px 0px 0px 0px; font-size:12px;display:none; font-family:Verdana, Arial, Helvetica, sans-serif; }                
    </style>
    
    <h2>Enter Job Name</h2>        
    <p><input type='text' name='wtgcsv_jobname_name' id='<?php echo $jobname_id;?>' value='' size="30" /><span id="wtgcsv_status_<?php echo $jsform_set['form_id'];?>"></span></p>

        <?php
        // full edition allows multiple file selection (do not bypass this without writing the functions to handle multiple files) 
        //if($wtgcsv_is_free){
            //wtgcsv_menu_csvfiles();
        //}else{
            //wtgcsv_selectables_csvfiles('all',$panel_array['panel_name']);
        //}?>
    
    <!-- jquery and ajax output start -->
    <div id='<?php echo $jsform_set['form_id'];?>loading_jobnamechange'>Checking Job Name Please Wait 10 Seconds</div>                 
    <div id='<?php echo $jsform_set['form_id'];?>formstatus'></div>  
    <!-- jquery and ajax output end -->
    
    <h2>Select Table Setup</h2>
    <p>            
        <script>
        $(function() {
            $( "#wtgcsv_tabletype<?php echo $panel_array['panel_name'];?>" ).buttonset();
        });
        </script>

        <div id="wtgcsv_tabletype<?php echo $panel_array['panel_name'];?>">
            <input type="radio" id="wtgcsv_radio1<?php echo $panel_array['panel_name'];?>" name="radio" checked="checked" /><label for="wtgcsv_radio1<?php echo $panel_array['panel_name'];?>">New Table</label>
            <input type="radio" id="wtgcsv_radio2<?php echo $panel_array['panel_name'];?>" name="radio" disabled="disabled" /><label for="wtgcsv_radio2<?php echo $panel_array['panel_name'];?>">Existing Table</label>
        </div>
    </p>
    
    <h2>Select CSV File/s</h2>
    <p><?php wtgcsv_display_csvfiles_fornewdataimportjob(); ?></p>
    
    <?php
    // add the javascript that will handle our form action, prevent submission and display dialogue box
    wtgcsv_jqueryform_singleaction_middle($jsform_set,$wtgcsv_options_array);

    // add end of form - dialogue box does not need to be within the <form>
    wtgcsv_formend_standard('Submit',$jsform_set['form_id']);?>

    <?php wtgcsv_jquery_form_prompt($jsform_set);?>            

<?php wtgcsv_panel_footer();?>

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'csvfileprofiles';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('CSV File Profiles');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $wtgcsv_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Information about all available CSV files, used or not');
$panel_array['panel_help'] = __('This panel shows all the .csv files available to import data. Some basic information about the files is displayed.');
$panel_array['help_button'] = wtgcsv_helpbutton_text(false,false);?>
<?php wtgcsv_panel_header( $panel_array );?>
    
    <h4>File Information</h4>
    <?php wtgcsv_available_csv_file_list();?>
    
    <h4>File Status</h4>
    <?php wtgcsv_csv_files_status_list();?>

<?php wtgcsv_panel_footer();?>


<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'testcsvfiles';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Test CSV Files');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $wtgcsv_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Run a series of tests on a file to help determine its suitability as a CSV file');
$panel_array['panel_help'] = __('This tool will run some tests on your file and try to detect potential problems. You may get recommendations for your file which you can ignore, you will know best but the plugin will try to suggest changes that you can try should you experience any problems with your file. Where a fault is detected and confirmed to prevent proper use of a file it will be made very clear to you. The most common cause of problems is a CSV file that is not properly formatted. A CSV files rows should be spread over a single line within the file when opened in Notepad and Excel. Many files are created with data covering multiple rows within the file, missing commas or headers/titles that are not suitable as an identifier i.e. too many words and special characters. Most of the requirements of a properly formatted CSV file follow standards often expected within database management because the data usually comes from a database and is eventually being imported to a database.');
$panel_array['help_button'] = wtgcsv_helpbutton_text(false,false);
// <form> values, seperate from panel value
$jsform_set_override = array();
$jsform_set = wtgcsv_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
$jsform_set['dialoguebox_title'] = 'Test CSV File';
$jsform_set['noticebox_content'] = 'Do you want to run the full series of tests on the selected file? <p>The plugin will run a series of tests that could use your servers full processing time depending on how large your file is. Please keep this in mind, if you experience problems you may want to run tests on a smaller version of your file as a first step. Please create a support ticket (full users) or forum thread (free users) if you do experience problems so that I can investigate possible improvements.</p>';
/**
* TODO:LOWPRIORITY,would it work to add a test that checks every row and every data value counting total number of columns then output exact row numbers where possible issues detected?
*/?>

<?php wtgcsv_panel_header( $panel_array );?>

    <?php wtgcsv_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','wtgcsv_form');?>

    <h2>Select CSV File</h2>
    <?php wtgcsv_menu_csvfiles('all',$panel_array['panel_name']);?>

    <script>
        $(function() {
            $( "#wtgcsv_separators_<?php echo $panel_array['panel_name'];?>" ).buttonset();
        });
    </script>

    <h2>Select Files Separator</h2>
    <div id="wtgcsv_separators_<?php echo $panel_array['panel_name'];?>">
        <input type="radio" id="wtgcsv_separator_radio1<?php echo $panel_array['panel_name'];?>" name="wtgcsv_testcsvfile_separator_radiogroup" value="," /><label for="wtgcsv_separator_radio1<?php echo $panel_array['panel_name'];?>">,</label>
        <input type="radio" id="wtgcsv_separator_radio2<?php echo $panel_array['panel_name'];?>" name="wtgcsv_testcsvfile_separator_radiogroup" value=";" /><label for="wtgcsv_separator_radio2<?php echo $panel_array['panel_name'];?>">;</label>
        <input type="radio" id="wtgcsv_separator_radio3<?php echo $panel_array['panel_name'];?>" name="wtgcsv_testcsvfile_separator_radiogroup" value="|" /><label for="wtgcsv_separator_radio3<?php echo $panel_array['panel_name'];?>">|</label>
    </div>
    
    <?php
    // add the javascript that will handle our form action, prevent submission and display dialogue box
    wtgcsv_jqueryform_singleaction_middle($jsform_set,$wtgcsv_options_array);

    // add end of form - dialogue box does not need to be within the <form>
    wtgcsv_formend_standard('Run Test',$jsform_set['form_id']);?>

    <?php wtgcsv_jquery_form_prompt($jsform_set);?> 
        
<?php wtgcsv_panel_footer();?>

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'usedcsvfilelist';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Used CSV File List');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $wtgcsv_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('A list of used files, scroll further down to view import jobs');
$panel_array['panel_help'] = __('Refreshing the browser will show the latest statistics in this table if you have imported data on this page. This list of files are those used in data import jobs. If a file shows twice it is because you are using it in more than one job. This panel is not for importing data. Scroll further down the Import screen to view individual job panels to begin manual data importing and view their progress.');
$panel_array['help_button'] = wtgcsv_helpbutton_text(false,false);?>
<?php wtgcsv_panel_header( $panel_array );?>
 
    <?php $usedcsvfile_count = wtgcsv_used_csv_file_list();?>
    
    <?php
    if($usedcsvfile_count == 0){
        wtgcsv_notice('You do not have any data import jobs and so no CSV files are in use either.','info','Small');
    }?>

<?php wtgcsv_panel_footer();?> 

<?php
if($wtgcsv_is_dev){
    
    // Current Job Array Panel
    ++$panel_number;// increase panel counter so this panel has unique ID
    $panel_array = array();
    $panel_array['panel_name'] = 'currentjobarraydump';// slug to act as a name and part of the panel ID 
    $panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
    $panel_array['panel_title'] = __('Current Job Array Dump');// user seen panel header text 
    $panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
    $panel_array['tabnumber'] = $wtgcsv_tab_number; 
    $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
    $panel_array['panel_intro'] = __('A dump of your current job array');
    $panel_array['panel_help'] = __('If you have a current data import job set, the jobs array will be dumped here. The array is a set of PHP values stored in the Wordpress options table under the key "wtgcsv_currentjobcode".');
    $panel_array['help_button'] = wtgcsv_helpbutton_text(false,true);?>

    <?php wtgcsv_panel_header( $panel_array );?>

        <h4>Entire Array</h4>
        <pre><?php var_dump($wtgcsv_job_array);?>

    <?php wtgcsv_panel_footer();
    
    // $wtgcsv_dataimportjobs_array Panel
    ++$panel_number;// increase panel counter so this panel has unique ID
    $panel_array = array();
    $panel_array['panel_name'] = 'dataimportjobsarray';// slug to act as a name and part of the panel ID 
    $panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
    $panel_array['panel_title'] = __('Data Import Jobs Array');// user seen panel header text 
    $panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
    $panel_array['tabnumber'] = $wtgcsv_tab_number; 
    $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
    $panel_array['panel_intro'] = __('A dump of the array that holds a list of all data import jobs');
    $panel_array['panel_help'] = __('The data import jobs array is a list of all jobs. It is mainly used to create a list of data import jobs for user to select as their current one.');
    $panel_array['help_button'] = wtgcsv_helpbutton_text(false,true);?>

    <?php wtgcsv_panel_header( $panel_array );?>

        <h4>Entire Array</h4>
        <pre><?php var_dump($wtgcsv_dataimportjobs_array);?>

    <?php wtgcsv_panel_footer();    

    // $wtgcsv_jobtable_array Panel
    ++$panel_number;// increase panel counter so this panel has unique ID
    $panel_array = array();
    $panel_array['panel_name'] = 'jobtablesarray';// slug to act as a name and part of the panel ID 
    $panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
    $panel_array['panel_title'] = __('Job Tables Array');// user seen panel header text 
    $panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
    $panel_array['tabnumber'] = $wtgcsv_tab_number; 
    $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
    $panel_array['panel_intro'] = __('The array dumped here holds all tables created for Data Import Jobs');
    $panel_array['panel_help'] = __('All database tables created by Wordpress CSV Importer for data import jobs are added to this array. As I write this, entries are not removed when deleting tables. How the plugin deals with this may change later, but for now the left over entries act as a history. The array is stored in $wtgcsv_jobtable_array which can be called globally and used to list tables.');
    $panel_array['help_button'] = wtgcsv_helpbutton_text(false,true);?>

    <?php wtgcsv_panel_header( $panel_array );?>

        <h4>Entire Array</h4>
        <pre><?php var_dump($wtgcsv_jobtable_array);?>

    <?php wtgcsv_panel_footer();        
}?>