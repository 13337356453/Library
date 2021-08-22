<?php
// {'power':'0/1','id':'xx','name':'xx','pwd':'xx'}
function get_id()
{
    if (isset($_COOKIE['l_info'])) {
        $data = json_decode(base64_decode($_COOKIE['l_info']));
        $id = $data->id;
        return $id;
    }
    return null;
}

?>