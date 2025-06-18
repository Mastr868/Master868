<?php
// login.php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email    = trim($_POST['email']);
        $password = $_POST['password'];

            $stmt = $conn->prepare("SELECT id, username, password, is_verified, is_banned FROM users WHERE email = ?");
                $stmt->bind_param("s", $email);
                    $stmt->execute();
                        $stmt->store_result();

                            if($stmt->num_rows == 1) {
                                    $stmt->bind_result($id, $username, $hashedPassword, $is_verified, $is_banned);
                                            $stmt->fetch();

                                                    if(password_verify($password, $hashedPassword)) {
                                                                if ($is_banned == 1) {
                                                                                $error = "متأسفیم، این کاربر بن شده است.";
                                                                                            } else {
                                                                                                            $_SESSION['user_id']   = $id;
                                                                                                                            $_SESSION['username']  = $username;
                                                                                                                                            $_SESSION['is_verified'] = $is_verified;
                                                                                                                                                            header("Location: home.php");
                                                                                                                                                                            exit();
                                                                                                                                                                                        }
                                                                                                                                                                                                } else {
                                                                                                                                                                                                            $error = "ایمیل یا رمز عبور اشتباه است.";
                                                                                                                                                                                                                    }
                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                $error = "ایمیل یا رمز عبور اشتباه است.";
                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                        $stmt->close();
                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                        ?>

                                                                                                                                                                                                                                        <!DOCTYPE html>
                                                                                                                                                                                                                                        <html lang="fa">
                                                                                                                                                                                                                                        <head>
                                                                                         <link rel="stylesheet" href="style.css">                                                                                                                                                   <meta charset="UTF-8">
                                                                                                                                                                                                                                                <title>ورود</title>
                                                                                                                                                                                                                                                    <link rel="stylesheet" href="style.css">
                                                                                                                                                                                                                                                    </head>
                                                                                                                                                                                                                                                    <body>
                                                                                                                                                                                                                                                    <div class="container">
                                                                                                                                                                                                                                                        <h2>ورود</h2>
                                                                                                                                                                                                                                                            <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
                                                                                                                                                                                                                                                                <form method="post" action="login.php">
                                                                                                                                                                                                                                                                        <label>ایمیل:</label>
                                                                                                                                                                                                                                                                                <input type="email" name="email" required>
                                                                                                                                                                                                                                                                                        <label>رمز عبور:</label>
                                                                                                                                                                                                                                                                                                <input type="password" name="password" required>
                                                                                                                                                                                                                                                                                                        <button type="submit">ورود</button>
                                                                                                                                                                                                                                                                                                            </form>
                                                                                                                                                                                                                                                                                                                <p>حساب نداری؟ <a href="register.php">ثبت نام کن</a></p>
                                                                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                                                                </body>
                                                                                                                                                                                                                                                                                                                </html>