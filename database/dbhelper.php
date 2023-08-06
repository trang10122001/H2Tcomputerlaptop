<?php
    function executeGetDataBindParam($sql, $dataType, $param) {
       
        if (!defined('BASE_URL')) {
            define('BASE_URL', './');
        }
        include BASE_URL."database/connect.php";

        $stmt = $connect->prepare($sql);
        $stmt->bind_param($dataType, ...$param);   
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $stmt->close();     
        $connect->close();
        return $data;
    }

    function executeGetData($sql) {
       
        if (!defined('BASE_URL')) {
            define('BASE_URL', './');
        }
        include BASE_URL."database/connect.php";

        $stmt = $connect->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $stmt->close();     
        $connect->close();
        return $data;
    }

    function executeSqlBindParam($sql, $dataType, $param) {
        if (!defined('BASE_URL')) {
            define('BASE_URL', './');
        }
        include BASE_URL."database/connect.php";

        $stmt = $connect->prepare($sql);
        $stmt->bind_param($dataType, ...$param); 
        // $flag = false; 
        if ($stmt->execute()) {
            $flag = true;
        } else {
            $flag = false;
        }
        $stmt->close();     
        $connect->close();
        return $flag;
    }
   
?>