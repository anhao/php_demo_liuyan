<?php
session_start();
define('IN_TG',true);
require_once dirname(__FILE__).'/includes/common.inc.php';
require_once ROOT_PATH.'/header.inc.php';
head('消息列表');
$_rows1=_fetch("SELECT tg_uniqid FROM tg_user where tg_username = '{$_COOKIE['username']}' LIMIT 1");
@_uniqid($_rows1['tg_uniqid'],$_COOKIE['uniqid']);
if(!isset($_COOKIE['username'])) {
    _location('非法登陆','index.php');
}
    if(@$_GET['action']=='delete' && isset($_GET['id'])){
        if(!!$_rows2=_fetch("select * from tg_message where tg_id='{$_GET['id']}'")){

                _select("delete from tg_message where tg_id='{$_GET['id']}' LIMIT 1");//删除信息
                if(_affected_rows()===1){
                    _close();
                    _session_destroy();
                    _location('删除成功','member_message.php');
                }else{
                    _close();
                    _alert_black_('删除失败');
                }

        }else{
            _alert_black_('此短信不存在');
        }
    exit;
    }
    if(isset($_GET['id'])){
        $_rows=_fetch("select * from tg_message where tg_id='{$_GET['id']}'");
        if($_rows){
            $_info=array();
            //解决用户跨域查看别人的信息
            if($_rows['tg_touser']==$_COOKIE['username']){
                $_info['id']=$_rows['tg_id'];
                $_info['fromuser']=$_rows['tg_fromuser'];
                $_info['content']=$_rows['tg_content'];
                $_info['date']=$_rows['tg_date'];
                $_info['status']=$_rows['tg_status'];
                //设置状态 0 未读，1已读
                if($_info['status']==0){
                    _select("UPDATE tg_message set tg_status = 1 where tg_id='{$_info['id']}'");
                    if(!_affected_rows()==1){
                        _alert_black_('异常');
                    }
                }
            }else{
                _alert_black_('非法查看');
            }


        }else{
        _alert_black_('该数据不存在');
        }
    }else{
        _location('数据错误','index.php');
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
            <div class="panel-heading text-center">短信详情</div>
            <div>
                <p><strong>发件人：</strong><?php echo $_info['fromuser'] ?></p>
            </div>
            <div>
                <p><strong>短信详情：</strong><?php echo $_info['content'] ?></p>
            </div>
            <div>
                <p><strong>发送时间：</strong><?php echo $_info['date'] ?></p>
            </div>
            <div class="text-center">
                <a href="member_message.php" class="btn btn-default">返回列表</a>
                <a href="javascript:void()" class="btn btn-default del" name="<?php echo $_info['id']?>">删除信息</a>
            </div>
        </div>
    </div>
</session>

<script src="js/del.js"></script>
<?php
require_once ROOT_PATH.'/footer.inc.php';
?>
