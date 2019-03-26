<?php
define('IN_TG',true);
session_start();
require dirname(__FILE__).'/includes/common.inc.php';
require_once ROOT_PATH.'/header.inc.php';
if($_GET['action']=='rearticle'){
    $_rows=_fetch("SELECT * FROM tg_user where tg_username = '{$_COOKIE['username']}'");
    @_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
    @_check_code($_POST['code'],$_SESSION[code]);//验证码
    require dirname(__FILE__) . '/includes/check.inc.php';
    $_info = array();
    $_info['reid']=$_POST['reid'];
    $_info['type']=$_POST['type'];
    $_info['username']=$_COOKIE['username'];
    $_info['title']=_check_title($_POST['title'],5,40);
    $_info['content']=_check_post_content($_POST['content'],10);
    _insert("insert into tg_article(tg_reid,tg_title,tg_type,tg_username,tg_content,tg_date)
            values('{$_info['reid']}','{$_info['title']}','{$_info['type']}','{$_info['username']}','{$_info['content']}',now())");
    if(_affected_rows()===1){
        //更新评论数
        _select("update tg_article set tg_comm =tg_comm+1 where tg_id={$_info['reid']} and tg_reid=0");
        _close();
        _session_destroy();
        _location('回帖成功','article.php?id='.$_info['reid']);
    }else{
        _close();
        _session_destroy();
        _alert_black_('回帖失败');
    }
}
if(isset($_GET['id'])){
    if(!!$row=_fetch("select * from tg_article where tg_reid=0 AND tg_id = '{$_GET['id']}'")){
        $_article=[];
        $_article['id']=$row['tg_id'];
        $_article['username']=$row['tg_username'];
        $_article['type']=$row['tg_type'];
        $_article['title']=$row['tg_title'];
        $_article['content']=$row['tg_content'];
        $_article['date']=$row['tg_date'];
        $_article['read']=$row['tg_ready'];
        $_article['comm']=$row['tg_comm'];
        $_article['reid']=$row['tg_id'];
        $_article['last_modify']=$row['tg_last_modify'];
        if($_article['last_modify']){
            $_article['last_modify']='最后修改时间'.$_article['last_modify'];
        }
        global $id;
        $id='id='.$_article['id'].'&';

        if($_article['username']==$_COOKIE['username']){
            $_article_modify='[修改]';
        }
//        $_article=_html($_article);
        if(!!$_row2=_fetch("select tg_id,tg_username,tg_sex,tg_face,tg_email,tg_url from tg_user where tg_username ='{$_article['username']}'")){
            $_user=[];
            $_user['id']=$_row2['tg_id'];
            $_user['username']=$_row2['tg_username'];
            $_user['sex']=$_row2['tg_sex'];
            $_user['face']=$_row2['tg_face'];
            $_user['url']=$_row2['tg_url'];
            $_user['email']=$_row2['tg_email'];
        }else{
            //用户
        }
        //读取回帖
        _page("select tg_id from tg_article where tg_reid='{$_article['reid']}'",5);
        $result=_select("select * from tg_article where tg_reid = '{$_article['reid']}' LIMIT $_pagenum,$_pagesize");

        //更新阅读量
        _select("update tg_article set tg_ready =tg_ready+1 where tg_id={$_GET['id']}");
    }else{
        _alert_black_('为找到该帖子');
    }
}else{
    _location('异常操作','index.php');
}
head($_article['title']);
?>
<session id="artcle">
    <div class="container" style="padding:0; ">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">帖子详情</div>
            </div>
        </div>
    <?php
    if($_page==1){ //如果换页了就不显示主题
    ?>
            <div class="col-md-12">
                <div class="text-center col-md-3">
                    <p class=""><?php echo $_user['username'].'(楼主)&nbsp;'.'('.$_user['sex'].')'?></p>
                    <img src="<?php echo $_user['face'] ?>" alt="">
                    <div class="text-center">
                        <button class="btn btn-default btn-xs send" title="<?php echo $_user['id']?>">发消息</button>
                        <button class="btn btn-default btn-xs add" title="<?php echo $_user['id']?>">加为好友</button>
                        <br>
                        <button class="btn btn-default btn-xs" >写留言</button>
                        <button class="btn btn-default btn-xs songhua" title="<?php echo $_user['id']?>">给他送花</button>
                        <br>
                        <p>个人主页：<a href="<?php echo $_user['url'] ?>"><?php echo $_user['url'] ?></a></p>
                        <p>个人邮箱：<?php echo $_user['email'] ?></p>
                    </div>
                </div>

                <div class="col-md-9">
                    <p><?php echo $_user['username']?> | 发表于 <?php  echo $_article['date']?><span class="badge">阅读数（<?php echo $_article['read']?>）</span><span class="badge">评论数（<?php echo $_article['comm']?>）</span>
                       <span><?php echo $_article['last_modify'] ?></span> <a href="article_modify.php?id=<?php echo $_article['id']?>" class="" style="float: right"><?php echo $_article_modify;?></a><span class="label label-info text-right" style="float: right;">1#</span>
                    </p>
                    <hr style="padding: 0;margin: 0;">
                    <h4><strong><?php  echo $_article['title'];?></strong><img src="img/icon<?php echo $_article['type']?>.gif" alt=""><span><?php if($_COOKIE['username']) echo '<a href="#title">[回帖]</a>';?></span></h4>
                    <p><?php echo $_article['content']?></p>
                </div>
            </div>
            <hr style="border:1px solid #DDDDDD;">
<?php } ?>

<!--            回帖楼层-->
            <?php
            $reuser=[];
            $reinfo=[];
            $_i=2;
            while(!!$row4=_fetch_list($result)) {
                $reinfo['title'] = $row4['tg_title'];
                $reinfo['content'] = $row4['tg_content'];
                $reinfo['date'] = $row4['tg_date'];
                $reinfo['username'] = $row4['tg_username'];
                if (!!$_row5 = _fetch("select tg_id,tg_username,tg_sex,tg_face,tg_email,tg_url from tg_user where tg_username ='{$reinfo['username']}'")) {
                    $reuser['id'] = $_row5['tg_id'];
                    $reuser['username'] = $_row5['tg_username'];
                    $reuser['sex'] = $_row5['tg_sex'];
                    $reuser['face'] = $_row5['tg_face'];
                    $reuser['url'] = $_row5['tg_url'];
                    $reuser['email'] = $_row5['tg_email'];
                    if($_page=1 &&$_i==2){
                        if($reuser['username']==$_user['username']){
                            $reuser['username']=$reuser['username'].'(楼主)';
                        }else{
                            $reuser['username']=$reuser['username'].'(沙发)';
                        }
                    }
                }
                ?>

                <div class="col-md-12">
                    <div class="text-center col-md-3">
                        <p class=""><?php echo $reuser['username'] . '&nbsp;' . '(' . $reuser['sex'] . ')' ?></p>
                        <img src="<?php echo $reuser['face'] ?>" alt="">
                        <div class="text-center">
                            <button class="btn btn-default btn-xs send" title="<?php echo $reuser['id'] ?>">发消息</button>
                            <button class="btn btn-default btn-xs add" title="<?php echo $reuser['id'] ?>">加为好友</button>
                            <br>
                            <button class="btn btn-default btn-xs">写留言</button>
                            <button class="btn btn-default btn-xs songhua" title="<?php echo $reuser['id'] ?>">给他送花
                            </button>
                            <br>
                            <p>个人主页：<a href="<?php echo $reuser['url'] ?>"><?php echo $reuser['url'] ?></a></p>
                            <p>个人邮箱：<?php echo $reuser['email'] ?></p>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <p><?php echo $reinfo['username'] ?> | 发表于 <?php echo $reinfo['date'] ?><span
                                    class="label label-info"
                                    style="float: right;">
                                <?php echo
                                $_ii=$_i + (($_page-1) * $_pagesize);

                                $ii; ?>#
                            </span></p>
                        <hr style="padding: 0;margin: 0;">
                        <h5><strong><?php echo $reinfo['title']; ?></strong>
                            <?php if($_COOKIE['username']) echo '<a href="#title" class="re" title="'.回复.''.$_ii.''.楼的楼主.'">[回帖]</a>';?>

                        </h5>
                        <p><?php echo $reinfo['content'] ?></p>
                    </div>
                </div>
                <hr style="border:1px solid #DDDDDD;">
                <?php
                $_i++;
            }
                _mysql_free($result);
                _pager(1);
?>
<!--            end-->

<!--          回帖-->
                <?php
                if($_COOKIE['username']){?>
            <div>
                <div class="col-md-8 col-md-offset-2">
                    <form action="?action=rearticle" class="form-horizontal" method="post">
                        <input type="hidden" name="type" value="<?php echo $_article['type'] ?>">
                        <input type="hidden" name="reid" value="<?php echo $_article['reid'] ?>">
                        <div class="form-group">
                            <label for="title" class="col-md-2 control-label">标题：</label>
                            <div class="col-md-8">
                                <input type="text" id="title" name="title" class="form-control" value="RE：<?php echo $_article['title']?>" >
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

                <?php }?>



    </div>
</session>
<script src="js/article.js"></script>
<script src="js/blog.js"></script>
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
</script><?php require ROOT_PATH.'/footer.inc.php' ?>
