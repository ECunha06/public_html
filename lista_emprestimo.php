<?php
session_start();
if (!isset($_SESSION['Num_Utilizador'])) {
    header('location: index.php');
    exit;
}
include "adicionalmente/config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    if (!isset($_SESSION)) {
        header('location:index.php');
        exit;
    }
    // Informa se a variável $_POST foi iniciada
    // Retorna TRUE se variável existe; FALSE caso contrário.
    if (isset($_POST)) {
        $id = $_SESSION['Num_Utilizador'];
        //Acesso aos dados do formulário
        $id_emprestimo          =    $_POST["id"];

        $date = new DateTime();
        //acrescenta ao nome do ficheiro tempo de forma a serem diferentes
        $data_final = $date->format('Y-m-d');

        $query = "UPDATE emprestimos SET DataFim = ? WHERE Num_Emprestimo = ?";
        $stmt = mysqli_prepare($conn, $query);
        $stmt->bind_param("si", $data_final, $id_emprestimo);
        $stmt->execute();
        $stmt->close();


        //print_r($_POST); // Para testes - Mostrar os dados recebidos do $_POST

        $sql = "SELECT Quantidade_emprestimo, Cod_Equipamento FROM Emprestimos WHERE Num_Emprestimo = $id_emprestimo";
        $result = mysqli_query($conn, $sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $quantidade = $row['Quantidade_emprestimo'];
            $Cod_Equipamento = $row['Cod_Equipamento'];

            // Query para a inserção de dados na BD
            try {

                $query = "UPDATE Equipamentos Set Quantidade = Quantidade + $quantidade, Emprestimo_Ativo = Emprestimo_Ativo - $quantidade Where Cod_Equipamento = $Cod_Equipamento";

                // Executa a query e verifica se deu erro
                $conn->begin_transaction();
                if (!mysqli_query($conn, $query)) throw new Exception();
                $conn->commit();
                //if (mysqli_query($conn, $sql) && mysqli_query($conn, $query)) {
                // Redirecionar para outra página
                header("location:produtos.php?concluir=1");
            } catch (Exception $e) {
                $conn->rollback();
                // Apresenta o erro
                //echo "Erro: " . $sql . "<br>" . mysqli_error($conn);


                echo "<script language='javascript' type='text/javascript' align='center'>
                    alert('Erro: Este Empréstimo já foi concluído.');
                    window.location='produtos'; </script>";
            }
        }
    }
    include "adicionalmente/close.php";
}
include "adicionalmente/head.php" ?>
<title>Empréstimos</title>
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
        <!-- Header -->
        <header id="portfolio" class="w3-main w3-top w3-light-grey">
            <a href="#"><img src="imagens/logo.jpg" style="width:65px;" class=" w3-right w3-margin w3-hide-large w3-hover-opacity"></a>
            <span class="w3-button w3-hide-large w3-xxlarge w3-hover-text-grey" onclick="w3_open()"><i class="fa fa-bars"></i></span>
            <div class="w3-container w3-bottombar">
                <h1><b>Empréstimos ativos</b></h1>
            </div>
        </header>

        <div class="w3-container">
            <div id="informatica" style="margin-top: 80px;">
                <div class="w3-row-padding">
                    <div class="w3-container">

                        <p>
                            <input class="w3-input w3-third" style="width:250px; margin-right: 10px;" type="text" id="filtraN" onkeyup="filtraN()" placeholder="Procura por nome..." title="Digita um nome...">
                            <input class="w3-input w3-third" style="width:250px;" type="text" id="filtraE" onkeyup="filtraE()" placeholder="Procura por equipamento... " title="Digita um equipamento...">

                            <span class="w3-right">
                                <input onclick="toggle('ativos')" type="checkbox" class="w3-check" name="ativos" checked> <label> Ativos</label>
                                <input onclick="toggle('expirados')" type="checkbox" class="w3-check" name="expirados" checked> <label> Ativos (Expirados)</label>
                                <input onclick="toggle('concluidos')" type="checkbox" class="w3-check" name="concluidos"> <label> Concluídos </label>
                            </span>
                        </p>

                        <script>
                            function filtraN() {
                                var input, filter, table, tr, td, i, txtValue;
                                input = document.getElementById("filtraN");
                                filter = input.value.toUpperCase();
                                table = document.getElementById("myTable");
                                tr = table.getElementsByTagName("tr");
                                for (i = 0; i < tr.length; i++) {
                                    td = tr[i].getElementsByTagName("td")[0];
                                    if (td) {
                                        txtValue = td.textContent || td.innerText;
                                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                            tr[i].style.display = "";
                                        } else {
                                            tr[i].style.display = "none";
                                        }
                                    }
                                }
                            }
                        </script>
                        <script>
                            function filtraE() {
                                var input, filter, table, tr, td, i, txtValue;
                                input = document.getElementById("filtraE");
                                filter = input.value.toUpperCase();
                                table = document.getElementById("myTable");
                                tr = table.getElementsByTagName("tr");
                                for (i = 0; i < tr.length; i++) {
                                    td = tr[i].getElementsByTagName("td")[3];
                                    if (td) {
                                        txtValue = td.textContent || td.innerText;
                                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                            tr[i].style.display = "";
                                        } else {
                                            tr[i].style.display = "none";
                                        }
                                    }
                                }
                            }
                        </script>

                        <br><br>
                        <table class="w3-table w3-bordered" id="myTable">

                            <?php
                            // Query para selecionar todos os dados da tabela emprestimos
                            $sql = "SELECT * FROM Emprestimos INNER JOIN Equipamentos ON Emprestimos.Cod_Equipamento = Equipamentos.Cod_Equipamento ORDER BY Emprestimos.DataFim, Emprestimos.Data_prevfim";

                            // Executar a query
                            $result = mysqli_query($conn, $sql);
                            //var_dump($result); // Mostra em bruto os dados recebidos da base de dados

                            // Verifica se recebeu pelo menos um registo
                            if (mysqli_num_rows($result) > 0) { ?>
                                <tr class="w3-teal">
                                    <th>Nome</th>
                                    <th>Ano / Turma</th>
                                    <th>Tipo</th>
                                    <th>Nome do Equipamento</th>
                                    <th style="width: 110px;">Data Inicio</th>
                                    <th style="width: 110px;">Data Prevista de Fim</th>
                                    <th class="w3-center" colspan="2">Operações</th>
                                    <!--<th>Opções</th>-->
                                </tr>

                                <tbody id="filtrarEmprestimos">
                                    <?php
                                    // Obter cada registo da base de dados para a variável $row
                                    while ($row = mysqli_fetch_assoc($result)) { ?>

                                        <tr <?php if ($row['DataFim'] <> null) echo "class='w3-green w3-text-black'" ?> <?php if ($row['Data_prevfim'] < date("Y-m-d")) echo "class='w3-red w3-text-black'" ?> <?php
                                                                                                                                                                                                                if ($row['DataFim'] <> null) {
                                                                                                                                                                                                                    echo 'data-find="0"';
                                                                                                                                                                                                                } else if ($row['Data_prevfim'] < date("Y-m-d")) {
                                                                                                                                                                                                                    echo 'data-find="1"';
                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                    echo 'data-find="2"';
                                                                                                                                                                                                                }
                                                                                                                                                                                                                ?>>

                                            <td style="font-size: 16px;"><?php echo $row['Nome']; ?> <?php echo $row['Apelido']; ?></td>
                                            <td style="font-size: 16px;"><?php echo $row['Ano']; ?> <?php echo $row['Turma']; ?></td>
                                            <td style="font-size: 16px;"><?php echo $row['Tipo_Reservante']; ?></td>
                                            <td style="font-size: 16px;"><?php echo $row['Nome_Equipamento']; ?></td>
                                            <td style="font-size: 16px;"><?php echo $row['DataInicio']; ?></td>
                                            <td style="font-size: 16px;"><?php echo $row['Data_prevfim']; ?></td>
                                            <td style="width:5%; border-right: solid 0px #ccc;">
                                                <form method="post">
                                                    <input type="hidden" name="id" value="<?php echo $row['Num_Emprestimo']; ?>">
                                                    <input class="w3-button w3-border w3-text-black" name="concluir" id="concluir" type="submit" value="Concluir" <?php if ($row['DataFim'] <> null) echo "disabled" ?>>
                                                </form>
                                            </td>
                                            <td style="width:5%; border-left:  solid 0px #ccc;">
                                                <a href="visualizar.php?codigo=<?php echo $row['Num_Emprestimo']; ?>">
                                                    <button class="w3-button w3-border w3-text-black" type="button"> Detalhes </button>
                                                </a>
                                            </td>

                                        </tr>

                                    <?php } ?>
                                </tbody>
                            <?php
                            } else {
                                echo "Não existem Empréstimos na BD.";
                            } ?>
                        </table>

                        <?php include "adicionalmente/close.php"; ?>
                    </div>
                </div>
                <script src="js/escolha.js"></script>
                <?php include "adicionalmente/fim.php" ?>

                <script>
                    const filtrarEmprestimos = document.getElementById('filtrarEmprestimos');

                    let ativos = true;
                    let expirados = true;
                    let concluidos = true;

                    function toggle(filtro) {
                        switch (filtro) {
                            case 'ativos':
                                ativos = !ativos;
                                break;

                            case 'expirados':
                                expirados = !expirados;
                                break;

                            case 'concluidos':
                                concluidos = !concluidos;
                                break;

                        }

                        pesquisar();
                    }

                    function pesquisar() {
                        filtrarEmprestimos.children.forEach((i) => {
                            const f = i.getAttribute('data-find');

                            switch (f) {
                                case '0':
                                    if (!concluidos) {
                                        i.style.display = "none";

                                        return;
                                    }

                                    i.style.display = "";

                                    break;

                                case '1':
                                    if (!expirados) {
                                        i.style.display = "none";

                                        return;
                                    }

                                    i.style.display = "";

                                    break;

                                case '2':
                                    if (!ativos) {
                                        i.style.display = "none";

                                        return;
                                    }

                                    i.style.display = "";

                                    break;
                            }
                        });
                    }

                    toggle('concluidos');
                </script>
</body>

</html>