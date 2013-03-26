<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'currentprojectdatabasetables';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Database Tables *current project*');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('You currently cannot change the tables added to your project due to complications that it could lead to when other configuration in project settings has been complete. If you find yourself in need of the ability to make changes to your projects tables long into post creation, it is possible but the features do not exist yet. Let me know you need the ability to make changes here.');?>
<?php csv2post_panel_header( $panel_array );?>

    <?php csv2post_display_project_database_tables_and_columns(); ?>

<?php csv2post_panel_footer();?>

<?php
if($csv2post_is_dev && isset($csv2post_project_array)){
    ++$panel_number;// increase panel counter so this panel has unique ID
    $panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
    $panel_array['panel_name'] = 'projectarraydump';// slug to act as a name and part of the panel ID 
    $panel_array['panel_title'] = __('Project Array Dump');// user seen panel header text 
    $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
    $panel_array['panel_help'] = __('The array dump shows the values that CSV 2 POST works with and is intended for advanced users. This panel only shows when Developer Mode is active, with the idea that only developers would really have use for what is then displayed. The more data in this array, the higher chance there is of post creation being slower. Not because there are more values in this array, but because the values trigger more functions to be used. If you see values in the array for settings and features you realise you do not need. It is recommended that you remove them by visiting the applicable screens and panels.');?>
    <?php csv2post_panel_header( $panel_array );?>

        <h4>Post Meta (Custom Fields)</h4>
        <?php
        if(!isset($csv2post_project_array['custom_fields'])){
            echo '<p>No [custom_fields] array found, your project is not prepared for adding post meta</p>';
        }else{ 
            csv2post_var_dump($csv2post_project_array['custom_fields']);
        }?>
            
        <h4>Statistics (stats)</h4>
        <?php
        if(!isset($csv2post_project_array['stats'])){
            echo '<p>No [stats] array found, this is required and must be investigated</p>';
        }else{ 
            csv2post_var_dump($csv2post_project_array['stats']);
        }?>   
             
        <h4>Dates</h4>
        <?php
        if(!isset($csv2post_project_array['dates'])){
            echo '<p>No [dates] array exists, publish dates will default to the time they are created on</p>';
        }else{ 
            csv2post_var_dump($csv2post_project_array['dates']);
        }?> 
        
        <h4>Post Type Rules (posttyperules)</h4>
        <?php
        if(!isset($csv2post_project_array['posttyperules'])){
            echo '<p>No post-type rules have been setup in this project, all posts will be "posts"</p>';    
        }else{ 
            csv2post_var_dump($csv2post_project_array['posttyperules']);    
        }?>
        
        <h4>Categories</h4>
        <?php
        if(!isset($csv2post_project_array['categories'])){
            echo '<p>No categories or category rules setup for this project, category with ID one will be the default.</p>';    
        }else{ 
            csv2post_var_dump($csv2post_project_array['categories']);    
        }?>        
               
        <h4>Entire Array</h4>
        <?php csv2post_var_dump($csv2post_project_array);?>

    <?php csv2post_panel_footer();
}?>
