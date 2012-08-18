=== Plugin Name ===
Contributors: Zara Walsh
Donate link: http://www.csv2post.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: CSV 2 POST, CSV 2 POST Plugin, CSV 2 POST Software, CSV2POST, wordpress data import,wordpress data importer,auto blogging,auto blogger,autoblog,mass create posts,mass post creation,csv file importer,csv file data import,post injection,import spreadsheet,excel file import,excel import,www.csv2post.com,CSV2POST,wordpresscsv import,wordpress import plugin,wordpress data import tool,wordpress data import plugin,wordpress post creation plugin
Requires at least: 3.3.1
Tested up to: 3.4.1
Stable tag: trunk

CSV 2 POST

== Description ==

CSV 2 POST, best Wordpress data import and post creation plugin since 2009 (re-developed in 2012)

= Versus Other Imports =
CSV 2 POST mass creates posts, categories, meta data, custom fields and more. The design of the plugins
interface and php functions offers a sandbox approach. That approach will become more clear as we enter 2013.
The plugin is well supported with a dedicated website and services.

= Getting Started =
We have  written a start guide and tips on the plugin main page. Please browse the guide there. The main thing 
to know is that any problems encountered are not always due to a bug. The plugin may require further development 
depending on your needs or your project configuration is not compatible with values in your data.

Please seek support by creating a ticket here on the [forum](http://wordpress.org/support/plugin/csv-2-post/)

= Support = 
The plugin is supported by a dedicated
website at [www.csv2post.com](http://www.csv2post.com/). The interface offers a "Help" button beside every feature. A small hint 
is giving and users can click another button to open a page on www.csv2post.com specific to the feature
the user needs help for. Some pages will have video tutorials and screenshots. The online support content is free.

= Our Mission =
It is very important to us that we deliver a useful free plugin for the Wordpress community to use. We must also support
the plugin and take responsibility for it. Priority development and focus in the free edition goes to the actual data 
import side of the plugin. It must do what it says in its name and we would like to deliver a tool for uncommon projects
i.e. importing product data to shopping cart plugin tables and manipulating data as it is being imported based on various
conditions. We have a very long term plan for CSV 2 POST, both free and paid. If you budget is tight, keep
checking the free edition and there is no harm in letting me know what you think the free plugin should offer users. If
you need support that knows the plugin well, you may seek to purchase the premium edition and services

== Installation ==

Initial upload and activation as guided by Wordpress.org standard plugin installation.

1. Upload the `csv-2-post` folder to the `/wp-content/plugins/` directory
1. Activate the CSV 2 POST plugin through the 'Plugins' menu in WordPress
1. Configure the plugin by going to the Settings screen
1. Always backup your database before mass creating posts unless working on a test blog
1. It is recommended you learn the plugin on a test blog first
1. Always seek support if a CSV file does not appear to work, it is usually something minor

== Frequently Asked Questions ==

= Does this plugin work with SEO by Yoast plugin? =
Yes it does, actually in a technical way all SEO plugins work with CSV 2 POST however
the most popular get some extra support to make it easier for users. That includes All In One SEO 
and we will add the extra support for any other plugins on request.

= Is CSV 2 POST well supported? =
Yes, the plugin will be supported for many years and has a dedicated website.

= Will you make changes to the plugin to suit my needs? =
We note every request on a "To Do" list and we intend to keep working through the list
every week. If your needs are more urgent we can be hired. It is mainly Ryan Bayne who 
handles the more intense requests when clients have deadlines, something we take very 
serious. 

= Will development continue for this plugin? =
Our To Do list for CSV 2 POST is already extensive. Ideas, requests and
requirements for new web technology will keep us busy until 2014. This is why the plugins
interface has so many screens and offers the ability to hide features not wanted. 

= Why are the features on so many different plugin screens? =
Long term plans for the development of CSV 2 POST will add an endless list
of new features. Not only do all the form fields and buttons need to be tidy but
every feature and ability has to be offered without assumption. Meaning users
must be able to configure them or opt out of using them or use defaults. Users have that
choice and flexability which is not offered in all plugins. The entire plugin offers a 
sandbox approach, especially for those who know a little PHP and can customise it even
further. The sandbox approach assumes nothing and is expressed on an interface that does
not push users through a linear step by step process.

= When was CSV 2 POST Beta released? =
This plugins re-development begun at the end of 2011 and the Beta was released June 2012. However the
first plugin was created in 2009 and was halted pending re-development.

== Screenshots ==

1. Start by creating a Data Import Job and import your CSV files data to a new database table created by CSV 2 POST. We have the potential here to import to existing tables and more.
2. Create templates for placing your data into post content. Templates are stored under a custom post type so many templates can be created. This gives us the potential to apply different designs based on specific conditions.
3. You can even create title templates, so you do not need pre-made titles, just suitable columns of data to create a title string from. These templates are stored under a custom post type.
4. Set the type of posts you want to create. Many plugins and themes will require you to create a different type of post, something CSV 2 POST will do easily.
5. This screenshot shows "Basic Custom Field Rules", paid edition has advanced features but most users require the basic form which allows you to create post meta with any data.
6. You can use up to 3 columns of data to create 3 levels of categories.
 
== Changelog == 
   
= 6.5.9 =
* Public Messages
    * Free users please use the CSV 2 POST forum on Wordpress.org for support, unless your communication contains sensitive information or attachments
    * http://wordpress.org/support/plugin/csv-2-post
* Bug Fixes
    * (minor) Installation dialogue result now has content confirming the installation outcome
    * (minor) Function for displaying panels was not using the panel state value properly
    * (minor) Post Types page was display the project type value i.e. post, instead of the default post type value
    * (critical) Post types are now applied properly in the full edition (free users can hack the plugin to create different post types)
    * (critical) Free edition wont display message saying there are no database tables created by CSV 2 POST
* General Improvements
    * Known conflicting plugins will now be entered into the plugin in a way that triggers warnigns to be displayed when conflicting plugin in use
    * Moved files age in CSV File Profiles too the second table to make room in the first table for fields/column count
    * File Profile Information table in the CSV Files Profile panel now displays the number of fields/columns
    * Uninstall is now confirmed with a notice
    * Activation panel will now be open by default
* Key Technical Improvements
    * $conflict_found variable no longer used in arugments in csv2post_tab0_install.php (plugin conflict check not part of the script anymore)
    * csv2post_plugin_conflict_prevention() improved and put into use
* Known Issues
    * Tweet My Post plugin conflicting on line 40 where a .js file is registered called jquery-latest, causes jQuery UI dialogue not to display
    * Wordpress HTTPS is reported to also conflict and causes jQuery UI tabs to break, all content displayed at once
* Web Services, Support and Websites changes
    * Installation guide published http://www.csv2post.com/how-to-articles/installing-csv-2-post   
    * Blog option in websites main menu now has sub-categories to make it easier to find tutorials, hacking support, new version updates etc 
          
= 6.5.8 =
* Public Messages
    * There are always many hidden abilities being added too CSV 2 POST, contact us if you seek something 
* Bug Fixes
    * (minor) Undefined variabled $csv2post_is_free when submitting category settings
    * (minor) functions that use get_posts() now have the "numberposts" argument and will query up to 999, not 5 which must be the default
* General Improvements
    * Clicking on the View More Help buttons displayed on help dialogue will now open a new tab
    * Many notifications will display an arrow which takes user too a help page explaining the notification further
    * Can no longer make a post creation project with no name
    * Ability to apply pre-made post title data has been added (panel already existed on interface but was not complete)
    * Advanced SEO panel now displays what settings have been saved (it was already saving properly)
    * Content template lists will now show more than 5 designs in any one list
* Key Technical Improvements
    * csv2post_jquery_opendialog_helpbutton() now opens help page in new tab and does not open in current window
    * csv2post_display_designtype_menu() sets $customfield_types_array as an array if get_post_meta returns false
* Known Issues
    * (minor) Lightbox type overlay applied by jQuery UI dialogue, on 2. Your Projects page, appears to have two overlays (there is a light gap between two of them)
* Web Services, Support and Websites changes
    * More support pages have been blogged...
    * http://www.csv2post.com/feature-guides/create-data-import-jobs-using-csv-files
    * http://www.csv2post.com/feature-guides/csv-file-profiles-panel
       
= 6.5.7 =
* Public Messages
    * The plugins first tutorial has been published on the plugins website
    * Features displayed as new are for testing only, if you use them in a final project please backup your database 
* Bug Fixes
    * (critical) custom fields fix
* General Improvements
    * Category creator (without the need to create posts) added too the Your Creation page
    * Feedburner email subscription form changed too CSV 2 POST feed
    * Twitter button updated to the CSV2POST twitter account
    * Adding tutorial RSS feed banner too the Updates screen
    * Improved content design panels to be easier to understand
    * Advanced Categories panel only displays category templates in the menus and not all template designs
    * Changed "Select CSV File" too "Select Database Tables" on the Create Post Creation Project panel
    * List of database tables in the Create Post Creation Project panel now indicates if a csv2post table has been used or not
* Technical Improvements
    * Project ID is stored in meta for all template designs not just in certain circumstances
    * csv2post_display_template_options() now displays specific template types when parameter is passed
    * csv2post_sql_used_records() added for querying used records in a project database table
    * csv2post_is_table_used() added for deciding if a database table has been used or not
    * csv2post_sql_query_unusedrecords_singletable() is now giving the main table and not first table a the maintable always holds the main status/history
* Known Issues
    * (minor) Lightbox type overlay applied by jQuery UI dialogue, on 2. Your Projects page, appears to have two overlays (there is a light gap between two of them)
* Web Services, Support and Websites changes
    * Tutorials are not being typed up with the first already published, videos will eventually be added too them also
    
= 6.5.6 =
* Public Messages
    * A big thanks to Wordpress for all their hard work and effort done for us recently 
* Bug Fixes
    * (critical) post creation done in multiple events was not tracking records already used
* General Improvements
    * Plugin now updates project database table with post ID
* Technical Improvements
    * csv2post_create_posts_advanced() now avoids doing anything further when $my_post is not an array after attempting to create draft
* Known Issues
    * (minor) Lightbox type overlay applied by jQuery UI dialogue, on 2. Your Projects page, appears to have two overlays (there is a light gap between two of them)
* Web Services, Support and Websites changes
    * None
    
= 6.5.5 =
* Public Messages
    * This version has been released urgently due to a newly introduced bug that will effect around half of the plugins users
    * Reminder: CSV 2 POST requires PHP 5.3 and is being tested on 5.4
* Bug Fixes
    *  (critical) project creation was creating a project table even if the user selected a suitable project table already
* General Improvements
    * None
* Technical Improvements
    * None
* Known Issues
    * Lightbox type overlay applied by jQuery UI dialogue, on 2. Your Projects page, appears to have two overlays (there is a light gap between two of them)
* Web Services, Support and Websites changes
    * None
    
= 6.5.4 =
* Public Messages
    * Please give us feedback on any aspect of the plugin, we will respond to it
* Bug Fixes
    * (critical) Column token replacement in templates was not always happening due to function missing a parameter
    * (minor) csv2post_record_id is now populated with database table record id and not project code
* General Improvements
    * Change the help button text for beta features and features currently not released in free edition
* Technical Improvements
    * maybe_unserialize() added too csv2post_get_dataimportjob()
* Known Issues
    * Nothing has been reported
* Web Services, Support and Websites changes
    * None
    
= 6.5.3 =
* Public Messages
    * CSV 2 POST requires PHP 5.3 (5.4 is being tested), 5.2 has deprecated functions and PEAR CSV only works on 5.3
* Bug Fixes
    * (minor) Warning: Invalid argument supplied for foreach() - Data Page, Created Tables tab
    * (minor) Undefined variable notices on Update Options screen 
    * (minor) Undefined variable notices on Schedule screen
* General Improvements
    * Changed data import panels: they no longer have many buttons, user can enter number of rows to be imported
    * Notice will be displayed on Projects page telling user that a project is required to be created if none have been set as current project or none created
    * Multiple Table Project panel now updates on first submission of a new project being created (refresh no longer required)
* Technical Improvements
    * $csv2post_project_array will now be used by csv2post_create_post_creation_project()
    * New function csv2post_notice_step() for displaying a clickable div with next step styling
    * New function csv2post_get_project_maintable() will be used to determine/retrieve a projects main table
    * Data import panels have two methods set in code: Ajax approach can be used and by default we will use a new form submission approach
    * New function csv2post_form_importdata() will handle $_POST method data import
* Known Issues
    * None
* Web Services, Support and Websites changes
    * On 31st July 2012 the plugins website was updated with the CSV 2 POST brand and Wordpress CSV Importer removed.
    
= 6.5.2 =
* Public Messages
    * CSV 2 POST was previously known as Wordpress CSV Importer but due to conflicts with the Wordpress trademark it had to be renamed
    * Version has been advanced to 6.5.2 to force update on all users of the old CSV 2 POST, a fresh new beginning, thank you for your patience
* Bug Fixes
    * Removed 4th parameter (count) from all uses of csv2post_parse_columnreplacement_advanced() and str_replace()
    * Invalid argument supplied for foreach() on Tags screen  
    * csv2post_ago() no longer performs a PHP 5.2 method due to further problems experienced (going to write a seperate function instead)
* General Improvements
    * Finished "Delete Advanced Random Shortcodes" panel
    * Notification will be displayed on SEO screen if no known SEO plugin is installed
    * Basic SEO Options panel allows selection of data column and entry of meta key used by SEO plugins
    * Advanced SEO Options panel allows selection of template design to create unique meta values that have a close match too the main page content
    * SEO screen added to free edition
    * Basic SEO Options Array Dump panel added (only displayed when developer more active)
    * Meta box on Title Template post edit screen has been removed
    * Meta box on Content Template post edit screen now shows the usage types used selected on the content design screen
    * Started adding Easy Configuration Questions (found on Plugin Settings page) 
* Technical Improvements
    * csv2post_notice and related functions changed to prepare for persistent notifications
    * csv2post_update_project_metadescription() removed
    * csv2post_form_update_metadescription() removed
    * csv2post_post_add_metadata_basic_seo() added (will handle the adding of seo related meta data to posts)
    * Replaced all uses of add_metadata() with add_post_meta() as recommended due to add_metadata() being a low level function
* Known Issues
    * Text spinning panel for deleting text spin shortcodes displays a dump of an array, this was left as is in the rush to get a new version out for PHP 5.2, it is not a fault
* Web Services, Support and Websites changes
    * None