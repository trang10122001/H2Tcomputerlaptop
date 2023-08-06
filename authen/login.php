<?php 
    define('BASE_URL', '../');
    $isRegisterPage = true;
    include_once BASE_URL."partials/header.php";
   
   
    
?>

<?php
   

?>


<div class="main">
    <div class="auth">
        <div class="container">
            <h1 class="auth-heading">Đăng nhập</h1>
            <div class="login">
                <form id="form-login" action="" method="POST">
                    <p class="message-request">Đăng nhập vào tài khoản!</p>
                    <div class="form-group">
                        <div class="wrapper-input">
                            <label for="input-email" class="auth-icons fas fa-envelope"></label>
                            <input required id="input-email" type="email" class="form-control" placeholder="Email">
                        </div>
                        <span class="form-message">message</span>
                    </div>
                    <div class="form-group" id="form-group-password">
                        <div class="wrapper-input">
                            <label for="input-fullname" class="auth-icons fas fa-lock"></label>
                            <input required id="input-password" type="password" class="form-control" placeholder="Mật khẩu">
                        </div>
                        <span class="form-message">Sai mat khau</span>
                    </div> 
                    <a href="" class="forgot-password">Quên mật khẩu?</a>
                    <button class="btn btn-submit-login" type="submit">Đăng nhập</button>
                    <div class="loading">
                            <img src="<?=BASE_URL?>public/image/loading-2.gif" alt="">
                    </div>
                </form>
                <div class="action">
                    <span>Bạn chưa có tài khoản? </span><a class="link-register" href="./register.php">Đăng ký tại đây</a>
                </div>
            </div>
    </div>
</div>

<?php 
    include_once BASE_URL."./partials/footer.php";

?>


<script type="module">
    import { isValidName, removeDuplicateSpaceAndTrim, handleUpperCaseFirstLetter } from '<?=BASE_URL?>public/js/validate.js';
    $(document).ready(function() {
        const formLogin = $('#form-login')

        formLogin.submit(function(e) {
            e.preventDefault();
            const email = $('#input-email').val()
            const password = $('#input-password').val()

            handleLogin(email, password)
        })
    })
   
    function handleLogin(email, password) {
        $.ajax({
            url: '<?=BASE_URL?>api/customer/authen.php',
            type: 'post',
            data: {
                action: 'login',
                email: email,
                password: password
            },
            beforeSend: function() {
                $('form .loading').addClass('show')
            },
            dataType: 'json',
            success: function(result) {
                $('form .loading').removeClass('show')
                console.log(result)
                if (result) {
                    location.href = '../index.php'
                } 
                else {
                    handleMessage(function() {
                        showMessage({
                            type: 'error',
                            title: 'Thất bại!',
                            message: `Email hoặc mật khẩu không chính xác!`
                        })
                    })
                }
            }
        })
    }
    
</script>