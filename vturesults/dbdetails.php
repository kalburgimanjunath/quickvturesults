<?php
/* Get conneted to database */
$con = mysql_connect("localhost","root","") or die("Error connecting database".mysql_error());
mysql_select_db("quickvturesults_com_vtustudents");

/**
 * function to check the validity of the given string
 * $what = what you are checking (phone, email, etc)
 * $data = the string you want to check
 */

 
function isValid( $what, $data ) {
 
    switch( $what ) {
 
        // validate a mobilenumber      
        case 'mobile':
            $pattern = "/^[7-9]{1}[0-9]{9}$/i";
        break;
         
        // validate email address
        case 'email':
            $pattern = "/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$/i";
        break;
             
        // validate BE USN
        case 'usn':
            $pattern = "/^[1-6]{1}[A-Z]{2}\d{2}[A-Z]{2}\d{3}$/i";
        break;

        // validate MCA USN
        case 'usnmca':
            $pattern = "/^[1-6]{1}[A-Z]{2}\d{2}[A-Z]{3}\d{2}$/i";
        break;

        default:
            return false;
        break;
     
    }
     
    return preg_match($pattern, $data) ? true : false;
}

?>