<?php

$mysql = new mysqli('localhost', 'root', '', 'db_address');
$mysql->set_charset('utf8');

if ($mysql == FALSE) {
    echo "Erro na conexão";
}
