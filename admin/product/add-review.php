<?php
    define('BASE_URL', '../../');
    define('BASE_URL_ADMIN', '../');

    include_once "../partials/header.php";

?>

<style>
    .message.success {
        color: var(--bs-green);
    }
    .message.error {
        color: var(--bs-red);
    }
</style>

<?php
    if (isset($_POST['submit-add-review'])) {
     
        $review = $_POST['review'];
        $productId = $_POST['productId'];
        $sql = "insert into product_review values(?, ?)";
        if (executeSqlBindParam($sql, "ss", [$productId, $review])) {
            $type = 'success';
            $message = 'Thành công!';
        } else {
            $type = 'error';
            $message = 'Có lỗi! Thêm bài viết thất bai!';
        }
    }


?>

<div class="content-wrapper">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Thêm bài viết</h5>
                            <p class="message <?php if(isset($type)) echo $type ?>">
                                <?php
                                    if (isset($message)) {
                                        echo $message;
                                    }
                                ?>
                            </p>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST"> 
                                <div class="row">
                                    <div class="col-xl-3">
                                        <label for="" class="form-label">Mã sản phẩm</label>
                                        <input id="product-id" name="productId" required type="text" class="form-control" placeholder="Mã sản phẩm">
                                    </div>
                                    <div class="col-xl-6">
                                        <label for="" class="form-label">Sản phẩm</label>
                                        <input disabled id="product-loaded" class="form-control" placeholder="Sản phẩm">
                                    </div>
                                    <div class="col-xl-3">
                                        <img style="width: 150px" id="product-img-loaded" src="" alt="">
                                    </div>
                                    <div class="col-xl-12">
                                        <label for="" class="form-label">Bài viết</label>
                                        <textarea name="review" id="review"></textarea>
                                    </div>
                                </div>
                                <button type="submit" name="submit-add-review" class="btn btn-danger mt-3">Thêm</button>
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
            console.error( error );
    } );

    $(document).ready(function() {

        $('#product-img-loaded').hide()

        $('#product-id').blur(function(e) {
            loadProduct($('#product-id').val())
        })

    })

    function loadProduct(productId) {
        $.ajax({
            url: '<?=BASE_URL?>api/product/product.php',
            type: 'get',
            data: {
                action: 'get-product-info',
                id: productId
            },
            dataType: 'json',
            success: function(result) {
                $('#product-loaded').val(result['name'])
                $('#product-img-loaded').attr('src', result['thumbnail'])
                $('#product-img-loaded').show()

            }
        })
    }
</script>
  

</body>
</html>