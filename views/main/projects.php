<?php
/** 
 * create new project view
 * 
 * the idea is to capture some information here to help configure the projects UI. By capturing
 * the post type as a key piece of information we can hide or display applicable taxonomies
 *  
 * @link by http://www.webtechglobal.co.uk
 * 
 * @author Ryan Bayne 
 *
 * @package CSV 2 POST
 */
 
global $C2P_UI,$C2P_WP,$CSV2POST,$wpdb,$C2P_DB;   
?>

<div class="csv2post_boxes_threethirds">
    <h4><?php _e('All Projects'); ?></h4>

    <div class="csv2post_boxes_content">
        
        <?php 
        $query_results = $CSV2POST->query_projects();
        $ProjectsTable = new C2P_Projects_Table();
        $ProjectsTable->prepare_items($query_results,5);
        ?>

        <form id="movies-filter" method="get">
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <?php $ProjectsTable->display() ?>
        </form>
                       
    </div>

</div>   

<div class="csv2post_boxes_twohalfs">

    <?php $myforms_title = __('New Project & New CSV Files');?>
    <?php $myforms_name = 'newprojectandnewcsvfiles';?>
    <div class="csv2post_boxes_content">
        <?php $C2P_UI->panel_header($myforms_title,$myforms_name,false,'2UQfk1PLj2s',false,false);?>

        <?php
        echo $C2P_UI->info_area('Example: wp-content\commissionjunction\affiliatedatafeed.csv','');   
        ?>
        
        <form method="post" name="newprojectandnewcsvfiles" action="<?php $C2P_WP->form_action(); ?>">
           
           <?php $C2P_WP->hidden_form_values($myforms_name,$myforms_title);?>

            <table class="form-table">
                <?php
                $C2P_UI->option_text('CSV File 1','csvfile1','csvfile1','');                                                  
                $C2P_UI->option_text('Project Name','newprojectname','newprojectname','');
                $C2P_UI->option_switch('Apply Defaults','applydefaults','applydefaults',false,'Yes','No','disabled');
                ?>       
            </table>
            <input class="button" type="submit" value="Submit" />

        </form>
                               
    </div>

</div>   

<div class="csv2post_boxes_twohalfs">

    <?php $myforms_title = __('Delete Project');?>
    <?php $myforms_name = 'deleteproject';?>
    <div class="csv2post_boxes_content">
        <?php $C2P_UI->panel_header($myforms_title,$myforms_name,false,false,false,false);?>
        
        <form method="post" name="newproject" action="<?php $C2P_WP->form_action(); ?>">
           
           <?php $C2P_WP->hidden_form_values('deleteproject',__('Delete Project','wpecustomers'));?>
        
            <table class="form-table">
                <?php
                $rand = rand(100000,999999);
                $C2P_UI->option_text('Project ID','projectid','projectid','');
                $C2P_UI->option_text('Code','randomcode','randomcode',$rand,true);
                $C2P_UI->option_text('Confirm Code','confirmcode','confirmcode','');
                ?>
            </table>
            <input class="button" type="submit" value="Submit" />

        </form>
                               
    </div>

</div>        