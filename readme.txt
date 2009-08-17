=== Plugin Name ===
Contributors: Ryan Bayne
Donate link: http://www.webtechglobal.co.uk/wordpress-services/wordpress-csv-2-post-plugin
Tags: csv,file,post,2,to,data,affiliate,webtechglobal,import,page
Requires at least: 2.8.0
Tested up to: 2.8.2
Stable tag: trunk

Created by Ryan Bayne from WebTechGlobal, import csv data, publish to WordPress as posts, auto custom fields, auto category creation and sorting. 

== Description ==

WebTechGlobal offers this csv import tool for wordpress, developed by Ryan Bayne. Import then publish affiliate data far easier than
other plugins claim! No messing about with your file to make it work, creates keywords, description and tags automatically. This is 
the free version and the low cost paid version CSV 2 POST Plus has auto custom fields, auto category creation and more!!!

== Installation ==

No coding skills required to use this plugin and you can install as you would most plugins.

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress


== Frequently Asked Questions ==

= Can I get the AdSense and links removed from my post made by CSV 2 POST? =

The options available are to either locate and edit every post that has the WebTechGlobal links in them or purchase CSV 2 POST Plus.

== Screenshots ==

1.Image 1 /images/csv2post_wordpressplugin_stage1.jpg 
2.Image 2 /images/csv2post_wordpressplugin_stage2.jpg 
3.Image 3 /images/csv2post_wordpressplugin_stage4.jpg 


== Changelog ==
= 2.0 = NOT YET RELEASED
* Decreased trial restrictions slightly.
* Added correct url to tutorials link on New Campaign stages.
* Fixed issue with MAC users not being able to get any further than stage 2.
* Shorten script lengths in new_campaign.php and post-maker.php to help speed them up.
* Increase PHP error reporting and sorted undefined variables on all pages.

= 1.9 =
* Changed file directory to wordpress upload folder so that csv files uploaded are not overwritten during upgrades.
* Instructions removed and replaced with link to my site where it is easier updated.
* Relaxed restrictions on link and ad placement as it was a bit much I think.
* Change page session name in wp-csv-2-post.php to avoid any conflicts.

= 1.8 =
* Mismatched function call corrected causing plugin to be unusable after last update.

= 1.7 =
* Seperated database create queries and put them in db_tables.php, also greatly improved the create database queries and updates.
* Database create queries are also only initiated if the database version numbers do not match making it quicker.
* Free edition now has trial like restrictions including my links in some posts, my adsense in some posts and full processing disabled.
* Functions.php file is only included when needed instead of all the time, same with db_tables.php.
* Most function names change to prevent conflicts with other plugins but mainly to prevent conflict with CSV 2 POST Plus, the paid edition of this plugin.
* The link on Stage 1 of New Campaign process updated to point to the main CSV 2 POST page.


= 1.6 =
* Change duplication check from checking "post_title" to checking "post_name" in the wp_posts table, this is 100% accurate now.
* Change SQL queries to not use "*" which should help speed the plugin up a little.
* Extend list of keyword exclusion, please see my new blog post for Version 1.6 release for a full list of excluded keywords.

= 1.5 =
* The so called fix for overwriting existing csv files when updating was pretty much a joke so I've went back to the old way and will spend more time considering a solution.
* Hoping what is a final fix to category issues. They can still be uncategoried depending on certain settings but I fixed that too.

== Arbitrary section ==

Please email wordpress@webtechglobal.co.uk with any questions regarding this plugin.

== A brief Markdown Example ==

What to put here I wonder?