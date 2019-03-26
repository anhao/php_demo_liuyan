$('.del').click(function () {
    if(confirm('确认删除吗?')){
        location.href='?action=delete&id='+$(this).attr('name');
    }else{
        return false;
    }
})
$('#all').click(function () {
    //prop() :可以取得元素的checked，如果有返回true,否则false
    if($('.all-del').find(':checkbox').prop('checked')){
        $('.all-del').find(':checkbox').prop('checked',false)
    }else{
        $('.all-del').find(':checkbox').prop('checked',true)
    }
})
$('.all-del').submit(function () {

})