<?php
/** 
* Adoption by WebTechGlobal is the process of matching a set of data
* sourced from outside of the WordPress database too post data in
* a WP database.
* 
* There are various methods with the goal being to pair a record
* with a post. We may then use the record to update the post or
* the post to update the record.
* 
* @package CSV 2 POST
* @author Ryan Bayne   
* @since 8.2.1
*/
 
class CSV2POST_PostAdoption {
    
    var $total_adoptions = 0;
    
    // count bad adoptions i.e. two or more possible matches (this is for the user to sort out)
    var $bad_adoptions = 0;
    
    // store the time it takes for each procedure
    var $timer_array = array();
    
    // array of active methods to be used during the fired procedure
    var $active_methods = array();
    
    // populate this with an arry of data before running methods  
    var $current_unused_row = array(); 
    
    // setting - force adoption ignores two ore more posts that coule be a match
    var $force_adoption = false;
    
    // setting - rebuild post content based on projects content template
    var $rebuild_content = false;
    
    // setting - 
    var $rebuild_title = false;
    
    // used for an early exit
    var $post_adopted = false;
    
    // ignore records in first result, count those actually processed
    var $records_processed = 0;
      
    public function __construct() {
        global $csv2post_settings;
    
        // create class objects
        $this->CSV2POST = CSV2POST::load_class( 'CSV2POST', 'class-csv2post.php', 'classes' ); # plugin specific functions
        $this->DB = $this->CSV2POST->load_class( 'CSV2POST_DB', 'class-wpdb.php', 'classes' ); # database interaction
        $this->PHP = $this->CSV2POST->load_class( 'CSV2POST_PHP', 'class-phplibrary.php', 'classes' ); # php library by Ryan R. Bayne
        $this->WPCore = $this->CSV2POST->load_class( 'CSV2POST_WPCore', 'class-wpcore.php', 'classes' );
        $this->UI = $this->CSV2POST->load_class( 'CSV2POST_UI', 'class-ui.php', 'classes' ); # interface, mainly notices
         
        // set current project values
        if( isset( $csv2post_settings['currentproject'] ) && $csv2post_settings['currentproject'] !== false ) {    
            $this->project_object = $this->CSV2POST->get_project( $csv2post_settings['currentproject'] ); 
            if( !$this->project_object ) {
                $this->pro_set = false;
            } else {
                $this->pro_set = maybe_unserialize( $this->project_object->projectsettings ); 
            }
        }   
    }  
    
    /**
    * Start post adoption procedure.
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.2.1
    * @version 1.0
    * 
    * @todo total posts to be processed requires a setting for user control
    */
    public function StartAdoptPosts() {
        global $csv2post_settings;
        
        // if project array not set then nothing can be done
        if( !$this->pro_set ) { return false; }
        
        $idcolumn = false;
        if( isset( $this->pro_set['idcolumn'] ) ){
            $idcolumn = $this->pro_set['idcolumn'];    
        }
                
        // get projects unused rows
        $unused_rows = $this->CSV2POST->get_unused_rows( $csv2post_settings['currentproject'], 500, $idcolumn );  
        if(!$unused_rows){
            $this->UI->create_notice( __( 'All of your current projects imported records have been used to create posts or already linked to existing posts in an adoption procedure. Posts can only be adopted by records that do not have a relationship with any post in your blog.' ), 'info', 'Small', __( 'No Records Available' ) );
            return;
        }        
        
        // set projec columns
        $projectcolumns = $this->CSV2POST->get_project_columns_from_db( $csv2post_settings['currentproject'] );
        unset( $projectcolumns['arrayinfo'] );
        $this->project_columns = $projectcolumns;
                
        // log
        if( isset( $this->pro_set['adoption']['settings']['logadoption']) 
            && $this->pro_set['adoption']['settings']['logadoption'] == 'enabled' ) {
            
                $this->CSV2POST->newlog( array(
                    'outcome' => 1,
                    'line' => __LINE__, 
                    'function' => __FUNCTION__,
                    'file' => __FILE__,          
                    'type' => 'general',
                    'category' => 'postevent',
                    'action' => __( 'Post adoption procedure initiated.', 'csv2post' ),
                    'priority' => 'normal',                        
                    'triga' => 'manualrequest'
                ) );        
        }
        
        // build array of active methods by checking all possible settings
        // postnamematch (match posts by their name, not title)
        if( isset( $this->pro_set['adoption']['postnamematch']['structure'] ) ) {
            if( is_string( $this->pro_set['adoption']['postnamematch']['structure'] ) ) {
                $this->active_methods[] = 'postnamematch';    
            }    
        }
        
        // pairmeta - match post with record using multiple meta key and values (all must match)
        if( isset( $this->pro_set['adoption']['pairmeta'] ) ) {
            if( is_array( $this->pro_set['adoption']['pairmeta'] ) ) {
                $this->active_methods[] = 'pairmeta';    
            }    
        }

        // valueincontent - pair a record with post by matching a value in post content
        if( isset( $this->pro_set['adoption']['valueincontent'] ) ) {
            if( is_string( $this->pro_set['adoption']['valueincontent'] ) ) {
                $this->active_methods[] = 'valueincontent';    
            }    
        }        
        
        // valueinanymeta - pair a record with a post that has a specific meta value assigned to it
        if( isset( $this->pro_set['adoption']['valueinanymeta'] ) ) {
            if( is_string( $this->pro_set['adoption']['valueinanymeta'] ) ) {
                $this->active_methods[] = 'valueinanymeta';    
            }    
        }        
   
        // valueinspecificmeta - pair a record with a specific value and specific meta key
        if( isset( $this->pro_set['adoption']['valueinspecificmeta']['structure'] ) 
            
            && isset( $this->pro_set['adoption']['valueinspecificmeta']['key'] ) ) {
            
                if( is_string( $this->pro_set['adoption']['valueinspecificmeta']['structure'] ) ) {
            
                    if( is_string( $this->pro_set['adoption']['valueinspecificmeta']['key'] ) ) {
            
                        $this->active_methods[] = 'valueinspecificmeta';    
            
                    }  
                }    
        }        
           
        // posttitlematch - link a record with post based on post title (not a recommended method)
        if( isset( $this->pro_set['adoption']['posttitlematch']['structure'] ) ) {
            if( is_string( $this->pro_set['adoption']['posttitlematch']['structure'] ) ) {
                $this->active_methods[] = 'valueinanymeta';    
            }    
        }        
        
        // loop through records
        foreach( $unused_rows as $rowkey => $unused_row ) {
            
            // add row to object 
            $this->current_unused_row = $unused_row;
            
            // loop through methods
            if( !empty( $this->active_methods ) ) {
                foreach( $this->active_methods as $key => $method ) {
                    if( method_exists( $this,$method ) ) {
                        eval( 'self::' . $method . '();' );    
                    }
                    
                    // discontinue applying methods to current record if post was adopted
                    if( $this->post_adopted ) {
                        break;
                    }
                }     
            }
            
            ++$this->records_processed;
        }
        
        $this->EndAdoptPosts();
    }
                
    /**
    * Match record to the post name only.
    *
    * Requires building a title, converting it to a URL suitable slug and
    * checking for a matching post_name.
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.2.1
    * @version 1.0
    */
    public function postnamematch() {
        global $csv2post_settings;
        
        // replace tokens with imported data
        $title = $this->CSV2POST->replace_tokens( $this->pro_set['adoption']['postnamematch']['structure'], $this->current_unused_row, $this->project_columns );

        // make post slug/name
        $new_post_name = sanitize_title($title);

        // query post
        $args = array(
          'name'        => $new_post_name,
          'numberposts' => 1
        );
        
        $my_posts = get_posts($args);                         
        
        if( $my_posts ) {
            $this->adopt( $this->current_unused_row['c2p_rowid'], $my_posts[0]->ID );    
        }                                                       
    }     
        
    /**
    * Match multiple meta keys and values.
    * 
    * This method is setup using a form that uses projects meta keys and not manually entered
    * ones. Another form for manually entered keys can be made available if not already added.
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.2.1
    * @version 1.0
    */
    public function pairmeta() {
       global $csv2post_settings;
       
       if( is_array( $this->pro_set['adoption']['pairmeta'] ) ) {
           
           // begin array of meta_query args, loop will add more array
           $args = array(
                'meta_query' => array()
           );
   
           // add all meta keys and values to query
           $i = 0;
           $found_post_id = false;
           foreach( $this->pro_set['adoption']['pairmeta'] as $cfname => $cfvalue ) {
               
               // generate value (should be a template)
               $possible_meta_value = $this->CSV2POST->replace_tokens( $cfvalue, $this->current_unused_row, $this->project_columns );    
               
               // add key and value to argument array
               $args['meta_query'][] = array(
                    'key' => $cfname,
                    'value' => $possible_meta_value,
                    'compare' => 'EQUALS'
               );
               
           }
                      
           $result = query_posts( $args );
           
           if( $result ) {
                $this->adopt( $this->current_unused_row['c2p_rowid'], $result[0]->ID );    
           }            
       }    
    }                
        
    /**
    * Match string within string (post content).
    * 
    * Requires querying all post contents then checking for string in string
    * one by one.
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.2.1
    * @version 1.0         
    * 
    * @todo add ability for user to avoid adoption if two or more posts are a match       
    */
    public function valueincontent() {
        global $wpdb,$csv2post_settings;
  
        $possible_meta_value = $this->CSV2POST->replace_tokens( $this->pro_set['adoption']['valueincontent'], $this->current_unused_row, $this->project_columns );    
 
        $result = $wpdb->get_results( "SELECT * 
                                       FROM $wpdb->posts 
                                       WHERE post_content LIKE '%" . $possible_meta_value . "%'" );
        
        // if more than one post the first will be adopted by default                                         
        if ($result){
            $this->adopt( $this->current_unused_row['c2p_rowid'], $result[0]->ID );
        }
    }        
        
    /**
    * Match a single value with a specific meta key.
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.2.1
    * @version 1.0
    */
    public function valueinspecificmeta() {
       global $csv2post_settings;
       
       if( is_array( $this->pro_set['adoption']['pairmeta'] ) ) {

           // generate value (should be a template)
           $possible_meta_value = $this->CSV2POST->replace_tokens( $this->pro_set['adoption']['valueinspecificmeta']['structure'], $this->current_unused_row, $this->project_columns );    

           // begin array of meta_query args, loop will add more array
           $args = array(
                'meta_query' => array(
                    array(
                        'key' => $this->pro_set['adoption']['valueinspecificmeta']['key'],
                        'value' => $possible_meta_value,
                        'compare' => 'EQUALS'
                    ))
           );
           
           $result = query_posts( $args );
           
           if( $result ) {
                $this->adopt( $this->current_unused_row['c2p_rowid'], $result[0]->ID );    
           }            
       }
    }
              
    /**
    * Match post title.
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.2.1
    * @version 1.0
    */
    public function posttitlematch() {
        global $csv2post_settings;

        // generate value (should be a template)
        $page_title = $this->CSV2POST->replace_tokens( $this->pro_set['adoption']['posttitlematch']['structure'], $this->current_unused_row, $this->project_columns );    
        
        $result = get_page_by_title( $page_title );
        
        if( $result ) {
            $this->adopt( $this->current_unused_row['c2p_rowid'], $result[0]->ID );    
        }        
    }   
   
    /**
    * Complete the adoption of a post.
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.2.1
    * @version 1.0
    */
    public function adopt( $record_ID, $post_ID ) {
        global $csv2post_settings;
        
        $project_table = $this->CSV2POST->get_project_main_table( $csv2post_settings['currentproject'] );
        
        $this->CSV2POST->pair_record_with_post( $project_table, $record_ID, $post_ID );

        $this->post_adopted = true;

        // log
        if( isset( $this->pro_set['adoption']['settings']['logadoption']) 
            && $this->pro_set['adoption']['settings']['logadoption'] == 'enabled' ) {
            
                $this->CSV2POST->newlog( array(
                    'outcome' => 1,
                    'line' => __LINE__, 
                    'function' => __FUNCTION__,
                    'file' => __FILE__,          
                    'type' => 'general',
                    'category' => 'postevent',
                    'action' => __( "Post ID $post_ID was adopted by record ID $record_ID", 'csv2post' ),
                    'priority' => 'normal',                        
                    'triga' => 'manualrequest'
                ) );        
        }
    } 
    
    /**
    * Description
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 0.0.1
    * @version 1.0
    */
    public function EndAdoptPosts() {
        $this->UI->create_notice( sprintf( __( "Post adoption has finished. A total of %s records were processed and %s posts were adopted." ), $this->records_processed ,$this->total_adoptions ), 'info', 'Small', __( 'Post Adoption Result', 'csv2post' ) );               
    }              
}  
?>