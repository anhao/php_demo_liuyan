let sned = $('.send').click(function () {
openWin('message.php?id='+$(this).attr('title'),'message',250,400);
});

function openWin(url, name, height, width) {
    let left=(screen.width-width)/2;
    let top=(screen.height-height)/2;
    open(url,name,'height='+height+',width='+width+',left='+left+',top='+top+'');
}

$('#code').click(function () {
    $(this).attr('src','code.php?tm='+Math.random());
})

$('.add').click(function () {
    openWin('friend.php?id='+$(this).attr('title'),'message',250,400);
})
$('.songhua').click(function(){
    openWin('flowers.php?id='+$(this).attr('title'),'message',250,400);
})