<?php
// admin-login.php
session_start();
if(isset($_POST['email']) && isset($_POST['password'])){
    $adminEmail = "gghu4201@gmail.com";
        $adminPass  = "Zzxcvbnm8";
            if($_POST['email'] === $adminEmail && $_POST['password'] === $adminPass){
                    $_SESSION['admin'] = true;
                            header("Location: admin-panel.php");
                                    exit();
                                        } else {
                                                $error = "نام کاربری یا رمز عبور اشتباه است.";
                                                    }
                                                    }
                                                    ?>
                                                    <!DOCTYPE html>
                                                    <html lang="fa">
                                                    <head>
                                                        <meta charset="UTF-8">
                                                            <title>ورود به پنل مدیریت</title>
                                                                <link rel="stylesheet" href="style.css">
                                                                    <meta name="viewport" content="width=device-width, initial-scale=1">
                                                                    </head>
                                                                    <body>
                                                                    <div class="container">
                                                                        <h2>ورود به پنل مدیریت</h2>
                                                                            <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
                                                                                <form method="post" action="admin-login.php">
                                                                                        <label>ایمیل:</label>
                                                                                                <input type="email" name="email" required>
                                                                                                        <label>رمز:</label>
                                                                                                                <input type="password" name="password" required>
                                                                                                                        <button type="submit">ورود</button>
                                                                                                                            </form>
                                                                                                                            </div>
                                                                                                                            </body>
                                                                                                                            </html>