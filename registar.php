<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $nome_utilizador = $_POST["nome_utilizador"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $numCC = $_POST["numCC"];
    $gestor_total = $_POST["gestor_total"];
    $gestor_inventarios = $_POST["gestor_inventarios"];
    $gestor_pedidos = $_POST["gestor_pedidos"];
    $gestor_entrega_registos = $_POST["gestor_entrega_registos"];
    $gestor_recebe_registos = $_POST["gestor_recebe_registos"];

    // TODO: Perform validation and sanitation of input data

    // TODO: Hash the password before storing it in the database (for security)

    // Now, you can insert the data into your database
    // Example using MySQLi:
    $mysqli = new mysqli("your_host", "your_username", "your_password", "your_database");

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $sql = "INSERT INTO Utilizadores (Nome_Utilizador, Email, Senha, NumCC, Gestor_Total, Gestor_Inventarios, Gestor_Pedidos, Gestor_Entrega_Registos, Gestor_Recebe_Registos)
            VALUES ('$nome_utilizador', '$email', '$senha', '$numCC', '$gestor_total', '$gestor_inventarios', '$gestor_pedidos', '$gestor_entrega_registos', '$gestor_recebe_registos')";

    if ($mysqli->query($sql) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $mysqli->error;
    }

    $mysqli->close();
}

include "adicionalmente/head.php";
?>

<title>User Registration</title>
<style>
    body {
        background-color: #f8f9fa;
    }

    .container {
        max-width: 700px;
        margin: 100px auto;
    }

    .card {
        border: 0;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 40px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
</style>
</head>

<body>

<div class="container">
    <div class="card">
        <div class="card-body">
            <h3 class="text-center mb-4"><strong>User Registration</strong></h3>
            <form class="form-elegant" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="md-form mb-4">
                    <label for="nome_utilizador">Name:</label>
                    <input type="text" id="nome_utilizador" class="form-control validate" name="nome_utilizador" required>
                </div>
                <div class="md-form mb-4">
                    <label for="email">Email:</label>
                    <input type="email" id="email" class="form-control validate" name="email" required>
                </div>
                <div class="md-form mb-4">
                    <label for="senha">Password:</label>
                    <input type="password" id="senha" class="form-control validate" name="senha" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block btn-rounded z-depth-1a">Register</button>
                </div>
            </form>
            
            <!-- Back to Index Button -->
            <div class="text-center mt-4">
                <a href="index.php" class="btn btn-secondary btn-rounded z-depth-1a">Back to Index</a>
            </div>
        </div>
    </div>
</div>

<?php include "adicionalmente/fim.php"; ?>
</body>

</html>
