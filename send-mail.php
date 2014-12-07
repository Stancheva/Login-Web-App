<?php
mb_internal_encoding('UTF-8');

$to      = $_SESSION[email];
$subject = "Студенска Научна Сесия ТУ-Варна";
$message = "
Студенска Научна Сесия ТУ-Варна

Здравейте, $_SESSION[name]

Вашият входящ номер е $_SESSION[entering_number].
Студентски съвет към ТУ-Варна Ви моли да предоставите съответния номер на Вашите съавтори.


";

$headers = 'From: sc@tu-varna.bg';

mail($to,  '=?utf-8?B?'.base64_encode($subject).'?=', $message, $headers);
?>

