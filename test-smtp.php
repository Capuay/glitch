<?php
$host = 'sandbox.smtp.mailtrap.io';
$port = 587;

$connection = fsockopen($host, $port, $errno, $errstr, 10);

if (!$connection) {
    echo "Ошибка: $errstr ($errno)\n";
} else {
    echo "Соединение успешно установлено с $host:$port\n";
    fclose($connection);
}
