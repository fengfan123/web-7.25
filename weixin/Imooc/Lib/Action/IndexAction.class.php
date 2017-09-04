<?php
header("content-type:text/html;charset=utf-8");
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    //index()函数，验证微信服务器的配置是否开启成功(验证token)
    public function index(){
        //1.将timestamp,nonce,token,按字典排序
        $timetamp=$_GET['timestamp'];
        $nonce=$_GET['nonce'];
        $token='estar';
        $signature=$_GET['signature'];
        $echostr = $_GET['echostr'];
        $array=array($timetamp,$nonce,$token);
        sort($array);
        //将排序后的三个'参数拼接之后用sha1加密
        $tmpstr=implode('',$array);//join
        $tmpstr=sha1($tmpstr);
        //将加密后的字符串与signature进行对比，判断该请求是否来自微信
		 if($signature==$tmpstr && $echostr){ 
        //第一次微信接入的时候
   			 echo $echostr;
        	 exit;
         }else{
    	 	 $this->responseMsg();
   		 }
    }//index结尾（入口文件）   
	
	public function responseMsg(){
    	//1.获取到微信推送过来的post数据(xml格式)
		$postArr=$GLOBALS['HTTP_RAW_POST_DATA'];
        //2.处理消息类型，将xml消息转化为对象
        $postObj=simplexml_load_string($postArr); 
        //3.判断该数据包是否是订阅的事件推送
	    if(strtolower($postObj->MsgType)=='event'){
		//4.如果是关注subscribe事件
		     if(strtolower($postObj->Event=='subscribe')){
				 $indexModel=new indexModel();
				 $content="劲易科技，欢迎您";
                 $indexModel->responseText($postObj,$content);
			}
			   if(strtolower($postObj->Event=='CLICK')){
                     switch($postObj->EventKey){
                         case "kefu":
                             $content="上海市共和新路3088弄3号楼7楼\n电话：021-54433856";
                             $indexModel=new indexModel();
                   			 $indexModel->responseText($postObj,$content); 
                             break;
                         case "video":
                              $content=array(
                                array(
                                'title'=>'视频产品',
                                'description'=>'',
                                'picUrl'=>'http://www.genetek.cc/weixin/image/huoche.jpg',
                                'url'=>''
                                ),
                                 array(
                                'title'=>"【视频产品】\n高清蛇眼视频检测仪",
                                'description'=>'',
                                'picUrl'=>'http://www.genetek.cc/weixin/image/image2.jpg',
                                'url'=>'http://mp.weixin.qq.com/s?__biz=MzIyMzU3MTYzNQ==&mid=100000025&idx=1&sn=3cf8fee4a3cec28dd4e0c99b53a36fe9&chksm=681d7ac55f6af3d3b61bbdbb812818654c903850756c70899df8024cde665bb84e24cee03917#rd'
                                ),
                                  array(
                                'title'=>"【视频产品】\n无线智能视频检测仪",
                                'description'=>'',
                                'picUrl'=>'http://www.genetek.cc/weixin/image/image6.jpg',
                                 'url'=>'http://mp.weixin.qq.com/s?__biz=MzIyMzU3MTYzNQ==&mid=100000019&idx=1&sn=77f00199d67f58aba187d9faae14f4b0&chksm=681d7acf5f6af3d9e3afe1a4f887809d6d847f77c96a6284a6b7c23432662fdcc7a066ed49da#rd'
                                ),
                                array(
                                'title'=>"【视频产品】\n声（风）屏障智能检查器1",
                                'description'=>'',
                                'picUrl'=>'http://www.genetek.cc/weixin/image/image10.jpg',
                                 'url'=>'http://mp.weixin.qq.com/s?__biz=MzIyMzU3MTYzNQ==&mid=100000026&idx=1&sn=ae77044e2487bef197e4f897e6126b27&chksm=681d7ac65f6af3d0da929765cb6916157364ac3987fd2684ec8fa20148a7f90f29a746c6990a#rd'
                                ),
                                 array(
                                'title'=>"【视频产品】\n声（风）屏障智能检查器2",
                                'description'=>'',
                                'picUrl'=>'http://www.genetek.cc/weixin/image/image11.jpg',
                                'url'=>'http://mp.weixin.qq.com/s?__biz=MzIyMzU3MTYzNQ==&mid=100000027&idx=1&sn=c97ccbc13914659072e349ba052c0981&chksm=681d7ac75f6af3d1ce5de2596a38b904ca854a454702ad52e988692f9269b6b69554fe319cb8#rd'
                                ),
                                array(
                               'title'=>"【视频产品】\n铁路伸缩式拍照检查器",
                                'description'=>'',
                                'picUrl'=>'http://www.genetek.cc/weixin/image/image12.png',
                               'url'=>'http://mp.weixin.qq.com/s?__biz=MzIyMzU3MTYzNQ==&mid=100000028&idx=1&sn=63d83f502200eed5436dccb26be0f7de&chksm=681d7ac05f6af3d6c33e6dfdad537e68adb749e1f10499ba56d55980ab01b9e4c58fd8f45b3f#rd'
                                ),
                               array(
                               'title'=>"【视频产品】\n现场工作记录仪",
                                'description'=>'',
                                'picUrl'=>'http://www.genetek.cc/weixin/image/image13.png',
                               'url'=>'http://mp.weixin.qq.com/s?__biz=MzIyMzU3MTYzNQ==&mid=100000029&idx=1&sn=9b73f2082b7bf164cc4c35b52a852a6b&chksm=681d7ac15f6af3d7ef12ddccbff27861c3a4cdbfc5a87c67cc483cd33ef6bf2b79ad9e689724#rd'
                                )    
                             );
                            	  break;  
                            case "interface":
                              $content=array(
                                array(
                                'title'=>'信息时代--车联网',
                                'description'=>'',
                                'picUrl'=>'http://www.genetek.cc/weixin/image/things.jpg',
                                'url'=>'http://mp.weixin.qq.com/s?__biz=MzIyMzU3MTYzNQ==&mid=100000054&idx=1&sn=e99214026763310e0c5e77b6b186b2dc&chksm=681d7aea5f6af3fc49c6bc373dd1db445df8b9c73c54d063d9983f8c85a0d399864817f90976#rd'
                                ),
                                array(
                                'title'=>"车载定位终端\n（用于挂车）",
                                'description'=>'',
                                'picUrl'=>'http://www.genetek.cc/weixin/image/end1.png',
                                'url'=>'http://mp.weixin.qq.com/s?__biz=MzIyMzU3MTYzNQ==&mid=100000049&idx=1&sn=2b4387e442ba818c3b8abb41328f1e26&chksm=681d7aed5f6af3fbdeb6533d6ef8d31c81ec09e3777be406a8933c6c223e5a1d0bfbd38e1b78#rd'
                                ),
                                array(
                                'title'=>"车载OBD终端\n（用与车头）",
                                'description'=>'',
                                'picUrl'=>'http://www.genetek.cc/weixin/image/carhead1.png',
                                 'url'=>'http://mp.weixin.qq.com/s?__biz=MzIyMzU3MTYzNQ==&mid=100000050&idx=1&sn=a3466214faa2ea993ee451a7b23a0136&chksm=681d7aee5f6af3f89b935a8a4779c96c1e6db9889e2501de3df225cbd7181f064246c0797534#rd'
                                ),  
                                array(
                                'title'=>"车载智能后视镜",
                                'description'=>'',
                                'picUrl'=>'http://www.genetek.cc/weixin/image/back1.png',
                                 'url'=>'http://mp.weixin.qq.com/s?__biz=MzIyMzU3MTYzNQ==&mid=100000051&idx=1&sn=66feb69ac63cae64e1e255202d4d5aa7&chksm=681d7aef5f6af3f9a028be128fcfdd6eb9d59a211aa225a752d015e6c5561865bc7419aeab56#rd'
                                ),
                                    array(
                                'title'=>"无线地磁车辆检测器",
                                'description'=>'',
                                'picUrl'=>'http://www.genetek.cc/weixin/image/dichi.jpg',
                                 'url'=>'http://mp.weixin.qq.com/s?__biz=MzIyMzU3MTYzNQ==&mid=100000064&idx=1&sn=1495e42acee705f056d7dc094c8631f9&chksm=681d7a9c5f6af38a81f4f6ce1e3f7155a5519ca192f5de5fa7dedb87aba2b595809b4742b643#rd'
                                ),  
                                array(
                                'title'=>"车载中控电脑",
                                'description'=>'',
                                'picUrl'=>'http://www.genetek.cc/weixin/image/ivo80.png',
                                 'url'=>'http://mp.weixin.qq.com/s?__biz=MzIyMzU3MTYzNQ==&mid=100000069&idx=1&sn=df72f6c1393d9083ce3b105fec0aa025&chksm=681d7a995f6af38f2eb9f9c640bd04a0a7a29f829e3cfbc26b19482bb4521fb98ae2d0d37193#rd'
                                )  
                             );   
                          		break; 
                           case "news":
                              $content=array(
                                array(
                                'title'=>'新闻动态',
                                'description'=>'123',
                                'picUrl'=>'http://www.genetek.cc/weixin/image/newslogo.jpg',
                                'url'=>'http://www.genetek.cc/weixin/index.html'
                                ),
                                array(
                                'title'=>"国内几大车联网系统对比",
                                'description'=>'',
                                'picUrl'=>'http://www.genetek.cc/weixin/image/new1.jpg',
                                'url'=>'http://mp.weixin.qq.com/s?__biz=MzIyMzU3MTYzNQ==&mid=100000030&idx=1&sn=08cfd4d3285861acd9590a95645a3617&chksm=681d7ac25f6af3d414297d0699bb3c5553b1b699240ae847bd320362485869b1c29e82713fe3#rd'
                                ),
                                array(
                                'title'=>"全国车联网产业创新联盟筹建",
                                'description'=>'',
                                'picUrl'=>'http://www.genetek.cc/weixin/image/new10.jpg',
                                 'url'=>'http://mp.weixin.qq.com/s?__biz=MzIyMzU3MTYzNQ==&mid=100000032&idx=1&sn=963ea1eb60178552a1d2d73616b870db&chksm=681d7afc5f6af3ea076b21ba15baa2285437bdadd3555cf89eb8a8303bab61a5b318f7c86244#rd'
                                ),  
                                array(
                                'title'=>"中国民营企业500强发布，华为超联想夺第一",
                                'description'=>'',
                                'picUrl'=>'http://www.genetek.cc/weixin/image/new3.jpg',
                                 'url'=>'http://mp.weixin.qq.com/s?__biz=MzIyMzU3MTYzNQ==&mid=100000033&idx=1&sn=fa1588e34540350475cb0ebe5770cdd2&chksm=681d7afd5f6af3ebfcc3a24fabafcb80c58d75be5a994a437d9ff5e7aef28e9c926bacec2269#rd'
                                ),
                                array(
                                'title'=>"互联造车 以车联网技术推动新能源2.0",
                                'description'=>'',
                                'picUrl'=>'http://www.genetek.cc/weixin/image/new4.jpg',
                                 'url'=>'http://mp.weixin.qq.com/s?__biz=MzIyMzU3MTYzNQ==&mid=100000037&idx=1&sn=9c1d9907c31383353bbcad780ae3a089&chksm=681d7af95f6af3ef70e45852e9424f542e6b3a2be43fec45fe2fceaefe91eb4bbf5ba397180f#rd'
                                )  
                             );   
                          		break; 
                 		}
 					 		$indexModel=new indexModel();
                            $indexModel->responseMsg($postObj,$content);        
                }
		}
	}
	function http_curl($url,$type='get',$res='json',$arr=''){
			//获取百度
			//1.初始化curl
			$ch=curl_init();
			//2.设置curl的参数
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        	if($type=='post'){
                curl_setopt($ch,CURLOPT_POST,1);
                curl_setopt($ch,CURLOPT_POSTFIELDS,$arr);
			};
			//3.采集
			$output=curl_exec($ch);
			//4.关闭
			curl_close($ch);
			if($res=='json'){
				if(curl_error($ch)){
					return curl_error($ch);
				}else{
					return json_decode($output,true);
				}
			}
     }//http_curl结尾
	
	public function getToken(){
		 if($_SESSION['access_token'] && $_SESSION['expire_time']>time()){
            //如果access_token在session中没有过期
			return $_SESSION['access_token'];
        }else{
        //如果access_token在session中已经过期，或者不存在，重新取access_token
       		$appid="wx2c3943a48c5513a3";
			$appsecret="b5456685445321d714ab5c5571f720df";
            $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
            $res=$this->http_curl($url);
            $access_token=$res['access_token'];
            //将从新获取的access_token存入S_SESSION中
            $_SESSION['access_token']=$access_token;
            //access_token的过期时间
            $_SESSION['expire_time']=time()+7200;
			return $access_token;
        }
	}
	
	public function definedItem(){ 	 
         $postArr=array(
            "button"=>array(
                array(
                    "name"=>urlencode("公司产品"),
                    "sub_button"=>array(
                         array(
                        	"name"=>urlencode("联系我们"),
                            "type"=>"click",
                    		 "key"=>"kefu"
                        ),
                        array(
                        	"name"=>urlencode("视频"),
                            "type"=>"click",
                            "key"=>"video"
                        ),
                        array(
                            "name"=>urlencode("车联网"),
                            "type"=>"click",
                            "key"=>"interface"
                        )
                    )
                ),//第一个一级菜单
                array(
                  "name"=>urlencode("公司简介"),
                  "type"=>"view",
                  "url"=>""
                ),//第二个一级菜单 
              array(
                  "name"=>urlencode("公司新闻"),
                  "type"=>"click",
                  "key"=>"news"
                )//第三个一级菜单
             )   
        );
        $postJson=urldecode(json_encode($postArr));
        $access_token=$this->getToken();
		var_dump($access_token);
        $url=" https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
		var_dump($postJson);
		$res=$this->http_curl($url,'post','json',$postJson);
        var_dump($res);
     }//definedItem结尾  
	
  } 
?>
