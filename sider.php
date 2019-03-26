<?php

if(!defined('IN_TG'))
    exit('Access Defined!');
?>

<div class="panel panel-default panel-info">
    <div class="panel-heading">个人导航</div>
    <div class="panel-body">
        <nav>
            <ul class="nav nav-pills nav-stacked">
                <li><h3  class="label label-info">账号管理</h3></li>
                <li><a href="member.php">个人信息</a></li>
                <li><a href="member_modify.php">修改资料</a></li>
                <li><a href="member_login_count.php">登陆记录</a></li>
                <li>
                    <h3  class="label label-info">其他管理</h3>
                </li>
                <li><a href="member_message.php">短信查阅</a></li>
                <li><a href="member_friend.php">好友设置</a></li>
                <li><a href="member_flowers.php">查询鲜花</a></li>
                <li><a href="">个人相册</a></li>
            </ul>
        </nav>
    </div>
