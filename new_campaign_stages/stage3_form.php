<h2>New Campaign Stage 3 - Post Status <a href="http://www.csv2post.com/blog/instructions/how-to-use-new-campaign-stage-3" target="_blank"><img src="http://www.csv2post.com/images/question_small.png" width="35" height="35" alt="Get help for Stage 3" /></a></h2>

<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" name="new_campaign3">

    <div id="poststuff" class="metabox-holder">
        <div id="post-body">
            <div id="post-body-content">
                <div class="postbox">
                    <h3 class='hndle'><span>Post Status:</span></h3>
                    <div class="inside">
                        <table>
                            <tr>
                                <td>Publish</td>
                                <td><input type="radio" name="poststatus" value="publish" id="poststatus_0" /></td>
                                <td></td>
                            </tr>     			
                            
                            <tr>
                                <td>Pending</td>
                                <td><input type="radio" name="poststatus" value="pending" id="poststatus_1" /></td>
                                <td></td>
                            </tr>
                                                
                            <tr>
                                <td>Draft </td>
                                <td><input type="radio" name="poststatus" value="draft" id="poststatus_2" /></td>
                                <td></td>
                            </tr>
                        </table>                  
                    </div>  
                </div>
            </div>
        </div>
    </div>

    <div id="poststuff" class="metabox-holder">
        <div id="post-body">
            <div id="post-body-content">
                <div class="postbox">
                    <h3 class='hndle'><span>Other Publish Settings:</span></h3>
                    <div class="inside">
                        <table>
                            <tr>
                                <td></td>
                                <td><a href="#" title="You can set a date range on the settings page and use this option to apply random publish dates to your new posts">Random Post Date</a>:
<input name="randomdate" type="checkbox" value="1" /></td>
                                <td></td>
                            </tr>
                        </table>                  
                    </div>  
                </div>
            </div>
        </div>
    </div>

            <input name="csvfile_columntotal" type="hidden" value="<?php echo $csvfile_columntotal; ?>" />
            <input name="stage" type="hidden" value="3" />
            <input name="page" type="hidden" value="new_campaign" />
            <input name="csvfiledirectory" type="hidden" value="<?php echo $csvfiledirectory; ?>" />
            <input name="camid" type="hidden" value="<?php echo $camid; ?>" />
            <input name="camid_option" type="hidden" value="<?php echo $_POST['camid_option']; ?>" />
            <input name="statussubmit" class="button-primary" type="submit" value="Submit" />
			<input name="csvfilename" type="hidden" value="<?php echo $_POST['csvfilename']; ?>" />
</form>

