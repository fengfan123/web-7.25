window.onload=function() {
    var map = new AMap.Map('map',{
        center:[121.4501395474,31.2934824475],
        zoom:16.5
    });
    //添加控件
    map.plugin(['AMap.ToolBar'],function(){
        var TooBar=new AMap.ToolBar();
        map.addControl(TooBar);
    });
    addMarker();
    //添加marker标记
    function addMarker() {
        map.clearMap();
        var marker = new AMap.Marker({
            map: map,
            position: [121.4467337319,31.2945114479],
        });
      /*  //鼠标点击marker弹出自定义的信息窗体
        AMap.event.addListener(marker, 'click', function() {
            infoWindow.open(map, marker.getPosition());
        });
        //实例化信息窗体
        content = [];
        content.push("<p class='info_title'>上海劲易电子科技有限公司<a href='introduce.html' class='info_more' >详情</a></p>");
        content.push("<p class='info_addr'>地址：上海市共和新路3088弄3号楼702</p>")
        content.push("<p class='info_tel'>电话：021-31002713</p>");
        var infoWindow = new AMap.InfoWindow({
            isCustom: false,  //不使用自定义窗体
            content: content.join(""),
            offset: new AMap.Pixel(16, -45)
        });
        infoWindow.open(map,[121.4467337319,31.2945114475]);*/
        //绘制折线
        var arr=[[],[]];
        arr[0].push(121.4467337319);
        arr[0].push(31.2945114475);
        arr[1].push(121.4501395474);
        arr[1].push(31.2925483612);
        var polyline=new AMap.Polyline({
            path:arr,
            strokeStyle: "solid",
            strokeColor:"#CE6030",
            strokeWeight:5
        });
        polyline.setMap(map);
        marker.setContent("<img src='img/green.png' alt=''>" +
            "<p style=' text-align:center; color:#CE6030;width:400px;background:#fff; " +
            "margin-top:100px;border:1px solid #ccc; height:30px;line-height:30px;'>" +
            "地铁一号线汶水路<--->上海劲易电子科技有限公司：345.95米</p>");
    }

    if(sessionStorage.getItem("data")!==null) {
        var index_json = sessionStorage.getItem("data");
        var arr = JSON.parse(index_json);
        $(".top_right").append("<a href='javascript:;'>" + arr['username'] + " 欢迎您" + "</a>");
        $(".top_right").append("<i></i>");
        $(".top_right").append("<a href='#' id='out'>退出</a>");
    }
    /*登录以后，跳转不同页面*/
    function user_href(){
        if(sessionStorage.getItem("data")==null){
            location.href="onlineExperience.html";
        }else{
            location.href="login_onlineExperience.html";
        }
    }
    $(".nav_box>ul>li:nth-child(4)>a").click(function(e){
        e.preventDefault();
        user_href()();
    });

    $(".exper").click(function(e){
        e.preventDefault();
        user_href();
    });
    $("#out").click(function(e){
        e.preventDefault();
        sessionStorage.removeItem("data");
        location.href="loginAndRegister.html";
    });
}
