//表单验证

$('#reg_form').submit(function () {

   /* var username = $('#username').val();
    var password=$('#password').val();
    var notpassword=$('#notpassword').val();
    var question =$('#question').val();
    var answer =$('#answer').val();
    var email = $('#email').val();
    var qq = $('#qq').val();
    var url =$('#url').val();*/
    //用户名
    if($('#username').val().length<2 || $('#username').val().length>20){
        alert('用户名不能小于两位或者大于二十位');
        $('#username').focus();
        return false;
    }
    var pattern = /[<>\'\"\\   ]/;
    if(pattern.test( $('#username').val() )){
        alert('用户名不能包含特殊字符');
        $('#username').focus();
        return false;
    }
    //密码
    if($('#password').val().length<6){
        alert('密码不能小于6位');
        $('#password').focus();
        return false;
    }
    if($('#password').val() != $('#notpassword').val()){
        alert('两次密码不一致');
        $('#notpassword').focus();
        return false;
    }
    if($('#question').val().length<2 || $('#question').val().length>50){
        alert('密码提示不能小于两位或者大于五十位');
        $('#question').focus();
        return false;
    }
    if($('#answer').val() ===$('#question').val()){
        alert('密码提示和密码答案不能一样');
        $('#answer').focus();
        return false;
    }
    if (!$('#email').val()) {
        alert('邮箱未填');
        $('#email').focus();
        return false;
    } else {
        var pattern = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
        if (!pattern.test($('#email').val())) {
            alert('邮箱错误');
            $('#email').focus();
            return false;
        }
    }
    if($('#qq').val()){
        var pattern = /[1-9][0-9]{4,}/;
        if(!pattern.test($('#qq').val())){
            alert('QQ错误');
            return false;
        }
    }
    if($('#yzm').val()=='' ||$('$id').val().length!=4){
        alert('验证码必须为4位');
        return false;
    }
})

