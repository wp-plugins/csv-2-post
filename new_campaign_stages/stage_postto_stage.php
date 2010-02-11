<?php
// no sessions are used
// check submitted values, some stages only require certain values but all values need to be pass from stage to stage

$nc_stage = 0;

if(isset($_POST['stage'])){ $nc_stage = $_POST['stage']; }

		
// campaign id - $camid
if(($nc_stage == 2 || $nc_stage == 3 || $nc_stage == 4  || $nc_stage == 5  || $nc_stage == 6) && (empty($_POST['camid'])))
{ echo "Error: Campaign ID not posted from Stage " . $nc_stage . " "; }else{ @$camid = $_POST['camid']; }


// csv file directory
if(($nc_stage == 2 || $nc_stage == 3  || $nc_stage == 4  || $nc_stage == 5   || $nc_stage == 6) && (empty($_POST['csvfiledirectory'])))
{ echo "Error 1: File directory not posted from Stage " . $nc_stage . " "; }
else{ @$csvfiledirectory = $_POST['csvfiledirectory'];}


// csv file column total
if(($nc_stage == 2 || $nc_stage == 3  || $nc_stage == 4  || $nc_stage == 5)  && (empty($_POST['csvfile_columntotal'])))
{ echo "Error 2: CSV file column total not posted from Stage " . $nc_stage . " "; }
else{ @$csvfile_columntotal = $_POST['csvfile_columntotal'];}

?>