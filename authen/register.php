<?php 
    define('BASE_URL', '../');
    $isRegisterPage = true;

    $titlePage = 'Tài khoản | H2T Computer';

    include_once BASE_URL."partials/header.php";

  
?>

<div class="main">
    <div class="auth">
       <div class="container">
            <h1 class="auth-heading">Đăng ký tài khoản</h1>
            <div class="register-input-email register">
                <form id="form-register" action="" method="POST">
                    <p class="message-request">Vui lòng nhập thông tin để đăng ký!</p>
                   <div class="wrapper-email row">
                        <div class="col col-xl-12">
                            <div class="form-group">
                                <label for="input-email" class="auth-icons fas fa-envelope"></label>
                                <input required id="input-email" type="email" class="form-control" placeholder="Nhập email (*)">
                            </div>
                        </div>
                   </div>
                    <div class="wrapper-name row">
                        <div class="col col-xl-6">
                            <div class="form-group">
                                <label for="input-email" class="auth-icons fas fa-user"></label>
                                <input required id="input-family-name" type="text" class="form-control" placeholder="Họ của bạn (*)">
                            </div>
                        </div>
                       <div class="col col-xl-6">
                            <div class="form-group">
                                <label for="input-email" class="auth-icons fas fa-user"></label>
                                <input required id="input-given-name" type="text" class="form-control" placeholder="Tên của bạn (*)">
                            </div>
                       </div>
                    </div>
                    <div class="row footer">
                        <div class="box-btn">
                            <button class="btn btn-submit" type="submit">Đăng ký</button>
                        </div>
                        <div class="loading">
                            <img src="<?=BASE_URL?>public/image/loading-2.gif" alt="">
                        </div>
                    </div>
                </form>
                <div class="action">
                    <span>Bạn đã có tài khoản? </span><a class="link-login" href="./login.php">Đăng nhập ngay tại đây!</a>
                </div>
            </div>
       </div>
    </div>
</div>
<!-- <div class="main">
    <div class="auth">
        <div class="container">
            <h1 class="auth-heading">Đăng nhập</h1>
            <div class="login">
                    <p class="message-request">Đăng nhập vào tài khoản!</p>
                    <div class="login-with-google">
                        <a class="btn login-google" href="">
                            <img src="../public/image/google-logo.png" alt="">
                            <span>Login with Google</span>
                        </a>
                    </div>
            </div>
    </div>
</div> -->
<?php 
    include_once BASE_URL."partials/footer.php";

?>


<script type="module">
    import { isValidName, removeDuplicateSpaceAndTrim, handleUpperCaseFirstLetter } from '<?=BASE_URL?>public/js/validate.js';
    $(document).ready(function() {
        const formRegister = $('#form-register')

        $('#input-family-name').blur(function() {
            let value = $(this).val()
            value = removeDuplicateSpaceAndTrim(value)
            value = handleUpperCaseFirstLetter(value)
            $(this).val(value)
        })

        $('#input-given-name').blur(function() {
            let value = $(this).val()
            value = removeDuplicateSpaceAndTrim(value)
            value = handleUpperCaseFirstLetter(value)
            $(this).val(value)
        })

        formRegister.submit(function(e) {
            e.preventDefault();
            const email = $('#input-email').val()
            let givenName = $('#input-given-name').val()
            let familyName = $('#input-family-name').val()

            // Xoa cac khoang trang thua, in hoa chu cai dau tien

            givenName = removeDuplicateSpaceAndTrim(givenName)
            givenName = handleUpperCaseFirstLetter(givenName)
            $('#input-given-name').val(givenName)

            familyName = removeDuplicateSpaceAndTrim(familyName)
            familyName = handleUpperCaseFirstLetter(familyName)
            $('#input-family-name').val(familyName)

            if (isValidName(givenName) && isValidName(familyName) && isValidName(givenName)) {
                handleRegister({email, familyName, givenName})
            }
            else {
                handleMessage(function() {
                    showMessage({
                        type: 'info',
                        title: 'Họ tên không hợp lệ!',
                        message: `Vui lòng không nhập các kí tự đặc biệt!`
                    })
                })
            }

        })
    })
   
    function handleRegister(info) {
        const {email, familyName, givenName} = info
        console.log(email, familyName, givenName)
        $.ajax({
            url: '<?=BASE_URL?>api/customer/authen.php',
            type: 'post',
            data: {
                action: 'register',
                email: email,
                familyName: familyName,
                givenName: givenName
            },
            beforeSend: function() {
                $('form .loading').addClass('show')
            },
            dataType: 'json',
            success: function(result) {
                $('form .loading').removeClass('show')
                console.log(result)
                if (result) {
                    handleMessage(function() {
                        showMessage({
                            type: 'success',
                            title: 'Thành công!',
                            message: `Bạn đã đăng ký tài khoản thành công! <br>Thông tin tài khoản đã gửi đến <strong><em>${email}</em></strong>`
                        })
                    })
                } 
                else {
                    handleMessage(function() {
                        showMessage({
                            type: 'error',
                            title: 'Thất bại!',
                            message: `Email <strong><em>${email}</em></strong> đã được đăng ký rồi!`
                        })
                    })
                }
            }
        })
    }
    
</script>