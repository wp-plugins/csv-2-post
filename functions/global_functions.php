<?php

// function creates drop down menu of csv file titles - input csv files profile, campaign if any, $column id if any for default selection and an object name
function csv2post_csvcolumnmenu($csvprofile,$cam,$column,$name)
{
	$target_path = csv2post_getcsvfilesdir();
	$csvfiledirectory = $target_path . $cam['settings']['file'];
	$handle = fopen("$csvfiledirectory", "r");
	
	$stop = 0;
	while (($data = fgetcsv($handle, 5000, $csvprofile['format']['delimiter'])) !== FALSE && $stop != 1)// Gets CSV rows
	{	 
		++$stop;// used to limit row parsing to just 1
		$i = 0; ?>
		<select name="<?php echo $name; ?>" size="1">
		<option value="999">Not Required</option>
		<?php
		while(isset($data[$i]))
		{
			$data[$i] = rtrim($data[$i]);
			if($column == $i)
			{    
				echo '<option value="'. $i .'" selected="selected">'. $data[$i] .'</option>';
			}
			else
			{   
				echo '<option value="'. $i .'">'. $data[$i] .'</option>';
			}
			
			$i++; // $i will equal number of columns - use to process submission
		}?>
		
		</select>
		<?php
	}
	
	fclose($handle);
}

// function initiates a newly uploaded csv files profile in the wordpress options table
function csv2post_createcampaign()
{
    global $wpdb;
	
	// create profile option for the new campaign using time as an ID
	$campaignid = 'campaign_' . time();
	
	/*
		camid_option = unique id for this option and also the options name - used to locate option
		stage = last complete stage on new campaign proces
		name = users entered name for identification
		file = csv file used in campaign
		phase = import or update phase 1=import 2= update
		imported = number of records import and posts created
		dropped = number of rows that could not be used for whatever reason
		updated = number of posts updated on update phase
		updatesetting = auto update on or off
		process = process method selected by user on Stage 1
		catparent = column id selected to be parent categories
		catchild1 = column id selected to be first child categories
		catchild2 = column id selected to be second child categories
		catdefault = default category for posts not categorised
		categorymethod = auto, manual, mixed etc
		customfield = method for creating custom fields auto or manual
		staggeredratio = number of posts to create per blog hit
		poststatus = publish, draft etc
		randomdate = is random date use requested or not
		scheduledhour = number of posts to be created per hour for scheduled campaigns
	*/
	
	$campaign['settings'] = array(
		'camid_option' => 'TBC',
		'stage' => '0',
		'name' => 'TBC',
		'file' => 'TBC',
		'phase' => '1',
		'imported' => '0',
		'dropped' => '0',
		'updated' => '0',
		'updatesetting' => '0',
		'process' => '2',
		'catparent' => '999',
		'catchild1' => '999',
		'catchild2' => '999',
		'catdefault' => '999',
		'categorymethod' => '',
		'customfield' => 'automated',
		'staggeredratio' => '1',
		'poststatus' => 'publish',
		'randomdate' => '0',
		'scheduledhour' => '0',
	);
		
	add_option( $campaignid, $campaign );	
	return $campaignid;
}

function csv2post_getcsvprofile( $filename )
{
   	$profileoptionname = 'csvprofile_' . $filename;
	return get_option( $profileoptionname );			
}

// simply returns the passed filename with prepended profile name tag
function csv2post_csvfilesprofilename($filename)
{
   	return 'csvprofile_' . $filename;
}

// function initiates a newly uploaded csv files profile in the wordpress options table
function csv2post_createcsvprofile( $filename )
{
    global $wpdb;
	
	// ensure csv file does not already have a layout
	$results = $wpdb->get_row("SELECT * FROM " .$wpdb->prefix . "csv2post_layouts WHERE name = '$filename' AND csvfile = '$filename'");
	if( !$results)// create the initial wysiwyg editor entry so that only updates are required afterwards
	{
    	$sqlQuery = "INSERT INTO " . $wpdb->prefix . "csv2post_layouts (name,code,inuse,type,csvfile,wysiwyg_content,wysiwyg_title) VALUES ('$filename','TBC',0,0,'$filename','TBC','TBC')";
    	$wpdb->query( $sqlQuery );
	}
	
	// create profile option for the csv file
	$optionname = 'csvprofile_' . $filename;
			
	$specialfunctions['columns'] = array(
		'excerpt_column' => 'NA',
		'tags_column' => 'NA',
		'uniqueid_column' => 'NA',
		'urlcloaking_column' => 'NA',
		'permalink_column' => 'NA',
		'dates_column' => 'NA'
	);
				
	// the state is a boolean switch which will be used to switch the special function on or off per campaign on stage 2
	$specialfunctions['states'] = array(
		'excerpt_state' => 'OFF',
		'tags_state' => 'OFF',
		'uniqueid_state' => 'OFF',
		'urlcloaking_state' => 'OFF',
		'permalink_state' => 'OFF',
		'dates_state' => 'OFF'
	);
	
	// csv file specific format information
	$specialfunctions['format'] = array(
		'delimiter' => get_option('csv2post_defaultdelimiter'),
		'columns_pear' => '1',
		'quote_pear' => '"',
		'rows' => 'TBC'
	);
	
	add_option( $optionname, $specialfunctions );	
}

function csv2post_getcsvfilesdir(){ return WP_CONTENT_DIR . '/csv2postfiles/'; }

function csv2post_queryresult($q){ if(!$q){ return false; }else{ return true; }}

// check and deal with safe mode status
function csv2post_checksafemodestatus()
{
	$server_safemode = ini_get('safe_mode');
	if ($server_safemode == 1) 
	{
		return '<span class="okgreen">Server Safe Mode Is On</span>';
	} 
	else 
	{
		return '<span class="okgreen">Server Safe Mode Is Off</span>';
	}
}

// create csv files storage folder
function csv2post_doesexist_csvfilesfolder()
{				
	$filename = csv2post_getcsvfilesdir();
	
	if (file_exists($filename)) 
	{
		if (is_writable($filename)) 
		{
			return '<span class="okgreen">OK - Folder is present and writeable</span>';
		} 
		else
		{
			return '<span class="okgreen">ERROR - Folder is present but not writeable! This may be a permissions issues.</span>';
		}
	} 
	else 
	{
		$outcome = @mkdir($filename, 0777);
		
		if(!$outcome)
		{	
			return '
			<span class="problemred">ERROR - Folder is not present and cannot be created or is just not writeable! You may need to create the directory manually. Example: http://www.domainname.com/wp-content/csv2postfiles</span>
			';
		}
		else
		{
			return '<span class="okgreen">OK - Folder has just been created for you.</span>';
		}
	}
}

function csv2post_autolineendings_status()
{
	$status = ini_get('auto_detect_line_endings');
	
	if($status == 1)
	{
		return '<span class="okgreen">Currently ON</span>';
	}
	elseif($status == 0)
	{
		return '<span class="problemred">Currently OFF! May cause problems uploading csv files from a MAC.</span>';
	}
}


# USED TO CHECK ALLOWED FILE EXTENSIONS
function isAllowedExtension_csv2post($fileName)
{
	$allowedExtensions = array("csv", "CSV");
	return in_array(end(explode(".", $fileName)), $allowedExtensions);
}
	
//STRIP HTML, TRUNCATE, CREATE TITLE
function create_meta_title_csv2post($str, $length) 
{
	$title = truncate_string_csv2post(seo_simple_strip_tags_csv2post($str), $length);
	if (strlen($str) > strlen($title)) 
	{$title .= "...";}
	return $title;
}
/* Example:	<title>WebTechGlobal: <?php echo create_meta_title($pagedesc, $met_tit_len);?></title> */

//STRIP HTML, TRUNCATE, CREATE DESCRIPTION
function create_meta_description_csv2post($str, $length)
{
	$meta_description = truncate_string_csv2post(seo_simple_strip_tags_csv2post($str), $length);
	if (strlen($str) > strlen($meta_description)) {$meta_description .= "...";}
	return $meta_description;
}
/* Example:	<meta name="description" content="<?php echo create_meta_description($pagedesc, $met_des_len);?>" /> */


// not only remove specified words but removes numeric only values if $tagsnumeric is set to 1 and not 0
function create_tags_csv2post($str, $length, $tagsnumeric) 
{
	$exclude = array(get_option('csv2post_exclusions'));
	$splitstr = @explode(" ", truncate_string_csv2post(seo_simple_strip_tags_csv2post(str_replace(array(",",".")," ", $str)), $length));
	$new_splitstr = array();
	foreach ($splitstr as $spstr) 
	{
		if($tagsnumeric == 1)
		{	// numeric only values will be removed
			if (strlen($spstr) > 2 && !(in_array(strtolower($spstr), $new_splitstr)) && !(in_array(strtolower($spstr), $exclude)) && !is_numeric($spstr)) 
			{$new_splitstr[] = strtolower($spstr);}
		}
		elseif($tagsnumeric == 0)
		{	// numeric only values will be included
			if (strlen($spstr) > 2 && !(in_array(strtolower($spstr), $new_splitstr)) && !(in_array(strtolower($spstr), $exclude))) 
			{$new_splitstr[] = strtolower($spstr);}
		}
	}
	return @implode(", ", $new_splitstr);
}

//STRIP HTML TAGS - CALLED WITHIN THE OTHER FUNCTIONS
function seo_simple_strip_tags_csv2post($str)
{
	$untagged = "";
	$skippingtag = false;
	for ($i = 0; $i < strlen($str); $i++) 
	{
		if (!$skippingtag) 
		{
			if ($str[$i] == "<") 
			{
				$skippingtag = true;
			} 
			else
			{
				if ($str[$i]==" " || $str[$i]=="\n" || $str[$i]=="\r" || $str[$i]=="\t") 
				{
					$untagged .= " ";
				}
				else
				{
					$untagged .= $str[$i];
				}
			}
		}
		else
		{
			if ($str[$i] == ">") 
			{
				$untagged .= " ";
				$skippingtag = false;
			}		
		}
	}	
	$untagged = preg_replace("/[\n\r\t\s ]+/i", " ", $untagged); // remove multiple spaces, returns, tabs, etc.
	if (substr($untagged,-1) == ' ') { $untagged = substr($untagged,0,strlen($untagged)-1); } // remove space from end of string
	if (substr($untagged,0,1) == ' ') { $untagged = substr($untagged,1,strlen($untagged)-1); } // remove space from start of string
	if (substr($untagged,0,12) == 'DESCRIPTION ') { $untagged = substr($untagged,12,strlen($untagged)-1); } // remove 'DESCRIPTION ' from start of string
	return $untagged;
}


//SPLIT WORDS (\W) BY DELIMITERS, ucfirst THEN RECOMBINE WITH DELIMITERS
function ucfirst_title_csv2post($string) 
{
	$temp = preg_split('/(\W)/', $string, -1, PREG_SPLIT_DELIM_CAPTURE );
	foreach ($temp as $key=>$word) 
	{
		$temp[$key] = ucfirst(strtolower($word));
	}
	$new_string = join ('', $temp);
	// Do the Search and Replacements on the $new_string.
	$search = array (' And ',' Or ',' But ',' At ',' In ',' On ',' To ',' From ',' Is ',' A ',' An ',' Am ',' For ',' Of ',' The ',"'S", 'Ac/');
	$replace = array (' and ',' or ',' but ',' at ',' in ',' on ',' to ',' from ',' is ',' a ',' an ',' am ',' for ',' of ',' the ',"'s", 'AC/');
	$new_string = str_replace($search, $replace, $new_string);
	// Several Special Replacements ('s, McPherson, McBain, etc.) on the $new_string.
	$new_string = preg_replace("/Mc([a-z]{3,})/e", "\"Mc\".ucfirst(\"$1\")", $new_string);
	// Another Strange Replacement (example: "Pure-Breed Dogs: the Breeds and Standards") on the $new_string.
	$new_string = preg_replace("/([:;])\s+([a-zA-Z]+)/e", "\"$1\".\" \".ucfirst(\"$2\")", $new_string);
	// If this is a very low string ( > 60 char) then do some more replacements.
	if (strlen($new_string > 60)) 
	{
		$search = array (" With "," That ");
		$replace = array (" with "," that ");
		$new_string = str_replace($search, $replace, $new_string);
	}
	return ($new_string);
}

//WORD WRAP, EXCLUDES HTML IN COUNT, SET MAX COLUMNS/CHARACTERS
function wordwrap_excluding_html_csv2post($str, $cols = 30, $cut = "&shy;")
{
	$len = strlen($str);
	$tag = 0;
	for ($i = 0; $i < $len; $i++) 
	{
		$chr = $str[$i];
		if ($chr == '<') 
		{$tag++;} 
		elseif($chr == '>')
		{$tag--;}
		elseif((!$tag) && ($chr==" " || $chr=="\n" || $chr=="\r" || $chr=="\t"))
		{$wordlen = 0;}
		elseif(!$tag)
		{$wordlen++;}
		if ((!$tag) && ($wordlen) && (!($wordlen % $cols))) 
		{$chr .= $cut;}
		$result .= $chr;
	}
	return $result;
}

//TRUNCATE STRING TO LENGTH, EXCLUDING HTML IN LENGTH COUNT BUT KEEPS THE HTML
function truncate_string_excluding_html_csv2post($str, $len = 150)
{
	$wordlen = 0; // Total text length.
	$resultlen = 0; // Total length of HTML and text.
	$len_exceeded = false;
	$cnt = 0;
	$splitstr = array (); // String split by HTML tags including delimiter.
	$open_tags = array(); // Assoc. Array for Simple HTML Tags
	$str = str_replace(array("\n","\r","\t"), array (" "," "," "), $str); // Replace returns/tabs with spaces
	$splitstr = preg_split('/(<[^>]*>)/', $str, -1, PREG_SPLIT_DELIM_CAPTURE );
	//var_dump($splitstr);
	if (count($splitstr) > 0 && strlen($str) > $len) 
	{
		while ($wordlen <= $len && $cnt <= 200 &&!$len_exceeded) 
		{
			$part = $splitstr[$cnt];
			if (preg_match('/^<[A-Za-z]{1,}/', $part)) 
			{$open_tags[strtolower(substr($match[0],1))]++;} 
			else if(preg_match('/^<\/[A-Za-z]{1,}/', $part))
			{$open_tags[strtolower(substr($match[0],2))]--;}
			else if(strlen($part) > $len-$wordlen)
			{ // truncate remaining length
				$tmpsplit = explode("\n", wordwrap($part, $len-$wordlen));
				$part = $tmpsplit[0]; // Define the truncated part.
				$len_exceeded = true;
				$wordlen += strlen($part);
			}else{$wordlen += strlen($part);}
			$result .= $part; // Add the part to the $result
			$resultlen = strlen($result);
			$cnt++;
		}
		
		// Close the open HTML Tags (Simple Tags Only!). This excludes IMG and LI tags.
		foreach ($open_tags as $key=>$value) 
		{
			if ($value > 0 && $key!= "" && $key!= null && $key!= "img" && $key!= "li") 
			{for ($i=0; $i<$value; $i++) { $result .= "</".$key.">"; }}
		}//end foreach
	}
	else
	{
		$result = $str;
	}//end if count
	return $result;
}

//TRUNCATE STRING TO SPECIFIED LENGTH - USED IN OTHER FUNCTIONS
function truncate_string_csv2post($string, $length = 70)
{
	if (strlen($string) > $length) 
	{
		$split = preg_split("/\n/", wordwrap($string, $length));
		return ($split[0]);
	}
	return ($string);
}

function webtechglobal_replacespaces_csv2post($v)
{
	return(str_replace(array(' ','  ','   ','     ','      ','       ','        ','         ',), '-', $v));
	return $v;
}

function webtechglobal_replacespecial_csv2post($v)
{
	return(str_replace(array('&reg;','and'), '', $v));
	return $v;
}

function webtechglobal_clean_desc_csv2post($text)
{
	$code_entities_match = array('  ','--','&quot;',"'",'"');
	$code_entities_replace = array(' ','-','','','');
	$text = str_replace($code_entities_match, $code_entities_replace, $text);
	return $text;
}

function webtechglobal_clean_title_csv2post($text)
{
	$code_entities_match = array('  ','--','&quot;',"'");
	$code_entities_replace = array(' ','-','','');
	$text = str_replace($code_entities_match, $code_entities_replace, $text);
	return $text;
}

function webtechglobal_clean_url_csv2post($text)
{
	$text=strtolower($text);
	$code_entities_match = array(' ','  ','--','&quot;','!','@','#','$','%','^','&','*','(',')','_','+','{','}','|',':','"','<','>','?','[',']','\\',';',"'",',','.','/','*','+','~','`','=');
	$code_entities_replace = array('-','-','-','','','','','','','','','','','','','','','','','','','','','','','','');
	$url = str_replace($code_entities_match, $code_entities_replace, $text);
	return $url;
}

function webtechglobal_clean_keywords_csv2post($text)
{
	$text=strtolower($text);
	$code_entities_match = array('--','&quot;','!','@','#','$','%','^','&','*','(',')','_','+','{','}','|',':','"','<','>','?','[',']','\\',';',"'",'.','/','*','+','~','`','=');
	$code_entities_replace = array('-','','','','','','','','','','','','','','','','','','','','','','','','');
	$text = str_replace($code_entities_match, $code_entities_replace, $text);
	return $text;
}

function get_categories_fordropdownmenu_csv2post()
{		
	get_categories('hide_empty=0show_option_all=&title_li=');
	$test = get_categories('hide_empty=0&echo=0&show_option_none=&style=none&title_li=');
	foreach($test as $category) 
	{   
		if($category->term_id == get_option('csv2post_defaultcatparent')){$selected = 'selected="selected"';}else{$selected="";}
		?>
   	 	<option value="<?php echo $category->term_id; ?>" <?php echo $selected; ?>><?php echo $category->cat_name;?></option>
		<?php
	}      
} 

function csv2post_opt($possible,$actual){	if($possible == $actual){return 'selected="selected"';}}

function csv2post_datepicker_nonejavascript()
{
	$monthstart = get_option('csv2post_randomdate_monthstart');
    $daystart = get_option('csv2post_randomdate_daystart');
    $yearstart = get_option('csv2post_randomdate_yearstart');
    $monthend = get_option('csv2post_randomdate_monthend');
    $dayend = get_option('csv2post_randomdate_dayend');
    $yearend = get_option('csv2post_randomdate_yearend');
	?>
    
	<strong>Start Date: </strong>    
    
    <select name="csv2post_randomdate_monthstart">
        <option <?php echo csv2post_opt('01',$monthstart)?> value="01">January</option>
        <option <?php echo csv2post_opt('02',$monthstart)?> value="02">Febuary</option>
        <option <?php echo csv2post_opt('03',$monthstart)?> value="03">March</option>
        <option <?php echo csv2post_opt('04',$monthstart)?> value="04">April</option>
        <option <?php echo csv2post_opt('05',$monthstart)?> value="05">May</option>
        <option <?php echo csv2post_opt('06',$monthstart)?> value="06">June</option>
        <option <?php echo csv2post_opt('07',$monthstart)?> value="07">July</option>
        <option <?php echo csv2post_opt('08',$monthstart)?> value="08">August</option>
        <option <?php echo csv2post_opt('09',$monthstart)?> value="09">September</option>
        <option <?php echo csv2post_opt('10',$monthstart)?> value="10">October</option>
        <option <?php echo csv2post_opt('11',$monthstart)?> value="11">November</option>
        <option <?php echo csv2post_opt('12',$monthstart)?> value="12">December</option>
    </select>
    
    <select name="csv2post_randomdate_daystart">
    	<?php
			$counter = 1;
			while($counter < 32)
			{
				$code = '<option ';
				$code .= csv2post_opt($counter,$daystart);
				$code .= ' value="' . $counter .'">' . $counter .'</option>';
				echo $code;
				$counter++;
			}
		?>
    </select>
    
    <select name="csv2post_randomdate_yearstart">
    	<?php
			$counter = 1990;
			while($counter < 2021)
			{
				$code = '<option ';
				$code .= csv2post_opt($counter,$yearstart);
				$code .= ' value="' . $counter .'">' . $counter .'</option>';
				echo $code;
				$counter++;
			}
		?>
    </select>

	<br />

	<strong>End Date:</strong>

    <select name="csv2post_randomdate_monthend">
        <option <?php csv2post_opt('01',$monthend)?> value="01">January</option>
        <option <?php csv2post_opt('02',$monthend)?> value="02">Febuary</option>
        <option <?php csv2post_opt('03',$monthend)?> value="03">March</option>
        <option <?php csv2post_opt('04',$monthend)?> value="04">April</option>
        <option <?php csv2post_opt('05',$monthend)?> value="05">May</option>
        <option <?php csv2post_opt('05',$monthend)?> value="06">June</option>
        <option <?php csv2post_opt('07',$monthend)?> value="07">July</option>
        <option <?php csv2post_opt('08',$monthend)?> value="08">August</option>
        <option <?php csv2post_opt('09',$monthend)?> value="09">September</option>
        <option <?php csv2post_opt('10',$monthend)?> value="10">October</option>
        <option <?php csv2post_opt('11',$monthend)?> value="11">November</option>
        <option <?php csv2post_opt('12',$monthend)?> value="12">December</option>
    </select>
    
    <select name="csv2post_randomdate_dayend">
    	<?php
			$counter = 1;
			while($counter < 32)
			{
				$code = '<option ';
				$code .= csv2post_opt($counter,$dayend);
				$code .= ' value="' . $counter .'">' . $counter .'</option>';
				echo $code;
				$counter++;
			}
		?>
    </select>
    
    <select name="csv2post_randomdate_yearend">
    	<?php
			$counter = 1990;
			while($counter < 2021)
			{
				$code = '<option ';
				$code .= csv2post_opt($counter,$yearend);
				$code .= ' value="' . $counter .'">' . $counter .'</option>';
				echo $code;
				$counter++;
			}
		?>
    </select>

<?php 
}
?>