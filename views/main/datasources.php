<?php 
/** 
 * data sources view
 * 
 * a list of all data sources for monitor their status. This includes import, update and usage progress. 
 * this view will be important for anyone importing data from various sources at different times.
 *  
 * @link by http://www.webtechglobal.co.uk
 * 
 * @author Ryan Bayne 
 *
 * @package CSV 2 POST
 */
global $CSV2POST,$wpdb,$C2P_DB;

$query_results = $C2P_DB->selectwherearray($wpdb->c2psources,'sourceid = sourceid','sourceid','*');
$SourcesTable = new C2P_DataSources_Table();
$SourcesTable->prepare_items($query_results,10);
?>

<form id="movies-filter" method="get">
    <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
    <?php $SourcesTable->display() ?>
</form>
             