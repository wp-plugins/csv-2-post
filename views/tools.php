<?php
/**
 * Post Creation Tools [page]   
 *
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne   
 * @since 8.1.3
 */

// Prohibit direct script loading
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * Post Creation Tools [page] 
 * 
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne
 * @since 8.1.3
 */
class CSV2POST_Tools_View extends CSV2POST_View {

    /**
     * Number of screen columns for post boxes on this screen
     *
     * @since 8.1.3
     *
     * @var int
     */
    protected $screen_columns = 2;
    
    protected $view_name = 'tools';
    
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
            
            $this->add_meta_box( 'tools-createpostsbasic', __( 'Create Posts', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'createpostsbasic' ) );      
            $this->add_meta_box( 'tools-updatespecificpost', __( 'Update Specific Post', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'updatespecificpost' ) );      
            $this->add_meta_box( 'tools-queryduplicateposts', __( 'Delete Duplicate Posts', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'queryduplicateposts' ) );      
            $this->add_meta_box( 'tools-undoprojectposts', __( 'Undo Projects Posts', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'undoprojectposts' ) );      
            $this->add_meta_box( 'tools-resetimportedrows', __( 'Reset Imported Rows', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'resetimportedrows' ) );      
       
       } else {
            $this->add_meta_box( 'tools-nocurrentproject', __( 'No Current Project', 'csv2post' ), array( $this->UI, 'metabox_nocurrentproject' ), 'normal','default',array( 'formid' => 'nocurrentproject' ) );      
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
    * post box function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_tools_createpostsbasic( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        ?>  

            <table class="form-table">
            <?php $this->UI->option_text( __( 'Total Posts' ), 'totalposts', 'totalposts', '1' )?>
            </table>
        
        <?php 
        $this->UI->postbox_content_footer();
    } 
        
    /**
    * post box function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_tools_updatespecificpost( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        ?>  

            <table class="form-table">
            <?php $this->UI->option_text( __( 'Post ID' ), 'updatespecificpostid', 'updatespecificpostid', '1' )?>
            </table>
        
        <?php 
        $this->UI->postbox_content_footer();
    }   
     
    /**
    * post box function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_tools_queryduplicateposts( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        ?>  

            <table class="form-table">
            
            <tr valign="top">
                <th scope="row">Force Delete (do not use trash)</th>
                <td><?php $this->UI->option_checkbox_single( 'forcedelete', 'Yes', 'forcedelete', true);?></td>
            </tr>
            
            <?php $this->UI->option_subline( __( 'By Post Title' ) );?>
            <?php $this->UI->option_text( __( 'Safety Code' ), 'deletetduplicatebytitlecode', 'deletetduplicatebytitlecode',rand(99,9999), true);?>
            <?php $this->UI->option_text( __( 'Confirm Code' ), 'deletetduplicatebytitleconfirm', 'deletetduplicatebytitleconfirm', '' );?>            
            
            <?php $this->UI->option_subline( __( 'By Times Row Used (enforce one post per imported row)' ) );?>
            <?php $this->UI->option_text( __( 'Safety Code' ), 'deleteduplicatepostssafetycode', 'deleteduplicatepostssafetycode',rand(99,9999), true);?>
            <?php $this->UI->option_text( __( 'Confirm Code' ), 'safetycodeconfirmed', 'safetycodeconfirmed', '' );?>
            
            </table>
        
        <?php 
        $this->UI->postbox_content_footer();
    }      
    
    /**
    * post box function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_tools_undoprojectposts( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        ?>  

            <table class="form-table">
            <tr valign="top">
                <th scope="row">Force Delete (do not use trash)</th>
                <td><?php $this->UI->option_checkbox_single( 'forcedelete', 'Yes', 'forcedelete', true);?></td>
            </tr>            
            <?php $this->UI->option_text( __( 'Limit' ), 'undopostslimit', 'undopostslimit',30, true);?>
            <?php $this->UI->option_text( __( 'Safety Code' ), 'undoallpostssafecode', 'undoallpostssafecode',rand(9999,99999), true);?>
            <?php $this->UI->option_text_simple( __( 'Confirm Code' ), 'undoallpostsconfirm', '', __( 'Please enter the random number shown above this field.' ) );?>
            </table>
        
        <?php 
        $this->UI->postbox_content_footer();
    }    
    
    /**
    * post box function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_tools_resetimportedrows( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']); 
        $this->UI->postbox_content_footer();
    }  
}?>