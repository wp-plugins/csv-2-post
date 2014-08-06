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
        if( isset( $c2p_settings['currentproject'] ) && $c2p_settings['currentproject'] !== false ) {
                
            $this->project_object = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );
            $this->current_project_settings = maybe_unserialize( $this->project_object->projectsettings );
                            
            parent::setup( $action, $data );
            
            $this->add_meta_box( 'columns-categorydata', __( 'Category Data', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'categorydata' ) );        

            if(!empty( $this->projectsettings['categories'] ) ){
                $this->add_meta_box( 'columns-presetlevelonecategory', __( 'Pre-Set Level One Category', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'presetlevelonecategory' ) );      
                $this->add_meta_box( 'columns-categorypairing', __( 'Category Mapping/Pairing', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'categorypairing' ) );      
            }
            
        } else {
            $this->add_meta_box( 'columns-nocurrentproject', __( 'No Current Project', 'csv2post' ), array( $this->UI, 'metabox_nocurrentproject' ), 'normal','default',array( 'formid' => 'nocurrentproject' ) );      
        }            
    }
 
    /**
    * All add_meta_box() callback to this function, values in $box are used to then call
    * the intended box to render a unique form or information. 
    * 
    * The purpose of this box is to apply security to all boxes but it could also be used
    * to dynamically call different functions based on arguments
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.32
    * @version 1.0.0
    */
    function parent( $data, $box ) {
        
        // if $box['args']['capability'] is not set with over-riding capability added to add_meta_box() arguments then set it
        if( !isset( $box['args']['capability'] ) || !is_string( $box['args']['capability'] ) ) {
            $box['args']['capability'] = $this->UI->get_boxes_capability( $box['args']['formid'] );
        }
        
        // call method in CSV2POST - this is done because it is harder to put this parent() function there as it includes "self::"
        // any other approach can get messy I think but I'd welcome suggestions on this 
        if( isset( $box['args']['capability'] ) && !current_user_can( $box['args']['capability'] ) ) { 
            echo '<p>' . __( 'You do not have permission to access the controls and information in this box.', 'csv2post' ) . '</p>';
            return false;    
        }        
        
        // call the intended function 
        eval( 'self::postbox_' . $this->view_name . '_' . $box['args']['formid'] . '( $data, $box );' );
    }
    
    /**
    * post box function for category column selection
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_columns_categorydata( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        
        global $c2p_settings;
        ?>  

            <table class="form-table">
            <?php
            for( $i=0;$i<=2;$i++){
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
    public function postbox_columns_presetlevelonecategory( $data, $box ) {    
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
    public function postbox_columns_categorypairing( $data, $box ) {    
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