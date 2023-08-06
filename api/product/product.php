<?php
    session_start();

    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        define('BASE_URL', '../../');
        switch ($action) {
            case 'filter-data-laptop':
                filterDataLaptop();
                break;
            case 'get-product-info':
                $id = $_GET['id'];
                getProductInfo($id);
                break;
            case 'search-product':
                $keyword = $_GET['keyword'];
                liveSearch($keyword);
                break;
            case 'get-list-laptop-brand':
                getListLaptopBrand();
                break;
        }
    }
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        define('BASE_URL', '../../');
        switch ($action) {
            case 'add-to-cart':
                $productId = $_POST['id'];
                $quantity = $_POST['quantity'];
                $productType = $_POST['productType'];
                addToCart($productId, $quantity, $productType);
                break;
            case 'delete-from-cart':
                $productId = $_POST['productId'];
                deleteItemFromCart($productId);
                break;
            case 'update-quantity-item':
                $productId = $_POST['productId'];
                $quantity = $_POST['quantity'];
                updateQuantityItem($productId, $quantity);

        }
    }
    function getProductInfo($id) {
        include_once "../../database/dbhelper.php";
        $sql = "select * from product, laptop_specification
                where product_type = 1
                and product.product_id = '".$id."'
                and laptop_specification.product_id = product.product_id";
        
        $data = executeGetData($sql);
        $data = $data[0];
        echo json_encode($data);
    }
    function filterDataLaptop() {
        include_once "../../database/connect.php";
        include_once "../../database/dbhelper.php";
        $sql = "select * from product, laptop_specification
                where product.product_id = laptop_specification.product_id
                and product.product_type = 1";
        
        if (isset($_GET["brand"])) {
            $brandFilter = implode(',', $_GET['brand']);

            $sql .= " and product.brand IN(".$brandFilter.")";
        }
        if (isset($_GET['cpu'])) {
            $cpuFilter = implode("','", $_GET['cpu']);
            $sql .= " and cpu IN('".$cpuFilter."')";
        }
        if (isset($_GET['demand'])) {
            $demandFilter = implode("','", $_GET['demand']);
            $sql .= " and category_id IN('".$demandFilter."')";
        }
        if (isset($_GET['ram'])) {
            $ramFilter = implode("','", $_GET['ram']);
            $sql .= " and ram IN('".$ramFilter."')";
        }
        if (isset($_GET['hardDrive'])) {
            $hardDriveFilter = implode("','", $_GET['hardDrive']);
            $sql .= " and hard_drive_size IN('".$hardDriveFilter."')";
        }
        
        $data = executeGetData($sql);
        $pageSize = 4;

        $countData = count($data);
        $totalPage = ceil($countData / $pageSize);

        $page = 1;
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        }

        $start = ($page - 1) * $pageSize;
        $sql .= " limit ".$start.", ".$pageSize."";

        $dataOfPage = executeGetData($sql);

        if (count($dataOfPage) > 0) {
            echo json_encode([
                'data' => $dataOfPage,
                'totalPage' => $totalPage,
                'currentPage' => $page,
            ]);
        }
        else echo json_encode([
            'data' => [],
        ]);
    }
    function liveSearch($keyword) {
        include_once "../../database/dbhelper.php";
        $paramSearch = "%" . $keyword . "%";
        $sqlSearch = "  select * from product
                        where product.name like ?";
        $data = executeGetDataBindParam($sqlSearch, "s", [$paramSearch]);
        echo json_encode($data);
    }

    function getListLaptopBrand() {
        include_once "../../database/dbhelper.php";
        $sql = "select distinct brand.slug, brand.name from brand, product
                where brand.id = product.brand
                and product.product_type = 1";
        $data = executeGetData($sql);
       
        $out = array();
        foreach ($data as $key => $value) {
            $out[] = array(
                'slug' => $value['slug'],
                'name' => $value['name']
            );
        }
        echo json_encode($out);
    }

    function addToCart($productId, $quantity, $productType) {
        include_once "../../database/dbhelper.php";
        $sql = "select * from product where product_id = ?";
        $result = executeGetDataBindParam($sql, "s", [$productId]);

        $productPrice = $result[0]['price'];
        $discount = $result[0]['discount'];

        if ($discount != 0) {
            $productPrice = $productPrice - $productPrice * ($discount)/100;
            $productPrice = round($productPrice, -4);
        }

        $cart = [];
        if (isset($_SESSION['cart']))
            $cart = $_SESSION['cart'];

        
        $isFind = false;
        for ($i = 0; $i < count($cart); $i++) {
            if ($cart[$i]['product_id'] == $productId) {
                $isFind = true;
                $cart[$i]['quantity'] += $quantity;
                break;
            }
        }
        if (!$isFind) {
            $cart[] =  array(
                'product_id' => $productId, 
                'quantity' => $quantity, 
                'price' => $productPrice,
                'type' => $productType);
        }
        $_SESSION['cart'] = $cart;
        echo json_encode($cart);
    }

    function deleteItemFromCart($productId) {
        $cart = [];
        if (isset($_SESSION['cart']))
            $cart = $_SESSION['cart'];

        for ($i = 0; $i < count($cart); $i++) {
            if ($cart[$i]['product_id'] == $productId) {
                array_splice($cart, $i, 1);
                break;
            }
        }

        $_SESSION['cart'] = $cart;
        $out = array('status' => 'success', 'data' => $cart);
        echo json_encode($out);
    }

    function updateQuantityItem($productId, $quantity) {
        $cart = [];
        if (isset($_SESSION['cart']))
            $cart = $_SESSION['cart'];

        for ($i = 0; $i < count($cart); $i++) {
            if ($cart[$i]['product_id'] == $productId) {
                $cart[$i]['quantity'] = $quantity;
                break;
            }
        }
        $_SESSION['cart'] = $cart;
        $out = array('status' => 'success', 'data' => $cart);
        echo json_encode($out);
    }


?>
