$(function(){
    if(sessionStorage.getItem("data")!==null) {
        var index_json = sessionStorage.getItem("data");
        var arr = JSON.parse(index_json);
        $(".top_right").append("<a href='javascript:;'>" + arr['username'] + " 欢迎您" + "</a>");
        $(".top_right").append("<i></i>");
        $(".top_right").append("<a href='#' id='out'>退出</a>");
    }
    /*登录以后，跳转不同页面*/
    function online_href(){
        if(sessionStorage.getItem("data")==null){
            location.href="onlineExperience.html";
        }else{
            location.href="login_onlineExperience.html";
        }
    }
    $(".nav_box>ul>li:nth-child(4)>a").click(function(e){
        e.preventDefault();
        online_href();
    });
    $(".exper").click(function(e){
        e.preventDefault();
        online_href();
    });

    $("#out").click(function(e){
        e.preventDefault();
        sessionStorage.removeItem("data");
        location.href="loginAndRegister.html";
    });
});
