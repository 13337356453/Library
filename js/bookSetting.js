$("#msg").click(function () {
    $.ajax({
        url:'/include/bookSetting.php',
        type:'GET',
        data:{'name':$("#name").val()},
        dataType:'json',
        success:function (data) {
            // {"status":200,"text":"获取成功","data":["Test",10,"TestInfo","/images/test.jpg"]}
            if (data['status']==200){
                $("input[name='bname']").val(data['data'][0]);
                $("input[name='amount']").val(data['data'][1]);
                $("textarea[name='info']").val(data['data'][2]);
                $("#bimg").attr('src',data['data'][3]);
            }else{
                alert(data['text']);
                $("#name").val("");
            }
        }
    })
});

$("#save").click(function () {
    $.ajax({
        url: "/include/bookSetting.php",
        type: 'POST',
        data:new FormData($(".x")[0]),
        processData: false,
        contentType: false,
        dataType: "json",
        success:function (data) {
            alert(data['text']);
            location.reload();
        }
    })
});