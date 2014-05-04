<?php
/** 
 * custom fields view
 * 
 * @link by http://www.webtechglobal.co.uk
 * 
 * @author Ryan Bayne 
 *
 * @package CSV 2 POST
 */   
 
global $C2P_WP,$C2P_UI,$c2p_settings;    
?>

<?php
if(!isset($c2p_settings['currentproject']) || !is_numeric($c2p_settings['currentproject'])){
echo "<p class=\"csv2post_boxes_introtext\">". __('You have not created a project or somehow a Current Project has not been set.') ."</p>";
return;
}
?>

<div class="csv2post_boxes_threethirds">

    <?php $myforms_title = __('New Custom Field');?>
    <?php $myforms_name = 'newcustomfield';?>
    <div class="csv2post_boxes_content">
        <?php 
        $C2P_UI->panel_header($myforms_title,$myforms_name,false,'_sBsPwUqv10',false);
        ?>
        
        <form method="post" name="<?php echo $myforms_name;?>" action="<?php $C2P_UI->form_action(); ?>">
            <?php $C2P_WP->hidden_form_values($myforms_name,$myforms_title);?>
        
            <table class="form-table"> 
                <?php 
                // custom field name
                $C2P_UI->option_text('Name','customfieldname','customfieldname','',false,'csv2post_inputtext','Example: mynew_customfield');
                $C2P_UI->option_switch('Unique','customfieldunique','customfieldunique','enabled',__('Yes'),__('No'));
                ?>        
            </table>
            
            <div id="poststuff">
                <?php 
                $cfcontent = '';
                if(isset($_POST['customfielddefaultcontent'])){$cfcontent = $_POST['customfielddefaultcontent'];}?>
                <?php wp_editor($cfcontent,'customfielddefaultcontent',array('textarea_name' => 'customfielddefaultcontent'));?>
            </div>
                        
            <input class="button" type="submit" value="Submit" />     
        </form>  
        
    </div>
</div> 

<?php
$project_array = $C2P_WP->get_project($c2p_settings['currentproject']);
$projectsettings = maybe_unserialize($project_array->projectsettings);

// ensure we have an array
if(!isset($projectsettings['customfields']['cflist']) || !is_array($projectsettings['customfields']['cflist'])){
    $projectsettings['customfields']['cflist'] = array();
}

$CFTable = new C2P_CustomFields_Table();
$CFTable->prepare_items($projectsettings['customfields']['cflist'],100);
?>
            
<form id="movies-filter" method="get">
    <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
    <?php $CFTable->display() ?>
</form>
