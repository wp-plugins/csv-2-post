<?php 
global $csv2post_twitter,$csv2post_feedburner;
?>
<p>
    <a href="https://twitter.com/<?php echo $csv2post_twitter;?>" class="twitter-follow-button" data-show-count="false">Follow @twitterapi</a>
    <script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>    
    <form style="border:1px solid #ccc;padding:5px;" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $csv2post_feedburner;?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true"><p>Subscribe For New Version Updates:</p><p><input type="text" style="width:280px" name="email"/></p><input type="hidden" value="<?php echo $csv2post_feedburner;?>" name="uri"/><input type="hidden" name="loc" value="en_US"/><input type="submit" value="Subscribe" /></form>
</p>


<p style="margin-top:10px; margin-bottom:0; padding-bottom:0; text-align:left; line-height:0"><a target="_blank" href="http://feeds.feedburner.com/~r/Csv2PostWordpressCsvImporterHowToArticles/~6/1"><img src="http://feeds.feedburner.com/Csv2PostWordpressCsvImporterHowToArticles.1.gif" alt="Latest Tutorials" style="border:0"></a></p><p style="margin-top:5px; padding-top:0; font-size:x-small; text-align:center"></p>