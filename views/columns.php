<?php
/**
 * Category Columns [page]   
 *
 * Columns with category terms are selected on this page
 * 
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne   
 * @since 8.1.3
 */

// Prohibit direct script loading
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * Category column selection [class] 
 * 
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne
 * @since 8.1.3
 */
class CSV2POST_Columns_View extends CSV2POST_View {

    /**
     * Number of screen columns for post boxes on this screen
     *
     * @since 8.1.3
     *
     * @var int
     */
    protected $screen_columns = 2;
    
    protected $view_name = 'columns';
    
    /**
     * Set up the view with data and do things that are specific for this view
     *
     * @since 8.1.3
     *
     * @param string $action Action for this view
     * @param array $data Data for this view
     */
    public function setup( $action, array $data ) {
        global $c2p_settings;

        // create constant for view name
        if(!defined( "WTG_CSV2POST_VIEWNAME") ){define( "WTG_CSV2POST_VIEWNAME", $this->view_name );}
        
        // create class objects
        $this->CSV2POST = CSV2POST::load_class( 'CSV2POST', 'class-csv2post.php', 'classes' );
        $this->UI = CSV2POST::load_class( 'C2P_UI', 'class-ui.php', 'classes' );
        $this->DB = CSV2POST::load_class( 'C2P_DB', 'class-wpdb.php', 'classes' );
        $this->PHP = CSV2POST::load_class( 'C2P_PHP', 'class-phplibrary.php', 'classes' );
                        
        // load the current project row and settings from that row
        $this->project_object = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );
        $this->current_project_settings = maybe_unserialize( $this->project_object->projectsettings );
                        
        parent::setup( $action, $data );
        
        $this->add_meta_box( 'categories-categorydata', __( 'Category Data', 'csv2post' ), array( $this, 'postbox_categories_categorydata' ), 'side','default',array( 'formid' => 'categorydata' ) );        
        $this->add_meta_box( 'categories-categorydescriptions', __( 'Category Descriptions', 'csv2post' ), array( $this, 'postbox_categories_categorydescriptions' ), 'normal','default',array( 'formid' => 'categorydescriptions' ) );      
        
        if(!empty( $this->projectsettings['categories'] ) ){
            $this->add_meta_box( 'categories-presetlevelonecategory', __( 'Pre-Set Level One Category', 'csv2post' ), array( $this, 'postbox_categories_presetlevelonecategory' ), 'normal','default',array( 'formid' => 'presetlevelonecategory' ) );      
            $this->add_meta_box( 'categories-categorypairing', __( 'Category Mapping/Pairing', 'csv2post' ), array( $this, 'postbox_categories_categorypairing' ), 'normal','default',array( 'formid' => 'categorypairing' ) );      
        }
    }
 
    /**
    * post box function for category column selection
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_categories_categorydata( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        
        global $c2p_settings;
        ?>  

            <table class="form-table">
            <?php
            for( $i=0;$i<=4;$i++){
                $default_table = false;
                $default_column = false;
                if( isset( $this->projectsettings['categories']['data'][$i] ) ){
                    $default_table = $this->projectsettings['categories']['data'][$i]['table'];
                    $default_column = $this->projectsettings['categories']['data'][$i]['column'];                
                }
                $level_label = $i + 1;
                $this->UI->option_projectcolumns_categoriesmenu( __( "Level $level_label"), $c2p_settings['currentproject'], "categorylevel$i", "categorylevel$i", $default_table, $default_column, 'notselected', 'Not Selected' );
            }
            
            ?>
            </table>
        
        <?php 
        $this->UI->postbox_content_footer();
    }    
    
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_categories_categorydescriptions( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);     
        
        global $c2p_settings;

        if(empty( $this->projectsettings['categories']['data'] ) ){
            echo 'Please select category data columns.';    
        }else{ 
        ?>

            <table class="form-table">
            <?php
            foreach( $this->projectsettings['categories']['data'] as $key => $catarray ){
           
                // use description data
                $default_table = false;
                $default_column = false;
                if( isset( $this->projectsettings['categories']['data'][$key] ) ){
                    $default_table = $this->projectsettings['categories']['descriptiondata'][$key]['table'];
                    $default_column = $this->projectsettings['categories']['descriptiondata'][$key]['column'];                
                }
                $level_label = $key + 1;
                $this->UI->option_projectcolumns_categoriesmenu( __( "Level $level_label"), $c2p_settings['currentproject'], "categorylevel$key", "categorylevel$key", $default_table, $default_column, 'notselected', 'Not Selected' );
     
                // or create a template
                $current_value = '';
                if( isset( $this->projectsettings['categories']['descriptiontemplates'][$key] ) ){$current_value = $this->projectsettings['categories']['descriptiontemplates'][$key];} 
                $level_label = $key + 1;
                $this->UI->option_textarea( "Level $level_label Description", 'level'.$key.'description', 'level'.$key.'description',10,30, $current_value); 
            }
            ?>
            </table>
        
        <?php }?>
        
        <?php 
        $this->UI->postbox_content_footer();
    }    
    
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_categories_presetlevelonecategory( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        ?>  

            <table class="form-table">
            <?php 
            $presetid = '';
            
            if( isset( $this->projectsettings['categories']['presetcategoryid'] ) ){
                $presetid = $this->projectsettings['categories']['presetcategoryid'];
            }
            
            $this->UI->option_text_simple( 'Category ID', 'presetcategoryid', $presetid, true);
            ?>
            </table>
        
        <?php 
        $this->UI->postbox_content_footer();
    }

    
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_categories_categorypairing( $data, $box ) {    
        if(!isset( $this->projectsettings['categories']['data'] ) ){
            $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], 'You have not selected your category columns.', false );    
        }else{
            $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false);
            $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
            
            global $wpdb;
            ?>

                <table class="form-table">
                <?php
                foreach( $this->projectsettings['categories']['data'] as $key => $catarray ){

                    $column = $catarray['column'];
                    $table = $catarray['table'];
                    $current_category_id = 'nocurrentcategoryid';
                                        
                    $distinct_result = $wpdb->get_results( "SELECT DISTINCT $column FROM $table",ARRAY_A);
                    foreach( $distinct_result as $key => $value ){
                        $distinctval_cleaned = $this->PHP->clean_string( $value[$column] );
                        $nameandid = 'distinct'.$table.$column.$distinctval_cleaned;
                        ?>
                        
                        <tr valign="top">
                            <th scope="row">
                                <input type="text" name="<?php echo $column .'#'. $table .'#' . $distinctval_cleaned;?>" id="<?php echo $nameandid;?>" value="<?php echo $value[$column];?>" title="<?php echo $column;?>" class="csv2post_inputtext" readonly> 
                            </th>
                            <td>
                                <select name="existing<?php echo $distinctval_cleaned;?>" id="existing<?php echo $distinctval_cleaned;?>">
                                    
                                    <option value="notselected">Not Required</option> 
                                    <?php $cats = get_categories( 'hide_empty=0&echo=0&show_option_none=&style=none&title_li=' );?>
                                    <?php         
                                    foreach( $cats as $c ){ 
    
                                        $selected = '';
                                        if( isset( $this->projectsettings['categories']['mapping'][$table][$column][ $value[$column] ] ) ){  
                                            $current_category_id = $this->projectsettings['categories']['mapping'][$table][$column][ $value[$column] ];        
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

         <?php }?> 
        
        <?php 
        $this->UI->postbox_content_footer();
    }   
}?>