<?php
define('IN_TG',true);
require_once dirname(__FILE__).'/includes/common.inc.php';
require_once ROOT_PATH.'/header.inc.php';
head('个人中心');

if(isset($_COOKIE['username'])){
    $_rows=_fetch("SELECT * FROM tg_user where tg_username = '{$_COOKIE['username']}'");
    @_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
    if($_rows){
        $_info=array();
        $_info['username']=$_rows['tg_username'];
        $_info['sex']=$_rows['tg_sex'];
        $_info['email']=$_rows['tg_email'];
        $_info['face']=$_rows['tg_face'];
        $_info['url']=$_rows['tg_url'];
        $_info['qq']=$_rows['tg_qq'];
        $_info['reg_time']=$_rows['tg_reg_time'];
        $_info['level']=$_rows['tg_level'];
        if($_info['level']==0){
            $_info['level']='普通会员';
        }else if ($_info['level']==1){
            $_info['level']='管理员';
        }
        $_info=_html($_info); //过滤html
    }else{
        _location('登陆异常','index.php');
    }
}else{
    _location('非法登陆','index.php');
}
?>

<session id="member">
<div class="container" style="padding: 0">
    <div class="col-md-4">
        <?php
        require_once '/sider.php';
        ?>
        </div>

    </div>
    <div class="col-md-6" style="padding: 0;">
        <div class="panel  panel-info">
            <div class="panel-heading">会员管理中心</div>
            <table class="table table-hover">
                <tbody>
                <tr>
                    <th scope="row" width="100">用户名：</th>
                    <td><?php echo $_info['username']?></td>
                </tr>
                <tr>
                    <th scope="row" width="100">性别：</th>
                    <td><?php echo $_info['sex']?></td>
                </tr>
                <tr>
                    <th scope="row" width="100">头像：</th>
                    <td><?php echo $_info['face']?></td>
                </tr>
                <tr>
                    <th scope="row" width="100">电子邮箱：</th>
                    <td><?php echo $_info['email']?></td>
                </tr>
                <tr>
                    <th scope="row" width="100">主页：</th>
                    <td><?php echo $_info['url']?></td>
                </tr>
                <tr>
                    <th scope="row" width="100">QQ：</th>
                    <td><?php echo $_info['qq']?></td>
                </tr>
                <tr>
                    <th scope="row" width="100">注册时间：</th>
                    <td><?php echo $_info['reg_time']?></td>
                </tr>
                <tr>
                    <th scope="row" width="100">身份：</th>
                    <td><?php echo $_info['level']?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

</session>

<?php require ROOT_PATH.'/footer.inc.php' ?>

