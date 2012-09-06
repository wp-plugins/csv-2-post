<?php 
global $wtgcsv_twitter,$wtgcsv_feedburner;
?>
<p>
    <a href="https://twitter.com/<?php echo $wtgcsv_twitter;?>" class="twitter-follow-button" data-show-count="false">Follow @twitterapi</a>
    <script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>    
    <form style="border:1px solid #ccc;padding:5px;" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $wtgcsv_feedburner;?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true"><p>Subscribe For New Version Updates:</p><p><input type="text" style="width:280px" name="email"/></p><input type="hidden" value="<?php echo $wtgcsv_feedburner;?>" name="uri"/><input type="hidden" name="loc" value="en_US"/><input type="submit" value="Subscribe" /></form>
</p>