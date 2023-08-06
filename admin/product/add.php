<?php
    define('BASE_URL', '../../');
    define('BASE_URL_ADMIN', '../');

    include_once BASE_URL."database/dbhelper.php";

    $sqlGetProductType = "select * from product_type";
    $dataProductType = executeGetData($sqlGetProductType);

    include_once "../partials/header.php";

?>

<style>
    .message {
        margin: 0;
    }
    .message.success {
        color: var(--bs-green);
    }
    .message.error {
        color: var(--bs-red);
    }
</style>


<?php

    // handle Submit Form
    if (isset($_POST['submit-add-product'])) {
        $productId = $_POST['productId'];
        $productType = $_POST['productType'];
        $category = $_POST['category'];
        $brand = $_POST['brand'];
        $productName = $_POST['productName'];
        $productSlug = $_POST['productSlug'];
        $productPrice = $_POST['productPrice'];
        $productDiscount = $_POST['productDiscount'];
        $productStatus = $_POST['productStatus'];
        $productCpu = $_POST['productCpu'];
        $productCpuDetail = $_POST['productCpuDetail'];
        $productHardDrive = $_POST['productHardDrive'];
        $productHardDriveDetail = $_POST['productHardDriveDetail'];
        $productRam = $_POST['productRam'];
        $productGraphics = $_POST['productGraphics'];
        $productScreen = $_POST['productScreen'];
        $productWeight = $_POST['productWeight'];
        $productKeyword = $_POST['productKeyword'];
        $productThumbnail = $_POST['productThumbnail'];

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $createdAt = date("Y-m-d H:i:s");

        $sqlInsertProduct = "insert into product values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $result1 = executeSqlBindParam($sqlInsertProduct, "siississiiis", [$productId, $productType, $category, $productName, $productSlug, $brand, $productThumbnail, $productKeyword, $productPrice, $productDiscount, $productStatus, $createdAt]);

        $sqlInsertLaptopSpecification = "insert into laptop_specification(product_id, cpu, cpu_detail, ram, hard_drive_size, hard_drive_desc, graphics, screen, weight)
        values(?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $result2 = executeSqlBindParam($sqlInsertLaptopSpecification, "sssissssd", [$productId, $productCpu, $productCpuDetail, $productRam, $productHardDrive, $productHardDriveDetail, $productGraphics, $productScreen, $productWeight]);

        if ($result1 && $result2) {
            $type = 'success';
            $message = 'Thêm sản phẩm thành công!';
        }
        else {
            $type = 'error';
            $message = 'Có lỗi! Thêm sản phẩm thất bai!';
        }
    }


?>
     
        <div class="content-wrapper">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Thêm sản phẩm</h5>
                            <p class="message <?php if(isset($type)) echo $type ?>">
                                <?php
                                    if (isset($message)) {
                                        echo $message;
                                    }
                                ?>
                            </p>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST" id="form-add"> 
                                <div class="row">
                                    <div class="col-xl-3">
                                        <label for="" class="form-label">Loại sản phẩm</label>
                                        <select name="productType" class="form-select" id="select-product-type">
                                            <?php
                                                $isFirst = true;
                                                foreach ($dataProductType as $key => $value) {
                                                    if ($isFirst) {
                                                        echo '  <option data-alias="'.$value['alias'].'" selected value="'.$value['id'].'">'.$value['name'].'</option>';
                                                        $isFirst = false;
                                                    } else {
                                                        echo '  <option data-alias="'.$value['alias'].'" value="'.$value['id'].'">'.$value['name'].'</option>';
                                                    }
                                                }

                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-xl-3">
                                        <label for="" class="form-label">Danh mục</label>
                                        <select name="category" class="form-select" id="select-category">
                                           
                                        </select>
                                    </div>
                                    <div class="col-xl-3">
                                        <label for="" class="form-label">Hãng</label>
                                        <select name="brand" class="form-select" id="select-brand">
                                           
                                        </select>
                                    </div>
                                   
                                    <div class="col-xl-3">
                                        <label for="" class="form-label">Mã sản phẩm</label>
                                        <input id="product-id" name="productId" required type="text" class="form-control" placeholder="Mã sản phẩm">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-xl-3">
                                        <label for="" class="form-label">Tên sản phẩm</label>
                                        <input name="productName" id="product-name" required type="text" class="form-control" placeholder="Tên sản phẩm">
                                    </div>
                                    <div class="col-xl-3">
                                        <label for="" class="form-label">Đường dẫn</label>
                                        <input name="productSlug" id="product-slug" required type="text" class="form-control" placeholder="Đường dẫn (slug)">
                                    </div>
                                    <div class="col-xl-3">
                                        <label for="" class="form-label">Giá sản phẩm</label>
                                        <input name="productPrice" required type="text" class="form-control" placeholder="Giá sản phẩm">
                                    </div>
                                    <div class="col-xl-3">
                                        <label for="" class="form-label">Khuyễn mãi</label>
                                        <input name="productDiscount" required type="text" class="form-control" placeholder="Khuyễn mãi (%)">
                                    </div>
                                    <div class="col-xl-3">
                                        <label label for="" class="form-label">Tình trạng</label>
                                        <select name="productStatus" class="form-select">
                                           <option selected value="1">Còn hàng</option>
                                           <option value="0">Hết hàng</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-3">
                                        <label for="" class="form-label">CPU</label>
                                        <input name="productCpu" required type="text" class="form-control" placeholder="CPU">
                                    </div>
                                    <div class="col-xl-3">
                                        <label for="" class="form-label">Thông tin chi tiết CPU</label>
                                        <input name="productCpuDetail" required type="text" class="form-control" placeholder="Thông tin chi tiết CPU">
                                    </div>
                                    <div class="col-xl-3">
                                        <label for="" class="form-label">Ổ cứng</label>
                                        <input name="productHardDrive" required type="text" class="form-control" placeholder="Ổ cứng">
                                    </div>
                                    <div class="col-xl-3">
                                        <label for="" class="form-label">Thông tin ổ cứng</label>
                                        <input name="productHardDriveDetail" required type="text" class="form-control" placeholder="Thông tin ổ cứng">
                                    </div>
                                     <div class="col-xl-3">
                                        <label for="" class="form-label">RAM</label>
                                        <input name="productRam" required type="text" class="form-control" placeholder="RAM">
                                    </div>
                                     <div class="col-xl-3">
                                        <label for="" class="form-label">Card màn hình</label>
                                        <input name="productGraphics" required type="text" class="form-control" placeholder="Card màn hình">
                                    </div>
                                     <div class="col-xl-3">
                                        <label for="" class="form-label">Màn hình</label>
                                        <input name="productScreen" required type="text" class="form-control" placeholder="Màn hình">
                                    </div>
                                    <div class="col-xl-3">
                                        <label for="" class="form-label">Trọng lượng</label>
                                        <input name="productWeight" required type="text" class="form-control" placeholder="Trọng lượng (kg)">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <label for="" class="form-label">Từ khóa</label>
                                        <input name="productKeyword" required type="text" class="form-control" placeholder="Từ khóa">
                                    </div>
                                    <div class="col-xl-12">
                                        <label for="" class="form-label">Hình ảnh</label>
                                        <input name="productThumbnail" required type="text" class="form-control" placeholder="Hình ảnh">
                                    </div>
                                </div>
                                <button type="submit" name="submit-add-product" class="btn btn-danger mt-3">Thêm</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Close admin-wrapper -->
    </div>


<script type="module">
    import { toSlug, removeDuplicateSpaceAndTrim } from '<?=BASE_URL?>public/js/validate.js';
 
    $(document).ready( async function() {
        $('#select-product-type').change(function() {
            loadCategoryByProductType($(this).val())
            let productType = $('#select-product-type option:selected').data('alias')
            let brandAlias = $('#select-brand option:selected').data('alias')
            $('#product-id').val(`${productType}${brandAlias}`)
        })

        $('#select-brand').change(function() {
            let productType = $('#select-product-type option:selected').data('alias')
            let brandAlias = $('#select-brand option:selected').data('alias')
            $('#product-id').val(`${productType}${brandAlias}`)
        })

        $('#product-name').blur(function() {
            $('#product-slug').val(toSlug($(this).val()))
        })

         $('#product-id').blur(function() {
            let productId = $(this).val();
            const flag = isValidProductId(productId)
        })

        $('#form-add input').blur(function(index, item) {
            let inputValue = removeDuplicateSpaceAndTrim($(this).val())
            $(this).val(inputValue)
        })

    })
    loadCategoryByProductType($('#select-product-type').val())
    loadBrand()

    function isValidProductId(productId) {
        $.ajax({
            url: '../ajax/index.php',
            type: 'get',
            data: {
                action: 'check-product-id',
                productId: productId
            },
            dataType: 'json',
            success: function(result) {
                if (!result) {
                    $('#product-id').next('div').text('Mã sản phẩm đã tồn tại')
                    $('#product-id').next('div').show();
                } else {
                    $('#product-id').next('div').text('')
                    $('#product-id').next('div').hide();
                }

            }
        })
    }

    function loadBrand() {
        $.ajax({
            url: '../ajax/index.php',
            type: 'get',
            data: {
                action: 'get-all-brand',
            },
            dataType: 'json',
            success: function(result) {
                let html = ``
                $.each(result, function(index, item) {
                    if (index == 0) {
                        html += `<option data-alias="${item['alias']}" selected value="${item['id']}">${item['name']}</option>`
                    }
                    else {
                        html += `<option data-alias="${item['alias']}" value="${item['id']}">${item['name']}</option>`
                    }
                })

                $('#select-brand').html(html)
                let productType = $('#select-product-type option:selected').data('alias')
                let brandAlias = $('#select-brand option:selected').data('alias')
                $('#product-id').val(`${productType}${brandAlias}`)

            }
        })
    }

    function loadCategoryByProductType(productType) {
        $.ajax({
            url: '../ajax/index.php',
            type: 'get',
            data: {
                action: 'get-category-by-product-type',
                productType: productType,
            },
            dataType: 'json',
            success: function(result) {
                let html = ``
                $.each(result, function(index, item) {
                    if (index == 0) {
                        html += `<option value="${item['id']}" selected >${item['name']}</option>`
                    }
                    else {
                        html += `<option value="${item['id']}">${item['name']}</option>`
                    }
                })

                $('#select-category').html(html)
            }
        })
    }
</script>
</body>
</html>