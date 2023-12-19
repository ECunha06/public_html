<?php

function tamanho()
{
    header("Location: ?erro=tamanho");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $senha = isset($_POST['senha']) ? $_POST['senha'] : null;

    if (!($email and $senha)) {
        header("Location: ?erro=obrigatorio");
        exit;
    }

    $emailLen = strlen($email);
    $senhaLen = strlen($senha);

    if ($emailLen < 5) tamanho();
    if ($senhaLen < 4) tamanho();

    include "adicionalmente/config.php";

    $query = "SELECT Num_Utilizador FROM Utilizadores WHERE Email = ? and senha = sha1(?);";
    $stmt = mysqli_prepare($conn, $query);
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        session_start();

        $_SESSION['Num_Utilizador'] = $row['Num_Utilizador'];
        $_SESSION['Email']          = $email;
    } else {
        header('Location: ?erro=invalido');
        exit;
    }

    include "adicionalmente/close.php";

    header("Location: produtos.php");
    exit;
}

include "adicionalmente/head.php";
?>

<title>OLX</title>
<style>
    img {
        width: 100vw;
        height: 100vh;
        object-fit: cover;
    }
</style>
</head>

<body class="w3-content" style="max-width:2000px;">

    <!-- Start your project here-->

    <!-- Header with Slideshow -->
    <header class="w3-display-container ">
        <!--Index para Desktop-->

        <div class="mySlides w3-animate-opacity">
            <img src="imagens/login.jpg" alt="Image 1">
            <h1 class="w3-top w3-text-white b" style="margin-left: 15px; font-size:43px;">OLX</h1>

            <div class="w3-display-left w3-padding" style="width:100%; max-width:500px; min-width: 250px;">
                <div class="w3-black w3-padding-large w3-round-large">
                    <form class="form-elegant" method="POST">

                        <div class="card-body">
                            <!--Header-->
                            <div class="text-center">
                                <h3 style="font-size: 30px; margin-bottom: 0%;"><strong>Login</strong></h3>
                            </div>

                            <hr class="w3-opacity" style="margin-top: 2%; margin-left: 0%; width: 100%;">

                            <!--Body-->
                            <div class="md-form mb-5 mx-4">
                                <input type="email" id="Form-email1" class="form-control validate" name="email">
                                <label data-error="errado" data-success="certo" for="Form-email1">E-mail</label>
                            </div>

                            <div class="md-form mx-4">
                                <input type="password" id="Form-pass1" class="form-control validate" name="senha" min="8">
                                <label for="Form-pass1">Palavra-passe</label>
                            </div>

                            <div class="text-center mb-3 mx-4">
                                <input type="submit" value="Entrar" class="btn blue-gradient btn-block btn-rounded z-depth-1a">
                            </div>

                            <div class="text-center mx-4">
                                <a href="forgot_password.php">Esqueceu-se da palavra-passe?</a>
                            </div>

                            <div class="text-center mx-4">
                                <a href="registar.php">Fazer Registo</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <p class="w3-bottom w3-right-align w3-container"><i class="far fa-copyright"></i> 2021 Desenvolvido por <strong>Eduardo Cunha | Luis Teixeira</strong></p>

        </div>
        <!--Index para Smartphone-->

    </header>

    <?php include "adicionalmente/fim.php" ?>
</body>

</html>
