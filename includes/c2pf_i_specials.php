<?php
##########################################################################
##     INTERFACE FOR SPECIAL DATA FUCNTIONS STAGE ON PROJECT CONFIG     ##
##########################################################################
?>

<br />
<form method="post" name="c2pf_specialfunctions_form" action="">            
     <table>
      <tr>
            <td><b>Functions</b></td>
            <td><b>CSV Columns</b></td>
        </tr>				
        <tr>
            <td>Thumbnails</td>
            <td><?php c2pf_csvcolumnmenu_specialfunctions( $pro['current'], 'thumbnail' );?></td>
        </tr>				
        <tr>
            <td>URL Cloaking</td>
            <td><?php c2pf_csvcolumnmenu_specialfunctions( $pro['current'], 'cloaking1' );?></td>
        </tr>
        <tr>
            <td>Permalink/Slug/Post Name</td>
            <td><?php c2pf_csvcolumnmenu_specialfunctions( $pro['current'], 'permalink' );?></td>
        </tr>
        <tr>
            <td>Pre-Made Dates</td>
            <td><?php c2pf_csvcolumnmenu_specialfunctions( $pro['current'], 'dates' );?></td>
        </tr>     
        <tr>
            <td>Pre-Made Tags</td>
            <td><?php c2pf_csvcolumnmenu_specialfunctions( $pro['current'], 'madetags' );?></td>
        </tr>	              
        <tr>
            <td>Tag Generator</td>
            <td><?php c2pf_csvcolumnmenu_specialfunctions( $pro['current'], 'tags' );?></td>
        </tr>                       
        <tr>
            <td>Excerpt Generator</td>
            <td><?php c2pf_csvcolumnmenu_specialfunctions( $pro['current'], 'excerpt' );?></td>
        </tr>   				
        <tr>
            <td>Category Splitter ( / )</td>
            <td><?php c2pf_csvcolumnmenu_specialfunctions( $pro['current'], 'catsplitter' );?></td>
        </tr>            
    </table>
    <input class="button-primary" type="submit" name="c2pf_specialfunctions_submit" value="Save" />
</form>
<br />
