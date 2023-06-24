<?php
//заполнение массива
$data = "Здравствуйте, давайте создадим объявление для обмена?:

 Задайте название для объявления:
 Укажите желаемый город для обмена:
 Создайте описание своего предмета:
 Укажите предмет, которому отдадите предпочтение при обмене:
 Добавти фотографию для объявления:
 Вы успешно создали объявление, вот так оно будет выглядить";
list($otv_hello, $otv_name_obiyv, $otv_gorod, $otv_opisani, $otv_zhel_predmet,$otv_photo,$otv_gotovo) = explode(":", $data);

$data2 = "1. Создать новновое объявление:2. Изменить название:3. Изменить описание:4. Изменить фото:5. Продолжить просмотр";
list($red_new, $red_name, $red_opis, $red_photo, $red_dalee) = explode(":", $data2);

$sql_ban = "SELECT `id_users` FROM `users` WHERE `chat_id` ='$chat_id' AND `gotovo` = 25 ";        
$sql_ban = sprintf($sql_ban,mysqli_real_escape_string($connect, $login));

$sql_start = "SELECT `id_users` FROM `users` WHERE `chat_id` ='$chat_id' AND `gotovo` = 1 ";
$sql_start = sprintf($sql_start,mysqli_real_escape_string($connect, $login));

$sql_user = "SELECT DISTINCT * FROM `users` WHERE `chat_id` != '$chat_id' ORDER BY RAND() ";
$sql_user_my = "SELECT * FROM `users` WHERE `chat_id` = '$chat_id'";

$sql_name = "SELECT * FROM `users` WHERE `chat_id` = '$chat_id' AND `name` = '/start'";
$sql_name = sprintf($sql_name);
$result_name = mysqli_query($connect, $sql_name);

$sql_city = "SELECT * FROM `users` WHERE `chat_id` = '$chat_id' AND `city` = '/start'";
$sql_city = sprintf($sql_city);
$result_city = mysqli_query($connect, $sql_city);

$sql_opis = "SELECT * FROM `users` WHERE `chat_id` = '$chat_id' AND `opis` = '/start'";
$sql_opis = sprintf($sql_opis);
$result_opis = mysqli_query($connect, $sql_opis);

$sql_item = "SELECT * FROM `users` WHERE `chat_id` = '$chat_id' AND `item` = '/start'";
$sql_item = sprintf($sql_item);
$result_item = mysqli_query($connect, $sql_item);

$sql_photo = "SELECT * FROM `users` WHERE `chat_id` = '$chat_id' AND `photo` = '/start'";
$sql_photo = sprintf($sql_photo);
$result_photo = mysqli_query($connect, $sql_photo);

$sql_add = "SELECT `id_users` FROM `users` WHERE `chat_id` ='$chat_id' AND `gotovo` = 1 ";
$sql_add = sprintf($sql_add,mysqli_real_escape_string($connect, $login));
$result_add = mysqli_query($connect, $sql_add);

$sql_one = "SELECT `id_users` FROM `users` WHERE `chat_id` ='$chat_id' AND `gotovo` = 1 ";        
$sql_one = sprintf($sql_one,mysqli_real_escape_string($connect, $login));
$result_one = mysqli_query($connect, $sql_one);

$sql_two = "SELECT `id_users` FROM `users` WHERE `chat_id` ='$chat_id' AND `gotovo` = 2 ";        
$sql_two = sprintf($sql_two,mysqli_real_escape_string($connect, $login));
$result_two = mysqli_query($connect, $sql_two);

$sql_free = "SELECT `id_users` FROM `users` WHERE `chat_id` ='$chat_id' AND `gotovo` = 3 ";        
$sql_free = sprintf($sql_free,mysqli_real_escape_string($connect, $login));
$result_free = mysqli_query($connect, $sql_free);

$sql_four = "SELECT `id_users` FROM `users` WHERE `chat_id` ='$chat_id' AND `gotovo` = 4 ";        
$sql_four = sprintf($sql_four,mysqli_real_escape_string($connect, $login));
$result_four = mysqli_query($connect, $sql_four);

$sql_message = "SELECT `id_users` FROM `users` WHERE `chat_id` ='$chat_id' AND `gotovo` = 10 ";        
$sql_message = sprintf($sql_message,mysqli_real_escape_string($connect, $login));
$result_message = mysqli_query($connect, $sql_message);
?>