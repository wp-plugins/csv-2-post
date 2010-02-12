<h2>New Campaign Stage 4 - Custom Fields <a href="http://www.csv2post.com/blog/instructions/how-to-use-new-campaign-stage-4" target="_blank"><img src="http://www.csv2post.com/images/question_small.png" width="35" height="35" alt="Get help for Stage 4" /></a></h2>

<h3>Select Method of Creating Custom Fields</h3>        
<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" name="new_campaign4">
    <table>
        <tr>
            <td><input type="radio" name="customfieldsmethod" value="automated" />
            <a href="#" title="This will make a custom field for every piece of data in a record for each posts. The custom field name will be the csv file column name which the data comes from.">Automated</a></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td><input type="radio" name="customfieldsmethod" value="manual" />
            <a href="#" title="Manuall setup custom fields below by entering the custom field names and their values. You can match a custom field name to a column of data to assign that columns data to the custom field in all posts created. This is perfect for ShopperPress">Manual</a></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td height="10"></td>
            <td></td>
            <td></td>
      </tr>
  <tr>
            <td><b>Identifier/Name</b></td>
            <td></td>
            <td><b>Assigned Value</b></td>
        </tr>
        
        <tr>
            <td>1:
              <input name="manual_customfield1a" type="text" value="" maxlength="30" /></td>
            <td></td>
            <td><input name="manual_customfield1b" type="text" value="" maxlength="30" /></td>
        </tr>

        <tr>
            <td>2:
              <input name="manual_customfield2a" type="text" value="" maxlength="30" /></td>
            <td></td>
            <td><input name="manual_customfield2b" type="text" value="" maxlength="30" /></td>
        </tr>
        
        <tr>
            <td>3:
              <input name="manual_customfield3a" type="text" value="" maxlength="30" /></td>
            <td></td>
            <td><input name="manual_customfield3b" type="text" value="" maxlength="30" /></td>
        </tr>
        
        <!-- CUSTOM FIELDS MARRIED TO COLUMNS FOR UNIQUE VALUE ENTRY PER POST AFTER HERE -->                    
      		<tr>
            <td colspan="3"><h3><a href="#" title="Use the form items below if you need to setup custom fields for themes like ShopperPress or ClassiPress. The form above here is for assigning a none unique value to all posts such as personal note.">Column Assigned Custom Fields</a></h3></td>
        </tr>
         
      <?php                 
	$typ2_counter = 1;
	$typ2_counter_special = 1;// used as column ID
	$fields = get_option('csv2post_stage4fieldscolumns') + 1;
	while($typ2_counter < $fields )
	{?>
	
    <tr>
    <td><?php echo $typ2_counter;?>:<input name="customfield<?php echo $typ2_counter;?>a" type="text" value="" maxlength="30" /></td>
    <td></td>
    <td><select name="customfield<?php echo $typ2_counter;?>b" size="1">      
    <?php
	$csvprofile = csv2post_getcsvprofile( $_POST['csvfilename'] );

    $typ2_counter_special = fopen("$csvfiledirectory", "r");
    $stop = 0;
    while (($data = fgetcsv($typ2_counter_special, 5000, $csvprofile['format']['delimiter'])) !== FALSE && $stop != 1)// Gets CSV rows
    {	 
		$stop++;// used to limit row parsing to just 1
		$i = 0; 
		$v = 1;
		while(isset($data[$i]))
		{
			$data[$i] = rtrim($data[$i]);
			?><option value="<?php echo $v; ?>"><?php echo $v . ' - ' . $data[$i]; ?></option><?php
			$i++; // $i will equal number of columns - use to process submission
			$v++;
		}
    }
    fclose($typ2_counter_special);
    ?>
    </select></td>
    </tr>
        
     <?php
	 	$typ2_counter++;
	 	$typ2_counter_special++;
	  }
	  ?>
   
        <tr>
            <td></td>
            <td></td>
            <td><input name="customfieldssubmit" class="button-primary" type="submit" value="Submit" /></td>
            <td></td>
        </tr>
        
    </table>
    
<input name="csvfile_columntotal" type="hidden" value="<?php echo $csvfile_columntotal; ?>" />
    <input name="stage" type="hidden" value="4" />
    <input name="page" type="hidden" value="new_campaign" />
    <input name="csvfiledirectory" type="hidden" value="<?php echo $csvfiledirectory; ?>" />
    <input name="camid" type="hidden" value="<?php echo $camid; ?>" />
    <input name="camid_option" type="hidden" value="<?php echo $_POST['camid_option']; ?>" />
    <input name="poststatus" type="hidden" value="<?php echo $status; ?>" />
    <input name="randomdate" type="hidden" value="<?php echo $randomdate; ?>" />
	<input name="csvfilename" type="hidden" value="<?php echo $_POST['csvfilename']; ?>" />
</form>

<div id="poststuff" class="metabox-holder">
    <div id="post-body">
        <div id="post-body-content">
            <div class="postbox">
                <h3 class='hndle'><span>ShopperPress Custom Fields</span> - Visit <a href="https://secure.avangate.com/order/product.php?PRODS=2929632&amp;QTY=1&amp;AFFILIATE=8691" title="Visit the ShopperPress website">ShopperPress</a></h3>
                <div class="inside">
                  <p>
                        <a href="https://secure.avangate.com/order/product.php?PRODS=2929632&amp;QTY=1&amp;AFFILIATE=8691" title="Example Data Value:19.99 - Example Display:$19.99">price</a> - 
                        <a href="https://secure.avangate.com/order/product.php?PRODS=2929632&amp;QTY=1&amp;AFFILIATE=8691" title="Example Data Value:29.99 --- Example Display:Was $29.99 Now $19.99">old_price</a> - 
                        <a href="https://secure.avangate.com/order/product.php?PRODS=2929632&amp;QTY=1&amp;AFFILIATE=8691" title="Example Data Value:http://www.website.com/image.jpg --- Example Display:Displays as a small image on the home and search pages.">image</a> - 
                        <a href="https://secure.avangate.com/order/product.php?PRODS=2929632&amp;QTY=1&amp;AFFILIATE=8691" title="Example Data Value:image.jpg,image.jpg,image.jpg --- Example Display:Will create a product image selection field under the product main page. Seperate each image with a comma.">images</a> - 
                        <a href="https://secure.avangate.com/order/product.php?PRODS=2929632&amp;QTY=1&amp;AFFILIATE=8691" title="Example Data Value:http://www.website.com/image.jpg --- Example Display:This will be used instead of the ‘image’ field in search results for people who wish to create custom thumbnails.">thumbnail</a> - 
                        <a href="https://secure.avangate.com/order/product.php?PRODS=2929632&amp;QTY=1&amp;AFFILIATE=8691" title="Cost of postage and packaging without any currency symbol in the data">shipping</a> - 
                        <a href="https://secure.avangate.com/order/product.php?PRODS=2929632&amp;QTY=1&amp;AFFILIATE=8691" title="Repair and replace terms">warranty</a> - 
                        <a href="https://secure.avangate.com/order/product.php?PRODS=2929632&amp;QTY=1&amp;AFFILIATE=8691" title="Number of this item available">qty</a> - 
                        <a href="https://secure.avangate.com/order/product.php?PRODS=2929632&amp;QTY=1&amp;AFFILIATE=8691" title="Apply image data to this to trigger featured item function for an item, you may not want to use this on mass import">featured</a> - 
                        <a href="https://secure.avangate.com/order/product.php?PRODS=2929632&amp;QTY=1&amp;AFFILIATE=8691" title="Product options such as colour">customlist1</a> - 
                        <a href="https://secure.avangate.com/order/product.php?PRODS=2929632&amp;QTY=1&amp;AFFILIATE=8691" title="Product options such as sizes">customlist2</a> - 
                        <a href="https://secure.avangate.com/order/product.php?PRODS=2929632&amp;QTY=1&amp;AFFILIATE=8691" title="Using amazon products will require amazon link in this custom field">amazon_link</a> - 
                        <a href="https://secure.avangate.com/order/product.php?PRODS=2929632&amp;QTY=1&amp;AFFILIATE=8691" title="The amazon guid would be applied if in use">amazon_guid</a> - <a href="https://secure.avangate.com/order/product.php?PRODS=2929632&amp;QTY=1&amp;AFFILIATE=8691" title="If your selling downloadable goods this should be the full web path to the file">file</a></a> - 
                   <a href="https://secure.avangate.com/order/product.php?PRODS=2929632&amp;QTY=1&amp;AFFILIATE=8691" title="Only use this and make the value &quot;article&quot; if you want to make the post an article, not normally used in mass import">type</a></p>
                </div>  
          </div>
        </div>
    </div>
</div>

<object width="425" height="344"><param name="movie" value="http://www.youtube.com/v/kvVLyfO5Y90&hl=en&fs=1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/kvVLyfO5Y90&hl=en&fs=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="425" height="344"></embed></object>