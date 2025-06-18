<?php
// register.php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
        $email    = trim($_POST['email']);
            $password = $_POST['password'];
                
                    // اعتبارسنجی‌های لازم می‌توانند اضافه شوند.

                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                                $stmt->bind_param("sss", $username, $email, $hashedPassword);

                                    if ($stmt->execute()) {
                                            $_SESSION['user_id']   = $stmt->insert_id;
                                                    $_SESSION['username']  = $username;
                                                            $_SESSION['is_verified'] = 0;
                                                                    header("Location: home.php");
                                                                            exit();
                                                                                } else {
                                                                                        $error = "خطا در ثبت نام: " . $stmt->error;
                                                                                            }
                                                                                                $stmt->close();
                                                                                                }
                                                                                                ?>

                                                                                                <!DOCTYPE html>
                                                                                                <html lang="fa">
                                                                                                <head>
                                                                                                    <meta charset="UTF-8">
                                                                                                        <title>ثبت نام</title>
                                                                                                            <link rel="stylesheet" href="style.css">
                                                                                                            </head>
                                                                                                            <body>
                                                                                                            <div class="container">
                                                                                                                <h2>ثبت نام</h2>
                                                                                                                    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
                                                                                                                        <form method="post" action="register.php">
                                                                                                                                <label>نام کاربری:</label>
                                                                                                                                        <input type="text" name="username" required>
                                                                                                                                                <label>ایمیل:</label>
                                                                                                                                                        <input type="email" name="email" required>
                                                                                                                                                                <label>رمز عبور:</label>
                                                                                                                                                                        <input type="password" name="password" required>
                                                                                                                                                                                <button type="submit">ثبت نام</button>
                                                                                                                                                                                    </form>
                                                                                                                                                                                        <p>حساب داری؟ <a href="login.php">ورود</a></p>
                                                                                                                                                                                        </div>
                                                                                                                                                                                        </body>
                                                                                                                                                                                        </html>