<?php
    define('BASE_URL', '../../');
    define('BASE_URL_ADMIN', '../');

    include_once BASE_URL."database/dbhelper.php";

    // $pageSize = 5;
    // $page = 1;
    // if (isset($_GET['page'])) {
    //     $page = $_GET['page'];
    // }

    // if ($page <= 0) {
    //     $page = 1;
    // }

    // $start = ($page - 1) * $pageSize;


    $sql = "select * from cart order by createdAt desc";
    // $sqlGetTCount = "select count(product_id) as total
    //                     from product";
    // $countResult = executeGetData($sqlGetTCount);

    // $count = $countResult[0]['total'];
    // $totalPage = ceil($count / $pageSize);
    $data =  executeGetData($sql);

    $arrStatus = ['Đang chờ xử lý', 'Đã tiếp nhận', 'Đang vận chuyển', 'Đã giao hàng'];

    include_once "../partials/header.php";

?>
<style>
.content-wrapper .table {
    font-size: 15px;
}

.form-select {
    font-size: 15px;
}
</style>
<div class="container-cart-detail">
    <div class="cart-detail-content">
        <div class="header">
            <h5 class="card-title">Chi tiết đơn hàng</h5>
            <i class="fas fa-times btn-close"></i>
        </div>
        <div class="body">
            <table class="table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Hình ảnh</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody id="cart-detail-tbody">

                </tbody>
            </table>
        </div>
    </div>
</div>

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
                                <th>Mã đơn hàng</th>
                                <th>Mã KH</th>
                                <th>Người nhận</th>
                                <th>SĐT</th>
                                <th>Email</th>
                                <th>Địa chỉ</th>
                                <th>Ngày mua</th>
                                <th>Tổng tiền</th>
                                <th>Tình trạng</th>
                                <th>Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
       if (count($data) > 0) {
            $start = 0;
            foreach ($data as $key => $value) {
                echo '<tr>
                        <td class="text-center">'.(++$start).'</td>
                        <th>'.$value['cart_id'].'</th>
                        <th>'.$value['customer_id'].'</th>
                        <td>'.$value['fullName'].'</td>
                        <td>'.$value['phoneNumber'].'</td>
                        <td>'.$value['email'].'</td>
                        <td>'.$value['address'].'</td>
                        <td>'.$value['createdAt'].'</td>
                        <td class="text-center">'.number_format($value['total'], 0, ',', '.').'đ</td>';
            echo '<td><select class="status-cart form-select status-'.$value['status'].'" data-id="'.$value['cart_id'].'">';
                foreach ($arrStatus as $key => $item) {
                    if ($value['status'] == $key) {
                        echo '<option selected value="'.$key.'">'.$item.'</option>';
                    } else {
                        echo '<option value="'.$key.'">'.$item.'</option>';

                    }
                }
            echo '</select></td>';
                        
                echo '<td><button data-id="'.$value['cart_id'].'" class="btn btn-show-cart-detail"><i class="fa-solid fa-eye"></i></button></td>
                    </tr>';
            }
       } 
    ?>
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>
</div>


<!-- Close admin-wrapper -->
</div>

<script>
$(document).ready(function() {
    $('.btn-show-cart-detail').click(function() {
        const cartId = $(this).data('id')
        handleGetCartInfo(cartId)
        $('.container-cart-detail').addClass('active')
    })

    $('.container-cart-detail .btn-close').click(function() {
        $('.container-cart-detail').removeClass('active')
    })


    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('status-cart')) {
            const cartId = e.target.getAttribute('data-id')
            const status = parseInt(e.target.value)
            updateStatusCart(cartId, status)
        }
    })

})

function updateStatusCart(cartId, status) {
    $.ajax({
        url: '<?=BASE_URL?>api/cart/cart.php',
        type: 'post',
        data: {
            action: 'update-status-cart',
            cartId,
            status
        },
        dataType: 'json',
        success: function(result) {
            const arrStatus = ['Đang chờ xử lý', 'Đã tiếp nhận', 'Đang vận chuyển', 'Đã giao hàng'];

            if (result) {
                let html = `<select class="status-cart form-select status-${status}" data-id="${cartId}">`;
                $.each(arrStatus, function(index, value) {
                    if (index == status) {
                        html += `<option selected value="${status}">${value}</option>`;
                    } else html += `<option value="${index}">${value}</option>`
                })
                html += `</select>`
                $(`.status-cart[data-id="${cartId}"]`).parent().html(html)
            }

        }
    })
}

function handleGetCartInfo(cartId) {
    $.ajax({
        url: '<?=BASE_URL?>api/cart/cart.php',
        type: 'get',
        data: {
            action: 'get-cart-info',
            cartId: cartId,
        },
        dataType: 'json',
        success: function(result) {
            console.log(result)
            if (result.message == 'success') {
                let html = ``;
                const data = result.data
                $.each(data, function(index, item) {
                    let total = new Intl.NumberFormat('de-DE').format(item['total'])

                    html += `
                            <tr>
                                <td>${++index}</td>
                                <td>${item['product_id']}</td>
                                <td>${item['name']}</td>
                                <td><img src="${item['thumbnail']}"/></td>
                                <td>${item['quantity']}</td>
                                <td>${total}đ</td>
                            </tr>
                        `;
                })
                $('#cart-detail-tbody').html(html);
            } else {
                alert('Thất bại!')
            }
        }
    })
}
</script>
</body>

</html>