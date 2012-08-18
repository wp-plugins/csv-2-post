<?php
##############################################################################################
####                                                                                      ####
####                EASY QUESTIONS ARRAY  ($csv2post_easyquestions_array)                   ####
####                                                                                      ####
##############################################################################################
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


/*
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
