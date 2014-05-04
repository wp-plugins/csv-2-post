<?php 
/** 
 * sample data from each of the current projects tables
 * 
 * @link by http://www.webtechglobal.co.uk
 * 
 * @author Ryan Bayne 
 *
 * @package CSV 2 POST
 */
global $CSV2POST,$wpdb,$C2P_WP,$c2p_settings,$C2P_DB,$wpdb,$C2P_UI;

if(!isset($c2p_settings['currentproject']) || !is_numeric($c2p_settings['currentproject'])){
    echo "<p class=\"csv2post_boxes_introtext\">". __('You have not created a project or somehow a Current Project has not been set.') ."</p>";
    return;
}

$sourceid_array = $C2P_WP->get_project_sourcesid($c2p_settings['currentproject']);

$tables_already_displayed = array();

foreach($sourceid_array as $key => $source_id){

    // get the source row
    $row = $C2P_DB->selectrow($wpdb->c2psources,'sourceid = "' . $source_id . '"','tablename,path');

    // avoid displaying the same database table twice
    if(in_array($row->tablename,$tables_already_displayed)){
        continue;
    }
    $tables_already_displayed[] = $row->tablename;
    
    $importedrows = $C2P_DB->selectwherearray($row->tablename);
    
    $projecttable_columns = $C2P_DB->get_tablecolumns($row->tablename,true,true);
    $excluded_array = array('c2p_rowid','c2p_postid','c2p_use','c2p_updated','c2p_applied','c2p_categories','c2p_changecounter');
    foreach($excluded_array as $key => $excluded_column){
        if(in_array($excluded_column,$projecttable_columns)){
            unset($projecttable_columns[$key]);
        }
    }

    $ReceivingTable = new C2P_ImportTableInformation_Table();
    $ReceivingTable->columnarray = $projecttable_columns;
    $ReceivingTable->prepare_items($importedrows,10);    
    ?>

        <?php $myforms_title = basename($row->path) .' to ' . $row->tablename;?>
        <?php $myforms_name = 'importdatatable'.$key;?>
        <a id="anchor_<?php echo $myforms_name;?>"></a>
        <h4><?php echo $myforms_title; ?></h4>

        <form id="projecttables<?php echo $key;?>" method="get">
        
            <?php $C2P_WP->hidden_form_values($myforms_name,$myforms_title);?>
            <input type="hidden" name="tablename" value="<?php echo $row->tablename;?>">
            <input type="hidden" name="sourceid" value="<?php echo $source_id;?>">
                        
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <?php $ReceivingTable->display() ?>
        </form>

<?php }
?>