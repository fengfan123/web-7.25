<?php
    require("find_mysql.php");
    require("accessStructure_mysql.php");
    $user=$_REQUEST['user'];
    $pwd=$_REQUEST['pwd'];
    $query=mysql_query("SELECT * from user_table WHERE username='$user' and pwd='$pwd'");
    $conn=mysql_fetch_row($query);
    if($conn){
             mysqllookup($conn);
    }else{
             echo "0";
    }
?>