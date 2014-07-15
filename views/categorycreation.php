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
        $this->project_object = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );
        $this->current_project_settings = maybe_unserialize( $this->project_object->projectsettings );
                
        parent::setup( $action, $data );
        
        $this->add_meta_box( 'categories-categorycreation', __( 'Category Creation', 'csv2post' ), array( $this, 'postbox_categories_categorycreation' ), 'side','default',array( 'formid' => 'categorycreation' ) );      
        $this->add_meta_box( 'categories-setpostscategories', __( 'Set Posts Categories', 'csv2post' ), array( $this, 'postbox_categories_setpostscategories' ), 'side','default',array( 'formid' => 'setpostscategories' ) );      
        $this->add_meta_box( 'categories-resetpostscategories', __( 'Re-Set Posts Categories', 'csv2post' ), array( $this, 'postbox_categories_resetpostscategories' ), 'side','default',array( 'formid' => 'resetpostscategories' ) );      
        $this->add_meta_box( 'categories-uncategorisedpoststable', __( 'Uncategorised Posts Table', 'csv2post' ), array( $this, 'postbox_categories_uncategorisedpoststable' ), 'normal','default',array( 'formid' => 'uncategorisedpoststable' ) );      

    }
 
    /**
    * post box function for category creation
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_categories_categorycreation( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']); 
        $this->UI->postbox_content_footer();
    }    
    
    /**
    * post box function for category updating
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_categories_setpostscategories( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']); 
        $this->UI->postbox_content_footer();
    }
        
    /**
    * post box function for resetting post categories by removing the relationship
    * and putting all posts into Uncategorized
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_categories_resetpostscategories( $data, $box ) {    
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
    public function postbox_categories_uncategorisedpoststable( $data, $box ) {    
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
        $SourcesTable->prepare_items( $items_array,10);
        ?>

        <form id="movies-filter" method="get">
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <?php $SourcesTable->display() ?>
        </form>
        
        <?php 
    }    
}?>