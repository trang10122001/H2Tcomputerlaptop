<?php
    session_start();
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        define('BASE_URL', '../../');
        switch ($action) {
            case 'get-category-by-product-type':
                $productType = $_GET['productType'];
                getCategoryByProductType($productType);
                break;
            case 'get-all-brand':
                getAllBrand();
                break;
            case 'check-product-id':
                $productId = $_GET['productId'];
                isValidProductId($productId);
                break;
            case 'get-data-cart-for-chart':
                getDataCartForChart();
                break;
            case 'get-revenue-for-chart':
                getRevenueForChart();
                break;
            case 'get-data-bestseller-product-for-chart':
                getBestSellerProductForChart();
                break;
        }
    }

    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        define('BASE_URL', '../../');
        switch ($action) {
            case 'change-password':
                $currentPassword = $_POST['currentPassword'];
                $newPassword = $_POST['newPassword'];
                $csrfToken = $_POST['csrfToken'];
                $email = $_POST['email'];
                updatePassword([
                    'currentPassword' => $currentPassword, 
                    'newPassword' => $newPassword, 
                    'csrfToken' => $csrfToken, 
                    'email' => $email, 
                ]);
                break;
        }
    }


    function isValidProductId($productId) {
        include_once "../../database/dbhelper.php";
        $sql = "select * from product where product_id = ?";
        
        $data = executeGetDataBindParam($sql, "s", [$productId]);
        if (count($data) > 0) {
            echo json_encode(false);
        }
         else {
            echo json_encode(true);
         }
    }

    function getCategoryByProductType($productType) {
        include_once "../../database/dbhelper.php";
        $sql = "select category.id as id, category.name as name from category, product_type
                where category.type = product_type.id
                and category.type = ?";
        
        $data = executeGetDataBindParam($sql, "s", [$productType]);
        echo json_encode($data);
    }

    function getAllBrand() {
        include_once "../../database/dbhelper.php";
        $sql = "select * from brand";
        
        $data = executeGetData($sql);
        echo json_encode($data);
    }

    function getDataCartForChart() {
        include_once "../../database/dbhelper.php";

        $sql = "select count(*) as count, DATE(createdAt) as date from cart 
                GROUP by DATE(createdAt)";
        
        $data = executeGetData($sql);
        echo json_encode($data);
    }

    function getRevenueForChart() {
        include_once "../../database/dbhelper.php";

        $sql = "select sum(total) as total, DATE(createdAt) as date from cart 
                where status = 3
                GROUP by DATE(createdAt)";
        
        $data = executeGetData($sql);
        echo json_encode($data);
    }
   
    function getBestSellerProductForChart() {
        include_once "../../database/dbhelper.php";

        $sql = "select product.product_id, product.name, count(*) as count from product, cart_detail
                where product.product_id = cart_detail.product_id
                GROUP by product.product_id, product.name
                order by count(*) desc
                limit 4";
        
        $data = executeGetData($sql);
        echo json_encode($data);
    }

    function updatePassword($input) {
        include_once "../../database/dbhelper.php";


        $csrfToken = $input['csrfToken'];

        if ($csrfToken == $_SESSION['csrf-token']) {
            $currentPassword = $input['currentPassword'];

            $sql = "select * from administrator where email = ? and password = ?";
            $verify = executeGetDataBindParam($sql, "ss", [$input['email'], md5($currentPassword)]);
    
            if (count($verify) > 0) { // mat khau hien tai dung
                $newPassword = $input['newPassword'];
                $hashPassword = md5($newPassword);
    
                $sqlUpdatePassword = "update administrator set password = ? where email = ?";
                $result = executeSqlBindParam($sqlUpdatePassword, "ss", [$hashPassword, $input['email']]);
                echo json_encode($result);
            } else {
                echo json_encode(false);
            }
        } else {
            echo json_encode(false);
        }

        

    }
 
?>