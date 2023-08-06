<?php
    define('BASE_URL', '../../');
    define('BASE_URL_ADMIN', '../');

    include_once "../partials/header.php";

    if (isset($_GET['product_id'])) {
        $productId = $_GET['product_id'];
        $sqlGetProduct = "select * from product, laptop_specification
        where product.product_id = laptop_specification.product_id
        and product.product_id = ?";
        $data = executeGetDataBindParam($sqlGetProduct, "s", [$productId]);
        if (count($data) > 0) {
            $productInfo = $data[0];
        }

        $sqlGetReview = "select * from product_review where product_id = ?";
        $resultGetReview = executeGetDataBindParam($sqlGetReview, "s", [$productId]);

        if (count($resultGetReview) > 0) {
            $dataReviewContent = $resultGetReview[0]['content'];
            $dataReviewContent = str_replace( '&', '&amp;', $dataReviewContent );
        }
    }

?>

<?php

    if (isset($_POST['submit-update-product'])) {
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

        $review = $_POST['review'];

        $sqlUpdateProduct = "update product
        set product_type = ?, category_id = ?, name = ?, slug = ?, brand = ?, thumbnail = ?,
        keywords = ?, price = ?, discount = ?, status = ?
        where product_id = ?";
        $result1 = executeSqlBindParam($sqlUpdateProduct, "iississiiis", [$productType, $category, $productName, $productSlug, $brand, $productThumbnail, $productKeyword, $productPrice, $productDiscount, $productStatus, $productId]);

        $sqlUpdateLaptopSpecification = "update laptop_specification
        set cpu = ? , cpu_detail = ?, ram = ?, hard_drive_size = ?, hard_drive_desc = ?, 
        graphics = ?, screen = ?, weight = ?
        where product_id = ?";
        $result2 = executeSqlBindParam($sqlUpdateLaptopSpecification, "ssissssds", [$productCpu, $productCpuDetail, $productRam, $productHardDrive, $productHardDriveDetail, $productGraphics, $productScreen, $productWeight, $productId]);

        $sqlUpdateProductReview = "update product_review
        set content = ?
        where product_id = ?";
        $result3 = executeSqlBindParam($sqlUpdateProductReview, "ss", [$review, $productId]);


        if ($result1 && $result2 && $result3) {
            $type = 'success';
            $message = 'Cập nhật thành công!';
        }
        else {
            $type = 'error';
            $message = 'Có lỗi! Cập nhật thất bai!';
        }
    }


?>
     <div class="content-wrapper">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Chỉnh sửa sản phẩm</h5>
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
                                            
                                                $sql = "select * from product_type";
                                                $dataProductType = executeGetData($sql);

                                                foreach ($dataProductType as $key => $value) {
                                                    if ($value['id'] == $productInfo['product_type']) {
                                                        echo '<option value="'.$value['id'].'" selected>'.$value['name'].'</option>';
                                                    } else {
                                                        echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';

                                                    }
                                                        
                                                }

                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-xl-3">
                                        <label for="" class="form-label">Danh mục</label>
                                        <select name="category" class="form-select" id="select-category">
                                            <?php
                                                $sql = "select * from category where type = ?";
                                                $dataCategory = executeGetDataBindParam($sql, "s", [$productInfo['product_type']]);
                                                foreach ($dataCategory as $key => $value) {
                                                    if ($value['id'] == $productInfo['category_id']) {
                                                        echo '<option value="'.$value['id'].'" selected>'.$value['name'].'</option>';
                                                    } else {
                                                        echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';

                                                    }
                                                        
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-xl-3">
                                        <label for="" class="form-label">Hãng</label>
                                        <select name="brand" class="form-select" id="select-brand">
                                            <?php
                                                $sql = "select * from brand";
                                                $dataBrand = executeGetData($sql);
                                                foreach ($dataBrand as $key => $value) {
                                                    if ($value['id'] == $productInfo['brand']) {
                                                        echo '<option value="'.$value['id'].'" selected>'.$value['name'].'</option>';
                                                    } else {
                                                        echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';

                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                   
                                    <div class="col-xl-3">
                                        <label for="" class="form-label">Mã sản phẩm</label>
                                        <input readonly id="product-id" name="productId" required type="text" class="form-control" value="<?=$productInfo['product_id']?>">
                                    </div>
                                    <div class="col-xl-3">
                                        <label for="" class="form-label">Tên sản phẩm</label>
                                        <input name="productName" id="product-name" required type="text" class="form-control" value="<?=$productInfo['name']?>">
                                    </div>
                                    <div class="col-xl-3">
                                        <label for="" class="form-label">Đường dẫn</label>
                                        <input name="productSlug" id="product-slug" required type="text" class="form-control" value="<?=$productInfo['slug']?>">
                                    </div>
                                    <div class="col-xl-3">
                                        <label for="" class="form-label">Giá sản phẩm</label>
                                        <input name="productPrice" required type="text" class="form-control" value="<?=$productInfo['price']?>">
                                    </div>
                                    <div class="col-xl-3">
                                        <label for="" class="form-label">Khuyễn mãi</label>
                                        <input name="productDiscount" required type="text" class="form-control" value="<?=$productInfo['discount']?>">
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
                                        <input name="productCpu" required type="text" class="form-control" value="<?=$productInfo['cpu']?>">
                                    </div>
                                    <div class="col-xl-3">
                                        <label for="" class="form-label">Thông tin chi tiết CPU</label>
                                        <input name="productCpuDetail" required type="text" class="form-control" value="<?=$productInfo['cpu_detail']?>">
                                    </div>
                                    <div class="col-xl-3">
                                        <label for="" class="form-label">Ổ cứng</label>
                                        <input name="productHardDrive" required type="text" class="form-control" value="<?=$productInfo['hard_drive_size']?>">
                                    </div>
                                    <div class="col-xl-3">
                                        <label for="" class="form-label">Thông tin ổ cứng</label>
                                        <input name="productHardDriveDetail" required type="text" class="form-control" value="<?=$productInfo['hard_drive_desc']?>">
                                    </div>
                                     <div class="col-xl-3">
                                        <label for="" class="form-label">RAM</label>
                                        <input name="productRam" required type="text" class="form-control" value="<?=$productInfo['ram']?>">
                                    </div>
                                     <div class="col-xl-3">
                                        <label for="" class="form-label">Card màn hình</label>
                                        <input name="productGraphics" required type="text" class="form-control" value="<?=$productInfo['graphics']?>">
                                    </div>
                                     <div class="col-xl-3">
                                        <label for="" class="form-label">Màn hình</label>
                                        <input name="productScreen" required type="text" class="form-control" value="<?=$productInfo['screen']?>">
                                    </div>
                                    <div class="col-xl-3">
                                        <label for="" class="form-label">Trọng lượng</label>
                                        <input name="productWeight" required type="text" class="form-control" value="<?=$productInfo['weight']?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <label for="" class="form-label">Từ khóa</label>
                                        <input name="productKeyword" required type="text" class="form-control" value="<?=$productInfo['keywords']?>">
                                    </div>
                                    <div class="col-xl-12">
                                        <label for="" class="form-label">Hình ảnh</label>
                                        <input name="productThumbnail" required type="text" class="form-control" value="<?=$productInfo['thumbnail']?>">
                                    </div>
                                </div>
                                <div class="row mt-2 p-2">
                                <?php 
                                    if (isset($dataReviewContent)) { ?>
                                        <textarea name="review" id="review"><?= $dataReviewContent ?></textarea>
                                    <?php     }
                                ?>
                                </div>
                                <button type="submit" name="submit-update-product" class="btn btn-danger mt-3">Lưu</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Close admin-wrapper -->
    </div>
    <script src="https://cdn.ckeditor.com/ckeditor5/32.0.0/classic/ckeditor.js"></script>

<script>
        const reviewElement = document.getElementById('review')
        if (reviewElement) {
            ClassicEditor
            .create( document.querySelector('#review'), {
                    heading: {
                        options: [
                            { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                            { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                            { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                            { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                            { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                            { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                            { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                        ]
                        }
                })
            .catch( error => {
                console.log(error);
            });
        }
        
</script>
    <script type="module">
    import { toSlug, removeDuplicateSpaceAndTrim } from '<?=BASE_URL?>public/js/validate.js';
 
    $(document).ready( async function() {
        $('#select-product-type').change(function() {
            loadCategoryByProductType($(this).val())
        })

        $('#product-name').blur(function() {
            $('#product-slug').val(toSlug($(this).val()))
        })

        $('#form-add input').blur(function(index, item) {
            let inputValue = removeDuplicateSpaceAndTrim($(this).val())
            $(this).val(inputValue)
        })

    })
    
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