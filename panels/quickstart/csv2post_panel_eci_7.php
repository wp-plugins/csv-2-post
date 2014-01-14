<?php
/** 
 * Free edition file (applies to paid also) for CSV 2 POST plugin by WebTechGlobal.co.uk
 *
 * @package CSV 2 POST
 * 
 * @author Ryan Bayne | ryan@webtechglobal.co.uk
 */
 
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'ecifreepoststatus';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Step 7: Post Status');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['dialogdisplay'] = 'no';
// <form> values, seperate from panel value
$jsform_set_override = array();### TODO:LOWPRIORITY, we can remove these lines and add array() to the functions parameter
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
?>

<?php csv2post_panel_header( $panel_array );?>
    
    <?php 
    if($csv2post_ecisession_array['nextstep'] > 7){

        $poststatus = 'publish';
        if(isset($csv2post_project_array['poststatus'])){
            $poststatus = $csv2post_project_array['poststatus'];    
        }
    
        $format = 'standard';
        if(isset($csv2post_project_array['postformat']['default'])){
            $format = $csv2post_project_array['postformat']['default'];    
        }    
        
        csv2post_n_incontent('This step was complete. Your default post status is '.$poststatus.' and
        your default post format is '.$format.'.','success','Small','Step Complete');

    }else{?>

        <?php 
        // begin form and add hidden values
        csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
        csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
        ?>

            <p>Fact: CSV 2 POST was the first plugin to allow custom post status to be selected, not just the default ones. We need you help 
            to keep provide more functionality for free. Please donate to paypal@webtechglobal.co.uk, thank you.</p>
            
            <script>
            $(function() {
                $( "#csv2post_eci_poststatus_radios" ).buttonset();
            });
            </script>

            <div id="csv2post_eci_poststatus_radios">
                <?php csv2post_FORMOBJECT_poststatus_radios('quickstart');?>
            </div>           
 
        <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>            
     
    <?php 
    }?>
    
<?php csv2post_panel_footer();?>