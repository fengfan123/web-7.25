<?php
  require("find_mysql.php");
  require("accessStructure_mysql.php");
  $inputval=$_REQUEST['inputval'];
  $userid=$_REQUEST['userid'];
  $conn=mysql_query("INSERT group_table values(null,'$inputval',$userid)");
  if($conn){
      $sel=mysql_query("SELECT * FROM user_table where userid=$userid");
      $selmysql=mysql_fetch_row($sel);
      mysqllookup($selmysql);
  }else{
       echo 0;
  }
?>