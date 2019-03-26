<?php define('IN_TG',true);
session_start();
//<!--转换成硬路径调用更快-->
require_once dirname(__FILE__).'/includes/common.inc.php';
_check_login();//检测登陆状态
if(isset($_GET['login'])){
    @_check_code($_POST['code'],$_SESSION[code]);
    require ROOT_PATH.'/login.inc.php';
    $_clear=array();
    $_clear['username']=_check_username($_POST['username'],2,20);
    $_clear['password']=_check_password($_POST['password'],6,20);
    $_clear['time']=_check_time($_POST['time']);

    //判断登陆用户的账号密码，还有激活状态
  /*  if(!!$_rows = _fetch("SELECT tg_username,tg_uniqid FROM tg_user WHERE tg_username='{$_clear['username']}' and tg_password='{$_clear['password']}' and tg_active='' LIMIT 1")){
//        _close();//关闭数据库
        _session_destroy();//清空session
        _setcookies($_rows['tg_username'],$_rows['tg_uniqid'],$_clear['time']);//设置Cookic
        _location('登陆成功','index.php');
    }else{
        _close();
        _session_destroy();
        _location('用户名密码不正确或者该账户未被激活！','login.php');
    }
}*/
  if(!!$_rows=_fetch("SELECT tg_username,tg_uniqid,tg_active FROM tg_user WHERE tg_username='{$_clear['username']}' and tg_password='{$_clear['password']}'  LIMIT 1"))
  {
      if($_rows['tg_active']==''){
          //登陆成功，记录信息
          $_ip=getIP();
          _select("update tg_user set 
                                  tg_last_ip='{$_ip}',
                                  tg_last_time=now(),
                                  tg_login_count=tg_login_count+1
                                   where 
                                   tg_username='{$_clear['username']}'
                                   ");
         _select("insert into tg_login_count(tg_username,tg_last_time,tg_last_ip) values('{$_clear['username']}',now(),'{$_ip}') ");
          _close();//关闭数据库
          _session_destroy();//清空session
          _setcookies($_rows['tg_username'],$_rows['tg_uniqid'],$_clear['time']);//设置Cookic
          _location('登陆成功','index.php');
      }else{
          _location('账号未激活','active.php?active='.$_rows['tg_active']);
      }
  }else{
      _location('账号或密码错误','login.php');
  }
}
require_once ROOT_PATH.'/header.inc.php';
//require_once 'includes/global.func.php';
head('登陆');
?>

<section id="login">
    <div class="contanier" style="padding: 0">
        <h3 class="text-center">会员登陆</h3>
        <form action="login.php?login=action" method="post" class="form-horizontal">
            <div class="form-group">
                <label for="username" class="control-label col-md-2">用户名:</label>
                <div class="col-md-8">
                    <input type="text" name="username" id="username" class="form-control" placeholder="输入你的用户名">
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="control-label col-md-2">密码:</label>
                <div class="col-md-8">
                    <input type="password" name="password" id="password" class="form-control" placeholder="输入你的密码">
                </div>
            </div>
            <div class="form-group">
                <label for="denglu" class="control-label col-md-2">保留登陆:</label>
                <div class="col-md-8">
                    <label class="radio-inline">
                        <input type="radio" name="time" id="time0" value="0"> 不保留
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="time" id="time1" value="1" checked> 一天
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="time" id="time2" value="2"> 一周
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="time" id="time3" value="3"> 一月
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="yzm" class="control-label col-md-2">验证码:</label>
                <div class="col-md-2">
                    <input type="text" name="code" id="yzm" class="form-control" placeholder="验证码">
                </div>
                <div class="col-md-2">
                    <img src="code.php" id="code" alt="验证码" >
                </div>
            </div>

            <div class="form-group">
                <label for="login" class="control-label col-md-2">登陆:</label>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-info btn-block">登陆</button>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-info btn-block">注册</button>
                </div>
            </div>
        </form>
    </div>
</section>

<script src="js/face.js"></script>
<script src="js/script.js"</script>
    <?php require ROOT_PATH.'/footer.inc.php' ?>

