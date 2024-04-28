<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: home.php");
}
if (isset($_POST["login"])) {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    //    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    require_once "database.php";
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
    if ($user) {
        if (password_verify($password, $user["password"])) {
            // session_start();
            $_SESSION["user"] = $user["id"];
            header("Location: home.php");
            die();
        } else {
            echo "<div style='color:red;'>Password does not match</div>";
        }
    } else {
        echo "<div style='color:red;'>Email does not match</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NoteGit - Login</title>
    <link rel="shortcut icon" href="./img/favicon.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anta&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/default.css">
    <link rel="stylesheet" href="./css/lsform.css">
    <link rel="stylesheet" href="./bootstrap_css/bootstrap.min.css">

</head>

<body class="anta-regular">
    <!-- navbar  -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid  d-flex flex-row">
            <a class="navbar-brand ps-5" href="#">
                <img src="./img/logo.png" alt="NoteGit" width="30" height="30">
                NoteGit</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active " aria-current="page" href="./index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="./signup.php" class="nav-link">Join</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- form  -->

    <?php
    ?>

    <div class="d-flex align-items-center flex-column lsform text-white">
        <form action="login.php" method="post">
            <div class="text-white pb-2 d-flex justify-content-center">
                <h1>Login</h1>
            </div>
            <div class="mb-3 pt-2">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text text-white">Registered email id</div>
            </div>

            <div class="mb-3 pt-2">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" onclick="ShowPass()" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Show password</label>
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" name="login" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>

    <footer class="footer p-3">
        <div class=" d-flex justify-content-center align-items-center">
            <p>Made by <a href="https://github.com/dipaashu">Dipak</a></p>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <script src="./js/bootstrap.min.js"></script>
    <script>
        function ShowPass() {
            var x = document.getElementById("exampleInputPassword1");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>

</html>