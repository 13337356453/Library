$("input[type='button']").click(function () {
    $.ajax({
        url:'/include/powerManager.php',
        type:'POST',
        data:{'need':"I want to improve my authority",'remarks':$("#remarks").val()},
        dataType:'json',
        success:function (data) {
            alert(data['text']);
        }
    })
});