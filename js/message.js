// language=JQuery-CSS
$("form").submit(function () {
    if($('#yzcontent').val().length<10 || $('#yzcontent').val().length>200){
        alert('短信内容不能大于200位或者小于10位');
        $('#yzcontent').focus();
        return false;
    }
    if($('#yzm').val()=='' ||$('$id').val().length!=4){
        alert('验证码必须为4位');
        $('#yzm').focus();
        return false;
    }
})