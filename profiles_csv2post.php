<div class="wrap">
  <h2>CSV 2 POST - CSV File Profiles</h2>
  
    <div id="poststuff" class="meta-box-sortables" style="position: relative; margin-top:10px;">
        
    <?php
    global $wpdb;
    
    $wysiwyg_finished = true;
        
    // prepare opendir for listing layout files
    $php_extension = 'php';
    $csv_extension = 'csv';
    
    $csvfiles_dir = csv2post_getcsvfilesdir();
    $csvfiles_diropen = opendir($csvfiles_dir);
    	
	// function used for special column function submission and to determine the first set state
    function csv2post_decidestate($v){  if( $v == 'NA' ){ return 'OFF'; }elseif( $v != 'NA' ){ return 'ON'; } }

    function process_wysiwyg($csvfilename)// processes a custom post layout submission - update or new insert
    {
        global $wpdb;
    
        $post_content_original = $_POST['content'];
        $post_title_original   = $_POST['post_title'];
		
		if( isset ( $_POST['csvfilename'] ) ){ $csvfilename = $_POST['csvfilename']; }

        $post_content = str_replace('<br>', '<br />', $post_content_original);
        $post_content = str_replace('<hr>', '<hr />', $post_content);
        $post_content = $wpdb->escape($post_content);		
		
		// first save the delimiter to csv files profile if it is being submitted
		if( isset ($_POST['delimiter'] ) )
		{
			$csvprofile = csv2post_getcsvprofile( $_POST['csvfilename'] );		
			$csvprofile['format']['delimiter'] = $_POST['delimiter'];
			update_option( csv2post_csvfilesprofilename($csvfilename), $csvprofile );
		}
		
        $file = csv2post_getcsvfilesdir() . $csvfilename;
        $handle = fopen("$file", "r");
                
        $num = 0;
    
        //build post_parts_layoutfile_csv2postplus() function 
        $cpl_function1 = '
        function post_parts_layoutfile_csv2post($i){?>
            <select name="posttypes<?php echo $i; ?>" size="1">
                <!--default options do not edit -->
                <option value="exclude" selected="selected">EXCLUDE</option><!-- csv columns not used -->
                <option value="customurlcloaking2">Cloak URL 2nd</option><!-- If default post date not wanted use data -->
                <!-- default options do not edit -->
        ';
        
        $post_title = $post_title_original;
            
        $stop_rows = 0;

		// first save the delimiter to csv files profile
		$csvprofile = csv2post_getcsvprofile( $_POST['csvfilename'] );

        while (($record = fgetcsv($handle, 5000, $csvprofile['format']['delimiter'])) !== FALSE && $stop_rows != 1)// get first csv row
        {
            $stop_rows++;// used to limit row parsing to just 1
            foreach($record as $postpart) 
            {
                $special_val = '%-' . $postpart . '-%';// value to locate
                $new_session = '@$_SESSION["' . $postpart . '"]';// new value (session variable)
                $new_val = "'.".$new_session.".'";
                $cpl_function1 .= '<option value="' . $postpart . '">' . $postpart . '</option>';
                $post_content = str_replace($special_val, $new_val, $post_content);
                $post_title = str_replace($special_val, $new_val, $post_title);
            }	
        }//end while rows
    
        $cpl_function1 .= '</select><?php } ';
        
        // build function post_content_layoutfile_csv2postplus() from cpl
        $cpl_function2 = 'function post_content_layoutfile_csv2post(){$';
        $cpl_function2 .= "post = '";
        $cpl_function2 .= $post_content;// content from WYSIWYG
        $cpl_function2 .= "'; return $";
        $cpl_function2 .= 'post;}';
        
        // build function manipulate_values_layoutfile_csv2postplus()
        $cpl_function3 = 'function manipulate_values_layoutfile_csv2post($post){';
        $cpl_function3 .= ' return $';
        $cpl_function3 .= 'post;}';
        
        $cpl_function4 = '
            function postparttitle_layoutfile_csv2post()
            {
                @$';
        $cpl_function4 .= '_SESSION["posttitle"] =  ';
        $cpl_function4 .= "'". $post_title . "'";
        $cpl_function4 .= ';}';	
        
        $code = $cpl_function1 . $cpl_function2 . $cpl_function3 . $cpl_function4;// puts all cpl parts together
        
        // prepare for database entry
        $code = mysql_real_escape_string( $code );
        $post_content = mysql_real_escape_string( $post_content );
        $post_title = mysql_real_escape_string( $post_title );
        $post_content_original = mysql_real_escape_string( $post_content_original );
        $post_title_original = mysql_real_escape_string( $post_title_original );
		
        if($_POST['action'] == 'process_wysiwygupdate')
        {
            $sqlQuery = "UPDATE " .	$wpdb->prefix . "csv2post_layouts 
            SET 
            code = '$code',
            wysiwyg_content = '$post_content_original',
            wysiwyg_title = '$post_title_original'
            WHERE csvfile = '$csvfilename'
			AND name = '$csvfilename'";
            $r = $wpdb->query( $sqlQuery );
            if( !$r )
            {
				echo '<div id="message" class="updated fade"><p>CSV Profile Not Saved - Possibly because there were no changes made!</p></div>';
            }
            else
            {			
				echo '<div id="message" class="updated fade"><p>Success - Your Custom Post Layout has been updated and it will also take effect on running campaigns!</p><p>Please remember to complete your entire CSV Profile by pairing your columns to the correct custom fields and any special functions you wish to use!</div>';
            }
            $wysiwyg_finished = true;
        }
        elseif($_POST['action'] == 'process_columnupdate')
        {
			$csvprofile = csv2post_getcsvprofile( $csvfilename );
			// create array of special column values
			$csvprofile['columns'] = array(
				'excerpt_column' => $_POST['excerpt_column'],
				'tags_column' => $_POST['tags_column'],
				'uniqueid_column' => $_POST['uniqueid_column'],
				'urlcloaking_column' => $_POST['urlcloaking_column'],
				'permalink_column' => $_POST['permalink_column'],
				'dates_column' => $_POST['dates_column']
			);
			// the state is a boolean switch which will be used to switch the special function on or off per campaign on stage 2
			$csvprofile['states'] = array(
				'excerpt_state' => csv2post_decidestate($_POST['excerpt_column']),
				'tags_state' => csv2post_decidestate($_POST['tags_column']),
				'uniqueid_state' => csv2post_decidestate($_POST['uniqueid_column']),
				'urlcloaking_state' => csv2post_decidestate($_POST['urlcloaking_column']),
				'permalink_state' => csv2post_decidestate($_POST['permalink_column']),
				'dates_state' => csv2post_decidestate($_POST['dates_column'])
			);
			update_option( csv2post_csvfilesprofilename($csvfilename), $csvprofile );
		    echo '<div id="message" class="updated fade"><p>Success - Your column pairing has been saved, you can make quick changes on Stage 2</div>';
		}
    }// end of function  		
    
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') 
    {
        ini_set('include_path',rtrim(ini_get('include_path'),';').';'.dirname(__FILE__).'/pear/');
    } 
    else 
    {
        ini_set('include_path',rtrim(ini_get('include_path'),':').':'.dirname(__FILE__).'/pear/');
    }
    
    require_once 'File/CSV.php';// PEAR csv file handling
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        $_POST = stripslashes_deep($_POST);
		// get post data
		$csvfilename = $_POST['csvfilename'];
		$post_title   = $_POST['post_title'];
        $post_content = $_POST['content'];		
		// get csv file profile
        $csvprofile = csv2post_getcsvprofile( $csvfilename );
		$delimiter = $csvprofile['format']['delimiter']; 
		
		if($_POST['action'] == 'quickprofile_submit')// update existing record
        {   			
            // user wants to apply existing csv profile to another csv profile - first get profile from options
			$csvprofile_secondaryprofile = csv2post_getcsvprofile( $_POST['csvfilename_secondary'] );// profile to be copied from
			update_option( csv2post_csvfilesprofilename($csvfilename), $csvprofile_secondaryprofile );// put the entire secondary profile into primary

			// get databse table stored information
			$res1 = $wpdb->get_row("SELECT * FROM " .$wpdb->prefix . "csv2post_layouts WHERE name = '$_POST[csvfilename_secondary]'");
			$wysiwyg_title = $res1->wysiwyg_title;
			$wysiwyg_content = $res1->wysiwyg_content;
			$name = $res1->name;
			$code = $res1->code;		

			$wysiwyg_title = mysql_real_escape_string( $wysiwyg_title );
			$wysiwyg_content = mysql_real_escape_string( $wysiwyg_content );
			$code = mysql_real_escape_string( $code );
		
            $sqlQuery = "UPDATE " .	$wpdb->prefix . "csv2post_layouts 
            SET 
            code = '$code',
            wysiwyg_content = '$wysiwyg_content',
            wysiwyg_title = '$wysiwyg_title'
            WHERE csvfile = '$csvfilename'
			AND name = '$csvfilename'";
            $res = $wpdb->query( $sqlQuery );
            if( !$res )
            {
				echo '<div id="message" class="updated fade"><p>Failed To Save - Sorry there has been a problem applying your selected profile to your csv file. Is it possible that it is already identical so no changes would be required in that case?</p></div>';
            }
            else
            {			
				echo '<div id="message" class="updated fade"><p>Success On Save - The selected CSV Profile has been applied to your New Profile.</p></div>';
            }
			$wysiwyg_finished = true;		
        }
		elseif($_POST['action'] == 'process_wysiwygupdate')// update existing record
        {   			
            list($notice, $message) = process_wysiwyg($csvfilename);           
            $wysiwyg_finished = true;
        }
        elseif($_POST['action'] == 'process_columnupdate')// update existing record
        {                          
            list($notice, $message) = process_wysiwyg($csvfilename);
            $wysiwyg_finished = true;
        }
        elseif($_POST['action'] == 'opencustompostlayout')// open exisitng record for editing
        {
            $csvfilename = $_POST['csvfilename'];
			
            if($_POST['submitbutton'] == 'Delete')
            {    
				$csvprofile = csv2post_getcsvprofile( $csvfilename );
				$delimiter = $csvprofile['format']['delimiter'];
                $user_count = $wpdb->get_var("SELECT COUNT(*) FROM " .$wpdb->prefix . "csv2post_campaigns WHERE camfile = '$csvfilename'");
                if($user_count >= 1)
                {
					echo '<div id="message" class="updated fade"><p>Cannot delete, currently in use! Please delete the campaign on the campaign management page then try again.</p></div>';
                }
                else
                {
					// delete wp option holding array of special column information for this file
					$optionname = 'csvprofile_' . $csvfilename;
					delete_option( $optionname );
                    $res3 = $wpdb->get_row("DELETE FROM " .$wpdb->prefix . "csv2post_layouts WHERE name = '$csvfilename'");
					echo '<div id="message" class="updated fade"><p>Custom Post Layout deleted successfully</p></div>';
                }
                $wysiwyg_finished = true;		
            }
            else
            {
                $res1 = $wpdb->get_row("SELECT * FROM " .$wpdb->prefix . "csv2post_layouts WHERE name = '$csvfilename'");
                $post_title = $res1->wysiwyg_title;
                $post_content = $res1->wysiwyg_content;
                $inuse = $res1->inuse;
                $csv2post_cpl_name = $res1->name;
				$csvprofile = csv2post_getcsvprofile( $csvfilename );
				$delimiter = $csvprofile['format']['delimiter'];
                $full_csvfilename = csv2post_getcsvfilesdir() . $csvfilename;
                # OPEN CSV FILE
                $csvfilehandle = fopen("$full_csvfilename", "r");
                $wysiwyg_finished = false;
            }
        }
    } 
        
    if($wysiwyg_finished == true)// if true then the wysiwyg editor is not shown and front page with file and profile lists is shown
    {?>
         <form method="post"><!-- Available CSV File List -->
            <input type="hidden" name="action" value="opencustompostlayout" />
                <div id="poststuff" class="metabox-holder">
                    <div id="datafeed-upload" class="postbox">
                        <h3 class='hndle'><span>Create New CSV File Profile</span></h3>
                        <div class="inside" style="padding:20px;">
                        <p>This box will list any csv files that have not yet had a profile completed. Select a new csv file and submit it to begin creating its profile</p>
                        <br />
                            <?php
                            $i = 0;
							while(false != ($csvfiles = readdir($csvfiles_diropen)))
							{
								if(($csvfiles != ".") and ($csvfiles != ".."))
								{
									$fileChunks = explode(".", $csvfiles);
									
									csv2post_createcsvprofile( $csvfiles );// create initial profile for csv files that may have been uploaded by ftp

									// check if profile already edited - if so do not display - causes only new csv files without profiles to be listed here
									$results = $wpdb->get_row("SELECT * FROM " .$wpdb->prefix . "csv2post_layouts WHERE csvfile = '$csvfiles' AND wysiwyg_content = 'TBC' AND wysiwyg_title = 'TBC' ");
									if( !empty ( $results ) )
									{
										if($fileChunks[1] == $csv_extension) //interested in second chunk only
										{
											++$i;
											$csvprofile = csv2post_getcsvprofile( $csvfiles );
											$delimiter = $csvprofile['format']['delimiter'];
											?>
											<label>
												<input type="radio" name="csvfilename" value="<?php echo $csvfiles;?>" /><?php echo $csvfiles; ?> 
											</label>
											<br /><?php
										}
									}
								}
							}
                            if( $i == 0 ){ echo '<h4>Either You Have No CSV Files Uploaded Or They All Have A Complete Profile Which You Can Edit Below</h4>';}
                            
                            closedir($csvfiles_diropen); 
                            ?>
                            <p class="submit"><input class="button-primary" type="submit" name="submitbutton" value="Submit" /></p>
                        </div>
                    </div>
                </div>
          </form>
            
            <form method="post">
                <input type="hidden" name="action" value="opencustompostlayout" />
                <div id="poststuff" class="metabox-holder">
                    <div id="datafeed-upload" class="postbox">
                        <h3 class='hndle'><span>Edit Profiles </span></h3>
                        <div class="inside" style="padding:20px;">
                            <?php
                                // list existing custom post layouts from database
                                $res1 = $wpdb->get_results("SELECT * FROM " .$wpdb->prefix . "csv2post_layouts WHERE type = '0' AND wysiwyg_content != 'TBC' AND wysiwyg_title != 'TBC'");
                                
                                if(! $res1 )
                                { 
                                    echo '<h4>You Have Not Created Any CSV File Profiles Yet</h4>';
                                }
                                else
                                {
                                    foreach($res1 as $x)
                                    {   
                                        ?>
                                        <label><input type="radio" name="csvfilename" value="<?php echo $x->name;?>" /><?php echo $x->name;?></label><br />
                                        <?php
                                    }
                                }
                            ?>
                            <p class="submit"><input class="button-primary" type="submit" name="submitbutton" value="Submit" /></p>
                        </div>
                    </div>
                </div>
            </form>
                    
        <?php        
        return;
    }
    elseif($wysiwyg_finished == false)
	{
		// start by retrieving csv files profile
		$csvprofile = csv2post_getcsvprofile( $csvfilename );?>

     <form method="post"><!-- This form is for selecting a csv file and applying its profile to the currently edited csv file -->
        <input type="hidden" name="action" value="quickprofile_submit" />
            <div id="poststuff" class="metabox-holder">
                <div id="datafeed-upload" class="postbox closed">
                    <h3 class='hndle'><span>Quick Profile for <?php echo $csvfilename;?></span></h3>
                    <div class="inside" style="padding:20px;">
                        <p>You can copy an existing CSV File's Profile to this one providing the format is exactly the same. This CSV File must have the same number of columns, they must be in the same order and have the same title as the Profile being copied from.</p>
                        <br />
                    
                    	<select name="csvfilename_secondary">
                        <?php
                            $i = 0;
							while(false != ($csvfiles2 = readdir($csvfiles_diropen)))
							{
								if(($csvfiles2 != ".") and ($csvfiles != ".."))
								{
									$fileChunks = explode(".", $csvfiles2);
									
									csv2post_createcsvprofile( $csvfiles2 );// create initial profile for csv files that may have been uploaded by ftp

									// check if profile already exist as completed - if so display
									$results = $wpdb->get_row("SELECT * FROM " .$wpdb->prefix . "csv2post_layouts WHERE csvfile = '$csvfiles2' AND wysiwyg_content != 'TBC' AND wysiwyg_title != 'TBC' ");
									if( !empty ( $results ) )
									{
										if($fileChunks[1] == $csv_extension) //interested in second chunk only
										{
											++$i;?><option value="<?php echo $csvfiles2; ?>" <?php echo $selected; ?>><?php echo $csvfiles2;?></option><?php 
										}
									}
								}
							}
                            if( $i == 0 ){ echo '<option value="NA" selected="selected">No Existing Profiles</option>';}
                        ?>
                        </select>
                        <input name="csvfilename" type="hidden" value="<?php echo $csvfilename;?>" />
                        <p class="submit"><input class="button-primary" type="submit" name="submitbutton" value="Apply Quick Profile" /></p>
                    </div>
                </div>
            </div>
      </form>
              
    <form method="post">
        <input type="hidden" name="action" value="process_wysiwygupdate" />
            <?php
				// get delimiter for current csv file			
				$delimiter = $csvprofile['format']['delimiter'];

				if($_POST['action'] == 'opencustompostlayout')// if cpl is in use display warning
				{
					if(isset($inuse) && $inuse == 1)
					{
    					?><h3>WARNING: <?php echo $csvfilename; ?> is currently in use by an active campaign!</h3><?php
					}
				}
			?>
            
		<div class="postbox closed">
            <div class="handlediv" title="Click to toggle"><br />
            </div>
             <h3>Custom Post Layout and Delimiter for <?php echo $csvfilename;?></h3>
                          
                <div class="inside">
                            
                <h4><a href="#" title="Special column title values, copy and paste these into the WYSIWYG editor (including title) as they represent where your data will appear in posts. These values should be listed one under the other. If they all appear on a single line then your delimiter may be incorrect, please change it further down the page.">Column Name Tokens</a></h4>
           
					<?php		
                    $stop_rows = 0;
                    
                    while (($data = fgetcsv($csvfilehandle, 5000, $delimiter)) !== FALSE && $stop_rows != 1)// get first csv row
                    {	 
                        $stop_rows++;// used to limit row parsing to just 1
                           
                               $i = 0;
                         
                                while(isset($data[$i]))
                                {
                                    $data[$i] = rtrim($data[$i]);
                                    echo '<b>%-' . $data[$i] . '-%</b><br /><br />';
                                    $i++; // $i will equal number of columns - use to process submission
                                }
                                
                                $csvfile_columntotal = $i;
                    
                    }//end while rows
                    
                    fclose($csvfilehandle);	
                    ?>  
                          
                    <h4><a href="#" title="If the column title tokens above are not listed properly (all on one line) then please change your delimiter to the correct value here then save before doing anything else.">CSV File Delimiter</a></h4>
                    <input type="text" name="delimiter" size="1" maxlength="1" value="<?php echo $delimiter; ?>" id="delimiter" />
                                        
                     <div id="titlediv">
                        <div id="titlewrap">
                        	<h4><a href="#" title="You can enter special values listed above into this title">Post Title</a></h4>
                          <input type="text" name="post_title" size="30" value="<?php if(isset($post_title)){echo attribute_escape($post_title);} ?>" id="title" />
                       </div>
                    </div>     
                    
                    
                     <div id="postdivrich" class="postarea">
                            <?php		
                            if(isset($post_content))
                            {
                                the_editor($post_content, 'content'); 
                            }
                            else
                            {
                                the_editor('', 'content'); 
                            }
                            ?>
                        <div id="post-status-info">
                            <span id="wp-word-count" class="alignleft"></span>
                        </div>
                    </div> 
                       
                    <input name="csvfilename" type="hidden" value="<?php echo $csvfilename;?>" />
                    <input name="cpl_id" type="hidden" value="<?php if(isset($cpl_id)){echo $cpl_id;}?>" />
                    <input class="button-primary" type="submit" value="Save Post Layout" />
                    
                    <br />
                    <br />
                    <h2><strong>Adding Images</strong></h2>
                    <object width="592" height="445"><param name="movie" value="http://www.youtube.com/v/zHjMU4p27Ec&hl=en_GB&fs=1&"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/zHjMU4p27Ec&hl=en_GB&fs=1&" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="592" height="445"></embed></object>
                    <h2><strong>Adding Links</strong></h2>
                    <object width="592" height="445"><param name="movie" value="http://www.youtube.com/v/ynbwQ9oVAj8&hl=en_GB&fs=1&"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/ynbwQ9oVAj8&hl=en_GB&fs=1&" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="592" height="445"></embed></object>
                    <h2><strong>WYSIWYG Basics</strong></h2>
                  <object width="592" height="445"><param name="movie" value="http://www.youtube.com/v/GYrgKv6hWOQ&hl=en_GB&fs=1&"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/GYrgKv6hWOQ&hl=en_GB&fs=1&" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="592" height="445"></embed></object>
  			</div>
        </div>    
    </form>
           
    <!-- Special column values begin here and are saved on a seperate form form WYSIWYG editor because the editor always requires a change in order to update -->
    <form method="post">
        <input type="hidden" name="action" value="process_columnupdate" />
                   
        <!-- Special Item Start -->
        <div class="postbox closed">
        <div class="handlediv" title="Click to toggle"><br />
        </div>
         <h3>Pair Columns Too Custom Fields &amp; Special Functions for <?php echo $csvfilename;?></h3>
            <div class="inside">
                <h2><strong><a href="#" title="Your data does not need to have a ready made excerpt. Simply select the biggest chunk of text used to describe your item and the plugin will create an excerpt from the first lines.">Excerpt</a></strong></h2>
                <table width="649">
                    <tr>
                        <td width="163">Not Applicable</td>
                        <td width="15"></td>
                        <td><input type="radio" name="excerpt_column" value="NA" <?php if( $csvprofile['columns']['excerpt_column'] == 'NA' ){ echo 'checked="checked"'; } ?> /></td>
                  </tr>
                <?php
                    $i = 0;
                    $stop_rows = 0;
                    $handle2 = fopen("$full_csvfilename", "r");
                    while (($data = fgetcsv($handle2, 5000, $delimiter)) !== FALSE && $stop_rows != 1)// get first csv row
                    {	 
                        $stop_rows++;// used to limit row parsing to just 1
                                                  
                        while(isset($data[$i]))
                        {
                            $data[$i] = rtrim($data[$i]);
                                ?>
                                <tr>
                                    <td width="163"><?php echo $data[$i]; ?></td>
                                    <td width="15"></td>
                                    <td><input type="radio" name="excerpt_column" value="<?php echo $i;?>"<?php if( $csvprofile['columns']['excerpt_column'] != 'NA' && $csvprofile['columns']['excerpt_column'] == $i ){ echo 'checked="checked"'; } ?> /></td>
                                </tr><?php							
                                $i++; // $i will equal number of columns - use to process submission
                        }
                    
                    }//end while rows
                    ?>
              </table>

              <h2><strong><a href="#" title="Much like the Excerpt funcion, simply pair up a column of data that has a lot of text and the plugin will automatically generate tags.">Select Column For Generating Tags</a></strong>              </h2>
              <table width="649">
                    <tr>
                        <td width="163">Not Applicable</td>
                        <td width="15"></td>
                        <td><input type="radio" name="tags_column" value="NA" <?php if( $csvprofile['columns']['tags_column'] == 'NA' ){ echo 'checked="checked"'; } ?> /></td>
                </tr>
                    <?php
                    $i = 0;
                    $stop_rows = 0;
                    $handle2 = fopen("$full_csvfilename", "r");
                    while (($data = fgetcsv($handle2, 5000, $delimiter)) !== FALSE && $stop_rows != 1)// get first csv row
                    {	 
                        $stop_rows++;// used to limit row parsing to just 1
                                                  
                        while(isset($data[$i]))
                        {
                            $data[$i] = rtrim($data[$i]);
                                ?>
                                <tr>
                                    <td width="163"><?php echo $data[$i]; ?></td>
                                    <td width="15"></td>
                                    <td><input type="radio" name="tags_column" value="<?php echo $i;?>"<?php if( $csvprofile['columns']['tags_column'] != 'NA' && $csvprofile['columns']['tags_column'] == $i ){ echo 'checked="checked"'; } ?> /></td>
                                </tr><?php							
                                $i++; // $i will equal number of columns - use to process submission
                        }
                    
                    }//end while rows
                    ?>
                </table>

              <h2><strong><a href="#" title="If you want to use Automatic Updating you must pair up a column of data that has ID's such as SKU code or IBSN">Select Unique ID Column</a></strong>              </h2>
              <table width="649">
                    <tr>
                        <td width="163">Not Applicable</td>
                        <td width="15"></td>
                        <td><input type="radio" name="uniqueid_column" value="NA" <?php if( $csvprofile['columns']['uniqueid_column'] == 'NA' ){ echo 'checked="checked"'; } ?> /></td>
                </tr>
                    <?php
                    $i = 0;
                    $stop_rows = 0;
                    $handle2 = fopen("$full_csvfilename", "r");
                    while (($data = fgetcsv($handle2, 5000, $delimiter)) !== FALSE && $stop_rows != 1)// get first csv row
                    {	 
                        $stop_rows++;// used to limit row parsing to just 1
                                                  
                        while(isset($data[$i]))
                        {
                            $data[$i] = rtrim($data[$i]);
                                ?>
                                <tr>
                                    <td width="163"><?php echo $data[$i]; ?></td>
                                    <td width="15"></td>
                                    <td><input type="radio" name="uniqueid_column" value="<?php echo $i;?>"<?php if( $csvprofile['columns']['uniqueid_column'] != 'NA' && $csvprofile['columns']['uniqueid_column'] == $i ){ echo 'checked="checked"'; } ?> /></td>
                                </tr><?php							
                                $i++; // $i will equal number of columns - use to process submission
                        }
                    
                    }//end while rows
                    ?>
                </table>

              <h2><strong><a href="#" title="If you would like to cloak URL's and let CSV 2 POST count outbound clicks then pair up the column that has your link urls.">Select URL Column For Cloaking</a></strong>              </h2>
              <table width="649">
                    <tr>
                        <td width="163">Not Applicable</td>
                        <td width="15"></td>
                        <td><input type="radio" name="urlcloaking_column" value="NA" <?php if( $csvprofile['columns']['urlcloaking_column'] == 'NA' ){ echo 'checked="checked"'; } ?> /></td>
                </tr>
                    <?php
                    $i = 0;
                    $stop_rows = 0;
                    $handle2 = fopen("$full_csvfilename", "r");
                    while (($data = fgetcsv($handle2, 5000, $delimiter)) !== FALSE && $stop_rows != 1)// get first csv row
                    {	 
                        $stop_rows++;// used to limit row parsing to just 1
                                                  
                        while(isset($data[$i]))
                        {
                            $data[$i] = rtrim($data[$i]);
                                ?>
                                <tr>
                                    <td width="163"><?php echo $data[$i]; ?></td>
                                    <td width="15"></td>
                                    <td><input type="radio" name="urlcloaking_column" value="<?php echo $i;?>"<?php if( $csvprofile['columns']['urlcloaking_column'] != 'NA' && $csvprofile['columns']['urlcloaking_column'] == $i ){ echo 'checked="checked"'; } ?> /></td>
                                </tr><?php							
                                $i++; // $i will equal number of columns - use to process submission
                        }
                    
                    }//end while rows
                    ?>
                </table>

              <h2><strong><a href="#" title="If you have pre-made url structures select that column here. This is rare so please do not use unless you understand what you are doing.">Select Column For Custom Post Name/Slug/URL/Permalink</a></strong>              </h2>
              <table width="649">
                    <tr>
                        <td width="163">Not Applicable</td>
                        <td width="15"></td>
                        <td><input type="radio" name="permalink_column" value="NA" <?php if( $csvprofile['columns']['permalink_column'] == 'NA' ){ echo 'checked="checked"'; } ?> /></td>
                </tr>
                    <?php
                    $i = 0;
                    $stop_rows = 0;
                    $handle2 = fopen("$full_csvfilename", "r");
                    while (($data = fgetcsv($handle2, 5000, $delimiter)) !== FALSE && $stop_rows != 1)// get first csv row
                    {	 
                        $stop_rows++;// used to limit row parsing to just 1
                                                  
                        while(isset($data[$i]))
                        {
                            $data[$i] = rtrim($data[$i]);
                                ?>
                                <tr>
                                    <td width="163"><?php echo $data[$i]; ?></td>
                                    <td width="15"></td>
                                    <td><input type="radio" name="permalink_column" value="<?php echo $i;?>"<?php if( $csvprofile['columns']['permalink_column'] != 'NA' && $csvprofile['columns']['permalink_column'] == $i ){ echo 'checked="checked"'; } ?> /></td>
                                </tr><?php							
                                $i++; // $i will equal number of columns - use to process submission
                        }
                    
                    }//end while rows
                    ?>
                </table>

        

              <h2><strong><a href="#" title="If you already have dates in your csv file then please select your column of data here. Please remember that there is a function on Stage3 of the New Campaign process for randomising dates. You can also set the data range for that on Settings page.">Select Column For Post Publish Dates</a></strong>                </h2>
              <table width="649">
                  <tr>
                        <td width="163">Not Applicable</td>
                        <td width="15"></td>
                        <td><input type="radio" name="dates_column" value="NA" <?php if( $csvprofile['columns']['dates_column'] == 'NA' ){ echo 'checked="checked"'; } ?> /></td>
                </tr>
                    <?php
                    $i = 0;
                    $stop_rows = 0;
                    $handle2 = fopen("$full_csvfilename", "r");
                    while (($data = fgetcsv($handle2, 5000, $delimiter)) !== FALSE && $stop_rows != 1)// get first csv row
                    {	 
                        $stop_rows++;// used to limit row parsing to just 1
                                                  
                        while(isset($data[$i]))
                        {
                            $data[$i] = rtrim($data[$i]);
                                ?>
                                <tr>
                                    <td width="163"><?php echo $data[$i]; ?></td>
                                    <td width="15"></td>
                                    <td><input type="radio" name="dates_column" value="<?php echo $i;?>"<?php if( $csvprofile['columns']['dates_column'] != 'NA' && $csvprofile['columns']['dates_column'] == $i ){ echo 'checked="checked"'; } ?> /></td>
                                </tr><?php							
                                $i++; // $i will equal number of columns - use to process submission
                        }
                    
                    }//end while rows
                    ?>
              </table>
                
                <input name="csvfilename" type="hidden" value="<?php echo $csvfilename;?>" />
		        <input class="button-primary" type="submit" value="Save Profile" />

              <h2>Special Functions Tutorial</h2>
                <object width="602" height="583"><param name="movie" value="http://www.youtube.com/v/wgSaKdJ4dyw&hl=en&fs=1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/wgSaKdJ4dyw&hl=en&fs=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="602" height="583"></embed></object>
                
          </div>
        </div>    <!-- END OF ACCORDIAN -->
        <!-- Special Item Finish -->
                               
    </form>
    </div>
    <?php
    }
    ?>
                    
	<script type="text/javascript">
    // <![CDATA[
    jQuery('.postbox div.handlediv').click( function() { jQuery(jQuery(this).parent().get(0)).toggleClass('closed'); } );
    jQuery('.postbox h3').click( function() { jQuery(jQuery(this).parent().get(0)).toggleClass('closed'); } );
    jQuery('.postbox.close-me').each(function(){
    jQuery(this).addClass("closed");
    });
    //-->
    </script>
  </div><!-- end of poststuff div id -->
</div>
  