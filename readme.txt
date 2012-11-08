=== Plugin Name ===
Contributors: Zara Walsh
Donate link: http://www.csv2post.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: CSV 2 POST, CSV 2 POST Plugin, CSV 2 POST Software, CSV2POST, wordpress data import,wordpress data importer,auto blogging,auto blogger,autoblog,mass create posts,mass post creation,csv file importer,csv file data import,post injection,import spreadsheet,excel file import,excel import,www.csv2post.com,CSV2POST,wordpresscsv import,wordpress import plugin,wordpress data import tool,wordpress data import plugin,wordpress post creation plugin
Requires at least: 3.3.1
Tested up to: 3.4.2
Stable tag: trunk

CSV 2 POST

== Description ==

CSV 2 POST is the most advanced Wordpress data import and post creation plugin. This
plugin has been designed with a sandbox approach (not a step-by-step system) and it does not assume anything when
dealing with your data. Many users will need a plugin that takes the complication out of imorting data.Please see 
Easy CSV Importer for a more step-by-step interface which configures posts with less configuration. 

Thank you for your interest in our software.


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
the user needs help for. Some pages will have video tutorials and screenshots. The online support content is free. We
also plan to create help content specifically for the free edition so that it is truly supported.

= Our Mission =
It is very important to us that we deliver a useful free plugin for the Wordpress community to use. We must also support
the plugin and take responsibility for it. Priority development and focus in the free edition goes to the actual data 
import side of the plugin. It must do what it says in its name and we would like to deliver a tool for uncommon projects
i.e. importing product data to shopping cart plugin tables and manipulating data as it is being imported based on various
conditions. We have a very long term plan for CSV 2 POST, both free and paid. If you budget is tight there is no harm in 
letting me know what you think the free plugin should offer users. We are keen to provide the most common requirements
for free in respect to the Wordpress community.

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
handles the more complex requests. However sometimes we can add a new feature to the free
edition quickly so please push for the free option first.

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

= 6.7.2 =
* Public Messages
    * Re-installation of the csv2post_schedule option for Schedule System required when upgrading too this version
* Fixes
    * The new logging system had a bug effecting the creation of log files
    * csv2post_install() used maybe_serialize() for installing schedule array but the serialize function is not loaded by Wordpress, replaced it with serialize() instead
    * Schedule array record was being re-installed during Partial Un-Install because the schedule system would run during submission. From now on the schedule will not be processed during form submissions both public and admin side.
    * Errors when plugin attempts to make log entries during installation, this is no longer done so these errors will no longer show (would only been seen with debug mode on)
* Feature Changes
    * Removed "Backup Old Content" settings on the Update Options screen
    * Schedule array now part of installation (done so we can set post updating to on by default)
    * All settings on the Update Options screen are on by default (post updating will be more active without the user having to visit settings)
    * "CSV 2 POST Install" will now show as "Install/Uninstall"
* Support Changes
    * Updated page explaining why rows are dropped
    * Fixed links in notices displayed after importing data  
    * Extended text on the Post Content Updating Settings 
* Technical Changes
    * $csv2post_twitter variable no longer in use, all instances of it deleted and replaced with 'CSV2POST' which is the plugins Twitter account
    * add_action('the_posts', 'csv2post_posts_autoupdate' ) removed from the schedule for postupdating, it appears to be called at all times from main file anyway
    * csv2post_posts_autoupdate() renamed too csv2post_posts_publicupdating() (this function updates posts as they are opened by visitors)
    * Removed use of csv2post_log from csv2post_install_functions.php
    * Added index.php to all directories to prevent indexing
    * New updating method by schedule that uses new values in $csv2post_projectlist_array to indicate if a project may have outdated posts
    * New function csv2post_project_changed($project_code) used to mark a project has updated within $csv2post_projectlist_array
    * Changed $csv2post_schedule_array, each event type now stores the event name and we'll use this for looping and building forms
    * wtgcore_notice() was coded to update schedule option record instead of notifications option record, however it has never happened as its not fully in use
    * Use of csv2post_uninstall() removed from csv2post_install(), we will track the versions of records eventually to ensure installation is suitable for plugin version
    * csv2post_schedule_array.php is only included when needed (install and get_option function)
    * add_option('csv2post_theme','start') is now performed during install but no output
    * Use of var_dump() replaced with csv2post_var_dump() throughout plugin. csv2post_var_dump() is only to be used for permanent dumps, var_dump() is for during development only, this approach allows us to locate the use of var_dump() and remove.
    * All use of add_option() replaced with wtgcore_option() which is new and does add,update and delete. It will allow us to log install related changes easier.
    
= 6.7.1 =
* Public Messages
    * We reached 10,000 downloads this week!
    * CSV 2 POST Twitter will notify you have new versions and important changes https://twitter.com/CSV2POST
* Fixes
    * A fix in data updating applied
    * Using the same CSV file for two or more data import jobs would break the Basic Import screen due to JavaScript ID's not being unique (using filenames, they now use job code)
    * Ultimate Taxonomy Manager: csv2post_form_save_ultimatetaxonomymanager_categories() function fixed thanks to Albert
    * Encoding Settings: missing line in form processing function so form was not being saved
    * Admin Triggered Automation: was not being saved
    * Basic SEO: saving the settings did not work, caused by Ryan and fixed by Ryan, again. Sorry folks.
    * Create Posts screen submission no longer conflict when there are multiple projects
    * Submitting a project with no entry in the project name field no longer creates a blank project
    * Table to Table MySQL queries improved
* Feature Changes
    * New Data History screen added to the Your Data page (by default it will display the latest 100 entries in descending order)
    * New Data Samples: the Created Tables screen now has a panel for each Data Import Job table which lists some records for the table. A tool for quickly confirming the existence of records, handy for us accessing users blogs and knowing they have imported records when we do not have access to phpmyadmin.
    * Reporting Settings: new panel offering ability to disable all logging and set the maximum size of log files
    * Two new log files: posts and data. We want to focus on these two new log files and get building a usable history of the plugins main purpose 
    * Log Files: dialogue boxes are no longer used to confirm form submission outcome when creating, delete or activating log files
    * Removed Critical Options panel from the Install Status screen, it never really had much use for the average user
    * Moved Log File Status panel up to make it easier for users to find and manage the files
    * Extensions: the main file now checks for an existing active extension if the plugin has never been installed, rather than requiring the extension status setting to be active. This allows the menu to display the extensions name straight away where previously it would still say CSV 2 POST
    * Renamed the Created Database Tables List to Delete Job Tables
    * We can now edit data using phpmyadmin to trigger updating on a post for the record we edit without also having to edit the csv2post_updated column, this will happen automatically (done by MySQL)
    * Log file is activated straight after creating them using Log File Status panel reducing number of submissions required
    * Log file is disabled within settings when user deletes the file using File Status Panel. We have autodelete to prevent log files getting too large so we will use manual delete to also disable the logging. 
* Support Changes
    * None   
* Technical Changes
    * csv2post_log() is now wtgcore_log() and moved to wtgcore_reports.php
    * New range of wtgcore_log_#####() functions created, one for each log type and each has parameters suiting the type
    * Moved wtgcore_log() and all other log related functions to wtgcore_reports.php (in the new core folder)  
    * csv2post_notice() functions renamed to wtgcore_notice() and moved to wtgcore_reports.php
    * Range of new wtgcore_notice() functions to make it easier for applying a standard to the most common uses of notice boxes i.e. form submission, in panels and at the top of screens 
    * csv2post_templatefiles_missing() removed from main file to help increase performance
    * csv2post_create_dataimportjob_table() changed so that csv2post_updated column updates on manual edit
    * wtgcore_activate_logfile() no longer returns value and log file activation (form processing) no longer requires it
    * csv2post_sql_query_rowid_exists() now returns csv2post_id value and not the CSV file row ID value
    * csv2post_load_admin_arrays_templatesystem.php renamed to csv2post_load_admin_arrays.php
    * New file csv2post_logfile_array.php (log files will have their own headers which are stored in the $csv2post_logfile_array)
    * Log system now allows us to easily create custom logs for different purposes (more important for ideas we coming much later)
    * csv2post_data_prep_fromcsvfile_advanced() created, new use of the data prep function is for our first extension which is still being worked on
    
= 6.7.0 =
* Public Messages
    * Status page may temporary show as CSV 2 POST Install.
    * This versions changes are very technical. A lot of new functions have been added for two new systems; Table to Table data transfer and Extension (like modules) system 
* Fixes
    * Warning on csv2post_tab1_pagedata.php on line 152 fixed
    * Warning on csv2post_tab8_pagedata.php on line 13 fixed 
    * Added missing echo in csv2post_menu_csvfiles() function
    * Basic SEO panel was not saving (somehow the function handling the form submission had been deleted!)
    * Updating a single post using the post ID would fail in some circumstances
* General Changes
    * Manual post update using post ID: improvements made which do more checks to ensure project is in ready state and csv2post_sql_get_posts_record() improved, fixing a bug.
    * Encoding Settings panel added to the General Settings screen (testing only for now)
    * General Settings tab is displayed again on the Main page
    * New Schedule Settings tab on the Main page and panels moved from Schedule screen on Creation page to this new one (Main page focusing on initial setup as many users are missing these options)
    * Extension panel added to the General Settings screen, one setting allowing us to disable/enable use extensions 
    * Advanced Import Screen: options to continue initial import or reset progress counters to force manual updating
    * New tab added to Your Data page named Table to Table, it is used to transfer data from one table to another. The interface allows us to pair columns between the two tables.
    * Select Table Setup on the Create Data Import Jobs panel removed, this will be handled in another way. All data import jobs will begin with a new table and a transfer from that table to another table will take place. The tools to do that will come after the Data Import Job is setup.
    * Help URL values removed from menu array in csv2post_variables_tabmenu_array.php to make the array smaller
    * csv2post.php is more organised, planning to reduce number of variables in use slightly and number of core files
    * Function for building menu is more dynamic, now loops through menu array, this is a required change for extension ability
    * Extension system built into the plugin, a template extension will be provided later (extensions re-configure plugins menus and can display custom screens while hiding other CSV 2 POST screens)
    * New screen on Main page named Configuration Settings, settings that change how the plugin operates i.e. allow extensions or not
    * Server Status screen has new panel displaying Wordpress configuration values, the first shown are Blog and Database charset (first change towards preparing better encoding options)
    * New panel on General Settings named Admin Triggered Automation: the ability to perform actions while working on the plugins pages. The first ability is checking CSV files for updates which will happen constantly when active and while logged in. The purpose of this is to force events while we are actually working with the plugin which makes it easier to test everything. The theory is, if it works while logged in, it will work while logged out and will be triggered by the schedule system.
* Support Changes
    * No website support changes (ticket system,download area and more planned) 
* Technical Information
    * Function csv2post_include_form_processing_php() now requires user to be logged in and $_POST['csv2post_post_processing_required'] to be set. It includes csv2post_form_processing.php which is admin side only. Public side $_POST processing is done using approaches specific to the form submitted.
    * Variable used to skip form processing functions ($cont) moved out of csv2post_form_processing.php to the csv2post_core_functions.php file inside csv2post_include_form_processing_php() function.
    * initialise core admin only variables moved outside of the is_admin() argument for ease of access by custom extensions
    * WTG_C2P_PLUGINTITLE constant changed to a variable
    * csv2post_load_templatesystem_constants.php is being removed from package, contents moved to csv2post.php
    * Two different functions with the same purpose: csv2post_form_submission_processing() deleted, csv2post_include_form_processing_php() is the one in use
    * Tab menu array option is no longer in the option record array, this avoids problems when user deletes menu array in order to reset it
    * Removed $record_id variable and related argument from csv2post_data_import_from_csvfile_basic() as it is meant for the advanced version of this function
    * csv2post_get_option_publicset(): function unserialize() changed to maybe_unserialize()
    * csv2post_menu_tablecolumns(): new $id parameter added to facilitate use of the function in csv2post_tabletotable_list_column_menus() where a list of menus is created
    * ['active'] value in $csv2post_mpt_arr for screens is now coming into use, use it to disable screens (hides the tab also)
    * Removed csv2post_update_currentproject_array() function, it is empty and not in use
    * New folder added named "wtgcore", we are starting a library of Wordpress suitable functions for all of our plugins (we have many planned for the next few years but focusing on building foundations right now)
    * Removed ['name'] value from tab menu array, it was never used
    * We can now name screen files something unique i.e. "csv2post_schedulesettings.php" rather than csv2post_tab4_creation.php
    * Tab Menu Array: the ['active'] feature is now in use for all pages and csv2post_admin_menu() adapted for it
    * csv2post_date() can now be used to return a giving time value as formatted date
    * Tab Menu: a big change to the tab menu array $csv2post_mpt_arr. All tabs now have the ['path'] value and it is always used. We can use it to point to any file on the server. This approach initially came about in our first extension.
    * csv2post_data_prep() function added to csv2post_sql_update_record(), all imported data will go through csv2post_data_prep()
    
= 6.6.9 =
* Public Messages
    * I work on the plugin daily but right now I'm so busy I cannot reply to every email straight away. I do read them and feedback is noted. 
* Bug Fixes
    * None
* General Improvements
    * Remove Re-Install panel, Un-install panel must be used then standard Install
    * Graphics removed from Un-install panel, related functions and JavaScript also removed
    * Un-install panel now allows every change made to be un-installed (database tables, option records, folders, CSV files)
    * New Partial Un-Install panel lists all individual elements for removal
* Key Technical Improvements
    * csv2post_drop_dataimportjob_table() now in use for deleting tables on both Un-Install panel and Your Data page
* Known Issues
    * None
* Web Services, Support and Websites changes
    * None
    
= 6.6.8 =
* Public Messages
    * Thanks to everyone for all their help testing our new plugin. The bugs found are critical so another swift update.
* Bug Fixes
    * Post status was not being applied to post object   
    * Post type was not being applied to post object 
    * Single default author was not being applied
* General Improvements
    * Users can no longer attempt to create posts when they have not selected a title or content template. Notifications are displayed in Create Posts panel regarding this.
    * Can only use the file uploader to upload .csv files, notice confirms this on attempting to upload any other extension.
    * Further improvement to categories including default category now applied
* Key Technical Improvements
    * None
* Known Issues
    * None
* Web Services, Support and Websites changes
    * None
    
= 6.6.7 =
* Public Messages
    * Custom field keys with underscore at the beginning are hidden on the Edit Post screen i.e. _yoast_wpseo_title.
    * Posts are now assigned to a single category by default. If you want to apply all levels of categorie to a post, there is a new option for it.
* Bug Fixes
    * Blank titles in all posts
    * Default Post Excerpt template now saves when clicking on templates in the Default Excerpt Template panel
* General Improvements
    * Can now apply a single category or all categories to our posts, new option on categories panels
    * SEO screen now displays notification confirming SEO plugin detected
    * Changed notification regarding post type being "post" from a warning to info box to appear more friendly
    * Changed warning notification on Post Dates screen to an information box
    * Basic SEO Options panel text fields are now automatically populated with required values for recognised SEO plugins
    * SEO screen displays a warning notice if Basic SEO Options settings have not been saved yet
    * Theme Support screen checklist notifications are now the same size as other checklist notifications on other screens
    * Theme Support screen message regarding user not having setup required post type yet now makes more sense and does not have blank space where "post" should be
    * Better handling of interface output when templates that are set as defaults are deleted by user
    * Two image links remove from the Screens screen on the main page, they were for settings pages that no longer exist
    * Advanced Import screen now has menu for selecting ID column, however further work required on this and coming 6.6.8
* Key Technical Improvements
    * csv2post_categorysetup_advancedscript_normalcategories() changed to allow single or all categories applied to post
* Known Issues
    * Categories created by CSV 2 POST are sometimes hidden on the Categories screen for a short period of time. However posts are still assigned to the categories and the categories display alright on the Edit Post screen.
* Web Services, Support and Websites changes
    * Rewards now offered for providing key information on how to fix critical bugs on the troubleshooting page http://www.csv2post.com/support/troubleshooting-2
    
= 6.6.6 =
* Was skipped accidently by updating the free plugin with 6.6.6 when it should have been 6.6.5
    
= 6.6.5 =
* Public Messages
    * Some very critical fixes in this version. I feel our new plugin is finally become very stable thanks to the help of all users over the last few weeks.
* Bug Fixes
    * (minor) on installation user would be sent to a screen that no longer exists, users now sent to the main screen
    * (critical) default author setting fixed
    * (critical) category issues
    * (critical) made some changes to prevent the same record being used for all post titles
    * (minor) Uninstall process was appearing to fail, but was actually uninstalling    
* General Improvements
    * None
* Key Technical Improvements
    * the ['defaultauthor'] project value is now in ['authors'] node of the project array
* Known Issues
    * None
* Web Services, Support and Websites changes
    * New troubleshooting tutorial http://www.csv2post.com/troubleshooting-tips/activate-error-display-and-debug-mode
    
= 6.6.4 =
* Public Messages
    * None  
* Bug Fixes
    * (critical) Installation fault introduced in recent version
    * (critical) csv2post_createfolder() function created, adapted from csv2post_post_createfolder() until we figure out what went wrong
    * (minor) Undefined variable: per
* General Improvements
    * Data import screen and functions improvements
    * Improved notification on deleting database tables
* Key Technical Improvements
    * csv2post_form_createfolder() chmod parameter corrected
* Known Issues
    * None
* Web Services, Support and Websites changes
    * None
    
= 6.6.3 =
* Public Messages
    * Sorry for incorrect version number in previous release. I was playing around with it to trigger new version notifications. Forgot to change it back!  
* Bug Fixes
    * (minor) plugin was still attempting to include csv2post_variables_easyset_array.php which is no longer packaged
* General Improvements
    * Data import jobs panels now show a range of statistics (maybe a little too much but we can work on that)
* Key Technical Improvements
    * maybe_unserialize() now used in csv2post_load_initialplugin_configuration.php instead of if statements
    * csv2post_form_importdata() now requires full file name (with .csv) to be submitted, job panels have been changed
* Known Issues
    * None
* Web Services, Support and Websites changes
    * None
    
= 6.6.2 =
* Public Messages
    * We can make CSV 2 POST do anything you need, just let us know what that is
* Bug Fixes
    * (critical) post updating problem fixed
    * (minor) links in notifications had http:// prepended twice
    * (critical) problem saving post content templates with only one type/use selected
    * (critical) post tags in free edition were not being applied
    * (critical) same record being used many times during post creation
* General Improvements
    * More page is now hidden, we will display it when most web services and community features are 100% complete
    * Improved CSS for notification links (the blue arrow)
    * Notifications now have rounded corners
    * Easy configuration question answers no longer stored in their own option record, reducing installation requirements and use of options table
    * New screen named Undo on the Your Creations page (will allow the reversal of changes made by projects)
    * New screen named Flagged Posts on the Your Creations page. It will show posts with issues and offer tools to correct them.
* Key Technical Improvements
    * csv2post_variables_easyset_array.php file removed, the $csv2post_easy_set array is now held in $csv2post_adm_set['easyconfigurationquestions']
    * Removed folder named base and moved containing files into the panels folder
    * New folder added to panels folder named themesupport, it will hold a file for each supported theme 
    * Added parameter to csv2post_sql_used_records() for changing the selected columns, making it more effecient
    * csv2post_sql_query_records_last_update() now returns a value instead of an array, was causing errors in csv2post_posts_autoupdate()
* Known Issues
    * URL http//www.csv2post.com/support is offered in help links, despite this url not being in the plugins code, the ":" is being removed somehow
* Web Services, Support and Websites changes
    * None
     
= 6.6.1 =
* Public Messages
    * We have a new baby girl weighing 7lb, named Kiera, born 22nd August 2012 at 03:12.
* Bug Fixes
    * (minor) CSV file table column indicating if a table has been used now shows correct result
    * (critical typo) variable in csv2post_create_postdraft_basic() spelled incorrectly ($project_codem should be $project_code)
    * (minor) Removed the use of $posts_target from post creation function in free edition as there is no user set target
    * (critical) further correction in the ability to apply custom post publish dates
* General Improvements
    * Settings page removed, settings tabs are now on the Main page (this is to make more use of Main page and encourage users to use settings first)
    * RSS subscription box now subscribes to the Updates/News category on www.csv2post.com only, not the entire website
    * Global setting added to schedule screen for activating Constant Post Content Updating
    * Can now reset a used table (removes post ID's) by selecting it again for the creation of a Post Creation Project
    * When table selected for reset, we can also opt to delete posts related to the selected table
    * Plugin establishes number of columns in a file better when user does not enter a number on the Job Creation form
* Key Technical Improvements
    * Schedule function csv2post_event_action() does not add_action for updating opened posts if user activated the new Constant Updating ability
    * add_action('the_posts', 'csv2post_posts_autoupdate' ); is also in main file so user can systematically and constantly update post content
* Known Issues
    * None
* Web Services, Support and Websites changes
    * None
    
= 6.6.0 =
* Public Messages
    * Big thanks to everyone for feedbacking, Tyler Smith for his patience and Al for offering complete code to add to the plugin
    * I have decided to design panel content wider than I have until now, wider tables and more horizontal fluidic forms so that we can make better use of larger screens (please give feedback on this)
* Bug Fixes
    * (minor) Default category selection is now displayed in menu (was always saving, just not being shown as so in menu)
    * (critical) $cat_term variable in category function loop was not being unset (causing levels 4 and 5 category creation with the level 3 term even if 4 and 5 not set)
* General Improvements
    * New tab added to Your Projects page named Authors
    * Default author selection now possible (advanced author import and assignment coming soon)
    * Can setup post excerpt by creating a template and selecting Post Excerpt in types menu
    * Post status can now be selected on a projects Creation panel (Your Creation page)
    * New panel named Delete CSV Files on the Your Data page, Start screen
    * Added a panel on Categories for the Ultimate Taxonomy Manager plugin as requested from Albert (more testing required)
* Key Technical Improvements
    * Advanced post creation now makes use of csv2post_post_poststatus_calculate()
    * csv2post_get_contenttemplate_design() renamed to csv2post_get_template_design()
* Known Issues
    * (minor) Lightbox type overlay applied by jQuery UI dialogue, on 2. Your Projects page, appears to have two overlays (there is a light gap between two of them)
* Web Services, Support and Websites changes
    * None
   
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
