<?php
include('./database.php');
session_start();


$db = new database();

if (isset($_POST['register'])) {
    $username_a = $_POST['username_a'];
    $lastname_a = $_POST['lastname_a'];
    $password = $_POST['password_a'];
    $email_a = $_POST['email_a'];
    $img = $_FILES['img_a'];
    $fileNew = $db -> uploadFile($img);

    $data = [
        'username_a' => $username_a,
        'lastname_a' => $lastname_a,
        'password_a' => $password,
        'email_a' => $email_a,
        "img_a" => $fileNew,
        
    ];

    $db->insertWhere('admin', $data,"(SELECT name_a FROM admin WHERE name_a = '$username')");

    if ($db->mysqli->affected_rows > 0) {
        $_SESSION['alert'] = 'Register Success !';
        header('location:' . $_SERVER['REQUEST_URI']);
        return;
    } else {
        $_SESSION['alert'] = 'Error Register !';
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

    <input type="text" placeholder="username" name="username_a"
        class="form-control mb-3 shadow-sm">

    <input type="text" placeholder="lastname_a" name="lastname_a"
    class="form-control mb-3 shadow-sm">

    <input type="text" placeholder="email_a" name="email_a"
        class="form-control mb-3 shadow-sm">
    <hr>
    
    <input type="text" placeholder="password" name="password_a"
        class="form-control mb-3 shadow-sm" style="border-radius:20px"
        id="">
    <input type="text" placeholder="password Confirm" name="password-con"
        class="form-control mb-3 shadow-sm" style="border-radius:20px"
        id="">
    <input type="file" placeholder="" name="img_a"
        class="form-control mb-3 shadow-sm" style="border-radius:20px"
        id="">
        
    <div class="row">
        <div class="col">
            <button type="submit" class="btn btn-outline-primary"
                name="register"
                style="border-radius:20px">สมัครสมาชิก</button>
        </div>
        <div class="col mt-auto text-center"><a href="./login.php"
                class="link-primary">มีบัญชีอยู่แล้ว</div>
</form>
</div>

    </div>
</body>
</html>