<h2>New Campaign Stage 5 - Category Creation &amp; Filtering <a href="http://www.csv2post.com/blog/instructions/how-to-use-new-campaign-stage-5" target="_blank"><img src="http://www.csv2post.com/images/question_small.png" width="35" height="35" alt="Get help for Stage 5" /></a></h2>

<?php
$csvprofile = csv2post_getcsvprofile( $_POST['csvfilename'] );
?>

<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" name="new_campaign3">

    <div id="poststuff" class="metabox-holder">
        <div id="post-body">
            <div id="post-body-content">
                <div class="postbox">
                
                    <h3 class='hndle'><span>Select Filter Method</span></h3>
                    <div class="inside">
    
                        <p><label><input type="radio" name="filtermethod" value="manual"  />
                          <a href="#" title="Manual requires you to only complete the form items at the very bottom">Manual</a></label>
                        </p>
                        <p><label><input type="radio" name="filtermethod" value="automated" />
                          <a href="#" title="By selecting this you will let the plugin generate categories and assign posts to them. You must select at least a parent category and you have the option of selecting sub/child categories.">Automated</a></label>
                        </p>
                        <p><label><input type="radio" name="filtermethod" value="mixed" />
                          <a href="#" title="This is both manual and automated together with manual having priority. The plugin will first look for the categories entered into the form at the bottom of the page before creating new ones. This is perfect if your data has some categories that are not named exactly the same as categories already in your blog. Manual will avoid creating those categories then ending up with duplicates. Then the rest of your category will be created automatically as normal.">Mixed</a></label>
                        </p>
                        <p><label><input type="radio" name="filtermethod" value="NA" checked="checked" />
                          <a href="#" title="Select this if you do not want the plugin to create categories for you or filter posts to different categories. You must still select the default category for posts to end up published too.">Not Required</a>:
							<select name="defaultpostcategory" size="1"><?php get_categories_fordropdownmenu_csv2post();?></select></label></p>
                  
                     </div>                    
                </div>
            </div>
        </div>
        
        <div id="post-body">
            <div id="post-body-content">
                <div class="postbox">
                
                    <h3 class='hndle'><span>Main/Parent Filter Column</span></h3>
                    <div class="inside">
    
                        <?php
                           $handle = fopen("$csvfiledirectory", "r");
                        
                            $stop = 0;
                           while (($data = fgetcsv($handle, 5000, $csvprofile['format']['delimiter'])) !== FALSE && $stop != 1)// Gets CSV rows
                            {	 
                                $stop++;// used to limit row parsing to just 1
                    
                                $i = 0; ?>
                                <select name="optedfiltercolumn" size="1">
                                <option value="999">Not Required</option>
                                <?php
                                while(isset($data[$i]))
                                {
                                    $data[$i] = rtrim($data[$i]);
                                    
                                    ?><option value="<?php echo $i; ?>"><?php echo $data[$i];?></option><?php
                                    
                                    $i++; // $i will equal number of columns - use to process submission
                                }?></select>
                                <?php
                            }
                            
                            fclose($handle);
                            ?> 
                                <a href="#" title="If your using Manual or Not Required for Filtering then please do not use this">Must be used with Automated and Mixed Filter Methods</a></div>                    
                </div>
            </div>
        </div>
      
          <div id="post-body">
            <div id="post-body-content">
                <div class="postbox">
                
                    <h3 class='hndle'><span>Child/Sub Category Creation and Filtering (Parent/Child)</span></h3>
                    <div class="inside">
                        <?php
                          $handle = fopen("$csvfiledirectory", "r");
                        
                          $stop = 0;
                        
                           while (($data = fgetcsv($handle, 5000, $csvprofile['format']['delimiter'])) !== FALSE && $stop != 1)// Gets CSV rows
                            {	 
                                $stop++;// used to limit row parsing to just 1
                    
                                $i = 0; ?>
                                <select name="optedfiltercolumn2" size="1">
                                <option value="999">Not Required</option>
                                <?php
                                while(isset($data[$i]))
                                {
                                    $data[$i] = rtrim($data[$i]);
                                    
                                    ?><option value="<?php echo $i; ?>"><?php echo $data[$i];?></option><?php
                                    
                                    $i++; // $i will equal number of columns - use to process submission
                                }?></select>
                                <?php
                            }
                            
                            fclose($handle);
                            ?>        
                     <a href="#" title="If your using Manual or Not Required for Filtering then please do not use this">Optional with Automated and Mixed Filter Methods</a></div>                    
                </div>
            </div>
        </div>              
                        
          <div id="post-body">
            <div id="post-body-content">
                <div class="postbox">
                
                    <h3 class='hndle'><span>Child of Child Category Creation and Filtering (Parent/Child/Child)</span></h3>
                    <div class="inside">
                        <?php
                           $handle = fopen("$csvfiledirectory", "r");
                        
                            $stop = 0;
                        
                           while (($data = fgetcsv($handle, 5000, $csvprofile['format']['delimiter'])) !== FALSE && $stop != 1)// Gets CSV rows
                            {	 
                                $stop++;// used to limit row parsing to just 1
                    
                                $i = 0; ?>
                                <select name="optedfiltercolumn3" size="1">
                                <option value="999">Not Required</option>
                                <?php
                                while(isset($data[$i]))
                                {
                                    $data[$i] = rtrim($data[$i]);
                                    
                                    ?><option value="<?php echo $i; ?>"><?php echo $data[$i];?></option><?php
                                    
                                    $i++; // $i will equal number of columns - use to process submission
                                }?></select>
                                <?php
                            }
                            
                            fclose($handle);
                            ?>        
                     <a href="#" title="If your using Manual or Not Required for Filtering then please do not use this">Optional with Automated and Mixed Filter Methods</a></div>                    
                </div>
            </div>
        </div>                         
    
    
        <p><input name="categoryfiltervalues" class="button-primary" type="submit" value="Submit" /></p>
    
    
          <div id="post-body">
            <div id="post-body-content">
                <div class="postbox">
                
                    <h3 class='hndle'><span>Enter Manual or Mixed Filter Values Below</span></h3>
                    <div class="inside">
                         <table>
                            
                            <tr>
                                <td><b>Data Value</b> </td><td><b>Category</b></td>
                            </tr>
                            
                            <?php
                            $number = 16;
                            $count = 1;
                            while($count != $number)
                            {   # ECHO A SET OF FILTER FIELDS ?>
                                <tr>
                                    <td><?php echo $count; ?>: <input name="cat<?php echo $count; ?>a" type="text" value="" size="30" maxlength="50" />
                                    <select name="cat<?php echo $count; ?>b" size="1"><?php get_categories_fordropdownmenu_csv2post();?></select></td>
                                    <td></td>
                                </tr><?php 
                                $count++;
                            }
                            ?>
                      </table>   
                     </div>                    
                </div>
            </div>
        </div>       
    </div>
    
    <input name="csvfile_columntotal" type="hidden" value="<?php echo $csvfile_columntotal; ?>" />
    <input name="stage" type="hidden" value="5" />
    <input name="page" type="hidden" value="new_campaign" />
    <input name="csvfiledirectory" type="hidden" value="<?php echo $csvfiledirectory; ?>" />
    <input name="camid" type="hidden" value="<?php echo $camid; ?>" />
    <input name="poststatus" type="hidden" value="<?php echo $_POST['poststatus']; ?>" />
	<input name="csvfilename" type="hidden" value="<?php echo $_POST['csvfilename']; ?>" />
</form>