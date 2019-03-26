<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/13
 * Time: 10:30
 */

//防止恶意调用
if(!defined('IN_TG')) {
    exit('Access Defined!');
}
header('Content-Type:text/html;charset=utf8');
//转换成硬路径，调用速度更快
define('ROOT_PATH',dirname(substr(__FILE__,0,-8)));


/*
 * PHP_VERSION PHP版本
 * */
if(PHP_VERSION <'5.4'){
    exit('PHP版本太低');
}
//引入函数库
require dirname(__FILE__).'/global.func.php';
require dirname(__FILE__).'/mysql.func.php';
//执行耗时

define('START_TIME',_runtime());

//给get_magic_quotes_gpc 定义成常量减少内存
define('GPC',get_magic_quotes_gpc());


//数据库配置
define('DB_HOST','127.0.0.1');
define('DB_USER','root');
define('DB_PASS','root');
define('DB_NAME','liuyan');

_connect();
_select_db();
_set_names();

//短信提醒
$_message_wei = @_fetch("select count(tg_id) from tg_message where tg_status=0 AND tg_touser='{$_COOKIE['username']}'");
$GLOBALS['_count']=$_message_wei['count(tg_id)'];
