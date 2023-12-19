<?php
    include "adicionalmente/config.php";

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $email = isset($_POST['email']) ? $_POST['email'] : null;

        // Validate and process the email (send reset link, update database, etc.)
        // ...

        // Redirect the user back to the login page or display a confirmation message.
        // ...
    }

    include "adicionalmente/head.php";
?>

<title>Recuperar Palavra-passe</title>
<style>
    body {
        background-color: #f8f9fa;
    }

    .container {
        max-width: 400px;
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
                <h3 class="text-center mb-4"><strong>Recuperar Palavra-passe</strong></h3>
                <form class="form-elegant" method="POST">
                    <div class="md-form mb-4">
                        <label for="Form-email1">E-mail</label>
                        <input type="email" id="Form-email1" class="form-control validate" name="email" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-block btn-rounded z-depth-1a">Recuperar</button>
                    </div>
                    <!-- Back to Index Button -->
                    <div class="text-center mt-4">
                        <a href="index.php" class="btn btn-secondary btn-rounded z-depth-1a">Back to Index</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include "adicionalmente/fim.php" ?>
</body>

</html>
