<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/tools/Is_Admin.php';
if (is_admin()) {

    if (isset($_POST['sql'])) {
        $sql = $_POST['sql'];
        $result = "";
        try {
            $starttime = time();
            $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $o = $stmt->fetchAll();
            for ($i = 0; $i < count($o); $i++) {
                $result .= "| ";
                for ($j = 0; $j < (count($o[$i]) / 2); $j++) {
                    if ($o[$i][$j] == "") {
                        $result .= "null | ";
                    } else {
                        $result .= ($o[$i][$j] . " | ");
                    }
                }
                $result .= "<br>";
            }
            $endtime = time();
            $seconds = ($endtime - $starttime) / 1000;
            $result .= ("运行时间：" . $seconds . "秒");
            $stmt = null;
            $pdo = null;
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        echo json_encode(array('text' => $result));
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
            <style>
                #sqlInput {
                    width: 100%;
                    text-align: center;
                    font-size: 20px;
                    padding-bottom: 10px;
                    border-bottom: 1px solid black;
                }

                #sqlInput input {
                    font-size: 20px
                }

                #resultBox {
                    width: 100%;
                    font-size: 18px;
                    padding-left: 10px;
                    border-left: 1px solid #f00;
                    border-right: 1px solid #f00;
                }
            </style>
            <script src="/js/jquery.min.js"></script>
        </head>
        <body>
        <div id="sqlInput">
            <label for="sql">请输入SQL语句：</label>
            <input type="text" id="sql">
            <input type="button" id="execBtn" value="执行">
            <input type="button" value="清空" onclick="$('#resultBox p').html('')">
        </div>
        <div id="resultBox">
            <p>
                这里是执行结果
            </p>
        </div>
        <script>
            $("#execBtn").click(function () {
                var sql = $("#sql").val();
                $.ajax({
                    url: "/include/sql.php",
                    type: "POST",
                    data: {'sql': sql},
                    dataType: "json",
                    success: function (data) {
                        $('#resultBox').html(data['text'])
                    }
                })
            })
        </script>
        </body>
        </html>
    <?php }
}?>