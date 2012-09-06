<?php
global $wtgcsv_apisession_array,$wtgcsv_is_webserviceavailable,$wtgcsv_is_domainregistered,$wtgcsv_is_emailauthorised,$wtgcsv_is_installed,$wtgcsv_apiservicestatus;
                  
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'premiumservicesstatus';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Premium Services Status');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $wtgcsv_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_array['panel_number'];// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('When a post does not have settings in its custom fields, these defaults are used.');
$panel_array['panel_help'] = __('Settings which effect posts (that includes pages or custom post types) will be found here. This panel of settings behaves as a default, in many cases the default is ignored when a setting is applied to a specific post i.e. setting value stored in a custom field.'); 
?>
<div id="titles" class="postbox">
    <div class="handlediv" title="Click to toggle"><br /></div>

    <h3 class="hndle"><span><?php echo $panel_array['panel_title'];?></span></h3>

    <div class="inside" id="<?php echo $panel_array['panel_name'];?>-box-inside-icon">

        <?php
        if(!$wtgcsv_is_installed){
            wtgcsv_notice(__('You must fully install the plugin before it can check the status of your premium services. Please check the 
            installation status screen, a part of your installation may be missing.'), 'info', 'Extra', false);
        }else{?>
            <div class="wtgcsv_boxintro_div">
                <?php wtgcsv_helpbutton_closebox($panel_array); ?>
            </div>
            <div class="wtgcsv_boxcontent_div">
                <?php
                ###########################################
                ####                                   ####
                ####     DISPLAY WEB SERVICE STATUS    ####
                ####                                   ####
                ###########################################
                if($wtgcsv_apiservicestatus){
                    echo '<img src="'.WTG_CSV_IMAGEFOLDER_URL.'statusbanners/webservicebanners/webtechglobal-webservice-online.jpg"/>';                        
                }else{
                    echo '<img src="'.WTG_CSV_IMAGEFOLDER_URL.'statusbanners/webservicebanners/webtechglobal-webservice-maintenence.jpg"/>'; 
                }
                
                ###########################################
                ####                                   ####
                ####        DISPLAY DOMAIN STATUS      ####
                ####                                   ####
                ###########################################             
                if(isset($wtgcsv_is_domainregistered) && $wtgcsv_is_domainregistered == true){
                    echo '<img src="'.WTG_CSV_IMAGEFOLDER_URL.'statusbanners/domainstatusbanners/wordpress-csv-importer-domainstatus-registered.jpg"/>';    
                }elseif(isset($wtgcsv_is_domainregistered) && $wtgcsv_is_domainregistered == false){ 
                    echo '<img src="'.WTG_CSV_IMAGEFOLDER_URL.'statusbanners/domainstatusbanners/wordpress-csv-importer-domainstatus-notregistered.jpg"/>';         
                }else{
                    echo '<img src="'.WTG_CSV_IMAGEFOLDER_URL.'statusbanners/domainstatusbanners/wordpress-csv-importer-domainstatus-unknown.jpg"/>';          
                }
                
                ###########################################
                ####                                   ####
                ####        DISPLAY SERVICE LEVEL      ####
                ####                                   ####
                ###########################################
                /*   
                Make use of these images and display the service level user is currently getting
                
                wordpress-csv-importer-support-level-prioritylevel.jpg
                wordpress-csv-importer-support-level-highlevel.jpg
                wordpress-csv-importer-support-level-standard.jpg
                wordpress-csv-importer-support-level-unknown.jpg
                
                if(isset($wtgcsv_is_domainregistered) && $wtgcsv_is_domainregistered == true){
                    echo '<img src="'.WTG_CSV_IMAGEFOLDER_URL.'statusbanners/webtechglobal-pluginmembership-online.jpg"/>';    
                }elseif(isset($wtgcsv_is_domainregistered) && $wtgcsv_is_domainregistered == false){ 
                    echo '<img src="'.WTG_CSV_IMAGEFOLDER_URL.'statusbanners/webtechglobal-pluginmembership-none.jpg"/>';         
                }else{
                    echo '<img src="'.WTG_CSV_IMAGEFOLDER_URL.'statusbanners/webtechglobal-pluginmembership-unknown.jpg"/>';          
                }*/
                ?>

                <?php
                $jsform_set = array();
                $jsform_set['has_options'] = true;// true or false (controls output of selected settings)
                $jsform_set['pageid'] = $pageid;
                $jsform_set['panelnumber'] = $panel_array['panel_number'];
                $jsform_set['panel_name'] = $panel_array['panel_name'];
                $jsform_set['panel_title'] = $panel_array['panel_title'];
                // form related
                $jsform_set['form_id'] = WTG_CSV_ABB.'form_id_' .$panel_array['panel_name'];
                $jsform_set['form_name'] = WTG_CSV_ABB.'form_name_'.$panel_array['panel_name'];

                wtgcsv_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post',WTG_CSV_ABB.'form','');?>

                <?php
                // add wtg hidden form values (for debugging)
                wtgcsv_hidden_form_values($panel_array['tabnumber'],$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
                   
                // add end of form - dialogue box does not need to be within the <form>
                wtgcsv_formend_standard('Submit',$jsform_set['form_id']);?>                

            </div>
        <?php } ?>
    </div>
</div> 