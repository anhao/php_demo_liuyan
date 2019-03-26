<?php define('IN_TG',true);
session_start();
//<!--转换成硬路径调用更快-->
require_once dirname(__FILE__).'/includes/common.inc.php';

require_once ROOT_PATH.'/header.inc.php';
//require_once 'includes/global.func.php';
head('退出');


_unsetcookies();