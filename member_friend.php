<?php
session_start();
define('IN_TG',true);
require_once dirname(__FILE__).'/includes/common.inc.php';
require_once ROOT_PATH.'/header.inc.php';
head('好友管理');
@_page("select tg_id from tg_friend where tg_touser='{$_COOKIE['username']}'",6);
if(isset($_COOKIE['username'])){
    $_rows=_fetch("SELECT * FROM tg_user where tg_username = '{$_COOKIE['username']}'");
    @_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
    $_friend=_select("select * from tg_friend where tg_fromuser='{$_COOKIE['username']}' or tg_touser='{$_COOKIE['username']}' order by tg_date DESC LIMIT $_pagenum,$_pagesize");
}else{
    _location('非法登陆','index.php');
}

//接收要删除的id  SQL in()
if(@($_GET['action']=='delete' && isset($_POST['ids']))){
    $_del=array();
    //implode() 将数组分割成字符串
    $_del['ids']=_mysql_string(implode(',',$_POST['ids']));
    _select("DELETE FROM tg_friend WHERE tg_id IN({$_del['ids']})");//删除信息
    if(_affected_rows()){
        _close();
        _session_destroy();
        _alert_black_('删除成功');
    }else{
        _close();
        _alert_black_('删除失败');
    }
}

//验证好友
if(@$_GET['action']=='check' && isset($_GET['id'])){
    //验证输入的id是否有数据
    if($_yz=_fetch("select tg_id,tg_touser from tg_friend where tg_id = '{$_GET['id']}' LIMIT 1")){
        //通过id查询当前用户cookie是否等于touser,如果不等于，则不可以添加，解决用户跨域问题
        $_yz['touser']=$_yz['tg_touser'];
        if($_yz['touser']==$_COOKIE['username']){
            _select("update tg_friend set tg_status=1 where tg_id='{$_GET['id']}'");
            if(_affected_rows()==1){
                _close();
                _session_destroy();
                _alert_black_('添加成功');
            }else{
                _close();
                _alert_black_('添加失败');
            }
        }else{
            _alert_black_('非法操作');
        }
    }else{
        _alert_black_('数据错误');
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
            <div class="panel-heading text-center">好友管理</div>

            <form action="?action=delete" method="post" class="all-del">
                <table class="table">
                    <thead>
                    <tr>
                        <th>好友</th>
                        <th>请求内容</th>
                        <th>时间</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <?php
                        $_messages=array();
                        while(!!$_info=_fetch_list($_friend)){
                        $_messages['id']=$_info['tg_id'];
                        $_messages['touser']=$_info['tg_touser'];
                        $_messages['fromuser']=$_info['tg_fromuser'];
                        $_messages['content']=$_info['tg_content'];
                        $_messages['date']=$_info['tg_date'];
                        $_messages['status']=$_info['tg_status'];
                        $_messages=_html($_messages);
                        if($_messages['status']==0){
                            //判断状态，0未验证，1验证
                            // 如果当前登陆的用户向其他人发送的验证请求，则自己不可以点击验证，对方才可以点击
                            if($_messages['touser']==$_COOKIE['username']){
                                $_messages['status']='<span class="label label-warning"><a href="?action=check&id='.$_messages['id'].'">点击通过验证</a></span>';
                            }else{
                                $_messages['status']='<span class="label label-warning">对方未验证</span>';

                            }
                        }else{
                            $_messages['status']='<span class="label label-success">通过</span>';
                        }
                        //判断当前登陆的用户，如果是本身，好友先显示好友的名字
                        if($_messages['fromuser']==$_COOKIE['username']){
                            $_messages['fromuser']=$_messages['touser'];
                        }
                        ?>
                        <td><?php echo $_messages['fromuser'] ?></td>
                        <td><?php echo ($_messages['content']) ?></td>
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
