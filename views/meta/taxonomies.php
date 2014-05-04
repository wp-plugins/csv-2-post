<?php
/** 
 * taxonomy view
 * 
 * @link by http://www.webtechglobal.co.uk
 * 
 * @author Ryan Bayne 
 *
 * @package CSV 2 POST
 */       
 
global $wpdb,$C2P_UI,$C2P_WP,$C2P_DB,$c2p_settings,$c2p_mpt_arr,$c2p_tab_number,$c2p_page_name;

if(!isset($c2p_settings['currentproject']) || !is_numeric($c2p_settings['currentproject'])){
    echo "<p class=\"csv2post_boxes_introtext\">". __('You have not created a project or somehow a Current Project has not been set.') ."</p>";
    return;
}

$project_array = $C2P_WP->get_project($c2p_settings['currentproject']);      
$projectsettings = maybe_unserialize($project_array->projectsettings);
?>


<div class="csv2post_boxes_threethirds">

    <?php $myforms_title = __('Single Taxonomies');?>
    <?php $myforms_name = 'singletaxonomies';?>
    
    <div class="csv2post_boxes_content">
        <?php $C2P_UI->panel_header($myforms_title,$myforms_name,false,'T_UEYDtiId0',false,__('None hierarchical taxonomy options. Data selected here will not work like categories do.'));?>
        <form method="post" name="<?php echo $myforms_name;?>" action="<?php $C2P_UI->form_action(); ?>">
            <?php $C2P_WP->hidden_form_values($myforms_name,$myforms_title);?>
           
            <table class="form-table">
            <?php 
            $excluded_post_types = array('nav_menu_item');
            
            // create and ID for form objects to relate
            $groupdid = 0;
                            
            // loop through all post types in blog
            $post_types = get_post_types('','names');
            foreach ($post_types as $key => $post_type ){
                if(in_array($post_type,$excluded_post_types)){continue;}
  
                // get and loop through the post types taxonomies
                $object_tax = get_object_taxonomies( $post_type,'objects' );
                foreach ( $object_tax as $tax_name => $tax ) {
                    // we are only working with none hierarachical taxonomies on this panel 
                    if(!isset($object_tax[$tax_name]->hierarchical) || isset($object_tax[$tax_name]->hierarchical) && $object_tax[$tax_name]->hierarchical == false){                   
                        
                        // id and acts as couner                     
                        ++$groupdid;
                                    
                        $project_columns_array = $C2P_WP->get_project_columns_from_db($c2p_settings['currentproject'],true);
                        unset($project_columns_array['arrayinfo']);
                        ?>         
                        <tr valign="top">
                            <th scope="row">
                                <input type="text" name="taxonomy<?php echo $groupdid;?>" id="taxonomy<?php echo $groupdid;?>" value="<?php echo $post_type.'.'.$tax_name;?>" title="<?php echo "Taxonomy ".$object_tax[$tax_name]->label." for $post_type";?> " class="csv2post_inputtext" readonly="readonly">
                            </th> 
                            <td>
                                <select name="column<?php echo $groupdid;?>" id="column<?php echo $groupdid;?>">
                                    <option value="notselected">Not Required</option>
                                    <?php 
                                    foreach($project_columns_array as $table_name => $columns_array){

                                        foreach($columns_array as $key => $acolumn){
                                         
                                            $selected = '';
                                            if(isset($projectsettings['taxonomies']['columns'][$post_type][$tax_name]['table']) && isset($projectsettings['taxonomies']['columns'][$post_type][$tax_name]['column'])){
                                                if($table_name == $projectsettings['taxonomies']['columns'][$post_type][$tax_name]['table'] && $acolumn == $projectsettings['taxonomies']['columns'][$post_type][$tax_name]['column']){
                                                    $selected = 'selected="selected"';
                                                }        
                                            }
    
                                            $label = $table_name . ' - '. $acolumn;

                                            echo '<option value="'.$table_name . '#' . $acolumn.'"'.$selected.'>'.$label.'</option>';    
                                        }  
                                    }
                                    ?>
                                    
                                </select> 
                                 
                            </td>
                        </tr>
                        
                        <?php
                    }
                }    
            } 
            ?>
            </table>
            <input type="hidden" name="numberoftaxonomies" value="<?php echo $groupdid;?>" />
            <input class="button" type="submit" value="Submit" />
        
        </form>                    
    </div>      
</div>