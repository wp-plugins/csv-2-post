<h2>New Campaign Stage 1 - Main Settings <a href="http://www.csv2post.com/blog/instructions/how-to-use-new-campaign-stage-1" target="_blank"><img src="http://www.csv2post.com/images/question_small.png" width="35" height="35" alt="Get help for Stage 1" /></a></h2>

<form enctype="multipart/form-data"  method="post" action="<?php $_SERVER['PHP_SELF']; ?>" name="new_campaign1">

  <div id="poststuff" class="metabox-holder">
        <div id="post-body">
            <div id="post-body-content">
                <div class="postbox">
                    <h3 class='hndle'><span>Enter Campaign Name:</span></h3>
                    <div class="inside">
                    	<input type="text" name="campaignname" id="campaignname" />
                    </div>  
                </div>
            </div>
        </div>
    </div>
    
    <div id="poststuff" class="metabox-holder">
        <div id="post-body">
            <div id="post-body-content">
                <div class="postbox">
                    <h3 class='hndle'><span>Select Processing Method</span></h3>
                    <div class="inside"><label>
                        <input type="radio" name="processrate" value="1" id="ProcessRate_0" <?php if(get_option('csv2post_demomode') == 1){echo 'disabled="disabled"';}?> />
                        Full</label>
                        <br />
                        
                        <label>
                        <input type="radio" name="processrate" value="2" id="ProcessRate_1" />
                        Staggered</label>
                        <br />
                        
                        <input type="radio" name="processrate" value="3" id="ProcessRate_2" />
                        Scheduled </label>
                        <input type="text" name="processratescheduled" id="processratescheduled" size="4" <?php if(get_option('csv2post_demomode') == 1){echo 'maxlength="1"';}?> />
                       <?php if(get_option('csv2post_demomode') == 1){echo ' Limited to one digit in demo mode!';}?>
                    </div>  
                </div>
            </div>
        </div>
    </div>
    
    <div id="poststuff" class="metabox-holder">
        <div id="post-body">
            <div id="post-body-content">
                <div class="postbox">
                    <h3 class='hndle'><span>Select CSV File</span></h3>
                    <div class="inside">    
                    	<p>A csv files name will only appear here if you have created or assigned a profile to it.</p>
					<?php
                          while(false != ($csvfiles = readdir($csvfiles_diropen)))
                          {
                            if(($csvfiles != ".") and ($csvfiles != ".."))
                            {
                              $fileChunks = explode(".", $csvfiles);
                              if($fileChunks[1] == $csv_extension) //interested in second chunk only
                              { 
								$results = $wpdb->get_row("SELECT * FROM " .$wpdb->prefix . "csv2post_layouts WHERE csvfile = '$csvfiles' AND wysiwyg_content != 'TBC' AND wysiwyg_title != 'TBC' ");
								if( !empty ( $results ) )
								{
									$csvprofile = csv2post_getcsvprofile( $csvfiles );
									$file_delimiter = $csvprofile['format']['delimiter'];?>
									<label>
									<input type="radio" name="csvfilename" value="<?php echo $csvfiles;?>" <?php if(empty($file_delimiter)){echo 'disabled="disabled"';}?> /><?php echo $csvfiles; ?> 
									<?php if(empty($file_delimiter)){echo ' empty, it must be entered on the CSV Uploader page before use! ';}?>
									</label>
									<br /><?php
								}
                              }
                            }
                          }
                          closedir($csvfiles_diropen); 
                    ?>
                    </div>  
                </div>
            </div>
        </div>
    </div>
         
    <br />

    <input name="stage" type="hidden" value="1" />
    <input name="page" type="hidden" value="new_campaign" />
    <input type="hidden" name="MAX_FILE_SIZE" value="90000000" />
    <input name="campaignsubmit" class="button-primary" type="submit" value="Next Step" />
</form>
<br />
<h2>New Campaign Quick Tutorial</h2>
<object width="589" height="430"><param name="movie" value="http://www.youtube.com/v/IThvP97pszE&hl=en&fs=1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/IThvP97pszE&hl=en&fs=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="589" height="430"></embed></object>