<?php
require("find_mysql.php");
require("accessStructure_mysql.php");
$devicename=$_REQUEST['devicename'];
$userid=$_REQUEST['userid'];
$mysql=mysql_query("DELETE from device_table where devicename='$devicename'");
$del_deviceinfo=mysql_query("DELETE from deviceInformation_table where deviceid='$devicename'");
if($mysql&&$del_deviceinfo){
        $sel=mysql_query("SELECT * FROM user_table where userid=$userid");
        $selmysql=mysql_fetch_row($sel);
        mysqllookup($selmysql);
}else{
       echo "0";
}
?>