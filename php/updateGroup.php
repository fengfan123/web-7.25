<?php
require("find_mysql.php");
require("accessStructure_mysql.php");
$inputval=$_REQUEST['inputval'];
$updateid=$_REQUEST['updateuserid'];
$userid=$_REQUEST['userid'];
$mysql=mysql_query("UPDATE group_table SET groupname='$inputval' where groupid='$updateid'");
if($mysql){
    $sel=mysql_query("SELECT * FROM user_table where userid=$userid");
    $selmysql=mysql_fetch_row($sel);
    mysqllookup($selmysql);
}else{
    echo "0";
}
?>