$("#code").click(function () {
    $("#code").attr("src", "/captcha.php?time=" + new Date().getTime());
});
$("form").submit(function () {
    $.ajax({
        type: "POST",
        url: "/user/reg.php",
        data: {name: $("#name").val(), pwd: $("#pwd").val(),pwd_2:$("#pwd_2").val(), captcha: $("#captcha").val()},
        dataType: "json",
        success: function (data) {
            alert(data['text']);
            if (data['status'] == 200) {
                location.href = "/user/index.php";
            } else {
                $("#code").click();
            }
        }
    })
});