<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/13
 * Time: 20:04
 */

if(!defined('IN_TG')) {
    exit('Access Defined!');
}

if(!function_exists('_alert_black_')){
    exit('_alert_black()函数不存在');
}




/*
 * _check_username() 检测并过滤用户名
 * @param string $_string 要过滤的用户名
 * @param int $min_num 限制用户名最小位数
 * @param int $max_num 限制用户名最大位数
 * @param string $_char_pattern 特殊字符正则
 * @param array $_mg 禁止注册的用户名
 * return string 返回过滤后的密码；
 * */
function _check_username($_string,$min_num=2,$max_num=20){
    //清除用户名两边空格
    $_string = trim($_string);
    //判断用户名位数
    if(mb_strlen($_string,'utf8')<$min_num || mb_strlen($_string,'utf8')>20){
        _alert_black_('用户名不得小于'.$min_num.'或大于'.$max_num.'位');
    }

    // 禁止特殊字符
    $_char_pattern = '/[<>\'\"\\   ]/';
    if(preg_match($_char_pattern,$_string)){
        _alert_black_('用户名包含敏感字符');
    }

    //用户名转义，能有效防止SQL注入
//    mysql_escape_string();
//    addslashes()
    return _mysql_string($_string);
}

/*
 * _check_password() 检查密码并加密密码
 *@param string $_first_pass 密码
 * @param string $_end_pass 确认密码
 *@param int $min_num 限制密码最小位数
 * @param int $max_num 限制密码最大位数
 * */
function _check_password($_pass,$min_num,$max_num){
    if(strlen($_pass) < $min_num || strlen($_pass)>$max_num){
        _alert_black_('密码不得小于'.$min_num.'或大于'.$max_num.'位');
    }
    return md5(_mysql_string($_pass));
}

/**
 * @param $_sting
 * @return string
 */
function _check_time($_sting){
    $_time = ['0','1','2','3'];
    if(!in_array($_sting,$_time)){
        _alert_black_('保留信息出错');
    }
    return _mysql_string($_sting);
}

/** _secookies 设置cookies 实现登陆功能
 * @param $_username
 * @param $_uniqid
 * @param $_time
 */
function _setcookies($_username, $_uniqid, $_time){
    switch ($_time) {
        case '0':  //浏览器进程
            setcookie('username',$_username);
            setcookie('uniqid',$_uniqid);
            break;
        case '1':  //一天
            setcookie('username',$_username,time()+86400);
            setcookie('uniqid',$_uniqid,time()+86400);
            break;
        case '2':  //一周
            setcookie('username',$_username,time()+604800);
            setcookie('uniqid',$_uniqid,time()+604800);
            break;
        case '3':  //一月
            setcookie('username',$_username,time()+2592000);
            setcookie('uniqid',$_uniqid,time()+2592000);
            break;
    }
}

