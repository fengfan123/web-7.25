$(function(){
    /*生成验证码*/
    var chars = [
        '0','1','2','3','4','5','6','7','8','9',
        'a','b','c','d','e','f','g','h','i','j',
        'k','l','m','n','o','p','q','r','s','t',
        'u','v','w','x','y','z','A','B','C','D',
        'E','F','G','H','I','J','K','L','M','N',
        'O','P','Q','R','S','T','U','V','W','X',
        'Y','Z'
    ];
    function generateMixed(n) {
        var res = "";
        for(var i = 0; i < n ; i ++) {
            var id = Math.floor(Math.random()*61);
            res += chars[id];
        }
        return res;
    }
    var code=generateMixed(4);
    $(".VerificationCode").html(code);
    /*表单登录验证*/
    $(".login_btn").click(function(){
            var login_user_val=$("#login_user").val();
            var login_pwd_val=$("#login_pwd").val();
            var login_code_val=$("#login_code").val();
            if(login_user_val===null||login_user_val===""){
                $(".login p:first-child").html("用户名不能为空");
                return false;
            }
            if(login_pwd_val===null||login_pwd_val===""){
                $(".login p:first-child").html("密码不能为空");
                return false;
            }
            if(login_code_val===null||login_code_val===""){
                $(".login p:first-child").html("验证码不能为空");
                return false;
            }
            if(login_code_val.toUpperCase()!==code.toUpperCase()){
                $(".login p:first-child").html("验证码输入错误");
                return false;
            }
            $.ajax({
                url:"php/login.php",
                data:({
                    user:$("#login_user").val(),
                    pwd:$("#login_pwd").val()
                }),
                success:function(data){
                   if(data==0){
                       $(".login p:first-child").html("用户名和密码不一致");
                   }else{
                       sessionStorage.setItem("data",data);
                       location.href="login_onlineExperience.html";
                   }
                }
            });
            if(check.checked){
                var exp=new Date();
                exp.setTime(exp.getTime()+30*24*60*60*2000);//设置时间2个月过期
                document.cookie="username="+login_user_val+";expires="+exp.toGMTString();
                document.cookie="password="+login_pwd_val+";expires="+exp.toGMTString();
            }
    });
    /*户第二次登录直接获取用户名密码*/
    var getcookie=document.cookie.split("; ");
    for(var i=0;i<getcookie.length;i++){
        var getcookies=getcookie[i].split("=");
        if(getcookies[0]=="username"){
            $("#login_user").val(getcookies[1]);
        }
        if(getcookies[0]=="password"){
            $("#login_pwd").val(getcookies[1]);
        }
    }
    /*注册表单验证*/
    var user_reg= /^[\w]{6,15}$/;//(字母、数字、下划线,组成 6-15);
    var pwd_reg=/^[0-9A-Za-z]{6,15}$/;//(字母、数字,组成 6-15位之间);
    var email_reg=/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;//(邮箱验证);
    $("#register_user").focus(function(){
        $(".register p:first-child").html("用户名由字母、数字、下划线,组成 6-15位");
    });
    $("#register_pwd").focus(function(){
        $(".register p:first-child").html("密码由6-16字母，数字组成");
    });
    $("#confirm_pwd").focus(function(){
        $(".register p:first-child").html("密码由6-16字母，数字组成");
    });
    $("#register_email").focus(function(){
        $(".register p:first-child").html("请输入正确的邮箱格式");
    });
    $("#register_code").focus(function(){
        $(".register p:first-child").html("请输入正确的验证码");
    });
    /*松开键盘去数据库检测用户名是否重复*/
    $("#register_user").keyup(function(){
        $.ajax({
            url:"php/register_remove_user.php",
            data:({
                user:$("#register_user").val()
            }),
            success:function(date){
                if(!(user_reg.test($("#register_user").val()))){
                    $(".register p:first-child").html("用户名格式错误");
                }else{
                    $(".register p:first-child").html(date);
                }
            }
        })
    });
    $("#register_btn").click(function(){
        if(!(user_reg.test($("#register_user").val()))){
            $(".register p:first-child").html("用户名格式错误");
            return false;
        }
        if(!(user_reg.test($("#register_pwd").val()))){
            $(".register p:first-child").html("密码设置不符合要求");
            return false;
        }
        if($("#register_pwd").val()!==$("#confirm_pwd").val()){
            $(".register p:first-child").html("两次密码不一致");
            return false;
        }
        if(!(email_reg.test($("#register_email").val()))){
            $(".register p:first-child").html("邮箱格式不符合要求");
            return false;
        }
        if($("#register_code").val().toUpperCase()!==code.toUpperCase()){
            $(".register p:first-child").html("验证码输入错误");
            return false;
        }
        $.ajax({
            url:"php/register.php",
            data:({
                user:$("#register_user").val(),
                pwd:$("#register_pwd").val(),
                email:$("#register_email").val()
            }),
            success:function(date){
                   if(date=="1"){
                       $(".register p:first-child").html("注册成功，请登录");
                   }else{
                       $(".register p:first-child").html("注册失败，请重新注册");
                   }
            }
        });
    });
});
