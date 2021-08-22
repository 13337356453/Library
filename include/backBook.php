<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/tools/DBTool.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/tools/Is_Librarian.php';
if (is_librarian()) {
    if (isset($_POST['name'])) {
        $status = 300;
        $name = $_POST['name'];
        $db = new DBTool();
        $i = $db->executeQuery("select book from user where name=? limit 0,1", [$name])->fetchAll()[0]['book'];
        if ($i != null) {
            $db->executeUpdate("update user set book=NULL , borrowing_time=NULL where name=?", [$name]);
            $db->executeUpdate("update book set amount=amount+1 where id=?", [$i]);
            $status = 200;
            $text = "保存成功";
        } else {
            $text = "该用户未借书";
        }
        echo json_encode(array('status' => $status, 'text' => $text));
    } else {
        ?>
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport"
                  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title></title>
            <script src="/js/jquery.min.js"></script>
            <style>
                h1 {
                    font-size: 30px;
                }

                p {
                    font-size: 24px;
                    text-align: left;
                    border-bottom: 1px solid #000;
                }

                input {
                    font-size: 20px;
                }
            </style>
        </head>
        <body>
        <h1>设置用户还书</h1>
        <form>
            <p><label for="name">用户名：</label></p>
            <p><input type="text" id="name"></p>
            <p><input type="button" value="提交"></p>
        </form>
        <script>
            $('input[type="button"]').click(function () {
                var res = confirm("确认要让用户 " + $('#name').val() + " 还书吗");
                if (res) {
                    $.ajax({
                        url: '/include/backBook.php',
                        type: "POST",
                        data: {'name': $("#name").val()},
                        dataType: "json",
                        success: function (data) {
                            alert(data['text']);
                            location.reload();
                        }
                    })
                }
            })
        </script>
        </body>
        </html>
    <?php }
}?>