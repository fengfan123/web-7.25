<?php
//初始化7个全局变量
error_reporting(E_ALL^E_NOTICE);
$id="";$gt="";$at="";$sta="";$d="";$spd="";$tim="";
$serv = new Swoole_Server("192.168.1.4",8502);
$serv->addlistener("192.168.1.4", 8501, SWOOLE_SOCK_TCP);
$serv->addlistener("192.168.1.4", 8500, SWOOLE_SOCK_TCP);
$serv->on('connect', function ($serv, $fd){
    echo "Client:Connect.\n";
});
function getBytes_16($str) {
        $len = strlen($str);
        $bytes = array();
           for($i=0;$i<$len;$i++) {
               if(ord($str[$i]) >= 128){
                   $byte = ord($str[$i]) - 256;
               }else{
                   $byte = ord($str[$i]);
               }
            $bytes[] = $byte;
        }
        return $bytes;
}
function GetUint32($ndata1)
{
    $Ret = (int)($ndata1 & 0x7f);
    if(($ndata1 & 0x80) != 0){
        $Ret = $Ret + 128;
    }
    return $Ret;
}
function  ParseLat($ndata1,$ndata2,$ndata3,$ndata4){
            $uint_data1= GetUint32( $ndata1);
            $uint_data2= GetUint32( $ndata2);
            $uint_data3= GetUint32( $ndata3);
            $uint_data4= GetUint32 ( $ndata4);
            $Lat=(($ndata1 & 0x7f) <<24)+($uint_data2<<16)+($uint_data3<<8)+$uint_data4;
            $dLat=(float)(($Lat % 100000) /  60000.0 )+(int)($Lat/100000);
            if ($dLat < 0 || $dLat > 180.0)
                $dLat = 0;
            if (($ndata1 & 0x80) != 0)
                $dLat = 0 - $dLat;      
            return $dLat;
}
function ParseLon($ndata1,$ndata2,$ndata3,$ndata4){
            $uint_data1= GetUint32( $ndata1);
            $uint_data2= GetUint32( $ndata2);
            $uint_data3= GetUint32( $ndata3);
            $uint_data4= GetUint32 ( $ndata4);
            $Lng=(($ndata1 & 0x7f) <<24)+($uint_data2<<16)+($uint_data3<<8)+$uint_data4;
            $dLng=(float)(($Lng % 100000)/60000)+(int)($Lng/100000);
            if ($dLng<0||$dLng>180.0)
                   $dLng=0;
            if (($ndata1 & 0x80)!=0)
                   $dLng=0-$dLng;
            return $dLng;
}
$serv->on('receive', function ($serv, $fd, $from_id, $data) {
        $serv->send($fd,'tcp-server:'.$data);
        $info = $serv->connection_info($fd, $from_id);
        if($info['server_port']==8501){
                   $getBytes_arr=getBytes_16($data);
                   $magicNumber=$getBytes_arr[0];
                   $Version=($getBytes_arr[1] & 0xf0) >> 4;
                   $Direction=($getBytes_arr[1] & 0xf0);
                   $ID=(GetUint32($getBytes_arr[2])<<24) + (GetUint32($getBytes_arr[3])<< 16)+(GetUint32($getBytes_arr[4])<<8)+(GetUint32($getBytes_arr[5]));
                   $sequence=$getBytes_arr[6].$getBytes_arr[7];
                   $length=$getBytes_arr[8];
                   $Message_id=$getBytes_arr[9];
                   switch($Message_id){
                           case 0x01:
                           $Band_broken=($getBytes_arr[10] & 0x80)>>7;
                           $Wrist_low_power=($getBytes_arr[10] & 0x40)>>6;
                           $Wrist_exception=($getBytes_arr[10] & 0x20)>>5;
                           $reserved=$getBytes_arr[10];
                           $host_low_power=($getBytes_arr[11] & 0x80)>>7;
                           $wrist_off_line=($getBytes_arr[11] & 0x40)>>6;
                           $gps=($getBytes_arr[11] & 0x04)>>2;
                           $lbs=($getBytes_arr[11] & 0x02)>>1;
                           if($gps==1&&$wrist_off_line==0&&$lbs==0){
                                  $lon=ParseLon($getBytes_arr[12],$getBytes_arr[13],$getBytes_arr[14],$getBytes_arr[15]);
                                  $late=ParseLat($getBytes_arr[16],$getBytes_arr[17],$getBytes_arr[18],$getBytes_arr[19]);
                                  $time=date("Y-m-d H:i:s");
                           }
                           break;
                   }
                   $deviceid=$ID;
                   $lgt=$lon;
                   $lat=$late;
                   $state=2;
                   $dir="12313";
                   $speed="23";
                   $time=$time;
                   if($lgt==null|| $lat==null){
                        return;
                   }else{
                       connectMysql($deviceid,$lgt,$lat,$state,$dir,$speed,$time);
                   }
        }
        if($info['server_port']==8500){
             $strbyarr=explode(",",$data);
			 var_dump($strbyarr[0]);
             switch($strbyarr[0]){
                case "*DG":
                    $deviceid=$strbyarr[1];
                    if($strbyarr[2]=="V"){
                        $yesorno=$strbyarr[3];
                    }
                    if($strbyarr[4]=="A"){
                       if(floatval($strbyarr[5])<90&&floatval($strbyarr[5])>-90){
                          $lat=$strbyarr[5];
                       }else{
                           echo "维度不合法";
                           return;
                       }
                       if(floatval($strbyarr[7])<180&&floatval($strbyarr[7])>-180){
                            $lgt=$strbyarr[7];
                       }else{
                            echo "经度不合法";
                            return;
                       }
                    }else{
                        return false;
                    }
                    $state=$strbyarr[12];
                    $dir=$strbyarr[10];
                    $speed=$strbyarr[9];
                    $time=$strbyarr[11];
                    connectMysql($deviceid,$lgt,$lat,$state,$dir,$speed,$time);
                    break;
                case '$JY'://这里必须用单引号，如果""，里面的东西会被解析成变量
                	echo "1";
                	$deviceid=$strbyarr[2];
                    if(floatval($strbyarr[3])<90&&floatval($strbyarr[3])>-90){
                          $lat=$strbyarr[3];
                    }else{
                           echo "维度不合法";
                           return;
                    }
                    if(floatval($strbyarr[4])<180&&floatval($strbyarr[4])>-180){
                            $lgt=$strbyarr[4];
                    }else{
                            echo "经度不合法";
                            return;
                    }
		    $state=$strbyarr[12];
                    $dir=$strbyarr[10];
                    $speed=$strbyarr[9];
                    $time=$strbyarr[11];
                    connectMysql($deviceid,$lgt,$lat,$state,$dir,$speed,$time);
                    break;
                default:
                    echo "格式不正确";
             }
        }
});
$serv->on('close', function ($serv, $fd) {
    echo "Client: Close.\n";
});
$serv->start();
function connectMysql($deviceid,$lgt,$lat,$state,$dir,$speed,$time){
    $db = new Swoole_MySQL;
    $server = array(
        'host' => '127.0.0.1',
        'user' => 'root',
        'password' => 'root',
        'database' => 'estar'
    );
    global $id,$gt,$at,$sta,$d,$spd,$tim;
    $id=$deviceid;
    $gt=$lgt;
    $at=$lat;
    $sta=$state;
    $d=$dir;
    $spd=$speed;
    $tim=$time;
    $db->connect($server,function($db,$result){
        global $id,$gt,$at,$sta,$d,$spd,$tim;
        $sql="insert deviceInformation_table values('$id','$gt','$at','$sta','$d','$spd','$tim')";
        $db->query($sql, function ($db, $result){
            if($result==false){
                echo "数据传输失败";
            }else{
                echo "数据传输成功";
            }
            $db->close();
        });
    });
}
?>