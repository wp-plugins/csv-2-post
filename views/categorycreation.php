<?php
/**
 * Category Creation [page]   
 *
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne   
 * @since 8.1.3
 */

// Prohibit direct script loading
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * View class for Beta Testing [page] 
 * 
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne
 * @since 8.1.3
 */
class CSV2POST_Categorycreation_View extends CSV2POST_View {

    /**
     * Number of screen columns for post boxes on this screen
     *
     * @since 8.1.3
     *
     * @var int
     */
    protected $screen_columns = 2;
    
    protected $view_name = 'categorycreation';
    
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
        $this->Class_Categories = CSV2POST::load_class( 'C2P_Categories', 'class-categories.php', 'classes' );
        $this->PHP = CSV2POST::load_class( 'C2P_PHP', 'class-phplibrary.php', 'classes' );
                        
        // load the current project row and settings from that row
        if( isset( $c2p_settings['currentproject'] ) && $c2p_settings['currentproject'] !== false ) {
            
            $this->project_object = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );
            $this->current_project_settings = maybe_unserialize( $this->project_object->projectsettings );
        
            parent::setup( $action, $data );
            
            $this->add_meta_box( $this->view_name . '-categorycreation', __( 'Category Creation', 'csv2post' ), array( $this, 'parent' ), 'side','default',array( 'formid' => 'categorycreation' ) );      
            $this->add_meta_box( $this->view_name . '-uncategorisedpoststable', __( 'Uncategorised Posts Table', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'uncategorisedpoststable' ) );      
        
        } else {
            $this->add_meta_box( $this->view_name . '-nocurrentproject', __( 'No Current Project', 'csv2post' ), array( $this->UI, 'metabox_nocurrentproject' ), 'normal','default',array( 'formid' => 'nocurrentproject' ) );      
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
    * post box function for category creation
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_categorycreation_categorycreation( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']); 
        $this->UI->postbox_content_footer();
    }    
 
    /**
    * displays a table of the posts that are in the uncategorised category and 
    * were created by CSV 2 POST. This allows the user to investigate why they are
    * not categorised.  
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_categorycreation_uncategorisedpoststable( $data, $box ) {    
        global $c2p_settings, $wpdb;
        
        // load uncategorised posts table class
        //$table = CSV2POST::load_class( 'CSV2POST_UncatPosts_Table', 'class-uncategorisedpoststable.php', 'classes' );
               
        // first query all posts in categorised that have the c2p_projects meta
        $args = array(
            'category'         => '1',
            'order'            => 'DESC',
            'meta_key'         => 'c2p_project',
            'meta_value'       => $c2p_settings['currentproject'],
            'post_type'        => 'post',
            'post_status'      => 'any' );       
        $uncatposts = get_posts( $args );
        
        // build array for table, involves getting each posts imported row to display category terms from the data
        $items_array = array();
        foreach( $uncatposts as $key => $post_array ){
            $items_array[ $key ]['ID'] = $post_array->ID;
            $items_array[ $key ]['post_title'] = $post_array->post_title;
            $items_array[ $key ]['c2p_project'] = $post_array->c2p_project;
            $items_array[ $key ]['level_one'] = '';
            $items_array[ $key ]['level_two'] = '';
            $items_array[ $key ]['level_three'] = '';
            $items_array[ $key ]['level_four'] = '';
            $items_array[ $key ]['level_five'] = '';
        }

        $SourcesTable = new CSV2POST_UncatPosts_Table();
        $SourcesTable->prepare_items_further( $items_array,10);
        ?>

        <form id="movies-filter" method="get">
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <?php $SourcesTable->display() ?>
        </form>
        
        <?php 
    }    
}?>