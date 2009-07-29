=== Plugin Name ===
Contributors: Ryan Bayne
Donate link: http://www.webtechglobal.co.uk/wordpress-services/wordpress-csv-2-post-plugin
Tags: csv,file,post,2,to,data,affiliate,webtechglobal,import,page
Requires at least: 2.8.0
Tested up to: 2.8.2
Stable tag: trunk

Inject any CSV file data into the WordPress database as new Posts!

== Description ==

Use CSV 2 POST to import a csv data file and inject up to 1 million posts in WordPress! It is free to use and has some cool features that other
similiar plugins don't with many more cool new ideas coming soon. Developed by Ryan Bayne from WebTechGlobal, a University graduate
in 2009, a father to be and a case for donations...please! It will help improvement to this plugin and more good plugins. 

== Installation ==

No coding skills required to use this plugin and you can install as you would most plugins.

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress


== Frequently Asked Questions ==

= Is the CSV file processed all at once? =

You have the option of doing it all at once or staggering it so that a few rows are processed for each page load on your blog!

== Screenshots ==

1. TBC

== Changelog ==

= 0.1 =
* Start and Release of Plugin with no Changes

= 0.2 =
* Stage 5 - Category filtering has more fields now.
* Stage 4 - Custom fields now allows pairing of columns for unique data per post as value.
* Fixed bug with custom fields not actually being created.
* Addded new custom field for ALL posts for campaign id, will be used for UNDO and UPDATE in campaign management.

= 0.3 =
* Stage 4 Improvement - Another row added for pairing column to custom field key and no null values entered to database now
* Version 0.2 updates caused filtering to stop working so that has been fixed

= 0.4 =
* Undo function added to campaign management
* New database table added for tracking posts created per campaign
* Database updating improved using wordpress functions now
* More affiliate links added to Main Page

= 0.5 =
* Ratio/Visitor field replaced with drop down menu and limit of 3
* More "post parts" added aimed at accomodating book data i.e. Author and publisher added
* Database upate script changed again, version 0.4. does not do database update however it is not crucial at this time

= 0.6 =
* This version was to correct an issue in repository only.

= 0.7 =
* Only the csv file name is required to be entered in Stage 1 when linking to a local file however you must upload your csv file to the CSV 2 POST plugin directory and put it in the "csv_files" folder.
* Stage 1 instructions amended to suit the new changes.
* Add file size limit indicator on stage 1 for file upload option. It is done dynamically using this: <?php $filelimit = ini_get( "upload_max_filesize"); echo $filelimit.' file size limit.'; ?>

= 0.8 =
* Fixed problem with duplicated posts.
* Recoded some of the create new campaign script.
* All csv files must be in the 'csv_files' folder now

= 0.9 =
* Recoding for version 0.8 caused a lot of issues and they have been resolve. Testing shows the plugin to be working well.
* Issue with "Written By" and "Published By" text showing up even when they are not required has been fixed.

= 1.0 =
* Full processing is limited by server memory, clear warnings now displayed regarding this and recommendation for localhost use only.
* Limited running campaigns to one at a time as two or more was causing conflicts. Later scheduling will be in place to automatically start paused campaigns.
* Extra duplication check to prevent duplicate posts when multiple hits are experianced. Quality, not quantity!
* Category filtering fixed, small variable change during version 0.9 work that caused this.
* Fixed problem when you select staggered and upload together, another variable change from version 0.9 and missed by me.
* You can now totally delete campaigns in campaign management. Multiple users asked for this.
* Set Post/Visit ratio to 1! A premium version will be available that will continue to be developed, donations will add to the free edition so please buy or donate.

= 1.1 =
* Moved processing trigger from footer based to header (wp instead of shutdown for developers). This helps to prevent loops and conflicts with other plugins.
* Added tags so SEO is not 100% covered.
* Fixed issue with some posts being created as Uncategorised!
* Finally I realised that my repository software will not prevent the csv_files folder being deleted on upgrade so instead the folder is not provided with the plugin. The plugin will now make the csv_files folder when it does not exist.

== Arbitrary section ==

Please email wordpress@webtechglobal.co.uk with any questions regarding this plugin.

== A brief Markdown Example ==

What to put here I wonder?