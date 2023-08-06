<?php
    
    define('BASE_URL', '../');
    include_once "./header.php";
    $csrfToken = md5(uniqid('csrf-token', true));
    $_SESSION['csrf-token'] = $csrfToken;

?>

<div class="content-wrapper">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Đổi mật khẩu</h5>
                        </div>
                        <div class="card-body dashboard">
                            <div class="row">
                                <div class="col-xl-12 offset-xl-2">
                                    <form action="" method="POST" id="form-change-password">
                                        <div class="row">
                                        
                                            <div class="col-xl-6">
                                                <label for="" class="form-label">Mật khẩu hiện tại</label>
                                                <input name="currentPassword" required type="password" class="form-control" placeholder="Mật khẩu hiện tại">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <label for="" class="form-label">Mật khẩu mới</label>
                                                <input name="newPassword" required type="password" class="form-control" placeholder="Mật khẩu mới">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-xl-6">
                                                <label for="" class="form-label">Nhập lại mật khẩu mới</label>
                                                <input name="confirmPassword" required type="password" class="form-control" placeholder="Nhập lại mật khẩu mới">
                                            </div>
                                        </div>
                                        <input type="hidden" name="customerId" value="<?=$customerId?>">
                                        <input type="hidden" name="csrf-token" value="<?=$_SESSION['csrf-token']?>">
                                        <button type="submit" class="btn btn-danger" name="submit-form-change-password">Đổi mật khẩu</button>  
                                    </form>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Close admin-wrapper -->
    </div>

    <script>
        const formChangePassword = document.getElementById('form-change-password') 

        formChangePassword.addEventListener('submit', function(e) {
            e.preventDefault()

            const currentPassword   = formChangePassword.querySelector('input[name="currentPassword"]').value
            const newPassword       = formChangePassword.querySelector('input[name="newPassword"]').value
            const confirmPassword   = formChangePassword.querySelector('input[name="confirmPassword"]').value
            const customerId        = formChangePassword.querySelector('input[name="customerId"]').value
            const csrfToken         = formChangePassword.querySelector('input[name="csrf-token"]').value
           
            if (newPassword === confirmPassword) {
                handleChangePassword({
                    currentPassword,
                    newPassword, 
                    customerId,
                    csrfToken
                })
            } else {
                alert('Mật khẩu không khớp!')
            }
            
        })

        function handleChangePassword(input) {
            $.ajax({
                url: '<?=BASE_URL?>api/customer/customer.php',
                type: 'post',
                data: {
                    action: 'change-password',
                    ...input
                },
                dataType: 'json',
                success: function(result) {
                    console.log(result)
                    if (result.status != 'error') {
                        alert('Đổi mật khẩu thành công!')
                        location.href = './index.php'
                    } 
                    else {
                        alert(`Thất bại! ${result.message}`)
                    }

                }
            })
        }

    </script>

</body>
</html>