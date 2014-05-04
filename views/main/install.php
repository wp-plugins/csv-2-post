<?php
/** 
 * Installation tab view for CSV 2 POST plugin 
 * 
 * @link by http://www.webtechglobal.co.uk
 * 
 * @author Ryan Bayne 
 *
 * @package CSV 2 POST
 */
 
global $C2P_WP,$C2P_UI;
?>

<!-- Box Start -->
<div class="csv2post_boxes_unlimitedcolumns">
    <!-- Panel Start -->
    <?php $myforms_title = __('Partial Un-Install');?>
    <?php $myforms_name = 'partialuninstall';?>
    <div class="csv2post_boxes_content">
        <?php $C2P_UI->panel_header($myforms_title,$myforms_name,false,false,false,__('Remove individual option records, tables and files...'));?>

        <form method="post" name="partialuninstall" action="<?php $C2P_UI->form_action(); ?>">
            
            <?php $C2P_WP->hidden_form_values('partialuninstall',__('Partial Uninstallation','csv2post'));?>
            
            <h4><?php _e('Core Plugin Tables','csv2post'); ?></h4>
            <?php $C2P_WP->list_plugintables();?>
                   
            <h4><?php _e('Folders','csv2post'); ?></h4>
            <?php $C2P_WP->list_folders();?>
                                                    
            <h4><?php _e('Option Records','csv2post'); ?></h4>
            <?php $C2P_WP->list_optionrecordtrace(true,'Tiny'); ?>                    
            
            <input class="button" type="submit" value="Submit" />
        </form>                 
                                                                      
    </div> 
    <!-- Panel End -->
</div>
<!-- Box End -->

<!-- Box Start -->
<div class="csv2post_boxes_unlimitedcolumns">

    <?php $myforms_title = __('Re-Install Database Tables');?>
    <?php $myforms_name = 'reinstalldatabasetables';?>
    <div class="csv2post_boxes_content">
        <?php $C2P_UI->panel_header($myforms_title,$myforms_name,false,false,false,__('Use with care, will delete all existing tables for this plugin...'));?>

        <form method="post" name="reinstalldatabasetables" action="<?php $C2P_UI->form_action(); ?>">
            
            <?php $C2P_WP->hidden_form_values('reinstalldatabasetables',__('Re-Install Database Tables','csv2post'));?>
            
            <?php 
            global $c2p_tables_array;
            if(is_array($c2p_tables_array)){
                
                echo '<h2>'. __('Tables Already Installed','csv2post') .'</h2>';  
                        
                $C2P_WP->tablestart();
                
                echo '
                <thead>
                    <tr>
                        <th>'. __('Table Names','csv2post') .'</th>
                        <th>'. __('Rows','csv2post') .'</th>
                    </tr>
                </thead>';

                echo '
                <tfoot>
                    <tr>
                        <th>'. __('Table Names','csv2post') .'</th>
                        <th>'. __('Rows','csv2post') .'</th>
                    </tr>
                </tfoot>';
                
                echo '<tbody>';
                       
                foreach($c2p_tables_array['tables'] as $key => $table){
                    if($C2P_WP->does_table_exist($table['name'])){         
                        echo '<tr><td>'.$table['name'].'</td><td>'.$C2P_WP->countrecords($table['name']).'</td></tr>';
                    }                                                             
                }
                                       
                echo '</tbody></table>';
                
                echo '<br /><br />';
                
                echo '<h2>'. __('Tables Not Installed','csv2post') .'</h2>';

                $C2P_WP->tablestart();
                
                echo '
                <thead>
                    <tr>
                        <th>'. __('Table Names','csv2post') .'</th>
                        <th>'. __('Required','csv2post') .'</th>
                    </tr>
                </thead>';
          
                echo '
                <tfoot>
                    <tr>
                        <th>'. __('Table Names','csv2post') .'</th>
                        <th>'. __('Required','csv2post') .'</th>
                    </tr>
                </tfoot>';
                  
                foreach($c2p_tables_array['tables'] as $key => $table){
                    if(!$C2P_WP->does_table_exist($table['name'])){         
                        echo '<tr><td>'.$table['name'].'</td><td>'.$table['required'].'</td></tr>';
                    }                                                             
                }
                                       
                echo '</tbody></table>';               
            }?>  
            
            <input class="button" type="submit" value="Submit" />   
        </form>
                                                                                      
    </div>
    <!-- Panel End -->
      
</div>
<!-- Box End -->

<!-- Box Start -->
<div class="csv2post_boxes_unlimitedcolumns">

    <?php $myforms_title = __('Install Test Data');?>
    <?php $myforms_name = 'installtestdata';?>
    <div class="csv2post_boxes_content">
        <?php $C2P_UI->panel_header($myforms_title,$myforms_name,false,false,false,__('Install test data on test blogs only.'));?>

        <form method="post" name="partialuninstall" action="<?php $C2P_UI->form_action(); ?>">
            
            <?php $C2P_WP->hidden_form_values('installtestdata',__('Install Test Data','csv2post'));?>                  
            
            <input class="button" type="submit" value="Submit" />
        </form>                 
                                                                      
    </div>
 
    <!-- Panel End -->
</div>
<!-- Box End -->
       
<!-- Box Start --> 
<div class="csv2post_boxes_unlimitedcolumns">

    <?php $myforms_title = __('Plugin Configuration');?>
    <?php $myforms_name = 'pluginconfiguration';?>
    <div class="csv2post_boxes_content">
        <?php $C2P_UI->panel_header($myforms_title,$myforms_name,false,false,false,__('Values that tell us about the current package/build and the installation.'));?>

        <h3><?php _e('Package Values','csv2post'); ?></h3>
        <ul>
            <li><strong><?php _e('Plugin Version','csv2post'); ?>:</strong> <?php echo $c2p_currentversion;?></li>               
            <li><strong>WTG_CSV2POST_NAME:</strong> <?php echo WTG_CSV2POST_NAME;?></li>
            <li><strong>WTG_CSV2POST_PHPVERSIONMINIMUM:</strong> <?php echo WTG_CSV2POST_PHPVERSIONMINIMUM;?></li>
        </ul> 
        
        <?php global $c2p_debug_mode,$c2p_is_dev,$c2p_isbeingactivated,$c2p_is_event,$c2p_installation_required,$c2p_extension_loaded;?>
            
        <h3>Variables</h3>   
        <ul>    
            <li><strong><?php _e('Debug Mode','csv2post'); ?>:</strong> <?php echo $c2p_debug_mode;?></li>                                                             
            <li><strong><?php _e('Developer Mode','csv2post'); ?>:</strong> <?php echo $c2p_is_dev;?></li>          
            <li><strong><?php _e('Is Event','csv2post'); ?>:</strong> <?php echo $c2p_is_event;?></li>
            <li><strong><?php _e('Installation Drive','csv2post'); ?>:</strong> <?php echo $c2p_installation_required;?></li>
            <li><strong><?php _e('Is Installed','csv2post'); ?>:</strong> <?php echo $c2p_is_installed;?></li>                                                      
            <li><strong><?php _e('Extension Loaded:','csv2post'); ?></strong> <?php echo $c2p_extension_loaded;?></li>
        </ul>  
        
        <h2>File Paths</h2>
        <ul> 
            <li><strong>WTG_CSV2POST_PATH</strong> <?php echo WTG_CSV2POST_PATH;?></li>                
        <ul> 
                                                                                      
    </div>

    <!-- Panel End --> 
</div>
<!-- Box End -->
    
<div class="csv2post_boxes_unlimitedcolumns">

    <?php $myforms_title = __('Environment Settings');?>
    <?php $myforms_name = 'environmentsettings';?>
    <div class="csv2post_boxes_content">
        <?php $C2P_UI->panel_header($myforms_title,$myforms_name,false,false,false,__('Server configuration including PHP, MySQL and modules...'));?>

        <ul>
            <li><strong>PHP Version:</strong> <?php echo phpversion();?></li>
            <li><strong>MySQL Version:</strong> <?php echo $C2P_WP->mysqlversion();?></li>                          
            <li><strong>HTTP_HOST:</strong> <?php echo $_SERVER['HTTP_HOST'];?></li>
            <li><strong>SERVER_NAME:</strong> <?php echo $_SERVER['SERVER_NAME'];?></li>           
        </ul>
                 
        <hr>
        
        <h2><?php _e('Common Functions (returned value)','csv2post'); ?></h2>
        <ul>
            <li><strong>time():</strong> <?php echo time();?></li>
            <li><strong>date('Y-m-d H:i:s'):</strong> <?php echo date('Y-m-d H:i:s');?></li>
            <li><strong>date('e'):</strong> <?php echo date('e');?> (timezone identifier)</li>
            <li><strong>date('G'):</strong> <?php echo date('G');?> (24-hour format)</li>
            <li><strong>get_admin_url():</strong> <?php echo get_admin_url();?></li>                 
        </ul>                
                                                                                      
    </div>
  
</div>
 
<div class="csv2post_boxes_unlimitedcolumns">

    <?php $myforms_title = __('Wordpress Configuration');?>
    <?php $myforms_name = 'wordpressconfiguration';?>
    <div class="csv2post_boxes_content">
        <?php $C2P_UI->panel_header($myforms_title,$myforms_name,false,false,false,__('Wordpress settings which effect how this plugin operates...'));?>

        <ul>
            <li><strong><?php _e('Wordpress Database Charset:','csv2post'); ?></strong> <?php echo DB_CHARSET; ?></li>
            <li><strong><?php _e('Wordpress Blog Charset:','csv2post'); ?></strong> <?php echo get_option('blog_charset'); ?></li>
            <li><strong>WP_MEMORY_LIMIT:</strong> <?php echo WP_MEMORY_LIMIT;?></li>            
            <li><strong>WP_POST_REVISIONS:</strong> <?php echo WP_POST_REVISIONS;?></li>                                    
        </ul>                 
                                                                                      
    </div>

</div>