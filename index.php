<?php
//fetch posts
$curl_handle_post = curl_init();
$url = "http://localhost:8080/posts";
curl_setopt($curl_handle_post, CURLOPT_URL, $url);
curl_setopt($curl_handle_post, CURLOPT_RETURNTRANSFER, true);
$curl_data_post = curl_exec($curl_handle_post);
curl_close($curl_handle_post);
$response_data_post = json_decode($curl_data_post);
$post_data = $response_data_post;

//fetch users
$curl_handle_user = curl_init();
$url = "http://localhost:8080/users";
curl_setopt($curl_handle_user, CURLOPT_URL, $url);
curl_setopt($curl_handle_user, CURLOPT_RETURNTRANSFER, true);
$curl_data_user = curl_exec($curl_handle_user);
curl_close($curl_handle_user);
$response_data_user = json_decode($curl_data_user);
$user_data = $response_data_user;

session_start();
//login user
if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    foreach ($user_data as $data) {
        if ($data->email == $email && $data->password == $password) {
            $_SESSION["login"] = true;
            $_SESSION["id"] = $data->id;
            $_SESSION["email"] = $data->email;
            $_SESSION["username"] = $data->username;
            $_SESSION["password"] = $data->password;
            header("location: home.php");
            exit;
        }
    }
    $error = true;
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CloudPost</title>
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
</head>

<body>

    <header>
        <nav class="navbar navbar-dark bg-dark p-2 mb-2">
            <div class="container-fluid justify-content-between ">
                <span class="navbar-brand mb-0 h1">
                    <h3>CloudPost</h3>
                </span>
                <div>
                    <!-- <a href="test.html" class="hr"><button class="btn btn-dark btn-outline-light me-2" type="button">Log in</button></a> -->
                    <?php
                    if (isset($_SESSION["login"])) {
                    ?>
                        <a href="home.php"><i class="bi bi-person-circle"></i></a>
                    <?php
                    } else {
                    ?>
                        <button class="btn btn-dark btn-outline-light me-2" type="button" data-bs-toggle="modal" data-bs-target="#loginModal">
                            Login
                        </button>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <div class="container-fluid">
            <div class="text-center m-5">
                <h1>Welcome to CloudPost</h1>
                <h5 class="fw-light">Share your activity here!</h5>
            </div>
            <!-- show post -->
            <?php
            foreach ($post_data as $posts) {
            ?>
                <div class="card m-4">
                    <div class="card-header">
                        <span class="fw-bold"><?= $posts->title ?></span>
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <p><?= $posts->description ?></p>
                            <footer class="blockquote-footer fs-6">Posted by <cite title="Source Title"><?= $posts->username ?></cite></footer>
                        </blockquote>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </main>

    <!-- Modal - Form -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-2">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login Here</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="form-group row mb-3 justify-content-between">
                            <label for="email" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="email" id="email" required>
                            </div>
                        </div>
                        <div class="form-group row mb-3 justify-content-between">
                            <label for="password" class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" name="password" id="password" required>
                            </div>
                        </div>
                        <div class="text-center">
                            <?php if (isset($error)) : ?>
                                <p>Username / Password Not Found</p>
                            <?php endif; ?>
                            <div class="my-auto">
                                <button type="submit" class="btn btn-primary" name="login">Login</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <h6>Don't have any account ?</h6>
                    <a href="regis.php" class="href">Sign up here</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>