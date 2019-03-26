<?php
define('IN_TG',true);
session_start();
//<!--转换成硬路径调用更快-->
require dirname(__FILE__).'/includes/common.inc.php';
require_once ROOT_PATH.'/header.inc.php';
head('发表帖子');
if(!@isset($_COOKIE['username'])) {
    _location('请先登陆！','login.php');
}
$_rows=_fetch("SELECT * FROM tg_user where tg_username = '{$_COOKIE['username']}'");
@_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
if(($_GET['action']=='post')){
    //发帖限时
    _x_time(time(),$_COOKIE['post_time'],60);
    @_check_code($_POST['code'],$_SESSION[code]);//验证码
    require dirname(__FILE__) . '/includes/check.inc.php';
    $_info = array();
    $_info['username']=$_COOKIE['username'];
    $_info['type']=$_POST['type'];
    $_info['title']=_check_title($_POST['title'],5,40);
    $_info['content']=_check_post_content($_POST['content'],10);
//    $_info=_html($_info);
    _insert("
               insert into tg_article(
               tg_title,
               tg_type,
               tg_content,
               tg_date,
               tg_username
               ) 
               values (
               '{$_info['title']}',
               '{$_info['type']}',
               '{$_info['content']}',
               now(),
               '{$_info['username']}'
               )");
    if(_affected_rows()===1){
        //mysql_insert_id获取上一次mysql插入数据的id
        setcookie('post_time',time());
        $_info['id']=mysql_insert_id();
        _close();
        _session_destroy();
        _location('发帖成功','article.php?id='.$_info['id']);
    }else{
        _close();
        _session_destroy();
        _alert_black_('发帖失败');
    }
}
?>
    <session id="post">
    <div class="container" style="padding: 0;">
        <div class="col-md-8 col-md-offset-2">
            <form action="?action=post" class="form-horizontal" method="post">
                <div class="form-group">
                    <label for="title" class="col-md-2 control-label">类型：</label>
                        <?php
                        foreach (range(1,13) as $_num){
                            if($_num==1){
                                echo ' <label class="radio-inline">'."\n";
                                echo '<input type="radio" checked name="type" id="type'.$_num.'" value="'.$_num.'">'."\n";
                                echo '<img src="img/icon'.$_num.'.gif" />'."\n";
                                echo '</label>';
                            }else{
                                echo ' <label class="radio-inline">'."\n";
                                echo '<input type="radio" name="type" id="type'.$_num.'" value="'.$_num.'">'."\n";
                                echo '<img src="img/icon'.$_num.'.gif" />'."\n";
                                echo '</label>';
                            }
                        }
                        ?>
                </div>
                <div class="form-group">
                    <label for="title" class="col-md-2 control-label">标题：</label>
                    <div class="col-md-8">
                        <input type="text" id="title" name="title" class="form-control" placeholder="输入帖子标题" >
                    </div>
                    <div class="col-md-2">
                        <p class="text-info">输入帖子标题</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-md-2"></label>
                    <textarea class="col-md-8" name="content" id="content" cols="30" rows="10" style="padding: 0"></textarea>
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
                    <div class="col-md-2 col-md-offset-2" >
                        <input type="submit" class="btn btn-default" value="发表">
                    </div>
                </div>
            </form>
        </div>
    </div>
</session>
    <script type="text/javascript">
    var editor = new UE.ui.Editor({
        toolbars:[
          [
              'bold', //加粗
              'blockquote', //引用
              'date', //日期
              'fontfamily', //字体
              'link', //超链接
              'emotion', //表情
              'wordimage', //图片转存
              'music', //音乐
              'background', //背景
              'imagenone', //默认
              'insertorderedlist', //有序列表
              'insertunorderedlist', //无序列表
              'simpleupload', //单图上传

          ]
        ]
    });
    editor.render("content");

</script>
    <script src="js/face.js"></script>

<?php require_once ROOT_PATH.'/footer.inc.php';?>