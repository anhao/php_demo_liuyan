<?php
session_start();
define('IN_TG',true);
//<!--转换成硬路径调用更快-->
require_once dirname(__FILE__).'/includes/common.inc.php';
_check_login();//检测登陆状态

//测试新增数据
if(isset($_GET['action'])){
    if($_GET['action']=='register'){
//        防止恶意注册，开启验证码
        @_check_code($_POST['code'],$_SESSION[code]);
        require dirname(__FILE__) . '/includes/check.inc.php';
           $_clear = array();
           $_clear['uniqid']=_check_uniqid($_POST['uniqid'],$_SESSION['uniqid']);
           $_clear['active']=_sha1_uniqid();
           $_clear['username']=_check_username($_POST['username'],2,20);
           $_clear['password']=_check_password($_POST['password'],$_POST['notpassword'],6,20);
           $_clear['qusetion']=_check_question($_POST['question'],2,50);
           $_clear['answer']=_check_answer($_POST['question'],$_POST['answer'],2,20);
           $_clear['sex']=_check_sex($_POST['sex']);
           $_clear['face']=_check_sex($_POST['face']);
           $_clear['email']=_check_email($_POST['email']);
           $_clear['url']=_check_url($_POST['url']);
           $_clear['qq']=_check_qq($_POST['qq']);
           $_clear['ip']=getIP();

           //插入数据前效验是否已存在注册的用户名
        //        $select =@mysql_query("select tg_username from tg_user where tg_username = '{$_clear['username']}'") or die('sql错误');
        /* if(@mysql_fetch_array($select,MYSQLI_ASYNC)){
             _alert_black_('用户名已被注册');
         }*/

        //调用函数来判断
        $select = _query('tg_user','tg_username',$_clear['username']);
        _fetch_array($select);
//           数据插入数据库
        _insert("insert into 
                            tg_user(
                            tg_uniqid,
                            tg_active,
                            tg_username,
                            tg_password,
                            tg_question,
                            tg_answer,
                            tg_email,
                            tg_qq,
                            tg_url,
                            tg_sex,
                            tg_face,
                            tg_reg_time,
                            tg_last_time,
                            tg_last_ip
                            ) 
                            values (
                            '{$_clear['uniqid']}',
                            '{$_clear['active']}',
                            '{$_clear['username']}',
                            '{$_clear['password']}',
                            '{$_clear['qusetion']}',
                            '{$_clear['answer']}',
                            '{$_clear['email']}',
                            '{$_clear['qq']}',
                            '{$_clear['url']}',
                            '{$_clear['sex']}',
                            '{$_clear['face']}',
                            now(),
                            now(),
                            '{$_clear['ip']}'
                            )");
       if(_affected_rows()===1){
           //mysql_insert_id获取上一次mysql插入数据的id
           $_clear['id']=mysql_insert_id();
           _close();
           _session_destroy();
           _setxml('user.xml',$_clear);
           _location('恭喜您,注册成功','active.php?active='.$_clear['active']);
       }else{
           _close();
           _session_destroy();
           _location('抱歉，注册失败！','register.php');
       }
    }
}
$_SESSION['uniqid']=$uniqid=_sha1_uniqid();
require_once ROOT_PATH.'/header.inc.php';
//require_once 'includes/global.func.php';
head('注册');
?>
<!--导航-->

<section id="reg">
    <div class="container" style="padding: 0">
        <h3 class="text-center">会员注册</h3>
        <form action="register.php?action=register" class="form-horizontal" method="post" id="reg_form">
            <input type="hidden" name="uniqid" value="<?php echo $uniqid ?>">
            <div class="form-group">
                <label for="username" class="col-md-2 control-label">用户名:</label>
                <div class="col-md-8">
                    <input type="text" id="username" name="username" class="form-control" placeholder="输入你的用户名">
                </div>
                <div class="col-md-2">
                   <p class="text-info">(*必填，至少两位)</p>
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-md-2 control-label">密码:</label>
                <div class="col-md-8">
                    <input type="password" id="password" name="password" class="form-control" placeholder="输入你的密码">
                </div>
                <div class="col-md-2">
                    <p class="text-info">(*必填，至少六位)</p>
                </div>
            </div>

            <div class="form-group">
                <label for="notpassword" class="col-md-2 control-label">重新输入密码:</label>
                <div class="col-md-8">
                    <input type="password" id="notpassword" name="notpassword" class="form-control" placeholder="重新输入你的密码">
                </div>
                <div class="col-md-2">
                    <p class="text-info">(*必填，同上)</p>
                </div>
            </div>

            <div class="form-group">
                <label for="question" class="col-md-2 control-label">密码提示:</label>
                <div class="col-md-8">
                    <input type="text" id="question" name="question" class="form-control" placeholder="输入你的密码提升">
                </div>
                <div class="col-md-2">
                    <p class="text-info"> (*必填，至少两位)</p>
                </div>
            </div>

            <div class="form-group">
                <label for="answer" class="col-md-2 control-label">密码回答:</label>
                <div class="col-md-8">
                    <input type="text" id="answer" name="answer" class="form-control" placeholder="输入你的密码答案">
                </div>
                <div class="col-md-2">
                    <p class="text-info"> (*必填，至少两位)</p>
                </div>
            </div>

            <div class="form-group">
                <label for="nan" class="col-md-2 control-label">性别:</label>
                <div class="col-md-3">
                    <input type="radio" id="nan" name="sex" class="" value="男" checked><label for="nan" class="radio-inline">男</label>
                </div>
                <div class="col-md-5">
                    <input type="radio" id="nv" name="sex" class="" value="女"><label for="nv" class="radio-inline">女</label>
                </div>
                <div class="col-md-2">
                    <p class="text-info"></p>
                </div>
            </div>

            <div class="form-group">
                <label for="face" class="col-md-2 control-label">头像</label>
                <div class="col-md-8">
                    <input type="hidden" id="faceval" name="face" value="face/m01.gif">
                    <img id="chface" class="face" src="face/m01.gif" alt="" >
                </div>
            </div>

            <div class="form-group">
                <label for="email" class="control-label col-md-2">电子邮箱:</label>
                <div class="col-md-8">
                    <input type="email" name="email" id="email" class="form-control" placeholder="输入你的电子邮箱">
                </div>
                <div class="col-md-2">
                    <p class="text-info">(*必填，激活账户)</p>
                </div>
            </div>
            
            <div class="form-group">
                <label for="qq" class="control-label col-md-2">QQ号:</label>
                <div class="col-md-8">
                    <input type="text" name="qq" id="qq" class="form-control" placeholder="输入你的QQ号">
                </div>
                <div class="col-md-2">
                    <p class="text-info">(*必填，至少五位)</p>
                </div>
            </div>
            
            <div class="form-group">
                <label for="url" class="col-md-2 control-label">个人主页:</label>
                <div class="col-md-8">
                    <input type="url" name="url" id="url" class="form-control" value="https://" placeholder="输入你的个人网站">
                </div>
                <div class="col-md-2">
                    <p class="text-info"></p>
                </div>
            </div>
            
            <div class="form-group">
                <label for="yzm" class="col-md-2 control-label">验证码:</label>
                <div class="col-md-2">
                    <input type="text" name='code' id='yzm' class="form-control">
                </div>
                <div class="col-md-2">
                    <img src="code.php" id="code" alt="验证码" >
                </div>
            </div>
            
            <div class="form-gruop">
                <div class="col-md-8 col-md-offset-2" >
                    <input type="submit" class="btn btn-default" value="注册">
                </div>
            </div>
        </form>
    </div>
</section>


<script src="js/face.js"></script>
<script src="js/script.js"></script>
<?php require ROOT_PATH.'/footer.inc.php' ?>
