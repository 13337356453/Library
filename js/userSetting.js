$("input[type='button']").click(function () {
    $.ajax({
        url:"/include/userSetting.php",
        type: 'POST',
        data:new FormData($("form")[0]),
        processData: false,
        contentType: false,
        dataType:'json',
        success: function(data) {
            alert(data['text']);
            location.reload()

        }
    })
});

$("#show_p").click(function () {
    var input=$("#pwd");
    var type=input.attr('type');
    if (type=="password"){
        input.attr('type','text');
        $(this).attr('src','/images/noshow.png')
    }else {
        input.attr('type','password');
        $(this).attr('src','/images/show.png')
    }
});