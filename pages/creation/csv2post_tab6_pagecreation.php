<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'latestten';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Latest Ten');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('The ten latest flagged posts still awaiting attention');
$panel_array['panel_help'] = __('This panel is good for quickly checking what happened during the last post creation
event. You can delete flags as you attend to the matters raised.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
$jsform_set['dialoguebox_title'] = 'Delete Flags';
$jsform_set['noticebox_content'] = 'You are about to delete flags, please ensure you have delete with the issues raised first. Do you wish to continue?';?>
<?php csv2post_panel_header( $panel_array );?>
 
    <?php csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form');?>
    
    <?php 
    $pageposts = $wpdb->get_results("
        SELECT * FROM wp_posts p 
        LEFT JOIN wp_postmeta m 
        ON p.ID = m.post_id 
        WHERE m.meta_key = '_csv2post_flagged'
        ORDER BY p.post_date DESC;
    ");  

    if(!$pageposts || !is_array($pageposts) || count($pageposts) == 0){
        echo wtgcore_notice('You do not have any flagged posts','info','Small','','','return');
    }else{ ?>
        
        <table class="widefat post fixed">
            <tr><td width="50"><strong>Delete</strong></td><td><strong>Flag</strong></td></tr>
            <?php 
            if ($pageposts){
                global $post;
                
                foreach ($pageposts as $post){ 

                    setup_postdata($post);

                    $flag = maybe_unserialize($post->meta_value);

                    // decide type
                    $type = 'info';
                    if($flag['priority'] == 3){
                        $type = 'error';
                    }elseif($flag['priority'] == 2){
                        $type = 'warning';
                    }elseif($flag['priority'] == 1){ 
                        $type = 'info';
                    }
                    
                    // build message
                    $message = $post->post_title .' @ ' . date('Y-m-d H:i:s',$flag['time']) . ' 
                    <p><strong>Reason:</strong> '.$flag['reason'].'</p>';

                    // build admin url 
                    $admin_url = get_admin_url() . 'post.php?post='.$post->ID.'&action=edit';
                    
                    echo '<tr><td><input type="checkbox" name="csv2post_delete_flag[]" id="csv2post_delete_flag" value="'.$post->meta_id.'" class="csv2post_tagexclusioncheckboxes" /></td><td>';
                    
                    echo wtgcore_notice($message,$type,'Small','',$admin_url,'return');
                    
                    echo '</td></tr>';
                }
            }?>
        </table>

    <?php
    }// end if $pageposts
    
    // add the javascript that will handle our form action, prevent submission and display dialogue box
    csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);

    // add end of form - dialogue box does not need to be within the <form>
    csv2post_formend_standard('Delete Flags',$jsform_set['form_id']);?>

    <?php csv2post_jquery_form_prompt($jsform_set);?>
        
<?php csv2post_panel_footer();?> 