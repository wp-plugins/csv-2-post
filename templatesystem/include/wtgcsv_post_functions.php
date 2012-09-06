<?php
/**
* Returns the returned result from a more specific post creation function (depending on edition used)
* 
* @param mixed $project_code
* @param mixed $posts_target
* @param mixed $request_method
*/
function wtgcsv_create_posts($project_code,$posts_target,$request_method){
    global $wtgcsv_is_free;
    if(!$wtgcsv_is_free){
        // paid edition only - circumventing this measure will only cause errors due to key functions not existing in free package
        return wtgcsv_create_posts_advanced($project_code,$posts_target,$request_method); 
    }else{
        return wtgcsv_create_posts_basic($project_code,$request_method); 
    }   
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
function wtgcsv_create_posts_basic($project_code,$request_method){ 

    global $wpdb;
    
    ############################################################################
    #                                                                          #
    #        GET ALL POSSIBLE VALUES PRIOR TO BASE POST BEING CREATED          #
    #                                                                          #
    ############################################################################
    $project_array = wtgcsv_get_project_array($project_code);
    
    // get data - if no data we return now
    $records = wtgcsv_sql_query_unusedrecords_singletable($project_array['tables'][0]);
    if(!$records){
        if($request_method == 'manual'){
            wtgcsv_notice('No posts were created as your project does not have any unused records. No project statistics were changed either.','info','Large','No Posts Created','','echo');    
        }else{
            ### TODO:MEDIUMPRIORITY, log this event when log system complete
        }
        return false;        
    }
        
    // get title template design
    if(!isset($project_array['default_titletemplate_id'])){
        $title_template = 'No Default Title Template Selected';    
    }else{
        $title_template = wtgcsv_get_titletemplate_design($project_array['default_titletemplate_id']);    
    }
    
    // get content template design
    if(!isset($project_array['default_contenttemplate_id'])){
        $content_template = 'No Default Content Template Selected! Please create and select a content design so the plugin knows where to put your data within post content.';
    }else{
        $content_template = wtgcsv_get_contenttemplate_design($project_array['default_contenttemplate_id']);    
    }   
        
    // increase events counter for campaign
        //++$pro[$filename]['events'];
   
    // initilize variables
    $new_posts = 0;
    $adopted_posts = 0;
    $void_records = 0;
    $invalid_records = 0;  
    $fault_occured = 0;// counted times the loop cannot finish the whole script   
                
    // begin looping through all records
    foreach( $records as $record_array ){
                    
        // set $category_array if $project_array['categories']['level1']['table'] is set (get existing, create or a mix of both)
        $category_array = array();
        if(isset($project_array['categories']['level1']['table'])){
            $category_array = wtgcsv_categorysetup_basicscript_normalcategories($record_array,$project_array);          
        }

        // parse default post title 
        $title_template = wtgcsv_parse_columnreplacement_basic($record_array,$title_template);        
         
        // parse default post content
        $content_template = wtgcsv_parse_columnreplacement_basic($record_array,$content_template);
                
        // create a draft post, wtgcsv_create_posts_basic uses a basic version of draft post creation with none of the most advanced features
        $my_post = wtgcsv_create_postdraft_basic($record_array,$category_array,$project_code,$content_template,$title_template );                                                                        
        if( !$my_post ){
            ++$fault_occured;
            
            // TODO:MEDIUMPRIORITY, log error
            
            // if a small number of posts being created, output a notice, this is allowed with basic function
            // as it is only called using forms, not automation
            if($posts_target < 3){
                wtgcsv_notice('Draft post could not be created, post creation failed when using one of your records, this must be investigated.','error','Large','Post Creation Failed','','echo');    
            } 
        }else{
            // update project table
            wtgcsv_update_project_databasetable_basic($record_id,$post_id,$table_name);
        }
           
        // set tags
        if(isset($project_array['tags']['default']['table']) && isset($project_array['tags']['default']['column'])){
            $my_post['tags_input'] = $record_array[$project_array['tags']['default']['column']];    
        }
         
        // add custom field meta values (basic array only in this function)
        if(isset($project_array['custom_fields']['basic'])){ 
            foreach($project_array['custom_fields']['basic'] as $key => $cfrule){
                add_post_meta($my_post['ID'], $cfrule['meta_key'], $record_array[$cfrule['column_name']], false);     
            }
        }
        
        // add SEO meta values (free edition uses the ['basic'] node of the array only)
        if(isset($project_array['seo']['basic'])){
            wtgcsv_post_add_metadata_basic_seo($project_code,$record_array,$my_post['ID']);
        }                                  

        // put the post id into variable for returning as the $my_post object is destroyed
        $post_id = $my_post['ID'];
        
        // keep $my_post for output at end if creating a single post, else destroy it to avoid its values being used in next post
        if( $posts_target > 1 ){unset($my_post);}

    }// end for each record
        
    // clear cache                   
    $wpdb->flush();
                      
    // return last post ID - only really matters for testing or single post create requests
    return $post_id;
} 

/**
* Adds SEO meta values to giving post.
* 1. Check that the projects ['seo']['basic'] values exist in array before calling it.
* 
* @param mixed $project_code
* @param mixed $post_ID
*/
function wtgcsv_post_add_metadata_basic_seo($project_code,$record_array,$post_ID,$post_type = 'post'){

    if( isset($wtgcsv_project_array['seo']['basic']['title_key']) && isset($wtgcsv_project_array['seo']['basic']['title_table']) && isset($wtgcsv_project_array['seo']['basic']['title_column']) ){    
        add_post_meta($post_ID,$wtgcsv_project_array['seo']['basic']['title_key'],$record_array[$wtgcsv_project_array['seo']['basic']['title_column']],true);
    }
 
    if( isset($wtgcsv_project_array['seo']['basic']['description_key']) && isset($wtgcsv_project_array['seo']['basic']['description_table']) && isset($wtgcsv_project_array['seo']['basic']['description_column']) ){   
        add_post_meta($post_ID,$wtgcsv_project_array['seo']['basic']['description_key'],$record_array[$wtgcsv_project_array['seo']['basic']['description_column']],true);
    }
    
    if( isset($wtgcsv_project_array['seo']['basic']['keywords_key']) && isset($wtgcsv_project_array['seo']['basic']['keywords_table']) && isset($wtgcsv_project_array['seo']['basic']['keywords_column']) ){        
        add_post_meta($post_ID,$wtgcsv_project_array['seo']['basic']['keywords_key'],$record_array[$wtgcsv_project_array['seo']['basic']['keywords_column']],true);
    }     
 
}

/**
* Replaces column strings within giving value. Does not take project table into consideration.
* Is only to be used within _basic functions
* 
* @param mixed $record_array
* @param mixed $value
* @return mixed
*/
function wtgcsv_parse_columnreplacement_basic($record_array,$value){
    // loop through record array values
    foreach( $record_array as $column => $data ){
        $value = str_replace('#'. $column, $data, $value); 
    }
    return $value;
}

/**
* Basic version of draft post creation for basic post creation, used in free edition or paying users who
* need maximum script speed possible. These functions are perfect for adapting to suit needs and build up, rather
* than trying to reverse engineer the advanced functions. 
*/
function wtgcsv_create_postdraft_basic( $r,$category_array,$project_code,$content,$title ){
    $my_post = array();
    $my_post['post_author'] = 1;    
    $my_post['post_date'] = date("Y-m-d H:i:s", time());    
    $my_post['post_date_gmt'] = gmdate("Y-m-d H:i:s", time());
    $my_post['post_title'] = $title;
    $my_post['post_content'] = $content;
    $my_post['post_status'] = 'draft';// set to draft until end of post creation processing
    $my_post['post_type'] = 'post';// free edition offers no features to change this, users can change it manually here if they wish
    $my_post['ID'] = wp_insert_post( $my_post );
    if( !$my_post['ID'] ){
        return false;
        ### TODO:MEDIUMPRIORITY, log this    
    }

    // add custom fields
    wtgcsv_post_default_projectmeta($my_post['ID'],$project_code);

    return $my_post;  
}     

/**
* Adds default post meta (custom fields) used to manage posts per project or globally
* 
* @param mixed $post_ID
* @param mixed $project_code
*/
function wtgcsv_post_default_projectmeta($post_ID,$project_code){
    add_post_meta($post_ID, 'wtgcsv_project_code', $project_code, true);
    add_post_meta($post_ID, 'wtgcsv_last_update', date("Y-m-d H:i:s", time()), true);                    
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
function wtgcsv_categorysetup_basicscript_normalcategories($r,$project_array){
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
        $cat_taxonomy_result = wtgcsv_sql_is_categorywithparent(sanitize_title($cat_term),$parent_id);
        // example return: ["term_id"]=> string(1) "3" ["name"]=> string(4) "Aone" ["parent"]=> string(1) "0"

        // did get_term_by provide a negative result, requiring category to be created with required parent
        // if level one - we only attempt to make category if NO result returned at all, the parent part can be ignored
        if(!$cat_taxonomy_result){
            
            $new_cat_id = wp_insert_term($cat_term, "category", array('description' => '', 'parent' => $parent_id));
            // array(2) { ["term_id"]=> int(80) ["term_taxonomy_id"]=> int(81) }
 
            if(!wtgcsv_is_WP_Error($new_cat_id) && $new_cat_id){
                 
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
                ### use wtgcsv_is_WP_Error if returned
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
 
/**
* Creates post creation project.
* 1. Saves all selected tables as ['tables'] within project array
* 2. Sets a main project table in most circumstances, used to create a relationship between all other tables
* 
* @returns boolean false on fail and project code on success
* @returns string, $project_array['code'] if success
*/
function wtgcsv_create_post_creation_project($project_name,$projecttables_array,$mapping_method){
    global $wtgcsv_is_free;
    
    // initialize a new post creation project array
    $project_array = wtgcsv_initialize_postcreationproject_array($project_name);

    // generate a unique project code
    if($wtgcsv_is_free){
        $project_array['code'] = 'freeproject';    
    }else{
        $project_array['code'] = 'pro' . wtgcsv_create_code(6);
        ### TODO:HIGHPRIORITY, ensure code is unique else generation another, loop until we have a unique code, this code will be used to create main project table name
    }

    // set the csv column to database table mapping method (required for advanced updating)
    $project_array['mappingmethod'] = $mapping_method;

    // add tables to project array (in this loop we also determine if an appropriate project table has been selected)
    $tablecounter = 0;
    $wtgcsv_projecttable_included = false;// change to true when we confirm a suitable project table is in use 
    foreach( $projecttables_array as $key => $table_name ){
        
        // all tables are added to the "tables" node of the $project_array
        $project_array['tables'][$tablecounter] = $table_name;

        // establish if a suitable project table has been selected - we set a table as the main table
        if($wtgcsv_projecttable_included == false){
            $is_wtgcsv_table = wtgcsv_is_wtgcsv_postprojecttable($table_name);
            if($is_wtgcsv_table){
                $wtgcsv_projecttable_included = true;// ensures the check is not done again, first found table is project table
                $project_array['tables'][$tablecounter] = $table_name;
                $project_array['maintable'] = $table_name;
            } 
        }
         
        ++$tablecounter;   
    }
    
    // if no project table found, create one (set the $maintableonly parameter to false for this)
    if(!$wtgcsv_projecttable_included){

        wtgcsv_create_dataimportjob_table($project_array['code'],false,true);

        // set main table as the one just created
        $project_array['maintable'] = $table_name;
    }
        
    // create option record for project
    $createoptionrecord_result = wtgcsv_update_option_postcreationproject($project_array['code'],$project_array);
    if($createoptionrecord_result === false){
        return false;
    }else{
        $save_result = wtgcsv_update_option_postcreationproject_list_newproject($project_array['code'],$project_name);
        if($save_result === false){
            return false;    
        }else{
            return $project_array['code'];
        }    
    }
    return false;            
}

/**
* Returns an array holding the default values for a post creation project array
* 
* @param mixed $project_name
*/
function wtgcsv_initialize_postcreationproject_array($project_name){
    $project_array = array();
    $project_array['name'] = $project_name;
    $project_array['type'] = 'post';// post, user, comment, media, custom i.e. ticket,question    
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
 * Returns post status based on giving criteria
 * makes final decisision on status based on generated post publish date
 * 
 * @param array $csv
 * @param array $my_post (wordpress post object)
 * @return $my_post (wordpress post object)
 * @link http://www.webtechglobal.co.uk/blog/php-mysql/strange-problem-with-date-function
 */
function wtgcsv_post_poststatus_calculate( $csv,$my_post ){
    $timenow = strtotime( date("Y-m-d H:i:s") );
    $timeset = strtotime( $my_post['post_date'] );

    if( $timeset > $timenow )// if posts time is greater than current
    {
        $my_post['post_status'] = 'future';
    }
    elseif( $timeset < $timenow )// if posts time is less than current
    {
        $my_post['post_status'] = $csv['poststatus'];
    }
    elseif( $timeset == $timenow )// if matching times
    {
        $my_post['post_status'] = $csv['poststatus'];
    }

    return $my_post;
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
* @return array $my_post object is returned by default and by wtgcsv_post_generate_tags_premade, wtgcsv_post_generate_tags_advanced
*/
function wtgcsv_post_tags($my_post,$record_array,$project_code,$project_array){
    global $wtgcsv_is_free;
    
    /**
    * If free edition, only allow pre-made tags data to be used.
    * If not free edition, [default] is set and [generate] not set then call premade function
    * If not free edition, [default] is not set but [generate] is set then call generate function 
    */
    
    if($wtgcsv_is_free){  
        if(isset($project_array['tags']['default'])){
            return wtgcsv_post_generate_tags_premade($my_post,$record_array,$project_code,$project_array);
        } 
        return $my_post;   
    }else{
        if( isset($project_array['tags']['generator']) ){ 
            return wtgcsv_post_generate_tags_advanced($my_post,$record_array,$project_code,$project_array);         
        }elseif( isset($project_array['tags']['default']) ){ 
            return wtgcsv_post_generate_tags_premade($my_post,$record_array,$project_code,$project_array);
        }    
    }

    return $my_post;
}

/**
* Adds pre-made tag string to the $my_post object.
* Tags must be comma seperated,required by Wordpress.
*/
function wtgcsv_post_generate_tags_premade($my_post,$record_array,$project_code,$project_array) {

    // ensure tags default column is set and the column value exists in record array, also ensure it is not a null value
    if(isset($project_array['tags']['default']['column']) && isset($record_array[ $project_array['tags']['default']['column'] ]) && $record_array[ $project_array['tags']['default']['column'] ] != NULL){
        $my_post['tags_input'] = $record_array[ $project_array['tags']['default']['column'] ];    
    }  
    
    return $my_post;
}

/**
* Inserts a new content template as post type wtgcsvcontent
*/
function wtgcsv_insert_post_contenttemplate(){
    // no ID exists, create a new template
    $post = array(
      'comment_status' => 'closed',
      'ping_status' => 'closed',
      'post_author' => get_current_user_id(),
      'post_content' => $_POST['wtgcsv_wysiwyg_editor'],
      'post_status' => 'publish', 
      'post_title' => $_POST['wtgcsv_templatename'],
      'post_type' => 'wtgcsvcontent'
    );  
                
    return wp_insert_post( $post, true );// returns WP_Error on fail                
}

/**
* Saves new title template design
* 
* @param mixed $_POST
*/
function wtgcsv_insert_titletemplate($titletemplate_name,$titletemplate_title){
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
function wtgcsv_get_project_defaultposttype($project_code){
    $project_array = wtgcsv_get_project_array($project_code);
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
function wtgcsv_update_project_defaultposttype($project_code,$default_post_type){
    $project_array = wtgcsv_get_project_array($project_code);
    $project_array['defaultposttype'] = $default_post_type;
    return wtgcsv_update_option_postcreationproject($project_code,$project_array);    
}
?>