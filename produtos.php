<?php
session_start();
if (!isset($_SESSION['Num_Utilizador'])) {
    header('location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include "adicionalmente/config.php";

    session_start();
    if (!isset($_SESSION)) {
        header('location: index.php');
        exit;
    }


    // Informa se a variável $_POST foi iniciada
    // Retorna TRUE se variável existe; FALSE caso contrário.
    if (isset($_POST)) {
        $id = $_SESSION['Num_Utilizador'];
        //Acesso aos dados do formulário

        $tipo_reservante        =    $_POST["tipo_reservante"];
        $nome                   =    $_POST["nome"];
        $apelido                =    $_POST["apelido"];
        $email_reservante       =    $_POST["email_reservante"];
        $nrcartao               =    $_POST["nrcartao"];
        $data_prevfim           =    $_POST["data_prevfim"];
        $ano                    =    $_POST["ano"];
        $curso                  =    $_POST["curso"];
        $turma                  =    $_POST["turma"];
        $quantidade             =    $_POST["quantidade_emprestimo"];
        $Cod_Equipamento        =    $_POST["Cod_Equipamento"];
        //print_r($_POST); // Para testes - Mostrar os dados recebidos do $_POST

        // Query para a inserção de dados na BD
        try {

            $sql = "INSERT INTO Emprestimos (Cod_Equipamento, tipo_reservante, nome, apelido, email_reservante, nrcartao, data_prevfim, ano, curso, turma, quantidade_emprestimo, Num_Utilizador)
            VALUES ('$Cod_Equipamento','$tipo_reservante', '$nome', '$apelido', '$email_reservante', '$nrcartao', '$data_prevfim', '$ano', '$curso', '$turma', '$quantidade', '$id')";

            $query = "UPDATE Equipamentos Set Quantidade = Quantidade - $quantidade, Emprestimo_Ativo = Emprestimo_Ativo + $quantidade Where Cod_Equipamento = $Cod_Equipamento";

            // Executa a query e verifica se deu erro
            $conn->begin_transaction();
            if (!mysqli_query($conn, $sql)) throw new Exception();
            if (!mysqli_query($conn, $query)) throw new Exception();
            $conn->commit();
            //if (mysqli_query($conn, $sql) && mysqli_query($conn, $query)) {
            // Redirecionar para outra página
            header("location:lista_emprestimo.php?insere=1");
        } catch (Exception $e) {
            $conn->rollback();
            // Apresenta o erro
            //echo "Erro: " . $sql . "<br>" . mysqli_error($conn);


            echo "<script language='javascript' type='text/javascript' align='center'>
                    alert('Erro ao concluir Empréstimo; Razão: A quantidade inserida ultrapassa a quantidade de produtos disponiveis.');
                    window.location='produtos'; </script>";
        }
    }


    include "adicionalmente/close.php";
}

include "adicionalmente/head.php" ?>

<title>Gestor Equipamentos</title>

<script type="text/javascript">
    function confirmacao(Cod_Equipamento) {
        var resposta = confirm("Deseja apagar o Produto?");

        if (resposta == true) {
            window.location.href = "3-apagar.php?Cod_Equipamento=" + Cod_Equipamento;
        }
    }

    function confirmar(Id_Categoria) {
        var resposta = confirm("Deseja apagar esta Categoria?");

        if (resposta == true) {
            window.location.href = "apagarcategoria.php?Id_Categoria=" + Id_Categoria;
        }
    }
</script>

<link href="vendor/css/sb-admin-2.min.css" rel="stylesheet">
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

    .img1 {

        min-height: 300px;
        max-height: 300px;
        object-fit: cover;
    }
</style>

<body class="w3-light-grey w3-content" style="max-width:2000px" id="page-top">
    <?php include "adicionalmente/header.php" ?>
    <!-- !PAGE CONTENT! -->

    <div class="w3-main" style="margin-left:300px">

        <!-- Header -->
        <header id="portfolio" class="w3-main w3-top w3-light-grey">
            <a href="#"><img src="imagens/logo.jpg" style="width:65px;" class=" w3-right w3-margin w3-hide-large w3-hover-opacity"></a>
            <span class="w3-button w3-hide-large w3-xxlarge w3-hover-text-grey" onclick="w3_open()"><i class="fa fa-bars"></i></span>
            <div class="w3-container">
                <h1><b>Equipamentos</b></h1>
                <div class="w3-section w3-bottombar w3-padding" id="categoria">
                    <span class="w3-margin-right">CATEGORIA:</span>

                    <!--<a href="?cat=1"><button class="w3-white btn bot-click" id="E" value="Red"><i class="w3-margin-right fas fa-laptop-code"></i>Informática</button></a>
                    <a href="?cat=2"><button class="w3-white btn bot-click" id="F" value="Red"><i class="w3-margin-right fas fa-car-battery"></i>Eletrónica</button></a>
                    <a href="?cat=3"><button class="w3-white btn bot-click" id="G" value="Red"><i class=" w3-margin-right fas fa-robot"></i>Mecatrónica</button></a>
                    <a href="?cat=4"><button class="w3-white btn bot-click" id="H" value="Red"><i class=" w3-margin-right fas fa-bars"></i>Outros</button></a> -->
                    <?php

                    include "adicionalmente/config.php";

                    $search = false;

                    if (isset($_GET['q'])) {
                        $q = $_GET['q'];
                        $search = true;
                    }

                    $sql    = "SELECT * FROM categorias";
                    $result = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <span class="wrapper">
                            <a href="?cat=<?php echo $row['Id_Categoria'] ?><?php echo $search ? "&q=$q" : "" ?>"><button class="w3-white btn bot-click" id="<?php echo $row['Id_Categoria'] ?>" name="categorias[]"><?php echo $row['Nome_Categoria'] ?></button></a>
                            <div class="tooltip">
                                <a href="javascript:func()" onclick="confirmar(<?php echo $row['Id_Categoria']; ?>)"><i class="material-icons w3-hover-text-grey" style="color: #04748c">delete</i></a>
                                <a href="alterar.php?Id_Categoria=<?php echo $row['Id_Categoria']; ?>"><i class="material-icons w3-hover-text-grey" style="color: #04748c">mode_edit</i></a>
                            </div>
                        </span>
                    <?php
                    }
                    ?>
                    <a href="categorias.php"><button class="w3-white btn bot-click" id="adicionarcat"><i class="fa fa-plus" aria-hidden="true"></i></button></a>
                </div>
            </div>
            <span>
                <form class="example w3-right" style="width: 30vw; margin-right:8vw; transform:translateY(-350%)">
                    <?php
                    $cat = 0;

                    if (isset($_GET['cat']) and (int) $_GET['cat'] >= 1) {
                        $cat = (int) $_GET['cat'];
                    }

                    if ($cat <> 0) {
                    ?>
                        <input type="hidden" name="cat" value="<?php echo $cat ?>">
                    <?php
                    }
                    ?>
                    <input type="text" placeholder="Procura.." name="q" style="display: inline-block;">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </span>
            <button onclick="printDiv('pdf')" class=" button button5 w3-right w3-text-center" style="transform: translate(15vw,-0.5vw);"><i class="material-icons" style="font-size:24px; ">print</i></button>
        </header>
        
        <!-- Primeira fila de imagens-->
        <div class="w3-container">
        
            <br><br><br><br><br><br>
            
            <?php


            include "adicionalmente/config.php";



            $sql = "SELECT * FROM Equipamentos";

            if ($cat <> 0) $sql .= " INNER JOIN Categorias_Equipamentos ON Equipamentos.Cod_Equipamento = Categorias_Equipamentos.Cod_Equipamento WHERE id_categoria = '$cat'";

            if ($search && $cat <> 0) {
                $sql .= " and match(Nome_Equipamento) against('$q*' in boolean mode)";
            } else if ($search) {
                $sql .= " WHERE match(Nome_Equipamento) against('$q*' in boolean mode)";
            }

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
            ?>
                <div id="pdf">
                    <?php
                    while ($row = $result->fetch_assoc()) {
                    ?>
                        <div class="w3-third w3-container w3-margin-bottom">
                            <img src="foto/<?php echo $row['Imagem'] ?>" style="width:100%" onclick="onClick(this)" class="w3-hover-opacity img1">
                            <div class="w3-container w3-white">
                                <p><b><?php echo $row['Nome_Equipamento'] ?></b></p>
                                <p class="hyphenate"><?php echo $row['Descricao'] ?></p>
                                <?php
                                if ($row['Quantidade'] > 0) {
                                ?>
                                    <button type="button" class="botaoreserva button button3 w3-right" id="emprestar" style="transform: translateY(-430%);"  onclick="abrirmodal( <?php echo $row['Cod_Equipamento'] ?> )"> Emprestar </button>
                                <?php
                                } else {
                                ?>
                                    <button type="button" class="botaoreserva button button3 w3-right" id="reservar" style="transform: translateY(-430%);" onclick="abrirreserva( <?php echo $row['Cod_Equipamento'] ?> )"> Reservar </button>
                                <?php
                                }
                                ?>
                                <p><b>Qtd:</b> <?php echo "<span id='quantidade' value='" . $row['Quantidade'] . "'>" . $row['Quantidade'] . "</span>" ?> &nbsp; &nbsp; <b>Emprestados:</b> <?php echo "<span id='emprestados' value='" . $row['Emprestimo_Ativo'] . "'>" . $row['Emprestimo_Ativo'] . "</span>" ?> </p>
                                
                                <a href="javascript:func()" onclick="confirmacao(<?php echo $row['Cod_Equipamento']; ?>)"> <i class="fa fa-trash w3-right w3-white" style="font-size: 18px; transform: translateX(500%);"> </i></a>
                                <a href="3-alterar_equipamento.php?id=<?php echo $row['Cod_Equipamento'] ?>"> <i class="fas fa-pencil-alt w3-right w3-white" style="font-size: 18px; margin-right: 5px; transform: translateX(430%);"> </i></a>
                                <br>
                            </div>
                        </div>
                    <?php
                    } ?>
                </div>
            <?php
            } else {
                echo "Não existem equipamentos!";
            }
            include "adicionalmente/close.php";
            ?>
        </div>
        <br>
    </div>
    <br><br>

    <div id="modal01" class="w3-modal " style="padding-top:0" onclick="this.style.display='none'">
        <span class="w3-button w3-xlarge w3-display-topright">×</span>
        <div class="w3-modal-content w3-animate-zoom w3-center w3-transparent w3-padding-64">
            <img id="img01" class="w3-image">
            <p id="caption"></p>
        </div>
    </div>
    <!-----------------------------------------------Modal Emprestimos-------------------------------->

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Empréstimo</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"> X </button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <!-- 2 column grid layout with text inputs for the first and last names -->
                        <!-- Default checked radio -->
                        <input type="hidden" name="Cod_Equipamento" value="" id="Codigo">
                        <div class="form-check">
                            <input class="form-check-input" value="Aluno" type="radio" name="tipo_reservante" id="Aluno" onchange="mudaCargo('Aluno')" checked required />
                            <label class="form-check-label" for="flexRadioDefault2"> Aluno &#8205 &#8205 &#8205 &#8205 &#8205
                                &#8205</label>

                            <input class="form-check-input" value="Professor" type="radio" name="tipo_reservante" id="Professor" onchange="mudaCargo('Professor')" required />
                            <label class="form-check-label" for="flexRadioDefault1"> Professor </label>
                        </div>
                        <br>
                        <div class="row mb-2">
                            <div class="col">
                                <div class="form-outline">
                                    <label class="form-label" for="form6Example1">Primeiro Nome</label>
                                    <input type="text" id="form6Example1" class="form-control" name="nome" required />
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-outline">
                                    <label class="form-label" for="form6Example2">Apelido</label>
                                    <input type="text" id="form6Example2" class="form-control" name="apelido" required />
                                </div>
                            </div>
                        </div>
                        <!-- Email input -->
                        <div class="form-outline mb-2">
                            <label class="form-label" for="form6Example5">Email</label>
                            <input type="email" id="form6Example3" class="form-control" name="email_reservante" required />
                        </div>

                        <!-- Text input -->
                        <div class="form-outline mb-2">
                            <label class="form-label" for="form6Example3">N.º Cartão</label>
                            <input type="text" id="form6Example4" class="form-control" name="nrcartao" required />
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <div class="form-outline mb-2">
                                    <label class="form-label" for="form6Example3">Data Prevista de Entrega</label>
                                    <input type="date" id="form6Example5" class="form-control" name="data_prevfim" min="" required />
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-outline mb-2">
                                    <label class="form-label" for="form6Example3">Quantidade</label>
                                    <input type="number" id="form6Example4" class="form-control" name="quantidade_emprestimo" required />
                                </div>
                            </div>
                        </div>

                        <div class="form-outline mb-2" id="Ano">
                            <label class="w3-tamanho18 form-label" for="form6Example6">Ano</label>
                            <select class="w3-input w3-border form-control" name="ano" onchange="mudaAno()">
                                <option value="" selected></option>
                                <option value="10">10º Ano</option>
                                <option value="11">11º Ano</option>
                                <option value="12">12º Ano</option>
                            </select>
                            <div><small class="erro" id="errosano"></small></div>
                        </div>

                        <div class="row mb-2">
                            <div class="col">
                                <div class="form-outline mb-4" id="Curso">
                                    <label class="w3-tamanho18 form-label" for="form6Example5">Curso</label>
                                    <select class="w3-input w3-border form-control" name="curso" id="CursoSelect">
                                        <option value="blank" selected></option>
                                        <option value="Profissional">Curso Profissional</option>
                                        <option value="Regular">Curso Científico-Humanísticos</option>
                                    </select>
                                    <div><small class="erro" id="erroselecao"></small></div>
                                </div>
                            </div>
                            <div class="col">
                                <div id="Turma">
                                    <div class="form-outline mb-4">
                                        <label class="w3-tamanho18 form-label" for="form6Example7">Turma</label>
                                        <select class="w3-input w3-border form-control" name="turma">
                                            <option></option>
                                            <optgroup label="Profissionais" id="selectProfissionais">
                                                <option value="TSI">TSI</option>
                                                <option value="TEA">TEA</option>
                                                <option value="TMC">TMC</option>
                                                <option value="TGR">TGR</option>
                                                <option value="TDS">TDS</option>
                                                <option value="TQA">TQA</option>
                                                <option value="TCM">TCM</option>
                                            </optgroup>
                                            <optgroup label="Regulares" id="selectRegulares">
                                                <option value="AV1">AV1</option>
                                                <option value="CSE1">CSE1</option>
                                                <option value="CSE2">CSE2</option>
                                                <option value="CSE3">CSE3</option>
                                                <option value="CT1">CT1</option>
                                                <option value="CT2">CT2</option>
                                                <option value="CT3">CT3</option>
                                                <option value="CT4">CT4</option>
                                                <option value="CT5">CT5</option>
                                                <option value="CT6">CT6</option>
                                                <option value="CT7">CT7</option>
                                                <option value="CT8">CT8</option>
                                                <option value="CT9">CT9</option>
                                                <option value="CT_CSE">CT_CSE</option>
                                                <option value="LH1">LH1</option>
                                                <option value="LH2">LH2</option>
                                                <option value="LH3">LH3</option>
                                                <option value="LH4">LH4</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Concluir</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-----------------------------------------------Modal Reserva-------------------------------->

    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reserva</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"> X </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="insere_reserva.php">
                        <!-- 2 column grid layout with text inputs for the first and last names -->
                        <!-- Default checked radio -->
                        <input type="hidden" name="Cod_Equipamento" value="" id="Reserva">
                        <div class="form-check">
                            <input class="form-check-input" value="Aluno" type="radio" name="tipo_reservante_reserva" id="Aluno1" onchange="mudaCargo1('Aluno1')" checked required />
                            <label class="form-check-label" for="flexRadioDefault2"> Aluno &#8205 &#8205 &#8205 &#8205 &#8205
                                &#8205</label>

                            <input class="form-check-input" value="Professor" type="radio" name="tipo_reservante_reserva" id="Professor1" onchange="mudaCargo1('Professor1')" required />
                            <label class="form-check-label" for="flexRadioDefault1"> Professor </label>
                        </div>
                        <br>
                        <div class="row mb-2">
                            <div class="col">
                                <div class="form-outline">
                                    <label class="form-label" for="form6Example1">Primeiro Nome</label>
                                    <input type="text" id="form6Example1" class="form-control" name="nome_reserva" required />
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-outline">
                                    <label class="form-label" for="form6Example2">Apelido</label>
                                    <input type="text" id="form6Example2" class="form-control" name="apelido_reserva" required />
                                </div>
                            </div>
                        </div>
                        <!-- Email input -->
                        <div class="form-outline mb-2">
                            <label class="form-label" for="form6Example5">Email</label>
                            <input type="email" id="form6Example3" class="form-control" name="email_reservante_reserva" required />
                        </div>

                        <!-- Text input -->
                        <div class="form-outline mb-2">
                            <label class="form-label" for="form6Example3">N.º Cartão</label>
                            <input type="text" id="form6Example4" class="form-control" name="nrcartao_reserva" required />
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                            <div class="form-outline mb-2">
                                    <label class="form-label" for="form6Example3">Duração Prevista de Entrega</label>
                                    <input type="number" id="form6Example5" class="form-control" name="data_prevfim_reserva" min="" placeholder="N.º de Dias" required />
                                </div>
                            </div>
                            <div class="col">
                            <div class="form-outline mb-2">
                                <label class="form-label" for="form6Example3">Quantidade</label>
                                <input type="number" id="form6Example4" class="form-control" name="quantidade_reserva" value="1" required />
                            </div>
                            </div>
                        </div>
                        

                        <div class="form-outline mb-2" id="Ano1">
                            <label class="w3-tamanho18 form-label" for="form6Example6">Ano</label>
                            <select class="w3-input w3-border form-control" name="ano_reserva" onchange="mudaAno()">
                                <option value="" selected></option>
                                <option value="10">10º Ano</option>
                                <option value="11">11º Ano</option>
                                <option value="12">12º Ano</option>
                            </select>
                            <div><small class="erro" id="errosano"></small></div>
                        </div>

                        <div class="row mb-2">
                            <div class="col">
                                <div class="form-outline mb-4" id="Curso1">
                                    <label class="w3-tamanho18 form-label" for="form6Example5">Curso</label>
                                    <select class="w3-input w3-border form-control" name="curso_reserva" id="CursoSelect1">
                                        <option value="blank" selected></option>
                                        <option value="Profissional">Curso Profissional</option>
                                        <option value="Regular">Curso Científico-Humanísticos</option>
                                    </select>
                                    <div><small class="erro" id="erroselecao"></small></div>
                                </div>
                            </div>
                            <div class="col">
                                <div id="Turma1">
                                    <div class="form-outline mb-4">
                                        <label class="w3-tamanho18 form-label" for="form6Example7">Turma</label>
                                        <select class="w3-input w3-border form-control" name="turma_reserva">
                                            <option></option>
                                            <optgroup label="Profissionais" id="selectProfissionais1">
                                                <option value="TSI">TSI</option>
                                                <option value="TEA">TEA</option>
                                                <option value="TMC">TMC</option>
                                                <option value="TGR">TGR</option>
                                                <option value="TDS">TDS</option>
                                                <option value="TQA">TQA</option>
                                                <option value="TCM">TCM</option>
                                            </optgroup>
                                            <optgroup label="Regulares" id="selectRegulares1">
                                                <option value="AV1">AV1</option>
                                                <option value="CSE1">CSE1</option>
                                                <option value="CSE2">CSE2</option>
                                                <option value="CSE3">CSE3</option>
                                                <option value="CT1">CT1</option>
                                                <option value="CT2">CT2</option>
                                                <option value="CT3">CT3</option>
                                                <option value="CT4">CT4</option>
                                                <option value="CT5">CT5</option>
                                                <option value="CT6">CT6</option>
                                                <option value="CT7">CT7</option>
                                                <option value="CT8">CT8</option>
                                                <option value="CT9">CT9</option>
                                                <option value="CT_CSE">CT_CSE</option>
                                                <option value="LH1">LH1</option>
                                                <option value="LH2">LH2</option>
                                                <option value="LH3">LH3</option>
                                                <option value="LH4">LH4</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Concluir</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
		// Verifica se recebeu a variável insere no GET do HTTP e se esta tem o valor de 1
		if (isset($_GET["concluir"]) && $_GET["concluir"] == 1) {
		?>

			<div id="id01" class="w3-modal" style="display: block;">
				<div class="w3-modal-content1 w3-card-4 w3-animate-zoom">

					<div class="w3-center">
						<br>
						<span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-xxlarge w3-transparent w3-display-topright w3-text-black" title="Close Modal">×</span>
                        <i class="fa fa-exclamation-triangle w3-text-red" style='font-size:48px;' aria-hidden="true"></i>
						<p class="w3-center w3-padding-32 w3-text-red w3-medium w3-container"><b>Cuidado!</b><br><br>Verificar as Reservas antes de fazer qualquer Empréstimo.</p>
					</div>
				</div>
			</div>
		<?php
		}
		?>

<?php
		// Verifica se recebeu a variável insere no GET do HTTP e se esta tem o valor de 1
		if (isset($_GET["email"]) && $_GET["email"] == 1) {
		?>

            <div id="email" class="w3-modal" style="display: block;">
                    <div class="w3-modal-content2 w3-white w3-opacity container w3-card-4 w3-animate-zoom">

                        <div class="w3-center">
                            <br>
                            <i class="fa fa-check w3-text-green" style='font-size:48px;' aria-hidden="true"></i>
                            <p class="w3-center w3-padding-32 w3-medium w3-container"><?php echo htmlspecialchars("Email enviado!"); ?></p>
                        </div>
                    </div>
                </div>
		<?php
		}
		?>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top" href="#">
        <i class="fa fa-angle-up" style="font-size: 26px; margin-left:12px; margin-top:7px"></i>
    </a>

    <footer class="w3-black w3-center w3-padding-16">Powered by <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-opacity">w3.css</a></footer>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    setTimeout(function email() {
        $("#email").hide();
    }, 2000);

    // Modal Image Gallery
    function onClick(element) {
        document.getElementById("img01").src = element.src;
        document.getElementById("modal01").style.display = "block";
        var captionText = document.getElementById("caption");
        captionText.innerHTML = element.alt;
    }

    function abrirmodal(id) {
        document.getElementById("Codigo").value = id;
        $('#exampleModal').modal('show');
    }

    function abrirreserva(id) {
        document.getElementById("Reserva").value = id;
        $('#exampleModal1').modal('show');
    }

    document.getElementById('CursoSelect').addEventListener('change', (event) => {
        const tipoV = event.target.value;

        let divProf = document.getElementById("selectProfissionais");
        let divRegulares = document.getElementById("selectRegulares");

        if (tipoV == "Profissional") {
            divProf.style.display = "block";
            divRegulares.style.display = "none";
        } else if (tipoV == "Regular") {
            divProf.style.display = "none";
            divRegulares.style.display = "block";
        } else if (tipoV == "blank") {
            divProf.style.display = "none";
            divRegulares.style.display = "none";
        }
    });

    document.getElementById('CursoSelect1').addEventListener('change', (event) => {
        const tipoV = event.target.value;

        let divProf = document.getElementById("selectProfissionais1");
        let divRegulares = document.getElementById("selectRegulares1");

        if (tipoV == "Profissional") {
            divProf.style.display = "block";
            divRegulares.style.display = "none";
        } else if (tipoV == "Regular") {
            divProf.style.display = "none";
            divRegulares.style.display = "block";
        } else if (tipoV == "blank") {
            divProf.style.display = "none";
            divRegulares.style.display = "none";
        }
    });

    var today = new Date().toISOString().split('T')[0];
    document.getElementsByName("data_prevfim")[0].setAttribute('min', today);
    document.getElementsByName("data_prevfim_reserva")[0].setAttribute('min', today);
    document.getElementsByName("data_levantar_reserva")[0].setAttribute('min', today);

    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;

        // Create a temporary container
        var tempContainer = document.createElement('div');
        tempContainer.innerHTML = "<html><head><title></title></head><body><h1 align='center'>Stock dos Equipamentos</h1>" + printContents + "</body>";

        // Append the original content to the temporary container
        tempContainer.appendChild(document.createTextNode(document.body.innerHTML));

        // Replace the entire content of the body with the content of the temporary container
        document.body.innerHTML = tempContainer.innerHTML;

        // Perform printing
        window.print();

        // Restore the original content by resetting the body's innerHTML
        document.body.innerHTML = document.body.innerHTML;
    }
</script>


    <script src="js/escolha.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    
    <?php include "adicionalmente/fim.php" ?>
</body>

</html>