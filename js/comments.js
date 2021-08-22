$(function () {
    var result;
    function getQueryString(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
        var r = window.location.search.substr(1).match(reg);
        if (r != null) return unescape(r[2]); return null;
    }
    function getComment(id,row,offset) {
        // {'status':200,'data':[['manlu','/images/userhead.jpg','Good'],[],...]}

        $.ajax({
            url: "/include/comments.php",
            type: "GET",
            data: {"id": id, "row": row, "offset": offset},
            dataType: "json",
            async:false,
            success: function (data) {
                if (data['status'] == 200) {
                    result=data['data'];
                } else {
                    result=null;
                }
            }
        })
    }
    function echoComment(list) {
        for (var i=0; i<list.length; i++){
            var o=list[i];
            var name=o[0];
            var head=o[1];
            var content=o[2];
            $(".comments").append("<div class='c'><img src='"+head+"' alt='"+name+"'><div class='p'><span class='uname'>"+name+"</span><span class='content'>"+content+"</span></div></div>")
        }
    }
    var bId=getQueryString("id");
    var row=0;
    var offset=20;
    getComment(getQueryString('id'),row,offset);
    row+=20;
    echoComment(result);
    $("#look_more").click(function () {
        getComment(bId,row,offset);
        row+=20;
        echoComment(result);
    })
});