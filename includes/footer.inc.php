
<?php
if(!defined('IN_TG')){
    exit('Access Defined!');
}
$endtime = _runtime()-START_TIME;
$time=round($endtime,4)
?>

<section id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <p class="text-center">本程序执行耗时为: <strong><?php echo $time ?></strong> 秒</p>
                <p class="text-center">版权所有 翻版必究</p>
                <p class="text-center">Copyright&nbsp;©&nbsp;2012-2015&nbsp;&nbsp;www.alone88.cn&nbsp;&nbsp;蜀ICP备00000000号
                </p>
            </div>
        </div>
</section>
</body>
</html>