=== Plugin Name ===
Contributors: Ryan Bayne
Donate link: http://www.webtechglobal.co.uk/wordpress-services/wordpress-csv-2-post-plugin
Tags: csv,file,post,2,to,data,affiliate,webtechglobal
Requires at least: 2.8.0
Tested up to: 2.8
Stable tag: 0.9

Inject any CSV file data into the WordPress database as new Posts!

== Description ==

Use CSV 2 POST to inject 1 million rows of csv file data in WordPress! It is free to use and has some cool features that other
similiar plugins don't. Users have commented that this can be a powerful plugin however it was originally developed when I finished
University in 2009 and for personal use only so there are bugs. It's popularity however requires many upgrades to bring it inline
with other plugins and WebTechGlobal will be working on these on a weekly basis during the rest of 2009. 

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

== Arbitrary section ==

Please email wordpress@webtechglobal.co.uk with any questions regarding this plugin.

== A brief Markdown Example ==

What to put here I wonder? Anyone interested in knowing anything specific about the plugin?