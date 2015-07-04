<?php
/**
 * Advanced adoption tools.
 * 
 * Adopt existing posts. Tools ensure existing meta data is used
 * properly.
 *
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne   
 * @since 8.1.3
 * 
 * @todo multiple meta adoption uses projects meta keys - require a form that allows user to enter the keys
 * @todo add diagnostic tool - establish what records would apply to more than one post - establish what posts would apply to more than one record
 * @todo add the ability to force a required combo of rules, by default it's one rule at a time, adoption on success of a single rule
 */

// Prohibit direct script loading
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

class CSV2POST_Adoption_View extends CSV2POST_View {

    /**
     * Number of screen columns for post boxes on this screen
     *
     * @since 8.1.3
     *
     * @var int
     */
    protected $screen_columns = 2;
    
    protected $view_name = 'adoption';
    
    public $purpose = 'normal';// normal, dashboard

    /**
    * Array of meta boxes, looped through to register them on views and as dashboard widgets
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.33
    * @version 1.1
    */
    public function meta_box_array() {
        // array of meta boxes + used to register dashboard widgets (id, title, callback, context, priority, callback arguments (array), dashboard widget (boolean) )   
        return $this->meta_boxes_array = array(
            // array( id, title, callback (usually parent, approach created by Ryan Bayne), context (position), priority, call back arguments array, add to dashboard (boolean), required capability
            array( $this->view_name . '-adoptionsettings', __( 'Adoption Settings', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'adoptionsettings' ), true, 'activate_plugins' ),
            array( $this->view_name . '-postnamematch', __( 'Post Name Match', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'postnamematch' ), true, 'activate_plugins' ),
            array( $this->view_name . '-posttitlematch', __( 'Post Title Match', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'posttitlematch' ), true, 'activate_plugins' ),
            array( $this->view_name . '-valueincontent', __( 'Match Value In Content', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'valueincontent' ), true, 'activate_plugins' ),
            array( $this->view_name . '-valueinanymeta', __( 'Match Value In Any Meta', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'valueinanymeta' ), true, 'activate_plugins' ),
            array( $this->view_name . '-valueinspecificmeta', __( 'Match Value In Specific Meta', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'valueinspecificmeta' ), true, 'activate_plugins' ),
            array( $this->view_name . '-pairmeta', __( 'Pair Meta', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'pairmeta' ), true, 'activate_plugins' ),
            array( $this->view_name . '-initiateadoption', __( 'Initiate Adoption', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'initiateadoption' ), true, 'activate_plugins' )
        );    
    }
            
    /**
     * Set up the view with data and do things that are specific for this view
     *
     * @since 8.1.3
     *
     * @param string $action Action for this view
     * @param array $data Data for this view
     */
    public function setup( $action, array $data ) {
        global $csv2post_settings;
        
        // create constant for view name
        if(!defined( "WTG_CSV2POST_VIEWNAME") ){define( "WTG_CSV2POST_VIEWNAME", $this->view_name );}
        
        // create class objects
        $this->CSV2POST = CSV2POST::load_class( 'CSV2POST', 'class-csv2post.php', 'classes' );
        $this->UI = CSV2POST::load_class( 'CSV2POST_UI', 'class-ui.php', 'classes' );// extended by CSV2POST_Forms
        $this->DB = CSV2POST::load_class( 'CSV2POST_DB', 'class-wpdb.php', 'classes' );
        $this->PHP = CSV2POST::load_class( 'CSV2POST_PHP', 'class-phplibrary.php', 'classes' );
        $this->FORMS = CSV2POST::load_class( 'CSV2POST_FORMS', 'class-forms.php', 'classes' );

        // load the current project row and settings from that row
        if( isset( $csv2post_settings['currentproject'] ) && $csv2post_settings['currentproject'] !== false ) {
              
            $this->project_object = $this->CSV2POST->get_project( $csv2post_settings['currentproject'] ); 
            if( !$this->project_object ) {
                $this->current_project_settings = false;
            } else {
                $this->current_project_settings = maybe_unserialize( $this->project_object->projectsettings ); 
            }
               
            parent::setup( $action, $data );

            // only output meta boxes
            if( $this->purpose == 'normal' ) {
                self::metaboxes();
            } elseif( $this->purpose == 'dashboard' ) {
                //self::dashboard();
            } elseif( $this->purpose == 'customdashboard' ) {
                return self::meta_box_array();
            } else {
                // do nothing - can call metaboxes() manually and place them 
            }        
              
       } else {
            $this->add_meta_box( 'tools-nocurrentproject', __( 'No Current Project', 'csv2post' ), array( $this->UI, 'metabox_nocurrentproject' ), 'normal','default',array( 'formid' => 'nocurrentproject' ) );      
       }
    }
     
    /**
    * Outputs the meta boxes
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 0.0.3
    * @version 1.1
    */
    public function metaboxes() {
        parent::register_metaboxes( self::meta_box_array() );     
    }

    /**
    * This function is called when on WP core dashboard and it adds widgets to the dashboard using
    * the meta box functions in this class. 
    * 
    * @uses dashboard_widgets() in parent class CSV2POST_View which loops through meta boxes and registeres widgets
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 0.0.2
    * @version 1.1
    */
    public function dashboard() { 
        parent::dashboard_widgets( self::meta_box_array() );  
    }
    
    /**
    * All add_meta_box() callback to this function to keep the add_meta_box() call simple.
    * 
    * This function also offers a place to apply more security or arguments.
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.32
    * @version 1.0.1
    */
    function parent( $data, $box ) {
        eval( 'self::postbox_' . $this->view_name . '_' . $box['args']['formid'] . '( $data, $box );' );
    }
     
    /**
    * Basic adoption settings.
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 0.0.1
    * @version 1.0
    */
    public function postbox_adoption_adoptionsettings( $data, $box ) {
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], __( 'You should learn what each setting does before making changes to a live blog. Even if you know you should always have all of your data backed-up before the procedure.', 'csv2post' ), false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title'] ); 
        $fid = $box['args']['formid'];
        ?>

            <table class="form-table">
                
                <?php
                $current_value = '';
                if( isset( $this->current_project_settings['adoption']['settings']['forceadoption'] ) ) {
                    $current_value = $this->current_project_settings['adoption']['settings']['forceadoption'];
                }
                $this->FORMS->switch_basic( $fid, 'forceadoption', 'forceadoption', __( 'Force Adoption', 'csv2post' ), 'disabled', $current_value, false ); 
                ?>
                
                <?php
                $current_value = '';
                if( isset( $this->current_project_settings['adoption']['settings']['logadoption'] ) ) {
                    $current_value = $this->current_project_settings['adoption']['settings']['logadoption'];
                }
                $this->FORMS->switch_basic( $fid, 'logadoption', 'logadoption', __( 'Log Adoption', 'csv2post' ), 'disabled', $current_value, false ); 
                ?>
                
                <?php
                $current_value = '';
                if( isset( $this->current_project_settings['adoption']['settings']['rebuildcontent'] ) ) {
                    $current_value = $this->current_project_settings['adoption']['settings']['rebuildcontent'];
                }
                $this->FORMS->switch_basic( $fid, 'rebuildcontent', 'rebuildcontent', __( 'Re-build Content', 'csv2post' ), 'disabled', $current_value, false ); 
                ?>
                
                <?php
                $current_value = '';
                if( isset( $this->current_project_settings['adoption']['settings']['rebuildtitle'] ) ) {
                    $current_value = $this->current_project_settings['adoption']['settings']['rebuildtitle'];
                }
                $this->FORMS->switch_basic( $fid, 'rebuildtitle', 'rebuildtitle', __( 'Re-build Title', 'csv2post' ), 'disabled', $current_value, false ); 
                ?>
                                                            
            </table>
        
        <?php       
        $this->UI->postbox_content_footer();    
    }    
    
    /**
    * Post name/slug match. Can build a title and CSV 2 POST will generate the name from that
    * then complete the search.
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 0.0.1
    * @version 1.0
    */
    public function postbox_adoption_postnamematch( $data, $box ) {
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], __( 'Adopt posts based on a specific postname (slug) structure which takes your own data into consideration. You may enter a single column in the box below for data that already contains post names. You may also use multiple columns and words. Your goal is to build what would result as an actual title. CSV 2 POST will generate a post name from the title by replacing spaces with hyphens etc. Then the comparison is made to any existing posts. This can be a demanding procedure for your server and delicate if you get the structure wrong.', 'csv2post' ), false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title'] ); 
        $fid = $box['args']['formid'];
        ?>

            <table class="form-table">

                <?php
                $current_value = '';
                if( isset( $this->current_project_settings['adoption']['postnamematch']['structure'] ) ) {
                    $current_value = $this->current_project_settings['adoption']['postnamematch']['structure'];
                }
                $this->FORMS->textarea_basic( $fid, 'postnamestructure', 'postnamestructure', __( 'Post Name Structure', 'csv2post' ), $current_value, true, 5, 30, array() );
                ?>
                                                            
            </table>
        
        <?php       
        $this->UI->postbox_content_footer();    
    }   

    /**
    * Post title match.
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 0.0.1
    * @version 1.0
    * 
    * @todo check for duplicate titles within data and warn user that
    */
    public function postbox_adoption_posttitlematch( $data, $box ) {
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], __( 'Adopt posts based on post titles. Enter one or more columns. This is nothing to do with the titles structure for creating posts. This is about creating a structure that may be different to the posts you plan to create but closer to posts created in the past. Ideal for well formatted pages in a situation where you want to change the format of the title with your newer posts.', 'csv2post' ), false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title'] ); 
        $fid = $box['args']['formid'];
        ?>

            <table class="form-table">

                <?php
                $current_value = '';
                if( isset( $this->current_project_settings['adoption']['posttitlematch']['structure'] ) ) {
                    $current_value = $this->current_project_settings['adoption']['posttitlematch']['structure'];    
                }
                $this->FORMS->textarea_basic( $fid, 'posttittlestructure', 'posttittlestructure', __( 'Post Title Structure', 'csv2post' ), $current_value, true, 5, 30, array() );
                ?>
                                                            
            </table>
        
        <?php       
        $this->UI->postbox_content_footer();    
    }
         
    /**
    * Match value in post content and adopt.
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 0.0.1
    * @version 1.0
    * 
    * @todo provide option to avoid adopting a post if the value is found in two posts
    */
    public function postbox_adoption_valueincontent( $data, $box ) {
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], __( 'Use one or more columns to create a value you expect to find in existing post content. When a match is made the post will be adopted and the record used to make the match becomes joined to the existing post.', 'csv2post' ), false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title'] ); 
        $fid = $box['args']['formid'];
        ?>

            <table class="form-table">

                <?php
                $current_value = '';
                if( isset( $this->current_project_settings['adoption']['valueincontent'] ) ) {
                    $current_value = $this->current_project_settings['adoption']['valueincontent'];
                }
                $this->FORMS->textarea_basic( $fid, 'valueincontentstructure', 'valueincontentstructure', __( 'Value In Content Structure', 'csv2post' ), $current_value, true, 5, 30, array() );
                ?>
                                                            
            </table>
        
        <?php       
        $this->UI->postbox_content_footer();    
    }
    
     
    /**
    * Match value in ANY custom field and adopt.
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 0.0.1
    * @version 1.0
    */
    public function postbox_adoption_valueinanymeta( $data, $box ) {
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], __( 'Attempt to pair a single or structured value with ANY post meta. This might not have the desired results as it is hard to know every post meta value in the database.', 'csv2post' ), false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title'] ); 
        $fid = $box['args']['formid'];
        ?>

            <table class="form-table">

                <?php
                $current_value = '';
                if( isset( $this->current_project_settings['adoption']['valueinanymeta'] ) ) {
                    $current_value = $this->current_project_settings['adoption']['valueinanymeta'];
                }
                $this->FORMS->textarea_basic( $fid, 'anypostmetastructure', 'anypostmetastructure', __( 'Any Meta Value Structure', 'csv2post' ), $current_value, true, 5, 30, array() );
                ?>
                                                            
            </table>
        
        <?php       
        $this->UI->postbox_content_footer();    
    } 
    
    /**
    * Match value for a specific meta key.
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 0.0.1
    * @version 1.0
    */
    public function postbox_adoption_valueinspecificmeta( $data, $box ) {
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], __( 'Pair a value from your data with a meta value within a specific key. This rule is run before the rule for ANY meta value as it offers a more accurate method. You can enter letters and numbers along with one or more column tokens.', 'csv2post' ), false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title'] ); 
        $fid = $box['args']['formid'];
        ?>
   
            <table class="form-table">

                <?php
                $current_value = '';
                if( isset( $this->current_project_settings['adoption']['valueinspecificmeta']['structure'] ) ) {
                    $current_value = $this->current_project_settings['adoption']['valueinspecificmeta']['structure'];    
                }
                $this->FORMS->textarea_basic( $fid, 'specificmetavaluestructure', 'specificmetavaluestructure', __( 'Value Structure', 'csv2post' ), $current_value, true, 5, 30, array() );
                
                $current_value = '';
                if( isset( $this->current_project_settings['adoption']['valueinspecificmeta']['key'] ) ) {
                    $current_value = $this->current_project_settings['adoption']['valueinspecificmeta']['key'];    
                }
                $this->FORMS->text_basic( $fid, 'specificmetakey', 'specificmetakey', __( 'Meta Key', 'csv2post' ), $current_value, false, array() );
                ?>
                                                            
            </table>
        
        <?php       
        $this->UI->postbox_content_footer();    
    }     
    
    /**
    * Adopt based on values matches in paired column and existing meta key.
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 0.0.1
    * @version 1.0
    */
    public function postbox_adoption_pairmeta( $data, $box ) {
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], __( 'Adopt by matching multiple meta values with existing meta values. Tell CSV 2 POST what meta keys to check even if the keys are originally created by CSV 2 POST. All meta values will need to match for an adoption to occur. Leave a field blank if you do not want to pair the post meta key displayed, to one already used in your blog. Note that this process could be demanding on your server. If you require a similar process that does not check keys and matches a group of values on a per post basis. That can be provided but it will only be a little less demanding.', 'csv2post' ), false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title'] ); 
        $fid = $box['args']['formid'];
        ?>
    
            <table class="form-table">

                <?php
                // ensure we have an array
                if(!isset( $this->current_project_settings['customfields']['cflist'] ) || !is_array( $this->current_project_settings['customfields']['cflist'] ) ){
                    $this->current_project_settings['customfields']['cflist'] = array();
                }
                
                if( empty( $this->current_project_settings['customfields']['cflist'] ) ) {
                    _e( 'You have not setup any custom fields (pos meta) rules. Once setup they will be listed here. You can then pair any to existing post meta keys used in your blog.', 'csv2post' );    
                } else {
                    
                    $i = 0;
                    foreach( $this->current_project_settings['customfields']['cflist'] as $cfrule ) {
                        $current_value = '';
                        if( isset( $this->current_project_settings['adoption']['pairmeta'][ $cfrule['name'] ] ) ) {
                            $current_value = $this->current_project_settings['adoption']['pairmeta'][ $cfrule['name'] ];
                        }
                        $this->FORMS->text_basic( $fid, 'pairproject' . $i, 'pairproject' . $i, $cfrule['name'], $current_value, false, array() );
                        ++$i;
                    }
                } 
                ?>
            
            </table>
        
        <?php  
        if( !empty( $this->current_project_settings['customfields']['cflist'] ) ) {     
            $this->UI->postbox_content_footer();    
        }
    }     
    
    /**
    * Initiate the adoption process, this has nothing to do with post creation or updating however
    * adopted posts may be updated with new meta or a new title.
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 0.0.1
    * @version 1.0
    * 
    * @todo add option to create a text log of all outcomes, this is seperate from logging into the database but the issue there is the log is mixed with everything else.
    */
    public function postbox_adoption_initiateadoption( $data, $box ) {
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], __( 'When ready click the button below to begin adopting posts. This is a delicate procedure especially if you have used many options on this page. Mass changes may occur.', 'csv2post' ), false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title'] ); 
        $fid = $box['args']['formid'];
    
        $this->UI->postbox_content_footer();    
    }       
}?>