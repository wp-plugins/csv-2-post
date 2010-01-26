=== Plugin Name ===
Contributors: Ryan Bayne
Donate link: http://www.csv2post.com
Tags: csv,file,post,plus,2,to,data,affiliate,webtechglobal,import,page
Requires at least: 2.5.0
Tested up to: 2.8.6
Stable tag: trunk

Not just a CSV Importer, its a CSV Import management tool for professionals. This is a free edition demo only.

== Description ==

Free edition of the best CSV Import plugin for Wordpress. This plugin is a sample of the professional plugin that improves week by week, constantly delivering new
ideas and approachs to not just getting data in your blog but managing your entire campaign.

== Installation ==

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Ensure plugin files are in a folder named 'csv-2-post-plus' i.e `/wp-content/plugins/csv-2-post-plus/csv-2-post-plus.php`

== Changelog ==
0.3.9
1. Removed disclaimer page, not really required. Terms and Conditions will soon be made available for presale.
2. Removed multiple debug function lines in postmaker file to help speed up importing.
3. Auto keywords, description and tags settings is per campaign now. No longer a global plugin setting for all campaigns.
4. Custom Post Layouts are now part of a CSV Profile system. Layouts page renamed to CSV Profiles.
5. Settings for special functions such as tag generating or custom permalink are now stored in Wordpress options as an array.
6. Stage 2 no longer has any column pairing, it is now always automated due to the new CSV Profile system.
7. Stage 2 special functions columns have been replaced with checkboxes. Columns for each special function are set in the CSV Profile.
8. Corrected an issue with the Posts Per Hit value not being saved properly in Settings.
9. Fixed custom slug function. Rarely used function so it was never picked up on that it was not working properly.
10. Applying your own dates from csv file did not always work, changes have been made to improve this and it works far better.
11. Change the name of all variables involved in processing CSV Profile name as a conflict with language translator plugin suspected.
12. CSV Profile text object for name had the ID of "Title" which is the same as the WYSIWYG editor title which was causing conflict.
13. Campaign management now shows last 100 posts created for viewing or edit. Later will have pagination for listing all posts created by a campaign.
14. CSV Uploader page now uses the new csv profile array.
15. Moved delimiter entry to CSV Profile page, underneath special column title tokens where it becomes apparent if the delimiter is correct or not.
16. CSV files can now only have one profile and the interface has been changed to prevent selection of csv files with a profile already. 
17. Profiles cannot be named manually, they are automatically named using the csv file name they are created for. This is less to do for the user.
18. Table names have had "plus" removed since the plugin originally had 3 editions. It has been removed from sql code and all php.
19. My own styles plus images have been removed from plugin files and standard Wordpress styling is now being applied.
20. There is now a menu for quickly applying a files profile to another csv file. Only possible when files are formatted the same in every way.
21. Stage 1 will only show csv file that have had a profile completed. This will now make the initial campaign setup quicker overall.


== Arbitrary section ==

Please email info@csv2post.com with any questions regarding this plugin.