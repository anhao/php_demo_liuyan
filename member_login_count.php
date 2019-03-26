<?php
session_start();
define('IN_TG',true);
require_once dirname(__FILE__).'/includes/common.inc.php';
require_once ROOT_PATH.'/header.inc.php';
head('登陆记录');
if(isset($_COOKIE['username'])){
    $_rows=_fetch("SELECT * FROM tg_user where tg_username = '{$_COOKIE['username']}'");
    @_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
    $_login=_select("select * from tg_login_count where tg_username='{$_COOKIE['username']}'");
   /*while(!!$_logins=_fetch_list($_login)){
       echo $_logins['tg_username'].'--'.$_logins['tg_last_time'];
   }
    print_r(mysql_fetch_array($_login));*/
   /* if($_login){
        $_info=array();
        $_info['username']=$_login['tg_username'];
        $_info['last_time']=$_login['tg_last_time'];
        $_info['last_ip']=$_login['tg_last_ip'];
        $_info=_html($_info);
//        print_r($_info);
    }else{
        _location('登陆异常','index.php');
    }*/
}else{
    _location('非法登陆','index.php');
}
?>

<session id="member-login-count">
    <div class="container" style="padding: 0">
        <div class="col-md-4">
            <?php
            require_once '/sider.php';
            ?>
        </div>
    </div>
    <div class="col-md-8">
        <div class="panel panel-info">
            <!-- Default panel contents -->
            <div class="panel-heading text-center">登陆记录</div>

            <!-- Table -->
            <table class="table">
                <thead>
                <tr>
                    <th>登陆用户</th>
                    <th>登陆时间</th>
                    <th>登陆IP</th>
                </tr>
                </thead>
                <tbody>
                <?php while(!!$_info=_fetch_list($_login)){
                    ?>
                <tr>
                    <td><?php echo $_info['tg_username']; ?></td>
                    <td><?php echo $_info['tg_last_time']; ?></td>
                    <td><?php echo $_info['tg_last_ip']; ?></td>
                </tr>
                <?php  } ?>
                </tbody>
            </table>
        </div>
    </div>
</session>
<?php require_once  ROOT_PATH.'/footer.inc.php' ?>
