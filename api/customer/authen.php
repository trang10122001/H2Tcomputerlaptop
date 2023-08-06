<?php
    session_start();
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        define('BASE_URL', '../../');
        switch ($action) {
            case 'register':
                $email = $_POST['email'];
                $givenName = $_POST['givenName'];
                $familyName = $_POST['familyName'];
                register($email, $familyName, $givenName);
                break;
            case 'login':
                $email = $_POST['email'];
                $password = $_POST['password'];
                login($email, $password);
                break;
        }
    }
    function register($email, $familyName, $givenName) {
        include_once "../../utility/utility.php";
        include_once "../../database/dbhelper.php";

        require_once '../../PHPMailer/src/Exception.php';
        require_once '../../PHPMailer/src/PHPMailer.php';
        require_once '../../PHPMailer/src/SMTP.php';

        // Kiem tra tai khoan da ton tai hay chua ?

        $sqlAlreadyRegister = "select * from customer where email = ?";
        $customer = executeGetDataBindParam($sqlAlreadyRegister, "s", [$email]);

        if (count($customer) > 0) {
            echo json_encode(false);
        }
        else {
            $mailer = new PHPMailer(true);
            $password = randomString(10);
            $customerId = randomString(10);
            $hashPassword = md5($password);
            $receiver = array(
                    'email' => $email,
                    'name' => $givenName,
                    'password' => $password
                );
            $sqlInsert = "insert into customer(customer_id, email, password, family_name, given_name) values (?, ?, ?, ?, ?)";
            $isSuccess = executeSqlBindParam($sqlInsert, "sssss", [$customerId, $email, $hashPassword, $familyName, $givenName]);

            $result = sendMailCustomerInformation($mailer, $receiver);
    
            echo json_encode($result && $isSuccess);
           
        }
       
    }

    function login($email, $password) {
        include_once "../../database/dbhelper.php";

        $hashPassword = md5($password);

        $sql = "select * from customer where email = ? and password = ?";
        $customer = executeGetDataBindParam($sql, "ss", [$email, $hashPassword]);

        if (count($customer) > 0) {
            $_SESSION['customer_id'] = $customer[0]['customer_id'];
            echo json_encode(true);
        }
        else {
            echo json_encode(false);
           
        }

       
    }
 
?>
