<?php
session_start();
require_once 'config.php';

// بررسی ورود کاربر
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Not logged in']);
        exit();
        }

        $post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
        $action = isset($_GET['action']) ? $_GET['action'] : '';

        if ($post_id <= 0 || ($action !== 'like' && $action !== 'unlike')) {
            echo json_encode(['error' => 'Invalid request']);
                exit();
                }

                if ($action === 'like') {
                    // بررسی اینکه لایک قبلاً ثبت نشده باشد
                        $checkStmt = $conn->prepare("SELECT id FROM likes WHERE post_id = ? AND user_id = ?");
                            $checkStmt->bind_param("ii", $post_id, $_SESSION['user_id']);
                                $checkStmt->execute();
                                    $checkStmt->store_result();
                                        if ($checkStmt->num_rows == 0) {
                                                $insertStmt = $conn->prepare("INSERT INTO likes (post_id, user_id) VALUES (?, ?)");
                                                        $insertStmt->bind_param("ii", $post_id, $_SESSION['user_id']);
                                                                $insertStmt->execute();
                                                                        $insertStmt->close();
                                                                            }
                                                                                $checkStmt->close();
                                                                                } elseif ($action === 'unlike') {
                                                                                    // حذف لایک
                                                                                        $deleteStmt = $conn->prepare("DELETE FROM likes WHERE post_id = ? AND user_id = ?");
                                                                                            $deleteStmt->bind_param("ii", $post_id, $_SESSION['user_id']);
                                                                                                $deleteStmt->execute();
                                                                                                    $deleteStmt->close();
                                                                                                    }

                                                                                                    // دریافت تعداد لایک‌های جدید
                                                                                                    $likeStmt = $conn->prepare("SELECT COUNT(*) FROM likes WHERE post_id = ?");
                                                                                                    $likeStmt->bind_param("i", $post_id);
                                                                                                    $likeStmt->execute();
                                                                                                    $likeStmt->bind_result($likeCount);
                                                                                                    $likeStmt->fetch();
                                                                                                    $likeStmt->close();

                                                                                                    // بررسی اینکه آیا کاربر لایک کرده یا خیر
                                                                                                    $checkLikeStmt = $conn->prepare("SELECT id FROM likes WHERE post_id = ? AND user_id = ?");
                                                                                                    $checkLikeStmt->bind_param("ii", $post_id, $_SESSION['user_id']);
                                                                                                    $checkLikeStmt->execute();
                                                                                                    $checkLikeStmt->store_result();
                                                                                                    $userLiked = $checkLikeStmt->num_rows > 0;
                                                                                                    $checkLikeStmt->close();

                                                                                                    echo json_encode(['likeCount' => $likeCount, 'userLiked' => $userLiked]);
                                                                                                    ?>