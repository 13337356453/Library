$iframe=$("iframe");
$(function(){
    $('#menu h2').on('click', function(){
        $(this).next('ul').slideToggle();
    })
});
$("#out").click(function () {
    var date=new Date();
    date.setTime(date.getTime()-10000);
    var keys=document.cookie.match(/[^ =;]+(?=\=)/g);
    if (keys) {
        for (var i =  keys.length; i--;)
            document.cookie=keys[i]+"=0; expire="+date.toGMTString()+"; path=/";
    }
    location.reload();
});

$("li,#power").click(function () {
        $("#userBody>h2").css("display",'none');
    }
);

$("#msg").click(function () {
    $iframe.attr('src','/include/userSetting.php');
    $iframe.css('display','block');
});

$("#borrow").click(function () {
    $iframe.attr('src','/include/borrowBook.php');
    $iframe.css('display','block');
});
$("#history").click(function () {
    $iframe.attr('src','/include/readHistory.php');
    $iframe.css('display','block');
});
$("#power").click(function () {
    $iframe.attr('src','/include/powerManager.php');
    $iframe.css('display','block');
});
$("#librarian").click(function () {
    location.href="/librarian/index.php";
});