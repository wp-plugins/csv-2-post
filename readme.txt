=== Plugin Name ===
Contributors: WebTechGlobal
Donate link: http://www.csv2post.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: CSV 2 POST, CSV2POST, Data Engine, CSV 2 POST Data Engine, wordpress data import,wordpress data importer,auto blogging,auto blogger,autoblog,mass create posts,mass post creation,csv file importer,csv file data import,post injection,import spreadsheet,excel file import,excel import,www.csv2post.com,CSV2POST,wordpresscsv import,wordpress import plugin,wordpress data import tool,wordpress data import plugin,wordpress post creation plugin
Requires at least: 3.5.0
Tested up to: 3.6.0
Stable tag: 7.0.1

CSV 2 POST Data Engine

== Description ==

Do you need to create hundreds, maybe thousands of pages within an hour?

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
CSV 2 POST is the ultimate CSV importer, a true web tool for auto-blogging and managing imported data.
We have created an electronic quill, not a pen, not a pencil...a quill. Everything added to this plugin is at the request of users 
who know best including professionals developing true money 
making websites or simply hosting large amounts of information as part of their service. Well known companies have even made use of CSV 2 POST 
to help with administration. It is a fact that CSV 2 POST is in use by Ryanair Ltd staff every day for a very specific admin task. So
you need to ask yourself why, right?!

The reason why is that they come to us because we cut out the BS. You won't see any of these 'Build sites in 15 minutes' sales pitches on our website and
our free edition does not fail to provide basic functionality such as Featured Images. Two or three years down the road we want users
of the free edition to tell us how their site is a booming success and it started with our plugin. The premium plugin
and services will do that without a doubt but our goal is to ensure our free edition is an impressive addition to the Wordpress.org
plugin site.

= Support =
The plugin is supported by a dedicated website at [www.csv2post.com](http://www.csv2post.com/). Most online support content is free. We
provide a higher level of priority to premium users. We recommend free users use the plugins forum on Wordpress.org and paid users email us.

= Our Mission =
It is very important to us that we deliver a useful free plugin for the Wordpress community to use and not
deliver software that behaves like a trial in order to advertise our paid edition. To ensure we do not make that
mistake as we have done before, we encourage all potential customers who email us to try the free edition, unless
thier project is unique and requires changes to the plugin. Development for CSV 2 POST will continue past 2014 and 
the plugin core will be shared with other plugins which will push CSV 2 POST further than other importers.

== Installation ==

Initial upload and activation as guided by Wordpress.org standard plugin installation.

1. Delete existing `csv-2-post` folder in `/wp-content/plugins/` (or delete plugin on Wordpress Plugins screen)
1. Upload the `csv-2-post` folder to the `/wp-content/plugins/` directory (or upload using Wordpress Plugins screen)
1. Activate the CSV 2 POST plugin through the 'Plugins' menu in WordPress
1. Configure the plugin by going to the Settings screen
1. Always backup your database before mass creating posts
1. Always backup your database before updating the plugin
1. You may upload CSV files using FTP to the /wp-content/wpcsvimportercontent/ folder to use them with CSV post

== Frequently Asked Questions ==

= Are custom fields supported? =
Yes

= Are the new Wordpress 3.6 Post Formats supported? =
Yes

= Can I create custom post types, not just post or page? =
Yes

= Can I create categories? =
Yes

= Is there a limit to the number of posts I can create? =
No

= Does the plugin have free support? =
Yes

= Is the plugin compatible with ShopperPress? =
Yes

= Is the plugin compatible with ClassiPress? =
Yes

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
Yes. We hope to be adding new features until 2015 and updating it for compatability with Wordpress for many years.

= When was CSV 2 POST Beta released? =
The plugin was released 2009 and re-developed from scratch in 2012. 

== Screenshots ==

1. Start by creating a Data Import Job and import your CSV files data to a new database table created by CSV 2 POST. We have the potential here to import to existing tables and more.
2. Create templates for placing your data into post content. Templates are stored under a custom post type so many templates can be created. This gives us the potential to apply different designs based on specific conditions.
3. You can even create title templates, so you do not need pre-made titles, just suitable columns of data to create a title string from. These templates are stored under a custom post type.
4. Set the type of posts you want to create. Many plugins and themes will require you to create a different type of post, something CSV 2 POST will do easily.
5. This screenshot shows "Basic Custom Field Rules", paid edition has advanced features but most users require the basic form which allows you to create post meta with any data.
6. You can use up to 3 columns of data to create 3 levels of categories.

== Changelog ==
= 7.0.1 =
* From The Developers
    * Released 30th June 2013 
* Fixes     
    * Quick start title fix for files with uppercase
    * Featured image in Quick Start improved
    * Tags in Quick Start improved 
* Feature Changes
    * Removed some links pointing to the premium edition
    * Dates panel removed (was never meant to be there)
* Technical Notes
    * Schedule system setting now within the main admin settings array and schedule array file deleted
    
= 7.0.0 =
* From The Developers
    * Released 26th June 2013
    * If installing via FTP please delete the existing plugin first, enjoy :) 
* Fixes     
    * None
* Feature Changes
    * Support buttons made smaller by using Wordpress styles instead of jQuery UI theme styles
    * New diagnostic system started, the old one was a group of splintered functions, wtgcore_wp_diagostics.php created for the new approach
    * csv2post_notice() now checks if user is adminstrator straight away, this is a security measure
* Technical Notes
    * None
    
= 6.9.9 =
* From The Developers
    * Released 31st May 2013
* Fixes     
    * Post Formats: fixed a bug in new Post Format function call (a new feature pending for Wordpress 3.6)
    * Updating jquery.multi-select.js may fix faulty tab menu experienced by some users
    * Switched from raw.github script loading to local jquery.multi-select.js file, strict mimi types causes issue using raw
    * Tokens are now replaced properly, some users were reporting the shorter token made easier for free edition not being replaced
* Feature Changes
    * None
* Technical Notes
    * Added more security to function csv2post_save_meta_boxes_flags()
    * Added more security to function csv2post_save_meta_boxes_contenttemplates()    
    * Updated jquery.multi-select.js
    * Updated jquery.cookie.js
    
= 6.9.8 =
* From The Developers
    * Released 27th May 2013
* Fixes     
    * Fix related to extension loading procedure
* Feature Changes
    * New Log screen (general history logging)
    * New Flags screen (basically an alert system but also acts an administration task list) 
    * Log/History panels and pages removed, all log entries will now be displayed on a single screen
    * Open Template For Editing: this panel has been removed, we are focusing on using C2P Content custom post type for editing templates
    
= 6.9.7 =
* From The Developers
    * Released 13th May 2013
* Fixes     
    * Missing file added csv2post_seoplugins_array.php 
* Feature Changes
    * None
            
= 6.9.6 =
* From The Developers
    * Released 10th May 2013
    * Wordpress 3.6 and jQuery updates have forced some key changes regarding the plugins theme and menu but the good thing is that we are prepared. Please back up your Wordpress files and database before updating.
    * Free edition reduced to the Quick Start screen. Feedback suggests that a free plugin is expected to be a bit more basic so that it is easier to use. Improvements will continue to be made to free features.
* Fixes     
    * Quick Start: the late addition of a WYSWYG editor to Quick Start was bugged on submission (submission of Step 4)
    * Overlay: we had an issue with overlay not showing properly and jQuery 1.9.1 made it worse, the overlay was appearing over the top of dialog. As a work around we have disabled all overlay but we would reward 50% discount on premium edition for anyone who finds a real solution.
    * Installation Refresh: wp_redirect() is used to refresh the screen after initial installation so that all settings kick-in. On initial installation we will no longer see multiple screens merged into one screen. This did not effect the operation of the plugin providing the user refreshed after install.
* Feature Changes
    * Templates: clicking on an existing template to assign as a projects main default content or title template now makes the selected template associated with the project. Previously only templates created when a project is active are associated with it.
    * Tables: Wordpress styling applied to tables. Some tables could probably do with the footer removed and accordion panels that only contain a table with a submit button will be removed so that only the table with button is displayed on screen.
    * Wordpress CSS Mode: the plugin allows jQuery or Wordpress theming. Improvements made to Wordpress mode which may become the default theming also. 
    * Nonce Security: is now in use for all themes. A generic approach to suit all submissions is in play (apart from a few forms that are fully coded in html so we need feedback on any issues)
    * jQuery UI Mode: Support buttons in accordions (Info and Video) have been moved to the right and forms moved upwards. This is to make things a little more compact but mostly to make vertical scrolling more fluent as we move from form to form.
    * Updates Screen Renamed: to News to avoid confusion with post and data updating (screen file renamed, requires menu array to be updated)
    * Quick Start: instructional text added to many Quick Start steps
    * About Screen: video removed, text changed to suit free edition more as it was more suited to the premium version only previously, list of links added
    * Installation Screen Changes: installation screens have been merged into one screen which can be found on the main plugin page
    * Removed form for testing CSV files (improved testing will be added later)

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
    * CSS menu class renamed to csv2post_cssmenu and the CSS itself moved to admin.css rather than the menu function itself
    * pear folder and contents deleted, fgetcsv() is now in use

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
    
