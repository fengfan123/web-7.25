$(function(){
    if(sessionStorage.getItem("data")!==null) {
        var index_json = sessionStorage.getItem("data");
        var arr = JSON.parse(index_json);
        $(".top_right").append("<a href='javascript:;'>" + arr['username'] + " 欢迎您" + "</a>");
        $(".top_right").append("<i></i>");
        $(".top_right").append("<a href='#' id='out'>退出</a>");
    }
    /*登录以后，跳转不同页面*/
    function product_href(){
        if(sessionStorage.getItem("data")==null){
            location.href="onlineExperience.html";
        }else{
            location.href="login_onlineExperience.html";
        }
    }
    $(".nav_box>ul>li:nth-child(4)>a").click(function(e){
        e.preventDefault();
        product_href();
    });
    $(".exper").click(function(e){
        e.preventDefault();
        product_href();
    });
    $("#out").click(function(e){
        e.preventDefault();
        sessionStorage.removeItem("data");
        location.href="loginAndRegister.html";
    });

    /*登录与注册页面切换*/
    $(".loginOrRegister_box>ul>li>a").click(function(e){
        e.preventDefault();
        $(this).addClass("login_h").parent().siblings("li").children("a").removeAttr("class");
        var login_a=$(this).attr("href");
        Take(login_a);
    });
    /*页面刷新，获取高度*/
    var login_h=$(".login").outerHeight();
    $(".login_register_box").css("height",login_h);
    var firstH=$(".companyProfile_introduction").outerHeight();
    $(".companyProfile_aside_r").css("height",firstH);
    /*新闻详情页*/
    $(".companyProfile_aside_l>ul>li").click(function(e){
        e.preventDefault();
        var companyProfile=$(this).children("a").attr("href");
        Take(companyProfile);
    });
    /**********取sessionstorage的值********************/
    function Take(take){
        var h=$(take).outerHeight();
        /*$("[href="+take+"]")*/
        $(take).css("display","block").siblings().css("display","none");
        $(take).parent().css("height",h);
    }
    /*pagejump页面跳转*/
    function pageJump(cur){
        cur.attr("class","color").siblings(".color").removeClass("color");
        var res= cur.attr("href");
        Take(res);
    }
    /*****新闻分页******/
    $(".news_show a").click(function(e){
        e.preventDefault();
        pageJump($(this));
    });
    /**********最新动态**************/
    $(".trends_show a").click(function(e){
        e.preventDefault();
        pageJump($(this));
    });
    /**点击product保存的sessionstorage*/
    function Products(nws){
        sessionStorage.setItem("data-list",nws);
    }
    $(".product_one a").click(function(){
        var product=$(this).attr("data-list");
        Products(product);
    });

    /*****新闻分页,最新动态,产品详情页****/
    var SessionStorage=sessionStorage.getItem("data-list");
    if(SessionStorage!==null||SessionStorage!==""){
        Take(SessionStorage);
        sessionStorage.removeItem('data-list');
    }
    /*产品详情页当前页面的点击*/
    $(".product_show a").click(function(e){
        e.preventDefault();
        $(this).attr("class","color").siblings(".color").removeClass("color");
        var res= $(this).attr("href");
        Take(res);
    });
    
    
   

});
