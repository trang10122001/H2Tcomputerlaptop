<?php 
     if (!defined('BASE_URL_ADMIN')) {
        define('BASE_URL_ADMIN', './');
    }

    if (!defined('BASE_URL')) {
        define('BASE_URL', '../');
    }
  
?>
<?php

include_once BASE_URL."database/dbhelper.php";
session_start();

if (isset($_POST['submit-login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashPassword = md5($password);
    $sqlLogin = "select * from administrator where email = ? and password = ?";
    $data = executeGetDataBindParam($sqlLogin, "ss", [$email, $hashPassword]);

    if (count($data) > 0) {
        $_SESSION['email'] = $email;
        header("Location: ./index.php");
    }
    else {
        $message = 'Thất bại! Tài khoản hoặc mật khẩu không đúng!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost:80/camcomputer/admin/css/reset.css">
    <link rel="stylesheet" href="http://localhost:80/camcomputer/admin/css/app.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <link rel="stylesheet" type="text/css" href="http://localhost:80/camcomputer/Public/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="http://localhost:80/camcomputer/Public/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="http://localhost:80/camcomputer/Public/css/util.css">
    <link rel="stylesheet" type="text/css" href="http://localhost:80/camcomputer/Public/css/main.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"
        integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>

    <style>

    </style>
    <title>ADMIN</title>
</head>

<body class=" bg-gradient" style="background: url('http://localhost:80/camcomputer/public/image/1.jpg');
">

    <div class="" id="wrapper">


        <form action="" method="POST" id="form-login">

            <h1 class="form-heading">ĐĂNG NHẬP</h1>
            <p class="login-message error"><?php if (isset($message)) echo $message; ?></p>

            <div class="form-group" data-validate="Enter email">
                <i class="far fa-user"></i>
                <input type="text" class="form-input" name="email" id="input-email" required="true"
                    placeholder="Tên đăng nhập">
                <div class="valid-feedback"> Looks good!</div>
            </div>

            <div class="form-group" data-validate="Enter password">
                <i class="fas fa-key"></i>
                <input type="password" class="form-input" name="password" required="true" placeholder="Mật khẩu">
                <div id="eye">
                    <i class="far fa-eye"></i>
                </div>
            </div>



            <button class="form-submit" name="submit-login" value="Đăng nhập" type="submit">Đăng
                nhập</button>


            <div class="text-center p-t-57 p-b-20">
                <span class="txt1">Or login with</span>
            </div>
            <div class="flex-c p-b-112">
                <a href="#" class="login100-social-item">
                    <img src="http://localhost:80/camcomputer/Public/images//facebook-icon-download-vector-29.jpg"
                        alt="FACEBOOK">
                </a>
                <a href="#" class="login100-social-item">
                    <img src="http://localhost:80/camcomputer/Public/images//icon-google.png" alt="GOOGLE">
                </a>
            </div>
            <div class="text-center">
                <a href="http://localhost:80/camcomputer/Login/Change" class="txt2 hov1">Đổi mật khẩu?</a>
                <a class="txt2 hov1" aria-current="page" href="../index.php">Xem Website</a>
            </div>




        </form>
    </div>


</body>