<?php  
##########################################################################################       
#                                                                                        #
#                         FLAG CUSTOM POST TYPE                              #
#                                                                                        #
##########################################################################################

function csv2post_register_customposttype_flags(){
    $labels = array(
        'name' => _x('CSV 2 POST Flags', 'post type general name'),
        'singular_name' => _x('CSV 2 POST Flag', 'post type singular name'),
        'add_new' => _x('Flag Item', 'csv2postflags'),
        'add_new_item' => __('Create Flag'),
        'edit_item' => __('Edit Flag'),
        'new_item' => __('Create Flag'),
        'all_items' => __('All Flags'),
        'view_item' => __('View Flag'),
        'search_items' => __('Search Flags'),
        'not_found' =>  __('No flags found'),
        'not_found_in_trash' => __('No flags found in Trash'), 
        'parent_item_colon' => '',
        'menu_name' => 'C2P Flags'
    );
    $args = array(
        'labels' => $labels,
        'public' => false,
        'publicly_queryable' => false,
        'show_ui' => true, 
        'show_in_menu' => true, 
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true, 
        'hierarchical' => false,
        'menu_position' => 25,
        'supports' => array( 'title', 'editor' )
    );   

    register_post_type( 'csv2postflags', $args );    
}

function csv2post_add_meta_boxes_flags() {
    global $csv2post_is_free;

    // phpline
    add_meta_box(
        'flags-meta-phpline',            
        esc_html__( 'PHP Line', 'example' ),       
        'csv2post_meta_box_flags_phpline',        
        'csv2postflags',                  
        'side',                 
        'default'                  
    );
 
    // phpfunction 
    add_meta_box(
        'flags-meta-phpfunction',            
        esc_html__( 'PHP Function', 'example' ),       
        'csv2post_meta_box_flags_phpfunction',        
        'csv2postflags',                  
        'side',                 
        'default'                  
    );       
     
    // priority 
    add_meta_box(
        'flags-meta-priority',            
        esc_html__( 'Priority', 'example' ),       
        'csv2post_meta_box_flags_priority',        
        'csv2postflags',                  
        'side',                 
        'default'                  
    ); 
  
    // type 
    add_meta_box(
        'flags-meta-type',            
        esc_html__( 'Type', 'example' ),       
        'csv2post_meta_box_flags_type',        
        'csv2postflags',                  
        'side',                 
        'default'                  
    );    
    
    // fileurl 
    add_meta_box(
        'flags-meta-fileurl',            
        esc_html__( 'File URL', 'example' ),       
        'csv2post_meta_box_flags_fileurl',        
        'csv2postflags',                  
        'side',                 
        'default'                  
    ); 

    // dataid 
    add_meta_box(
        'flags-meta-dataid',            
        esc_html__( 'Data ID', 'example' ),       
        'csv2post_meta_box_flags_dataid',        
        'csv2postflags',                  
        'side',                 
        'default'                  
    ); 

    // userid 
    add_meta_box(
        'flags-meta-userid',            
        esc_html__( 'User ID', 'example' ),       
        'csv2post_meta_box_flags_userid',        
        'csv2postflags',                  
        'side',                 
        'default'                  
    ); 
    
    // errortext 
    add_meta_box(
        'flags-meta-errortext',            
        esc_html__( 'Error Text', 'example' ),       
        'csv2post_meta_box_flags_errortext',        
        'csv2postflags',                  
        'normal',                 
        'default'                  
    ); 
    
    // projectid 
    add_meta_box(
        'flags-meta-projectid',            
        esc_html__( 'Project ID', 'example' ),       
        'csv2post_meta_box_flags_projectid',        
        'csv2postflags',                  
        'side',                 
        'default'                  
    ); 

    // reason 
    add_meta_box(
        'flags-meta-reason',            
        esc_html__( 'Reason', 'example' ),       
        'csv2post_meta_box_flags_reason',        
        'csv2postflags',                  
        'normal',                 
        'default'                  
    ); 

    // action 
    add_meta_box(
        'flags-meta-action',            
        esc_html__( 'Action', 'example' ),       
        'csv2post_meta_box_flags_action',        
        'csv2postflags',                  
        'normal',                 
        'default'                  
    ); 
    
    // instructions 
    add_meta_box(
        'flags-meta-instructions',            
        esc_html__( 'Instructions', 'example' ),       
        'csv2post_meta_box_flags_instructions',        
        'csv2postflags',                  
        'normal',                 
        'default'                  
    ); 

    // dump 
    add_meta_box(
        'flags-meta-dump',            
        esc_html__( 'Dump', 'example' ),       
        'csv2post_meta_box_flags_dump',        
        'csv2postflags',                  
        'normal',                 
        'default'                  
    ); 

    // creator 
    add_meta_box(
        'flags-meta-creator',            
        esc_html__( 'Creator', 'example' ),       
        'csv2post_meta_box_flags_creator',        
        'csv2postflags',                  
        'side',                 
        'default'                  
    ); 
    
    // version 
    add_meta_box(
        'flags-meta-version',            
        esc_html__( 'Version', 'example' ),       
        'csv2post_meta_box_flags_version',        
        'csv2postflags',                  
        'side',                 
        'default'                  
    ); 
}

// phpline meta box
function csv2post_meta_box_flags_phpline( $object, $box ) { ?>
    <?php wp_nonce_field( basename( __FILE__ ), 'csv2post_flags_phplinenonce' ); ?>
    <p>
        <input class="widefat" type="text" name="csv2post_flags_phpline" id="phpline-id" value="<?php echo esc_attr( get_post_meta( $object->ID, '_csv2postflags_phpline', true ) ); ?>" size="30" />
    </p><?php 
}

// phpfunction meta box
function csv2post_meta_box_flags_phpfunction( $object, $box ) { ?>
    <?php wp_nonce_field( basename( __FILE__ ), 'csv2post_flags_phpfunctionnonce' ); ?>
    <p>
        <input class="widefat" type="text" name="csv2post_flags_phpfunction" id="phpfunction-id" value="<?php echo esc_attr( get_post_meta( $object->ID, '_csv2postflags_phpfunction', true ) ); ?>" size="30" />
    </p><?php 
}    
    
// priority meta box
function csv2post_meta_box_flags_priority( $object, $box ) { ?>
    <?php wp_nonce_field( basename( __FILE__ ), 'csv2post_flags_prioritynonce' ); ?>
    <p>
        <input class="widefat" type="text" name="csv2post_flags_priority" id="priority-id" value="<?php echo esc_attr( get_post_meta( $object->ID, '_csv2postflags_priority', true ) ); ?>" size="30" />
    </p><?php 
}        

// type meta box
function csv2post_meta_box_flags_type( $object, $box ) { ?>
    <?php wp_nonce_field( basename( __FILE__ ), 'csv2post_flags_typenonce' ); ?>
    <p>
        <input class="widefat" type="text" name="csv2post_flags_type" id="type-id" value="<?php echo esc_attr( get_post_meta( $object->ID, '_csv2postflags_type', true ) ); ?>" size="30" />
    </p><?php 
}      

// fileurl meta box
function csv2post_meta_box_flags_fileurl( $object, $box ) { ?>
    <?php wp_nonce_field( basename( __FILE__ ), 'csv2post_flags_fileurlnonce' ); ?>
    <p>
        <input class="widefat" type="text" name="csv2post_flags_fileurl" id="fileurl-id" value="<?php echo esc_attr( get_post_meta( $object->ID, '_csv2postflags_fileurl', true ) ); ?>" size="30" />
    </p><?php 
}      

// dataid meta box
function csv2post_meta_box_flags_dataid( $object, $box ) { ?>
    <?php wp_nonce_field( basename( __FILE__ ), 'csv2post_flags_dataidnonce' ); ?>
    <p>
        <input class="widefat" type="text" name="csv2post_flags_dataid" id="dataid-id" value="<?php echo esc_attr( get_post_meta( $object->ID, '_csv2postflags_dataid', true ) ); ?>" size="30" />
    </p><?php 
}      

// userid meta box
function csv2post_meta_box_flags_userid( $object, $box ) { ?>
    <?php wp_nonce_field( basename( __FILE__ ), 'csv2post_flags_useridnonce' ); ?>
    <p>
        <input class="widefat" type="text" name="csv2post_flags_userid" id="userid-id" value="<?php echo esc_attr( get_post_meta( $object->ID, '_csv2postflags_userid', true ) ); ?>" size="30" />
    </p><?php 
}      

// errortext meta box
function csv2post_meta_box_flags_errortext( $object, $box ) { ?>
    <?php wp_nonce_field( basename( __FILE__ ), 'csv2post_flags_errortextnonce' ); ?>
    <p>
        <input class="widefat" type="text" name="csv2post_flags_errortext" id="errortext-id" value="<?php echo esc_attr( get_post_meta( $object->ID, '_csv2postflags_errortext', true ) ); ?>" size="30" />
    </p><?php 
}      

// projectid meta box
function csv2post_meta_box_flags_projectid( $object, $box ) { ?>
    <?php wp_nonce_field( basename( __FILE__ ), 'csv2post_flags_projectidnonce' ); ?>
    <p>
        <input class="widefat" type="text" name="csv2post_flags_projectid" id="projectid-id" value="<?php echo esc_attr( get_post_meta( $object->ID, '_csv2postflags_projectid', true ) ); ?>" size="30" />
    </p><?php 
}        

// reason 
function csv2post_meta_box_flags_reason( $object, $box ) { ?>
    <?php wp_nonce_field( basename( __FILE__ ), 'csv2post_flags_reasonnonce' ); ?>
    <p>
        <input class="widefat" type="text" name="csv2post_flags_reason" id="reason-id" value="<?php echo esc_attr( get_post_meta( $object->ID, '_csv2postflags_reason', true ) ); ?>" size="30" />
    </p><?php 
}        
        
// action 
function csv2post_meta_box_flags_action( $object, $box ) { ?>
    <?php wp_nonce_field( basename( __FILE__ ), 'csv2post_flags_actionnonce' ); ?>
    <p>
        <input class="widefat" type="text" name="csv2post_flags_action" id="action-id" value="<?php echo esc_attr( get_post_meta( $object->ID, '_csv2postflags_action', true ) ); ?>" size="30" />
    </p><?php 
}        

// instructions 
function csv2post_meta_box_flags_instructions( $object, $box ) { ?>
    <?php wp_nonce_field( basename( __FILE__ ), 'csv2post_flags_instructionsnonce' ); ?>
    <p>
        <input class="widefat" type="text" name="csv2post_flags_instructions" id="action-id" value="<?php echo esc_attr( get_post_meta( $object->ID, '_csv2postflags_instructions', true ) ); ?>" size="30" />
    </p><?php 
}      

// dump 
function csv2post_meta_box_flags_dump( $object, $box ) { ?>
    <?php wp_nonce_field( basename( __FILE__ ), 'csv2post_flags_dumpnonce' ); ?>
    <p>
        <input class="widefat" type="text" name="csv2post_flags_dump" id="action-id" value="<?php echo esc_attr( get_post_meta( $object->ID, '_csv2postflags_dump', true ) ); ?>" size="30" />
    </p><?php 
}      

// creator 
function csv2post_meta_box_flags_creator( $object, $box ) { ?>
    <?php wp_nonce_field( basename( __FILE__ ), 'csv2post_creator_creatornonce' ); ?>
    <p>
        <input class="widefat" type="text" name="csv2post_flags_creator" id="action-id" value="<?php echo esc_attr( get_post_meta( $object->ID, '_csv2postflags_creator', true ) ); ?>" size="30" />
    </p><?php 
}      

// version 
function csv2post_meta_box_flags_version( $object, $box ) { ?>
    <?php wp_nonce_field( basename( __FILE__ ), 'csv2post_flagsnonce' ); ?>
    <p>
        <input class="widefat" type="text" name="csv2post_flags_version" id="version-id" value="<?php echo esc_attr( get_post_meta( $object->ID, '_csv2postflags_version', true ) ); ?>" size="30" />
    </p><?php 
}   

/**
* Save flag meta box's
* 
* @param mixed $post_id
* @param mixed $post
*/
function csv2post_save_meta_boxes_flags( $post_id, $post ) {

    /* Verify the nonce before proceeding. */
    if ( !isset( $_POST['csv2post_flagsnonce'] ) || !wp_verify_nonce( $_POST['csv2post_flagsnonce'], basename( __FILE__ ) ) )    
        return $post_id;
        
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
 
    // check permissions
    if ( (key_exists('post_type', $post)) && ('page' == $post['post_type']) ) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }        

    /* Get the post type object. */
    $post_type = get_post_type_object( $post->post_type );

    /* Check if the current user has permission to edit the post. */
    if ( !current_user_can( $post_type->cap->edit_post, $post_id ) ){
        return $post_id;
    }
    
    $flagmeta_array = array('phpline','phpfunction','priority','type','fileurl','dataid','userid','errortext',
    'projectid','reason','action','instructions','dump','creator','version');
 
    // loop through our terms and meta functions
    foreach($flagmeta_array as $key => $term){  
        $new_meta_value = '';
         
        /* Get the meta key. */
        $meta_key = '_csv2postflags_' . $term;

        if(isset($_POST['csv2post_flags_'.$term])){
            $new_meta_value = $_POST['csv2post_flags_'.$term];    
        }
        
        /* Get the meta value of the custom field key. */
        $meta_value = get_post_meta( $post_id, $meta_key, true );

        if ( $new_meta_value && '' == $meta_value ){
            add_post_meta( $post_id, $meta_key, $new_meta_value, true );# new meta value was added and there was no previous value
        }elseif ( $new_meta_value && $new_meta_value != $meta_value ){
            update_post_meta( $post_id, $meta_key, $new_meta_value );# new meta value does not match the old value, update it
        }elseif ( '' == $new_meta_value && $meta_value ){
            delete_post_meta( $post_id, $meta_key, $meta_value );# no new meta value but an old value exists, delete it
        }
    }
}

##########################################################################################       
#                                                                                        #
#                         CONTENT TEMPLATE CUSTOM POST TYPE                              #
#                                                                                        #
##########################################################################################

/**
* Must be called using add_action( 'init', 'csv2post_register_customposttype_contentdesigns' )
* Registers custom post type for content only
*/
function csv2post_init_posttype_contentdesigns() {
    $labels = array(
        'name' => _x('CSV 2 POST Content Templates', 'post type general name'),
        'singular_name' => _x('CSV 2 POST Content Template', 'post type singular name'),
        'add_new' => _x('Create', 'wtgcsvcontent'),
        'add_new_item' => __('Create Content Template'),
        'edit_item' => __('Edit Content Template'),
        'new_item' => __('Create Content Template'),
        'all_items' => __('All Content Templates'),
        'view_item' => __('View Content Template'),
        'search_items' => __('Search Content Templates'),
        'not_found' =>  __('No content templates found'),
        'not_found_in_trash' => __('No content templates found in Trash'), 
        'parent_item_colon' => '',
        'menu_name' => 'C2P Content'
    );
    $args = array(
        'labels' => $labels,
        'public' => false,
        'publicly_queryable' => false,
        'show_ui' => true, 
        'show_in_menu' => true, 
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true, 
        'hierarchical' => false,
        'menu_position' => 25,
        'supports' => array( 'title', 'editor','custom-fields' )
    );   

    register_post_type( 'wtgcsvcontent', $args );
}

/* Create one or more meta boxes to be displayed on the post editor screen. */
function csv2post_add_meta_boxes_contenttemplates() {
    global $csv2post_is_free;
    
    // test posts update procedure
    if(!$csv2post_is_free){
        add_meta_box(
            'test-posts',            // Unique ID
            esc_html__( 'Test Posts', 'example' ),        // Title
            'csv2post_meta_box_contenttemplates_testposts',        // Callback function
            'wtgcsvcontent',                    // Admin page (or post type)
            'side',                    // Context
            'default'                    // Priority
        );
    }
}

/* Display the post meta box. */
function csv2post_meta_box_contenttemplates_testposts( $object, $box ) { ?>
    <?php wp_nonce_field( basename( __FILE__ ), 'csv2post_contenttemplate_testpostsnonce' ); ?>
    <p>
        <label for="test-posts"><?php _e( "Comma Separated Post ID:", 'example' ); ?></label>
        <br />
        <input class="widefat" type="text" name="csv2post_contenttemplate_testposts" id="test-posts" value="<?php echo esc_attr( get_post_meta( $object->ID, '_csv2post_testposts', true ) ); ?>" size="30" />
        <br>
        <a href="http://www.csv2post.com/feature-guides/content-template-test-posts-meta-box" title="Feature guide on Content Template Test Posts">Read feature guide</a>
    </p><?php 
}

/**
* Save the meta box's post metadata
* 
* @param mixed $post_id
* @param mixed $post
*/
function csv2post_save_meta_boxes_contenttemplates( $post_id, $post ) {

    /* Verify the nonce before proceeding. */
    if ( !isset( $_POST['csv2post_contenttemplate_testpostsnonce'] ) || !wp_verify_nonce( $_POST['csv2post_contenttemplate_testpostsnonce'], basename( __FILE__ ) ) )
        return $post_id;

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
 
    // check permissions
    if ( (key_exists('post_type', $post)) && ('page' == $post['post_type']) ) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
            
    /* Get the post type object. */
    $post_type = get_post_type_object( $post->post_type );

    /* Check if the current user has permission to edit the post. */
    if ( !current_user_can( $post_type->cap->edit_post, $post_id ) ){
        return $post_id;
    }
    
    ##############################
    #                            #
    #     UPDATE TEST POSTS      #         
    #                            #
    ##############################
    # comma separated test posts, a quick way to apply changes and check them
    
    // string out any none numeric values
    $new_meta_value = '';
    if(isset( $_POST['csv2post_contenttemplate_testposts'] )){
        $idarray = explode(',', $_POST['csv2post_contenttemplate_testposts'] );
        foreach($idarray as $id){        
            if(is_numeric($id)){    
                $new_meta_value .= $id.',';    
            }    
        }
    }
  
    // remove last comma
    $new_meta_value = substr_replace($new_meta_value, '', -1);
           
    /* Get the meta key. */
    $meta_key = '_csv2post_testposts';

    /* Get the meta value of the custom field key. */
    $meta_value = get_post_meta( $post_id, $meta_key, true );

    if ( $new_meta_value && '' == $meta_value ){
        add_post_meta( $post_id, $meta_key, $new_meta_value, true );# new meta value was added and there was no previous value
    }elseif ( $new_meta_value && $new_meta_value != $meta_value ){
        update_post_meta( $post_id, $meta_key, $new_meta_value );# new meta value does not match the old value, update it. */
    }elseif ( '' == $new_meta_value && $meta_value ){
        delete_post_meta( $post_id, $meta_key, $meta_value );# no new meta value but an old value exists, delete it. */
    }
    
    // update each post
    $idarray = explode(',', $new_meta_value );
    foreach($idarray as $csv2post_postid){
        csv2post_POST_updatebyid($csv2post_postid);
    }
}
                                      
##########################################################################################       
#                                                                                        #
#                        TITLE TEMPLATE CUSTOM POST TYPE                                 #
#                                                                                        #
##########################################################################################

/**
* Register custom post type for title templates 
*/
function csv2post_register_customposttype_titledesigns() {
    $labels = array(
        'name' => _x('CSV 2 POST Title Templates', 'post type general name'),
        'singular_name' => _x('CSV 2 POST Title template', 'post type singular name'),
        'add_new' => _x('Create', 'wtgcsvtitle'),# changed this to wtgcsvtitle from wtgcsvcontent on 11th May 2013
        'add_new_item' => __('Create Title Template'),
        'edit_item' => __('Edit Title Template'),
        'new_item' => __('Create Title Template'),
        'all_items' => __('All Title Templates'),
        'view_item' => __('View Title Template'),
        'search_items' => __('Search Title Templates'),
        'not_found' =>  __('No title templates found'),
        'not_found_in_trash' => __('No title templates found in Trash'), 
        'parent_item_colon' => '',
        'menu_name' => 'C2P Titles'
    );
    $args = array(
        'labels' => $labels,
        'public' => false,
        'publicly_queryable' => false,
        'show_ui' => true, 
        'show_in_menu' => true, 
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true, 
        'hierarchical' => false,
        'menu_position' => 25,
        'supports' => array( 'title', 'editor','custom-fields' )
    );   

    register_post_type( 'wtgcsvtitle', $args );
}
?>
