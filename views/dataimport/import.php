<?php
/** 
* import data view
* 
* @link by http://www.webtechglobal.co.uk
* 
* @author Ryan Bayne 
*
* @package CSV 2 POST
*/  

global $C2P_WP,$c2p_settings,$C2P_DB,$wpdb,$C2P_UI;      

if(!isset($c2p_settings['currentproject']) || !is_numeric($c2p_settings['currentproject'])){
    echo "<p class=\"csv2post_boxes_introtext\">". __('You have not created a project or somehow a Current Project has not been set.') ."</p>";
    return;
}

$sourceid_array = $C2P_WP->get_project_sourcesid($c2p_settings['currentproject']);
foreach($sourceid_array as $key => $source_id){
    // get the source row
    $row = $C2P_DB->selectrow($wpdb->c2psources,'sourceid = "' . $source_id . '"','path,tablename,thesep');?>
    <div class="csv2post_boxes_twohalfs">
    
        <?php $myforms_title = 'Import ' . basename($row->path) .' to ' . $row->tablename;?>
        <?php $myforms_name = 'importdata'.$key;?>
        <a id="anchor_<?php echo $myforms_name;?>"></a>
        <h4><?php echo $myforms_title; ?></h4>

        <div class="csv2post_boxes_content">
            <form method="post" name="<?php echo $myforms_name;?>" action="<?php $C2P_UI->form_action(); ?>">
                <?php $C2P_WP->hidden_form_values($myforms_name,$myforms_title);?>

                <input type="hidden" name="tablename" value="<?php echo $row->tablename;?>">
                <input type="hidden" name="sourceid" value="<?php echo $source_id;?>">             
                <table class="form-table">
                <?php    
                $C2P_UI->option_subline($wpdb->get_var( "SELECT COUNT(*) FROM $row->tablename"),'Imported');
                $C2P_UI->option_subline($wpdb->get_var( "SELECT COUNT(*) FROM $row->tablename WHERE c2p_postid != 0"),'Used');
                
                // to determine how many rows are outdated we need to get the wp_c2psources changecounter value which tells us the total 
                // number of times the source has been updated, records with a lower changecounter have not been updated yet
                $changecount = $wpdb->get_var( "SELECT changecounter FROM $wpdb->c2psources");
                // now query all imported rows that have a lower value than $changecount
                $outdated = $wpdb->get_var( "SELECT COUNT(*) FROM $row->tablename WHERE c2p_changecounter < $changecount");
                $C2P_UI->option_subline($outdated,'Outdated');
                
                $C2P_UI->option_subline(0,'Expired');// rows older than user defined expiry date or defined column of expiry dates
                $C2P_UI->option_subline(0,'Void');// rows made void due to rules or fault or even public reporting a bad post                                                                                          
                ?>
                </table>
                <input class="button" type="submit" value="Submit" />
            </form>                    
        </div>
    </div>
<?php }?>


<div class="csv2post_boxes_twohalfs">
    <h4>Data Source Information</h4>
        
    <div class="csv2post_boxes_content">
<?php 
$query_results = $C2P_DB->selectwherearray($wpdb->c2psources,'projectid = ' . $c2p_settings['currentproject'],'sourceid','*');
$SourcesTable = new C2P_ProjectDataSources_Table();
$SourcesTable->prepare_items($query_results,10);
?>

<form id="movies-filter" method="get">
    <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
    <?php $SourcesTable->display() ?>
</form>                
    </div>
</div>