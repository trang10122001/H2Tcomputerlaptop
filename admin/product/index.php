<?php
    define('BASE_URL', '../../');
    define('BASE_URL_ADMIN', '../');

    include_once BASE_URL."database/dbhelper.php";

    $pageSize = 5;
    $page = 1;
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    }

    if ($page <= 0) {
        $page = 1;
    }

    $start = ($page - 1) * $pageSize;


    $sql = "select product.*,  category.name as category_name from product, category
            where product.category_id = category.id
            order by createdAt desc
            limit ".$start.", ".$pageSize."";
    $sqlGetTCount = "select count(product_id) as total
                        from product";
    $countResult = executeGetData($sqlGetTCount);

    $count = $countResult[0]['total'];
    $totalPage = ceil($count / $pageSize);
    $data =  executeGetData($sql);

    include_once "../partials/header.php";

?>
     
        <div class="content-wrapper">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Danh sách sản phẩm</h5>
                        </div>
                        <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Mã sản phẩm</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Danh mục</th>
                                    <th>Trạng thái</th>
                                    <th>Giá tiền (VND)</th>
                                    <th>Ngày thêm</th>
                                    <th>Giảm giá (%)</th>
                                    <th colspan="2">Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
    $status = ['Hết hàng', 'Còn hàng'];
    foreach ($data as $key => $value) {
        if ($value['status'] == 1) {
            $statusClass = "btn-success";
        } else {
            $statusClass = "btn-secondary";
        }
        if (!$value['createdAt']) {
            $value['createdAt'] = '';
        }
        echo '<tr>
                <td class="text-center">'.(++$start).'</td>
                <th>'.$value['product_id'].'</th>
                <td>'.$value['name'].'</td>
                <td>'.$value['category_name'].'</td>
                <td class="text-center"><button class="btn '.$statusClass.'">'.$status[$value['status']].'</button></td>
                <td class="text-center">'.number_format($value['price'], 0, ',', '.').'</td>
                <td class="text-center">'.$value['createdAt'].'</td>
                <td class="text-center">'.$value['discount'].'</td>
                <td><a href="./update.php?product_id='.$value['product_id'].'" class="btn btn-primary">Update</a></td>
                <td><button class="btn btn-danger">Delete</button></td>
            </tr>';
    }

?>
                            </tbody>
                            </table>
    <?php
        pagination($totalPage, $page);
    ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Close admin-wrapper -->
    </div>


</body>
</html>