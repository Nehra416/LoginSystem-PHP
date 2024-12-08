<!-- signup logic in php -->
<?php
    $alertError = "";
    $alertShow = false;

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // create a connection with the database
        require "components/_dbconnect.php";

        // get the user's form data
        $username = $_POST["username"];
        $pwd = $_POST["pwd"];
        $confirm_pwd = $_POST["confirm_pwd"];

        // Validations
        $existsql = "SELECT * FROM `users` where `username` = '$username'";
        $response = mysqli_query($con, $existsql);
        $num = mysqli_num_rows($response);

        if($num != 0){
            $alertError = "Username is already exists";
            $alertShow = true;
        }
        elseif(!$username || !$pwd || !$confirm_pwd){
            $alertError = "All Fields  are Required";
            $alertShow = true;
        } 
        elseif ($pwd == $confirm_pwd){
            // convert the password into hash which is store in db
            $hash = password_hash($pwd, PASSWORD_DEFAULT);

            // write the insert sql query
            $sql = "INSERT INTO `users` (`username`, `password`, `dt`) VALUES ('$username', '$hash', current_timestamp())";

            // run the sql query
            $response = mysqli_query($con, $sql);

            if($response) {
                $alertShow = true;
            }
            else {
                $alertError = "Something went wrong";
                $alertShow = true;
            }
                
        } else {
            $alertError = "Password and Confirm Password is not same";
            $alertShow = true;
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

    <title>SignUp</title>
</head>

<body>
    <!-- Require the navbar -->
    <?php require 'components/_navbar.php' ?>

    <!-- Alert -->
     <?php
     if($alertShow){
            if ($alertError) {
                echo
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong>  ' . $alertError . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            } else {
                echo
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Successfully!</strong> Your account is created.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
     }
     
    ?>

    <div class="container">
        <h2 class="text-center mt-4">Signup here to create a new account</h2>

        <!-- SignUp Form -->
        <form method="post" action="/phpCode/LoginSystem/signup.php">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username">
            </div>
            <div class="mb-3">
                <label for="pwd" class="form-label">Password</label>
                <input type="password" class="form-control" id="pwd" name="pwd">
            </div>
            <div class="mb-3">
                <label for="confirm_pwd" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_pwd" name="confirm_pwd">
                <div id="emailHelp" class="form-text">Password and confirm password need to be same</div>
            </div>
            <button type="submit" class="btn btn-primary">SignUp</button>
        </form>
    </div>

    <!-- Botstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
</body>

</html>