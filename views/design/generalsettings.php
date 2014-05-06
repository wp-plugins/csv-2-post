<?php
/** 
 * general settings view in designs area
 * 
 * @link by http://www.webtechglobal.co.uk
 * 
 * @author Ryan Bayne 
 *
 * @package CSV 2 POST
 */   
 
global $C2P_WP,$C2P_UI,$c2p_settings;

if(!isset($c2p_settings['currentproject']) || !is_numeric($c2p_settings['currentproject'])){
    echo "<p class=\"csv2post_boxes_introtext\">". __('You have not created a project or somehow a Current Project has not been set.') ."</p>";
    return;
}

$project_array = $C2P_WP->get_project($c2p_settings['currentproject']);
// get the design array where we store settings related to configuring posts in every way 
$projectsettings = maybe_unserialize($project_array->projectsettings); 
?>


<div class="csv2post_boxes_twohalfs">

    <?php $myforms_title = __('Basic Post Option');?>
    <?php $myforms_name = 'basicpostoptions';?>

    <div class="csv2post_boxes_content">
        <?php $C2P_UI->panel_header($myforms_title,$myforms_name,false,false,false);?>
        <form method="post" name="<?php echo $myforms_name;?>" action="<?php $C2P_UI->form_action(); ?>">
            <?php $C2P_WP->hidden_form_values($myforms_name,$myforms_title);?>        
            <table class="form-table">  
            <?php
            // status 
            $poststatus = 'nocurrent123';
            if(isset($projectsettings['basicsettings']['poststatus'])){$poststatus = $projectsettings['basicsettings']['poststatus'];}
            $C2P_UI->option_radiogroup('Status','poststatus','poststatus',array('draft' => 'Draft','auto-draft' => 'Auto-Draft','publish' => 'Publish','pending' => 'Pending','future' => 'Future','private' => 'Private'),$poststatus,'publish');             
            
            // ping status
            $pingstatus = 'nocurrent123';
            if(isset($projectsettings['basicsettings']['pingstatus'])){$pingstatus = $projectsettings['basicsettings']['pingstatus'];}
            $C2P_UI->option_radiogroup(__('Ping Status'),'pingstatus','pingstatus',array('open' => 'Open','closed' => 'Closed'),$pingstatus,'closed');
            
            // comment status
            $commentstatus = 'nocurrent123';
            if(isset($projectsettings['basicsettings']['commentstatus'])){$commentstatus = $projectsettings['basicsettings']['commentstatus'];}            
            $C2P_UI->option_radiogroup(__('Comment Status'),'commentstatus','commentstatus',array('open' => 'Open','closed' => 'Closed'),$commentstatus,'open');
            
            // default author
            $defaultauthor = '';
            if(isset($projectsettings['basicsettings']['defaultauthor'])){$defaultauthor = $projectsettings['basicsettings']['defaultauthor'];}
            $C2P_UI->option_menu_users(__('Default Author'),'defaultauthor','defaultauthor',$defaultauthor);
            
            // default category
            $defaultcategory = '';
            if(isset($projectsettings['basicsettings']['defaultcategory'])){$defaultcategory = $projectsettings['basicsettings']['defaultcategory'];}
            $C2P_UI->option_menu_categories(__('Default Category'),'defaultcategory','defaultcategory',$defaultcategory);

            // default post type
            $defaultposttype = 'nocurrent123';
            if(isset($projectsettings['basicsettings']['defaultposttype'])){$defaultposttype = $projectsettings['basicsettings']['defaultposttype'];}            
            $C2P_UI->option_radiogroup_posttypes(__('Default Post Type'),'defaultposttype','defaultposttype',$defaultposttype);
            
            // default post format
            $defaultpostformat = 'nocurrent123';
            if(isset($projectsettings['basicsettings']['defaultpostformat'])){$defaultpostformat = $projectsettings['basicsettings']['defaultpostformat'];}            
            $C2P_UI->option_radiogroup_postformats(__('Default Post Format'),'defaultpostformat','defaultpostformat',$defaultpostformat);
            ?>                              
            </table>
            <input class="button" type="submit" value="Submit" />
        </form>                               
    </div>
</div> 

<div class="csv2post_boxes_twohalfs">

    <?php $myforms_title = __('Data Based Options');?>
    <?php $myforms_name = 'databasedoptions';?>
    <div class="csv2post_boxes_content">
        <?php $C2P_UI->panel_header($myforms_title,$myforms_name,false,false,false);?>
        <form method="post" name="<?php echo $myforms_name;?>" action="<?php $C2P_UI->form_action(); ?>">
        
            <?php $C2P_WP->hidden_form_values($myforms_name,$myforms_title);?>             
            <table class="form-table">    
            <?php
            // tags (ready made tags data)
            $tags_table = ''; 
            $tags_column = '';
            if(isset($projectsettings['basicsettings']['tags']['table'])){$tags_table = $projectsettings['basicsettings']['tags']['table'];}
            if(isset($projectsettings['basicsettings']['tags']['column'])){$tags_column = $projectsettings['basicsettings']['tags']['column'];}             
            $C2P_UI->option_projectcolumns(__('Tags'),$c2p_settings['currentproject'],'tags','tags',$tags_table,$tags_column,'notrequired','Not Required');
            
            // featured image
            $featuredimage_table = ''; 
            $featuredimage_column = '';
            if(isset($projectsettings['basicsettings']['featuredimage']['table'])){$featuredimage_table = $projectsettings['basicsettings']['featuredimage']['table'];}
            if(isset($projectsettings['basicsettings']['featuredimage']['column'])){$featuredimage_column = $projectsettings['basicsettings']['featuredimage']['column'];}             
            $C2P_UI->option_projectcolumns(__('Featured Images'),$c2p_settings['currentproject'],'featuredimage','featuredimage',$featuredimage_table,$featuredimage_column,'notrequired','Not Required');
            ?>    
            </table>
            
            <input class="button" type="submit" value="Submit" />  
        
        </form>
    </div>
</div> 

<div class="csv2post_boxes_twohalfs">

    <?php $myforms_title = __('Tag Rules');?>
    <?php $myforms_name = 'defaulttagrules';?>
    <div class="csv2post_boxes_content">
        <?php $C2P_UI->panel_header($myforms_title,$myforms_name,false,false,false);?>
        <form method="post" name="<?php echo $myforms_name;?>" action="<?php $C2P_UI->form_action(); ?>">
        
            <?php $C2P_WP->hidden_form_values($myforms_name,$myforms_title);?>             
            <table class="form-table">    
            <?php
            // generate tags
            $generatetags_table = ''; 
            $generatetags_column = '';
            if(isset($projectsettings['tags']['generatetags']['table'])){$generatetags_table = $projectsettings['tags']['generatetags']['table'];}
            if(isset($projectsettings['tags']['generatetags']['column'])){$generatetags_column = $projectsettings['tags']['generatetags']['column'];}             
            $C2P_UI->option_projectcolumns(__('Text Data'),$c2p_settings['currentproject'],'generatetags','generatetags',$generatetags_table,$generatetags_column,'notrequired','Not Required');

            // numeric tags
            $numerictags = 'nocurrent123';
            if(isset($projectsettings['tags']['numerictags'])){$numerictags = $projectsettings['tags']['numerictags'];}  
            $C2P_UI->option_radiogroup(__('Numeric Tags'),'numerictags','numerictags',array('allow' => 'Allow','disallow' => 'Disallow'),$numerictags,'disallow');
            
            // tag string length
            $tagstringlength = 'nocurrent123';
            if(isset($projectsettings['tags']['tagstringlength'])){$tagstringlength = $projectsettings['tags']['tagstringlength'];}           
            $C2P_UI->option_text(__('Tag String Length'),'tagstringlength','tagstringlength',$tagstringlength,false,'csv2post_inputtext');

            // maximum tags
            $maximumtags = 'nocurrent123';
            if(isset($projectsettings['tags']['maximumtags'])){$maximumtags = $projectsettings['tags']['maximumtags'];}                     
            $C2P_UI->option_text(__('Maximum Tags'),'maximumtags','maximumtags',$maximumtags,false);

            // excluded tags
            $excludedtags = 'nocurrent123';
            if(isset($projectsettings['tags']['excludedtags'])){$excludedtags = $projectsettings['tags']['excludedtags'];}                                 
            $C2P_UI->option_textarea('Excluded','excludedtags','excludedtags',5,40,$excludedtags);
            ?>    
            </table>
            
            <input class="button" type="submit" value="Submit" />  
        
        </form>
    </div>
</div> 