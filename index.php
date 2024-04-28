<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NoteGit</title>
    <link rel="shortcut icon" href="./img/favicon.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anta&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./bootstrap_css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/default.css">
    <link rel="stylesheet" href="./css/index.css">
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
    <!-- content  -->
    <div class="header">
        <div class="">
            <h1>NoteGit</h1>
            <br>
            <p>" From Inspiration to Implementation: Your Notes, Your Journey. "</p>
            <p>A simple web based repository system for your notes.</p>
            <p>Now create, save and access your notes anytime , anywhere fron the globe.</p>
        </div>
    </div>

    <footer class="footer p-3">
        <div class=" d-flex justify-content-center align-items-center">
            <p>Made by <a href="https://github.com/dipaashu">Dipak</a></p>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <script src="./js/bootstrap.min.js"></script>
</body>

</html>