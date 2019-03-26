<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/14
 * Time: 17:08
 */


//创建数据库连接
function _connect(){
    global $_conn;
    $_conn = @mysql_connect(DB_HOST,DB_USER,DB_PASS) or die('数据库连接错误');
}

//选择数据库
function _select_db(){
    mysql_select_db(DB_NAME) or die('数据库不存在');
}

//设置数据库字符编码
function _set_names(){
    mysql_query('SET NAMES UTF8') or die('字符集错误');
}

/**
 * _query 数据库查询
 * @param $table
 * @param $where
 * @return resource
 */
function _query($table, $where_k,$where_v){
//    $sql = 'select * from '.$table.'where='.$where.';
    $sql = 'SELECT * FROM '.$table.' WHERE '.$where_k.'="'.$where_v.'" LIMIT 1';
    $result = @mysql_query($sql) or die("sql错误");
    return $result;
}

function _select($_result){
    if (!$_result = mysql_query($_result)) {
        exit('SQL执行失败'.mysql_error());
    }
    return $_result;
}

function _fetch($sql){
    return mysql_fetch_array(_select($sql),MYSQL_ASSOC);
}

function _num_rows($_result){
    return @mysql_num_rows($_result);
}

/**
 * @param $_result
 * @return array
 */
function _fetch_list($_result){
    return mysql_fetch_array($_result,MYSQL_ASSOC);
}

/**
 * @param $sql
 * @return resource
 */
function _insert($sql) {
    return @mysql_query($sql);
}

/**
 * @param $result
 */
function _fetch_array($result){
    if(@mysql_fetch_array($result,MYSQL_ASSOC)) {
        _alert_black_('用户名已注册');
    }
}
function _affected_rows(){

//        mysql_affected_rows()取得前一次 MySQL 操作所影响的记录行数
    return @mysql_affected_rows();
}

function _sql($sql){
    mysql_query($sql);
}

/**
 *
 */
function _close(){
    @mysql_close();
}