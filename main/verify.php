<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="/css.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <?php
    include("db_connect.php");
    session_start();
    if (isset($_SESSION['otp']) && isset($_SESSION['otp_expire'])) {
        if (isset($_POST['otp'])) {
            $user_otp = $_POST['otp'];
            if (time() > $_SESSION['otp_expire']) {
                header("Location: login.php?msg=OTP đã hết hạn, vui lòng gửi lại mã xác thực");
                exit();
            } else {
                if ($user_otp == $_SESSION['otp']) {
                    $email = $_SESSION['email'];
                    $sql = "SELECT * FROM `user` WHERE `email` = '$email'";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        header("Location: signup.php?msg=Email đã tồn tại trong hệ thống");
                        exit();
                    } else {
                        $sql = "INSERT INTO `user` ( `email`, `otp`) VALUES ( '$email', '$user_otp');";
                        if (mysqli_query($conn, $sql)) {
                            header("Location: verify.php?msg=Đăng nhập thành công");
                            exit();
                        } else {
                            header("Location: verify.php?msg= " . mysqli_error($con));
                            exit();
                        }
                    }
                } else {
                    header("Location: verify.php?msg=Mã OTP không chính xác, vui lòng thử lại");
                    exit();
                }
            }
        }
    }
    ?>

    <div>
        <?php
        if (isset($_GET['msg'])) {
            echo "<div class='alert alert-danger' role='alert'>" . $_GET['msg'] . "</div>";
        }
        ?>
    </div>
    <form action="verify.php" method="post">
        <div class="mb-3">
            <label for="" class="form-label">OTP</label>
            <input type="text" name="otp" id="" required>
        </div>
        <button type="submit" class="btn btn-primary">
            Xác thực
        </button>
    </form>
    <form action="send_mail.php" method="post">
        <input type="hidden" name="email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>">
        <button type="submit" class="btn btn-primary">
            Gửi lại mã OTP
        </button>
    </form>

    <script>
        // Get the OTP expiration time from PHP
        const otpExpireTime = <?php echo isset($_SESSION['otp_expire']) ? $_SESSION['otp_expire'] : 'null'; ?>;

        if (otpExpireTime) {
            const countdownElement = document.createElement('div');
            countdownElement.className = 'alert alert-info';
            countdownElement.setAttribute('role', 'alert');
            countdownElement.id = 'countdown';
            document.body.insertBefore(countdownElement, document.body.firstChild);

            function updateCountdown() {
                const currentTime = Math.floor(Date.now() / 1000); // Current time in seconds
                const remainingTime = otpExpireTime - currentTime;

                if (remainingTime <= 0) {
                    countdownElement.textContent = 'OTP đã hết hạn, vui lòng gửi lại mã xác thực';
                    countdownElement.className = 'alert alert-danger';
                    clearInterval(countdownInterval);
                } else {
                    const minutes = Math.floor(remainingTime / 60);
                    const seconds = remainingTime % 60;
                    countdownElement.textContent = `Thời gian còn lại: ${minutes} phút ${seconds} giây`;
                }
            }

            // Update the countdown every second
            const countdownInterval = setInterval(updateCountdown, 1000);
            updateCountdown(); // Initial call to display immediately
        }
    </script>

</body>


</html>