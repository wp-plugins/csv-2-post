<?php
##############################################################################################
####                                                                                      ####
####                EASY QUESTIONS ARRAY  ($wtgcsv_easyquestions_array)                   ####
####                                                                                      ####
##############################################################################################
$wtgcsv_easyquestions_array = array();
$k = 0;

// One or more files 
$wtgcsv_easyquestions_array[$k]['question'] = 'Do you want to merge the data from two or more files and create posts using the merged data';
$wtgcsv_easyquestions_array[$k]['active'] = true;
$wtgcsv_easyquestions_array[$k]['type'] = 'single';// single,multiple,text,slider 
$wtgcsv_easyquestions_array[$k]['answers'] = 'Yes - I want to merge my CSV files,No - I only wish to import data from one CSV file';
$wtgcsv_easyquestions_array[$k]['helpurl'] = 'http://www.importcsv.eu/support';

// Any database table or just the imported CSV file
++$k;
$wtgcsv_easyquestions_array[$k]['question'] = 'Do you need the ability to use any table in your Wordpress database for creating posts with';
$wtgcsv_easyquestions_array[$k]['active'] = true;
$wtgcsv_easyquestions_array[$k]['type'] = 'single';// single,multiple,text,slider 
$wtgcsv_easyquestions_array[$k]['answers'] = 'Yes - I want to use data already in my database,No - I only want to use data from one CSV file';
$wtgcsv_easyquestions_array[$k]['helpurl'] = 'http://www.importcsv.eu/support';


/*
++$k;
$wtgcsv_easyquestions_array[$k]['question'] = 'Question two example only, multiple answer question';
$wtgcsv_easyquestions_array[$k]['active'] = true;
$wtgcsv_easyquestions_array[$k]['type'] = 'multiple';// single,multiple,text,slider 
$wtgcsv_easyquestions_array[$k]['answers'] = 'one,two,three,four,five,six,seven';
$wtgcsv_easyquestions_array[$k]['helpurl'] = 'http://www.importcsv.eu/support';

++$k;
$wtgcsv_easyquestions_array[$k]['question'] = 'Question three example only,text box question';
$wtgcsv_easyquestions_array[$k]['active'] = true;
$wtgcsv_easyquestions_array[$k]['type'] = 'text';// single,multiple,text,slider 
$wtgcsv_easyquestions_array[$k]['answers'] = 'Ryan,Zara,Summer,Baby,Bayne';
$wtgcsv_easyquestions_array[$k]['helpurl'] = 'http://www.importcsv.eu/support';

++$k;
$wtgcsv_easyquestions_array[$k]['question'] = 'Question four example only, slider bar question';
$wtgcsv_easyquestions_array[$k]['active'] = true;
$wtgcsv_easyquestions_array[$k]['type'] = 'slider';// single,multiple,text,slider 
$wtgcsv_easyquestions_array[$k]['answers'] = 0;
$wtgcsv_easyquestions_array[$k]['helpurl'] = 'http://www.importcsv.eu/support';

++$k;
$wtgcsv_easyquestions_array[$k]['question'] = 'None active question five example only, slider bar question';
$wtgcsv_easyquestions_array[$k]['active'] = false;
$wtgcsv_easyquestions_array[$k]['type'] = 'slider';// single,multiple,text,slider 
$wtgcsv_easyquestions_array[$k]['answers'] = 0;
$wtgcsv_easyquestions_array[$k]['helpurl'] = 'http://www.importcsv.eu/support';
*/
?>
