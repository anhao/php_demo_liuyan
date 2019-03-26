<!--require 生成一个致命错误（E_COMPILE_ERROR），在错误发生后脚本会停止执行。
include 生成一个警告（E_WARNING），在错误发生后脚本会继续执行。-->
<?php
define('IN_TG',true);
//<!--转换成硬路径调用更快-->
require dirname(__FILE__).'/includes/common.inc.php';
require_once ROOT_PATH.'/header.inc.php';
head('首页');
$_info=_get_xml('user.xml');
_page("select tg_id from tg_article where tg_reid=0",10);
$_result = _select("select tg_id,tg_title,tg_type,tg_ready,tg_comm from tg_article where tg_reid=0 ORDER BY tg_date DESC LIMIT $_pagenum,$_pagesize"); //从数据库或的结果集
?>
<!--导航-->

<!--导航end-->

<!--内容开始-->
<section id="content">
    <div class="container" style="padding: 0">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">新进会员</div>
                <div class="panel-body">
                    <div class="text-center">
                        <p class=""><?php echo $_info['username'].'&nbsp;'.'('.$_info['sex'].')'?></p>
                        <img src="<?php echo $_info['face'] ?>" alt="">
                        <div class="text-center">
                           <button class="btn btn-default btn-xs send" title="<?php echo $_info['id']?>">发消息</button>
                           <button class="btn btn-default btn-xs add" title="<?php echo $_info['id']?>">加为好友</button>
                            <br>
                            <button class="btn btn-default btn-xs" >写留言</button>
                            <button class="btn btn-default btn-xs songhua" title="<?php echo $_info['id']?>">给他送花</button>
                            <br>
                            <p>个人主页：<a href="<?php echo $_info['url'] ?>"><?php echo $_info['url'] ?></a></p>
                            <p>个人邮箱：<?php echo $_info['email'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading" id="newimg">最新图片</div>
                    <div class="panel-body">
                        <img src="https://via.placeholder.com/200x80.png/09f/fff?text=200x80" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">留言列表</div>
                <a href="post.php" class="btn btn-block btn-info" style="margin: 0">发表帖子</a>
                <ul class="list-group">
                    <?php
                    $_bbs=[];
                    while(!!$row=_fetch_list($_result)){
                        $_bbs['title']=$row['tg_title'];
                        $_bbs['type']=$row['tg_type'];
                        $_bbs['read']=$row['tg_ready'];
                        $_bbs['comm']=$row['tg_comm'];
                        $_bbs['id']=$row['tg_id'];
                    ?>
                    <li class="list-group-item"><span><img src="img/icon<?php echo $_bbs['type']?>.gif" alt=""></span><a href="article.php?id=<?php echo $_bbs['id'];?>"> <?php echo $_bbs['title']?></a><span class="badge">阅读数（<?php echo $_bbs['read']?>）</span><span class="badge">评论数（<?php echo $_bbs['comm']?>）</span></li>
                <?php } ?>
                </ul>
                <?php _pager(1)?>
            </div>
        </div>
    </div>
</section>
<script src="js/blog.js"></script>
<?php require ROOT_PATH.'/footer.inc.php' ?>
