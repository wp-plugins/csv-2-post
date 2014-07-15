<?php
/**
 * Last Post Created [page]   
 *
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne   
 * @since 8.1.3
 */

// Prohibit direct script loading
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * Last Post Created [page] 
 * 
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne
 * @since 8.1.3
 */
class CSV2POST_Lastpost_View extends CSV2POST_View {

    /**
     * Number of screen columns for post boxes on this screen
     *
     * @since 8.1.3
     *
     * @var int
     */
    protected $screen_columns = 2;
    
    protected $view_name = 'lastpost';
    
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
        
        // query the last post
        $result = $this->DB->selectorderby( $this->CSV2POST->get_project_main_table( $c2p_settings['currentproject'] ), 'c2p_postid != 0', 'c2p_applied', 'c2p_postid',1);
        if($result){
            $this->lastpost = get_post( $result[0]->c2p_postid);
            $this->add_meta_box( 'lastpost-generalpostsettings', __( 'General', 'csv2post' ), array( $this, 'postbox_lastpost_generalpostsettings' ), 'side','default',array( 'formid' => 'generalpostsettings' ) );      
            $this->add_meta_box( 'lastpost-lastpostcontent', __( 'Content', 'csv2post' ), array( $this, 'postbox_lastpost_lastpostcontent' ), 'normal','default',array( 'formid' => 'lastpostcontent' ) );      
        }else{
            $this->add_meta_box( 'lastpost-nopostscreated', __( 'No Posts Created', 'csv2post' ), array( $this, 'postbox_lastpost_nopostscreated' ), 'normal','default',array( 'formid' => 'nopostscreated' ) );      
        }

        parent::setup( $action, $data );
        
   }
 
    /**
    * post box function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_lastpost_generalpostsettings( $data, $box ) {    
        echo '<ul>';
        echo '<li>Post ID: '        . $this->lastpost->ID . '</li>';
        echo '<li>Post Author: '    . $this->lastpost->post_author . '</li>';
        echo '<li>Post Date: '      . $this->lastpost->post_date . '</li>';
        echo '<li>Post Date GMT: '  . $this->lastpost->post_date_gmt . '</li>';
        echo '<li>Post Title: '     . $this->lastpost->post_title . '</li>';
        echo '<li>Post Excerpt: '   . $this->lastpost->post_excerpt . '</li>';
        echo '<li>Post Status: '    . $this->lastpost->post_status . '</li>';
        echo '<li>Comment Status: ' . $this->lastpost->comment_status . '</li>';
        echo '<li>Ping Status: '    . $this->lastpost->ping_status . '</li>';
        echo '<li>Post Password: '  . $this->lastpost->post_password . '</li>';
        echo '<li>Post Name: '      . $this->lastpost->post_name . '</li>';
        echo '<li>Post Parent: '    . $this->lastpost->post_parent . '</li>';
        echo '<li>Post Type: '      . $this->lastpost->post_type . '</li>';
        echo '<li>Comment Count: '  . $this->lastpost->comment_count . '</li>';
        echo '</ul>'; 
    }
  
    /**
    * post box function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_lastpost_lastpostcontent( $data, $box ) {    
        echo $this->lastpost->post_content;
    }     
    
    /**
    * post box function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_lastpost_nopostscreated( $data, $box ) {    
        echo '<p>' . __( 'Your current project has not been used to create any posts. When you create your first post using the current project. This box will be hidden and others will appear.', 'csv2post' ) . '</p>';
    }         
    
}?>