<?php
    function createMenuRecursive($source, $parent, $level, &$result)
    {
        if (!defined('BASE_URL')) {
            define('BASE_URL', './');
        }
        if (count($source) > 0) {
            if ($level == 0) {
                $result .= '<ul class="nav-category">';
            }
            else if ($level == 1) {
                $result .= '<div class="wrapper-subcate"><ul class="sub-category">';
            } else {
                $class = 'sub-category level'.$level.'';
                $result .= '<ul class="'.$class.'">';
            }
            foreach ($source as $key => $value) {
                if ($value['parent_id'] == $parent) {
                    // $value['level'] = $level;
                    $isFirst = true;
                    if ($level == 0) {
                        if ($value['type'] == 1) {
                            $value ['name'] = '<a href="'.BASE_URL.'laptop.php"><i class="fas bi-laptop"></i> '.$value['name'].'</a>';
                        } 
                        else if ($value['type'] == 2) {
                            $value['name'] = '<a href="'.BASE_URL.'cpu.php"><i class="fas bi-laptop"></i> '.$value['name'].'</a>';
                        }
                        else if ($value['type'] == 3){
                            $value['name'] = '<a href="'.BASE_URL.'monitor.php"><i class="fas bi-laptop"></i> '.$value['name'].'</a>';
                        }
                        else if ($value['type'] == 4){
                            $value['name'] = '<a href="'.BASE_URL.'hard_drive.php"><i class="fas bi-laptop"></i> '.$value['name'].'</a>';
                        }
                        
                    }
                    else if ($level == 1){
                            if ($value['type'] == 1) {
                                $value ['name'] = '<a class="'.$value['slug'].' subcate-title" href="'.BASE_URL.'laptop.php">'.$value['name'].'</a>';
                            }
                            else if ($value['type'] == 2){
                                $value ['name'] = '<a class="subcate-title" href="'.BASE_URL.'cpu.php">'.$value['name'].'</a>';
                            }
                            else if ($value['type'] == 3){
                                $value ['name'] = '<a class="subcate-title" href="'.BASE_URL.'monitor.php?c='.$value['slug'].'">'.$value['name'].'</a>';
                            }
                            else if ($value['type'] == 4){
                                $value ['name'] = '<a class="subcate-title" href="'.BASE_URL.'hard_drive.php?type='.$value['slug'].'">'.$value['name'].'</a>';
                            }
                    }
                    else { // level 2
                        $slug_parent = findSlugParent($source, $value['id']);
                        if ($value['type'] == 1) {
                            $value ['name'] = '<a href="'.BASE_URL.'laptop.php?q='.$value['slug'].'">'.$value['name'].'</a>';
                        }
                        else if ($value['type'] == 2) {
                            $value ['name'] = '<a href="'.BASE_URL.'cpu.php?'.$slug_parent.'='.$value['slug'].'">'.$value['name'].'</a>';
                        }
                        else if ($value['type'] == 3){
                            $value ['name'] = '<a href="'.BASE_URL.'monitor.php?q='.$value['slug'].'">'.$value['name'].'</a>';
                        }
                        else {
                            $value ['name'] = '<a href="'.BASE_URL.'hard_drive.php?type='.$slug_parent.'&size='.$value['slug'].'">'.$value['name'].'</a>';
                        }
                    }
                    $result .= '<li class="category-item-menu">' . $value['name'];
                    $new_parent = $value['id'];
                    createMenuRecursive($source, $new_parent, $level + 1, $result);
                    $result .= '</li>';
                }
            }
            if ($level == 1) {
                $result .= '</ul></div>';
            } else
                $result .= '</ul>';
        }
    }

    function findSlugParent($source, $id)
    {
        if (!defined('BASE_URL')) {
            define('BASE_URL', './');
        }
        if (count($source) > 0) {
            $parent_id = '';
            foreach ($source as $key => $value) {
                if ($value['id'] == $id) {
                    $parent_id = $value['parent_id'];
                    break;
                }
            }
            if ($parent_id != '') {
                foreach ($source as $key => $value) {
                    if ($value['id'] == $parent_id) {
                        return $value['slug'];
                    }
                }
            }
            
        }
    }

    function findAllChildCategories($source, $id, &$result) {

        if (!defined('BASE_URL')) {
            define('BASE_URL', './');
        }
        if (count($source) > 0) {
            foreach ($source as $key => $value) {
                if ($value['parent_id'] == $id) {
                    $result[] = $value['id'];
                    $new_parent = $value['id'];
                    findAllChildCategories($source, $new_parent, $result);
                }
            }
        }
    }

    function randomString($length) {
        $source = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*';

        $result = '';

        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, strlen($source) - 1);
            $result .= $source[$index];
        }

        return $result;
    }

    function sendMailCustomerInformation($mail, $receiver) {
        if (!defined('BASE_URL')) {
            define('BASE_URL', './');
        }

        try {
        //Server settings
            $mail->isSMTP();     
            $mail->CharSet  = "utf-8";                                     
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth   = true;                                  
            $mail->SMTPSecure = "ssl";          
            $mail->Host       = 'http://h2tcomputer.com/';                     
            $mail->Port       = 465;                                    
            $mail->Username   = 'H2Tcomputer@gmail.com';                    
            $mail->Password   = '123';                              
            
            //Recipients
            $mail->setFrom('H2Tcomputer@gmail.com', 'H2T COMPUTER');
            $mail->addAddress($receiver['email'], $receiver['name']);     
            $mail->addReplyTo('H2Tcomputer@gmail.com', 'H2T COMPUTER');

            //Content
            $mail->isHTML(true);                                  
            $mail->Subject = 'Thông tin tài khoản - H2T Computer';
            $mail->Body    = ' <html>
                                    <body>
                                        <p>Xin chào '.$receiver['name'].',</p>
                                        <p>Cảm ơn bạn đã đăng ký tài khoản tại H2T Computer.</p>
                                        <p>Để đăng nhập, hãy sử dụng thông tin tài khoản dưới đây:</p>
                                        <p><b>Tài khoản</b>: <i>'.$receiver['email'].'</i></p>
                                        <p><b>Mật khẩu</b>: <i>'.$receiver['password'].'</i></p>
                                        <p>Trân trọng,</p>
                                        <p><b>H2T COMPUTER</b></p>
                                    </body>
                                </html>';

            $mail->send();
            return true;

            } catch (Exception $e) {
                return false;
        }

    }


    function pagination($totalPage, $currentPage) {
        if ($totalPage <= 1) {
            return;
        } 
        echo   '<nav class="pagination-container">
                        <ul class="pagination">';
        if ($currentPage > 1) {
            echo '<li class="page-item"><a class="page-link" href="?page='.($currentPage-1).'">Previous</a></li>';
        }
                                    
        $availablePage = [1, $currentPage - 1, $currentPage, $currentPage + 1, $totalPage];
        $isFirst = $isLast = false;
        for ($i = 0; $i < $totalPage; $i++) {
            if (!in_array($i + 1, $availablePage)) {
                if (!$isFirst && $currentPage > 3) {
                    echo '<li class="page-item"><a class="page-link" href="?page='.($currentPage-2).'">...</a></li>';
                    $isFirst = true;
                }
                if (!$isLast && ($i+1) > $currentPage) {
                    echo '<li class="page-item"><a class="page-link" href="?page='.($currentPage+2).'">...</a></li>';
                    $isLast = true;
                }
                continue;
            }
            if ($currentPage == ($i + 1)) {
                echo '<li class="page-item active"><a class="page-link" href="#">'.($i+1).'</a></li>';
            } else {
                echo '<li class="page-item "><a class="page-link" href="?page='.($i+1).'">'.($i+1).'</a></li> ';
                
            }
        }

        if ($currentPage < $totalPage) {
            echo '<li class="page-item"><a class="page-link" href="?page='.($currentPage+1).'">Next</a></li>';
        }
        echo '  </ul>
            </nav>';
                                     
    }

    function middlewareisRoleAdmin($email) {
        if (!defined('BASE_URL')) {
            define('BASE_URL', './');
        }

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        include_once BASE_URL."database/dbhelper.php";
    
        $sql = "select * from administrator where email = ?";
        $admin = executeGetDataBindParam($sql, "s", [$email]);
        if (count($admin) > 0) {
            return true;
        }
        return false;
    
    }

?>