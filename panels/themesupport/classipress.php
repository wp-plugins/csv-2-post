<?php
// if post type not set as ad_listing
###TODO:MEDIUMPRIORITY,make a persistent notification in its current position
###TODO:MEDIUMPRIORITY, add form button so user can change post type to ad_listing  
if(!isset($csv2post_project_array['defaultposttype']) || isset($csv2post_project_array['defaultposttype']) && $csv2post_project_array['defaultposttype'] != 'ad_listing'){
    
    // set post type
    if(!isset($csv2post_project_array['defaultposttype'])){
        $post_type_is = 'post';
    }else{
        $post_type_is = $csv2post_project_array['defaultposttype'];
    }
    echo csv2post_notice('Your default post type for the current project is '.$post_type_is.'.
    You will need to change it to "ad_listing" which is the ClassiPress custom post type.',
    'error','Tiny','','','return');
}
?>