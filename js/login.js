$("#code").click(function () {
    $("#code").attr("src", "/captcha.php?time=" + new Date().getTime());
});
$("form").submit(function () {
    $.ajax({
        type: "POST",
        url: "/user/login.php",
        data: {name: $("#name").val(), pwd: $("#pwd").val(), captcha: $("#captcha").val()},
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