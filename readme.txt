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

CSV 2 POST, data import and post creation plugin new for 2012.

= Versus Other Imports =
CSV 2 POST offers a stand-alone solution for data importing with or without post creation. It is
easily customised to import data to existing database tables and can create posts using any tables in your database.
The flexability of this approach offers endless potential and is usually safer than a direct import to the wp_posts
database table or instant post creation straight from a CSV file.

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

= When was CSV 2 POST Beta released? =
This plugins development begun at the end of 2011 and the Beta was released June 2012.

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

== Screenshots ==

1. Start by creating a Data Import Job and import your CSV files data to a new database table created by CSV 2 POST. We have the potential here to import to existing tables and more.
2. Create templates for placing your data into post content. Templates are stored under a custom post type so many templates can be created. This gives us the potential to apply different designs based on specific conditions.
3. You can even create title templates, so you do not need pre-made titles, just suitable columns of data to create a title string from. These templates are stored under a custom post type.
4. Set the type of posts you want to create. Many plugins and themes will require you to create a different type of post, something CSV 2 POST will do easily.
5. This screenshot shows "Basic Custom Field Rules", paid edition has advanced features but most users require the basic form which allows you to create post meta with any data.
6. You can use up to 3 columns of data to create 3 levels of categories.
 
== Changelog ==
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
    
= 0.2.3 =
* Public Messages
    * This update includes changes for both paid and free editions
    * Good luck to all countries in the Olympics, but being British I especially want to see us getting more golds this time around 
* General Improvements
    * Plugin now supports PHP 5.2 
    * New random value shortcode panel added as part of text spinning (text spinning ability test and working well)
    * New advanced shortcode called "csv2post_random_advanced"
    * New basic shortcode called "csv2post_random_basic"
* Bug Fixes
    * Error regarding ksort() in function csv2post_get_array_nextkey()
    * Undefined function csv2post_exit_forbidden_request() (function and function called was removed)
    * PHP 5.2 related bugs have been fixed
    * csv2post_get_template_bypostrequest() was not handling post ID properly (breaking content template design type menu)  
* Technical Improvements
    * Panel added for displaying $csv2post_textspin_array dump on the Text Spinning screen
    * add_shortcode function is now being used in CSV2POST.php
    * Error regarding ksort() in function csv2post_get_array_nextkey(), returning from function if no array passed now (will also log the event)
    * Function csv2post_exit_forbidden_request() removed
    * Content template design types are now stored as individual meta values (not a comma seperated string)
* Known Issues
    * Lightbox type overlay applied by jQuery UI dialogue, on 2. Your Projects page, appears to have two overlays (there is a light gap between two of them)
* Web Services, Support and Websites changes
    * Updated specifications page

= 0.2.2 =
* Public Messages
    * Our heart goes to the victims in Colorado especially the 4 month old baby and 6 year old girl.
* Bug Fixes
    * Undefined variable $csv2post_is_free when creating post creation project
    * Undefined variable $csv2post_is_free on More page
* General Improvements
    * Google Ads removed from free edition
    * New notification boxes called "Next Step" boxes introduced to free and paid edition to help guide user (they will slowly be added throughout the plugin)
    * Corrected html header mistake causing h4 to be applied to entire paragraph on About screen
    * csv2post_check_requirements no longer calls fsockopen() to check for an internet connection (not needed yet)
    * Reduced number of variables loaded in main file for development purposes in the aim of less memory usage
    * Files and variables for the automated system now load during public visits to the blog (not just admin side)
    * Panel added to show scheduled eventa history times and counters
    * Panel added to Schedule tab on Your Creation screen: Event Types (used to control what types of event are run during automated scheduled processing)
    * Schedule screen will display various notices indicating if the schedule cannot run and why so that users may take action
    * Spelling mistake on Create Project panel "Immport"
    * Event Types panels help url added: http://www.csv2post.com/hacking/event-types
    * Default page for all View More Help buttons is now the main support page on plugin website: http://www.csv2post.com/support
    * Button with "Multiple Key Columns" on the Create Post Creation Project has been removed, it will not be supported until later due to the complexity of the feature
    * Added new column with menu to the Create Post Creation Project panel, inside the tables list, for selecting a key (creates relationship between multiple tables)
    * New html table column on Create Post Creation Project panel was removed, decided a new panel required to handle multiple file configuration
    * New panel called Multiple Table Project for configuring the relationship between selected project tables
    * New images for "Next Step" notification boxes, CSS styling and csv2post_notifications function updated
    * Removed panel named "Database Tables Mapping" from Project Data screen, it is now on main Projects screen and called "Multiple Table Projects" 
* Technical Improvements
    * csv2post_event_decide() now allows event types to be excluded totally (interfacing coming for user configuration)
    * Critical change when using multiple database tables in a project, plugin now determines if a project table was selected with required columns else it creates one
    * csv2post_notifications function now stores the $csv2post_notice_array in wp_options table (used for persistent messages)
    * jQuery UI tab script updated to display the hash and tab number in url
* Known Issues
    * Adding tables to a project that were not created by this plugin are not handled properly, this will be worked on soon
* Web Services, Support and Websites changes
    * Support page updated: http://www.csv2post.com/support
    * New page explaining Multiple Table Project panel: http://www.csv2post.com/feature-guides/multiple-table-project-panel

= 0.2.1 =
* Public Messages
    * Donations help to continue this project, even $5.00 makes a difference, send to paypal@csv2post.com
* Bug Fixes
    * Field count was not being submitted for some selected CSV files
* General Improvements
    * None
* Web Services, Support and Websites changes
    * None

= 0.2.0 =
* Bug Fixes
    * A data import update query was fixed
* General Improvements
    * Database names are no longer kept in the list of created tables after being deleted
    * Users must delete Data Import Job before deleting a jobs database table
* Web Services, Support and Websites changes
    * None
* Public Messages
    * None
    
= 0.1.9 =
* Public Messages
    * Happy Bastille Day, just make it a weekend
* Bug Fixes
    * Missing file warning for a file no longer included in package
* Interface Improvements
    * Message regarding missing files now includes the expected path
* Web Services, Support and Websites changes
    * Plugin no longer checks web service status, not required until web services are complete

= 0.1.8 =
* Public Messages
    * Thanks to Eric from Quebec for days of good feedback
* Bug Fixes
    * Error related to csv2post_sql_query_unusedrecords_singletable() missing parameter
* Interface Improvements
    * None
* Web Services, Support and Websites changes
    * New YouTube video, a lot more to come: http://www.youtube.com/watch?v=uGA8R0PVR8M
       
= 0.1.7 = 
* Added support to read CSV files using 2 different methods: PEAR CSV and fget/fgetcsv (each method often suits different files or purposes)
* Can select files separator on the Test CSV File panel
* CSV file test now uses PEAR CSV and php fget function to count columns
* CSV file test compares user submitted separator (if any) with PEAR CSV and fget method separators
    
= 0.1.6 = 
* Bug fix in reading CSV file columns for none comma files
    
= 0.1.5 = 
* Further improvements made for manually applying separator and quote
    
= 0.1.4 = 
* BETA Edition
    * Interfaces for paid edition were being hidden in the paid edition, but should only be hidden in free edition
    * jQuery UI tabs now hold their state when submitting forms
    * jquery.cookie.js added to bundle
    * Done some work on how the plugin handles separators and establishing the correct one, plus warning users of any issues

= 0.1.3 = 
* BETA Edition
    * Plugin no longer uses wp_die when PHP 5.2 in use, a notification is displayed instead
    * Improved the use of deactivate_plugins( 'csv-2-post' ) when PHP 5.2 detected (plugin requires 5.3)

= 0.1.2 = 
* BETA Edition
    
= 0.1.1 = 
* BETA Edition
    * Reduced the number of files, including the removal of some jQuery UI themes. The plugin size was too large, mainly caused by png images.
    * Complete readme.txt including screen-shots being added to the package

= 0.1.0 =
* BETA Edition
    * Activation errors detected when blog is not using PHP 5.3, error is fixed and now a clear message is displayed
