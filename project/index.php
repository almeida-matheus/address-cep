<?php

require 'config.php';
require 'function.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //! FUNÇÃO PARA EXIBIR TODAS LINHAS
    $address = new Address($mysql);
    $addresses = $address->exibirTodos();
    $qntLine = count($addresses);

    // echo "<pre>";
    // echo count($addresses);
    // echo "</pre>";
    // if ((!is_numeric(isset($_GET['input_search']))) && (isset($_GET['input_search']))) {
    // if (!is_numeric($_GET['input_search']) && $_GET['input_search'] ) {
    //! FUNÇÃO PARA EXIBIR LINHAS Q TEM O CEP = PESQUISA
    if (isset($_GET['input_search'])) {
        //* checa se digitou numero
        if (is_numeric($_GET['input_search'])) {
            $address = new Address($mysql);
            $addresses = $address->exibirPesquisa("%{$_GET['input_search']}%");
            $qntLine = count($addresses);
        } 
        else {
            echo "<script>alert('Somento números são aceitos')</script>";
            echo "<script>alertMessage('Somento números são aceitos')</script>";
            echo "<script type='text/javascript' src='./js/scripts.js'>alertMessage('Somento números são aceitos');</script>";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //! FUNÇÃO ADICIONAR UMA LINHA
    // if ($_POST['input_add'] === "Submit") {
    if ($_POST['input_add']) {
        $address_send = new Address($mysql);
        $address_send->adicionar($_POST['nome'], $_POST['cep'], $_POST['rua'], $_POST['numero'],$_POST['cidade'], $_POST['estado']);
    }
    //! FUNÇÃO PARA REMOVER UMA LINHA
    if ($_POST['input_remove']) {
        $address_remove = new Address($mysql);
        $address_remove->remover($_POST['input_remove']);
    }

    header('Location: index.php');
    die();
}

?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <title>Agenda</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <!-- CSS customizedo-->
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <header class="all-navbar">
        <div class="container">
            <nav class="navbar">
                <a class="navbar-brand pr-0 mr-0" onclick = "reloadPage()">
                    <i class="far fa-address-card"></i>
                    address cep
                </a>
            </nav>
        </div>
    </header>

    <!-- Page Content -->
    <div class="container">

        <!-- <h1 class="mt-5">CADASTRO DE ENDEREÇO</h1> -->

        <a href="#" onclick="Modal.open()" class="button new add__btn">
            <i class="far fa-address-card"></i>&nbsp;
            NOVO ENDEREÇO
        </a>

        <form method="get" action="index.php">
            <div class="input-group mt-5 mb-3">
                <input type="search" class="form-control bg-light" placeholder="Pesquise pelo nome"
                    aria-label="pesquisar contato" aria-describedby="button-addon" name="input_search">
                <div class="input-group-append">
                    <button class="btn search__btn" type="submit" id="button-addon">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>

        <h4 class="text-primary mb-0 mt-4 "><span><?php echo $qntLine; ?></span> endereços encontrados</h4>

        <!--! TABLE -->
        <section id="table-overflow">
            <table id="tbl" class="content-table">
                <thead>
                    <tr>
                        <!-- <th>ID</th> -->
                        <th>Nome</th>
                        <th>CEP</th>
                        <th>Estado</th>
                        <th>Cidade</th>
                        <th>Rua</th>
                        <th>Número</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($addresses as $address) : ?>
                    <tr>
                        <!-- <td>{{ contato.id }}</td> -->
                        <td><?php echo $address['nome']; ?></td>
                        <td><?php echo $address['cep']; ?></td>
                        <td><?php echo $address['estado']; ?></td>
                        <td><?php echo $address['cidade']; ?></td>
                        <td><?php echo $address['rua']; ?></td>
                        <td><?php echo $address['numero']; ?></td>
                        <td>
                        <form action="index.php" method="post">
                            <input type="hidden" name="input_remove" value="<?php echo $address['id']; ?>">
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </div>
    <!--! [MODAL]-->
    <div class="modal1-overlay">
        <div class="modal1">
            <div id="form">
                <h3>Novo Endereço</h3>
                <!-- <form action="" onsubmit="Form.submit(event)"> -->
                <!-- <form class="form-card" onsubmit="return validate(0)"> -->
                <!-- onsubmit="createLine(nome.value, cep.value, rua.value, numero.value, cidade.value, estado.value)" -->
                <form action="index.php" method="post" id="form" class="form-card">
                    <div class="row justify-content-between text-left mt-5">

                        <div class="form-group col-sm-12 flex-column d-flex">
                            <label for="nome" class="form-control-label mb-0 px-1">Nome<span class="text-danger">
                                    *</span>
                            </label>
                            <input id="nome" type="text" name="nome" placeholder="..." maxlength="100" required>
                        </div>
                        <!-- onblur="validate(1)"  -->
                    </div>

                    <div class="row justify-content-start text-left">
                        <div class="form-group col-sm-6 flex-column d-flex">
                            <label for="cep" class="form-control-label mb-0 px-1">CEP<span class="text-danger"> *</span>
                            </label>
                            <div class="input-group">
                                <input id="cep" type="text" name="cep" class="form-control" maxlength="8" pattern="\d*"
                                    title="Somente números são permitidos" placeholder="..." aria-label="CEP"
                                    aria-describedby="button-addon2" required>
                                <div class="input-group-append">
                                    <button class="cep__btn btn btn-primary text-white" type="button"
                                        id="button-addon2">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-between text-left">

                        <div class="form-group col-sm-9 flex-column d-flex">
                            <label for="rua" class="form-control-label mb-0 px-1">Rua<span class="text-danger"> *</span>
                            </label>
                            <input id="rua" type="text" name="rua" placeholder="..." required>
                        </div>

                        <div class="form-group col-sm-3 flex-column d-flex">
                            <label for="numero" class="form-control-label mb-0 px-1">N°<span class="text-danger">
                                    *</span>
                            </label>
                            <input id="numero" name="numero" pattern="\d*" title="Somente números são permitidos"
                                placeholder="..." maxlength="6" required>
                        </div>

                    </div>

                    <div class="row justify-content-between text-left">
                        <div class="form-group col-sm-9 flex-column d-flex">
                            <label for="cidade" class="form-control-label mb-0 px-1">Cidade<span class="text-danger">
                                    *</span>
                            </label>
                            <input id="cidade" type="text" name="cidade" placeholder="..." maxlength="100" required>
                        </div>
                        <div class="form-group col-sm-3 flex-column d-flex">
                            <label for="estado" class="form-control-label mb-0 px-1">UF<span class="text-danger">
                                    *</span>
                            </label>
                            <select name="estado" type="text" id="estado" class="form-control" maxlength="2" required>
                                <option value="AC">AC</option>
                                <option value="AL">AL</option>
                                <option value="AM">AM</option>
                                <option value="AP">AP</option>
                                <option value="BA">BA</option>
                                <option value="CE">CE</option>
                                <option value="DF">DF</option>
                                <option value="ES">ES</option>
                                <option value="GO">GO</option>
                                <option value="MA">MA</option>
                                <option value="MG" selected>MG</option>
                                <option value="MT">MT</option>
                                <option value="MS">MS</option>
                                <option value="PA">PA</option>
                                <option value="PB">PB</option>
                                <option value="PE">PE</option>
                                <option value="PI">PI</option>
                                <option value="PR">PR</option>
                                <option value="RJ">RJ</option>
                                <option value="RO">RO</option>
                                <option value="RN">RN</option>
                                <option value="RS">RS</option>
                                <option value="SC">SC</option>
                                <option value="SE">SE</option>
                                <option value="SP">SP</option>
                                <option value="TO">TO</option>
                            </select>
                        </div>
                    </div>

                    <div class="row justify-content-between action">
                        <div class="form-group col-sm-6">
                            <button onclick="Modal.close()" class="btn-block btn-danger">
                                Cancelar
                            </button>
                        </div>

                        <div class="form-group col-sm-6">
                            <input type="hidden" name="input_add" value="Submit">
                            <button type="submit" class="btn-block btn-success">Adicionar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--ALERT ERROR-->
    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <div class="alert-message">
            <i class="fas fa-exclamation-triangle"></i> <strong>Erro!</strong> Preencha todas as informações
        </div>
    </div>
    <!--// MODAL-->

    <script>
    function alertMessage(message){
        alert_message.parentElement.classList.add('active')
        alert_message.innerHTML = `<i class="fas fa-exclamation-triangle"></i> <strong>Erro!</strong> ${message}`
    }
    </script>
    <!-- Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
        crossorigin="anonymous"></script>
    <!-- Fontawesome -->
    <script src="https://kit.fontawesome.com/f0e17cbf2f.js" crossorigin="anonymous"></script>
    <!-- Javascript customizado -->
    <script src="./js/scripts.js"></script>
</body>

</html>