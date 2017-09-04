$(function(){
    /*轮播广告*/
    var banner=document.getElementById("banner");
    var list=document.getElementById("list");
    var buttons=document.getElementById("buttons").getElementsByTagName("span");
    var prev=document.getElementById("prev");
    var next=document.getElementById("next");
    var index=1;
    var len = 3;
    var animated=false;
    var interval=3000;
    var timer;
    function showButton(){
        for(var i=0;i<buttons.length;i++){
            if(buttons[i].className=="on"){
                buttons[i].className="";
                break;
            }
        }
        buttons[index-1].className="on";
    }
    function animate(offset){
        if (offset == 0) {
            return;
        }
        animated=true;
        var newleft=parseInt(list.style.left)+offset;
        var time=500;//位移总时间
        var interval=10;//位移间隔时间
        var speed=offset/(time/interval);//每次位移位移量
        var go=function(){
            if((speed<0&&parseInt(list.style.left)>newleft)
                ||(speed>0&&parseInt(list.style.left)<newleft)){
                list.style.left=parseInt(list.style.left)+speed+'px';
                setTimeout(go,interval);
            }else{
                animated=false;
                list.style.left=newleft+"px";
                if(newleft>-1100){
                    list.style.left=-3300+"px"
                }
                if(newleft<-3300){
                    list.style.left=-1100+"px"
                }
            }
        }
        go();
    }
    function play(){
        timer=setInterval(function(){
            next.onclick();
        },interval)
    }
    function stop(){
        clearInterval(timer);
    }
    next.onclick=function(){
        if(index==3){
            index=1;
        }else{
            index+=1;
        }
        showButton();
        if(!animated){
            animate(-1100);
        }
    }
    prev.onclick=function(){
        if(index==1){
            index=3;
        }else{
            index-=1;
        }
        showButton();
        if(!animated){
            animate(1100);
        }
    }
    for(var i=0;i<buttons.length;i++){
        buttons[i].onclick=function(){
            if(this.className=="on"){
                return;
            }
            var myIndex=parseInt(this.getAttribute("date-index"));
            var offset=-1100*(myIndex-index);
            if(!animated){
                animate(offset);
            }
            index=myIndex;
            showButton();
        }
    }
    banner.onmouseover = stop;
    banner.onmouseout = play;
    play();
    /*首页-公司新闻-页面切换*/
    function ES(){
        $("#content>.content_left>p>span").mouseover(function(){
            $(this).addClass("default").siblings().removeClass("default")
            var a=$(this).attr("date-list");
            $(a).css("display","block").siblings().css("display","none");
        })
    }
    ES();

    if(sessionStorage.getItem("data")==null){
        $(".top_right").append("<a href='loginAndRegister.html' data-list='#login'>登录</a>");
        $(".top_right").append("<i></i>");
        $(".top_right").append("<a href='loginAndRegister.html' data-list='#register'>注册</a>");
    }else{
        var index_json=sessionStorage.getItem("data");
        var arr=JSON.parse(index_json);
        $(".top_right").append("<a href='javascript:;'>"+arr['username']+" 欢迎您"+"</a>");
        $(".top_right").append("<i></i>");
        $(".top_right").append("<a href='#' id='out'>退出</a>");
    }
    /*登录以后，跳转不同页面*/
    function index_href(){
        if(sessionStorage.getItem("data")==null){
            location.href="onlineExperience.html";
        }else{
            location.href="login_onlineExperience.html";
        }
    }
    $(".nav_box>ul>li:nth-child(4)>a").click(function(e){
        e.preventDefault();
        index_href()();
    });

    $(".exper").click(function(e){
        e.preventDefault();
        index_href();
    });

    $("#out").click(function(e){
        e.preventDefault();
        sessionStorage.removeItem("data");
        location.href="loginAndRegister.html";
    });

    /*公司新闻页面跳转*/
    function News(nws){
        sessionStorage.setItem("data-list",nws);
    }
    $(".content_Box a").click(function(){
        var news=$(this).attr("data-list");
        News(news);
    });
    /*最新动态*/
    $(".content_max a").click(function(){
        var dy=$(this).attr("data-list");
        News(dy);
    });

    /*登录和注册*/
    $(".top_right a").click(function(){
        var login_register=$(this).attr("data-list");
        News(login_register);
    });

    /*回到顶部*/
    $(".toolbar-text").click(function(){
        $('body,html').animate({scrollTop:0},500);
        return false;
    });
});

