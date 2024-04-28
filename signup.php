<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: home.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NoteGit - Sign up</title>
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
    <div class="d-flex align-items-center flex-column lsform text-white">
        <?php
        if (isset($_POST["submit"])) {
            $fullName = $_POST["fullname"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $passwordRepeat = $_POST["repeat_password"];

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $errors = array();

            if (empty($fullName) or empty($email) or empty($password) or empty($passwordRepeat)) {
                array_push($errors, "All fields are required");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Email is not valid");
            }
            if (strlen($password) < 8) {
                array_push($errors, "Password must be at least 8 charactes long");
            }
            if ($password !== $passwordRepeat) {
                array_push($errors, "Password does not match");
            }
            require_once "database.php";
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $rowCount = mysqli_num_rows($result);
            if ($rowCount > 0) {
                array_push($errors, "Email already exists!");
            }
            if (count($errors) > 0) {
                foreach ($errors as  $error) {
                    echo "<div style='color:red;'>$error</div>";
                }
            } else {

                $sql = "INSERT INTO users (full_name, email, password) VALUES ( ?, ?, ? )";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                if ($prepareStmt) {
                    mysqli_stmt_bind_param($stmt, "sss", $fullName, $email, $passwordHash);
                    mysqli_stmt_execute($stmt);
                    echo "<div style='color:#eebbc3;'>You are registered successfully.</div>";
                } else {
                    die("Something went wrong");
                }
            }
        }
        ?>
        <form action="signup.php" method="post">
            <div class="text-white pb-2 d-flex justify-content-center">
                <h1>Signup</h1>
            </div>
            <div class="mb-3">
                <label for="formGroupExampleInput" class="form-label">Full Name</label>
                <input type="text" name="fullname" class="form-control" id="formGroupExampleInput" placeholder="Enter your full name">
            </div>

            <div class="mb-3 pt-2">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text text-white">We'll never share your email with anyone else.</div>
            </div>

            <div class="mb-3 pt-2">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                <div class="col-auto">
                    <span id="passwordHelpInline" class="form-text text-white">
                        Must be 8-20 characters long.
                    </span>
                </div>

            </div>
            <div class="mb-3 pt-2">
                <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
                <input type="password" name="repeat_password" class="form-control" id="exampleInputPassword1">
                <div class="col-auto">
                    <span id="passwordHelpInline" class="form-text text-white">
                        Both password must match
                    </span>
                </div>

            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" onclick="ShowPass()" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Show password</label>
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" name="submit" class="btn btn-primary">Signup</button>
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