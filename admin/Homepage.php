<?php
session_start();
include('./database.php');

$db = new database();

$db2 = new database();


if(isset($_POST['create_admin'])){
    $name_a =$_POST['name_a'];
    $lastname_a =$_POST['lastname_a'];
    $email_a = $_POST['email_a'];
    $password = $_POST['password'];
    $img = $_FILES['img'];

    $fileNew = $db -> uploadFile($img);
    
    $data=[
        "name_a" => $name_a,
        "lastname_a" => $lastname_a,
        "img_a" => $fileNew,
        "email_a" => $email_a,
        "password" => $password,
    ];

     $db -> insert("admin",$data);
    

     if($db -> query){
         $_SESSION['success'] = "เพิ่มข้อมูลสำเร็จ!";
       header('location:'.$_SERVER['REQUEST_URI']);
         return;
     }else{
        $_SESSION['alert'] ="เพิ่มข้อมูลไม่สำเร็จ";
       header('location:'.$_SERVER['REQUEST_URI']);
        return;
     }

    
}

if (isset($_POST['edit_admin'])) {
    $id = $_POST['id'];
    $name_a = $_POST['name_a'];
    $lastname_a = $_POST['lastname_a'];
    $email_a= $_POST['email_a'];
    $img = $_FILES['img'];
    $imgold = $_POST['imgold'];

    if($img['name'] != ""){
        $fileNew = $db -> uploadFile($img);
    }else{
        $fileNew = $imgold;
    }

    $data = [

        "name_a" => $name_a,
        "lastname_a" => $lastname_a,
        "img_a" => $fileNew,
        "email_a" => $email_a,
    
    ];

    $db -> update("admin",$data,"admin_id = $id");

    if($db -> query){
        $_SESSION['success'] = "แก้ไขข้อมูลสำเร็จ!";
      header('location:'.$_SERVER['REQUEST_URI']);
        return;
    }else{
       $_SESSION['alert'] ="แก้ไขข้อมูลไม่สำเร็จ!";
      header('location:'.$_SERVER['REQUEST_URI']);
       return;
    }
}

if(isset($_POST['edit_password'])) {
    $password = $_POST['password_o'];
    $pass_new = $_POST['password_new'];
    $pass_new2 = $_POST['password_new2'];
    $id = $_POST['id'];

    if($pass_new != $pass_new2){
        $_SESSION['alert'] ="รหัสผ่านไม่ตรงกัน!";
        header('location:'.$_SERVER['REQUEST_URI']);
         return;

      }else{

        $result_check = $db -> mysqli -> query("SELECT * FROM admin WHERE admin_id = $id AND password = $password");

        if($result_check -> num_rows > 0){

            $db -> mysqli -> query("UPDATE admin SET password = $pass_new WHERE admin_id = $id");
            if($db -> mysqli -> affected_rows > 0){
                echo "Edit Password";
            }else{
                echo "Not Edit password";
            }
        }
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
    <div class="container">
        <div class="col-8">
            <?php include('./error.php')  ?>
            <form action="" method="post" enctype="multipart/form-data">

                <div class="form-container m-4">
                    <h3 class="text-container mb-4">รายชื่อผู้ดูแลระบบ</h3>
                    <input type="text" placeholder="ชื่อ" name="name_a" class="form-control mb-3 shadow-sm"
                        style="border-radius:20px" id="foodname" required>

                    <input type="text" placeholder="นามสกุล" name="lastname_a" id="lastname_a"
                        class="form-control mb-3 shadow-sm" style="border-radius:20px" required>
                    <hr>
                    <input type="text" placeholder="อีเมล" name="email_a" id="email_a"
                        class="form-control mb-3 shadow-sm" style="border-radius:20px" required>

                    <input type="password" placeholder="รหัส" name="password" id="password"
                        class="form-control mb-3 shadow-sm" style="border-radius:20px" required>

                    <input type="file" name="img" class="form-control mb-3 shadow-sm" id="" style="border-radius:20px">


                    <button type="submit" class="btn btn-outline-primary" name="create_admin"
                        style="border-radius:20px">เพิ่มข้อมูล</button>
                </div>
            </form>

        </div>

        <div class="row row-cols-md-3">
            <?php 
                $db_2 = new database();
                $db_2 -> select("admin","*");
                while($fetch_admin = $db_2 -> query -> fetch_object())
                {?>
            <div class="col mt-4">
                <div class="card">
                    <img src="./image/<?= $fetch_admin -> img_a ?>" class="card-img-top"
                        alt="Hollywood Sign on The Hill" style="height:250px;object-fit:cover;" />

                    <div class="card-body">

                        <h5 class="card-title"><?= $fetch_admin->name_a ?></h5>
                        <p class="card-text">รหัส : <?= $fetch_admin->password ?></p>

                    </div>
                    <form action="" method="post" enctype="multipart/form-data">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#exampleModal<?= $fetch_admin -> admin_id ?>">
                            แก้ไขข้อมูล
                        </button>


                        <div class="modal fade" id="exampleModal<?= $fetch_admin->admin_id ?>" tabindex="-1">

                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">แก้ไขข้อมูล</h5>

                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id" value="<?= $fetch_admin->admin_id ?>">
                                        <input type="hidden" name="imgold" value="<?= $fetch_admin->img_a ?>">

                                        <div class="form-container m-4">
                                            <h3 class="text-container mb-4">รายชื่อผู้ดูแลระบบ</h3>
                                            <input type="text" placeholder="ชื่อ" name="name_a"
                                                class="form-control mb-3 shadow-sm" style="border-radius:20px"
                                                id="foodname" required>

                                            <input type="text" placeholder="นามสกุล" name="lastname_a" id="lastname_a"
                                                class="form-control mb-3 shadow-sm" style="border-radius:20px" required>
                                            <hr>
                                            <input type="text" placeholder="อีเมล" name="email_a" id="email_a"
                                                class="form-control mb-3 shadow-sm" style="border-radius:20px" required>

                                            <input type="file" name="img" class="form-control mb-3 shadow-sm" id=""
                                                style="border-radius:20px">

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="edit_admin" class="btn btn-primary">Save
                                            changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                    <form action="" method="post">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#example<?= $fetch_admin -> admin_id ?>">
                            แก้ไขรหัสผ่าน
                        </button>


                        <div class="modal fade" id="example<?= $fetch_admin->admin_id ?>" tabindex="-1">

                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="">แก้ไขข้อมูล</h5>

                                    </div>
                                    <div class="modal-body">

                                        <input type="hidden" name="id" value="<?= $fetch_admin->admin_id ?>">
                                        <div class="form-container m-4">


                                            <input type="text" placeholder="รห้สผ่านปัจจุบัน" name="password_o" id=""
                                                class="form-control mb-3 shadow-sm" style="border-radius:20px"
                                                required />

                                            <input type="text" placeholder="รห้สผ่านใหม่" name="password_new" id=""
                                                class="form-control mb-3 shadow-sm" style="border-radius:20px"
                                                required />
                                            <input type="text" placeholder="รห้สผ่านใหม่ยืนยัน" name="password_new2"
                                                id="" class="form-control mb-3 shadow-sm" style="border-radius:20px"
                                                required />
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="edit_password" class="btn btn-primary">Save
                                            password</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

</body>

</html>