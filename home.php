<?php
include 'noteOperation.php';
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
}

$userId = $_SESSION['user'];
$noteOps = new NoteOperations($conn);

$sql = "SELECT * FROM users WHERE id = $userId";
$result = mysqli_query($conn, $sql);
$theuser = mysqli_fetch_assoc($result);

$fullname = $theuser['full_name'];

// Handle create note request
if (isset($_POST['create'])) {
    $title = $_POST['title'];
    $content = $_POST['notes'];
    $noteOps->createNote($userId, $title, $content);
    header('Location: home.php');
}

// Handle update note request
if (isset($_POST['update'])) {
    $noteId = $_POST['noteid'];
    $title = $_POST['title'];
    $content = $_POST['notes'];
    $noteOps->updateNote($noteId, $userId, $title, $content);
    header('Location: home.php');
}

// Handle delete note request
if (isset($_GET['delete'])) {
    $noteId = $_GET['delete'];
    $noteOps->deleteNote($noteId, $userId);
    header('Location: home.php'); // Prevent form resubmission
}

$notes = $noteOps->readNotes($userId);
$sno = 0;
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NoteGit - Home</title>
    <link rel="shortcut icon" href="./img/favicon.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anta&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/default.css">
    <link rel="stylesheet" href="./bootstrap_css/bootstrap.min.css">
    <link href="./DataTables/datatables.min.css" rel="stylesheet">
</head>

<body class="anta-regular">
    <!-- modal for editing notes -->
    <div class="modal modalbox" id="myModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Notes</h5>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <form method="post">
                            <input id="noteidedit" type="hidden" name="noteid" value="<?= $note['noteid'] ?>">
                            <label for="formGroupExampleInput" class="form-label">Title</label>
                            <input type="text" class="form-control" id="formGroupExampleInput" placeholder="New Title" name="title" value="<?= htmlspecialchars($note['title']) ?>" required>
                            <label for="formGroupExampleInput2" class="form-label">Content</label>
                            <textarea type="text" class="form-control" id="formGroupExampleInput2" placeholder="Add or change content" name="notes" required><?= htmlspecialchars($note['notes']) ?></textarea>
                            <div class="modal-footer">
                                <span class="close">
                                    <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal" aria-level="Close">Close</button>
                                </span>
                                <button type="submit" name="update" class="btn btn-primary">Save changes</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
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
                        <?php echo "<a class='nav-link active' aria-current='page' href='./home.php'>{$fullname}</a>" ?>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Create note form  -->
    <div class="create-note d-flex align-items-center flex-column text-white">
        <h2>My Notes</h2>

        <form class="add w-50" method="post">
            <div class="mb-3">
                <label for="formGroupExampleInput" class="form-label">Title</label>
                <input type="text" class="form-control" id="formGroupExampleInput" name="title" placeholder="Title" required>
            </div>
            <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Content</label>
                <textarea type="text" class="form-control" id="formGroupExampleInput2" name="notes" placeholder="Write your note here..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="create">Create</button>
        </form>
    </div>

    <!-- table  -->
    <div class="mytable text-white d-flex flex-column justify-content-center align-items-center">
        <table id="myTable" class="table table-light border border-white">
            <thead>
                <tr>
                    <th>Sl. No</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($notes as $note) : ?>
                    <tr>
                        <th>
                            <?= $sno = $sno + 1 ?>
                        </th>
                        <td>
                            <?= htmlspecialchars($note['title']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($note['notes']) ?>
                        </td>
                        <td><button class="edit btn btn-primary" id="<?= htmlspecialchars($note['noteid']) ?>">Edit</button> <a id="delete" href="?delete=<?= $note['noteid'] ?>"><button class="btn btn-danger">Delete</button></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <footer class="footer p-3">
        <div class=" d-flex justify-content-center align-items-center">
            <p>Made by <a href="https://github.com/dipaashu">Dipak</a></p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./DataTables/datatables.min.js"></script>
    <script>
        let table = new DataTable('#myTable');
    </script>
    <script>
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((el) => {
            el.addEventListener("click", (e) => {
                tr = e.target.parentNode.parentNode;
                title = tr.getElementsByTagName("td")[0].innerText;
                notes = tr.getElementsByTagName("td")[1].innerText;
                formGroupExampleInput.value = title;
                formGroupExampleInput2.value = notes;
                noteidedit.value = e.target.id;
                $("#myModal").modal("toggle");
            })
        })
        const modal = document.getElementById('myModal');
        span = document.getElementsByClassName("close")[0];
        span.onclick = function() {
            modal.style.display = "none";
        }
    </script>

</body>

</html>