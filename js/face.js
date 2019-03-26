$('#chface').click(function () {
    open('../demo_Liuyan/face.php','face','width=400,height=400;');
})
$('dl dd img').click(function () {
    var src = $(this).attr('src');
    _opener(src);
    window.close();
    //获取face窗口图片的src地址，传到父窗口
})
function _opener(src) {
    //opener 获取父窗口元素
    opener.$('#chface').attr('src',src);
    opener.$('#faceval').val(src);
}
$('#code').click(function () {
   $(this).attr('src','code.php?tm='+Math.random());
})

