<?php
define('IN_TG',true);
//<!--转换成硬路径调用更快-->
require_once dirname(__FILE__).'/includes/common.inc.php';



if(!isset($_GET['active'])){
    _location('非法操作','index.php');
}
if(isset($_GET['action']) && $_GET['active'] && $_GET['action']=='ok'){
    $_active=_mysql_string($_GET['active']);
    if(_query('tg_user','tg_active','$_active')){

    _sql("UPDATE tg_user SET tg_active=NULL WHERE tg_active='$_active' LIMIT 1");
    if (_affected_rows() == 1) {
        _close();
        _location('账户激活成功','login.php');
    } else {
        _close();
        _location('账户激活失败','register.php');
    }
}else{
        _location('非法操作','index.php');
    }

}

require_once ROOT_PATH.'/header.inc.php';
head('激活');
?>

<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading text-center" id="">激活账户</div>
        <div class="panel-body">
            <h4 class="text-center">点击下方链接激活账号</h4>
            <p class="text-center">您的激活链接为:
                <a href="active.php?action=ok&amp;active=<?php echo $_GET['active'] ?>"><?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?></a>
        </div>
    </div>
</div>


<?php require ROOT_PATH.'/footer.inc.php' ?>
