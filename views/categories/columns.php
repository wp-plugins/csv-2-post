<?php
/** 
 * category column selection view
 * 
 * include configuration of category description and mapping 
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

<div class="csv2post_boxes_twohalfs">

    <?php $myforms_title = __('Category Data');?>
    <?php $myforms_name = 'categorydata';?>
    
    <div class="csv2post_boxes_content">
        <?php $C2P_UI->panel_header($myforms_title,$myforms_name,false,'QjuOcNU6ICA',0,__('All columns must be in the same table.'));?>
        <form method="post" name="<?php echo $myforms_name;?>" action="<?php $C2P_UI->form_action(); ?>">
            <?php $C2P_WP->hidden_form_values($myforms_name,$myforms_title);?>
           
            <table class="form-table">
            <?php
            for($i=0;$i<=2;$i++){
                $default_table = false;
                $default_column = false;
                if(isset($projectsettings['categories']['data'][$i])){
                    $default_table = $projectsettings['categories']['data'][$i]['table'];
                    $default_column = $projectsettings['categories']['data'][$i]['column'];                
                }
                $level_label = $i + 1;
                $C2P_UI->option_projectcolumns_categoriesmenu(__("Level $level_label"),$c2p_settings['currentproject'],"categorylevel$i","categorylevel$i",$default_table,$default_column,'notselected','Not Selected');
            }
            
            ?>
            </table>
            <input class="button" type="submit" value="Submit" />
        
        </form>                    
    </div>
            
</div>

<?php if(!empty($projectsettings['categories'])){?>
    <div class="csv2post_boxes_twohalfs">

        <?php $myforms_title = __('Category Pairing');?>
        <?php $myforms_name = 'categorypairing';?>
        <div class="csv2post_boxes_content">

            <?php 
            if(!isset($projectsettings['categories']['data'])){
                $C2P_UI->panel_header($myforms_title,$myforms_name,false,'7dQwGDKvw-g',2,'You have not selected your category columns.');    
            }else{
                $C2P_UI->panel_header($myforms_title,$myforms_name,false,'7dQwGDKvw-g',2);?>
                
                <form method="post" name="<?php echo $myforms_name;?>" action="<?php $C2P_UI->form_action(); ?>">
                    <?php $C2P_WP->hidden_form_values($myforms_name,$myforms_title);?>
                   
                    <table class="form-table">
                    <?php
                    foreach($projectsettings['categories']['data'] as $key => $catarray){

                        $column = $catarray['column'];
                        $table = $catarray['table'];
                        $current_category_id = 'nocurrentcategoryid';
                                            
                        $distinct_result = $wpdb->get_results("SELECT DISTINCT $column FROM $table",ARRAY_A);
                        foreach($distinct_result as $key => $value){
                            $distinctval_cleaned = $C2P_WP->clean_string($value[$column]);
                            $nameandid = 'distinct'.$table.$column.$distinctval_cleaned;
                            ?>
                            
                            <tr valign="top">
                                <th scope="row">
                                    <input type="text" name="<?php echo $column .'#'. $table .'#' . $distinctval_cleaned;?>" id="<?php echo $nameandid;?>" value="<?php echo $value[$column];?>" title="<?php echo $column;?>" class="csv2post_inputtext" readonly> 
                                </th>
                                <td>
                                    <select name="existing<?php echo $distinctval_cleaned;?>" id="existing<?php echo $distinctval_cleaned;?>">
                                        
                                        <option value="notselected">Not Required</option> 
                                        <?php $cats = get_categories('hide_empty=0&echo=0&show_option_none=&style=none&title_li=');?>
                                        <?php         
                                        foreach( $cats as $c ){ 
        
                                            $selected = '';
                                            if(isset($projectsettings['categories']['mapping'][$table][$column][ $value[$column] ])){  
                                                $current_category_id = $projectsettings['categories']['mapping'][$table][$column][ $value[$column] ];        
                                                if( $current_category_id === $c->term_id ) {
                                                    $selected = ' selected="selected"';
                                                }                                        
                                            }
                      
                                            echo '<option value="'.$c->term_id.'"'.$selected.'>'. $c->name . ' - ' . $c->term_id . '</option>'; 
                                        }?>
                                                                                                                                                                                     
                                    </select> 
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    </table>
                    <input class="button" type="submit" value="Submit" />
                
                </form>
             <?php }?>                    
        </div>
    </div><?php           
}
?>
