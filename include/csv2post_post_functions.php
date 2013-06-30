<?php
/**
 * Returns post status based on giving criteria
 * makes final decisision on status based on generated post publish date
 * 
 * @param array $csv
 * @param array $my_post (wordpress post object)
 * @return $my_post (wordpress post object)
 * @link http://www.webtechglobal.co.uk/blog/php-mysql/strange-problem-with-date-function
 */
function csv2post_post_poststatus_calculate( $project_array,$my_post ){
    
    $timenow = strtotime( date("Y-m-d H:i:s",time()) );
    $timeset = strtotime( $my_post['post_date'] );
    
    // add 10 seconds to $timenow, no point in setting a post for future if its only to be publish moments later
    $timenow = $timenow + 10;
    
    // if posts time is greater than current
    if( $timeset > $timenow ) {
        $my_post['post_status'] = 'future';
    }elseif( $timeset < $timenow ){
        if(isset($project_array['poststatus'])){
            $my_post['post_status'] = $project_array['poststatus'];
        }else{
            $my_post['post_status'] = 'draft';
        }
    }elseif( $timeset == $timenow ){
        if(isset($project_array['poststatus'])){
            $my_post['post_status'] = $project_array['poststatus'];
        }else{
            $my_post['post_status'] = 'draft';
        }
    }

    return $my_post;
}

/**
* Returns the returned result from a more specific post creation function (depending on edition used)
* 
* @param mixed $project_code
* @param mixed $posts_target
* @param mixed $request_method
*/
function csv2post_create_posts($project_code,$posts_target,$request_method,$subpagelevel = false){
    global $csv2post_is_free;
    if(!$csv2post_is_free){# hack this, you will need to hack csv2post_create_posts_advanced() to become the advanced version of csv2post_creatE_posts_basic()
        // paid edition only - circumventing this measure will only cause errors due to key functions not existing in free package
        return csv2post_create_posts_advanced($project_code,$posts_target,$request_method,$subpagelevel); 
    }else{
        return csv2post_create_posts_basic($project_code,$request_method); 
    }   
}

/**
* Basic version of draft post creation for basic post creation, used in free edition or paying users who
* need maximum script speed possible. These functions are perfect for adapting to suit needs and build up, rather
* than trying to reverse engineer the advanced functions. 
*/
function csv2post_create_postdraft_basic( $my_post,$r,$project_code,$content ){

    $my_post['post_date'] = date("Y-m-d H:i:s", time());    
    $my_post['post_date_gmt'] = gmdate("Y-m-d H:i:s", time());
    $my_post['post_content'] = $content; 
    $my_post['ID'] = wp_insert_post( $my_post );
    if( !$my_post['ID'] ){
        return false;  
    }
    
    // add custom fields
    csv2post_post_default_projectmeta($my_post['ID'],$project_code,$r['csv2post_id']);

    return $my_post;  
}     

/**
* Creates Posts (basic script that does not make use of advanced level settings)
* 
* List Of Functions Not In This Post Creation Script
* 1. No post adoption
* 2. Only basic custom field creation with default data value
* 3. Expects project to have a single database table
* 4. Data modification rules
* 5. No automation, this functions is only designed for manual post creation
* 
* More restrictions exist on this function and it is suited for basic projects and the free edition.
* This functions main purpose is to offer quicker processing for those who need basic posts.* 
* 
* @param string $project_code
* @param integer $posts_target
* @param string $request_method manual, auto
*/
function csv2post_create_posts_basic($project_code,$request_method){ 

    global $wpdb;
    
    ############################################################################
    #                                                                          #
    #        GET ALL POSSIBLE VALUES PRIOR TO BASE POST BEING CREATED          #
    #                                                                          #
    ############################################################################
    $project_array = csv2post_get_project_array($project_code);

    // get data - if no data we return now
    $records = csv2post_WP_SQL_unusedrecords_singletable($project_array['tables'][0]);

    if(!$records){
        if($request_method == 'manual'){
            csv2post_notice('No posts were created as your project does not have any unused records. 
            No project statistics were changed either.','info','Large','No Posts Created','','echo');    
        }
        return false;        
    }
        
    // get title template design
    if(!isset($project_array['default_titletemplate_id'])){
        $title_template = 'No Default Title Template Selected';    
    }else{
        $title_template = csv2post_get_titletemplate_design($project_array['default_titletemplate_id']);    
    }
    
    // get content template design
    if(!isset($project_array['default_contenttemplate_id'])){
        $content_template = 'No Default Content Template Selected! Please create and select a content design so the plugin knows where to put your data within post content.';
    }else{
        $content_template = csv2post_get_template_design($project_array['default_contenttemplate_id']);    
    }   
        
    // increase events counter for campaign
        //++$pro[$filename]['events'];
   
    // initilize variables
    $new_posts = 0;
    $void_records = 0;
    $invalid_records = 0;  
    $fault_occured = 0;// counted times the loop cannot finish the whole script   
                
    // begin looping through all records
    foreach( $records as $record_array ){
        
        // begin $my_post array, we will udpate it with the draft post details
        $my_post = array();
                              
        // Categories   
        $my_post['post_category'] = csv2post_post_categories($record_array);

        // if post title column set, use that
        if(isset($project_array['posttitles']['column'])){
            if(isset($record_array[$project_array['posttitles']['column']])){
                $my_post['post_title'] = $record_array[$project_array['posttitles']['column']];    
            }else{
                $my_post['post_title'] = 'Title Data Value Not Found';
            }             
        }else{
            // if we have a title template parse default post title 
            if($title_template != 'No Default Title Template Selected'){ 
                $my_post['post_title'] = csv2post_parse_columnreplacement_basic($record_array,$title_template);        
            }    
        }
                     
        // parse default post content
        $content = csv2post_parse_columnreplacement_basic($record_array,$content_template);

        // parse excerpt template        
        $my_post = csv2post_POST_excerpt_basic($my_post,$record_array,$project_array);
                               
        // set tags
        if(isset($project_array['tags']['default']['table']) && isset($project_array['tags']['default']['column'])){
            $my_post['tags_input'] = $record_array[$project_array['tags']['default']['column']];    
        }
         
        // set post type (function uses post type rules if any else defaults)
        $my_post['post_type'] = csv2post_establish_posttype($project_array,$record_array);
        $my_post['post_date'] =  date("Y-m-d H:i:s", time());
        $my_post['post_date_gmt'] = gmdate("Y-m-d H:i:s", time());
                
        $my_post = csv2post_post_poststatus_calculate( $project_array,$my_post );

        // apply post author
        if(isset($project_array['authors']['defaultauthor']) && is_numeric($project_array['authors']['defaultauthor'])){
            $my_post['post_author'] = $project_array['authors']['defaultauthor'];
        }else{
            $my_post['post_author'] = 1;    
        }
        
        // ping
        if(isset($project_array['pingstatus']) && $project_array['pingstatus']){
            $my_post['ping_status'] = 'closed';                    
        }
  
        // comments
        if(isset($project_array['pingstatus']) && $project_array['commentstatus']){
            $my_post['comment_status'] = 'closed';                
        }        

        // create a draft post, csv2post_create_posts_basic uses a basic version of draft post creation with none of the most advanced features
        $my_post = csv2post_create_postdraft_basic($my_post,$record_array,$project_code,$content );                                                                        

        if( !$my_post ){
            ++$fault_occured;
            
            // TODO:MEDIUMPRIORITY, log error
            
            // if a small number of posts being created, output a notice, this is allowed with basic function
            // as it is only called using forms, not automation
            if($posts_target < 3){
                csv2post_notice('Draft post could not be created, post creation failed when using one of your records, this must be investigated.','error','Large','Post Creation Failed','','echo');    
            } 
        }else{
                 
            if(isset($project_array['postformat']['default'])){
                wp_set_post_terms($my_post['ID'], 'post-format-'.$project_array['postformat']['default'], 'post_format');    
            }
        
            ++$new_posts;
            
            // update project table
            csv2post_WP_SQL_update_project_databasetable_basic($record_array['csv2post_id'],$my_post['ID'],$project_array['tables'][0]); 
                                                                                                 
                        
            // add custom field meta values (basic array only in this function)
            if(isset($project_array['custom_fields']['basic'])){ 
                foreach($project_array['custom_fields']['basic'] as $key => $cfrule){
                    add_post_meta($my_post['ID'], $cfrule['meta_key'], $record_array[$cfrule['column_name']], false);     
                }
            }
                        
            // add SEO meta values (free edition uses the ['basic'] node of the array only)
            if(isset($project_array['seo']['basic'])){
                csv2post_post_add_metadata_basic_seo($project_array,$project_code,$record_array,$my_post['ID']);
            }                                  

            // put the post id into variable for returning as the $my_post object is destroyed
            $post_id = $my_post['ID'];
        }
        
        // keep $my_post for output at end if creating a single post, else destroy it to avoid its values being used in next post
        unset($my_post);

    }// end for each record
    
    $project_array['stats']['postscreated'] = $project_array['stats']['postscreated'] + $new_posts;
    csv2post_update_option_postcreationproject($project_code,$project_array);
        
    // clear cache                   
    $wpdb->flush();
                      
    // return last post ID - only really matters for testing or single post create requests
    return $post_id;
} 

/**
* Processes project rules against a record to establish post type.
* This function should only be called in argument checking post type rules exist in project array.
* 
* @param mixed $project_array
* @param mixed $record_array
* @returns post type, defaults to user selected default or post when no rules exist or rules are not applied
*/
function csv2post_establish_posttype($project_array,$record_array){
    
    // loop through "byvalue" rules
    if(isset($project_array['posttyperules'])){
        foreach($project_array['posttyperules']['byvalue'] as $key => $rule){
            // ensure $record_array has expected column_name 
            if(isset($record_array[ $rule['column_name'] ])){
                if( $rule['trigger_value'] == $record_array[ $rule['column_name'] ]){
                    return $rule['post_type'];                        
                }       
            }   
        }
    }

    // on reaching here we must now use the user set default if any, else use post
    if(isset($project_array['defaultposttype'])){
        return $project_array['defaultposttype'];
    }
    
    return 'post';          
} 

/**
* Adds SEO meta values to giving post.
* 1. Check that the projects ['seo']['basic'] values exist in array before calling it.
* 
* @param mixed $project_code
* @param mixed $post_ID
*/
function csv2post_post_add_metadata_basic_seo($project_array,$project_code,$record_array,$post_ID,$post_type = 'post'){
    if( isset($project_array['seo']['basic']['title_key']) && isset($project_array['seo']['basic']['title_table']) && isset($project_array['seo']['basic']['title_column']) ){    
        add_post_meta($post_ID,$project_array['seo']['basic']['title_key'],$record_array[$project_array['seo']['basic']['title_column']],true);
    }
 
    if( isset($project_array['seo']['basic']['description_key']) && isset($project_array['seo']['basic']['description_table']) && isset($project_array['seo']['basic']['description_column']) ){   
        add_post_meta($post_ID,$project_array['seo']['basic']['description_key'],$record_array[$project_array['seo']['basic']['description_column']],true);
    }
    
    if( isset($project_array['seo']['basic']['keywords_key']) && isset($project_array['seo']['basic']['keywords_table']) && isset($project_array['seo']['basic']['keywords_column']) ){        
        add_post_meta($post_ID,$project_array['seo']['basic']['keywords_key'],$record_array[$project_array['seo']['basic']['keywords_column']],true);
    }     
}

/**
* Adds default post meta (custom fields) used to manage posts per project or globally
* 
* @param mixed $post_ID
* @param mixed $project_code
*/
function csv2post_post_default_projectmeta($post_ID,$project_code,$record_id){
    add_post_meta($post_ID, 'csv2post_project_code', $project_code, true);
    add_post_meta($post_ID, 'csv2post_record_id', $record_id, true);
    add_post_meta($post_ID, 'csv2post_last_update', date("Y-m-d H:i:s", time()), true);                    
}                                                                           
 
/**
* Creates post creation project.
* 1. Saves all selected tables as ['tables'] within project array
* 2. Sets a main project table in most circumstances, used to create a relationship between all other tables
* 
* @returns boolean false on fail and project code on success
* @returns string, $project_array['code'] if success
*/
function csv2post_create_post_creation_project($project_name,$projecttables_array,$mapping_method){
    global $csv2post_is_free,$csv2post_project_array;
               
    // initialize a new post creation project array
    $csv2post_project_array = csv2post_initialize_postcreationproject_array($project_name);

    // generate a unique project code
    $csv2post_project_array['code'] = 'pro' . csv2post_create_code(6);
   
    // set the csv column to database table mapping method (required for advanced updating)
    $csv2post_project_array['mappingmethod'] = $mapping_method;

    $csv2post_project_array['pingstatus'] = $_POST['csv2post_pingstatus'];
    $csv2post_project_array['commentstatus'] = $_POST['csv2post_commentstatus'];
        
    // add tables to project array (in this loop we also determine if an appropriate project table has been selected)
    $tablecounter = 0;
    $csv2post_projecttable_included = false;// change to true when we confirm a suitable project table is in use 
    foreach( $projecttables_array as $key => $table_name ){
        
        // all tables are added to the "tables" node of the $project_array
        $csv2post_project_array['tables'][$tablecounter] = $table_name;

        // establish if a suitable project table has been selected - we set a table as the main table
        if($csv2post_projecttable_included == false){
            $is_csv2post_table = csv2post_is_csv2post_postprojecttable($table_name);
            if($is_csv2post_table){    
                $csv2post_projecttable_included = true;// ensures the check is not done again, first found table is project table
                $csv2post_project_array['tables'][$tablecounter] = $table_name;
                $csv2post_project_array['maintable'] = $table_name;
            } 
        }
         
        ++$tablecounter;   
    }
    
    // if no project table found, create one (set the $maintableonly parameter to false for this)
    if(!$csv2post_projecttable_included){

        // table name will be csv2post_(project code)
        csv2post_WP_SQL_create_dataimportjob_table($csv2post_project_array['code'],false,true);

        // set main table as the one just created
        $csv2post_project_array['maintable'] = 'csv2post_'.$csv2post_project_array['code'];
    }
        
    // create option record for project
    $createoptionrecord_result = csv2post_update_option_postcreationproject($csv2post_project_array['code'],$csv2post_project_array);
    if($createoptionrecord_result === false){
        return false;
    }else{
        $save_result = csv2post_update_option_postcreationproject_list_newproject($csv2post_project_array['code'],$project_name);
        if($save_result === false){
            return false;    
        }else{
            return $csv2post_project_array['code'];
        }    
    }
    return false;            
}

/**
* Returns an array holding the default values for a post creation project array
* 
* @param mixed $project_name
*/
function csv2post_initialize_postcreationproject_array($project_name){
    $project_array = array();
    $project_array['name'] = $project_name;
    $project_array['type'] = 'post';// post, users, comments, media, custom i.e. ticket,question    
    $project_array['tables'] = array();
    
    // statistics
    $project_array['stats']['creationevents'] = 0;
    $project_array['stats']['updateevents'] = 0;    
    $project_array['stats']['postscreated'] = 0;    
    $project_array['stats']['postsupdated'] = 0;
    $project_array['stats']['pagescreated'] = 0;
    $project_array['stats']['pagesupdated'] = 0;
                                        
    return $project_array;                
}

/**
* Decides which tag generating function to use.
* You must check that the [tags] array is set before calling this function. This function
* will then establish what [tags] settings are to be used
* 
* @param mixed $my_post
* @param mixed $record_array
* @param mixed $project_code
* @param mixed $project_array
* @return array $my_post object is returned by default and by csv2post_post_generate_tags_premade, csv2post_post_generate_tags_advanced
*/
function csv2post_post_tags($my_post,$record_array,$project_code,$project_array){
    global $csv2post_is_free;
    
    /**
    * If free edition, only allow pre-made tags data to be used.
    * If not free edition, [default] is set and [generate] not set then call premade function
    * If not free edition, [default] is not set but [generate] is set then call generate function 
    */
    
    if($csv2post_is_free){  
        if(isset($project_array['tags']['default'])){
            return csv2post_post_generate_tags_premade($my_post,$record_array,$project_code,$project_array);
        } 
        return $my_post;   
    }else{
        if( isset($project_array['tags']['generator']) ){ 
            return csv2post_post_generate_tags_advanced($my_post,$record_array,$project_code,$project_array);         
        }elseif( isset($project_array['tags']['default']) ){ 
            return csv2post_post_generate_tags_premade($my_post,$record_array,$project_code,$project_array);
        }    
    }

    return $my_post;
}

/**
* Adds pre-made tag string to the $my_post object.
* Tags must be comma seperated,required by Wordpress.
*/
function csv2post_post_generate_tags_premade($my_post,$record_array,$project_code,$project_array) {

    // ensure tags default column is set and the column value exists in record array, also ensure it is not a null value
    if(isset($project_array['tags']['default']['column']) && isset($record_array[ $project_array['tags']['default']['column'] ]) && $record_array[ $project_array['tags']['default']['column'] ] != NULL){
        $my_post['tags_input'] = $record_array[ $project_array['tags']['default']['column'] ];    
    }  
    
    return $my_post;
}

/**
* Inserts a new content template as post type wtgcsvcontent
* 
* @param mixed $content
* @param mixed $title technical the post title but we refer to it as the content templates name
* @return int|WP_Error
*/
function csv2post_insert_post_contenttemplate($content,$title){
    // no ID exists, create a new template
    $post = array(
      'comment_status' => 'closed',
      'ping_status' => 'closed',
      'post_author' => get_current_user_id(),
      'post_content' => $content,
      'post_status' => 'publish', 
      'post_title' => $title,
      'post_type' => 'wtgcsvcontent'
    );  
                
    return wp_insert_post( $post, true );// returns WP_Error on fail                
}

/**
* Saves new title template design
* 
* @param mixed $_POST
*/
function csv2post_insert_titletemplate($titletemplate_name,$titletemplate_title){
    // no ID exists, create a new template
    $post = array(
      'comment_status' => 'closed',
      'ping_status' => 'closed',
      'post_author' => get_current_user_id(),
      'post_content' => $titletemplate_title,
      'post_status' => 'publish', 
      'post_title' => $titletemplate_name,
      'post_type' => 'wtgcsvtitle'
    );  
                
    return wp_insert_post( $post, true );// returns WP_Error on fail     
}

/**
* Returns the giving projects default post type.
* @returns boolean false if no default post type set or fault
*/
function csv2post_get_project_defaultposttype($project_code){
    $project_array = csv2post_get_project_array($project_code);
    if(isset( $project_array['defaultposttype'] )){
        return $project_array['defaultposttype'];
    }else{
        return false;
    } 
    return false;   
}

/**
* Changes the default post type for giving project
*/
function csv2post_update_project_defaultposttype($project_code,$default_post_type){
    $project_array = csv2post_get_project_array($project_code);
    $project_array['defaultposttype'] = $default_post_type;
    return csv2post_update_option_postcreationproject($project_code,$project_array);    
}

/**
* Basic category creation script - mainly for use in free edition.
* Only suitable for projects with one table.
* Check that category level1 is set before calling this function.
* 
* USER ADVICE
* This function does not locate and use category slugs that result from two or more different terms.
* This means that where different terms result in the exacts same slug, the function will treat them all as
* different categories. Other methods exist in full edition to get around data that is more complex.
* 
* Some Exclusions
* 1. 3 levels of categories not 5
* 2. Applies all categories to posts
* 3. One set of categories i.e. a post cannot belong to two or more sections on a site
* 
* @todo LOWPRIORITY, consider a custom SQL query per level for establishing if a category exists with require parents etc
* @param mixed $r a single record from results query, is an associative array
*/
function csv2post_categorysetup_basicscript_normalcategories($r,$project_array){
    global $wpdb;
                
    // array to hold our final category ID's ( all are applied to post in this function )
    $finalcat_array = array();

    // count total new categories inserted into blog
    $cats_created_count = 0;
                
    // total number of categories added to $appliedcat_array
    $cats_used_count = 0;
    
    // create variables to hold each level of category ID
    $catid_levone = 0;$catid_levtwo = 0;$catid_levthree = 0;               
                                
    // loop three times 0 = level one and so on
    for ($col_lev = 0; $col_lev < 3; $col_lev++) {
        
        // get the current category term
        if($col_lev == 0){
            $cat_term = $r[$project_array['categories']['level1']['column']];    
        }elseif($col_lev == 1){
            $cat_term = $r[$project_array['categories']['level2']['column']];
        }elseif($col_lev == 2){
            $cat_term = $r[$project_array['categories']['level3']['column']];
        }    

        // set parent ID - if any
        $parent_id = 0;
        if($col_lev == 1){
            $parent_id = $catid_levone;        
        }elseif($col_lev == 2){
            $parent_id = $catid_levtwo;            
        }
        
        // determine if category term already exists, under the parent if one exists
        $cat_taxonomy_result = csv2post_WP_SQL_is_categorywithparent(sanitize_title($cat_term),$parent_id);
        // example return: ["term_id"]=> string(1) "3" ["name"]=> string(4) "Aone" ["parent"]=> string(1) "0"

        // did get_term_by provide a negative result, requiring category to be created with required parent
        // if level one - we only attempt to make category if NO result returned at all, the parent part can be ignored
        if(!$cat_taxonomy_result){
            
            $new_cat_id = wp_insert_term($cat_term, "category", array('description' => '', 'parent' => $parent_id));
            // array(2) { ["term_id"]=> int(80) ["term_taxonomy_id"]=> int(81) }
 
            if(!csv2post_is_WP_Error($new_cat_id) && $new_cat_id){
                 
                if($col_lev == 0){
                    $catid_levone = $new_cat_id['term_id'];       
                }elseif($col_lev == 1){
                    $catid_levtwo = $new_cat_id['term_id'];       
                }elseif($col_lev == 2){
                    $catid_levthree = $new_cat_id['term_id'];       
                }
                
                ++$cats_created_count;
                ++$cats_used_count;
                
            }else{
                ### TODO:HIGHPRIORITY, log error
                ### use csv2post_is_WP_Error if returned
            }            
                
        }elseif( $cat_taxonomy_result && $cat_taxonomy_result->parent == $parent_id ){
            
            // get_term_by returned existing category that has the giving parent
            if($col_lev == 0){
                $catid_levone = $cat_taxonomy_result->term_id;       
            }elseif($col_lev == 1){
                $catid_levtwo = $cat_taxonomy_result->term_id;       
            }elseif($col_lev == 2){
                $catid_levthree = $cat_taxonomy_result->term_id;       
            }
            
            ++$cats_used_count;
        }
   }

   // build final array - I have done this so that 2nd or 3rd level cannot be applied if their parent level 
   // has somehow failed to be found or created. In debugging, if a post is applied to 1st and 3rd category but not
   // the expected 2nd then this is where to begin debugging.
   $appliedcat_array = array();
   if($catid_levone != 0 && is_numeric($catid_levone)){
        $appliedcat_array[] = $catid_levone;      
   }
   if($catid_levtwo != 0 && is_numeric($catid_levtwo) && $catid_levone != 0 && is_numeric($catid_levone)){
        $appliedcat_array[] = $catid_levtwo;      
   }
   if($catid_levthree != 0 && is_numeric($catid_levthree) && $catid_levtwo != 0 && is_numeric($catid_levtwo)){
        $appliedcat_array[] = $catid_levthree;      
   }
      
   return $appliedcat_array;      
} 

function csv2post_POST_excerpt_basic($my_post,$record_array,$project_array){
    if(isset($project_array['default_excerpttemplate_id']) ){  
        $excerpt_template = csv2post_get_template_design($project_array['default_excerpttemplate_id']);
        if($excerpt_template){
            $my_post['post_excerpt'] = csv2post_parse_columnreplacement_basic($record_array,$excerpt_template);
            return $my_post;
        }                 
    }  
    return $my_post;
}   

/**
* Replaces column strings within giving value. Does not take project table into consideration.
* Is only to be used within _basic functions
* 
* @param mixed $record_array
* @param mixed $value
* @return mixed
*/
function csv2post_parse_columnreplacement_basic($record_array,$subject){
    // loop through record array values
    foreach( $record_array as $column => $data ){
        $subject = str_replace('#'. $column, $data, $subject); 
    } 
    return $subject;
}    

/**
* Returns the default hierarchical taxonomy name, used in creating categories to automatically apply categoryes to correct taxonomy 
*/
function csv2post_get_default_hierarchicaltaxonomy(){
    global $csv2post_project_array,$csv2post_currentproject_code;
    $taxonomy_type = 'category';
    $posttype = csv2post_get_project_defaultposttype($csv2post_currentproject_code);
    $taxonomies = get_object_taxonomies($posttype, 'objects');
    foreach($taxonomies as $tax_name => $tax_array){
        if($tax_array->hierarchical){
            $taxonomy_type = $tax_name;
        }
    }                
}
            
?>