<?php
    session_start();
    
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        define('BASE_URL', '../../');
        switch ($action) {
            case 'add-cart':
                $customerId = $_POST['customerId'];
                $fullName = $_POST['fullName'];
                $phoneNumber = $_POST['phoneNumber'];
                $email = $_POST['email'];
                $fullAddress = $_POST['fullAddress'];
                $total = $_POST['total'];
                $payMethod = $_POST['payMethod'];
                handleAddCart([
                    'customerId' => $customerId,
                    'fullName' => $fullName,
                    'phoneNumber' => $phoneNumber,
                    'email' => $email,
                    'fullAddress' => $fullAddress,
                    'total' => $total,
                    'payMethod' => $payMethod,
                ]);
                break;
            case 'update-status-cart':
                $cartId = $_POST['cartId'];
                $status = $_POST['status'];
                updateStatusCart($cartId, $status);
                break;
        }
    }

    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        define('BASE_URL', '../../');
        switch ($action) {
            case 'get-cart-info':
                $cartId = $_GET['cartId'];
                getCartInfo($cartId);
                break;
        }
    }


   
    function handleAddCart($arrayCartInfo) {
        include_once "../../utility/utility.php";
        include_once "../../database/dbhelper.php";

        $customerId = $arrayCartInfo['customerId'];
        $fullName = $arrayCartInfo['fullName'];
        $phoneNumber = $arrayCartInfo['phoneNumber'];
        $email = $arrayCartInfo['email'];
        $fullAddress = $arrayCartInfo['fullAddress'];
        $total = $arrayCartInfo['total'];
        $payMethod = $arrayCartInfo['payMethod'];

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $createdAt = date("Y-m-d H:i:s");


        $cartId = randomString(10);
        $sql = "insert into cart(cart_id, customer_id, fullName, phoneNumber, email, address, createdAt, total,
                payMethod, status) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $result1 = executeSqlBindParam($sql, "sssssssiii", [$cartId, $customerId, $fullName, $phoneNumber, $email, $fullAddress, $createdAt, $total, $payMethod, 0]);

        $cart = $_SESSION['cart'];

        if ($result1) {
            foreach ($cart as $key => $value) {
                $total = $value['quantity'] * $value['price'];
                $sql = "insert into cart_detail values(?, ?, ?, ?)";
                executeSqlBindParam($sql, "ssii", [$cartId, $value['product_id'], $value['quantity'], $total]);
            }

            unset($_SESSION['cart']);
        }
        
        echo json_encode($result1);
    }

    function getCartInfo($cartId) {
        include_once "../../database/dbhelper.php";

        $sql = "select * from cart_detail, product
        where cart_detail.cart_id = ?
        and cart_detail.product_id = product.product_id";
        $data = executeGetDataBindParam($sql, "s", [$cartId]);

        if (count($data) > 0) {
            echo json_encode([
                'message' => 'success',
                'data' => $data
            ]);
        } else {
            echo json_encode([
                'message' => 'error',
                'data' => []
            ]);
        }

    }

    function updateStatusCart($cartId, $status) {
        include_once "../../database/dbhelper.php";

        $sql = "update cart set status = ? where cart_id = ?";
       
        $result = executeSqlBindParam($sql, "is", [$status, $cartId]);

        echo json_encode($result);
    }
 
?>
