<?php 
global $csv2post_installlog_help_0510;###TODO:CRITICAL,does this variable exist anymore???

++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'installationlog';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Installation Log');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = 'Here you can view installation status related entries to the general log file';
$panel_array['panel_help'] = 'Any actions related to the installation status of '.$csv2post_plugintitle.' will be logged in the General log file. The plugin filters log entries related to install, re-insall or un-install changes. This is mainly for troubleshooting but in some cases we can offer the ability to change your installation without logging into your blog. The log entries are imported to review such changes.'; 
$panel_array['help_button'] = csv2post_helpbutton_text(true,false);?>

<?php csv2post_panel_header( $panel_array );?>
       
    <?php
    // create array of key words to filter entries from the general log
    $install_filter_array = array();
    $install_filter_array['logfile'] = 'admin';// use logfile to open specific log file
    $install_filter_array['action'] = 'install';// use this action for uninstall,reinstall etc
    $install_filter_array['priority'] = 'all';// all (default),low,high,critical
    // add panel details to array, used for forms in notices
    $install_filter_array['pageid'] = $pageid;         
    $install_filter_array['panel_title'] = $panel_array['panel_title'];            
    $install_filter_array['panel_name'] = $panel_array['panel_name'];
    $install_filter_array['panel_number'] = $panel_array['panel_number'];  
                                         
    csv2post_viewhistory($install_filter_array);?>
        
<?php csv2post_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'installlogactions';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Install Log Actions');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_array['panel_number'];// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = 'Pause and start log files';
$panel_array['panel_help'] = 'The plugin logs different events in different files. Any actions related to the installation status of '.$csv2post_plugintitle.' will be logged in the General log file. The plugin filters log entries related to install, re-insall or un-install changes. This is mainly for troubleshooting but in some cases we can offer the ability to change your installation without logging into your blog. The log entries are imported to review such changes.';
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);?>
<?php csv2post_panel_header( $panel_array );?>  

    <script type='text/javascript'>
    //<![CDATA[
    $(function(){

    $(document).ready(function() {

        <?php $multibutton_formname = 'installlogactions_formname';?>
        var form_id = "<?php echo WTG_C2P_ABB;?>installlogactions_formid";
        var form_name = "<?php echo WTG_C2P_ABB;?>installlogactions_formname";

        // display dia logue box function
        $("#<?php echo WTG_C2P_ABB;?>logdivid1").dialog({
            autoOpen: false,
            modal: true,
            width: 800,
            resizable: true,
            buttons: {
                "Pause": function() {
                    document.<?php echo $multibutton_formname; ?>.submit();
                },
                "Cancel": function() {
                    $(this).dialog("close");
                }
            }
        });

         $("#<?php echo WTG_C2P_ABB;?>logdivid2").dialog({
            autoOpen: false,
            modal: true,
            width: 800,
            resizable: true,
            buttons: {
                "Pause": function() {
                    document.<?php echo $multibutton_formname; ?>.submit();
                },
                "Cancel": function() {
                    $(this).dialog("close");
                }
            }
        });

        $("#<?php echo WTG_C2P_ABB;?>logdivid3").dialog({
            autoOpen: false,
            modal: true,
            width: 800,
            resizable: true,
            buttons: {
                "Pause": function() {
                    document.<?php echo $multibutton_formname; ?>.submit();
                },
                "Cancel": function() {
                    $(this).dialog("close");
                }
            }
        });

        $("#<?php echo WTG_C2P_ABB;?>logdivid4").dialog({
            autoOpen: false,
            modal: true,
            width: 800,
            resizable: true,
            buttons: {
                "Start": function() {
                    document.<?php echo $multibutton_formname; ?>.submit();
                },
                "Cancel": function() {
                    $(this).dialog("close");
                }
            }
        });

        $("#<?php echo WTG_C2P_ABB;?>logdivid5").dialog({
            autoOpen: false,
            modal: true,
            width: 800,
            resizable: true,
            buttons: {
                "Start": function() {
                    document.<?php echo $multibutton_formname; ?>.submit();
                },
                "Cancel": function() {
                    $(this).dialog("close");
                }
            }
        });

        $("#<?php echo WTG_C2P_ABB;?>logdivid6").dialog({
            autoOpen: false,
            modal: true,
            width: 800,
            resizable: true,
            buttons: {
                "Start": function() {
                    document.<?php echo $multibutton_formname; ?>.submit();
                },
                "Cancel": function() {
                    $(this).dialog("close");
                }
            }
        });

        // prevent form submission, display dialog box instead
        $("#<?php echo WTG_C2P_ABB;?>logbutton_id1").click(function(e){
            e.preventDefault();
            if( $("#hiddenField_process_1").length == 0 ) $("<input type='hidden' name='hiddenField_process_1' id='hiddenField_process_1' value='submittedone' />").appendTo("form#" + form_id); else $("#formMainHiddenField_id").val("submittedone");
            $("#<?php echo WTG_C2P_ABB;?>logdivid1").dialog('open');
        });
        $("#<?php echo WTG_C2P_ABB;?>logbutton_id2").click(function(e){
            e.preventDefault();
            if( $("#hiddenField_process_2").length == 0 ) $("<input type='hidden' name='hiddenField_process_2' id='hiddenField_process_2' value='submittedtwo' />").appendTo("form#" + form_id); else $("#formMainHiddenField_id").val("submittedtwo");
            $("#<?php echo WTG_C2P_ABB;?>logdivid2").dialog('open');
        });
        $("#<?php echo WTG_C2P_ABB;?>logbutton_id3").click(function(e){
            e.preventDefault();
            if( $("#hiddenField_process_3").length == 0 ) $("<input type='hidden' name='hiddenField_process_3' id='hiddenField_process_3' value='submittedthree' />").appendTo("form#" + form_id); else $("#formMainHiddenField_id").val("submittedthree");
            $("#<?php echo WTG_C2P_ABB;?>logdivid3").dialog('open');
        });
        
        $("#<?php echo WTG_C2P_ABB;?>logbutton_id4").click(function(e){
            e.preventDefault();
            if( $("#hiddenField_process_4").length == 0 ) $("<input type='hidden' name='hiddenField_process_4' id='hiddenField_process_4' value='submittedfour' />").appendTo("form#" + form_id); else $("#formMainHiddenField_id").val("submittedfour");
            $("#<?php echo WTG_C2P_ABB;?>logdivid4").dialog('open');
        });

        $("#<?php echo WTG_C2P_ABB;?>logbutton_id5").click(function(e){
            e.preventDefault();
            if( $("#hiddenField_process_5").length == 0 ) $("<input type='hidden' name='hiddenField_process_5' id='hiddenField_process_5' value='submittedfive' />").appendTo("form#" + form_id); else $("#formMainHiddenField_id").val("submittedfive");
            $("#<?php echo WTG_C2P_ABB;?>logdivid5").dialog('open');
        });

        $("#<?php echo WTG_C2P_ABB;?>logbutton_id6").click(function(e){
            e.preventDefault();
            if( $("#hiddenField_process_6").length == 0 ) $("<input type='hidden' name='hiddenField_process_6' id='hiddenField_process_6' value='submittedsix' />").appendTo("form#" + form_id); else $("#formMainHiddenField_id").val("submittedsix");
            $("#<?php echo WTG_C2P_ABB;?>logdivid6").dialog('open');
        });

    });
  });
  //]]>
  </script>

<div>

    <form id="<?php echo WTG_C2P_ABB;?>installlogactions_formid" method="post" name="<?php echo WTG_C2P_ABB;?>installlogactions_formname" action="">

        <div class="jquerybutton">
            <?php
            if($csv2post_adm_set['log_install_active'] == true){
                echo '<button id="'. WTG_C2P_ABB .'logbutton_id1">Pause Installation Log</button>';
            }else{
                echo '<button id="'. WTG_C2P_ABB .'logbutton_id4">Start Installation Log</button>';
            }
            
            if($csv2post_adm_set['log_general_active'] == true){
                echo '<button id="'. WTG_C2P_ABB .'logbutton_id2">Pause General Log</button>';
            }else{
                echo '<button id="'. WTG_C2P_ABB .'logbutton_id5">Start General Log</button>';
            }
            
            if(csv2post_ishistory_active('any')){
                echo '<button id="'. WTG_C2P_ABB .'logbutton_id3">Pause All Logs</button>';
            }else{
                echo '<button id="'. WTG_C2P_ABB .'logbutton_id6">Start All Logs</button>';
            }?>
        </div>
    </form>

    <!-- will display output <div><p><b>Results:</b> <span id="resultstest"></span></p></div> -->

    <!-- each buttons own dialog box -->
    <div id="<?php echo WTG_C2P_ABB;?>logdivid1" title="Pause Installation Log">
        <?php csv2post_notice(__('Do you want to pause any log recording regarding the installation state of the plugin?'), 'question', 'Small', false); ?>
    </div>

    <div id="<?php echo WTG_C2P_ABB;?>logdivid2" title="Pause General Log">
        <?php csv2post_notice(__('Do you want to pause any log entries to the general log file?'), 'question', 'Small', false); ?>
    </div>

    <div id="<?php echo WTG_C2P_ABB;?>logdivid3" title="Pause All Logs">
        <?php csv2post_notice(__('Do you want to pause all log keeping for the whole plugin?'), 'question', 'Small', false); ?>
    </div>

    <div id="<?php echo WTG_C2P_ABB;?>logdivid4" title="Start Installation Log">
        <?php csv2post_notice(__('Do you want to log installation related activities?'), 'question', 'Small', false); ?>
    </div>

    <div id="<?php echo WTG_C2P_ABB;?>logdivid5" title="Start General Log">
        <?php csv2post_notice(__('Do you want to log general activity to the general log file?'), 'question', 'Small', false); ?>
    </div>

    <div id="<?php echo WTG_C2P_ABB;?>logdivid6" title="Start All Logs">
        <?php csv2post_notice(__('Do you want to start keeping a record of everything and use all log files?'), 'question', 'Small', false); ?>
    </div>

</div>

<?php csv2post_panel_footer();?> 