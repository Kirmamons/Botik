<?php
//подключаем файл с клавиатурами
require_once "keyboard.php";
require_once "connect.php";
require_once "mas.php";


//подключение библиотеки
require_once __DIR__ . '/vendor/autoload.php';
use Telegram\Bot\Api;

//соединенние с сервером
$telegram = new Api('6229306155:AAFSrUAICTUuF-bAZgI0s0q5rSP4AV9Yuuw');
$update = $telegram->getWebhookUpdates();

file_put_contents(__DIR__ . '/logsss.txt', print_r($update, 1), FILE_APPEND);

//переменные для бота
$chat_id = $update['message']['chat']['id'];
$text = $update['message']['text'];
$username = $update['message']['from']['username'];
$name = $update['message']['from']['first_name'];
$photo = $update['message']['photo']['1']['file_id'];

    $sql_start = "SELECT `id_users` FROM `users` WHERE `chat_id` ='$chat_id' AND `gotovo` = 25 ";        
    $sql_start = sprintf($sql_start,mysqli_real_escape_string($connect, $login));
    $result_start = mysqli_query($connect, $sql_start);
    if(mysqli_num_rows($result_start) > 0){
    $response = $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => "{$name}, к сожалению Ваш профиль в бане, для уточнения причины свяжитись с @kirmamon",
    ]);  
    }else{
//приветсвенное создание объявления
if($text == '/start'){
                $response = $telegram->sendMessage([
                'chat_id' => $chat_id,
                'text' => "Здравствуйте, {$name}, давайте создадим первое объявление",
                'reply_markup' => json_encode([
                    'keyboard' => $new_obiy_keyboard,
                    'resize_keyboard' => true,
                    'red_keyboard' => true,
                    'one_time_keyboard' => true,
                ])
            ]);
}


//приветсвие и команда продолжить
if ($text == 'Создать объявление' OR $text == '5️⃣')
{
    $sql_start = "SELECT `id_users` FROM `users` WHERE `chat_id` ='$chat_id' AND `gotovo` = 1 ";
    $sql_start = sprintf($sql_start,mysqli_real_escape_string($connect, $login));
    $result_start = mysqli_query($connect, $sql_start);
    if(mysqli_num_rows($result_start) > 0) 
    {
        $sql_user = "SELECT DISTINCT * FROM `users` WHERE `chat_id` != '$chat_id' ORDER BY RAND() ";
        if($result_user = $connect->query($sql_user))
        {   
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
        }
    }else
    {
        $response = $telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' => "{$otv_name_obiyv}",
        ]);
        $connect->query("INSERT INTO `users` (`chat_id`,`name`,`city`,`opis`,`item`,`photo`)
                        VALUES('$chat_id','/start','/start','/start','/start','/start')"); // добавление значений в бд
        $connect->close();
    }

}


//добавление название объявления
$sql_name = "SELECT * FROM `users` WHERE `chat_id` = '$chat_id' AND `name` = '/start'";
$sql_name = sprintf($sql_name);
$result_name = mysqli_query($connect, $sql_name);
if(mysqli_num_rows($result_name) == 1)
{
    $connect->query("UPDATE `users` SET `name` = '$text' WHERE `users`.`chat_id` = '$chat_id'");        
    $response = $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => " {$otv_gorod}",
    ]);
    $connect->close();

}


//добавление города
$sql_city = "SELECT * FROM `users` WHERE `chat_id` = '$chat_id' AND `city` = '/start'";
$sql_city = sprintf($sql_city);
$result_city = mysqli_query($connect, $sql_city);
if(mysqli_num_rows($result_city) == 1)
{
    $connect->query("UPDATE `users` SET `city` = '$text' WHERE `users`.`chat_id` = '$chat_id'");        
    $response = $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => " {$otv_opisani}",
    ]);
    $connect->close();

}


//добавление описания
$sql_opis = "SELECT * FROM `users` WHERE `chat_id` = '$chat_id' AND `opis` = '/start'";
$sql_opis = sprintf($sql_opis);
$result_opis = mysqli_query($connect, $sql_opis);
if(mysqli_num_rows($result_opis) == 1)
{
    $connect->query("UPDATE `users` SET `opis` = '$text' WHERE `users`.`chat_id` = '$chat_id'");        
    $response = $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => " {$otv_zhel_predmet}",
    ]);
    $connect->close();

}


//добавление предмета на обмен
$sql_item = "SELECT * FROM `users` WHERE `chat_id` = '$chat_id' AND `item` = '/start'";
$sql_item = sprintf($sql_item);
$result_item = mysqli_query($connect, $sql_item);
if(mysqli_num_rows($result_item) == 1)
{
    $connect->query("UPDATE `users` SET `item` = '$text' WHERE `users`.`chat_id` = '$chat_id'");        
    $response = $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => " {$otv_photo}",
    ]);
    $connect->close();

}

//добавление фото
$sql_photo = "SELECT * FROM `users` WHERE `chat_id` = '$chat_id' AND `photo` = '/start'";
$sql_photo = sprintf($sql_photo);
$result_photo = mysqli_query($connect, $sql_photo);
if(mysqli_num_rows($result_photo) == 1)
{

    $connect->query("UPDATE `users` SET `photo` = '$photo' WHERE `users`.`chat_id` = '$chat_id'");  
    $connect->query("UPDATE `users` SET `gotovo` = 1 WHERE `users`.`chat_id` = '$chat_id'");       
    $response = $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => "Вы заполнили все данные",
    ]);
    $connect->close();

    $response = $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => "Просмотр и редактирование объявления доступно по команде /my_add. Выкладывать можно только одно объявление, если вы захотите поменять другу вещь, то просто выложите новое объявление.",
    ]);
}

//команда help
if($text == '/help'){
    $response = $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => "Краткое руководство:\n
❤️ -Информирует владельца пользователя, которому вы поставили  ❤️, о том, что Вы заинтересованы в обмене. Пользователь получит Ваше объявление и ссылку на Вашу страничку в Телеграм.\n
✉️ - Позволяет отправить сообщение владельцу объявления через бота, после отправки повторится информация из команды ❤️\n
👎 -после нажатия на кнопку, генерируется новое объявление.\n
🚪 -выход из ленты в мои объявления.
По вопросам и предложениям оброщайтесь к @kirmamon",

    ]);
}



//показ моего объявления
if($text=='/my_add' OR $text =='🚪')
{

    $sql_start = "SELECT `id_users` FROM `users` WHERE `chat_id` ='$chat_id' AND `gotovo` = 1 ";
    $sql_start = sprintf($sql_start,mysqli_real_escape_string($connect, $login));
    $result_start = mysqli_query($connect, $sql_start);
    if(mysqli_num_rows($result_start) > 0) 
    {
        $sql_user = "SELECT * FROM `users` WHERE `chat_id` = '$chat_id'";
        if($result_user = $connect->query($sql_user))
        {   
            while($row = $result_user->fetch_assoc())
            {
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
            $response = $telegram->sendMessage([
                'chat_id' => $chat_id,
                'text' => "{$red_new}\n{$red_name}\n{$red_opis}\n{$red_photo}\n{$red_dalee}",
                'reply_markup' => json_encode([
                    'keyboard' => $red_keyboard,
                    'resize_keyboard' => true,
                    'red_keyboard' => true,
                    'one_time_keyboard' => true,
                ])
            ]);
        }
    }else
    {
        $response = $telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' => "Чтобы создать объявление, введите /start",
        ]);
    }

}

//создание нового объявления
if($text=='1️⃣')
{   

    $response = $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => "создаем новое объявление",
    ]); 
    $response = $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => "Введите название для объявления",
    ]); 
    $connect->query("UPDATE `users` SET `name` = '/start' WHERE `users`.`chat_id` = '$chat_id'");
    $connect->query("UPDATE `users` SET `city` = '/start' WHERE `users`.`chat_id` = '$chat_id'");
    $connect->query("UPDATE `users` SET `opis` = '/start' WHERE `users`.`chat_id` = '$chat_id'");
    $connect->query("UPDATE `users` SET `item` = '/start' WHERE `users`.`chat_id` = '$chat_id'");
    $connect->query("UPDATE `users` SET `photo` = '/start' WHERE `users`.`chat_id` = '$chat_id'");
    $connect->query("UPDATE `users` SET `gotovo` = 6 WHERE `users`.`chat_id` = '$chat_id'");

}else{

    $sql_start = "SELECT `id_users` FROM `users` WHERE `chat_id` ='$chat_id' AND `gotovo` = 1 ";        
    $sql_start = sprintf($sql_start,mysqli_real_escape_string($connect, $login));
    $result_start = mysqli_query($connect, $sql_start);
    if(mysqli_num_rows($result_start) > 0) 
    {



        $connect->query("UPDATE `users` SET `gotovo` = 1 WHERE `users`.`chat_id` = '$chat_id'");

    }
}


//редактирование названия объявления
if($text=='2️⃣')
{   

    $response = $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => "Введите новое название объявления",
    ]); 

    $connect->query("UPDATE `users` SET `gotovo` = 2 WHERE `users`.`chat_id` = '$chat_id'");

}else{

    $sql_start = "SELECT `id_users` FROM `users` WHERE `chat_id` ='$chat_id' AND `gotovo` = 2 ";        
    $sql_start = sprintf($sql_start,mysqli_real_escape_string($connect, $login));
    $result_start = mysqli_query($connect, $sql_start);
    if(mysqli_num_rows($result_start) > 0) 
    {

        $connect->query("UPDATE `users` SET `name` = '$text' WHERE `users`.`chat_id` = '$chat_id'");

        $connect->query("UPDATE `users` SET `gotovo` = 1 WHERE `users`.`chat_id` = '$chat_id'");

        $response = $telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' => "успешно /my_add",
        ]);

    }
}



//создание нового объявления
if($text=='3️⃣')
{   

    $response = $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => "Введите новое описание для объявления",
    ]); 

    $connect->query("UPDATE `users` SET `gotovo` = 3 WHERE `users`.`chat_id` = '$chat_id'");

}else{

   $sql_start = "SELECT `id_users` FROM `users` WHERE `chat_id` ='$chat_id' AND `gotovo` = 3 ";        
   $sql_start = sprintf($sql_start,mysqli_real_escape_string($connect, $login));
   $result_start = mysqli_query($connect, $sql_start);
   if(mysqli_num_rows($result_start) > 0) 
   {

    $connect->query("UPDATE `users` SET `opis` = '$text' WHERE `users`.`chat_id` = '$chat_id'");

    $connect->query("UPDATE `users` SET `gotovo` = 1 WHERE `users`.`chat_id` = '$chat_id'");

    $response = $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => "успешно /my_add",
    ]);
}
}




if($text=='4️⃣')
{   

    $response = $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => "загрузите фотографию",
    ]); 

    $connect->query("UPDATE `users` SET `gotovo` = 4 WHERE `users`.`chat_id` = '$chat_id'");

}else{

    $sql_start = "SELECT `id_users` FROM `users` WHERE `chat_id` ='$chat_id' AND `gotovo` = 4 ";        
    $sql_start = sprintf($sql_start,mysqli_real_escape_string($connect, $login));
    $result_start = mysqli_query($connect, $sql_start);
    if(mysqli_num_rows($result_start) > 0) 
    {

        $connect->query("UPDATE `users` SET `photo` = '$text' WHERE `users`.`chat_id` = '$chat_id'");

        $connect->query("UPDATE `users` SET `gotovo` = 1 WHERE `users`.`chat_id` = '$chat_id'");

        $response = $telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' => "успешно /my_add",
        ]);
    }
}



//обработка кнопки лайк
if($text=='❤️')
{   


//отправка уведомления пользователю и объявление
        $sql_user = "SELECT * FROM `users` WHERE `chat_id` = '$chat_id'";
        if($result_user = $connect->query($sql_user))
        {   
            while($row = $result_user->fetch_assoc())
            {
                $chat_user_id = $row["message"];
                $ob_name = $row["name"];
                $ob_city = $row["city"];
                $ob_opis = $row["opis"];
                $ob_item = $row["item"];
                $ob_photo = $row["photo"];
            }
        $response = $telegram->sendPhoto([
            'chat_id' => $chat_user_id,
            'caption' => "<b>{$ob_name}</b>\n<b>{$ob_city}</b>\n\n{$ob_opis}\n\nПредпочтение: {$ob_item}",
            'photo' => $ob_photo,
            'parse_mode' => 'HTML',
            'reply_markup' => json_encode([
            'keyboard' => $treid_keyboard,
            'resize_keyboard' => true,
            'red_keyboard' => true,
            ])
            ]);
        $response = $telegram->sendMessage([
            'chat_id' => $chat_user_id,
            'text' => "Ваше объявление понравилось пользователю. Если вы согласн с ним обменяться, то просто напешите ему и договоритесь во встрече. Контак @{$username}",
        ]);
        }



//генерация объявлений в ленте
    $sql_user = "SELECT DISTINCT * FROM `users` WHERE `chat_id` != '$chat_id' ORDER BY RAND() ";
    if($result_user = $connect->query($sql_user))
    {   
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
        
    }
}





//обработка кнопки сообщение
if($text=='✉️')
{   


    $response = $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => "Напишите сообщение пользователю",
    ]); 

    $connect->query("UPDATE `users` SET `gotovo` = 10 WHERE `users`.`chat_id` = '$chat_id'");
}
else{
//отправка сообщения и объявления пользвоателю
    $sql_start = "SELECT `id_users` FROM `users` WHERE `chat_id` ='$chat_id' AND `gotovo` = 10 ";        
    $sql_start = sprintf($sql_start,mysqli_real_escape_string($connect, $login));
    $result_start = mysqli_query($connect, $sql_start);
    if(mysqli_num_rows($result_start) > 0) 
    {
        $sql_user = "SELECT * FROM `users` WHERE `chat_id` = '$chat_id'";
        if($result_user = $connect->query($sql_user))
        {   
            while($row = $result_user->fetch_assoc())
            {
                $chat_user_id = $row["message"];
                $ob_name = $row["name"];
                $ob_city = $row["city"];
                $ob_opis = $row["opis"];
                $ob_item = $row["item"];
                $ob_photo = $row["photo"];
            }
        $response = $telegram->sendPhoto([
            'chat_id' => $chat_user_id,
            'caption' => "<b>{$ob_name}</b>\n<b>{$ob_city}</b>\n\n{$ob_opis}\n\nПредпочтение: {$ob_item}",
            'photo' => $ob_photo,
            'parse_mode' => 'HTML',
            'reply_markup' => json_encode([
            'keyboard' => $treid_keyboard,
            'resize_keyboard' => true,
            'red_keyboard' => true,
            ])
            ]);
        }


        $response = $telegram->sendMessage([
            'chat_id' =>  $chat_user_id,
            'text' => "Сообщение от пользователя: {$text}",
        ]);

        $connect->query("UPDATE `users` SET `gotovo` = 1 WHERE `users`.`chat_id` = '$chat_id'");
//генерация объявления в ленте
        $sql_user = "SELECT DISTINCT * FROM `users` WHERE `chat_id` != '$chat_id' ORDER BY RAND() ";
        if($result_user = $connect->query($sql_user))
        {   
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
        }
    }
}



//обработка кнопки дизлайк
if($text=='👎')
{ 
//генерация объявления в ленте
    $sql_user = "SELECT DISTINCT * FROM `users` WHERE `chat_id` != '$chat_id' ORDER BY RAND() ";
    if($result_user = $connect->query($sql_user))
    {   
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
    }
}
}


//запись сообщений от бота
file_put_contents(__DIR__ . '/logss.txt', print_r($response, 1), FILE_APPEND);

?>