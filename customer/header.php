<?php


    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    include_once BASE_URL."database/dbhelper.php";
    include_once BASE_URL."utility/utility.php";

    $isNext = false;
   
    if (isset($_SESSION['customer_id'])) {
        $customerId = $_SESSION['customer_id'];
        $sqlGetCustomer = "select * from customer where customer_id = ?";
        $customer = executeGetDataBindParam($sqlGetCustomer, "s", [$customerId]);
        if (count($customer) > 0) {
            $isNext = true;
            $customerInfo = $customer[0];

            $sqlGetAddress = "select * from address where customer_id = ?";
            $addressResult = executeGetDataBindParam($sqlGetAddress, "s", [$customerId]);
        }
        
    }

    if (!$isNext) {
        header("Location: ".BASE_URL."authen/login.php");
    } 


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/customer.css">
    <title>H2T COMPUTER - Quản trị viên</title>
</head>
<body>

    <div class="admin-wrapper">
        <nav class="nav">
            <ul class="navbar full">
                <li class="nav-item bars">
                    <a href=""><i class="fa-solid fa-bars"></i></i></a>
                </li>
                <li class="nav-item">
                    <a href="../index.php">Về Website</a>
                </li>
            </ul>
            <ul class="navbar ml-auto">
                <li class="nav-item">
                    <a href="<?=BASE_URL?>authen/logout.php">Đăng xuất</a>
                </li>
            </ul>

        </nav>


        <div class="main-sidebar active">
            <div class="logo">
                <a href="">
                    <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="">
                    <span>Chào, <?=$customerInfo['given_name']?></span>
                </a>
            </div>
            <div class="sidebar-container">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="./index.php">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Thông tin tài khoản</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./MyCart.php">
                            <i class="fa-regular fa-user"></i>
                            <span>Đơn hàng</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./ChangePassword.php">
                            <i class="fa-solid fa-keyboard"></i>
                            <span>Bảo mật</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
