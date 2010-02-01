<?php
// basic debugging tracker - when debuggin is on records script state messages to text file
function csv2post_debug_write($line,$filename,$message)
{
	if(get_option('csv2post_debugmode') == 1)
	{
		// update last point of execution option and record latest known point of execution
		update_option('csv2post_lastpointofexecution','Ran csv2post_processcheck function - File wp-csv-2-post - Scheduled campaign processing begun!');	
		// write latest poe to debug file
		$debugfiledir = WP_CONTENT_DIR . '/csv2postfiles/';	
		$file = $debugfiledir . "csv2post_debug.txt";
		$file  = fopen($file , 'a');
		$text = "Line:" . $line . " File:" . $filename . " Message:" . $message . "\n";
		fwrite($file , $text);
		fclose($file );		
	}
}

//use to display any text message with any style
function messagebox_csv2post($style, $message){echo '<div class="'.$style.'">'.$message.'</div>';}

function error_csv2post($line,$file,$my_error)
{
	global $wpdb;

	$wpdb->query("SELECT id FROM " .$wpdb->prefix . "csv2post_reports ORDER BY id DESC LIMIT 10");
	$c = $wpdb->num_rows;
	
	if($c >= 1)
	{
		// do not insert in order to avoid too many duplicate errors
	}
	else
	{
		$sqlQuery = "INSERT INTO " . $wpdb->prefix . "csv2post_reports (line,file,my_error,date) VALUES ('$line','$file','$my_error',NOW())";
		$wpdb->query($sqlQuery);
		
		emailerrorreport_csv2post($line,$file,$my_error);
	}
}

function smallerrorreport_csv2post()
{
	global $wpdb;
	$r = $wpdb->get_results("SELECT line,file,my_error,date FROM " .$wpdb->prefix . "csv2post_reports ORDER BY id DESC LIMIT 5");
	
	if( !$r )
	{
		echo '<h4>No Error Events Logged</h4>';
	}
	else
	{
		echo '<ul>';
		foreach($res2 as $y)
		{
			echo '<li>' . $y->my_error . '</li>';
		}
		echo '</ul>';
	}
}

function mediumerrorreport_csv2post()
{
	global $wpdb;
	$sqlQuery = "INSERT INTO " . $wpdb->prefix . "csv2post_reports (line,file) VALUES ('$line','$file')";
	$wpdb->query($sqlQuery);
}

function fullerrorreport_csv2post()
{
	global $wpdb;
	$sqlQuery = "INSERT INTO " . $wpdb->prefix . "csv2post_reports (line,file) VALUES ('$line','$file')";
	$wpdb->query($sqlQuery);
}

function emailerrorreport_csv2post($line,$file,$my_error)
{	
	$email = $my_error;
	
	$email .= '
	<br />
	Server/Domain: ' . $_SERVER['HTTP_HOST'] .'
	<br />
	File Name: ' . $file . '
	<br />
	Line Number: ' . $line .'
	<br />
	';

	if(get_option('csv2post_debugmode') == 1)// email error@webtechglobal.co.uk
	{
		//wp_mail('error@webtechglobal.co.uk', 'CSV 2 POST Error Report', $email);
	}
}

?>