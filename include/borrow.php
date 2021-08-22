<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tools/Is_Login.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tools/Get_Id.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/User.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/Book.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/tools/DBTool.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/tools/Is_Login.php';
if (is_login()) {
    if (isset($_POST['bId'])) {
        $status = 300;
        if (is_login()) {
            $bId = $_POST['bId'];
            $uid = get_id();
            $user = new User();
            $user->setAll($uid);
            $b = $user->getBook();
            if ($b !== null) {
                $text = "你已经借了一本书，请归还后再借";
            } else if ($b == $bId) {
                $text = "你已借过这本书，请不要重复借书";
            } else {
                $book = new Book();
                $book->setAll($bId);
                $amount = $book->getAmount();
                if ($amount < 1) {
                    $text = "书已经被借完了";
                } else {
                    $history = $user->getHistory();
                    if ($history == null) {
                        $his = $bId;
                    } else {
                        $his = "";
                        foreach ($history as $val) {
                            $his .= ("," . $val);
                        }
                    }
                    $db = new DBTool();
                    $sql1 = "update user set book=? , borrowing_time=? , history=? where id=?";
                    $db->executeUpdate($sql1, array($bId, date("Y-m-d"), $his, $uid));

                    $sql2 = "update book set amount=amount-1 where id=?";
                    $db->executeUpdate($sql2, array($bId));

                    $sql3 = "insert into borrowing_log (book_id,user_id,time) VALUES (?,?,?)";
                    $db->executeUpdate($sql3, array($bId, $uid, date("Y-m-d")));

                    $status = 200;
                    $text = "借书成功";
                    $db->close();
                }
            }
        } else {
            $status = 400;
            $text = "你还未登录，请登录后再试";
        }
        echo json_encode(array("status" => $status, 'text' => $text));
    }
}
?>