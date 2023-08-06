<?php
    session_start();

    $cart = [];
    if (isset($_SESSION['cart']))
        $cart = $_SESSION['cart'];
    $count = count($cart);
    if (!defined('BASE_URL')) {
        define('BASE_URL', './');
    }

    include_once BASE_URL."database/dbhelper.php";
    include_once BASE_URL."utility/utility.php";

    if (!empty($_SESSION['customer_id'])) {
        $customerId = $_SESSION['customer_id'];
        $sqlGetCustomer = "select * from customer where customer_id = ?";
        $customer = executeGetDataBindParam($sqlGetCustomer, "s", [$customerId]);
        if (count($customer) > 0)
            $customerInfo = $customer[0];
        // var_dump($customer);
    }

    if (!empty($_SESSION['customer_id'])) {
        $customerId = $_SESSION['customer_id'];
        $sqlGetCustomer = "select * from administrator where administrator_id = ?";
        $customer = executeGetDataBindParam($sqlGetCustomer, "s", [$customerId]);
        if (count($customer) > 0)
            $customerInfo = $customer[0];
        // var_dump($customer);
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        if (empty($metaDescription))
            $metaDescription = 'H2T Computer - Laptop, linh kiện máy tính, Laptop Gaming, Laptop Văn Phòng, Siêu thị máy tính';
    ?>
    <?php
        if (empty($metaKeywords))
            $metaKeywords = 'H2T Computer, laptop, máy tính xách tay, linh kiện máy tính, laptop gaming, Laptop Văn Phòng';
    ?>
    <meta name="keywords" content="<?=$metaKeywords?>">
    <meta name="description" content="<?=$metaDescription?>">

    <?php
        if (empty($openGraph)) {
            $propertyTitle = 'H2T Computer - Laptop, linh kiện máy tính';
            $propertyDescription = 'H2T Computer, laptop, linh kiện máy tính, laptop gaming, Laptop Văn Phòng';
            $propertyUrl = 'http://H2Tcomputer.com/';
            $propertyImage = 'http://H2Tcomputer.com/public/image/5.png';
            $propertyImageAlt = 'H2T Computer - Laptop, linh kiện máy tính';
        }
    ?>

    <meta property="og:title" content="<?=$propertyTitle?>">
    <meta property="og:description" content="<?=$propertyDescription?>">
    <meta property="og:url" content="<?=$propertyUrl?>">
    <meta property="og:image" content="<?=$propertyImage?>">
    <meta property="og:image:alt" content="<?=$propertyImageAlt?>">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"
        integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />

    <link rel="stylesheet" href="<?=BASE_URL?>public/css/base.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/grid.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/header.css">
    <?php
        if (isset($isRegisterPage)) { ?>
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/register.css">
    <?php  } ?>

    <?php
        if (isset($isHomePage)) {  ?>
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/banner.css">
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/homepage-product.css">
    <?php    } ?>

    <?php
        if (isset($isCategoryPage)) { ?>
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/category.css">
    <?php  } ?>

    <?php
        if (isset($isProductDetailPage)) { ?>
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/product-detail.css">
    <?php  } ?>

    <?php
        if (isset($isCartPage)) { ?>
    <link rel="stylesheet" href="<?=BASE_URL?>public/css/cart.css">
    <?php  } ?>

    <link rel="stylesheet" href="<?=BASE_URL?>public/css/footer.css">
    <?php
     if (empty($titlePage)) {
         $titlePage = 'H2T Computer | Laptop, linh kiện máy tính chính hãng';
     } ?>
    <title><?=$titlePage?></title>
</head>

<body>
    <div id="top"></div>
    <div class="icon-fixed-right">
        <button class="btn-to-top">
            <i class="fas fa-arrow-up"></i>
        </button>
    </div>
    <div id="loading">
        <img src="<?=BASE_URL?>public/image/loading.gif" alt="">
    </div>
    <div id="box-message">

    </div>
    <header class="header">
        <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="wrapper-logo">
                        <a title="H2T COMPUTER" href="<?=BASE_URL?>index.php">H2T COMPUTER
                            <!-- <img src="<?=BASE_URL?>public/image/5.png" alt="H2T COMPUTER"> -->
                        </a>
                    </div>
                    <div class="wrapper-search">
                        <form action="<?=BASE_URL?>tim-kiem.php" method="GET" id="form-search">
                            <div class="form-group">
                                <input type="text" placeholder="Nhập tên sản phẩm" name="q" class="form-control"
                                    value="<?php if(!empty($keyword)) echo $keyword;?>">
                                <button type="reset" class="reset"><i class="fa-solid fa-xmark"></i></button>
                                <button type="submit" class="submit"><i class="fas fa-search"></i> Tìm kiếm</button>
                            </div>
                            <div class="live-search-result">
                                <ul class="search-result">

                                </ul>
                            </div>
                        </form>
                    </div>
                    <div class="header-left">

                        <div class="wrapper-auth">
                            <?php

                              
                                
                                ?>
                            <a href="<?=BASE_URL?>customer/index.php" class="icon-auth">
                                <i class="fas fa-user"></i>
                            </a>
                            <span>

                                <?php

                                    if (!empty($customerInfo)) {
                                        echo '<a title="Đăng nhập" href="'.BASE_URL.'customer/index.php">'.$customerInfo['given_name'].'</a>';
                                        echo '<a title="Đăng xuất" href="'.BASE_URL.'authen/logout.php">Đăng xuất</a>';

                                    }
                                    else {
                                        echo '<a title="Đăng ký" href="'.BASE_URL.'authen/register.php">Đăng ký</a>
                                            <a title="Đăng nhập" href="'.BASE_URL.'authen/login.php">Đăng nhập</a>';
                                    }
                                
                                ?>
                            </span>
                        </div>
                        <div class="header-separator"></div>
                        <div class="wrapper-cart">
                            <button class="icon-cart">
                                <i class="fas fa-shopping-bag"></i>
                                <span class="cart-count-product"><?=$count?></span>
                            </button>
                            <a title="Giỏ hàng" href="<?=BASE_URL?>gio-hang.php">Giỏ hàng</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom">
            <div class="container">
                <div class="row">
                    <div class="col col-xl-2">
                        <div class="header-category">
                            <span class="header-btn <?php if (isset($isHomePage)) echo 'disabled';?>"><i
                                    class="fas fa-bars"></i> DANH MỤC SẢN PHẨM
                                <div class="header-menu">
                                    <?php

        include_once BASE_URL."database/dbhelper.php";
        include_once BASE_URL."utility/utility.php";
        $sql = "select * from category";
        $menuData =  executeGetData($sql);

        createMenuRecursive($menuData, 0, 0, $resultMenu);
        $resultMenu = str_replace('<ul class="sub-category level3"></ul>', '', $resultMenu);
        $resultMenu = str_replace('<ul class="sub-category"></ul>', '', $resultMenu);
        $resultMenu = str_replace('<div class="wrapper-subcate"></div>', '', $resultMenu);
        echo $resultMenu;
?>
                                </div>
                            </span>

                        </div>
                    </div>
                    <ul class="header-service">
                        <li><a class="header-btn header-btn-transparent" href="">HƯỚNG DẪN THANH TOÁN</a></li>
                        <li><a class="header-btn header-btn-transparent" href="">CHÍNH SÁCH BẢO HÀNH</a></li>
                        <li><a class="header-btn header-btn-transparent" href="">CHÍNH SÁNH VẬN CHUYỂN</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <header class="header-mobile">
        <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="wrapper-bar">
                        <button class="btn-bar"><i class="fa-solid fa-bars"></i></button>
                    </div>
                    <div class="wrapper-logo">
                        <a title="H2T COMPUTER" href="<?=BASE_URL?>index.php">H2T COMPUTER
                            <!-- <img src="<?=BASE_URL?>public/image/5.png" alt="H2T COMPUTER"> -->
                        </a>
                    </div>

                    <div class="wrapper-search">

                        <form action="<?=BASE_URL?>tim-kiem.php" method="GET" id="form-search">
                            <div class="form-group">
                                <input type="text" placeholder="Nhập tên sản phẩm" name="q" class="form-control"
                                    value="<?php if(!empty($keyword)) echo $keyword;?>">
                                <button type="submit" class="submit"><i class="fas fa-search"></i></button>
                            </div>
                            <div class="live-search-result">
                                <ul class="search-result">

                                </ul>
                            </div>

                        </form>
                    </div>

                    <div class="wrapper-cart">
                        <a href="<?=BASE_URL?>gio-hang.php" class="icon-cart">
                            <i class="bi bi-cart3"></i>
                            <span class="cart-count-product"><?=$count?></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom">
            <div class="container">
                <div class="wrapper-search">

                    <form action="<?=BASE_URL?>tim-kiem.php" method="GET" id="form-search">
                        <div class="form-group">
                            <input type="text" placeholder="Nhập tên sản phẩm" name="q" class="form-control"
                                value="<?php if(!empty($keyword)) echo $keyword;?>">
                            <button type="submit" class="submit"><i class="fas fa-search"></i></button>
                        </div>
                        <div class="live-search-result">
                            <ul class="search-result">

                            </ul>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </header>
    <script type="module">
    import {
        removeDuplicateSpaceAndTrim,
        noSpecialChars
    } from '<?=BASE_URL?>public/js/validate.js';
    $(document).ready(function() {
        const liveSearchResult = $('.live-search-result')
        let formSearch = document.getElementById('form-search')

        formSearch.addEventListener('submit', function(e) {
            e.preventDefault();
            let value = $('#form-search input').val()

            $('#form-search input').val(removeDuplicateSpaceAndTrim(value))

            value = $('#form-search input').val()

            if (noSpecialChars(value) && value != '')
                formSearch.submit();
            else {
                handleMessage(function() {
                    showMessage({
                        type: 'info',
                        title: 'Có lỗi !',
                        message: 'Vui lòng không nhập các kí tự đặc biệt!'
                    })
                })
            }
        })

        $('#form-search input').keyup(function(e) {
            liveSearch($(this).val())
            if ($(this).val()) {
                liveSearchResult.show();
                $('.wrapper-search button.reset').show();
                if (!liveSearchResult.hasClass('active')) {
                    liveSearchResult.addClass('active')
                }

                if ($('.header .header-bottom').hasClass('scroll')) {
                    $('.header .header-bottom').removeClass('scroll')
                }
            } else {
                $('.wrapper-search button.reset').hide();
                liveSearchResult.hide();
            }
        })

        $('#form-search input').focus(function(e) {
            liveSearch($(this).val())
            if ($(this).val()) {
                liveSearchResult.show();
                $('.wrapper-search button.reset').show();
                if (!liveSearchResult.hasClass('active')) {
                    liveSearchResult.addClass('active')
                }
                if ($('.header .header-bottom').hasClass('scroll')) {
                    $('.header .header-bottom').removeClass('scroll')
                }
            } else {
                $('.wrapper-search button.reset').hide();
            }
        })

        $('.wrapper-search button.reset').click(function() {
            $(this).hide();
            $('#form-search input').attr('value', '')
        })

        if ($('#form-search input').val() != '') {
            $('.wrapper-search button.reset').show();
        }

        $('#form-search input').blur(function(e) {
            liveSearchResult.hide();
            if (liveSearchResult.hasClass('active')) {
                liveSearchResult.removeClass('active')
            }
        })

        $('.live-search-result .search-result').mousedown(function(e) {
            e.preventDefault();
        })

    })

    function highlightText(keyword, result) {
        let ans = ''
        result.split(' ').forEach((item, index) => {
            if (isInclude(keyword, item)) {
                ans += ` <span class="highlight">${item}</span>`
            } else ans += ` ${item}`
        })
        return ans
    }

    function isInclude(keyword, result) {
        let ans = false
        let b = result.toLowerCase();
        keyword.split(' ').forEach((item, index) => {
            let a = item.toLowerCase();
            if (b.includes(a) && a != '') {
                ans = true;
                return
            }
        })
        return ans
    }

    function liveSearch(keyword) {
        keyword = removeDuplicateSpaceAndTrim(keyword);
        $.ajax({
            url: "<?=BASE_URL?>api/product/product.php",
            type: "GET",
            data: {
                action: 'search-product',
                keyword: keyword
            },
            dataType: "json",
            success: function(result) {
                const divSearchResult = $('.live-search-result .search-result')
                let html = `<li style="padding: 8px 12px; font-weight: bold;">Sản phẩm gợi ý</li>`;
                if (result.length > 0) {
                    $.each(result, function(index, item) {
                        let price = item['price']
                        let discount = item['discount'];
                        if (discount != 0) {
                            price = price - (price * discount) / 100;
                            price = Math.round(price / 10000) * 10000;
                        }
                        price = new Intl.NumberFormat('de-DE').format(price)

                        let name = highlightText(keyword, item['name'])
                        html += `<li>
                                        <a class="row" href="<?=BASE_URL?>san-pham.php?slug=${item['slug']}">
                                            <div class="col col-xl-2 col-3">
                                                <img src="${item['thumbnail']}" alt="">
                                            </div>
                                            <div class="col col-xl-10 col-9">
                                                <p class="product-name">${name}</p>
                                                <p class="product-price">Giá: ${price}đ</p>
                                            </div>
                                        </a>
                                    </li>`;
                    })
                } else html =
                    '<li style="padding: 8px 12px; color: red">Không tìm thấy sản phẩm phù hợp!</li>'
                divSearchResult.html(html)
            }
        })
    }
    </script>

    <script>
    function showMessage(options) {
        const {
            type,
            title,
            message
        } = options
        const icons = {
            success: 'fa-solid fa-check',
            error: 'fa-solid fa-xmark',
            info: 'fa-solid fa-question'
        }
        const boxMessage = $('#box-message')
        if (boxMessage) {
            let html = `<div class="message ${type}">
                            <div class="message-icon">
                                <i class="${icons[type]}"></i>
                            </div>
                            <div class="message-body">
                                <p class="message-title">${title}</p>
                                <p class="message-info">${message}</p>
                            </div>
                            <div class="message-action">
                                <button class="btn btn-accept">OK</button>
                            </div>
                        </div>`
            boxMessage.html(html)
        }
        boxMessage.addClass('show')

    }

    function hideMessage() {
        $('#box-message .message').css({
            "transform": "scale(0)"
        })
        $('#box-message').removeClass('show')
    }

    function handleMessage(callback) {
        callback();

        $('#box-message').click(function() {
            hideMessage();
        })

        $('#box-message .btn.btn-accept').click(function() {
            hideMessage();
        })

        $('#box-message .message').click(function(e) {
            e.stopPropagation()
        });

    }
    </script>


    <script>


    </script>