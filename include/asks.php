<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/tools/DBTool.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/User.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/tools/Is_Admin.php';
if (is_admin()) {
    if (isset($_POST['uid']) && isset($_POST['cls'])) {
        $cls = $_POST['cls'];
        $db = new DBTool();
        if ($cls === 'allow') {
            $db->executeUpdate("update user set power=1 where id=?", [$_POST['uid']]);
        }
        $db->executeUpdate("delete from power_ask where uid=?", [$_POST['uid']]);
        $text = "Success";
        echo json_encode(array('text' => $text));
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
                table {
                    width: 80%;
                }
            </style>
        </head>
        <body>
        <div id="box">
            <table border="1" cellspacing="0" align="center">
                <thead>
                <tr>
                    <th>用户名</th>
                    <th>时间</th>
                    <th>备注</th>
                    <th>是否同意</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $db = new DBTool();
                $sql = "select * from power_ask";
                $stmt = $db->executeQuery($sql, []);
                while ($row = $stmt->fetch()) {
                    $uid = $row['uid'];
                    $user = new User();
                    $user->setAll($uid);
                    echo "<tr><th>" . $user->getName() . "</th><th>" . $row['time'] . "</th><th>" . $row['remarks'] . "</th><th id='" . $uid . "'>
<input type='button' value='同意' class='allow'>
<input type='button' value='不同意' class='disallow'>
</th></tr>";
                }
                ?>

                </tbody>
            </table>
        </div>
        <script>
            $("input").click(function () {
                var uid = $(this).parent().attr('id');
                var cls = $(this).attr('class');
                $.ajax({
                    url: '/include/asks.php',
                    type: "POST",
                    data: {'uid': uid, 'cls': cls},
                    dataType: "JSON",
                    success: function (data) {
                        alert(data['text']);
                        location.reload();
                    }
                })
            })
        </script>
        </body>
        </html>
    <?php }
}?>