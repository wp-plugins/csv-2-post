<?php
##############################################################################################
####                                                                                      ####
####                EASY QUESTIONS ARRAY  ($csv2post_easyquestions_array)                 ####
####                                                                                      ####
##############################################################################################
/*
* Answers are stored in wp_option table. The default answers are in the $csv2post_eas_set array
* which is set in the csv2post_variables_easyset_array.php file. 
* 
* New questions MUST be put at the end of this array as the answers match 
* the $csv2post_easyquestions_array key
*/
$csv2post_easyquestions_array = array();
$k = 0;

// One or more files 
$csv2post_easyquestions_array[$k]['question'] = 'Do you want to merge the data from two or more files and create posts using the merged data';
$csv2post_easyquestions_array[$k]['active'] = true;
$csv2post_easyquestions_array[$k]['type'] = 'single';// single,multiple,text,slider 
$csv2post_easyquestions_array[$k]['answers'] = 'Yes - I want to merge my CSV files,No - I only wish to import data from one CSV file';
$csv2post_easyquestions_array[$k]['helpurl'] = 'http://www.csv2post.com/support';

// Any database table or just the imported CSV file
++$k;
$csv2post_easyquestions_array[$k]['question'] = 'Do you need the ability to use any table in your Wordpress database for creating posts with';
$csv2post_easyquestions_array[$k]['active'] = true;
$csv2post_easyquestions_array[$k]['type'] = 'single';// single,multiple,text,slider 
$csv2post_easyquestions_array[$k]['answers'] = 'Yes - I want to use data already in my database,No - I only want to use data from one CSV file';
$csv2post_easyquestions_array[$k]['helpurl'] = 'http://www.csv2post.com/support';


/* EXAMPLES

Multiple: the answer stored will be an array itself, this questions configuration expects an array in order to display
users selections on interface and any use of the answers should expect an array.
++$k;
$csv2post_easyquestions_array[$k]['question'] = 'Question two example only, multiple answer question';
$csv2post_easyquestions_array[$k]['active'] = true;
$csv2post_easyquestions_array[$k]['type'] = 'multiple';// single,multiple,text,slider 
$csv2post_easyquestions_array[$k]['answers'] = 'one,two,three,four,five,six,seven';
$csv2post_easyquestions_array[$k]['helpurl'] = 'http://www.csv2post.com/support';


++$k;
$csv2post_easyquestions_array[$k]['question'] = 'Question three example only,text box question';
$csv2post_easyquestions_array[$k]['active'] = true;
$csv2post_easyquestions_array[$k]['type'] = 'text';// single,multiple,text,slider 
$csv2post_easyquestions_array[$k]['answers'] = 'Ryan,Zara,Summer,Baby,Bayne';
$csv2post_easyquestions_array[$k]['helpurl'] = 'http://www.csv2post.com/support';

++$k;
$csv2post_easyquestions_array[$k]['question'] = 'Question four example only, slider bar question';
$csv2post_easyquestions_array[$k]['active'] = true;
$csv2post_easyquestions_array[$k]['type'] = 'slider';// single,multiple,text,slider 
$csv2post_easyquestions_array[$k]['answers'] = 0;
$csv2post_easyquestions_array[$k]['helpurl'] = 'http://www.csv2post.com/support';

++$k;
$csv2post_easyquestions_array[$k]['question'] = 'None active question five example only, slider bar question';
$csv2post_easyquestions_array[$k]['active'] = false;
$csv2post_easyquestions_array[$k]['type'] = 'slider';// single,multiple,text,slider 
$csv2post_easyquestions_array[$k]['answers'] = 0;
$csv2post_easyquestions_array[$k]['helpurl'] = 'http://www.csv2post.com/support';
*/
?>
