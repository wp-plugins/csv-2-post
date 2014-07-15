<?php
/**
 * Taxonomies [page]   
 *
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne   
 * @since 8.1.3
 */

// Prohibit direct script loading
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * Taxonomies [page] 
 * 
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne
 * @since 8.1.3
 */
class CSV2POST_Taxonomies_View extends CSV2POST_View {

    /**
     * Number of screen columns for post boxes on this screen
     *
     * @since 8.1.3
     *
     * @var int
     */
    protected $screen_columns = 2;
    
    protected $view_name = 'taxonomies';
    
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
        
        $this->add_meta_box( 'taxonomies-singletaxonomies', __( 'Single Taxonomies', 'csv2post' ), array( $this, 'postbox_taxonomies_singletaxonomies' ), 'normal','default',array( 'formid' => 'singletaxonomies' ) );      
   }
 
    /**
    * post box function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_taxonomies_singletaxonomies( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        
        global $c2p_settings;
        ?>  
        
            <table class="form-table">
            <?php 
            $excluded_post_types = array( 'nav_menu_item' );
            
            // create and ID for form objects to relate
            $groupdid = 0;
                            
            // loop through all post types in blog
            $post_types = get_post_types( '', 'names' );
            foreach ( $post_types as $key => $post_type ){
                if(in_array( $post_type, $excluded_post_types) ){continue;}
  
                // get and loop through the post types taxonomies
                $object_tax = get_object_taxonomies( $post_type, 'objects' );
                foreach ( $object_tax as $tax_name => $tax ) {
                    // we are only working with none hierarachical taxonomies on this panel 
                    if(!isset( $object_tax[$tax_name]->hierarchical) || isset( $object_tax[$tax_name]->hierarchical) && $object_tax[$tax_name]->hierarchical == false ){                   
                        
                        // id and acts as couner                     
                        ++$groupdid;
                                    
                        $project_columns_array = $this->CSV2POST->get_project_columns_from_db( $c2p_settings['currentproject'], true);
                        unset( $project_columns_array['arrayinfo'] );
                        ?>         
                        <tr valign="top">
                            <th scope="row">
                                <input type="text" name="taxonomy<?php echo $groupdid;?>" id="taxonomy<?php echo $groupdid;?>" value="<?php echo $post_type.'.'.$tax_name;?>" title="<?php echo "Taxonomy ".$object_tax[$tax_name]->label." for $post_type";?> " class="csv2post_inputtext" readonly="readonly">
                            </th> 
                            <td>
                                <select name="column<?php echo $groupdid;?>" id="column<?php echo $groupdid;?>">
                                    <option value="notselected">Not Required</option>
                                    <?php 
                                    foreach( $project_columns_array as $table_name => $columns_array ){

                                        foreach( $columns_array as $key => $acolumn){
                                         
                                            $selected = '';
                                            if( isset( $projectsettings['taxonomies']['columns'][$post_type][$tax_name]['table'] ) && isset( $projectsettings['taxonomies']['columns'][$post_type][$tax_name]['column'] ) ){
                                                if( $table_name == $projectsettings['taxonomies']['columns'][$post_type][$tax_name]['table'] && $acolumn == $projectsettings['taxonomies']['columns'][$post_type][$tax_name]['column'] ){
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
            
        <?php 
        $this->UI->postbox_content_footer();
    }
    
}?>