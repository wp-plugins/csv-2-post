<?php
$username = $_POST['username']; // get the username
$username = trim(htmlentities($username)); // strip some crap out of it

echo check_usernametest($file,$username); // call the check_username function and echo the results.

function check_usernametest($file_in,$username){

    return '<span style="color:#f00">Username Unavailable</span>';
    
    
    return '<span style="color:#0c0">Username Available</span>';
}
?>
