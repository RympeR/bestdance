<?php
// Файлы phpmailer
require 'PHPMailer.php';
require 'SMTP.php';
require 'Exception.php';

// Переменные, которые отправляет пользователь


$mail = new PHPMailer\PHPMailer\PHPMailer();
try {
    $msg = "ok";
    $mail->isSMTP();   
    $mail->CharSet = "UTF-8";                                          
    $mail->SMTPAuth   = true;

    // Настройки вашей почты
    $mail->Host       = 'smtp.gmail.com'; // SMTP сервера GMAIL
    $mail->Username   = 'georg.rashkov@gmail.com'; // Логин на почте
    $mail->Password   = 'george09122000'; // Пароль на почте
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->setFrom('bestdancefest@gmail.com', 'YOUR NAME'); // Адрес самой почты и имя отправителя

    // Получатель письма
    $mail->addAddress('georg.rashkov@gmail.com');  
    // $mail->addAddress('youremail@gmail.com'); // Ещё один, если нужен

    // Прикрипление файлов к письму
if (!empty($_FILES['file_name']['name'][0])) {
    for ($ct = 0; $ct < count($_FILES['file_name']['tmp_name']); $ct++) {
        $uploadfile = tempnam(sys_get_temp_dir(), sha1($_FILES['file_name']['name'][$ct]));
        $filename = $_FILES['file_name']['name'][$ct];
        if (move_uploaded_file($_FILES['file_name']['tmp_name'][$ct], $uploadfile)) {
            $mail->addAttachment($uploadfile, $filename);
        } else {
            $msg .= 'Неудалось прикрепить файл ' . $uploadfile;
        }
    }   
}
if (!empty($_FILES['photo_name']['name'][0])) {
    for ($ct = 0; $ct < count($_FILES['photo_name']['tmp_name']); $ct++) {
        $uploadfile = tempnam(sys_get_temp_dir(), sha1($_FILES['photo_name']['name'][$ct]));
        $filename = $_FILES['photo_name']['name'][$ct];
        if (move_uploaded_file($_FILES['photo_name']['tmp_name'][$ct], $uploadfile)) {
            $mail->addAttachment($uploadfile, $filename);
        } else {
            $msg .= 'Неудалось прикрепить файл ' . $uploadfile;
        }
    }   
}

        // -----------------------
        // Само письмо
        // -----------------------
        $mail->isHTML(true);
    
        $mail->Subject = 'Заголовок письма';
        $mail->Body    = "nothing";


// Проверяем отравленность сообщения
if ($mail->send()) {
    echo "$msg";
} else {
echo "Сообщение не было отправлено. Неверно указаны настройки вашей почты";
}

} catch (Exception $e) {
    echo "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
}