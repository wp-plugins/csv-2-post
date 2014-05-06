<?php
/** 
 * Main view file for main tabs in CSV 2 POST plugin 
 * 
 * @link by http://www.webtechglobal.co.uk
 * 
 * @author Ryan Bayne 
 *
 * @package CSV 2 POST
 */

global $c2p_page_name,$C2P_WP,$c2p_tab_number,$c2p_settings,$c2p_currentversion,$c2p_mpt_arr,$c2p_is_beta,$c2p_is_installed,$c2p_extension_loaded,$c2p_is_free;
$c2p_page_name = 'main';
                            
$pageid = 'main';// used to access variable.php configuration
$pagefolder = 'pagemain';             

// set the installation software name, CSV 2 POST or extension name
$installed_version = $C2P_WP->get_installed_version();
            
// this switch is set to false when we detect first time install or update is required
$display_main_screens = true;
     
// main page header
$C2P_WP->pageheader($c2p_mpt_arr[$pageid]['title'],0);
                       
########################################################
#        REQUEST USER TO INITIATE PLUGIN UPDATE        #
########################################################                    
if($c2p_currentversion > $installed_version){       
        
    // hide the main screens until update complete
    $display_main_screens = false;
    
    $C2P_WP->n_incontent_depreciated(__('The plugins files have been replaced with a new version. You now need to complete the update by clicking below.','csv2post'),'warning','Large',sprintf(__("CSV 2 POST Update %s",'csv2post'),$c2p_currentversion));?>

    <?php 
    $c2p_update = new C2P_UpdatePlugin();
    $c2p_update->changelist('next');
    ?>
    
    <form class="csv2post_form" method="post" name="updatecsv2post" action="">
        <?php wp_nonce_field('updatecsv2post');?> 
        <input type="hidden" id="csv2post_post_requested" name="csv2post_post_requested" value="true">
        <input type="hidden" name="csv2post_hidden_pagename" value="<?php echo $pageid;?>">
        <input type="hidden" name="csv2post_form_name" value="updatecsv2post">
        <input type="hidden" name="csv2post_form_title" value="Update CSV 2 POST">
        <input type="hidden" name="csv2post_hidden_tabnumber" value="0">  
        
        <!-- existing of this value is used for security but we also pass the next version (cleaned) to confirm in submission what version should be updated to -->
        <input type="hidden" id="csv2post_plugin_update_now" name="csv2post_plugin_update_now" value="<?php echo $c2p_update->nextversion_clean();?>">
             
        <input class="button" type="submit" value="<?php _e('Update CSV 2 POST Installation','csv2post'); ?>" />
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
          
    // set tab number variable, a common use is in form hidden values
    $c2p_tab_number = $C2P_WP->tabnumber();
                    
    // create tab menu for the giving page
    $C2P_WP->createmenu($pageid);
              
    // create screen content 
    include($c2p_mpt_arr[$pageid]['tabs'][$c2p_tab_number]['path']);?>

<?php 
}?>


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
</script>