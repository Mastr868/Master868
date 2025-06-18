/* style.css */
/* طراحی mobile-first */
* {
    margin: 0;
        padding: 0;
            box-sizing: border-box;
            }

            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    background-color: #f9f9f9;
                        color: #333;
                            line-height: 1.6;
                            }

                            .container {
                                width: 90%;
                                    max-width: 600px;
                                        background-color: #fff;
                                            margin: 20px auto;
                                                padding: 15px;
                                                    border-radius: 10px;
                                                        box-shadow: 0 3px 6px rgba(0,0,0,0.1);
                                                        }

                                                        h2 {
                                                            text-align: center;
                                                                margin-bottom: 15px;
                                                                    color: #444;
                                                                    }

                                                                    form {
                                                                        margin: 15px 0;
                                                                        }

                                                                        label {
                                                                            display: block;
                                                                                margin-bottom: 5px;
                                                                                    color: #555;
                                                                                    }

                                                                                    input[type="text"],
                                                                                    input[type="email"],
                                                                                    input[type="password"],
                                                                                    textarea {
                                                                                        width: 100%;
                                                                                            padding: 10px;
                                                                                                border: 1px solid #ddd;
                                                                                                    border-radius: 5px;
                                                                                                        margin-bottom: 10px;
                                                                                                        }

                                                                                                        button {
                                                                                                            width: 100%;
                                                                                                                padding: 10px;
                                                                                                                    background: #27ae60;
                                                                                                                        border: none;
                                                                                                                            color: #fff;
                                                                                                                                border-radius: 5px;
                                                                                                                                    font-size: 16px;
                                                                                                                                        cursor: pointer;
                                                                                                                                            transition: background 0.3s ease;
                                                                                                                                            }

                                                                                                                                            button:hover {
                                                                                                                                                background: #219150;
                                                                                                                                                }

                                                                                                                                                .error {
                                                                                                                                                    color: #d9534f;
                                                                                                                                                        text-align: center;
                                                                                                                                                            margin-bottom: 10px;
                                                                                                                                                            }

                                                                                                                                                            .navbar {
                                                                                                                                                                background: #fff;
                                                                                                                                                                    padding: 10px 20px;
                                                                                                                                                                        display: flex;
                                                                                                                                                                            align-items: center;
                                                                                                                                                                                justify-content: space-between;
                                                                                                                                                                                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                                                                                                                                                                                        margin-bottom: 15px;
                                                                                                                                                                                        }

                                                                                                                                                                                        .navbar .logo {
                                                                                                                                                                                            font-weight: bold;
                                                                                                                                                                                                font-size: 18px;
                                                                                                                                                                                                    color: #333;
                                                                                                                                                                                                    }

                                                                                                                                                                                                    .nav-links a {
                                                                                                                                                                                                        margin-left: 15px;
                                                                                                                                                                                                            text-decoration: none;
                                                                                                                                                                                                                color: #27ae60;
                                                                                                                                                                                                                    font-size: 16px;
                                                                                                                                                                                                                    }

                                                                                                                                                                                                                    .nav-links a:hover {
                                                                                                                                                                                                                        color: #1e8c59;
                                                                                                                                                                                                                        }

                                                                                                                                                                                                                        /* استایل جدول‌ها */
                                                                                                                                                                                                                        table {
                                                                                                                                                                                                                            width: 100%;
                                                                                                                                                                                                                                border-collapse: collapse;
                                                                                                                                                                                                                                    margin-bottom: 15px;
                                                                                                                                                                                                                                    }

                                                                                                                                                                                                                                    table, th, td {
                                                                                                                                                                                                                                        border: 1px solid #ddd;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        th, td {
                                                                                                                                                                                                                                            text-align: center;
                                                                                                                                                                                                                                                padding: 10px;
                                                                                                                                                                                                                                                }

                                                                                                                                                                                                                                                /* media queries برای نمایش در دستگاه‌های کوچک */
                                                                                                                                                                                                                                                @media (max-width: 600px) {
                                                                                                                                                                                                                                                    .container {
                                                                                                                                                                                                                                                            width: 95%;
                                                                                                                                                                                                                                                                    margin: 10px auto;
                                                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                                                            .nav-links a {
                                                                                                                                                                                                                                                                                    display: block;
                                                                                                                                                                                                                                                                                            margin: 10px 0;
                                                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                                                }