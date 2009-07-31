<?php
# CREATING PLUGINS DATABASE TABLES ON INSTALLATION
function init_csvtopost_campaigndata_tabele_wtg () 
{
	# INSERT INITIAL VERSION OPTION
	$csvtopost_tables_version = "0.2";// different from plugin version
 	$installed_ver = get_option( "csvtopost_tables_version" );
	
	if(empty($installed_ver))
	{
    	add_option( "csvtopost_tables_version", '0.2' );
	}
	
	global $wpdb;
	global $csvtopost_tables_version;
	
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');


	# ADD OR UPDATE csvtopost_relationships TABLE
	$table_name = $wpdb->prefix . "csvtopost_relationships";
	if($installed_ver != $table_name) 
	{
		$sql = "CREATE TABLE `" . $table_name . "` (
			`id` int(10) unsigned NOT NULL auto_increment,
			`camid` int(10) unsigned NOT NULL COMMENT 'Campaign ID',
			`csvcolumnid` int(10) unsigned NOT NULL COMMENT 'Incremented number assigned to columns of CSV file in order they are in the file',
			`postpart` varchar(50) NOT NULL COMMENT 'Part CSV column assigned to in order to fulfill post data requirements',
			PRIMARY KEY  (`id`)
			) ENGINE=MyISAM AUTO_INCREMENT=380 DEFAULT CHARSET=utf8 COMMENT='Links between CSV file columns and post parts';";
		
		dbDelta($sql);// executes sql object query
	}

	# ADD OR UPDATE csvtopost_customfields TABLE
	$table_name = $wpdb->prefix . "csvtopost_customfields";
	if($installed_ver != $table_name) 
	{
		$sql = "
			CREATE TABLE `" . $table_name . "` (
			`id` int(10) unsigned NOT NULL auto_increment,
			`camid` int(10) unsigned NOT NULL,
			`identifier` varchar(30) NOT NULL,
			`value` varchar(500) NOT NULL,
			`type` int(10) unsigned NOT NULL COMMENT '0 = custom global value 1 = column marriage and possible unique value per post',
			PRIMARY KEY  (`id`)
			) ENGINE=MyISAM AUTO_INCREMENT=169 DEFAULT CHARSET=utf8 COMMENT='custom field data for campaigns';";
		
		dbDelta($sql);// executes sql object query
	}
	
	# ADD OR UPDATE csvtopost_categories TABLE
	$table_name = $wpdb->prefix . "csvtopost_categories";
	if($installed_ver != $table_name) 
	{
		$sql = "
			CREATE TABLE `" . $table_name . "` (
			`id` int(10) unsigned NOT NULL auto_increment,
			`camid` int(10) unsigned NOT NULL,
			`catcolumn` int(10) unsigned NOT NULL COMMENT 'csv column id for the column used to decide categorie sorting',
			`catid` int(10) unsigned NOT NULL COMMENT 'id of wp category',
			`uniquevalue` varchar(50) NOT NULL COMMENT 'unique value from the choosing column that determines this post goes in this category',
			PRIMARY KEY  (`id`)
			) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='Data used to sort new posts into correct category';";
		
		dbDelta($sql);// executes sql object query
	}	
	
	# ADD OR UPDATE csvtopost_campaigns TABLE
	$table_name = $wpdb->prefix . "csvtopost_campaigns";
	if($installed_ver != $table_name) 
	{
		$sql = "CREATE TABLE `" . $table_name . "` (
			`id` int(10) unsigned NOT NULL auto_increment,
			`camname` varchar(50) NOT NULL,
			`camfile` varchar(500) NOT NULL COMMENT 'Filename without extension (directory is scripted)',
			`process` int(10) unsigned NOT NULL COMMENT '1 = Full and 2 = Staggered',
			`ratio` int(10) unsigned NOT NULL COMMENT 'If Staggered processing selected this is the per visitor row to process',
			`stage` int(10) unsigned NOT NULL COMMENT '100 = Ready, 200 = Paused, 300 = FINISHED',
			`csvcolumns` int(10) unsigned default NULL COMMENT 'Number of columns in CSV file',
			`poststatus` varchar(45) default NULL COMMENT 'published,pending,draft',
			`csvrows` int(10) unsigned default NULL COMMENT 'Total number of rows in CSV file',
			`filtercolumn` int(10) unsigned default NULL COMMENT 'CSV file column ID for the choosen categories filter',
			`location` varchar(500) default NULL COMMENT 'CSV file location for FULL processing selection',
			`locationtype` int(10) unsigned default NULL COMMENT '1 = link and 2 = upload',
			`posts` int(10) unsigned default NULL COMMENT 'Total number of posts created',
			PRIMARY KEY  (`id`)
			) ENGINE=MyISAM AUTO_INCREMENT=195 DEFAULT CHARSET=utf8;";
		dbDelta($sql);// executes sql object query
	}	

	# ADD OR UPDATE hhhhhhhhhhhhhhhhhhhhhhh TABLE
	$table_name = $wpdb->prefix . "csvtopost_posthistory";
	if($installed_ver != $table_name) 
	{
		$sql = "CREATE TABLE  `" . $table_name . "` (
			`id` int(10) unsigned NOT NULL auto_increment,
			`camid` int(10) unsigned NOT NULL,
			`postid` int(10) unsigned NOT NULL,
			PRIMARY KEY  (`id`)
			) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='List of post ID''s created under each campaign';";
		dbDelta($sql);// executes sql object query
	}		
	
	# EXECUTE ADD OPTION TO RECORD NEW DATABASE VERSION
    update_option( "csvtopost_tables_version", $csvtopost_tables_version );
}

# USED TO CHECK ALLOWED FILE EXTENSIONS
function isAllowedExtension($fileName)
{
	$allowedExtensions = array("csv", "CSV");
	return in_array(end(explode(".", $fileName)), $allowedExtensions);
}
	
//STRIP HTML, TRUNCATE, CREATE TITLE
function create_meta_title($str, $length) 
{
	$title = truncate_string(seo_simple_strip_tags($str), $length);
	if (strlen($str) > strlen($title)) 
	{$title .= "...";}
	return $title;
}
/* Example:	<title>WebTechGlobal: <?php echo create_meta_title($pagedesc, $met_tit_len);?></title> */

//STRIP HTML, TRUNCATE, CREATE DESCRIPTION
function create_meta_description($str, $length)
{
	$meta_description = truncate_string(seo_simple_strip_tags($str), $length);
	if (strlen($str) > strlen($meta_description)) {$meta_description .= "...";}
	return $meta_description;
}
/* Example:	<meta name="description" content="<?php echo create_meta_description($pagedesc, $met_des_len);?>" /> */


//STRIP HTML,TRUNCATE,CREATE KEYWORDS
function create_meta_keywords($str, $length) 
{
	$exclude = array('description','save','$ave','month!','year!','hundreds','dollars','per','month','year',
	'and','or','but','at','in','on','to','from','is','a','an','am','for','of','the','are','home','much','more',
	'&','every','this','has','been','with','selecting','set','other','thingy','maybe','shit','fuck','piss','cunt','bastard',
	'thats','not','too','them','must-have','youre','can','these','where','will','our','end','all','using','use','your','get',
	'getting','away','you','who','help','helps','any','plus','new','offer','fees','thinking','consider','going','into','where',
	'interested',"you'll","that's","fee's","year's",'were','had','through','have','made','that','how','his','her','its');
	$splitstr = @explode(" ", truncate_string(seo_simple_strip_tags(str_replace(array(",",".")," ", $str)), $length));
	$new_splitstr = array();
	foreach ($splitstr as $spstr) 
	{
		if (strlen($spstr) > 2 &&!(in_array(strtolower($spstr), $new_splitstr)) &&!(in_array(strtolower($spstr), $exclude))) 
		{$new_splitstr[] = strtolower($spstr);}
	}
	return @implode(", ", $new_splitstr);
}
/* Example:	<meta name="keywords" content="<?php echo create_meta_keywords($pagedesc, $met_key_len);?>" /> */

//STRIP HTML TAGS - CALLED WITHIN THE OTHER FUNCTIONS
function seo_simple_strip_tags($str)
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
function ucfirst_title($string) 
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
// splitS word, that is longer than $cols and is outside
// HTML tags, by the string $cut. Lines with whitespace in them are ok, only
// single words over $cols length are split. (&shy; = safe-hyphen)
function wordwrap_excluding_html($str, $cols = 30, $cut = "&shy;")
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
function truncate_string_excluding_html($str, $len = 150)
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
		//echo "wordlen: $wordlen, resultlen: $resultlen<br />";
		//var_dump($open_tags);
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
function truncate_string($string, $length = 70)
{
	if (strlen($string) > $length) 
	{
		$split = preg_split("/\n/", wordwrap($string, $length));
		return ($split[0]);
	}
	return ($string);
}

function webtechglobal_replacespaces($v)
{
	return(str_replace(array(' ','  ','   ','     ','      ','       ','        ','         ',), '-', $v));
	return $v;
}

function webtechglobal_replacespecial($v)
{
	return(str_replace(array('&reg;','and'), '', $v));
	return $v;
}

function webtechglobal_clean_desc($text)
{
	$code_entities_match = array('  ','--','&quot;',"'",'"');
	$code_entities_replace = array(' ','-','','','');
	$text = str_replace($code_entities_match, $code_entities_replace, $text);
	return $text;
}

function webtechglobal_clean_title($text)
{
	$code_entities_match = array('  ','--','&quot;',"'");
	$code_entities_replace = array(' ','-','','');
	$text = str_replace($code_entities_match, $code_entities_replace, $text);
	return $text;
}

function webtechglobal_clean_url($text)
{
	$text=strtolower($text);
	$code_entities_match = array(' ','  ','--','&quot;','!','@','#','$','%','^','&','*','(',')','_','+','{','}','|',':','"','<','>','?','[',']','\\',';',"'",',','.','/','*','+','~','`','=');
	$code_entities_replace = array('-','-','-','','','','','','','','','','','','','','','','','','','','','','','','');
	$url = str_replace($code_entities_match, $code_entities_replace, $text);
	return $url;
}

function webtechglobal_clean_keywords($text)
{
	$text=strtolower($text);
	$code_entities_match = array('--','&quot;','!','@','#','$','%','^','&','*','(',')','_','+','{','}','|',':','"','<','>','?','[',']','\\',';',"'",'.','/','*','+','~','`','=');
	$code_entities_replace = array('-','','','','','','','','','','','','','','','','','','','','','','','','');
	$text = str_replace($code_entities_match, $code_entities_replace, $text);
	return $text;
}

function get_categories_fordropdownmenu()
{		
	get_categories('hide_empty=0show_option_all=&title_li=');
	$test = get_categories('hide_empty=0&echo=0&show_option_none=&style=none&title_li=');
	foreach($test as $category) 
	{ ?>
		<option value="<?php echo $category->term_id; ?>"><?php
		echo $category->cat_name;?> 
		</option><?php
	}      
} 

# CHECKS IF CAMPAIGNS ARE RUNNING - IF SO INCLUDES post-maker.php FOR FULL PROCESSING
function wtg_csvtopost_processcheck()
{ 
    if(isset($_SESSION['page']) && $_SESSION['page'] == $_SERVER['PHP_SELF'])
    {
    	# DO NOTHING – the current page has not change from the last page load so do not begin process and this approach will hopefully allow plugins like XML-Sitemap and WP-to-Twitter to do their job, trigger page loads but not trigger further processing in CSV 2 POST.
    }
    else
    {
		# TRIGGER CSV 2 POST PROCESSING
		$_SESSION['page'] = $_SERVER['PHP_SELF']; // set current page into session and use on next page load to prevent processing if page not differrent

		global $wpdb;
		$count = $wpdb->get_var("SELECT COUNT(*) FROM " .$wpdb->prefix . "csvtopost_campaigns WHERE stage = '100'");
	
		if( $count > 0 )
		{
			include('post-maker.php');
		}
		else
		{			
			# DO NOTHING AS THERE ARE NO CAMPAIGNS TO RUN
		}
	}
}
?>