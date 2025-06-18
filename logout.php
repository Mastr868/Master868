<?php
session_start();

// پاک کردن تمامی داده‌های سشن
$_SESSION = array();

// پاکسازی کوکی سشن (در صورت استفاده)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
                $params["path"],
                        $params["domain"],
                                $params["secure"],
                                        $params["httponly"]
                                            );
                                            }

                                            // از بین بردن سشن
                                            session_destroy();

                                            // انتقال به صفحه ورود
                                            header("Location: login.php");
                                            exit();
                                            ?>