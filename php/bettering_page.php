<?php
header('Content-Type: text/html; charset=utf-8'); //网页编码
$con = mysql_connect('127.0.0.1', 'root', 'root');
mysql_select_db('estar',$con);
$devicename=$_REQUEST['devicename'];
$information=[];
for($i=0;$i<count($devicename);$i++){
    $array=[];
    $conn=mysql_query("select * from deviceInformation_table where deviceid='$devicename[$i]'");
    while($result=mysql_fetch_row($conn)){
           if($result){
               array_push($array,$result);
           }else{
               echo "0";
           }
       }
       array_push($information,$array[count($array)-1]);
   }
   echo json_encode($information);










