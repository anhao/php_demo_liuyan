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
 *_check_uniqid() 判断唯一标识符
 *@param string $_first_uniqid
 *@param string $_end_uniqid
 * */
function _check_uniqid($_first_uniqid,$_end_uniqid){
    if(strlen($_first_uniqid)!=40 || $_first_uniqid!=$_end_uniqid){
        _alert_black_('唯一标识符异常');
    }
    return _mysql_string($_first_uniqid);
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

    //设置限制字符
    $_mg[0]='admin';
    $_mg[1]='root';
    $_mg[2]='lp';
    foreach ($_mg as $v){
        $_mg_string='';
    $_mg_string .='['.$v.']'.'\n';
    }
    if(in_array($_string,$_mg)){
        _alert_black_($_mg_string.'以上用户名不得注册');
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
function _check_password($_first_pass,$_end_pass,$min_num,$max_num){
    if(strlen($_first_pass) < $min_num || strlen($_first_pass)>$max_num){
        _alert_black_('密码不得小于'.$min_num.'或大于'.$max_num.'位');
    }
    if(!$_first_pass == $_end_pass){
        _alert_black_('两次密码不一致');
    }
    return md5(_mysql_string($_first_pass));
}

function _check_modify_passowd($_sting,$_minnum){
    if(!empty($_sting)){
        if(strlen($_sting)<$_minnum){
            _alert_black_('密码不能小于'.$_minnum.'位');
        }
    }else{
        return null;
    }
    return md5(_mysql_string($_sting));
}


/*
 * _check_question() 返回密码提示
 * @param string $_string
 * @param int $min_num
 * @param int $max_num
 * */
function _check_question($_string,$min_num,$max_num){
    $_string = trim($_string);
    //判断问题字数
    if(mb_strlen($_string,'utf8')<$min_num || mb_strlen($_string,'utf8')>20){
        _alert_black_('密码提示不得小于'.$min_num.'或大于'.$max_num.'位');
    }

    return _mysql_string($_string);
}


/*
 * _check_question() 返回密码回答
 * @param string $_question
 * @param string $_answer
 * @param int $min_num
 * @param int $max_num
 * */
function _check_answer($_question,$_answer,$min_num,$max_num){
    $_answer=trim($_answer);
    $_question=trim($_question);
    if(strlen($_answer)<$min_num || strlen($_answer) >$max_num){
        _alert_black_('密码答案不得小于'.$min_num.'或大于'.$max_num.'位');
    }
    if($_question == $_answer){
        _alert_black_('密码提示和密码答案不能一样');
    }
    return md5(_mysql_string($_answer));
}

/**
 * @param $_string
 * @return string|null
 */
function _check_email($_string){
    if(empty($_string)){
        return null;
    }else {
        $_string = trim($_string);
        $_email_pattern = '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/';
        if (!preg_match($_email_pattern, $_string)) {
            _alert_black_('邮箱不正确');
        }
        return _mysql_string($_string);
    }
}

/**
 * @param $_string
 * @return string|null
 */
function _check_url($_string){
    if(empty($_string)){
        return null;
    }else {
        $_string = trim($_string);
        $_url_pattern = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        if (!preg_match($_url_pattern,$_string)){
            _alert_black_('网址不正确');
        }
    return _mysql_string($_string);
}
}

/**
 * @param $_int
 * @return string|null
 */
function _check_qq($_int){
    if(empty($_int)){
        return null;
    }else{
        $_int=trim($_int);
        $_qq_pattern='/[1-9][0-9]{4,}/';
        if(!preg_match($_qq_pattern,$_int)){
            _alert_black_('QQ输入错误');
        }
    return _mysql_string($_int);
    }

}

/**
 * @param $_string
 * @return string
 */
function _check_sex($_string){
    return _mysql_string($_string);
}

/**
 * @param $_string
 * @return string
 */
function _check_face($_string){
    return _mysql_string($_string);
}


/**
 * @param $_string
 * @return mixed
 */
function _check_content($_string){
    if((mb_strlen($_string,'utf8')>200) || (mb_strlen($_string,'utf8')<10)){
        _alert_black_('短信内容不能超过200位或小于10位');
    }
        return $_string;
}

/**
 * @param $_string
 * @param $min
 * @param $max
 * @return mixed
 */
function _check_title($_string, $min, $max){
    if((mb_strlen($_string,'utf8')<$min) ||(mb_strlen($_string,'utf8')>$max) ){
        _alert_black_('帖子标题不能小于'.$min.'或大于'.$max.'位');
    }
    return $_string;
}
/**
 * @param $_string
 * @param $min
 * @param $max
 * @return mixed
 */
function _check_post_content($_string, $min){
    if(mb_strlen($_string,'utf8')<$min ){
        _alert_black_('帖子内容不能小于于'.$min);
    }
    return $_string;
}