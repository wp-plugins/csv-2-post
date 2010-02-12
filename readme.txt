=== Plugin Name ===
Contributors: Ryan Bayne
Donate link: http://www.csv2post.com
Tags: csv,file,post,plus,2,to,data,affiliate,webtechglobal,import,page
Requires at least: 2.5.0
Tested up to: 2.8.6
Stable tag: trunk

Inject any CSV file data into the WordPress database as new Posts with CSV 2 POST Pro, try the demo now!

== Description ==

Use CSV 2 POST Pro to import a csv data file and inject up to 1 million posts in WordPress! It is free to use and has some cool features that other
similiar plugins don't with many more cool new ideas coming soon. Developed by Ryan Bayne from WebTechGlobal, a University graduate
in 2009. This is a demo.

== Installation ==

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Ensure plugin files are in a folder named 'csv-2-post-plus' i.e `/wp-content/plugins/csv-2-post-plus/csv-2-post-plus.php`

== Changelog ==
0.4.6
* Tags now work after switching them to the new per campaign settings instead of a global pluging setting.
* cloakedurls_csv2post.php will only be included now if $_GET['viewitem'] is set, errors on uninstall now fixed.
* Tools page removed, all mass delete buttons will be found on a campaigns own management page.

0.4.5
* The categorising part of my script was not fully updated since re-coding a lot of the plugin but it now works properly.
* Adding video to Stage 4 for manual custom field setup.
* Duplication should now be prevented when using draft or pending post status. function csv2post_duplicates($posttitle) now handles duplication prevention.

0.4.4
* You can now reset campaigns, this will delete all posts created by that campaign and reset counters.
* You can now view the last 100 posts created in a campaign on campaign management.
* Changed message on Stage 6, no longer tells you to click start on campaign management.

0.4.3
* Campaign management link now fixed, it was not passing the new CSV Profile ID in the URL.

0.4.2
* A new table column required on Stage 1 was not being created on installation. You can now get past stage 1.

0.4.1
* Fixed problem where we could not select csv files on the CSV Profile page.

== Arbitrary section ==

Please email info@csv2post.com with any questions regarding this plugin.