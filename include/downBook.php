<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/tools/DBTool.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/tools/Is_Librarian.php';

if (is_librarian()) {

    if (isset($_POST['bname'])) {
        $bname = $_POST['bname'];
        $status = 300;
        $db = new DBTool();
        $sql = "delete from book where name=?";
        $db->executeUpdate($sql, array($bname));
        $status = 200;
        $text = "下架成功";
        $db->close();
        echo json_encode(array("status" => $status, 'text' => $text));
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
                    font-size: 32px;
                }

                form div {
                    font-size: 20px;
                    border-bottom: 1px solid #000;
                    margin-top: 15px;
                }

                form div input {
                    font-size: 18px;
                }

                input[type='reset'] {
                    float: right;
                }
            </style>
        </head>
        <body>
        <h1>下架书籍</h1>
        <form>
            <div>
                <label for="bname">书名：</label>
                <input type="text" id="bname" placeholder="需要下架的书的书名">
            </div>
            <div>
                <div><input type="button" value="提交"><input type="reset" value="重置"></div>
            </div>
        </form>
        <script>
            $("input[type='button']").click(function () {
                var bname = $("#bname").val();
                var res = confirm("确认要删除 《" + bname + "》 吗");
                if (res) {
                    $.ajax({
                        url: '/include/downBook.php',
                        type: "POST",
                        data: {'bname': bname},
                        dataType: 'json',
                        success: function (data) {
                            alert(data['text']);
                            if (data['status'] == 200) {
                                parent.location.reload();
                            } else {
                                location.reload();
                            }
                        }
                    })
                }
            })
        </script>
        </body>
        </html>
    <?php }
}?>