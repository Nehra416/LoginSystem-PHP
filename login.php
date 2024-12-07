<!-- Login logic in php -->
<?php
$alertError = "";
$alertShow = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // create a connection with the database
    require "components/_dbconnect.php";

    // get the user's form data
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];

    // Validations
    if (!$username || !$pwd) {
        $alertError = "Both Fields are Required";
        $alertShow = true;
    } else {
        // write the find sql query
        $sql = "SELECT * FROM `users` where `username` = '$username' AND `password` = '$pwd'";

        // run the sql query
        $response = mysqli_query($con, $sql);
        $num = mysqli_num_rows($response);

        if ($num == 1) {
            $alertShow = true;
            session_start();
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $username;
            header("location: welcome.php");
        } else {
            $alertError = "Wrong username or password";
            $alertShow = true;
        }
    } 

}

?>


<!-- html -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Botstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>LogIn</title>
</head>

<body>
    <!-- Require the navbar -->
    <?php require 'components/_navbar.php' ?>

    <!-- Alert -->
    <?php
    if ($alertShow) {
        if ($alertError) {
            echo
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong>  ' . $alertError . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        } 
    }

    ?>

    <div class="container">
        <h2 class="text-center mt-4">Signup here to create a account</h2>

        <!-- LogIn Form -->
        <form method="post" action="/phpCode/LoginSystem/Login.php">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username">
            </div>
            <div class="mb-3">
                <label for="pwd" class="form-label">Password</label>
                <input type="password" class="form-control" id="pwd" name="pwd">
            </div>
            <button type="submit" class="btn btn-primary">LogIn</button>
        </form>
    </div>

    <!-- Botstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>