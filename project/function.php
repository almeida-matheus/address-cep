<?php

class Address
{
    private $mysql;
    //recebe o valor e atribui a private $mysql
    public function __construct(mysqli $mysql)
    {
        $this->mysql = $mysql;
    }

    public function exibirTodos(): array
    {

        $resultado = $this->mysql->query('SELECT id, nome, cep, estado, cidade, rua, numero FROM address');
        $addresses = $resultado->fetch_all(MYSQLI_ASSOC);

        return $addresses;
    }
}
