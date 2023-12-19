<?php 
session_start();
if (!isset($_SESSION['Num_Utilizador'])) { header('location: index.php'); exit; }
include "adicionalmente/config.php" ?>
<?php include "adicionalmente/head.php" ?>
<title>Visualizar Reservas</title>
</head>
<style>
    body,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: "Raleway", sans-serif
    }
</style>


<body class="w3-light-grey w3-content" style="max-width:2000px">
    <?php include "adicionalmente/header.php" ?>
    <!-- !PAGE CONTENT! -->
    <div class="w3-main" style="margin-left:300px">
        <header id="portfolio" class="w3-main w3-light-grey">
            <a href="#"><img src="imagens/logo.jpg" style="width:65px;" class=" w3-right w3-margin w3-hide-large w3-hover-opacity"></a>
            <span class="w3-button w3-hide-large w3-xxlarge w3-hover-text-grey" onclick="w3_open()"><i class="fa fa-bars"></i></span>
            <div class="w3-container w3-bottombar">
                <h1><b>Ver Pedido</b></h1>
            </div>
        </header>


        <div class="container">
           
            <?php

            $NumReserva = $_GET["codigo"];

            $sql_reservas = "SELECT * FROM Reservas where NumReserva=$NumReserva";
            $result_reservas = mysqli_query($conn, $sql_reservas);
            $row_reservas = mysqli_fetch_assoc($result_reservas); ?>
            <form action="">
                <input type="hidden" id="NumReserva" value="<?php echo $row["NumReserva"]; ?>" readonly>
                <br>
                <div class="row mb-4">
                    <div class="col">

                        <div class="form-outline">
                            <label class="form-label">Primeiro Nome</label>
                            <input type="text" id="Nome" class="form-control" value="<?php echo $row_reservas["Nome"]; ?>" readonly />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline">
                            <label class="form-label">Apelido</label>
                            <input type="text" id="Apelido" class="form-control" value="<?php echo $row_reservas["Apelido"]; ?>" readonly />
                        </div>
                    </div>
                </div>
                <!-- Email input -->
                <div class="form-outline mb-4">
                    <label class="form-label">Email</label>
                    <input type="email" id="Email_Reservante" class="form-control" value="<?php echo $row_reservas["Email_Reservante"]; ?>" readonly />
                </div>

                <!-- Text input -->
                <div class="form-outline mb-4">
                    <label class="form-label">N.º Cartão</label>
                    <input type="text" id="NrCartao" class="form-control" value="<?php echo $row_reservas["NrCartao"]; ?>" readonly />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label">Duração Prevista de Entrega</label>
                    <input type="text" id="Data_prevfim" class="form-control" value="<?php echo $row_reservas["Data_prevfim_reserva"]; ?> dias" readonly />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label">Quantidade</label>
                    <input type="number" id="Quantidade_emprestimo" class="form-control" value="<?php echo $row_reservas["Quantidade_reserva"]; ?>" readonly />
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <div class="form-outline mb-4">
                            <label class="w3-tamanho18 form-label">Ano</label>
                            <select class="w3-select" id="Ano">
                                <?php
                                $dados = [];
                                $i = 0;

                                do {
                                    $dados[$i] = $row_reservas;
                                    $i++;
                                    ?>
                                
                                    <option value="<?php echo $row_reservas['Ano']; ?>" <?php if ($row_reservas["Ano"] == $row_reservas['Ano']) echo "selected"; ?>><?php echo $row_reservas['Ano']; ?></option>
                                <?php
                                } while ($row_reservas = mysqli_fetch_assoc($result))
                                ?>
                            </select>

                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="form-outline mb-4">
                            <label class="w3-tamanho18 form-label" for="form6Example5">Curso</label>
                            <select class="w3-select" id="Curso">
                                <?php
                                foreach ($dados as $row_reservas) { ?>
                                    <option value="<?php echo $row_reservas['Curso']; ?>" <?php if ($row_reservas["Curso"] == $row_reservas['Curso']) echo "selected"; ?>><?php echo $row_reservas['Curso']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div id="Turma">
                            <div class="form-outline mb-4">
                                <label class="w3-tamanho18 form-label" for="form6Example7">Turma</label>
                                <select class="w3-select" id="Turma">
                                    <?php
                                    foreach ($dados as $row_reservas) { ?>
                                        <option value="<?php echo $row_reservas['Turma']; ?>" <?php if ($row_reservas["Turma"] == $row_reservas['Turma']) echo "selected"; ?>><?php echo $row_reservas['Turma']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <?php
            include "adicionalmente/close.php";
            ?>
            <div class="footer">
                <a href="lista_reservas.php" type="submit" class="btn btn-primary" style="margin-top: 0%; margin-bottom:0%" data-dismiss="modal" aria-label="Close">Voltar</a>
            </div>
        </div>

        <br>
    </div>

</body>

</html>