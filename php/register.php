<?php
    require("find_mysql.php");
    $user=$_REQUEST['user'];
    $pwd=$_REQUEST['pwd'];
    $email=$_REQUEST['email'];
    $con=mysql_query("INSERT user_table values(null,'$user','$email',$pwd)");
    if($con){
        echo "1";
    }else{
        echo "0";
    }
?>