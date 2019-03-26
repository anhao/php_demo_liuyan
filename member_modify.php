<?php
session_start();
define('IN_TG',true);
require_once dirname(__FILE__).'/includes/common.inc.php';
require_once ROOT_PATH.'/header.inc.php';
head('资料修改');
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
        $_info=_html($_info); //过滤html
    }else{
        _location('登陆异常','index.php');
    }
}else{
    _location('非法登陆','index.php');
}
if(isset($_GET['action'])){
    if($_GET['action']=='change'){
        @_check_code($_POST['code'],$_SESSION[code]);
        require dirname(__FILE__) . '/includes/check.inc.php';
        $_clean['password']=_check_modify_passowd($_POST['password'],6);
        $_clean['sex']=_check_sex($_POST['sex']);
        $_clean['face']=_check_face($_POST['face']);
        $_clean['url']=_check_url($_POST['url']);
        $_clean['qq']=_check_qq($_POST['qq']);
        $_clean['email']=_check_email($_POST['email']);
        if(empty($_clean['password'])){
            //如果密码为空不修改密码
            _select("UPDATE tg_user set tg_sex='{$_clean['sex']}',
                                              tg_face='{$_clean['face']}',
                                              tg_email='{$_clean['email']}',
                                              tg_url='{$_clean['url']}',
                                              tg_qq='{$_clean['qq']}'
                                              WHERE tg_username ='{$_COOKIE['username']}'
                                            ");
        }else{
            //否则修改密码
            _select("UPDATE tg_user set tg_password='{$_clean['password']}',
                                              tg_sex='{$_clean['sex']}',
                                              tg_face='{$_clean['face']}',
                                              tg_email='{$_clean['email']}',
                                              tg_url='{$_clean['url']}',
                                              tg_qq='{$_clean['qq']}'
                                              WHERE tg_username ='{$_COOKIE['username']}'
                                            ");
        }
        if(_affected_rows()===1){
            _close();
            _session_destroy();
            _location('恭喜您,修改成功','member.php');
        }else{
            _close();
            _session_destroy();
            _location('抱歉，未修改数据！','member_modify.php');
        }

    }
}

?>

<session id="member_modify">
    <div class="container" style="padding: 0">
        <div class="col-md-4">
            <?php
            require_once '/sider.php';
            ?>
        </div>
    </div>
        <div class="col-md-8">
            <div class="panel  panel-info">
                <div class="panel-heading">会员资料</div>

                <form action="member_modify.php?action=change" class="form-horizontal" method="post" id="reg_form">
                    <div class="form-group">
                        <label for="username" class="col-md-2 control-label">用户名:</label>
                        <div class="col-md-8">
                            <p class="form-control-static"><?php echo $_info['username'] ?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-md-2 control-label">密码:</label>
                        <div class="col-md-8">
                            <input type="password" name="password" id="password" class="form-control input-sm" placeholder="重新设置你的密码">
                        </div>
                        <div class="col-md-2">
                            <p>留空则不修改</p>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <label for="nan" class="col-md-2 control-label">性别:</label>
                        <div class="col-md-3">
                            <input type="radio" id="nan" name="sex" class="" value="男" checked><label for="nan" class="radio-inline">男</label>
                        </div>
                        <div class="col-md-5">
                            <input type="radio" id="nv" name="sex" class="" value="女"><label for="nv" class="radio-inline">女</label>
                        </div>

                    </div>

                    <div class="form-group form-group-sm">
                        <label for="face" class="col-md-2 control-label">头像</label>
                        <div class="col-md-8">
                            <input type="hidden" id="faceval" name="face" value="face/m01.gif">
                            <img id="chface" class="face" src="<?php echo $_info['face']; ?>" alt="" >
                        </div>
                    </div>

                    <div class="form-group form-group-sm">
                        <label for="email" class="control-label col-md-2">电子邮箱:</label>
                        <div class="col-md-8">
                            <input type="email" value="<?php echo $_info['email']; ?>" name="email" id="email" class="form-control input-sm" placeholder="输入你的电子邮箱">
                        </div>

                    </div>

                    <div class="form-group form-group-sm">
                        <label for="qq" class="control-label col-md-2">QQ号:</label>
                        <div class="col-md-8">
                            <input type="text" value="<?php echo $_info['qq']; ?>" name="qq" id="qq" class="form-control input-sm" placeholder="输入你的QQ号">
                        </div>

                    </div>

                    <div class="form-group form-group-sm">
                        <label for="url" class="col-md-2 control-label">个人主页:</label>
                        <div class="col-md-8">
                            <input type="url" value="<?php echo $_info['url']; ?>" name="url" id="url" class="form-control input-sm" value="https://" placeholder="输入你的个人网站">
                        </div>

                    </div>

                    <div class="form-group form-group-sm">
                        <label for="yzm" class="col-md-2 control-label">验证码:</label>
                        <div class="col-md-2">
                            <input type="text" name='code' id='yzm' class="form-control input-sm">
                        </div>
                        <div class="col-md-2">
                            <img src="code.php" id="code" alt="验证码" >
                        </div>
                    </div>

                    <div class="form-gruop form-group-sm">
                        <div class="text-center">
                            <input type="submit" class="btn btn-default" value="修改资料">
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</session>
<script src="js/face.js"></script>
<script src="js/script.js"></script>
<?php require ROOT_PATH.'/footer.inc.php' ?>
