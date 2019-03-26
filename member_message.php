<?php
session_start();
define('IN_TG',true);
require_once dirname(__FILE__).'/includes/common.inc.php';
require_once ROOT_PATH.'/header.inc.php';
head('消息列表');
_page("select tg_id from tg_message where tg_touser='{$_COOKIE['username']}'",6);
if(isset($_COOKIE['username'])){
    $_rows=_fetch("SELECT * FROM tg_user where tg_username = '{$_COOKIE['username']}'");
    @_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
    $_message=_select("select * from tg_message where tg_touser='{$_COOKIE['username']}' order by tg_date DESC LIMIT $_pagenum,$_pagesize");
}else{
    _location('非法登陆','index.php');
}

//接收要删除的id  SQL in()
if(@($_GET['action']=='delete' && isset($_POST['ids']))){
        $_del=array();
        //implode() 将数组分割成字符串
        $_del['ids']=_mysql_string(implode(',',$_POST['ids']));
           _select("DELETE FROM tg_message WHERE tg_id IN({$_del['ids']})");//删除信息
           if(_affected_rows()){
               _close();
               _session_destroy();
               _location('删除成功','member_message.php');
           }else{
               _close();
               _alert_black_('删除失败');
           }
}
?>

<session id="member_message">
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
            <div class="panel-heading text-center">信息管理</div>

            <form action="?action=delete" method="post" class="all-del">
            <table class="table">
                <thead>
                <tr>
                    <th>发件人</th>
                    <th>短信内容</th>
                    <th>时间</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <?php
                    $_messages=array();
                    while(!!$_info=_fetch_list($_message)){
                        $_messages['id']=$_info['tg_id'];
                        $_messages['fromuser']=$_info['tg_fromuser'];
                        $_messages['content']=$_info['tg_content'];
                        $_messages['date']=$_info['tg_date'];
                        $_messages['status']=$_info['tg_status'];
                        $_messages=_html($_messages);
                        if($_messages['status']==0){
                            $_messages['status']='未读';
                            $_messages['content_html']='<strong>'._title($_messages['content']).'</strong>';
                        }else{
                            $_messages['status']='已读';
                            $_messages['content_html']=_title($_messages['content']);
                        }
                    ?>
                    <td><?php echo $_messages['fromuser'] ?></td>
                    <td><a href="member_message_detail.php?id=<?php echo $_messages['id']; ?>" title="<?php echo ($_messages['content']) ?>"><?php echo ($_messages['content_html']) ?></a></td>
                    <td><?php echo $_messages['date'] ?></td>
                    <td><?php echo $_messages['status'] ?></td>
                    <td><input type="checkbox" name="ids[]" value="<?php echo $_messages['id'] ?>"></td>
                </tr>
                <?php }
                ?>
                </tbody>

            </table>
                <label for="all" class="text-center">全选: <input type="checkbox" id="all"></label>
                <label for=""><input type="submit" value="全部删除"></label>
            </form>
            <?php _pager(2,'数据'); ?>
        </div>
    </div>
</session>
<script src="js/del.js"></script>
<?php
require_once ROOT_PATH.'/footer.inc.php';
?>
