<?php
//create account
if (isset($_POST["regis"])) {
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    $url = "http://localhost:8080/users";
    $data = array("email" => $email, "username" => $username, "password" => $password);
    $options = array(
        "http" => array(
            "method" => "POST",
            "header" => "Content-Type: application/x-www-form-urlencoded",
            "content" => http_build_query($data)
        )
    );
    $response = file_get_contents($url, false, stream_context_create($options));
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
</head>

<body>

    <header>
        <nav class="navbar navbar-dark bg-dark p-2 mb-2">
            <div class="container-fluid justify-content-between ">
                <span class="navbar-brand mb-0 h1">
                    <h3>CloudPost</h3>
                </span>
                <div>
                    <a href="index.html" class="hr"><button class="btn btn-dark btn-outline-light me-2" type="button">Back</button></a>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <div class="row justify-content-center">
            <div class="col-sm-5">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title p-4 mb-2 text-center">Create your account here</h5>
                        <form action="" method="post">
                            <div class="form-group row mb-3 justify-content-between px-4">
                                <label for="username" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" name="email" id="email" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3 justify-content-between px-4">
                                <label for="username" class="col-sm-3 col-form-label">Username</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="username" id="username" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3 justify-content-between px-4">
                                <label for="password" class="col-sm-3 col-form-label">Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" name="password" id="password" required>
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="my-auto">
                                    <button type="submit" class="btn btn-primary" name="regis">Sign Up</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>