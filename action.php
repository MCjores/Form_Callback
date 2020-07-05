<?php

/**/
$msg_box = ""; // в этой переменной будем хранить сообщения формы
$errors = array(); // контейнер для ошибок
$isResult = 0;  //булево зн. об успешной регистрации

$users_mails = array('qwer@mail.ru', 'qw@mail.ru', 'qwe@mail.ru', 'biznesgeorg@gmail.com');

// проверяем password
if ($_POST['repeat_password'] != $_POST['password']) $errors[] = "Пароли не совпадают";


// если форма без ошибок
if (empty($errors)) {

    $user = $_POST['e-mail'];
    if (in_array($user, $users_mails)) {
        $errors[] = "Пользователь с данным E-mail уже зарегистрирован";
        error_msg();
        $log = date('Y-m-d H:i:s') . " Пользователь $user пытался заново зарегистрироваться";
        file_put_contents(__DIR__ . '/log.txt', $log . PHP_EOL, FILE_APPEND);
    } else {
        $msg_box = "Вы зарегистрированы";
        array_push($users_mails, $_POST['e-mail']);

        $log = date('Y-m-d H:i:s') . " Добавлен новый пользователь: $user";
        file_put_contents(__DIR__ . '/log.txt', $log . PHP_EOL, FILE_APPEND);

        $isResult = 1;
    }

} else {
    // если были ошибки, то выводим их
    error_msg();
}

// делаем ответ
echo json_encode(array(
        'isResult' => $isResult,
        'result' => $msg_box

    )
);


// функция вывода ошибок
function error_msg()
{
    global $msg_box;
    global $errors;

    $msg_box = "";
    foreach ($errors as $one_error) {
        $msg_box .= "$one_error";
    }
}



