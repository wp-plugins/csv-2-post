<?php
/**
 * Post Settings [page]   
 *
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne   
 * @since 8.1.3
 */

// Prohibit direct script loading
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * Post Settings [page] 
 * 
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne
 * @since 8.1.3
 */
class CSV2POST_Postsettings_View extends CSV2POST_View {

    /**
     * Number of screen columns for post boxes on this screen
     *
     * @since 8.1.3
     *
     * @var int
     */
    protected $screen_columns = 2;
    
    protected $view_name = 'postsettings';
    
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
        
        $this->add_meta_box( 'postsettings-basicpostoptions', __( 'Common Options', 'csv2post' ), array( $this, 'postbox_postsettings_basicpostoptions' ), 'normal','default',array( 'formid' => 'basicpostoptions' ) );      
        $this->add_meta_box( 'postsettings-databasedoptions', __( 'Options Requiring Data', 'csv2post' ), array( $this, 'postbox_postsettings_databasedoptions' ), 'normal','default',array( 'formid' => 'databasedoptions' ) );
        $this->add_meta_box( 'postsettings-authoroptions', __( 'Author Options', 'csv2post' ), array( $this, 'postbox_postsettings_authoroptions' ), 'normal','default',array( 'formid' => 'authoroptions' ) );
        $this->add_meta_box( 'postsettings-defaulttagrules', __( 'Tag Rules', 'csv2post' ), array( $this, 'postbox_postsettings_defaulttagrules' ), 'normal','default',array( 'formid' => 'defaulttagrules' ) );
    }
 
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_postsettings_basicpostoptions( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        ?>  

            <table class="form-table">  
            <?php
            // status 
            $poststatus = 'nocurrent123';
            if( isset( $this->projectsettings['basicsettings']['poststatus'] ) ){$poststatus = $this->projectsettings['basicsettings']['poststatus'];}
            $this->UI->option_radiogroup( __( 'Post Status', 'csv2post' ), 'poststatus', 'poststatus', array( 'draft' => 'Draft', 'auto-draft' => 'Auto-Draft', 'publish' => 'Publish', 'pending' => 'Pending', 'future' => 'Future', 'private' => 'Private' ), $poststatus, 'publish' );             
            
            // ping status
            $pingstatus = 'nocurrent123';
            if( isset( $this->projectsettings['basicsettings']['pingstatus'] ) ){$pingstatus = $this->projectsettings['basicsettings']['pingstatus'];}
            $this->UI->option_radiogroup( __( 'Ping Status', 'csv2post' ), 'pingstatus', 'pingstatus', array( 'open' => 'Open', 'closed' => 'Closed' ), $pingstatus, 'closed' );
            
            // comment status
            $commentstatus = 'nocurrent123';
            if( isset( $this->projectsettings['basicsettings']['commentstatus'] ) ){$commentstatus = $this->projectsettings['basicsettings']['commentstatus'];}            
            $this->UI->option_radiogroup( __( 'Comment Status' ), 'commentstatus', 'commentstatus', array( 'open' => 'Open', 'closed' => 'Closed' ), $commentstatus, 'open' );
            
            // default author
            $defaultauthor = '';
            if( isset( $this->projectsettings['basicsettings']['defaultauthor'] ) ){$defaultauthor = $this->projectsettings['basicsettings']['defaultauthor'];}
            $this->UI->option_menu_users( __( 'Default Author' ), 'defaultauthor', 'defaultauthor', $defaultauthor);
            
            // default category
            $defaultcategory = '';
            if( isset( $this->projectsettings['basicsettings']['defaultcategory'] ) ){$defaultcategory = $this->projectsettings['basicsettings']['defaultcategory'];}
            $this->UI->option_menu_categories( __( 'Default Category' ), 'defaultcategory', 'defaultcategory', $defaultcategory );

            // default post type
            $defaultposttype = 'nocurrent123';
            if( isset( $this->projectsettings['basicsettings']['defaultposttype'] ) ){$defaultposttype = $this->projectsettings['basicsettings']['defaultposttype'];}            
            $this->UI->option_radiogroup_posttypes( __( 'Default Post Type' ), 'defaultposttype', 'defaultposttype', $defaultposttype);
            
            // default post format
            $defaultpostformat = 'nocurrent123';
            if( isset( $this->projectsettings['basicsettings']['defaultpostformat'] ) ){$defaultpostformat = $this->projectsettings['basicsettings']['defaultpostformat'];}            
            $this->UI->option_radiogroup_postformats( __( 'Default Post Format' ), 'defaultpostformat', 'defaultpostformat', $defaultpostformat);
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
    public function postbox_postsettings_databasedoptions( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        
        global $c2p_settings;
        ?>  

            <table class="form-table">    
            <?php
            // tags (ready made tags data)
            $tags_table = ''; 
            $tags_column = '';
            if( isset( $this->projectsettings['basicsettings']['tags']['table'] ) ){$tags_table = $this->projectsettings['basicsettings']['tags']['table'];}
            if( isset( $this->projectsettings['basicsettings']['tags']['column'] ) ){$tags_column = $this->projectsettings['basicsettings']['tags']['column'];}             
            $this->UI->option_projectcolumns( __( 'Tags' ), $c2p_settings['currentproject'], 'tags', 'tags', $tags_table, $tags_column, 'notrequired', 'Not Required' );
            $this->UI->option_text( __( '' ), 'tagsexample', 'tagsexample', '', true, 'csv2post_inputtext' );
            
            // featured image
            $featuredimage_table = ''; 
            $featuredimage_column = '';
            if( isset( $this->projectsettings['basicsettings']['featuredimage']['table'] ) ){$featuredimage_table = $this->projectsettings['basicsettings']['featuredimage']['table'];}
            if( isset( $this->projectsettings['basicsettings']['featuredimage']['column'] ) ){$featuredimage_column = $this->projectsettings['basicsettings']['featuredimage']['column'];}             
            $this->UI->option_projectcolumns( __( 'Featured Images' ), $c2p_settings['currentproject'], 'featuredimage', 'featuredimage', $featuredimage_table, $featuredimage_column, 'notrequired', 'Not Required' );
            $this->UI->option_text( __( '' ), 'featuredimageexample', 'featuredimageexample', '', true, 'csv2post_inputtext' );

            // permalink
            $permalink_table = ''; 
            $permalink_column = '';
            if( isset( $this->projectsettings['basicsettings']['permalink']['table'] ) ){$permalink_table = $this->projectsettings['basicsettings']['permalink']['table'];}
            if( isset( $this->projectsettings['basicsettings']['permalink']['column'] ) ){$permalink_column = $this->projectsettings['basicsettings']['permalink']['column'];}             
            $this->UI->option_projectcolumns( __( 'Permalink Column' ), $c2p_settings['currentproject'], 'permalink', 'permalink', $permalink_table, $permalink_column, 'notrequired', 'Not Required' );
            $this->UI->option_text( __( '' ), 'permalinkexample', 'permalinkexample', '', true, 'csv2post_inputtext' );
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
    public function postbox_postsettings_authoroptions( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        
        global $c2p_settings;
        ?>  

           <table class="form-table">    
            <?php
            // email (for user creation)
            $email_table = ''; 
            $email_column = '';
            if( isset( $this->projectsettings['authors']['email']['table'] ) ){$urlcloak1_table = $this->projectsettings['authors']['email']['table'];}
            if( isset( $this->projectsettings['authors']['email']['column'] ) ){$urlcloak1_column = $this->projectsettings['authors']['email']['column'];}             
            $this->UI->option_projectcolumns( __( 'Email Address Data' ), $c2p_settings['currentproject'], 'email', 'email', $email_table, $email_column, 'notrequired', 'Not Required' );
            $this->UI->option_text( __( '' ), 'emailexample', 'emailexample', '', true, 'csv2post_inputtext' );

            // username (for user creation)
            $username_table = ''; 
            $username_column = '';
            if( isset( $this->projectsettings['authors']['username']['table'] ) ){$username_table = $this->projectsettings['authors']['username']['table'];}
            if( isset( $this->projectsettings['authors']['username']['column'] ) ){$username_column = $this->projectsettings['authors']['username']['column'];}             
            $this->UI->option_projectcolumns( __( 'Username Data' ), $c2p_settings['currentproject'], 'username', 'username', $username_table, $username_column, 'notrequired', 'Not Required' );
            $this->UI->option_text( __( '' ), 'usernameexample', 'usernameexample', '', true, 'csv2post_inputtext' );
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
    public function postbox_postsettings_defaulttagrules( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        
        global $c2p_settings;
        ?>  

           <table class="form-table">    
            <?php
            // generate tags
            $generatetags_table = ''; 
            $generatetags_column = '';
            if( isset( $this->projectsettings['tags']['generatetags']['table'] ) ){$generatetags_table = $this->projectsettings['tags']['generatetags']['table'];}
            if( isset( $this->projectsettings['tags']['generatetags']['column'] ) ){$generatetags_column = $this->projectsettings['tags']['generatetags']['column'];}             
            $this->UI->option_projectcolumns( __( 'Text Data' ), $c2p_settings['currentproject'], 'generatetags', 'generatetags', $generatetags_table, $generatetags_column, 'notrequired', 'Not Required' );
            $this->UI->option_text( __( '' ), 'generatetagsexample', 'generatetagsexample', '', true, 'csv2post_inputtext' );

            // numeric tags
            $numerictags = 'nocurrent123';
            if( isset( $this->projectsettings['tags']['numerictags'] ) ){$numerictags = $this->projectsettings['tags']['numerictags'];}  
            $this->UI->option_radiogroup( __( 'Numeric Tags' ), 'numerictags', 'numerictags', array( 'allow' => 'Allow', 'disallow' => 'Disallow' ), $numerictags, 'disallow' );
            
            // tag string length
            $tagstringlength = 'nocurrent123';
            if( isset( $this->projectsettings['tags']['tagstringlength'] ) ){$tagstringlength = $this->projectsettings['tags']['tagstringlength'];}           
            $this->UI->option_text( __( 'Tag String Length' ), 'tagstringlength', 'tagstringlength', $tagstringlength, false, 'csv2post_inputtext' );

            // maximum tags
            $maximumtags = 'nocurrent123';
            if( isset( $this->projectsettings['tags']['maximumtags'] ) ){$maximumtags = $this->projectsettings['tags']['maximumtags'];}                     
            $this->UI->option_text( __( 'Maximum Tags' ), 'maximumtags', 'maximumtags', $maximumtags, false );

            // excluded tags
            $excludedtags = 'nocurrent123';
            if( isset( $this->projectsettings['tags']['excludedtags'] ) ){$excludedtags = $this->projectsettings['tags']['excludedtags'];}                                 
            $this->UI->option_textarea( 'Excluded', 'excludedtags', 'excludedtags',5,40, $excludedtags);
            ?>    
            </table>
        
        <?php 
        $this->UI->postbox_content_footer();
    }
}?>