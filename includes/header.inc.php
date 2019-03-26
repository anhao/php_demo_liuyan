<?php

/*
 *  deined() 判断是否有这个常量,防止恶意调用
 * */

//防止恶意调用
if(!defined('IN_TG'))
exit('Access Defined!');
?>

<?php
function head($title)
{
    $title .= ' - 多用户留言系统';
    ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title><?php echo $title ?></title>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="style.css">
        <script src="bootstrap/js/jquery-3.3.1.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="ueditor/ueditor.config.js"></script>
        <script type="text/javascript" src="ueditor/ueditor.all.min.js"></script>
    </head>
    <body>
    <section id="header">
        <div class="container">
            <div class="navbar navbar-default">
                <div class="container">
                    <div class="navbar-header">
                        <button class="navbar-toggle" data-toggle="collapse" data-target=".collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a href="#" class="navbar-brand">多用户留言系统</a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="index.php">首页</a></li>
                            <?php
                            if(isset($_COOKIE['username'])){//检测是否是否存在username的cookic
                                echo '<li><a href="member.php">'.$_COOKIE['username'].'.个人中心</a></li>';
                                echo '<li><a href="member_message.php">未读（'.$GLOBALS['_count'].'）</a></li>';
                            }else{
                               echo  '<li><a href="register.php">注册</a></li>';
                            echo '<li><a href="login.php">登陆</a></li>';
                            }
                            ?>
                            <li><a href="blog.php">博友</a></li>
                            <li><a href="photo.php">相册</a></li>
                            <?php
                            if(isset($_COOKIE['username'])){
                                echo '<li><a href="logout.php">退出</a></li> ';
                            }
                            ?>
                            <li>
                                <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                   aria-expanded="true">风格</a>
                                <ul class="dropdown-menu">
                                    <li><a href="">风格1</a></li>
                                    <li><a href="">风格2</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php

}
