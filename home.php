<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("location: index.php");
}
$id = $_SESSION["id"];
$username = $_SESSION["username"];
$email = $_SESSION["email"];
$password = $_SESSION["password"];

//show all your posts
$url = "http://localhost:8080/posts/you";
$data = array("username" => $username);
$options = array(
    "http" => array(
        "method" => "GET",
        "header" => "Content-Type: application/x-www-form-urlencoded",
        "content" => http_build_query($data)
    )
);
$response = file_get_contents($url, false, stream_context_create($options));
$response_data = json_decode($response);
$post_data = $response_data;

//create new post
if (isset($_POST["addPost"])) {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $username = $_POST["username"];

    $url = "http://localhost:8080/posts";
    $data = array("title" => $title, "description" => $description, "username" => $username);
    $options = array(
        "http" => array(
            "method" => "POST",
            "header" => "Content-Type: application/x-www-form-urlencoded",
            "content" => http_build_query($data)
        )
    );
    $response = file_get_contents($url, false, stream_context_create($options));
    header("location: home.php");
}

//update user information (password)
if (isset($_POST["changePassword"])) {
    $id = $_POST["id"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $url = "http://localhost:8080/users";
    $data = array("id" => $id, "email" => $email, "password" => $password);
    $options = array(
        "http" => array(
            "method" => "PUT",
            "header" => "Content-Type: application/x-www-form-urlencoded",
            "content" => http_build_query($data)
        )
    );
    $response = file_get_contents($url, false, stream_context_create($options));
    session_destroy();
    header("location: index.php");
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CloudPost</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark p-2 mb-2">
            <div class="container-fluid justify-content-between">
                <a class="navbar-brand" href="index.php">
                    <h3>CloudPost</h3>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNavDarkDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-bg-dark" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Welcome, <?= $username ?>!</a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                                <li><a class="dropdown-item text-bg-dark" href="#" data-bs-toggle="modal" data-bs-target="#editUserModal">Change Password</a></li>
                                <li><a class="dropdown-item text-bg-dark" href="logout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <div class="container-fluid">
            <div class="text-center m-5">
                <h1>Share your activities to your friends</h1>

                <button type="button" class="btn btn-success my-3" data-bs-toggle="modal" data-bs-target="#addPostModal">Add Post</button>

            </div>
            <!-- postingan anda -->
            <?php
            foreach ($post_data as $post) {
            ?>
                <div class="card m-4">
                    <div class="card-header">
                        <a href="delete_post.php?id=<?= $post->id ?>" onclick="return confirm('yakin?');"><i class="bi bi-trash3-fill"></i></a>
                        <span class="fw-bold"><?= $post->title ?></span>
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <p><?= $post->description ?></p>
                        </blockquote>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </main>

    <!-- modal add post -->
    <div class="modal fade" id="addPostModal" tabindex="-1" aria-labelledby="addPostModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content p-2">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPostModalLabel">Write your post here</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <input type="hidden" name="username" id="username" value="<?= $username ?>">
                        <div class=" form-group row mb-3 justify-content-between">
                            <label for="title" class="col-sm-3 col-form-label">Title</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="title" id="title" required>
                            </div>
                            <div class="form-group row mb-3 justify-content-between">
                                <label for="description" class="col-sm-3 col-form-label">Description</label>
                                <div class="col-sm-12">
                                    <textarea class="form-control" name="description" id="description"></textarea>
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="my-auto">
                                    <button type="submit" class="btn btn-primary" name="addPost">Post</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Modal - Change Pass -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-2">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Change <?= $username ?> Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <input type="hidden" name="id" id="id" value="<?= $id ?>">
                        <input type="hidden" name="email" id="email" value="<?= $email ?>">
                        <div class="form-group row mb-3 justify-content-between">
                            <label for="password" class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" name="password" id="password" required>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="my-auto">
                                <button type="submit" class="btn btn-primary" name="changePassword">Change</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>