<?php
class indexModel{
    public function responseMsg($postObj,$arr){
     //回复多图文(单图文)的微信消息
    	    $toUser=$postObj->FromUserName;
            $fromUser=$postObj->ToUserName;
            $template=" <xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <ArticleCount>".count($arr)."</ArticleCount>
                        <Articles>";
            foreach($arr as $k=>$v){
                $template.=" <item>
                            <Title><![CDATA[".$v['title']."]]></Title> 
                            <Description><![CDATA[".$v['description']."]]></Description>
                            <PicUrl><![CDATA[".$v['picUrl']."]]></PicUrl>
                            <Url><![CDATA[".$v['url']."]]></Url>
                            </item>";
           	 }
            $template.=" </Articles>
                          </xml> ";
           echo sprintf($template, $toUser, $fromUser,time(),'news');
    }
    //回复文本消息
    public function responseText($postObj,$content){
    			$toUser=$postObj->FromUserName;
                $fromUser=$postObj->ToUserName;	
                $time=time();
           	 	$msgType='text';
				$template="<xml>
                  		 <ToUserName><![CDATA[%s]]></ToUserName>
                  		 <FromUserName><![CDATA[%s]]></FromUserName>
                   		 <CreateTime>%s</CreateTime>
                   		 <MsgType><![CDATA[%s]]></MsgType>
                   		 <Content><![CDATA[%s]]></Content>
                  		 </xml>";
              echo sprintf($template,$toUser,$fromUser,$time,$msgType,$content);
    }  
    
    //回复图片消息
    public function transmitImage($postObj,$imageArray){
        		$itemTpl="<Image><MediaId><![CDATA[%s]></MediaId></Image>";
        		$item_str=sprintf($itemTpl,$imageArray['MediaId']);
    			$toUser=$postObj->FromUserName;
                $fromUser=$postObj->ToUserName;	
				$template="<xml>
                  		 <ToUserName><![CDATA[%s]]></ToUserName>
                  		 <FromUserName><![CDATA[%s]]></FromUserName>
                   		 <CreateTime>%s</CreateTime>
                   		 <MsgType><![CDATA[image]]></MsgType>
                   		 $item_str
                  		 </xml>";
              echo sprintf($template,$toUser,$fromUser,time());
            } 
        
    
    //回复语音消息
    public function transmitVoice($postObj,$voiceArray){
        		$itemTpl="<Voice><MediaId><![CDATA[%s]></MediaId></Voice>";
        		$item_str=sprintf($itemTpl,$voiceArray['MediaId']);
    			$toUser=$postObj->FromUserName;
                $fromUser=$postObj->ToUserName;	
				$template="<xml>
                  		 <ToUserName><![CDATA[%s]]></ToUserName>
                  		 <FromUserName><![CDATA[%s]]></FromUserName>
                   		 <CreateTime>%s</CreateTime>
                   		 <MsgType><![CDATA[voice]]></MsgType>
                   		 $item_str
                  		 </xml>";
              echo sprintf($template,$toUser,$fromUser,time());
    }  
    
   //回复音乐消息
    public function transmitMusic($postObj,$musicArray){
        		$itemTpl="<Music>
                    <Title><![CDATA[%s]]></Title>
                    <Description><![CDATA[%s]]></Description>
                    <MusicUrl><![CDATA[%s]]></MusicUrl>
                    <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
                    </Music>";
        		$item_str=sprintf($itemTpl,$musicArray['Title'],$musicArray['Description'],$musicArray['MusicUrl'],$musicArray['HQMusicUrl']);
    			$toUser=$postObj->FromUserName;
                $fromUser=$postObj->ToUserName;	
				$template="<xml>
                  		 <ToUserName><![CDATA[%s]]></ToUserName>
                  		 <FromUserName><![CDATA[%s]]></FromUserName>
                   		 <CreateTime>%s</CreateTime>
                   		 <MsgType><![CDATA[music]]></MsgType>
                   		 $item_str
                  		 </xml>";
              echo sprintf($template,$toUser,$fromUser,time());
    }  
    
}
?>