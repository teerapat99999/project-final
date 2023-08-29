<?php
include('./database.php');
session_start();


$db = new database();

if (isset($_POST['login'])) {
    $username = $_POST['name_a'];
    $password = $_POST['password'];
    

    $db->select("admin","*","name_a = '$username' AND password = '$password'");

    if ($db-> query -> num_rows > 0) {

        $fetch  = $db -> query -> fetch_object();
        $_SESSION['userid'] = $fetch -> id_u;
        
        if($fetcb -> type === 'user'){
            $_SESSION['alert'] = 'user';
            header('location:');
            return;
        } else {
            $_SESSION['alert'] = 'admin !';
            header('location:');
            return;
        }
        return;
        } else {
        $_SESSION['alert'] = 'Username / Password Wrong !!';
        header('location:' . $_SERVER['REQUEST_URI']);
        return;
    }
     
   
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</head>
<body>
    <div class="conteiner">
<form action="" method="post">

<div class="form-container m-4">
    <h3 class="text-container mb-4">Register</h3>

    <input type="text" placeholder="username" name="username"
        class="form-control mb-3 shadow-sm">
    <hr>
    <input type="password" placeholder="password" name="password"
        class="form-control mb-3 shadow-sm">
    
        
    <div class="row">
        <div class="col">
            <button type="submit" class="btn btn-outline-primary"
                name="login"
                style="border-radius:20px">เข้าสู่ระบบ</button>
        </div>
        <div class="col mt-auto text-center"><a href="./index.php"
                class="link-primary">มีบัญชีอยู่แล้ว</div>
</form>
</div>

    </div>