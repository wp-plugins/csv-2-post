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
$panel_array['panel_name'] = 'ecifreedefaultauthor';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Step 14: Default Author');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
// <form> values, seperate from panel value
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
?>

<?php csv2post_panel_header( $panel_array );?>
    
    <?php        
    if($csv2post_ecisession_array['nextstep'] > 15){

         csv2post_n_incontent('This step has been complete.','success','Small','Step Complete');

    }else{?>

        <?php 
        // begin form and add hidden values
        csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
        csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
        ?>
            
        <?php         
        global $csv2post_project_array;
        
        $currentuserid = get_current_user_id();
        
        echo '<p>Your own user ID is ' . $currentuserid .' and it will be used as the default if no other ID is entered.</p>';
         
        if(isset($csv2post_project_array['authors']['defaultauthor']) && is_numeric($csv2post_project_array['authors']['defaultauthor'])){
            $currentuserid = $csv2post_project_array['authors']['defaultauthor'];
        }
        ?>
        <label for="csv2post_ecifreedefaultauthor_select">Author ID:</label> <input type="text" name="csv2post_ecifreedefaultauthor_select" value="<?php echo $currentuserid;?>">

        <br />            

        <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>            
     
    <?php 
    }?>
    
<?php csv2post_panel_footer();?>