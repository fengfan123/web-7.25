<?php
 require("find_mysql.php");
 require("accessStructure_mysql.php");
 $device=$_REQUEST['devicename'];
 $groupid=$_REQUEST['groupid'];
 $userid=$_REQUEST['userid'];
 $sel_device=mysql_query("SELECT * FROM deviceInformation_table where deviceid='$device'");
 $sel_device_arr=mysql_fetch_row($sel_device);
 if($sel_device_arr){
     $conn=mysql_query("INSERT device_table values(null,'$device',$groupid)");
     if($conn){
         $sel=mysql_query("SELECT * FROM user_table where userid=$userid");
         $selmysql=mysql_fetch_row($sel);
         mysqllookup($selmysql);
     }else{
         echo "0";
     }
 }else{
    echo "2";
 }
?>