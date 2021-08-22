$("input[type='button']").click(function () {
    $.ajax({
        url:'/include/newBook.php',
        type: 'POST',
        data:new FormData($("form")[0]),
        processData: false,
        contentType: false,
        dataType:'json',
        success: function(data) {
            alert(data['text']);
            if (data['status'] == 200) {
                parent.location.reload()
            } else {
                location.reload()
            }
        }
    })
});