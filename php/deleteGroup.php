<?php
require("find_mysql.php");
require("accessStructure_mysql.php");
$groupid=$_REQUEST['groupid'];
$userid=$_REQUEST['userid'];
$sel=mysql_query("select * from device_table where groupid='$groupid'");
$conn=mysql_fetch_array($sel);
$devicename=$conn['devicename'];
if($conn){
  $mysql=mysql_query("delete a,b from group_table a,device_table b where a.groupid = b.groupid and a.groupid='$groupid'");
  $del_deviceinfo=mysql_query("DELETE from deviceInformation_table where deviceid='$devicename'");
}else{
  $mysql=mysql_query("delete from group_table where groupid='$groupid'");
}
if($mysql){
      $sel=mysql_query("SELECT * FROM user_table where userid=$userid");
      $selmysql=mysql_fetch_row($sel);
      mysqllookup($selmysql);
}else{
      echo "0";
}
?>