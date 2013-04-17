=== Plugin Name ===
Contributors: WebTechGlobal,Zara Walsh,Ryan Bayne
Donate link: http://www.csv2post.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: CSV 2 POST, CSV2POST, Data Engine, CSV 2 POST Data Engine, wordpress data import,wordpress data importer,auto blogging,auto blogger,autoblog,mass create posts,mass post creation,csv file importer,csv file data import,post injection,import spreadsheet,excel file import,excel import,www.csv2post.com,CSV2POST,wordpresscsv import,wordpress import plugin,wordpress data import tool,wordpress data import plugin,wordpress post creation plugin
Requires at least: 3.3.1
Tested up to: 3.5.1
Stable tag: trunk

CSV 2 POST Data Engine

== Description ==

Do you need to create hundreds, maybe thousands of pages within minutes?

CSV 2 POST exists to auto-blog...

Not just posts, maybe you need pages or a custom post type and with featured images?

CSV 2 POST can handle it...

Do you also want your posts to have all the correct custom fields (meta data) for your theme, any theme?

CSV 2 POST loves all themes...

Are you going to need those post put into correct categories, maybe create the categories automatically?

CSV 2 POST likes to keep blogs organized...

Have you considered some text spinning, URL cloaking and scheduling to create a more natural blog for Google?

CSV 2 POST premium is on stand by if your needs are far above average...
    
    
= About Our Plugin =
CSV 2 POST is a growing box of tools for auto-blogging and managing imported data. 
Everything added to this plugin is at the request of users who know best including professionals developing true money 
making websites and even well known companies have made use of CSV 2 POST to help with administration. Those
include CBS News and Ryanair Ltd. They come to us because
other plugins which offer a step by step system and assume a lot about what the user wants done with their data
are simply not good enough. 

This data engine has been designed to out-perform other importers and we have done that with the help of the Wordpress
community, who have been outstanding. We include a step-by-step system like most (possibly all) other plugins available,
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
Long term plans for the development of CSV 2 POST Data Engine will add an endless list
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

= 6.9.5 =
* From The Developers
    * Released 18th April 2013
    * WARNING: due to the amount of changes in this version and how complex they are. There is no ability to modify existing installations. If anyone wants to update their exisitng installation, please backup your database. Request update script if you run into issues on attempting to update. 
    * Work has already begun for the support of Wordpress 3.6 beta including new options for Post Format
* Fixes     
    * CSV Read Method option now displays the saved setting (option worked, it just did not reflect users save on the form)
    * Quick Start: a lot of improvement overall including a bug that caused  mixup of settings when using the same CSV file two or more times. This applies to the Quick Start screen only.
    * CSS GUI Mode: when jQuery not in use, a bug caused issues on the Data Import page and it disabled a lot of functionality. CSS Mode is a secondary option still in development but this fix should allow it to be used even if the styling ain't perfect yet
    * CSS GUI Mode: install screen now displays the CSS only menu
* Feature Changes
    * Cleaned up table/column selection menus by hiding "csv2post_" columns and if only one table is in use the table is also removed from options
    * Post Types screen renamed to Post Settings. It holds the new Post Format option.
    * Project Data screen renamed to "Info" in order to use reduce the menu and use this screen a bit more by merging other screens into it
    * Project History screen removed and the history will now show on the new Info screen which holds general project information
    * Post Format option added to the sixteenth panel "Extended Theme Support", on the Quick Start screen
    * Custom post status can now be selected. The text display on post status buttons have also changed.S
    * Basic SEO form fields will not default to the last plugin in our SEO plugin array when no plugin is installed, currently Yoast.
    * Extra SEO Plugins Support panel: added a panel which lists SEO plugins that have "extra" support with links to their sites
    * Were now setting more form defaults, starting with Quick Start which now has default radio/checkboxes etc. This will speed up use.
    * Improvements made to the Quick Start
    * Dates Screen: general improvements including a menu for selecting the format of dates data to avoid conflict with UK, US and MySQL formats
    * Default Post Content Template: this panel now shows less information if the user is working with a single project. If a user delets their test projects, it will keep the panel in a state of minimum information. A small change to help reduce GUI complexity.
* Support Changes
    * Removed Post Creation Video (http://www.youtube.com/embed/b1K__laYifc) as it was really meant to explain the big change in our approach, I will get a more direct tutorial made soon
* Technical Changes
    * Some user friendly improvements made
    * URL Cloaking Panel: improved the panels handling of determing applicable columns
    * SEO plugins array moved from tab3_pageprojects.php to csv2post_seoplugins_array.php
    * Paid edition inclusion lines have been moved up and are included under free edition include
    * Quick Start: can remove the two lines for dialog now (we will be removing those lines for many panels to reduce amount of text)
    * Moved csv2post_post_poststatus_calculate() to be called before csv2post_create_postdraft_advanced() in csv2post_create_posts_advanced()
    * csv2post_update_option_postcreationproject() is now only called in csv2post_post_publishdate_advanced() when user has selected a date method, this will reduce processing a little
    * csv2post_post_update_metadata_basic_seo() improved, possibly a premium edition fix.
    * Merged csv2post_post_add_metadata_advanced() and csv2post_post_update_metadata_advanced() to become csv2post_post_customfields(), using update_post_meta() instead of add_post_meta() for all purposes. This makes it easier to maintain.
    * Update for custom field 'csv2post_last_update' is now done within csv2post_post_updatepost()
    * Update for custom field 'csv2post_outdated' is now done within csv2post_post_updatepost()
    * Added table exclusion array on Your Projects, Projects screen. Plugin no longer queries tables as if they were created for post creation projects. This clears up some annoying Wordpress errors which are not critical but alarm users should they activate error display.
    * Quick Start step 2 submission process was sharing $code for two different purposes. A loop was populating $code with old project code and preventing a new code being used instead. This caused bad behaviour in Quick Start when using the same file a second time.
    * Screen file csv2post_tab4_install.php and csv2post_tab5_install.php deleted. Entries in menu array also removed. These screens were not yet in use and will not be in use for many weeks.
    * New columns added to Data Import Job tables. csv2post_cat1 through to csv2post_cat5. These are for category splitting i.e. we will split a single column of categories into multiple columns. This way the user can use all category tools that expect multiple columns.
    * Excerpt function now requires $my_post object and returns it
    
= 6.9.4 =
* From The Developers
    * Released 26th March 2013
* Fixes     
    * Corrected installation issue, somehow we have reversed a previous fix so we are sorry about that. We have recently changed to Windows 8 and experiencing FTP issues.
* Feature Changes
    * Easy CSV Importer screen renamed to Quick Start in response to feedback
* Support Changes
    * None
* Technical Changes
    * None
    
= 6.9.3 =
* From The Developers
    * Released 26th March 2013
* Fixes     
    * No longer attempts to process CSV file upload more than once. 
    * Processing a CSV file twice caused an existing copy of the file to be deleted rather than replaced, causing errors as there is no file for certain interface features that expect the file to be present.
* Feature Changes
    * Create Data Import Job Panel: removed jQuery UI styling for radios/checkboxes
* Support Changes
    * None
* Technical Changes
    * None
    
= 6.9.2 =
* From The Developers
    * Massive changes to file structure again. The last phase of preparing a multi-plugin core is 99% complete so this will not happen again.
    * A big change in our approach with the free edition. We want the free edition to focus on our Quick Start approach and steer uses away from an advanced/complex sandbox GUI.
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
    
