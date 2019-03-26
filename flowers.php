<?php
session_start();
define('IN_TG',true);
//<!--转换成硬路径调用更快-->
require_once dirname(__FILE__).'/includes/common.inc.php';
require_once ROOT_PATH.'/check.inc.php';
//判断是否登陆
if(!@isset($_COOKIE['username'])) {
    _alert_close('请先登陆！');
}
//校验唯一标识符
$_rows=_fetch("SELECT * FROM tg_user where tg_username = '{$_COOKIE['username']}'");
if($_rows['tg_uniqid']==$_COOKIE['uniqid']){
    //写入数据
    if(@$_GET['action']=='send'){
        @_check_code($_POST['code'],$_SESSION[code]);
        $_clear=array();
        $_clear['touser']=$_POST['touser'];
        $_clear['fromuser']=$_COOKIE['username'];
        $_clear['content']=_check_content($_POST['content']);
        $_clear['count_flower']=$_POST['flower'];
        $_clear=_mysql_string($_clear);
        if($_clear['touser']==$_clear['fromuser']){
            _alert_close('不能给自己送花');
        }
        _select("insert into tg_flowers(tg_touser,tg_fromuser,tg_flower,tg_content,tg_date) 
              values ('{$_clear['touser']}','{$_clear['fromuser']}','{$_clear['count_flower']}','{$_clear['content']}',now())
              ");
        if(_affected_rows()===1){
            _close();
            _session_destroy();
            _alert_close('送花成功');
        }else{
            _close();
            _session_destroy();
            _alert_black_('送花失败');
        }
        exit;
    }
}else{
    _alert_close('非法登陆');
}


//判断接收者id
if(isset($_GET['id'])){
    if(!!$_rows=_fetch("select tg_username from tg_user where tg_id={$_GET['id']} LIMIT 1") ){
        $_info=array();
        $_info['touser']=$_rows['tg_username'];
        $_info=_html($_info);
    }else{
        _alert_close('不存在此用户');
    }
}else{
    _alert_close('非法操作');
}

?>
<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>送花</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="bootstrap/js/jquery-3.3.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

</head>
<body>
<section id="message">
    <div class="container">
        <h4 class="text-center">送花好友</h4>
        <form action="?action=send" class="from-horizontal" method="post">
            <input type="hidden" name="touser" value="<?php echo $_info['touser']?>">
            <input type="text" name="user" id="" class="form-control" value="发送给:<?php echo $_info['touser']?>" readonly>
            <select name="flower" class="form-control">
                <?php
                foreach (range(1,100) as $_num) {
                    echo '<option value="'.$_num.'"> x'.$_num.'朵</option>';
                }
                ?>
            </select>
            <textarea name="content" id="yzcontent"class="form-control" rows="3" placeholder="输入你的留言">我非常的欣赏你呀！！！</textarea>
            <br>
            <div class="row">
                <label for="code">验证码：</label>
                <input type="text" name="code" id="yzm">
                <img src="code.php" alt="" id="code">
            </div>
            <button type="submit" class="btn btn-default">发送短信</button>
        </form>
    </div>
    <script src='js/blog.js'></script>
    <script src="js/message.js"></script>
</section>
</body>
</html>
