=== Plugin Name ===
Contributors: Zara Walsh,WebTechGlobal
Donate link: http://www.csv2post.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: CSV 2 POST, CSV2POST, wordpress data import,wordpress data importer,auto blogging,auto blogger,autoblog,mass create posts,mass post creation,csv file importer,csv file data import,post injection,import spreadsheet,excel file import,excel import,www.csv2post.com,CSV2POST,wordpresscsv import,wordpress import plugin,wordpress data import tool,wordpress data import plugin,wordpress post creation plugin
Requires at least: 3.3.1
Tested up to: 3.5.1
Stable tag: trunk

CSV 2 POST

== Description ==

CSV 2 POST is a growing box of tools for auto-blogging and managing imported data. 
Everything added to this plugin is at the request of users who know best including professionals developing true money 
making websites and even well known companies have made use of CSV 2 POST to help with administration. Those
include CBS News and Ryanair Ltd. They come to us because
other plugins which offer a step by step system and assume a lot about what the user wants done with their data
are simply not good enough. 

CSV 2 POST has been designed to out-perform other importers and we have done that with the help of the Wordpress
community who use them all. We include a step-by-step system like most (possibly all) other plugins available,
which takes users through the same process on every single use, every single website no matter what theme or plugins
we use. However our main interface is more of a workshop or a sandbox and in this sandbox are endless tools, some
are not obvious because it's hard putting them all on one interface without making it feel over complicated.

= Support = 
The plugin is supported by a dedicated
website at [www.csv2post.com](http://www.csv2post.com/). The interface offers a "Help" button beside every feature. A small hint 
is giving and users can click another button to open a page on www.csv2post.com specific to the feature
the user needs help for. Some pages will have video tutorials and screenshots. The online support content is free. We
also plan to create help content specifically for the free edition so that it is truly supported.

= Our Mission =
It is very important to us that we deliver a useful free plugin for the Wordpress community to use and not
deliver software that behaves like a trial in order to advertise our paid edition. To ensure we do not make that
mistake as we have done before, we encourage all potential customers who email us to try the free edition, unless
thier project is unique and requires changes to the plugin. We have a very long term plan for CSV 2 POST, both free 
and paid. Most of the time a new feature begins on the free edition and grows in the paid edition. This is how
we ensure full respect to Wordpress is giving. If you budget is tight just say

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

= 6.9.3 =
* From The Developers
    * Released 26th March 2013
* Fixes     
    * No longer attempts to process CSV file upload more than once. 
    * Processing a CSV file twice caused an existing copy of the file to be deleted rather than replaced, causing errors as there is no file for certain interface features that expect the file to be present.
* Feature Changes
    * Create Data Import Job Panel: removed jQuery UI styling for radios/checkboxes
* Support Changes
    * 
* Technical Changes
    * 
    
= 6.9.2 =
* From The Developers
    * Massive changes to file structure again. The last phase of preparing a multi-plugin core is 99% complete so this will not happen again.
    * A big change in our approach with the free edition. We want the free edition to focus on our Easy CSV Importer approach and steer uses away from an advanced/complex sandbox GUI.
* Fixes     
    * Many users may see improvement in reading/importing CSV file data. The default method is a new method not previously used in CSV 2 POST.
* Feature Changes
    * Form dialog popups when clicking Submit are now hidden by default. A late setting in place for panel/form arrays will be used to force the dialog to show where we feel the user needs a prompt.
    * General Settings: yet more changes, sorry folks. Some confusion reading instructions led to incorrect settings changes. General Settings was meant to be the settings screen for all of our plugins using the same core. It has been changed to reflect this. Plugin related settings, in this case CSV 2 POST are on other screens. 
    * Data Settings and Post Settings screens added to the Main Page for holding CSV 2 POST options
    * Video updated on About screen
    * New option and change to function that allows different CSV read method as the current does not work with all hosting/servers
* Support Changes
    * Demo Blogs: www.csv2post.com home page, last section, now offers a link to a new demo portal at www.csvtopost.com. 
* Technical Changes
    * WTG Core: more files added
    * WTG Core: final phase to creating a core using CSV 2 POST functions that will be used in many plugins is 99% complete. The other 1% will be complete when we use the core to create another plugin for the first time.
    * Many functions moved from "include" folder to wtg-core, almost done preparing the wtg-core to be used in more plugins
    * Many functions that were added during development but never used have been removed
    * Removed all instance of WTG_C2P_CONURL, it was never actually used and possibly contributes to the error showing "SELECT option_name, option_value FROM wp_options WHERE autoload = 'yes'"
    * csv2post_data_import_from_csvfile_basic() now uses fgetcsv() by default and can be switched to PEAR CSV in options
    
= 6.9.1 =
* From The Developers
    * Released 11th March 2013
* Fixes     
    * None 
* Feature Changes
    * Easy CSV Importer: now sets the 'Current Project' properly. This allows user to move away from ECI to the Your Projects page and finish or update their project there.
    * Easy CSV Importer: projects created on ECI screen are named using filename only (date and time no longer included)
    * Easy CSV Importer: using the same file twice deletes an existing project as it shares the same project name. The intention is for anyone restarting not to have difficulties. Any user looking for the ability to keep the older project despite using the same file simply needs to use the sandbox screens and not use ECI.
    * Easy CSV Importer: Ping and Comment options added to ECI step 2 as the form submission also creates project
    * Easy CSV Importer: Confirm CSV File Format panel renamed to 'CSV File and Post Creation Setup'
* Support Changes
    * New Video: http://www.youtube.com/embed/gNwD-36ilWo (Content Template WYSIWYG Editor Tutorial)
    * New Video: http://youtu.be/ydF1bqI-FtM (Title Templates)
    * New Video: http://www.youtube.com/embed/5Dm-LbywiE0 (Post Update Settings)
* Technical Changes
    * ['panel_intro'] removed from all files
    * $panel_intro removed from all files
    
= 6.9.0 =
* From The Developers
    * Released 9th March 2013
* Fixes     
    * New category screen was adding form start when form was not needed, causing bug on post creation screen 
* Feature Changes
    * Added select all checkboxes to the Partial Un-Install panel
* Support Changes
    * None
* Technical Changes
    * None

= 6.8.9 =
* From The Developers
    * Released 6th March 2013
* Fixes     
    * Interface Failure: Theme related option new in recent version not added to the Update process. The fact that the setting is not initialized breaks the interface. 
* Feature Changes
    * None
* Support Changes
    * None
* Technical Changes
    * None
    
= 6.8.8 =
* From The Developers
    * Released 6th March 2013
* Fixes     
    * Critical fix that would cause error when submitting any form 
* Feature Changes
    * None
* Support Changes
    * None
* Technical Changes
    * None
    
= 6.8.7 =
* From The Developers
    * Released 6th March 2013
    * Time has gone into making the plugin lighter so that the package is smaller and the interface loads quicker. These are big changes, try this new version on a test blog and backup existing installations.
* Fixes     
    * Removed the duplicate options on Event Types panel for Post Creation 
* Feature Changes
    * Log system changed to database storage instead of files, related settings and features for files removed, related functions adapted
    * Ping (open or closed) option added to the create new post creation project panel
    * Comments (open or closed) option added to the create new post creation project panel
    * WYSIWYG editor has been added to the content template screen again
    * Panels no longer have intros (making way for more buttons including a new Video button)
    * Panel Help buttons renamed to Info, the intention is to show more dynamic information in some panels
    * Improved layout of Update screen  
    * Plugin Theme accordion panel has been renamed to Plugin Theming and no longer offers switching between jQuery themes. Instead it allows switching between jQuery UI and Wordpress styling
    * Easy Configuration Questions tab/screen now hidden, we have decided to focus on the Easy CSV Importer screen so free users can just get straight into importing and creating posts  
    * Interface Settings panels moved to General Settings in order to condense things a little and Interface Settings screen is hidden until we have a better use for it
    * 'Your Server Status' tab renamed to Config (plan to add more information about the variables that configure the plugin)
    * Install page Config tab now shows a lot more variable values, mainly for developers
    * Main page title will now show "CSV 2 POST Free Edition" and "CSV 2 POST Premium Edition" to help avoid confusion
    * Free edition will once again apply random codes for Data Import Jobs and Post Creation Projects rather than using "freeproject". This will make hacking easier among a lot of code that is designed for just this as it is in paid edition.
* Support Changes
    * New Users Page on www.csv2post.com, get your site listed here http://www.csv2post.com/developers/plugins-users
    * New Video (Categories): http://www.youtube.com/watch?v=gkmY31MycsA
    * New Video (Create Job): http://www.youtube.com/watch?v=58WipF9Vo98
    * Subscription form removed from Updates screen on main page
    * New RSS feed added to Update screen (Freelance.com jobs posted by us, there will be many for CSV 2 POST)
* Technical Changes
    * ['intro'] text removed from all panels
    * Removed "templatesystem" folder and path (contents of folder now in main plugin folder)
    * Removed plugin status images, they will be used for premium service accounts only from here on
    * Removed "validationengine" folder from css folder
    * Removed fileuploader.css from css folder
    * Removed "themethumbs" folder
    * $csv2post_theme_array no longer in use
    * ['vertical'] is no longer in use in tab menu array, css for it removed also
    * $csv2post_mpt_arr['menu']['main']['slug'] now has a value of 'csv2post', previously it was a NULL variable
    * csv2post_tabnumber changed to csv2posttabnumber in csv2post_get_tabnumber()
    * Moved csv2post_ADDACTION_admin_init_registered_scripts() from core file to script parent file
    * Moved csv2post_print_admin_scripts() from core file to script parent file
    * WP_DEBUG_DISPLAY added to csv2post_debugmode()
    * WP_DEBUG_LOG added to csv2post_debugmode()  
    * $csv2post_adm_set['ecq'] now set to array() as default, the $csv2post_eas_set array was been removed  
    * $csv2post_easyquestions_array shortened to $csv2post_ecq_array 
    * $csv2post_adm_set['easyconfigurationquestions'] changed to $csv2post_adm_set['ecq']
    * Panel help button function renamed to csv2post_panel_support_buttons() and the div wrapping the function is now inside this function to prevent the div being used when no buttons are in use
    * CSS inside panels has been changed to reduce empty space and make more use of the page, important on screens with many panels or wide tables inside panels
    * csv2post_load_arrays.php deleted, contents moved to csv2post.php
