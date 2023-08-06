<footer class="footer">
        <div class="footer-link">
            <div class="container">
                <div class="row">
                    <div class="col col-xl-3 col-sm-6 col-6">
                        <div class="link-group">
                            <span class="link-group-title">Giới thiệu H2T COMPUTER</span>
                            <p><a href="">Giới thiệu</a></p>
                            <p><a href="">Thông tin tuyển dụng</a></p>
                            <p><a href="">Tin tức</a></p>
                            <span class="footer-social">
                                <a target="_blank" href="https://www.facebook.com/haniyeuhanine"><i class="facebook fab fa-facebook-f"></i></a>
                                <a target="_blank" href="https://www.youtube.com/"><i class="youtube fab fa-youtube"></i></a>
                                <a target="_blank" href="https://www.instagram.com/"><i class="instagram fab fa-instagram"></i></a>
                            </span>
                        </div>
                    </div>
                    <div class="col col-xl-3 col-sm-6 col-6">
                        <div class="link-group">
                            <span class="link-group-title">Hỗ trợ khách hàng</span>
                            <p><a href="">Hướng dẫn mua hàng trực tuyến</a></p>
                            <p><a href="">Hướng dẫn thanh toán</a></p>
                            <p><a href="">Gửi yêu cầu bảo hành</a></p>
                            <p><a href="">Góp ý, Khiếu Nại</a></p>
                        </div>
                    </div>
                    <div class="col col-xl-3 col-sm-6 col-6">
                        <div class="link-group">
                            <span class="link-group-title">Chính sách chung</span>
                            <p><a href="">Chính sách, quy định chung</a></p>
                            <p><a href="">Chính sách bảo hành</a></p>
                            <p><a href="">Chính sách hàng chính hãng</a></p>
                        </div>
                    </div>
                    <div class="col col-xl-3 col-sm-6 col-6">
                        <div class="link-group">
                            <span class="link-group-title">Thông tin khuyến mại</span>
                            <p><a href="">Thông tin khuyến mại</a></p>
                            <p><a href="">Sản phẩm khuyến mại</a></p>
                            <p><a href="">Sản phẩm bán chạy</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                <p>© 2023 H2T Computer</p>
                <p>Địa chỉ: Hà Nội</p>
                <p>Email: H2Tcomputer@gmail.com - Điện thoại: 0868******</p>
            </div>
        </div>
     </footer>
<script src="<?=BASE_URL?>public/js/btnToTop.js"></script>
<script>
    const laptopByBrand = $('.header-menu .category-item-menu .laptop-by-brand')
    $.ajax({
        url: "<?=BASE_URL?>api/product/product.php",
        type: "get",
        data: {
            action: 'get-list-laptop-brand',
        },
        dataType: "json",
        success: function(result) {
            const destDiv = $('.header-menu .category-item-menu .laptop-by-brand + .sub-category.level2')
            let html = ``;
            $.each(result, function(index, item) {
                html += `<li class="category-item-menu">
                            <a href="<?=BASE_URL?>laptop.php?brand=${item['slug']}">Laptop ${item['name']}</a>
                        </li>`;
            })
            destDiv.html(html)
        }
    })
    $(document).ready(function() {
        $('#loading').hide();
    })
</script>
</body>
</html>