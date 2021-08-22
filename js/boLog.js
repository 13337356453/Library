$(function () {
    var result;
    function getLog(row,offset) {
        // {'status':200,'data':[['manlu','Test','2021-08-18'],[],...]}
        $.ajax({
            url:"/include/borrowingLog.php",
            type:"GET",
            data:{"row":row,"offset":offset},
            dataType:"json",
            async:false,
            success:function (data) {
                if (data['status']==200){
                    result=data['data']
                }else {
                    result=null;
                }
            }
        })
    }
    function echoLog(list) {
        for (var i=0;i<list.length;i++){
            var o=list[i];
            var uname=o[0];
            var bname=o[1];
            var time=o[2];
            var backed=o[3];
            $("tbody").append("<tr><td>"+uname+"</td><td>"+bname+"</td><td>"+time+"</td><td>"+backed+"</td></tr>")
        }
    }
    var row=0,offset=15;
    getLog(row,offset);
    row+=20;
    offset=25;
    echoLog(result);
    $("#moreLog").click(function () {
        getLog(row,offset);
        row+=20;
        echoLog(result);
    });

    $(".search input[type='button']").click(function () {
        var key=$("#key").val();
        var i=$("select option:selected").val();
        $.ajax({
            url: "/include/borrowingLog.php",
            type: "POST",
            data: {'key':key,'i':i},
            dataType: "json",
            async: false,
            success:function (data) {
                if (data['status']==200){
                    $("tbody").empty();
                    echoLog(data['data'])
                }
            }
        })
    });
    $("select").change(function () {
        var selected=$(this).children('option:selected').val();
        if (selected==3){
            $("#key").attr('type','date');
        }else{
            $("#key").attr('type','text');
            $("#key").val("");
        }
    })
});