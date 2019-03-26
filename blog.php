<?php define('IN_TG',true);
//<!--转换成硬路径调用更快-->
require_once dirname(__FILE__).'/includes/common.inc.php';

/*
 * LIMIT 0,10 表示0行开始,显示10行  LIMIT 10,10 从10行开始显示10
 *
 * is_numeric() 判断变量是否数字 is_numeric($_page) 判断页面是否是数字
 * intval() 取得小数整数部分
 * */
_page("select tg_id from tg_user",6);
$_result = _select("select * from tg_user ORDER BY tg_reg_time DESC LIMIT $_pagenum,$_pagesize"); //从数据库或的结果集
require_once ROOT_PATH.'/header.inc.php';
//require_once 'includes/global.func.php';
head('博友');
?>

<section id="blog">
    <div class="container" style="padding: 0">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center">博友列表</div>
                <div class="panel-body">
                    <?php
                    $_info=array();
                    while(!!$_rows=_fetch_list($_result,MYSQL_ASSOC)) {
                        $_info['id']=$_rows['tg_id'];
                        $_info['username']=$_rows['tg_username'];
                        $_info['face']=$_rows['tg_face'];
                        $_info['sex']=$_rows['tg_sex'];
                        ?>
                    <div class="col-md-2">
                        <p class="text-center"><?php echo $_info['username']?>(<?php echo $_info['sex'] ?>)</p>
                        <img src="<?php echo $_info['face']=$_rows['tg_face'];?>"class="img-responsive">
                        <div class="text-center ">
                            <button class="btn btn-default btn-xs send" title="<?php echo $_info['id']?>">发消息</button>
                            <button class="btn btn-default btn-xs add" title="<?php echo $_info['id']?>">加为好友</button>
                            <br>
                            <button class="btn btn-default btn-xs liuyan">写留言</button>
                            <button class="btn btn-default btn-xs songhua" title="<?php echo $_info['id']?>">给他送花</button>
                        </div>

                    </div>
                    <?php }?>
        </div>

                <?php
                _pager(2);
                ?>

    </div>
            <script src="js/blog.js"></script>
</section>
<?php require ROOT_PATH.'/footer.inc.php' ?>
