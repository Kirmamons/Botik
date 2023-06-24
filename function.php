<?php
require_once 'connect.php';

function add() {
$sql_user = "SELECT DISTINCT * FROM `users` WHERE `chat_id` != '$chat_id' ORDER BY RAND() ";
        while($row = $result_user->fetch_assoc())
        {
            $chat_user_id = $row["chat_id"];
            $ob_name = $row["name"];
            $ob_city = $row["city"];
            $ob_opis = $row["opis"];
            $ob_item = $row["item"];
            $ob_photo = $row["photo"];
        }
        $response = $telegram->sendPhoto([
            'chat_id' => $chat_id,
            'caption' => "<b>{$ob_name}</b>\n<b>{$ob_city}</b>\n\n{$ob_opis}\n\nПредпочтение: {$ob_item}",
            'photo' => $ob_photo,
            'parse_mode' => 'HTML',
            'reply_markup' => json_encode([
            'keyboard' => $treid_keyboard,
            'resize_keyboard' => true,
            'red_keyboard' => true,
            ])
            ]);
        $connect->query("UPDATE `users` SET `message` = '$chat_user_id' WHERE `users`.`chat_id` = '$chat_id'");
        return $response;
}


?>