<?php 
global $csv2post_guitheme,$csv2post_extension_loaded,$csv2post_adm_set,$csv2post_is_installed,$csv2post_currentversion,$csv2post_file_profiles,$csv2post_mpt_arr,$wpdb,$wtgtp_pluginforum,$wtgtp_pluginblog,$csv2post_options_array,$csv2post_is_free,$csv2post_projectslist_array,$csv2post_schedule_array;
                        
$installing_software_name = WTG_C2P_NAME;
$installing_software_name_plus = '';
$installing_message = '';

// load extension globals
if($csv2post_extension_loaded){
    $installing_software_name = WTG_C2P_RYANAIR_NAME;
    $installing_software_name_plus = ' and ' . WTG_C2P_RYANAIR_NAME;
    $installing_message = 'You are using the ' . $installing_software_name . ' extension files.
    This extension will also be installed. Remove the extension files to install CSV 2 POST on its own.';
}

// set the installation software name, CSV 2 POST or extension name
$installed_version = csv2post_WP_SETTINGS_get_version();
            
// this switch is set to false when we detect first time install or update is required
$display_main_screens = true;
                             
########################################################
#                                                      #
#     REQUEST USER TO INITIATE FIRST TIME INSTALL      #
#                                                      #
########################################################
if(!$csv2post_is_installed && !isset($_POST['csv2post_plugin_install_now'])){# we do not enter here if installation was submitted, this allows the resulting notices to be displayed under page header else they come before all admin content

    // hide the main screens until update complete
    $display_main_screens = false;
    
    ### TODO:MEDIUMPRIORITY, add link to forum page and form for feedback
    csv2post_n_incontent('Thank you for using our plugin, we look forward to your feedback.<br /><br />
    <strong>' . $installing_message .'</strong>','info','Large','Welcome To CSV 2 POST');
        
    csv2post_jquery_button();?>

    <form class="csv2post_form" method="post" name="csv2post_plugin_install" action="">
        <input type="hidden" id="csv2post_post_processing_required" name="csv2post_post_processing_required" value="true">
        <input type="hidden" id="csv2post_plugin_install_now" name="csv2post_plugin_install_now" value="z3sx4bhik970">
        <input type="hidden" name="csv2post_hidden_pageid" value="main">
        <input type="hidden" name="csv2post_hidden_panel_name" value="installationscreen">
        <input type="hidden" name="csv2post_hidden_panel_title" value="Welcome To CSV 2 POST">
        <input type="hidden" name="csv2post_hidden_tabnumber" value="0">
        <div class="jquerybutton">
            <button id="csv2post_install_plugin_button">Install CSV 2 POST <?php echo $installing_software_name_plus;?></button>
        </div>
    </form>
    
<?php  
}elseif($csv2post_currentversion > $installed_version){         
########################################################
#                                                      #
#  REQUEST USER TO INITIATE PLUGIN UPDATE IF REQUIRED  #
#                                                      #
######################################################## 
    
    // hide the main screens until update complete
    $display_main_screens = false;
    
    csv2post_n_incontent('You have updated the plugins core
    files but changes may be required to values in database or in files outside of the plugin folder. 
    All required changes will be laid out below. Please scroll down and confirm that you accept the changes
    to be made in your blog by clicking the "Update CSV 2 POST Installation" button.',
    'warning','Large','CSV 2 POST Plugin Update Required');

    // include the upgrade array
    require_once(WTG_C2P_DIR.'include/variables/csv2post_variables_update_array.php');
        
    $installed_version = csv2post_WP_SETTINGS_get_version();
        
    // build a message for displaying in notice box
    $notice_box_message = '';
    $total_changes_to_be_made = 0;
    foreach($csv2post_upgrade_array as $version => $change){
        
        if($version > $installed_version){
            $notice_box_message .= '<h2>Version '.$version.'</h2>';
            
            $notice_box_message .= '<strong>WARNING: '.$change['warning'].'</strong>';
            
            $notice_box_message .= '<ol>'; 
            foreach($change['changes'] as $id => $info){
                
                // do not show changes that apply to the paid edition only
                if($info['package'] == 'free' || !$csv2post_is_free && $info['package'] == 'paid'){
                    $notice_box_message .= '<li><strong>'.$info['title'].':</strong> '.$info['description'].'</li>';
                    
                    // count number of changes 
                    ++$total_changes_to_be_made;
                }    
                
            }                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               
            $notice_box_message .= '</ol>'; 
        }
        
    }

    if($total_changes_to_be_made == 0){
        $notice_box_message = 'No key changes are required for this update but you must still click "Update CSV 2 POST Installation"
        and the plugin will store the latest version in your blogs database. This is how we track the versions and once
        the new version number is added to your database you will no longer see this page.';
    }

    csv2post_n_incontent($notice_box_message,'info','Extra','Required Changes');

    csv2post_jquery_button();?>

    <form class="csv2post_form" method="post" name="csv2post_plugin_update" action="">
        <input type="hidden" id="csv2post_post_processing_required" name="csv2post_post_processing_required" value="true">
        <input type="hidden" id="csv2post_plugin_update_now" name="csv2post_plugin_update_now" value="a43bt7695c34">
        <input type="hidden" name="csv2post_hidden_pageid" value="<?php echo $pageid;?>">
        <input type="hidden" name="csv2post_hidden_panel_name" value="pluginupdatescreen">
        <input type="hidden" name="csv2post_hidden_panel_title" value="Update CSV 2 POST">
        <input type="hidden" name="csv2post_hidden_tabnumber" value="0">       
        <div class="jquerybutton">
            <button id="csv2post_update_plugin_button">Update CSV 2 POST Installation</button>
        </div>
    </form>
    
<?php   
}

########################################################
#                                                      #
#               DISPLAY MAIN SCREENS                   #
#                                                      #
########################################################
// the plugin update process is complete above and that decides if we should show the main screens
if($display_main_screens){

    $pageid = 'main';// used to access variable.php configuration
    $pagefolder = 'pagemain';

    // main page header
    $a = 'Premium Edition';
    if($csv2post_is_free){$a = 'Free Edition';}
    csv2post_header_page($csv2post_mpt_arr['menu'][$pageid]['title'].' '.$a,0);
                
    // create tab menu for the giving page
    csv2post_createmenu($pageid);
              
    // count number of panels, variable used as in code ID to pass to functions, not the TAB number users can see in url
    $panel_number = 0;

    // set tab number variable, a common use is in form hidden values
    $csv2post_tab_number = csv2post_get_tabnumber();

    if($csv2post_guitheme == 'wordpresscss' ){### TODO:CRITICAL, complete css menu 

        csv2post_GUI_css_screen_include($pageid,$panel_number,$csv2post_tab_number);

    }elseif($csv2post_guitheme == 'jquery'){
        
        // loop through tabs - held in menu pages tabs array
        foreach($csv2post_mpt_arr['menu'][$pageid]['tabs'] as $tab => $values){
            
            // chekc if tab is to be displayed, if not, we do not add the div for it    
            if(csv2post_menu_should_tab_be_displayed($pageid,$tab)){
                
                // build form action value, will be appended            
                $csv2post_form_action = '';
     
                echo '<div id="tabs-'.$tab.'">';
                
                // check users permissions for this screen
                if(current_user_can( csv2post_WP_SETTINGS_get_tab_capability($pageid,$tab) )){
                    // display persistent notices for the current screen
                    csv2post_persistentnotice_output('screen',$tab,$pageid);
                    // create screen content                
                    include($csv2post_mpt_arr['menu'][$pageid]['tabs'][$tab]['path']);    
                }else{
                    csv2post_n_incontent('Your Wordpress user account does not have permission to access this screen.','info','Small','No Permission: ');    
                }
                
                echo '</div>';
            }
        } 
        
    }elseif($csv2post_guitheme == 'nonav'){# results in all accordions listed on one screen
        
        ### TODO:CRITICAL, complete no navigation view 
        
        // loop through tabs - held in menu pages tabs array
        foreach($csv2post_mpt_arr['menu'][$pageid]['tabs'] as $tab=>$values){
            
            // chekc if tab is to be displayed, if not, we do not add the div for it    
            if( csv2post_menu_should_tab_be_displayed($pageid,$tab) ){
                
                $csv2post_form_action = csv2post_link_toadmin($_GET['page'],'#tabs-' . $tab);            

                include(WTG_C2P_DIR.'pages/'.$pagefolder.'/csv2post_tab'.$tab.'_page'.$pageid.'.php');
            
            }
        }    
        
    }?>

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
}?>
