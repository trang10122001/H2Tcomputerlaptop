<?php 
    define('BASE_URL', '../');
    include_once "./header.php";

    $sql = "select * from cart where customer_id = ?";
    $data = executeGetDataBindParam($sql, "s", [$customerId]);
?>

<style>
table td {
    text-align: center;
}

#cart-detail-tbody img {
    width: 100px;
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
                    <h5 class="card-title">Đơn hàng</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Mã đơn hàng</th>
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
            $status = ['Đang chờ xử lý', 'Đã tiếp nhận', 'Đang vận chuyển', 'Đã giao hàng'];
            foreach ($data as $key => $value) {
                echo '<tr>
                        <td class="text-center">'.(++$start).'</td>
                        <th>'.$value['cart_id'].'</th>
                        <td>'.$value['fullName'].'</td>
                        <td>'.$value['phoneNumber'].'</td>
                        <td>'.$value['email'].'</td>
                        <td>'.$value['address'].'</td>
                        <td>'.$value['createdAt'].'</td>
                        <td class="text-center">'.number_format($value['total'], 0, ',', '.').'đ</td>
                        <td>'.$status[$value['status']].'</td>
                        <td><button data-id="'.$value['cart_id'].'" class="btn btn-show-cart-detail"><i class="fa-solid fa-eye"></i></button></td>
                    </tr>';
            }
       } else {
           echo '<tr>
                    <th>Bạn chưa có đơn hàng nao!</th>
                </tr>';
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
})

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