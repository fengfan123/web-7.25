<?php
      require("find_mysql.php");
      $user=$_REQUEST['user'];
      $query=mysql_query("SELECT * from user_table WHERE username='$user'");
      $conn=mysql_fetch_row($query);
      if($conn){
         echo "用户名已经存在";
      }else{
         echo "用户名可用";
      }
  ?>