function getQueryString(name) {

    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return unescape(r[2]); return null;
}

$("#borrow").click(function () {
   $.ajax({
       url:"/include/borrow.php",
       type:"POST",
       data:{"bId":getQueryString("id")},
       dataType:"json",
       success:function (data) {
            alert(data['text']);
            if (data['status']==200){
                location.href="/user/index.php";
            }else if (data['status']==400){
                location.href="/user/login.php";
            }else {
                location.reload();
            }
       }
   })
});

$("input[type='button']").click(function () {
    $.ajax({
        url: "/include/comment.php",
        type: "POST",
        data: {"text":$("#c").val(),"bId":getQueryString("id")},
        dataType: "json",
        success:function (data) {
            alert(data['text']);
            if (data['status']==400){
                location.href="/user/login.php";
            }else {
                location.reload();
            }
        }
    })
});

$(".look_all").click(function () {
    location.href="/list/comments.html?id="+getQueryString("id");
});