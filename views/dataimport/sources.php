<?php 
/** 
 * project data sources view
 * 
 * @link by http://www.webtechglobal.co.uk
 * 
 * @author Ryan Bayne 
 *
 * @package CSV 2 POST
 */
global $CSV2POST,$wpdb,$C2P_DB,$c2p_settings;

if(!isset($c2p_settings['currentproject']) || !is_numeric($c2p_settings['currentproject'])){
    echo "<p class=\"csv2post_boxes_introtext\">". __('You have not created a project or somehow a Current Project has not been set.') ."</p>";
    return;
}

$query_results = $C2P_DB->selectwherearray($wpdb->c2psources,'projectid = ' . $c2p_settings['currentproject'],'sourceid','*');
$SourcesTable = new C2P_ProjectDataSources_Table();
$SourcesTable->prepare_items($query_results,10);
?>

<form id="movies-filter" method="get">
    <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
    <?php $SourcesTable->display() ?>
</form>
             