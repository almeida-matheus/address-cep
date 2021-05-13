<?php

class Address
{
    private $mysql;
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

    public function adicionar(string $nome, int $cep, string $rua, int $numero, string $cidade, string $estado): void
    {
        $insertAddress = $this->mysql->prepare('INSERT INTO address (nome, cep, estado, cidade, rua, numero) VALUES(?,?,?,?,?,?);');
        $insertAddress->bind_param('sisssi', $nome, $cep, $estado, $cidade, $rua, $numero);
        $insertAddress->execute();
    }
}
