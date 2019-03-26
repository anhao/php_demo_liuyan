<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/13
 * Time: 11:02
 */
/*
 * _alert_black() js返回上一页弹窗
 * @access public
 * @param string $_info 弹出信息
 * */
function _alert_black_($_info)
{
    echo "<script>alert('".$_info."');history.back();</script>";
    exit();
}

function _alert_close($_info){
    echo "<script>alert('".$_info."');close();</script>";
    exit;
}

function _location($info,$adress){
    echo "<script>alert('$info');</script>";
    echo "<script>location.href='$adress';</script>";
}


function _session_destroy(){
    session_destroy();
}

/**
 * @return string
 */
function _sha1_uniqid(){
    return sha1(uniqid(rand(),true));
}


/*
 * _mysql_string() 判断是否转义
 * @param string $_string 转义的字符
 * return string
 * */
function _mysql_string($_string){
    //get_magic_quotes_gpc()如果开启状态，那么就不需要转义
    if(!GPC){
        if(is_array($_string)){
            foreach ($_string as $key => $value){
                $_string[$key]=_html($value); //采用递归，如果值是数组，那么重新进行_html()
            }
        }else{
            $_string=mysql_real_escape_string($_string);
        }
    }
    return $_string;
}

function _x_time($nowtime,$pertime,$num){
    if($nowtime-$pertime>$num){
        _alert_black_('限时发帖');
    }
}

/*
 * _runtime() 用来获取程序耗时
 * @access public  表示函数对外公开
 * @return float 返回浮点数
 * */
function _runtime(){
//    以explode 分割microtiem 成数组
//    microtime() 返回当前 Unix 时间戳和微秒数
    $_mtime = explode(' ',microtime());

//
    return $_mtime[1]+$_mtime[0];

//    return microtime(true);
// microtime(true) 可以直接返回浮点数

}

/*
 *
 * _check_code 检验验证码是否正确
 * @param string $_start_code 用户输入的验证码
 * @param string $_end_code session保存的验证码
 * */
function _check_code($_start_code,$_end_code){
    if($_start_code != $_end_code){
        _alert_black_('验证码错误');
    }

}


/*
 * _code() 生成一个验证码
 * @param int $_width 验证码的长度
 * @param int $_height 验证码的高度
 * @param int $_rnd_code 验证码个数
 * @param bool $flag 是否开启验证码边框
 * @return void 这个函数执行生成一个验证码
 * */
function _code($_width=75,$_height=25,$_rnd_code=4,$flag=false)
{
    $_nmsg = '';
//    $_rnd_code = 4;
//创建随机码，保持在SESSION
    for ($i = 0; $i < $_rnd_code; $i++) {
        $_nmsg .= dechex(mt_rand(0, 15));
    }
// 创建验证码图片
    $_SESSION['code'] = $_nmsg;
//长和高
    /*  $_width=75;
      $_height=25;*/

//创建真彩图层
    $_img = imagecreatetruecolor($_width, $_height);

//添加颜色
//imagecolorallocate( resource $image, int $red, int $green, int $blue)
    $_white = imagecolorallocate($_img, 255, 255, 255);

//填充背景颜色
//imagefill( resource $image, int $x, int $y, int $color)
    imagefill($_img, 0, 0, $_white);

//黑色边框
    if ($flag) {

    $_black = imagecolorallocate($_img, 0, 0, 0);
    imagerectangle($_img, 0, 0, $_white - 1, $_height - 1, $_black);
}
//随机线条
//imageline( resource $image, int $x1, int $y1, int $x2, int $y2, int $color)
    for ($i=0;$i<6;$i++){
        $_rnd_color=imagecolorallocate($_img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
        imageline($_img,mt_rand(0,$_width),mt_rand(0,$_height),mt_rand(0,$_width),mt_rand(0,$_height),$_rnd_color);
    }

//随机雪花
    for ($i=0;$i<100;$i++){
        $_rnd_color = imagecolorallocate($_img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255)); //值越大颜色越淡
        imagestring($_img,1,mt_rand(0,$_width),mt_rand(0,$_height),'*',$_rnd_color);
    }

//输出验证码
    /*$_rnd_color=imagecolorallocate($_img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
    imagestring($_img,5,20,4,$_SESSION['code'],$_rnd_color);*/
    for ($i=0;$i<strlen($_SESSION['code']);$i++) {
        $_rnd_color = imagecolorallocate($_img,mt_rand(0,100),mt_rand(0,150),mt_rand(0,200));
        imagestring($_img,5,$i*$_width/$_rnd_code+mt_rand(1,10),mt_rand(1,$_height/2),$_SESSION['code'][$i],$_rnd_color);
    }

    ob_clean(); //清空缓存
//输出图片
    header('Content-Type:image/png');
    imagepng($_img);


//结束图片资源
    imagedestroy($_img);
}


/**
 * @return array|false|string
 */
function getIP() {
    if (getenv('HTTP_CLIENT_IP')) {
        $ip = getenv('HTTP_CLIENT_IP');
    }
    elseif (getenv('HTTP_X_FORWARDED_FOR')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    }
    elseif (getenv('HTTP_X_FORWARDED')) {
        $ip = getenv('HTTP_X_FORWARDED');
    }
    elseif (getenv('HTTP_FORWARDED_FOR')) {
        $ip = getenv('HTTP_FORWARDED_FOR');

    }
    elseif (getenv('HTTP_FORWARDED')) {
        $ip = getenv('HTTP_FORWARDED');
    }
    else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

/**
 *_unsetcookies() 删除cookies 实现退出登陆
 */
function _unsetcookies(){
    setcookie('username','',time()-1);
    setcookie('uniqid','',time()-1);
    _session_destroy();
    _location('已退出','index.php');
}
/*
 * 判断是否登陆
 * */
function _check_login(){
    if(isset($_COOKIE['username'])){
        _location('已登陆','index.php');
    }
}


/**
 * _page()
 * @param $sql
 * @param $_size
 */
function _page($sql, $_size){
    global $_pagesize,$_pagenum,$_page,$_num,$_pageabsolute;
    if(isset($_GET['page'])){
        $_page=$_GET['page'];//获取当前页
        if(empty($_page) || $_page<=0 || !is_numeric($_page)){
            $_page=1;
        }else{
            $_page = intval($_page);
        }
    }else{
        $_page=1;
    }
    $_num=_num_rows(_select($sql));//获取数据总条数
//    $_pagesize=6;//每页显示多少数据
    $_pagesize=$_size;
//如果数据库为空，则默认返回第一页
    if($_num ==0){
        $_page=1;
    }else{
        $_pageabsolute = ceil($_num / $_pagesize); // 向上取整获取页码
        if ($_page > $_pageabsolute) {
            $_page = $_pageabsolute;
        }
    }
//如果你输入的页码大于实际页码，则把实际页码赋值给_page
    $_pagenum= ($_page -1 ) * $_pagesize; //从第几行开始
}

/**
 * _pager() 分页函数,显示数字分页还是文本分页
 * @param $_type 类型
 * return 返回分页
 */
function _pager($_type){
    $url_path=parse_url($_SERVER['REQUEST_URI'])['path'];
    global $_page,$_pageabsolute,$_num,$id;

    if($_type==1){
                echo '<div class="text-center">';
                 echo ' <nav aria-label="Page navigation " id="nav">';
                 echo '<ul class="pagination">';
                               for($i=0;$i<$_pageabsolute;$i++){
                                    if(($i+1)==$_page){
                                        echo '<li class="active"><a href="'.$url_path.'?'.$id.'page='.($i+1).'">'.($i+1).'</a></li>';
                                    }else{
                                        echo '<li><a href="'.$url_path.'?'.$id.'page='.($i+1).'">'.($i+1).'</a></li>';
                                    }
                                }
                        echo '</ul>';
                    echo '</ul>';
                echo '</div>';
    }else if($_type==2){
                echo '<div class="page_text text-center">';
                    echo '<ul class="pager">';
                        echo '<li>'.$_page.'/'.$_pageabsolute.'页</li>';
                        echo '<li>共有<strong>'.$_num.'</strong>个数据</li>';

                        if($_page ==1){
                            echo '<li class="disabled"> <a href="'.$url_path.'">首页</a> </li>';
                            echo '<li class="disabled"> <a href="'.$url_path.'?page='.($_page-1).'">上一页</a> </li>';
                        }else{
                            echo '<li> <a href="'.$url_path.'">首页</a> </li>';
                            echo '<li> <a href="'.$url_path.'?page='.($_page-1).'">上一页</a> </li>';
                        }
                        if($_page==$_pageabsolute){
                            echo '<li class="disabled"> <a href="'.$url_path.'?page='.($_page+1).'">下一页</a> </li>';
                            echo '<li class="disabled"> <a href="'.$url_path.'?page='.$_pageabsolute.'">尾页</a> </li>';
                        }else{
                            echo '<li> <a href="'.$url_path.'?page='.($_page+1).'">下一页</a> </li>';
                            echo '<li> <a href="'.$url_path.'?page='.$_pageabsolute.'">尾页</a> </li>';
                        }

                    echo '</ul>';
                echo '</div>';
    }

}


/** html过滤
 * @param $_string
 * @return string
 */
function _html($_string){
    if(is_array($_string)){
        foreach ($_string as $key => $value){
            $_string[$key]=_html($value); //采用递归，如果值是数组，那么重新进行_html()
        }
    }else{
        $_string=htmlspecialchars($_string);
    }
    return $_string;
}

function _html_get($_string){
    if(is_array($_string)){
        foreach ($_string as $key => $value){
            $_string[$key]=_html_get($value); //采用递归，如果值是数组，那么重新进行_html()
        }
    }else{
        $_string= htmlentities($_string);
    }
    return $_string;
}
function _mysql_free($result){
    return mysql_free_result($result);
}

function _uniqid($_mysql_uniqid,$_cookie_uniqid){
    if($_mysql_uniqid!=$_cookie_uniqid){
        _location('非法登陆','index.php');
    }
}

function _title($_string){
    if(mb_strlen($_string,'utf-8')>14){
        $_string=mb_substr($_string,0,14,'utf-8').'...';//截取
    }
    return $_string;
}


/**
 * @param $file
 * @return array
 */
function _get_xml($file){
    if(file_exists($file)){
        $_xml = file_get_contents($file);
        preg_match_all('/<user>(.*)<\/user>/s',$_xml,$dom);
       foreach ($dom[1] as $value){
           preg_match_all('/<id>(.*)<\/id>/s',$value,$id);
           preg_match_all('/<name>(.*)<\/name>/s',$value,$username);
           preg_match_all('/<sex>(.*)<\/sex>/s',$value,$sex);
           preg_match_all('/<face>(.*)<\/face>/s',$value,$face);
           preg_match_all('/<qq>(.*)<\/qq>/s',$value,$qq);
           preg_match_all('/<url>(.*)<\/url>/s',$value,$url);
           preg_match_all('/<email>(.*)<\/email>/s',$value,$email);
           $_info= [];
           $_info['id']=$id[1][0];
           $_info["username"]=$username[1][0];
           $_info['sex']=$sex[1][0];
           $_info['face']=$face[1][0];
           $_info['qq']=$qq[1][0];
           $_info['url']=$url[1][0];
           $_info['email']=$email[1][0];
           $_info=_html($_info);
       }
    }else{
        echo '文件错误！';
    }
    return $_info;
}



/**
 * @param $filename 获取sql文件写入xml
 * @param $_info
 */
function _setxml($filename, $_info){
    $fp=fopen($filename,'w');
    if(!$fp){
        exit('文件获取出错');
    }
    flock($fp,LOCK_EX);
    $_string="<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n";
    fwrite($fp,$_string,strlen($_string));
    //int fwrite ( resource $文件资源变量, string $写入的字符串 [, int 长度])
    $_string="<user>\r\n";
    fwrite($fp,$_string,strlen($_string));
    $_string="<id>{$_info['id']}</id>\r\n";
    fwrite($fp,$_string,strlen($_string));
    $_string="<name>{$_info['username']}</name>\r\n";
    fwrite($fp,$_string,strlen($_string));
    $_string="<sex>{$_info['sex']}</sex>\r\n";
    fwrite($fp,$_string,strlen($_string));
    $_string="<face>{$_info['face']}</face>\r\n";
    fwrite($fp,$_string,strlen($_string));
    $_string="<email>{$_info['email']}</email>\r\n";
    fwrite($fp,$_string,strlen($_string));
    $_string="<qq>{$_info['qq']}</qq>\r\n";
    fwrite($fp,$_string,strlen($_string));
    $_string="<url>{$_info['url']}</url>\r\n";
    fwrite($fp,$_string,strlen($_string));
    $_string="</user>\r\n";
    fwrite($fp,$_string,strlen($_string));
    flock($fp,LOCK_UN);
}

/**
+----------------------------------------------------------
 * UBB 解析
+----------------------------------------------------------
 */
function _ubb($Text) {
    $Text=trim($Text);
    $Text=ereg_replace("\n","<br>",$Text);
    $Text=preg_replace("/\\t/is","  ",$Text);
    $Text=preg_replace("/\[hr\]/is","<hr>",$Text);
    $Text=preg_replace("/\[separator\]/is","<br/>",$Text);
    $Text=preg_replace("/\[h1\](.+?)\[\/h1\]/is","<h1>\\1</h1>",$Text);
    $Text=preg_replace("/\[h2\](.+?)\[\/h2\]/is","<h2>\\1</h2>",$Text);
    $Text=preg_replace("/\[h3\](.+?)\[\/h3\]/is","<h3>\\1</h3>",$Text);
    $Text=preg_replace("/\[h4\](.+?)\[\/h4\]/is","<h4>\\1</h4>",$Text);
    $Text=preg_replace("/\[h5\](.+?)\[\/h5\]/is","<h5>\\1</h5>",$Text);
    $Text=preg_replace("/\[h6\](.+?)\[\/h6\]/is","<h6>\\1</h6>",$Text);
    $Text=preg_replace("/\[center\](.+?)\[\/center\]/is","<center>\\1</center>",$Text);
    //$Text=preg_replace("/\[url=([^\[]*)\](.+?)\[\/url\]/is","<a href=\\1 target='_blank'>\\2</a>",$Text);
    $Text=preg_replace("/\[url\](.+?)\[\/url\]/is","<a href=\"\\1\" target='_blank'>\\1</a>",$Text);
    $Text=preg_replace("/\[url=(http:\/\/.+?)\](.+?)\[\/url\]/is","<a href='\\1' target='_blank'>\\2</a>",$Text);
    $Text=preg_replace("/\[url=(.+?)\](.+?)\[\/url\]/is","<a href=\\1>\\2</a>",$Text);
    $Text=preg_replace("/\[img\](.+?)\[\/img\]/is","<img src=\\1>",$Text);
    $Text=preg_replace("/\[img\s(.+?)\](.+?)\[\/img\]/is","<img \\1 src=\\2>",$Text);
    $Text=preg_replace("/\[color=(.+?)\](.+?)\[\/color\]/is","<font color=\\1>\\2</font>",$Text);
    $Text=preg_replace("/\[colorTxt\](.+?)\[\/colorTxt\]/eis","color_txt('\\1')",$Text);
    $Text=preg_replace("/\[style=(.+?)\](.+?)\[\/style\]/is","<div class='\\1'>\\2</div>",$Text);
    $Text=preg_replace("/\[size=(.+?)\](.+?)\[\/size\]/is","<font size=\\1>\\2</font>",$Text);
    $Text=preg_replace("/\[sup\](.+?)\[\/sup\]/is","<sup>\\1</sup>",$Text);
    $Text=preg_replace("/\[sub\](.+?)\[\/sub\]/is","<sub>\\1</sub>",$Text);
    $Text=preg_replace("/\[pre\](.+?)\[\/pre\]/is","<pre>\\1</pre>",$Text);
    $Text=preg_replace("/\[emot\](.+?)\[\/emot\]/eis","emot('\\1')",$Text);
    $Text=preg_replace("/\[email\](.+?)\[\/email\]/is","<a href='mailto:\\1'>\\1</a>",$Text);
    $Text=preg_replace("/\[i\](.+?)\[\/i\]/is","<i>\\1</i>",$Text);
    $Text=preg_replace("/\[u\](.+?)\[\/u\]/is","<u>\\1</u>",$Text);
    $Text=preg_replace("/\[b\](.+?)\[\/b\]/is","<b>\\1</b>",$Text);
    $Text=preg_replace("/\[quote\](.+?)\[\/quote\]/is","<blockquote>引用:<div style='border:1px solid silver;background:#EFFFDF;color:#393939;padding:5px' >\\1</div></blockquote>", $Text);
    $Text=preg_replace("/\1(.+?)\[\/code\]/eis","highlight_code('\\1')", $Text);
    $Text=preg_replace("/\1(.+?)\[\/php\]/eis","highlight_code('\\1')", $Text);
    $Text=preg_replace("/\[sig\](.+?)\[\/sig\]/is","<div style='text-align: left; color: darkgreen; margin-left: 5%'><br><br>--------------------------<br>\\1<br>--------------------------</div>", $Text);
    return $Text;
}