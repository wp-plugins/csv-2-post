<?php
/** 
 * Tab navigation array for CSV 2 POST plugin 
 * 
 * @link by http://www.webtechglobal.co.uk
 * 
 * @author Ryan Bayne 
 *
 * @package CSV 2 POST
 */
 
/**
* Instructions
* 1. remember to set an ['userdefault'] for each page, this is to revert to if there are issues loading requested screen, the default for none admin should be suitable for anyone who is expected to visit the page
* 2. note, there are other values that are not included in the array by default and in most cases the value not being present is treated as boolean true
*/

global $c2p_is_dev;

$dc = 'update_core';// default capability required by page or tab
$freepath = WTG_CSV2POST_PATH . 'views/';
$c2p_mpt_arr = array();

function csv2post_active_status($default_active_status = false) {
    global $c2p_is_dev;
    if($c2p_is_dev){return true;}// developers see all
    return $default_active_status;
}

function csv2post_help_entry($header,$info,$url = false,$videoid = false){
    return array($header,$info,$url,$videoid);
}

// create help array with topics that apply to many screens
$helptopics_array = array();
$helptopics_array[0] = array(__('Column Replacement Tokens'), __('Column replacement tokens are values replaced with your data. The token must be one of your column names wrapped with hashes i.e #mycolumn#, #prices#, #someprices#. These are used to place data in templates, especially the main content template. You may see me using them in some text fields that require column names. However the hash is not actually required, I just do out of habit. I expect users to do the same and so to avoid confusion we can enter column names into text fields that require a single "Column" without hashes. This does not apply to text fields which are labelled as a "Template". They require hash so that the plugin can distingish what as meant to be a column and what is meant to be text content.'));

// main page
$c2p_mpt_arr['main']['active'] = csv2post_active_status(true);// boolean -is this page in use
$c2p_mpt_arr['main']['slug'] = 'csv2post';// home page slug set in main file
$c2p_mpt_arr['main']['menu'] = 'CSV 2 POST';// main menu title
$c2p_mpt_arr['main']['name'] = "main";// name of page (slug) and unique
$c2p_mpt_arr['main']['title'] = 'CSV 2 POST';// page title seen once page is opened
$c2p_mpt_arr['main']['permissions']['capability'] = $dc;// our best guess on a suitable capability
$c2p_mpt_arr['main']['permissions']['customcapability'] = $dc;// users requested capability which is giving priority over default 
$sub = 0;  
$c2p_mpt_arr['main']['tabs'][$sub]['active'] = csv2post_active_status(true);
$c2p_mpt_arr['main']['tabs'][$sub]['slug'] = 'projects';
$c2p_mpt_arr['main']['tabs'][$sub]['label'] = __('Projects','csv2post');
$c2p_mpt_arr['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$c2p_mpt_arr['main']['tabs'][$sub]['path'] = $freepath.'main/projects.php';
$c2p_mpt_arr['main']['tabs'][$sub]['permissions']['capability'] = $dc;
$c2p_mpt_arr['main']['tabs'][$sub]['permissions']['customcapability'] = $dc;
$c2p_mpt_arr['main']['tabs'][$sub]['help'][0] = array('', __('I came up with an original approach that requires data to be imported to a database table before creating posts. This approach is more professional and gives us more options for our projects. But it does require some learning.') );              
$c2p_mpt_arr['main']['tabs'][$sub]['help'][1] = array(__('New Project & New CSV Files'), __('After uploading your .csv file/s using Wordpress, FTP or another plugin. Enter the path/s into the form then submit. The plugin will do various checks to ensure your file/s can be used and end with creating one or more database tables.') ); 
$c2p_mpt_arr['main']['tabs'][$sub]['help'][2] = array(__('Single File'), __('This is the default. You must change it if you are using two or more .csv files in one project.'));
$c2p_mpt_arr['main']['tabs'][$sub]['help'][3] = array(__('Individual Tables'), __("Select this if you need each of your files (it will be all of them) to be imported to individual tables. A new database table will be created per file and I've done all the hard work to make it possible. It does mean that some procedures will need to perform more complex database queries. This should be taking into consideration when automatically creating or update posts."));
$c2p_mpt_arr['main']['tabs'][$sub]['help'][4] = array(__('New Project & Existing CSV Files'), __('The project creation form with menus instead of text fields allows us to create a project using existing data sources. We can store data sources for management and ease when working with many sources/files. One set of data can be used in more than one project although not a commonly used feature. If using '));
$c2p_mpt_arr['main']['tabs'][$sub]['help'][5] = array(__('Delete Project'), __('Version 8.0.0 adds more caution to deleting projects by requiring a random code to be repeated. You still need to enter the correct project ID, get that wrong and...oops!'));
$c2p_mpt_arr['main']['tabs'][$sub]['help'][6] = array(__('Current Projects Table'), __('This table will be more use to anyone using the plugin to import affiliate data because that usually involves many files from different affiliate networks. Then usually we create a project per file which is a key ability in CSV 2 POST. However please note that it is possible to append new files to existing projects so that we do not keep creating many database tables. The exact approach depends...well it just depends. A video tutorial will be needed to explain that further.'));
++$sub; 
$c2p_mpt_arr['main']['tabs'][$sub]['active'] = csv2post_active_status(true);
$c2p_mpt_arr['main']['tabs'][$sub]['slug'] = 'datasources';
$c2p_mpt_arr['main']['tabs'][$sub]['label'] = __('Data Sources','csv2post');
$c2p_mpt_arr['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$c2p_mpt_arr['main']['tabs'][$sub]['path'] = $freepath.'main/datasources.php';
$c2p_mpt_arr['main']['tabs'][$sub]['permissions']['capability'] = $dc;
$c2p_mpt_arr['main']['tabs'][$sub]['permissions']['customcapability'] = $dc;
$c2p_mpt_arr['main']['tabs'][$sub]['help'][0] = array(__(''), __('You will have little use for this screen if your working with a single .csv file or database table. But it will still tell you something. The table is populated queries the wp_c2psources table which holds progress and other important details.'));
++$sub;
$c2p_mpt_arr['main']['tabs'][$sub]['active'] = true;
$c2p_mpt_arr['main']['tabs'][$sub]['slug'] = 'import';
$c2p_mpt_arr['main']['tabs'][$sub]['label'] = 'Import';
$c2p_mpt_arr['main']['tabs'][$sub]['allowhide'] = false;
$c2p_mpt_arr['main']['tabs'][$sub]['display'] = true;
$c2p_mpt_arr['main']['tabs'][$sub]['path'] = $freepath.'dataimport/import.php';
$c2p_mpt_arr['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'update_core';  
$c2p_mpt_arr['main']['tabs'][$sub]['help'][0] = array(__(''), __('Import data from .csv file to database tables. That is a required step before creating posts. If you are working with multiple database tables/sources you may see multiple panels. Most people will import a single file and so there will be a single panel. Either way each panel imports data to a specific table, not always different tables i.e. multiple .csv files can be imported to the same table to complete one set of data in one place.'),false,'l06LkzyQ2hU');
++$sub;
$c2p_mpt_arr['main']['tabs'][$sub]['active'] = true;
$c2p_mpt_arr['main']['tabs'][$sub]['slug'] = 'table';
$c2p_mpt_arr['main']['tabs'][$sub]['label'] = 'Table';
$c2p_mpt_arr['main']['tabs'][$sub]['allowhide'] = false;
$c2p_mpt_arr['main']['tabs'][$sub]['display'] = true;
$c2p_mpt_arr['main']['tabs'][$sub]['path'] = $freepath.'dataimport/table.php';
$c2p_mpt_arr['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'update_core';  
$c2p_mpt_arr['main']['tabs'][$sub]['help'][0] = array(__(''), __('You will see any database tables associated with your currently active project on this screen.'));
++$sub;
$c2p_mpt_arr['main']['tabs'][$sub]['active'] = true;
$c2p_mpt_arr['main']['tabs'][$sub]['slug'] = 'columns';
$c2p_mpt_arr['main']['tabs'][$sub]['label'] = 'Categories';
$c2p_mpt_arr['main']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$c2p_mpt_arr['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$c2p_mpt_arr['main']['tabs'][$sub]['path'] = $freepath.'categories/columns.php';
$c2p_mpt_arr['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'update_core';  
$c2p_mpt_arr['main']['tabs'][$sub]['help'][0] = array(__('Category Data'), __('Use this panel if you need to put your posts into two or more categories. Select each of your category data columns in hierarchical order so that the plugin knows which terms in your data are to match different levels within your existing categories. Once your selections are made you can map all values/terms to existing categories.'));
$c2p_mpt_arr['main']['tabs'][$sub]['help'][1] = array(__('Category Pairing'),__('This panel will also become clearer after you select and save your category columns. CSV 2 POST will query each of your columns and list their distinct values. Essentially a list of category terms to be. If you stop your cursor over the text fields you can read which column each term belongs to, this will be browser dependant. On the right we have a column of menus which include all existing categories within our blog. Each categories ID is displayed for blogs that have the same child category names under different parents. The idea is to map the distinct values/categories in our data to existing categories. Where we do not map the plugin will create, unless it determines the category exists already and in that case it will still use the existing category. Mapping is meant in situations where the term in our data is not the same as an existing category but we still want them to be associated. Essentially avoiding another category being created and putting posts into the existing one.'));
++$sub;
$c2p_mpt_arr['main']['tabs'][$sub]['active'] = true;
$c2p_mpt_arr['main']['tabs'][$sub]['slug'] = 'customfields';
$c2p_mpt_arr['main']['tabs'][$sub]['label'] = 'Custom Fields';
$c2p_mpt_arr['main']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$c2p_mpt_arr['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$c2p_mpt_arr['main']['tabs'][$sub]['path'] = $freepath.'meta/customfields.php';
$c2p_mpt_arr['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'update_core';  
$c2p_mpt_arr['main']['tabs'][$sub]['help'][0] = csv2post_help_entry('',__('Custom Fields can be found on the Edit Post screen and are a type of meta. This meta is usually used to populate theme values. If you plan to spend a lot of time using Wordpress I recommend reading the official codex page for this topic.'),'http://codex.wordpress.org/Custom_Fields',false);
$c2p_mpt_arr['main']['tabs'][$sub]['help'][1] = csv2post_help_entry('Name',__('The name is often unique among the custom fields for any post but it does not have to be. The name is also known as the key by developers because it is used to access a specific value.'),false,false);
$c2p_mpt_arr['main']['tabs'][$sub]['help'][2] = csv2post_help_entry(__('Unique'),__('The same custom field name can be used many times for a single post. This is usually the case for values that build a list or history keeping. If you need the same name/key to be used many times set this to no. Leaving it set to yes will ensure the custom field name can only be used once per post and any update will write over the existing value.'),false,false);
$c2p_mpt_arr['main']['tabs'][$sub]['help'][3] = csv2post_help_entry(__('Value'),__('An entire WYSIWYG editor has been added for the creation of your custom field value. Normally we would just paste a singe column token into the editor. That would put the data from a single column into custom fields as the value. The purpose of the editor is to create a more complex template that includes your own text and even HTML.'),false,false);
++$sub;
$c2p_mpt_arr['main']['tabs'][$sub]['active'] = true;
$c2p_mpt_arr['main']['tabs'][$sub]['slug'] = 'generalsettings';
$c2p_mpt_arr['main']['tabs'][$sub]['label'] = 'General Post Settings';
$c2p_mpt_arr['main']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$c2p_mpt_arr['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$c2p_mpt_arr['main']['tabs'][$sub]['path'] = $freepath.'design/generalsettings.php';
$c2p_mpt_arr['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'update_core';  
$c2p_mpt_arr['main']['tabs'][$sub]['help'][0] = array(__('Basic Post Options'), __('These are the first and most commonly used options when creating posts in Wordpress. The selections you make here will only apply to posts created by this plugin. If you want to read more about each setting you should use the Wordpress.org codex.'),'https://codex.wordpress.org/Post_Status');
$c2p_mpt_arr['main']['tabs'][$sub]['help'][1] = array(__('Data Based Options'), __('Most of these settings are related to other options you have when manually creating posts in WP. When creating posts manually we will type in tags, change the permalink or upload an image. In this plugin you need to tell the plugin which columns has the applicable data so it can apply it in the same way. URL cloaking is not a WP core feature though. This option allows us to replace long URL with a shorter one that includes your own domain. On clicking the local domain the user is forwarded to the hidden one.'));
$c2p_mpt_arr['main']['tabs'][$sub]['help'][2] = array(__('Generate Tags'), __('If you do not have a column of data suitable as pre-made tags then you can generate some using a body of text. Some options are provide to increase the quality of tags. The tags string length is the total characters of all tags when put together including commas which separate each word or phrase.'));
++$sub;
$c2p_mpt_arr['main']['tabs'][$sub]['active'] = true;
$c2p_mpt_arr['main']['tabs'][$sub]['slug'] = 'dates';// including list of posts already created with future dates (scheduled by wordpress)
$c2p_mpt_arr['main']['tabs'][$sub]['label'] = 'Dates';
$c2p_mpt_arr['main']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$c2p_mpt_arr['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$c2p_mpt_arr['main']['tabs'][$sub]['path'] = $freepath.'design/dates.php';
$c2p_mpt_arr['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'update_core';  
$c2p_mpt_arr['main']['tabs'][$sub]['help'][0] = array(__('Panel: Publish Dates'), __(''));
$c2p_mpt_arr['main']['tabs'][$sub]['help'][1] = array(__('Date Method'), __('CSV 2 POST offers three custom date options for anyone who does not want post publish dates to be the time and date when the post was made by this plugin. You may import dates data, you may increment dates to look as if constant blogging has been done and you can even randomize dates.'));
$c2p_mpt_arr['main']['tabs'][$sub]['help'][2] = array(__('Pre-Made Dates'), __('If you have dates data you can select your dates column here. Remember your column can have any name it does not need to be "dates" or "date".'));
$c2p_mpt_arr['main']['tabs'][$sub]['help'][3] = array(__('Format'), __('Here we select the expected data format within our data. If you are importing dates data you may need to make a selection in this menu. This is used by PHP to convert a date string to a standard format with accuracy.'));
$c2p_mpt_arr['main']['tabs'][$sub]['help'][4] = array(__('Start Date'), __('Incremental method option. Use this to tell the plugin the earliest publish date to be applied to the first post created.'));
$c2p_mpt_arr['main']['tabs'][$sub]['help'][5] = array(__('Variation Low'), __('This is part of setting an increment. If you enter the same value in this field as in Variation High then the increment will be precise per post. The gap between publish dates will not appear as natural. Enter the number of seconds to set the soonest allowed publish date after the previous.'));
$c2p_mpt_arr['main']['tabs'][$sub]['help'][6] = array(__('Variation High'), __('Enter a number to set the latest allowed publish date for the next post. Enter the same value as entered in Variation Low to force an exact number of seconds between each publish date.'));
$c2p_mpt_arr['main']['tabs'][$sub]['help'][7] = array(__('Earliest Date'), __('Random method option. This is the low part of a range we create and all random dates generated will exist after the date set here. This is much the same as Start Date only the date you enter here is not always used, due to it being random. '));
$c2p_mpt_arr['main']['tabs'][$sub]['help'][8] = array(__('Latest Date'), __('Enter the final date allowed for any post. All posts created will have a date before this date.'));
++$sub;
$c2p_mpt_arr['main']['tabs'][$sub]['active'] = true;
$c2p_mpt_arr['main']['tabs'][$sub]['slug'] = 'content';// wysiwyg editor,list of project templates. Also including design rules form and list
$c2p_mpt_arr['main']['tabs'][$sub]['label'] = 'Post Content';
$c2p_mpt_arr['main']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$c2p_mpt_arr['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$c2p_mpt_arr['main']['tabs'][$sub]['path'] = $freepath.'design/content.php';
$c2p_mpt_arr['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'update_core';  
++$sub;
$c2p_mpt_arr['main']['tabs'][$sub]['active'] = true;
$c2p_mpt_arr['main']['tabs'][$sub]['slug'] = 'tools';// quick creation, undo, quick searches/queries
$c2p_mpt_arr['main']['tabs'][$sub]['label'] = 'Create Posts';
$c2p_mpt_arr['main']['tabs'][$sub]['allowhide'] = false;// is tab screen allowed to be hidden (boolean)
$c2p_mpt_arr['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$c2p_mpt_arr['main']['tabs'][$sub]['path'] = $freepath.'postcreation/tools.php';
$c2p_mpt_arr['main']['tabs'][$sub]['permissions']['defaultcapability'] = 'update_core';  
++$sub;
$c2p_mpt_arr['main']['tabs'][$sub]['active'] = csv2post_active_status(true);
$c2p_mpt_arr['main']['tabs'][$sub]['slug'] = 'about';
$c2p_mpt_arr['main']['tabs'][$sub]['label'] = __('About','csv2post');  
$c2p_mpt_arr['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$c2p_mpt_arr['main']['tabs'][$sub]['path'] = $freepath.'main/about.php';
$c2p_mpt_arr['main']['tabs'][$sub]['permissions']['capability'] = $dc;
$c2p_mpt_arr['main']['tabs'][$sub]['permissions']['customcapability'] = $dc;
$c2p_mpt_arr['main']['tabs'][$sub]['help'][0] = array(__('Translators Needed'), __('It is my hope to give translators something back. If you can translate a language not already listed please let me know what you would like in return.'));
$c2p_mpt_arr['main']['tabs'][$sub]['help'][1] = array(__('Please Donate'), __('You can donate to paypal@webtechglobal.co.uk or click one of the affiliatated ads. If you happen to want your own product added here please email me a link to where I can create an affiliate account.'));
++$sub; 
$c2p_mpt_arr['main']['tabs'][$sub]['active'] = csv2post_active_status(true);
$c2p_mpt_arr['main']['tabs'][$sub]['slug'] = 'install';
$c2p_mpt_arr['main']['tabs'][$sub]['label'] = __('Install','csv2post');
$c2p_mpt_arr['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$c2p_mpt_arr['main']['tabs'][$sub]['path'] = $freepath.'main/install.php';
$c2p_mpt_arr['main']['tabs'][$sub]['permissions']['capability'] = $dc;
$c2p_mpt_arr['main']['tabs'][$sub]['permissions']['customcapability'] = $dc;
$c2p_mpt_arr['main']['tabs'][$sub]['help'][0] = array(__('Partial Un-Install'), __('Intended for advanced users. This panel allows surgical removal of data or files we no longer require or wish to re-install. I have important data re-installing automatically after deletion so this is not always intended for 100% un-installation of the plugin.'));
$c2p_mpt_arr['main']['tabs'][$sub]['help'][1] = array(__('Core Plugin Tables'), __('A list of the plugins database tables required for correct operation. You may this to cleanup if you wish to uninstall the plugin 100% as the tables will not be automatically reinstalled. Core (none project or custom) tables will be reinstalled if you disabled and activate the plugin again in Wordpress.'));
$c2p_mpt_arr['main']['tabs'][$sub]['help'][2] = array(__('Folders'), __('Please check the contents of folders before deleting them.'));
$c2p_mpt_arr['main']['tabs'][$sub]['help'][3] = array(__('Option Records'), __('These are rows in the wp_options table. They are all created by this plugin however if you have a plugin installed that is integreated with CSV 2 POST that plugins options may show in this list. Some options are critical to the plugin working and will be reinstalled automatically, some are critical and will not be reinstalled. Custom or project related options are usually safe to delete without disrupting the state of the entire plugin.'));
++$sub;
$c2p_mpt_arr['main']['tabs'][$sub]['active'] = csv2post_active_status(true);
$c2p_mpt_arr['main']['tabs'][$sub]['slug'] = 'log';
$c2p_mpt_arr['main']['tabs'][$sub]['label'] = __('Log','csv2post');# developer information
$c2p_mpt_arr['main']['tabs'][$sub]['display'] = true;// user can change to false to hide screens
$c2p_mpt_arr['main']['tabs'][$sub]['path'] = $freepath.'main/log.php';
$c2p_mpt_arr['main']['tabs'][$sub]['permissions']['capability'] = $dc;
$c2p_mpt_arr['main']['tabs'][$sub]['permissions']['customcapability'] = $dc;
$c2p_mpt_arr['main']['tabs'][$sub]['help'][0] = array(__(''), __('The plugin mostly makes log entries when automated events are processed. I try not to log too much however I could easily log anything. If you need the log to show you something just let me know.'));  
?>