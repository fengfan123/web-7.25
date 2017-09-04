<?php
$url=realpath("FireCtrlStationUDP.apk");
function downfile($fileurl)
{
$filename=$fileurl;
$file  =  fopen($filename, "rb"); 
Header( "Content-type:  application/octet-stream "); 
Header( "Accept-Ranges:  bytes "); 
Header( "Content-Disposition:  attachment;  filename= FireCtrlStationUDP.apk"); 
$contents = "";
while (!feof($file)) {
 $contents .= fread($file, 8192);
}
echo $contents;
fclose($file); 
}
downfile($url);


?>