$(function(){
    var map = new AMap.Map('login_map',{
        resizeEnable:true,
        zoom:10
    });
    map.getCenter();
    AMap.plugin(['AMap.ToolBar', 'AMap.Scale'], function() {
        var toolBar = new AMap.ToolBar();
        var scale = new AMap.Scale();
        map.addControl(toolBar);
        map.addControl(scale);
    });
    //创建对象
    var MarkerhashTable={};
    // 添加
    function add(key,value){
        MarkerhashTable[key] = value;
    }
    //添加marker
    function addMarker(id,lng,lat,state,dir,speed,time){
        var point = new AMap.LngLat(lng,lat);
        AMap.convertFrom(point, "gps", function(constatus, result) {
            if (result.info == "ok") {	
		console.log(result);	
                var convLng = result.locations[0].getLng();
                var convLat = result.locations[0].getLat();
                var marker;
                switch (state) {
                    case "1":
                        marker = new AMap.Marker({
                            icon: "img/gray.png",
                            position: new AMap.LngLat(convLng, convLat)
                        });
                        break;
                    case "2":
                        marker = new AMap.Marker({
                            icon: "img/green.png",
                            position: new AMap.LngLat(convLng, convLat)
                        });
                        break;
                    case "3":
                        marker = new AMap.Marker({
                            icon: "img/pink.png",
                            position: new AMap.LngLat(convLng,convLat)
                        });
                        break;
		   case "0.0" :
                    marker = new AMap.Marker({
                            icon: "img/gray.png",
                            position: new AMap.LngLat(convLng, convLat)
                        });
                    break;
                }
                AMap.event.addListener(marker, 'mouseover', function () {
                    marker.setLabel({
                        offset: new AMap.Pixel(15, 15),
                        content: "设备ID：" + id
                    });
                });
                AMap.event.addListener(marker, 'mouseout', function () {
                    marker.setLabel({
                        offset: new AMap.Pixel(15, 15),
                        content: ""
                    });
                });
                var info = new AMap.InfoWindow({
                    closeWhenClickMap: false,//是否在鼠标点击地图后关闭信息窗体
                    /* offset: new AMap.Pixel(-70, 0),*/
                    content: '<p>ID： ' + id + '</p>' +
                    '<p>经度：' + lng + '</p>' +
                    '<p>纬度：' + lat + '</p>' +
                    '<p>状态：' + state + '</p>' +
                    '<p>风向：' + dir + '</p>' +
                    '<p>速度：' + speed + '</p>' +
                    '<p>时间：' + time + '</p>'
                });
                AMap.event.addListener(marker, "click", function () {
                    info.open(map, marker.getPosition());//点击mk的时候，弹出Infowindow
                });
                marker.setMap(map);
                add(id, marker);
            }
        })
    }   

    //画图标
    function DrawWatchingItems(id,lng,lat,state,dir,speed,time){
        if (id in MarkerhashTable) {
            MarkerhashTable[id].setPosition(new AMap.LngLat(lng,lat)); //更新点标记位置
            return;
        }
        addMarker(id,lng,lat,state,dir,speed,time);
    }
    //页面登陆以后，第一次从sessionStorage中取数据
    var session_json;
    var user_arr;
    var group;
    function getSessionStorage(){
        session_json=sessionStorage.getItem("data");
        user_arr=JSON.parse(session_json);
        group=user_arr['arrGroup'];//group名称
    }
    getSessionStorage();
    var userid=user_arr['userid'];//用户ID;
    $(".top_right").append("<a href='javascript:;'>"+user_arr['username']+" 欢迎您"+"</a>");
    $(".top_right").append("<i></i>");
    $(".top_right").append("<a href='#' id='out'>退出</a>");
    $("#out").click(function(e){
        e.preventDefault();
        sessionStorage.removeItem("data");
        location.href="loginAndRegister.html";
    });
    if(group.length==0){
       alert("请先添加组");
    }
    /*展开和收起*/
    function showorslide(){
        $(".login_onlineExperience_box>ul>li>a").click(function(e){
            e.preventDefault();
            var attrhref= $(this).attr("href");
            $(attrhref).css("display","block").siblings().css("display","none");
        });
    }
    showorslide();
    /*点击button的x让当前页面隐藏*/
    $(".operating button").click(function(){
        $(this).parent().css("display","none");
    });
    //页面加载完成以后刷新设备
    function addGroupAndDevice(groups){
        $(".slt").append("<option>--请选择--</option>");
        for(var i=0;i<groups.length;i++){
            var grouparr=groups[i]['grouparr_dev'];
            $(".slt").append("<option>"+groups[i]['groupname']+"</option>");
            $(".group_box").append("<h3><span>+</span>"+groups[i]['groupname']+"</h3>");
            $(".group_box").append("<div id='"+i+"' class='device'></div>");
            if(grouparr!=0||grouparr!=null){
                $(".deviceslt").empty();
                $(".deviceslt").append("<option>--请选择--</option>");
                for(var j=0;j<grouparr.length;j++){
                    $("#"+i).append("<p>"+grouparr[j]['devicename']+"</p>");
                    $(".deviceslt").append("<option>"+grouparr[j]['devicename']+"</option>");
                }
            }
        }
    };
    addGroupAndDevice(group);
    /*手风琴*/
    function  accordion(){
        $('.group_box h3').click(function(){
            if($(this).next().hasClass("on")){
                $(this).next().slideUp(500).removeClass('on');
                $(this).children('span').text('+');
            }else{
                $(this).next().slideDown(500).addClass('on');
                $(this).children('span').text('-');
            }
        });
    };
    accordion();
    //数据解析及清空函数
    function dataEmpty(data,id){
        sessionStorage.setItem("data",data);
        //这里也可以直接从session中直接取出来,这样速度比直接取数据库要快很多，
        getSessionStorage();
        $(".slt").empty();
        $(".group_box").empty();
        addGroupAndDevice(group);
        $("#"+id).css("display","none");
        accordion();
    };
    //添加组
    $("#addgroup .add").click(function(){
        var lival=$("#addgroup .input").val();
            if(lival!=""&&lival!=null){
            $.ajax({
                type:"POST",
                url:"php/addGroup.php",
                data:{
                    inputval:lival,
                    userid:userid
                },
                success:function(data){
                    if(data==0) {
                        alert("组名已经存在");
                        return;
                    }
                    dataEmpty(data,"addgroup");
                }
            });
        }else{
            alert("请填写组名称");
            return;
        }
    });
    $("#addgroup .delete").click(function(){
        $("#addgroup .input").val("");
    });
    //添加设备
    $("#adddevice .add ").click(function(){
        var devicename=$("#adddevice .input").val();
        //获取选中option的值
        var opt=$("#adddevice .slt");
        var groupid= groupNameById(opt);
        if(opt.val()=='--请选择--'){
            alert("请选择组名");
            return;
        }
        if(devicename!=""&&devicename!=null){
            $.ajax({
                url:"php/addDevice.php",
                type:"POST",
                data:{
                    userid:userid,
                    devicename:devicename,
                    groupid:groupid
                },
                success:function(data){
                    if(data==0) {
                        alert("设备已经存在");
                        return;
                    }
 		    if(data==2){
                        alert("设备不在线，无法添加");
                        return;
                    }
                    dataEmpty(data,"adddevice");
                }
            });
        }else{
            alert("请输入设备编号");
            return;
        }
    });
    $("#adddevice .delete").click(function(){
        $("#adddevice .input").val("");
    });
    //修改组
    $("#updategroup .add").click(function(){
        var opt=$("#updategroup .slt");
        var inputval=$("#updategroup .input").val();
        var updateuserid=groupNameById(opt);
        if($("#updategroup .slt").val()=="--请选择--"){
            alert("请选择修改的组");
            return;
        };
        if(inputval===""){
            alert("请填写新的组名");
            return;
        };
        $.ajax({
            url:"php/updateGroup.php",
            data:({
                inputval:inputval,
                updateuserid:updateuserid,
                userid:userid
            }),
            success:function(data){
                dataEmpty(data,"updategroup");
            }
        });
    });
    $("#updategroup .delete").click(function(){
        $("#updategroup .input").val("");
    });
    //删除组
    $("#deletegroup .add").click(function(){
        var opt=$("#deletegroup .slt");
        var groupid=groupNameById(opt);
        var groupname=$(opt).val();
        if(groupname=="--请选择--"){
            alert("请选择删除的组名");
            return;
        }
        if(group.length==0){
            return;
        }else{
            for(var i=0;i<group.length;i++){
                if(group[i]['groupname']== groupname){
                    for(var j=0;j<group[i]['grouparr_dev'].length;j++){
                        var devicename=group[i]['grouparr_dev'][j]['devicename'];
                        var marker=MarkerhashTable[devicename];
                        marker.setMap(null);
                        delete MarkerhashTable[devicename];
                    }
                }
            }
        }
        $.ajax({
            url:"php/deleteGroup.php",
            data:({
                groupid:groupid,
                userid:userid
            }),
            success:function(data){
                dataEmpty(data,"deletegroup");
            }
        });
        $(".click_left_content").css("left","-200px");
    });
    //删除设备
    $("#deletedevice .add").click(function(){
        var deviceslt=document.getElementsByClassName("deviceslt")[0];
        deviceslt.remove(deviceslt.selectedIndex+1);
        var devicename=grouparrDev();
        if($("#deletedevice .slt").val()=='--请选择--'){
            alert("请选择要删除的组名");
            return;
        }
        if($("#deletedevice .deviceslt").val()=="无"){
            alert("没有设备,无法删除");
            return;
        }
        var marker=MarkerhashTable[devicename];
        marker.setMap(null);
        delete MarkerhashTable[devicename];
        $.ajax({
            url:"php/deleteDevice.php",
            data:({
                devicename:devicename,
                userid:userid
            }),
            success:function(data){
                dataEmpty(data,"deletedevice");
            }
        });
        $(".click_left_content").css("left","-200px");
    });
    //两下拉框改变
    $("#deletedevice  .slt").change(function () {
        var slt=$("#deletedevice .slt").val();
        if(slt=="--请选择--"){
            $(".deviceslt").empty();
            $(".deviceslt").append("<option>--请选择--</option>");
        }
        for (var i = 0; i <group.length; i++) {
            if (slt == group[i]['groupname']) {
                $(".deviceslt").empty();
                if ((group[i]['grouparr_dev'].length) == 0) {
                    $(".deviceslt").append("<option>无</option>");
                }
                for (var j = 0; j <group[i]['grouparr_dev'].length; j++) {
                    $(".deviceslt").append("<option>" +group[i]['grouparr_dev'][j]['devicename']+ "</option>");
                }
            }
        }
    });
    //通过数组里面的名字去找ID
    function grouparrDev(){
        var deviceslt=$(".deviceslt").val();
        var devicename="";
        for(var i=0;i<group.length;i++){
            for(var j=0;j<group[i]['grouparr_dev'].length;j++){
                if(deviceslt==group[i]['grouparr_dev'][j]['devicename']){
                    devicename=group[i]['grouparr_dev'][j]['devicename'];
                }
            }
        }
        return devicename;
    };
    //通过groupname去找groupid
    function groupNameById(opt){
        var updateoption=$(opt).val();
        var updateuserid="";
        for(var i=0;i<group.length;i++){
            if(updateoption==group[i]['groupname']){
                updateuserid=group[i]['groupid'];
            }
        }
        return updateuserid;
    };
    /*请求最新位置*/
    function reuquestAddr(){
        setInterval(function(){
            var device_arr=[];
            for(var i=0;i<group.length;i++){
                if(group[i].grouparr_dev.length!=0){
                    for(var j=0;j<group[i].grouparr_dev.length;j++){
                        device_arr.push(group[i].grouparr_dev[j]['devicename']);
                    }
                }
            }
            if(device_arr.length==0){
                return
            }else{
                $.ajax({
                    url:"php/bettering_page.php",
                    data:({
                        devicename:device_arr
                    }),
                    success:function(data){
                        if(data=="0"){
                            return;
                        }
                        console.log(data);
                        var json=JSON.parse(data);
                        sessionStorage.removeItem("list");
                        sessionStorage.setItem("list",data);
                        for(var i=0;i<json.length;i++){
                            DrawWatchingItems(json[i][0],json[i][1],json[i][2],json[i][3],json[i][4],json[i][5],json[i][6]);
                        }
                    }
                })
            }
        },1000);
    }
    reuquestAddr();
    /*点击左边设备信息，显示内容*/
    $(".group_box").on('click', 'p', function() {
        var new_info=$(this).html();
        /*MarkerhashTable[new_info].setPosition(map.getCenter());*/
        var data=sessionStorage.getItem("list");
        var json=JSON.parse(data);
        for(var i=0;i<json.length;i++){
            if(new_info==json[i][0]){
                $(".click_left_content").empty();
                $(".click_left_content").append("" +
                    "<button>X</button>"+
                    "<p><span>名称:</span>" +json[i][0]+"</p>" +
                    "<p><span>经度:</span>"+json[i][1]+"</p>"+
                    "<p><span>纬度:</span>"+json[i][2]+"</p>"+
                    "<p><span>状态:</span>"+json[i][3]+"</p>"+
                    "<p><span>速度:</span>"+json[i][4]+"</p>"+
                    "<p><span>方向:</span>"+json[i][5]+"</p>"+
                    "<p><span>时间:</span>"+json[i][6]+"</p>"+
                    "");
            }
        }
        $(".click_left_content").animate({
            left:"0px"
        },1000)
    });
    $(".click_left_content").on('click','button',function(){
        $(this).parent().animate({
            left:"-200px"
        },1000);
    });
});
