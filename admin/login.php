<?php
session_start();
ob_start();
include_once "../script/user.script.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz App</title>
    <link rel="stylesheet" href="style.ad.css">
    <link rel="stylesheet" href="../assets/bootstrap-5.0.2-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/ti-icons/css/themify-icons.css">
</head>
<body>
    <div class="container bod col-lg-5 col-10 mt-5 p-5">
        <h5>Admin Login</h5>
        <form action="" class="was-validated" method="post">
            <div class="form-group">
                <label for="fullname">Admin Id:</label>
                <input type="text" class="form-control" id="adminid"  name="adminid" required>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" id="pwd2"  name="pswd" required>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <button type="submit" class="btn btn-primary col-lg-5 mt-2" name="adlogin">Login</button>
        </form>
    </div>
</body>
</html>

<?php

    if (isset($_POST['adlogin'])) {
        $adminid = $_POST['adminid'];
        $pwd = $_POST['pswd'];
        adlogin($adminid,$pwd);
    }

?>