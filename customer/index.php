<?php 
    define('BASE_URL', '../');
    include_once "./header.php";

?>

<div class="content-wrapper">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Thông tin tài khoản</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-3">
                                    <label for="" class="form-label">Email</label>
                                    <input id="email" readonly type="text" class="form-control" value="<?=$customerInfo['email']?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3">
                                    <label for="" class="form-label">Họ</label>
                                    <input readonly type="text" class="form-control" value="<?=$customerInfo['family_name']?>">
                                </div>
                                <div class="col-xl-3">
                                    <label for="" class="form-label">Tên</label>
                                    <input readonly type="text" class="form-control" value="<?=$customerInfo['given_name']?>">
                                </div>
                            </div>
                            <?php
                                if (!count($addressResult) > 0) { ?>
                                    <div class="alert alert-block alert-danger mt-4">
                                        <p>Bạn chưa có địa chỉ giao hàng!</p>
                                    </div>
                                    
                             <?php   }
                             else {
                                 echo '<div class="row mt-4">';
                                 echo '<h4>Địa chỉ giao hàng của bạn</h4> ';
                                 foreach ($addressResult as $key => $value) {
                                     echo '<div class="col-xl-6 mb-3">
                                                <div class="row">
                                                    <div class="col-xl-9">
                                                        <input readonly type="text" class="form-control" value="'.$value['address'].'">       
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <button data-id="'.$value['id'].'" type="button" class="btn btn-danger" onclick="deleteAddress('.$value['id'].')">Xóa</button>
                                                    </div>
                                                </div>
                                            </div>';
                                 }
                                 echo '</div>';
                                }
                                
                                ?>
                            <button type="button" class="btn btn-success add-new-address">Thêm địa chỉ giao hàng</button>
                            <div class="box-add-address">
                                <form action="" method="post" id="form-add-address">
                                    <div class="row mt-4">
                                        <div class="col-xl-3">
                                            <label for="" class="form-label">Tỉnh/Thành phố</label>
                                            <select name="province" class="form-select" id="buyer_province">
                                                <option value="">Tỉnh/Thành phố</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-3">
                                            <label for="" class="form-label">Quận/Huyện</label>
                                            <select name="district" class="form-select" id="buyer_district">
                                                <option value="">Quận/Huyện</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-3">
                                            <label for="" class="form-label">Phường/Xã</label>
                                            <select name="ward" class="form-select" id="buyer_ward">
                                                <option value="">Phường/Xã</option>
                                            </select>
                                        </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <label for="">Địa chỉ</label>
                                            <input type="text" id="buyer_address" class="form-control" placeholder="Số nhà, tên đường">
                                        </div>
                                    </div>
                                    </div>
                                    <button type="submit" name="submit-add-address" class="btn btn-submit-add-address btn-success mt-3">Thêm</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Close admin-wrapper -->
    </div>

<script type="module">
    import { loadProvince, loadDistrict, loadWard, firstLoad } from '<?=BASE_URL?>public/js/fetchAdress.js';

    $(document).ready(function() {


        firstLoad('buyer_province', 'buyer_district', 'buyer_ward');

        $('#buyer_province').change(async function() {
            const provinceId = $('#buyer_province').val()
            $('#buyer_ward').html('<option value="">Chọn phường/xã</option>')
            await loadDistrict('buyer_district', provinceId)
            const districtId = $('#buyer_district').val()
            await loadWard('buyer_ward', provinceId, districtId)
        })

        $('#buyer_district').change(async function() {
            const provinceId = $('#buyer_province').val()
            const districtId = $('#buyer_district').val()
            await loadWard('buyer_ward', provinceId, districtId)

        })

        $('.add-new-address').click(function() {
            if (!$('.box-add-address').hasClass('active')) {
                $('.box-add-address').addClass('active')
            }
        })

        let formAddAddress = document.getElementById('form-add-address')

        formAddAddress.addEventListener('submit', function(e) {
            e.preventDefault();
            let province = $('#buyer_province option:selected').text()
            let district = $('#buyer_district option:selected').text()
            let ward = $('#buyer_ward option:selected').text()
            let address = $('#buyer_address').val();
            let email = $('#email').val()

            let addressInput = `${address}, ${ward}, ${district}, ${province}`
            console.log(addressInput)
            addAddress({
                addressInput,
                email
            })
            
        })

        function addAddress({email, addressInput}) {
            $.ajax({
                url: '<?=BASE_URL?>api/customer/customer.php',
                type: 'post',
                data: {
                    action: 'add-address',
                    email: email,
                    address: addressInput
                },
                dataType: 'json',
                success: function(result) {
                    if (result) {
                        location.reload();
                    } 
                    else {
                        handleMessage(function() {
                            showMessage({
                                type: 'error',
                                title: 'Thất bại!',
                                message: `Có lỗi xảy ra!`
                            })
                        })
                    }
                }
            })
        }
    })
   
</script>

<script>
    function deleteAddress(addressId) {
        $.ajax({
            url: '<?=BASE_URL?>api/customer/customer.php',
            type: 'post',
            data: {
                action: 'delete-address',
                addressId: addressId
            },
            dataType: 'json',
            success: function(result) {
                console.log(result)
                if (result) {
                    location.reload();
                } 
                else {
                    handleMessage(function() {
                        showMessage({
                            type: 'error',
                            title: 'Thất bại!',
                            message: `Có lỗi xảy ra!`
                        })
                    })
                }
            }
        })
    }
</script>