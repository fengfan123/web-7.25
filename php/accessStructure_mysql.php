<?php
   class CUser{
      public $userid;
      public $username;
      public $email;
      public $pwd;
      public $arrGroup=array();
    }
    Class CGroup{
        public $groupid;
        public $groupname;
        public $userid;
        public $grouparr_dev=array();
    }
    class cDevice{
        public $deviceid;
        public $devicename;
        public $groupid;
    }
    function returnData($conn){
         $user=new CUser();
         $user->userid=$conn[0];
         $user->username=$conn[1];
         $user->email=$conn[2];
         $user->pwd=$conn[3];
         $group=mysql_query("select *  from group_table where userid=$user->userid");
         while($grouprow=mysql_fetch_row($group)){
             $tpmGroup =new CGroup();
             for($i=0;$i<count($grouprow);$i+=3){
                   $tpmGroup->groupid = $grouprow[$i];
                   $tpmGroup->groupname=$grouprow[$i+1];
                   $tpmGroup->userid= $grouprow[$i+2];
             }
             $device=mysql_query("select  * from device_table where device_table.groupid=$tpmGroup->groupid");
             while($devicerow=mysql_fetch_row($device)){
                  $tpmDevice =new CDevice();
                  for($i=0;$i<count($devicerow);$i+=3){
                       $tpmDevice->deviceid=$devicerow[$i];
                       $tpmDevice->devicename=$devicerow[$i+1];
                       $tpmDevice->groupid=$devicerow[$i+2];
                  }
                  array_push($tpmGroup->grouparr_dev,$tpmDevice);
             }
             array_push($user->arrGroup ,$tpmGroup);
         }
         $jsonUser=json_encode($user);
         echo  $jsonUser;
    }
?>